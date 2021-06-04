<?php

namespace MonerisAssignment\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use MonerisAssignment\Models\Customer;

class CustomerFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Customer::class;

    /**
     * Define the model's default state.
     * creating Users here to have user_id for Customer model
     *
     * @return array
     */
    public function definition()
    {
        return [
            'user_id'   => function() {
                return \App\Models\User::factory()->create()->id;
            },
            'age'       => $this->faker->numberBetween(18, 50)
        ];
    }
}
