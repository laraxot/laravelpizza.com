<?php

declare(strict_types=1);

namespace Modules\Xot\Tests\Unit\Docs;

use function Safe\file_get_contents;
use function Safe\glob;
use function Safe\preg_match_all;

/**
 * Uno screenshot in un manuale vale solo se la pagina è davvero quella.
 *
 * Una unità (modulo o tema) che ha `docs/manuals/screenshots.json` ha adottato la pipeline di
 * `bashscripts/tools/docs/manual-screenshots.mjs`: ogni immagine che il suo manuale incorpora deve avere una cattura registrata
 * nel manifest (data, HTTP, sha256) e il file deve essere ancora quello catturato. Il 25 novembre 2026 un
 * `rating-admin-dashboard.png` era la pagina di login, e fu riscritto tre volte da un altro attore: senza questa
 * guardia ognuno vede «un'immagine» e nessuno vede che è sbagliata. Le unità senza manifest non sono toccate (adozione per unità).
 *
 * @see Modules/Xot/docs/stories/0176-manuali-moduli-screenshot-reali.story.md
 */

/**
 * @return array<string, array{dir: string, shots: array<string, string>}> unità => cartella manuals e sha256 catturato per nome
 */
function manualShotsAdoptingUnits(): array
{
    $units = [];

    foreach ([dirname(__DIR__, 4), dirname(__DIR__, 5).'/Themes'] as $root) {
        foreach (glob($root.'/*/docs/manuals/screenshots.json') as $manifest) {
            /** @var array{shots?: list<array{name?: string, captured?: array{sha256?: string}}>} $data */
            $data = json_decode(file_get_contents($manifest), true, 512, JSON_THROW_ON_ERROR);
            $shots = [];

            foreach ($data['shots'] ?? [] as $shot) {
                if (isset($shot['name'], $shot['captured']['sha256'])) {
                    $shots[$shot['name']] = $shot['captured']['sha256'];
                }
            }

            // Chiave "Modules/Meetup" e non "Meetup": un modulo e un tema possono avere lo stesso nome.
            $units[basename($root).'/'.basename(dirname($manifest, 3))] = ['dir' => dirname($manifest), 'shots' => $shots];
        }
    }

    return $units;
}

it('ogni immagine di un manuale con screenshots.json ha una cattura registrata e invariata', function (): void {
    $offenders = [];

    foreach (manualShotsAdoptingUnits() as $unit => $info) {
        foreach (glob($info['dir'].'/*.md') as $manual) {
            preg_match_all('/!\[[^\]]*\]\((assets\/[^)\s]+)\)/', file_get_contents($manual), $matches);

            foreach ($matches[1] as $relative) {
                $file = $info['dir'].'/'.$relative;
                $name = pathinfo($relative, PATHINFO_FILENAME);

                if (! is_file($file)) {
                    $offenders[] = "{$unit}: {$relative} non esiste";
                } elseif (! isset($info['shots'][$name])) {
                    $offenders[] = "{$unit}: {$relative} non ha una cattura in screenshots.json (screenshot non provato)";
                } elseif (hash_file('sha256', $file) !== $info['shots'][$name]) {
                    $offenders[] = "{$unit}: {$relative} è cambiata dopo la cattura (sha256 diverso)";
                }
            }
        }
    }

    expect($offenders)->toBe([]);
});
