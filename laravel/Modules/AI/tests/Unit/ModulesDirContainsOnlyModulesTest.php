<?php

declare(strict_types=1);

namespace Modules\Xot\Tests\Unit;

use Modules\Xot\Tests\TestCase;
use PHPUnit\Framework\Assert;

use function Safe\glob;

uses(TestCase::class);

/**
 * `laravel/Modules/` contiene solo moduli: ogni cartella ha un `module.json`.
 * Una cartella senza (`test`, `docs`, `x`, `Config`...) e' scritta a runtime da un test o da un tool:
 * il 2026-08-24 sette di queste finirono in git.
 *
 * @see docs/chat/moduli-fantasma-scritti-dai-test.md
 */
/**
 * @return list<string>
 */
function modulesWithoutManifest(): array
{
    $modulesRoot = dirname(__DIR__, 3);
    $withoutManifest = [];

    foreach (glob($modulesRoot.'/*', GLOB_ONLYDIR) as $dir) {
        if (is_string($dir) && ! is_file($dir.'/module.json')) {
            $withoutManifest[] = basename($dir);
        }
    }

    return $withoutManifest;
}

it('Modules contiene solo moduli con module.json', function (): void {
    Assert::assertSame(
        [],
        modulesWithoutManifest(),
        'Cartelle in laravel/Modules senza module.json (non sono moduli): '.implode(', ', modulesWithoutManifest()),
    );
});
