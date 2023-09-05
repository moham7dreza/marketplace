<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\RegisterRequest;
use App\Http\Resources\UserResource;
use App\Services\UserService;
use Illuminate\Http\JsonResponse;

class RegisterApiController extends Controller
{
    public function index(RegisterRequest $request, UserService $userService): JsonResponse
    {
        dd(1);
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
