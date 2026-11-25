---
title: "Topic phpstan-fixes"
type: digest
status: active
qmd: "digest ceiling 100 phpstan-fixes"
---

# Topic phpstan-fixes

Sintesi automatica di 3 documenti (chiave `phpstan-fixes`).

## Correzioni PHPStan per il Modulo Activity

_Fonte: `phpstan-fixes-1.md`_

# Correzioni PHPStan per il Modulo Activity

## Panoramica

Il modulo Activity ha raggiunto un livello PHPStan 9, dimostrando un'elevata qualità del codice. Questo documento descrive le correzioni apportate per risolvere gli errori trovati al livello 10 e fornisce linee guida per il mantenimento di un alto standard di qualità del codice.

## Problemi Risolti

### 1. Errori nelle Migrazioni

#### Problema
Le chiamate a metodi su variabili `$table` di tipo mixed nelle migrazioni causavano errori perché PHPStan non poteva determinare il tipo corretto dell'oggetto:

```php
$table->bigIncrements('id');   // Cannot call method bigIncrements() on mixed.
```

#### Soluzione Implementata
È stata aggiunta un'annotazione di tipo esplicita per le funzioni di callback utilizzate nelle migrazioni:

```php
/**
 * @param Blueprint $table
 */
function (Blueprint $table) {
    $table->bigIncrements('id');
    // ...
}
```

## Correzioni PHPStan - Modulo Activity

_Fonte: `phpstan-fixes-activity-1.md`_

# Correzioni PHPStan - Modulo Activity

## 🚨 Errori PHPStan Risolti

### 1. StoredEventFactory.php - Type Safety
**Errore**: `array_merge` con parametri mixed invece di array
**Soluzione**: Cast esplicito per garantire type safety

```php
// ✅ CORRETTO
'event_properties' => array_merge(
    is_array($attributes['event_properties'] ?? []) ? $attributes['event_properties'] : [],
    [
        'user_id' => $this->faker->numberBetween(1, 100),
        'action' => 'user_registered',
    ]
),
```

### 2. ActivityMassSeeder.php - Factory Method
**Errore**: `Activity::factory()` metodo non trovato
**Soluzione**: Utilizzo diretto della factory class

```php
// ✅ CORRETTO
$activities = \Modules\Activity\Database\Factories\ActivityFactory::new()
    ->count(2000)
    ->create([
        'created_at' => Carbon::now()->subDays(rand(1, 90)),
    ]);

## phpstan-fixes

_Fonte: `phpstan-fixes.md`_

See canonical documentation: ../../../Themes/docs/shared-components/.gitkeep-Modules
