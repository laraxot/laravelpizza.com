---
title: "Topic phpstan-fixes"
type: digest
status: active
qmd: "digest ceiling 100 phpstan-fixes"
---

# Topic phpstan-fixes

Sintesi automatica di 4 documenti (chiave `phpstan-fixes`).

## PHPStan Fixes - Modulo Rating

_Fonte: `bmad/phpstan-fixes.md`_

# PHPStan Fixes - Modulo Rating

**Data**: 2026-01-27  
**Modulo**: Rating  
**Status**: ✅ **COMPLETATO - 0 Errori**

---

## Correzioni Applicate

### 1. Conversione `$casts` in `casts()` (Laravel 13+)

**File**: `app/Models/Rating.php`

**Prima**:
```php
public $casts = [
    'extra_attributes' => SchemalessAttributes::class,
    'rule' => RuleEnum::class,
    'is_disabled' => 'boolean',
    'is_readonly' => 'boolean',
];
```

**Dopo**:
```php
/**
 * Get the attributes that should be cast.
 *
 * @return array<string, string>

## phpstan-fixes-analysis

_Fonte: `phpstan-fixes-analysis.md`_

See canonical documentation: ../../../Themes/docs/shared-components/phpstan-fixes.md

## PHPStan Fixes - Modulo Rating

_Fonte: `phpstan-fixes-modulo-rating.md`_

> **Superseded / storico** (nome con data: non creare altri così). Canonico: [phpstan-fixes.md](phpstan-fixes.md). Indice: [index.md](index.md).

# PHPStan Fixes - Modulo Rating

**Data**: 2026-01-27  
**Modulo**: Rating  
**Status**: ✅ **COMPLETATO - 0 Errori** (snapshot)

---

## Correzioni Applicate

### 1. Conversione `$casts` in `casts()` (Laravel 12+)

**File**: `app/Models/Rating.php`

**Prima**:
```php
public $casts = [
    'extra_attributes' => SchemalessAttributes::class,
    'rule' => RuleEnum::class,
    'is_disabled' => 'boolean',
    'is_readonly' => 'boolean',
];
```

**Dopo**:
```php
/**
 * Get the attributes that should be cast.

## PHPStan Fixes - Modulo Rating

_Fonte: `phpstan-fixes.md`_

# PHPStan Fixes - Modulo Rating

## Wave 2026-11-17 — 172 → 0

Verify: `cd laravel && ./vendor/bin/phpstan analyse Modules/Rating Modules/Lang --memory-limit=-1 --error-format=raw` → **0**.

Root causes: Eloquent PHPDoc `Builder<static>` (no Larastan in neon); `::query()` for where/create; HasRating array/MorphToMany types + `RateableHost`; dead traits removed; migrations `json('extra_attributes')`; Pest `Ensure` + XotBaseTestCase.

See also: [wiki/troubleshooting/phpstan-generic-limitation-morphtomany.md](wiki/troubleshooting/phpstan-generic-limitation-morphtomany.md).

---

## ✅ Status: COMPLETATO - 0 Errori

**Data**: 11 Ottobre 2025  
**PHPStan Level**: Max  
**Errori Risolti**: 1 → 0 ✅

---

## 📊 Correzioni Implementate

### 1. Rimozione Generic Type da HasXotFactory ✅

**Problema**: PHPDoc tag `@use` conteneva tipo generico per trait non generico.

**Errore PHPStan**:
```
PHPDoc tag @use contains generic type Modules\Xot\Models\Traits\HasXotFactory<Illuminate\Database\Eloquent\Factories\Factory>
