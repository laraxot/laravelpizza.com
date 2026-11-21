<?php

declare(strict_types=1);

/**
 * Contratto: unico owner Folio = Cms FolioVoltServiceProvider.
 * Non deve esistere App\Providers\FolioServiceProvider.
 *
 * @see Modules/Cms/docs/bmad/folio-volt-sole-owner.md
 */

use PHPUnit\Framework\Assert;

test('app providers must not define FolioServiceProvider', function (): void {
    $path = base_path('app/Providers/FolioServiceProvider.php');
    Assert::assertFileDoesNotExist($path);
    Assert::assertFalse(class_exists(\App\Providers\FolioServiceProvider::class, false));
});

test('Cms FolioVoltServiceProvider class exists and is the mount owner', function (): void {
    Assert::assertTrue(class_exists(\Modules\Cms\Providers\FolioVoltServiceProvider::class));
});
