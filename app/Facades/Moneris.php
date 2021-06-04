<?php


namespace MonerisAssignment\Facades;


use Illuminate\Support\Facades\Facade;

/**
 * Creating Moneris Facade for MonerisPaymentService Class
 */

class Moneris extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'moneris';
    }

}
