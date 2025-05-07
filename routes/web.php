<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\WithdrawController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', [HomeController::class, 'index'])->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    //Transactions
    Route::group([
        'prefix' => 'transaction', 
        'as' => 'transaction.'
    ], function () {
        Route::get('{transaction}/show', [TransactionController::class, 'show'])->name('show');
        //Withdraws
        Route::group(['prefix' => 'withdraw'], function() {
            Route::get('/', [WithdrawController::class, 'create'])->name('withdraw.create');
            Route::post('/', [WithdrawController::class, 'store'])->name('withdraw.store');
        });
    });
});

require __DIR__.'/auth.php';
