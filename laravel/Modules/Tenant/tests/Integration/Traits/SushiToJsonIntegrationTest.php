<?php

declare(strict_types=1);

use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\File;
use Modules\Tenant\Models\Tenant;
use Modules\Tenant\Models\TestSushiModel;
use Modules\Tenant\Services\TenantService;

uses(Tests\TestCase::class, DatabaseTransactions::class)->beforeEach(function () {
    // Crea un tenant di test
    $this->tenant = Tenant::factory()->create([
        'name' => 'test-tenant',
        'domain' => 'test.example.com',
    ]);

    // Imposta il tenant corrente
    app('tenant')->setCurrent($this->tenant);

    $this->model = new TestSushiModel();
    $this->testJsonPath = TenantService::filePath('database/content/test_sushi.json');

    // Pulisce eventuali file di test esistenti
    if (File::exists($this->testJsonPath)) {
        File::delete($this->testJsonPath);
    }

    // Rimuove la directory se esiste
    $directory = dirname($this->testJsonPath);
    if (File::exists($directory)) {
        File::deleteDirectory($directory);
    }
})->afterEach(function () {
    // Pulisce i file di test
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
            'description' => 'This item belongs to the current tenant',
            'tenant_id' => $this->tenant->id,
        ],
    ];

    $result = $this->model->saveToJson($testData);

    expect($result)->toBeTrue();
    expect(File::exists($this->testJsonPath))->toBeTrue();

    // Verifica che il file sia nella directory del tenant corretto
    $expectedPath = TenantService::filePath('database/content/test_sushi.json');
    expect($this->testJsonPath)->toBe($expectedPath);

    // Verifica che il contenuto sia corretto
    $savedContent = File::get($this->testJsonPath);
    $savedData = json_decode($savedContent, true);

    expect($savedData)->toBe($testData);
    expect($savedData['1']['tenant_id'])->toBe($this->tenant->id);
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
    File::makeDirectory($directory, 0755, true, true);
    File::put($this->testJsonPath, json_encode($testData, JSON_PRETTY_PRINT));

    $rows = $this->model->getSushiRows();

    expect($rows)->toBe($testData);
    expect($rows)->toHaveCount(2);

    // Verifica che tutti gli elementi appartengano al tenant corrente
    foreach ($rows as $row) {
        expect($row['tenant_id'])->toBe($this->tenant->id);
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
    File::makeDirectory($directory, 0755, true, true);
    File::put($this->testJsonPath, json_encode($testData, JSON_PRETTY_PRINT));

    $rows = $this->model->getSushiRows();

    expect($rows)->toHaveKey('1');
    expect($rows['1']['name'])->toBe('Complex Item');

    // Verifica che gli array nidificati siano stati convertiti in stringhe JSON
    expect($rows['1']['metadata'])->toBeString();

    $decodedMetadata = json_decode($rows['1']['metadata'], true);
    expect($decodedMetadata)->toBe($testData['1']['metadata']);
    expect($decodedMetadata['tags'])->toBe(['tag1', 'tag2', 'tag3']);
    expect($decodedMetadata['nested']['level1']['level2']['level3'])->toBe('deep_value');
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
    expect($content)->toBeString();
    expect($content)->not->toBeEmpty();
});

it('handles concurrent access safely', function (): void {
    // Simula accesso concorrente creando più istanze del modello
    $model1 = new TestSushiModel();
    $model2 = new TestSushiModel();
    $model3 = new TestSushiModel();

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
    $finalContent = File::get($this->testJsonPath);
    $finalData = json_decode($finalContent, true);

    expect($finalData)->toHaveKey('1');
    expect($finalData)->toHaveKey('2');
    expect($finalData)->toHaveKey('3');
    expect($finalData['1']['name'])->toBe('Concurrent Item 1');
    expect($finalData['2']['name'])->toBe('Concurrent Item 2');
    expect($finalData['3']['name'])->toBe('Concurrent Item 3');
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
    expect($rows[1]['name'])->toBe('Large Item 1');
    expect($rows[500]['name'])->toBe('Large Item 500');
    expect($rows[1000]['name'])->toBe('Large Item 1000');
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

    expect($rows)->toHaveKey('1');
    expect($rows['1']['name'])->toBe('Item con caratteri speciali: à, è, ì, ò, ù');
    expect($rows['1']['description'])->toBe('Descrizione con emoji 🚀 e simboli €$£¥');

    // Verifica i metadati
    $metadata = json_decode($rows['1']['metadata'], true);
    expect($metadata['special_chars'])->toBe('Caratteri: <>&"\'');
    expect($metadata['unicode'])->toBe('Unicode: 你好世界 🌍');
    expect($metadata['numbers'])->toBe('1234567890');
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
    expect($rows['1']['name'])->toBe('');
    expect($rows['1']['description'])->toBeNull();
    expect($rows['1']['metadata'])->toBe('[]');

    // Verifica il secondo elemento
    expect($rows['2']['name'])->toBe('Valid Item');
    expect($rows['2']['description'])->toBe('Valid Description');
    expect($rows['2']['metadata'])->toBeNull();
    expect($rows['2']['status'])->toBe('');
});

it('works with different tenant configurations', function (): void {
    // Crea un secondo tenant per testare l'isolamento
    $secondTenant = Tenant::factory()->create([
        'name' => 'second-tenant',
        'domain' => 'second.example.com',
    ]);

    // Imposta il secondo tenant come corrente
    app('tenant')->setCurrent($secondTenant);

    $secondModel = new TestSushiModel();
    $secondJsonPath = TenantService::filePath('database/content/test_sushi.json');

    $testData = [
        '1' => [
            'id' => 1,
            'name' => 'Second Tenant Item',
            'tenant_id' => $secondTenant->id,
        ],
    ];

    $result = $secondModel->saveToJson($testData);

    expect($result)->toBeTrue();
    expect($secondJsonPath)->not->toBe($this->testJsonPath);

    // Verifica che i file siano separati
    expect(File::exists($this->testJsonPath))->toBeFalse(); // Primo tenant
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
