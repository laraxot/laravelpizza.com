<?php

declare(strict_types=1);

<<<<<<< HEAD
dataset('userMigrationFiles', static function (): array {
    $basePath = dirname(__DIR__, 4).'/database/migrations';
    $files = glob($basePath.'/*.php');

    if (false === $files) {
        return [];
    }

    sort($files);

    return array_combine($files, $files);
=======
use PHPUnit\Framework\Assert;

use function Safe\exec;
use function Safe\file_get_contents;
use function Safe\glob;

uses(Modules\User\Tests\TestCase::class);

/** @return list<string> */
function getUserMigrationFiles(): array
{
    $basePath = dirname(__DIR__, 4).'/database/migrations';
    $files = glob($basePath.'/*.php');

    sort($files);

    /* @var list<string> $files */
    return $files;
}

it('does not contain merge conflict markers in user migrations', function (): void {
    foreach (getUserMigrationFiles() as $migrationFile) {
        $contents = file_get_contents($migrationFile);

        Assert::assertNotFalse($contents, "Could not read {$migrationFile}");
        Assert::assertStringNotContainsString('<<<<<<<', $contents, "Merge conflict marker in {$migrationFile}");
    }
});

it('has valid php syntax in user migrations', function (): void {
    foreach (getUserMigrationFiles() as $migrationFile) {
        $output = [];
        $exitCode = 0;

        exec('php -l '.escapeshellarg($migrationFile), $output, $exitCode);
        /** @var list<string> $output */
        $outputLines = array_map(static fn (mixed $line): string => (string) $line, $output);
        Assert::assertSame(0, $exitCode, implode(PHP_EOL, $outputLines));
    }
>>>>>>> 6d3760fe (.)
});

it('does not contain merge conflict markers in user migrations', function (string $migrationFile): void {
    $contents = file_get_contents($migrationFile);

    expect($contents)->not->toBeFalse();
    expect($contents)->not->toContain('<<<<<<< HEAD');
    expect($contents)->not->toContain('=======');
    expect($contents)->not->toContain('>>>>>>> ');
})->with('userMigrationFiles');

it('has valid php syntax in user migrations', function (string $migrationFile): void {
    $output = [];
    $exitCode = 0;

    exec('php -l '.escapeshellarg($migrationFile), $output, $exitCode);

    expect($exitCode)->toBe(
        0,
        implode(PHP_EOL, $output),
    );
})->with('userMigrationFiles');
