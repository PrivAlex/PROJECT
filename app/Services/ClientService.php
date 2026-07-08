<?php

namespace App\Services;

use App\Actions\CreateClientAction;
use App\DTO\ClientDTO;
use App\Jobs\SendWelcomeEmail;
use App\Models\Client;
use App\Repositories\Contracts\ClientRepositoryInterface;

class ClientService
{
    public function __construct(
        private readonly ClientRepositoryInterface $clientRepository,
        private readonly CreateClientAction $createClientAction,
    ) {}

    public function create(ClientDTO $dto): Client
    {
        $client = $this->createClientAction->execute($dto);
        SendWelcomeEmail::dispatch($client);
        return $client;
    }

    public function getAllPaginated(int $perPage = 10)
    {
        return $this->clientRepository->getAllPaginated($perPage);
    }

    public function findWithOrders(int $id): Client
    {
        return $this->clientRepository->findWithOrders($id);
    }

    public function update(Client $client, ClientDTO $dto): Client
    {
        $data = $dto->toArray();
        return $this->clientRepository->update($client, $data);
    }

    public function delete(Client $client): bool
    {
        return $this->clientRepository->delete($client);
    }
}
