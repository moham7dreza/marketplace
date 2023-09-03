<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\OrderRequest;
use App\Http\Resources\OrderResource;
use App\Services\OrderService;
use Illuminate\Http\JsonResponse;

class OrderApiController extends Controller
{
    private OrderService $service;

    public function __construct(OrderService $service)
    {
        $this->service = $service;
    }

    public function store(OrderRequest $request): JsonResponse
    {
        $order = $this->service->store($request);
        return response()->json([
            'status' => 'success',
            'message' => 'order created successfully',
            'data' => new OrderResource($order),
        ], 201);
    }
}
