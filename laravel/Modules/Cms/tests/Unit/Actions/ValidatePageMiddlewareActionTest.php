<?php

declare(strict_types=1);

use Illuminate\Http\Middleware\SetCacheHeaders;
use Modules\Cms\Actions\ValidatePageMiddlewareAction;
<<<<<<< HEAD
use PHPUnit\Framework\Assert;

=======
use Modules\Cms\Tests\TestCase;
use PHPUnit\Framework\Assert;

/** @see docs/wiki/concepts/cms-page-middleware-json-ssot.md */

// Senza questo binding le closure di `test()`/`it()` restano legate a
// PHPUnit\Framework\TestCase, cioe' a un caso di test SENZA applicazione
// Laravel: `app()`, `config()` e le facade non si risolvono. Era la causa di
// 94 fallimenti «Target class [config] does not exist» nel modulo
// (base_quaeris_fila5#228).
uses(TestCase::class);

>>>>>>> laraxot/dev
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
<<<<<<< HEAD
});
=======
})->group('CMS-PAGE-MIDDLEWARE-INV-3');
>>>>>>> laraxot/dev

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
<<<<<<< HEAD
]);
=======
])->group('CMS-PAGE-MIDDLEWARE-INV-1');
>>>>>>> laraxot/dev

test('un solo nome non ammesso rifiuta tutta la lista', function (): void {
    expect(fn () => app(ValidatePageMiddlewareAction::class)->execute(['auth', 'api']))
        ->toThrow(InvalidArgumentException::class, 'api');
<<<<<<< HEAD
});
=======
})->group('CMS-PAGE-MIDDLEWARE-INV-2');
>>>>>>> laraxot/dev

test('l allowlist si estende dalla configurazione, non dal JSON', function (): void {
    config(['cms.config.page_middleware_allowlist' => ['auth', 'throttle', 'verified']]);

    Assert::assertSame(['verified'], app(ValidatePageMiddlewareAction::class)->execute(['verified']));
<<<<<<< HEAD
});
=======
})->group('CMS-PAGE-MIDDLEWARE-INV-4');
>>>>>>> laraxot/dev

test('con allowlist vuota o non valida non passa nulla tranne web', function (): void {
    config(['cms.config.page_middleware_allowlist' => 'auth']);

    expect(fn () => app(ValidatePageMiddlewareAction::class)->execute(['auth']))
        ->toThrow(InvalidArgumentException::class);
    Assert::assertSame(['web'], app(ValidatePageMiddlewareAction::class)->execute(['web']));
<<<<<<< HEAD
});
=======
})->group('CMS-PAGE-MIDDLEWARE-INV-4');
>>>>>>> laraxot/dev
