<?php

declare(strict_types=1);

/*
 * Folio esegue il blocco PHP iniziale di ogni pagina anche solo per leggere name() e middleware(), per esempio quando
 * si genera route('login') dentro un'email inviata dalla coda. Un setLocale() lì cambiava la lingua dell'intero processo
 * (le email in tedesco uscivano in italiano). La lingua la imposta il middleware SetFolioLocale del modulo Cms.
 */
test('Folio pages of the theme never change the locale', function (): void {
    // Test puro sul filesystem: niente applicazione Laravel (tests/Unit non la avvia).
    $pages = dirname(__DIR__, 5).'/Themes/Meetup/resources/views/pages';
    expect(is_dir($pages))->toBeTrue();

    $offenders = [];
    $files = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($pages, FilesystemIterator::SKIP_DOTS));
    foreach ($files as $file) {
        $contents = (string) file_get_contents($file->getPathname());
        if (preg_match('/(LaravelLocalization::|app\(\)->|App::)setLocale\(/', $contents) === 1) {
            $offenders[] = substr($file->getPathname(), strlen($pages) + 1);
        }
    }

    expect($offenders)->toBe([]);
});
