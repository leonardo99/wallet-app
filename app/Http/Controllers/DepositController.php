<?php

namespace App\Http\Controllers;

use App\Actions\Deposit;
use App\Http\Requests\DepositRequest;
use Exception;

class DepositController extends Controller
{
    public function create()
    {
        $balance = auth()->user()->account->getBalance();
        return view('transaction.deposit.form', compact('balance'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(DepositRequest $request)
    {
        try {
            $depositMoney = Deposit::run($request->validated());
            if($depositMoney) {
                return redirect()->route('transaction.show', ['transaction' => $depositMoney])->with('success', "Pronto! O valor foi depositado com sucesso.")->withInput();   
            }
        } catch(Exception $e) {
            return redirect()->back()->with('error', $e->getMessage())->withInput();
        }
    }
}
