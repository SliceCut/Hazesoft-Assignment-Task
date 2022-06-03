<?php

namespace App\Http\Controllers\Api\V1\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\Api\V1\LoginRequest;
use App\Models\User;
use Illuminate\Auth\AuthenticationException;

class LoginController extends Controller
{
    public function __invoke(LoginRequest $request)
    {
        if (!auth()->attempt(['email' => $request->email, 'password' => $request->password])) {
            throw new AuthenticationException('Invalid Credentials');
        }

        $user = User::where('email', $request->email)->first();
        $token = $user->createToken('authToken')->plainTextToken;
        return response()->json([
            'error' => false,
            'code' => 200,
            'data' => [
                'user' => new UserResource($user),
                'token' => $token,
                'permissions'=>(new UserRepository($user))->getAllPermissions()
            ],
            'message' => 'user logged in successfully'
        ]);
    }
}
