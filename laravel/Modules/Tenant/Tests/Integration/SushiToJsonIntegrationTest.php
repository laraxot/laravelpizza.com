<?php

declare(strict_types=1);

namespace Modules\Tenant\Tests\Integration;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\File;
use Modules\Tenant\Models\Tenant;
use Modules\Tenant\Models\TestSushiModel;
use Modules\Tenant\Services\TenantService;
use Modules\User\Models\User;
use PHPUnit\Framework\Attributes\Group;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

/**
 * Test di integrazione per il trait SushiToJson.
 *
 * Testa l'integrazione del trait con il sistema multi-tenant,
 * verificando l'isolamento dei dati e la gestione dei percorsi.
 */
#[Group('integration')]
#[Group('sushi-json')]
class SushiToJsonIntegrationTest extends TestCase
{
    use RefreshDatabase;

    private Tenant $tenant1;

    private Tenant $tenant2;

    private string $tenant1Path;

    private string $tenant2Path;

    protected function setUp(): void
    {
        parent::setUp();

        // Crea tenant di test
        $this->tenant1 = Tenant::factory()->create([
            'name' => 'Test Tenant 1',
            'domain' => 'tenant1.test',
        ]);

        $this->tenant2 = Tenant::factory()->create([
            'name' => 'Test Tenant 2',
            'domain' => 'tenant2.test',
        ]);

        // Configura percorsi per i tenant
        $this->tenant1Path = config_path($this->tenant1->name.'/database/content');
        $this->tenant2Path = config_path($this->tenant2->name.'/database/content');

        // Crea directory per i tenant
        if (! File::exists($this->tenant1Path)) {
            File::makeDirectory($this->tenant1Path, 0o755, true, true);
        }
        if (! File::exists($this->tenant2Path)) {
            File::makeDirectory($this->tenant2Path, 0o755, true, true);
        }
    }

    protected function tearDown(): void
    {
        // Cleanup directory tenant
        if (File::exists($this->tenant1Path)) {
            File::deleteDirectory(dirname($this->tenant1Path));
        }
        if (File::exists($this->tenant2Path)) {
            File::deleteDirectory(dirname($this->tenant2Path));
        }

        parent::tearDown();
    }

    #[Test]
    #[Group('tenant-isolation')]
    public function it_creates_json_file_with_tenant_isolation(): void
    {
        // Configura tenant 1
        $this->actingAs($this->createUserForTenant($this->tenant1));
        $this->setCurrentTenant($this->tenant1);

        $model1 = new TestSushiModel;
        $data1 = [
            '1' => [
                'id' => 1,
                'name' => 'Tenant 1 Item',
                'description' => 'Item specifico per tenant 1',
                'status' => 'active',
            ],
        ];

        $model1->saveToJson($data1);

        // Verifica che i dati siano salvati nel percorso corretto del tenant 1
        $this->assertFileExists($this->tenant1Path.'/test_sushi.json');
        $this->assertFileDoesNotExist($this->tenant2Path.'/test_sushi.json');

        // Configura tenant 2
        $this->actingAs($this->createUserForTenant($this->tenant2));
        $this->setCurrentTenant($this->tenant2);

        $model2 = new TestSushiModel;
        $data2 = [
            '1' => [
                'id' => 1,
                'name' => 'Tenant 2 Item',
                'description' => 'Item specifico per tenant 2',
                'status' => 'active',
            ],
        ];

        $model2->saveToJson($data2);

        // Verifica che i dati siano salvati nel percorso corretto del tenant 2
        $this->assertFileExists($this->tenant2Path.'/test_sushi.json');

        // Verifica che i dati siano diversi tra i tenant
        $tenant1Data = json_decode(File::get($this->tenant1Path.'/test_sushi.json'), true);
        $tenant2Data = json_decode(File::get($this->tenant2Path.'/test_sushi.json'), true);

        $this->assertEquals('Tenant 1 Item', $tenant1Data['1']['name']);
        $this->assertEquals('Tenant 2 Item', $tenant2Data['1']['name']);
    }

    #[Test]
    #[Group('tenant-isolation')]
    public function it_loads_data_with_tenant_isolation(): void
    {
        // Crea dati per entrambi i tenant
        $this->createTenantData();

        // Testa caricamento dati tenant 1
        $this->actingAs($this->createUserForTenant($this->tenant1));
        $this->setCurrentTenant($this->tenant1);

        $model1 = new TestSushiModel;
        $rows1 = $model1->getSushiRows();

        $this->assertCount(2, $rows1);
        $this->assertEquals('Tenant 1 Item 1', $rows1['1']['name']);
        $this->assertEquals('Tenant 1 Item 2', $rows1['2']['name']);

        // Testa caricamento dati tenant 2
        $this->actingAs($this->createUserForTenant($this->tenant2));
        $this->setCurrentTenant($this->tenant2);

        $model2 = new TestSushiModel;
        $rows2 = $model2->getSushiRows();

        $this->assertCount(2, $rows2);
        $this->assertEquals('Tenant 2 Item 1', $rows2['1']['name']);
        $this->assertEquals('Tenant 2 Item 2', $rows2['2']['name']);

        // Verifica che i dati siano completamente isolati
        $this->assertNotEquals($rows1, $rows2);
    }

    #[Test]
    #[Group('data-integrity')]
    public function it_handles_complex_data_structures(): void
    {
        $this->actingAs($this->createUserForTenant($this->tenant1));
        $this->setCurrentTenant($this->tenant1);

        $model = new TestSushiModel;
        $complexData = [
            '1' => [
                'id' => 1,
                'name' => 'Complex Item',
                'metadata' => [
                    'tags' => ['tag1', 'tag2', 'tag3'],
                    'settings' => [
                        'enabled' => true,
                        'max_retries' => 3,
                        'timeout' => 30.5,
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

        $result = $model->saveToJson($complexData);
        $this->assertTrue($result);

        // Verifica che i dati complessi siano caricati correttamente
        $loadedData = $model->getSushiRows();
        $this->assertArrayHasKey('1', $loadedData);
        $this->assertEquals('Complex Item', $loadedData['1']['name']);

        // Verifica che gli array nidificati siano convertiti in stringhe JSON
        $this->assertIsString($loadedData['1']['metadata']);
        $metadata = json_decode($loadedData['1']['metadata'], true);
        $this->assertEquals(['tag1', 'tag2', 'tag3'], $metadata['tags']);
        $this->assertEquals(30.5, $metadata['settings']['timeout']);
        $this->assertEquals('deep_value', $metadata['nested']['level1']['level2']['level3']);
    }

    #[Test]
    #[Group('file-management')]
    public function it_manages_file_permissions_correctly(): void
    {
        $this->actingAs($this->createUserForTenant($this->tenant1));
        $this->setCurrentTenant($this->tenant1);

        $model = new TestSushiModel;
        $testData = [
            '1' => [
                'id' => 1,
                'name' => 'Permission Test Item',
                'status' => 'active',
            ],
        ];

        $result = $model->saveToJson($testData);
        $this->assertTrue($result);

        // Verifica che il file sia leggibile
        $this->assertFileIsReadable($this->tenant1Path.'/test_sushi.json');

        // Verifica che il file sia scrivibile
        $this->assertFileIsWritable($this->tenant1Path.'/test_sushi.json');

        // Verifica che la directory abbia i permessi corretti
        $this->assertDirectoryIsReadable($this->tenant1Path);
        $this->assertDirectoryIsWritable($this->tenant1Path);
    }

    #[Test]
    #[Group('concurrency')]
    public function it_handles_concurrent_access_safely(): void
    {
        $this->actingAs($this->createUserForTenant($this->tenant1));
        $this->setCurrentTenant($this->tenant1);

        $model = new TestSushiModel;
        $initialData = [
            '1' => [
                'id' => 1,
                'name' => 'Initial Item',
                'status' => 'active',
            ],
        ];

        $model->saveToJson($initialData);

        // Simula accesso concorrente
        $concurrentData = [
            '1' => [
                'id' => 1,
                'name' => 'Concurrent Update',
                'status' => 'updated',
            ],
            '2' => [
                'id' => 2,
                'name' => 'New Item',
                'status' => 'active',
            ],
        ];

        $result = $model->saveToJson($concurrentData);
        $this->assertTrue($result);

        // Verifica che i dati siano stati salvati correttamente
        $loadedData = $model->getSushiRows();
        $this->assertCount(2, $loadedData);
        $this->assertEquals('Concurrent Update', $loadedData['1']['name']);
        $this->assertEquals('New Item', $loadedData['2']['name']);
    }

    #[Test]
    #[Group('performance')]
    public function it_handles_large_datasets_efficiently(): void
    {
        $this->actingAs($this->createUserForTenant($this->tenant1));
        $this->setCurrentTenant($this->tenant1);

        $model = new TestSushiModel;

        // Crea dataset grande (500 record)
        $largeData = [];
        for ($i = 1; $i <= 500; $i++) {
            $largeData[$i] = [
                'id' => $i,
                'name' => "Large Dataset Item {$i}",
                'description' => "Description for large dataset item {$i}",
                'status' => 0 === ($i % 2) ? 'active' : 'inactive',
                'metadata' => [
                    'category' => 'Category '.($i % 10),
                    'priority' => ($i % 5) + 1,
                    'tags' => ["tag{$i}", 'tag'.($i + 1)],
                ],
                'created_at' => now()->toISOString(),
                'updated_at' => now()->toISOString(),
            ];
        }

        $startTime = microtime(true);
        $result = $model->saveToJson($largeData);
        $saveTime = microtime(true) - $startTime;

        $this->assertTrue($result);
        $this->assertLessThan(2.0, $saveTime, 'Salvataggio dataset grande deve essere veloce');

        // Testa caricamento
        $startTime = microtime(true);
        $loadedData = $model->getSushiRows();
        $loadTime = microtime(true) - $startTime;

        $this->assertCount(500, $loadedData);
        $this->assertLessThan(1.0, $loadTime, 'Caricamento dataset grande deve essere veloce');
    }

    #[Test]
    #[Group('unicode')]
    public function it_handles_unicode_and_special_characters(): void
    {
        $this->actingAs($this->createUserForTenant($this->tenant1));
        $this->setCurrentTenant($this->tenant1);

        $model = new TestSushiModel;
        $unicodeData = [
            '1' => [
                'id' => 1,
                'name' => 'Café & Résumé 🚀',
                'description' => 'Test con caratteri speciali: é, è, ñ, 中文, 🎉',
                'tags' => ['tag-é', 'tag-è', 'tag-ñ', '中文标签', '🚀-tag'],
                'metadata' => [
                    'special_chars' => 'áéíóú ñ ü ç',
                    'emojis' => ['🎉', '🚀', '⭐', '🔥', '💯'],
                    'chinese' => '你好世界',
                    'japanese' => 'こんにちは世界',
                ],
            ],
        ];

        $result = $model->saveToJson($unicodeData);
        $this->assertTrue($result);

        // Verifica che i caratteri Unicode siano preservati
        $loadedData = $model->getSushiRows();
        $this->assertEquals('Café & Résumé 🚀', $loadedData['1']['name']);
        $this->assertEquals('Test con caratteri speciali: é, è, ñ, 中文, 🎉', $loadedData['1']['description']);

        // Verifica che gli array con caratteri speciali siano convertiti correttamente
        $this->assertIsString($loadedData['1']['tags']);
        $this->assertIsString($loadedData['1']['metadata']);

        $tags = json_decode($loadedData['1']['tags'], true);
        $metadata = json_decode($loadedData['1']['metadata'], true);

        $this->assertEquals('tag-é', $tags[0]);
        $this->assertEquals('🚀-tag', $tags[4]);
        $this->assertEquals('你好世界', $metadata['chinese']);
        $this->assertEquals('こんにちは世界', $metadata['japanese']);
    }

    #[Test]
    #[Group('edge-cases')]
    public function it_handles_empty_and_null_values(): void
    {
        $this->actingAs($this->createUserForTenant($this->tenant1));
        $this->setCurrentTenant($this->tenant1);

        $model = new TestSushiModel;
        $edgeCaseData = [
            '1' => [
                'id' => 1,
                'name' => '',
                'description' => null,
                'metadata' => [],
                'tags' => null,
                'settings' => [
                    'enabled' => false,
                    'max_retries' => 0,
                    'timeout' => 0.0,
                    'empty_string' => '',
                    'null_value' => null,
                    'empty_array' => [],
                ],
                'status' => false,
                'created_at' => null,
                'updated_at' => null,
            ],
        ];

        $result = $model->saveToJson($edgeCaseData);
        $this->assertTrue($result);

        // Verifica che i valori vuoti e null siano gestiti correttamente
        $loadedData = $model->getSushiRows();
        $this->assertEquals('', $loadedData['1']['name']);
        $this->assertNull($loadedData['1']['description']);
        $this->assertEquals('[]', $loadedData['1']['metadata']); // Convertito in stringa JSON
        $this->assertNull($loadedData['1']['tags']);
        $this->assertFalse($loadedData['1']['status']);

        // Verifica che gli array nidificati con valori vuoti siano convertiti correttamente
        $this->assertIsString($loadedData['1']['settings']);
        $settings = json_decode($loadedData['1']['settings'], true);
        $this->assertFalse($settings['enabled']);
        $this->assertEquals(0, $settings['max_retries']);
        $this->assertEquals(0.0, $settings['timeout']);
        $this->assertEquals('', $settings['empty_string']);
        $this->assertNull($settings['null_value']);
        $this->assertEquals([], $settings['empty_array']);
    }

    #[Test]
    #[Group('tenant-configuration')]
    public function it_works_with_different_tenant_configurations(): void
    {
        // Testa con tenant che ha configurazioni diverse
        $customTenant = Tenant::factory()->create([
            'name' => 'Custom Tenant',
            'domain' => 'custom.test',
            'settings' => [
                'json_storage_path' => 'custom/path',
                'file_permissions' => 0o644,
                'max_file_size' => '10MB',
            ],
        ]);

        $this->actingAs($this->createUserForTenant($customTenant));
        $this->setCurrentTenant($customTenant);

        $customPath = config_path($customTenant->name.'/database/content');
        if (! File::exists($customPath)) {
            File::makeDirectory($customPath, 0o755, true, true);
        }

        $model = new TestSushiModel;
        $testData = [
            '1' => [
                'id' => 1,
                'name' => 'Custom Tenant Item',
                'status' => 'active',
            ],
        ];

        $result = $model->saveToJson($testData);
        $this->assertTrue($result);

        // Verifica che i dati siano salvati nel percorso personalizzato
        $this->assertFileExists($customPath.'/test_sushi.json');

        // Cleanup
        if (File::exists($customPath)) {
            File::deleteDirectory(dirname($customPath));
        }
    }

    /**
     * Crea dati di test per entrambi i tenant.
     */
    private function createTenantData(): void
    {
        // Dati per tenant 1
        $this->actingAs($this->createUserForTenant($this->tenant1));
        $this->setCurrentTenant($this->tenant1);

        $model1 = new TestSushiModel;
        $data1 = [
            '1' => [
                'id' => 1,
                'name' => 'Tenant 1 Item 1',
                'description' => 'Primo item per tenant 1',
                'status' => 'active',
            ],
            '2' => [
                'id' => 2,
                'name' => 'Tenant 1 Item 2',
                'description' => 'Secondo item per tenant 1',
                'status' => 'inactive',
            ],
        ];
        $model1->saveToJson($data1);

        // Dati per tenant 2
        $this->actingAs($this->createUserForTenant($this->tenant2));
        $this->setCurrentTenant($this->tenant2);

        $model2 = new TestSushiModel;
        $data2 = [
            '1' => [
                'id' => 1,
                'name' => 'Tenant 2 Item 1',
                'description' => 'Primo item per tenant 2',
                'status' => 'active',
            ],
            '2' => [
                'id' => 2,
                'name' => 'Tenant 2 Item 2',
                'description' => 'Secondo item per tenant 2',
                'status' => 'inactive',
            ],
        ];
        $model2->saveToJson($data2);
    }

    /**
     * Crea un utente per il tenant specificato.
     */
    private function createUserForTenant(Tenant $tenant): User
    {
        return User::factory()->create([
            'tenant_id' => $tenant->id,
        ]);
    }

    /**
     * Imposta il tenant corrente per il test.
     */
    private function setCurrentTenant(Tenant $tenant): void
    {
        // Mock del TenantService per restituire il percorso corretto
        $this->mock(TenantService::class, function ($mock) use ($tenant) {
            $mock
                ->shouldReceive('filePath')
                ->with('database/content/test_sushi.json')
                ->andReturn(config_path($tenant->name.'/database/content/test_sushi.json'));
        });
    }
}
