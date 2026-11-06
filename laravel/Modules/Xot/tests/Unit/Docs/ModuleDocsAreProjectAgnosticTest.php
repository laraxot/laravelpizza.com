<?php

declare(strict_types=1);

namespace Modules\Xot\Tests\Unit\Docs;

use Modules\Xot\Tests\TestCase;

use function Safe\file_get_contents;
use function Safe\preg_match_all;

uses(TestCase::class);

/**
 * I docs di un modulo non nominano il progetto ospite.
 *
 * Un modulo gira in più progetti: una frase che nomina un'installazione specifica
 * è falsa ovunque tranne che lì, e nessuno se ne accorge finché il modulo non
 * viene riusato.
 *
 * Il debito è enorme e storico, quindi la guardia non pretende zero: fissa un
 * tetto che **può solo scendere**. Impedisce che un file nuovo aggiunga
 * occorrenze, che è la parte applicabile subito.
 *
 * @see docs/wiki/rules/project-agnostic.md
 */

/**
 * Nomi di installazioni note. Vivono qui e non nel wiki: elencarli in un documento
 * agnostico sarebbe la violazione che il documento vieta.
 *
 * @return list<string>
 */
function hostProjectNames(): array
{
    return ['fixcity', 'quaeris'];
}

/**
 * @return array<string, int> percorso relativo => occorrenze
 */
function moduleDocsWithHostProjectName(): array
{
    $hits = [];
    $pattern = '/'.implode('|', array_map(
        static fn (string $name): string => preg_quote($name, '/'),
        hostProjectNames()
    )).'/i';

    foreach ([base_path('Modules'), base_path('Themes')] as $root) {
        if (! is_dir($root)) {
            continue;
        }

        $iterator = new \RecursiveIteratorIterator(
            new \RecursiveDirectoryIterator($root, \FilesystemIterator::SKIP_DOTS)
        );

        foreach ($iterator as $fileInfo) {
            if (! $fileInfo instanceof \SplFileInfo || $fileInfo->getExtension() !== 'md') {
                continue;
            }

            $path = $fileInfo->getPathname();

            if (! str_contains($path, '/docs/')) {
                continue;
            }

            $count = preg_match_all($pattern, file_get_contents($path));

            if ($count > 0) {
                $hits[str_replace(base_path().'/', '', $path)] = $count;
            }
        }
    }

    return $hits;
}

/**
 * Tetto misurato il 2026-09-08. Scende con la bonifica, non sale mai.
 * Quando bonifichi, abbassalo: un ratchet che non scende torna verde per inerzia.
 */
const MODULE_DOCS_HOST_NAME_FILE_BASELINE = 1261;

test('nessun documento nuovo di modulo nomina il progetto ospite', function (): void {
    $hits = moduleDocsWithHostProjectName();

    expect(count($hits))->toBeLessThanOrEqual(
        MODULE_DOCS_HOST_NAME_FILE_BASELINE,
        "Un documento di modulo nomina un'installazione specifica. Un modulo gira in "
        .'più progetti: il dato specifico sta nella configurazione del progetto, non qui. '
        .'Vedi docs/wiki/rules/project-agnostic.md'
    );
});

test('il tetto resta allineato al debito, cosi la guardia continua a misurare', function (): void {
    $hits = moduleDocsWithHostProjectName();

    expect(count($hits))->toBeGreaterThan(
        MODULE_DOCS_HOST_NAME_FILE_BASELINE - 100,
        'Sono stati bonificati più di 100 file: abbassa MODULE_DOCS_HOST_NAME_FILE_BASELINE '
        .'al numero attuale ('.count($hits).').'
    );
});
