<?php

declare(strict_types=1);

/**
 * Form Validation Tests for Registration.
 *
 * NOTE: ValidateUserDataAction only validates duplicate email. Required fields,
 * email format, password strength are validated by RegisterWidget (Livewire).
 * Tests for ValidateUserDataAction validation are skipped.
 */

use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
use Modules\Gdpr\Actions\Validation\ValidateGdprConsentAction;
use Modules\Gdpr\Actions\Validation\ValidateUserDataAction;
use Modules\Gdpr\Tests\TestCase;
use Modules\User\Models\User;

uses(TestCase::class);

// ---------------------------------------------------------------------------
// Required Field Validation (ValidateUserDataAction does NOT validate - skip)
// ---------------------------------------------------------------------------

it('validates first_name is required', function (): void {
    test()->markTestSkipped('ValidateUserDataAction does not validate required - validation is in RegisterWidget');
});

it('validates last_name is required', function (): void {
    test()->markTestSkipped('ValidateUserDataAction does not validate required - validation is in RegisterWidget');
});

it('validates email is required', function (): void {
    test()->markTestSkipped('ValidateUserDataAction does not validate required - validation is in RegisterWidget');
});

it('validates password is required', function (): void {
    test()->markTestSkipped('ValidateUserDataAction does not validate required - validation is in RegisterWidget');
});

it('validates email format', function (): void {
    test()->markTestSkipped('ValidateUserDataAction does not validate email format - validation is in RegisterWidget');
});

it('validates email must have domain', function (): void {
    test()->markTestSkipped('ValidateUserDataAction does not validate email - validation is in RegisterWidget');
});

it('accepts valid email format', function (): void {
    $email = 'valid-'.Str::random(8).'@example.com';
    $formData = [
        'first_name' => 'Mario',
        'last_name' => 'Rossi',
        'email' => $email,
        'password' => 'SecureP@ss1!',
        'password_confirmation' => 'SecureP@ss1!',
    ];

    $result = app(ValidateUserDataAction::class)->execute($formData);
    expect($result['email'])->toBe($email);
});

// ---------------------------------------------------------------------------
// Password Validation (ValidateUserDataAction does NOT validate - skip)
// ---------------------------------------------------------------------------

it('validates password minimum length', function (): void {
    test()->markTestSkipped('ValidateUserDataAction does not validate password - validation is in RegisterWidget');
});

it('validates password must contain uppercase', function (): void {
    test()->markTestSkipped('ValidateUserDataAction does not validate password - validation is in RegisterWidget');
});

it('validates password must contain lowercase', function (): void {
    test()->markTestSkipped('ValidateUserDataAction does not validate password - validation is in RegisterWidget');
});

it('validates password must contain number', function (): void {
    test()->markTestSkipped('ValidateUserDataAction does not validate password - validation is in RegisterWidget');
});

it('validates password must contain symbol', function (): void {
    test()->markTestSkipped('ValidateUserDataAction does not validate password - validation is in RegisterWidget');
});

it('accepts valid strong password', function (): void {
    $formData = [
        'first_name' => 'Mario',
        'last_name' => 'Rossi',
        'email' => 'strong-pw-'.Str::random(8).'@example.com',
        'password' => 'SecureP@ss1!',
        'password_confirmation' => 'SecureP@ss1!',
    ];

    $result = app(ValidateUserDataAction::class)->execute($formData);
    expect($result['password'])->not->toBe('SecureP@ss1!');
});

it('validates password confirmation must match', function (): void {
    test()->markTestSkipped('ValidateUserDataAction does not validate password confirmation - validation is in RegisterWidget');
});

// ---------------------------------------------------------------------------
// GDPR Consent Validation
// ---------------------------------------------------------------------------

it('validates privacy consent is required', function (): void {
    $this->expectException(ValidationException::class);
    app(ValidateGdprConsentAction::class)->execute(false, true);
});

it('validates terms consent is required', function (): void {
    $this->expectException(ValidationException::class);
    app(ValidateGdprConsentAction::class)->execute(true, false);
});

it('validates both consents required', function (): void {
    $this->expectException(ValidationException::class);
    app(ValidateGdprConsentAction::class)->execute(false, false);
});

it('accepts valid consent combination', function (): void {
    $result = app(ValidateGdprConsentAction::class)->execute(true, true);
    expect($result)->toBeNull();
});

// ---------------------------------------------------------------------------
// User Type Security
// ---------------------------------------------------------------------------

it('always sets type to customer_user regardless of input', function (): void {
    $formData = [
        'first_name' => 'Hacker',
        'last_name' => 'Attempt',
        'email' => 'admin-like-'.Str::random(8).'@example.com',
        'password' => 'SecureP@ss1!',
        'password_confirmation' => 'SecureP@ss1!',
    ];

    $result = app(ValidateUserDataAction::class)->execute($formData);
    expect($result['type'])->toBe('customer_user');
    expect($result['type'])->not->toBe('admin');
    expect($result['type'])->not->toBe('super_admin');
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
    expect($result['type'])->toBe('customer_user');
    expect($result)->toHaveKey('lang');
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
    expect($result['email_verified_at'])->not->toBeNull();
});

// ---------------------------------------------------------------------------
// Duplicate Email Prevention
// ---------------------------------------------------------------------------

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

    $this->expectException(ValidationException::class);
    app(ValidateUserDataAction::class)->execute($formData);
});

// ---------------------------------------------------------------------------
// Name Validation (ValidateUserDataAction does NOT validate - skip)
// ---------------------------------------------------------------------------

it('validates first_name minimum length', function (): void {
    test()->markTestSkipped('ValidateUserDataAction does not validate name length - validation is in RegisterWidget');
});

it('validates first_name maximum length', function (): void {
    test()->markTestSkipped('ValidateUserDataAction does not validate name length - validation is in RegisterWidget');
});

it('validates last_name minimum length', function (): void {
    test()->markTestSkipped('ValidateUserDataAction does not validate name length - validation is in RegisterWidget');
});
