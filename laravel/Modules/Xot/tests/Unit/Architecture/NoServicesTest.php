<?php

declare(strict_types=1);

namespace Modules\Xot\Tests\Unit\Architecture;

use FilesystemIterator;
use Modules\Xot\Tests\TestCase;
use RecursiveCallbackFilterIterator;
use RecursiveDirectoryIterator;
use RecursiveIteratorIterator;
use SplFileInfo;

use function Safe\file_get_contents;
use function Safe\glob;
use function Safe\preg_match;

uses(TestCase::class);

/*
 * Regola «No Services/Jobs» (story DCP-270): nel codice di produzione non esistono
 * cartelle app/Services, app/Servces o app/Jobs ne' classi in quei namespace diretti.
 * Un caso d'uso = una Action Spatie Queueable (`execute()`). I Jobs tecnici annidati
 * sotto un adapter (es. Exports/Jobs) non sono il confine applicativo vietato.
 *
 * Roots: `Modules/<M>/app`, `Themes/<T>/app`, `Themes/<T>/src` (albero storico) e `app/` di laravel.
 * Fuori dal controllo: `tests/` (una cartella di test non e' codice di produzione) e le viste (`views/services`
 * e' una pagina del sito, in minuscolo). Allowlist: nessuna, volutamente vuota. Ogni riesumazione da merge
 * (e' gia' successo: Geo, Notify, Xot, Fixcity) fa fallire questo test invece di passare in silenzio.
 */

/**
 * @return list<string>
 */
function productionRoots(): array
{
    $roots = [];
    foreach ([base_path('Modules/*/app'), base_path('Themes/*/app'), base_path('Themes/*/src'), base_path('app')] as $pattern) {
        foreach (glob($pattern) as $path) {
            if (is_string($path) && is_dir($path)) {
                $roots[] = $path;
            }
        }
    }

    return $roots;
}

/**
 * @return iterable<SplFileInfo>
 */
function walk(string $root): iterable
{
    $skip = ['vendor', 'node_modules', 'storage', '.git'];

    return new RecursiveIteratorIterator(
        new RecursiveCallbackFilterIterator(
            new RecursiveDirectoryIterator($root, FilesystemIterator::SKIP_DOTS),
            static fn (SplFileInfo $file): bool => ! in_array($file->getFilename(), $skip, true),
        ),
        RecursiveIteratorIterator::SELF_FIRST,
    );
}

function relative(string $path): string
{
    return ltrim(str_replace(base_path(), '', $path), '/');
}

test('no Services directory exists in production code', function (): void {
    $found = [];
    foreach (productionRoots() as $root) {
        foreach (walk($root) as $entry) {
            if ($entry->isDir() && $entry->getFilename() === 'Services') {
                $found[] = relative($entry->getPathname());
            }
        }
    }
    sort($found);

    expect($found)->toBe([]);
});

test('no direct Jobs or misspelled Servces directory exists in production code', function (): void {
    $found = [];
    foreach (productionRoots() as $root) {
        foreach (walk($root) as $entry) {
            if ($entry->isDir() && in_array($entry->getFilename(), ['Jobs', 'Servces'], true)
                && $entry->getPath() === $root) {
                $found[] = relative($entry->getPathname());
            }
        }
    }
    sort($found);

    expect($found)->toBe([]);
});

test('data objects use the canonical Datas directory', function (): void {
    $found = [];
    foreach (productionRoots() as $root) {
        foreach (walk($root) as $entry) {
            if ($entry->isDir() && in_array($entry->getFilename(), ['Data', 'DTOs'], true)
                && $entry->getPath() === $root) {
                $found[] = relative($entry->getPathname());
            }
        }
    }
    sort($found);

    expect($found)->toBe([]);
});

test('no Support directory exists under production module app roots', function (): void {
    $found = [];
    foreach (productionRoots() as $root) {
        foreach (walk($root) as $entry) {
            if ($entry->isDir() && $entry->getFilename() === 'Support') {
                $found[] = relative($entry->getPathname());
            }
        }
    }
    sort($found);

    expect($found)->toBe([]);
});

test('production code does not use a Support namespace', function (): void {
    $found = [];
    foreach (productionRoots() as $root) {
        foreach (walk($root) as $entry) {
            if (! $entry->isFile() || $entry->getExtension() !== 'php') {
                continue;
            }
            $source = file_get_contents($entry->getPathname());
            if (preg_match('/^(?:namespace|use)\s+(?:Modules|Themes|App)\\\\[A-Za-z0-9_\\\\]*\\\\Support(?:\\\\|\s|;)/m', $source) === 1) {
                $found[] = relative($entry->getPathname());
            }
        }
    }
    sort($found);

    expect($found)->toBe([]);
});

test('no class lives in a Services namespace', function (): void {
    $found = [];
    foreach (productionRoots() as $root) {
        foreach (walk($root) as $entry) {
            if (! $entry->isFile() || $entry->getExtension() !== 'php') {
                continue;
            }
            $head = file_get_contents($entry->getPathname(), false, null, 0, 4096);
            if (preg_match('/^namespace\s+[A-Za-z0-9_\\\\]*\\\\Services(\\\\[A-Za-z0-9_\\\\]+)?\s*;/m', $head) === 1) {
                $found[] = relative($entry->getPathname());
            }
        }
    }
    sort($found);

    expect($found)->toBe([]);
});

test('no class lives in a direct Jobs or Servces namespace', function (): void {
    $found = [];
    foreach (productionRoots() as $root) {
        foreach (walk($root) as $entry) {
            if (! $entry->isFile() || $entry->getExtension() !== 'php') {
                continue;
            }
            $head = file_get_contents($entry->getPathname(), false, null, 0, 4096);
            if (preg_match('/^namespace\s+(?:Modules|Themes|App)\\\\[A-Za-z0-9_]+\\\\(?:Jobs|Servces)(?:\\\\|\s|;)/m', $head) === 1) {
                $found[] = relative($entry->getPathname());
            }
        }
    }
    sort($found);

    expect($found)->toBe([]);
});

test('production code does not import a Services namespace', function (): void {
    $found = [];
    foreach (productionRoots() as $root) {
        foreach (walk($root) as $entry) {
            if (! $entry->isFile() || $entry->getExtension() !== 'php') {
                continue;
            }
            $source = file_get_contents($entry->getPathname());
            // `use Modules\X\Services\Y;` e `use Themes\X\Services\Y;`. Le righe commentate non contano.
            if (preg_match('/^use\s+(Modules|Themes|App)\\\\[A-Za-z0-9_\\\\]*\\\\?Services\\\\[A-Za-z0-9_\\\\]+/m', $source) === 1) {
                $found[] = relative($entry->getPathname());
            }
        }
    }
    sort($found);

    expect($found)->toBe([]);
});
