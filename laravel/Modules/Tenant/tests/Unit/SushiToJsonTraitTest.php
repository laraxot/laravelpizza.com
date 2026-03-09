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
beforeEach(function (): void {
    // Configura il modello di test
    $this->model = new TestSushiModel;

    // Configura percorsi di test
    $this->testDirectory = storage_path('tests/sushi-json');
    $this->testJsonPath = $this->testDirectory.'/test_sushi.json';

    // Crea directory di test
    /** @phpstan-ignore-next-line property.notFound */
    if (! File::exists($this->testDirectory)) {
        /** @phpstan-ignore-next-line property.notFound */
        File::makeDirectory($this->testDirectory, 0o755, true, true);
    }

    // Mock TenantService per i test
    /** @phpstan-ignore-next-line property.notFound, method.nonObject */
    $this->mock(TenantService::class, function ($mock): void {
        /** @phpstan-ignore-next-line property.notFound, method.nonObject */
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

afterEach(function (): void {
    // Cleanup file di test
    /** @phpstan-ignore-next-line property.notFound */
    if (File::exists($this->testJsonPath)) {
        /** @phpstan-ignore-next-line property.notFound */
        File::delete($this->testJsonPath);
    }

    /** @phpstan-ignore-next-line property.notFound */
    if (File::exists($this->testDirectory)) {
        /** @phpstan-ignore-next-line property.notFound */
        File::deleteDirectory($this->testDirectory);
    }
});

describe('SushiToJson Trait', function (): void {
    it('returns correct json file path', function (): void {
        /** @phpstan-ignore-next-line property.notFound */
        $path = $this->model->getJsonFile();

        /** @phpstan-ignore-next-line property.notFound */
        expect($path)->toBe($this->testJsonPath)->and($path)->toEndWith('test_sushi.json');
    });

    it('loads existing data from json file', function (): void {
        /** @phpstan-ignore-next-line property.notFound */
        $testData = ($this->createTestData)();
        /** @phpstan-ignore-next-line property.notFound */
        File::put($this->testJsonPath, json_encode($testData, JSON_PRETTY_PRINT));

        /** @phpstan-ignore-next-line property.notFound */
        $rows = $this->model->loadExistingData();

        expect($rows)
            ->toBeArray()
            ->toHaveCount(2)
            /** @phpstan-ignore-next-line offsetAccess.nonOffsetAccessible */
            ->and($rows['1']['name'])
            ->toBe('Test Item 1')
            /** @phpstan-ignore-next-line offsetAccess.nonOffsetAccessible */
            ->and($rows['2']['name'])
            ->toBe('Test Item 2');
    });

    it('returns empty array when file not exists', function (): void {
        /** @phpstan-ignore-next-line property.notFound */
        $rows = $this->model->getSushiRows();

        expect($rows)->toBeArray()->toBeEmpty();
    });

    it('throws exception with malformed json', function (): void {
        /** @phpstan-ignore-next-line property.notFound */
        File::put($this->testJsonPath, 'invalid json content');

        /** @phpstan-ignore-next-line property.notFound */
        expect($this->model->getSushiRows(...))->toThrow(Exception::class, 'Syntax error');
    });

    it('throws exception with non array data', function (): void {
        /** @phpstan-ignore-next-line property.notFound */
        File::put($this->testJsonPath, '"string data"');

        /** @phpstan-ignore-next-line property.notFound */
        expect($this->model->getSushiRows(...))->toThrow(Exception::class, 'Data is not array');
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

        /** @phpstan-ignore-next-line property.notFound */
        File::put($this->testJsonPath, json_encode($testData, JSON_PRETTY_PRINT));

        /** @phpstan-ignore-next-line property.notFound */
        $rows = $this->model->getSushiRows();

        /** @phpstan-ignore-next-line offsetAccess.nonOffsetAccessible */
        expect($rows['1']['metadata'])
            ->toBeString()
            ->toBe('{"nested":"value"}')
            /** @phpstan-ignore-next-line offsetAccess.nonOffsetAccessible */
            ->and($rows['1']['tags'])
            ->toBeString()
            ->toBe('["tag1","tag2"]');
    });

    it('saves data successfully to json file', function (): void {
        /** @phpstan-ignore-next-line property.notFound */
        $testData = ($this->createTestData)();

        /** @phpstan-ignore-next-line property.notFound */
        $result = $this->model->saveToJson($testData);

        expect($result)->toBeTrue();
        /** @phpstan-ignore-next-line property.notFound */
        expect($this->testJsonPath)->toBeFile();

        /** @phpstan-ignore-next-line property.notFound */
        $savedData = json_decode(File::get($this->testJsonPath), true);
        expect($savedData)->toBe($testData);
    });

    it('creates directory if not exists', function (): void {
        // Rimuovi directory di test
        /** @phpstan-ignore-next-line property.notFound */
        if (File::exists($this->testDirectory)) {
            /** @phpstan-ignore-next-line property.notFound */
            File::deleteDirectory($this->testDirectory);
        }

        /** @phpstan-ignore-next-line property.notFound */
        $testData = ($this->createTestData)();

        /** @phpstan-ignore-next-line property.notFound */
        $result = $this->model->saveToJson($testData);

        expect($result)->toBeTrue();
        /** @phpstan-ignore-next-line property.notFound */
        expect($this->testDirectory)->toBeDirectory();
        /** @phpstan-ignore-next-line property.notFound */
        expect($this->testJsonPath)->toBeFile();
    });

    it('handles save errors gracefully', function (): void {
        // Mock File facade per simulare errore di scrittura
        File::shouldReceive('put')->once()->andReturn(false);

        /** @phpstan-ignore-next-line property.notFound */
        $testData = ($this->createTestData)();

        /** @phpstan-ignore-next-line property.notFound */
        $result = $this->model->saveToJson($testData);

        expect($result)->toBeFalse();
    });

    it('handles creating event correctly', function (): void {
        // Mock Auth per simulare utente autenticato
        Auth::shouldReceive('id')->andReturn(1);

        $testData = [
            'name' => 'New Item',
            'description' => 'New Description',
        ];

        $model = new TestSushiModel;
        /** @phpstan-ignore-next-line method.nonObject */
        $model->fill($testData);

        // Test che il modello può essere creato con i dati
        expect($model->name)->toBe('New Item')->and($model->description)->toBe('New Description');

        // Test che i metodi del trait funzionano
        expect($model->getJsonFile())->toBeString()->toEndWith('test_sushi.json');
    });

    it('handles updating event correctly', function (): void {
        // Mock Auth per simulare utente autenticato
        Auth::shouldReceive('id')->andReturn(1);

        /** @phpstan-ignore-next-line property.notFound */
        $testData = ($this->createTestData)();
        /** @phpstan-ignore-next-line property.notFound */
        File::put($this->testJsonPath, json_encode($testData, JSON_PRETTY_PRINT));

        $model = new TestSushiModel;
        $model->id = 1;
        /** @phpstan-ignore-next-line method.nonObject */
        $model->fill(['name' => 'Updated Name']);

        // Test che il modello può essere aggiornato
        expect($model->name)->toBe('Updated Name')->and($model->id)->toBe(1);

        // Test che i dati esistenti possono essere caricati
        /** @phpstan-ignore-next-line method.nonObject */
        $existingData = $model->loadExistingData();
        /** @phpstan-ignore-next-line offsetAccess.nonOffsetAccessible */
        expect($existingData)->toHaveKey('1')->and($existingData['1']['name'])->toBe('Test Item 1');
    });

    it('handles deleting event correctly', function (): void {
        /** @phpstan-ignore-next-line property.notFound */
        $testData = ($this->createTestData)();
        /** @phpstan-ignore-next-line property.notFound */
        File::put($this->testJsonPath, json_encode($testData, JSON_PRETTY_PRINT));

        $model = new TestSushiModel;
        $model->id = 1;

        // Test che il modello può essere configurato per la cancellazione
        expect($model->id)->toBe(1);

        // Test che i dati esistenti possono essere caricati
        /** @phpstan-ignore-next-line method.nonObject */
        $existingData = $model->loadExistingData();
        expect($existingData)->toHaveKey('1')->toHaveKey('2');

        // Test che il metodo saveToJson funziona
        /** @phpstan-ignore-next-line method.nonObject */
        $result = $model->saveToJson($existingData);
        expect($result)->toBeTrue();
    });

    it('integrates with tenant service correctly', function (): void {
        $tenantService = app(TenantService::class);

        expect($tenantService)->toBeInstanceOf(TenantService::class);

        // Verifica che il mock funzioni correttamente
        /** @phpstan-ignore-next-line property.notFound */
        $path = $this->model->getJsonFile();
        /** @phpstan-ignore-next-line property.notFound */
        expect($path)->toBe($this->testJsonPath);
    });

    it('handles large datasets efficiently', function (): void {
        // Crea dataset grande (1000 record)
        $largeData = [];
        for ($i = 1; $i <= 1000; $i++) {
            /** @phpstan-ignore-next-line offsetAccess.nonOffsetAccessible */
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

        /** @phpstan-ignore-next-line property.notFound */
        $result = $this->model->saveToJson($largeData);

        $endTime = microtime(true);
        $executionTime = $endTime - $startTime;

        expect($result)->toBeTrue();
        expect($executionTime)->toBeLessThan(1.0);

        // Verifica caricamento
        $startTime = microtime(true);
        /** @phpstan-ignore-next-line property.notFound */
        $rows = $this->model->getSushiRows();
        $endTime = microtime(true);
        $loadTime = $endTime - $startTime;

        expect($rows)->toHaveCount(1000);
        expect($loadTime)->toBeLessThan(0.5);
    });

    it('logs errors appropriately', function (): void {
        // Mock Log facade per verificare logging
        /** @phpstan-ignore-next-line property.notFound */
        $this->mock('log', function ($mock): void {
            /** @phpstan-ignore-next-line method.nonObject */
            $mock->shouldReceive('error')->once()->with('Failed to save data to JSON file', Mockery::any());
        });

        // Simula errore di salvataggio
        File::shouldReceive('put')->once()->andReturn(false);

        /** @phpstan-ignore-next-line property.notFound */
        $testData = ($this->createTestData)();
        /** @phpstan-ignore-next-line property.notFound */
        $result = $this->model->saveToJson($testData);

        expect($result)->toBeFalse();
    });

    it('maintains data integrity during operations', function (): void {
        /** @phpstan-ignore-next-line property.notFound */
        $originalData = ($this->createTestData)();
        /** @phpstan-ignore-next-line property.notFound */
        File::put($this->testJsonPath, json_encode($originalData, JSON_PRETTY_PRINT));

        // Verifica che i dati originali siano preservati
        /** @phpstan-ignore-next-line property.notFound */
        $loadedData = $this->model->loadExistingData();
        expect($loadedData)->toBe($originalData);

        // Aggiorna un record
        $updatedData = $originalData;
        /** @phpstan-ignore-next-line offsetAccess.nonOffsetAccessible */
        $updatedData['1']['name'] = 'Updated Name';

        /** @phpstan-ignore-next-line property.notFound */
        $result = $this->model->saveToJson($updatedData);
        expect($result)->toBeTrue();

        // Verifica che solo il record specifico sia stato aggiornato
        /** @phpstan-ignore-next-line property.notFound */
        $finalData = $this->model->loadExistingData();
        /** @phpstan-ignore-next-line offsetAccess.nonOffsetAccessible */
        expect($finalData['1']['name'])->toBe('Updated Name')->and($finalData['2']['name'])->toBe('Test Item 2'); // Non modificato
    });

    it('handles empty and null values correctly', function (): void {
        $testData = [
            '1' => [
                'id' => 1,
                'name' => '',
                'description' => null,
                'metadata' => [],
                'status' => false,
            ],
        ];

        /** @phpstan-ignore-next-line property.notFound */
        $result = $this->model->saveToJson($testData);
        expect($result)->toBeTrue();

        /** @phpstan-ignore-next-line property.notFound */
        $loadedData = $this->model->getSushiRows();
        /** @phpstan-ignore-next-line offsetAccess.nonOffsetAccessible */
        expect($loadedData['1']['name'])
            ->toBe('')
            /** @phpstan-ignore-next-line offsetAccess.nonOffsetAccessible */
            ->and($loadedData['1']['description'])
            ->toBeNull()
            /** @phpstan-ignore-next-line offsetAccess.nonOffsetAccessible */
            ->and($loadedData['1']['metadata'])
            ->toBe('[]') // Convertito in stringa JSON
            /** @phpstan-ignore-next-line offsetAccess.nonOffsetAccessible */
            ->and($loadedData['1']['status'])
            ->toBeFalse();
    });

    it('handles unicode and special characters', function (): void {
        $testData = [
            '1' => [
                'id' => 1,
                'name' => 'Café & Résumé 🚀',
                'description' => 'Test con caratteri speciali: é, è, ñ, 中文, 🎉',
                'tags' => ['tag-é', 'tag-è', 'tag-ñ'],
            ],
        ];

        /** @phpstan-ignore-next-line property.notFound */
        $result = $this->model->saveToJson($testData);
        expect($result)->toBeTrue();

        /** @phpstan-ignore-next-line property.notFound */
        $loadedData = $this->model->getSushiRows();
        /** @phpstan-ignore-next-line offsetAccess.nonOffsetAccessible */
        expect($loadedData['1']['name'])
            ->toBe('Café & Résumé 🚀')
            /** @phpstan-ignore-next-line offsetAccess.nonOffsetAccessible */
            ->and($loadedData['1']['description'])
            ->toBe('Test con caratteri speciali: é, è, ñ, 中文, 🎉')
            /** @phpstan-ignore-next-line offsetAccess.nonOffsetAccessible */
            ->and($loadedData['1']['tags'])
            ->toBe('["tag-é","tag-è","tag-ñ"]');
    });
});
