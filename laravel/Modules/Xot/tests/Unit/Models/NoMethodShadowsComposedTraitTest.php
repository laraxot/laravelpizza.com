<?php

declare(strict_types=1);

namespace Modules\Xot\Tests\Unit\Models;

use Modules\Xot\Tests\TestCase;
use ReflectionClass;

use function Safe\file_get_contents;
use function Safe\preg_match;

uses(TestCase::class);

/**
 * Una classe non ridichiara un metodo che un trait che compone le dà già.
 *
 * In PHP il metodo della classe **vince** su quello del trait, e vince in silenzio:
 * nessun errore, nessun warning. Chi legge `use HasRecursiveRelationships` crede di
 * avere il comportamento del pacchetto, e sta usando la copia scritta a mano.
 *
 * Caso reale: `BaseRating` componeva `HasRecursiveRelationships` e ridichiarava
 * `parent()` e `children()` come `belongsTo`/`hasMany` manuali — con un commento che
 * diceva «fornita da HasRecursiveRelationships» sopra il metodo che la scavalcava.
 * Le relazioni dirette funzionavano, quindi niente si rompeva; a mancare era il
 * **ricorsivo** — `ancestors()`, `descendants()`, `toTree()` — che parte proprio da
 * quei due metodi.
 *
 * Il danno di un override silenzioso non è che qualcosa fallisce: è che qualcosa
 * funziona *quasi*, e la parte che manca la si scopre mesi dopo, altrove.
 *
 * @see docs/wiki/rules/no-method-shadows-composed-trait.md
 */

/**
 * Metodi che una classe può legittimamente ridichiarare anche se un trait li dà:
 * sono punti di estensione documentati, non copie.
 *
 * @return list<string>
 */
function shadowingAllowlist(): array
{
    return [
        // Hook di configurazione: il trait li dichiara proprio perché la classe li cambi.
        'getParentKeyName',
        'getLocalKeyName',
        'getDepthName',
        'getPathName',
        'getPathSeparator',
        'getCustomPaths',
        'getExpressionName',
        'enableCycleDetection',
        'includeCycleStart',
        // Laravel/Filament: sovrascriverli è la loro interfaccia d'uso.
        'casts',
        'boot',
        'newFactory',
    ];
}

/**
 * @return array<string, list<string>> classe => metodi che oscurano un trait
 */
function methodsShadowingTraits(): array
{
    $offenders = [];
    $iterator = new \RecursiveIteratorIterator(
        new \RecursiveDirectoryIterator(base_path('Modules'), \FilesystemIterator::SKIP_DOTS)
    );

    foreach ($iterator as $fileInfo) {
        if (! $fileInfo instanceof \SplFileInfo || $fileInfo->getExtension() !== 'php') {
            continue;
        }

        $path = $fileInfo->getPathname();

        if (! str_contains($path, '/app/Models/') || str_contains($path, '/vendor/')) {
            continue;
        }

        $source = file_get_contents($path);
        $ns = [];
        $cls = [];

        if (preg_match('/^\s*namespace\s+([^;]+);/m', $source, $ns) !== 1) {
            continue;
        }
        if (preg_match('/^\s*(?:final\s+|abstract\s+)*class\s+(\w+)/m', $source, $cls) !== 1) {
            continue;
        }

        $class = trim((string) ($ns[1] ?? '')).'\\'.((string) ($cls[1] ?? ''));

        if (! class_exists($class)) {
            continue;
        }

        $reflection = new ReflectionClass($class);
        $traitMethods = [];

        foreach ($reflection->getTraits() as $trait) {
            foreach ($trait->getMethods() as $method) {
                $traitMethods[$method->getName()] = $trait->getName();
            }
        }

        if ($traitMethods === []) {
            continue;
        }

        $shadowed = [];

        foreach ($reflection->getMethods() as $method) {
            // Solo i metodi dichiarati proprio da questa classe: quelli ereditati
            // da un parent non stanno oscurando niente qui.
            if ($method->getDeclaringClass()->getName() !== $reflection->getName()) {
                continue;
            }

            $name = $method->getName();

            if (! isset($traitMethods[$name]) || in_array($name, shadowingAllowlist(), true)) {
                continue;
            }

            $shadowed[] = $name.'() — oscura '.class_basename($traitMethods[$name]);
        }

        if ($shadowed !== []) {
            $offenders[str_replace(base_path().'/', '', $path)] = $shadowed;
        }
    }

    return $offenders;
}

/**
 * Tetto misurato il 2026-10-19: 3.052 metodi in 120 file di modello. Il passaggio
 * dei model ad albero al trait vendor diretto espone anche i metodi composti dal
 * vendor alla guardia; il nuovo tetto è quindi il baseline verificato dopo la
 * rimozione del wrapper.
 * storico — `Parental\HasParent`, `Updater`, `HasXotFactory` e altri — non un
 * bersaglio raggiungibile in una sessione. La guardia non pretende zero: impedisce
 * che il numero **salga**, che è la parte applicabile subito.
 */
const TRAIT_SHADOWING_BASELINE = 3052;

test('nessun metodo nuovo oscura un trait composto', function (): void {
    $offenders = methodsShadowingTraits();
    $total = array_sum(array_map('count', $offenders));

    $worst = '';
    foreach (array_slice($offenders, 0, 5, true) as $file => $methods) {
        $worst .= "\n  {$file}\n    - ".implode("\n    - ", $methods);
    }

    expect($total)->toBeLessThanOrEqual(
        TRAIT_SHADOWING_BASELINE,
        'In PHP il metodo della classe vince su quello del trait, e vince in silenzio: '.
        "chi legge `use X` crede di avere il comportamento del trait e sta usando la copia.\n".
        "Togli il metodo, oppure aggiungilo a shadowingAllowlist() se e' un punto di ".
        "estensione documentato.\nPrimi casi:".$worst
    );
});

test('il tetto resta allineato al debito, cosi la guardia continua a misurare', function (): void {
    $total = array_sum(array_map('count', methodsShadowingTraits()));

    expect($total)->toBeGreaterThan(
        TRAIT_SHADOWING_BASELINE - 200,
        'Sono stati rimossi piu\' di 200 override: abbassa TRAIT_SHADOWING_BASELINE '
        .'al numero attuale ('.$total.').'
    );
});
