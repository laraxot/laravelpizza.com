<?php

declare(strict_types=1);

use Illuminate\Auth\Events\Login;
use Modules\Activity\Providers\EventServiceProvider;
use Modules\Activity\Listeners\LoginListener;
use Modules\Activity\Tests\TestCase;
use PHPUnit\Framework\Assert;

uses(TestCase::class);

test('login listener is registered for login event', function () {
    $reflection = new ReflectionClass(EventServiceProvider::class);
    /** @var array<class-string, list<class-string>> $listen */
    $listen = $reflection->getDefaultProperties()['listen'] ?? [];
    /** @var list<class-string> $handlers */
    $handlers = $listen[Login::class] ?? [];

    Assert::assertContains(LoginListener::class, $handlers);
});

test('login listener can be instantiated', function () {
    $listener = new LoginListener;

    Assert::assertInstanceOf(LoginListener::class, $listener);
});

test('login listener has handle method', function () {
    $listener = new LoginListener;
    $reflection = new ReflectionClass($listener);

    Assert::assertTrue($reflection->hasMethod('handle'));
});

test('login listener handle method is callable', function () {
    $listener = new LoginListener;

    $listener->handle();
});
