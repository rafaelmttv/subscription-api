<?php

namespace App\Repositories;

use App\Models\Plan;

class PlanRepository
{
    public function paginate()
    {
        return Plan::paginate();
    }

    public function create(array $data): Plan
    {
        return Plan::create($data);
    }

    public function update(Plan $plan, array $data): Plan
    {
        $plan->update($data);
        return $plan;
    }

    public function delete(Plan $plan): void
    {
        $plan->delete();
    }
}
