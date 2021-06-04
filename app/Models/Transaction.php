<?php

namespace MonerisAssignment\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Transaction
 * @package MonerisAssignment\Models
 */
class Transaction extends Model
{
    use HasFactory;


    /**
     * Transaction States
     */
    const TRANSACTION_PENDING = 'pending';
    const TRANSACTION_PAID = 'paid';
    const TRANSACTION_FAILED = 'failed';

    /**
     * Transactions to Customer Models relation
     * Customer can have more then 1 Transaction,
     * Transaction belongs to 1 Customer
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function customer() {
        return $this->belongsTo(Customer::class);
    }

    /**
     * Transaction to PaymentMethod models relation
     * PaymentMethod can have more then one Transactions
     * Transaction can have 1 PaymentMethod
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function paymentMethod() {
        return $this->belongsTo(PaymentMethod::class);
    }

    /**
     * Creates new Transaction with initial data and PENDING state, before sending request to Moneris
     *
     * @param PaymentMethod $paymentMethod
     * @param float $amount
     * @return Transaction Instance
     */
    public function openTransaction(PaymentMethod $paymentMethod, float $amount)
    {
        $this->payment_method_id = $paymentMethod->id;
        $this->customer_id = $paymentMethod->customer_id;
        $this->state = self::TRANSACTION_PENDING;
        $this->amount = $amount;

        return $this;
    }

    /**
     * Filling up Transaction with data received from Moneris
     *
     * @param $mpgResponse
     * @return Transaction Instance
     */
    public function completeTransaction($mpgResponse)
    {

        $this->CardType = $mpgResponse->getCardType();
        $this->TransAmount = $mpgResponse->getTransAmount();
        $this->TxnNumber = $mpgResponse->getTxnNumber();
        $this->ReceiptId = $mpgResponse->getReceiptId();
        $this->TransType = $mpgResponse->getTransType();
        $this->ReferenceNum = $mpgResponse->getReferenceNum();
        $this->ResponseCode = $mpgResponse->getResponseCode();
        $this->ISO = $mpgResponse->getISO();
        $this->Message = $mpgResponse->getMessage();
        $this->IsVisaDebit = $mpgResponse->getIsVisaDebit();
        $this->AuthCode = $mpgResponse->getAuthCode();
        $this->Complete = $mpgResponse->getComplete();
        $this->TransDate = $mpgResponse->getTransDate();
        $this->TransTime = $mpgResponse->getTransTime();
        $this->Ticket = $mpgResponse->getTicket();
        $this->TimedOut = $mpgResponse->getTimedOut();
        $this->StatusCode = $mpgResponse->getStatusCode();
        $this->StatusMessage = $mpgResponse->getStatusMessage();
        $this->HostId = $mpgResponse->getHostId();
        $this->IssuerId = $mpgResponse->getIssuerId();

        return $this;

    }
}
