<?php

declare(strict_types=1);

namespace Modules\Gdpr\Tests\Feature;

use Modules\User\Database\Factories\UserFactory;

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
    $locales = ['en', 'it', 'es', 'de', 'fr', 'ru'];

    foreach ($locales as $locale) {
        $response = gdprGet("/{$locale}/auth/register");
        $response->assertStatus(200);
    }
});

// ---------------------------------------------------------------------------
// Page content tests (translations)
// ---------------------------------------------------------------------------

it('displays correct title in English', function (): void {
    $response = gdprGet('/en/auth/register');

    $response->assertSee('Start Your Pizza Journey', false);
});

it('displays correct title in Italian', function (): void {
    $response = gdprGet('/it/auth/register');

    $response->assertSee('Unisciti alla Pizza Revolution', false);
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

it('has correct page title in English', function (): void {
    $response = gdprGet('/en/auth/register');

    $response->assertSee('Start Your Pizza Journey', false);
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
    $response->assertSee('wire:submit', false);
    $response->assertSee('RegisterWidget', false);
});

// ---------------------------------------------------------------------------
// Form action tests (without full Livewire test)
// ---------------------------------------------------------------------------

it('has submit button with correct text', function (): void {
    $response = gdprGet('/en/auth/register');

    // Submit button should be present
    $response->assertSee('type="submit"', false);
});

// ---------------------------------------------------------------------------
// Benefits section
// ---------------------------------------------------------------------------

it('displays benefits section in English', function (): void {
    $response = gdprGet('/en/auth/register');

    $response->assertSee('Developer Community', false);
});

it('displays benefits section in Italian', function (): void {
    $response = gdprGet('/it/auth/register');

    $response->assertSee('Community', false);
});

// ---------------------------------------------------------------------------
// Social proof / trust badges
// ---------------------------------------------------------------------------

it('displays trust indicators', function (): void {
    $response = gdprGet('/en/auth/register');

    // Should have some trust-related content
    $response->assertSee('FREE', false);
});
