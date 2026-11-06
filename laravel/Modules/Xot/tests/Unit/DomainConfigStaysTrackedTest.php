<?php

declare(strict_types=1);

namespace Modules\Xot\Tests\Unit;

use Modules\Xot\Tests\TestCase;
use PHPUnit\Framework\Assert;

use function Safe\shell_exec;

uses(TestCase::class);

/**
 * `laravel/config/local/<dominio_inverso>/` e' la configurazione per dominio (ptvx.local -> local/ptvx):
 * metatag (logo), app, database, xra, menu, policy. E' versionata di proposito, anche se `.gitignore` ha
 * `laravel/config/local/` (un ignore non tocca i file gia' tracciati).
 *
 * Una pulizia che rimuove dall'indice "tutto cio' che .gitignore copre" (`git rm --cached` su
 * `git ls-files -ci --exclude-standard`) li de-versiona in silenzio: il 2026-09-29 sono usciti 90 file.
 */
const DOMAIN_CONFIG_ROOT = 'laravel/config/local';

const DOMAIN_CONFIG_MUST_STAY_TRACKED = [
    'laravel/config/local/ptvx/metatag.php',
    'laravel/config/local/ptvx/app.php',
    'laravel/config/local/ptvx/database.php',
];

function domainConfigRepoRoot(): string
{
    return dirname(__DIR__, 5);
}

it('i file di config per dominio restano tracciati in git', function (string $file): void {
    $root = domainConfigRepoRoot();
    if (! is_dir($root.'/.git') && ! is_file($root.'/.git')) {
        $this->markTestSkipped('repo git non disponibile');
    }

    $output = shell_exec('git -C '.escapeshellarg($root).' ls-files --error-unmatch '.escapeshellarg($file).' 2>&1');

    Assert::assertNotNull($output);
    Assert::assertStringNotContainsString(
        'did not match',
        $output,
        $file.' non e\' piu\' tracciato: config per dominio de-versionata. Ripristina con '
        .'`git restore --staged --source=<commit prima> -- '.DOMAIN_CONFIG_ROOT.'` (il disco non va toccato).',
    );
})->with(DOMAIN_CONFIG_MUST_STAY_TRACKED);
