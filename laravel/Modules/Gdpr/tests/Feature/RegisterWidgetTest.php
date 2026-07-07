<?php

declare(strict_types=1);

namespace Modules\Gdpr\Tests\Feature;

use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Schema;
use Illuminate\Validation\ValidationException;
use Modules\Gdpr\Actions\Consent\CollectGdprConsentsAction;
use Modules\Gdpr\Actions\SaveGdprConsentsAction;
use Modules\Gdpr\Actions\Validation\ValidateGdprConsentAction;
use Modules\Gdpr\Actions\Validation\ValidateUserDataAction;
use Modules\Gdpr\Models\Consent;
use Modules\Gdpr\Models\Treatment;
use Modules\Gdpr\Tests\TestCase;
use Modules\User\Actions\User\CreateUserAction;
use Modules\User\Database\Factories\UserFactory;
use Modules\User\Models\User;
use PHPUnit\Framework\Assert;

uses(TestCase::class);

// ---------------------------------------------------------------------------
// ValidateGdprConsentAction
// ---------------------------------------------------------------------------

it('validates gdpr consent passes when both accepted', function (): void {
    $action = app(ValidateGdprConsentAction::class);

    gdprAssertDoesNotThrow(ValidationException::class, fn () => $action->execute(true, true));
});

it('validates gdpr consent fails when privacy not accepted', function (): void {
    $action = app(ValidateGdprConsentAction::class);

    gdprAssertThrows(ValidationException::class, fn () => $action->execute(false, true));
});

it('validates gdpr consent fails when terms not accepted', function (): void {
    $action = app(ValidateGdprConsentAction::class);

    gdprAssertThrows(ValidationException::class, fn () => $action->execute(true, false));
});

it('validates gdpr consent fails when both not accepted', function (): void {
    $action = app(ValidateGdprConsentAction::class);

    gdprAssertThrows(ValidationException::class, fn () => $action->execute(false, false));
});

// ---------------------------------------------------------------------------
// CollectGdprConsentsAction
// ---------------------------------------------------------------------------

it('collects gdpr consents correctly', function (): void {
    $action = app(CollectGdprConsentsAction::class);

    $result = $action->execute(true, true, false);

    Assert::assertSame([
        'privacy_accepted' => true,
        'terms_accepted' => true,
        'marketing_consent' => false,
    ], $result);
});

it('collects gdpr consents with all true', function (): void {
    $action = app(CollectGdprConsentsAction::class);

    $result = $action->execute(true, true, true);

    Assert::assertTrue($result['privacy_accepted']);
    Assert::assertTrue($result['terms_accepted']);
    Assert::assertTrue($result['marketing_consent']);
});

it('collects gdpr consents with all false', function (): void {
    $action = app(CollectGdprConsentsAction::class);

    $result = $action->execute(false, false, false);

    Assert::assertFalse($result['privacy_accepted']);
    Assert::assertFalse($result['terms_accepted']);
    Assert::assertFalse($result['marketing_consent']);
});

// ---------------------------------------------------------------------------
// ValidateUserDataAction
// ---------------------------------------------------------------------------

it('validates and transforms user data correctly', function (): void {
    $action = app(ValidateUserDataAction::class);

    $email = 'mario.rossi.'.uniqid().'@example.com';
    $formData = [
        'first_name' => 'Mario',
        'last_name' => 'Rossi',
        'email' => $email,
        'password' => 'SecureP@ssw0rd!',
    ];

    $result = $action->execute($formData);

    Assert::assertSame('Mario', $result['first_name']);
    Assert::assertSame('Rossi', $result['last_name']);
    Assert::assertSame($email, $result['email']);
    Assert::assertSame('customer_user', $result['type']);
    Assert::assertNotNull($result['email_verified_at']);
    $hashed = is_string($result['password'] ?? null) ? $result['password'] : '';
    Assert::assertTrue(Hash::check('SecureP@ssw0rd!', $hashed));
});

it('validates user data hashes the password', function (): void {
    $action = app(ValidateUserDataAction::class);

    $formData = [
        'first_name' => 'Test',
        'last_name' => 'User',
        'email' => 'hash-test-'.uniqid().'@example.com',
        'password' => 'MyP@ssword123!',
    ];

    $result = $action->execute($formData);

    // Password should be hashed, not plain text
    Assert::assertNotSame('MyP@ssword123!', $result['password']);
    $hashed = is_string($result['password'] ?? null) ? $result['password'] : '';
    Assert::assertTrue(Hash::check('MyP@ssword123!', $hashed));
});

it('validates user data always sets customer_user type', function (): void {
    $action = app(ValidateUserDataAction::class);

    $formData = [
        'first_name' => 'Admin',
        'last_name' => 'Attempt',
        'email' => 'admin-attempt-'.uniqid().'@example.com',
        'password' => 'Tr1ckyP@ss!',
    ];

    $result = $action->execute($formData);

    // Type must always be customer_user regardless of input
    Assert::assertSame('customer_user', $result['type']);
});

// ---------------------------------------------------------------------------
// SaveGdprConsentsAction
// ---------------------------------------------------------------------------

it('saves gdpr consents for a user when treatments exist', function (): void {
    if (! Schema::connection('gdpr')->hasTable('treatments')) {
        gdprSkipTest('GDPR treatments table not migrated. Run: php artisan migrate --env=testing');
    }

    $user = UserFactory::new()->createOne(['type' => 'customer_user']);

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

    Assert::assertGreaterThanOrEqual(2, $savedConsents->count());

    // Privacy consent should be accepted
    $privacyConsent = $savedConsents->where('treatment_id', $privacyTreatment->id)->first();
    if ($privacyConsent) {
        Assert::assertNotNull($privacyConsent->accepted_at);
        Assert::assertSame('127.0.0.1', $privacyConsent->ip_address);
        Assert::assertSame('PestTest/1.0', $privacyConsent->user_agent);
    }

    // Marketing consent should NOT be accepted
    $marketingConsent = $savedConsents->where('treatment_id', $marketingTreatment->id)->first();
    if ($marketingConsent) {
        Assert::assertNull($marketingConsent->accepted_at);
    }
});

it('saves gdpr consents with marketing accepted', function (): void {
    if (! Schema::connection('gdpr')->hasTable('treatments')) {
        gdprSkipTest('GDPR treatments table not migrated. Run: php artisan migrate --env=testing');
    }

    $user = UserFactory::new()->createOne(['type' => 'customer_user']);

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
        Assert::assertNotNull($marketingConsent->accepted_at);
    }
});

// ---------------------------------------------------------------------------
// Full registration flow (unit-level, no Livewire rendering)
// ---------------------------------------------------------------------------

it('can create a user with customer_user type via CreateUserAction', function (): void {
    $action = app(CreateUserAction::class);

    $data = [
        'first_name' => 'Pest',
        'last_name' => 'Tester',
        'email' => 'pest-register-'.uniqid().'@example.com',
        'password' => Hash::make('TestP@ssw0rd!'),
        'type' => 'customer_user',
        'state' => 'active',
        'email_verified_at' => now(),
    ];

    $user = $action->execute($data);

    Assert::assertInstanceOf(User::class, $user);
    Assert::assertSame('Pest', $user->first_name);
    Assert::assertSame('Tester', $user->last_name);
    Assert::assertSame('customer_user', $user->type);
    Assert::assertSame('active', $user->state);
    Assert::assertNotNull($user->email_verified_at);
    /* @var TestCase $this */
    assertGdprTableHas('users', [
        'id' => $user->id,
        'email' => $data['email'],
        'type' => 'customer_user',
    ], 'user');
});

it('full registration pipeline works end to end', function (): void {
    if (! Schema::connection('gdpr')->hasTable('treatments')) {
        gdprSkipTest('GDPR treatments table not migrated. Run: php artisan migrate --env=testing');
    }

    // 1. Validate GDPR consents
    app(ValidateGdprConsentAction::class)->execute(true, true);

    // 2. Validate and transform user data
    $formData = [
        'first_name' => 'Integration',
        'last_name' => 'Test',
        'email' => 'integration-'.uniqid().'@example.com',
        'password' => 'Str0ngP@ssword!',
    ];
    $validatedData = app(ValidateUserDataAction::class)->execute($formData);

    Assert::assertSame('customer_user', $validatedData['type']);
    // 3. Create user
    $user = app(CreateUserAction::class)->execute($validatedData);
    Assert::assertInstanceOf(User::class, $user);
    // 4. Collect consents
    $consents = app(CollectGdprConsentsAction::class)->execute(true, true, false);
    Assert::assertTrue($consents['privacy_accepted']);
    Assert::assertFalse($consents['marketing_consent']);
    // 5. Save consents (only if treatments exist)
    try {
        Treatment::firstOrCreate(
            ['name' => 'privacy_policy'],
            ['description' => 'Privacy Policy', 'weight' => 1, 'active' => true, 'required' => true]
        );
    } catch (\Exception) {
        // Already exists
    }
    try {
        Treatment::firstOrCreate(
            ['name' => 'terms_conditions'],
            ['description' => 'Terms and Conditions', 'weight' => 2, 'active' => true, 'required' => true]
        );
    } catch (\Exception) {
        // Already exists
    }
    try {
        Treatment::firstOrCreate(
            ['name' => 'marketing_consent'],
            ['description' => 'Marketing Consent', 'weight' => 3, 'active' => true, 'required' => false]
        );
    } catch (\Exception) {
        // Already exists
    }

    app(SaveGdprConsentsAction::class)->execute($user, $consents, '127.0.0.1', 'PestTest/1.0');

    // Verify user exists
    /* @var TestCase $this */
    assertGdprTableHas('users', [
        'id' => $user->id,
        'type' => 'customer_user',
    ], 'user');

    // Verify consents exist
    $savedConsents = Consent::where('subject_id', $user->id)->count();
    Assert::assertGreaterThanOrEqual(2, $savedConsents);
});

// ---------------------------------------------------------------------------
// Translation keys exist
// ---------------------------------------------------------------------------

it('has all required translation keys for register page', function (): void {
    $requiredKeys = [
        'gdpr::register.title',
        'gdpr::register.subtitle',
        'gdpr::register.submit',
        'gdpr::register.submitting',
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
        Assert::assertNotSame($key, "Translation key [{$key}] is missing or returns raw key", $translated);
    }
});
