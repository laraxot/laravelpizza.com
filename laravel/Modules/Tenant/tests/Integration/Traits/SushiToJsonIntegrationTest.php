<?php

declare(strict_types=1);

namespace Modules\Tenant\Tests\Integration\Traits;

use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\File;
use Modules\Tenant\Models\TestSushiModel;
use Modules\Tenant\Services\TenantService;
use Modules\Tenant\Tests\TestCase;

use function Safe\json_encode;

uses(TestCase::class, DatabaseTransactions::class);

/**
 * @param  array<array-key, mixed>  $data
 */
function writeTraitIntegrationJson(string $path, array $data): void
{
    $directory = dirname($path);
    File::makeDirectory($directory, 0755, true, true);
    File::put($path, json_encode($data, JSON_PRETTY_PRINT));
}

beforeEach(function (): void {
    $this->tenant = createTenant([
        'name' => 'test-tenant',
        'domain' => 'test.example.com',
    ]);

    $this->setCurrentTenant($this->tenantModel());

    $this->model = new TestSushiModel;
    $this->testJsonPath = TenantService::filePath('database/content/test_sushi.json');

    if (File::exists($this->testJsonPath)) {
        File::delete($this->testJsonPath);
    }

    $directory = dirname($this->testJsonPath);
    if (File::exists($directory)) {
        File::deleteDirectory($directory);
    }
});

afterEach(function (): void {
    if (File::exists($this->testJsonPath)) {
        File::delete($this->testJsonPath);
    }

    $directory = dirname($this->testJsonPath);
    if (File::exists($directory)) {
        File::deleteDirectory($directory);
    }
});

it('creates json file with tenant isolation', function (): void {
    $testData = [
        '1' => [
            'id' => 1,
            'name' => 'Tenant Specific Item',
            'tenant_id' => $this->tenantId(),
        ],
    ];

    expect($this->sushiModel()->saveToJson($testData))->toBeTrue();
    expect(File::exists($this->sushiJsonPath()))->toBeTrue();
    expect($this->sushiJsonPath())->toBe(TenantService::filePath('database/content/test_sushi.json'));

    $savedData = $this->readJsonFileAsArray($this->sushiJsonPath());
    expect($savedData)->toBe($testData);
    expect($this->jsonRecordAt($savedData, '1')['tenant_id'])->toBe($this->tenantId());
});

it('loads data with tenant isolation', function (): void {
    $tenantId = $this->tenantId();
    $testData = [
        '1' => ['id' => 1, 'name' => 'Item 1', 'tenant_id' => $tenantId],
        '2' => ['id' => 2, 'name' => 'Item 2', 'tenant_id' => $tenantId],
    ];

    writeTraitIntegrationJson($this->sushiJsonPath(), $testData);

    $rows = $this->sushiModel()->getSushiRows();

    expect($rows)->toHaveCount(2);
    foreach ($rows as $row) {
        if (! is_array($row)) {
            continue;
        }

        expect($row['tenant_id'] ?? null)->toBe($tenantId);
    }
});

it('handles large datasets efficiently', function (): void {
    $largeDataset = [];
    for ($i = 1; $i <= 1000; $i++) {
        $largeDataset[$i] = [
            'id' => $i,
            'name' => "Large Item {$i}",
            'status' => $i % 2 === 0 ? 'active' : 'inactive',
        ];
    }

    $startTime = microtime(true);
    expect($this->sushiModel()->saveToJson($largeDataset))->toBeTrue();
    expect(microtime(true) - $startTime)->toBeLessThan(5.0);

    $rows = $this->sushiModel()->getSushiRows();
    expect($rows)->toHaveCount(1000);
});

it('works with different tenant configurations', function (): void {
    $secondTenant = createTenant([
        'name' => 'second-tenant',
        'domain' => 'second.example.com',
    ]);

    $this->setCurrentTenant($secondTenant);

    $secondModel = new TestSushiModel;
    $secondJsonPath = TenantService::filePath('database/content/test_sushi.json');

    expect($secondModel->saveToJson([
        '1' => ['id' => 1, 'name' => 'Second Tenant Item', 'tenant_id' => $secondTenant->id],
    ]))->toBeTrue();

    expect($secondJsonPath)->not->toBe($this->sushiJsonPath());
    expect(File::exists($secondJsonPath))->toBeTrue();

    if (File::exists($secondJsonPath)) {
        File::delete($secondJsonPath);
    }

    $directory = dirname($secondJsonPath);
    if (File::exists($directory)) {
        File::deleteDirectory($directory);
    }
});
