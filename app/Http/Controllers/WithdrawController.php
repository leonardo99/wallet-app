<?php

namespace App\Http\Controllers;

use App\Actions\Withdraw;
use App\Http\Requests\WithdrawRequest;
use Exception;

class WithdrawController extends Controller
{
    public function create()
    {
        $balance = auth()->user()->account->getBalance();
        return view('transaction.withdraw.form', compact('balance'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(WithdrawRequest $request)
    {
        try {
            $sendMoney = Withdraw::run($request->validated());
            if($sendMoney) {
                return redirect()->route('transaction.show', ['transaction' => $sendMoney])->with('success', " Pronto! O valor foi transferido com sucesso.")->withInput();   
            }
        } catch(Exception $e) {
            return redirect()->back()->with('error', $e->getMessage())->withInput();
        }
    }
}
