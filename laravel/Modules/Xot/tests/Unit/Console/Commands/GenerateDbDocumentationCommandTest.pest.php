<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\File;
use Modules\Xot\Tests\TestCase;

uses(TestCase::class);

beforeEach(function () {
    $testSchemaPath = storage_path('tests/schema.json');
    $testOutputDir = storage_path('tests/docs');

    // Create test directory if it doesn't exist
    if (! File::exists(dirname($testSchemaPath
        File::makeDirectory(dirname($testSchemaPath));
    }

    // Create a test schema file
    $testSchema = [
        'database' => 'test_db',
        'connection' => 'mysql',
        'tables' => [
            'users' => [
                'columns' => [
                    'id' => [
                        'type' => 'bigint',
                        'nullable' => false,
                        'default' => null,
                        'extra' => 'auto_increment',
                    ],
                    'name' => [
                        'type' => 'varchar(255)',
                        'nullable' => false,
                        'default' => null,
                    ],
                ],
                'primary_key' => [
                    'columns' => ['id'],
                ],
                'indexes' => [
                    'name_index' => [
                        'columns' => ['name'],
                        'type' => 'index',
                    ],
                ],
                'foreign_keys' => [],
                'record_count' => 10,
            ],
        ],
        'relationships' => [],
    ];

    file_put_contents($testSchemaPath, json_encode($testSchema, JSON_PRETTY_PRINT));

    // Ensure output directory is clean
    if (File::exists($testOutputDir
        File::deleteDirectory($testOutputDir);
    }
});

afterEach(function () {
    // Clean up test files
    if (File::exists($testSchemaPath
        File::delete($testSchemaPath);
    }
    if (File::exists($testOutputDir
        File::deleteDirectory($testOutputDir);
    }
});

test('it generates database documentation', function () {
    // Run the command
    $exitCode = Artisan::call('xot:generate-db-documentation', [
        '--schema' => $testSchemaPath,
        '--output' => $testOutputDir,
    ]);

    // Assert command was successful
    expect($exitCode)->toBe(0);

    // Check if output files were created
    expect(File::exists($testOutputDir.'/database-documentation.md'
        ->toBeTrue()
        ->and(File::exists($testOutputDir.'/tables/users.md'
        ->toBeTrue();
});

test('it handles missing schema file', function () {
    // Delete the schema file
    File::delete($testSchemaPath);

    // Run the command and expect an error
    $exitCode = Artisan::call('xot:generate-db-documentation', [
        '--schema' => $testSchemaPath,
        '--output' => $testOutputDir,
    ]);

    // Assert command failed
    expect($exitCode)->not->toBe(0);
});

test('it handles invalid schema file', function () {
    // Write invalid JSON to the schema file
    file_put_contents($testSchemaPath, 'invalid json');

    // Run the command and expect an error
    $exitCode = Artisan::call('xot:generate-db-documentation', [
        '--schema' => $testSchemaPath,
        '--output' => $testOutputDir,
    ]);

    // Assert command failed
    expect($exitCode)->not->toBe(0);
});

test('it handles missing output directory', function () {
    // Delete the output directory if it exists
    if (File::exists($testOutputDir
        File::deleteDirectory($testOutputDir);
    }

    // Run the command
    $exitCode = Artisan::call('xot:generate-db-documentation', [
        '--schema' => $testSchemaPath,
        '--output' => $testOutputDir,
    ]);

    // Assert command was successful and created the output directory
    expect($exitCode)->toBe(0)->and(File::isDirectory($testOutputDir));
});
