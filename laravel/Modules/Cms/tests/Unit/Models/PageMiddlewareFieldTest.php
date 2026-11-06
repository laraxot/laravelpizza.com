<?php

declare(strict_types=1);

use Modules\Cms\Models\Page;
use PHPUnit\Framework\Assert;

/*
 * DCP-283 (C-03): un campo `middleware` dichiarato ma illeggibile non deve rendere pubblica la pagina.
 * Prima: una stringa diventava null (cast array) e `array_filter(is_string)` toglieva le voci non stringa.
 */

function dcp283PageWithRawMiddleware(?string $raw): Page
{
    return (new Page)->setRawAttributes(['middleware' => $raw]);
}

test('un campo assente o null e una pagina pubblica', function (): void {
    Assert::assertSame([], dcp283PageWithRawMiddleware(null)->declaredMiddleware());
    Assert::assertSame([], dcp283PageWithRawMiddleware('[]')->declaredMiddleware());
});

test('una lista di stringhe viene restituita cosi com e', function (): void {
    Assert::assertSame(['auth', 'throttle:10,1'], dcp283PageWithRawMiddleware('["auth","throttle:10,1"]')->declaredMiddleware());
});

test('un middleware dichiarato ma illeggibile lancia invece di rendere pubblica la pagina', function (string $raw): void {
    expect(fn () => dcp283PageWithRawMiddleware($raw)->declaredMiddleware())
        ->toThrow(UnexpectedValueException::class);
})->with([
    'stringa al posto della lista' => ['auth'],
    'oggetto in lista' => ['[{"a":1}]'],
    'numero in lista' => ['["auth",5]'],
    'stringa vuota in lista' => ['[""]'],
    'oggetto con chiavi' => ['{"x":"auth"}'],
    'null in lista' => ['["auth",null]'],
]);

test('le pagine reali conservano i loro middleware', function (): void {
    Assert::assertSame(['auth'], Page::getMiddlewareBySlug('tickets.create'));
    Assert::assertSame(['auth'], Page::getMiddlewareBySlug('area-personale.pratiche'));
    Assert::assertSame(['throttle:10,1'], Page::getMiddlewareBySlug('tickets.track'));
    Assert::assertSame([], Page::getMiddlewareBySlug('home'));
    Assert::assertSame([], Page::getMiddlewareBySlug('dcp283-slug-che-non-esiste'));
});
