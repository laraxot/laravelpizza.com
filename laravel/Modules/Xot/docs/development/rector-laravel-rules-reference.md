# Rector Laravel - Reference Completo Regole e Set

> **File**: `Modules/Xot/docs/development/rector-laravel-rules-reference.md`  
> **Ultimo aggiornamento**: Gennaio 2025  
> **Status**: ✅ Active  
> **Riferimento**: https://github.com/driftingly/rector-laravel

## 🎯 Panoramica

Questa guida documenta tutte le regole e i set disponibili in **Rector Laravel**, l'estensione di Rector specifica per progetti Laravel.

## 📦 Installazione

```bash
# Installazione via Composer
composer require --dev driftingly/rector-laravel

# Verifica installazione
./vendor/bin/rector --version
```

## 🔧 Set di Regole Disponibili

### Laravel Version Sets

#### Laravel 8.0

```php
use RectorLaravel\Set\LaravelSetList;

$rectorConfig->sets([
    LaravelSetList::LARAVEL_80,
]);
```

**Regole incluse**:
- Migrazione da Laravel 7.x a 8.x
- Aggiornamento middleware
- Aggiornamento route model binding
- Aggiornamento facades

#### Laravel 9.0

```php
$rectorConfig->sets([
    LaravelSetList::LARAVEL_90,
]);
```

**Regole incluse**:
- Migrazione da Laravel 8.x a 9.x
- Aggiornamento a PHP 8.0+
- Aggiornamento Str facade
- Aggiornamento route caching

#### Laravel 10.0

```php
$rectorConfig->sets([
    LaravelSetList::LARAVEL_100,
]);
```

**Regole incluse**:
- Migrazione da Laravel 9.x a 10.x
- Rimozione deprecazioni
- Aggiornamento a PHP 8.1+
- Aggiornamento validation rules

#### Laravel 11.0

```php
$rectorConfig->sets([
    LaravelSetList::LARAVEL_110,
]);
```

**Regole incluse**:
- Migrazione da Laravel 10.x a 11.x
- Aggiornamento a PHP 8.2+
- Nuove convenzioni Laravel 11
- Aggiornamento service providers

### Code Quality Sets

#### Laravel Code Quality

```php
$rectorConfig->sets([
    LaravelSetList::LARAVEL_CODE_QUALITY,
]);
```

**Regole incluse**:
- Miglioramento type hints
- Rimozione codice morto
- Ottimizzazione query
- Miglioramento performance

#### Laravel Array Str Function to Static Call

```php
$rectorConfig->sets([
    LaravelSetList::LARAVEL_ARRAY_STR_FUNCTION_TO_STATIC_CALL,
]);
```

**Trasformazioni**:
```php
// Prima
array_get($array, 'key');
str_contains($string, 'needle');

// Dopo
\Illuminate\Support\Arr::get($array, 'key');
\Illuminate\Support\Str::contains($string, 'needle');
```

## 📋 Regole Specifiche

### Facade to Dependency Injection

**Regola**: `RectorLaravel\Rector\StaticCall\ReplaceHelperFacadesByBaseTestCaseRector`

```php
// Prima
use Illuminate\Support\Facades\DB;

public function getData()
{
    return DB::table('users')->get();
}

// Dopo
use Illuminate\Database\Connection;

public function __construct(
    private Connection $db
) {}

public function getData()
{
    return $this->db->table('users')->get();
}
```

### Route Model Binding

**Regola**: `RectorLaravel\Rector\MethodCall\ChangeQueryWhereDateValueWithCarbonRector`

```php
// Prima
Route::get('/users/{user}', function ($user) {
    $user = User::findOrFail($user);
});

// Dopo
Route::get('/users/{user}', function (User $user) {
    // $user già risolto
});
```

### Validation Rules

**Regola**: `RectorLaravel\Rector\MethodCall\RedirectRouteToToRouteHelperRector`

```php
// Prima
return redirect()->route('users.index');

// Dopo
return to_route('users.index');
```

### String Helpers

**Regola**: `RectorLaravel\Rector\FuncCall\StrHelperToMethodCallRector`

```php
// Prima
str_contains($string, 'needle');
str_starts_with($string, 'prefix');

// Dopo
\Illuminate\Support\Str::contains($string, 'needle');
\Illuminate\Support\Str::startsWith($string, 'prefix');
```

## 🎯 Configurazione per Modulo Sigma

### File: `Modules/Sigma/rector.php`

```php
<?php

declare(strict_types=1);

use Rector\Config\RectorConfig;
use RectorLaravel\Set\LaravelSetList;
use Rector\Set\ValueObject\LevelSetList;
use Rector\Set\ValueObject\SetList;

return static function (RectorConfig $rectorConfig): void {
    $rectorConfig->paths([
        __DIR__ . '/app',
    ]);

    $rectorConfig->skip([
        __DIR__ . '/vendor',
        __DIR__ . '/docs',
        // Skip trait complessi che richiedono refactoring manuale
        __DIR__ . '/app/Models/Traits/Extras/FunctionExtra.php',
        __DIR__ . '/app/Models/Traits/Extras/MassExtra.php',
    ]);

    $rectorConfig->phpVersion(\Rector\ValueObject\PhpVersion::PHP_83);

    $rectorConfig->sets([
        // Laravel specific sets
        LaravelSetList::LARAVEL_100,
        LaravelSetList::LARAVEL_CODE_QUALITY,
        LaravelSetList::LARAVEL_ARRAY_STR_FUNCTION_TO_STATIC_CALL,
        
        // PHP version sets
        LevelSetList::UP_TO_PHP_83,
        
        // Code quality sets
        SetList::CODE_QUALITY,
        SetList::DEAD_CODE,
        SetList::EARLY_RETURN,
        SetList::TYPE_DECLARATION,
    ]);

    $rectorConfig->importNames();
    $rectorConfig->importShortClasses(false);
};
```

## 🚀 Utilizzo Pratico

### Dry Run (Preview)

```bash
# Preview modifiche senza applicarle
./vendor/bin/rector process Modules/Sigma/app --dry-run --config=Modules/Sigma/rector.php
```

### Applicazione Modifiche

```bash
# Applica modifiche
./vendor/bin/rector process Modules/Sigma/app --config=Modules/Sigma/rector.php
```

### Applicazione Incrementale

```bash
# Applica solo su file specifici
./vendor/bin/rector process Modules/Sigma/app/Models/Scheda.php --config=Modules/Sigma/rector.php

# Applica solo su directory specifica
./vendor/bin/rector process Modules/Sigma/app/Models --config=Modules/Sigma/rector.php
```

## 📊 Pattern di Refactoring Comuni

### Pattern 1: Facade to Dependency Injection

**Problema**: Uso eccessivo di facades

**Prima**:
```php
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cache;

public function getData()
{
    return Cache::remember('key', 3600, function () {
        return DB::table('users')->get();
    });
}
```

**Dopo** (con Rector):
```php
use Illuminate\Database\Connection;
use Illuminate\Contracts\Cache\Repository as CacheRepository;

public function __construct(
    private Connection $db,
    private CacheRepository $cache
) {}

public function getData()
{
    return $this->cache->remember('key', 3600, function () {
        return $this->db->table('users')->get();
    });
}
```

### Pattern 2: String Helpers to Static Calls

**Problema**: Funzioni globali invece di classi

**Prima**:
```php
if (str_contains($string, 'needle')) {
    $result = str_replace('old', 'new', $string);
}
```

**Dopo** (con Rector):
```php
use Illuminate\Support\Str;

if (Str::contains($string, 'needle')) {
    $result = Str::replace('old', 'new', $string);
}
```

### Pattern 3: Type Hints Migliorati

**Problema**: Mancanza di type hints

**Prima**:
```php
public function process($data, $options = null)
{
    // ...
}
```

**Dopo** (con Rector):
```php
public function process(array $data, ?array $options = null): void
{
    // ...
}
```

### Pattern 4: Early Return

**Problema**: Nested if statements

**Prima**:
```php
public function check($value)
{
    if ($value !== null) {
        if ($value > 0) {
            return true;
        }
    }
    return false;
}
```

**Dopo** (con Rector):
```php
public function check($value): bool
{
    if ($value === null) {
        return false;
    }
    
    if ($value <= 0) {
        return false;
    }
    
    return true;
}
```

## 🔍 Regole Specifiche per Modulo Sigma

### Regole Consigliate

```php
$rectorConfig->sets([
    // Laravel specific
    LaravelSetList::LARAVEL_100,
    LaravelSetList::LARAVEL_CODE_QUALITY,
    
    // Type safety
    SetList::TYPE_DECLARATION,
    
    // Code quality
    SetList::CODE_QUALITY,
    SetList::DEAD_CODE,
    
    // Early returns
    SetList::EARLY_RETURN,
]);
```

### Regole da Evitare (per ora)

```php
// Non applicare ancora queste regole su legacy code
// SetList::CODING_STYLE, // Troppo invasivo
// SetList::PRIVATIZATION, // Può rompere codice esistente
```

## 📋 Workflow Consigliato

### Fase 1: Analisi

```bash
# Dry run completo
./vendor/bin/rector process Modules/Sigma/app --dry-run --config=Modules/Sigma/rector.php > rector-preview.txt

# Analizza preview
cat rector-preview.txt | grep -E "would change|would be added"
```

### Fase 2: Applicazione Incrementale

```bash
# Applica solo su file specifici
./vendor/bin/rector process Modules/Sigma/app/Models/Scheda.php --config=Modules/Sigma/rector.php

# Verifica PHPStan dopo ogni applicazione
./vendor/bin/phpstan analyse Modules/Sigma/app/Models/Scheda.php --level=10
```

### Fase 3: Verifica Completa

```bash
# Verifica PHPStan completo
./vendor/bin/phpstan analyse Modules/Sigma --level=10

# Verifica test
php artisan test Modules/Sigma
```

## 🚨 Note Importanti

### File da Non Modificare Automaticamente

1. **FunctionExtra.php**: Richiede refactoring manuale completo
2. **MassExtra.php**: Richiede refactoring manuale completo
3. **File con logica business critica**: Verificare manualmente

### Best Practices

1. **Sempre dry-run prima**: Verifica modifiche prima di applicarle
2. **Commit incrementali**: Applica su piccoli gruppi di file
3. **Verifica PHPStan dopo**: Assicurati che non introduca errori
4. **Test dopo modifiche**: Esegui test per verificare funzionalità

## 🔗 Collegamenti Correlati

- [Guida Generale Mago e Rector](./mago-rector-guide.md)
- [Mago Lexer-Parser Reference](./mago-lexer-parser-reference.md)
- [Utilizzo nel Modulo Sigma](../../Sigma/docs/development/mago-rector-usage.md)
- [PHPStan Workflow](../rules/phpstan-workflow.md)

---

**Ultimo aggiornamento**: Gennaio 2025  
**Versione**: 1.0  
**Status**: ✅ Active  
**Riferimento**: https://github.com/driftingly/rector-laravel

