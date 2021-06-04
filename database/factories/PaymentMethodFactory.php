<?php

namespace MonerisAssignment\Database\Factories;

use MonerisAssignment\Models\PaymentMethod;
use Illuminate\Database\Eloquent\Factories\Factory;

class PaymentMethodFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = PaymentMethod::class;

    /**
     * Define the model's default state.
     *
     * Customer can have many PaymentMethods, so no reason to create Customer here for having the customer_id, we can use random number (max customers number)
     * card_number is hardcoded for this project, to use the number what Moneris will accept as for testing purposes
     * is_default indicates if the PaymentMethod Default for Customer
     *
     * @return array
     */
    public function definition()
    {
        return [
            'customer_id' => $this->faker->numberBetween(1, 10),
            'card_number' => '4242424242424242',
            'card_holder' => $this->faker->name,
            'exp_date'    => $this->faker->creditCardExpirationDate,
            'is_default'  => $this->faker->boolean
        ];
    }
}
