<?php

namespace App\Http\Controllers\Auth\Api;

use App\Exceptions\User\CannotLoginUserException;
use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;

class LoginController extends Controller
{
    public function login(LoginRequest $request)
    {
        $credentials = $request->only('email', 'password');

        if (!auth()->attempt($credentials))
            throw new CannotLoginUserException();

        $token = auth()->user()->createToken('auth_token');

        return response()->json([
            'data' => [
                'token' => $token->plainTextToken
            ]
        ]);
    }

    public function logout()
    {
        auth()->user()->currentAccessToken()->delete();
        return response()->json([], 204);
    }
}
