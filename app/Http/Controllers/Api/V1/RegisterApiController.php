<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\RegisterRequest;
use App\Http\Resources\UserResource;
use App\Services\UserService;
use Illuminate\Http\JsonResponse;

class RegisterApiController extends Controller
{

    /**
     * @OA\Post(
     ** path="/api/v1/register",
     *  tags={"Auth Module"},
     *  description="register user",
     * @OA\RequestBody(
     *    required=true,
     * *         @OA\MediaType(
     *           mediaType="multipart/form-data",
     *           @OA\Schema(
     *              @OA\Property(
     *                  property="name",
     *                  description="Enter name",
     *                  type="string",
     *               ),@OA\Property(
     *                  property="email",
     *                  description="Enter email",
     *                  type="string",
     *               ),@OA\Property(
     *                  property="password",
     *                  description="Enter password",
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
    public function index(RegisterRequest $request, UserService $userService): JsonResponse
    {
        $response = $userService->register($request);
        return response()->json([
            'status' => 'success',
            'message' => 'user created successfully',
            'data' => [
                'user' => new UserResource($response['user']),
                'token' => $response['token']
            ],
        ], 201);
    }
}
