<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Transaction>
 */
class TransactionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'coin_id' => $this->faker->numberBetween(1, 6),
            'user_id' => $this->faker->numberBetween(1, 6),
            'quantity' => $this->faker->randomFloat(2, 1, 100),
            'price_buy' => $this->faker->randomFloat(2, 1, 100),
            'amount' => $this->faker->randomFloat(2, 1, 100),
            'actual_price' => $this->faker->randomFloat(2, 1, 100),
            'date_buy' => $this->faker->dateTimeBetween('-1 year', 'now'),
        ];
    }
}
