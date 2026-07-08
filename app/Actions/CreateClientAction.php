<?php

namespace App\Actions;

use App\DTO\ClientDTO;
use App\Models\Client;
use App\Repositories\Contracts\ClientRepositoryInterface;

class CreateClientAction
{
    public function __construct(
        private readonly ClientRepositoryInterface $clientRepository
    ) {}

    public function execute(ClientDTO $dto): Client
    {
        $data = $dto->toArray();
        $data['user_id'] = auth()->id();

        return $this->clientRepository->create($data);
    }
}
