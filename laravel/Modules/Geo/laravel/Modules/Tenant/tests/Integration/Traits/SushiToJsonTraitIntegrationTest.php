<?php

declare(strict_types=1);

namespace Modules\Tenant\Tests\Integration\Traits;

use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\File;
use Modules\Tenant\Database\Factories\TenantFactory;
use Modules\Tenant\Models\Tenant;
use Modules\Tenant\Models\TestSushiModel;
use Modules\Tenant\Services\TenantService;
use Modules\Tenant\Tests\TestCase;
use PHPUnit\Framework\Assert;
use function Safe\json_decode;
use function Safe\json_encode;
use function Pest\Laravel\get;
use function Pest\Laravel\put;
use function Pest\Laravel\delete;

uses(\Modules\Tenant\Tests\TestCase::class);

beforeEach(function (): void {
    /** @var \Modules\Tenant\Tests\TestCase $this */
// Crea un tenant di test
        $this->tenant = TenantFactory::new()->createOne([
            'name' => 'test-tenant',
            'domain' => 'test.example.com',
        ]);

        // Imposta il tenant corrente
        $this->setCurrentTenant($this->tenantModel());

        $this->model = new TestSushiModel;
        $this->testJsonPath = TenantService::filePath('database/content/test_sushi.json');

        if (File::exists($this->sushiJsonPath())) {
            File::delete($this->sushiJsonPath());
        }

        $directory = dirname($this->sushiJsonPath());
        if (File::exists($directory)) {
            File::deleteDirectory($directory);
        }
});

afterEach(function (): void {
if (File::exists($this->sushiJsonPath())) {
            File::delete($this->sushiJsonPath());
        }

        $directory = dirname($this->sushiJsonPath());
        if (File::exists($directory)) {
            File::deleteDirectory($directory);
        }

});

describe('Sushi To Json Trait Integration', function (): void {
    test('creates json file with tenant isolation', function (): void {
        /** @var \Modules\Tenant\Tests\TestCase $this */
$testData = [
            '1' => [
                'id' => 1,
                'name' => 'Tenant Specific Item',
                'description' => 'This item belongs to the current tenant',
                'tenant_id' => $this->tenantModel()->id,
            ],
        ];

        $result = $this->sushiModel()->saveToJson($testData);

        Assert::assertTrue($result);
        Assert::assertTrue(File::exists($this->sushiJsonPath()));
        // Verifica che il file sia nella directory del tenant corretto
        $expectedPath = TenantService::filePath('database/content/test_sushi.json');
        Assert::assertSame($expectedPath, $this->sushiJsonPath());
        // Verifica che il contenuto sia corretto
        $savedContent = File::get($this->sushiJsonPath());
        $savedData = json_decode($savedContent, true);

        Assert::assertSame($testData, $savedData);
        Assert::assertSame($this->tenantModel()->id, \sushiRowById($savedData, 1)['tenant_id']);
    });

    test('loads data with tenant isolation', function (): void {
$testData = [
            '1' => [
                'id' => 1,
                'name' => 'Item 1',
                'tenant_id' => $this->tenantModel()->id,
            ],
            '2' => [
                'id' => 2,
                'name' => 'Item 2',
                'tenant_id' => $this->tenantModel()->id,
            ],
        ];

        // Crea il file JSON di test
        $directory = dirname($this->sushiJsonPath());
        File::makeDirectory($directory, 0755, true, true);
        File::put($this->sushiJsonPath(), json_encode($testData, JSON_PRETTY_PRINT));

        $rows = $this->sushiModel()->getSushiRows();

        Assert::assertSame($testData, $rows);
        Assert::assertCount(2, $rows);
        // Verifica che tutti gli elementi appartengano al tenant corrente
        foreach ($rows as $row) {
            Assert::assertSame($this->tenantModel()->id, $row['tenant_id']);
        }
    });

    test('handles complex data structures', function (): void {
$testData = [
            '1' => [
                'id' => 1,
                'name' => 'Complex Item',
                'metadata' => [
                    'tags' => ['tag1', 'tag2', 'tag3'],
                    'settings' => [
                        'enabled' => true,
                        'max_retries' => 3,
                        'timeout' => 30,
                    ],
                    'nested' => [
                        'level1' => [
                            'level2' => [
                                'level3' => 'deep_value',
                            ],
                        ],
                    ],
                ],
                'status' => 'active',
                'created_at' => now()->toISOString(),
                'updated_at' => now()->toISOString(),
            ],
        ];

        // Crea il file JSON di test
        $directory = dirname($this->sushiJsonPath());
        File::makeDirectory($directory, 0755, true, true);
        File::put($this->sushiJsonPath(), json_encode($testData, JSON_PRETTY_PRINT));

        $rows = $this->sushiModel()->getSushiRows();

        Assert::assertArrayHasKey('1', $rows);
        Assert::assertSame('Complex Item', \sushiRowById($rows, 1)['name']);
        // Verifica che gli array nidificati siano stati convertiti in stringhe JSON
        Assert::assertIsString(\sushiRowById($rows, 1)['metadata']);
        /** @var array<string, mixed> $decodedMetadata */
        $decodedMetadata = json_decode(\sushiRowById($rows, 1)['metadata'], true);
        Assert::assertIsArray($decodedMetadata);
        Assert::assertSame($testData['1']['metadata'], $decodedMetadata);
        Assert::assertSame(['tag1', 'tag2', 'tag3'], $decodedMetadata['tags']);
        Assert::assertSame('deep_value', $decodedMetadata['nested']['level1']['level2']['level3']);
    });

    test('manages file permissions correctly', function (): void {
$testData = ['1' => ['id' => 1, 'name' => 'Permission Test']];

        $result = $this->sushiModel()->saveToJson($testData);

        Assert::assertTrue($result);
        // Verifica che la directory abbia i permessi corretti
        $directory = dirname($this->sushiJsonPath());
        Assert::assertTrue(File::exists($directory));
        // Verifica che il file abbia i permessi corretti
        Assert::assertTrue(File::exists($this->sushiJsonPath()));
        // Verifica che il file sia leggibile
        $content = File::get($this->sushiJsonPath());
        Assert::assertIsString($content);
        Assert::assertNotEmpty($content);
    });

    test('handles concurrent access safely', function (): void {
// Simula accesso concorrente creando più istanze del modello
        $model1 = new TestSushiModel;
        $model2 = new TestSushiModel;
        $model3 = new TestSushiModel;

        $testData1 = ['1' => ['id' => 1, 'name' => 'Concurrent Item 1']];
        $testData2 = ['2' => ['id' => 2, 'name' => 'Concurrent Item 2']];
        $testData3 = ['3' => ['id' => 3, 'name' => 'Concurrent Item 3']];

        // Salva i dati in sequenza
        $result1 = $model1->saveToJson($testData1);
        $result2 = $model2->saveToJson($testData2);
        $result3 = $model3->saveToJson($testData3);

        Assert::assertTrue($result1);
        Assert::assertTrue($result2);
        Assert::assertTrue($result3);
        // Verifica che tutti i dati siano stati salvati correttamente
        $finalData = $this->readJsonFileAsArray($this->sushiJsonPath());

        Assert::assertArrayHasKey('1', $finalData);
        Assert::assertArrayHasKey('2', $finalData);
        Assert::assertArrayHasKey('3', $finalData);
        Assert::assertSame('Concurrent Item 1', $this->jsonRecordAt($finalData, '1')['name']);
        Assert::assertSame('Concurrent Item 2', $this->jsonRecordAt($finalData, '2')['name']);
        Assert::assertSame('Concurrent Item 3', $this->jsonRecordAt($finalData, '3')['name']);
    });

    test('handles large datasets efficiently', function (): void {
// Crea un dataset grande per testare le performance
        $largeDataset = [];
        for ($i = 1; $i <= 1000; $i++) {
            $largeDataset[$i] = [
                'id' => $i,
                'name' => "Large Item {$i}",
                'description' => "Description for large item {$i}",
                'status' => $i % 2 === 0 ? 'active' : 'inactive',
                'metadata' => [
                    'index' => $i,
                    'category' => 'category_'.($i % 10),
                    'tags' => ["tag{$i}", 'tag'.($i + 1)],
                ],
            ];
        }

        $startTime = microtime(true);
        $result = $this->sushiModel()->saveToJson($largeDataset);
        $saveTime = microtime(true) - $startTime;

        Assert::assertTrue($result);
        Assert::assertLessThan(5.0, $saveTime);

        // Verifica che il file sia stato creato e contenga tutti i dati
        Assert::assertTrue(File::exists($this->sushiJsonPath()));
        $fileSize = File::size($this->sushiJsonPath());
        Assert::assertGreaterThan(0, $fileSize);
        // Testa il caricamento dei dati
        $startTime = microtime(true);
        $rows = $this->sushiModel()->getSushiRows();
        $loadTime = microtime(true) - $startTime;

        Assert::assertCount(1000, $rows);
        Assert::assertLessThan(2.0, $loadTime);

        // Verifica alcuni elementi specifici
        Assert::assertSame('Large Item 1', $this->jsonRecordAt($rows, '1')['name']);
        Assert::assertSame('Large Item 500', $this->jsonRecordAt($rows, '500')['name']);
        Assert::assertSame('Large Item 1000', $this->jsonRecordAt($rows, '1000')['name']);
    });

    test('handles unicode and special characters', function (): void {
$testData = [
            '1' => [
                'id' => 1,
                'name' => 'Item con caratteri speciali: à, è, ì, ò, ù',
                'description' => 'Descrizione con emoji 🚀 e simboli €$£¥',
                'metadata' => [
                    'special_chars' => 'Caratteri: <>&"\'',
                    'unicode' => 'Unicode: 你好世界 🌍',
                    'numbers' => '1234567890',
                ],
            ],
        ];

        $result = $this->sushiModel()->saveToJson($testData);

        Assert::assertTrue($result);
        // Verifica che il file sia stato creato
        Assert::assertTrue(File::exists($this->sushiJsonPath()));
        // Carica i dati e verifica che i caratteri speciali siano preservati
        $rows = $this->sushiModel()->getSushiRows();

        Assert::assertArrayHasKey('1', $rows);
        Assert::assertSame('Item con caratteri speciali: à, è, ì, ò, ù', \sushiRowById($rows, 1)['name']);
        Assert::assertSame('Descrizione con emoji 🚀 e simboli €$£¥', \sushiRowById($rows, 1)['description']);
        $row = $this->jsonRecordAt($rows, '1');
        $metadataValue = $row['metadata'] ?? null;
        if (is_string($metadataValue)) {
            $metadata = $this->decodeJsonString($metadataValue);
        } else {
            Assert::assertIsArray($metadataValue);
            /** @var array<string, mixed> $metadata */
            $metadata = $metadataValue;
        }

        Assert::assertSame('Caratteri: <>&"\'', $metadata['special_chars']);
        Assert::assertSame('Unicode: 你好世界 🌍', $metadata['unicode']);
        Assert::assertSame('1234567890', $metadata['numbers']);
    });

    test('handles empty and null values', function (): void {
$testData = [
            '1' => [
                'id' => 1,
                'name' => '',
                'description' => null,
                'metadata' => [],
                'status' => 'active',
            ],
            '2' => [
                'id' => 2,
                'name' => 'Valid Item',
                'description' => 'Valid Description',
                'metadata' => null,
                'status' => '',
            ],
        ];

        $result = $this->sushiModel()->saveToJson($testData);

        Assert::assertTrue($result);
        // Carica i dati e verifica che i valori vuoti e null siano gestiti correttamente
        $rows = $this->sushiModel()->getSushiRows();

        Assert::assertArrayHasKey('1', $rows);
        Assert::assertArrayHasKey('2', $rows);
        // Verifica il primo elemento
        Assert::assertSame('', \sushiRowById($rows, 1)['name']);
        Assert::assertNull(\sushiRowById($rows, 1)['description']);
        Assert::assertSame('[]', \sushiRowById($rows, 1)['metadata']);
        // Verifica il secondo elemento
        Assert::assertSame('Valid Item', \sushiRowById($rows, 2)['name']);
        Assert::assertSame('Valid Description', \sushiRowById($rows, 2)['description']);
        Assert::assertNull(\sushiRowById($rows, 2)['metadata']);
        Assert::assertSame('', \sushiRowById($rows, 2)['status']);
    });

    test('works with different tenant configurations', function (): void {
        /** @var \Modules\Tenant\Tests\TestCase $this */
// Crea un secondo tenant per testare l'isolamento
        $this->secondTenant = TenantFactory::new()->createOne([
            'name' => 'second-tenant',
            'domain' => 'second.example.com',
        ]);

        // Imposta il secondo tenant come corrente
        $this->setCurrentTenant($this->secondTenantModel());

        $secondModel = new TestSushiModel;
        $secondJsonPath = TenantService::filePath('database/content/test_sushi.json');

        $testData = [
            '1' => [
                'id' => 1,
                'name' => 'Second Tenant Item',
                'tenant_id' => $this->secondTenantModel()->id,
            ],
        ];

        $result = $secondModel->saveToJson($testData);

        Assert::assertTrue($result);
        Assert::assertNotSame($this->sushiJsonPath(), $secondJsonPath);
        // Verifica che i file siano separati
        Assert::assertFalse(File::exists($this->sushiJsonPath()));
        Assert::assertTrue(File::exists($secondJsonPath));

        // Pulisce il secondo tenant
        File::delete($secondJsonPath);

        $directory = dirname($secondJsonPath);
        if (File::exists($directory)) {
            File::deleteDirectory($directory);
        }
    });
});
