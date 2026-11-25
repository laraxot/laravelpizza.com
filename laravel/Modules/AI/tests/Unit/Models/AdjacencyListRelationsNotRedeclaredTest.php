<?php

declare(strict_types=1);

namespace Modules\Xot\Tests\Unit\Models;

use Modules\Xot\Tests\TestCase;

use function Safe\file_get_contents;
use function Safe\glob;
use function Safe\preg_match;

uses(TestCase::class);

/**
 * Un model che compone l'adjacency list non riscrive le relazioni che il trait gli da'.
 *
 * `Staudenmeir\LaravelAdjacencyList\Eloquent\HasRecursiveRelationships` fornisce
 * `children()`, `parent()`, `ancestors()`, `descendants()`, `siblings()` e le varianti
 * `*AndSelf()`. Riscriverle a mano come `hasMany`/`belongsTo` non e' ridondanza innocua:
 * **i metodi di una classe vincono su quelli di un trait**, quindi la versione manuale
 * scavalca quella ricorsiva in silenzio — `children()` continua a funzionare, ma
 * `descendants()` e `toTree()` partono da presupposti diversi.
 *
 * Successo il 2026-09-08 su `BaseRating`, che aveva `parent()` e `children()` scritti a
 * mano con un docblock che diceva «fornita da HasRecursiveRelationships»: il commento
 * sapeva quello che il codice ignorava.
 *
 * ## Perche' legge il sorgente e non usa la Reflection
 *
 * I trait sono **flattened** nella classe che li compone: per un metodo che viene da un
 * trait, `getDeclaringClass()` restituisce **la classe**, non il trait. Una guardia basata
 * sulla Reflection segnalerebbe come violazione ogni model che usa correttamente il trait —
 * misurato: 20 falsi positivi su 5 model, cioe' tutti. E' la stessa trappola per cui
 * `self::class` dentro un trait vale la classe che lo compone.
 */
test('nessun model con adjacency list ridichiara le relazioni del trait', function (): void {
    $relations = [
        'children', 'parent', 'ancestors', 'descendants', 'siblings',
        'ancestorsAndSelf', 'descendantsAndSelf', 'childrenAndSelf', 'parentAndSelf',
    ];

    $offenders = [];

    /** @var list<string> $files */
    $files = glob(base_path('Modules/*/app/Models/*.php'));

    foreach ($files as $file) {
        $source = file_get_contents($file);

        // Solo i model che compongono davvero il trait: gli altri sono liberi.
        if (preg_match('/use\s+[\w\\\\]*(?:AdjacencyList|RecursiveRelationships)\w*;/', $source) !== 1) {
            continue;
        }

        if (preg_match('/^(?:final\s+|abstract\s+)?class\s+(\w+)/m', $source, $class) !== 1) {
            continue;
        }

        $className = (string) ($class[1] ?? '');

        foreach ($relations as $relation) {
            if (preg_match('/function\s+'.$relation.'\s*\(/', $source) === 1) {
                $offenders[] = $className.'::'.$relation.'()';
            }
        }
    }

    expect($offenders)->toBe([]);
});

test('i model ad albero del progetto compongono davvero il trait', function (): void {
    // Contraltare del test sopra: se il trait sparisse da tutti, il primo passerebbe
    // per assenza di soggetti invece che per correttezza.
    $composers = [];

    /** @var list<string> $files */
    $files = glob(base_path('Modules/*/app/Models/*.php'));

    foreach ($files as $file) {
        $source = file_get_contents($file);

        if (preg_match('/use\s+[\w\\\\]*(?:AdjacencyList|RecursiveRelationships)\w*;/', $source) === 1) {
            $composers[] = basename($file, '.php');
        }
    }

    expect(count($composers))->toBeGreaterThanOrEqual(4);
});
