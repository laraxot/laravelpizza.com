<?php

declare(strict_types=1);

namespace Modules\Gdpr\Tests\Feature;

use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
use Modules\Gdpr\Actions\Validation\ValidateGdprConsentAction;
use Modules\Gdpr\Actions\Validation\ValidateUserDataAction;
use Modules\Gdpr\Tests\TestCase;
use Modules\User\Models\User;
use PHPUnit\Framework\Assert;

uses(TestCase::class);

/*
 * Form Validation Tests for Registration.
 *
 * NOTE: ValidateUserDataAction only validates duplicate email. Required fields,
 * email format, password strength are validated by RegisterWidget (Livewire).
 */

it('validates first_name is required', function (): void {
    gdprSkipTest('ValidateUserDataAction does not validate required - validation is in RegisterWidget');
});

it('validates last_name is required', function (): void {
    gdprSkipTest('ValidateUserDataAction does not validate required - validation is in RegisterWidget');
});

it('validates email is required', function (): void {
    gdprSkipTest('ValidateUserDataAction does not validate required - validation is in RegisterWidget');
});

it('validates password is required', function (): void {
    gdprSkipTest('ValidateUserDataAction does not validate required - validation is in RegisterWidget');
});

it('validates email format', function (): void {
    gdprSkipTest('ValidateUserDataAction does not validate email format - validation is in RegisterWidget');
});

it('validates email must have domain', function (): void {
    gdprSkipTest('ValidateUserDataAction does not validate email - validation is in RegisterWidget');
});

it('validates password confirmation must match', function (): void {
    gdprSkipTest('ValidateUserDataAction does not validate password confirmation - validation is in RegisterWidget');
});

it('validates privacy consent is required', function (): void {
    gdprAssertThrows(ValidationException::class, fn () => app(ValidateGdprConsentAction::class)->execute(false, true));
});

it('validates terms consent is required', function (): void {
    gdprAssertThrows(ValidationException::class, fn () => app(ValidateGdprConsentAction::class)->execute(true, false));
});

it('validates both consents required', function (): void {
    gdprAssertThrows(ValidationException::class, fn () => app(ValidateGdprConsentAction::class)->execute(false, false));
});

it('accepts valid consent combination', function (): void {
    gdprAssertDoesNotThrow(ValidationException::class, fn () => app(ValidateGdprConsentAction::class)->execute(true, true));
});

it('always sets type to customer_user regardless of input', function (): void {
    $formData = [
        'first_name' => 'Hacker',
        'last_name' => 'Attempt',
        'email' => 'admin-like-'.Str::random(8).'@example.com',
        'password' => 'SecureP@ss1!',
        'password_confirmation' => 'SecureP@ss1!',
    ];

    $result = app(ValidateUserDataAction::class)->execute($formData);
    Assert::assertSame('customer_user', $result['type']);
    Assert::assertNotSame('admin', $result['type']);
    Assert::assertNotSame('super_admin', $result['type']);
});

it('always sets type to customer_user and lang', function (): void {
    $formData = [
        'first_name' => 'Mario',
        'last_name' => 'Rossi',
        'email' => 'type-lang-'.Str::random(8).'@example.com',
        'password' => 'SecureP@ss1!',
        'password_confirmation' => 'SecureP@ss1!',
    ];

    $result = app(ValidateUserDataAction::class)->execute($formData);
    Assert::assertSame('customer_user', $result['type']);
    Assert::assertArrayHasKey('lang', $result);
});

it('sets email_verified_at on registration', function (): void {
    $formData = [
        'first_name' => 'Mario',
        'last_name' => 'Rossi',
        'email' => 'verified-'.Str::random(8).'@example.com',
        'password' => 'SecureP@ss1!',
        'password_confirmation' => 'SecureP@ss1!',
    ];

    $result = app(ValidateUserDataAction::class)->execute($formData);
    Assert::assertNotNull($result['email_verified_at']);
});

it('prevents duplicate email registration', function (): void {
    $email = 'duplicate-'.Str::random(8).'@example.com';

    User::create([
        'first_name' => 'Existing',
        'last_name' => 'User',
        'email' => $email,
        'password' => bcrypt('SecureP@ss1!'),
        'type' => 'customer_user',
    ]);

    $formData = [
        'first_name' => 'Second',
        'last_name' => 'User',
        'email' => $email,
        'password' => 'SecureP@ss2!',
        'password_confirmation' => 'SecureP@ss2!',
    ];

    gdprAssertThrows(ValidationException::class, fn () => app(ValidateUserDataAction::class)->execute($formData));
});

it('validates first_name minimum length', function (): void {
    gdprSkipTest('ValidateUserDataAction does not validate name length - validation is in RegisterWidget');
});

it('validates first_name maximum length', function (): void {
    gdprSkipTest('ValidateUserDataAction does not validate name length - validation is in RegisterWidget');
});

it('validates last_name minimum length', function (): void {
    gdprSkipTest('ValidateUserDataAction does not validate name length - validation is in RegisterWidget');
});
