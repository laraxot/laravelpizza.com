<?php

declare(strict_types=1);

namespace Modules\Xot\Tests\Unit\Models;

use Modules\Xot\Tests\TestCase;
use PHPUnit\Framework\Assert;

use function Safe\file_get_contents;
use function Safe\glob;
use function Safe\preg_match;

uses(TestCase::class);

/**
 * La risoluzione dinamica di classe passa da `XotBaseModel::getClassName()`,
 * mai da un resolver scritto a mano con ripiego su un altro modulo.
 *
 * Perche' una guardia e non una regola scritta: la regola c'era, ed era scritta due
 * volte — in `Xot/docs/wiki/concepts/xotbasemodel-get-class-name.md` e in
 * `Ptv/docs/dynamic-class-resolution-pattern.md`. Il secondo pero' chiamava la forma
 * a mano «pattern legacy ancora valido dove gia' presente», e da li' si e' propagata:
 * il 2026-09-09 era in quattro punti di Ptv e in `HasRatingsTrait::resolveRatingClass()`.
 *
 * Perche' e' grave e non stilistico: ogni modulo ha il suo model su una **connessione
 * diversa** con lo **stesso nome di tabella** (`ptv.schede`, `progressione.schede`;
 * `rating.ratings`, `progressione.ratings`, ...). Il ripiego
 *
 *     $c = class_exists($moduleClass) ? $moduleClass : AltroModulo\Models\X::class;
 *
 * non degrada: risponde con le righe di **un altro ente**, senza eccezione e senza log.
 * `getClassName()` invece fa `Assert::classExists()` e lancia — che e' la diagnosi
 * giusta: «a questo modulo manca `Models\X`».
 *
 * La guardia legge il **sorgente**, non usa la Reflection: i trait sono flattened nella
 * classe che li compone, quindi via Reflection un metodo che viene da un trait risulta
 * dichiarato dalla classe (stessa trappola di `AdjacencyListRelationsNotRedeclaredTest`).
 *
 * Tetto **decrescente**: oggi zero. Se qualcuno ne aggiunge uno, questo test lo dice.
 *
 * @see docs/wiki/concepts/xotbasemodel-get-class-name.md
 */

/**
 * File sorgente dei model di tutti i moduli, esclusi test, docs e vendor.
 *
 * @return list<string>
 */
function modelSourceFiles(): array
{
    $base = \dirname(__DIR__, 4);
    $out = [];

    foreach (glob($base.'/*/app/Models', GLOB_ONLYDIR) ?: [] as $dir) {
        if (! \is_string($dir)) {
            continue;
        }
        $it = new \RecursiveIteratorIterator(new \RecursiveDirectoryIterator($dir));
        foreach ($it as $file) {
            if (! $file instanceof \SplFileInfo || $file->getExtension() !== 'php') {
                continue;
            }
            $out[] = $file->getPathname();
        }
    }

    sort($out);

    return $out;
}

test('nessun model costruisce un FQCN a mano per risolvere una classe gemella', function (): void {
    // `Str::of(static::class)->beforeLast('\\')->append('\\Qualcosa')` e varianti:
    // e' la forma scritta a mano di getClassName().
    $handRolled = '/beforeLast\(\s*[\'"]\\\\\\\\[\'"]\s*\)[^;]{0,200}?->append\(/s';

    // `RelationX::buildPivotClassName()` non risolve un gemello: costruisce il nome di
    // una **pivot** a partire da un contesto, ed e' l'implementazione della primitiva
    // stessa (`guessPivotFullClass`). Non e' il difetto, e' il motore.
    $allowed = ['Modules/Xot/app/Models/Traits/RelationX.php'];

    $offenders = [];
    foreach (modelSourceFiles() as $file) {
        $rel = str_replace(\dirname(__DIR__, 5).'/', '', $file);
        if (\in_array($rel, $allowed, true)) {
            continue;
        }
        $src = file_get_contents($file);
        if (preg_match($handRolled, $src) === 1) {
            $offenders[] = $rel;
        }
    }

    Assert::assertSame(
        [],
        $offenders,
        "Risoluzione di classe scritta a mano invece di `<Model>::getClassName()`:\n  "
        .implode("\n  ", $offenders)
        ."\n\nOgni modulo ha il suo model su una connessione diversa con lo stesso nome di"
        .' tabella: il ripiego su un altro modulo legge un altro database in silenzio.'
        ."\nCanon: Modules/Xot/docs/wiki/concepts/xotbasemodel-get-class-name.md"
    );
});

test('nessun model ripiega su una classe di un altro modulo quando la propria manca', function (): void {
    // `class_exists($x) ? $x : Qualcosa::class` — il ripiego silenzioso.
    $silentFallback = '/class_exists\(\s*\$\w+\s*\)\s*\?\s*\$\w+\s*:\s*\w+::class/';

    $offenders = [];
    foreach (modelSourceFiles() as $file) {
        $src = file_get_contents($file);
        if (preg_match($silentFallback, $src) === 1) {
            $offenders[] = str_replace(\dirname(__DIR__, 5).'/', '', $file);
        }
    }

    Assert::assertSame(
        [],
        $offenders,
        "Ripiego silenzioso su un model di un altro modulo:\n  "
        .implode("\n  ", $offenders)
        ."\n\nUsare `<Model>::getClassName()`: se il gemello manca deve LANCIARE, non"
        .' rispondere con i dati di un altro ente.'
    );
});
