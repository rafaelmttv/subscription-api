<?php

namespace App\Services;

use App\Models\Plan;
use App\Models\User;
use App\Repositories\SubscriptionRepository;
use App\Enums\SubscriptionStatus;
use Exception;

class SubscriptionService
{
    public function __construct(
        protected SubscriptionRepository $repository
    ) {

    }

    public function subscribe(User $user, Plan $plan)
    {
        if ($this->repository->activeForUser($user->id)) {
            throw new Exception('User already has an active subscription');
        }

        return $this->repository->create([
            'user_id' => $user->id,
            'plan_id' => $plan->id,
            'status' => SubscriptionStatus::ACTIVE,
        ]);
    }

    public function cancel(User $user)
    {
        $subscription = $this->repository->activeForUser($user->id);

        if (! $subscription) {
            throw new Exception('No active subscription found');
        }

        return $this->repository->cancel($subscription);
    }

    public function history(User $user)
    {
        return $this->repository->historyForUser($user->id);
    }
}
