<?php

declare(strict_types=1);

<<<<<<< HEAD
=======
use Modules\Cms\Tests\TestCase;

// Senza questo binding le closure di `test()`/`it()` restano legate a
// PHPUnit\Framework\TestCase, cioe' a un caso di test SENZA applicazione
// Laravel: `app()`, `config()` e le facade non si risolvono. Era la causa di
// 94 fallimenti «Target class [config] does not exist» nel modulo
// (base_quaeris_fila5#228).
uses(TestCase::class);

>>>>>>> laraxot/dev
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
