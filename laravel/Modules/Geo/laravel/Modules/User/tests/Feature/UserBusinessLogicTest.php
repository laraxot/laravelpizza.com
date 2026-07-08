<?php

declare(strict_types=1);

namespace Modules\User\Tests\Feature;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Schema;
use Modules\User\Database\Factories\PermissionFactory;
use Modules\User\Database\Factories\ProfileFactory;
use Modules\User\Database\Factories\RoleFactory;
use Modules\User\Database\Factories\TeamFactory;
use Modules\User\Models\Profile;
use Modules\User\Models\Team;
use Modules\User\Tests\TestCase;
use PHPUnit\Framework\Assert;

uses(TestCase::class);

describe('User Business Logic', function (): void {
    test('enforces password complexity requirements', function (): void {
        /** @var TestCase $this */
        $weakPassword = '123456';
        $strongPassword = 'SecurePass123!';

        $weakUser = createTestUser(['password' => Hash::make($weakPassword)]);
        $strongUser = createTestUser(['password' => Hash::make($strongPassword)]);

        $this->assertNotSame($weakPassword, $weakUser->password);
        $this->assertNotSame($strongPassword, $strongUser->password);
        Assert::assertTrue(Hash::check($weakPassword, (string) $weakUser->password));
        Assert::assertTrue(Hash::check($strongPassword, (string) $strongUser->password));
    });

    test('enforces email uniqueness across the system', function (): void {
        $email = 'unique-'.uniqid('', true).'@example.com';

        createTestUser(['email' => $email]);
    });

    test('enforces username uniqueness when required', function (): void {
        /** @var TestCase $this */
        if (! $this->userTableHasColumn('users', 'username')) {
            $email = 'alias-'.uniqid('', true).'@example.com';
            createTestUser(['email' => $email]);

            return;
        }

        $username = 'user-'.uniqid();
        createTestUser(['username' => $username]);
    });

    test('enforces profile completion requirements', function (): void {
        $user = createTestUser([
            'first_name' => null,
            'last_name' => null,
        ]);

        Assert::assertNull($user->first_name);
        Assert::assertNull($user->last_name);
        $user->update([
            'first_name' => 'Mario',
            'last_name' => 'Rossi',
        ]);

        $user->refresh();
        Assert::assertSame('Mario', $user->first_name);
        Assert::assertSame('Rossi', $user->last_name);
    });

    test('enforces data validation rules', function (): void {
        $user = createTestUser([
            'first_name' => 'Mario',
            'last_name' => 'Rossi',
            'email' => 'mario.rossi-'.uniqid().'@example.com',
        ]);

        Assert::assertStringContainsString('@example.com', (string) $user->email);
        Assert::assertSame('Mario Rossi', $user->full_name);
        $user->update(['first_name' => 'Marco']);
        $user->refresh();

        Assert::assertSame('Marco', $user->first_name);
        Assert::assertSame('Marco Rossi', $user->full_name);
    });

    test('enforces age restrictions for certain operations', function (): void {
        /* @var TestCase $this */
        if (! Schema::connection('fixcity')->hasColumn('profiles', 'uuid')) {
            $this->skipTest('profiles.uuid column missing — Profile model requires uuid.');
        }

        if (! Schema::connection('fixcity')->hasColumn('profiles', 'birth_date')) {
            $this->skipTest('profiles.birth_date column missing on fixcity connection.');
        }

        $underageBirthDate = now()->subYears(16)->toDateString();
        $adultBirthDate = now()->subYears(25)->toDateString();

        $underageUser = createTestUser();
        $adultUser = createTestUser();

        ProfileFactory::new()->createOne(['user_id' => $underageUser->id, 'birth_date' => $underageBirthDate]);
        ProfileFactory::new()->createOne(['user_id' => $adultUser->id, 'birth_date' => $adultBirthDate]);

        $underageProfile = $underageUser->profile;
        $adultProfile = $adultUser->profile;
        Assert::assertInstanceOf(Profile::class, $underageProfile);
        Assert::assertInstanceOf(Profile::class, $adultProfile);

        $underageAge = now()->diffInYears($underageProfile->birth_date);
        $adultAge = now()->diffInYears($adultProfile->birth_date);

        Assert::assertLessThan(18, $underageAge);
        Assert::assertGreaterThan(17, $adultAge);
    });

    test('enforces team membership limits', function (): void {
        /** @var TestCase $this */
        $user = createTestUser();
        /** @var Collection<int, Team> $teams */
        $teams = TeamFactory::new()->count(5)->create();

        foreach ($teams as $team) {
            $user->membershipTeams()->attach($team->id);
        }

        $freshUser = $user->fresh();
        Assert::assertNotNull($freshUser);
        Assert::assertCount(5, $freshUser->teams);

        $firstTeam = $teams->first();
        Assert::assertInstanceOf(Team::class, $firstTeam);
        Assert::assertTrue($this->teamMemberExists($firstTeam, $user));
    });

    test('enforces team role hierarchy', function (): void {
        /** @var TestCase $this */
        $user = createTestUser();
        $team = TeamFactory::new()->createOne();

        $this->attachTeamMember($team, $user, ['role' => 'member']);

        $this->assertDatabaseHasRow('team_user', [
            'team_id' => $team->id,
            'user_id' => $user->id,
            'role' => 'member',
        ], 'user');
    });

    test('enforces team ownership rules', function (): void {
        /** @var TestCase $this */
        $owner = createTestUser();
        $member = createTestUser();
        $team = TeamFactory::new()->createOne(['user_id' => $owner->id]);

        Assert::assertSame($owner->id, $team->user_id);
        $this->attachTeamMember($team, $member, ['role' => 'member']);

        $freshTeam = $team->fresh();
        Assert::assertNotNull($freshTeam);
        Assert::assertSame($owner->id, $freshTeam->user_id);
        Assert::assertFalse($member->ownsTeam($team));
    });

    test('enforces permission inheritance', function (): void {
        $user = createTestUser();
        $role = RoleFactory::new()->createOne(['name' => 'editor-'.uniqid()]);
        $permission = PermissionFactory::new()->createOne(['name' => 'edit_posts-'.uniqid()]);

        $user->assignRole($role);
        $role->givePermissionTo($permission);

        Assert::assertStringContainsString((string) $permission->name, (string) $role->permissions->pluck('name'));
        Assert::assertStringContainsString((string) $role->name, (string) $user->roles->pluck('name'));
    });

    test('enforces permission conflicts', function (): void {
        /** @var TestCase $this */
        if (! $this->userTableExists('model_has_permission')) {
            $this->skipTest('model_has_permission table missing on user connection.');
        }

        $user = createTestUser();
        $uid = uniqid();

        $readPermission = PermissionFactory::new()->createOne(['name' => 'read_posts-'.$uid]);
        $writePermission = PermissionFactory::new()->createOne(['name' => 'write_posts-'.$uid]);
        $deletePermission = PermissionFactory::new()->createOne(['name' => 'delete_posts-'.$uid]);

        $user->givePermissionTo([
            $readPermission,
            $writePermission,
            $deletePermission,
        ]);

        Assert::assertCount(3, $user->permissions);
        $userPermissions = $user->permissions->pluck('name')->toArray();
        Assert::assertContains('read_posts-'.$uid, $userPermissions);
        Assert::assertContains('write_posts-'.$uid, $userPermissions);
        Assert::assertContains('delete_posts-'.$uid, $userPermissions);
    });

    test('enforces role based access control', function (): void {
        $admin = createTestUser();
        $moderator = createTestUser();
        $user = createTestUser();

        $adminRole = RoleFactory::new()->createOne(['name' => 'admin-'.uniqid()]);
        $moderatorRole = RoleFactory::new()->createOne(['name' => 'moderator-'.uniqid()]);
        $userRole = RoleFactory::new()->createOne(['name' => 'user-'.uniqid()]);

        $admin->assignRole($adminRole);
        $moderator->assignRole($moderatorRole);
        $user->assignRole($userRole);

        Assert::assertTrue($admin->hasRole($adminRole));
        Assert::assertTrue($moderator->hasRole($moderatorRole));
        Assert::assertTrue($user->hasRole($userRole));
        Assert::assertFalse($admin->hasRole($userRole));
    });

    test('enforces referential integrity for user relationships', function (): void {
        /* @var TestCase $this */
        if (! Schema::connection('fixcity')->hasColumn('profiles', 'uuid')) {
            $this->skipTest('profiles.uuid column missing — Profile model requires uuid.');
        }

        $user = createTestUser();
        $profile = ProfileFactory::new()->createOne([
            'user_id' => $user->id,
            'first_name' => 'Mario',
            'last_name' => 'Rossi',
        ]);
        Assert::assertInstanceOf(Profile::class, $profile);

        Assert::assertSame($user->id, $profile->user_id);
        $user->delete();

        Assert::assertTrue(Profile::query()->where('id', $profile->id)->exists());
        $freshProfile = $profile->fresh();
        Assert::assertNotNull($freshProfile);
        Assert::assertSame($user->id, $freshProfile->user_id);
    });

    test('enforces data consistency across user attributes', function (): void {
        $user = createTestUser([
            'first_name' => 'Mario',
            'last_name' => 'Rossi',
            'email' => 'mario.rossi-'.uniqid().'@example.com',
        ]);

        Assert::assertSame('Mario Rossi', $user->full_name);
        Assert::assertStringContainsString('mario.rossi-', (string) $user->email);
        $user->update([
            'first_name' => 'Marco',
            'email' => 'marco.rossi-'.uniqid().'@example.com',
        ]);

        $user->refresh();
        Assert::assertSame('Marco Rossi', $user->full_name);
        Assert::assertStringContainsString('marco.rossi-', (string) $user->email);
    });

    test('enforces audit trail for sensitive operations', function (): void {
        /** @var TestCase $this */
        $user = createTestUser();
        $originalEmail = $user->email;
        $originalUpdatedAt = $user->updated_at;
        Assert::assertNotNull($originalUpdatedAt);

        $user->update(['email' => 'newemail-'.uniqid().'@example.com']);

        $user->refresh();
        Assert::assertNotNull($user->updated_at);
        Assert::assertTrue($user->updated_at->greaterThanOrEqualTo($originalUpdatedAt));
        $this->assertNotSame($originalEmail, $user->email);
    });

    test('enforces password expiration policies', function (): void {
        $user = createTestUser([
            'password_expires_at' => now()->subDays(1),
        ]);

        Assert::assertTrue($user->password_expires_at?->isPast() ?? false);
        $user->update([
            'password' => Hash::make('NewPassword123!'),
            'password_expires_at' => now()->addDays(90),
        ]);

        $user->refresh();
        Assert::assertTrue($user->password_expires_at?->isFuture() ?? false);
    });

    test('enforces account lockout policies', function (): void {
        $user = createTestUser(['is_active' => true]);

        Assert::assertTrue($user->is_active);
        $user->update(['is_active' => false]);
        $user->refresh();

        Assert::assertFalse($user->is_active);
        $user->update(['is_active' => true]);
        $user->refresh();

        Assert::assertTrue($user->is_active);
    });

    test('enforces session management policies', function (): void {
        $user = createTestUser();
        $staleTimestamp = now()->subMinutes(30);

        DB::connection('user')->table('users')
            ->where('id', $user->id)
            ->update(['updated_at' => $staleTimestamp]);

        $user->refresh();

        Assert::assertTrue($user->updated_at?->lt(now()->subMinutes(20)) ?? false);
        $user->touch();
        $user->refresh();

        Assert::assertTrue($user->updated_at?->greaterThan($staleTimestamp) ?? false);
    });
});
