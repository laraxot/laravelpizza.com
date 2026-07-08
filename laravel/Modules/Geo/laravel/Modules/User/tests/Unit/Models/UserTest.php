<?php

declare(strict_types=1);

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Schema;
use Modules\User\Database\Factories\UserFactory;
use Modules\User\Enums\UserType;
use Modules\User\Models\User;
use PHPUnit\Framework\Assert;

uses(Modules\User\Tests\TestCase::class);

/**
 * @param array<string, mixed> $attributes
 */
function modelsUserCreate(array $attributes = []): User
{
    return UserFactory::new()->createOne(array_merge([
        'email' => 'test-'.uniqid('', true).'@example.com',
    ], $attributes));
}

function modelsUserCreateDefault(): User
{
    return modelsUserCreate([
        'type' => UserType::MasterAdmin,
        'password' => Hash::make('password123'),
    ]);
}

function modelsUserTypeValue(User $user): string
{
    $type = $user->type;

    return $type instanceof UserType ? $type->value : (string) $type;
}

test('user can be created', function (): void {
    $user = modelsUserCreateDefault();

    Assert::assertInstanceOf(User::class, $user);
    Assert::assertIsString($user->email);
    Assert::assertNotSame('', $user->email);
    Assert::assertSame(UserType::MasterAdmin->value, modelsUserTypeValue($user));
});

test('user has correct type casting', function (): void {
    Assert::assertSame('master_admin', modelsUserTypeValue(modelsUserCreateDefault()));
});

test('user password is hashed', function (): void {
    $user = modelsUserCreateDefault();

    Assert::assertTrue(Hash::check('password123', $user->password));
    Assert::assertFalse(Hash::check('wrongpassword', $user->password));
});

test('user can change password', function (): void {
    $user = modelsUserCreateDefault();
    $user->update(['password' => Hash::make('newpassword123')]);

    $refreshed = $user->fresh();
    Assert::assertInstanceOf(User::class, $refreshed);
    Assert::assertTrue(Hash::check('newpassword123', $refreshed->password));
    Assert::assertFalse(Hash::check('password123', $refreshed->password));
});

test('user can be updated', function (): void {
    $user = modelsUserCreateDefault();

    $updatedEmail = 'updated-'.uniqid('', true).'@example.com';
    $user->update([
        'email' => $updatedEmail,
        'type' => UserType::BoUser,
    ]);
    $user->refresh();

    Assert::assertSame($updatedEmail, $user->email);
    Assert::assertSame(UserType::BoUser->value, modelsUserTypeValue($user));
});

test('user can be deleted', function (): void {
    $user = modelsUserCreateDefault();
    $userId = $user->id;

    if (! Schema::connection('user')->hasTable('model_has_permission')) {
        DB::connection('user')->table('users')->where('id', $userId)->delete();
    } else {
        $user->delete();
    }

    Assert::assertNull(User::find($userId));
});

test('user has fillable attributes', function (): void {
    $fillable = modelsUserCreateDefault()->getFillable();

    Assert::assertContains('email', $fillable);
    Assert::assertContains('password', $fillable);
    Assert::assertContains('type', $fillable);
});

test('user has hidden attributes', function (): void {
    $hidden = modelsUserCreateDefault()->getHidden();

    Assert::assertContains('password', $hidden);
    Assert::assertContains('remember_token', $hidden);
});

test('user can be found by email', function (): void {
    $user = modelsUserCreateDefault();
    $foundUser = User::where('email', $user->email)->first();

    Assert::assertInstanceOf(User::class, $foundUser);
    Assert::assertSame($user->id, $foundUser->id);
});

test('user can be found by type', function (): void {
    $user = modelsUserCreateDefault();
    $admins = User::where('type', UserType::MasterAdmin)->get();

    Assert::assertGreaterThanOrEqual(1, $admins->count());
    Assert::assertTrue($admins->contains(static fn (User $admin): bool => $admin->id === $user->id));
});

test('user can be created with different types', function (): void {
    $boUser = modelsUserCreate(['type' => UserType::BoUser]);
    $customerUser = modelsUserCreate(['type' => UserType::CustomerUser]);

    Assert::assertSame(UserType::BoUser->value, modelsUserTypeValue($boUser));
    Assert::assertSame(UserType::CustomerUser->value, modelsUserTypeValue($customerUser));
});

test('user has timestamps', function (): void {
    $user = modelsUserCreateDefault();

    Assert::assertNotNull($user->created_at);
    Assert::assertNotNull($user->updated_at);
});

test('user can access socialite', function (): void {
    Assert::assertTrue(modelsUserCreateDefault()->canAccessSocialite());
});

test('user has connection attribute', function (): void {
    Assert::assertSame('user', modelsUserCreateDefault()->getConnectionName());
});

test('user can be found by name pattern', function (): void {
    modelsUserCreate(['name' => 'John Doe']);
    modelsUserCreate(['name' => 'Jane Doe']);
    modelsUserCreate(['name' => 'Bob Smith']);

    $doeUsers = User::where('name', 'like', '%Doe%')->get();

    Assert::assertGreaterThanOrEqual(2, $doeUsers->count());
    foreach ($doeUsers as $doeUser) {
        Assert::assertStringContainsString('Doe', (string) $doeUser->name);
    }
});

test('user can be found by language', function (): void {
    modelsUserCreate(['lang' => 'en']);
    modelsUserCreate(['lang' => 'it']);
    modelsUserCreate(['lang' => 'de']);

    $englishUsers = User::where('lang', 'en')->get();

    Assert::assertGreaterThanOrEqual(1, $englishUsers->count());
    $first = $englishUsers->first();
    Assert::assertInstanceOf(User::class, $first);
    Assert::assertSame('en', $first->lang);
});

test('user can be found by active status', function (): void {
    modelsUserCreate(['is_active' => true]);
    modelsUserCreate(['is_active' => false]);
    modelsUserCreate(['is_active' => true]);

    $activeUsers = User::where('is_active', true)->get();

    Assert::assertGreaterThanOrEqual(2, $activeUsers->count());
    foreach ($activeUsers as $activeUser) {
        Assert::assertTrue((bool) $activeUser->is_active);
    }
});

test('user can be found by otp status', function (): void {
    modelsUserCreate(['is_otp' => true]);
    modelsUserCreate(['is_otp' => false]);
    modelsUserCreate(['is_otp' => true]);

    $otpUsers = User::where('is_otp', true)->get();

    Assert::assertGreaterThanOrEqual(2, $otpUsers->count());
    foreach ($otpUsers as $otpUser) {
        Assert::assertTrue((bool) $otpUser->is_otp);
    }
});

test('user can handle null values', function (): void {
    $user = modelsUserCreate([
        'first_name' => null,
        'last_name' => null,
        'lang' => null,
    ]);

    Assert::assertNull($user->first_name);
    Assert::assertNull($user->last_name);
    Assert::assertNull($user->lang);
});
