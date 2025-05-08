<?php

use App\Models\Account;
use App\Models\Transaction;
use App\Models\User;

it('Contas de origem e destino devem ser diferentes', function () {
    $senderAccount = User::factory()
    ->has(Account::factory(['balance' => 0]))
    ->create();
    $receiverAccount = Account::factory()->create();
    $this->actingAs($senderAccount);
    expect($senderAccount)->not()->toEqual($receiverAccount);
});

it('Contas de origem deve ter saldo maior que zero', function () {
    $senderAccount = User::factory()
    ->has(Account::factory(['balance' => 0.1]))
    ->create();
    $this->actingAs($senderAccount);
    expect($senderAccount->account->balance)->toBeGreaterThan(0);
});

it('Saldo da conta de origem deve ser maior que o valor a ser enviado para a conta de destino', function () {
    $senderAccount = User::factory()
    ->has(Account::factory(['balance' => 2.00]))
    ->create();
    $withDrawInput = ['amount' => 1];
    $this->actingAs($senderAccount);
    expect($senderAccount->account->balance)->toBeGreaterThanOrEqual($withDrawInput['amount']);
});

it('Deve ser possível devolver saldo', function () {
    
    $transaction = Transaction::factory()->create();
    $account = Account::find($transaction->receiver_account_id);
    $account->balance = 100;
    $account->save();
    $response = $this->actingAs($account->user)->post(route('transaction.refund', $transaction));
    $response->assertRedirect();
    $response->assertSessionHas('success');
});
