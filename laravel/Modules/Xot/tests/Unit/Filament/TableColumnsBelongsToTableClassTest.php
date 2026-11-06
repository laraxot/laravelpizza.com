<?php

declare(strict_types=1);

namespace Modules\Xot\Tests\Unit\Filament;

use Modules\Xot\Filament\Resources\Pages\XotBaseListRecords;
use Modules\Xot\Tests\TestCase;
use Webmozart\Assert\Assert as WebmozartAssert;

use function Safe\file_get_contents;
use function Safe\glob;
use function Safe\preg_match;

uses(TestCase::class)->group('no-db');

/**
 * Le colonne di una lista stanno nella Table class, mai sulla List page.
 *
 * `XotBaseResource::table()` arriva sempre a `Tables\{PluralModel}Table` via
 * `getTableClass()`: un `getTableColumns()` dichiarato su una List page non veniva
 * mai chiamato, e la lista usciva con meno colonne senza un errore ne' una riga di
 * log. Da quando il metodo sulla base e' `final` lo stesso codice manda la pagina in
 * `Cannot override final method` al load: da difetto silenzioso a pagina che non si apre.
 *
 * La guardia e' statica di proposito. Risolvere la catena con `is_subclass_of()`
 * richiederebbe di autoloadare la pagina, e una pagina che viola la regola non si
 * carica: il fatal ucciderebbe il processo invece di far fallire il test, cioe' la
 * violazione si presenterebbe come suite rotta e non come questa asserzione.
 *
 * Gemella di `FormSchemaBelongsToFormClassTest` per il lato tabella. Esiste perche'
 * la regola e' gia' regredita: la rimozione di `HasXotTable` da `XotBaseListRecords`
 * ha reso morti 90 hook di pagina in un istante e nessuno se n'e' accorto per giorni.
 *
 * @see docs/wiki/rules/xot-table-method-names.md
 * @see laravel/Modules/Xot/docs/stories/18.23.list-page-hook-tabella-morti-dopo-hasxottable.story.md
 */

/**
 * Tutte le pagine Filament dei moduli e dei temi.
 *
 * @return list<string>
 */
function filamentPageFiles(): array
{
    // Niente `glob()` con `**`: in PHP non e' ricorsivo, vale un solo livello, e le
    // pagine stanno due livelli sotto `Filament/` (`Resources/{X}Resource/Pages/`).
    // Un pattern che non matcha nulla renderebbe questa guardia verde per sbaglio.
    $roots = array_filter([
        base_path('Modules'),
        base_path('Themes'),
    ], 'is_dir');

    $files = [];
    foreach ($roots as $root) {
        $iterator = new \RecursiveIteratorIterator(
            new \RecursiveDirectoryIterator($root, \FilesystemIterator::SKIP_DOTS)
        );
        foreach ($iterator as $file) {
            // `RecursiveIteratorIterator` e' `Traversable<mixed>` per l'analisi statica:
            // il tipo si verifica, non si assume.
            WebmozartAssert::isInstanceOf($file, \SplFileInfo::class);

            $path = $file->getPathname();
            if ($file->getExtension() !== 'php') {
                continue;
            }
            if (! str_contains($path, '/app/Filament/')) {
                continue;
            }
            if (! str_contains($path, '/Pages/')) {
                continue;
            }
            $files[] = $path;
        }
    }

    return array_values(array_unique($files));
}

/**
 * FQCN della classe dichiarata nel file e del suo genitore.
 *
 * `extends Foo` da solo non identifica una classe: due moduli possono avere lo stesso
 * basename. Il genitore si risolve sugli `use` del file, altrimenti sul namespace.
 *
 * @return array{class: string, parent: string|null}|null
 */
function declaredClassAndParent(string $file): ?array
{
    $src = file_get_contents($file);

    if (preg_match('/^namespace\s+([^;]+);/m', $src, $ns) !== 1) {
        return null;
    }
    if (preg_match('/^(?:final\s+|abstract\s+)*class\s+(\w+)(?:\s+extends\s+([\w\\\\]+))?/m', $src, $cls) !== 1) {
        return null;
    }

    // I gruppi di cattura sono opzionali nel pattern: per l'analisi statica l'offset
    // puo' non esistere anche dopo un match. Si legge con `??`, non si da' per scontato.
    $namespace = trim((string) ($ns[1] ?? ''));
    $name = (string) ($cls[1] ?? '');
    $parent = (string) ($cls[2] ?? '');

    if ($namespace === '' || $name === '') {
        return null;
    }

    $class = $namespace.'\\'.$name;

    if ($parent === '') {
        return ['class' => $class, 'parent' => null];
    }
    if (str_contains($parent, '\\')) {
        return ['class' => $class, 'parent' => ltrim($parent, '\\')];
    }
    if (preg_match('/^use\s+([\w\\\\]*\\\\'.preg_quote($parent, '/').')\s*;/m', $src, $imp) === 1) {
        $imported = (string) ($imp[1] ?? '');

        if ($imported !== '') {
            return ['class' => $class, 'parent' => $imported];
        }
    }

    return ['class' => $class, 'parent' => $namespace.'\\'.$parent];
}

/**
 * Le List page: quelle che risalgono a `XotBaseListRecords`, a qualunque distanza.
 *
 * Le `XotBaseManageRelatedRecords` restano fuori di proposito — li' l'hook non e'
 * `final` ed e' il punto di estensione previsto.
 *
 * @return array<string, string> FQCN => file
 */
function listPageFiles(): array
{
    $parents = [];
    $files = [];

    foreach (filamentPageFiles() as $file) {
        $info = declaredClassAndParent($file);
        if ($info === null) {
            continue;
        }
        $parents[$info['class']] = $info['parent'];
        $files[$info['class']] = $file;
    }

    $base = 'Modules\\Xot\\Filament\\Resources\\Pages\\XotBaseListRecords';
    $pages = [];

    foreach (array_keys($parents) as $class) {
        $current = $parents[$class] ?? null;

        for ($hop = 0; $hop < 10 && $current !== null; $hop++) {
            if ($current === $base) {
                $pages[$class] = $files[$class];
                break;
            }
            $current = $parents[$current] ?? null;
        }
    }

    unset($pages[$base]);

    return $pages;
}

/**
 * Il file dichiara davvero il metodo? Col tokenizer, mai con un regex.
 *
 * Un `/​* ... *​/` attorno a un vecchio `getTableColumns()` — ce n'e' almeno uno in
 * `Performance/ListOrganizzativas` — fa scattare qualunque `preg_match`, e una guardia
 * che grida su codice commentato viene disattivata invece che rispettata.
 */
function declaresMethod(string $file, string $method): bool
{
    $tokens = token_get_all(file_get_contents($file));
    $count = count($tokens);

    for ($i = 0; $i < $count; $i++) {
        $token = $tokens[$i];
        if (! is_array($token) || $token[0] !== T_FUNCTION) {
            continue;
        }
        for ($j = $i + 1; $j < $count; $j++) {
            if (! is_array($tokens[$j])) {
                continue;
            }
            if ($tokens[$j][0] === T_WHITESPACE) {
                continue;
            }
            if ($tokens[$j][0] === T_STRING && $tokens[$j][1] === $method) {
                return true;
            }
            break;
        }
    }

    return false;
}

test('nessuna List page dichiara getTableColumns()', function (): void {
    $offenders = [];

    foreach (listPageFiles() as $file) {
        if (declaresMethod($file, 'getTableColumns')) {
            $offenders[] = str_replace(base_path().'/', '', $file);
        }
    }

    expect($offenders)->toBe([]);
});

test('XotBaseListRecords::getTableColumns() e\' final', function (): void {
    $method = new \ReflectionMethod(XotBaseListRecords::class, 'getTableColumns');

    expect($method->isFinal())->toBeTrue();
});

test('la guardia vede davvero delle List page', function (): void {
    // Senza questa asserzione un errore nella risoluzione della catena renderebbe
    // la lista vuota e il test sopra verde per il motivo sbagliato.
    expect(count(listPageFiles()))->toBeGreaterThan(100);
});
