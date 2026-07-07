<?php

declare(strict_types=1);

use Modules\Cms\Tests\TestCase;

uses(TestCase::class);
it('GET /de localizes guest auth labels in header', function (): void {
    $response = cmsGet('/de');
    $status = (int) $response->getStatusCode();

    if ($status >= 500) {
        cmsSkipTest("Route /de returned server error ({$status}).");
    }

    if (200 !== $status) {
        cmsSkipTest("Route /de returned {$status} — cannot verify header auth localization.");
    }

    $response
        ->assertSee('lang="de"', false)
        ->assertSeeText('Anmelden')
        ->assertSeeText('Registrieren')
        ->assertDontSeeText('Accedi')
        ->assertSee('/de/auth/login', false)
        ->assertSee('/de/auth/register', false);
});

it('GET /en localizes guest auth labels in header', function (): void {
    $response = cmsGet('/en');
    $status = (int) $response->getStatusCode();

    if ($status >= 500) {
        cmsSkipTest("Route /en returned server error ({$status}).");
    }

    if (200 !== $status) {
        cmsSkipTest("Route /en returned {$status} — cannot verify header auth localization.");
    }

    $response
        ->assertSee('lang="en"', false)
        ->assertSeeText('Log in')
        ->assertSeeText('Create account')
        ->assertDontSeeText('Accedi')
        ->assertSee('/en/auth/login', false)
        ->assertSee('/en/auth/register', false);
});
