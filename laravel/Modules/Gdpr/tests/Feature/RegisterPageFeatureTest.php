<?php

declare(strict_types=1);

use Modules\Gdpr\Tests\TestCase;

uses(TestCase::class);

it('renders the English register page with hero and form texts', function (): void {
    $response = $this->get('/en/auth/register');

    $response->assertStatus(200);
    $response->assertSee(__('gdpr::register.title'), false);
    $response->assertSee(__('gdpr::register.subtitle'), false);
    $response->assertSee(__('gdpr::register.form.cta_title'), false);
    $response->assertSee(__('gdpr::register.form.cta_subtitle'), false);
    $response->assertSee(__('gdpr::register.form.terms_notice'), false);
});

it('uses the localized login link on the register page', function (): void {
    $response = $this->get('/en/auth/register');

    $response->assertStatus(200);
    $response->assertSee('/en/auth/login', false);
});

it('has all required translation keys used by the register page', function (): void {
    $requiredKeys = [
        'gdpr::register.title',
        'gdpr::register.subtitle',
        'gdpr::register.form.cta_title',
        'gdpr::register.form.cta_subtitle',
        'gdpr::register.form.terms_notice',
        'gdpr::register.sections.trust_badges',
        'gdpr::register.sections.registration_form',
        'gdpr::register.sections.benefits',
        'gdpr::register.benefits.community.title',
        'gdpr::register.benefits.community.cta',
        'gdpr::register.benefits.tutorials.title',
        'gdpr::register.benefits.tutorials.cta',
        'gdpr::register.benefits.networking.title',
        'gdpr::register.benefits.networking.cta',
        'gdpr::register.social_proof',
        'gdpr::register.already_registered',
        'gdpr::register.login',
    ];

    foreach ($requiredKeys as $key) {
        $translated = __($key);
        expect($translated)->not->toBe($key, "Translation key [{$key}] is missing or returns raw key");
    }
});
