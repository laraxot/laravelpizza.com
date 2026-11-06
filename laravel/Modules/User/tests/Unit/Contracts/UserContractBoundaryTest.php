<?php

declare(strict_types=1);

use Symfony\Component\Finder\Finder;

use function Safe\preg_match;

uses(\Modules\User\Tests\TestCase::class);

test('user boundaries depend on UserContract instead of BaseUser', function (): void {
    $root = dirname(__DIR__, 5);

    // Modulo User + ogni tema presente nel progetto (app e viste).
    $paths = [$root.'/Modules/User/app'];
    foreach (Finder::create()->directories()->in($root.'/Themes')->depth(0) as $theme) {
        foreach (['app', 'resources/views'] as $subPath) {
            if (is_dir($theme->getPathname().'/'.$subPath)) {
                $paths[] = $theme->getPathname().'/'.$subPath;
            }
        }
    }

    $violations = [];
    // `*.php` copre anche i `*.blade.php`: l'estensione di un blade e' comunque `php`.
    foreach (Finder::create()->files()->in($paths)->name('*.php') as $file) {
        if (preg_match('/instanceof\s+BaseUser\b/', $file->getContents()) === 1) {
            $violations[] = $file->getPathname();
        }
    }

    expect($violations)->toBe([], 'Runtime boundaries must check UserContract, not BaseUser.');
});