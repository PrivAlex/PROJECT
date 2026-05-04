<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Client;
use App\Models\Order;
use App\Models\Payment;
class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 1. Создаём 2 админа и 8 обычных пользователей
        $admins = User::factory()->count(2)->create(['role' => User::ROLE_ADMIN]);
        $users  = User::factory()->count(8)->create(['role' => User::ROLE_USER]);

        $allUsers = $admins->merge($users);

        // 2. Создаём клиентов, привязываем к случайному пользователю
        Client::factory()
            ->count(20)
            ->create()
            ->each(function ($client) use ($allUsers) {
                // Привязываем клиента к случайному пользователю (или админу)
                $client->user_id = $allUsers->random()->id;
                $client->save();

                // Для каждого клиента создаём заказы
                Order::factory()
                    ->count(20)
                    ->for($client)
                    ->create()
                    ->each(function ($order) use ($client) {
                        // Заказ получает user_id от клиента
                        $order->user_id = $client->user_id;
                        $order->save();

                        // Платежи для заказа
                        Payment::factory()
                            ->count(5)
                            ->for($order)
                            ->for($client)
                            ->create()
                            ->each(function ($payment) use ($order) {
                                // Платёж получает user_id от заказа
                                $payment->user_id = $order->user_id;
                                $payment->save();
                            });
                    });
            });
    }
}
