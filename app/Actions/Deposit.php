<?php

namespace App\Actions;

use App\Http\Requests\WithdrawRequest;
use App\Models\Account;
use App\Models\Transaction;
use Illuminate\Support\Facades\DB;
use Exception;

class Deposit
{
    protected function handle(array $data)
    {
        return DB::transaction(function () use($data) {
            $userAccount = auth()->user()->account()->lockForUpdate()->first();
            $userAccount->balance += $data['balance'];
            $userAccount->save();
            $saveTransaction = Transaction::create([
                'receiver_account_id' => $userAccount->id,
                'amount' => $data['balance'],
                'type' => 'deposit',
                'status' => 'completed'
            ]);
            if(!$saveTransaction)
            {
                throw new Exception("Ocorreu um erro tentar salvar a transação");
            }
            return $saveTransaction;
        });
    }

    public static function run(array $data)
    {
        return (new self())->handle($data);
    }
}