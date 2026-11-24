<?php

declare(strict_types=1);

<<<<<<< .merge_file_5ZUmaA
use App\Providers\FolioServiceProvider;
use Symfony\Component\Finder\Finder;

use function Safe\file_get_contents;

/**
 * Behaviour: le Folio pages di User non importano Modules\Cms e non esiste un archivio `pages/pages`.
 * Il modulo e' condiviso: in questo progetto Modules/Cms esiste, quindi NON si asserisce l'assenza
 * della cartella Cms ne' quella di `resources/views/pages` (tracciata e popolata).
 *
 * @see FolioServiceProvider stub no-op
 * @see Modules/User/docs/architecture/auth-blade-structure.md
 * @see Modules/User/docs/adr/frontoffice-login-page-ownership.md
 */
=======
use Symfony\Component\Finder\Finder;

<<<<<<< HEAD
use function Safe\file_get_contents;

/**
 * Behaviour: PTVX senza Cms — User non importa Modules\Cms nelle Folio pages.
 * Existing: NoCommentModuleDependencyTest.php (pattern Comment); nessuno per Cms.
 * User: «Aggiungi/aggiorna Pest unit che asserisce assenza Cms e assenza route/page phantom».
 *
 * @see App\Providers\FolioServiceProvider stub no-op
 */
test('cms module directory is absent in this portfolio', function (): void {
    $cmsPath = dirname(__DIR__, 2).'/../Cms';

    expect(is_dir($cmsPath))->toBeFalse();
});

>>>>>>> .merge_file_Ygx93a
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
<<<<<<< .merge_file_5ZUmaA
=======
=======
/**
 * Il modulo User conserva i vecchi template in `pages_old/` come materiale di
 * riferimento/stub; la directory `pages/` deve restare assente per non
 * registrarli accidentalmente come pagine Folio.
 *
 * @see Modules/User/docs/architecture/auth-blade-structure.md
 * @see Modules/User/docs/adr/frontoffice-login-page-ownership.md
 */
test('user keeps legacy page templates outside the Folio mount', function (): void {
    $viewsPath = dirname(__DIR__, 2).'/resources/views';
    $activePagesPath = $viewsPath.'/pages';
    $legacyPagesPath = $viewsPath.'/pages_old';

    expect($activePagesPath)->not->toBeDirectory();
    expect($legacyPagesPath)->toBeDirectory();

    $files = iterator_to_array(
        Finder::create()
            ->in($legacyPagesPath)
            ->files()
            ->name('*.blade.php'),
    );

    expect($files)->not->toBeEmpty();
});

test('user has no nested phantom pages directory in the active view tree', function (): void {
    $phantomArchive = dirname(__DIR__, 2).'/resources/views/pages/pages';

    expect($phantomArchive)->not->toBeDirectory();
>>>>>>> laraxot/dev
>>>>>>> .merge_file_Ygx93a
});
