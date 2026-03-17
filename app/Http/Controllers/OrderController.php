<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\Order;
use App\Http\Requests\StoreOrderRequest;
use App\Http\Requests\UpdateOrderRequest;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Order::with('client');

        if ($request->search) {
            $query->where(function($searchQuery) use ($request) {
                $searchQuery->where('title', 'like', '%' . $request->search . '%')
                    ->orWhere('amount', 'like', '%' . $request->search . '%')
                    ->orWhereHas('client', function ($query) use ($request) {
                        $query->where('name' , 'like' , '%'  . request('search') . '%');
                    });
            });
        }

        $orders = $query->paginate(10);
        return view('orders.index' , compact('orders'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $clients = Client::all(); // чтобы выбрать клиента в форме
        return view('orders.create', compact('clients'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreOrderRequest $request)
    {
        $data = $request->validated();
        // Если чекбокс не отмечен, status будет null → приводим к false
        $data['status'] = $request->has('status');

        Order::create($data);
        return redirect()->route('orders.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(Order $order)
    {
        $order->load('client');
        return view('orders.show', compact('order'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Order $order)
    {
        $clients = Client::all();

        return view('orders.edit', compact('order', 'clients'));
    }

    public function update(UpdateOrderRequest $request, Order $order)
    {
        $data = $request->validated();
        $data['status'] = $request->has('status');
        $order->update($data);
        return redirect()->route('orders.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Order $order)
    {
        $order->delete();
        return redirect()->route('orders.index');
    }
}
