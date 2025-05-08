<?php

namespace App\Http\Controllers;

use App\Actions\GetTransactions;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $balance = auth()->user()->account;
        $transactions = GetTransactions::run();
        return view('dashboard', compact('balance', 'transactions'));
    }
}
