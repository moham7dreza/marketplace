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

    /**
     * @OA\Get(
     ** path="/api/v1/products/index",
     *  tags={"Product Module"},
     *  description="product index page",
     * @OA\RequestBody(
     *    required=true,
     * *         @OA\MediaType(
     *           mediaType="multipart/form-data",
     *           @OA\Schema(
     *               @OA\Property(
     *                  property="search",
     *                  description="Enter search key ...",
     *                  type="string",
     *               ),@OA\Property(
     *                  property="sort",
     *                  description="Enter sorting type 1:most seller, 2:most visited, 3:newest, 4:cheapest, 5:expensive, 6:popular, 7:hasAmazingSale",
     *                  type="string",
     *               ),@OA\Property(
     *                  property="min_price",
     *                  description="Enter min_price",
     *                  type="string",
     *               ),@OA\Property(
     *                  property="max_price",
     *                  description="Enter max_price",
     *                  type="string",
     *               ),
     *     )
     *   )
     * ),
     *   @OA\Response(
     *      response=200,
     *      description="Its Ok",
     *      @OA\MediaType(
     *           mediaType="application/json",
     *      )
     *   )
     *)
     **/
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

    /**
     * @OA\Post(
     ** path="/api/v1/products/store",
     *  tags={"Product Module"},
     *  description="product index page",
     * @OA\RequestBody(
     *    required=true,
     * *         @OA\MediaType(
     *           mediaType="multipart/form-data",
     *           @OA\Schema(@OA\Property(
     *                  property="title",
     *                  description="Enter title",
     *                  type="string",
     *               ),@OA\Property(
     *                  property="price",
     *                  description="Enter price",
     *                  type="integer",
     *               ),
     *     )
     *   )
     * ),
     *   @OA\Response(
     *      response=200,
     *      description="Its Ok",
     *      @OA\MediaType(
     *           mediaType="application/json",
     *      )
     *   )
     *)
     **/
    public function store(ProductRequest $request): JsonResponse
    {
        $product = $this->service->store($request);
        return response()->json([
            'status' => 'success',
            'message' => 'product created successfully',
            'data' => new ProductResource($product),
        ], 201);
    }

    /**
     * @OA\Delete(
     ** path="/api/v1/products/destroy/{product}",
     *  tags={"Product Module"},
     *  security={{"sanctum":{}}},
     *  description="delete product",
     *     @OA\Parameter(
     *         in="path",
     *         name="product",
     *         required=true,
     *         @OA\Schema(
     *             type="integer",
     *         ),
     *     ),
     *   @OA\Response(
     *      response=200,
     *      description="Its Ok",
     *      @OA\MediaType(
     *           mediaType="application/json",
     *      )
     *   )
     *)
     **/
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
