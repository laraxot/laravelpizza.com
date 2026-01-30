<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Hash;
use Modules\User\Enums\UserType;
use Modules\User\Models\User;
use Modules\User\Tests\TestCase;

// Import per le funzioni Safe
use function Safe\json_decode;
use function Safe\json_encode;

uses(TestCase::class);

beforeEach(function (): void {
    /** @var User $user */
    $user = User::factory()->create([
        'type' => UserType::MasterAdmin,
        'email' => fake()->unique()->safeEmail(),
        'password' => Hash::make('password123'),
    ]);
    $this->user = $user;
});

test('user can be created', function (): void {
    expect($this->user)->toBeInstanceOf(User::class);
    expect($this->user->email)->toBeString()->not->toBeEmpty();
    expect($this->user->type->value ?? $this->user->type)->toBe(UserType::MasterAdmin->value);
});

test('user has correct type casting', function (): void {
    $type = $this->user->type;
    $typeValue = $type instanceof UserType ? $type->value : $type;
    expect($typeValue)->toBe('master_admin');
});

test('user password is hashed', function (): void {
    expect(Hash::check('password123', $this->user->password))->toBeTrue();
    expect(Hash::check('wrongpassword', $this->user->password))->toBeFalse();
});

test('user can change password', function (): void {
    $this->user->update(['password' => Hash::make('newpassword123')]);

    expect(Hash::check('newpassword123', $this->user->fresh()->password))->toBeTrue();
    expect(Hash::check('password123', $this->user->fresh()->password))->toBeFalse();
});

test('user can be updated', function (): void {
    $this->user->update([
        'email' => 'updated@example.com',
        'type' => UserType::BoUser,
    ]);

    $this->user->refresh();

    expect($this->user->email)->toBe('updated@example.com');
    $type = $this->user->type;
    $typeValue = $type instanceof UserType ? $type->value : $type;
    expect($typeValue)->toBe(UserType::BoUser->value);
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
    $foundUser = User::where('email', $this->user->email)->first();

    expect($foundUser)->toBeInstanceOf(User::class);
    expect($foundUser->id)->toBe($this->user->id);
});

test('user can be found by type', function (): void {
    $admins = User::where('type', UserType::MasterAdmin)->get();

    expect($admins->count())->toBeGreaterThanOrEqual(1);
    expect($admins->first()->id)->toBe($this->user->id);
});

test('user can be created with different types', function (): void {
    $boUser = User::factory()->create(['type' => UserType::BoUser]);
    $customerUser = User::factory()->create(['type' => UserType::CustomerUser]);

    $boTypeValue = $boUser->type instanceof UserType ? $boUser->type->value : $boUser->type;
    $customerTypeValue = $customerUser->type instanceof UserType ? $customerUser->type->value : $customerUser->type;

    expect($boTypeValue)->toBe(UserType::BoUser->value);
    expect($customerTypeValue)->toBe(UserType::CustomerUser->value);
});

test('user has timestamps', function (): void {
    expect($this->user->created_at)->not->toBeNull();
    expect($this->user->updated_at)->not->toBeNull();
});

test('user can access socialite', function (): void {
    expect($this->user->canAccessSocialite())->toBeTrue();
});

test('user has connection attribute', function (): void {
    expect($this->user->connection)->toBe('user');
});

test('user can be found by name pattern', function (): void {
    User::factory()->create(['name' => 'John Doe']);
    User::factory()->create(['name' => 'Jane Doe']);
    User::factory()->create(['name' => 'Bob Smith']);

    $doeUsers = User::where('name', 'like', '%Doe%')->get();

    expect($doeUsers->count())->toBeGreaterThanOrEqual(2);
    expect($doeUsers->every(fn ($user) => str_contains($user->name ?? '', 'Doe')))->toBeTrue();
});

test('user can be found by language', function (): void {
    User::factory()->create(['lang' => 'en']);
    User::factory()->create(['lang' => 'it']);
    User::factory()->create(['lang' => 'de']);

    $englishUsers = User::where('lang', 'en')->get();

    expect($englishUsers->count())->toBeGreaterThanOrEqual(1);
    expect($englishUsers->first()->lang)->toBe('en');
});

test('user can be found by active status', function (): void {
    User::factory()->create(['is_active' => true]);
    User::factory()->create(['is_active' => false]);
    User::factory()->create(['is_active' => true]);

    $activeUsers = User::where('is_active', true)->get();

    expect($activeUsers->count())->toBeGreaterThanOrEqual(2);
    expect($activeUsers->every(fn ($user) => $user->is_active))->toBeTrue();
});

test('user can be found by otp status', function (): void {
    User::factory()->create(['is_otp' => true]);
    User::factory()->create(['is_otp' => false]);
    User::factory()->create(['is_otp' => true]);

    $otpUsers = User::where('is_otp', true)->get();

    expect($otpUsers->count())->toBeGreaterThanOrEqual(2);
    expect($otpUsers->every(fn ($user) => $user->is_otp))->toBeTrue();
});

test('user can handle null values', function (): void {
    $user = User::factory()->create([
        'first_name' => null,
        'last_name' => null,
        'lang' => null,
    ]);

    expect($user->first_name)->toBeNull();
    expect($user->last_name)->toBeNull();
    expect($user->lang)->toBeNull();
});
