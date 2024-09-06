<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoanController;
use App\Http\Controllers\CreditorController;
use App\Http\Controllers\RepaymentController;
use App\Http\Controllers\HistoryController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('layouts.app');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';

Route::get('/loans', [LoanController::class, 'index'])->name('loans.index');
Route::get('/loans/create', [LoanController::class, 'create'])->name('loans.create');
Route::post('/loans', [LoanController::class, 'store'])->name('loans.store');
Route::post('/loans/{id}', [LoanController::class, 'update'])->name('loans.update');
Route::get('/loans/current-month', [LoanController::class, 'currentMonth'])->name('loans.current-month');
Route::get('/loans/{id}/details', [LoanController::class, 'getLoanDetails'])->name('loans.details');
Route::get('/send-repayment-notification', [LoanController::class, 'sendRepaymentNotification'])->name('send-repayment-notification');

Route::get('creditors', [CreditorController::class, 'index'])->name('creditors.index');
Route::get('/creditors/create', [CreditorController::class, 'create'])->name('creditors.create');
Route::get('creditors/{id}', [CreditorController::class, 'show'])->name('creditors.show');
Route::post('/creditors/store', [CreditorController::class, 'store'])->name('creditors.store');

Route::get('repayments', [RepaymentController::class, 'index'])->name('repayments.index');
Route::get('/repayments/create', [RepaymentController::class, 'create'])->name('repayments.create');
Route::get('repayments/{id}', [RepaymentController::class, 'show'])->name('repayments.show');
Route::post('/repayments/store', [RepaymentController::class, 'store'])->name('repayments.store');

Route::get('history', [HistoryController::class, 'index'])->name('history.index');
Route::get('history/{id}', [HistoryController::class, 'show'])->name('history.show');