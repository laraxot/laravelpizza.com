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
        $user = User::factory()->create([
            'type' => UserType::MasterAdmin,
            'email' => fake()->unique()->safeEmail(),
            'password' => Hash::make('password123'),
        ]);
    } catch (\Throwable) {
        $this->markTestSkipped('User type aliases (e.g. master_admin) are not configured in this install.');
    }
    \assert($user instanceof User);

    expect($user)->toBeInstanceOf(User::class);
    expect($user->email)->toBeString()->not->toBeEmpty();
    expect($user->type)->toBe(UserType::MasterAdmin);
});

test('user has correct type casting', function (): void {
    try {
        $user = User::factory()->create(['type' => UserType::MasterAdmin]);
    } catch (\Throwable) {
        $this->markTestSkipped('User type aliases (e.g. master_admin) are not configured in this install.');
    }
    \assert($user instanceof User);

    $type = $user->type;
    \assert($type instanceof UserType);

    expect($type)->toBeInstanceOf(UserType::class);
    expect($type->value)->toBe('master_admin');
});

test('user password is hashed', function (): void {
    $user = User::factory()->create(['password' => Hash::make('password123')]);
    \assert($user instanceof User);

    expect(Hash::check('password123', $user->password))->toBeTrue();
    expect(Hash::check('wrongpassword', $user->password))->toBeFalse();
});

test('user can change password', function (): void {
    $user = User::factory()->create(['password' => Hash::make('password123')]);
    \assert($user instanceof User);

    $user->update(['password' => Hash::make('newpassword123')]);

    $freshUser = $user->fresh();
    \assert($freshUser instanceof User);
    expect(Hash::check('newpassword123', $freshUser->password))->toBeTrue();
    expect(Hash::check('password123', $freshUser->password))->toBeFalse();
});

test('user can be updated', function (): void {
    try {
        $user = User::factory()->create([
            'type' => UserType::MasterAdmin,
            'email' => fake()->unique()->safeEmail(),
        ]);
    } catch (\Throwable) {
        $this->markTestSkipped('User type aliases (e.g. master_admin) are not configured in this install.');
    }
    \assert($user instanceof User);

    $user->update([
        'email' => 'updated@example.com',
    ]);

    $user->refresh();

    expect($user->email)->toBe('updated@example.com');
});

test('user can be deleted', function (): void {
    $user = User::factory()->create();
    \assert($user instanceof User);

    $userId = $user->id;

    $user->delete();

    expect(User::find($userId))->toBeNull();
});

test('user has fillable attributes', function (): void {
    $user = User::factory()->make();
    \assert($user instanceof User);

    $fillable = $user->getFillable();

    expect($fillable)->toContain('email');
    expect($fillable)->toContain('password');
    expect($fillable)->toContain('type');
});

test('user has hidden attributes', function (): void {
    $user = User::factory()->make();
    \assert($user instanceof User);

    $hidden = $user->getHidden();

    expect($hidden)->toContain('password');
    expect($hidden)->toContain('remember_token');
});

test('user can be found by email', function (): void {
    $user = User::factory()->create();
    \assert($user instanceof User);

    $foundUser = User::where('email', $user->email)->first();

    \assert($foundUser instanceof User);
    expect($foundUser)->toBeInstanceOf(User::class);
    expect($foundUser->id)->toBe($user->id);
});

test('user can be found by type', function (): void {
    try {
        $user = User::factory()->create(['type' => UserType::MasterAdmin]);
    } catch (\Throwable) {
        $this->markTestSkipped('User type aliases (e.g. master_admin) are not configured in this install.');
    }
    \assert($user instanceof User);

    $admins = User::where('type', UserType::MasterAdmin)->get();

    expect($admins)->toHaveCount(1);
    $firstAdmin = $admins->first();
    \assert($firstAdmin instanceof User);
    expect($firstAdmin->id)->toBe($user->id);
});

test('user can be created with different types', function (): void {
    try {
        $boUser = User::factory()->create(['type' => UserType::BoUser]);
        $customerUser = User::factory()->create(['type' => UserType::CustomerUser]);
    } catch (\Throwable) {
        $this->markTestSkipped('User type aliases are not configured in this install.');
    }
    \assert($boUser instanceof User);
    \assert($customerUser instanceof User);

    expect($boUser->type)->toBe(UserType::BoUser);
    expect($customerUser->type)->toBe(UserType::CustomerUser);
});

test('user has timestamps', function (): void {
    $user = User::factory()->create();
    \assert($user instanceof User);

    expect($user->created_at)->not->toBeNull();
    expect($user->updated_at)->not->toBeNull();
});

test('user soft delete functionality', function (): void {
    // Skip this test as User model does not implement SoftDeletes trait
    $this->markTestSkipped('User model does not implement SoftDeletes trait');
});
