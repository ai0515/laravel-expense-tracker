<?php

namespace Database\Factories;

use App\Enums\TransactionType;
use App\Models\PaymentMethod;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Category;

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
            'user_id' => User::factory(),
            'transaction_date' => date('Y-m-d'),
            'amount' => fake()->randomNumber(5),
            'transaction_type' => fake()->randomElement(TransactionType::cases()),
            'payment_method_id' => PaymentMethod::factory(),
            'note' => fake()->realText(100)
        ];
    }

    public function withCategories(int $count = 3)
    {
        return $this->hasAttached(
            Category::factory()->count($count),
            'categories'
        );
    }
}
