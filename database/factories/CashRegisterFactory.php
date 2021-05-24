<?php

namespace Database\Factories;

use App\Entities\CashRegisters\CashRegister;
use Illuminate\Database\Eloquent\Factories\Factory;

class CashRegisterFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = CashRegister::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [ 
            'denomination' => $this->faker->randomElement(['bill', 'coin']),
            'value'        => $this->faker->randomElement([100000, 50000, 20000, 10000, 5000, 1000, 500, 200, 100, 50]),
            'quantity'     => $this->faker->numberBetween(1, 10)
        ];
    }
}
