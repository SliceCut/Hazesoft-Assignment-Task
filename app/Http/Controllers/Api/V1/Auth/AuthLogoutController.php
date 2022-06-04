<?php

namespace App\Http\Controllers\Api\V1\Auth;

use App\Domain\Repositories\User\UserRepositoryInterface;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AuthLogoutController extends Controller
{
    private UserRepositoryInterface $userRepository;

    public function __construct(
        UserRepositoryInterface $userRepository
    )
    {
        $this->userRepository = $userRepository;
    }

    public function __invoke()
    {
        $user = auth()->user();

        $this->userRepository->deleteUserToken($user, $user->currentAccessToken()->id);

        return $this->responseOk(
            "User logout successfully"
        );
    }
}
