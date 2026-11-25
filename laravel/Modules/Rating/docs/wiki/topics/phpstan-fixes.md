---
title: "Topic phpstan-fixes"
type: digest
status: active
qmd: "digest ceiling 100 phpstan-fixes"
---

# Topic phpstan-fixes

Sintesi automatica di 3 documenti (chiave `phpstan-fixes`).

## phpstan-fixes-analysis

_Fonte: `phpstan-fixes-analysis.md`_

See canonical documentation: ../../../Themes/docs/shared-components/phpstan-fixes-2026-01.md

## PHPStan Fixes - Modulo Rating

_Fonte: `phpstan-fixes-modulo-rating.md`_

# PHPStan Fixes - Modulo Rating

**Data**: 2026-01-27  
**Modulo**: Rating  
**Status**: ✅ **COMPLETATO - 0 Errori**

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
 *
 * @return array<string, string>

## PHPStan Fixes - Modulo Rating

_Fonte: `phpstan-fixes.md`_

# PHPStan Fixes - Modulo Rating

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
but trait Modules\Xot\Models\Traits\HasXotFactory is not generic.
🪪 generics.notGeneric
```

**File**: `app/Models/BaseModel.php:19`

**Soluzione Implementata**:

```php
// ❌ PRIMA (Errore PHPStan)
/**
