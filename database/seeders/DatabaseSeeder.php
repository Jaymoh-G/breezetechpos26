<?php

namespace Database\Seeders;

use App\Models\Tenant;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $tenant = Tenant::factory()->create([
            'name' => 'Demo Tenant',
            'slug' => 'demo-tenant',
        ]);

        User::factory()->for($tenant)->create([
            'name' => 'Demo Admin',
            'email' => 'admin@example.com',
        ]);

        User::factory(5)->for($tenant)->create();
    }
}
