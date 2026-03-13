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
        Client::factory()
            ->count(20)
            ->create()
            ->each(function ($client) {

                Order::factory()
                    ->count(20)
                    ->for($client)
                    ->create()
                    ->each(function ($order) use ($client) {

                        Payment::factory()
                            ->count(5)
                            ->for($order)
                            ->for($client)
                            ->create();

                    });

            });
    }
}
