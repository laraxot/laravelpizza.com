<?php

declare(strict_types=1);
use Illuminate\Support\Facades\File;
use Modules\Activity\Actions\Log\ListLogFilesAction;
use Modules\Activity\Datas\LogFileData;
use Safe\Exceptions\FilesystemException;
use Tests\TestCase;

use function Safe\symlink;
use function Safe\touch;

uses(TestCase::class);

/**
 * @param  list<LogFileData>  $files
 * @return list<string>
 */
function listedLogFilePaths(array $files): array
{
    return array_map(
        static fn (LogFileData $file): string => $file->path,
        $files
    );
}

beforeEach(function (): void {
    $this->root = storage_path('framework/testing/log-viewer-'.uniqid('', true));
    $this->base = $this->root.'/logs';
    File::makeDirectory($this->base.'/reports/252', 0777, true);
    File::makeDirectory($this->base.'/reports/rejected', 0777, true);
    File::put($this->root.'/secret.log', 'segreto');
});

afterEach(function (): void {
    File::deleteDirectory($this->root);
});

it('lists log files recursively including the subfolders', function (): void {
    File::put($this->base.'/laravel.log', 'a');
    File::put($this->base.'/reports/252/daily_2026-09-17.log', 'bb');
    File::put($this->base.'/reports/rejected/daily_2026-09-20.log', 'ccc');

    $paths = listedLogFilePaths((new ListLogFilesAction)->execute($this->base));

    expect($paths)->toContain('laravel.log');
    expect($paths)->toContain('reports/252/daily_2026-09-17.log');
    expect($paths)->toContain('reports/rejected/daily_2026-09-20.log');
    expect($paths)->toHaveCount(3);
});

it('ignores files that are not .log and dot files', function (): void {
    File::put($this->base.'/laravel.log', 'a');
    File::put($this->base.'/notes.txt', 'x');
    File::put($this->base.'/.gitignore', '*');
    File::put($this->base.'/dump.log.gz', 'x');

    expect(listedLogFilePaths((new ListLogFilesAction)->execute($this->base)))->toBe(['laravel.log']);
});

it('returns size, name, directory and modification time for each file', function (): void {
    File::put($this->base.'/reports/252/daily_2026-09-17.log', 'hello');

    $files = (new ListLogFilesAction)->execute($this->base);

    expect($files)->toHaveCount(1);
    expect($files[0]->name)->toBe('daily_2026-09-17.log');
    expect($files[0]->directory)->toBe('reports/252');
    expect($files[0]->size)->toBe(5);
    expect($files[0]->modifiedAt)->toBeGreaterThan(0);
});

it('sorts files from the most recently modified to the oldest', function (): void {
    File::put($this->base.'/vecchio.log', 'a');
    File::put($this->base.'/recente.log', 'a');
    File::put($this->base.'/medio.log', 'a');
    touch($this->base.'/vecchio.log', 1_000_000);
    touch($this->base.'/medio.log', 2_000_000);
    touch($this->base.'/recente.log', 3_000_000);

    expect(listedLogFilePaths((new ListLogFilesAction)->execute($this->base)))->toBe(['recente.log', 'medio.log', 'vecchio.log']);
});

it('limits the number of returned files', function (): void {
    foreach (range(1, 5) as $i) {
        File::put($this->base."/f{$i}.log", 'a');
    }

    expect((new ListLogFilesAction)->execute($this->base, 2))->toHaveCount(2);
});

it('does not list a symlink that points outside the log directory', function (): void {
    File::put($this->base.'/laravel.log', 'a');
    try {
        symlink($this->root.'/secret.log', $this->base.'/link.log');
    } catch (FilesystemException) {
        $this->markTestSkipped('Impossibile creare link simbolici in questo ambiente.');
    }

    expect(listedLogFilePaths((new ListLogFilesAction)->execute($this->base)))->toBe(['laravel.log']);
});

it('returns an empty list when the log directory does not exist', function (): void {
    expect((new ListLogFilesAction)->execute($this->root.'/non-esiste'))->toBe([]);
});
