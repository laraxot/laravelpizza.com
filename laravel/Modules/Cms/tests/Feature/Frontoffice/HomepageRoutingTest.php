<?php

declare(strict_types=1);

use Modules\Cms\Tests\TestCase;
use Nwidart\Modules\Facades\Module;
use PHPUnit\Framework\Assert;

uses(TestCase::class);

beforeEach(function (): void {
    if (! Module::isEnabled('Cms')) {
        cmsSkipTest('Module Cms is disabled');
    }
});

it('redirects root / to /{locale}', function (): void {
    $locale = app()->getLocale();
    $response = cmsGet('/');
    Assert::assertSame('/'.$locale, $response->headers->get('Location'));
});

it('serves localized homepage at /{locale}', function (): void {
    $locale = app()->getLocale();
    $response = cmsGet('/'.$locale);
    Assert::assertSame(200, $response->status());
});
