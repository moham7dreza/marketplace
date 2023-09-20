<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\ImageRequest;
use App\Http\Resources\ImageResource;
use App\Models\Product;
use App\Services\ImageService;
use Illuminate\Http\JsonResponse;

class ImageApiController extends Controller
{
    private ImageService $service;

    public function __construct(ImageService $service)
    {
        $this->service = $service;
    }

    /**
     * @OA\Post(
     ** path="/api/v1/images/store/{product}",
     *  tags={"Image Module"},
     *   security={{"sanctum":{}}},
     *  description="store image for product",
     * *     @OA\Parameter(
     *         in="path",
     *         name="product",
     *         required=true,
     *         description="Enter product id",
     *         @OA\Schema(
     *             type="integer",
     *         ),
     *     ),
     * @OA\RequestBody(
     *    required=true,
     *         @OA\MediaType(
     *           mediaType="multipart/form-data",
     *           @OA\Schema(
     *               @OA\Property(
     *                   property="image",
     *                   description="product image",
     *                   type="array",
     *                   @OA\Items(
     *                        type="string",
     *                        format="binary",
     *                   ),
     *                ),
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
    public function store(ImageRequest $request, Product $product): JsonResponse
    {
        $image = $this->service->store($request, $product);
        return response()->json([
            'status' => 'success',
            'message' => 'image created successfully',
            'data' => new ImageResource($image),
        ], 201);
    }
}
