# Analisi PHPStan per il modulo Chart

Data: Wed Jan 8 10:42:39 CEST 2025

## Riassunto

| Livello | Stato | Errori |
|---------|-------|--------|
| 9 | ✅ Successo | Nessun errore |

## Panoramica
Questo documento descrive l'analisi statica del codice tramite PHPStan per il modulo Chart, inclusi i livelli di analisi, gli errori comuni e le soluzioni implementate.

## Struttura della Documentazione

Questa cartella contiene l'analisi statica del codice eseguita con PHPStan per il modulo Chart.

## File di Configurazione

- `phpstan.neon.dist`: Configurazione principale di PHPStan
- `phpstan-baseline.neon`: Baseline degli errori noti
- `analysis.json`: Risultati dell'analisi corrente

## Come Eseguire l'Analisi

```bash
cd laravel/Modules/Chart
composer install
vendor/bin/phpstan analyse --error-format=json > docs/phpstan/analysis.json
```

## Correzioni Recenti

### Metodo getSettings() - Chart Model
**Data**: 8 Gennaio 2025
**Problema**: Errori di tipizzazione PHPStan livello 9
- `Method should return array<string, array<int|string, mixed>> but returns array<mixed>`
- `PHPDoc tag @var with type array<string, array<int|string, mixed>> is not subtype of native type array{mixed}`

**Soluzione**: 
- Corretta la tipizzazione del return type da `array<string, array<int|string, mixed>>` a `array<string, array<string, mixed>>`
- Rimossa la tipizzazione ridondante `array<int|string, mixed>` che causava conflitti
- Aggiunta documentazione PHPDoc completa per il metodo
- Verificata compatibilità con PHPStan livello 9

**File**: `app/Models/Chart.php` - metodo `getSettings()`

## Livelli di Analisi

### [Livello 0](./level_0.md) - Base
- Controlli di base
- Errori di sintassi
- Chiamate a funzioni inesistenti

### [Livello 1](./level_1.md) - Tipi Base
- Type hints base
- Return types
- Parametri obbligatori

### [Livello 2](./level_2.md) - Controlli Avanzati
- Controlli di tipo più stretti
- Null checks
- Array shapes

### [Livello 3](./level_3.md) - Proprietà
- Proprietà di classe
- Proprietà dinamiche
- Proprietà statiche

### [Livello 4](./level_4.md) - Type Inference
- Type inference base
- Operatori
- Costrutti di controllo

### [Livello 5](./level_5.md) - Types
- Controlli di tipo completi
- Generics
- Template types

### [Livello 6](./level_6.md) - Signatures
- Signatures di metodi
- Ereditarietà
- Interfacce

### [Livello 7](./level_7.md) - Union Types
- Union types
- Intersection types
- Template type variance

### [Livello 8](./level_8.md) - Magic
- Magic methods
- Magic properties
- Dynamic calls

### [Livello 9](./level_9.md) - Strict
- Strict types
- Strict properties
- Strict methods

## Configurazione

### phpstan.neon
```yaml
parameters:
    level: 9
    paths:
        - app
    excludePaths:
        - app/Filament/Pages
        - build
        - vendor
        - Tests
    ignoreErrors:
        - '#Unsafe usage of new static#'
        - '#Access to an undefined property#'
        - '#Call to an undefined method#'
```

## Errori Comuni

### 1. Type Hints Mancanti
```php
// ❌ NON FARE QUESTO
function getData($id) {
    return Chart::find($id);
}

// ✅ FARE QUESTO
function getData(int $id): ?Chart {
    return Chart::find($id);
}
```

### 2. Array Type Specifications (RISOLTO: 2025-01-06)
```php
// ❌ NON FARE QUESTO
/** @return array<string, array<int|string, mixed>> */
public function getSettings(): array {
    return $mixed->charts->toArray(); // Collection->toArray() restituisce array<mixed>
}

// ✅ FARE QUESTO
/** @return array<int, array<string, mixed>> */
public function getSettings(): array {
    /** @var array<int, array<string, mixed>> $chartsArray */
    $chartsArray = $mixed->charts->toArray();
    return $chartsArray;
}
```

### 3. Null Safety
```php
// ❌ NON FARE QUESTO
$chart->title = $request->title;

// ✅ FARE QUESTO
$chart->title = $request->title ?? $chart->title;
```

### 4. Return Types
```php
// ❌ NON FARE QUESTO
public function getChartData() {
    return $this->data;
}

// ✅ FARE QUESTO
public function getChartData(): array {
    return $this->data;
}
```

## Best Practices

### 1. Type Declarations
- Usare sempre type hints
- Specificare return types
- Utilizzare nullable types quando appropriato

### 2. PHPDoc
- Documentare parametri complessi
- Specificare tipi generici
- Mantenere documentazione aggiornata

### 3. Testing
- Scrivere test per casi edge
- Verificare null safety
- Testare type conversions

## Risoluzione Problemi

### Analisi
```bash

# Analisi completa
php artisan phpstan:analyse

# Analisi specifica
php artisan phpstan:analyse app/Models/Chart.php

# Debug
php artisan phpstan:analyse --debug
```

### Fixing
```bash

# Fix automatici
php artisan phpstan:fix

# Fix specifici
php artisan phpstan:fix app/Models/Chart.php
```

### Fix Documentati
- [Chart getSettings() Array Types](./chart-getsettings-fix.md) - Risoluzione errori array type specifications (2025-01-06)

## Collegamenti Bidirezionali

### Collegamenti ad Altri Moduli
- [PHPStan User](../../User/docs/phpstan/README.md)
- [PHPStan Activity](../../Activity/docs/phpstan/README.md)
- [PHPStan Xot](../../Xot/docs/phpstan/README.md)

### Collegamenti Interni
- [README Principale](../README.md)
- [Implementazione](../implementation.md)
- [Testing](../testing.md)
- [Performance](../performance/README.md)

## Collegamenti tra versioni di README.md
* [README.md](../../../../../bashscripts/docs/README.md)
* [README.md](../../../../../bashscripts/docs/it/README.md)
* [README.md](../../../../../docs/laravel-app/phpstan/README.md)

## Collegamenti

- [README Chart](../README.md)
- [Documentazione <nome progetto>](/docs/README.md)
- [Regole PHPStan Globali](/docs/phpstan_usage.md)
