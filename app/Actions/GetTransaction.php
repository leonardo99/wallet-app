<?php

namespace App\Actions;

use App\Models\Transaction;
use Exception;
use Illuminate\Support\Facades\DB;

class GetTransaction
{
    protected function handle($transaction): Transaction
    {
        return DB::transaction(function () use($transaction) {
            $accountId = auth()->user()->account->id;
            if(!$transaction || ($transaction->sender_account_id !== $accountId && $transaction->receiver_account_id !== $accountId)) {
                throw new Exception('Transação não encontrada.');
            }
            return $transaction;
        });
    }

    public static function run($transaction): Transaction
    {
        return (new self())->handle($transaction);
    }
}