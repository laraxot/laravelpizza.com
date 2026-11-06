<?php

declare(strict_types=1);

namespace Modules\Xot\Tests\Unit\Actions\File;

use Illuminate\Support\Facades\File;
use Modules\Xot\Actions\File\CreateDirectoryForFilenameAction;
use Modules\Xot\Tests\TestCase;
use PHPUnit\Framework\Assert;

uses(TestCase::class);

// $this dentro le closure Pest e' tipizzato da Pest come TestCall (vedi
// @param-closure-this in vendor/pestphp/pest/src/Functions.php), non come
// Modules\Xot\Tests\TestCase: PHPStan vieta di ritipizzare $this via @var,
// quindi la working dir del test vive in una variabile locale condivisa per riferimento.
$workDir = '';

beforeEach(function () use (&$workDir): void {
    $workDir = sys_get_temp_dir().DIRECTORY_SEPARATOR.'test_create_dir_'.uniqid();
    if (! File::isDirectory($workDir)) {
        File::makeDirectory($workDir, 0755, true);
    }
});

afterEach(function () use (&$workDir): void {
    if (File::isDirectory($workDir)) {
        File::deleteDirectory($workDir);
    }
});

describe('Create Directory For Filename Action', function () use (&$workDir): void {
    test('creates directory for filename', function () use (&$workDir): void {
        $filename = $workDir.'/nested/deep/file.txt';

        app(CreateDirectoryForFilenameAction::class)->execute($filename);

        Assert::assertTrue(File::isDirectory($workDir.'/nested/deep'));
    });

    test('does nothing when directory already exists', function () use (&$workDir): void {
        $filename = $workDir.'/existing/file.txt';
        File::makeDirectory($workDir.'/existing', 0755, true);

        app(CreateDirectoryForFilenameAction::class)->execute($filename);

        Assert::assertTrue(File::isDirectory($workDir.'/existing'));
    });

    test('handles root level file', function () use (&$workDir): void {
        $filename = $workDir.'/rootfile.txt';

        app(CreateDirectoryForFilenameAction::class)->execute($filename);

        Assert::assertTrue(File::isDirectory($workDir));
    });
});
