<?php

declare(strict_types=1);

namespace Modules\Xot\Tests\Unit\Docs;

use Symfony\Component\Finder\Finder;

use function Safe\file_get_contents;
use function Safe\glob;
use function Safe\preg_match;

/*
 * Harness: ogni ADR e' docs/adr/NNNN-slug.md (mai basename senza numero).
 * Eccezioni: README.md, INDEX.md/index.md, 0000-template.md,
 * stub superseded (puntatore al NNNN canonico — vedi docs/adr/INDEX.md).
 *
 * @see Modules/Xot/docs/adr/0000-template.md
 */

it('ogni ADR in Modules e Themes ha prefisso numerico NNNN-', function (): void {
    $moduleRoots = [
        dirname(__DIR__, 4),
        dirname(__DIR__, 5).'/Themes',
    ];
    $extraAdrDirs = [
        dirname(__DIR__, 6).'/docs/adr',
    ];

    $allowed = [
        'README.md',
        'INDEX.md',
        'index.md',
        '0000-template.md',
    ];

    $offenders = [];

    foreach ($moduleRoots as $root) {
        if (! is_dir($root)) {
            continue;
        }

        $finder = Finder::create()
            ->files()
            ->in($root)
            ->path('docs/adr')
            ->name('*.md');

        foreach ($finder as $file) {
            $name = $file->getFilename();
            if (in_array($name, $allowed, true)) {
                continue;
            }

            if (preg_match('/^\d+-/', $name) !== 1) {
                $contents = $file->getContents();
                if (isAdrSupersededStub($contents)) {
                    continue;
                }
                $offenders[] = $file->getRelativePathname();
            }
        }
    }

    foreach ($extraAdrDirs as $adrDir) {
        if (! is_dir($adrDir)) {
            continue;
        }
        foreach (glob($adrDir.'/*.md') as $path) {
            if (! is_string($path)) {
                continue;
            }
            $name = basename($path);
            if (in_array($name, $allowed, true)) {
                continue;
            }
            if (preg_match('/^\d+-/', $name) !== 1) {
                if (isAdrSupersededStub(file_get_contents($path))) {
                    continue;
                }
                $offenders[] = 'docs/adr/'.$name;
            }
        }
    }

    expect($offenders)->toBe([]);
});

function isAdrSupersededStub(string $contents): bool
{
    return str_contains($contents, 'status: superseded')
        || str_contains($contents, 'STUB →');
}
