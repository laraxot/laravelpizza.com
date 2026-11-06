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

/** @return list<string> */
function noJobsProductionRoots(): array
{
    $roots = [];
    foreach ([base_path('Modules/*/app'), base_path('Themes/*/app'), base_path('Themes/*/src'), base_path('app')] as $pattern) {
        foreach (glob($pattern) ?: [] as $path) {
            if (! is_string($path) || ! is_dir($path)) {
                continue;
            }

            $roots[] = $path;
        }
    }

    return $roots;
}

/** @return iterable<SplFileInfo> */
function noJobsWalk(string $root): iterable
{
    return new RecursiveIteratorIterator(
        new RecursiveCallbackFilterIterator(
            new RecursiveDirectoryIterator($root, FilesystemIterator::SKIP_DOTS),
            static fn (SplFileInfo $file): bool => ! in_array($file->getFilename(), ['vendor', 'node_modules', 'storage', '.git'], true),
        ),
        RecursiveIteratorIterator::SELF_FIRST,
    );
}

function noJobsRelative(string $path): string
{
    return ltrim(str_replace(base_path(), '', $path), '/');
}

/*
 * La coda è una modalità di esecuzione, non un layer applicativo: i casi d'uso
 * vivono in Actions e QueueableAction li esegue in sync o async. Questo ratchet
 * impedisce che un merge ricrei app/Jobs o namespace Jobs nel codice di produzione.
 */

test('no Jobs directory exists in production code', function (): void {
    $found = [];

    foreach (noJobsProductionRoots() as $root) {
        foreach (noJobsWalk($root) as $entry) {
            if ($entry->isDir()
                && $entry->getFilename() === 'Jobs'
                && $entry->getPathInfo()->getFilename() === 'app') {
                $found[] = noJobsRelative($entry->getPathname());
            }
        }
    }

    sort($found);

    expect($found)->toBe([]);
});

test('production code does not use a Jobs namespace', function (): void {
    $found = [];

    foreach (noJobsProductionRoots() as $root) {
        foreach (noJobsWalk($root) as $entry) {
            if (! $entry->isFile() || $entry->getExtension() !== 'php') {
                continue;
            }

            $source = file_get_contents($entry->getPathname());
            if (preg_match('/^(?:namespace|use)\s+(?:Modules|Themes)\\\\[A-Za-z0-9_]+\\\\Jobs(?:\\\\|\s|;)|^(?:namespace|use)\s+App\\\\Jobs(?:\\\\|\s|;)/m', $source) === 1) {
                $found[] = noJobsRelative($entry->getPathname());
            }
        }
    }

    sort($found);

    expect($found)->toBe([]);
});
