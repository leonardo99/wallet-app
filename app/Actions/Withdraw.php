<?php

namespace App\Actions;

use App\Models\Account;
use App\Models\Transaction;
use Illuminate\Support\Facades\DB;
use Exception;

class Withdraw
{
    protected function handle(array $data): Transaction
    {
        return DB::transaction(function () use($data) {
           $senderAccount = auth()->user()->account()->lockForUpdate()->first();
           $receiverAccount = Account::query()->lockForUpdate()->findOrFail($data['id']);
            if($senderAccount->id === $receiverAccount->id) {
                throw new Exception('Transação recusada: a conta de origem e destino não podem ser iguais.');
            }
            if($senderAccount->balance <= 0) {
                throw new Exception('Transação não autorizada: sua conta não possui saldo.');
            }
            if($senderAccount->balance < $data['amount']) {
                throw new Exception('Transação não autorizada: saldo insuficiente para o valor informado.');
            }
            $senderAccount->balance -= $data['amount'];
            $receiverAccount->balance += $data['amount'];
            $senderAccount->save();
            $receiverAccount->save();
            $saveTransaction = Transaction::create([
                'sender_account_id' => $senderAccount->id,
                'receiver_account_id' => $receiverAccount->id,
                'amount' => $data['amount'],
                'type' => 'transfer',
                'status' => 'completed'
            ]);
            if(!$saveTransaction)
            {
                throw new Exception("Ocorreu um erro tentar salvar a transação");
            }
            return $saveTransaction;
        });
    }

    public static function run(array $data): Transaction
    {
        return (new self())->handle($data);
    }
}