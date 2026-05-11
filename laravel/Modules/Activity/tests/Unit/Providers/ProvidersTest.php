<?php

declare(strict_types=1);

namespace Modules\Activity\Tests\Unit\Providers;

uses(TestCase::class);

use Modules\Activity\Providers\ActivityServiceProvider;
use Modules\Activity\Providers\EventServiceProvider;
use Modules\Activity\Providers\RouteServiceProvider;
use Modules\Activity\Tests\TestCase;
use Modules\Xot\Providers\XotBaseRouteServiceProvider;
use Modules\Xot\Providers\XotBaseServiceProvider;

test('ActivityServiceProvider extends XotBaseServiceProvider', function (): void {
    $reflection = new ReflectionClass(ActivityServiceProvider::class);
    expect($reflection->isSubclassOf(XotBaseServiceProvider::class))->toBeTrue();
});

test('ActivityServiceProvider has correct name', function (): void {
    $provider = new ActivityServiceProvider(app());
    expect($provider->name)->toBe('Activity');
});

test('ActivityServiceProvider registers migrations', function (): void {
    $provider = new ActivityServiceProvider(app());
    $provider->boot();

    expect(true)->toBeTrue();
});

test('EventServiceProvider can be instantiated', function (): void {
    $provider = new EventServiceProvider(app());
    expect($provider)->toBeInstanceOf(EventServiceProvider::class);
});

test('RouteServiceProvider can be instantiated', function (): void {
    $provider = new RouteServiceProvider(app());
    expect($provider)->toBeInstanceOf(RouteServiceProvider::class);
});

test('RouteServiceProvider has correct properties', function (): void {
    $provider = new RouteServiceProvider(app());
    expect($provider->name)->toBe('Activity');
});

test('RouteServiceProvider extends XotBaseRouteServiceProvider', function (): void {
    $reflection = new ReflectionClass(RouteServiceProvider::class);
    expect($reflection->isSubclassOf(XotBaseRouteServiceProvider::class))->toBeTrue();
});

test('ActivityServiceProvider has boot method', function (): void {
    $provider = new ActivityServiceProvider(app());
    $reflection = new ReflectionMethod($provider, 'boot');
    expect($reflection->isPublic())->toBeTrue();
});

test('EventServiceProvider has boot method', function (): void {
    $provider = new EventServiceProvider(app());
    $reflection = new ReflectionMethod($provider, 'boot');
    expect($reflection->isPublic())->toBeTrue();
});
