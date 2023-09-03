<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\CartItemRequest;
use App\Http\Resources\CartItemResource;
use App\Models\Product;
use App\Services\CartItemService;
use Illuminate\Http\JsonResponse;

class CartItemApiController extends Controller
{
    private CartItemService $service;

    public function __construct(CartItemService $service)
    {
        $this->service = $service;
    }

    public function store(CartItemRequest $request, Product $product): JsonResponse
    {
        $item = $this->service->store($request, $product);
        return response()->json([
            'status' => 'success',
            'message' => 'item added successfully',
            'data' => new CartItemResource($item),
        ], 201);
    }
}
