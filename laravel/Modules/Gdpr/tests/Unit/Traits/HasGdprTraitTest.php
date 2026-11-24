<?php

declare(strict_types=1);

namespace Modules\Gdpr\Tests\Unit\Traits;

use Modules\Gdpr\Models\Traits\HasGdpr;
use Modules\Gdpr\Tests\TestCase;
use PHPUnit\Framework\Assert;

uses(TestCase::class);

test('has_gdpr_trait_is_trait', function (): void {
    Assert::assertTrue(trait_exists(HasGdpr::class));
});

test('has_gdpr_trait_has_required_methods', function (): void {
    $methods = get_class_methods(HasGdpr::class);

    Assert::assertContains('consents', $methods);
    Assert::assertContains('activeConsents', $methods);
    Assert::assertContains('treatments', $methods);
    Assert::assertContains('hasGivenConsent', $methods);
    Assert::assertContains('giveConsent', $methods);
    Assert::assertContains('revokeConsent', $methods);
    Assert::assertContains('getMissingRequiredConsents', $methods);
    Assert::assertContains('hasAllRequiredConsents', $methods);
});

test('has_gdpr_trait_methods_are_public', function (): void {
    $reflection = new \ReflectionClass(HasGdpr::class);

    foreach ([
        'consents',
        'activeConsents',
        'treatments',
        'hasGivenConsent',
        'giveConsent',
        'revokeConsent',
        'getMissingRequiredConsents',
        'hasAllRequiredConsents',
    ] as $method) {
        Assert::assertTrue($reflection->hasMethod($method));
        Assert::assertTrue($reflection->getMethod($method)->isPublic());
    }
});
