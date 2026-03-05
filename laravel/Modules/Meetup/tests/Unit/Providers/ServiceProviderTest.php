<?php

declare(strict_types=1);

namespace Modules\Meetup\Tests\Unit\Providers;

use Modules\Meetup\Providers\EventServiceProvider;
use Modules\Meetup\Providers\MeetupServiceProvider;
use Modules\Meetup\Providers\RouteServiceProvider;
use Modules\Meetup\Tests\TestCase;

uses(TestCase::class);

test('meetup service provider is registered', function () {
    expect(app()->getProvider(MeetupServiceProvider::class))->toBeInstanceOf(MeetupServiceProvider::class);
});

test('event service provider is registered', function () {
    expect(app()->getProvider(EventServiceProvider::class))->toBeInstanceOf(EventServiceProvider::class);
});

test('event service provider boot can be invoked', function () {
    $provider = app()->getProvider(EventServiceProvider::class);

    expect($provider)->toBeInstanceOf(EventServiceProvider::class);

    $provider->boot();

    expect(true)->toBeTrue();
});

test('route service provider is registered', function () {
    expect(app()->getProvider(RouteServiceProvider::class))->toBeInstanceOf(RouteServiceProvider::class);
});
