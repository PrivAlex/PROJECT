<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Client;
use App\Models\Order;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Order>
 */
class OrderFactory extends Factory
{
    protected $model = Order::class;
    public function definition(): array
    {
        return [
            'title' => $this->faker->words(3, true),
            'amount' => $this->faker->randomFloat(2, 100, 500),
            'status' => $this->faker->boolean(),
            'user_id' => null,
        ];
    }
}
