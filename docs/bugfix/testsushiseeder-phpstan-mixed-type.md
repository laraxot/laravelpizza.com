# Bugfix: TestSushiSeeder PHPStan Mixed Type Errors

**Data Fix**: 11 Novembre 2025
**Status**: ✅ RISOLTO

## Problema

**Errori PHPStan Level 10**:

```
Line 62: Cannot call method create() on mixed. (method.nonObject)
Line 67: Cannot call method count() on mixed. (method.nonObject)
Line 67: Cannot call method create() on mixed. (method.nonObject)
```

## Causa Radice

**Type Inference Failure con Generics**:

PHPStan Level 10 non riusciva a inferire il tipo corretto quando si usava il generic type `Factory<TestSushiModel>` nei PHPDoc.

```php
// ❌ PRIMA - PHPStan non capisce che Factory<T> ha create() e count()
/** @var \Illuminate\Database\Eloquent\Factories\Factory<TestSushiModel> $factory */
$factory = TestSushiModel::factory();
\Webmozart\Assert\Assert::methodExists($factory, 'create', 'Factory must have create method');
$factory->create($data);
```

**Problema**:
- Generic type `Factory<TestSushiModel>` non è abbastanza specifico per PHPStan L10
- Webmozart Assert controlla runtime, non aiuta analisi statica
- PHPStan tratta `factory()` come ritorno `mixed`

## Soluzione Applicata

### 1. Usare Tipo Specifico invece di Generic

```php
// ✅ DOPO - Tipo specifico riconosciuto da PHPStan
/** @var \Modules\Tenant\Database\Factories\TestSushiModelFactory $factory */
$factory = TestSushiModel::factory();
$factory->create($data);
```

**Vantaggi**:
- PHPStan capisce che `TestSushiModelFactory extends Factory`
- Tutti i metodi ereditati sono riconosciuti
- Nessun bisogno di Assert runtime (più pulito)

### 2. Semplificazione Codice

**Prima** (15 righe con Assert e variabili intermedie):
```php
foreach ($testData as $data) {
    /** @var \Illuminate\Database\Eloquent\Factories\Factory<TestSushiModel> $factory */
    $factory = TestSushiModel::factory();
    \Webmozart\Assert\Assert::methodExists($factory, 'create', 'Factory must have create method');
    $factory->create($data);
}

if (app()->environment(['local', 'development'])) {
    /** @var \Illuminate\Database\Eloquent\Factories\Factory<TestSushiModel> $factory */
    $factory = TestSushiModel::factory();
    \Webmozart\Assert\Assert::methodExists($factory, 'count', 'Factory must have count method');
    \Webmozart\Assert\Assert::methodExists($factory, 'create', 'Factory must have create method');

    /** @var \Illuminate\Database\Eloquent\Factories\Factory<TestSushiModel> $countedFactory */
    $countedFactory = $factory->count(10);
    $countedFactory->create();
}
```

**Dopo** (10 righe senza Assert ridondanti):
```php
foreach ($testData as $data) {
    /** @var \Modules\Tenant\Database\Factories\TestSushiModelFactory $factory */
    $factory = TestSushiModel::factory();
    $factory->create($data);
}

if (app()->environment(['local', 'development'])) {
    /** @var \Modules\Tenant\Database\Factories\TestSushiModelFactory $factory */
    $factory = TestSushiModel::factory();
    $factory->count(10)->create();
}
```

**Miglioramenti**:
- ✅ -5 righe (-33% codice)
- ✅ Rimossi Assert ridondanti
- ✅ Fluent chain supportato
- ✅ PHPStan Level 10 compliant

## Pattern PHPStan Level 10

### Generic Types vs Concrete Types

| Approach | PHPStan L10 | Leggibilità | Manutenibilità |
|----------|-------------|-------------|----------------|
| `Factory<T>` | ❌ Non capisce | 🟡 Generico | 🟡 Richiede Assert |
| `SpecificFactory` | ✅ Capisce | ✅ Esplicito | ✅ Self-documenting |

### Regola Generale

**Quando PHPStan non inferisce correttamente il tipo**:
1. Usa il tipo concreto più specifico possibile
2. Evita generics nei PHPDoc se il tipo concreto è disponibile
3. Rimuovi Assert ridondanti se il tipo garantisce i metodi

## Struttura Factory Corretta

```php
// Modello
class TestSushiModel extends Model
{
    use HasXotFactory;

    /**
     * @method static TestSushiModelFactory factory($count = null, $state = [])
     */
}

// Factory
/**
 * @extends Factory<TestSushiModel>
 */
class TestSushiModelFactory extends Factory
{
    protected $model = TestSushiModel::class;

    public function definition(): array { /* ... */ }
}

// Seeder - ✅ CORRETTO
/** @var TestSushiModelFactory $factory */
$factory = TestSushiModel::factory();
$factory->create($data);
```

## Verifica

```bash
./vendor/bin/phpstan analyse Modules/Tenant/database/seeders/TestSushiSeeder.php --level=10
```

**Output**: ✅ `[OK] No errors`

## Best Practices

### 1. Type Hints Specifici

```php
// ❌ Generico - PHPStan può non capire
/** @var Factory<Model> $factory */

// ✅ Specifico - PHPStan sempre capisce
/** @var ModelFactory $factory */
```

### 2. Evitare Assert Ridondanti

```php
// ❌ Assert inutile con tipo specifico
/** @var ModelFactory $factory */
$factory = Model::factory();
Assert::methodExists($factory, 'create'); // Ridondante!

// ✅ Tipo specifico garantisce metodi
/** @var ModelFactory $factory */
$factory = Model::factory();
$factory->create(); // PHPStan sa che esiste
```

### 3. Fluent Chains

```php
// ✅ OK con tipo esplicito
/** @var ModelFactory $factory */
$factory = Model::factory();
$factory->count(10)->state(['active' => true])->create();
```

## Filosofia Laraxot

- ✅ **Type Safety**: Tipi espliciti e specifici
- ✅ **KISS**: Rimuovi complessità inutile (Assert)
- ✅ **PHPStan Level 10**: Zero errori, zero compromessi
- ✅ **Self-Documenting**: Tipo specifico documenta intent

## Riferimenti

- [PHPStan Generics](https://phpstan.org/blog/generics-in-php-using-phpdocs)
- [Laravel Factories](https://laravel.com/docs/eloquent-factories)
- [Webmozart Assert](https://github.com/webmozarts/assert)

---

**Risultato**: 3 errori PHPStan → 0 errori ✅
**Codice**: 15 righe → 10 righe (-33%) ✅
**Complessità**: Ridotta (rimossi Assert) ✅
