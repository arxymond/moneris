<?php


namespace MonerisAssignment\Services;

use Illuminate\Support\Facades\Log;
use MonerisAssignment\Exceptions\MonerisUndocumentedException;
use MonerisAssignment\Exceptions\NoDefaultPaymentMethodException;
use MonerisAssignment\Libs\PaymentCommand;
use MonerisAssignment\Models\Transaction;

// Moneris doesn't provide it's library the way it can be 'installed' in Laravel way
// The only way to use Moneris classes is to have this require_once here
require_once __DIR__."/../../vendor/moneris/ecommerce-unified-api-php/mpgClasses.php";

use mpgHttpsPost;
use mpgRequest;
use mpgTransaction;


/**
 * Class MonerisPaymentService
 * @package MonerisAssignment\Services
 */
class MonerisPaymentService
{

    /**
     * @var \Illuminate\Config\Repository
     */
    private $config;

    /**
     * MonerisPaymentService constructor.
     */
    public function __construct()
    {
        $this->config = config('moneris');
    }

    /**
     * Preparing Moneris charge request body with initial data
     *
     * @param PaymentCommand $command
     * @param Transaction $tx
     * @return array
     */
    public function prepareChargeRequestData( PaymentCommand $command, Transaction $tx )
    {
        return [
            'type'                  => 'purchase',
            'order_id'              => $tx->id . '-' . strtotime('now'),
            'cust_id'               => $command->customer->id,
            'amount'                => $command->amount,
            'pan'                   => $tx->paymentMethod->card_number,
            'expdate'               => $tx->paymentMethod->getExpDateMMYY(),
            'crypt_type'            => 7, // SSL enabled Merchant
            'dynamic_descriptor'    => $this->config['dynamic_desc_prefix'] . ' TRN: ' . $tx->id
        ];
    }

    /**
     * Main charge method which prepares charge request body, Moneris mpgTransaction and mpgRequest
     * and makes the actual call to Moneris.
     *
     * @param PaymentCommand $command
     * @return string "APPROVED || DECLINED, with reason"
     * @throws MonerisUndocumentedException
     * @throws NoDefaultPaymentMethodException
     */
    public function charge( PaymentCommand $command )
    {
        Log::debug("Charge process started for CustomerID:" . $command->customer->id.", with amount:" . $command->amount);

        // First step is to get default PaymentMethod for Customer
        $paymentMethod = $command->customer->getDefaultPaymentMethod();

        // Throw the exception if there is no default PaymentMethod associated with Customer
        if( ! $paymentMethod ) {
            throw new NoDefaultPaymentMethodException();
        }

        // creating new empty Transaction and filling it with initial data along with PENDING state
        $tx = (new Transaction())->openTransaction($paymentMethod, $command->amount);
        // saving initiated Transaction
        $tx->save();
        Log::debug("New Initial transaction created with ID: " .$tx->id);

        // preparing charge request data for Moneris
        $chargeRequestData = $this->prepareChargeRequestData($command, $tx);
        Log::debug("ChargeRequestData ready to send:" . print_r($chargeRequestData, true));


        try {
            // excerpt from Moneris official documentation

            /**************************** Transaction Object *****************************/
            $mpgTxn = new mpgTransaction($chargeRequestData);

            /****************************** Request Object *******************************/
            $mpgRequest = new mpgRequest($mpgTxn);
            $mpgRequest->setProcCountryCode($this->config['country_code']);
            $mpgRequest->setTestMode($this->config['test_mode']);
            /***************************** HTTPS Post Object *****************************/
            $mpgHttpPost = new mpgHttpsPost($this->config['store_id'], $this->config['api_token'], $mpgRequest);
            /******************************* Response ************************************/
            $mpgResponse = $mpgHttpPost->getMpgResponse();

        } catch ( \Exception $e ) {

            throw new MonerisUndocumentedException($e->getCode(), $e->getMessage()); // There is no documented exception in Moneris API, but I don't trust it :)

        }

        // If we are here, means Request goes through and have some response
        // filling up Transaction instance with the Response data
        $tx->completeTransaction($mpgResponse);

        // According to Moneris official documentation
        // Response code < 50 means transaction APPROVED
        // otherwise transaction DECLINED
        $responseCode = $mpgResponse->getResponseCode();
        Log::debug("Moneris response received  with ResponseCode:" . $responseCode);

        // Deciding the Transaction state by response code and preparing charge return string
        if( (int)$responseCode && $responseCode < 50 ) {
            $tx->state = Transaction::TRANSACTION_PAID;
            $result = "APPROVED";
        } else {
            $tx->state = Transaction::TRANSACTION_FAILED;
            $result = "DECLINED: " . $mpgResponse->getMessage();
        }

        // finally saving Transaction
        $tx->save();

        Log::debug("Returning charge method result: " . $result);

        return $result;

    }
}
