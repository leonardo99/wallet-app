<?php

namespace App\Http\Controllers;

use App\Actions\Deposit;
use App\Http\Requests\DepositRequest;
use Exception;
use Illuminate\Http\Request;

class DepositController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
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

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
