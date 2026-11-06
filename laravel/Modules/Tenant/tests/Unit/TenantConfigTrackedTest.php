<?php

declare(strict_types=1);

namespace Modules\Tenant\Tests\Unit;

use Modules\Tenant\Tests\TestCase;
use PHPUnit\Framework\Assert;
use Symfony\Component\Finder\Finder;
use Symfony\Component\Process\Process;

uses(TestCase::class);

/*
 * `laravel/config/local/<tenant>/` e' versionata apposta: e' la config per tenant che
 * TenantServiceProvider carica in base all'host (database, morph_map, metatag, menu).
 * Il commit 8b3b7cbea3 l'ha tolta dall'indice applicando il `.gitignore` ai file gia'
 * tracciati: su un altro checkout il pull l'avrebbe cancellata dal disco, e il tenant
 * sarebbe ripiegato su `localhost` (altro database, niente alias morph, niente logo).
 *
 * @see Modules/Tenant/docs/bmad/stories/tenant-config-untracked-by-gitignore.story.md
 */

if (! function_exists('tenantConfigRepoRoot')) {
    /**
     * Root del repo principale: la prima cartella sopra il modulo con `.git` e `laravel/config/local`.
     * Null quando il modulo gira fuori dal progetto (repo del modulo da solo).
     */
    function tenantConfigRepoRoot(): ?string
    {
        $dir = __DIR__;
        while ($dir !== \dirname($dir)) {
            $dir = \dirname($dir);
            if (file_exists($dir.'/.git') && is_dir($dir.'/laravel/config/local')) {
                return $dir;
            }
        }

        return null;
    }
}

if (! function_exists('tenantConfigGit')) {
    /**
     * @param  list<string>  $arguments
     */
    function tenantConfigGit(string $root, array $arguments): Process
    {
        $process = new Process(['git', ...$arguments], $root);
        $process->run();

        return $process;
    }
}

if (! function_exists('tenantConfigDirs')) {
    /**
     * Cartelle tenant, relative alla root, che dichiarano una `database.php`.
     *
     * @return list<string>
     */
    function tenantConfigDirs(string $root): array
    {
        $dirs = [];
        foreach (Finder::create()->files()->in($root.'/laravel/config/local')->name('database.php') as $file) {
            $dirs[] = 'laravel/config/local/'.str_replace('\\', '/', $file->getRelativePath());
        }

        sort($dirs);

        return $dirs;
    }
}

it('versiona database.php e morph_map.php di ogni tenant in laravel/config/local', function (): void {
    $root = tenantConfigRepoRoot();
    if ($root === null) {
        Assert::markTestSkipped('Repo principale con laravel/config/local non trovato.');
    }

    $tenantDirs = tenantConfigDirs($root);
    Assert::assertNotSame([], $tenantDirs, 'Nessun tenant con database.php in laravel/config/local.');

    foreach ($tenantDirs as $tenantDir) {
        foreach (['database.php', 'morph_map.php'] as $file) {
            $path = $tenantDir.'/'.$file;
            $process = tenantConfigGit($root, ['ls-files', '--error-unmatch', '--', $path]);

            Assert::assertTrue($process->isSuccessful(), $path.' non e\' tracciato: la config per tenant va versionata (8b3b7cbea3).');
        }
    }
});

it('non ignora la config per tenant nel .gitignore', function (): void {
    $root = tenantConfigRepoRoot();
    if ($root === null) {
        Assert::markTestSkipped('Repo principale con laravel/config/local non trovato.');
    }

    // -c -i: i file tracciati coperti da una regola, cioe' proprio quelli che "applica .gitignore ai tracciati"
    // toglie dall'indice. Tutti, non solo database.php: metatag.php (logo), app.php, menu, policy.
    $process = tenantConfigGit($root, ['ls-files', '-c', '-i', '--exclude-standard', '--', 'laravel/config/local']);

    Assert::assertTrue($process->isSuccessful(), $process->getErrorOutput());
    Assert::assertSame('', trim($process->getOutput()), "Tracciati ma coperti dal .gitignore, la prossima pulizia li untraccia:\n".$process->getOutput());
});
