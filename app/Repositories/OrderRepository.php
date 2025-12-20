<?php

namespace App\Repositories;

use App\Models\Order;
use App\Enums\OrderStatus;

class OrderRepository
{
    public function countForUserInMonth(int $userId): int
    {
        return Order::where('user_id', $userId)
            ->whereMonth('created_at', now()->month)
            ->whereYear('created_at', now()->year)
            ->count();
    }

    public function create(array $data): Order
    {
        return Order::create($data);
    }
}
