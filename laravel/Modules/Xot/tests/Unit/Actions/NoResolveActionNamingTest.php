<?php

declare(strict_types=1);

namespace Modules\Xot\Tests\Unit\Actions;

use Symfony\Component\Finder\Finder;

use function Safe\preg_match;

/*
 * ADR 0016: Action files under Modules/.../app/Actions must not be named Resolve*Action.
 * Pure filesystem — no TestCase / DB bootstrap.
 *
 * @see Modules/Xot/docs/adr/0016-action-names-get-not-resolve.md
 */

it('nessun file Resolve Action sotto app Actions dei moduli', function (): void {
    $modulesRoot = dirname(__DIR__, 4);
    $finder = Finder::create()
        ->files()
        ->in($modulesRoot)
        ->path('app/Actions')
        ->name('Resolve*Action.php');

    $offenders = [];
    foreach ($finder as $file) {
        $offenders[] = $file->getRelativePathname();
    }

    expect($offenders)->toBe([]);
});

it('nessuna class Resolve Action in app Actions dei moduli', function (): void {
    $modulesRoot = dirname(__DIR__, 4);
    $finder = Finder::create()
        ->files()
        ->in($modulesRoot)
        ->path('app/Actions')
        ->name('*Action.php');

    $offenders = [];
    foreach ($finder as $file) {
        $contents = $file->getContents();
        if (preg_match('/\bclass\s+Resolve\w+Action\b/', $contents) === 1) {
            $offenders[] = $file->getRelativePathname();
        }
    }

    expect($offenders)->toBe([]);
});
