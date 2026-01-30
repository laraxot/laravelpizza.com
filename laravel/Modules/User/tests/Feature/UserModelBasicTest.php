<?php

declare(strict_types=1);

use Modules\User\Models\User;
use Modules\User\Tests\TestCase;

// Simple test to verify basic functionality
uses(TestCase::class);

test('user model can be created', function () {
    $user = new User;

    expect($user)->toBeInstanceOf(User::class);
});

test('user model can access connection', function () {
    $user = new User;

    expect($user->getConnectionName())->toBe('user');
});

test('user model can create basic record', function () {
    $userData = [
        'name' => 'Test User',
        'first_name' => 'Test',
        'last_name' => 'User',
        'email' => 'test-'.uniqid().'@example.com',
        'password' => bcrypt('password'),
        'lang' => 'it',
        'is_active' => true,
    ];

    $user = User::create($userData);

    expect($user)->toBeInstanceOf(User::class);
    expect($user->name)->toBe('Test User');
    expect($user->email)->toBe($userData['email']);
    expect($user->lang)->toBe('it');
    expect($user->is_active)->toBe(true);

    // Clean up
    $user->delete();
});

test('user model can query records', function () {
    // Create some test data
    User::create([
        'name' => 'User 1',
        'email' => 'user1-'.uniqid().'@example.com',
        'password' => bcrypt('password'),
    ]);
    User::create([
        'name' => 'User 2',
        'email' => 'user2-'.uniqid().'@example.com',
        'password' => bcrypt('password'),
    ]);

    $users = User::all();

    expect($users)->toHaveCount(2);
});

test('user model can filter records', function () {
    // Create test data
    User::create(['name' => 'Active User', 'is_active' => true, 'email' => 'active-'.uniqid().'@example.com', 'password' => bcrypt('password')]);
    User::create(['name' => 'Inactive User', 'is_active' => false, 'email' => 'inactive-'.uniqid().'@example.com', 'password' => bcrypt('password')]);

    $activeUsers = User::where('is_active', true)->get();

    expect($activeUsers)->toHaveCount(1);
    expect($activeUsers->first()->name)->toBe('Active User');
});

test('user model can update records', function () {
    $user = User::create([
        'name' => 'Original Name',
        'email' => 'original-'.uniqid().'@example.com',
        'password' => bcrypt('password'),
    ]);

    $user->name = 'Updated Name';
    $user->save();

    expect($user->name)->toBe('Updated Name');
});
