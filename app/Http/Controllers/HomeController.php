<?php

namespace App\Http\Controllers;

use App\Actions\GetTransactions;
use Illuminate\View\View;

class HomeController extends Controller
{
    public function index(): View
    {
        $balance = auth()->user()->account;
        $transactions = GetTransactions::run();
        return view('dashboard', compact('balance', 'transactions'));
    }
}
