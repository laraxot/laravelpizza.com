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
use Modules\User\Contracts\UserContract;
use Modules\User\Database\Factories\PermissionFactory;
use Modules\User\Database\Factories\RoleFactory;
use Modules\User\Database\Factories\UserFactory;
use Modules\User\Models\User;
use Modules\User\Tests\TestCase;

uses(TestCase::class);

beforeEach(function () {
    $user = UserFactory::new()->createOne([
        'password' => Hash::make('password123'),
        'is_active' => true,
        'email_verified_at' => now(),
    ]);
    \assert($user instanceof UserContract);
    TestCase::$user = $user;
});

describe('User Authentication', function () {
    it('can authenticate with valid credentials', function () {
        $result = Auth::attempt([
            'email' => TestCase::requireUser()->email,
            'password' => 'password123',
        ]);

        expect($result)->toBe(true);
        expect(Auth::user()?->id)->toBe(TestCase::requireUser()->id);
    });

    it('cannot authenticate with invalid password', function () {
        $result = Auth::attempt([
            'email' => TestCase::requireUser()->email,
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
        $inactiveUser = UserFactory::new()->createOne([
            'password' => Hash::make('password123'),
            'is_active' => false,
        ]);
        \assert($inactiveUser instanceof UserContract);

        $result = Auth::attempt([
            'email' => $inactiveUser->email,
            'password' => 'password123',
            'is_active' => true,
        ]);

        expect($result)->toBe(false);
    });

    it('can logout user', function () {
        Auth::login(TestCase::requireUser());
        expect(Auth::check())->toBe(true);

        Auth::logout();
        expect(Auth::check())->toBe(false);
    });
});

describe('User Password Management', function () {
    it('can hash password on creation', function () {
        /** @var User $user */
        /** @var User $user */
        $user = UserFactory::new()->createOne([
            'password' => Hash::make('testpassword'),
        ]);
        \assert($user instanceof UserContract);

        expect(Hash::check('testpassword', $user->password))->toBe(true);
    });

    it('can change password', function () {
        $newPassword = 'newpassword123';
        TestCase::requireUser()->update([
            'password' => Hash::make($newPassword),
        ]);

        expect(Hash::check($newPassword, TestCase::requireFreshUser(TestCase::requireUser())->password))->toBe(true);
        expect(Hash::check('password123', TestCase::requireFreshUser(TestCase::requireUser())->password))->toBe(false);
    });

    it('can check password expiration', function () {
        /** @var User $user */
        $user = UserFactory::new()->createOne([
            'password_expires_at' => now()->subDays(1),
        ]);
        \assert($user instanceof UserContract);
        $passwordExpiresAt = $user->password_expires_at;
        \assert($passwordExpiresAt !== null);

        expect($passwordExpiresAt->isPast())->toBe(true);
    });

    it('can set password expiration', function () {
        $expirationDate = now()->addDays(90);
        TestCase::requireUser()->update([
            'password_expires_at' => $expirationDate,
        ]);

        $passwordExpiresAt = TestCase::requireFreshUser(TestCase::requireUser())->password_expires_at;
        \assert($passwordExpiresAt !== null);

        expect($passwordExpiresAt->toDateString())
            ->toBe($expirationDate->toDateString());
    });
});

describe('User Remember Token', function () {
    it('can generate remember token', function () {
        $token = Str::random(60);
        TestCase::requireUser()->forceFill(['remember_token' => $token])->save();

        expect(TestCase::requireFreshUser(TestCase::requireUser())->remember_token)->toBe($token);
    });

    it('can authenticate using remember token', function () {
        $token = Str::random(60);
        TestCase::requireUser()->forceFill(['remember_token' => $token])->save();

        $user = User::where('email', TestCase::requireUser()->email)->where('remember_token', $token)->first();

        expect($user)->not->toBeNull();
        \assert($user instanceof UserContract);
        expect($user->id)->toBe(TestCase::requireUser()->id);
    });
});

describe('User Email Verification', function () {
    it('can mark email as verified', function () {
        /** @var User $user */
        $user = UserFactory::new()->createOne([
            'email_verified_at' => null,
        ]);
        \assert($user instanceof UserContract);

        expect($user->email_verified_at)->toBeNull();

        $user->markEmailAsVerified();

        $fresh = $user->fresh();
        \assert($fresh !== null);

        expect($fresh->email_verified_at)->not->toBeNull();
    });

    it('can check if email is verified', function () {
        /** @var User $verifiedUser */
        $verifiedUser = UserFactory::new()->createOne([
            'email_verified_at' => now(),
        ]);
        \assert($verifiedUser instanceof UserContract);

        /** @var User $unverifiedUser */
        $unverifiedUser = UserFactory::new()->createOne([
            'email_verified_at' => null,
        ]);
        \assert($unverifiedUser instanceof UserContract);

        expect($verifiedUser->hasVerifiedEmail())->toBe(true);
        expect($unverifiedUser->hasVerifiedEmail())->toBe(false);
    });

    it('can send email verification notification', function () {
        /** @var User $user */
        $user = UserFactory::new()->createOne([
            'email_verified_at' => null,
        ]);
        \assert($user instanceof UserContract);

        Notification::fake();

        $user->sendEmailVerificationNotification();

        Notification::assertSentTo($user, VerifyEmail::class);
    });
});

describe('User Authorization', function () {
    it('can assign and check roles', function () {
        $adminRole = RoleFactory::new()->createOne(['name' => 'admin']);
        // 'editor' esiste ma non e' assegnato: hasRole('editor') deve restare false
        RoleFactory::new()->createOne(['name' => 'editor']);

        TestCase::requireUser()->assignRole($adminRole);

        expect(TestCase::requireUser()->hasRole('admin'))->toBe(true);
        expect(TestCase::requireUser()->hasRole('editor'))->toBe(false);
        expect(TestCase::requireUser()->hasRole($adminRole))->toBe(true);
    });

    it('can assign and check permissions', function () {
        $editPermission = PermissionFactory::new()->createOne(['name' => 'edit posts']);
        // 'delete posts' esiste ma non e' concesso: hasPermissionTo('delete posts') deve restare false
        PermissionFactory::new()->createOne(['name' => 'delete posts']);

        TestCase::requireUser()->givePermissionTo($editPermission);

        expect(TestCase::requireUser()->hasPermissionTo('edit posts'))->toBe(true);
        expect(TestCase::requireUser()->hasPermissionTo('delete posts'))->toBe(false);
        expect(TestCase::requireUser()->hasPermissionTo($editPermission))->toBe(true);
    });

    it('can inherit permissions from roles', function () {
        $role = RoleFactory::new()->createOne(['name' => 'editor']);
        $permission = PermissionFactory::new()->createOne(['name' => 'edit posts']);

        $role->givePermissionTo($permission);
        TestCase::requireUser()->assignRole($role);

        expect(TestCase::requireUser()->hasPermissionTo('edit posts'))->toBe(true);
    });

    it('can check multiple permissions', function () {
        $permission1 = PermissionFactory::new()->createOne(['name' => 'edit posts']);
        $permission2 = PermissionFactory::new()->createOne(['name' => 'delete posts']);

        TestCase::requireUser()->givePermissionTo([$permission1, $permission2]);

        expect(TestCase::requireUser()->hasAllPermissions(['edit posts', 'delete posts']))->toBe(true);
        expect(TestCase::requireUser()->hasAnyPermission(['edit posts', 'publish posts']))->toBe(true);
    });

    it('can remove roles and permissions', function () {
        $role = RoleFactory::new()->createOne(['name' => 'editor']);
        $permission = PermissionFactory::new()->createOne(['name' => 'edit posts']);

        TestCase::requireUser()->assignRole($role);
        TestCase::requireUser()->givePermissionTo($permission);

        expect(TestCase::requireUser()->hasRole('editor'))->toBe(true);
        expect(TestCase::requireUser()->hasPermissionTo('edit posts'))->toBe(true);

        TestCase::requireUser()->removeRole($role);
        TestCase::requireUser()->revokePermissionTo($permission);

        expect(TestCase::requireUser()->hasRole('editor'))->toBe(false);
        expect(TestCase::requireUser()->hasPermissionTo('edit posts'))->toBe(false);
    });
});

describe('User OAuth Authentication', function () {
    it('can have oauth clients', function () {
        expect((TestCase::requireUser()->clients())::class)->toBe(MorphMany::class);
    });

    it('can have oauth tokens', function () {
        expect((TestCase::requireUser()->tokens())::class)->toBe(HasMany::class);
    });

    it('can find user for passport', function () {
        $user = User::findForPassport(TestCase::requireUser()->email);

        expect($user)->not->toBeNull();
        \assert($user instanceof UserContract);
        expect($user->id)->toBe(TestCase::requireUser()->id);
    });

    it('can validate password for passport', function () {
        $isValid = TestCase::requireUser()->validateForPassportPasswordGrant('password123');

        expect($isValid)->toBe(true);
    });
});

describe('User Authentication Logging', function () {
    it('can log authentication attempts', function () {
        expect((TestCase::requireUser()->authentications())::class)->toBe(MorphMany::class);
    });

    it('can get latest authentication log', function () {
        expect((TestCase::requireUser()->latestAuthentication())::class)->toBe(MorphOne::class);
    });
});

describe('User Session Management', function () {
    it('can store user in session', function () {
        Auth::login(TestCase::requireUser());

        expect(Auth::check())->toBe(true);
        expect(Auth::id())->toBe(TestCase::requireUser()->id);
    });

    it('can remember user across sessions', function () {
        Auth::login(TestCase::requireUser(), true);

        expect(TestCase::requireFreshUser(TestCase::requireUser())->remember_token)->not->toBeNull();
    });

    it('can clear user session on logout', function () {
        Auth::login(TestCase::requireUser());
        expect(Auth::check())->toBe(true);

        Auth::logout();
        expect(Auth::check())->toBe(false);
    });
});

describe('User Two Factor Authentication', function () {
    it('can enable two factor authentication', function () {
        TestCase::requireUser()->update(['is_otp' => true]);

        expect(TestCase::requireFreshUser(TestCase::requireUser())->is_otp)->toBe(true);
    });

    it('can disable two factor authentication', function () {
        TestCase::requireUser()->update(['is_otp' => false]);

        expect(TestCase::requireFreshUser(TestCase::requireUser())->is_otp)->toBe(false);
    });

    it('handles otp authentication workflow', function () {
        /** @var User $user */
        $user = UserFactory::new()->createOne([
            'is_otp' => true,
            'password' => Hash::make('password123'),
        ]);
        \assert($user instanceof UserContract);

        // First step: password authentication
        $result = Auth::attempt([
            'email' => $user->email,
            'password' => 'password123',
        ]);

        // La password (OTP) e' valida: il login riesce, poi PasswordExpiryMiddleware impone il cambio password
        expect($result)->toBe(true);
        expect($user->is_otp)->toBe(true);
    });
});
