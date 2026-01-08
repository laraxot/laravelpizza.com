# Testing nel Modulo Tenant

## Introduzione

Il testing è una parte fondamentale dello sviluppo del modulo Tenant. Questo documento descrive le best practices e le strategie di testing da seguire per garantire la qualità e l'affidabilità del codice.

## Tipi di Test

### 1. Test Unitari

I test unitari verificano il comportamento di singole unità di codice in isolamento.

```php
namespace Modules\Tenant\Tests\Unit;

use Tests\TestCase;
use Modules\Tenant\Models\Tenant;
use Modules\Tenant\Services\TenantService;

class TenantServiceTest extends TestCase
{
    private TenantService $service;

    protected function setUp(): void
    {
        parent::setUp();
        $this->service = app(TenantService::class);
    }

    public function test_can_create_tenant()
    {
        $data = [
            'name' => 'Test Tenant',
            'domain' => 'test.example.com'
        ];

        $tenant = $this->service->create($data);

        $this->assertInstanceOf(Tenant::class, $tenant);
        $this->assertEquals($data['name'], $tenant->name);
        $this->assertEquals($data['domain'], $tenant->domain);
    }
}
```

### 2. Test di Integrazione

I test di integrazione verificano l'interazione tra diversi componenti del modulo.

```php
namespace Modules\Tenant\Tests\Integration;

use Tests\TestCase;
use Modules\Tenant\Models\Tenant;
use Modules\Tenant\Events\TenantCreated;
use Illuminate\Support\Facades\Event;

class TenantIntegrationTest extends TestCase
{
    public function test_tenant_creation_workflow()
    {
        Event::fake();

        $tenant = Tenant::factory()->create([
            'name' => 'Integration Test Tenant'
        ]);

        Event::assertDispatched(TenantCreated::class, function ($event) use ($tenant) {
            return $event->tenant->id === $tenant->id;
        });

        $this->assertDatabaseHas('tenants', [
            'id' => $tenant->id,
            'name' => 'Integration Test Tenant'
        ]);
    }
}
```

### 3. Test Funzionali

I test funzionali verificano il comportamento del modulo dal punto di vista dell'utente finale.
**Nota**: Seguendo le regole Laraxot, evitare l'uso di `RefreshDatabase` nei test.

```php
namespace Modules\Tenant\Tests\Feature;

use Tests\TestCase;
use Modules\Tenant\Models\Tenant;

class TenantControllerTest extends TestCase
{
    public function test_can_view_tenant_list()
    {
        // Usa dati di test temporanei senza RefreshDatabase
        $tempDir = storage_path('testing/tenant_' . uniqid());
        config(['tenant.storage_path' => $tempDir]);
        
        // Crea dati di test nel filesystem temporaneo
        $this->createTestTenantData($tempDir);

        $response = $this->get(route('tenants.index'));

        $response->assertStatus(200)
                ->assertViewIs('tenant::index')
                ->assertViewHas('tenants');
                
        // Cleanup
        $this->cleanupTestData($tempDir);
    }
    
    private function createTestTenantData(string $path): void
    {
        File::makeDirectory($path, 0755, true);
        // Crea dati di test specifici
    }
    
    private function cleanupTestData(string $path): void
    {
        if (File::exists($path)) {
            File::deleteDirectory($path);
        }
    }
}
```

## Best Practices

### 1. Organizzazione dei Test

- Mantenere una struttura speculare alla struttura del codice
- Utilizzare namespace appropriati
- Seguire le convenzioni di naming di Laravel

```
Tests/
├── Unit/
│   ├── Models/
│   ├── Services/
│   └── Actions/
├── Integration/
│   ├── Events/
│   └── Listeners/
└── Feature/
    └── Http/
```

### 2. Database Testing

**Nota**: Seguendo le regole Laraxot, evitare l'uso di `RefreshDatabase`. Utilizzare invece dati temporanei e cleanup manuale.

```php
class TenantDatabaseTest extends TestCase
{
    public function test_tenant_soft_deletes()
    {
        // Setup dati temporanei per il test
        $tempDir = storage_path('testing/tenant_' . uniqid());
        $this->setupTempTenantStorage($tempDir);
        
        // Crea tenant utilizzando SushiToJson trait
        $tenant = new TestTenantModel([
            'name' => 'Test Tenant',
            'status' => 'active'
        ]);
        $tenant->save();
        
        // Test soft delete
        $tenant->delete();
        
        // Verifica che il record sia marcato come eliminato
        $this->assertNotNull($tenant->deleted_at);
        
        // Cleanup
        $this->cleanupTempStorage($tempDir);
    }
    
    private function setupTempTenantStorage(string $path): void
    {
        File::makeDirectory($path, 0755, true);
        config(['tenant.storage_path' => $path]);
    }
    
    private function cleanupTempStorage(string $path): void
    {
        if (File::exists($path)) {
            File::deleteDirectory($path);
        }
    }
}
```

### 3. Mocking e Stubbing

```php
use Mockery;

class TenantServiceTest extends TestCase
{
    public function test_tenant_creation_with_mocked_repository()
    {
        $repository = Mockery::mock(TenantRepositoryInterface::class);
        $repository->shouldReceive('create')
                  ->once()
                  ->andReturn(new Tenant());

        $service = new TenantService($repository);
        $result = $service->create(['name' => 'Test']);

        $this->assertInstanceOf(Tenant::class, $result);
    }
}
```

### 4. Test delle Eccezioni

```php
class TenantExceptionTest extends TestCase
{
    public function test_throws_exception_on_invalid_domain()
    {
        $this->expectException(InvalidDomainException::class);

        Tenant::factory()->create([
            'domain' => 'invalid domain'
        ]);
    }
}
```

## Test di Performance

### 1. Benchmarking

```php
class TenantPerformanceTest extends TestCase
{
    public function test_tenant_creation_performance()
    {
        $start = microtime(true);

        Tenant::factory()->count(100)->create();

        $duration = microtime(true) - $start;
        $this->assertLessThan(5.0, $duration);
    }
}
```

### 2. Memory Testing

```php
class TenantMemoryTest extends TestCase
{
    public function test_memory_usage()
    {
        $initialMemory = memory_get_usage();

        $tenants = Tenant::factory()->count(1000)->create();

        $finalMemory = memory_get_usage();
        $memoryUsed = $finalMemory - $initialMemory;

        $this->assertLessThan(50 * 1024 * 1024, $memoryUsed); // 50MB
    }
}
```

## Continuous Integration

### 1. GitHub Actions

```yaml
name: Tests

on: [push, pull_request]

jobs:
  test:
    runs-on: ubuntu-latest
    
    steps:
    - uses: actions/checkout@v2
    
    - name: Setup PHP
      uses: shivammathur/setup-php@v2
      with:
        php-version: '8.1'
        
    - name: Install Dependencies
      run: composer install -q --no-ansi --no-interaction --no-scripts --no-progress --prefer-dist
        
    - name: Execute tests
      run: vendor/bin/phpunit
```

### 2. Code Coverage

```bash

# phpunit.xml
<coverage>
    <include>
        <directory suffix=".php">./app</directory>
    </include>
    <exclude>
        <directory>./vendor</directory>
    </exclude>
</coverage>
```

## Manutenzione dei Test

### 1. Refactoring

- Mantenere i test aggiornati con le modifiche al codice
- Rimuovere i test obsoleti
- Aggiornare le asserzioni quando necessario

### 2. Documentazione

- Documentare i casi di test complessi
- Mantenere aggiornata la documentazione dei test
- Includere esempi di utilizzo

## Collegamenti Correlati

- [Struttura del Modulo](structure.md)
- [Best Practices](README.md#best-practices)
- [Documentazione PHPUnit](https://phpunit.de/documentation.html) 
