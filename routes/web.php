<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\PaymentController;

Route::get('/', function () {
    return view('welcome');
});

Route::resource('clients', ClientController::class);

Route::resource('orders', OrderController::class)->except('destroy');

Route::delete('/orders/{order}', [OrderController::class, 'destroy'])
    ->middleware('admin')
    ->name('orders.destroy');

Route::resource('payments', PaymentController::class);

require __DIR__.'/auth.php';
