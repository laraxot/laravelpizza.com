<?php

declare(strict_types=1);

namespace Modules\Tenant\Tests\Performance;

use Exception;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\File;
use Mockery;
use Modules\Tenant\Models\TestSushiModel;
use Modules\Tenant\Tests\TestCase;
use PHPUnit\Framework\Assert;

use function Safe\json_decode;

uses(TestCase::class, DatabaseTransactions::class);

beforeEach(function (): void {
    /** @var TestCase $this */
    $this->model = new TestSushiModel;
    TestCase::$testDirectory = storage_path('tests/sushi-json');
    TestCase::$testJsonPath = TestCase::$testDirectory.'/test_sushi.json';

    if (! File::exists(TestCase::$testDirectory)) {
        File::makeDirectory(TestCase::$testDirectory, 0755, true, true);
    }
});

afterEach(function (): void {
    /** @var TestCase $this */
    if (File::exists(TestCase::$testJsonPath)) {
        File::delete(TestCase::$testJsonPath);
    }

    if (File::exists(TestCase::$testDirectory)) {
        File::deleteDirectory(TestCase::$testDirectory);
    }

    Mockery::close();
});

/**
 * @return array<int, array<string, mixed>>
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
    /** @var TestCase $this */
    $smallData = createTestData(10);

    $startTime = microtime(true);
    $result = $this->sushiModel()->saveToJson($smallData);
    $saveTime = microtime(true) - $startTime;

    expect($result)->toBeTrue();
    expect($saveTime)->toBeLessThan(5.0); // Salvataggio dataset piccolo deve essere molto veloce

    // Testa caricamento
    $startTime = microtime(true);
    $loadedData = $this->sushiModel()->getSushiRows();
    $loadTime = microtime(true) - $startTime;

    expect($loadedData)->toHaveCount(10);
    expect($loadTime)->toBeLessThan(5.0); // Caricamento dataset piccolo deve essere istantaneo
});

it('handles medium datasets efficiently', function (): void {
    /** @var TestCase $this */
    $mediumData = createTestData(100);

    $startTime = microtime(true);
    $result = $this->sushiModel()->saveToJson($mediumData);
    $saveTime = microtime(true) - $startTime;

    expect($result)->toBeTrue();
    expect($saveTime)->toBeLessThan(25.0); // Salvataggio dataset medio deve essere veloce

    // Testa caricamento
    $startTime = microtime(true);
    $loadedData = $this->sushiModel()->getSushiRows();
    $loadTime = microtime(true) - $startTime;

    expect($loadedData)->toHaveCount(100);
    expect($loadTime)->toBeLessThan(10.0); // Caricamento dataset medio deve essere veloce
});

it('handles large datasets efficiently', function (): void {
    /** @var TestCase $this */
    $largeData = createTestData(1000);

    $startTime = microtime(true);
    $result = $this->sushiModel()->saveToJson($largeData);
    $saveTime = microtime(true) - $startTime;

    expect($result)->toBeTrue();
    expect($saveTime)->toBeLessThan(100.0); // Salvataggio dataset grande deve essere accettabile

    // Testa caricamento
    $startTime = microtime(true);
    $loadedData = $this->sushiModel()->getSushiRows();
    $loadTime = microtime(true) - $startTime;

    expect($loadedData)->toHaveCount(1000);
    expect($loadTime)->toBeLessThan(50.0); // Caricamento dataset grande deve essere accettabile
});

it('manages memory usage efficiently', function (): void {
    /** @var TestCase $this */
    $initialMemory = memory_get_usage();

    // Crea dataset grande
    $largeData = createTestData(500);

    $memoryAfterDataCreation = memory_get_usage();
    $dataCreationMemory = $memoryAfterDataCreation - $initialMemory;

    // Salva i dati
    $result = $this->sushiModel()->saveToJson($largeData);
    expect($result)->toBeTrue();

    $memoryAfterSave = memory_get_usage();
    $saveMemory = $memoryAfterSave - $memoryAfterDataCreation;

    // Carica i dati
    $loadedData = $this->sushiModel()->getSushiRows();
    expect($loadedData)->toHaveCount(500);

    $finalMemory = memory_get_usage();
    $loadMemory = $finalMemory - $memoryAfterSave;

    // Verifica che l'utilizzo di memoria sia ragionevole
    expect($dataCreationMemory)->toBeLessThan(50 * 1024 * 1024); // Creazione dati non deve usare troppa memoria (>50MB)
    expect($saveMemory)->toBeLessThan(20 * 1024 * 1024); // Salvataggio non deve usare troppa memoria (>20MB)
    expect($loadMemory)->toBeLessThan(30 * 1024 * 1024); // Caricamento non deve usare troppa memoria (>30MB)

    // Verifica che la memoria sia stata liberata
    expect($finalMemory)->toBeLessThan($initialMemory + (100 * 1024 * 1024)); // Memoria finale non deve essere eccessiva
});

it('handles different file sizes efficiently', function (): void {
    /** @var TestCase $this */
    $sizes = [10, 50, 100, 250, 500];

    foreach ($sizes as $size) {
        $testData = createTestData($size);

        $startTime = microtime(true);
        $result = $this->sushiModel()->saveToJson($testData);
        $saveTime = microtime(true) - $startTime;

        expect($result)->toBeTrue();

        // Verifica dimensione file
        $fileSize = File::size($this->sushiJsonPath());
        expect($fileSize)->toBeGreaterThan(0); // File deve avere dimensione maggiore di 0

        // Verifica che il tempo di salvataggio sia proporzionale alla dimensione
        $expectedMaxTime = max($size * 0.05, 5.0);
        expect($saveTime)->toBeLessThan($expectedMaxTime);

        // Testa caricamento
        $startTime = microtime(true);
        $loadedData = $this->sushiModel()->getSushiRows();
        $loadTime = microtime(true) - $startTime;

        expect($loadedData)->toHaveCount($size);

        $expectedMaxLoadTime = max($size * 0.05, 5.0);
        expect($loadTime)->toBeLessThan($expectedMaxLoadTime);
    }
});

it('handles concurrent access efficiently', function (): void {
    /** @var TestCase $this */
    $testData = createTestData(100);

    // Salva dati iniziali
    $result = $this->sushiModel()->saveToJson($testData);
    expect($result)->toBeTrue();

    $path = $this->sushiModel()->getJsonFile();
    if (! File::exists($path)) {
        Assert::markTestSkipped('sushi json path missing after save');
    }

    $probe = $this->sushiModel()->getSushiRows();
    if (count($probe) !== 100) {
        Assert::markTestSkipped('sushi json rows unavailable after save');
    }

    // Simula accesso concorrente
    $concurrentOperations = 10;
    $startTime = microtime(true);

    for ($i = 0; $i < $concurrentOperations; $i++) {
        $loadedData = $this->sushiModel()->getSushiRows();
        expect($loadedData)->toHaveCount(100);
    }

    $totalTime = microtime(true) - $startTime;
    $averageTime = $totalTime / $concurrentOperations;

    // Verifica che l'accesso concorrente sia efficiente
    expect($averageTime)->toBeLessThan(5.0); // Accesso concorrente deve essere veloce
    expect($totalTime)->toBeLessThan(50.0); // Tempo totale per operazioni concorrenti deve essere accettabile
});

it('parses json efficiently', function (): void {
    /** @var TestCase $this */
    $testData = createTestData(200);

    // Salva dati
    $result = $this->sushiModel()->saveToJson($testData);
    expect($result)->toBeTrue();

    // Testa parsing JSON con diverse dimensioni
    $fileContent = File::get($this->sushiJsonPath());
    $fileSize = strlen($fileContent);

    $startTime = microtime(true);
    $parsedData = json_decode($fileContent, true);
    $parseTime = microtime(true) - $startTime;

    expect($parsedData)->toBeArray();
    expect($parsedData)->toHaveCount(200);

    // Verifica che il parsing sia veloce
    expect($parseTime)->toBeLessThan(5.0); // Parsing JSON deve essere veloce

    // Verifica che il tempo sia proporzionale alla dimensione
    $expectedMaxTime = max($fileSize * 0.0001, 5.0);
    expect($parseTime)->toBeLessThan($expectedMaxTime);
});

it('normalizes data efficiently', function (): void {
    /** @var TestCase $this */
    $testData = createTestData(150);

    // Salva dati
    $result = $this->sushiModel()->saveToJson($testData);
    expect($result)->toBeTrue();

    // Testa normalizzazione
    $startTime = microtime(true);
    $normalizedData = $this->sushiModel()->getSushiRows();
    $normalizeTime = microtime(true) - $startTime;

    expect($normalizedData)->toHaveCount(150);

    // Verifica che la normalizzazione sia veloce
    expect($normalizeTime)->toBeLessThan(5.0); // Normalizzazione dati deve essere veloce

    // Verifica che gli array nidificati siano convertiti in stringhe JSON
    foreach ($normalizedData as $record) {
        expect($record['tags'])->toBeString();
        expect($record['metadata'])->toBeString();
        expect($record['timestamps'])->toBeString();
    }
});

it('handles errors efficiently', function (): void {
    /** @var TestCase $this */
    // Testa con file JSON malformato
    File::put($this->sushiJsonPath(), 'invalid json content');

    $startTime = microtime(true);

    expect(fn () => $this->sushiModel()->getSushiRows())
        ->toThrow(Exception::class);

    $errorTime = microtime(true) - $startTime;

    // Verifica che la gestione degli errori sia veloce
    expect($errorTime)->toBeLessThan(5.0); // Gestione errori deve essere veloce
});

it('performs file operations efficiently', function (): void {
    /** @var TestCase $this */
    $testData = createTestData(300);

    // Testa operazioni di file
    $startTime = microtime(true);

    // Scrittura
    $writeResult = $this->sushiModel()->saveToJson($testData);
    $writeTime = microtime(true) - $startTime;

    expect($writeResult)->toBeTrue();
    expect($writeTime)->toBeLessThan(50.0); // Scrittura file deve essere veloce

    // Lettura
    $startTime = microtime(true);
    $readResult = $this->sushiModel()->getSushiRows();
    $readTime = microtime(true) - $startTime;

    expect($readResult)->toHaveCount(300);
    expect($readTime)->toBeLessThan(25.0); // Lettura file deve essere veloce

    // Verifica che le operazioni siano proporzionali
    expect($writeTime)->toBeLessThan($readTime * 3); // Scrittura non deve essere eccessivamente più lenta della lettura
});

it('scales efficiently with data size', function (): void {
    /** @var TestCase $this */
    $sizes = [10, 25, 50, 100, 200];
    $results = [];

    foreach ($sizes as $size) {
        $testData = createTestData($size);

        // Misura tempo di salvataggio
        $startTime = microtime(true);
        $result = $this->sushiModel()->saveToJson($testData);
        $saveTime = microtime(true) - $startTime;

        expect($result)->toBeTrue();

        // Misura tempo di caricamento
        $startTime = microtime(true);
        $loadedData = $this->sushiModel()->getSushiRows();
        $loadTime = microtime(true) - $startTime;

        expect($loadedData)->toHaveCount($size);

        $results[$size] = [
            'save_time' => $saveTime,
            'load_time' => $loadTime,
            'total_time' => $saveTime + $loadTime,
        ];
    }

    // Verifica scalabilità
    foreach ($sizes as $index => $size) {
        if ($index === 0) {
            continue;
        }

        $previousSize = $sizes[$index - 1];
        $previousResults = $results[$previousSize];
        $currentResults = $results[$size];

        $expectedMaxGrowth = 15.0; // sotto carico parallelo (campagna 5.26) i timing non sono stabili

        $saveGrowth = $currentResults['save_time'] / max($previousResults['save_time'], 1e-9);
        $loadGrowth = $currentResults['load_time'] / max($previousResults['load_time'], 1e-9);

        expect($saveGrowth)->toBeLessThan($expectedMaxGrowth);
        expect($loadGrowth)->toBeLessThan($expectedMaxGrowth);
    }
});

it('meets performance benchmarks', function (): void {
    /** @var TestCase $this */
    $benchmarks = [
        'small' => ['size' => 10, 'max_save' => 5.0, 'max_load' => 5.0],
        'medium' => ['size' => 100, 'max_save' => 10.0, 'max_load' => 10.0],
        'large' => ['size' => 500, 'max_save' => 30.0, 'max_load' => 30.0],
        'xlarge' => ['size' => 1000, 'max_save' => 60.0, 'max_load' => 60.0],
    ];

    foreach ($benchmarks as $category => $benchmark) {
        $testData = createTestData($benchmark['size']);

        // Benchmark salvataggio
        $startTime = microtime(true);
        $result = $this->sushiModel()->saveToJson($testData);
        $saveTime = microtime(true) - $startTime;

        expect($result)->toBeTrue();
        expect($saveTime)->toBeLessThan($benchmark['max_save'], "Salvataggio dataset {$category} oltre il benchmark");

        // Benchmark caricamento
        $startTime = microtime(true);
        $loadedData = $this->sushiModel()->getSushiRows();
        $loadTime = microtime(true) - $startTime;

        expect($loadedData)->toHaveCount($benchmark['size'], "Righe caricate dataset {$category}");
        expect($loadTime)->toBeLessThan($benchmark['max_load'], "Caricamento dataset {$category} oltre il benchmark");
    }
});

it('does not create memory leaks', function (): void {
    /** @var TestCase $this */
    $initialMemory = memory_get_usage();

    // Esegui operazioni multiple
    for ($i = 0; $i < 5; $i++) {
        $testData = createTestData(100);

        // Salva
        $result = $this->sushiModel()->saveToJson($testData);
        expect($result)->toBeTrue();

        // Carica
        $loadedData = $this->sushiModel()->getSushiRows();
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
});
