<?php

declare(strict_types=1);

namespace Modules\Xot\Tests\Unit\Docs;

use Modules\Xot\Tests\TestCase;

use function Safe\preg_match;

uses(TestCase::class);

/**
 * Due story non possono avere lo stesso numero.
 *
 * Il numero di una story è il suo indirizzo: ci si rimanda dentro le altre story,
 * nei commit, in `docs/sprint-status.yaml` e nei messaggi fra sessioni. Se due file
 * lo condividono, «vedi 18.34» smette di indicare qualcosa.
 *
 * Non è teorico: il 2026-09-08 due sessioni che lavoravano sulla stessa richiesta
 * hanno prodotto **due 18.34 e due 18.35** nello stesso modulo, con una coppia che
 * era anche lo stesso argomento scritto due volte. Nessuno se n'è accorto finché non
 * si è andati a cercare un rimando.
 *
 * Il debito storico è grosso (74 numeri duplicati sull'intero repo), quindi la
 * guardia usa un tetto che **può solo scendere**: impedisce di aggiungerne, non
 * pretende la bonifica in un colpo.
 *
 * @see docs/wiki/rules/bmad-story-numbering.md
 */

/**
 * @return array<string, list<string>> numero => file che lo usano
 */
function storyNumberCollisions(): array
{
    $byNumber = [];

    foreach ([base_path('Modules'), base_path('Themes')] as $root) {
        if (! is_dir($root)) {
            continue;
        }

        $iterator = new \RecursiveIteratorIterator(
            new \RecursiveDirectoryIterator($root, \FilesystemIterator::SKIP_DOTS)
        );

        foreach ($iterator as $fileInfo) {
            if (! $fileInfo instanceof \SplFileInfo || ! str_ends_with($fileInfo->getFilename(), '.story.md')) {
                continue;
            }

            if (! str_contains($fileInfo->getPathname(), '/docs/stories/')) {
                continue;
            }

            $matches = [];

            if (preg_match('/^(\d+\.\d+)\./', $fileInfo->getFilename(), $matches) !== 1) {
                continue; // le story senza numero sono legittime: si indirizzano per nome
            }

            $number = (string) ($matches[1] ?? '');

            if ($number === '') {
                continue;
            }

            $byNumber[$number][] = str_replace(base_path().'/', '', $fileInfo->getPathname());
        }
    }

    return array_filter($byNumber, static fn (array $files): bool => count($files) > 1);
}

/**
 * Tetto misurato il 2026-09-08. Scende con la bonifica, non sale mai.
 */
const STORY_NUMBER_COLLISION_BASELINE = 57;

test('nessuna story nuova riusa un numero gia preso', function (): void {
    $collisions = storyNumberCollisions();

    expect(count($collisions))->toBeLessThanOrEqual(
        STORY_NUMBER_COLLISION_BASELINE,
        "Due story con lo stesso numero: il numero è l'indirizzo con cui le altre story ".
        "la citano.\nPrendi il primo numero libero del modulo.\nCollisioni:\n".
        implode("\n", array_map(
            static fn (string $n, array $f): string => "  {$n}: ".implode(' | ', $f),
            array_keys($collisions),
            $collisions,
        ))
    );
});

test('il tetto resta allineato, cosi la guardia continua a misurare', function (): void {
    expect(count(storyNumberCollisions()))->toBeGreaterThan(
        STORY_NUMBER_COLLISION_BASELINE - 10,
        'Sono state rinumerate più di 10 story: abbassa STORY_NUMBER_COLLISION_BASELINE '
        .'al numero attuale ('.count(storyNumberCollisions()).').'
    );
});
