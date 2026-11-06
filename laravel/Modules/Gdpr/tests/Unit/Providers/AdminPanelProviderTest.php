<?php

declare(strict_types=1);

namespace Modules\Gdpr\Tests\Unit\Providers;

use Modules\Gdpr\Providers\Filament\AdminPanelProvider;
use Modules\Xot\Providers\Filament\XotBasePanelProvider;
use PHPUnit\Framework\Assert;

use function Safe\class_parents;

test('admin_panel_provider_extends_xot_base_panel_provider', function (): void {
    Assert::assertArrayHasKey(XotBasePanelProvider::class, class_parents(AdminPanelProvider::class));
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
