<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use MonerisAssignment\Models\Customer;
use MonerisAssignment\Models\PaymentMethod;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {

        $this->command->getOutput()->writeln("Mocking some data in to DB for testing purposes");

        $this->command->getOutput()->writeln("Generating 10 Customers");
        Customer::factory(10)->create();
        $this->command->getOutput()->writeln("Customers are generated");

        $this->command->getOutput()->writeln("Generating 20 PaymentMethods");
        PaymentMethod::factory(20)->create();
        $this->command->getOutput()->writeln("PaymentMethods are generated");

        $this->command->getOutput()->writeln("Mocking date finished");
    }
}
