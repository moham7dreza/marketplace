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
