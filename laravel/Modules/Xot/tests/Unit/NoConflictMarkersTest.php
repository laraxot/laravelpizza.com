<?php

declare(strict_types=1);

namespace Modules\Xot\Tests\Unit;

use Modules\Xot\Tests\TestCase;
use Symfony\Component\Process\Process;

uses(TestCase::class);

/*
 * Nessun file tracciato puo' contenere marcatori di conflitto di merge (`<<<<<<< ` / `>>>>>>> ` a inizio riga).
 * Il 13/11 un sync ne ha committati 471 (171 PHP, AssetAction compreso): l'app non partiva.
 * Issue: https://github.com/provtv/base_ptv_fila5/issues/263
 */
it('nessun file tracciato contiene marcatori di conflitto di merge', function (): void {
    $repoRoot = dirname(__DIR__, 5);
    if (! is_dir($repoRoot.'/.git') && ! is_file($repoRoot.'/.git')) {
        $this->markTestSkipped('Repository git non disponibile in questo ambiente.');
    }

    $process = new Process(
        ['git', 'grep', '-l', '-I', '-E', '^(<<<<<<<|>>>>>>>) ', '--', '.', ':!laravel/vendor', ':!node_modules'],
        $repoRoot,
    );
    $process->run();

    // git grep: exit 1 = nessuna corrispondenza, 0 = trovati file, altro = errore.
    if ($process->getExitCode() !== 0 && $process->getExitCode() !== 1) {
        $this->markTestSkipped('git grep non eseguibile: '.$process->getErrorOutput());
    }

    $files = array_values(array_filter(explode("\n", trim($process->getOutput()))));

    expect($files)->toBe([], "File con marcatori di conflitto:\n".implode("\n", $files));
});
