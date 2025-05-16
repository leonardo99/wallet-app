<?php

namespace App\Actions;

use App\Models\Transaction;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;

class GetTransactions
{
    protected function handle(): LengthAwarePaginator
    {
        return DB::transaction(function () {
            $account = auth()->user()->account->id;
            $transactions = Transaction::where('sender_account_id', $account)
                                        ->orWhere('receiver_account_id', $account)
                                        ->orWhere('status', 'refunded')
                                        ->latest()
                                        ->paginate(5);
            return $transactions;
        });
    }

    public static function run(): LengthAwarePaginator
    {
        return (new self())->handle();
    }
}