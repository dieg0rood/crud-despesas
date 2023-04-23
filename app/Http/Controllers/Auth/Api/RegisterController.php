<?php

namespace App\Http\Controllers\Auth\Api;

use App\Exceptions\User\CannotCreateUserException;
use App\Http\Controllers\Controller;
use App\Http\Requests\RegisterRequest;
use Illuminate\Http\Request;
use App\Models\User;

class RegisterController extends Controller
{
    public function register(RegisterRequest $request, User $user)
    {
        $userData = $request->only('name','email', 'password');
        $userData['password'] = bcrypt($userData['password']);

        if(!$user = $user->create($userData))
            throw new CannotCreateUserException();

        return response()->json([
            'data' => [
                'user' => $user
            ]
        ]);
    }
}
