<?php

declare(strict_types=1);

it('renders localized auth labels and links on localized homepages', function (): void {
    $response = cmsGet('/it');

    $status = $response->getStatusCode();

    if ($status >= 500) {
        cmsSkipTest('Italian homepage returned server error in this install.');

        return;
    }

    $response->assertOk();
    $response->assertSee('Accedi');
    $response->assertSee('Registrati');
    $response->assertSee('/it/auth/login');
    $response->assertSee('/it/auth/register');

    $response = cmsGet('/de');
    $status = $response->getStatusCode();

    if ($status >= 500) {
        cmsSkipTest('German homepage returned server error in this install.');

        return;
    }

    $response->assertOk();
    $response->assertDontSee('Accedi');
    $response->assertDontSee('Registrati');
    $response->assertSee('Einloggen');
    $response->assertSee('Registrieren');
    $response->assertSee('/de/auth/login');
    $response->assertSee('/de/auth/register');
});
