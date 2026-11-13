<?php

declare(strict_types=1);

use Modules\User\Models\User;
use Modules\User\Tests\TestCase;

uses(TestCase::class);

it('serves authenticated area personale pages', function (string $path): void {
    $user = User::query()->firstOrFail();
    $this->actingAs($user)->get('/it'.$path)->assertOk();
})->with([
    '/area-personale/pratiche',
    '/area-personale/servizi',
    '/area-personale/seguite',
    '/area-personale/notifiche',
    '/area-personale/impostazioni',
]);

it('redirects authenticated area personale root to a canonical child page', function (): void {
    $user = User::query()->firstOrFail();
    $response = $this->actingAs($user)->get('/it/area-personale');
    $response->assertRedirect();
    expect($response->headers->get('Location'))->toContain('/it/area-personale/');
});

it('serves public detail pages for authenticated user', function (string $path): void {
    $user = User::query()->firstOrFail();
    $this->actingAs($user)->get('/it'.$path)->assertOk();
})->with([
    '/events',
    '/blog',
    '/services',
]);
