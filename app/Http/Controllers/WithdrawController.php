<?php

namespace App\Http\Controllers;

use App\Actions\Withdraw;
use App\Http\Requests\WithdrawRequest;
use Exception;
use Illuminate\Http\Request;

class WithdrawController extends Controller
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
