<?php

namespace App\Http\Controllers;

use App\Actions\Deposit;
use App\Http\Requests\DepositRequest;
use Exception;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class DepositController extends Controller
{
    public function create(): View
    {
        $balance = auth()->user()->account->getBalance();
        return view('transaction.deposit.form', compact('balance'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(DepositRequest $request): RedirectResponse
    {
        try {
            $depositMoney = Deposit::run($request->validated());
            return redirect()->route('transaction.show', ['transaction' => $depositMoney])->with('success', "Pronto! O valor foi depositado com sucesso.")->withInput();
        } catch(Exception $e) {
            return redirect()->back()->with('error', $e->getMessage())->withInput();
        }
    }
}
