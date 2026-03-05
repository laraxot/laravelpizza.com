<?php

declare(strict_types=1);

uses(Modules\Gdpr\Tests\TestCase::class);

use Modules\Gdpr\Providers\GdprServiceProvider;

test('gdpr_service_provider_extends_xot_base_service_provider', function () {
    $provider = new GdprServiceProvider(app());

    expect($provider)->toBeInstanceOf(\Modules\Xot\Providers\XotBaseServiceProvider::class);
});

test('gdpr_service_provider_has_name', function () {
    $provider = new GdprServiceProvider(app());
    $reflection = new ReflectionClass($provider);
    $property = $reflection->getProperty('name');
    $property->setAccessible(true);

    expect($property->getValue($provider))->toBe('Gdpr');
});

test('gdpr_service_provider_has_module_dir', function () {
    $provider = new GdprServiceProvider(app());
    $reflection = new ReflectionClass($provider);
    $property = $reflection->getProperty('module_dir');
    $property->setAccessible(true);

    expect($property->getValue($provider))->not->toBeNull();
});

test('gdpr_service_provider_has_module_ns', function () {
    $provider = new GdprServiceProvider(app());
    $reflection = new ReflectionClass($provider);
    $property = $reflection->getProperty('module_ns');
    $property->setAccessible(true);

    expect($property->getValue($provider))->toBe('Modules\Gdpr\Providers');
});
