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
        return view('withdraw.form', compact('balance'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(WithdrawRequest $request)
    {
        try {
            Withdraw::run($request->validated());
        } catch(Exception $e) {
            dd($e->getMessage());
            return redirect()->back()->withInput();
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
