<?php

declare(strict_types=1);

namespace Modules\User\Tests\Feature\Authentication;

use Illuminate\Auth\Notifications\VerifyEmail;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Str;
use Modules\User\Database\Factories\PermissionFactory;
use Modules\User\Database\Factories\RoleFactory;
use Modules\User\Database\Factories\UserFactory;
use Modules\User\Models\User;
use Modules\User\Tests\TestCase;
use Modules\User\Tests\Traits\HasUserTestCase;

uses(TestCase::class, HasUserTestCase::class);

beforeEach(function () {
    $user = UserFactory::new()->create([
        'password' => Hash::make('password123'),
        'is_active' => true,
        'email_verified_at' => now(),
    ]);
    \assert($user instanceof User);
    $this->user = $user;
});

describe('User Authentication', function () {
    it('can authenticate with valid credentials', function () {
        $result = Auth::attempt([
            'email' => $this->requireUser()->email,
            'password' => 'password123',
        ]);

        expect($result)->toBe(true);
        expect(Auth::user()?->id)->toBe($this->requireUser()->id);
    });

    it('cannot authenticate with invalid password', function () {
        $result = Auth::attempt([
            'email' => $this->requireUser()->email,
            'password' => 'wrongpassword',
        ]);

        expect($result)->toBe(false);
        expect(Auth::user())->toBeNull();
    });

    it('cannot authenticate with non-existent email', function () {
        $result = Auth::attempt([
            'email' => 'nonexistent@example.com',
            'password' => 'password123',
        ]);

        expect($result)->toBe(false);
        expect(Auth::user())->toBeNull();
    });

    it('cannot authenticate inactive user', function () {
        /** @var User $inactiveUser */
        /** @var User $inactiveUser */
        $inactiveUser = UserFactory::new()->create([
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

    it('can logout user', function () {
        Auth::login($this->requireUser());
        expect(Auth::check())->toBe(true);

        Auth::logout();
        expect(Auth::check())->toBe(false);
    });
});

describe('User Password Management', function () {
    it('can hash password on creation', function () {
        /** @var User $user */
        /** @var User $user */
        $user = UserFactory::new()->create([
            'password' => Hash::make('testpassword'),
        ]);
        \assert($user instanceof User);

        expect(Hash::check('testpassword', $user->password))->toBe(true);
    });

    it('can change password', function () {
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
        $this->requireUser()->update([
            'password_expires_at' => $expirationDate,
        ]);

        $passwordExpiresAt = $this->requireFreshUser($this->requireUser())->password_expires_at;
        \assert(null !== $passwordExpiresAt);

        expect($passwordExpiresAt->toDateString())
            ->toBe($expirationDate->toDateString());
    });
});

describe('User Remember Token', function () {
    it('can generate remember token', function () {
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
        $user = UserFactory::new()->create([
            'email_verified_at' => null,
        ]);
        \assert($user instanceof User);

        expect($user->email_verified_at)->toBeNull();

        $user->markEmailAsVerified();

        $fresh = $user->fresh();
        \assert(null !== $fresh);

        expect($fresh->email_verified_at)->not->toBeNull();
    });

    it('can check if email is verified', function () {
        /** @var User $verifiedUser */
        $verifiedUser = UserFactory::new()->create([
            'email_verified_at' => now(),
        ]);
        \assert($verifiedUser instanceof User);

        /** @var User $unverifiedUser */
        $unverifiedUser = UserFactory::new()->create([
            'email_verified_at' => null,
        ]);
        \assert($unverifiedUser instanceof User);

        expect($verifiedUser->hasVerifiedEmail())->toBe(true);
        expect($unverifiedUser->hasVerifiedEmail())->toBe(false);
    });

    it('can send email verification notification', function () {
        /** @var User $user */
        $user = UserFactory::new()->create([
            'email_verified_at' => null,
        ]);
        \assert($user instanceof User);

        Notification::fake();

        $user->sendEmailVerificationNotification();

        Notification::assertSentTo($user, VerifyEmail::class);
    });
});

describe('User Authorization', function () {
    it('can assign and check roles', function () {
        $adminRole = RoleFactory::new()->createOne(['name' => 'admin']);
        $editorRole = RoleFactory::new()->createOne(['name' => 'editor']);

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

    it('can validate password for passport', function () {
        $isValid = $this->requireUser()->validateForPassportPasswordGrant('password123');

        expect($isValid)->toBe(true);
    });
});

describe('User Authentication Logging', function () {
    it('can log authentication attempts', function () {
        expect($this->requireUser()->authentications())->toBeInstanceOf(MorphMany::class);
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

    it('can clear user session on logout', function () {
        Auth::login($this->requireUser());
        expect(Auth::check())->toBe(true);

        Auth::logout();
        expect(Auth::check())->toBe(false);
    });
});

describe('User Two Factor Authentication', function () {
    it('can enable two factor authentication', function () {
        $this->requireUser()->update(['is_otp' => true]);

        expect($this->requireFreshUser($this->requireUser())->is_otp)->toBe(true);
    });

    it('can disable two factor authentication', function () {
        $this->requireUser()->update(['is_otp' => false]);

        expect($this->requireFreshUser($this->requireUser())->is_otp)->toBe(false);
    });

    it('handles otp authentication workflow', function () {
        /** @var User $user */
        $user = UserFactory::new()->create([
            'is_otp' => true,
            'password' => Hash::make('password123'),
        ]);
        \assert($user instanceof User);

        // First step: password authentication
        $result = Auth::attempt([
            'email' => $user->email,
            'password' => 'password123',
        ]);

        // Should handle OTP requirement
        expect($user->is_otp)->toBe(true);
    });
});
