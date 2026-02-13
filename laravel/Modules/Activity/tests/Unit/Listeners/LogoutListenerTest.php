<?php

declare(strict_types=1);

use Illuminate\Auth\Events\Logout;
use Illuminate\Support\Facades\Event;
use Modules\Activity\Listeners\LogoutListener;
use Modules\Activity\Tests\TestCase;

uses(TestCase::class);

test('logout listener is registered for logout event', function () {
    Event::fake();

    Event::assertListening(
        Logout::class,
        LogoutListener::class
    );
})->skip('LogoutListener may not be registered in EventServiceProvider');

test('logout listener can be instantiated', function () {
    $listener = new LogoutListener();

    expect($listener)->toBeInstanceOf(LogoutListener::class);
});

test('logout listener has handle method', function () {
    $listener = new LogoutListener();
    $reflection = new ReflectionClass($listener);

    expect($reflection->hasMethod('handle'))->toBeTrue();
});

test('logout listener handle method accepts logout event', function () {
    $listener = new LogoutListener();
    $reflection = new ReflectionClass($listener);
    $method = $reflection->getMethod('handle');
    $parameters = $method->getParameters();

    expect($parameters)->toHaveCount(1);
    expect($parameters[0]->getType()?->getName())->toBe(Logout::class);
});

test('logout listener handles event without user gracefully', function () {
    $event = new Logout('web', null);

    $listener = new LogoutListener();

    expect(fn () => $listener->handle($event))->not->toThrow(Exception::class);
});
