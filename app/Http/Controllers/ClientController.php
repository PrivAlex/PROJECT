<?php

namespace App\Http\Controllers;

use App\DTO\ClientDTO;
use App\Services\ClientService;
use App\Http\Requests\StoreClientRequest;
use App\Http\Requests\UpdateClientRequest;
use App\Models\Client;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ClientController extends Controller
{
    public function __construct(
        private readonly ClientService $clientService
    ) {}

    public function index(Request $request)
    {
        $clients = $this->clientService->getAllPaginated(10);
        return Inertia::render('Clients/Index', ['clients' => $clients]);
    }

    public function store(StoreClientRequest $request)
    {
        $dto = ClientDTO::fromRequest($request->validated());
        $client = $this->clientService->create($dto);

        return redirect()->route('clients.index')->with('success', 'Клиент создан');
    }

    public function show(Client $client)
    {
        $client = $this->clientService->findWithOrders($client->id);
        return Inertia::render('Clients/Show', ['client' => $client]);
    }

    public function update(UpdateClientRequest $request, Client $client)
    {
        $dto = ClientDTO::fromRequest($request->validated());
        $this->clientService->update($client, $dto);

        return redirect()->route('clients.index')->with('success', 'Клиент обновлён');
    }

    public function destroy(Client $client)
    {
        $this->clientService->delete($client);
        return redirect()->route('clients.index')->with('success', 'Клиент удалён');
    }
}
