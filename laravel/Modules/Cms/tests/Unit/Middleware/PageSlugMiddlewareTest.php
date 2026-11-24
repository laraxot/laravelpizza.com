<?php

declare(strict_types=1);

use Illuminate\Http\Request;
use Modules\Cms\Http\Middleware\PageSlugMiddleware;
<<<<<<< HEAD
use PHPUnit\Framework\Assert;
use Symfony\Component\HttpFoundation\Response;

=======
use Modules\Cms\Tests\TestCase;
use PHPUnit\Framework\Assert;
use Symfony\Component\HttpFoundation\Response;

// Senza questo binding le closure di `test()`/`it()` restano legate a
// PHPUnit\Framework\TestCase, cioe' a un caso di test SENZA applicazione
// Laravel: `app()`, `config()` e le facade non si risolvono. Era la causa di
// 94 fallimenti «Target class [config] does not exist» nel modulo
// (base_quaeris_fila5#228).
uses(TestCase::class);

>>>>>>> laraxot/dev
test('PageSlugMiddleware can be instantiated', function () {
    Assert::assertSame(PageSlugMiddleware::class, (new PageSlugMiddleware)::class);

});

test('PageSlugMiddleware passes the request through when no CMS page matches', function () {
    $middleware = new PageSlugMiddleware;
    $expected = new Response('ok');

    // Request::create() non ha una rotta risolta: nessuno slug CMS, si prosegue la catena.
    $response = $middleware->handle(Request::create('/it/no-such-page'), fn (Request $request): Response => $expected);

    Assert::assertSame($expected, $response);
});
