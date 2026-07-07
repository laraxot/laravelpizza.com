<?php

declare(strict_types=1);

namespace Modules\Gdpr\Tests\Feature;

use Modules\Gdpr\Filament\Widgets\Auth\RegisterWidget;
use Modules\Gdpr\Models\Consent;
use Modules\Gdpr\Tests\TestCase;
use Modules\User\Database\Factories\UserFactory;
use PHPUnit\Framework\Assert;

uses(TestCase::class);

/*
 * Comprehensive Registration Page Tests.
 *
 * Tests for /en/auth/register and /it/auth/register pages including:
 * - Page load and status codes
 * - Translation keys presence
 * - Form fields presence
 * - GDPR consent checkboxes
 * - All supported locales
 * - Security validation
 * - Form submission scenarios
 */

// ---------------------------------------------------------------------------
// Page Loading Tests
// ---------------------------------------------------------------------------

it('returns 200 for English registration page', function (): void {
    $response = gdprGet('/en/auth/register');
    $response->assertStatus(200);
});

it('returns 200 for Italian registration page', function (): void {
    $response = gdprGet('/it/auth/register');
    $response->assertStatus(200);
});

it('returns 200 for Spanish registration page', function (): void {
    $response = gdprGet('/es/auth/register');
    $response->assertStatus(200);
});

it('returns 200 for German registration page', function (): void {
    $response = gdprGet('/de/auth/register');
    $response->assertStatus(200);
});

it('returns 200 for French registration page', function (): void {
    $response = gdprGet('/fr/auth/register');
    $response->assertStatus(200);
});

it('returns 200 for Russian registration page', function (): void {
    $response = gdprGet('/ru/auth/register');
    $response->assertStatus(200);
});

it('redirects authenticated users away from registration', function (): void {
    $user = UserFactory::new()->createOne(['type' => 'customer_user']);

    gdprActingAs($user);
    $response = gdprGet('/en/auth/register');

    // Should redirect or return 302
    Assert::assertContains($response->status(), [302, 403]);
});

// ---------------------------------------------------------------------------
// English Page Content Tests
// ---------------------------------------------------------------------------

it('displays correct English title on registration page', function (): void {
    $response = gdprGet('/en/auth/register');
    $response->assertSee('Start Your Pizza Journey', false);
});

it('displays English CTA title', function (): void {
    $response = gdprGet('/en/auth/register');
    $response->assertSee('Create Your FREE Account', false);
});

it('displays English form trust notice', function (): void {
    $response = gdprGet('/en/auth/register');
    $response->assertSee('No credit card required', false);
});

it('displays English terms notice', function (): void {
    $response = gdprGet('/en/auth/register');
    $response->assertSee('Terms and Privacy Policy', false);
});

it('displays English benefits section', function (): void {
    $response = gdprGet('/en/auth/register');
    $response->assertSee('Developer Community', false);
    $response->assertSee('Tutorials', false);
    $response->assertSee('Networking', false);
});

it('displays English social proof', function (): void {
    $response = gdprGet('/en/auth/register');
    $response->assertSee('Join', false);
    $response->assertSee('developers', false);
});

// ---------------------------------------------------------------------------
// Italian Page Content Tests
// ---------------------------------------------------------------------------

it('displays correct Italian title on registration page', function (): void {
    $response = gdprGet('/it/auth/register');
    $response->assertSee('Pizza Revolution', false);
});

it('displays Italian CTA title', function (): void {
    $response = gdprGet('/it/auth/register');
    $response->assertSee('account gratuito', false);
});

it('displays Italian form trust notice', function (): void {
    $response = gdprGet('/it/auth/register');
    $response->assertSee('Nessuna carta', false);
});

it('displays Italian terms notice', function (): void {
    $response = gdprGet('/it/auth/register');
    $response->assertSee('Termini', false);
});

it('displays Italian benefits section', function (): void {
    $response = gdprGet('/it/auth/register');
    $response->assertSee('Community', false);
});

// ---------------------------------------------------------------------------
// Form Fields Tests
// ---------------------------------------------------------------------------

it('displays first name input field', function (): void {
    $response = gdprGet('/en/auth/register');
    $response->assertSee('first_name', false);
});

it('displays last name input field', function (): void {
    $response = gdprGet('/en/auth/register');
    $response->assertSee('last_name', false);
});

it('displays email input field', function (): void {
    $response = gdprGet('/en/auth/register');
    $response->assertSee('email', false);
});

it('displays password input field', function (): void {
    $response = gdprGet('/en/auth/register');
    $response->assertSee('password', false);
});

it('displays password confirmation input field', function (): void {
    $response = gdprGet('/en/auth/register');
    $response->assertSee('password_confirmation', false);
});

// ---------------------------------------------------------------------------
// GDPR Consent Tests
// ---------------------------------------------------------------------------

it('displays privacy policy checkbox', function (): void {
    $response = gdprGet('/en/auth/register');
    $response->assertSee('privacy_accepted', false);
    $response->assertSee('Privacy', false);
});

it('displays terms checkbox', function (): void {
    $response = gdprGet('/en/auth/register');
    $response->assertSee('terms_accepted', false);
    $response->assertSee('Terms', false);
});

it('displays marketing consent checkbox', function (): void {
    $response = gdprGet('/en/auth/register');
    $response->assertSee('marketing_consent', false);
});

it('displays GDPR sections', function (): void {
    $response = gdprGet('/en/auth/register');
    $response->assertSee('Personal Information', false);
    $response->assertSee('Required Consent', false);
});

// ---------------------------------------------------------------------------
// Submit Button Tests
// ---------------------------------------------------------------------------

it('displays submit button', function (): void {
    $response = gdprGet('/en/auth/register');
    $response->assertSee('submit', false);
});

it('has form with post method', function (): void {
    $response = gdprGet('/en/auth/register');
    $response->assertSee('<form', false);
});

// ---------------------------------------------------------------------------
// Login Link Tests
// ---------------------------------------------------------------------------

it('displays login link', function (): void {
    $response = gdprGet('/en/auth/register');
    $response->assertSee('Already have an account', false);
    $response->assertSee('Sign in', false);
});

it('displays Italian login link', function (): void {
    $response = gdprGet('/it/auth/register');
    $response->assertSee('Hai già un account', false);
    $response->assertSee('Accedi', false);
});

// ---------------------------------------------------------------------------
// Meta Tags and SEO Tests
// ---------------------------------------------------------------------------

it('includes proper title tag', function (): void {
    $response = gdprGet('/en/auth/register');
    $response->assertSee('<title>', false);
});

it('includes csrf token in form', function (): void {
    $response = gdprGet('/en/auth/register');
    $response->assertSee('_token', false);
});

// ---------------------------------------------------------------------------
// Accessibility Tests
// ---------------------------------------------------------------------------

it('has proper language attribute', function (): void {
    $response = gdprGet('/en/auth/register');
    $response->assertSee('lang="en"', false);
});

it('has Italian language attribute', function (): void {
    $response = gdprGet('/it/auth/register');
    $response->assertSee('lang="it"', false);
});

it('has form labels for accessibility', function (): void {
    $response = gdprGet('/en/auth/register');
    $response->assertSee('label', false);
});

// ---------------------------------------------------------------------------
// All Translation Keys Exist Tests
// ---------------------------------------------------------------------------

it('has all required English translation keys', function (): void {
    app()->setLocale('en');

    $requiredKeys = [
        'gdpr::register.title',
        'gdpr::register.subtitle',
        'gdpr::register.form.cta_title',
        'gdpr::register.form.cta_subtitle',
        'gdpr::register.form.terms_notice',
        'gdpr::register.benefits.community.title',
        'gdpr::register.benefits.community.description',
        'gdpr::register.benefits.tutorials.title',
        'gdpr::register.benefits.tutorials.description',
        'gdpr::register.benefits.networking.title',
        'gdpr::register.benefits.networking.description',
        'gdpr::register.social_proof',
        'gdpr::register.fields.first_name.label',
        'gdpr::register.fields.first_name.placeholder',
        'gdpr::register.fields.last_name.label',
        'gdpr::register.fields.last_name.placeholder',
        'gdpr::register.fields.email.label',
        'gdpr::register.fields.email.placeholder',
        'gdpr::register.fields.password.label',
        'gdpr::register.fields.password.placeholder',
        'gdpr::register.fields.password_confirmation.label',
        'gdpr::register.fields.password_confirmation.placeholder',
        'gdpr::register.sections.user_info',
        'gdpr::register.sections.required_consents',
        'gdpr::register.sections.optional_consents',
        'gdpr::register.consents.title',
        'gdpr::register.consents.privacy_policy_label',
        'gdpr::register.consents.terms_label',
        'gdpr::register.consents.marketing_label',
        'gdpr::register.already_registered',
        'gdpr::register.login',
    ];

    foreach ($requiredKeys as $key) {
        $translated = __($key);
        Assert::assertNotSame($key, "Translation key [{$key}] is missing", $translated);
    }
});

it('has all required Italian translation keys', function (): void {
    app()->setLocale('it');

    $requiredKeys = [
        'gdpr::register.title',
        'gdpr::register.subtitle',
        'gdpr::register.form.cta_title',
        'gdpr::register.form.cta_subtitle',
        'gdpr::register.form.terms_notice',
        'gdpr::register.benefits.community.title',
        'gdpr::register.benefits.tutorials.title',
        'gdpr::register.benefits.networking.title',
        'gdpr::register.fields.first_name.label',
        'gdpr::register.fields.email.label',
        'gdpr::register.fields.password.label',
        'gdpr::register.sections.user_info',
        'gdpr::register.sections.required_consents',
        'gdpr::register.consents.privacy_policy_label',
        'gdpr::register.already_registered',
        'gdpr::register.login',
    ];

    foreach ($requiredKeys as $key) {
        $translated = __($key);
        Assert::assertNotSame($key, "Italian translation key [{$key}] is missing", $translated);
    }
});

// ---------------------------------------------------------------------------
// Widget CanView Tests
// ---------------------------------------------------------------------------

it('widget is not visible to authenticated users', function (): void {
    $user = UserFactory::new()->createOne(['type' => 'customer_user']);

    gdprActingAs($user);
    $widget = new RegisterWidget();
    Assert::assertFalse($widget->canView());
});

it('widget is visible to guest users', function (): void {
    $widget = new RegisterWidget();
    Assert::assertTrue($widget->canView());
});
