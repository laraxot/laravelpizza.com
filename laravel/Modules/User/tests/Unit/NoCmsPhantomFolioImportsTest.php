<?php

declare(strict_types=1);

use Symfony\Component\Finder\Finder;

use function Safe\file_get_contents;

/**
 * Behaviour: le Folio pages di User non importano Modules\Cms e non esiste un archivio `pages/pages`.
 * Il modulo e' condiviso: in questo progetto Modules/Cms esiste, quindi NON si asserisce l'assenza
 * della cartella Cms ne' quella di `resources/views/pages` (tracciata e popolata).
 *
 * @see Modules/Cms/app/Providers/FolioVoltServiceProvider.php (unico owner Folio+Volt)
 * @see Modules/User/docs/architecture/auth-blade-structure.md
 * @see Modules/User/docs/adr/frontoffice-login-page-ownership.md
 */
test('user folio pages do not import modules cms', function (): void {
    $pagesPath = dirname(__DIR__, 2).'/resources/views/pages';

    expect(is_dir($pagesPath))->toBeTrue();

    $files = Finder::create()
        ->in($pagesPath)
        ->files()
        ->name('*.blade.php');

    foreach ($files as $file) {
        $contents = file_get_contents($file->getPathname());

        expect($contents)
            ->not()->toContain('Modules\\Cms\\')
            ->and($contents)
            ->not()->toContain('PageSlugMiddleware');
    }
});

test('user has no phantom cms pages archive under folio pages', function (): void {
    $phantomArchive = dirname(__DIR__, 2).'/resources/views/pages/pages';

    expect(is_dir($phantomArchive))->toBeFalse();
});
