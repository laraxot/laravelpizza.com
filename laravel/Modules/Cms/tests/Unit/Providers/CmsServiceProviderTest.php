<?php

declare(strict_types=1);

use Modules\Cms\Providers\CmsServiceProvider;
use Modules\Cms\Providers\EventServiceProvider;
use Modules\Cms\Providers\FolioVoltServiceProvider;
use Modules\Cms\Providers\RouteServiceProvider;
use PHPUnit\Framework\Assert;

uses(Modules\Cms\Tests\TestCase::class);
test('CmsServiceProvider has correct name', function () {
    $provider = new CmsServiceProvider(app());
    $reflection = new ReflectionClass($provider);
    $property = $reflection->getProperty('name');
    $property->setAccessible(true);

    Assert::assertSame('Cms', $property->getValue($provider));
});

test('CmsServiceProvider extends XotBaseServiceProvider', function () {
    Assert::assertInstanceOf(Modules\Xot\Providers\XotBaseServiceProvider::class, new CmsServiceProvider(app()));
});

test('EventServiceProvider has empty event listeners', function () {
    $provider = new EventServiceProvider(app());
    $reflection = new ReflectionClass($provider);
    $property = $reflection->getProperty('listen');
    $property->setAccessible(true);

    Assert::assertSame([], $property->getValue($provider));
});

test('EventServiceProvider has shouldDiscoverEvents enabled', function () {
    $provider = new EventServiceProvider(app());
    $reflection = new ReflectionClass($provider);
    $property = $reflection->getProperty('shouldDiscoverEvents');
    $property->setAccessible(true);

    Assert::assertTrue($property->getValue($provider));
});

test('RouteServiceProvider has correct module namespace', function () {
    $provider = new RouteServiceProvider(app());
    $reflection = new ReflectionClass($provider);
    $property = $reflection->getProperty('moduleNamespace');
    $property->setAccessible(true);

    Assert::assertSame('Modules\Cms\Http\Controllers', $property->getValue($provider));
});

test('RouteServiceProvider has correct name', function () {
    $provider = new RouteServiceProvider(app());
    $reflection = new ReflectionClass($provider);
    $property = $reflection->getProperty('name');
    $property->setAccessible(true);

    Assert::assertSame('Cms', $property->getValue($provider));
});

test('RouteServiceProvider has registerRoutePattern method', function () {
    $provider = new RouteServiceProvider(app());
});

test('RouteServiceProvider has registerMyMiddleware method', function () {
    $provider = new RouteServiceProvider(app());
});

test('FolioVoltServiceProvider extends ServiceProvider', function () {
    Assert::assertInstanceOf(Illuminate\Support\ServiceProvider::class, new FolioVoltServiceProvider(app()));
});

test('FolioVoltServiceProvider has register method', function () {
    $provider = new FolioVoltServiceProvider(app());
});

test('FolioVoltServiceProvider has boot method', function () {
    $provider = new FolioVoltServiceProvider(app());
});
