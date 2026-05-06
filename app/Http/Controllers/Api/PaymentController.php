<?php

namespace App\Http\Controllers\Api;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use App\Http\Controllers\Controller;
use App\Models\Client;
use App\Models\Order;
use App\Models\Payment;
use Illuminate\Http\Request;
use App\Http\Requests\StorePaymentRequest;
use App\Http\Requests\UpdatePaymentRequest;

class PaymentController extends Controller
{
    use AuthorizesRequests;
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $query = Payment::query();

        if(!auth()->user()->isAdmin()){
            $query->where('user_id' , auth()->id());
        }

        $payments = $query->with('order.client')->paginate(10);
        return response()->json($payments);
    }


    public function store(StorePaymentRequest $request)
    {
        $data = $request->validated();
        $data['user_id'] = auth()->id();
        $payment= Payment::create($data);
        return response()->json($payment , 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Payment $payment)
    {
        $this->authorize('view', $payment);
        $payment->load('order.client');
        return response()->json($payment);
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatePaymentRequest $request, Payment $payment)
    {
        $this->authorize('update', $payment);
        $data = $request->validated();
        $payment->update($data);
        return response()->json($payment);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Payment $payment)
    {
        $this->authorize('delete', $payment);
        $payment->delete();
        return response()->json(null, 204);
    }
}
