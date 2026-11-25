<?php

declare(strict_types=1);

namespace Modules\Xot\Tests\Unit\Docs;

use PHPUnit\Framework\Assert;

use function Safe\file_get_contents;
use function Safe\glob;
use function Safe\preg_match;

/*
 * Ogni modulo e tema ha docs/contracts/ (cosa promettono Action e interfacce) e docs/adr/ (il perche' delle scelte),
 * ciascuna con un README.md che spiega il formato. Regola: Modules/Xot/docs/rules/action-behavioral-contract.md.
 * Source-level (nessuna app).
 */

const ADR_SECTIONS = ['## Contesto', '## Decisione', '## Alternative scartate', '## Conseguenze'];

/** @return list<string> cartelle dei moduli e dei temi (hanno module.json o theme.json o composer.json) */
function packageDirectories(): array
{
    $root = dirname(__DIR__, 5);
    $packages = [];
    foreach ([...glob($root.'/Modules/*', GLOB_ONLYDIR), ...glob($root.'/Themes/*', GLOB_ONLYDIR)] as $dir) {
        if (is_string($dir) && (is_file($dir.'/module.json') || is_file($dir.'/theme.json') || is_file($dir.'/composer.json'))) {
            $packages[] = $dir;
        }
    }

    return $packages;
}

it('gives every module and theme a docs/contracts and a docs/adr folder with a README', function (): void {
    $root = dirname(__DIR__, 5);
    $missing = [];
    foreach (packageDirectories() as $dir) {
        foreach (['contracts', 'adr'] as $folder) {
            if (! is_file($dir.'/docs/'.$folder.'/README.md')) {
                $missing[] = substr($dir, strlen($root) + 1).'/docs/'.$folder.'/README.md';
            }
        }
    }

    Assert::assertNotSame([], packageDirectories());
    Assert::assertSame([], $missing);
});

it('writes every ADR with context, decision, rejected alternatives and consequences, and no date in its name', function (): void {
    $root = dirname(__DIR__, 5);
    $problems = [];
    foreach (packageDirectories() as $dir) {
        foreach (glob($dir.'/docs/adr/*.md') as $path) {
            if (! is_string($path) || in_array(basename($path), ['README.md', '0000-template.md', 'INDEX.md'], true)) {
                continue;
            }
            $relative = substr($path, strlen($root) + 1);
            if (preg_match('/\d{4}-\d{2}-\d{2}|\d{8}/', basename($path)) === 1) {
                $problems[] = $relative.': data nel nome (va nella frontmatter)';
            }
            $source = file_get_contents($path);
            foreach (ADR_SECTIONS as $section) {
                // «Alternative considerate» vale quando l'elenco comprende anche l'opzione scelta (tabella pro/contro)
                $variants = $section === '## Alternative scartate' ? [$section, '## Alternative considerate'] : [$section];
                if (array_filter($variants, static fn (string $variant): bool => str_contains($source, "\n".$variant."\n")) === []) {
                    $problems[] = $relative.': manca «'.$section.'»';
                }
            }
        }
    }

    Assert::assertSame([], $problems);
});

it('gives every module and theme at least one substantive ADR', function (): void {
    $root = dirname(__DIR__, 5);
    $missing = [];

    foreach (packageDirectories() as $dir) {
        $adrFiles = array_values(array_filter(
            glob($dir.'/docs/adr/*.md'),
            static fn (mixed $path): bool => is_string($path)
                && ! in_array(basename($path), ['README.md', '0000-template.md', 'INDEX.md'], true),
        ));

        $substantive = false;
        foreach ($adrFiles as $path) {
            if (! is_string($path)) {
                continue;
            }

            $contents = file_get_contents($path);
            if (str_contains($contents, '## Contesto')
                && (str_contains($contents, '## Driver della decisione') || str_contains($contents, '## Driver'))
                && str_contains($contents, '## Alternative scartate')
                && str_contains($contents, '## Decisione')
                && str_contains($contents, '## Conseguenze')
                && str_contains($contents, '## Conferma')) {
                $substantive = true;

                break;
            }
        }

        if (! $substantive) {
            $missing[] = substr($dir, strlen($root) + 1).'/docs/adr';
        }
    }

    Assert::assertSame([], $missing);
});
