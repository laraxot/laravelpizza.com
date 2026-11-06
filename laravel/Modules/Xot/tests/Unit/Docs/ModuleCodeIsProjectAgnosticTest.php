<?php

declare(strict_types=1);

namespace Modules\Xot\Tests\Unit\Docs;

use Modules\Xot\Tests\TestCase;

use function Safe\file_get_contents;
use function Safe\preg_match;

uses(TestCase::class);

/**
 * Il **codice** dei moduli non nomina il progetto ospite.
 *
 * I moduli vivono in piu' progetti: un nome di progetto nel codice li rende portabili
 * solo verso il progetto in cui sono nati. Non e' una questione di stile — i danni
 * misurati il 2026-09-08:
 *
 * - `Schema::connection('<progetto>')` in `UserBusinessLogicTest`: quella connessione
 *   non esiste in questo checkout, quindi il ramo di skip non girava mai;
 * - `database_path('<progetto>_data.sqlite')` cablato in 12 `TestCase`: la suite di
 *   ogni modulo pretendeva il file di un progetto specifico;
 * - `cittadino@<progetto>.demo` in `DemoUserSeeder`, dentro il modulo User condiviso.
 *
 * A differenza della guardia sui documenti (`ModuleDocsAreProjectAgnosticTest`, che usa
 * un tetto decrescente perche' il debito .md e' di migliaia di file), qui la soglia e'
 * **zero**: il codice e' stato ripulito, e un'asserzione secca impedisce che rientri.
 *
 * Regola: `docs/wiki/rules/project-agnostic.md`.
 */
test('nessun file php dei moduli nomina un progetto ospite', function (): void {
    $forbidden = forbiddenProjectNames();
    $offenders = [];

    foreach (modulePhpFiles() as $file) {
        // La guardia stessa e la sua gemella contengono i nomi per definizione.
        if (str_contains($file, 'ModuleCodeIsProjectAgnosticTest')
            || str_contains($file, 'ModuleDocsAreProjectAgnosticTest')) {
            continue;
        }

        $source = file_get_contents($file);

        foreach ($forbidden as $name) {
            if (preg_match('/'.preg_quote($name, '/').'/i', $source) === 1) {
                $offenders[] = str_replace(base_path().'/', '', $file).' → '.$name;

                break;
            }
        }
    }

    expect($offenders)->toBe([]);
});

test('il nome del file sqlite di test non e cablato', function (): void {
    // sharedSqlitePath() e' la SSoT: config del progetto, poi l'unico *.sqlite presente,
    // poi un default neutro. Nessun modulo deve ricablare un nome.
    $offenders = [];

    foreach (modulePhpFiles() as $file) {
        if (str_contains($file, 'XotBaseTestCase')) {
            continue;
        }

        $source = file_get_contents($file);

        if (preg_match("/database_path\(\s*'[a-z_]*\.sqlite'\s*\)/i", $source) === 1) {
            $offenders[] = str_replace(base_path().'/', '', $file);
        }
    }

    expect($offenders)->toBe([]);
});

/**
 * @return list<string>
 */
function forbiddenProjectNames(): array
{
    // Progetti che condividono questi moduli. Aggiungerne uno qui e' il modo per
    // scoprire in un colpo solo dove il suo nome e' finito nel codice comune.
    return ['fixcity', 'quaeris'];
}

/**
 * @return list<string>
 */
function modulePhpFiles(): array
{
    $out = [];
    $root = base_path('Modules');

    $iterator = new \RecursiveIteratorIterator(
        new \RecursiveDirectoryIterator($root, \FilesystemIterator::SKIP_DOTS)
    );

    foreach ($iterator as $entry) {
        if (! $entry instanceof \SplFileInfo || $entry->getExtension() !== 'php') {
            continue;
        }

        $path = $entry->getPathname();

        // `build/` contiene la cache di PHPStan: copie di sorgenti gia' analizzati,
        // non codice del modulo. Analizzarle segnala violazioni gia' corrette.
        if (str_contains($path, '/vendor/')
            || str_contains($path, '/node_modules/')
            || str_contains($path, '/build/')) {
            continue;
        }

        $out[] = $path;
    }

    return $out;
}
