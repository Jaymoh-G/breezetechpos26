<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Services\AuthService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function __construct(private readonly AuthService $authService)
    {
    }

    public function register(Request $request): JsonResponse
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', 'unique:users,email'],
            'password' => ['required', 'string', 'min:8'],
        ]);

        $result = $this->authService->register($data);

        return $this->success($result, 'User registered', 201);
    }

    public function registerTenant(Request $request): JsonResponse
    {
        $data = $request->validate([
            'owner_name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', 'unique:users,email'],
            'password' => ['required', 'string', 'min:8'],
            'business_name' => ['required', 'string', 'max:255'],
            'business_slug' => ['required', 'string', 'max:255', 'unique:tenants,slug'],
            'phone' => ['nullable', 'string', 'max:50'],
        ]);

        $result = $this->authService->registerTenant($data);

        return $this->success([
            'token' => $result['token'],
            'tenant' => $result['tenant'],
            'settings' => $result['settings'],
            'branch' => $result['branch'],
            'user' => $result['user'],
        ], 'Tenant registered', 201);
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

        return $this->success($result, 'Login successful');
    }

    public function profile(Request $request): JsonResponse
    {
        return $this->success($request->user(), 'Authenticated user profile');
    }

    public function logout(Request $request): JsonResponse
    {
        $this->authService->logout($request->user());

        return $this->success(null, 'Logout successful');
    }
}

