<?php

declare(strict_types=1);

namespace Modules\Tenant\Tests\Integration;

use Illuminate\Support\Facades\File;
use Modules\Tenant\Models\TestSushiModel;
use Modules\Tenant\Tests\Fixtures\TestSushiModelForPath;
use Modules\Tenant\Tests\TestCase;
use Modules\Xot\Actions\Cast\SafeStringCastAction;
use PHPUnit\Framework\Assert;

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
    $model = new TestSushiModelForPath;
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

    Assert::assertFileExists($tenant1Path);
    Assert::assertFileDoesNotExist($tenant2Path);

    $model2->saveToJson([
        1 => ['id' => 1, 'name' => 'Tenant 2 Item', 'description' => 'Item specifico per tenant 2', 'status' => 'active'],
    ]);

    Assert::assertFileExists($tenant2Path);

    $tenant1Data = TestCase::decodeTenantJsonFile($tenant1Path);
    $tenant2Data = TestCase::decodeTenantJsonFile($tenant2Path);

    Assert::assertSame('Tenant 1 Item', rowNameById($tenant1Data, 1));
    Assert::assertSame('Tenant 2 Item', rowNameById($tenant2Data, 1));
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

    Assert::assertCount(2, $rows1);
    Assert::assertCount(2, $rows2);
    Assert::assertSame('Tenant 1 Item 1', rowNameById($rows1, 1));
    Assert::assertSame('Tenant 2 Item 1', rowNameById($rows2, 1));
    Assert::assertNotSame($rows1, $rows2);
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

    Assert::assertTrue($model->saveToJson($complexData));

    $row = rowNameById($model->getSushiRows(), 1);
    Assert::assertSame('Complex Item', $row);
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

    Assert::assertTrue($model->saveToJson($largeData));
    Assert::assertCount(500, $model->getSushiRows());
});

test('works with different tenant configurations', function (): void {
    $customDir = storage_path('tests/sushi-json/custom-tenant');
    if (! File::exists($customDir)) {
        File::makeDirectory($customDir, 0o755, true, true);
    }

    $model = makeTestSushiModelForPath($customDir.'/test_sushi.json');

    Assert::assertTrue($model->saveToJson([
        1 => ['id' => 1, 'name' => 'Custom Tenant Item', 'status' => 'active'],
    ]));

    Assert::assertFileExists($customDir.'/test_sushi.json');
});
