<?php

declare(strict_types=1);

namespace Modules\User\Tests\Feature\Authentication;

use Illuminate\Auth\Notifications\VerifyEmail;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
<<<<<<< HEAD
=======
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Str;
use Modules\User\Database\Factories\PermissionFactory;
use Modules\User\Database\Factories\RoleFactory;
use Modules\User\Database\Factories\UserFactory;
<<<<<<< HEAD
>>>>>>> 6d3760fe (.)
use Modules\User\Models\Permission;
use Modules\User\Models\Role;
=======
>>>>>>> 9fa499be (.)
use Modules\User\Models\User;
use Modules\User\Tests\TestCase;
use Modules\User\Tests\Traits\HasUserTestCase;

<<<<<<< HEAD
<<<<<<< HEAD
uses(TestCase::class, HasUserTestCase::class);

beforeEach(function () {
    $user = User::factory()->create([
=======
uses(\Modules\User\Tests\TestCase::class, HasUserTestCase::class);

/**
 * @param array<string, bool|string|\DateTimeInterface|null> $attributes
 */
function createUser(array $attributes = []): User
{
    return UserFactory::new()->createOne($attributes);
}

/**
 * @param array<string, bool|string|\DateTimeInterface|null> $attributes
 */
function createRole(array $attributes = []): Role
{
    return RoleFactory::new()->createOne($attributes);
}

/**
 * @param array<string, bool|string|\DateTimeInterface|null> $attributes
 */
function createPermission(array $attributes = []): Permission
{
    return PermissionFactory::new()->createOne($attributes);
}

function userUnderTest(TestCase $testCase): User
{
    $user = $testCase->user;

    if (! $user instanceof User) {
        throw new \RuntimeException('Expected authenticated test user.');
    }

    return $user;
}

function freshUser(User $user): User
{
    $freshUser = $user->fresh();

    if (! $freshUser instanceof User) {
        throw new \RuntimeException('Expected fresh user model.');
    }

    return $freshUser;
}

beforeEach(function (): void {
    $user = createUser([
>>>>>>> 6d3760fe (.)
=======
uses(TestCase::class, HasUserTestCase::class);

beforeEach(function () {
    $user = UserFactory::new()->create([
>>>>>>> 9fa499be (.)
        'password' => Hash::make('password123'),
        'is_active' => true,
        'email_verified_at' => now(),
    ]);
<<<<<<< HEAD
<<<<<<< HEAD
    \assert($user instanceof User);
    \assert($user instanceof User);
    $this->user = $user;
});

describe('User Authentication', function () {
    it('can authenticate with valid credentials', function () {
        $result = Auth::attempt([
            'email' => $this->user->email,
=======
=======
    \assert($user instanceof User);
>>>>>>> 9fa499be (.)
    $this->user = $user;
});

describe('User Authentication', function () {
    it('can authenticate with valid credentials', function () {
        $result = Auth::attempt([
<<<<<<< HEAD
            'email' => userUnderTest($this)->email,
>>>>>>> 6d3760fe (.)
=======
            'email' => $this->requireUser()->email,
>>>>>>> 9fa499be (.)
            'password' => 'password123',
        ]);

        expect($result)->toBe(true);
<<<<<<< HEAD
<<<<<<< HEAD
        expect(Auth::user()?->id)->toBe($this->user->id);
    });

    it('cannot authenticate with invalid password', function () {
        $result = Auth::attempt([
            'email' => $this->user->email,
=======
        expect(Auth::user()?->id)->toBe(userUnderTest($this)->id);
=======
        expect(Auth::user()?->id)->toBe($this->requireUser()->id);
>>>>>>> 9fa499be (.)
    });

    it('cannot authenticate with invalid password', function () {
        $result = Auth::attempt([
<<<<<<< HEAD
            'email' => userUnderTest($this)->email,
>>>>>>> 6d3760fe (.)
=======
            'email' => $this->requireUser()->email,
>>>>>>> 9fa499be (.)
            'password' => 'wrongpassword',
        ]);

        expect($result)->toBe(false);
        expect(Auth::user())->toBeNull();
    });

<<<<<<< HEAD
<<<<<<< HEAD
    it('cannot authenticate with non-existent email', function () {
=======
    it('cannot authenticate with non-existent email', function (): void {
>>>>>>> 6d3760fe (.)
=======
    it('cannot authenticate with non-existent email', function () {
>>>>>>> 9fa499be (.)
        $result = Auth::attempt([
            'email' => 'nonexistent@example.com',
            'password' => 'password123',
        ]);

        expect($result)->toBe(false);
        expect(Auth::user())->toBeNull();
    });

<<<<<<< HEAD
<<<<<<< HEAD
    it('cannot authenticate inactive user', function () {
        /** @var User $inactiveUser */
        /** @var User $inactiveUser */
        $inactiveUser = User::factory()->create([
=======
    it('cannot authenticate inactive user', function (): void {
        /** @var User $inactiveUser */
        /** @var User $inactiveUser */
        $inactiveUser = createUser([
>>>>>>> 6d3760fe (.)
=======
    it('cannot authenticate inactive user', function () {
        /** @var User $inactiveUser */
        /** @var User $inactiveUser */
        $inactiveUser = UserFactory::new()->create([
>>>>>>> 9fa499be (.)
            'password' => Hash::make('password123'),
            'is_active' => false,
        ]);
        \assert($inactiveUser instanceof User);

        $result = Auth::attempt([
            'email' => $inactiveUser->email,
            'password' => 'password123',
            'is_active' => true,
        ]);

        expect($result)->toBe(false);
    });

<<<<<<< HEAD
<<<<<<< HEAD
    it('can logout user', function () {
        Auth::login($this->user);
=======
    it('can logout user', function (): void {
        Auth::login(userUnderTest($this));
>>>>>>> 6d3760fe (.)
=======
    it('can logout user', function () {
        Auth::login($this->requireUser());
>>>>>>> 9fa499be (.)
        expect(Auth::check())->toBe(true);

        Auth::logout();
        expect(Auth::check())->toBe(false);
    });
});

<<<<<<< HEAD
<<<<<<< HEAD
describe('User Password Management', function () {
    it('can hash password on creation', function () {
        /** @var User $user */
        /** @var User $user */
        $user = User::factory()->create([
=======
describe('User Password Management', function (): void {
    it('can hash password on creation', function (): void {
        /** @var User $user */
        /** @var User $user */
        $user = createUser([
>>>>>>> 6d3760fe (.)
=======
describe('User Password Management', function () {
    it('can hash password on creation', function () {
        /** @var User $user */
        /** @var User $user */
        $user = UserFactory::new()->create([
>>>>>>> 9fa499be (.)
            'password' => Hash::make('testpassword'),
        ]);
        \assert($user instanceof User);

        expect(Hash::check('testpassword', $user->password))->toBe(true);
    });

<<<<<<< HEAD
<<<<<<< HEAD
    it('can change password', function () {
        $newPassword = 'newpassword123';
        $this->user->update([
            'password' => Hash::make($newPassword),
        ]);

        expect(Hash::check($newPassword, $this->user->fresh()->password))->toBe(true);
        expect(Hash::check('password123', $this->user->fresh()->password))->toBe(false);
    });

    it('can check password expiration', function () {
        /** @var User $user */
        /** @var User $user */
        $user = User::factory()->create([
            'password_expires_at' => now()->subDays(1),
        ]);
        \assert($user instanceof User);

        expect($user->password_expires_at->isPast())->toBe(true);
    });

    it('can set password expiration', function () {
        $expirationDate = now()->addDays(90);
        $this->user->update([
=======
    it('can change password', function (): void {
=======
    it('can change password', function () {
>>>>>>> 9fa499be (.)
        $newPassword = 'newpassword123';
        $this->requireUser()->update([
            'password' => Hash::make($newPassword),
        ]);

        expect(Hash::check($newPassword, $this->requireFreshUser($this->requireUser())->password))->toBe(true);
        expect(Hash::check('password123', $this->requireFreshUser($this->requireUser())->password))->toBe(false);
    });

    it('can check password expiration', function () {
        /** @var User $user */
        $user = UserFactory::new()->create([
            'password_expires_at' => now()->subDays(1),
        ]);
        \assert($user instanceof User);
        $passwordExpiresAt = $user->password_expires_at;
        \assert(null !== $passwordExpiresAt);

        expect($passwordExpiresAt->isPast())->toBe(true);
    });

    it('can set password expiration', function () {
        $expirationDate = now()->addDays(90);
<<<<<<< HEAD
        userUnderTest($this)->update([
>>>>>>> 6d3760fe (.)
            'password_expires_at' => $expirationDate,
        ]);

        expect(
<<<<<<< HEAD
            $this
                ->user->fresh()
                ->password_expires_at->toDateString(),
=======
            freshUser(userUnderTest($this))->password_expires_at?->toDateString(),
>>>>>>> 6d3760fe (.)
        )
=======
        $this->requireUser()->update([
            'password_expires_at' => $expirationDate,
        ]);

        $passwordExpiresAt = $this->requireFreshUser($this->requireUser())->password_expires_at;
        \assert(null !== $passwordExpiresAt);

        expect($passwordExpiresAt->toDateString())
>>>>>>> 9fa499be (.)
            ->toBe($expirationDate->toDateString());
    });
});

<<<<<<< HEAD
<<<<<<< HEAD
describe('User Remember Token', function () {
    it('can generate remember token', function () {
        $token = Str::random(60);
        $this->user->forceFill(['remember_token' => $token])->save();

        expect($this->user->fresh()->remember_token)->toBe($token);
    });

    it('can authenticate using remember token', function () {
        $token = Str::random(60);
        $this->user->forceFill(['remember_token' => $token])->save();

        $user = User::where('email', $this->user->email)->where('remember_token', $token)->first();

        expect($user)->not->toBeNull();
        expect($user->id)->toBe($this->user->id);
    });
});

describe('User Email Verification', function () {
    it('can mark email as verified', function () {
        /** @var User $user */
        $user = User::factory()->create([
=======
describe('User Remember Token', function (): void {
    it('can generate remember token', function (): void {
=======
describe('User Remember Token', function () {
    it('can generate remember token', function () {
>>>>>>> 9fa499be (.)
        $token = Str::random(60);
        $this->requireUser()->forceFill(['remember_token' => $token])->save();

        expect($this->requireFreshUser($this->requireUser())->remember_token)->toBe($token);
    });

    it('can authenticate using remember token', function () {
        $token = Str::random(60);
        $this->requireUser()->forceFill(['remember_token' => $token])->save();

        $user = User::where('email', $this->requireUser()->email)->where('remember_token', $token)->first();

        expect($user)->not->toBeNull();
        \assert($user instanceof User);
        expect($user->id)->toBe($this->requireUser()->id);
    });
});

describe('User Email Verification', function () {
    it('can mark email as verified', function () {
        /** @var User $user */
<<<<<<< HEAD
        $user = createUser([
>>>>>>> 6d3760fe (.)
=======
        $user = UserFactory::new()->create([
>>>>>>> 9fa499be (.)
            'email_verified_at' => null,
        ]);
        \assert($user instanceof User);

        expect($user->email_verified_at)->toBeNull();

        $user->markEmailAsVerified();

<<<<<<< HEAD
<<<<<<< HEAD
        expect($user->fresh()->email_verified_at)->not->toBeNull();
    });

    it('can check if email is verified', function () {
        /** @var User $verifiedUser */
        $verifiedUser = User::factory()->create([
=======
        expect(freshUser($user)->email_verified_at)->not->toBeNull();
=======
        $fresh = $user->fresh();
        \assert(null !== $fresh);

        expect($fresh->email_verified_at)->not->toBeNull();
>>>>>>> 9fa499be (.)
    });

    it('can check if email is verified', function () {
        /** @var User $verifiedUser */
<<<<<<< HEAD
        $verifiedUser = createUser([
>>>>>>> 6d3760fe (.)
=======
        $verifiedUser = UserFactory::new()->create([
>>>>>>> 9fa499be (.)
            'email_verified_at' => now(),
        ]);
        \assert($verifiedUser instanceof User);

        /** @var User $unverifiedUser */
<<<<<<< HEAD
<<<<<<< HEAD
        $unverifiedUser = User::factory()->create([
=======
        $unverifiedUser = createUser([
>>>>>>> 6d3760fe (.)
=======
        $unverifiedUser = UserFactory::new()->create([
>>>>>>> 9fa499be (.)
            'email_verified_at' => null,
        ]);
        \assert($unverifiedUser instanceof User);

        expect($verifiedUser->hasVerifiedEmail())->toBe(true);
        expect($unverifiedUser->hasVerifiedEmail())->toBe(false);
    });

<<<<<<< HEAD
<<<<<<< HEAD
    it('can send email verification notification', function () {
        /** @var User $user */
        $user = User::factory()->create([
=======
    it('can send email verification notification', function (): void {
        /** @var User $user */
        $user = createUser([
>>>>>>> 6d3760fe (.)
=======
    it('can send email verification notification', function () {
        /** @var User $user */
        $user = UserFactory::new()->create([
>>>>>>> 9fa499be (.)
            'email_verified_at' => null,
        ]);
        \assert($user instanceof User);

        Notification::fake();

        $user->sendEmailVerificationNotification();

        Notification::assertSentTo($user, VerifyEmail::class);
    });
});

<<<<<<< HEAD
<<<<<<< HEAD
describe('User Authorization', function () {
    it('can assign and check roles', function () {
        $adminRole = Role::factory()->create(['name' => 'admin']);
        $editorRole = Role::factory()->create(['name' => 'editor']);

        $this->user->assignRole($adminRole);

        expect($this->user->hasRole('admin'))->toBe(true);
        expect($this->user->hasRole('editor'))->toBe(false);
        expect($this->user->hasRole($adminRole))->toBe(true);
    });

    it('can assign and check permissions', function () {
        $editPermission = Permission::factory()->create(['name' => 'edit posts']);
        $deletePermission = Permission::factory()->create(['name' => 'delete posts']);

        $this->user->givePermissionTo($editPermission);

        expect($this->user->hasPermissionTo('edit posts'))->toBe(true);
        expect($this->user->hasPermissionTo('delete posts'))->toBe(false);
        expect($this->user->hasPermissionTo($editPermission))->toBe(true);
    });

    it('can inherit permissions from roles', function () {
        $role = Role::factory()->create(['name' => 'editor']);
        $permission = Permission::factory()->create(['name' => 'edit posts']);

        $role->givePermissionTo($permission);
        $this->user->assignRole($role);

        expect($this->user->hasPermissionTo('edit posts'))->toBe(true);
    });

    it('can check multiple permissions', function () {
        $permission1 = Permission::factory()->create(['name' => 'edit posts']);
        $permission2 = Permission::factory()->create(['name' => 'delete posts']);

        $this->user->givePermissionTo([$permission1, $permission2]);

        expect($this->user->hasAllPermissions(['edit posts', 'delete posts']))->toBe(true);
        expect($this->user->hasAnyPermission(['edit posts', 'publish posts']))->toBe(true);
    });

    it('can remove roles and permissions', function () {
        $role = Role::factory()->create(['name' => 'editor']);
        $permission = Permission::factory()->create(['name' => 'edit posts']);

        $this->user->assignRole($role);
        $this->user->givePermissionTo($permission);

        expect($this->user->hasRole('editor'))->toBe(true);
        expect($this->user->hasPermissionTo('edit posts'))->toBe(true);

        $this->user->removeRole($role);
        $this->user->revokePermissionTo($permission);

        expect($this->user->hasRole('editor'))->toBe(false);
        expect($this->user->hasPermissionTo('edit posts'))->toBe(false);
    });
});

describe('User OAuth Authentication', function () {
    it('can have oauth clients', function () {
        expect($this->user->clients())->toBeInstanceOf(Illuminate\Database\Eloquent\Relations\MorphMany::class);
    });

    it('can have oauth tokens', function () {
        expect($this->user->tokens())->toBeInstanceOf(HasMany::class);
    });

    it('can find user for passport', function () {
        $user = User::findForPassport($this->user->email);

        expect($user)->not->toBeNull();
        expect($user->id)->toBe($this->user->id);
    });

    it('can validate password for passport', function () {
        $isValid = $this->user->validateForPassportPasswordGrant('password123');
=======
describe('User Authorization', function (): void {
    it('can assign and check roles', function (): void {
        $adminRole = createRole(['name' => 'admin']);
=======
describe('User Authorization', function () {
    it('can assign and check roles', function () {
        $adminRole = RoleFactory::new()->createOne(['name' => 'admin']);
        $editorRole = RoleFactory::new()->createOne(['name' => 'editor']);
>>>>>>> 9fa499be (.)

        $this->requireUser()->assignRole($adminRole);

        expect($this->requireUser()->hasRole('admin'))->toBe(true);
        expect($this->requireUser()->hasRole('editor'))->toBe(false);
        expect($this->requireUser()->hasRole($adminRole))->toBe(true);
    });

    it('can assign and check permissions', function () {
        $editPermission = PermissionFactory::new()->createOne(['name' => 'edit posts']);
        $deletePermission = PermissionFactory::new()->createOne(['name' => 'delete posts']);

        $this->requireUser()->givePermissionTo($editPermission);

        expect($this->requireUser()->hasPermissionTo('edit posts'))->toBe(true);
        expect($this->requireUser()->hasPermissionTo('delete posts'))->toBe(false);
        expect($this->requireUser()->hasPermissionTo($editPermission))->toBe(true);
    });

    it('can inherit permissions from roles', function () {
        $role = RoleFactory::new()->createOne(['name' => 'editor']);
        $permission = PermissionFactory::new()->createOne(['name' => 'edit posts']);

        $role->givePermissionTo($permission);
        $this->requireUser()->assignRole($role);

        expect($this->requireUser()->hasPermissionTo('edit posts'))->toBe(true);
    });

    it('can check multiple permissions', function () {
        $permission1 = PermissionFactory::new()->createOne(['name' => 'edit posts']);
        $permission2 = PermissionFactory::new()->createOne(['name' => 'delete posts']);

        $this->requireUser()->givePermissionTo([$permission1, $permission2]);

        expect($this->requireUser()->hasAllPermissions(['edit posts', 'delete posts']))->toBe(true);
        expect($this->requireUser()->hasAnyPermission(['edit posts', 'publish posts']))->toBe(true);
    });

    it('can remove roles and permissions', function () {
        $role = RoleFactory::new()->createOne(['name' => 'editor']);
        $permission = PermissionFactory::new()->createOne(['name' => 'edit posts']);

        $this->requireUser()->assignRole($role);
        $this->requireUser()->givePermissionTo($permission);

        expect($this->requireUser()->hasRole('editor'))->toBe(true);
        expect($this->requireUser()->hasPermissionTo('edit posts'))->toBe(true);

        $this->requireUser()->removeRole($role);
        $this->requireUser()->revokePermissionTo($permission);

        expect($this->requireUser()->hasRole('editor'))->toBe(false);
        expect($this->requireUser()->hasPermissionTo('edit posts'))->toBe(false);
    });
});

describe('User OAuth Authentication', function () {
    it('can have oauth clients', function () {
        expect($this->requireUser()->clients())->toBeInstanceOf(MorphMany::class);
    });

    it('can have oauth tokens', function () {
        expect($this->requireUser()->tokens())->toBeInstanceOf(HasMany::class);
    });

    it('can find user for passport', function () {
        $user = User::findForPassport($this->requireUser()->email);

        expect($user)->not->toBeNull();
        \assert($user instanceof User);
        expect($user->id)->toBe($this->requireUser()->id);
    });

<<<<<<< HEAD
    it('can validate password for passport', function (): void {
        $isValid = userUnderTest($this)->validateForPassportPasswordGrant('password123');
>>>>>>> 6d3760fe (.)
=======
    it('can validate password for passport', function () {
        $isValid = $this->requireUser()->validateForPassportPasswordGrant('password123');
>>>>>>> 9fa499be (.)

        expect($isValid)->toBe(true);
    });
});

<<<<<<< HEAD
<<<<<<< HEAD
describe('User Authentication Logging', function () {
    it('can log authentication attempts', function () {
        expect($this->user->authentications())->toBeInstanceOf(Illuminate\Database\Eloquent\Relations\MorphMany::class);
    });

    it('can get latest authentication log', function () {
        expect($this->user->latestAuthentication())
            ->toBeInstanceOf(Illuminate\Database\Eloquent\Relations\MorphOne::class);
    });
});

describe('User Session Management', function () {
    it('can store user in session', function () {
        Auth::login($this->user);

        expect(Auth::check())->toBe(true);
        expect(Auth::id())->toBe($this->user->id);
    });

    it('can remember user across sessions', function () {
        Auth::login($this->user, true);

        expect($this->user->fresh()->remember_token)->not->toBeNull();
    });

    it('can clear user session on logout', function () {
        Auth::login($this->user);
=======
describe('User Authentication Logging', function (): void {
    it('can log authentication attempts', function (): void {
        expect(userUnderTest($this)->authentications())->toBeInstanceOf(MorphMany::class);
=======
describe('User Authentication Logging', function () {
    it('can log authentication attempts', function () {
        expect($this->requireUser()->authentications())->toBeInstanceOf(MorphMany::class);
>>>>>>> 9fa499be (.)
    });

    it('can get latest authentication log', function () {
        expect($this->requireUser()->latestAuthentication())
            ->toBeInstanceOf(MorphOne::class);
    });
});

describe('User Session Management', function () {
    it('can store user in session', function () {
        Auth::login($this->requireUser());

        expect(Auth::check())->toBe(true);
        expect(Auth::id())->toBe($this->requireUser()->id);
    });

    it('can remember user across sessions', function () {
        Auth::login($this->requireUser(), true);

        expect($this->requireFreshUser($this->requireUser())->remember_token)->not->toBeNull();
    });

<<<<<<< HEAD
    it('can clear user session on logout', function (): void {
        Auth::login(userUnderTest($this));
>>>>>>> 6d3760fe (.)
=======
    it('can clear user session on logout', function () {
        Auth::login($this->requireUser());
>>>>>>> 9fa499be (.)
        expect(Auth::check())->toBe(true);

        Auth::logout();
        expect(Auth::check())->toBe(false);
    });
});

<<<<<<< HEAD
<<<<<<< HEAD
describe('User Two Factor Authentication', function () {
    it('can enable two factor authentication', function () {
        $this->user->update(['is_otp' => true]);

        expect($this->user->fresh()->is_otp)->toBe(true);
    });

    it('can disable two factor authentication', function () {
        $this->user->update(['is_otp' => false]);

        expect($this->user->fresh()->is_otp)->toBe(false);
    });

    it('handles otp authentication workflow', function () {
        /** @var User $user */
        $user = User::factory()->create([
=======
describe('User Two Factor Authentication', function (): void {
    it('can enable two factor authentication', function (): void {
        userUnderTest($this)->update(['is_otp' => true]);
=======
describe('User Two Factor Authentication', function () {
    it('can enable two factor authentication', function () {
        $this->requireUser()->update(['is_otp' => true]);
>>>>>>> 9fa499be (.)

        expect($this->requireFreshUser($this->requireUser())->is_otp)->toBe(true);
    });

    it('can disable two factor authentication', function () {
        $this->requireUser()->update(['is_otp' => false]);

        expect($this->requireFreshUser($this->requireUser())->is_otp)->toBe(false);
    });

    it('handles otp authentication workflow', function () {
        /** @var User $user */
<<<<<<< HEAD
        $user = createUser([
>>>>>>> 6d3760fe (.)
=======
        $user = UserFactory::new()->create([
>>>>>>> 9fa499be (.)
            'is_otp' => true,
            'password' => Hash::make('password123'),
        ]);
        \assert($user instanceof User);

        // First step: password authentication
        $result = Auth::attempt([
            'email' => $user->email,
            'password' => 'password123',
        ]);
<<<<<<< HEAD
<<<<<<< HEAD

        // Should handle OTP requirement
=======
>>>>>>> 6d3760fe (.)
=======

        // Should handle OTP requirement
>>>>>>> 9fa499be (.)
        expect($user->is_otp)->toBe(true);
    });
});
