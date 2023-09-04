<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProductFilterRequest;
use App\Http\Requests\ProductRequest;
use App\Http\Resources\ProductResource;
use App\Models\Product;
use App\Services\ProductService;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Gate;

class ProductApiController extends Controller
{

    private ProductService $service;

    public function __construct(ProductService $service)
    {
        $this->service = $service;
    }

    public function index(ProductFilterRequest $request): JsonResponse
    {
        $products = resolve(ProductService::class)->filter($request)
            ->paginate(12)
            ->appends($request->query());

        return response()->json([
            'status' => 'success',
            'message' => 'products index',
            'data' => ProductResource::collection($products)->response()->getData(true),
        ], 201);
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
        if (!Gate::allows('destroy-product', $product)) {
            return response()->json([
                'status' => 'success',
                'message' => 'you can not delete this product',
                'data' => [],
            ], 201);
        }
        $product->delete();
        return response()->json([
            'status' => 'success',
            'message' => 'product destroyed successfully',
            'data' => [],
        ], 201);
    }
}
