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

    /**
     * @OA\Post(
     ** path="/api/v1/orders/store",
     *  tags={"Order Module"},
     *   security={{"sanctum":{}}},
     *  description="store user order",
     * @OA\RequestBody(
     *    required=true,
     *         @OA\MediaType(
     *           mediaType="multipart/form-data",
     *           @OA\Schema(
     *          @OA\Property(
     *                   property="delivery_id",
     *                   description="enter delivery_id",
     *                   type="string",
     *            ),
     *       )
     * )
     * ),
     *   @OA\Response(
     *      response=200,
     *      description="Data saved",
     *      @OA\MediaType(
     *           mediaType="application/json",
     *      )
     *   )
     *)
     *
     */
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
