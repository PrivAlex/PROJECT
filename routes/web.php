<?php

use App\Http\Controllers\OrderController;
use App\Http\Controllers\PaymentController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ClientController;

Route::resource('clients', ClientController::class);
Route::resource('orders', OrderController::class);
Route::resource('payments', PaymentController::class);
