<?php

declare(strict_types=1);

namespace Modules\Tenant\Tests\Integration\Traits;

use Illuminate\Support\Facades\File;
use Modules\Tenant\Models\Tenant;
use Modules\Tenant\Models\TestSushiModel;
use Modules\Tenant\Tests\Fixtures\TestSushiModelForPath;
use Modules\Tenant\Tests\TestCase;
use PHPUnit\Framework\Assert;

use function Safe\json_decode;
use function Safe\json_encode;

uses(TestCase::class);

beforeEach(function () {
    // Crea un tenant di test
    $this->tenant = Tenant::factory()->create([
        'name' => 'test-tenant',
        'domain' => 'test.example.com',
    ]);
    Assert::assertInstanceOf(Tenant::class, $this->tenant);

    // Imposta il tenant corrente
    $this->setCurrentTenant($this->tenant);

    $this->model = new TestSushiModel;
    $this->testJsonPath = storage_path('tests/sushi-json/test_sushi.json');
    $this->testDirectory = dirname($this->testJsonPath);

    // Pulisce eventuali file di test esistenti
    if (File::exists($this->testJsonPath)) {
        File::delete($this->testJsonPath);
    }
});

afterEach(function () {
    // Pulisce i file di test
    if (File::exists($this->testJsonPath)) {
        File::delete($this->testJsonPath);
    }
});

it('creates json file with tenant isolation', function (): void {
    $testData = [
        '1' => [
            'id' => 1,
            'name' => 'Tenant Specific Item',
            'description' => 'This item belongs to the current tenant',
            'tenant_id' => $this->tenant->id,
        ],
    ];

    $result = $this->model->saveToJson($testData);

    expect($result)->toBeTrue();
    expect(File::exists($this->testJsonPath))->toBeTrue();

    // Verifica che il file sia nella directory del tenant corretto
    $expectedPath = storage_path('tests/sushi-json/test_sushi.json');
    expect($this->testJsonPath)->toBe($expectedPath);

    // Verifica che il contenuto sia corretto
    $savedContent = File::get($this->testJsonPath);
    $savedData = json_decode($savedContent, true);
    Assert::assertIsArray($savedData);

    expect($savedData)->toBe($testData);
    $savedRow = $this->jsonRecordAt($savedData, '1');
    Assert::assertSame($this->tenant->id, $savedRow['tenant_id'] ?? null);
});

it('loads data with tenant isolation', function (): void {
    $testData = [
        '1' => [
            'id' => 1,
            'name' => 'Item 1',
            'tenant_id' => $this->tenant->id,
        ],
        '2' => [
            'id' => 2,
            'name' => 'Item 2',
            'tenant_id' => $this->tenant->id,
        ],
    ];

    // Crea il file JSON di test
    $directory = dirname($this->testJsonPath);
    File::makeDirectory($directory, 0o755, true, true);
    File::put($this->testJsonPath, json_encode($testData, JSON_PRETTY_PRINT));

    $rows = $this->model->getSushiRows();

    expect($rows)->toBe($testData);
    expect($rows)->toHaveCount(2);

    // Verifica che tutti gli elementi appartengano al tenant corrente
    foreach ($rows as $row) {
        Assert::assertSame($this->tenant->id, $row['tenant_id'] ?? null);
    }
});

it('handles complex data structures', function (): void {
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
    $directory = dirname($this->testJsonPath);
    File::makeDirectory($directory, 0o755, true, true);
    File::put($this->testJsonPath, json_encode($testData, JSON_PRETTY_PRINT));

    $rows = $this->model->getSushiRows();
    $row = $this->jsonRecordAt($rows, '1');

    Assert::assertSame('Complex Item', $row['name'] ?? null);

    // Verifica che gli array nidificati siano stati convertiti in stringhe JSON
    $metadata = $row['metadata'] ?? null;
    Assert::assertIsString($metadata);

    $decodedMetadata = json_decode($metadata, true);
    Assert::assertIsArray($decodedMetadata);
    // Il confronto strict sull'intero array copre anche `tags` e `nested.level1.level2.level3`.
    Assert::assertSame($testData['1']['metadata'], $decodedMetadata);
});

it('manages file permissions correctly', function (): void {
    $testData = ['1' => ['id' => 1, 'name' => 'Permission Test']];

    $result = $this->model->saveToJson($testData);

    expect($result)->toBeTrue();

    // Verifica che la directory abbia i permessi corretti
    $directory = dirname($this->testJsonPath);
    expect(File::exists($directory))->toBeTrue();

    // Verifica che il file abbia i permessi corretti
    expect(File::exists($this->testJsonPath))->toBeTrue();

    // Verifica che il file sia leggibile
    $content = File::get($this->testJsonPath);
    expect($content)->not->toBeEmpty();
});

it('handles concurrent access safely', function (): void {
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

    expect($result1)->toBeTrue();
    expect($result2)->toBeTrue();
    expect($result3)->toBeTrue();

    // Verifica che tutti i dati siano stati salvati correttamente
    $finalData = $this->readJsonFileAsArray($this->testJsonPath);

    expect($finalData)->toHaveKey('1');
    expect($finalData)->toHaveKey('2');
    expect($finalData)->toHaveKey('3');
    Assert::assertSame('Concurrent Item 1', $this->jsonRecordAt($finalData, '1')['name'] ?? null);
    Assert::assertSame('Concurrent Item 2', $this->jsonRecordAt($finalData, '2')['name'] ?? null);
    Assert::assertSame('Concurrent Item 3', $this->jsonRecordAt($finalData, '3')['name'] ?? null);
});

it('handles large datasets efficiently', function (): void {
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
    $result = $this->model->saveToJson($largeDataset);
    $saveTime = microtime(true) - $startTime;

    expect($result)->toBeTrue();
    expect($saveTime)->toBeLessThan(5.0); // Dovrebbe essere completato in meno di 5 secondi

    // Verifica che il file sia stato creato e contenga tutti i dati
    expect(File::exists($this->testJsonPath))->toBeTrue();

    $fileSize = File::size($this->testJsonPath);
    expect($fileSize)->toBeGreaterThan(0);

    // Testa il caricamento dei dati
    $startTime = microtime(true);
    $rows = $this->model->getSushiRows();
    $loadTime = microtime(true) - $startTime;

    expect($rows)->toHaveCount(1000);
    expect($loadTime)->toBeLessThan(2.0); // Dovrebbe essere caricato in meno di 2 secondi

    // Verifica alcuni elementi specifici
    Assert::assertSame('Large Item 1', $this->jsonRecordAt($rows, '1')['name'] ?? null);
    Assert::assertSame('Large Item 500', $this->jsonRecordAt($rows, '500')['name'] ?? null);
    Assert::assertSame('Large Item 1000', $this->jsonRecordAt($rows, '1000')['name'] ?? null);
});

it('handles unicode and special characters', function (): void {
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

    $result = $this->model->saveToJson($testData);

    expect($result)->toBeTrue();

    // Verifica che il file sia stato creato
    expect(File::exists($this->testJsonPath))->toBeTrue();

    // Carica i dati e verifica che i caratteri speciali siano preservati
    $rows = $this->model->getSushiRows();
    $row = $this->jsonRecordAt($rows, '1');

    Assert::assertSame('Item con caratteri speciali: à, è, ì, ò, ù', $row['name'] ?? null);
    Assert::assertSame('Descrizione con emoji 🚀 e simboli €$£¥', $row['description'] ?? null);

    // Verifica i metadati
    $metadataValue = $row['metadata'] ?? null;
    Assert::assertIsString($metadataValue);
    $metadata = json_decode($metadataValue, true);
    Assert::assertIsArray($metadata);
    Assert::assertSame('Caratteri: <>&"\'', $metadata['special_chars'] ?? null);
    Assert::assertSame('Unicode: 你好世界 🌍', $metadata['unicode'] ?? null);
    Assert::assertSame('1234567890', $metadata['numbers'] ?? null);
});

it('handles empty and null values', function (): void {
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

    $result = $this->model->saveToJson($testData);

    expect($result)->toBeTrue();

    // Carica i dati e verifica che i valori vuoti e null siano gestiti correttamente
    $rows = $this->model->getSushiRows();

    expect($rows)->toHaveKey('1');
    expect($rows)->toHaveKey('2');

    // Verifica il primo elemento
    $row1 = $this->jsonRecordAt($rows, '1');
    Assert::assertSame('', $row1['name'] ?? null);
    Assert::assertNull($row1['description'] ?? null);
    Assert::assertSame('[]', $row1['metadata'] ?? null);

    // Verifica il secondo elemento
    $row2 = $this->jsonRecordAt($rows, '2');
    Assert::assertSame('Valid Item', $row2['name'] ?? null);
    Assert::assertSame('Valid Description', $row2['description'] ?? null);
    Assert::assertNull($row2['metadata'] ?? null);
    Assert::assertSame('', $row2['status'] ?? null);
});

it('works with different tenant configurations', function (): void {
    // Crea un secondo tenant per testare l'isolamento
    $this->secondTenant = Tenant::factory()->create([
        'name' => 'second-tenant',
        'domain' => 'second.example.com',
    ]);
    Assert::assertInstanceOf(Tenant::class, $this->secondTenant);

    // Imposta il secondo tenant come corrente
    $this->setCurrentTenant($this->secondTenantModel());

    // Usiamo modelli con path esplicito per simulare il file JSON di ogni tenant
    $firstJsonPath = storage_path('tests/sushi-json/tenant-first/test_sushi.json');
    $secondJsonPath = storage_path('tests/sushi-json/tenant-second/test_sushi.json');

    $secondModel = (new TestSushiModelForPath)->setJsonPath($secondJsonPath);

    $testData = [
        '1' => [
            'id' => 1,
            'name' => 'Second Tenant Item',
            'tenant_id' => $this->secondTenantModel()->id,
        ],
    ];

    $result = $secondModel->saveToJson($testData);

    expect($result)->toBeTrue();
    expect($secondJsonPath)->not->toBe($firstJsonPath);

    // Verifica che i file siano separati
    expect(File::exists($firstJsonPath))->toBeFalse(); // Primo tenant
    expect(File::exists($secondJsonPath))->toBeTrue(); // Secondo tenant

    // Pulisce il secondo tenant
    if (File::exists($secondJsonPath)) {
        File::delete($secondJsonPath);
    }

    $directory = dirname($secondJsonPath);
    if (File::exists($directory)) {
        File::deleteDirectory($directory);
    }
});
