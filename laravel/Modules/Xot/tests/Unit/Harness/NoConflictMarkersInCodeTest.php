<?php

declare(strict_types=1);

namespace Modules\Xot\Tests\Unit\Harness;

use PHPUnit\Framework\Assert;

use function Safe\file_get_contents;
use function Safe\preg_match;

/*
 * Nessun marcatore di conflitto git nel codice PHP e Blade di moduli, temi e app.
 * Lezione L-007 (.harness/memory/lessons.md): una sync ha committato file con <<<<<<< / >>>>>>>; in Cms il componente
 * <head> e la sua Action non compilavano, in Seo la sitemap, in Geo vite.config.js; in Blog e Rating i tipi dei docblock erano doppi.
 * Source-level (niente app): deve girare proprio quando il codice non compila.
 *
 * @see Modules/Xot/docs/adr/agent-harness.md
 */

it('keeps PHP, Blade and vite.config files free of git conflict markers', function (): void {
    $laravel = dirname(__DIR__, 5);
    $roots = [$laravel.'/Modules', $laravel.'/Themes', $laravel.'/app', $laravel.'/config', $laravel.'/routes', $laravel.'/bootstrap/app.php'];
    $found = [];
    foreach ($roots as $root) {
        $files = is_file($root) ? [new \SplFileInfo($root)] : (is_dir($root) ? new \RecursiveIteratorIterator(
            new \RecursiveCallbackFilterIterator(
                new \RecursiveDirectoryIterator($root, \FilesystemIterator::SKIP_DOTS),
                // vendor e node_modules dei pacchetti non sono codice nostro
                static fn (\SplFileInfo $file): bool => ! in_array($file->getFilename(), ['vendor', 'node_modules', '.git'], true),
            ),
        ) : []);
        foreach ($files as $file) {
            if (! $file instanceof \SplFileInfo || ($file->getExtension() !== 'php' && ! str_starts_with($file->getFilename(), 'vite.config.'))) {
                continue;
            }
            if (preg_match('/^(<{7}|>{7}) /m', file_get_contents($file->getPathname())) === 1) {
                $found[] = substr($file->getPathname(), strlen($laravel) + 1);
            }
        }
    }

    Assert::assertSame([], $found, 'marcatori di conflitto git: risolvi il merge (scegli o unisci le due parti), non committare');
});
