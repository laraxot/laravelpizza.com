<?php

declare(strict_types=1);
use Modules\Activity\Actions\Log\BuildLogFileTreeAction;
use Modules\Activity\Datas\LogFileData;
use Modules\Activity\Datas\LogTreeData;
use Tests\TestCase;

uses(TestCase::class);

function treeLogFile(string $path, int $modifiedAt = 1_000): LogFileData
{
    $directory = dirname($path);

    return new LogFileData(
        path: $path,
        name: basename($path),
        directory: $directory === '.' ? '' : $directory,
        size: 10,
        modifiedAt: $modifiedAt,
    );
}

it('builds a nested tree with the subfolders and the top-level files', function (): void {
    $tree = (new BuildLogFileTreeAction)->execute([
        treeLogFile('laravel.log'),
        treeLogFile('reports/252/daily_2026-09-17.log'),
        treeLogFile('reports/rejected/daily_2026-09-20.log'),
    ]);

    expect($tree->name)->toBe('');
    expect($tree->path)->toBe('');
    expect($tree->count)->toBe(3);
    expect(array_map(fn (LogFileData $file): string => $file->path, $tree->files))->toBe(['laravel.log']);

    expect($tree->folders)->toHaveCount(1);
    $reports = $tree->folders[0];
    expect($reports->name)->toBe('reports');
    expect($reports->path)->toBe('reports');
    expect($reports->count)->toBe(2);
    expect($reports->files)->toBe([]);

    expect(array_map(fn (LogTreeData $folder): string => $folder->path, $reports->folders))->toBe(['reports/252', 'reports/rejected']);
    expect($reports->folders[0]->files[0]->path)->toBe('reports/252/daily_2026-09-17.log');
});

it('orders folders naturally so 9 comes before 10 and 252 before 1000', function (): void {
    $tree = (new BuildLogFileTreeAction)->execute([
        treeLogFile('reports/1000/a.log'),
        treeLogFile('reports/10/a.log'),
        treeLogFile('reports/9/a.log'),
        treeLogFile('reports/252/a.log'),
    ]);

    expect(array_map(fn (LogTreeData $folder): string => $folder->name, $tree->folders[0]->folders))->toBe(['9', '10', '252', '1000']);
});

it('orders the files of each folder from the most recent to the oldest', function (): void {
    $tree = (new BuildLogFileTreeAction)->execute([
        treeLogFile('reports/252/vecchio.log', 100),
        treeLogFile('reports/252/recente.log', 300),
        treeLogFile('reports/252/medio.log', 200),
    ]);

    expect(array_map(fn (LogFileData $file): string => $file->name, $tree->folders[0]->folders[0]->files))->toBe(['recente.log', 'medio.log', 'vecchio.log']);
});

it('counts the files of a folder including its subfolders', function (): void {
    $tree = (new BuildLogFileTreeAction)->execute([
        treeLogFile('reports/252/a.log'),
        treeLogFile('reports/252/b.log'),
        treeLogFile('reports/253/a.log'),
        treeLogFile('laravel.log'),
    ]);

    expect($tree->count)->toBe(4);
    expect($tree->folders[0]->count)->toBe(3);
    expect($tree->folders[0]->folders[0]->count)->toBe(2);
    expect($tree->folders[0]->folders[1]->count)->toBe(1);
});

it('does not mix a folder with another whose name starts the same way', function (): void {
    $tree = (new BuildLogFileTreeAction)->execute([
        treeLogFile('reports/25/a.log'),
        treeLogFile('reports/252/b.log'),
    ]);

    expect($tree->folders[0]->folders)->toHaveCount(2);
    expect($tree->folders[0]->folders[0]->count)->toBe(1);
    expect($tree->folders[0]->folders[1]->count)->toBe(1);
});

it('returns an empty root for an empty list', function (): void {
    $tree = (new BuildLogFileTreeAction)->execute([]);

    expect($tree->count)->toBe(0);
    expect($tree->folders)->toBe([]);
    expect($tree->files)->toBe([]);
});

it('lists the ancestor folders of a file from the outermost', function (): void {
    expect(treeLogFile('reports/252/daily_2026-09-17.log')->ancestorFolders())->toBe(['reports', 'reports/252']);
    expect(treeLogFile('laravel.log')->ancestorFolders())->toBe([]);
});
