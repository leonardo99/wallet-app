<?php

namespace App\Actions;

use App\Models\Transaction;
use Illuminate\Support\Facades\DB;
use Exception;

class Refund
{
    protected function handle(Transaction $transaction): Transaction
    {
        return DB::transaction(function () use($transaction) {
           $senderAccount = $transaction->senderAccount;
           $receiverAccount = $transaction->receiverAccount;
            if($receiverAccount->id === $senderAccount->id) {
                throw new Exception('Transação recusada: a conta de origem e destino não podem ser iguais.');
            }
            if($receiverAccount->balance <= 0) {
                throw new Exception('Transação não autorizada: sua conta não possui saldo.');
            }
            if($receiverAccount->balance < $transaction->amount) {
                throw new Exception('Transação não autorizada: saldo insuficiente para o valor informado.');
            }
            $senderAccount->balance += $transaction->amount;
            $receiverAccount->balance -= $transaction->amount;
            $transaction->status = 'refunded';
            $senderAccount->save();
            $receiverAccount->save();
            $transaction->save();
            $saveTransaction = Transaction::create([
                'sender_account_id' => $receiverAccount->id,
                'receiver_account_id' => $senderAccount->id,
                'reversed_transaction_id' => $transaction->id,
                'amount' => $transaction->amount,
                'type' => 'transfer',
                'status' => 'refunded'
            ]);
            if(!$saveTransaction)
            {
                throw new Exception("Ocorreu um erro tentar salvar a transação");
            }
            return $saveTransaction;
        });
    }

    public static function run(Transaction $transaction): Transaction
    {
        return (new self())->handle($transaction);
    }
}