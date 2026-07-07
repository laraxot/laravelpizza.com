<?php

declare(strict_types=1);

namespace Modules\Gdpr\Tests\Unit\Providers;

use Modules\Gdpr\Providers\Filament\AdminPanelProvider;
use Modules\Gdpr\Tests\TestCase;
use Modules\Xot\Providers\Filament\XotBasePanelProvider;
use PHPUnit\Framework\Assert;

uses(TestCase::class);

test('admin_panel_provider_extends_xot_base_panel_provider', function (): void {
    $provider = new AdminPanelProvider(app());

    Assert::assertInstanceOf(XotBasePanelProvider::class, $provider);
});

test('admin_panel_provider_has_module_property', function (): void {
    $provider = new AdminPanelProvider(app());
    $reflection = new \ReflectionClass($provider);
    $property = $reflection->getProperty('module');
    $property->setAccessible(true);

    Assert::assertSame('Gdpr', $property->getValue($provider));
});

test('admin_panel_provider_has_panel_method', function (): void {
    $provider = new AdminPanelProvider(app());

    Assert::assertTrue((new \ReflectionClass($provider))->hasMethod('panel'));
});
