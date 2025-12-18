<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\StorePlanRequest;
use App\Http\Requests\UpdatePlanRequest;
use App\Models\Plan;
use App\Services\PlanService;

class PlanController extends Controller
{
    public function __construct(
        protected PlanService $service
    ) {}

    public function index()
    {
        return Plan::paginate();
    }

    public function store(StorePlanRequest $request)
    {
        return response()->json(
            $this->service->create($request->validated()),
            201
        );
    }

    public function update(UpdatePlanRequest $request, Plan $plan)
    {
        return response()->json(
            $this->service->update($plan, $request->validated())
        );
    }

    public function destroy(Plan $plan)
    {
        $this->service->delete($plan);

        return response()->json([
            'message' => 'Plan deleted',
        ]);
    }
}

