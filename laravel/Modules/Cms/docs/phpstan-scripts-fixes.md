# PHPStan Level 10 - Scripts Utility Fixes

**Modulo**: Cms  
**Livello PHPStan**: 10  
**Status**: 🔄 **IN PROGRESSO** (65.6% completato)

---

## 📊 Executive Summary

**Errori iniziali**: 32  
**Errori risolti**: 21  
**Errori rimanenti**: 11  
**Progresso**: 65.6% ✅

---

## ✅ Fix Applicati

### `generate_test_data.php` - 21/22 errori risolti

#### 1. Type Narrowing per `$app` (Riga 31)

**Pattern Applicato**:
```php
// PRIMA
$app = require_once __DIR__.'/laravel/bootstrap/app.php';
$app->make(Kernel::class)->bootstrap();

// DOPO
/** @var \Illuminate\Contracts\Foundation\Application $app */
$app = require_once __DIR__.'/laravel/bootstrap/app.php';
assert($app instanceof \Illuminate\Contracts\Foundation\Application);
$app->make(Kernel::class)->bootstrap();
```

**Lezione**: Type narrowing con PHPDoc + `assert()` per garantire type safety.

---

#### 2. Type Assertions per Foreach Iterabili (Righe 81, 157, 188)

**Pattern Applicato**:
```php
// PRIMA
foreach ($this->businessModels as $module => $models) {
    foreach ($models as $modelName => $factoryClass) {
        // ...
    }
}

// DOPO
foreach ($this->businessModels as $module => $models) {
    /** @var string $module */
    /** @var array<string, string> $models */
    foreach ($models as $modelName => $factoryClass) {
        /** @var string $modelName */
        /** @var string $factoryClass */
        // ...
    }
}
```

**Lezione**: PHPDoc inline per type narrowing in foreach loops.

---

#### 3. Type Assertions per Array Access (Righe 99, 130, 137, 158, 162, 164, 166)

**Pattern Applicato**:
```php
// PRIMA
$this->results[$module][$modelName] = ['status' => 'success', ...];

// DOPO
/** @var array{status: string, count: int, factory: string} $resultData */
$resultData = ['status' => 'success', ...];
/** @var array<string, array{status: string, ...}> $moduleResults */
$moduleResults = $this->results[$module] ?? [];
$moduleResults[$modelName] = $resultData;
$this->results[$module] = $moduleResults;
```

**Lezione**: Evitare accesso diretto a array nested, usare variabili intermedie con type assertions.

---

#### 4. Type Narrowing per Factory Calls (Righe 109, 125)

**Pattern Applicato**:
```php
// PRIMA
$factory = new $factoryClass();
$records = $factory->count(100)->create();

// DOPO
/** @var object $factory */
$factory = new $factoryClass();
if (method_exists($factory, 'count')) {
    /** @var \Illuminate\Database\Eloquent\Collection<int, \Illuminate\Database\Eloquent\Model>|array<int, \Illuminate\Database\Eloquent\Model> $records */
    $records = $factory->count(100)->create();
} else {
    // Fallback con call_user_func
    $record = call_user_func([$factory, 'create']);
}
```

**Lezione**: Usare `call_user_func` per evitare errori "method on mixed" quando il tipo non può essere inferito.

---

#### 5. Casting Esplicito per Stringhe (Righe 159, 162, 166, 193, 194)

**Pattern Applicato**:
```php
// PRIMA
echo "Model: $modelName";
echo "Count: {$result['count']}";

// DOPO
/** @var string $modelName */
/** @var int $count */
$count = $result['count'] ?? 0;
echo "Model: {$modelName}";
echo "Count: {$count}";
```

**Lezione**: Estrarre variabili con type assertions prima dell'interpolazione.

---

## ⏳ Errori Rimanenti

### `generate_test_data.php` - 1 errore

**Riga 122**: `Cannot call method create() on mixed`

**Causa**: PHPStan non può inferire il tipo del risultato di `count(100)`.

**Tentativi**:
1. ❌ Type assertion `object&callable` - Non risolve
2. ❌ `call_user_func` - Non risolve
3. ❌ Type narrowing con `method_exists` - Non sufficiente

**Prossimi Passi**: Usare interfaccia o trait che definisca il tipo del factory.

---

### `populate_database_comprehensive.php` - 10 errori

**Pattern simili a `generate_test_data.php`**:
- Type narrowing per `$app` (riga 35)
- Type narrowing per factory calls (righe 81, 117, 119, 194)
- Type assertions per array access (righe 233, 240, 241)

**Strategia**: Applicare gli stessi pattern già testati in `generate_test_data.php`.

---

## 📚 Pattern Riusabili

### Pattern 1: Type Narrowing per Application Bootstrap

```php
/** @var \Illuminate\Contracts\Foundation\Application $app */
$app = require_once __DIR__.'/laravel/bootstrap/app.php';
assert($app instanceof \Illuminate\Contracts\Foundation\Application);
$app->make(Kernel::class)->bootstrap();
```

### Pattern 2: Type Assertions per Array Nested

```php
/** @var array{key: type} $data */
$data = ['key' => 'value'];
/** @var array<string, array{key: type}> $parent */
$parent = $this->results[$module] ?? [];
$parent[$subKey] = $data;
$this->results[$module] = $parent;
```

### Pattern 3: Type Narrowing per Foreach

```php
foreach ($array as $key => $value) {
    /** @var string $key */
    /** @var ExpectedType $value */
    // ...
}
```

### Pattern 4: Factory Calls con Type Safety

```php
/** @var object $factory */
$factory = new $factoryClass();
if (method_exists($factory, 'count')) {
    /** @var Collection|array $records */
    $records = $factory->count(100)->create();
} else {
    $record = call_user_func([$factory, 'create']);
}
```

---

## ✅ Verifica Post-Fix

```bash
# PHPStan Level 10
./vendor/bin/phpstan analyse Modules/Cms/generate_test_data.php --level=10
./vendor/bin/phpstan analyse Modules/Cms/populate_database_comprehensive.php --level=10

# Sintassi PHP
php -l Modules/Cms/generate_test_data.php
php -l Modules/Cms/populate_database_comprehensive.php
```

---

## 🎯 Obiettivo Finale

**Target**: ✅ **0 errori PHPStan Level 10** per tutti gli script utility

**Benefici**:
- ✅ Type safety completa
- ✅ Codice più robusto e manutenibile
- ✅ Prevenzione bug runtime
- ✅ Migliore developer experience

---

**Status**: 🔄 **IN PROGRESSO** (65.6% completato)

**Ultimo aggiornamento**: [DATE]
