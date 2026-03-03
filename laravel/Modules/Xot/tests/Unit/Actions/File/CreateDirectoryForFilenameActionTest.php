<?php

declare(strict_types=1);

use Modules\Xot\Actions\File\CreateDirectoryForFilenameAction;
use Modules\Xot\Tests\TestCase;
use Illuminate\Support\Facades\File;

uses(TestCase::class);

beforeEach(function (): void {
    $this->action = app(CreateDirectoryForFilenameAction::class);
    $this->tempDir = sys_get_temp_dir() . '/xot_createdir_test_' . uniqid();
});

afterEach(function (): void {
    if (File::isDirectory($this->tempDir)) {
        File::deleteDirectory($this->tempDir);
    }
});

it('creates directory for filename', function (): void {
    $filename = $this->tempDir . '/nested/deep/file.txt';

    $this->action->execute($filename);

    expect(File::isDirectory($this->tempDir . '/nested/deep'))->toBeTrue();
});

it('does nothing when directory already exists', function (): void {
    $filename = $this->tempDir . '/existing/file.txt';
    File::makeDirectory($this->tempDir . '/existing', 0755, true);

    // Should not throw
    $this->action->execute($filename);

    expect(File::isDirectory($this->tempDir . '/existing'))->toBeTrue();
});

it('handles root level file', function (): void {
    $filename = $this->tempDir . '/rootfile.txt';
    File::makeDirectory($this->tempDir, 0755, true);

    $this->action->execute($filename);

    expect(File::isDirectory($this->tempDir))->toBeTrue();
});
