<?php

namespace Database\Factories;

use App\Models\Order;
use App\Enums\OrderStatus;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class OrderFactory extends Factory
{
    protected $model = Order::class;

    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'amount' => $this->faker->randomFloat(2, 10, 500),
            'status' => OrderStatus::PENDING,
        ];
    }
}
