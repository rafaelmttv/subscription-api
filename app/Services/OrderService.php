<?php

namespace App\Services;

use App\Models\User;
use App\Repositories\OrderRepository;
use App\Repositories\SubscriptionRepository;
use App\Enums\OrderStatus;
use App\Jobs\ProcessPaymentJob;
use Exception;

class OrderService
{
    public function __construct(
        protected OrderRepository $orders,
        protected SubscriptionRepository $subscriptions
    ) {}

    public function create(User $user, float $amount)
    {
        $subscription = $this->subscriptions->activeForUser($user->id);

        if (! $subscription) {
            throw new Exception('User has no active subscription');
        }

        $limit = $subscription->plan->order_limit;

        $currentCount = $this->orders->countForUserInMonth($user->id);

        if ($currentCount >= $limit) {
            throw new Exception('Order limit exceeded for current plan');
        }

        $order = $this->orders->create([
            'user_id' => $user->id,
            'amount' => $amount,
            'status' => OrderStatus::PENDING,
        ]);

        ProcessPaymentJob::dispatch($order);

        return $order;
    }
}
