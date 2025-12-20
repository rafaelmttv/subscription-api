<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreOrderRequest;
use App\Services\OrderService;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function __construct(
        protected OrderService $orderService
    ) {

    }

    public function store(StoreOrderRequest $request)
    {

        return response()->json(
            $this->orderService->create(
                $request->user(),
                $request->validated()['amount']
            ),
            201
        );
    }
}
