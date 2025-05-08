<?php

namespace App\Http\Controllers;

use App\Actions\GetTransaction;
use App\Actions\Refund;
use App\Models\Transaction;
use Exception;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class TransactionController extends Controller
{
    public function show(Transaction $transaction): View|RedirectResponse
    {
        try {
            $transaction = GetTransaction::run($transaction);
            return view('transaction.show', compact('transaction'));
        } catch (Exception $e) {
            return redirect()->route('dashboard')->with('error', $e->getMessage());
        }
    }

    public function refund(Transaction $transaction): RedirectResponse
    {
        try {
            $transaction = Refund::run($transaction);
            return redirect()->route('transaction.show', $transaction)->with('success', 'O valor foi devolvido com sucesso.');
        } catch (Exception $e) {
            return redirect()->route('dashboard')->with('error', $e->getMessage());
        }
    }
}
