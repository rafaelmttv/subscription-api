<?php

namespace App\Services;

use App\Models\Plan;
use App\Repositories\PlanRepository;

class PlanService
{
    public function __construct(
        protected PlanRepository $repository
    ) {

    }

    public function create(array $data): Plan
    {
        return $this->repository->create($data);
    }

    public function update(Plan $plan, array $data): Plan
    {
        return $this->repository->update($plan, $data);
    }

    public function delete(Plan $plan): void
    {
        $this->repository->delete($plan);
    }
}
