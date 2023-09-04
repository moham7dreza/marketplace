<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;

class LoginApiController extends Controller
{
    public function index(LoginRequest $request): JsonResponse
    {
        $credentials = $request->only('email', 'password');
        if (!auth()->attempt($credentials)) {
            return response()->json([
                'status' => 'success',
                'message' => 'failed to login',
                'data' => [],
            ], 401);
        }
        $user = Auth::getProvider()->retrieveByCredentials($credentials);
        Auth::login($user);

        return response()->json([
            'status' => 'success',
            'message' => 'login successfully',
            'data' => [],
        ], 201);
    }

    public function logout(): JsonResponse
    {
        auth()->logout();

        return response()->json([
            'status' => 'success',
            'message' => 'logout successfully',
            'data' => [],
        ], 201);
    }
}
