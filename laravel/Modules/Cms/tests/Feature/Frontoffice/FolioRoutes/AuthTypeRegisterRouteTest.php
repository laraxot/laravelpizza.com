<?php

declare(strict_types=1);
<<<<<<< HEAD
use Modules\Cms\Tests\TestCase;

uses(TestCase::class);

=======

use Modules\Cms\Tests\TestCase;

// Senza questo binding le closure di `test()`/`it()` restano legate a
// PHPUnit\Framework\TestCase, cioe' a un caso di test SENZA applicazione
// Laravel: `app()`, `config()` e le facade non si risolvono. Era la causa di
// 94 fallimenti «Target class [config] does not exist» nel modulo
// (base_quaeris_fila5#228).
uses(TestCase::class);
/** @see Modules/Cms/docs/bmad/folio-volt-sole-owner.md */
>>>>>>> laraxot/dev
it('SKIP dynamic /it/auth/{type}/register', function (): void {
    $this->markTestSkipped('Dynamic type route requires fixture.');
});
