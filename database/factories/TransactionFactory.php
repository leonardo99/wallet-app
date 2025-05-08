<?php

namespace Database\Factories;

use App\Models\Account;
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
            'sender_account_id' => Account::factory(),
            'receiver_account_id' => Account::factory(),
            'amount' => 5.00,
            'type' => 'transfer',
            'status' => 'completed'
        ];
    }
}
