<?php

declare(strict_types=1);

namespace Modules\Tenant\Tests\Unit;

use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Mockery;
use Modules\Tenant\Models\TestSushiModel;
use Modules\Tenant\Services\TenantService;
use Modules\Tenant\Tests\TestCase;

use function Safe\json_encode;

uses(TestCase::class);

beforeEach(function (): void {
    $this->model = new TestSushiModel;
    $this->testDirectory = storage_path('tests/sushi-json');
    $this->testJsonPath = $this->testDirectory.'/test_sushi.json';

    if (! File::exists($this->testDirectory)) {
        File::makeDirectory($this->testDirectory, 0o755, true, true);
    }

    $jsonPath = $this->testJsonPath;
    $mock = Mockery::mock(TenantService::class);
    tenantMockExpectation($mock, 'filePath')
        ->with('database/content/test_sushi.json')
        ->andReturn($jsonPath);
    app()->instance(TenantService::class, $mock);

    $this->createTestData = static fn (): array => [
        1 => [
            'id' => 1,
            'name' => 'Test Item 1',
            'description' => 'Description 1',
            'status' => 'active',
            'metadata' => ['key1' => 'value1'],
            'created_at' => now()->toISOString(),
            'updated_at' => now()->toISOString(),
        ],
        2 => [
            'id' => 2,
            'name' => 'Test Item 2',
            'description' => 'Description 2',
            'status' => 'inactive',
            'metadata' => ['key3' => 'value3'],
            'created_at' => now()->toISOString(),
            'updated_at' => now()->toISOString(),
        ],
    ];
});

afterEach(function (): void {
    if (File::exists($this->testJsonPath)) {
        File::delete($this->testJsonPath);
    }

    if (File::exists($this->testDirectory)) {
        File::deleteDirectory($this->testDirectory);
    }

    Mockery::close();
});

describe('SushiToJson Trait', function (): void {
    it('returns correct json file path', function (): void {
        expect($this->sushiModel()->getJsonFile())->toBe($this->testJsonPath);
    });

    it('loads existing data from json file', function (): void {
        /** @var array<int, array<string, mixed>> $testData */
        $testData = $this->sushiTestData();
        File::put($this->testJsonPath, json_encode($testData, JSON_PRETTY_PRINT));

        $rows = $this->sushiModel()->loadExistingData();

        expect($rows)->toBeArray()->toHaveCount(2);
        expect($this->jsonRecordAt($rows, '1')['name'])->toBe('Test Item 1');
        expect($this->jsonRecordAt($rows, '2')['name'])->toBe('Test Item 2');
    });

    it('returns empty array when file not exists', function (): void {
        expect($this->sushiModel()->getSushiRows())->toBeArray()->toBeEmpty();
    });

    it('throws exception with malformed json', function (): void {
        File::put($this->testJsonPath, 'invalid json content');

        expect(fn () => $this->sushiModel()->getSushiRows())
            ->toThrow(Exception::class, 'Syntax error');
    });

    it('throws exception with non array data', function (): void {
        File::put($this->testJsonPath, '"string data"');

        expect(fn () => $this->sushiModel()->getSushiRows())
            ->toThrow(Exception::class, 'Data is not array');
    });

    it('normalizes nested arrays to json strings', function (): void {
        $testData = [
            '1' => [
                'id' => 1,
                'name' => 'Test',
                'metadata' => ['nested' => 'value'],
                'tags' => ['tag1', 'tag2'],
            ],
        ];

        File::put($this->testJsonPath, json_encode($testData, JSON_PRETTY_PRINT));

        $rows = $this->sushiModel()->getSushiRows();
        $row = $this->jsonRecordAt($rows, '1');

        expect($row['metadata'])->toBeString()->toBe('{"nested":"value"}');
        expect($row['tags'])->toBeString()->toBe('["tag1","tag2"]');
    });

    it('saves data successfully to json file', function (): void {
        /** @var array<int, array<string, mixed>> $testData */
        $testData = $this->sushiTestData();

        expect($this->sushiModel()->saveToJson($testData))->toBeTrue();
        expect($this->testJsonPath)->toBeFile();

        expect($this->readJsonFileAsArray($this->testJsonPath))->toBe($testData);
    });

    it('creates directory if not exists', function (): void {
        if (File::exists($this->testDirectory)) {
            File::deleteDirectory($this->testDirectory);
        }

        /** @var array<int, array<string, mixed>> $testData */
        $testData = $this->sushiTestData();

        expect($this->sushiModel()->saveToJson($testData))->toBeTrue();
        expect($this->testDirectory)->toBeDirectory();
        expect($this->testJsonPath)->toBeFile();
    });

    it('handles save errors gracefully', function (): void {
        File::shouldReceive('put')->once()->andReturn(false);

        /** @var array<int, array<string, mixed>> $testData */
        $testData = $this->sushiTestData();

        expect($this->sushiModel()->saveToJson($testData))->toBeFalse();
    });

    it('handles creating event correctly', function (): void {
        Auth::shouldReceive('id')->andReturn(1);

        $model = new TestSushiModel;
        $model->fill(['name' => 'New Item', 'description' => 'New Description']);

        expect($model->name)->toBe('New Item');
        expect($model->getJsonFile())->toBeString()->toEndWith('test_sushi.json');
    });

    it('integrates with tenant service correctly', function (): void {
        expect(app(TenantService::class))->toBeInstanceOf(TenantService::class);
        expect($this->sushiModel()->getJsonFile())->toBe($this->testJsonPath);
    });

    it('handles large datasets efficiently', function (): void {
        $largeData = [];
        for ($i = 1; $i <= 1000; $i++) {
            $largeData[$i] = [
                'id' => $i,
                'name' => "Item {$i}",
                'description' => "Description for item {$i}",
                'status' => ($i % 2) === 0 ? 'active' : 'inactive',
                'created_at' => now()->toISOString(),
                'updated_at' => now()->toISOString(),
            ];
        }

        $startTime = microtime(true);
        expect($this->sushiModel()->saveToJson($largeData))->toBeTrue();
        expect(microtime(true) - $startTime)->toBeLessThan(1.0);

        $startTime = microtime(true);
        $rows = $this->sushiModel()->getSushiRows();
        expect(microtime(true) - $startTime)->toBeLessThan(0.5);
        expect($rows)->toHaveCount(1000);
    });

    it('maintains data integrity during operations', function (): void {
        /** @var array<int, array<string, mixed>> $originalData */
        $originalData = $this->sushiTestData();
        File::put($this->testJsonPath, json_encode($originalData, JSON_PRETTY_PRINT));

        expect($this->sushiModel()->loadExistingData())->toBe($originalData);

        $updatedData = $originalData;
        $updatedData[1]['name'] = 'Updated Name';

        expect($this->sushiModel()->saveToJson($updatedData))->toBeTrue();

        $finalData = $this->sushiModel()->loadExistingData();
        expect($this->jsonRecordAt($finalData, 1)['name'])->toBe('Updated Name');
        expect($this->jsonRecordAt($finalData, 2)['name'])->toBe('Test Item 2');
    });
});
