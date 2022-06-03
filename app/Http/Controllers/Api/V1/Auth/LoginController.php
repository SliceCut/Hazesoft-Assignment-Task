<?php

namespace App\Http\Controllers\Api\V1\Auth;

use App\Domain\Repositories\User\UserRepositoryInterface;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\Api\V1\LoginRequest;
use App\Http\Resources\Api\V1\UserResource;
use App\Models\User;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Http\Response;

class LoginController extends Controller
{
    private UserRepositoryInterface $userRepository;

    public function __construct(
        UserRepositoryInterface $userRepository
    )
    {
        $this->userRepository = $userRepository;
    }

    public function __invoke(LoginRequest $request)
    {
        if (!auth()->attempt(['email' => $request->email, 'password' => $request->password])) {
            throw new AuthenticationException('Invalid Credentials');
        }

        $user = $this->userRepository->findUserBy(['email' => $request->email]);
        $token = $this->userRepository->createUserToken($user)->plainTextToken;

        return new Response([
            'user' => new UserResource($user),
            'token' => $token,
        ], 200);
    }
}
