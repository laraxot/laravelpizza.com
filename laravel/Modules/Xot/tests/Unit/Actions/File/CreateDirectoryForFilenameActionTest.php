<?php

declare(strict_types=1);

use Illuminate\Support\Facades\File;
use Modules\Xot\Actions\File\CreateDirectoryForFilenameAction;


beforeEach(function (): void {
    $this->action = app(CreateDirectoryForFilenameAction::class);
    $this->tempDir = sys_get_temp_dir() . DIRECTORY_SEPARATOR . 'test_create_dir_' . uniqid();
    if (!File::isDirectory($this->tempDir)) {
        File::makeDirectory($this->tempDir, 0755, true);
    }
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
