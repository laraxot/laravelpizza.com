<?php

declare(strict_types=1);

namespace Modules\User\Tests\Feature\Database\Migrations;

use Modules\User\Tests\TestCase;
use PHPUnit\Framework\Assert;

use function Safe\exec;
use function Safe\file_get_contents;

uses(TestCase::class);

describe('User Migration Syntax', function (): void {
    test('user migrations do not contain merge conflict markers', function (): void {
        foreach (userMigrationFiles() as $migrationFile) {
            $contents = file_get_contents($migrationFile);

            Assert::assertStringNotContainsString('<<<<<<<', $contents, $migrationFile);
            Assert::assertStringNotContainsString('=======', $contents, $migrationFile);
            Assert::assertStringNotContainsString('>>>>>>>', $contents, $migrationFile);
        }
    });

    test('user migrations have valid php syntax', function (): void {
        foreach (userMigrationFiles() as $migrationFile) {
            $output = [];
            $exitCode = 0;

            exec('php -l '.escapeshellarg($migrationFile), $output, $exitCode);

            $lines = [];
            if (is_array($output)) {
                foreach ($output as $line) {
                    if (is_string($line)) {
                        $lines[] = $line;
                    }
                }
            }

            Assert::assertSame(0, $exitCode, implode(PHP_EOL, $lines));
        }
    });
});
