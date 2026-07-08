# 🧪 Code Quality - PHPStan, Testing e Standards

> **FONDAMENTALE**: Il codice PTVX deve passare controlli di qualità rigorosi prima del merge.

## 🔥 PHPStan Level 10 - Massima Strictness

### Configurazione PHPStan
PTVX usa PHPStan al massimo livello di strictness (Level 10) per garantire qualità del codice.

### Esecuzione PHPStan
```bash
# Analisi completa
./vendor/bin/phpstan analyze

# Analisi per modulo specifico
./vendor/bin/phpstan analyze Modules/MyModule

# Analisi con cache
./vendor/bin/phpstan analyze --memory-limit=2G

# Baseline per errori legacy
./vendor/bin/phpstan analyze --generate-baseline
```

### Regole PHPStan Critiche
```php
<?php

declare(strict_types=1); // OBBLIGATORIO

namespace Modules\MyModule\Services;

use Illuminate\Database\Eloquent\Collection;
use Modules\MyModule\Models\MyModel;

// ✅ Typing rigoroso
class MyService
{
    public function __construct(
        private readonly MyRepository $repository
    ) {}
    
    // ✅ Return type OBBLIGATORIO
    public function findById(int $id): ?MyModel
    {
        return $this->repository->findById($id);
    }
    
    // ✅ Parametri tipizzati
    public function create(array $data): MyModel
    {
        return $this->repository->create($data);
    }
    
    // ✅ Collection tipizzata
    public function getAll(): Collection
    {
        return $this->repository->all();
    }
}
```

### Errori PHPStan Comuni
```php
// ❌ Missing return type
function processData($data) {
    return $processed;
}

// ✅ Con return type
function processData(array $data): array {
    return $processed;
}

// ❌ Untyped parameters
function createUser($name, $email) {
    // ...
}

// ✅ Typed parameters
function createUser(string $name, string $email): User {
    // ...
}

// ❌ Mixed type senza controllo
function processValue($value) {
    return $value * 2;
}

// ✅ Type checking esplicito
function processValue(mixed $value): int {
    if (!is_numeric($value)) {
        throw new InvalidArgumentException('Value must be numeric');
    }
    return (int) $value * 2;
}
```

---

## 🧪 Testing con Pest

### Structure Test
```php
<?php

declare(strict_types=1);

use Modules\MyModule\Models\MyModel;
use Modules\MyModule\Actions\CreateMyModelAction;
use Modules\MyModule\Data\MyData;

// ✅ Test features con descrizioni chiare
it('can create a model with valid data', function () {
    $data = MyData::from([
        'name' => 'Test Model',
        'email' => 'test@example.com',
    ]);
    
    $model = app(CreateMyModelAction::class)->execute($data);
    
    expect($model)
        ->toBeInstanceOf(MyModel::class)
        ->name->toBe('Test Model')
        ->email->toBe('test@example.com');
});

it('throws validation exception with invalid data', function () {
    $data = MyData::from([
        'name' => '', // Invalid: empty
        'email' => 'invalid-email', // Invalid: not email
    ]);
    
    app(CreateMyModelAction::class)->execute($data);
})->throws(ValidationException::class);
```

### Unit Test Pattern
```php
<?php

declare(strict_types=1);

use Modules\MyModule\Services\MyService;
use Modules\MyModule\Repositories\MyRepositoryInterface;

// ✅ Unit test con mock
it('calculates correct total', function () {
    $repository = Mockery::mock(MyRepositoryInterface::class);
    $repository->shouldReceive('getAll')
        ->once()
        ->andReturn(collect([
            ['price' => 100],
            ['price' => 200],
            ['price' => 300],
        ]));
    
    $service = new MyService($repository);
    
    $total = $service->calculateTotal();
    
    expect($total)->toBe(600);
});
```

### Feature Test Pattern
```php
<?php

declare(strict_types=1);

use Modules\User\Models\User;
use Modules\MyModule\Models\MyModel;
use Modules\MyModule\Filament\Resources\MyResource\Pages\ListMyRecords;

// ✅ Filament test
it('can view my models list', function () {
    $user = User::factory()->create();
    $models = MyModel::factory()->count(5)->create();
    
    actingAs($user)
        ->get(MyResource::getUrl('index'))
        ->assertSuccessful()
        ->assertSee($models->first()->name);
});

// ✅ CRUD test
it('can create a new model', function () {
    $user = User::factory()->create();
    
    actingAs($user)
        ->get(MyResource::getUrl('create'))
        ->assertSuccessful();
    
    $newModel = [
        'name' => 'New Model',
        'email' => 'new@example.com',
    ];
    
    actingAs($user)
        ->post(MyResource::getUrl('store'), $newModel)
        ->assertRedirect();
    
    $this->assertDatabaseHas('my_models', $newModel);
});
```

---

## 📏 PSR-12 Code Style

### Formattazione Automatica
```bash
# Formatta tutto il progetto
./vendor/bin/pint

# Formatta solo un file
./vendor/bin/pint app/Models/User.php

# Formatta modulo specifico
./vendor/bin/pint Modules/MyModule
```

### Regole PSR-12 Fondamentali
```php
<?php

declare(strict_types=1);

namespace Modules\MyModule\Services;

use Modules\MyModule\Repositories\MyRepositoryInterface;

// ✅ Class declaration
class MyService
{
    // ✅ Properties with visibility
    private MyRepositoryInterface $repository;
    
    // ✅ Constructor property promotion
    public function __construct(
        private readonly MyRepositoryInterface $repository
    ) {}
    
    // ✅ Method with proper typing
    public function processData(array $data): array
    {
        // ✅ Proper indentation (4 spaces)
        if (empty($data)) {
            return [];
        }
        
        // ✅ Line length under 120 characters
        $processedData = array_map(
            fn (array $item): array => $this->processItem($item),
            $data
        );
        
        return $processedData;
    }
    
    // ✅ Private/protected methods after public
    private function processItem(array $item): array
    {
        return $item;
    }
}
```

---

## 🔍 PHPMD - Mess Detector

### Esecuzione PHPMD
```bash
# Analisi completa
./vendor/bin/phpmd . text phpmd-ruleset.xml

# Analisi modulo specifico
./vendor/bin/phpmd Modules/MyModule text phpmd-ruleset.xml

# Output in altri formati
./vendor/bin/phpmd . json phpmd-ruleset.xml > report.json
```

### Problemi PHPMD Comuni
```php
// ❌ Classe troppo complessa (CC > 10)
class ComplexService {
    public function complexMethod() {
        if ($condition1) {
            if ($condition2) {
                if ($condition3) {
                    // Troppo nidificato!
                }
            }
        }
    }
}

// ✅ Metodo semplice e leggibile
class SimpleService {
    public function simpleMethod() {
        if (!$this->isValidCondition()) {
            return $this->getDefaultResult();
        }
        
        return $this->processResult();
    }
    
    private function isValidCondition(): bool {
        return $this->condition1 && $this->condition2;
    }
}
```

---

## 📊 PHPInsights

### Esecuzione Insights
```bash
# Analisi completa
./vendor/bin/phpinsights

// Analisi modulo specifico
./vendor/bin/phpinsights analyse Modules/MyModule

// Fix automatici
./vendor/bin/phpinsights fix
```

### Metriche Qualità
- **Code**: Complessità ciclomatica, mantenibilità
- **Architecture**: Accoppiamento, coesione
- **Style**: Conformità PSR-12
- **Security**: Vulnerabilità comuni

---

## 📋 Quality Checklist Pre-Commit

### PHPStan
- [ ] Level 10 passa: `./vendor/bin/phpstan analyze`
- [ ] Nessun errore, solo warnings giustificati
- [ ] Typing rigoroso ovunque
- [ ] Return types su tutti i metodi

### Testing
- [ ] Test passano: `php artisan test`
- [ ] Coverage > 80% per codice critico
- [ ] Unit test per logica business
- [ ] Feature test per flussi utente

### Code Style
- [ ] Pint formatta: `./vendor/bin/pint`
- [ ] PSR-12 compliant
- [ ] Nessun warning PHPMD
- [ ] PHPInsights score > 8.0

### Security
- [ ] Nessuna hardcoded secret
- [ ] Input validation appropriata
- [ ] Authorization policies implementate
- [ ] SQL injection prevention

---

## 🚀 Quality Pipeline

### Comando Quality Completo
```bash
#!/bin/bash
# quality-check.sh

echo "🔍 Running PHPStan Level 10..."
./vendor/bin/phpstan analyze || exit 1

echo "🎨 Running Pint formatter..."
./vendor/bin/pint || exit 1

echo "🧪 Running Tests..."
php artisan test || exit 1

echo "📊 Running PHPMD..."
./vendor/bin/phpmd . text phpmd-ruleset.xml || exit 1

echo "📈 Running PHPInsights..."
./vendor/bin/phpinsights || exit 1

echo "✅ All quality checks passed!"
```

### Pre-commit Hook
```bash
#!/bin/bash
# .git/hooks/pre-commit

./vendor/bin/pint
./vendor/bin/phpstan analyze --no-progress
php artisan test --no-coverage
```

---

## 📚 Riferimenti Correlati

- [Core Rules](core.md) - Regole di sviluppo
- [Architecture Rules](architecture-rules.md) - Pattern architetturali
- [Testing Best Practices](framework-specifics.md#testing) - Testing frameworks

---

**Versione**: 3.0 (Refactor DRY + KISS)  
**Priorità**: ⚡ ALTA - Qualità del codice obbligatoria  
**Aggiornamento**: Dicembre 2025

> **💡 Principio**: "Codice che non passa PHPStan Level 10 non entra in produzione" - Qualità non negoziabile.