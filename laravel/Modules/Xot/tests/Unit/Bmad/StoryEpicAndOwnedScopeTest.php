<?php

declare(strict_types=1);
use Modules\Xot\Tests\TestCase;
use PHPUnit\Framework\Assert;

use function Safe\file_get_contents;
use function Safe\preg_match;
use function Safe\preg_match_all;

uses(TestCase::class);

/**
 * Le story BMAD si shardano da `docs/epics.md`: il numero non si sceglie.
 *
 * Il 2026-09-08 l'utente ha rilevato «stai facendo errori con bmad». Misurato:
 * `docs/epics.md` definisce gli **Epic 1-7**, e 85 story su 394 numerate portano un epic
 * che non esiste (18 su 65 file, 17, 16, 9...). Il numero non era stato shardato con
 * `bmad-epics-and-stories`: era stato scelto leggendo l'elenco dei file.
 *
 * Da li' discende tutto il resto: due sessioni che leggono la stessa lista assegnano lo
 * stesso numero (75 duplicati misurati), e una story fuori epic non e' schedulabile ne'
 * verificabile contro la Story Ownership Boundary di `epics.md`.
 *
 * Stessa cosa per **Owned File/Module Scope**: e' il campo con cui BMAD pianifica il
 * lavoro parallelo senza conflitti, e `epics.md` dichiara «Scope Disjoint: no overlapping
 * Owned File/Module ranges». Senza quel campo il conflitto si scopre a merge, e si
 * finisce a sostituirlo con lock file e messaggi fra agenti.
 *
 * **Soglie a cricchetto, non a zero**: il debito e' preesistente e ampio. Il test non
 * chiede di sanarlo oggi, chiede che **non cresca**. Chi sana, abbassa la soglia.
 * La rinumerazione delle story esistenti e' un atto di planning e passa da
 * `bmad-correct-course`, mai da una `mv`.
 *
 * @see docs/epics.md
 * @see bmad-output/decision-log.md — «Le story "18.x" sono numerate su un epic che non esiste»
 */
$repoRoot = \dirname(__DIR__, 6);

/**
 * @return list<string>
 */
$storyFiles = static function () use ($repoRoot): array {
    $files = [];
    foreach (['laravel/Modules', 'laravel/Themes'] as $root) {
        $base = $repoRoot.'/'.$root;
        if (! is_dir($base)) {
            continue;
        }
        $it = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($base, FilesystemIterator::SKIP_DOTS));
        foreach ($it as $file) {
            if (! $file instanceof SplFileInfo) {
                continue;
            }
            $path = $file->getPathname();
            if (str_ends_with($path, '.story.md') && str_contains($path, '/docs/stories/')) {
                $files[] = $path;
            }
        }
    }
    sort($files);

    return $files;
};

test('gli epic dichiarati nelle story esistono in docs/epics.md', function () use ($repoRoot, $storyFiles): void {
    $epicsFile = $repoRoot.'/docs/epics.md';
    Assert::assertFileExists($epicsFile, 'docs/epics.md e\' la sorgente degli epic: senza, ogni numero di story e\' arbitrario.');

    $epics = [];
    preg_match_all('/^## Epic (\d+)/m', file_get_contents($epicsFile), $matches);
    foreach ($matches[1] as $n) {
        $epics[(int) $n] = true;
    }
    Assert::assertNotEmpty($epics, 'Nessun "## Epic N" trovato in docs/epics.md.');

    $orphans = [];
    foreach ($storyFiles() as $path) {
        $name = basename($path);
        if (preg_match('/^0*(\d+)\./', $name, $m) !== 1) {
            continue; // story senza numero: fuori dal perimetro di questo test
        }
        if (! isset($m[1])) {
            continue;
        }
        if (! isset($epics[(int) $m[1]])) {
            $orphans[] = $name;
        }
    }

    // Cricchetto: misurato 85 il 2026-09-08. Chi sana, abbassa questo numero.
    $soglia = 85;

    Assert::assertLessThanOrEqual(
        $soglia,
        \count($orphans),
        \sprintf(
            "Story con un epic che non esiste in docs/epics.md: %d (soglia %d).\n".
            "Il numero di una story si sharda da docs/epics.md con bmad-epics-and-stories, non si sceglie leggendo l'elenco dei file.\n".
            "Se l'epic serve davvero, si aggiunge a epics.md come atto di planning; non lo si inventa nel nome del file.\nEsempi: %s",
            \count($orphans),
            $soglia,
            implode(', ', \array_slice($orphans, 0, 5))
        )
    );
});

test('le story dichiarano il proprio Owned File/Module Scope', function () use ($storyFiles): void {
    $senzaScope = [];
    foreach ($storyFiles() as $path) {
        $content = file_get_contents($path);
        if (! str_contains($content, 'Owned File/Module Scope')) {
            $senzaScope[] = basename($path);
        }
    }

    // Cricchetto: misurato 348 su 471 il 2026-09-08.
    $soglia = 348;

    Assert::assertLessThanOrEqual(
        $soglia,
        \count($senzaScope),
        \sprintf(
            "Story senza Owned File/Module Scope: %d (soglia %d).\n".
            "E' il campo con cui BMAD pianifica il lavoro parallelo senza conflitti (docs/epics.md, \"Scope Disjoint\").\n".
            "Senza, il conflitto fra due agenti si scopre a merge e si finisce a sostituirlo con lock file.\nEsempi: %s",
            \count($senzaScope),
            $soglia,
            implode(', ', \array_slice($senzaScope, 0, 5))
        )
    );
});
