<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\Plan;
use App\Services\SubscriptionService;
use Illuminate\Http\Request;

class SubscriptionController extends Controller
{
    public function __construct(
        protected SubscriptionService $service
    ) {}

    public function store(Request $request, Plan $plan)
    {
        return response()->json(
            $this->service->subscribe($request->user(), $plan),
            201
        );
    }

    public function cancel(Request $request)
    {
        return response()->json(
            $this->service->cancel($request->user())
        );
    }

    public function history(Request $request)
    {
        return response()->json(
            $this->service->history($request->user())
        );
    }
}

