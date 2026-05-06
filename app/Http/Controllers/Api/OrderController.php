<?php

namespace App\Http\Controllers\Api;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use App\Http\Controllers\Controller;
use App\Models\Client;
use App\Models\Order;
use App\Http\Requests\StoreOrderRequest;
use App\Http\Requests\UpdateOrderRequest;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    use AuthorizesRequests;
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Order::query();

        if(!auth()->user()->isAdmin()){
            $query->where('user_id' , auth()->id());
        }

        if ($request->search) {
            $query->where(function($searchQuery) use ($request) {
                $searchQuery->where('title', 'like', '%' . $request->search . '%')
                    ->orWhere('amount', 'like', '%' . $request->search . '%')
                    ->orWhereHas('client', function ($query) use ($request) {
                        $query->where('name' , 'like' , '%'  . $request->search . '%');
                    });
            });
        }

        $orders = $query->with('client')->paginate(10);
        return response()->json($orders);
    }


    public function store(StoreOrderRequest $request)
    {
        $data = $request->validated();
        // Если чекбокс не отмечен, status будет null → приводим к false
        $data['status'] = $request->has('status');
        $data['user_id'] = auth()->id();
        $order=Order::create($data);
        return response()->json($order , 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Order $order)
    {
        $this->authorize('view', $order);
        $order->load('client');
        return response()->json($order);
    }


    public function update(UpdateOrderRequest $request, Order $order)
    {
        $this->authorize('update', $order);
        $data = $request->validated();
        $data['status'] = $request->has('status');
        $order->update($data);
        return response()->json($order);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Order $order)
    {
        $this->authorize('delete', $order);
        $order->delete();
        return response()->json(null , 204);
    }
}
