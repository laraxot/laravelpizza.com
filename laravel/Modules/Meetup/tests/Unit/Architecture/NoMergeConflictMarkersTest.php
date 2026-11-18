<?php

declare(strict_types=1);

/*
 * Nessun file del progetto contiene marcatori di conflitto git (<<<<<<<, =======, >>>>>>>).
 *
 * Il 13/11/2026 il sync dei moduli condivisi ha portato in dev 476 file con conflitti non risolti: un composer.json
 * non più JSON valido (CI ferma a "Install Dependencies" per giorni), classi PHP che non si caricavano, traduzioni e
 * docs con due versioni incollate. Questo test fa fallire la CI subito, indicando i file.
 * Analisi e regola: laravel/Modules/Xot/docs/lessons/module-sync-merge-conflicts.md
 */
test('no tracked file contains git merge conflict markers', function (): void {
    // Test puro sul filesystem e su git: niente applicazione Laravel.
    $root = dirname(__DIR__, 6);

    $output = [];
    $exit = 0;
    // git grep cerca solo nei file tracciati (niente vendor, node_modules, storage). -I salta i binari.
    exec('git -C '.escapeshellarg($root).' grep -I -l -E '.escapeshellarg('^(<<<<<<< |>>>>>>> )').' -- . 2>/dev/null', $output, $exit);

    // exit 1 = nessuna corrispondenza; 0 = trovati file; altro = git non disponibile (es. export senza .git).
    if ($exit > 1) {
        $this->markTestSkipped('git non disponibile: impossibile controllare i marcatori di conflitto.');
    }

    expect($output)->toBe([], "File con marcatori di conflitto non risolti:\n".implode("\n", $output));
});
