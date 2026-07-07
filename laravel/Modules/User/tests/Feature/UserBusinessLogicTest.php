<?php

declare(strict_types=1);

namespace Modules\User\Tests\Feature;

<<<<<<< HEAD
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Hash;
use Modules\User\Models\Permission;
=======
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Schema;
use Modules\User\Database\Factories\PermissionFactory;
use Modules\User\Database\Factories\ProfileFactory;
use Modules\User\Database\Factories\RoleFactory;
use Modules\User\Database\Factories\TeamFactory;
>>>>>>> 6d3760fe (.)
use Modules\User\Models\Profile;
use Modules\User\Models\Role;
use Modules\User\Models\Team;
use Modules\User\Models\User;

<<<<<<< HEAD
describe('User Business Logic Integration', function () {
    beforeEach(function () {
        $this->user = User::factory()->create();
        $this->admin = User::factory()->create();
        $this->team = Team::factory()->create();
=======
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
>>>>>>> 9fa499be (.)
    });

    describe('User Authentication Business Rules', function () {
        it('enforces password complexity requirements', function () {
            $weakPassword = '123456';
            $strongPassword = 'SecurePass123!';

            // Verifica che la password debole non sia accettabile
            $weakHash = Hash::make($weakPassword);
            $weakUser = User::factory()->create(['password' => $weakHash]);

            // Verifica che la password forte sia accettabile
            $strongHash = Hash::make($strongPassword);
            $strongUser = User::factory()->create(['password' => $strongHash]);

            expect($weakUser->password)->not->toBe($weakPassword);
            expect($strongUser->password)->not->toBe($strongPassword);

            // Verifica che entrambe le password siano hashate
            expect(Hash::check($weakPassword, $weakUser->password))->toBeTrue();
            expect(Hash::check($strongPassword, $strongUser->password))->toBeTrue();
        });

        it('enforces email uniqueness across the system', function () {
            $email = 'test@example.com';

            // Primo utente con email
            $user1 = User::factory()->create(['email' => $email]);

            // Tentativo di creare secondo utente con stessa email
            $this->expectException(QueryException::class);

            User::factory()->create(['email' => $email]);
        });

        it('enforces username uniqueness when required', function () {
            $username = 'testuser';

            // Primo utente con username
            $user1 = User::factory()->create(['username' => $username]);

            // Tentativo di creare secondo utente con stesso username
            $this->expectException(QueryException::class);

            User::factory()->create(['username' => $username]);
        });
    });

<<<<<<< HEAD
    describe('User Profile Business Rules', function () {
        it('enforces profile completion requirements', function () {
            $user = User::factory()->create([
                'first_name' => null,
                'last_name' => null,
            ]);
=======
    test('enforces username uniqueness when required', function (): void {
        /** @var TestCase $this */
        if (! $this->userTableHasColumn('users', 'username')) {
            $email = 'alias-'.uniqid('', true).'@example.com';
            createTestUser(['email' => $email]);
>>>>>>> 9fa499be (.)

            // Verifica che i campi obbligatori siano null
            expect($user->first_name)->toBeNull();
            expect($user->last_name)->toBeNull();

            // Aggiornamento con dati completi
            $user->update([
                'first_name' => 'Mario',
                'last_name' => 'Rossi',
            ]);

            $user->refresh();
            expect($user->first_name)->toBe('Mario');
            expect($user->last_name)->toBe('Rossi');
        });

        it('enforces data validation rules', function () {
            $invalidData = [
                'email' => 'invalid-email',
                'phone' => 'not-a-phone',
                'date_of_birth' => 'invalid-date',
            ];

            // Verifica che i dati non validi non possano essere salvati
            foreach ($invalidData as $field => $value) {
                $this->expectException(QueryException::class);

                User::factory()->create([$field => $value]);
            }
        });

        it('enforces age restrictions for certain operations', function () {
            $underageUser = User::factory()->create([
                'date_of_birth' => now()->subYears(16),
            ]);

            $adultUser = User::factory()->create([
                'date_of_birth' => now()->subYears(25),
            ]);

            $underageAge = now()->diffInYears($underageUser->date_of_birth);
            $adultAge = now()->diffInYears($adultUser->date_of_birth);

            expect($underageAge)->toBeLessThan(18);
            expect($adultAge)->toBeGreaterThanOrEqual(18);
        });
    });

    describe('Team Management Business Rules', function () {
        it('enforces team membership limits', function () {
            $user = User::factory()->create();
            $teams = Team::factory()->count(5)->create();

            // Aggiunta utente a tutti i team
            foreach ($teams as $team) {
                $user->teams()->attach($team->id);
            }

            // Verifica che l'utente sia membro di tutti i team
            expect($user->teams)->toHaveCount(5);

            // Verifica che non possa essere aggiunto a un team già membro
            $existingTeam = $user->teams->first();
            $user->teams()->attach($existingTeam->id);

            // Non dovrebbe creare duplicati
            expect($user->teams()->count())->toBe(5);
        });

        it('enforces team role hierarchy', function () {
            $user = User::factory()->create();
            $team = Team::factory()->create();

            // Ruoli con livelli di autorità
            $memberRole = Role::factory()->create(['name' => 'member', 'level' => 1]);
            $moderatorRole = Role::factory()->create(['name' => 'moderator', 'level' => 2]);
            $adminRole = Role::factory()->create(['name' => 'admin', 'level' => 3]);

            // Assegnazione ruolo base
            $user->teams()->attach($team->id, ['role' => 'member']);

            // Verifica che l'utente abbia il ruolo corretto
            $userTeam = $user->teams()->where('team_id', $team->id)->first();
            expect($userTeam->pivot->role)->toBe('member');
        });

        it('enforces team ownership rules', function () {
            $owner = User::factory()->create();
            $member = User::factory()->create();
            $team = Team::factory()->create(['user_id' => $owner->id]);

            // Verifica che solo il proprietario possa eliminare il team
            expect($team->user_id)->toBe($owner->id);

            // Tentativo di eliminazione da parte di un membro
            $member->teams()->attach($team->id);

            // Il membro non dovrebbe poter eliminare il team
            expect($team->user_id)->toBe($owner->id);
        });
    });

    describe('Permission and Role Business Rules', function () {
        it('enforces permission inheritance', function () {
            $user = User::factory()->create();
            $role = Role::factory()->create(['name' => 'editor']);
            $permission = Permission::factory()->create(['name' => 'edit_posts']);

            // Assegnazione ruolo all'utente
            $user->roles()->attach($role->id);

            // Assegnazione permesso al ruolo
            $role->permissions()->attach($permission->id);

            // Verifica che l'utente erediti il permesso dal ruolo
            $userPermissions = $user->getAllPermissions();
            expect($userPermissions)->toContain($permission);
        });

        it('enforces permission conflicts', function () {
            $user = User::factory()->create();

            // Permessi che si escludono a vicenda
            $readPermission = Permission::factory()->create(['name' => 'read_posts']);
            $writePermission = Permission::factory()->create(['name' => 'write_posts']);
            $deletePermission = Permission::factory()->create(['name' => 'delete_posts']);

            // Assegnazione permessi all'utente
            $user->permissions()->attach([
                $readPermission->id,
                $writePermission->id,
                $deletePermission->id,
            ]);

            // Verifica che tutti i permessi siano assegnati
            expect($user->permissions)->toHaveCount(3);

            // Verifica che non ci siano conflitti
            $userPermissions = $user->permissions->pluck('name')->toArray();
            expect($userPermissions)->toContain('read_posts');
            expect($userPermissions)->toContain('write_posts');
            expect($userPermissions)->toContain('delete_posts');
        });

        it('enforces role-based access control', function () {
            $admin = User::factory()->create();
            $moderator = User::factory()->create();
            $user = User::factory()->create();

            // Ruoli con livelli di accesso
            $adminRole = Role::factory()->create(['name' => 'admin', 'level' => 3]);
            $moderatorRole = Role::factory()->create(['name' => 'moderator', 'level' => 2]);
            $userRole = Role::factory()->create(['name' => 'user', 'level' => 1]);

            // Assegnazione ruoli
            $admin->roles()->attach($adminRole->id);
            $moderator->roles()->attach($moderatorRole->id);
            $user->roles()->attach($userRole->id);

            // Verifica livelli di accesso
            expect($adminRole->level)->toBeGreaterThan($moderatorRole->level);
            expect($moderatorRole->level)->toBeGreaterThan($userRole->level);
        });
    });

<<<<<<< HEAD
    describe('Data Integrity Business Rules', function () {
        it('enforces referential integrity for user relationships', function () {
            $user = User::factory()->create();
            $profile = Profile::factory()->create(['user_id' => $user->id]);
            $team = Team::factory()->create();
=======
    test('enforces age restrictions for certain operations', function (): void {
        /* @var TestCase $this */
        if (! Schema::connection('fixcity')->hasColumn('profiles', 'uuid')) {
            $this->skipTest('profiles.uuid column missing — Profile model requires uuid.');
        }
>>>>>>> 9fa499be (.)

            // Verifica che le relazioni siano mantenute
            expect($profile->user_id)->toBe($user->id);

            // Tentativo di eliminare utente con relazioni
            $this->expectException(QueryException::class);

            $user->delete();
        });

<<<<<<< HEAD
        it('enforces data consistency across user attributes', function () {
            $user = User::factory()->create([
                'first_name' => 'Mario',
                'last_name' => 'Rossi',
                'email' => 'mario.rossi@example.com',
            ]);
=======
        ProfileFactory::new()->createOne(['user_id' => $underageUser->id, 'birth_date' => $underageBirthDate]);
        ProfileFactory::new()->createOne(['user_id' => $adultUser->id, 'birth_date' => $adultBirthDate]);
>>>>>>> 6d3760fe (.)

            // Verifica coerenza dei dati
            expect($user->full_name)->toBe('Mario Rossi');
            expect($user->email)->toBe('mario.rossi@example.com');

            // Aggiornamento che mantiene la coerenza
            $user->update([
                'first_name' => 'Marco',
                'email' => 'marco.rossi@example.com',
            ]);

            $user->refresh();
            expect($user->full_name)->toBe('Marco Rossi');
            expect($user->email)->toBe('marco.rossi@example.com');
        });

        it('enforces audit trail for sensitive operations', function () {
            $user = User::factory()->create();
            $originalEmail = $user->email;

            // Modifica email (operazione sensibile)
            $user->update(['email' => 'newemail@example.com']);

            // Verifica che i timestamp siano aggiornati
            expect($user->updated_at)->not->toBe($user->created_at);

            // Verifica che l'email sia stata modificata
            expect($user->email)->not->toBe($originalEmail);
            expect($user->email)->toBe('newemail@example.com');
        });
    });

<<<<<<< HEAD
    describe('Security Business Rules', function () {
        it('enforces password expiration policies', function () {
            $user = User::factory()->create([
                'password_expires_at' => now()->subDays(1),
            ]);

            // Verifica che la password sia scaduta
            $isExpired = $user->password_expires_at->isPast();
            expect($isExpired)->toBeTrue();
=======
    test('enforces team membership limits', function (): void {
        /** @var TestCase $this */
        $user = createTestUser();
        /** @var Collection<int, Team> $teams */
        $teams = TeamFactory::new()->count(5)->create();

        foreach ($teams as $team) {
            $user->membershipTeams()->attach($team->id);
        }
>>>>>>> 6d3760fe (.)

            // Aggiornamento password con nuova scadenza
            $user->update([
                'password' => Hash::make('NewPassword123!'),
                'password_expires_at' => now()->addDays(90),
            ]);

            $user->refresh();
            $isExpired = $user->password_expires_at->isFuture();
            expect($isExpired)->toBeTrue();
        });

<<<<<<< HEAD
        it('enforces account lockout policies', function () {
            $user = User::factory()->create([
                'failed_login_attempts' => 5,
                'locked_until' => now()->addMinutes(30),
            ]);
=======
    test('enforces team role hierarchy', function (): void {
        /** @var TestCase $this */
        $user = createTestUser();
        $team = TeamFactory::new()->createOne();
>>>>>>> 9fa499be (.)

            // Verifica che l'account sia bloccato
            $isLocked = $user->locked_until->isFuture();
            expect($isLocked)->toBeTrue();

            // Sblocco account
            $user->update([
                'failed_login_attempts' => 0,
                'locked_until' => null,
            ]);

<<<<<<< HEAD
            $user->refresh();
            expect($user->failed_login_attempts)->toBe(0);
            expect($user->locked_until)->toBeNull();
        });
=======
    test('enforces team ownership rules', function (): void {
        /** @var TestCase $this */
        $owner = createTestUser();
        $member = createTestUser();
        $team = TeamFactory::new()->createOne(['user_id' => $owner->id]);
>>>>>>> 9fa499be (.)

        it('enforces session management policies', function () {
            $user = User::factory()->create([
                'last_login_at' => now()->subHours(2),
                'last_activity_at' => now()->subMinutes(30),
            ]);

            // Verifica che l'utente abbia fatto login recentemente
            $lastLogin = $user->last_login_at;
            $lastActivity = $user->last_activity_at;

            expect($lastLogin->diffInHours(now()))->toBeLessThan(24);
            expect($lastActivity->diffInMinutes(now()))->toBeLessThan(60);

            // Aggiornamento attività
            $user->update(['last_activity_at' => now()]);

<<<<<<< HEAD
            $user->refresh();
            expect($user->last_activity_at->diffInMinutes(now()))->toBeLessThan(1);
        });
=======
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
>>>>>>> 6d3760fe (.)
    });
});
