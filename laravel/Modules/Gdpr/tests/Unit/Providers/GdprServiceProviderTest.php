<?php

declare(strict_types=1);

namespace Modules\Gdpr\Tests\Unit\Providers;

use Modules\Gdpr\Providers\GdprServiceProvider;
use Modules\Gdpr\Tests\TestCase;
use Modules\Xot\Providers\XotBaseServiceProvider;
use PHPUnit\Framework\Assert;

uses(TestCase::class);

test('gdpr_service_provider_extends_xot_base_service_provider', function (): void {
    $provider = new GdprServiceProvider(app());

    Assert::assertInstanceOf(XotBaseServiceProvider::class, $provider);
});

test('gdpr_service_provider_has_name', function (): void {
    $provider = new GdprServiceProvider(app());
    $reflection = new \ReflectionClass($provider);
    $property = $reflection->getProperty('name');
    $property->setAccessible(true);

    Assert::assertSame('Gdpr', $property->getValue($provider));
});

test('gdpr_service_provider_has_module_dir', function (): void {
    $provider = new GdprServiceProvider(app());
    $reflection = new \ReflectionClass($provider);
    $property = $reflection->getProperty('module_dir');
    $property->setAccessible(true);

    Assert::assertNotNull($property->getValue($provider));
});

test('gdpr_service_provider_has_module_ns', function (): void {
    $provider = new GdprServiceProvider(app());
    $reflection = new \ReflectionClass($provider);
    $property = $reflection->getProperty('module_ns');
    $property->setAccessible(true);

    Assert::assertSame('Modules\Gdpr\Providers', $property->getValue($provider));
});
