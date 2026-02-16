<?php

declare(strict_types=1);

/**
 * Localization Tests for Registration Page.
 *
 * Tests that all supported locales have complete translations:
 * - Italian (it) - Primary
 * - English (en) - International
 * - Spanish (es) - LATAM
 * - German (de) - Germany/EU
 * - French (fr) - France/EU
 * - Russian (ru) - CIS/Eastern Europe
 */

use Modules\Gdpr\Tests\TestCase;

uses(TestCase::class);

// ---------------------------------------------------------------------------
// All Locales Have Required Keys
// ---------------------------------------------------------------------------

it('has all required keys in Italian locale', function (): void {
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
        'gdpr::register.social_proof',
        'gdpr::register.fields.first_name.label',
        'gdpr::register.fields.last_name.label',
        'gdpr::register.fields.email.label',
        'gdpr::register.fields.password.label',
        'gdpr::register.fields.password_confirmation.label',
        'gdpr::register.sections.user_info',
        'gdpr::register.sections.required_consents',
        'gdpr::register.sections.optional_consents',
        'gdpr::register.consents.privacy_policy_label',
        'gdpr::register.consents.terms_label',
        'gdpr::register.consents.marketing_label',
        'gdpr::register.already_registered',
        'gdpr::register.login',
    ];

    foreach ($requiredKeys as $key) {
        $translated = __($key);
        expect($translated)->not->toBe($key, "Italian translation [{$key}] missing");
    }
});

it('has all required keys in English locale', function (): void {
    app()->setLocale('en');

    $requiredKeys = [
        'gdpr::register.title',
        'gdpr::register.subtitle',
        'gdpr::register.form.cta_title',
        'gdpr::register.form.cta_subtitle',
        'gdpr::register.form.terms_notice',
        'gdpr::register.benefits.community.title',
        'gdpr::register.benefits.tutorials.title',
        'gdpr::register.benefits.networking.title',
        'gdpr::register.social_proof',
        'gdpr::register.fields.first_name.label',
        'gdpr::register.fields.last_name.label',
        'gdpr::register.fields.email.label',
        'gdpr::register.fields.password.label',
        'gdpr::register.fields.password_confirmation.label',
        'gdpr::register.sections.user_info',
        'gdpr::register.sections.required_consents',
        'gdpr::register.sections.optional_consents',
        'gdpr::register.consents.privacy_policy_label',
        'gdpr::register.consents.terms_label',
        'gdpr::register.consents.marketing_label',
        'gdpr::register.already_registered',
        'gdpr::register.login',
    ];

    foreach ($requiredKeys as $key) {
        $translated = __($key);
        expect($translated)->not->toBe($key, "English translation [{$key}] missing");
    }
});

it('has all required keys in Spanish locale', function (): void {
    app()->setLocale('es');

    $requiredKeys = [
        'gdpr::register.title',
        'gdpr::register.subtitle',
        'gdpr::register.form.cta_title',
        'gdpr::register.form.cta_subtitle',
        'gdpr::register.benefits.community.title',
        'gdpr::register.benefits.tutorials.title',
        'gdpr::register.benefits.networking.title',
        'gdpr::register.already_registered',
        'gdpr::register.login',
    ];

    foreach ($requiredKeys as $key) {
        $translated = __($key);
        expect($translated)->not->toBe($key, "Spanish translation [{$key}] missing");
    }
});

it('has all required keys in German locale', function (): void {
    app()->setLocale('de');

    $requiredKeys = [
        'gdpr::register.title',
        'gdpr::register.subtitle',
        'gdpr::register.form.cta_title',
        'gdpr::register.form.cta_subtitle',
        'gdpr::register.benefits.community.title',
        'gdpr::register.benefits.tutorials.title',
        'gdpr::register.benefits.networking.title',
        'gdpr::register.already_registered',
        'gdpr::register.login',
    ];

    foreach ($requiredKeys as $key) {
        $translated = __($key);
        expect($translated)->not->toBe($key, "German translation [{$key}] missing");
    }
});

it('has all required keys in French locale', function (): void {
    app()->setLocale('fr');

    $requiredKeys = [
        'gdpr::register.title',
        'gdpr::register.subtitle',
        'gdpr::register.form.cta_title',
        'gdpr::register.form.cta_subtitle',
        'gdpr::register.benefits.community.title',
        'gdpr::register.benefits.tutorials.title',
        'gdpr::register.benefits.networking.title',
        'gdpr::register.already_registered',
        'gdpr::register.login',
    ];

    foreach ($requiredKeys as $key) {
        $translated = __($key);
        expect($translated)->not->toBe($key, "French translation [{$key}] missing");
    }
});

it('has all required keys in Russian locale', function (): void {
    app()->setLocale('ru');

    $requiredKeys = [
        'gdpr::register.title',
        'gdpr::register.subtitle',
        'gdpr::register.form.cta_title',
        'gdpr::register.form.cta_subtitle',
        'gdpr::register.benefits.community.title',
        'gdpr::register.benefits.tutorials.title',
        'gdpr::register.benefits.networking.title',
        'gdpr::register.already_registered',
        'gdpr::register.login',
    ];

    foreach ($requiredKeys as $key) {
        $translated = __($key);
        expect($translated)->not->toBe($key, "Russian translation [{$key}] missing");
    }
});

// ---------------------------------------------------------------------------
// Locale Detection Tests
// ---------------------------------------------------------------------------

it('detects Italian locale from URL', function (): void {
    $response = $this->get('/it/auth/register');
    $response->assertSee('lang="it"', false);
    $response->assertStatus(200);
});

it('detects English locale from URL', function (): void {
    $response = $this->get('/en/auth/register');
    $response->assertSee('lang="en"', false);
    $response->assertStatus(200);
});

it('detects Spanish locale from URL', function (): void {
    $response = $this->get('/es/auth/register');
    $response->assertSee('lang="es"', false);
    $response->assertStatus(200);
});

it('detects German locale from URL', function (): void {
    $response = $this->get('/de/auth/register');
    $response->assertSee('lang="de"', false);
    $response->assertStatus(200);
});

it('detects French locale from URL', function (): void {
    $response = $this->get('/fr/auth/register');
    $response->assertSee('lang="fr"', false);
    $response->assertStatus(200);
});

it('detects Russian locale from URL', function (): void {
    $response = $this->get('/ru/auth/register');
    $response->assertSee('lang="ru"', false);
    $response->assertStatus(200);
});

// ---------------------------------------------------------------------------
// Translation Content Tests
// ---------------------------------------------------------------------------

it('Italian title contains pizza reference', function (): void {
    app()->setLocale('it');
    $title = __('gdpr::register.title');
    expect($title)->toContain('Pizza');
});

it('English title contains pizza reference', function (): void {
    app()->setLocale('en');
    $title = __('gdpr::register.title');
    expect($title)->toContain('Pizza');
});

it('Italian CTA is action-oriented', function (): void {
    app()->setLocale('it');
    $cta = __('gdpr::register.form.cta_title');
    expect($cta)->toContain('gratuito');
});

it('English CTA is action-oriented', function (): void {
    app()->setLocale('en');
    $cta = __('gdpr::register.form.cta_title');
    expect($cta)->toContain('FREE');
});
