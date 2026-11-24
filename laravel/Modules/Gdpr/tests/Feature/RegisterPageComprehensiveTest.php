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
    gdprSkipUnlessLocaleSupported('es');
    $response = gdprGet('/es/auth/register');
    $response->assertStatus(200);
});

it('returns 200 for German registration page', function (): void {
    gdprSkipUnlessLocaleSupported('de');
    $response = gdprGet('/de/auth/register');
    $response->assertStatus(200);
});

it('returns 200 for French registration page', function (): void {
    gdprSkipUnlessLocaleSupported('fr');
    $response = gdprGet('/fr/auth/register');
    $response->assertStatus(200);
});

it('returns 200 for Russian registration page', function (): void {
    gdprSkipUnlessLocaleSupported('ru');
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
// Page Content Tests: solo i testi del form, che il modulo possiede.
// Titolo, sottotitolo, vantaggi e "social proof" sono della pagina del tema ospite
// (Modules/Gdpr/docs/register-widget-copy-ownership.md).
// ---------------------------------------------------------------------------

it('displays the field labels of the registration form', function (string $locale): void {
    gdprSkipUnlessLocaleSupported($locale);
    app()->setLocale($locale);
    $response = gdprGet('/'.$locale.'/auth/register');
    $response->assertSee(__('gdpr::register.fields.first_name.label'));
    $response->assertSee(__('gdpr::register.fields.last_name.label'));
    $response->assertSee(__('gdpr::register.fields.email.label'));
    $response->assertSee(__('gdpr::register.fields.password.label'));
    $response->assertSee(__('gdpr::register.fields.password_confirmation.label'));
})->with(['en', 'it', 'de', 'es']);

it('displays the consent texts of the registration form', function (string $locale): void {
    gdprSkipUnlessLocaleSupported($locale);
    app()->setLocale($locale);
    $response = gdprGet('/'.$locale.'/auth/register');
    $response->assertSee(__('gdpr::register.consents.privacy_policy_label'));
    $response->assertSee(__('gdpr::register.consents.terms_label'));
    $response->assertSee(__('gdpr::register.consents.marketing_label'));
})->with(['en', 'it', 'de', 'es']);

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
    app()->setLocale('en');
    $response = gdprGet('/en/auth/register');
    $response->assertSee(__('gdpr::register.fields.first_name.label'));
    $response->assertSee(__('gdpr::register.fields.email.label'));
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
    $response->assertSee('wire:submit="submit"', false);
});

// ---------------------------------------------------------------------------
// Legal Document Links Tests
// Il link al login e' della pagina ospite; del widget sono i link a informativa e condizioni.
// ---------------------------------------------------------------------------

it('displays the links to privacy notice and terms', function (): void {
    app()->setLocale('en');
    $response = gdprGet('/en/auth/register');
    $response->assertSee(__('gdpr::register.consents.privacy_policy_link'));
    $response->assertSee(__('gdpr::register.consents.terms_link'));
});

it('displays the Italian links to privacy notice and terms', function (): void {
    app()->setLocale('it');
    $response = gdprGet('/it/auth/register');
    $response->assertSee(__('gdpr::register.consents.privacy_policy_link'));
    $response->assertSee(__('gdpr::register.consents.terms_link'));
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
    $response->assertSee('csrf-token', false);
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
        Assert::assertNotSame($key, $translated, "Translation key [{$key}] is missing");
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
        Assert::assertNotSame($key, $translated, "Italian translation key [{$key}] is missing");
    }
});

// ---------------------------------------------------------------------------
// Widget CanView Tests
// ---------------------------------------------------------------------------

it('widget is not visible to authenticated users', function (): void {
    $user = UserFactory::new()->createOne(['type' => 'customer_user']);

    gdprActingAs($user);
    $widget = new RegisterWidget;
    Assert::assertFalse($widget->canView());
});

it('widget is visible to guest users', function (): void {
    $widget = new RegisterWidget;
    Assert::assertTrue($widget->canView());
});
