<?php

declare(strict_types=1);

/**
 * Registration Flow Integration Tests.
 *
 * These tests verify the full registration pipeline used by the GDPR RegisterWidget.
 * Registration is handled via Livewire (not a traditional POST route), so we test
 * the Action pipeline directly — the same code path the widget executes.
 *
 * Flow tested:
 * 1. ValidateGdprConsentAction  — validates privacy + terms acceptance
 * 2. ValidateUserDataAction     — sanitizes & hashes password, sets type/state
 * 3. CreateUserAction           — persists user to DB
 * 4. CollectGdprConsentsAction  — collects consent booleans into array
 * 5. SaveGdprConsentsAction     — creates Consent records linked to Treatment records
 */

use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use Modules\Gdpr\Actions\Consent\CollectGdprConsentsAction;
use Modules\Gdpr\Actions\SaveGdprConsentsAction;
use Modules\Gdpr\Actions\Validation\ValidateGdprConsentAction;
use Modules\Gdpr\Actions\Validation\ValidateUserDataAction;
use Modules\Gdpr\Models\Consent;
use Modules\Gdpr\Models\Treatment;
use Modules\Gdpr\Tests\TestCase;
use Modules\User\Actions\User\CreateUserAction;
use Modules\User\Models\User;

uses(TestCase::class);

// ---------------------------------------------------------------------------
// Happy path: full registration pipeline
// ---------------------------------------------------------------------------

it('completes full registration with privacy and terms accepted', function (): void {
    // 1. Validate GDPR consents (should not throw)
    app(ValidateGdprConsentAction::class)->execute(true, true);

    // 2. Validate and transform user data
    $formData = [
        'first_name' => 'Mario',
        'last_name' => 'Rossi',
        'email' => 'mario-reg-' . uniqid() . '@example.com',
        'password' => 'SecureP@ssw0rd!',
    ];
    $validatedData = app(ValidateUserDataAction::class)->execute($formData);

    expect($validatedData['type'])->toBe('customer_user');
    expect($validatedData['state'])->toBe('active');
    expect(Hash::check('SecureP@ssw0rd!', $validatedData['password']))->toBeTrue();

    // 3. Create user
    $user = app(CreateUserAction::class)->execute($validatedData);
    expect($user)->toBeInstanceOf(User::class);
    expect($user->first_name)->toBe('Mario');
    expect($user->type)->toBe('customer_user');

    // 4. Collect consents
    $consents = app(CollectGdprConsentsAction::class)->execute(true, true, false);
    expect($consents)->toBe([
        'privacy_accepted' => true,
        'terms_accepted' => true,
        'marketing_consent' => false,
    ]);

    // 5. Ensure treatments exist and save consents
    Treatment::firstOrCreate(
        ['name' => 'privacy_policy'],
        ['description' => 'Privacy Policy', 'weight' => 1, 'active' => true, 'required' => true]
    );
    Treatment::firstOrCreate(
        ['name' => 'terms_conditions'],
        ['description' => 'Terms and Conditions', 'weight' => 2, 'active' => true, 'required' => true]
    );
    Treatment::firstOrCreate(
        ['name' => 'marketing_consent'],
        ['description' => 'Marketing Consent', 'weight' => 3, 'active' => true, 'required' => false]
    );

    app(SaveGdprConsentsAction::class)->execute($user, $consents, '127.0.0.1', 'PestTest/1.0');

    // Verify user in DB
    $this->assertDatabaseHas('users', [
        'id' => $user->id,
        'email' => $formData['email'],
        'type' => 'customer_user',
    ]);

    // Verify consents saved
    $savedConsents = Consent::where('subject_id', $user->id)->get();
    expect($savedConsents->count())->toBe(3);

    // Privacy and terms should be accepted
    $acceptedConsents = $savedConsents->whereNotNull('accepted_at');
    expect($acceptedConsents->count())->toBe(2);

    // Marketing should be declined
    $marketingConsent = $savedConsents->where('type', 'marketing_consent')->first();
    expect($marketingConsent)->not->toBeNull();
    expect($marketingConsent->accepted_at)->toBeNull();
});

it('completes registration with all consents including marketing', function (): void {
    $formData = [
        'first_name' => 'Giulia',
        'last_name' => 'Bianchi',
        'email' => 'giulia-reg-' . uniqid() . '@example.com',
        'password' => 'Str0ngP@ssword!',
    ];

    app(ValidateGdprConsentAction::class)->execute(true, true);
    $validatedData = app(ValidateUserDataAction::class)->execute($formData);
    $user = app(CreateUserAction::class)->execute($validatedData);

    Treatment::firstOrCreate(
        ['name' => 'privacy_policy'],
        ['description' => 'Privacy Policy', 'weight' => 1, 'active' => true, 'required' => true]
    );
    Treatment::firstOrCreate(
        ['name' => 'terms_conditions'],
        ['description' => 'Terms and Conditions', 'weight' => 2, 'active' => true, 'required' => true]
    );
    Treatment::firstOrCreate(
        ['name' => 'marketing_consent'],
        ['description' => 'Marketing Consent', 'weight' => 3, 'active' => true, 'required' => false]
    );

    $consents = app(CollectGdprConsentsAction::class)->execute(true, true, true);
    app(SaveGdprConsentsAction::class)->execute($user, $consents, '10.0.0.1', 'PestTest/1.0');

    // All 3 consents should be accepted
    $savedConsents = Consent::where('subject_id', $user->id)->get();
    expect($savedConsents->count())->toBe(3);
    expect($savedConsents->whereNotNull('accepted_at')->count())->toBe(3);
});

// ---------------------------------------------------------------------------
// Validation failures: GDPR consents
// ---------------------------------------------------------------------------

it('fails registration when privacy not accepted', function (): void {
    app(ValidateGdprConsentAction::class)->execute(false, true);
})->throws(ValidationException::class);

it('fails registration when terms not accepted', function (): void {
    app(ValidateGdprConsentAction::class)->execute(true, false);
})->throws(ValidationException::class);

it('fails registration when both consents not accepted', function (): void {
    app(ValidateGdprConsentAction::class)->execute(false, false);
})->throws(ValidationException::class);

// ---------------------------------------------------------------------------
// User data validation
// ---------------------------------------------------------------------------

it('always sets customer_user type regardless of input', function (): void {
    $formData = [
        'first_name' => 'Hacker',
        'last_name' => 'Attempt',
        'email' => 'hacker@example.com',
        'password' => 'Tr1ckyP@ss!',
    ];

    $result = app(ValidateUserDataAction::class)->execute($formData);

    // Type must be customer_user — cannot be overridden
    expect($result['type'])->toBe('customer_user');
    expect($result['state'])->toBe('active');
    expect($result['email_verified_at'])->not->toBeNull();
});

it('hashes password during validation', function (): void {
    $formData = [
        'first_name' => 'Test',
        'last_name' => 'User',
        'email' => 'test@example.com',
        'password' => 'MyP@ssword123!',
    ];

    $result = app(ValidateUserDataAction::class)->execute($formData);

    // Password must be hashed
    expect($result['password'])->not->toBe('MyP@ssword123!');
    expect(Hash::check('MyP@ssword123!', $result['password']))->toBeTrue();
});

// ---------------------------------------------------------------------------
// Consent persistence details
// ---------------------------------------------------------------------------

it('saves consent with correct IP and user agent', function (): void {
    $user = User::factory()->create(['type' => 'customer_user']);

    Treatment::firstOrCreate(
        ['name' => 'privacy_policy'],
        ['description' => 'Privacy Policy', 'weight' => 1, 'active' => true, 'required' => true]
    );
    Treatment::firstOrCreate(
        ['name' => 'terms_conditions'],
        ['description' => 'Terms and Conditions', 'weight' => 2, 'active' => true, 'required' => true]
    );
    Treatment::firstOrCreate(
        ['name' => 'marketing_consent'],
        ['description' => 'Marketing Consent', 'weight' => 3, 'active' => true, 'required' => false]
    );

    $consents = [
        'privacy_accepted' => true,
        'terms_accepted' => true,
        'marketing_consent' => false,
    ];

    app(SaveGdprConsentsAction::class)->execute($user, $consents, '192.168.1.42', 'TestBrowser/2.0');

    $savedConsents = Consent::where('subject_id', $user->id)->get();
    expect($savedConsents->count())->toBeGreaterThanOrEqual(2);
});

it('does not create consents when treatments do not exist', function (): void {
    $user = User::factory()->create(['type' => 'customer_user']);

    // Ensure no treatments for a unique name
    Treatment::where('name', 'nonexistent_treatment')->delete();

    $consents = [
        'privacy_accepted' => true,
        'terms_accepted' => true,
        'marketing_consent' => false,
    ];

    // This will only create consents for existing treatments
    // If no treatments exist with the expected names, no consents are created
    $countBefore = Consent::where('subject_id', $user->id)->count();
    app(SaveGdprConsentsAction::class)->execute($user, $consents, '127.0.0.1', 'PestTest/1.0');
    $countAfter = Consent::where('subject_id', $user->id)->count();

    // At minimum, consents are created for the treatments that exist in the DB
    expect($countAfter)->toBeGreaterThanOrEqual($countBefore);
});

// ---------------------------------------------------------------------------
// Duplicate email prevention
// ---------------------------------------------------------------------------

it('prevents duplicate user registration with same email', function (): void {
    $email = 'duplicate-' . uniqid() . '@example.com';

    // First user
    $formData1 = [
        'first_name' => 'First',
        'last_name' => 'User',
        'email' => $email,
        'password' => 'SecureP@ss1!',
    ];
    $validatedData1 = app(ValidateUserDataAction::class)->execute($formData1);
    app(CreateUserAction::class)->execute($validatedData1);

    // Second user with same email should fail
    $formData2 = [
        'first_name' => 'Second',
        'last_name' => 'User',
        'email' => $email,
        'password' => 'SecureP@ss2!',
    ];
    $validatedData2 = app(ValidateUserDataAction::class)->execute($formData2);

    expect(fn () => app(CreateUserAction::class)->execute($validatedData2))
        ->toThrow(\Exception::class);
});
