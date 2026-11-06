<?php

declare(strict_types=1);

namespace Modules\Xot\Tests\Feature;

use Modules\Xot\Tests\TestCase;
use PHPUnit\Framework\Assert;

use function Safe\chdir;
use function Safe\chmod;
use function Safe\exec;
use function Safe\file_get_contents;
use function Safe\file_put_contents;
use function Safe\mkdir;
use function Safe\rmdir;
use function Safe\scandir;
use function Safe\unlink;

uses(TestCase::class);

// $this dentro le closure Pest e' tipizzato da Pest come TestCall (vedi
// @param-closure-this in vendor/pestphp/pest/src/Functions.php), non come
// Modules\Xot\Tests\TestCase: PHPStan vieta di ritipizzare $this via @var,
// quindi lo stato del test vive in una variabile locale condivisa per riferimento.
$testDir = '';

$rrmdir = function (string $dir) use (&$rrmdir): void {
    if (! is_dir($dir)) {
        return;
    }

    /** @var array<int, string> $files */
    $files = scandir($dir);

    foreach ($files as $file) {
        if ($file === '.' || $file === '..') {
            continue;
        }

        $path = $dir.'/'.$file;
        if (is_dir($path)) {
            $rrmdir($path);
        } else {
            unlink($path);
        }
    }

    rmdir($dir);
};

beforeEach(function () use (&$testDir): void {
    // Creiamo una directory temporanea per i test
    $testDir = sys_get_temp_dir().'/fix_structure_test_'.uniqid();
    mkdir($testDir, 0o755, true);

    // Impostiamo la directory di lavoro
    chdir($testDir);
});

afterEach(function () use (&$testDir, $rrmdir): void {
    // Puliamo la directory di test
    if ($testDir !== '') {
        $rrmdir($testDir);
    }
});

describe('Fix Structure', function () use (&$testDir): void {
    test('move to app functionality', function () use (&$testDir): void {
        // Creiamo una struttura di directory di test
        mkdir($testDir.'/Actions', 0o755, true);
        file_put_contents($testDir.'/Actions/test.php', 'echo "test";');

        // Copiamo lo script nella directory di test
        $script = base_path('../bashscripts/utils/fix_structure.sh');
        $scriptContent = file_get_contents($script);
        file_put_contents($testDir.'/fix_structure.sh', $scriptContent);
        chmod($testDir.'/fix_structure.sh', 0o755);

        // Eseguiamo lo script
        exec('cd '.$testDir.' && ./fix_structure.sh');

        // Verifichiamo che la cartella Actions sia stata spostata in app/
        Assert::assertDirectoryExists($testDir.'/app/Actions');
        Assert::assertFileExists($testDir.'/app/Actions/test.php');
        Assert::assertDirectoryDoesNotExist($testDir.'/Actions');
    });

    test('rename to lower functionality', function () use (&$testDir): void {
        // Creiamo una struttura di directory di test
        mkdir($testDir.'/Config', 0o755, true);
        file_put_contents($testDir.'/Config/test.php', 'echo "test";');

        // Copiamo lo script nella directory di test
        $script = base_path('../bashscripts/utils/fix_structure.sh');
        $scriptContent = file_get_contents($script);
        file_put_contents($testDir.'/fix_structure.sh', $scriptContent);
        chmod($testDir.'/fix_structure.sh', 0o755);

        // Eseguiamo lo script
        exec('cd '.$testDir.' && ./fix_structure.sh');

        // Verifichiamo che la cartella Config sia stata rinominata in config
        Assert::assertDirectoryExists($testDir.'/config');
        Assert::assertFileExists($testDir.'/config/test.php');
        Assert::assertDirectoryDoesNotExist($testDir.'/Config');
    });

    test('move config functionality', function () use (&$testDir): void {
        // Creiamo una struttura di directory di test con entrambe le versioni
        mkdir($testDir.'/Config', 0o755, true);
        file_put_contents($testDir.'/Config/main.php', 'echo "main";');

        mkdir($testDir.'/config', 0o755, true);
        file_put_contents($testDir.'/config/secondary.php', 'echo "secondary";');

        // Copiamo lo script nella directory di test
        $script = base_path('../bashscripts/utils/fix_structure.sh');
        $scriptContent = file_get_contents($script);
        file_put_contents($testDir.'/fix_structure.sh', $scriptContent);
        chmod($testDir.'/fix_structure.sh', 0o755);

        // Eseguiamo lo script
        exec('cd '.$testDir.' && ./fix_structure.sh');

        // Verifichiamo che i contenuti siano stati uniti e che la cartella minuscola contenga tutto
        Assert::assertDirectoryExists($testDir.'/config');
        Assert::assertFileExists($testDir.'/config/main.php');
        Assert::assertFileExists($testDir.'/config/secondary.php');
        Assert::assertDirectoryDoesNotExist($testDir.'/Config');
        Assert::assertDirectoryExists($testDir.'/config_old');
    });
});
