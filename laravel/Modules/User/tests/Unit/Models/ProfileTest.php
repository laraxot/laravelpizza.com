<?php

declare(strict_types=1);

namespace Modules\User\Tests\Unit\Models;

use Illuminate\Foundation\Testing\DatabaseTransactions;
use Modules\User\Models\Profile;
use Modules\User\Tests\TestCase;

uses(TestCase::class, DatabaseTransactions::class);

test('can create profile with minimal data', function (): void {
    $profile = Profile::factory()->create([
        'first_name' => 'John',
        'last_name' => 'Doe',
        'user_name' => 'johndoe',
        'email' => 'john@example.com',
    ]);

    $this->assertDatabaseHas('profiles', [
        'id' => $profile->id,
        'first_name' => 'John',
        'last_name' => 'Doe',
        'user_name' => 'johndoe',
        'email' => 'john@example.com',
    ]);
});

test('can create profile with all fields', function (): void {
    $profileData = [
        'first_name' => 'Jane',
        'last_name' => 'Smith',
        'user_name' => 'janesmith',
        'email' => 'jane@example.com',
        'phone' => '+1234567890',
        'bio' => 'Software Developer',
        'avatar' => 'avatar.jpg',
        'timezone' => 'UTC',
        'locale' => 'en',
        'preferences' => ['theme' => 'dark', 'notifications' => true],
        'status' => 'active',
        'extra' => ['skills' => ['PHP', 'Laravel'], 'experience' => 5],
    ];

    $profile = Profile::factory()->create($profileData);

    $this->assertDatabaseHas('profiles', [
        'id' => $profile->id,
        'first_name' => 'Jane',
        'last_name' => 'Smith',
        'user_name' => 'janesmith',
        'email' => 'jane@example.com',
        'phone' => '+1234567890',
        'bio' => 'Software Developer',
        'avatar' => 'avatar.jpg',
        'timezone' => 'UTC',
        'locale' => 'en',
        'status' => 'active',
    ]);

    // Verifica campi JSON
    expect($profile->preferences)->toBe(['theme' => 'dark', 'notifications' => true]);
    expect($profile->extra->toArray())->toBe(['skills' => ['PHP', 'Laravel'], 'experience' => 5]);
});

test('profile has schemaless attributes', function (): void {
    $profile = new Profile();
    $expectedAttributes = ['extra'];
    expect($profile->getSchemalessAttributes())->toBe($expectedAttributes);
});

test('profile has table name', function (): void {
    $profile = new Profile();
    expect($profile->getTable())->toBe('profiles');
});

test('can find profile by email', function (): void {
    $profile = Profile::factory()->create(['email' => 'unique@example.com']);
    $foundProfile = Profile::where('email', 'unique@example.com')->first();
    expect($foundProfile)->not->toBeNull();
    expect($foundProfile->id)->toBe($profile->id);
});

test('can find profile by user name', function (): void {
    $profile = Profile::factory()->create(['user_name' => 'uniqueuser']);
    $foundProfile = Profile::where('user_name', 'uniqueuser')->first();
    expect($foundProfile)->not->toBeNull();
    expect($foundProfile->id)->toBe($profile->id);
});

test('can find profile by first name', function (): void {
    $profile = Profile::factory()->create(['first_name' => 'Unique']);
    $foundProfile = Profile::where('first_name', 'Unique')->first();
    expect($foundProfile)->not->toBeNull();
    expect($foundProfile->id)->toBe($profile->id);
});

test('can find profile by last name', function (): void {
    $profile = Profile::factory()->create(['last_name' => 'Unique']);
    $foundProfile = Profile::where('last_name', 'Unique')->first();
    expect($foundProfile)->not->toBeNull();
    expect($foundProfile->id)->toBe($profile->id);
});

test('can find profile by phone', function (): void {
    $profile = Profile::factory()->create(['phone' => '+1234567890']);
    $foundProfile = Profile::where('phone', '+1234567890')->first();
    expect($foundProfile)->not->toBeNull();
    expect($foundProfile->id)->toBe($profile->id);
});

test('can find profile by status', function (): void {
    Profile::factory()->create(['status' => 'active']);
    Profile::factory()->create(['status' => 'inactive']);
    Profile::factory()->create(['status' => 'pending']);

    $activeProfiles = Profile::where('status', 'active')->get();
    expect($activeProfiles)->toHaveCount(1);
    expect($activeProfiles->first()->status)->toBe('active');
});

test('can find profile by timezone', function (): void {
    Profile::factory()->create(['timezone' => 'UTC']);
    Profile::factory()->create(['timezone' => 'Europe/Rome']);
    Profile::factory()->create(['timezone' => 'America/New_York']);

    $utcProfiles = Profile::where('timezone', 'UTC')->get();
    expect($utcProfiles)->toHaveCount(1);
    expect($utcProfiles->first()->timezone)->toBe('UTC');
});

test('can find profile by locale', function (): void {
    Profile::factory()->create(['locale' => 'en']);
    Profile::factory()->create(['locale' => 'it']);
    Profile::factory()->create(['locale' => 'de']);

    $englishProfiles = Profile::where('locale', 'en')->get();
    expect($englishProfiles)->toHaveCount(1);
    expect($englishProfiles->first()->locale)->toBe('en');
});

test('can find profiles by name pattern', function (): void {
    Profile::factory()->create(['first_name' => 'John', 'last_name' => 'Doe']);
    Profile::factory()->create(['first_name' => 'Jane', 'last_name' => 'Doe']);
    Profile::factory()->create(['first_name' => 'Bob', 'last_name' => 'Smith']);

    $doeProfiles = Profile::where('last_name', 'like', '%Doe%')->get();
    expect($doeProfiles)->toHaveCount(2);
    expect($doeProfiles->every(fn ($profile) => str_contains($profile->last_name, 'Doe')))->toBeTrue();
});

test('can find profiles by bio pattern', function (): void {
    Profile::factory()->create(['bio' => 'Software Developer']);
    Profile::factory()->create(['bio' => 'Designer']);
    Profile::factory()->create(['bio' => 'Product Manager']);

    $devProfiles = Profile::where('bio', 'like', '%Developer%')->get();
    expect($devProfiles)->toHaveCount(1);
    expect($devProfiles->every(fn ($profile) => str_contains($profile->bio, 'Developer')))->toBeTrue();
});

test('can update profile', function (): void {
    $profile = Profile::factory()->create(['first_name' => 'Old Name']);
    $profile->update(['first_name' => 'New Name']);

    $this->assertDatabaseHas('profiles', [
        'id' => $profile->id,
        'first_name' => 'New Name',
    ]);
});

test('can handle null values', function (): void {
    $profile = Profile::factory()->create([
        'first_name' => 'Test',
        'last_name' => 'User',
        'user_name' => 'testuser',
        'email' => 'test@example.com',
        'phone' => null,
        'bio' => null,
        'avatar' => null,
        'timezone' => null,
        'locale' => null,
    ]);

    $this->assertDatabaseHas('profiles', [
        'id' => $profile->id,
        'phone' => null,
        'bio' => null,
        'avatar' => null,
        'timezone' => null,
        'locale' => null,
    ]);
});

test('can find profiles by multiple criteria', function (): void {
    Profile::factory()->create([
        'status' => 'active',
        'timezone' => 'UTC',
        'locale' => 'en',
    ]);

    Profile::factory()->create([
        'status' => 'active',
        'timezone' => 'Europe/Rome',
        'locale' => 'it',
    ]);

    Profile::factory()->create([
        'status' => 'inactive',
        'timezone' => 'UTC',
        'locale' => 'en',
    ]);

    $profiles = Profile::where('status', 'active')->where('timezone', 'UTC')->get();
    expect($profiles)->toHaveCount(1);
    expect($profiles->first()->status)->toBe('active');
    expect($profiles->first()->timezone)->toBe('UTC');
});

test('profile has roles relationship', function (): void {
    $profile = Profile::factory()->create();
    expect(method_exists($profile, 'roles'))->toBeTrue();
});

test('profile has permissions relationship', function (): void {
    $profile = Profile::factory()->create();
    expect(method_exists($profile, 'permissions'))->toBeTrue();
});

test('profile has teams relationship', function (): void {
    $profile = Profile::factory()->create();
    expect(method_exists($profile, 'teams'))->toBeTrue();
});

test('profile has devices relationship', function (): void {
    $profile = Profile::factory()->create();
    expect(method_exists($profile, 'devices'))->toBeTrue();
});

test('profile has media relationship', function (): void {
    $profile = Profile::factory()->create();
    expect(method_exists($profile, 'media'))->toBeTrue();
});

test('profile can use permission scopes', function (): void {
    $profile = Profile::factory()->create();
    expect(method_exists($profile, 'scopePermission'))->toBeTrue();
    expect(method_exists($profile, 'scopeWithoutPermission'))->toBeTrue();
});

test('profile can use role scopes', function (): void {
    $profile = Profile::factory()->create();
    expect(method_exists($profile, 'scopeRole'))->toBeTrue();
    expect(method_exists($profile, 'scopeWithoutRole'))->toBeTrue();
});

test('profile can use extra attributes scopes', function (): void {
    $profile = Profile::factory()->create();
    expect(method_exists($profile, 'scopeWithExtraAttributes'))->toBeTrue();
});

test('profile has factory', function (): void {
    $profile = Profile::factory()->create();
    expect($profile->id)->not->toBeNull();
    expect($profile)->toBeInstanceOf(Profile::class);
});
