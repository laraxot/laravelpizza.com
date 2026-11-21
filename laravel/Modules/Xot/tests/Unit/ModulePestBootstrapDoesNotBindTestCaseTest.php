<?php

declare(strict_types=1);

namespace Modules\Xot\Tests\Unit;

use Modules\Xot\Tests\TestCase;
use PHPUnit\Framework\Assert;

use function Safe\file_get_contents;
use function Safe\glob;
use function Safe\preg_match;

uses(TestCase::class)->group('no-xot-db');

/*
 * Un uses()->in() nel Pest.php di un modulo non gira col runner di root (i test restano senza applicazione) e con
 * --test-directory raddoppia il binding dei file (TestCaseAlreadyInUse). Il TestCase si lega in ogni file.
 *
 * @see Modules/Xot/docs/adr/pest-testcase-binding-per-file.md
 */
it('keeps the TestCase binding out of every module and theme Pest.php', function (): void {
    $offenders = [];
    foreach ([...glob(base_path('Modules/*/tests/Pest.php')), ...glob(base_path('Themes/*/tests/Pest.php'))] as $file) {
        if (! is_string($file)) {
            continue;
        }
        $code = file_get_contents($file);
        if (preg_match('/^\s*(uses\(|pest\(\)->extend\()[^;]*->in\(/m', $code) === 1) {
            $offenders[] = substr($file, strlen(base_path()) + 1);
        }
    }

    Assert::assertSame([], $offenders, 'Pest.php che legano il TestCase con ->in(): spostare uses(TestCase::class) nei file di test.');
});
