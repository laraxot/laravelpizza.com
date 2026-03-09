<?php

declare(strict_types=1);

namespace Modules\Cms\Tests\Unit\Http\Middleware;

use Illuminate\Http\Request;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;
use Modules\Cms\Http\Middleware\SetFolioLocale;
use Tests\TestCase;

uses(TestCase::class);

test('it uses user language with highest priority', function (): void {
    LaravelLocalization::shouldReceive('setLocale')->once()->with('fr');

    $request = Request::create('/en/some-page', 'GET');
    $request->setUserResolver(fn (): object => (object) ['lang' => 'fr']);

    $middleware = new SetFolioLocale();
    $response = $middleware->handle($request, fn (Request $req) => response('ok'));

    expect($response->getStatusCode())->toBe(200)
        ->and(app()->getLocale())->toBe('fr');
});

test('it uses first url segment when locale is supported', function (): void {
    LaravelLocalization::shouldReceive('getSupportedLanguagesKeys')
        ->once()
        ->andReturn(['it', 'en', 'de', 'fr']);

    $request = Request::create('/de/some-page', 'GET');
    $request->setUserResolver(fn () => null);

    $middleware = new SetFolioLocale();
    $response = $middleware->handle($request, fn (Request $req) => response('ok'));

    expect($response->getStatusCode())->toBe(200)
        ->and(app()->getLocale())->toBe('de');
});

test('it falls back to default app locale when url segment is not supported', function (): void {
    config()->set('app.locale', 'it');

    LaravelLocalization::shouldReceive('getSupportedLanguagesKeys')
        ->once()
        ->andReturn(['it', 'en', 'fr']);

    $request = Request::create('/blog/post-1', 'GET');
    $request->setUserResolver(fn () => null);

    $middleware = new SetFolioLocale();
    $response = $middleware->handle($request, fn (Request $req) => response('ok'));

    expect($response->getStatusCode())->toBe(200)
        ->and(app()->getLocale())->toBe('it');
});
