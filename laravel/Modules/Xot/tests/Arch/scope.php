<?php

declare(strict_types=1);

namespace Modules\Xot\Tests\Arch;

use Composer\Autoload\ClassLoader;
use RuntimeException;

use function Safe\file_get_contents;
use function Safe\glob;
use function Safe\json_decode;

/*
 * Ambito dei test di architettura (Pest arch()): i namespace di produzione di ogni modulo e tema.
 *
 * Perche' non `expect('Modules')`: Pest risolve un namespace dalla mappa PSR-4 di Composer, e nwidart registra un
 * prefisso per modulo (`Modules\Geo\` → `Modules/Geo/app/`), mai `Modules\`. Una regola scritta su `Modules` passa
 * senza controllare nulla (misurato: `expect('Modules')->not->toHaveSuffix('Service')` verde con 22 Service presenti).
 * Qui si leggono i prefissi dai composer.json dei pacchetti, e `scope_is_resolvable()` verifica che Pest li veda.
 *
 * ADR: Modules/Xot/docs/adr/architecture-tests-pest-arch.md.
 */

/**
 * Namespace di produzione (la voce PSR-4 che punta ad `app/`) di ogni pacchetto, senza la barra finale.
 *
 * @param  'modules'|'themes'|'all'  $kind
 * @return list<string> es. ['Modules\Activity', 'Modules\AI', ...]
 */
function production_namespaces(string $kind = 'all'): array
{
    $laravel = dirname(__DIR__, 4);
    $patterns = match ($kind) {
        'modules' => [$laravel.'/Modules/*/composer.json'],
        'themes' => [$laravel.'/Themes/*/composer.json'],
        'all' => [$laravel.'/Modules/*/composer.json', $laravel.'/Themes/*/composer.json'],
    };

    $namespaces = [];
    foreach ($patterns as $pattern) {
        foreach (glob($pattern) as $file) {
            if (! is_string($file)) {
                continue;
            }
            foreach (composer_psr4($file, 'autoload') as $namespace => $directory) {
                if (rtrim($directory, '/') === 'app') {
                    $namespaces[] = rtrim($namespace, '\\');
                }
            }
        }
    }
    sort($namespaces);

    return array_values(array_unique($namespaces));
}

/**
 * Namespace di produzione esclusi alcuni pacchetti (es. il modulo del progetto ospite).
 *
 * @param  list<string>  $except  namespace da togliere, es. il modulo del progetto ospite
 * @param  'modules'|'themes'|'all'  $kind
 * @return list<string>
 */
function production_namespaces_except(array $except, string $kind = 'all'): array
{
    return array_values(array_diff(production_namespaces($kind), $except));
}

/**
 * Namespace di factory e seeder di ogni pacchetto (`<Namespace>\Database\...`).
 *
 * @return list<string>
 */
function database_namespaces(): array
{
    return array_map(static fn (string $namespace): string => $namespace.'\Database', production_namespaces());
}

/**
 * Nome completo di ogni file PHP sotto `app/` dei pacchetti, ricavato dal percorso (PSR-4).
 *
 * @return list<string>
 */
function production_classes(): array
{
    $laravel = dirname(__DIR__, 4);
    $classes = [];
    foreach (production_namespaces() as $namespace) {
        [$kind, $package] = explode('\\', $namespace, 2);
        $root = $laravel.'/'.$kind.'/'.$package.'/app';
        if (! is_dir($root)) {
            continue;
        }
        $files = new \RecursiveIteratorIterator(new \RecursiveDirectoryIterator($root, \FilesystemIterator::SKIP_DOTS));
        foreach ($files as $file) {
            if ($file instanceof \SplFileInfo && $file->getExtension() === 'php' && ! str_ends_with($file->getFilename(), '.blade.php')) {
                $relative = substr($file->getPathname(), strlen($root) + 1, -4);
                $classes[] = $namespace.'\\'.str_replace('/', '\\', $relative);
            }
        }
    }
    sort($classes);

    return $classes;
}

/**
 * Namespace dei test di ogni pacchetto: Pest li include nei preset (sono prefissi PSR-4 dei moduli), qui si escludono.
 *
 * @return list<string>
 */
function test_namespaces(): array
{
    return array_map(static fn (string $namespace): string => $namespace.'\Tests', production_namespaces());
}

/**
 * Namespace dell'elenco che Pest non saprebbe risolvere (nessun prefisso PSR-4 li contiene): una regola su di loro
 * passerebbe senza controllare nulla.
 *
 * @param  list<string>  $namespaces
 * @return list<string>
 */
function unresolvable_namespaces(array $namespaces): array
{
    $prefixes = array_keys(composer_loader()->getPrefixesPsr4());

    return array_values(array_filter(
        $namespaces,
        static function (string $namespace) use ($prefixes): bool {
            foreach ($prefixes as $prefix) {
                if (str_starts_with($namespace.'\\', $prefix)) {
                    return false;
                }
            }

            return true;
        },
    ));
}

/**
 * Voci PSR-4 (stringa → stringa) di una sezione di un composer.json; [] se mancano o hanno un formato diverso.
 *
 * @param  'autoload'|'autoload-dev'  $section
 * @return array<string, string>
 */
function composer_psr4(string $file, string $section): array
{
    $json = json_decode(file_get_contents($file), true);
    if (! is_array($json) || ! is_array($json[$section] ?? null) || ! is_array($json[$section]['psr-4'] ?? null)) {
        return [];
    }

    $psr4 = [];
    foreach ($json[$section]['psr-4'] as $namespace => $directory) {
        if (is_string($namespace) && is_string($directory)) {
            $psr4[$namespace] = $directory;
        }
    }

    return $psr4;
}

/**
 * File di debito dei pacchetti: namespace del pacchetto => percorso di `tests/Arch/debt.php`.
 *
 * @return array<string, string>
 */
function debt_files(): array
{
    $laravel = dirname(__DIR__, 4);
    $files = [];
    foreach (production_namespaces() as $namespace) {
        [$kind, $package] = explode('\\', $namespace, 2);
        $file = $laravel.'/'.$kind.'/'.$package.'/tests/Arch/debt.php';
        if (is_file($file)) {
            $files[$namespace] = $file;
        }
    }

    return $files;
}

/**
 * @return array<string, list<string>> regola => classi
 */
function read_debt_file(string $file): array
{
    $data = require $file;
    if (! is_array($data)) {
        throw new RuntimeException($file.' deve restituire un array regola => classi');
    }

    $debt = [];
    foreach ($data as $rule => $entries) {
        if (! is_string($rule) || ! is_array($entries)) {
            throw new RuntimeException($file.': formato regola => list<string>');
        }
        $debt[$rule] = array_values(array_filter($entries, is_string(...)));
    }

    return $debt;
}

function composer_loader(): ClassLoader
{
    foreach (spl_autoload_functions() as $function) {
        if (is_array($function) && $function[0] instanceof ClassLoader) {
            return $function[0];
        }
    }

    throw new RuntimeException('Composer ClassLoader non registrato');
}

/**
 * I temi non passano dal merge-plugin di laravel/composer.json: a runtime li registra
 * `Modules\Xot\Actions\Composer\RegisterRuntimePsr4NamespacesAction`, che pero' richiede l'applicazione.
 * I test arch girano senza applicazione: qui si registrano gli stessi prefissi, letti dai composer.json dei temi
 * (autoload e autoload-dev). Senza, ogni regola sui temi passerebbe senza controllare nulla.
 */
function register_theme_namespaces(): void
{
    $loader = composer_loader();
    $registered = $loader->getPrefixesPsr4();
    foreach (glob(dirname(__DIR__, 4).'/Themes/*/composer.json') as $file) {
        if (! is_string($file)) {
            continue;
        }
        foreach (['autoload', 'autoload-dev'] as $section) {
            foreach (composer_psr4($file, $section) as $namespace => $directory) {
                $path = dirname($file).'/'.rtrim($directory, '/');
                if (! isset($registered[$namespace]) && is_dir($path)) {
                    $loader->addPsr4($namespace, $path);
                }
            }
        }
    }
}

register_theme_namespaces();
