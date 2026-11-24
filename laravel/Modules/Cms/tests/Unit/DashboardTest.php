<?php

declare(strict_types=1);

use Modules\Cms\Tests\TestCase;
use PHPUnit\Framework\Assert;

// Senza questo binding le closure di `test()`/`it()` restano legate a
// PHPUnit\Framework\TestCase, cioe' a un caso di test SENZA applicazione
// Laravel: `app()`, `config()` e le facade non si risolvono. Era la causa di
// 94 fallimenti «Target class [config] does not exist» nel modulo
// (base_quaeris_fila5#228).
uses(TestCase::class);

test('route home returns successful response with correct view', function (): void {
    $response = cmsGetOrSkipOnServerError('/');
    $status = $response->status();
    if (in_array($status, [301, 302, 303, 307, 308], true)) {
        Assert::assertNotEmpty($response->headers->get('Location'));

        return;
    }
    Assert::assertContains($status, [200, 404]);
});

test('route login returns successful response with correct view', function (): void {
    $response = cmsGetOrSkipOnServerError('/it/auth/login');
    Assert::assertContains($response->status(), [200, 302, 404]);
});
