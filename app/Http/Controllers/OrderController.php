<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\Order;
use App\Http\Requests\StoreOrderRequest;
use App\Http\Requests\UpdateOrderRequest;
use Illuminate\Http\Request;
use Inertia\Inertia;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Order::query();

        if (!auth()->user()->isAdmin()) {
            $query->where('user_id', auth()->id());
        }

        if ($request->search) {
            $query->where(function ($searchQuery) use ($request) {
                $searchQuery->where('title', 'like', '%' . $request->search . '%')
                    ->orWhere('amount', 'like', '%' . $request->search . '%')
                    ->orWhereHas('client', function ($query) use ($request) {
                        $query->where('name', 'like', '%' . request('search') . '%');
                    });
            });
        }

        $orders = $query->with('client')->paginate(10);
        return Inertia::render('Orders/Index', ['orders' => $orders]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $clients = Client::all(); // чтобы выбрать клиента в форме
        return Inertia::render('Orders/Create', ['clients' => $clients]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreOrderRequest $request)
    {
        $data = $request->validated();
        // Если чекбокс не отмечен, status будет null → приводим к false
        $data['status'] = $request->has('status');
        $data['user_id'] = auth()->id();

        Order::create($data);
        return redirect()->route('orders.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(Order $order)
    {
        $order->load('client');
        return Inertia::render('Orders/Show', ['order' => $order]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Order $order)
    {
        $clients = Client::all();

        return Inertia::render('Orders/Edit', ['order' => $order, 'clients' => $clients]);
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
