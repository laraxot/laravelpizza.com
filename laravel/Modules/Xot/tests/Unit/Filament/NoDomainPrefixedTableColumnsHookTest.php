<?php

declare(strict_types=1);

use Modules\Xot\Tests\TestCase;
use PHPUnit\Framework\Assert;
use Symfony\Component\Finder\Finder;

use function Safe\preg_match_all;

uses(TestCase::class)->group('no-db');

/*
 * ADR Ptv 0005: le colonne di una tabella Filament si dichiarano solo in getTableColumns().
 * Un get{Dominio}TableColumns() (es. getSigmaTableColumns) e' un secondo contratto che il
 * framework non legge: chi lo dimentica ottiene una tabella sbagliata senza errori.
 */
it('declares table columns only through getTableColumns', function (): void {
    $allowed = [
        'getTableColumns',
        'getGridTableColumns',
    ];
    $offenders = [];

    $files = Finder::create()->files()->name('*.php')->in(base_path('Modules/*/app'));
    foreach ($files as $file) {
        $source = $file->getContents();
        if (preg_match_all('/function\s+(get[A-Za-z0-9]*TableColumns)\s*\(/', $source, $matches) === 0) {
            continue;
        }

        foreach ($matches[1] as $method) {
            if (! in_array($method, $allowed, true)) {
                $offenders[] = $file->getRelativePathname().'::'.$method;
            }
        }
    }

    Assert::assertSame([], $offenders);
});
