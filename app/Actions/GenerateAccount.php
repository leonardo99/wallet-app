<?php

namespace App\Actions;

use App\Models\Account;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Exception;

class GenerateAccount
{
    protected function handle(User $user): Account
    {
        return DB::transaction(function () use($user) {
            $account = new Account(['balance' => 0.00]);
            $saveUser = $user->account()->save($account);
            if(!$saveUser) {
                throw new Exception("Ocorreu um erro ao criar uma conta.");
            }
            return $saveUser;
        });
    }

    public static function run(User $user): Account
    {
        return (new self())->handle($user);
    }
}