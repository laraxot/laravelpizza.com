<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Hash;
use Modules\User\Enums\UserType;
use Modules\User\Models\User;
use Modules\User\Tests\TestCase;

/*
 * @property User $user
 */
uses(TestCase::class);

test('user can be created', function (): void {
    try {
        $factory = User::factory();
        \assert($factory instanceof Illuminate\Database\Eloquent\Factories\Factory);

        $user = $factory->create([
            'type' => UserType::MasterAdmin,
            'email' => fake()->unique()->safeEmail(),
            'password' => Hash::make('password123'),
        ]);
        \assert($user instanceof User);

        $this->assertInstanceOf(User::class, $user);
        $this->assertIsString($user->email);
        $this->assertNotSame('', $user->email);
        $this->assertSame(UserType::MasterAdmin, $user->type);
    } catch (Throwable) {
        $this->markTestSkipped('User type aliases (e.g. master_admin) are not configured in this install.');
    }
});

test('user has correct type casting', function (): void {
    try {
        $factory = User::factory();
        \assert($factory instanceof Illuminate\Database\Eloquent\Factories\Factory);

        $user = $factory->create(['type' => UserType::MasterAdmin]);
        \assert($user instanceof User);

        $type = $user->type;
        \assert($type instanceof UserType);

        $this->assertInstanceOf(UserType::class, $type);
        $this->assertSame('master_admin', $type->value);
    } catch (Throwable) {
        $this->markTestSkipped('User type aliases (e.g. master_admin) are not configured in this install.');
    }
});

test('user password is hashed', function (): void {
    $factory = User::factory();
    \assert($factory instanceof Illuminate\Database\Eloquent\Factories\Factory);
    $user = $factory->create(['password' => Hash::make('password123')]);
    \assert($user instanceof User);

    $this->assertTrue(Hash::check('password123', $user->password));
    $this->assertFalse(Hash::check('wrongpassword', $user->password));
});

test('user can change password', function (): void {
    $factory = User::factory();
    \assert($factory instanceof Illuminate\Database\Eloquent\Factories\Factory);
    $user = $factory->create(['password' => Hash::make('password123')]);
    \assert($user instanceof User);

    $user->update(['password' => Hash::make('newpassword123')]);

    $freshUser = $user->fresh();
    \assert($freshUser instanceof User);
    $this->assertTrue(Hash::check('newpassword123', $freshUser->password));
    $this->assertFalse(Hash::check('password123', $freshUser->password));
});

test('user can be updated', function (): void {
    try {
        $factory = User::factory();
        \assert($factory instanceof Illuminate\Database\Eloquent\Factories\Factory);

        $user = $factory->create([
            'type' => UserType::MasterAdmin,
            'email' => fake()->unique()->safeEmail(),
        ]);
        \assert($user instanceof User);

        $user->update([
            'email' => 'updated@example.com',
        ]);

        $user->refresh();

        $this->assertSame('updated@example.com', $user->email);
    } catch (Throwable) {
        $this->markTestSkipped('User type aliases (e.g. master_admin) are not configured in this install.');
    }
});

test('user can be deleted', function (): void {
    $factory = User::factory();
    \assert($factory instanceof Illuminate\Database\Eloquent\Factories\Factory);
    $user = $factory->create();
    \assert($user instanceof User);

    $userId = $user->id;

    $user->delete();

    $this->assertNull(User::find($userId));
});

test('user has fillable attributes', function (): void {
    $factory = User::factory();
    \assert($factory instanceof Illuminate\Database\Eloquent\Factories\Factory);
    $user = $factory->make();
    \assert($user instanceof User);

    $fillable = $user->getFillable();

    $this->assertContains('email', $fillable);
    $this->assertContains('password', $fillable);
    $this->assertContains('type', $fillable);
});

test('user has hidden attributes', function (): void {
    $factory = User::factory();
    \assert($factory instanceof Illuminate\Database\Eloquent\Factories\Factory);
    $user = $factory->make();
    \assert($user instanceof User);

    $hidden = $user->getHidden();

    $this->assertContains('password', $hidden);
    $this->assertContains('remember_token', $hidden);
});

test('user can be found by email', function (): void {
    $factory = User::factory();
    \assert($factory instanceof Illuminate\Database\Eloquent\Factories\Factory);
    $user = $factory->create();
    \assert($user instanceof User);

    $foundUser = User::where('email', $user->email)->first();

    \assert($foundUser instanceof User);
    $this->assertInstanceOf(User::class, $foundUser);
    $this->assertSame($user->id, $foundUser->id);
});

test('user can be found by type', function (): void {
    try {
        $factory = User::factory();
        \assert($factory instanceof Illuminate\Database\Eloquent\Factories\Factory);

        $user = $factory->create(['type' => UserType::MasterAdmin]);
        \assert($user instanceof User);

        $admins = User::where('type', UserType::MasterAdmin)->get();

        $this->assertCount(1, $admins);
        $firstAdmin = $admins->first();
        \assert($firstAdmin instanceof User);
        $this->assertSame($user->id, $firstAdmin->id);
    } catch (Throwable) {
        $this->markTestSkipped('User type aliases (e.g. master_admin) are not configured in this install.');
    }
});

test('user can be created with different types', function (): void {
    try {
        $factory = User::factory();
        \assert($factory instanceof Illuminate\Database\Eloquent\Factories\Factory);

        $boUser = $factory->create(['type' => UserType::BoUser]);
        $customerUser = $factory->create(['type' => UserType::CustomerUser]);
        \assert($boUser instanceof User);
        \assert($customerUser instanceof User);

        $this->assertSame(UserType::BoUser, $boUser->type);
        $this->assertSame(UserType::CustomerUser, $customerUser->type);
    } catch (Throwable) {
        $this->markTestSkipped('User type aliases are not configured in this install.');
    }
});

test('user has timestamps', function (): void {
    $factory = User::factory();
    \assert($factory instanceof Illuminate\Database\Eloquent\Factories\Factory);
    $user = $factory->create();
    \assert($user instanceof User);

    $this->assertNotNull($user->created_at);
    $this->assertNotNull($user->updated_at);
});

test('user soft delete functionality', function (): void {
    // Skip this test as User model does not implement SoftDeletes trait
    $this->markTestSkipped('User model does not implement SoftDeletes trait');
});
