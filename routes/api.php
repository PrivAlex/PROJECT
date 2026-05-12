<?php

use App\Http\Controllers\Api\ClientController;
use App\Http\Controllers\Api\OrderController;
use App\Http\Controllers\Api\PaymentController;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Route;

// Публичный маршрут для логина (не требует токена)
Route::post('/login', function (Request $request) {
    $request->validate([
        'email' => 'required|email',
        'password' => 'required',
    ]);

    $user = User::where('email', $request->email)->first();

    if (!$user || !Hash::check($request->password, $user->password)) {
        return response()->json(['message' => 'Invalid credentials'], 401);
    }

    $token = $user->createToken('auth_token')->plainTextToken;

    return response()->json(['token' => $token, 'user' => $user]);
});

Route::middleware('auth:sanctum')->post('/logout', function (Request $request) {
    $request->user()->currentAccessToken()->delete();
    return response()->json(['message' => 'Logged out']);
});

// Защищённые маршруты (требуют токен)
Route::middleware('auth:sanctum')->group(function () {
    Route::apiResource('clients', ClientController::class)->names('api.clients');
    Route::apiResource('orders', OrderController::class)->names('api.orders');
    Route::apiResource('payments', PaymentController::class)->names('api.payments');
});
