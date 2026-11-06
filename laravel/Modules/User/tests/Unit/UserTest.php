<?php

declare(strict_types=1);

use Tests\TestCase;
use Illuminate\Support\Facades\Hash;
use Modules\User\Enums\UserType;
use Modules\User\Models\User;

/**
 * @property User $user
 */

uses(TestCase::class);

beforeEach(function (): void {
    $this->user = User::factory()->create([
        'type' => UserType::MasterAdmin,
        'email' => fake()->unique()->safeEmail(),
        'password' => Hash::make('password123'),
    ]);
});

test('user can be created', function (): void {
    expect($this->user->email)->not->toBeEmpty();
    expect($this->user->type)->toBe(UserType::MasterAdmin);
});

test('user has correct type casting', function (): void {
    expect($this->user->type)->toBe(UserType::MasterAdmin);
});

test('user password is hashed', function (): void {
    expect(Hash::check('password123', $this->user->password))->toBeTrue();
    expect(Hash::check('wrongpassword', $this->user->password))->toBeFalse();
});

test('user can change password', function (): void {
    $this->user->update(['password' => Hash::make('newpassword123')]);

    $user = User::findOrFail($this->user->id);
    expect(Hash::check('newpassword123', $user->password))->toBeTrue();
    expect(Hash::check('password123', $user->password))->toBeFalse();
});

test('user can be updated', function (): void {
    $this->user->update([
        'email' => 'updated@example.com',
        'type' => UserType::BoUser,
    ]);

    $this->user->refresh();

    expect($this->user->email)->toBe('updated@example.com');
    expect($this->user->type)->toBe(UserType::BoUser);
});

test('user can be deleted', function (): void {
    $userId = $this->user->id;

    $this->user->delete();

    expect(User::find($userId))->toBeNull();
});

test('user has fillable attributes', function (): void {
    $fillable = $this->user->getFillable();

    expect($fillable)->toContain('email');
    expect($fillable)->toContain('password');
    expect($fillable)->toContain('type');
});

test('user has hidden attributes', function (): void {
    $hidden = $this->user->getHidden();

    expect($hidden)->toContain('password');
    expect($hidden)->toContain('remember_token');
});

test('user can be found by email', function (): void {
    $foundUser = User::where('email', $this->user->email)->firstOrFail();
    expect($foundUser->id)->toBe($this->user->id);
});

test('user can be found by type', function (): void {
    $admins = User::where('type', UserType::MasterAdmin)->get();

    expect($admins)->toHaveCount(1);
    expect($admins->firstOrFail()->id)->toBe($this->user->id);
});

test('user can be created with different types', function (): void {
    $boUser = User::factory()->create(['type' => UserType::BoUser]);
    $customerUser = User::factory()->create(['type' => UserType::CustomerUser]);

    expect($boUser->type)->toBe(UserType::BoUser);
    expect($customerUser->type)->toBe(UserType::CustomerUser);
});

test('user has timestamps', function (): void {
    expect($this->user->created_at)->not->toBeNull();
    expect($this->user->updated_at)->not->toBeNull();
});

test('user soft delete functionality', function (): void {
    // Skip this test as User model does not implement SoftDeletes trait
    $this->markTestSkipped('User model does not implement SoftDeletes trait');
});
