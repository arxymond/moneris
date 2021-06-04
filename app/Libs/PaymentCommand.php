<?php


namespace MonerisAssignment\Libs;


use MonerisAssignment\Models\Customer;

/**
 * Simple PaymentCommand Class as wrapper for Customer and Amount as required
 */

class PaymentCommand
{
    /**
     * @var Customer
     */
    public Customer $customer;

    /**
     * @var float
     */
    public float $amount;

    public function __construct(Customer $customer, float $amount)
    {
        $this->customer = $customer;
        $this->amount   = $amount;

    }
}
