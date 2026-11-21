<?php

declare(strict_types=1);

namespace Modules\Gdpr\Tests\Feature;

use Modules\Gdpr\Tests\TestCase;
use PHPUnit\Framework\Assert;

uses(TestCase::class);

it('renders the English register page with the texts of the registration form', function (): void {
    // Titolo, sottotitolo e vantaggi della pagina sono del tema ospite; il modulo possiede etichette e consensi del form.
    $response = gdprGet('/en/auth/register');

    $response->assertStatus(200);
    $response->assertSee(e(__('gdpr::register.fields.first_name.label')), false);
    $response->assertSee(e(__('gdpr::register.fields.email.label')), false);
    $response->assertSee(e(__('gdpr::register.consents.privacy_policy_label')), false);
    $response->assertSee(e(__('gdpr::register.consents.terms_label')), false);
    $response->assertSee(e(__('gdpr::register.consents.marketing_label')), false);
});

it('uses the localized login link on the register page', function (): void {
    $response = gdprGet('/en/auth/register');

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
        'gdpr::register.sections.registration_form',
        'gdpr::register.already_registered',
        'gdpr::register.login',
    ];

    foreach ($requiredKeys as $key) {
        $translated = __($key);
        Assert::assertNotSame($key, $translated, "Translation key [{$key}] is missing or returns raw key");
    }
});
