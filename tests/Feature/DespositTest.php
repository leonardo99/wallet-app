<?php

use App\Models\Account;
use App\Models\User;

it('Deve ser possível criar um depósito', function () {
    $user = User::factory()
        ->has(Account::factory(['balance' => 0]))
        ->create();

    $depositInputs = [
        'balance' => 10,
    ];
    $response = $this->actingAs($user)->post(route('transaction.deposit.store'), $depositInputs);
    $response->assertRedirect();
    $response->assertSessionHas('success');
});
