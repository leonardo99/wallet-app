<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $balance = auth()->user()->account;
        return view('dashboard', compact('balance'));
    }
}
