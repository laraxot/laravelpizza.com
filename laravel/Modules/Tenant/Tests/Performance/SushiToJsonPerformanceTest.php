<?php

declare(strict_types=1);

namespace Modules\Tenant\Tests\Performance;

use Exception;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\File;
use Modules\Tenant\Models\TestSushiModel;
use Modules\Tenant\Services\TenantService;
use PHPUnit\Framework\Attributes\Group;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

/**
 * Test di performance per il trait SushiToJson.
 *
 * Testa le prestazioni del trait con file JSON di diverse dimensioni
 * e verifica che i tempi di esecuzione rimangano accettabili.
 */
#[Group('performance')]
#[Group('sushi-json')]
class SushiToJsonPerformanceTest extends TestCase
{
    use RefreshDatabase;

    private TestSushiModel $model;

    private string $testJsonPath;

    private string $testDirectory;

    protected function setUp(): void
    {
        parent::setUp();

        // Configura il modello di test
        $this->model = new TestSushiModel;

        // Configura percorsi di test
        $this->testDirectory = storage_path('tests/sushi-json-performance');
        $this->testJsonPath = $this->testDirectory.'/test_sushi.json';

        // Crea directory di test
        if (! File::exists($this->testDirectory)) {
            File::makeDirectory($this->testDirectory, 0o755, true, true);
        }

        // Mock TenantService per i test
        $this->mockTenantService();
    }

    protected function tearDown(): void
    {
        // Cleanup file di test
        if (File::exists($this->testJsonPath)) {
            File::delete($this->testJsonPath);
        }

        if (File::exists($this->testDirectory)) {
            File::deleteDirectory($this->testDirectory);
        }

        parent::tearDown();
    }

    /**
     * Mock del TenantService per i test.
     */
    private function mockTenantService(): void
    {
        $this->mock(TenantService::class, function ($mock) {
            $mock->shouldReceive('filePath')->with('database/content/test_sushi.json')->andReturn($this->testJsonPath);
        });
    }

    /**
     * Crea dati di test con dimensioni specifiche.
     */
    private function createTestData(int $recordCount): array
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

    #[Test]
    #[Group('small-dataset')]
    public function it_handles_small_datasets_efficiently(): void
    {
        $smallData = $this->createTestData(10);

        $startTime = microtime(true);
        $result = $this->model->saveToJson($smallData);
        $saveTime = microtime(true) - $startTime;

        $this->assertTrue($result);
        $this->assertLessThan(0.1, $saveTime, 'Salvataggio dataset piccolo deve essere molto veloce');

        // Testa caricamento
        $startTime = microtime(true);
        $loadedData = $this->model->getSushiRows();
        $loadTime = microtime(true) - $startTime;

        $this->assertCount(10, $loadedData);
        $this->assertLessThan(0.05, $loadTime, 'Caricamento dataset piccolo deve essere istantaneo');
    }

    #[Test]
    #[Group('medium-dataset')]
    public function it_handles_medium_datasets_efficiently(): void
    {
        $mediumData = $this->createTestData(100);

        $startTime = microtime(true);
        $result = $this->model->saveToJson($mediumData);
        $saveTime = microtime(true) - $startTime;

        $this->assertTrue($result);
        $this->assertLessThan(0.5, $saveTime, 'Salvataggio dataset medio deve essere veloce');

        // Testa caricamento
        $startTime = microtime(true);
        $loadedData = $this->model->getSushiRows();
        $loadTime = microtime(true) - $startTime;

        $this->assertCount(100, $loadedData);
        $this->assertLessThan(0.2, $loadTime, 'Caricamento dataset medio deve essere veloce');
    }

    #[Test]
    #[Group('large-dataset')]
    public function it_handles_large_datasets_efficiently(): void
    {
        $largeData = $this->createTestData(1000);

        $startTime = microtime(true);
        $result = $this->model->saveToJson($largeData);
        $saveTime = microtime(true) - $startTime;

        $this->assertTrue($result);
        $this->assertLessThan(2.0, $saveTime, 'Salvataggio dataset grande deve essere accettabile');

        // Testa caricamento
        $startTime = microtime(true);
        $loadedData = $this->model->getSushiRows();
        $loadTime = microtime(true) - $startTime;

        $this->assertCount(1000, $loadedData);
        $this->assertLessThan(1.0, $loadTime, 'Caricamento dataset grande deve essere accettabile');
    }

    #[Test]
    #[Group('memory-usage')]
    public function it_manages_memory_usage_efficiently(): void
    {
        $initialMemory = memory_get_usage();

        // Crea dataset grande
        $largeData = $this->createTestData(500);

        $memoryAfterDataCreation = memory_get_usage();
        $dataCreationMemory = $memoryAfterDataCreation - $initialMemory;

        // Salva i dati
        $result = $this->model->saveToJson($largeData);
        $this->assertTrue($result);

        $memoryAfterSave = memory_get_usage();
        $saveMemory = $memoryAfterSave - $memoryAfterDataCreation;

        // Carica i dati
        $loadedData = $this->model->getSushiRows();
        $this->assertCount(500, $loadedData);

        $finalMemory = memory_get_usage();
        $loadMemory = $finalMemory - $memoryAfterSave;

        // Verifica che l'utilizzo di memoria sia ragionevole
        $this->assertLessThan(
            50 * 1024 * 1024,
            $dataCreationMemory,
            'Creazione dati non deve usare troppa memoria (>50MB)',
        );
        $this->assertLessThan(20 * 1024 * 1024, $saveMemory, 'Salvataggio non deve usare troppa memoria (>20MB)');
        $this->assertLessThan(30 * 1024 * 1024, $loadMemory, 'Caricamento non deve usare troppa memoria (>30MB)');

        // Verifica che la memoria sia stata liberata
        $this->assertLessThan(
            $initialMemory + (100 * 1024 * 1024),
            $finalMemory,
            'Memoria finale non deve essere eccessiva',
        );
    }

    #[Test]
    #[Group('file-size')]
    public function it_handles_different_file_sizes_efficiently(): void
    {
        $sizes = [10, 50, 100, 250, 500];

        foreach ($sizes as $size) {
            $testData = $this->createTestData($size);

            $startTime = microtime(true);
            $result = $this->model->saveToJson($testData);
            $saveTime = microtime(true) - $startTime;

            $this->assertTrue($result);

            // Verifica dimensione file
            $fileSize = File::size($this->testJsonPath);
            $this->assertGreaterThan(0, $fileSize, 'File deve avere dimensione maggiore di 0');

            // Verifica che il tempo di salvataggio sia proporzionale alla dimensione
            $expectedMaxTime = $size * 0.001; // 1ms per record
            $this->assertLessThan($expectedMaxTime, $saveTime, "Salvataggio {$size} record deve essere veloce");

            // Testa caricamento
            $startTime = microtime(true);
            $loadedData = $this->model->getSushiRows();
            $loadTime = microtime(true) - $startTime;

            $this->assertCount($size, $loadedData);

            // Verifica che il tempo di caricamento sia proporzionale alla dimensione
            $expectedMaxLoadTime = $size * 0.0005; // 0.5ms per record
            $this->assertLessThan($expectedMaxLoadTime, $loadTime, "Caricamento {$size} record deve essere veloce");
        }
    }

    #[Test]
    #[Group('concurrent-access')]
    public function it_handles_concurrent_access_efficiently(): void
    {
        $testData = $this->createTestData(100);

        // Salva dati iniziali
        $result = $this->model->saveToJson($testData);
        $this->assertTrue($result);

        // Simula accesso concorrente
        $concurrentOperations = 10;
        $startTime = microtime(true);

        for ($i = 0; $i < $concurrentOperations; $i++) {
            $loadedData = $this->model->getSushiRows();
            $this->assertCount(100, $loadedData);
        }

        $totalTime = microtime(true) - $startTime;
        $averageTime = $totalTime / $concurrentOperations;

        // Verifica che l'accesso concorrente sia efficiente
        $this->assertLessThan(0.1, $averageTime, 'Accesso concorrente deve essere veloce');
        $this->assertLessThan(1.0, $totalTime, 'Tempo totale per operazioni concorrenti deve essere accettabile');
    }

    #[Test]
    #[Group('json-parsing')]
    public function it_parses_json_efficiently(): void
    {
        $testData = $this->createTestData(200);

        // Salva dati
        $result = $this->model->saveToJson($testData);
        $this->assertTrue($result);

        // Testa parsing JSON con diverse dimensioni
        $fileContent = File::get($this->testJsonPath);
        $fileSize = strlen($fileContent);

        $startTime = microtime(true);
        $parsedData = json_decode($fileContent, true);
        $parseTime = microtime(true) - $startTime;

        $this->assertIsArray($parsedData);
        $this->assertCount(200, $parsedData);

        // Verifica che il parsing sia veloce
        $this->assertLessThan(0.1, $parseTime, 'Parsing JSON deve essere veloce');

        // Verifica che il tempo sia proporzionale alla dimensione
        $expectedMaxTime = $fileSize * 0.000001; // 1 microsecondo per byte
        $this->assertLessThan($expectedMaxTime, $parseTime, 'Parsing deve essere proporzionale alla dimensione');
    }

    #[Test]
    #[Group('data-normalization')]
    public function it_normalizes_data_efficiently(): void
    {
        $testData = $this->createTestData(150);

        // Salva dati
        $result = $this->model->saveToJson($testData);
        $this->assertTrue($result);

        // Testa normalizzazione
        $startTime = microtime(true);
        $normalizedData = $this->model->getSushiRows();
        $normalizeTime = microtime(true) - $startTime;

        $this->assertCount(150, $normalizedData);

        // Verifica che la normalizzazione sia veloce
        $this->assertLessThan(0.1, $normalizeTime, 'Normalizzazione dati deve essere veloce');

        // Verifica che gli array nidificati siano convertiti in stringhe JSON
        foreach ($normalizedData as $record) {
            $this->assertIsString($record['tags']);
            $this->assertIsString($record['metadata']);
            $this->assertIsString($record['timestamps']);
        }
    }

    #[Test]
    #[Group('error-handling')]
    public function it_handles_errors_efficiently(): void
    {
        // Testa con file JSON malformato
        File::put($this->testJsonPath, 'invalid json content');

        $startTime = microtime(true);

        $this->expectException(Exception::class);
        $this->expectExceptionMessage('Data is not array');

        $this->model->getSushiRows();

        $errorTime = microtime(true) - $startTime;

        // Verifica che la gestione degli errori sia veloce
        $this->assertLessThan(0.1, $errorTime, 'Gestione errori deve essere veloce');
    }

    #[Test]
    #[Group('file-operations')]
    public function it_performs_file_operations_efficiently(): void
    {
        $testData = $this->createTestData(300);

        // Testa operazioni di file
        $startTime = microtime(true);

        // Scrittura
        $writeResult = $this->model->saveToJson($testData);
        $writeTime = microtime(true) - $startTime;

        $this->assertTrue($writeResult);
        $this->assertLessThan(1.0, $writeTime, 'Scrittura file deve essere veloce');

        // Lettura
        $startTime = microtime(true);
        $readResult = $this->model->getSushiRows();
        $readTime = microtime(true) - $startTime;

        $this->assertCount(300, $readResult);
        $this->assertLessThan(0.5, $readTime, 'Lettura file deve essere veloce');

        // Verifica che le operazioni siano proporzionali
        $this->assertLessThan(
            $readTime * 3,
            $writeTime,
            'Scrittura non deve essere eccessivamente più lenta della lettura',
        );
    }

    #[Test]
    #[Group('scalability')]
    public function it_scales_efficiently_with_data_size(): void
    {
        $sizes = [10, 25, 50, 100, 200];
        $results = [];

        foreach ($sizes as $size) {
            $testData = $this->createTestData($size);

            // Misura tempo di salvataggio
            $startTime = microtime(true);
            $result = $this->model->saveToJson($testData);
            $saveTime = microtime(true) - $startTime;

            $this->assertTrue($result);

            // Misura tempo di caricamento
            $startTime = microtime(true);
            $loadedData = $this->model->getSushiRows();
            $loadTime = microtime(true) - $startTime;

            $this->assertCount($size, $loadedData);

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

                $this->assertLessThan(
                    $expectedMaxGrowth,
                    $saveGrowth,
                    "Salvataggio deve scalare linearmente per {$size} record",
                );
                $this->assertLessThan(
                    $expectedMaxGrowth,
                    $loadGrowth,
                    "Caricamento deve scalare linearmente per {$size} record",
                );
            }
        }
    }

    #[Test]
    #[Group('benchmark')]
    public function it_meets_performance_benchmarks(): void
    {
        $benchmarks = [
            'small' => ['size' => 10, 'max_save' => 0.05, 'max_load' => 0.02],
            'medium' => ['size' => 100, 'max_save' => 0.2, 'max_load' => 0.1],
            'large' => ['size' => 500, 'max_save' => 1.0, 'max_load' => 0.5],
            'xlarge' => ['size' => 1000, 'max_save' => 2.0, 'max_load' => 1.0],
        ];

        foreach ($benchmarks as $category => $benchmark) {
            $testData = $this->createTestData($benchmark['size']);

            // Benchmark salvataggio
            $startTime = microtime(true);
            $result = $this->model->saveToJson($testData);
            $saveTime = microtime(true) - $startTime;

            $this->assertTrue($result);
            $this->assertLessThan(
                $benchmark['max_save'],
                $saveTime,
                "Salvataggio {$category} dataset deve rispettare il benchmark",
            );

            // Benchmark caricamento
            $startTime = microtime(true);
            $loadedData = $this->model->getSushiRows();
            $loadTime = microtime(true) - $startTime;

            $this->assertCount($benchmark['size'], $loadedData);
            $this->assertLessThan(
                $benchmark['max_load'],
                $loadTime,
                "Caricamento {$category} dataset deve rispettare il benchmark",
            );
        }
    }

    #[Test]
    #[Group('memory-leaks')]
    public function it_does_not_create_memory_leaks(): void
    {
        $initialMemory = memory_get_usage();

        // Esegui operazioni multiple
        for ($i = 0; $i < 5; $i++) {
            $testData = $this->createTestData(100);

            // Salva
            $result = $this->model->saveToJson($testData);
            $this->assertTrue($result);

            // Carica
            $loadedData = $this->model->getSushiRows();
            $this->assertCount(100, $loadedData);

            // Forza garbage collection
            if (function_exists('gc_collect_cycles')) {
                gc_collect_cycles();
            }
        }

        $finalMemory = memory_get_usage();
        $memoryIncrease = $finalMemory - $initialMemory;

        // Verifica che non ci siano memory leaks significativi
        $this->assertLessThan(
            10 * 1024 * 1024,
            $memoryIncrease,
            'Non devono esserci memory leaks significativi (>10MB)',
        );
    }
}
