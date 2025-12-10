<?php

namespace App\Services;

use App\Models\User;
use App\Repositories\Contracts\UserRepositoryInterface;
use Illuminate\Support\Facades\Hash;
use Laravel\Sanctum\NewAccessToken;

class AuthService
{
    public function __construct(private readonly UserRepositoryInterface $users)
    {
    }

    /**
     * @return array{user: User, token: string}
     */
    public function register(array $data): array
    {
        $user = $this->users->create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => $data['password'],
        ]);

        $token = $this->issueToken($user);

        return ['user' => $user, 'token' => $token];
    }

    /**
     * @return array{user: User, token: string}|null
     */
    public function attemptLogin(array $credentials): ?array
    {
        $user = $this->users->findByEmail($credentials['email']);

        if (! $user || ! Hash::check($credentials['password'], $user->password)) {
            return null;
        }

        return ['user' => $user, 'token' => $this->issueToken($user)];
    }

    public function logout(User $user): void
    {
        $user->currentAccessToken()?->delete();
    }

    protected function issueToken(User $user): string
    {
        /** @var NewAccessToken $token */
        $token = $user->createToken('api_token');

        return $token->plainTextToken;
    }
}

