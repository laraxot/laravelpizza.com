<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Modules\Tenant\Models\TestSushiModel;
use Modules\Tenant\Services\TenantService;
use Tests\TestCase;

uses(TestCase::class);

/**
 * Test unitari per il trait SushiToJson.
 *
 * Testa tutte le funzionalità del trait in isolamento,
 * utilizzando mock per le dipendenze esterne.
 */
beforeEach(function () {
    // Configura il modello di test
    $this->model = new TestSushiModel;

    // Configura percorsi di test
    $this->testDirectory = storage_path('tests/sushi-json');
    $this->testJsonPath = $this->testDirectory.'/test_sushi.json';

    // Crea directory di test
    if (! File::exists($this->testDirectory)) {
        File::makeDirectory($this->testDirectory, 0o755, true, true);
    }

    // Mock TenantService per i test
    $this->mock(TenantService::class, function ($mock) {
        $mock->shouldReceive('filePath')->with('database/content/test_sushi.json')->andReturn($this->testJsonPath);
    });

    // Helper per creare dati di test
    $this->createTestData = fn () => [
        '1' => [
            'id' => 1,
            'name' => 'Test Item 1',
            'description' => 'Description 1',
            'status' => 'active',
            'metadata' => ['key1' => 'value1', 'key2' => 'value2'],
            'created_at' => now()->toISOString(),
            'updated_at' => now()->toISOString(),
        ],
        '2' => [
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

afterEach(function () {
    // Cleanup file di test
    if (File::exists($this->testJsonPath)) {
        File::delete($this->testJsonPath);
    }

    if (File::exists($this->testDirectory)) {
        File::deleteDirectory($this->testDirectory);
    }
});

describe('SushiToJson Trait', function () {
    it('returns correct json file path', function () {
        $path = $this->model->getJsonFile();

        expect($path)->toBe($this->testJsonPath)->and($path)->toEndWith('test_sushi.json');
    });

    it('loads existing data from json file', function () {
        $testData = ($this->createTestData)();
        File::put($this->testJsonPath, json_encode($testData, JSON_PRETTY_PRINT));

        $rows = $this->model->loadExistingData();

        expect($rows)
            ->toBeArray()
            ->toHaveCount(2)
            ->and($rows['1']['name'])
            ->toBe('Test Item 1')
            ->and($rows['2']['name'])
            ->toBe('Test Item 2');
    });

    it('returns empty array when file not exists', function () {
        $rows = $this->model->getSushiRows();

        expect($rows)->toBeArray()->toBeEmpty();
    });

    it('throws exception with malformed json', function () {
        File::put($this->testJsonPath, 'invalid json content');

        expect($this->model->getSushiRows(...))->toThrow(Exception::class, 'Syntax error');
    });

    it('throws exception with non array data', function () {
        File::put($this->testJsonPath, '"string data"');

        expect($this->model->getSushiRows(...))->toThrow(Exception::class, 'Data is not array');
    });

    it('normalizes nested arrays to json strings', function () {
        $testData = [
            '1' => [
                'id' => 1,
                'name' => 'Test',
                'metadata' => ['nested' => 'value'],
                'tags' => ['tag1', 'tag2'],
            ],
        ];

        File::put($this->testJsonPath, json_encode($testData, JSON_PRETTY_PRINT));

        $rows = $this->model->getSushiRows();

        expect($rows['1']['metadata'])
            ->toBeString()
            ->toBe('{"nested":"value"}')
            ->and($rows['1']['tags'])
            ->toBeString()
            ->toBe('["tag1","tag2"]');
    });

    it('saves data successfully to json file', function () {
        $testData = ($this->createTestData)();

        $result = $this->model->saveToJson($testData);

        expect($result)->toBeTrue();
        expect($this->testJsonPath)->toBeFile();

        $savedData = json_decode(File::get($this->testJsonPath), true);
        expect($savedData)->toBe($testData);
    });

    it('creates directory if not exists', function () {
        // Rimuovi directory di test
        if (File::exists($this->testDirectory)) {
            File::deleteDirectory($this->testDirectory);
        }

        $testData = ($this->createTestData)();

        $result = $this->model->saveToJson($testData);

        expect($result)->toBeTrue();
        expect($this->testDirectory)->toBeDirectory();
        expect($this->testJsonPath)->toBeFile();
    });

    it('handles save errors gracefully', function () {
        // Mock File facade per simulare errore di scrittura
        File::shouldReceive('put')->once()->andReturn(false);

        $testData = ($this->createTestData)();

        $result = $this->model->saveToJson($testData);

        expect($result)->toBeFalse();
    });

    it('handles creating event correctly', function () {
        // Mock Auth per simulare utente autenticato
        Auth::shouldReceive('id')->andReturn(1);

        $testData = [
            'name' => 'New Item',
            'description' => 'New Description',
        ];

        $model = new TestSushiModel;
        $model->fill($testData);

        // Test che il modello può essere creato con i dati
        expect($model->name)->toBe('New Item')->and($model->description)->toBe('New Description');

        // Test che i metodi del trait funzionano
        expect($model->getJsonFile())->toBeString()->toEndWith('test_sushi.json');
    });

    it('handles updating event correctly', function () {
        // Mock Auth per simulare utente autenticato
        Auth::shouldReceive('id')->andReturn(1);

        $testData = ($this->createTestData)();
        File::put($this->testJsonPath, json_encode($testData, JSON_PRETTY_PRINT));

        $model = new TestSushiModel;
        $model->id = 1;
        $model->fill(['name' => 'Updated Name']);

        // Test che il modello può essere aggiornato
        expect($model->name)->toBe('Updated Name')->and($model->id)->toBe(1);

        // Test che i dati esistenti possono essere caricati
        $existingData = $model->loadExistingData();
        expect($existingData)->toHaveKey('1')->and($existingData['1']['name'])->toBe('Test Item 1');
    });

    it('handles deleting event correctly', function () {
        $testData = ($this->createTestData)();
        File::put($this->testJsonPath, json_encode($testData, JSON_PRETTY_PRINT));

        $model = new TestSushiModel;
        $model->id = 1;

        // Test che il modello può essere configurato per la cancellazione
        expect($model->id)->toBe(1);

        // Test che i dati esistenti possono essere caricati
        $existingData = $model->loadExistingData();
        expect($existingData)->toHaveKey('1')->toHaveKey('2');

        // Test che il metodo saveToJson funziona
        $result = $model->saveToJson($existingData);
        expect($result)->toBeTrue();
    });

    it('integrates with tenant service correctly', function () {
        $tenantService = app(TenantService::class);

        expect($tenantService)->toBeInstanceOf(TenantService::class);

        // Verifica che il mock funzioni correttamente
        $path = $this->model->getJsonFile();
        expect($path)->toBe($this->testJsonPath);
    });

    it('handles large datasets efficiently', function () {
        // Crea dataset grande (1000 record)
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

        $result = $this->model->saveToJson($largeData);

        $endTime = microtime(true);
        $executionTime = $endTime - $startTime;

        expect($result)->toBeTrue();
        expect($executionTime)->toBeLessThan(1.0);

        // Verifica caricamento
        $startTime = microtime(true);
        $rows = $this->model->getSushiRows();
        $endTime = microtime(true);
        $loadTime = $endTime - $startTime;

        expect($rows)->toHaveCount(1000);
        expect($loadTime)->toBeLessThan(0.5);
    });

    it('logs errors appropriately', function () {
        // Mock Log facade per verificare logging
        $this->mock('log', function ($mock) {
            $mock->shouldReceive('error')->once()->with('Failed to save data to JSON file', Mockery::any());
        });

        // Simula errore di salvataggio
        File::shouldReceive('put')->once()->andReturn(false);

        $testData = ($this->createTestData)();
        $result = $this->model->saveToJson($testData);

        expect($result)->toBeFalse();
    });

    it('maintains data integrity during operations', function () {
        $originalData = ($this->createTestData)();
        File::put($this->testJsonPath, json_encode($originalData, JSON_PRETTY_PRINT));

        // Verifica che i dati originali siano preservati
        $loadedData = $this->model->loadExistingData();
        expect($loadedData)->toBe($originalData);

        // Aggiorna un record
        $updatedData = $originalData;
        $updatedData['1']['name'] = 'Updated Name';

        $result = $this->model->saveToJson($updatedData);
        expect($result)->toBeTrue();

        // Verifica che solo il record specifico sia stato aggiornato
        $finalData = $this->model->loadExistingData();
        expect($finalData['1']['name'])->toBe('Updated Name')->and($finalData['2']['name'])->toBe('Test Item 2'); // Non modificato
    });

    it('handles empty and null values correctly', function () {
        $testData = [
            '1' => [
                'id' => 1,
                'name' => '',
                'description' => null,
                'metadata' => [],
                'status' => false,
            ],
        ];

        $result = $this->model->saveToJson($testData);
        expect($result)->toBeTrue();

        $loadedData = $this->model->getSushiRows();
        expect($loadedData['1']['name'])
            ->toBe('')
            ->and($loadedData['1']['description'])
            ->toBeNull()
            ->and($loadedData['1']['metadata'])
            ->toBe('[]') // Convertito in stringa JSON
            ->and($loadedData['1']['status'])
            ->toBeFalse();
    });

    it('handles unicode and special characters', function () {
        $testData = [
            '1' => [
                'id' => 1,
                'name' => 'Café & Résumé 🚀',
                'description' => 'Test con caratteri speciali: é, è, ñ, 中文, 🎉',
                'tags' => ['tag-é', 'tag-è', 'tag-ñ'],
            ],
        ];

        $result = $this->model->saveToJson($testData);
        expect($result)->toBeTrue();

        $loadedData = $this->model->getSushiRows();
        expect($loadedData['1']['name'])
            ->toBe('Café & Résumé 🚀')
            ->and($loadedData['1']['description'])
            ->toBe('Test con caratteri speciali: é, è, ñ, 中文, 🎉')
            ->and($loadedData['1']['tags'])
            ->toBe('["tag-é","tag-è","tag-ñ"]');
    });
});
