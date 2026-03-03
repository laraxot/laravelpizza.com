<?php

declare(strict_types=1);

use Modules\User\Models\User;
use Modules\User\Tests\TestCase;

// Simple test to verify basic functionality
uses(TestCase::class);

test('user model can be created', function () {
    $user = new User();

    expect($user)->toBeInstanceOf(User::class);
});

test('user model can access connection', function () {
    $user = new User();

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
});

test('user model can query records', function () {
    // Create some test data
    $countBefore = User::count();

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

    expect($users->count())->toBeGreaterThanOrEqual(2);
});

test('user model can filter records', function () {
    // Create test data with unique identifiers
    $uniqueToken = uniqid();
    User::create(['name' => 'Active User '.$uniqueToken, 'is_active' => true, 'email' => 'active-'.$uniqueToken.'@example.com', 'password' => bcrypt('password')]);
    User::create(['name' => 'Inactive User '.$uniqueToken, 'is_active' => false, 'email' => 'inactive-'.$uniqueToken.'@example.com', 'password' => bcrypt('password')]);

    $activeUsers = User::where('name', 'Active User '.$uniqueToken)->where('is_active', true)->get();

    expect($activeUsers)->toHaveCount(1);
    expect($activeUsers->first()->name)->toBe('Active User '.$uniqueToken);
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
