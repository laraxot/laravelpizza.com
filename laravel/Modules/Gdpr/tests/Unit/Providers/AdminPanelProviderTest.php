<?php

declare(strict_types=1);

namespace Modules\Gdpr\Tests\Unit\Providers;

uses(\Modules\Gdpr\Tests\TestCase::class);

use Modules\Gdpr\Providers\Filament\AdminPanelProvider;

test('admin_panel_provider_extends_xot_base_panel_provider', function () {
    $provider = new AdminPanelProvider(app());

    expect($provider)->toBeInstanceOf(Modules\Xot\Providers\Filament\XotBasePanelProvider::class);
});

test('admin_panel_provider_has_module_property', function () {
    $provider = new AdminPanelProvider(app());
    $reflection = new ReflectionClass($provider);
    $property = $reflection->getProperty('module');
    $property->setAccessible(true);

    expect($property->getValue($provider))->toBe('Gdpr');
});

test('admin_panel_provider_has_panel_method', function () {
    $provider = new AdminPanelProvider(app());

    expect(method_exists($provider, 'panel'))->toBeTrue();
});
