<?php

declare(strict_types=1);

use Illuminate\Routing\Router;
use Modules\Cms\Providers\CmsServiceProvider;
use Modules\Cms\Providers\EventServiceProvider;
use Modules\Cms\Providers\RouteServiceProvider;
use PHPUnit\Framework\Assert;

test('CmsServiceProvider has correct name', function () {
    $provider = new CmsServiceProvider(app());
    $reflection = new ReflectionClass($provider);
    $property = $reflection->getProperty('name');
    $property->setAccessible(true);

    Assert::assertSame('Cms', $property->getValue($provider));
});

test('CmsServiceProvider extends XotBaseServiceProvider', function () {})->todo();

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

test('RouteServiceProvider registerRoutePattern registers the lang route pattern', function () {
    $provider = new RouteServiceProvider(app());
    // Router isolato: non si altera il router dell'applicazione di test.
    $router = new Router(app('events'), app());

    $provider->registerRoutePattern($router);

    $pattern = $router->getPatterns()['lang'] ?? null;
    Assert::assertIsString($pattern);
    Assert::assertStringStartsWith('/|', $pattern);
    Assert::assertStringEndsWith('|/i', $pattern);
});

test('RouteServiceProvider registerMyMiddleware registers the Cms middleware', function () {})->todo('registerMyMiddleware() e\' volutamente vuoto (i middleware di locale sono commentati): non c\'e\' comportamento da asserire finche\' non viene riabilitato.');

test('FolioVoltServiceProvider extends ServiceProvider', function () {})->todo();

test('FolioVoltServiceProvider register does not bind anything', function () {})->todo('register() e\' vuoto: il lavoro e\' in boot().');

test('FolioVoltServiceProvider boot registers the Folio paths once the app is booted', function () {})->todo('boot() registra i path Folio/Volt sul container gia\' avviato (effetti globali sul router): serve un\'app isolata per asserirlo.');
