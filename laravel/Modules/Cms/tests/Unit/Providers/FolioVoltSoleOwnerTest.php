<?php

declare(strict_types=1);

/**
 * Contratto: unico owner Folio = Cms FolioVoltServiceProvider.
 * Non deve esistere App\Providers\FolioServiceProvider.
 *
 * @see Modules/Cms/docs/bmad/folio-volt-sole-owner.md
 */

use Modules\Cms\Providers\FolioVoltServiceProvider;
use Modules\Cms\Tests\TestCase;
use PHPUnit\Framework\Assert;

// Senza questo binding le closure di `test()`/`it()` restano legate a
// PHPUnit\Framework\TestCase, cioe' a un caso di test SENZA applicazione
// Laravel: `app()`, `config()` e le facade non si risolvono. Era la causa di
// 94 fallimenti «Target class [config] does not exist» nel modulo
// (base_quaeris_fila5#228).
uses(TestCase::class);

test('app providers must not define FolioServiceProvider', function (): void {
    $path = base_path('app/Providers/FolioServiceProvider.php');
    Assert::assertFileDoesNotExist($path);
    Assert::assertFalse(class_exists(\App\Providers\FolioServiceProvider::class, false));
});

test('Cms FolioVoltServiceProvider class exists and is the mount owner', function (): void {
<<<<<<< HEAD
    Assert::assertTrue(class_exists(\Modules\Cms\Providers\FolioVoltServiceProvider::class));
=======
    Assert::assertTrue(class_exists(FolioVoltServiceProvider::class));
>>>>>>> laraxot/dev
});
