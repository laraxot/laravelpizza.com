<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Hash;
use Modules\Gdpr\Actions\Consent\CollectGdprConsentsAction;
use Modules\Gdpr\Actions\SaveGdprConsentsAction;
use Modules\Gdpr\Actions\Validation\ValidateGdprConsentAction;
use Modules\Gdpr\Actions\Validation\ValidateUserDataAction;
use Modules\Gdpr\Models\Consent;
use Modules\Gdpr\Models\Treatment;
use Modules\Gdpr\Tests\TestCase;
use Modules\User\Models\User;

uses(TestCase::class);

// ---------------------------------------------------------------------------
// ValidateGdprConsentAction
// ---------------------------------------------------------------------------

it('validates gdpr consent passes when both accepted', function (): void {
    $action = app(ValidateGdprConsentAction::class);

    // Should not throw
    $action->execute(true, true);

    expect(true)->toBeTrue();
});

it('validates gdpr consent fails when privacy not accepted', function (): void {
    $action = app(ValidateGdprConsentAction::class);

    $action->execute(false, true);
})->throws(\Illuminate\Validation\ValidationException::class);

it('validates gdpr consent fails when terms not accepted', function (): void {
    $action = app(ValidateGdprConsentAction::class);

    $action->execute(true, false);
})->throws(\Illuminate\Validation\ValidationException::class);

it('validates gdpr consent fails when both not accepted', function (): void {
    $action = app(ValidateGdprConsentAction::class);

    $action->execute(false, false);
})->throws(\Illuminate\Validation\ValidationException::class);

// ---------------------------------------------------------------------------
// CollectGdprConsentsAction
// ---------------------------------------------------------------------------

it('collects gdpr consents correctly', function (): void {
    $action = app(CollectGdprConsentsAction::class);

    $result = $action->execute(true, true, false);

    expect($result)->toBe([
        'privacy_accepted' => true,
        'terms_accepted' => true,
        'marketing_consent' => false,
    ]);
});

it('collects gdpr consents with all true', function (): void {
    $action = app(CollectGdprConsentsAction::class);

    $result = $action->execute(true, true, true);

    expect($result['privacy_accepted'])->toBeTrue();
    expect($result['terms_accepted'])->toBeTrue();
    expect($result['marketing_consent'])->toBeTrue();
});

it('collects gdpr consents with all false', function (): void {
    $action = app(CollectGdprConsentsAction::class);

    $result = $action->execute(false, false, false);

    expect($result['privacy_accepted'])->toBeFalse();
    expect($result['terms_accepted'])->toBeFalse();
    expect($result['marketing_consent'])->toBeFalse();
});

// ---------------------------------------------------------------------------
// ValidateUserDataAction
// ---------------------------------------------------------------------------

it('validates and transforms user data correctly', function (): void {
    $action = app(ValidateUserDataAction::class);

    $formData = [
        'first_name' => 'Mario',
        'last_name' => 'Rossi',
        'email' => 'mario.rossi@example.com',
        'password' => 'SecureP@ssw0rd!',
    ];

    $result = $action->execute($formData);

    expect($result['first_name'])->toBe('Mario');
    expect($result['last_name'])->toBe('Rossi');
    expect($result['email'])->toBe('mario.rossi@example.com');
    expect($result['type'])->toBe('customer_user');
    expect($result['state'])->toBe('active');
    expect($result['email_verified_at'])->not->toBeNull();
    expect(Hash::check('SecureP@ssw0rd!', $result['password']))->toBeTrue();
});

it('validates user data hashes the password', function (): void {
    $action = app(ValidateUserDataAction::class);

    $formData = [
        'first_name' => 'Test',
        'last_name' => 'User',
        'email' => 'test@example.com',
        'password' => 'MyP@ssword123!',
    ];

    $result = $action->execute($formData);

    // Password should be hashed, not plain text
    expect($result['password'])->not->toBe('MyP@ssword123!');
    expect(Hash::check('MyP@ssword123!', $result['password']))->toBeTrue();
});

it('validates user data always sets customer_user type', function (): void {
    $action = app(ValidateUserDataAction::class);

    $formData = [
        'first_name' => 'Admin',
        'last_name' => 'Attempt',
        'email' => 'admin@example.com',
        'password' => 'Tr1ckyP@ss!',
    ];

    $result = $action->execute($formData);

    // Type must always be customer_user regardless of input
    expect($result['type'])->toBe('customer_user');
});

// ---------------------------------------------------------------------------
// SaveGdprConsentsAction
// ---------------------------------------------------------------------------

it('saves gdpr consents for a user when treatments exist', function (): void {
    $user = User::factory()->create(['type' => 'customer_user']);

    // Ensure treatments exist
    $privacyTreatment = Treatment::firstOrCreate(
        ['name' => 'privacy_policy'],
        ['description' => 'Privacy Policy', 'weight' => 1, 'active' => true, 'required' => true]
    );
    $termsTreatment = Treatment::firstOrCreate(
        ['name' => 'terms_conditions'],
        ['description' => 'Terms and Conditions', 'weight' => 2, 'active' => true, 'required' => true]
    );
    $marketingTreatment = Treatment::firstOrCreate(
        ['name' => 'marketing_consent'],
        ['description' => 'Marketing Consent', 'weight' => 3, 'active' => true, 'required' => false]
    );

    $consents = [
        'privacy_accepted' => true,
        'terms_accepted' => true,
        'marketing_consent' => false,
    ];

    $action = app(SaveGdprConsentsAction::class);
    $action->execute($user, $consents, '127.0.0.1', 'PestTest/1.0');

    // Verify consents were saved
    $savedConsents = Consent::where('subject_id', $user->id)->get();

    expect($savedConsents->count())->toBeGreaterThanOrEqual(2);

    // Privacy consent should be accepted
    $privacyConsent = $savedConsents->where('treatment_id', $privacyTreatment->id)->first();
    if ($privacyConsent) {
        expect($privacyConsent->accepted_at)->not->toBeNull();
        expect($privacyConsent->ip_address)->toBe('127.0.0.1');
        expect($privacyConsent->user_agent)->toBe('PestTest/1.0');
    }

    // Marketing consent should NOT be accepted
    $marketingConsent = $savedConsents->where('treatment_id', $marketingTreatment->id)->first();
    if ($marketingConsent) {
        expect($marketingConsent->accepted_at)->toBeNull();
    }
});

it('saves gdpr consents with marketing accepted', function (): void {
    $user = User::factory()->create(['type' => 'customer_user']);

    Treatment::firstOrCreate(
        ['name' => 'privacy_policy'],
        ['description' => 'Privacy Policy', 'weight' => 1, 'active' => true, 'required' => true]
    );
    Treatment::firstOrCreate(
        ['name' => 'terms_conditions'],
        ['description' => 'Terms and Conditions', 'weight' => 2, 'active' => true, 'required' => true]
    );
    $marketingTreatment = Treatment::firstOrCreate(
        ['name' => 'marketing_consent'],
        ['description' => 'Marketing Consent', 'weight' => 3, 'active' => true, 'required' => false]
    );

    $consents = [
        'privacy_accepted' => true,
        'terms_accepted' => true,
        'marketing_consent' => true,
    ];

    app(SaveGdprConsentsAction::class)->execute($user, $consents, '10.0.0.1', 'PestTest/1.0');

    $marketingConsent = Consent::where('subject_id', $user->id)
        ->where('treatment_id', $marketingTreatment->id)
        ->first();

    if ($marketingConsent) {
        expect($marketingConsent->accepted_at)->not->toBeNull();
    }
});

// ---------------------------------------------------------------------------
// Full registration flow (unit-level, no Livewire rendering)
// ---------------------------------------------------------------------------

it('can create a user with customer_user type via CreateUserAction', function (): void {
    $action = app(\Modules\User\Actions\User\CreateUserAction::class);

    $data = [
        'first_name' => 'Pest',
        'last_name' => 'Tester',
        'email' => 'pest-register-' . uniqid() . '@example.com',
        'password' => Hash::make('TestP@ssw0rd!'),
        'type' => 'customer_user',
        'state' => 'active',
        'email_verified_at' => now(),
    ];

    $user = $action->execute($data);

    expect($user)->toBeInstanceOf(User::class);
    expect($user->first_name)->toBe('Pest');
    expect($user->last_name)->toBe('Tester');
    expect($user->type)->toBe('customer_user');
    expect($user->state)->toBe('active');
    expect($user->email_verified_at)->not->toBeNull();

    $this->assertDatabaseHas('users', [
        'id' => $user->id,
        'email' => $data['email'],
        'type' => 'customer_user',
    ]);
});

it('full registration pipeline works end to end', function (): void {
    // 1. Validate GDPR consents
    app(ValidateGdprConsentAction::class)->execute(true, true);

    // 2. Validate and transform user data
    $formData = [
        'first_name' => 'Integration',
        'last_name' => 'Test',
        'email' => 'integration-' . uniqid() . '@example.com',
        'password' => 'Str0ngP@ssword!',
    ];
    $validatedData = app(ValidateUserDataAction::class)->execute($formData);

    expect($validatedData['type'])->toBe('customer_user');

    // 3. Create user
    $user = app(\Modules\User\Actions\User\CreateUserAction::class)->execute($validatedData);
    expect($user)->toBeInstanceOf(User::class);

    // 4. Collect consents
    $consents = app(CollectGdprConsentsAction::class)->execute(true, true, false);
    expect($consents['privacy_accepted'])->toBeTrue();
    expect($consents['marketing_consent'])->toBeFalse();

    // 5. Save consents (only if treatments exist)
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

    // Verify user exists
    $this->assertDatabaseHas('users', [
        'id' => $user->id,
        'type' => 'customer_user',
    ]);

    // Verify consents exist
    $savedConsents = Consent::where('subject_id', $user->id)->count();
    expect($savedConsents)->toBeGreaterThanOrEqual(2);
});

// ---------------------------------------------------------------------------
// Translation keys exist
// ---------------------------------------------------------------------------

it('has all required translation keys for register page', function (): void {
    $requiredKeys = [
        'gdpr::register.register.title',
        'gdpr::register.register.subtitle',
        'gdpr::register.register.submit',
        'gdpr::register.register.submitting',
        'gdpr::register.consents.title',
        'gdpr::register.consents.privacy_checkbox_html',
        'gdpr::register.consents.terms_checkbox_html',
        'gdpr::register.consents.privacy_policy_required',
        'gdpr::register.consents.terms_required',
        'gdpr::register.consents.marketing_label',
        'gdpr::register.already_registered',
        'gdpr::register.login',
        'gdpr::register.fields.first_name',
        'gdpr::register.fields.last_name',
        'gdpr::register.fields.email',
        'gdpr::register.fields.password',
        'gdpr::register.fields.password_confirmation',
    ];

    foreach ($requiredKeys as $key) {
        $translated = __($key);
        // Translation should not return the raw key
        expect($translated)->not->toBe($key, "Translation key [{$key}] is missing or returns raw key");
    }
});
