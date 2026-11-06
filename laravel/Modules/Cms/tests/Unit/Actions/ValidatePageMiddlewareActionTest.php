<?php

declare(strict_types=1);

use Illuminate\Http\Middleware\SetCacheHeaders;
use Modules\Cms\Actions\ValidatePageMiddlewareAction;
use PHPUnit\Framework\Assert;

/*
 * DCP-283 (C-03): dal campo `middleware` del JSON si accettano solo i nomi in allowlist
 * (`cms.config.page_middleware_allowlist`), confrontati sul nome prima dei due punti.
 */

test('accetta i middleware realmente usati dai JSON, con i loro parametri', function (): void {
    $declared = ['auth', 'throttle:10,1'];

    Assert::assertSame($declared, app(ValidatePageMiddlewareAction::class)->execute($declared));
});

test('una lista vuota e valida: la pagina e pubblica', function (): void {
    Assert::assertSame([], app(ValidatePageMiddlewareAction::class)->execute([]));
});

test('web e un gruppo gia applicato dallo stack Folio e non viene rifiutato', function (): void {
    Assert::assertSame(['web'], app(ValidatePageMiddlewareAction::class)->execute(['web']));
});

test('rifiuta ogni nome fuori allowlist', function (string $name): void {
    expect(fn () => app(ValidatePageMiddlewareAction::class)->execute([$name]))
        ->toThrow(InvalidArgumentException::class);
})->with([
    'classe qualunque' => [SetCacheHeaders::class],
    'classe del modulo' => ['Modules\\User\\Http\\Middleware\\EnsureUserHasType:doctor'],
    'refuso' => ['auht'],
    'maiuscole diverse' => ['Auth'],
    'spazio davanti' => [' auth'],
    'guest bloccherebbe i loggati' => ['guest'],
    'gruppo api' => ['api'],
    'nome vuoto' => [''],
    'solo parametri' => [':10,1'],
    'prefisso di un nome ammesso' => ['authorize:view'],
]);

test('un solo nome non ammesso rifiuta tutta la lista', function (): void {
    expect(fn () => app(ValidatePageMiddlewareAction::class)->execute(['auth', 'api']))
        ->toThrow(InvalidArgumentException::class, 'api');
});

test('l allowlist si estende dalla configurazione, non dal JSON', function (): void {
    config(['cms.config.page_middleware_allowlist' => ['auth', 'throttle', 'verified']]);

    Assert::assertSame(['verified'], app(ValidatePageMiddlewareAction::class)->execute(['verified']));
});

test('con allowlist vuota o non valida non passa nulla tranne web', function (): void {
    config(['cms.config.page_middleware_allowlist' => 'auth']);

    expect(fn () => app(ValidatePageMiddlewareAction::class)->execute(['auth']))
        ->toThrow(InvalidArgumentException::class);
    Assert::assertSame(['web'], app(ValidatePageMiddlewareAction::class)->execute(['web']));
});
