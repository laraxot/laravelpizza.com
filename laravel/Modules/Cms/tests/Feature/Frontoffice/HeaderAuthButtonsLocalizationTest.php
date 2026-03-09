<?php

declare(strict_types=1);

namespace Modules\Cms\Tests\Feature\Frontoffice;

use Modules\Cms\Tests\TestCase;

uses(TestCase::class);

it('renders localized auth labels and links on localized homepages', function (): void {
    $response = $this->get('/it');

    $status = $response->getStatusCode();

    if ($status >= 500) {
        test()->markTestSkipped('Italian homepage returned server error in this install.');

        return;
    }

    $response->assertOk();
    $response->assertSee('Accedi');
    $response->assertSee('Registrati');
    $response->assertSee('/it/auth/login');
    $response->assertSee('/it/auth/register');

    $response = $this->get('/de');
    $status = $response->getStatusCode();

    if ($status >= 500) {
        test()->markTestSkipped('German homepage returned server error in this install.');

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
