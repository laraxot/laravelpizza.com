<?php

declare(strict_types=1);

use Illuminate\Support\Facades\File;
use Modules\Xot\Actions\File\CreateDirectoryForFilenameAction;
use Modules\Xot\Tests\TestCase;

uses(TestCase::class);

beforeEach(function (): void {
    $action = app(CreateDirectoryForFilenameAction::class);
    $tempDir = sys_get_temp_dir();
});

afterEach(function (): void {
    if (File::isDirectory($tempDir
        File::deleteDirectory($tempDir);
    }
});

it('creates directory for filename', function (): void {
    $filename = $tempDir.'/nested/deep/file.txt';

    $action->execute($filename);

    expect(File::isDirectory($tempDir.'/nested/deep'));
});

it('does nothing when directory already exists', function (): void {
    $filename = $tempDir.'/existing/file.txt';
    File::makeDirectory($tempDir.'/existing', 0755, true);

    // Should not throw
    $action->execute($filename);

    expect(File::isDirectory($tempDir.'/existing'));
});

it('handles root level file', function (): void {
    $filename = $tempDir.'/rootfile.txt';
    File::makeDirectory($tempDir, 0755, true);

    $action->execute($filename);

    expect(File::isDirectory($tempDir));
});
