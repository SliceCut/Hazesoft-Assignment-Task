<?php

namespace App\Http\Controllers\Api\V1\Auth;

use App\Http\Controllers\Controller;
use App\Http\Resources\Api\V1\UserResource;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class AuthUserDetailController extends Controller
{
    public function __invoke()
    {
        $user = auth()->user();

        if(!$user)
            new AuthorizationException("unauthorized");

        return new Response([
            'user' => UserResource::make($user)
        ]);
    }
}
