<?php

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;

uses(RefreshDatabase::class);

it('redirects an admin to the admin dashboard', function () {
    $admin = User::query()->create([
        'name' => 'Admin User',
        'email' => 'admin@example.com',
        'password' => Hash::make('password'),
        'role' => 'admin',
        'status' => 'active',
        'commission_rate' => 0,
        'credit_limit' => 0,
    ]);

    $this->actingAs($admin)
        ->get(route('dashboard'))
        ->assertRedirect(route('admin.dashboard'));
});

it('redirects an agent to the agent dashboard', function () {
    $agent = User::query()->create([
        'name' => 'Agent User',
        'email' => 'agent@example.com',
        'password' => Hash::make('password'),
        'role' => 'agent',
        'status' => 'active',
        'commission_rate' => 0,
        'credit_limit' => 0,
    ]);

    $this->actingAs($agent)
        ->get(route('dashboard'))
        ->assertRedirect(route('agent.dashboard'));
});

it('redirects a regular user to the user dashboard', function () {
    $user = User::query()->create([
        'name' => 'Regular User',
        'email' => 'user@example.com',
        'password' => Hash::make('password'),
        'role' => 'user',
        'status' => 'active',
        'commission_rate' => 0,
        'credit_limit' => 0,
    ]);

    $this->actingAs($user)
        ->get(route('dashboard'))
        ->assertRedirect(route('user.dashboard'));
});

it('registers a new user and assigns the user role', function () {
    $this->post(route('register.store'), [
        'name' => 'New Member',
        'email' => 'new-member@example.com',
        'password' => 'password123',
        'password_confirmation' => 'password123',
    ])->assertRedirect(route('dashboard'));

    $this->assertDatabaseHas('users', [
        'email' => 'new-member@example.com',
        'role' => 'user',
        'status' => 'active',
    ]);
});
