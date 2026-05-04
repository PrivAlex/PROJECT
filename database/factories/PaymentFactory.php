<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Payment;
use App\Models\Client;
use App\Models\Order;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Payment>
 */
class PaymentFactory extends Factory
{
    protected $model = Payment::class;
    public function definition(): array
    {
        return [
            'amount' => $this->faker->randomFloat(2, 100, 500),
            'method' => $this->faker->randomElement(['cash', 'card', 'bank_transfer']),
            'user_id' => null,
        ];
    }
}
