<?php

namespace App\Repositories;

use App\Models\Subscription;
use App\Enums\SubscriptionStatus;

class SubscriptionRepository
{
    public function activeForUser(int $userId): ?Subscription
    {
        return Subscription::where('user_id', $userId)
            ->where('status', SubscriptionStatus::ACTIVE)
            ->first();
    }

    public function create(array $data): Subscription
    {
        return Subscription::create($data);
    }

    public function cancel(Subscription $subscription): Subscription
    {
        $subscription->update([
            'status' => SubscriptionStatus::CANCELLED,
            'ends_at' => now(),
        ]);

        return $subscription;
    }

    public function historyForUser(int $userId)
    {
        return Subscription::where('user_id', $userId)->get();
    }
}
