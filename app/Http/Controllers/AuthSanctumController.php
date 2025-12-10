<?php

namespace App\Http\Controllers;

use App\Services\AuthService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class AuthSanctumController extends Controller
{
    public function __construct(private readonly AuthService $authService)
    {
    }

    public function login(Request $request): JsonResponse
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required', 'string'],
        ]);

        $result = $this->authService->attemptLogin($credentials);

        if (! $result) {
            return $this->error('Invalid credentials', 401);
        }

        $user = $result['user']->load('tenant');

        return $this->success([
            'token' => $result['token'],
            'user' => $user,
            'tenant' => $user->tenant,
        ], 'Login successful');
    }

    public function me(Request $request): JsonResponse
    {
        $user = $request->user()?->load('tenant');

        return $this->success([
            'user' => $user,
            'tenant' => $user?->tenant,
        ], 'Authenticated user');
    }

    public function logout(Request $request): JsonResponse
    {
        $this->authService->logout($request->user());

        return $this->success(null, 'Logout successful');
    }
}

