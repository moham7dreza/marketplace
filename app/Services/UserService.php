<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class UserService
{
    public function register($request): array
    {
        $user = User::query()->where('email', $request->email)->first();
        if (empty($user)) {
            $user = $this->store($request);
        }
        $token = $user->createToken($user->name)->accessToken;
        auth()->loginUsingId($user->id);
        return ['user' => $user, 'token' => $token];
    }

    private function query(): Builder
    {
        return User::query();
    }

    public function store($request): Model|Builder
    {
        return $this->query()->create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
        ]);
    }
}
