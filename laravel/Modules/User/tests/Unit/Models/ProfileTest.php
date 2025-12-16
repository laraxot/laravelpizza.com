<?php

declare(strict_types=1);

namespace Modules\User\Tests\Unit\Models;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Modules\User\Models\Profile;
use Tests\TestCase;

class ProfileTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_create_profile_with_minimal_data(): void
    {
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
    }

    public function test_can_create_profile_with_all_fields(): void
    {
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
        static::assertSame(['theme' => 'dark', 'notifications' => true], $profile->preferences);
        static::assertSame(['skills' => ['PHP', 'Laravel'], 'experience' => 5], $profile->extra);
    }

    public function test_profile_has_schemaless_attributes(): void
    {
        $profile = new Profile;

        $expectedAttributes = ['extra'];
        static::assertSame($expectedAttributes, $profile->getSchemalessAttributes());
    }

    public function test_profile_has_table_name(): void
    {
        $profile = new Profile;

        static::assertSame('profiles', $profile->getTable());
    }

    public function test_can_find_profile_by_email(): void
    {
        $profile = Profile::factory()->create(['email' => 'unique@example.com']);

        $foundProfile = Profile::where('email', 'unique@example.com')->first();

        static::assertNotNull($foundProfile);
        static::assertSame($profile->id, $foundProfile->id);
    }

    public function test_can_find_profile_by_user_name(): void
    {
        $profile = Profile::factory()->create(['user_name' => 'uniqueuser']);

        $foundProfile = Profile::where('user_name', 'uniqueuser')->first();

        static::assertNotNull($foundProfile);
        static::assertSame($profile->id, $foundProfile->id);
    }

    public function test_can_find_profile_by_first_name(): void
    {
        $profile = Profile::factory()->create(['first_name' => 'Unique']);

        $foundProfile = Profile::where('first_name', 'Unique')->first();

        static::assertNotNull($foundProfile);
        static::assertSame($profile->id, $foundProfile->id);
    }

    public function test_can_find_profile_by_last_name(): void
    {
        $profile = Profile::factory()->create(['last_name' => 'Unique']);

        $foundProfile = Profile::where('last_name', 'Unique')->first();

        static::assertNotNull($foundProfile);
        static::assertSame($profile->id, $foundProfile->id);
    }

    public function test_can_find_profile_by_phone(): void
    {
        $profile = Profile::factory()->create(['phone' => '+1234567890']);

        $foundProfile = Profile::where('phone', '+1234567890')->first();

        static::assertNotNull($foundProfile);
        static::assertSame($profile->id, $foundProfile->id);
    }

    public function test_can_find_profile_by_status(): void
    {
        Profile::factory()->create(['status' => 'active']);
        Profile::factory()->create(['status' => 'inactive']);
        Profile::factory()->create(['status' => 'pending']);

        $activeProfiles = Profile::where('status', 'active')->get();

        static::assertCount(1, $activeProfiles);
        static::assertSame('active', $activeProfiles->first()->status);
    }

    public function test_can_find_profile_by_timezone(): void
    {
        Profile::factory()->create(['timezone' => 'UTC']);
        Profile::factory()->create(['timezone' => 'Europe/Rome']);
        Profile::factory()->create(['timezone' => 'America/New_York']);

        $utcProfiles = Profile::where('timezone', 'UTC')->get();

        static::assertCount(1, $utcProfiles);
        static::assertSame('UTC', $utcProfiles->first()->timezone);
    }

    public function test_can_find_profile_by_locale(): void
    {
        Profile::factory()->create(['locale' => 'en']);
        Profile::factory()->create(['locale' => 'it']);
        Profile::factory()->create(['locale' => 'de']);

        $englishProfiles = Profile::where('locale', 'en')->get();

        static::assertCount(1, $englishProfiles);
        static::assertSame('en', $englishProfiles->first()->locale);
    }

    public function test_can_find_profiles_by_name_pattern(): void
    {
        Profile::factory()->create(['first_name' => 'John', 'last_name' => 'Doe']);
        Profile::factory()->create(['first_name' => 'Jane', 'last_name' => 'Doe']);
        Profile::factory()->create(['first_name' => 'Bob', 'last_name' => 'Smith']);

        $doeProfiles = Profile::where('last_name', 'like', '%Doe%')->get();

        static::assertCount(2, $doeProfiles);
        static::assertTrue($doeProfiles->every(fn ($profile) => str_contains($profile->last_name, 'Doe')));
    }

    public function test_can_find_profiles_by_bio_pattern(): void
    {
        Profile::factory()->create(['bio' => 'Software Developer']);
        Profile::factory()->create(['bio' => 'Designer']);
        Profile::factory()->create(['bio' => 'Product Manager']);

        $devProfiles = Profile::where('bio', 'like', '%Developer%')->get();

        static::assertCount(1, $devProfiles);
        static::assertTrue($devProfiles->every(fn ($profile) => str_contains($profile->bio, 'Developer')));
    }

    public function test_can_update_profile(): void
    {
        $profile = Profile::factory()->create(['first_name' => 'Old Name']);

        $profile->update(['first_name' => 'New Name']);

        $this->assertDatabaseHas('profiles', [
            'id' => $profile->id,
            'first_name' => 'New Name',
        ]);
    }

    public function test_can_handle_null_values(): void
    {
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
    }

    public function test_can_find_profiles_by_multiple_criteria(): void
    {
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

        static::assertCount(1, $profiles);
        static::assertSame('active', $profiles->first()->status);
        static::assertSame('UTC', $profiles->first()->timezone);
    }

    public function test_profile_has_roles_relationship(): void
    {
        $profile = Profile::factory()->create();

        static::assertTrue(method_exists($profile, 'roles'));
    }

    public function test_profile_has_permissions_relationship(): void
    {
        $profile = Profile::factory()->create();

        static::assertTrue(method_exists($profile, 'permissions'));
    }

    public function test_profile_has_teams_relationship(): void
    {
        $profile = Profile::factory()->create();

        static::assertTrue(method_exists($profile, 'teams'));
    }

    public function test_profile_has_devices_relationship(): void
    {
        $profile = Profile::factory()->create();

        static::assertTrue(method_exists($profile, 'devices'));
    }

    public function test_profile_has_media_relationship(): void
    {
        $profile = Profile::factory()->create();

        static::assertTrue(method_exists($profile, 'media'));
    }

    public function test_profile_can_use_permission_scopes(): void
    {
        $profile = Profile::factory()->create();

        static::assertTrue(method_exists($profile, 'permission'));
        static::assertTrue(method_exists($profile, 'withoutPermission'));
    }

    public function test_profile_can_use_role_scopes(): void
    {
        $profile = Profile::factory()->create();

        static::assertTrue(method_exists($profile, 'role'));
        static::assertTrue(method_exists($profile, 'withoutRole'));
    }

    public function test_profile_can_use_extra_attributes_scopes(): void
    {
        $profile = Profile::factory()->create();

        static::assertTrue(method_exists($profile, 'withExtraAttributes'));
    }

    public function test_profile_has_factory(): void
    {
        $profile = Profile::factory()->create();

        static::assertNotNull($profile->id);
        static::assertInstanceOf(Profile::class, $profile);
    }
}
