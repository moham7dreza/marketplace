<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProductRequest;
use App\Http\Resources\ProductResource;
use App\Models\Product;
use App\Services\ProductService;
use Illuminate\Http\JsonResponse;

class ProductApiController extends Controller
{

    private ProductService $service;

    public function __construct(ProductService $service)
    {
        $this->service = $service;
    }

    public function store(ProductRequest $request): JsonResponse
    {
        $product = $this->service->store($request);
        return response()->json([
            'status' => 'success',
            'message' => 'product created successfully',
            'data' => new ProductResource($product),
        ], 201);
    }

    public function destroy(Product $product): JsonResponse
    {
        $product->delete();
        return response()->json([
            'status' => 'success',
            'message' => 'product destroyed successfully',
            'data' => [],
        ], 201);
    }
}
