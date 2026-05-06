<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class RoleBasedSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // remove existing seeded test users by email to avoid duplicates
        User::query()->whereIn('email', [
            'admin@iwander.test',
            'agent@iwander.test',
            'user@iwander.test'
        ])->delete();

        // System admin
        User::create([
            'name' => 'System Admin',
            'email' => 'admin@iwander.test',
            'password' => Hash::make('password'),
            'role' => 'admin',
            'status' => 'active',
            'commission_rate' => 0,
            'credit_limit' => 0,
        ]);

        // sample agent
        User::create([
            'name' => 'Sample Agent',
            'email' => 'agent@iwander.test',
            'password' => Hash::make('password'),
            'role' => 'agent',
            'status' => 'active',
            'commission_rate' => 10,
            'credit_limit' => 1000,
        ]);

        // sample regular user
        User::create([
            'name' => 'Sample User',
            'email' => 'user@iwander.test',
            'password' => Hash::make('password'),
            'role' => 'user',
            'status' => 'active',
        ]);
    }
}