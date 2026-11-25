---
title: "Topic phpstan-fixes"
type: digest
status: active
qmd: "digest ceiling 100 phpstan-fixes"
---

# Topic phpstan-fixes

Sintesi automatica di 8 documenti (chiave `phpstan-fixes`).

## 🔧 PHPStan Fixes - Modulo Job - Gennaio 2025

_Fonte: `phpstan-fixes-conflict.md`_

# 🔧 PHPStan Fixes - Modulo Job - Gennaio 2025

**Status**: ✅ COMPLETATO CON SUCCESSO
**Errori Corretti**: 1 errore di sintassi constructor

## 📋 Panoramica Correzioni

### ✅ **Errori Risolti**

#### **1. TaskCompleted.php - Sintassi Constructor**
- **File**: `app/Notifications/TaskCompleted.php`
- **Linea**: 53
- **Problema**: Sintassi constructor con proprietà readonly non riconosciuta da PHPStan
- **Soluzione**: Convertito a sintassi tradizionale con proprietà esplicita

**Prima (ERRATO):**
```php
class TaskCompleted extends Notification implements ShouldQueue
{
    use Queueable;

    public function __construct(
        private readonly string $output,
    ) {}
}
```

**Dopo (CORRETTO):**
```php
class TaskCompleted extends Notification implements ShouldQueue

## 🔧 PHPStan Fixes - Modulo Job - Gennaio 2025

_Fonte: `phpstan-fixes-gennaio-archive.md`_

# 🔧 PHPStan Fixes - Modulo Job - Gennaio 2025

**Data**: 27 Gennaio 2025
**Status**: ✅ COMPLETATO CON SUCCESSO
**Errori Corretti**: 1 errore di sintassi constructor

## 📋 Panoramica Correzioni

### ✅ **Errori Risolti**

#### **1. TaskCompleted.php - Sintassi Constructor**
- **File**: `app/Notifications/TaskCompleted.php`
- **Linea**: 53
- **Problema**: Sintassi constructor con proprietà readonly non riconosciuta da PHPStan
- **Soluzione**: Convertito a sintassi tradizionale con proprietà esplicita

**Prima (ERRATO):**
```php
class TaskCompleted extends Notification implements ShouldQueue
{
    use Queueable;

    public function __construct(
        private readonly string $output,
    ) {}
}
```

**Dopo (CORRETTO):**
```php

## 🔧 PHPStan Fixes - Modulo Job - Gennaio 2025

_Fonte: `phpstan-fixes-gennaio.md`_

# 🔧 PHPStan Fixes - Modulo Job - Gennaio 2025

**Data**: 27 Gennaio 2025  
**Status**: ✅ COMPLETATO CON SUCCESSO  
**Errori Corretti**: 1 errore di sintassi constructor

## 📋 Panoramica Correzioni

### ✅ **Errori Risolti**

#### **1. TaskCompleted.php - Sintassi Constructor**
- **File**: `app/Notifications/TaskCompleted.php`
- **Linea**: 53
- **Problema**: Sintassi constructor con proprietà readonly non riconosciuta da PHPStan
- **Soluzione**: Convertito a sintassi tradizionale con proprietà esplicita

**Prima (ERRATO):**
```php
class TaskCompleted extends Notification implements ShouldQueue
{
    use Queueable;

    public function __construct(
        private readonly string $output,
    ) {}
}
```

**Dopo (CORRETTO):**
```php

## 🔧 PHPStan Fixes - Modulo Job - Gennaio 2025

_Fonte: `phpstan-fixes-january-conflict.md`_

# 🔧 PHPStan Fixes - Modulo Job - Gennaio 2025

**Data**: 27 Gennaio 2025
**Status**: ✅ COMPLETATO CON SUCCESSO
**Errori Corretti**: 1 errore di sintassi constructor

## 📋 Panoramica Correzioni

### ✅ **Errori Risolti**

#### **1. TaskCompleted.php - Sintassi Constructor**
- **File**: `app/Notifications/TaskCompleted.php`
- **Linea**: 53
- **Problema**: Sintassi constructor con proprietà readonly non riconosciuta da PHPStan
- **Soluzione**: Convertito a sintassi tradizionale con proprietà esplicita

**Prima (ERRATO):**
```php
class TaskCompleted extends Notification implements ShouldQueue
{
    use Queueable;

    public function __construct(
        private readonly string $output,
    ) {}
}
```

**Dopo (CORRETTO):**
```php

## PHPStan Fixes - Gennaio 2025

_Fonte: `phpstan-fixes-january.md`_

# PHPStan Fixes - Gennaio 2025

## Modulo Job - Correzioni Completate

### File Corretto

**Modules/Job/app/Models/Result.php**

### Errori Risolti

1. **PHPDoc tag @property-read per `$creator`**
   - Prima: `@property-read \Modules\Xot\Contracts\ProfileContract|null $creator`
   - Dopo: `@property-read \Modules\Xot\Contracts\ProfileContract|null $creator`

2. **PHPDoc tag @property-read per `$updater`**
   - Prima: `@property-read \Modules\Xot\Contracts\ProfileContract|null $updater`
   - Dopo: `@property-read \Modules\Xot\Contracts\ProfileContract|null $updater`

3. **PHPDoc tag @method per `factory()`**
   - Verificato che il namespace sia corretto: `\Modules\Job\Database\Factories\ResultFactory`

## Pattern Applicato

### PHPDoc Contracts
- Utilizzare sempre `ProfileContract` invece di `Profile` nei PHPDoc
- Namespace completo per Factory: `Modules\{Module}\Database\Factories\{Model}Factory`

## Risultati

- **Errori PHPStan**: 0

## 🔧 PHPStan Fixes - Modulo Job - Gennaio 2025

_Fonte: `phpstan-fixes-renamed.md`_

# 🔧 PHPStan Fixes - Modulo Job - Gennaio 2025

**Status**: ✅ COMPLETATO CON SUCCESSO
**Errori Corretti**: 1 errore di sintassi constructor

## 📋 Panoramica Correzioni

### ✅ **Errori Risolti**

#### **1. TaskCompleted.php - Sintassi Constructor**
- **File**: `app/Notifications/TaskCompleted.php`
- **Linea**: 53
- **Problema**: Sintassi constructor con proprietà readonly non riconosciuta da PHPStan
- **Soluzione**: Convertito a sintassi tradizionale con proprietà esplicita

**Prima (ERRATO):**
```php
class TaskCompleted extends Notification implements ShouldQueue
{
    use Queueable;

    public function __construct(
        private readonly string $output,
    ) {}
}
```

**Dopo (CORRETTO):**
```php
class TaskCompleted extends Notification implements ShouldQueue

## PHPStan Fixes - Modulo Job

_Fonte: `phpstan-fixes-session.md`_

# PHPStan Fixes - Modulo Job

## 🔄 Status: IN PROGRESS - 49 Errori Rimanenti

**PHPStan Level**: Max
**Errori Risolti**: 58 → 49 (-9 errori) ✅

---

## 📊 Correzioni Implementate

### 1. Rimozione Generic Type da HasXotFactory ✅
**File**: `app/Models/BaseModel.php:23`

### 2. Aggiunta Casts Mancanti in JobBatch ✅
**File**: `app/Models/JobBatch.php` - Aggiunte properties: total_jobs, pending_jobs, failed_jobs, name

### 3. Aggiunta Casts Completi in Task ✅
**File**: `app/Models/Task.php` - 25 properties complete con casts

### 4. Fix Type Safety in autoCleanup() ✅
**File**: `app/Models/Task.php:245` - Type narrowing per auto_cleanup_num e auto_cleanup_type

### 5. Array Associativi in Filament Actions ✅
**File**: `app/Filament/Resources/ScheduleResource/Pages/ListSchedules.php`

### 6. Fix Generic Type in TaskComment ✅
**File**: `app/Models/TaskComment.php:30`

### 7. Fix Return Type in TaskCompleted Notification ✅

## PHPStan Fixes — Job

_Fonte: `phpstan-fixes.md`_

# PHPStan Fixes — Job

## 2026-06-10 — STORY-307 · L10 · 0 errori codice

795→0. [#336](https://github.com/laraxot/base_fixcity_fila5/issues/336). `GetTaskFrequenciesAction` + test Assert.

---

## Storico — Gennaio 2025

## ✅ Stato complessivo

Il modulo Job è completamente conforme al livello PHPStan 7 con **0 errori rimanenti**. Le correzioni riguardano sia i modelli Eloquent sia le Filament Resources, in modo allineato con le convenzioni `XotBase`.

---

## 🔧 Correzioni implementate

### 1. Modello `Modules/Job/app/Models/Result.php`

- Allineati i PHPDoc `@property-read` a `\Modules\Xot\Contracts\ProfileContract|null` per gli attributi `creator` e `updater`.
- Verificato e documentato il metodo `factory()` con il namespace completo `\Modules\Job\Database\Factories\ResultFactory`.

### 2. Filament Resource `FailedJobResource/Pages/ListFailedJobs.php`

- `getHeaderActions()` ora restituisce array associativi con chiavi string coerenti.
- PHPDoc aggiornato a `@return array<string, \Filament\Actions\Action>` secondo gli standard Filament/Xot.

---
