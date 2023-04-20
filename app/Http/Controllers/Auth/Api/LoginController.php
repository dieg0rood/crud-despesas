<?php

namespace App\Http\Controllers\Auth\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    public function login(Request $request)
    {
        //ToDo validar request
        $credentials = $request->only('email', 'password');

        if (!auth()->attempt($credentials))
            abort(401, 'Invalid Credentials');

        $token = auth()->user()->createAccessToken();

        return response()->json([
            'data' => [
                'token' => $token->plainTextToken
            ]
        ]);
    }
}
