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

    /**
     * @OA\Post(
     ** path="/api/v1/cart-items/store/{product}",
     *  tags={"Cart Module"},
     *  security={{"sanctum":{}}},
     *  description="add item to cart",
     *     @OA\Parameter(
     *         in="path",
     *         name="item",
     *         required=true,
     *         @OA\Schema(
     *             type="integer",
     *         ),
     *     ),
     * @OA\RequestBody(
     *    required=true,
     *         @OA\MediaType(
     *           mediaType="multipart/form-data",
     *           @OA\Schema(
     *     @OA\Property(
     *                  property="number",
     *                  description="item number count",
     *                  type="integer",
     *               ),
     *           ),
     *       )
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
