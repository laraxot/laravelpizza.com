<?php

declare(strict_types=1);

/**
 * Contratto: unico owner Folio = Cms FolioVoltServiceProvider.
 * Non deve esistere App\Providers\FolioServiceProvider.
 *
 * @see Modules/Cms/docs/bmad/folio-volt-sole-owner.md
 */

<<<<<<< .merge_file_4VPbtG
<<<<<<< .merge_file_KtTFH1
use App\Providers\FolioServiceProvider;
=======
>>>>>>> .merge_file_Ty1hb7
=======
>>>>>>> .merge_file_2ISUPk
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
<<<<<<< .merge_file_4VPbtG
<<<<<<< .merge_file_KtTFH1
    Assert::assertFalse(class_exists(FolioServiceProvider::class, false));
});

test('Cms FolioVoltServiceProvider class exists and is the mount owner', function (): void {
    Assert::assertTrue(class_exists(FolioVoltServiceProvider::class));
=======
=======
>>>>>>> .merge_file_2ISUPk
    Assert::assertFalse(class_exists(\App\Providers\FolioServiceProvider::class, false));
});

test('Cms FolioVoltServiceProvider class exists and is the mount owner', function (): void {
<<<<<<< HEAD
    Assert::assertTrue(class_exists(\Modules\Cms\Providers\FolioVoltServiceProvider::class));
=======
    Assert::assertTrue(class_exists(FolioVoltServiceProvider::class));
>>>>>>> laraxot/dev
<<<<<<< .merge_file_4VPbtG
>>>>>>> .merge_file_Ty1hb7
=======
>>>>>>> .merge_file_2ISUPk
});
