<?php

declare(strict_types=1);

namespace Modules\Xot\Tests\Unit\Actions\File;

use Illuminate\Support\Facades\File;
use Modules\Xot\Actions\File\CreateDirectoryForFilenameAction;
use Modules\Xot\Tests\TestCase;
use PHPUnit\Framework\Assert;

uses(TestCase::class);

beforeEach(function (): void {
    /* @var \Modules\Xot\Tests\TestCase $this */
    $this->action = app(CreateDirectoryForFilenameAction::class);
    $this->workDir = sys_get_temp_dir().DIRECTORY_SEPARATOR.'test_create_dir_'.uniqid();
    assert(is_string($this->workDir));
    if (! File::isDirectory($this->workDir)) {
        File::makeDirectory($this->workDir, 0755, true);
    }
});

afterEach(function (): void {
    /* @var \Modules\Xot\Tests\TestCase $this */
    assert(is_string($this->workDir));
    if (File::isDirectory($this->workDir)) {
        File::deleteDirectory($this->workDir);
    }
});

describe('Create Directory For Filename Action', function (): void {
    test('creates directory for filename', function (): void {
        /* @var \Modules\Xot\Tests\TestCase $this */
        Assert::assertIsString($this->workDir);
        $filename = $this->workDir.'/nested/deep/file.txt';

        app(CreateDirectoryForFilenameAction::class)->execute($filename);

        Assert::assertTrue(File::isDirectory($this->workDir.'/nested/deep'));
    });

    test('does nothing when directory already exists', function (): void {
        /* @var \Modules\Xot\Tests\TestCase $this */
        Assert::assertIsString($this->workDir);
        $filename = $this->workDir.'/existing/file.txt';
        File::makeDirectory($this->workDir.'/existing', 0755, true);

        app(CreateDirectoryForFilenameAction::class)->execute($filename);

        Assert::assertTrue(File::isDirectory($this->workDir.'/existing'));
    });

    test('handles root level file', function (): void {
        /* @var \Modules\Xot\Tests\TestCase $this */
        assert(is_string($this->workDir));
        $filename = $this->workDir.'/rootfile.txt';
        File::makeDirectory($this->workDir, 0755, true);

        app(CreateDirectoryForFilenameAction::class)->execute($filename);

        Assert::assertTrue(File::isDirectory($this->workDir));
    });
});
