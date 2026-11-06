<?php

declare(strict_types=1);

namespace Modules\Xot\Tests\Unit\Docs;

use Modules\Xot\Tests\TestCase;

use function Safe\glob;
use function Safe\preg_match;

uses(TestCase::class);

/**
 * I nomi dei file in `docs/chat/` non contengono date.
 *
 * Regola: `docs/wiki/rules/docs-chat-filename-no-dates.md`. La data e' gia' nel git
 * history; nel nome rende inutile `git log`, spezza il raggruppamento per argomento e
 * produce due file per lo stesso tema a due giorni di distanza.
 *
 * Il debito e' preesistente e ampio (96 file su 165 il 2026-09-08), quindi il test non
 * pretende zero: fissa un tetto che **puo' solo scendere**. Ogni file nuovo con la data
 * lo fa fallire; chi ne rinomina uno abbassa la costante. E' il modo per rendere una
 * regola effettiva senza bloccare il repo su una bonifica di 96 file.
 */
// Azzerato il 2026-10-15 dalla rinomina di massa (DCP-201, `md-filenames.py apply`): 0 file con data in docs/chat. Non deve piu' salire.
const CHAT_FILES_WITH_DATE_BASELINE = 0;

/**
 * @return list<string>
 */
function chatFilesWithDateInName(): array
{
    $offenders = [];

    /** @var list<string> $files */
    $files = glob(base_path('../docs/chat/*.md'));

    foreach ($files as $file) {
        $name = basename($file);

        // Qualunque posizione: prefisso, mezzo o coda. La regola le vieta tutte.
        if (preg_match('/\d{4}-\d{2}-\d{2}/', $name) === 1) {
            $offenders[] = $name;
        }
    }

    sort($offenders);

    return $offenders;
}

test('nessun file nuovo in docs/chat porta la data nel nome', function (): void {
    $offenders = chatFilesWithDateInName();

    expect(count($offenders))->toBeLessThanOrEqual(
        CHAT_FILES_WITH_DATE_BASELINE,
        'Un file nuovo con la data nel nome: la data va nel frontmatter o in una sezione '
        .'del documento, non nel filename. Vedi docs/wiki/rules/docs-chat-filename-no-dates.md'
    );
});

test('il tetto e allineato al debito reale, cosi il test resta utile', function (): void {
    // Se la bonifica procede e il tetto non scende, il test smette di misurare qualcosa:
    // torna verde per inerzia e il prossimo file sbagliato passa inosservato.
    $offenders = chatFilesWithDateInName();

    expect(count($offenders))->toBeGreaterThan(
        CHAT_FILES_WITH_DATE_BASELINE - 10,
        'Sono stati rinominati piu'."'".' di 10 file: abbassa CHAT_FILES_WITH_DATE_BASELINE '
        .'al numero attuale ('.count($offenders).').'
    );
});

test('i file senza data sono la forma corretta', function (): void {
    /** @var list<string> $files */
    $files = glob(base_path('../docs/chat/*.md'));

    expect($files)->not->toBeEmpty();

    $clean = array_diff(array_map('basename', $files), chatFilesWithDateInName());

    expect($clean)->not->toBeEmpty();
});
