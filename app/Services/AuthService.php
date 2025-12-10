<?php

namespace App\Services;

use App\Models\Branch;
use App\Models\Setting;
use App\Models\Tenant;
use App\Models\User;
use App\Repositories\Contracts\UserRepositoryInterface;
use Illuminate\Support\Facades\DB;
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
     * @return array{user: User, token: string, tenant: Tenant, settings: array, branch: Branch}
     */
    public function registerTenant(array $data): array
    {
        return DB::transaction(function () use ($data) {
            $tenant = Tenant::create([
                'name' => $data['business_name'],
                'slug' => $data['business_slug'],
            ]);

            $user = $this->users->create([
                'name' => $data['owner_name'],
                'email' => $data['email'],
                'password' => $data['password'],
                'tenant_id' => $tenant->id,
            ]);

            $branch = Branch::create([
                'tenant_id' => $tenant->id,
                'name' => 'Main Branch',
                'code' => 'MAIN-' . strtoupper(dechex(mt_rand(256, 4095))),
                'phone' => $data['phone'] ?? null,
            ]);

            $defaultSettings = [
                'timezone' => 'UTC',
                'currency' => 'USD',
                'locale' => 'en',
            ];

            Setting::create([
                'tenant_id' => $tenant->id,
                'key' => 'app.defaults',
                'value' => $defaultSettings,
            ]);

            $token = $this->issueToken($user);

            return [
                'user' => $user,
                'tenant' => $tenant,
                'branch' => $branch,
                'settings' => $defaultSettings,
                'token' => $token,
            ];
        });
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

