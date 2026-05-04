<?php

namespace App\Policies;

use App\Models\Client;
use App\Models\User;

class ClientPolicy
{
    // Просмотр списка всех клиентов
    public function viewAny(User $user): bool
    {
        return true; // Все авторизованные могут видеть список
    }

    // Просмотр конкретного клиента
    public function view(User $user, Client $client): bool
    {
        return $user->isAdmin() || $user->id === $client->user_id;
    }

    // Создание клиента
    public function create(User $user): bool
    {
        return true; // Все авторизованные могут создавать
    }

    // Редактирование клиента
    public function update(User $user, Client $client): bool
    {
        return $user->isAdmin() || $user->id === $client->user_id;
    }

    // Удаление клиента
    public function delete(User $user, Client $client): bool
    {
        return $user->isAdmin(); // Только админ
    }

    // Восстановление (если используется мягкое удаление)
    public function restore(User $user, Client $client): bool
    {
        return $user->isAdmin();
    }

    // Полное удаление из БД (force delete)
    public function forceDelete(User $user, Client $client): bool
    {
        return $user->isAdmin();
    }
}
