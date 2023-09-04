<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProductFilterRequest;
use App\Http\Resources\ProductResource;
use App\Services\ProductService;
use Illuminate\Http\JsonResponse;

class FilterApiController extends Controller
{
    public function index(ProductFilterRequest $request): JsonResponse
    {
        $products = resolve(ProductService::class)->filter($request)
            ->paginate(12)
            ->appends($request->query());

        return response()->json([
            'status' => 'success',
            'message' => 'filter in products',
            'data' => ProductResource::collection($products)->response()->getData(true),
        ], 201);
    }
}
