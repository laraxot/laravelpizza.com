<?php

declare(strict_types=1);

use Symfony\Component\Finder\Finder;

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
