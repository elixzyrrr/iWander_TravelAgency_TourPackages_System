<?php

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

it('renders the admin dashboard', function () {
    $this->get(route('admin.dashboard'))->assertOk();
});

it('stores a new admin user in the database', function () {
    $this->post(route('admin.users.store'), [
        'name' => 'Ava Cruz',
        'email' => 'ava.cruz@example.com',
        'role' => 'agent',
        'status' => 'active',
        'commission_rate' => 12,
        'credit_limit' => 50000,
        'password' => 'password123',
        'password_confirmation' => 'password123',
    ])->assertRedirect(route('admin.users.index'));

    $this->assertDatabaseHas('users', [
        'email' => 'ava.cruz@example.com',
        'role' => 'agent',
        'status' => 'active',
    ]);

    expect(User::query()->count())->toBe(1);
});
