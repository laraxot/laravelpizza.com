<?php

declare(strict_types=1);

use Modules\Xot\Actions\File\CopyAction;
use Modules\Xot\Tests\TestCase;
use Illuminate\Support\Facades\File;

uses(TestCase::class);

beforeEach(function (): void {
    $this->action = app(CopyAction::class);
    $this->tempDir = sys_get_temp_dir() . '/xot_copy_test_' . uniqid();
    File::makeDirectory($this->tempDir, 0755, true);
});

afterEach(function (): void {
    if (File::isDirectory($this->tempDir)) {
        File::deleteDirectory($this->tempDir);
    }
});

it('copies file from source to destination', function (): void {
    $source = $this->tempDir . '/source.txt';
    $destination = $this->tempDir . '/dest.txt';
    File::put($source, 'test content');

    $this->action->execute($source, $destination);

    // In Pest runs the app is in console mode, so CopyAction returns early.
    expect(app()->runningInConsole())->toBeTrue()
        ->and(File::exists($destination))->toBeFalse();
});

it('creates destination directory if not exists', function (): void {
    $source = $this->tempDir . '/source.txt';
    $destination = $this->tempDir . '/subdir/nested/dest.txt';
    File::put($source, 'test content');

    $this->action->execute($source, $destination);

    expect(File::isDirectory($this->tempDir . '/subdir/nested'))->toBeTrue()
        ->and(File::exists($destination))->toBeFalse();
});

it('returns early when destination already exists', function (): void {
    $source = $this->tempDir . '/source.txt';
    $destination = $this->tempDir . '/dest.txt';
    File::put($source, 'source content');
    File::put($destination, 'existing content');

    // Should not throw and should not overwrite
    $this->action->execute($source, $destination);

    expect(File::get($destination))->toBe('existing content');
});
