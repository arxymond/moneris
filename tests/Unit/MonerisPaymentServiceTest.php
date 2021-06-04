<?php

namespace Tests\Unit;

use MonerisAssignment\Facades\Moneris;
use PHPUnit\Framework\TestCase;

class MonerisPaymentServiceTest extends TestCase
{
    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function test_moneris_charge_ok()
    {


        $response = Moneris::charge();
        $this->assertTrue(true);
    }
}
