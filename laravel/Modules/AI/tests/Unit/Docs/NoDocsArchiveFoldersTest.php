<?php

declare(strict_types=1);

namespace Modules\Xot\Tests\Unit\Docs;

use RecursiveDirectoryIterator;
use RecursiveIteratorIterator;
use SplFileInfo;

use function Safe\file_get_contents;
use function Safe\realpath;

/*
 * Vietate cartelle docs di tipo archivio/backup: lo storico e' Git (ADR Xot 0041).
 * Solo filesystem — niente TestCase/DB (come BmadStoriesAreMadrFormatTest).
 *
 * @see laravel/Modules/Xot/docs/adr/0041-no-docs-archive-folders.md
 */

/**
 * @var list<string>
 */
const FORBIDDEN_DOCS_DIR_NAMES = [
    'archivio',
    'archive',
    '_archive',
    'archived',
    'historical',
    'backup',
    'backups',
];

/**
 * @return list<string> path assoluti di cartelle vietate sotto docs/
 */
function forbiddenDocsArchiveDirectories(): array
{
    $laravelRoot = dirname(__DIR__, 5);
    $repoRoot = dirname($laravelRoot);
    $roots = [
        $laravelRoot.'/Modules',
        $laravelRoot.'/Themes',
        $repoRoot.'/docs',
    ];

    $found = [];

    foreach ($roots as $root) {
        if (! is_dir($root)) {
            continue;
        }

        $iterator = new RecursiveIteratorIterator(
            new RecursiveDirectoryIterator($root, RecursiveDirectoryIterator::SKIP_DOTS),
            RecursiveIteratorIterator::SELF_FIRST
        );

        foreach ($iterator as $fileInfo) {
            if (! $fileInfo instanceof SplFileInfo || ! $fileInfo->isDir()) {
                continue;
            }

            $name = $fileInfo->getFilename();
            if (! in_array($name, FORBIDDEN_DOCS_DIR_NAMES, true)) {
                continue;
            }

            $path = $fileInfo->getPathname();
            if (! str_contains($path, DIRECTORY_SEPARATOR.'docs'.DIRECTORY_SEPARATOR)
                && ! str_ends_with($path, DIRECTORY_SEPARATOR.'docs')) {
                continue;
            }

            $found[] = $path;
        }
    }

    sort($found);

    return $found;
}

test('no archive-named directories under docs in modules themes or root', function (): void {
    expect(forbiddenDocsArchiveDirectories())->toBe([]);
});

test('xot gitignore ignores docs archive folder names from adr 0041', function (): void {
    $laravelRoot = dirname(__DIR__, 5);
    $gitignore = realpath($laravelRoot.'/Modules/Xot/.gitignore');
    $contents = file_get_contents($gitignore);

    foreach ([
        'docs/archivio/',
        'docs/archive/',
        'docs/_archive/',
        'docs/archived/',
        'docs/historical/',
        'docs/backup/',
        'docs/backups/',
    ] as $pattern) {
        expect($contents)->toContain($pattern);
    }
});
