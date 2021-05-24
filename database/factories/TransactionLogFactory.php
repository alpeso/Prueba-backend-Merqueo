<?php

namespace Database\Factories;

use App\Entities\TransactionLogs\TransactionLog;
use Illuminate\Database\Eloquent\Factories\Factory;

class TransactionLogFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = TransactionLog::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'type'  => $this->faker->randomElement(['load_base', 'payment', 'cash_back']),
            'value' => $this->faker->randomElement([100000, 50000, 20000, 10000, 5000, 1000, 500, 200, 100, 50]),
        ];
    }
}
