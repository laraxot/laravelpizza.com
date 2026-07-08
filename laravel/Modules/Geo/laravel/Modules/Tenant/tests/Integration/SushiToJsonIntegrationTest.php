<?php

declare(strict_types=1);

namespace Modules\Tenant\Tests\Integration;

use Illuminate\Support\Facades\File;
use Modules\Tenant\Models\TestSushiModel;
use Modules\Tenant\Tests\TestCase;
use Modules\Xot\Actions\Cast\SafeStringCastAction;

uses(TestCase::class);

function tenantJsonPath(string $tenantName): string
{
    $dir = storage_path('tests/sushi-json/'.$tenantName);
    if (! File::exists($dir)) {
        File::makeDirectory($dir, 0o755, true, true);
    }

    return $dir.'/test_sushi.json';
}

function makeTestSushiModelForPath(string $jsonPath): TestSushiModel
{
    $model = new class extends TestSushiModel
    {
        public string $jsonPath = '';

        public function setJsonPath(string $jsonPath): void
        {
            $this->jsonPath = $jsonPath;
        }

        public function getJsonFile(): string
        {
            return $this->jsonPath;
        }
    };

    $model->setJsonPath($jsonPath);

    return $model;
}

/**
 * @param  array<array-key, array<string, mixed>>  $rows
 */
function rowNameById(array $rows, int $id): string
{
    foreach ($rows as $row) {
        if (! is_array($row)) {
            continue;
        }

        if (($row['id'] ?? null) === $id) {
            return SafeStringCastAction::cast($row['name'] ?? '');
        }
    }

    return '';
}

beforeEach(function (): void {
    $root = storage_path('tests/sushi-json');
    if (File::exists($root)) {
        File::deleteDirectory($root);
    }
});

afterEach(function (): void {
    $root = storage_path('tests/sushi-json');
    if (File::exists($root)) {
        File::deleteDirectory($root);
    }
});

test('creates json file with tenant isolation', function (): void {
    $tenant1Path = tenantJsonPath('tenant1');
    $tenant2Path = tenantJsonPath('tenant2');

    $model1 = makeTestSushiModelForPath($tenant1Path);
    $model2 = makeTestSushiModelForPath($tenant2Path);

    $model1->saveToJson([
        1 => ['id' => 1, 'name' => 'Tenant 1 Item', 'description' => 'Item specifico per tenant 1', 'status' => 'active'],
    ]);

    expect(File::exists($tenant1Path))->toBeTrue();
    expect(File::exists($tenant2Path))->toBeFalse();

    $model2->saveToJson([
        1 => ['id' => 1, 'name' => 'Tenant 2 Item', 'description' => 'Item specifico per tenant 2', 'status' => 'active'],
    ]);

    expect(File::exists($tenant2Path))->toBeTrue();

    $tenant1Data = decodeTenantJsonFile($tenant1Path);
    $tenant2Data = decodeTenantJsonFile($tenant2Path);

    expect(rowNameById($tenant1Data, 1))->toBe('Tenant 1 Item');
    expect(rowNameById($tenant2Data, 1))->toBe('Tenant 2 Item');
});

test('loads data with tenant isolation', function (): void {
    $model1 = makeTestSushiModelForPath(tenantJsonPath('tenant1'));
    $model2 = makeTestSushiModelForPath(tenantJsonPath('tenant2'));

    $model1->saveToJson([
        1 => ['id' => 1, 'name' => 'Tenant 1 Item 1', 'status' => 'active'],
        2 => ['id' => 2, 'name' => 'Tenant 1 Item 2', 'status' => 'active'],
    ]);
    $model2->saveToJson([
        1 => ['id' => 1, 'name' => 'Tenant 2 Item 1', 'status' => 'active'],
        2 => ['id' => 2, 'name' => 'Tenant 2 Item 2', 'status' => 'active'],
    ]);

    $rows1 = $model1->getSushiRows();
    $rows2 = $model2->getSushiRows();

    expect($rows1)->toHaveCount(2);
    expect($rows2)->toHaveCount(2);
    expect(rowNameById($rows1, 1))->toBe('Tenant 1 Item 1');
    expect(rowNameById($rows2, 1))->toBe('Tenant 2 Item 1');
    expect($rows1)->not->toBe($rows2);
});

test('handles complex data structures', function (): void {
    $model = makeTestSushiModelForPath(tenantJsonPath('tenant1'));

    $complexData = [
        1 => [
            'id' => 1,
            'name' => 'Complex Item',
            'metadata' => [
                'tags' => ['tag1', 'tag2', 'tag3'],
                'settings' => ['enabled' => true, 'max_retries' => 3, 'timeout' => 30.5],
            ],
            'status' => 'active',
        ],
    ];

    expect($model->saveToJson($complexData))->toBeTrue();

    $row = rowNameById($model->getSushiRows(), 1);
    expect($row)->toBe('Complex Item');
});

test('handles large datasets efficiently', function (): void {
    $model = makeTestSushiModelForPath(tenantJsonPath('tenant1'));

    $largeData = [];
    for ($i = 1; $i <= 500; $i++) {
        $largeData[$i] = [
            'id' => $i,
            'name' => "Large Dataset Item {$i}",
            'status' => 0 === ($i % 2) ? 'active' : 'inactive',
        ];
    }

    expect($model->saveToJson($largeData))->toBeTrue();
    expect($model->getSushiRows())->toHaveCount(500);
});

test('works with different tenant configurations', function (): void {
    $customDir = storage_path('tests/sushi-json/custom-tenant');
    if (! File::exists($customDir)) {
        File::makeDirectory($customDir, 0o755, true, true);
    }

    $model = makeTestSushiModelForPath($customDir.'/test_sushi.json');

    expect($model->saveToJson([
        1 => ['id' => 1, 'name' => 'Custom Tenant Item', 'status' => 'active'],
    ]))->toBeTrue();

    expect(File::exists($customDir.'/test_sushi.json'))->toBeTrue();
});
