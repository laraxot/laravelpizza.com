<?php

declare(strict_types=1);

namespace Modules\Activity\Tests\Unit\Providers;

use Illuminate\Auth\Events\Login;
use Illuminate\Auth\Events\Logout;
use Modules\Activity\Listeners\LoginListener;
use Modules\Activity\Listeners\LogoutListener;
use Modules\Activity\Providers\EventServiceProvider;
use Modules\Activity\Tests\TestCase;

uses(TestCase::class);

test('event service provider registers login and logout listeners', function () {
    $provider = new EventServiceProvider(app());

    $reflection = new \ReflectionClass($provider);
    $property = $reflection->getProperty('listen');
    $property->setAccessible(true);

    /** @var array<class-string, array<int, class-string>> $listen */
    $listen = $property->getValue($provider);

    expect($listen)->toHaveKey(Login::class)
        ->and($listen)->toHaveKey(Logout::class)
        ->and($listen[Login::class])->toContain(LoginListener::class)
        ->and($listen[Logout::class])->toContain(LogoutListener::class);
});

test('event discovery is enabled on provider', function () {
    $reflection = new \ReflectionClass(EventServiceProvider::class);
    $property = $reflection->getProperty('shouldDiscoverEvents');
    $property->setAccessible(true);

    expect($property->getValue())->toBeTrue();
});
