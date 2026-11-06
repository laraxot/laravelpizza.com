<?php

declare(strict_types=1);

namespace Modules\Xot\Tests\Unit\Docs;

use Modules\Xot\Tests\TestCase;

use function Safe\file_get_contents;
use function Safe\preg_match_all;

uses(TestCase::class);

/**
 * I file citati dai `CLAUDE.md` esistono.
 *
 * I `CLAUDE.md` sono istruzioni caricate a ogni sessione: un riferimento a un file che non
 * c'e' non produce nessun errore, non compare in nessun log, e chi lo segue conclude che
 * la regola non esiste. Trovato cosi' il 2026-09-08: `.claude/CLAUDE.md` chiudeva la
 * sezione «BMAD obbligatorio» con «Memoria collegata: feedback_bmad_mandatory.md», e quel
 * file non era mai stato scritto.
 *
 * Il test cerca per **basename** in tutto il repo, non per percorso: i `CLAUDE.md` citano
 * spesso il solo nome del file, e pretendere il path completo produrrebbe falsi positivi
 * senza aggiungere garanzie.
 */
test('ogni file citato nei CLAUDE.md esiste nel repo', function (): void {
    $roots = [
        base_path('../CLAUDE.md'),
        base_path('../.claude/CLAUDE.md'),
        base_path('CLAUDE.md'),
    ];

    $missing = [];

    foreach ($roots as $file) {
        if (! is_file($file)) {
            continue;
        }

        $source = file_get_contents($file);
        $matches = [];

        preg_match_all('/`([A-Za-z0-9_.\/-]+\.(?:md|mdc|sh|php|yaml|json))`/', $source, $matches);

        foreach ($matches[1] as $reference) {
            // `-1.md`, `appunti-continuous-integration-tools.md`, `-3.md` nelle istruzioni sono l'ESEMPIO di cosa e' vietato nei nomi dei file (regola dell'utente 2026-10-15), non file.
            if (str_starts_with($reference, '-') || referenceExistsInRepo($reference)) {
                continue;
            }

            $missing[] = basename($file).' → '.$reference;
        }
    }

    expect(array_values(array_unique($missing)))->toBe([]);
});

function referenceExistsInRepo(string $reference): bool
{
    $root = base_path('..');

    if (is_file($root.'/'.$reference)) {
        return true;
    }

    $needle = basename($reference);

    $iterator = new \RecursiveIteratorIterator(
        new \RecursiveDirectoryIterator($root, \FilesystemIterator::SKIP_DOTS),
        \RecursiveIteratorIterator::LEAVES_ONLY,
        \RecursiveIteratorIterator::CATCH_GET_CHILD
    );

    foreach ($iterator as $entry) {
        if (! $entry instanceof \SplFileInfo) {
            continue;
        }

        $path = $entry->getPathname();

        if (str_contains($path, '/vendor/') || str_contains($path, '/node_modules/') || str_contains($path, '/.git/')) {
            continue;
        }

        if ($entry->getFilename() === $needle) {
            return true;
        }
    }

    return false;
}
