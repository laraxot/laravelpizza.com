<?php

declare(strict_types=1);

/**
 * Form Validation Tests for Registration.
 *
 * Tests form validation for registration including:
 * - Required field validation
 * - Email format validation
 * - Password matching validation
 * - Password strength validation
 * - GDPR consent validation
 */

use Illuminate\Validation\ValidationException;
use Modules\Gdpr\Actions\Validation\ValidateGdprConsentAction;
use Modules\Gdpr\Actions\Validation\ValidateUserDataAction;
use Modules\Gdpr\Models\Treatment;
use Modules\Gdpr\Tests\TestCase;
use Modules\User\Actions\User\CreateUserAction;
use Modules\User\Models\User;

uses(TestCase::class);

// ---------------------------------------------------------------------------
// Required Field Validation
// ---------------------------------------------------------------------------

it('validates first_name is required', function (): void {
    $formData = [
        'first_name' => '',
        'last_name' => 'Rossi',
        'email' => 'test@example.com',
        'password' => 'SecureP@ss1!',
        'password_confirmation' => 'SecureP@ss1!',
    ];

    $this->expectException(ValidationException::class);
    app(ValidateUserDataAction::class)->execute($formData);
});

it('validates last_name is required', function (): void {
    $formData = [
        'first_name' => 'Mario',
        'last_name' => '',
        'email' => 'test@example.com',
        'password' => 'SecureP@ss1!',
        'password_confirmation' => 'SecureP@ss1!',
    ];

    $this->expectException(ValidationException::class);
    app(ValidateUserDataAction::class)->execute($formData);
});

it('validates email is required', function (): void {
    $formData = [
        'first_name' => 'Mario',
        'last_name' => 'Rossi',
        'email' => '',
        'password' => 'SecureP@ss1!',
        'password_confirmation' => 'SecureP@ss1!',
    ];

    $this->expectException(ValidationException::class);
    app(ValidateUserDataAction::class)->execute($formData);
});

it('validates password is required', function (): void {
    $formData = [
        'first_name' => 'Mario',
        'last_name' => 'Rossi',
        'email' => 'test@example.com',
        'password' => '',
        'password_confirmation' => 'SecureP@ss1!',
    ];

    $this->expectException(ValidationException::class);
    app(ValidateUserDataAction::class)->execute($formData);
});

// ---------------------------------------------------------------------------
// Email Validation
// ---------------------------------------------------------------------------

it('validates email format', function (): void {
    $formData = [
        'first_name' => 'Mario',
        'last_name' => 'Rossi',
        'email' => 'not-an-email',
        'password' => 'SecureP@ss1!',
        'password_confirmation' => 'SecureP@ss1!',
    ];

    $this->expectException(ValidationException::class);
    app(ValidateUserDataAction::class)->execute($formData);
});

it('validates email must have domain', function (): void {
    $formData = [
        'first_name' => 'Mario',
        'last_name' => 'Rossi',
        'email' => 'test@',
        'password' => 'SecureP@ss1!',
        'password_confirmation' => 'SecureP@ss1!',
    ];

    $this->expectException(ValidationException::class);
    app(ValidateUserDataAction::class)->execute($formData);
});

it('accepts valid email format', function (): void {
    $formData = [
        'first_name' => 'Mario',
        'last_name' => 'Rossi',
        'email' => 'mario.rossi@example.com',
        'password' => 'SecureP@ss1!',
        'password_confirmation' => 'SecureP@ss1!',
    ];

    $result = app(ValidateUserDataAction::class)->execute($formData);
    expect($result['email'])->toBe('mario.rossi@example.com');
});

// ---------------------------------------------------------------------------
// Password Validation
// ---------------------------------------------------------------------------

it('validates password minimum length', function (): void {
    $formData = [
        'first_name' => 'Mario',
        'last_name' => 'Rossi',
        'email' => 'test@example.com',
        'password' => 'Short1!',
        'password_confirmation' => 'Short1!',
    ];

    $this->expectException(ValidationException::class);
    app(ValidateUserDataAction::class)->execute($formData);
});

it('validates password must contain uppercase', function (): void {
    $formData = [
        'first_name' => 'Mario',
        'last_name' => 'Rossi',
        'email' => 'test@example.com',
        'password' => 'nouppercase1!',
        'password_confirmation' => 'nouppercase1!',
    ];

    $this->expectException(ValidationException::class);
    app(ValidateUserDataAction::class)->execute($formData);
});

it('validates password must contain lowercase', function (): void {
    $formData = [
        'first_name' => 'Mario',
        'last_name' => 'Rossi',
        'email' => 'test@example.com',
        'password' => 'NOLOWERCASE1!',
        'password_confirmation' => 'NOLOWERCASE1!',
    ];

    $this->expectException(ValidationException::class);
    app(ValidateUserDataAction::class)->execute($formData);
});

it('validates password must contain number', function (): void {
    $formData = [
        'first_name' => 'Mario',
        'last_name' => 'Rossi',
        'email' => 'test@example.com',
        'password' => 'NoNumber!!',
        'password_confirmation' => 'NoNumber!!',
    ];

    $this->expectException(ValidationException::class);
    app(ValidateUserDataAction::class)->execute($formData);
});

it('validates password must contain symbol', function (): void {
    $formData = [
        'first_name' => 'Mario',
        'last_name' => 'Rossi',
        'email' => 'test@example.com',
        'password' => 'NoSymbol1',
        'password_confirmation' => 'NoSymbol1',
    ];

    $this->expectException(ValidationException::class);
    app(ValidateUserDataAction::class)->execute($formData);
});

it('accepts valid strong password', function (): void {
    $formData = [
        'first_name' => 'Mario',
        'last_name' => 'Rossi',
        'email' => 'test@example.com',
        'password' => 'SecureP@ss1!',
        'password_confirmation' => 'SecureP@ss1!',
    ];

    $result = app(ValidateUserDataAction::class)->execute($formData);
    expect($result['password'])->not->toBe('SecureP@ss1!');
});

// ---------------------------------------------------------------------------
// Password Confirmation
// ---------------------------------------------------------------------------

it('validates password confirmation must match', function (): void {
    $formData = [
        'first_name' => 'Mario',
        'last_name' => 'Rossi',
        'email' => 'test@example.com',
        'password' => 'SecureP@ss1!',
        'password_confirmation' => 'DifferentP@ss1!',
    ];

    $this->expectException(ValidationException::class);
    app(ValidateUserDataAction::class)->execute($formData);
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
        'email' => 'admin@example.com',
        'password' => 'SecureP@ss1!',
        'password_confirmation' => 'SecureP@ss1!',
    ];

    $result = app(ValidateUserDataAction::class)->execute($formData);
    expect($result['type'])->toBe('customer_user');
    expect($result['type'])->not->toBe('admin');
    expect($result['type'])->not->toBe('super_admin');
});

it('always sets state to active', function (): void {
    $formData = [
        'first_name' => 'Mario',
        'last_name' => 'Rossi',
        'email' => 'test@example.com',
        'password' => 'SecureP@ss1!',
        'password_confirmation' => 'SecureP@ss1!',
    ];

    $result = app(ValidateUserDataAction::class)->execute($formData);
    expect($result['state'])->toBe('active');
});

it('sets email_verified_at on registration', function (): void {
    $formData = [
        'first_name' => 'Mario',
        'last_name' => 'Rossi',
        'email' => 'test@example.com',
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
    
    // First registration
    $formData1 = [
        'first_name' => 'First',
        'last_name' => 'User',
        'email' => $email,
        'password' => 'SecureP@ss1!',
        'password_confirmation' => 'SecureP@ss1!',
    ];
    
    app(ValidateUserDataAction::class)->execute($formData1);
    
    // Second registration with same email should fail
    $formData2 = [
        'first_name' => 'Second',
        'last_name' => 'User',
        'email' => $email,
        'password' => 'SecureP@ss2!',
        'password_confirmation' => 'SecureP@ss2!',
    ];
    
    $this->expectException(\Illuminate\Database\QueryException::class);
    app(ValidateUserDataAction::class)->execute($formData2);
});

// ---------------------------------------------------------------------------
// Name Validation
// ---------------------------------------------------------------------------

it('validates first_name minimum length', function (): void {
    $formData = [
        'first_name' => 'A',
        'last_name' => 'Rossi',
        'email' => 'test@example.com',
        'password' => 'SecureP@ss1!',
        'password_confirmation' => 'SecureP@ss1!',
    ];

    $this->expectException(ValidationException::class);
    app(ValidateUserDataAction::class)->execute($formData);
});

it('validates first_name maximum length', function (): void {
    $formData = [
        'first_name' => str_repeat('A', 256),
        'last_name' => 'Rossi',
        'email' => 'test@example.com',
        'password' => 'SecureP@ss1!',
        'password_confirmation' => 'SecureP@ss1!',
    ];

    $this->expectException(ValidationException::class);
    app(ValidateUserDataAction::class)->execute($formData);
});

it('validates last_name minimum length', function (): void {
    $formData = [
        'first_name' => 'Mario',
        'last_name' => 'A',
        'email' => 'test@example.com',
        'password' => 'SecureP@ss1!',
        'password_confirmation' => 'SecureP@ss1!',
    ];

    $this->expectException(ValidationException::class);
    app(ValidateUserDataAction::class)->execute($formData);
});
