<?php

namespace App\Http\Controllers\Api;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use App\Http\Controllers\Controller;
use App\Models\Client;
use App\Models\Order;
use App\Http\Requests\StoreOrderRequest;
use App\Http\Requests\UpdateOrderRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class OrderController extends Controller
{
    use AuthorizesRequests;
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $user = auth()->user();
        $cacheKey = 'orders_' . $user->id . '_' . ($request->search ?? 'null') . '_page_' . ($request->page ?? 1);

        \Log::info('Cache key: ' . $cacheKey); // теперь переменная определена

        $orders = Cache::remember($cacheKey, 300, function () use ($user, $request) {
            \Log::info('Orders retrieved from cache or DB');
            $query = Order::query();

            if (!$user->isAdmin()) {
                $query->where('user_id', $user->id);
            }

            if ($request->search) {
                $query->where(function($q) use ($request) {
                    $q->where('title', 'like', '%' . $request->search . '%')
                        ->orWhere('amount', 'like', '%' . $request->search . '%')
                        ->orWhereHas('client', fn($q) => $q->where('name', 'like', '%' . $request->search . '%'));
                });
            }

            return $query->with('client')->paginate(10);
        });

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
