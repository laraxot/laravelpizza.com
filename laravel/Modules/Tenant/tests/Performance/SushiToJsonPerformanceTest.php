<?php

declare(strict_types=1);

use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\File;
use Modules\Tenant\Models\TestSushiModel;
use Modules\Tenant\Services\TenantService;

uses(Tests\TestCase::class, DatabaseTransactions::class)->beforeEach(function () {
    // Configura il modello di test
    $this->model = new TestSushiModel;

    // Configura percorsi di test
    $this->testDirectory = storage_path('tests/sushi-json-performance');
    $this->testJsonPath = $this->testDirectory.'/test_sushi.json';

    // Crea directory di test
    if (! File::exists($this->testDirectory)) {
        File::makeDirectory($this->testDirectory, 0755, true, true);
    }

    // Mock TenantService per i test
    $this->mock(TenantService::class, function ($mock): void {
        $mock->shouldReceive('filePath')->with('database/content/test_sushi.json')->andReturn($this->testJsonPath);
    });
})->afterEach(function () {
    // Cleanup file di test
    if (File::exists($this->testJsonPath)) {
        File::delete($this->testJsonPath);
    }

    if (File::exists($this->testDirectory)) {
        File::deleteDirectory($this->testDirectory);
    }
});

/**
 * Crea dati di test con dimensioni specifiche.
 */
function createTestData(int $recordCount): array
{
    $data = [];
    for ($i = 1; $i <= $recordCount; $i++) {
        $data[$i] = [
            'id' => $i,
            'name' => "Test Item {$i}",
            'description' => "This is a detailed description for test item {$i} with additional information to increase the size of the data",
            'status' => 0 === ($i % 2) ? 'active' : 'inactive',
            'category' => 'Category '.(($i % 10) + 1),
            'priority' => ($i % 5) + 1,
            'tags' => ["tag{$i}", "priority{$i}", "category{$i}"],
            'metadata' => [
                'created_by' => 'test_user',
                'department' => 'testing',
                'location' => 'test_environment',
                'notes' => "Additional notes for item {$i} to increase data size",
                'settings' => [
                    'notifications' => true,
                    'auto_save' => false,
                    'backup_frequency' => 'daily',
                ],
            ],
            'timestamps' => [
                'created_at' => now()->subDays($i)->toISOString(),
                'updated_at' => now()->subHours($i)->toISOString(),
            ],
        ];
    }

    return $data;
}

it('handles small datasets efficiently', function (): void {
    $smallData = createTestData(10);

    $startTime = microtime(true);
    $result = $this->model->saveToJson($smallData);
    $saveTime = microtime(true) - $startTime;

    expect($result)->toBeTrue();
    expect($saveTime)->toBeLessThan(0.1); // Salvataggio dataset piccolo deve essere molto veloce

    // Testa caricamento
    $startTime = microtime(true);
    $loadedData = $this->model->getSushiRows();
    $loadTime = microtime(true) - $startTime;

    expect($loadedData)->toHaveCount(10);
    expect($loadTime)->toBeLessThan(0.05); // Caricamento dataset piccolo deve essere istantaneo
})->group('small-dataset');

it('handles medium datasets efficiently', function (): void {
    $mediumData = createTestData(100);

    $startTime = microtime(true);
    $result = $this->model->saveToJson($mediumData);
    $saveTime = microtime(true) - $startTime;

    expect($result)->toBeTrue();
    expect($saveTime)->toBeLessThan(0.5); // Salvataggio dataset medio deve essere veloce

    // Testa caricamento
    $startTime = microtime(true);
    $loadedData = $this->model->getSushiRows();
    $loadTime = microtime(true) - $startTime;

    expect($loadedData)->toHaveCount(100);
    expect($loadTime)->toBeLessThan(0.2); // Caricamento dataset medio deve essere veloce
})->group('medium-dataset');

it('handles large datasets efficiently', function (): void {
    $largeData = createTestData(1000);

    $startTime = microtime(true);
    $result = $this->model->saveToJson($largeData);
    $saveTime = microtime(true) - $startTime;

    expect($result)->toBeTrue();
    expect($saveTime)->toBeLessThan(2.0); // Salvataggio dataset grande deve essere accettabile

    // Testa caricamento
    $startTime = microtime(true);
    $loadedData = $this->model->getSushiRows();
    $loadTime = microtime(true) - $startTime;

    expect($loadedData)->toHaveCount(1000);
    expect($loadTime)->toBeLessThan(1.0); // Caricamento dataset grande deve essere accettabile
})->group('large-dataset');

it('manages memory usage efficiently', function (): void {
    $initialMemory = memory_get_usage();

    // Crea dataset grande
    $largeData = createTestData(500);

    $memoryAfterDataCreation = memory_get_usage();
    $dataCreationMemory = $memoryAfterDataCreation - $initialMemory;

    // Salva i dati
    $result = $this->model->saveToJson($largeData);
    expect($result)->toBeTrue();

    $memoryAfterSave = memory_get_usage();
    $saveMemory = $memoryAfterSave - $memoryAfterDataCreation;

    // Carica i dati
    $loadedData = $this->model->getSushiRows();
    expect($loadedData)->toHaveCount(500);

    $finalMemory = memory_get_usage();
    $loadMemory = $finalMemory - $memoryAfterSave;

    // Verifica che l'utilizzo di memoria sia ragionevole
    expect($dataCreationMemory)->toBeLessThan(50 * 1024 * 1024); // Creazione dati non deve usare troppa memoria (>50MB)
    expect($saveMemory)->toBeLessThan(20 * 1024 * 1024); // Salvataggio non deve usare troppa memoria (>20MB)
    expect($loadMemory)->toBeLessThan(30 * 1024 * 1024); // Caricamento non deve usare troppa memoria (>30MB)

    // Verifica che la memoria sia stata liberata
    expect($finalMemory)->toBeLessThan($initialMemory + (100 * 1024 * 1024)); // Memoria finale non deve essere eccessiva
})->group('memory-usage');

it('handles different file sizes efficiently', function (): void {
    $sizes = [10, 50, 100, 250, 500];

    foreach ($sizes as $size) {
        $testData = createTestData($size);

        $startTime = microtime(true);
        $result = $this->model->saveToJson($testData);
        $saveTime = microtime(true) - $startTime;

        expect($result)->toBeTrue();

        // Verifica dimensione file
        $fileSize = File::size($this->testJsonPath);
        expect($fileSize)->toBeGreaterThan(0); // File deve avere dimensione maggiore di 0

        // Verifica che il tempo di salvataggio sia proporzionale alla dimensione
        $expectedMaxTime = $size * 0.001; // 1ms per record
        expect($saveTime)->toBeLessThan($expectedMaxTime); // Salvataggio $size record deve essere veloce

        // Testa caricamento
        $startTime = microtime(true);
        $loadedData = $this->model->getSushiRows();
        $loadTime = microtime(true) - $startTime;

        expect($loadedData)->toHaveCount($size);

        // Verifica che il tempo di caricamento sia proporzionale alla dimensione
        $expectedMaxLoadTime = $size * 0.0005; // 0.5ms per record
        expect($loadTime)->toBeLessThan($expectedMaxLoadTime); // Caricamento $size record deve essere veloce
    }
})->group('file-size');

it('handles concurrent access efficiently', function (): void {
    $testData = createTestData(100);

    // Salva dati iniziali
    $result = $this->model->saveToJson($testData);
    expect($result)->toBeTrue();

    // Simula accesso concorrente
    $concurrentOperations = 10;
    $startTime = microtime(true);

    for ($i = 0; $i < $concurrentOperations; $i++) {
        $loadedData = $this->model->getSushiRows();
        expect($loadedData)->toHaveCount(100);
    }

    $totalTime = microtime(true) - $startTime;
    $averageTime = $totalTime / $concurrentOperations;

    // Verifica che l'accesso concorrente sia efficiente
    expect($averageTime)->toBeLessThan(0.1); // Accesso concorrente deve essere veloce
    expect($totalTime)->toBeLessThan(1.0); // Tempo totale per operazioni concorrenti deve essere accettabile
})->group('concurrent-access');

it('parses json efficiently', function (): void {
    $testData = createTestData(200);

    // Salva dati
    $result = $this->model->saveToJson($testData);
    expect($result)->toBeTrue();

    // Testa parsing JSON con diverse dimensioni
    $fileContent = File::get($this->testJsonPath);
    $fileSize = strlen($fileContent);

    $startTime = microtime(true);
    $parsedData = json_decode($fileContent, true);
    $parseTime = microtime(true) - $startTime;

    expect($parsedData)->toBeArray();
    expect($parsedData)->toHaveCount(200);

    // Verifica che il parsing sia veloce
    expect($parseTime)->toBeLessThan(0.1); // Parsing JSON deve essere veloce

    // Verifica che il tempo sia proporzionale alla dimensione
    $expectedMaxTime = $fileSize * 0.000001; // 1 microsecondo per byte
    expect($parseTime)->toBeLessThan($expectedMaxTime); // Parsing deve essere proporzionale alla dimensione
})->group('json-parsing');

it('normalizes data efficiently', function (): void {
    $testData = createTestData(150);

    // Salva dati
    $result = $this->model->saveToJson($testData);
    expect($result)->toBeTrue();

    // Testa normalizzazione
    $startTime = microtime(true);
    $normalizedData = $this->model->getSushiRows();
    $normalizeTime = microtime(true) - $startTime;

    expect($normalizedData)->toHaveCount(150);

    // Verifica che la normalizzazione sia veloce
    expect($normalizeTime)->toBeLessThan(0.1); // Normalizzazione dati deve essere veloce

    // Verifica che gli array nidificati siano convertiti in stringhe JSON
    foreach ($normalizedData as $record) {
        expect($record['tags'])->toBeString();
        expect($record['metadata'])->toBeString();
        expect($record['timestamps'])->toBeString();
    }
})->group('data-normalization');

it('handles errors efficiently', function (): void {
    // Testa con file JSON malformato
    File::put($this->testJsonPath, 'invalid json content');

    $startTime = microtime(true);

    expect(fn () => $this->model->getSushiRows())
        ->toThrow(Exception::class, 'Data is not array ['.$this->testJsonPath.']');

    $errorTime = microtime(true) - $startTime;

    // Verifica che la gestione degli errori sia veloce
    expect($errorTime)->toBeLessThan(0.1); // Gestione errori deve essere veloce
})->group('error-handling');

it('performs file operations efficiently', function (): void {
    $testData = createTestData(300);

    // Testa operazioni di file
    $startTime = microtime(true);

    // Scrittura
    $writeResult = $this->model->saveToJson($testData);
    $writeTime = microtime(true) - $startTime;

    expect($writeResult)->toBeTrue();
    expect($writeTime)->toBeLessThan(1.0); // Scrittura file deve essere veloce

    // Lettura
    $startTime = microtime(true);
    $readResult = $this->model->getSushiRows();
    $readTime = microtime(true) - $startTime;

    expect($readResult)->toHaveCount(300);
    expect($readTime)->toBeLessThan(0.5); // Lettura file deve essere veloce

    // Verifica che le operazioni siano proporzionali
    expect($writeTime)->toBeLessThan($readTime * 3); // Scrittura non deve essere eccessivamente più lenta della lettura
})->group('file-operations');

it('scales efficiently with data size', function (): void {
    $sizes = [10, 25, 50, 100, 200];
    $results = [];

    foreach ($sizes as $size) {
        $testData = createTestData($size);

        // Misura tempo di salvataggio
        $startTime = microtime(true);
        $result = $this->model->saveToJson($testData);
        $saveTime = microtime(true) - $startTime;

        expect($result)->toBeTrue();

        // Misura tempo di caricamento
        $startTime = microtime(true);
        $loadedData = $this->model->getSushiRows();
        $loadTime = microtime(true) - $startTime;

        expect($loadedData)->toHaveCount($size);

        $results[$size] = [
            'save_time' => $saveTime,
            'load_time' => $loadTime,
            'total_time' => $saveTime + $loadTime,
        ];
    }

    // Verifica scalabilità
    foreach ($sizes as $size) {
        if ($size > 10) {
            $previousSize = $sizes[array_search($size, $sizes, strict: true) - 1];
            $previousResults = $results[$previousSize];
            $currentResults = $results[$size];

            // Il tempo dovrebbe crescere linearmente o sub-linearmente
            $expectedMaxGrowth = 2.5; // Massimo 2.5x per raddoppio della dimensione

            $saveGrowth = $currentResults['save_time'] / $previousResults['save_time'];
            $loadGrowth = $currentResults['load_time'] / $previousResults['load_time'];

            expect($saveGrowth)->toBeLessThan($expectedMaxGrowth); // Salvataggio deve scalare linearmente per $size record
            expect($loadGrowth)->toBeLessThan($expectedMaxGrowth); // Caricamento deve scalare linearmente per $size record
        }
    }
})->group('scalability');

it('meets performance benchmarks', function (): void {
    $benchmarks = [
        'small' => ['size' => 10, 'max_save' => 0.05, 'max_load' => 0.02],
        'medium' => ['size' => 100, 'max_save' => 0.2, 'max_load' => 0.1],
        'large' => ['size' => 500, 'max_save' => 1.0, 'max_load' => 0.5],
        'xlarge' => ['size' => 1000, 'max_save' => 2.0, 'max_load' => 1.0],
    ];

    foreach ($benchmarks as $category => $benchmark) {
        $testData = createTestData($benchmark['size']);

        // Benchmark salvataggio
        $startTime = microtime(true);
        $result = $this->model->saveToJson($testData);
        $saveTime = microtime(true) - $startTime;

        expect($result)->toBeTrue();
        expect($saveTime)->toBeLessThan($benchmark['max_save']); // Salvataggio $category dataset deve rispettare il benchmark

        // Benchmark caricamento
        $startTime = microtime(true);
        $loadedData = $this->model->getSushiRows();
        $loadTime = microtime(true) - $startTime;

        expect($loadedData)->toHaveCount($benchmark['size']);
        expect($loadTime)->toBeLessThan($benchmark['max_load']); // Caricamento $category dataset deve rispettare il benchmark
    }
})->group('benchmark');

it('does not create memory leaks', function (): void {
    $initialMemory = memory_get_usage();

    // Esegui operazioni multiple
    for ($i = 0; $i < 5; $i++) {
        $testData = createTestData(100);

        // Salva
        $result = $this->model->saveToJson($testData);
        expect($result)->toBeTrue();

        // Carica
        $loadedData = $this->model->getSushiRows();
        expect($loadedData)->toHaveCount(100);

        // Forza garbage collection
        if (function_exists('gc_collect_cycles')) {
            gc_collect_cycles();
        }
    }

    $finalMemory = memory_get_usage();
    $memoryIncrease = $finalMemory - $initialMemory;

    // Verifica che non ci siano memory leaks significativi
    expect($memoryIncrease)->toBeLessThan(10 * 1024 * 1024); // Non devono esserci memory leaks significativi (>10MB)
})->group('memory-leaks');
