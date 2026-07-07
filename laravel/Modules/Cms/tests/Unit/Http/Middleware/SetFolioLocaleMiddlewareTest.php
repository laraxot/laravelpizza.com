<?php

declare(strict_types=1);

use Illuminate\Http\Request;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;
use Modules\Cms\Http\Middleware\SetFolioLocale;
use PHPUnit\Framework\Assert;

uses(Modules\Cms\Tests\TestCase::class);
test('it uses user language with highest priority', function (): void {
    LaravelLocalization::shouldReceive('setLocale')->once()->with('fr');

    $request = Request::create('/en/some-page', 'GET');
    $request->setUserResolver(fn (): object => (object) ['lang' => 'fr']);

    $middleware = new SetFolioLocale();
    $response = $middleware->handle($request, fn (Request $req) => response('ok'));
    Assert::assertInstanceOf(Symfony\Component\HttpFoundation\Response::class, $response);

    Assert::assertSame(200, $response->getStatusCode());

    Assert::assertSame('fr', app()->getLocale());
});

test('it uses first url segment when locale is supported', function (): void {
    LaravelLocalization::shouldReceive('getSupportedLanguagesKeys')
        ->once()
        ->andReturn(['it', 'en', 'de', 'fr']);
    LaravelLocalization::shouldReceive('setLocale')
        ->once()
        ->with('de');

    $request = Request::create('/de/some-page', 'GET');
    $request->setUserResolver(fn () => null);

    $middleware = new SetFolioLocale();
    $response = $middleware->handle($request, fn (Request $req) => response('ok'));
    Assert::assertInstanceOf(Symfony\Component\HttpFoundation\Response::class, $response);

    Assert::assertSame(200, $response->getStatusCode());

    Assert::assertSame('de', app()->getLocale());
});

test('it falls back to default app locale when url segment is not supported', function (): void {
    config()->set('app.locale', 'it');

    LaravelLocalization::shouldReceive('getSupportedLanguagesKeys')
        ->once()
        ->andReturn(['it', 'en', 'fr']);
    LaravelLocalization::shouldReceive('setLocale')
        ->once()
        ->with('it');

    $request = Request::create('/blog/post-1', 'GET');
    $request->setUserResolver(fn () => null);

    $middleware = new SetFolioLocale();
    $response = $middleware->handle($request, fn (Request $req) => response('ok'));
    Assert::assertInstanceOf(Symfony\Component\HttpFoundation\Response::class, $response);

    Assert::assertSame(200, $response->getStatusCode());

    Assert::assertSame('it', app()->getLocale());
});
