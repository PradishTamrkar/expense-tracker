<?php

namespace Database\Factories;

use App\Models\Transaction;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Transaction>
 */
class TransactionFactory extends Factory
{
    protected $model= Transaction::class;

    public function definition(): array
    {
        return [
            'user_id' => 1,
            'category_id' => $this->faker->numberBetween(1, 12),
            'amount' => $this->faker->numberBetween(100, 50000),
            'type' => $this->faker->randomElement(['income', 'expense']),
            'description' => $this->faker->sentence(),
            'transaction_date' => $this->faker->dateTimeBetween('-1 month', 'now'),        
        ];
    }
    
    // Custom state: only expenses
    public function expense(): static
    {
        return $this->state(function (array $attributes) {
            return [
                'type' => 'expense',
                'amount' => $this->faker->numberBetween(100, 20000),
            ];
        });
    }

    // Custom state: only income
    public function income(): static
    {
        return $this->state(function (array $attributes) {
            return [
                'type' => 'income',
                'amount' => $this->faker->numberBetween(10000, 100000),
            ];
        });
    }
}
