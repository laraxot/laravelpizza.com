<?php

declare(strict_types=1);

use Illuminate\Http\Request;
use Modules\Cms\Http\Middleware\PageSlugMiddleware;
use PHPUnit\Framework\Assert;
use Symfony\Component\HttpFoundation\Response;

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
