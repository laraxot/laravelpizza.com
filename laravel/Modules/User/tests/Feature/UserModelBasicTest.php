<?php

declare(strict_types=1);

namespace Modules\User\Tests\Feature;

use Modules\User\Models\User;
use Modules\User\Tests\TestCase;

// Simple test to verify basic functionality
uses(TestCase::class);

test('user model can be created', function () {
    $user = new User();

<<<<<<< HEAD
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
=======
        Assert::assertInstanceOf(User::class, $user);
    });

    test('user model can access connection', function (): void {
        $user = new User();

        Assert::assertSame('user', $user->getConnectionName());
    });

    test('user model can create basic record', function (): void {
        /* @var TestCase $this */
        $this->skipUnlessUsersTableReady();

        $user = createTestUser([
            'name' => 'Test User',
            'first_name' => 'Test',
            'last_name' => 'User',
            'lang' => 'it',
            'is_active' => true,
        ]);

        Assert::assertInstanceOf(User::class, $user);
        Assert::assertSame('Test User', $user->name);
        Assert::assertNotEmpty($user->email);
        Assert::assertSame('it', $user->lang);
        Assert::assertSame(true, $user->is_active);
    });

    test('user model can query records', function (): void {
        /* @var TestCase $this */
        $this->skipUnlessUsersTableReady();

        $user1 = createTestUser(['name' => 'User 1']);
        $user2 = createTestUser(['name' => 'User 2']);

        $users = User::query()->whereIn('id', [$user1->id, $user2->id])->get();

        Assert::assertCount(2, $users);
    });

    test('user model can filter records', function (): void {
        /* @var TestCase $this */
        $this->skipUnlessUsersTableReady();

        $activeUser = createTestUser([
            'name' => 'Active User',
            'is_active' => true,
        ]);
        $inactiveUser = createTestUser([
            'name' => 'Inactive User',
            'is_active' => false,
        ]);

        $activeUsers = User::query()
            ->whereIn('id', [$activeUser->id, $inactiveUser->id])
            ->where('is_active', true)
            ->get();

        Assert::assertCount(1, $activeUsers);
        Assert::assertSame('Active User', $activeUsers->first()?->name);
    });

    test('user model can update records', function (): void {
        /* @var TestCase $this */
        $this->skipUnlessUsersTableReady();

        $user = createTestUser(['name' => 'Original Name']);

        $user->name = 'Updated Name';
        $user->save();

        Assert::assertSame('Updated Name', $user->name);
    });
>>>>>>> 9fa499be (.)
});
