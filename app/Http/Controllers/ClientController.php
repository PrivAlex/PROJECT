<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Http\Requests\StoreClientRequest;
use App\Http\Requests\UpdateClientRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;
use App\Jobs\SendWelcomeEmail;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;


class ClientController extends Controller
{
    use AuthorizesRequests;
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Client::query();

        if(!auth()->user()->isAdmin()){
            $query->where('user_id' , auth()->id());
        }

        if ($request->search) {
            $query->where(function($searchQuery) use ($request) {
                $searchQuery->where('name', 'like', '%' . $request->search . '%')
                    ->orWhere('email', 'like', '%' . $request->search . '%')
                    ->orWhere('phone', 'like', '%' . $request->search . '%');
            });
        }

        $clients = $query->paginate(10);
        return view('clients.index' , compact('clients'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('clients.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreClientRequest $request)
    {
        $data = $request->validated();

        if ($request->hasFile('avatar')){
            $data['avatar'] = $request->file('avatar')->store('avatars' , 'public');
        }

        $data['user_id'] = auth()->id();
        $client = Client::create($data);

        SendWelcomeEmail::dispatch($client);
        return redirect()->route('clients.index')->with('success' , 'Клиент создан');
    }

    /**
     * Display the specified resource.
     */
    public function show(Client $client)
    {
        $this->authorize('view', $client);
        $client = Cache::remember('client_' . $client->id, 3600, function() use ($client) {
            \Log::info('Загрузка из БД, клиент id=' . $client->id);
            return $client->load('orders');
        });
        \Log::info('Клиент ' . $client->id . ' загружен из ' . (Cache::has('client_' . $client->id) ? 'кеша' : 'БД (ошибка?)'));
        return view('clients.show', compact('client'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $client = Client::findOrFail($id);
        return view('clients.edit', compact('client'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateClientRequest $request, Client $client)
    {
        $this->authorize('update', $client);
        $data = $request->validated();
        if ($request->hasFile('avatar')){
            if ($client->avatar){
            Storage::disk('public')->delete($client->avatar);
            }
            $data['avatar'] = $request->file('avatar')->store('avatars' , 'public');
        }
        $client->update($data);
        Cache::forget('client_' . $client->id);
        return redirect()->route('clients.index')->with('success' , 'Клиент изменен');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Client $client)
    {
        $this->authorize('delete', $client);
        $client->delete();
        Cache::forget('client_' . $client->id);
        return redirect()->route('clients.index')->with('success', 'Client deleted successfully');
    }
}
