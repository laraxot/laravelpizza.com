<?php

declare(strict_types=1);

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Modules\User\Models\Profile;
use PHPUnit\Framework\Assert;

uses(Modules\User\Tests\TestCase::class);

/**
 * @param array<string, mixed> $attributes
 */
function modelsProfileCreate(array $attributes = []): Profile
{
    $payload = array_merge([
        'id' => (string) Str::uuid(),
        'email' => 'profile-'.uniqid('', true).'@example.com',
        'user_name' => 'user-'.uniqid(),
        'first_name' => 'Test',
        'last_name' => 'User',
        'status' => 'active',
    ], $attributes);

    /** @var Profile $created */
    $created = Profile::withoutEvents(static function () use ($payload): Profile {
        $profile = new Profile();
        $profile->forceFill($payload);
        $profile->save();

        $reloaded = $profile->fresh();

        return $reloaded instanceof Profile ? $reloaded : $profile;
    });

    return $created;
}

/**
 * @param array<string, mixed> $where
 */
function modelsProfileAssertInDatabase(array $where): void
{
    $query = DB::connection('user')->table('profiles');
    foreach ($where as $column => $value) {
        $query->where($column, $value);
    }

    Assert::assertTrue($query->exists());
}

test('can create profile with minimal data', function (): void {
    $profile = modelsProfileCreate([
        'first_name' => 'John',
        'last_name' => 'Doe',
        'user_name' => 'johndoe-'.uniqid(),
        'email' => 'john-'.uniqid().'@example.com',
    ]);

    modelsProfileAssertInDatabase([
        'email' => $profile->email,
        'first_name' => 'John',
        'last_name' => 'Doe',
    ]);
});

test('can create profile with all fields', function (): void {
    $email = 'jane-'.uniqid().'@example.com';
    $profile = modelsProfileCreate([
        'first_name' => 'Jane',
        'last_name' => 'Smith',
        'user_name' => 'janesmith-'.uniqid(),
        'email' => $email,
        'phone' => '+1234567890',
        'bio' => 'Software Developer',
        'avatar' => 'avatar.jpg',
        'timezone' => 'UTC',
        'locale' => 'en',
        'preferences' => ['theme' => 'dark', 'notifications' => true],
        'status' => 'active',
        'extra' => ['skills' => ['PHP', 'Laravel'], 'experience' => 5],
    ]);

    modelsProfileAssertInDatabase([
        'email' => $email,
        'first_name' => 'Jane',
        'last_name' => 'Smith',
        'status' => 'active',
    ]);

    Assert::assertSame(['theme' => 'dark', 'notifications' => true], $profile->preferences);
    Assert::assertSame(['skills' => ['PHP', 'Laravel'], 'experience' => 5], $profile->extra->toArray());
});

test('profile has schemaless attributes', function (): void {
    Assert::assertSame(['extra'], (new Profile())->getSchemalessAttributes());
});

test('profile has table name', function (): void {
    Assert::assertSame('profiles', (new Profile())->getTable());
});

test('can find profile by email', function (): void {
    $email = 'unique-'.uniqid().'@example.com';
    $profile = modelsProfileCreate(['email' => $email]);
    $foundProfile = Profile::where('email', $email)->first();

    Assert::assertInstanceOf(Profile::class, $foundProfile);
    Assert::assertSame($profile->email, $foundProfile->email);
});

test('can find profile by user name', function (): void {
    $userName = 'uniqueuser-'.uniqid();
    $profile = modelsProfileCreate(['user_name' => $userName]);
    $foundProfile = Profile::where('user_name', $userName)->first();

    Assert::assertInstanceOf(Profile::class, $foundProfile);
    Assert::assertSame($profile->user_name, $foundProfile->user_name);
});

test('can find profile by first name', function (): void {
    $firstName = 'Unique-'.uniqid();
    $profile = modelsProfileCreate(['first_name' => $firstName]);
    $foundProfile = Profile::where('first_name', $firstName)->first();

    Assert::assertInstanceOf(Profile::class, $foundProfile);
    Assert::assertSame($profile->first_name, $foundProfile->first_name);
});

test('can find profile by last name', function (): void {
    $lastName = 'Unique-'.uniqid();
    $profile = modelsProfileCreate(['last_name' => $lastName]);
    $foundProfile = Profile::where('last_name', $lastName)->first();

    Assert::assertInstanceOf(Profile::class, $foundProfile);
    Assert::assertSame($profile->last_name, $foundProfile->last_name);
});

test('can find profile by phone', function (): void {
    $phone = '+1234567890-'.uniqid();
    $profile = modelsProfileCreate(['phone' => $phone]);
    $foundProfile = Profile::where('phone', $phone)->first();

    Assert::assertInstanceOf(Profile::class, $foundProfile);
    Assert::assertSame($profile->phone, $foundProfile->phone);
});

test('can find profile by status', function (): void {
    $marker = uniqid();
    modelsProfileCreate(['status' => "active-{$marker}"]);
    modelsProfileCreate(['status' => "inactive-{$marker}"]);

    $activeProfiles = Profile::where('status', "active-{$marker}")->get();

    Assert::assertCount(1, $activeProfiles);
    $first = $activeProfiles->first();
    Assert::assertInstanceOf(Profile::class, $first);
    Assert::assertSame("active-{$marker}", $first->status);
});

test('can find profile by timezone', function (): void {
    $marker = uniqid();
    modelsProfileCreate(['timezone' => "UTC-{$marker}"]);
    modelsProfileCreate(['timezone' => "Europe/Rome-{$marker}"]);

    $utcProfiles = Profile::where('timezone', "UTC-{$marker}")->get();

    Assert::assertCount(1, $utcProfiles);
    $first = $utcProfiles->first();
    Assert::assertInstanceOf(Profile::class, $first);
    Assert::assertSame("UTC-{$marker}", $first->timezone);
});

test('can find profile by locale', function (): void {
    $marker = uniqid();
    modelsProfileCreate(['locale' => "en-{$marker}"]);
    modelsProfileCreate(['locale' => "it-{$marker}"]);

    $englishProfiles = Profile::where('locale', "en-{$marker}")->get();

    Assert::assertCount(1, $englishProfiles);
    $first = $englishProfiles->first();
    Assert::assertInstanceOf(Profile::class, $first);
    Assert::assertSame("en-{$marker}", $first->locale);
});

test('can find profiles by name pattern', function (): void {
    $marker = uniqid();
    modelsProfileCreate(['first_name' => 'John', 'last_name' => "Doe-{$marker}"]);
    modelsProfileCreate(['first_name' => 'Jane', 'last_name' => "Doe-{$marker}"]);
    modelsProfileCreate(['first_name' => 'Bob', 'last_name' => "Smith-{$marker}"]);

    $doeProfiles = Profile::where('last_name', 'like', "%Doe-{$marker}%")->get();

    Assert::assertCount(2, $doeProfiles);
    foreach ($doeProfiles as $doeProfile) {
        Assert::assertStringContainsString("Doe-{$marker}", (string) $doeProfile->last_name);
    }
});

test('can find profiles by bio pattern', function (): void {
    $marker = uniqid();
    modelsProfileCreate(['bio' => "Software Developer {$marker}"]);
    modelsProfileCreate(['bio' => "Designer {$marker}"]);

    $devProfiles = Profile::where('bio', 'like', "%Developer {$marker}%")->get();

    Assert::assertCount(1, $devProfiles);
    $first = $devProfiles->first();
    Assert::assertInstanceOf(Profile::class, $first);
    Assert::assertStringContainsString('Developer', (string) $first->bio);
});

test('can update profile', function (): void {
    $email = 'update-'.uniqid('', true).'@example.com';
    $profile = modelsProfileCreate(['email' => $email, 'first_name' => 'Old Name']);
    Profile::query()->where('email', $email)->update(['first_name' => 'New Name']);

    modelsProfileAssertInDatabase(['email' => $email, 'first_name' => 'New Name']);
});

test('can handle null values', function (): void {
    $profile = modelsProfileCreate([
        'first_name' => 'Test',
        'last_name' => 'User',
        'phone' => null,
        'bio' => null,
        'avatar' => null,
        'timezone' => null,
        'locale' => null,
    ]);

    Assert::assertNull($profile->phone);
    Assert::assertNull($profile->bio);
    Assert::assertNull($profile->getAttributes()['avatar'] ?? null);
    Assert::assertNull($profile->timezone);
    Assert::assertNull($profile->locale);
});

test('can find profiles by multiple criteria', function (): void {
    $marker = uniqid();
    modelsProfileCreate([
        'status' => "active-{$marker}",
        'timezone' => "UTC-{$marker}",
        'locale' => "en-{$marker}",
    ]);

    modelsProfileCreate([
        'status' => "active-{$marker}",
        'timezone' => "Europe/Rome-{$marker}",
        'locale' => "it-{$marker}",
    ]);

    $profiles = Profile::where('status', "active-{$marker}")
        ->where('timezone', "UTC-{$marker}")
        ->get();

    Assert::assertCount(1, $profiles);
    $first = $profiles->first();
    Assert::assertInstanceOf(Profile::class, $first);
    Assert::assertSame("active-{$marker}", $first->status);
    Assert::assertSame("UTC-{$marker}", $first->timezone);
});

test('profile has factory', function (): void {
    $profile = modelsProfileCreate();
    Assert::assertNotEmpty($profile->email);
    Assert::assertInstanceOf(Profile::class, $profile);
});
