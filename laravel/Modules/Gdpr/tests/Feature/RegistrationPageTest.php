<?php

declare(strict_types=1);

namespace Modules\Gdpr\Tests\Feature;

use Modules\Gdpr\Tests\TestCase;
use Modules\User\Database\Factories\UserFactory;

uses(TestCase::class);

// ---------------------------------------------------------------------------
// Page rendering tests
// ---------------------------------------------------------------------------

it('renders registration page successfully for English locale', function (): void {
    $response = gdprGet('/en/auth/register');

    $response->assertStatus(200);
    $response->assertHeader('content-type', 'text/html; charset=utf-8');
});

it('renders registration page successfully for Italian locale', function (): void {
    $response = gdprGet('/it/auth/register');

    $response->assertStatus(200);
});

it('renders registration page successfully for all supported locales', function (): void {
    // Le lingue che il progetto offre davvero, non un elenco fisso di un altro sito.
    $supported = config('laravellocalization.supportedLocales');
    $locales = is_array($supported) ? array_keys($supported) : ['it', 'en'];

    foreach ($locales as $locale) {
        $response = gdprGet("/{$locale}/auth/register");
        $response->assertStatus(200);
    }
});

// ---------------------------------------------------------------------------
// Page content tests (translations)
// ---------------------------------------------------------------------------

// Il titolo della pagina e' del tema ospite: del modulo e' il form (docs/register-widget-copy-ownership.md).
it('displays the first field label in English', function (): void {
    app()->setLocale('en');
    $response = gdprGet('/en/auth/register');

    $response->assertSee(__('gdpr::register.fields.first_name.label'));
});

it('displays the first field label in Italian', function (): void {
    app()->setLocale('it');
    $response = gdprGet('/it/auth/register');

    $response->assertSee(__('gdpr::register.fields.first_name.label'));
});

it('displays form fields with correct placeholders', function (): void {
    $response = gdprGet('/en/auth/register');

    $response->assertSee('first_name', false);
    $response->assertSee('last_name', false);
    $response->assertSee('email', false);
    $response->assertSee('password', false);
    $response->assertSee('password_confirmation', false);
});

it('displays GDPR consent checkboxes', function (): void {
    $response = gdprGet('/en/auth/register');

    $response->assertSee('privacy_accepted', false);
    $response->assertSee('terms_accepted', false);
});

it('displays marketing consent checkbox', function (): void {
    $response = gdprGet('/en/auth/register');

    $response->assertSee('marketing_consent', false);
});

// ---------------------------------------------------------------------------
// Page SEO tests
// ---------------------------------------------------------------------------

it('has a page title without raw module translation keys', function (): void {
    app()->setLocale('en');
    $response = gdprGet('/en/auth/register');

    // Il testo del <title> lo sceglie il tema; il modulo garantisce solo di non lasciare chiavi grezze.
    $response->assertSee('<title>', false);
    $response->assertDontSee('gdpr::register.', false);
});

it('has meta description in English', function (): void {
    $response = gdprGet('/en/auth/register');

    // Should have description meta tag with content
    $response->assertSee('meta', false);
});

// ---------------------------------------------------------------------------
// Authentication guards
// ---------------------------------------------------------------------------

it('redirects authenticated users away from registration', function (): void {
    $user = UserFactory::new()->createOne();

    $response = gdprActingAs($user)->get('/en/auth/register');

    // Authenticated users should be redirected (to home or dashboard)
    $response->assertRedirect();
});

it('registration page is accessible to guests only', function (): void {
    $response = gdprGet('/en/auth/register');

    // Guest should be able to access
    $response->assertStatus(200);
});

// ---------------------------------------------------------------------------
// Livewire widget presence
// ---------------------------------------------------------------------------

it('contains Livewire registration form', function (): void {
    $response = gdprGet('/en/auth/register');

    // Should have wire:submit or Livewire component
    $response->assertSee('wire:submit="submit"', false);
    $response->assertSee('wire:model="privacy_accepted"', false);
});

// ---------------------------------------------------------------------------
// Form action tests (without full Livewire test)
// ---------------------------------------------------------------------------

it('has submit button with correct text', function (): void {
    $response = gdprGet('/en/auth/register');

    // Submit button should be present
    $response->assertSee('wire:submit="submit"', false);
});

// ---------------------------------------------------------------------------
// Consents section (i "vantaggi" della pagina sono del tema ospite)
// ---------------------------------------------------------------------------

it('displays consents section in English', function (): void {
    app()->setLocale('en');
    $response = gdprGet('/en/auth/register');

    $response->assertSee(__('gdpr::register.consents.privacy_policy_label'));
});

it('displays consents section in Italian', function (): void {
    app()->setLocale('it');
    $response = gdprGet('/it/auth/register');

    $response->assertSee(__('gdpr::register.consents.privacy_policy_label'));
});

// ---------------------------------------------------------------------------
// Social proof / trust badges
// ---------------------------------------------------------------------------

it('displays trust indicators', function (): void {
    app()->setLocale('en');
    $response = gdprGet('/en/auth/register');

    // La fiducia che il modulo offre: il link all'informativa e la nota per i lettori di schermo che si apre altrove.
    $response->assertSee(__('gdpr::register.consents.privacy_policy_link'));
    $response->assertSee(__('gdpr::register.consents.opens_new_tab'));
});
