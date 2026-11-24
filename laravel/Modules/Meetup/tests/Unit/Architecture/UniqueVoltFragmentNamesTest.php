<?php

declare(strict_types=1);

/*
 * Ogni @volt('nome') delle pagine Folio (tema e moduli) ha un nome unico.
 *
 * Volt registra i frammenti per nome: se tema e modulo usano lo stesso nome, la pagina del tema mostra il frammento
 * del modulo. Dopo il sync del 13/11 il modulo User portava pages/auth/password/confirm.blade.php con
 * @volt('auth.password.confirm'), lo stesso nome del tema: /it/auth/password/confirm dava 500 (il frammento del modulo
 * include un partial che questo tema non ha). Il tema usa il prefisso "meetup." per i nomi che i moduli usano già.
 */
test('volt fragment names are unique across theme and module pages', function (): void {
    // Test puro sul filesystem: niente applicazione Laravel.
    $laravel = dirname(__DIR__, 5);
    $files = [
        ...(glob($laravel.'/Themes/*/resources/views/pages/{,*/,*/*/,*/*/*/}*.blade.php', GLOB_BRACE) ?: []),
        ...(glob($laravel.'/Modules/*/resources/views/pages/{,*/,*/*/,*/*/*/}*.blade.php', GLOB_BRACE) ?: []),
    ];

    expect($files)->not->toBeEmpty();

    $owners = [];
    foreach ($files as $file) {
        // Un tema non attivo non viene montato: conta solo il tema Meetup (quello di questo progetto).
        if (str_contains($file, '/Themes/') && ! str_contains($file, '/Themes/Meetup/')) {
            continue;
        }
        preg_match_all("/@volt\\('([^']+)'\\)/", (string) file_get_contents($file), $matches);
        foreach ($matches[1] as $name) {
            $owners[$name][] = substr($file, strlen($laravel) + 1);
        }
    }

    $duplicates = array_filter($owners, static fn (array $paths): bool => count($paths) > 1);

    expect($duplicates)->toBe([], 'Nomi @volt usati da più pagine: '.json_encode($duplicates, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES));
});
