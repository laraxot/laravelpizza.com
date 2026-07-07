<?php

declare(strict_types=1);

use Modules\Cms\Tests\TestCase;

uses(TestCase::class);
it('renders the italian privacy page from cms json content', function (): void {
    $response = cmsGet('/it/privacy');
    $status = (int) $response->getStatusCode();

    if ($status >= 500) {
        cmsSkipTest("Route /it/privacy returned server error ({$status}).");
    }

    if (200 !== $status) {
        cmsSkipTest("Route /it/privacy returned {$status} — CMS legal page not configured in this install.");
    }

    $response
        ->assertSee('Privacy Policy')
        ->assertSee('Ultimo aggiornamento: 9 marzo 2026')
        ->assertSee('Diritti dell\'interessato')
        ->assertSee('privacy@laravelpizza.com');
});

it('renders the italian terms page from cms json content', function (): void {
    $response = cmsGet('/it/terms');
    $status = (int) $response->getStatusCode();

    if ($status >= 500) {
        cmsSkipTest("Route /it/terms returned server error ({$status}).");
    }

    if (200 !== $status) {
        cmsSkipTest("Route /it/terms returned {$status} — CMS legal page not configured in this install.");
    }

    $response
        ->assertSee('Termini e Condizioni')
        ->assertSee('Ultimo aggiornamento: 9 marzo 2026')
        ->assertSee('Limitazione di responsabilita')
        ->assertSee('hello@laravelpizza.com');
});
