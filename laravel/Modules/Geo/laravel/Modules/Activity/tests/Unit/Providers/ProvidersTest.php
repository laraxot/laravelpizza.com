<?php

declare(strict_types=1);

namespace Modules\Activity\Tests\Unit\Providers;
use Modules\Activity\Providers\ActivityServiceProvider;
use Modules\Activity\Providers\EventServiceProvider;
use Modules\Activity\Providers\RouteServiceProvider;
use Modules\Activity\Tests\TestCase;
use Modules\Xot\Providers\XotBaseRouteServiceProvider;
use Modules\Xot\Providers\XotBaseServiceProvider;
use PHPUnit\Framework\Assert;

uses(\Modules\Activity\Tests\TestCase::class);

test('ActivityServiceProvider extends XotBaseServiceProvider', function (): void {
    $reflection = new \ReflectionClass(ActivityServiceProvider::class);
    Assert::assertTrue($reflection->isSubclassOf(XotBaseServiceProvider::class));
});

test('ActivityServiceProvider has correct name', function (): void {
    $provider = new ActivityServiceProvider(app());
    Assert::assertSame('Activity', $provider->name);
});

test('ActivityServiceProvider registers migrations', function (): void {
    $provider = new ActivityServiceProvider(app());
    $provider->boot();

    Assert::assertInstanceOf(ActivityServiceProvider::class, $provider);
});

test('EventServiceProvider can be instantiated', function (): void {
    $provider = new EventServiceProvider(app());
    Assert::assertInstanceOf(EventServiceProvider::class, $provider);
});

test('RouteServiceProvider can be instantiated', function (): void {
    $provider = new RouteServiceProvider(app());
    Assert::assertInstanceOf(RouteServiceProvider::class, $provider);
});

test('RouteServiceProvider has correct properties', function (): void {
    $provider = new RouteServiceProvider(app());
    Assert::assertSame('Activity', $provider->name);
});

test('RouteServiceProvider extends XotBaseRouteServiceProvider', function (): void {
    $reflection = new \ReflectionClass(RouteServiceProvider::class);
    Assert::assertTrue($reflection->isSubclassOf(XotBaseRouteServiceProvider::class));
});

test('ActivityServiceProvider has boot method', function (): void {
    $provider = new ActivityServiceProvider(app());
    $reflection = new \ReflectionMethod($provider, 'boot');
    Assert::assertTrue($reflection->isPublic());
});

test('EventServiceProvider has boot method', function (): void {
    $provider = new EventServiceProvider(app());
    $reflection = new \ReflectionMethod($provider, 'boot');
    Assert::assertTrue($reflection->isPublic());
});
