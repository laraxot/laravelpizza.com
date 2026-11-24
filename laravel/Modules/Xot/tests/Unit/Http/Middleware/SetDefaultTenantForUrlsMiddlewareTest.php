<?php

declare(strict_types=1);

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\URL;
use Modules\Xot\Http\Middleware\SetDefaultTenantForUrlsMiddleware;
use Modules\Xot\Tests\TestCase;

uses(TestCase::class);

/** @see Modules/Xot/docs/adr/auth-register-livewire-tenant-url-defaults.md */
it('does not carry a Filament tenant into the public registration Livewire cycle', function (): void {
    URL::defaults(['tenant' => 'stale-panel-tenant']);

    $middleware = new SetDefaultTenantForUrlsMiddleware;
    $request = Request::create('/it/auth/register', 'GET');
    $response = $middleware->handle($request, static fn (): Response => new Response('ok'));

    expect($response->getStatusCode())->toBe(200)
        ->and(URL::getDefaultParameters())->toHaveKey('tenant', null);
});

/** @see Modules/Xot/docs/adr/auth-register-livewire-tenant-url-defaults.md */
it('recognises the registration page as the origin of its Livewire update', function (): void {
    URL::defaults(['tenant' => 'stale-panel-tenant']);

    $middleware = new SetDefaultTenantForUrlsMiddleware;
    $request = Request::create('/livewire/update', 'POST', [], [], [], [
        'HTTP_REFERER' => 'https://fixcity.test/it/auth/register',
    ]);
    $response = $middleware->handle($request, static fn (): Response => new Response('ok'));

    expect($response->getStatusCode())->toBe(200)
        ->and(URL::getDefaultParameters())->toHaveKey('tenant', null);
});
