<?php

declare(strict_types=1);

namespace Modules\Gdpr\Tests\Unit\Providers;

uses(Modules\Gdpr\Tests\TestCase::class);

use Modules\Gdpr\Providers\EventServiceProvider;

test('event_service_provider_extends_xot_base_event_service_provider', function () {
    $provider = new EventServiceProvider(app());

    expect($provider)->toBeInstanceOf(Modules\Xot\Providers\XotBaseEventServiceProvider::class);
});

test('event_service_provider_has_empty_listen_array', function () {
    $provider = new EventServiceProvider(app());
    $reflection = new ReflectionClass($provider);
    $property = $reflection->getProperty('listen');
    $property->setAccessible(true);

    expect($property->getValue($provider))->toBeArray();
});

test('event_service_provider_has_should_discover_events', function () {
    $provider = new EventServiceProvider(app());
    $reflection = new ReflectionClass($provider);
    $property = $reflection->getProperty('shouldDiscoverEvents');
    $property->setAccessible(true);

    expect($property->getValue($provider))->toBeTrue();
});
