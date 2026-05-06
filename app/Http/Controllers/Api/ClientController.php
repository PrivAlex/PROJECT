<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreClientRequest;
use App\Http\Requests\UpdateClientRequest;
use App\Models\Client;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class ClientController extends Controller
{
    use AuthorizesRequests;
    public function index()
    {
        $user = auth()->user();
        $query = Client::query();

        if (!$user->isAdmin()) {
            $query->where('user_id', $user->id);
        }

        $clients = $query->with('orders')->paginate(10);
        return response()->json($clients);
    }

    public function store(StoreClientRequest $request)
    {
        $data = $request->validated();
        if ($request->hasFile('avatar')) {
            $data['avatar'] = $request->file('avatar')->store('avatars', 'public');
        }
        $data['user_id'] = auth()->id();
        $client = Client::create($data);
        return response()->json($client, 201);
    }

    public function show(Client $client)
    {
        $this->authorize('view', $client);
        return response()->json($client->load('orders'));
    }

    public function update(UpdateClientRequest $request, Client $client)
    {
        $this->authorize('update', $client);

        $data = $request->validated();
        if ($request->hasFile('avatar')) {
            if ($client->avatar) {
                Storage::disk('public')->delete($client->avatar);
            }
            $data['avatar'] = $request->file('avatar')->store('avatars', 'public');
        }

        $client->update($data);
        return response()->json($client);
    }

    public function destroy(Client $client)
    {
        $this->authorize('delete', $client);
        $client->delete();
        return response()->json(null, 204);
    }
}
