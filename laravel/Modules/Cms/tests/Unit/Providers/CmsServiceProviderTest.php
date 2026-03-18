<?php

declare(strict_types=1);

namespace Modules\Cms\Tests\Unit\Providers;

use Modules\Cms\Providers\CmsServiceProvider;
use Modules\Cms\Providers\EventServiceProvider;
use Modules\Cms\Providers\FolioVoltServiceProvider;
use Modules\Cms\Providers\RouteServiceProvider;

test('CmsServiceProvider has correct name', function () {
    $provider = new CmsServiceProvider(app());
    $reflection = new \ReflectionClass($provider);
    $property = $reflection->getProperty('name');
    $property->setAccessible(true);

    expect($property->getValue($provider))->toBe('Cms');
});

test('CmsServiceProvider extends XotBaseServiceProvider', function () {
    expect(new CmsServiceProvider(app()))->toBeInstanceOf(Modules\Xot\Providers\XotBaseServiceProvider::class);
});

test('EventServiceProvider has empty event listeners', function () {
    $provider = new EventServiceProvider(app());
    $reflection = new \ReflectionClass($provider);
    $property = $reflection->getProperty('listen');
    $property->setAccessible(true);

    expect($property->getValue($provider))->toBe([]);
});

test('EventServiceProvider has shouldDiscoverEvents enabled', function () {
    $provider = new EventServiceProvider(app());
    $reflection = new \ReflectionClass($provider);
    $property = $reflection->getProperty('shouldDiscoverEvents');
    $property->setAccessible(true);

    expect($property->getValue($provider))->toBeTrue();
});

test('RouteServiceProvider has correct module namespace', function () {
    $provider = new RouteServiceProvider(app());
    $reflection = new \ReflectionClass($provider);
    $property = $reflection->getProperty('moduleNamespace');
    $property->setAccessible(true);

    expect($property->getValue($provider))->toBe('Modules\Cms\Http\Controllers');
});

test('RouteServiceProvider has correct name', function () {
    $provider = new RouteServiceProvider(app());
    $reflection = new \ReflectionClass($provider);
    $property = $reflection->getProperty('name');
    $property->setAccessible(true);

    expect($property->getValue($provider))->toBe('Cms');
});

test('RouteServiceProvider has registerRoutePattern method', function () {
    $provider = new RouteServiceProvider(app());
    expect(method_exists($provider, 'registerRoutePattern'))->toBeTrue();
});

test('RouteServiceProvider has registerMyMiddleware method', function () {
    $provider = new RouteServiceProvider(app());
    expect(method_exists($provider, 'registerMyMiddleware'))->toBeTrue();
});

test('FolioVoltServiceProvider extends ServiceProvider', function () {
    expect(new FolioVoltServiceProvider(app()))->toBeInstanceOf(Illuminate\Support\ServiceProvider::class);
});

test('FolioVoltServiceProvider has register method', function () {
    $provider = new FolioVoltServiceProvider(app());
    expect(method_exists($provider, 'register'))->toBeTrue();
});

test('FolioVoltServiceProvider has boot method', function () {
    $provider = new FolioVoltServiceProvider(app());
    expect(method_exists($provider, 'boot'))->toBeTrue();
});
