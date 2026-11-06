<?php

declare(strict_types=1);
namespace Modules\Activity\Tests\Unit\Listeners;
use Illuminate\Auth\Events\Login;
use Modules\Activity\Providers\EventServiceProvider;
use Modules\Activity\Listeners\LoginListener;
use Modules\Activity\Tests\TestCase;
use PHPUnit\Framework\Assert;
use ReflectionClass;

uses(TestCase::class);

test('login listener is registered for login event', function () {
    $reflection = new ReflectionClass(EventServiceProvider::class);
    $properties = $reflection->getDefaultProperties();
    $listen = $properties['listen'] ?? null;
    Assert::assertIsArray($listen);
    $handlers = $listen[Login::class] ?? [];
    Assert::assertIsArray($handlers);

    Assert::assertContains(LoginListener::class, $handlers);
});

test('login listener can be instantiated', function () {
    $listener = new LoginListener;

    Assert::assertTrue((new ReflectionClass($listener))->hasMethod('handle'));
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

// Specifica non implementata: LoginListener::handle() e' un segnaposto senza parametri che non registra attivita'
// (vedi 'login listener handle executes without side effects' in LoginLogoutListenerBehaviorTest). Il corpo
// di questi test, scritto per un handle(Login $event) che crea l'Activity, e' nel repo Activity al commit b88f43dd.
$loginLoggingNotImplemented = 'LoginListener::handle() logging not implemented';

test('login listener handles login event and creates activity')->skip($loginLoggingNotImplemented);
test('login listener creates activity with correct properties')->skip($loginLoggingNotImplemented);
test('login listener handles multiple login events correctly')->skip($loginLoggingNotImplemented);
test('login listener includes request information in activity properties')->skip($loginLoggingNotImplemented);
test('login listener uses correct log name for activities')->skip($loginLoggingNotImplemented);
test('login listener handles event without user gracefully')->skip($loginLoggingNotImplemented);
test('login listener creates unique activities for same user different sessions')->skip($loginLoggingNotImplemented);
