# Testing Guidelines - Modulo Xot

## Framework di Testing: Pest

Il modulo Xot utilizza **Pest** per testare il core framework, i trait condivisi, e i componenti base utilizzati da tutti gli altri moduli del sistema Laraxot.

### Focus del Modulo Xot

- **Core Framework**: Testing di base system, configurazioni, provider
- **Shared Traits**: Validazione di trait utilizzati da più moduli
- **Base Components**: Test di componenti UI/framework comuni
- **Data Objects**: Validazione di Data Transfer Objects e strutture dati
- **Foundation Services**: Servizi base utilizzati system-wide

## Struttura dei Test

```
Modules/Xot/tests/
├── Pest.php                    # Configurazione Pest per framework core
├── CreatesApplication.php      # Trait per bootstrap applicazione
├── TestCase.php                # TestCase base per framework
├── Feature/                    # Test di integrazione framework
│   ├── Actions/
│   │   ├── SendMailByRecordActionTest.php
│   │   ├── ExportActionTest.php
│   │   └── ImportActionTest.php
│   ├── Services/
│   │   ├── CoreServiceTest.php
│   │   ├── ConfigServiceTest.php
│   │   └── CacheServiceTest.php
│   └── Providers/
│       ├── XotServiceProviderTest.php
│       └── RouteServiceProviderTest.php
└── Unit/                       # Test unitari componenti core
    ├── MetatagDataTest.php     # Test strutture dati meta
    ├── Traits/
    │   ├── HasXotTableTest.php
    │   ├── RelationXTest.php
    │   └── BaseModelTraitTest.php
    ├── Datas/
    │   ├── BaseDataTest.php
    │   └── ConfigurationDataTest.php
    └── Helpers/
        ├── StringHelperTest.php
        └── ArrayHelperTest.php
```

## Configurazione Pest.php

```php
<?php

declare(strict_types=1);

use Modules\Xot\Tests\TestCase;

/*
|--------------------------------------------------------------------------
| Test Case
|--------------------------------------------------------------------------
|
| TestCase core per il framework Xot che fornisce bootstrap personalizzato
|
*/

uses(TestCase::class)->in('Feature', 'Unit');

/*
|--------------------------------------------------------------------------
| Core Expectations
|--------------------------------------------------------------------------
|
| Custom expectations per testing del framework core
|
*/

expect()->extend('toBeValidMetatag', function () {
    return $this->toHaveKeys(['title', 'description', 'keywords'])
        ->and($this->value['title'])->not->toBeEmpty()
        ->and($this->value['description'])->not->toBeEmpty();
});

expect()->extend('toHaveXotStructure', function () {
    return $this->toHaveKey('module_name')
        ->and($this->value)->toHaveKey('namespace')
        ->and($this->value)->toHaveKey('version');
});

expect()->extend('toBeValidConfig', function () {
    return $this->toBeArray()
        ->and($this->value)->not->toBeEmpty();
});

/*
|--------------------------------------------------------------------------
| Framework Helper Functions
|--------------------------------------------------------------------------
|
| Funzioni helper specifiche per test del framework core
|
*/

function createTestMetatag(array $overrides = []): array
{
    return array_merge([
        'title' => 'Test Page Title',
        'description' => 'Test page description for SEO',
        'keywords' => 'test, page, seo',
        'author' => 'Laraxot Framework',
        'robots' => 'index,follow',
        'canonical' => 'https://example.com/test',
    ], $overrides);
}

function createTestModuleConfig(string $module = 'TestModule'): array
{
    return [
        'module_name' => $module,
        'namespace' => "Modules\\{$module}",
        'version' => '1.0.0',
        'providers' => [
            "Modules\\{$module}\\Providers\\{$module}ServiceProvider",
        ],
        'aliases' => [],
        'files' => [],
        'requires' => [],
    ];
}
```

## CreatesApplication Trait

Il trait `CreatesApplication` fornisce il bootstrap customizzato per Laraxot:

```php
<?php

declare(strict_types=1);

namespace Modules\Xot\Tests;

use Illuminate\Contracts\Console\Kernel;
use Illuminate\Foundation\Application;

trait CreatesApplication
{
    /**
     * Creates the Laraxot application instance.
     */
    public function createApplication(): Application
    {
        $app = require __DIR__.'/../../../bootstrap/app.php';

        $app->make(Kernel::class)->bootstrap();

        return $app;
    }
    
    /**
     * Setup Xot-specific test environment.
     */
    protected function setUpXotTestEnvironment(): void
    {
        // Framework configuration for testing
        config(['xot.test_mode' => true]);
        config(['cache.default' => 'array']);
        config(['session.driver' => 'array']);
        
        // Module discovery in test mode
        config(['modules.scan.enabled' => true]);
        config(['modules.cache.enabled' => false]);
    }
}
```

## TestCase Base Framework

```php
<?php

declare(strict_types=1);

namespace Modules\Xot\Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;
    
    protected function setUp(): void
    {
        parent::setUp();
        
        $this->setUpXotTestEnvironment();
    }
    
    /**
     * Helper per mock di moduli in test.
     */
    protected function mockModule(string $moduleName, array $config = []): void
    {
        $moduleConfig = createTestModuleConfig($moduleName);
        $moduleConfig = array_merge($moduleConfig, $config);
        
        config(["modules.modules.{$moduleName}" => $moduleConfig]);
    }
}
```

## Test Core Framework

### Test MetatagData (Esistente - Aggiornato a Pest)

```php
use Modules\Xot\Datas\MetatagData;

test('creates MetatagData with valid data', function (): void {
    $metaData = createTestMetatag();
    
    $metatag = MetatagData::from($metaData);
    
    expect($metatag->toArray())->toBeValidMetatag()
        ->and($metatag->title)->toBe('Test Page Title')
        ->and($metatag->description)->toBe('Test page description for SEO')
        ->and($metatag->keywords)->toBe('test, page, seo');
});

test('validates required fields in MetatagData', function (): void {
    expect(fn() => MetatagData::from([]))
        ->toThrow(\Exception::class);
});

test('generates proper HTML meta tags', function (): void {
    $metaData = createTestMetatag();
    $metatag = MetatagData::from($metaData);
    
    $html = $metatag->toHtml();
    
    expect($html)
        ->toContain('<title>Test Page Title</title>')
        ->toContain('<meta name="description" content="Test page description for SEO">')
        ->toContain('<meta name="keywords" content="test, page, seo">');
});
```

### Test Trait HasXotTable

```php
use Modules\Xot\Models\Traits\HasXotTable;

test('HasXotTable trait provides table naming', function (): void {
    $model = new class extends \Illuminate\Database\Eloquent\Model {
        use HasXotTable;
        
        protected string $module = 'TestModule';
    };
    
    expect($model->getTable())->toContain('test_module_');
});

test('HasXotTable respects custom table names', function (): void {
    $model = new class extends \Illuminate\Database\Eloquent\Model {
        use HasXotTable;
        
        protected $table = 'custom_table';
    };
    
    expect($model->getTable())->toBe('custom_table');
});

test('HasXotTable handles module detection', function (): void {
    $this->mockModule('SampleModule');
    
    $model = new class extends \Illuminate\Database\Eloquent\Model {
        use HasXotTable;
    };
    
    // Test automatico detection del modulo dal namespace
    expect($model->getModuleName())->not->toBeEmpty();
});
```

### Test Core Actions

```php
use Modules\Xot\Actions\SendMailByRecordAction;

beforeEach(function () {
    Mail::fake();
});

test('SendMailByRecordAction sends email correctly', function (): void {
    $record = new \stdClass();
    $record->email = 'test@example.com';
    $record->name = 'Test User';
    
    $action = app(SendMailByRecordAction::class);
    
    $result = $action->execute($record, [
        'template' => 'welcome',
        'subject' => 'Welcome Email'
    ]);
    
    expect($result)->toBeTrue();
    
    Mail::assertSent(\Modules\Xot\Mail\GenericMail::class, function ($mail) {
        return $mail->hasTo('test@example.com');
    });
});

test('SendMailByRecordAction validates record data', function (): void {
    $invalidRecord = new \stdClass();
    // Missing email
    
    $action = app(SendMailByRecordAction::class);
    
    expect(fn() => $action->execute($invalidRecord, []))
        ->toThrow(\InvalidArgumentException::class, 'Email field required');
});
```

### Test Export/Import Actions

```php
use Modules\Xot\Actions\ExportAction;
use Modules\Xot\Actions\ImportAction;

test('ExportAction generates valid export data', function (): void {
    // Setup test data
    $testData = collect([
        ['id' => 1, 'name' => 'Item 1'],
        ['id' => 2, 'name' => 'Item 2'],
    ]);
    
    $action = app(ExportAction::class);
    
    $result = $action->execute($testData, 'csv');
    
    expect($result)
        ->toHaveKey('format', 'csv')
        ->toHaveKey('data')
        ->toHaveKey('filename')
        ->and($result['data'])->toContain('Item 1');
});

test('ImportAction processes CSV data correctly', function (): void {
    $csvData = "id,name\n1,Item 1\n2,Item 2";
    
    $action = app(ImportAction::class);
    
    $result = $action->execute($csvData, 'csv');
    
    expect($result)
        ->toBeArray()
        ->toHaveCount(2)
        ->and($result[0])->toHaveKey('name', 'Item 1');
});
```

## Test Services Core

### Test ConfigService

```php
use Modules\Xot\Services\ConfigService;

test('ConfigService loads module configurations', function (): void {
    $this->mockModule('TestModule', [
        'custom_setting' => 'test_value'
    ]);
    
    $service = app(ConfigService::class);
    
    $config = $service->getModuleConfig('TestModule');
    
    expect($config)->toBeValidConfig()
        ->and($config)->toHaveKey('custom_setting', 'test_value');
});

test('ConfigService merges configurations correctly', function (): void {
    $service = app(ConfigService::class);
    
    $result = $service->mergeConfigs([
        'setting1' => 'value1',
        'nested' => ['key1' => 'val1']
    ], [
        'setting2' => 'value2',
        'nested' => ['key2' => 'val2']
    ]);
    
    expect($result)
        ->toHaveKey('setting1', 'value1')
        ->toHaveKey('setting2', 'value2')
        ->and($result['nested'])->toHaveKeys(['key1', 'key2']);
});
```

### Test CacheService

```php
use Modules\Xot\Services\CacheService;

test('CacheService stores and retrieves data', function (): void {
    $service = app(CacheService::class);
    
    $service->put('test_key', 'test_value', 60);
    
    $result = $service->get('test_key');
    
    expect($result)->toBe('test_value');
});

test('CacheService handles cache tags', function (): void {
    $service = app(CacheService::class);
    
    $service->tags(['module:test'])->put('tagged_key', 'tagged_value', 60);
    
    $result = $service->tags(['module:test'])->get('tagged_key');
    
    expect($result)->toBe('tagged_value');
});
```

## Test Data Objects

### Test BaseData Structure

```php
use Modules\Xot\Datas\BaseData;

test('BaseData validates required fields', function (): void {
    $data = BaseData::from([
        'id' => 1,
        'name' => 'Test Item',
        'created_at' => now(),
    ]);
    
    expect($data->id)->toBe(1)
        ->and($data->name)->toBe('Test Item')
        ->and($data->created_at)->toBeInstanceOf(\Carbon\Carbon::class);
});

test('BaseData converts to array correctly', function (): void {
    $original = [
        'id' => 1,
        'name' => 'Test Item',
        'active' => true,
    ];
    
    $data = BaseData::from($original);
    $array = $data->toArray();
    
    expect($array)->toBe($original);
});
```

## Test Helpers e Utilities

### Test String Helpers

```php
use Modules\Xot\Helpers\StringHelper;

test('StringHelper converts to camelCase correctly', function (string $input, string $expected) {
    $result = StringHelper::toCamelCase($input);
    
    expect($result)->toBe($expected);
})->with([
    ['hello_world', 'helloWorld'],
    ['test-string', 'testString'],
    ['Already CamelCase', 'alreadyCamelCase'],
]);

test('StringHelper generates slugs correctly', function (): void {
    $result = StringHelper::generateSlug('Test Title With Spaces!');
    
    expect($result)->toBe('test-title-with-spaces')
        ->and($result)->toMatch('/^[a-z0-9-]+$/');
});
```

### Test Array Helpers

```php
use Modules\Xot\Helpers\ArrayHelper;

test('ArrayHelper flattens nested arrays', function (): void {
    $nested = [
        'level1' => [
            'level2' => [
                'level3' => 'value'
            ]
        ]
    ];
    
    $flattened = ArrayHelper::flatten($nested);
    
    expect($flattened)->toHaveKey('level1.level2.level3', 'value');
});

test('ArrayHelper filters by keys', function (): void {
    $array = ['a' => 1, 'b' => 2, 'c' => 3];
    
    $filtered = ArrayHelper::only($array, ['a', 'c']);
    
    expect($filtered)->toHaveKeys(['a', 'c'])
        ->and($filtered)->not->toHaveKey('b');
});
```

## Performance e Load Testing

### Test Performance Core

```php
test('core services perform within benchmarks', function (string $service, float $maxTime) {
    $startTime = microtime(true);
    
    $instance = app($service);
    $instance->performanceTestMethod();
    
    $executionTime = microtime(true) - $startTime;
    
    expect($executionTime)->toBeLessThan($maxTime);
})->with([
    [ConfigService::class, 0.1],  // 100ms max
    [CacheService::class, 0.05],  // 50ms max
]);

test('module loading performance is acceptable', function (): void {
    $startTime = microtime(true);
    
    // Simula caricamento di 10 moduli
    for ($i = 1; $i <= 10; $i++) {
        $this->mockModule("TestModule{$i}");
    }
    
    $loadTime = microtime(true) - $startTime;
    
    expect($loadTime)->toBeLessThan(1.0); // Max 1 secondo per 10 moduli
});
```

## CI/CD per Modulo Xot

### GitHub Actions

```yaml
name: Xot Core Framework Tests

on: [push, pull_request]

jobs:
  core-tests:
    runs-on: ubuntu-latest
    
    strategy:
      matrix:
        php-version: [8.1, 8.2, 8.3]
        
    steps:
    - uses: actions/checkout@v2
    
    - name: Setup PHP ${{ matrix.php-version }}
      uses: shivammathur/setup-php@v2
      with:
        php-version: ${{ matrix.php-version }}
        extensions: mbstring, xml, ctype, iconv, intl, pdo_sqlite
        
    - name: Install dependencies
      run: composer install --prefer-dist --no-interaction
      
    - name: Run Xot Core Tests
      run: ./vendor/bin/pest Modules/Xot/tests/ --coverage --min=90
      
    - name: Test Framework Compatibility
      run: ./vendor/bin/pest Modules/Xot/tests/ --group=compatibility
```

## Quality Gates Framework

### Pre-Release Checklist

- [ ] **Core Stability**: Tutti i test core passano su PHP 8.1+
- [ ] **Backward Compatibility**: Nessuna breaking change non documentata
- [ ] **Performance**: Benchmark rispettati per servizi core
- [ ] **Memory Usage**: Nessun memory leak in operazioni ripetitive
- [ ] **Documentation**: Tutti i trait e servizi documentati

### Regression Testing

```php
test('framework maintains backward compatibility', function (): void {
    // Test che API pubbliche del framework non cambino
    expect(class_exists('Modules\Xot\Models\Traits\HasXotTable'))->toBeTrue();
    expect(interface_exists('Modules\Xot\Contracts\BaseDataContract'))->toBeTrue();
    
    // Test che metodi pubblici esistano ancora
    $hasXotTable = new ReflectionClass('Modules\Xot\Models\Traits\HasXotTable');
    expect($hasXotTable->hasMethod('getTable'))->toBeTrue();
});
```

## Esecuzione Test

### Comandi Base

```bash

# Tutti i test del framework Xot
./vendor/bin/pest Modules/Xot/tests/

# Solo test unitari
./vendor/bin/pest Modules/Xot/tests/Unit/

# Solo test di integrazione
./vendor/bin/pest Modules/Xot/tests/Feature/

# Test specifico
./vendor/bin/pest Modules/Xot/tests/Unit/MetatagDataTest.php

# Con coverage (target 90%+)
./vendor/bin/pest Modules/Xot/tests/ --coverage --min=90

# Performance tests
./vendor/bin/pest Modules/Xot/tests/ --group=performance
```

### Debugging Framework

```bash

# Test in modalità debug
./vendor/bin/pest Modules/Xot/tests/ --debug

# Test con profiling
./vendor/bin/pest Modules/Xot/tests/ --profile

# Memory usage tracking
./vendor/bin/pest Modules/Xot/tests/ --memory
```

## Troubleshooting

### Errori Comuni Framework

1. **"Module not found"**: Verificare registrazione moduli in test
2. **"Trait method conflict"**: Controllare ordine use dei trait
3. **"Config not loaded"**: Verificare bootstrap in CreatesApplication
4. **"Cache driver error"**: Usare 'array' driver nei test

### Memory e Performance Issues

```php
// Test per memory leaks
test('no memory leaks in repeated operations', function (): void {
    $startMemory = memory_get_usage();
    
    for ($i = 0; $i < 1000; $i++) {
        $data = MetatagData::from(createTestMetatag());
        unset($data); // Force garbage collection
    }
    
    $endMemory = memory_get_usage();
    $memoryIncrease = $endMemory - $startMemory;
    
    // Acceptable memory increase < 1MB
    expect($memoryIncrease)->toBeLessThan(1024 * 1024);
});
```

## Links di Riferimento

### Internal Documentation
- [Root Testing Organization](../../../project_docs/testing-organization.md)
- [<nome progetto> Testing Guidelines](../../<nome progetto>/project_docs/testing.md)
- [Cms Testing Guidelines](../../Cms/project_docs/testing.md)

### Framework Documentation
- [Xot Framework Architecture](./architecture.md)
- [Module Development Guide](./module-development.md)
- [Core Services Documentation](./core-services.md)

### External Resources
- [Pest Documentation](https://pestphp.com/)
- [Laravel Testing](https://laravel.com/project_docs/testing)
- [Spatie Laravel Data](https://spatie.be/project_docs/laravel-data)

---

**Ultimo aggiornamento**: Dicembre 2024  
**Framework**: Pest v2.x  
**Coverage Target**: 90%+ per core framework  
