<?php

declare(strict_types=1);

namespace Modules\Gdpr\Tests\Unit\Traits;

uses(Modules\Gdpr\Tests\TestCase::class);

use Modules\Gdpr\Models\Traits\HasGdpr;

test('has_gdpr_trait_is_trait', function () {
    expect(trait_exists(HasGdpr::class))->toBeTrue();
});

test('has_gdpr_trait_has_consents_method', function () {
    expect(method_exists(HasGdpr::class, 'consents'))->toBeTrue();
});

test('has_gdpr_trait_has_active_consents_method', function () {
    expect(method_exists(HasGdpr::class, 'activeConsents'))->toBeTrue();
});

test('has_gdpr_trait_has_treatments_method', function () {
    expect(method_exists(HasGdpr::class, 'treatments'))->toBeTrue();
});

test('has_gdpr_trait_has_has_given_consent_method', function () {
    expect(method_exists(HasGdpr::class, 'hasGivenConsent'))->toBeTrue();
});

test('has_gdpr_trait_has_give_consent_method', function () {
    expect(method_exists(HasGdpr::class, 'giveConsent'))->toBeTrue();
});

test('has_gdpr_trait_has_revoke_consent_method', function () {
    expect(method_exists(HasGdpr::class, 'revokeConsent'))->toBeTrue();
});

test('has_gdpr_trait_has_get_missing_required_consents_method', function () {
    expect(method_exists(HasGdpr::class, 'getMissingRequiredConsents'))->toBeTrue();
});

test('has_gdpr_trait_has_has_all_required_consents_method', function () {
    expect(method_exists(HasGdpr::class, 'hasAllRequiredConsents'))->toBeTrue();
});
