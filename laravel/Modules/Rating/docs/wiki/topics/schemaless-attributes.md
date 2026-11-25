---
title: "Topic schemaless-attributes"
type: digest
status: active
qmd: "digest ceiling 100 schemaless-attributes"
---

# Topic schemaless-attributes

Sintesi automatica di 3 documenti (chiave `schemaless-attributes`).

## Schemaless Attributes - Errori e Correzioni

_Fonte: `schemaless-attributes-errors.md`_

# Schemaless Attributes - Errori e Correzioni

**Modulo**: Rating
**Data**: 2026-02-11
**Status**: FIX APPLICATI

---
## Errori Trovati

### 1. Rating estende BaseModel invece di BaseRating (DRY Violation)

**File**: `app/Models/Rating.php`

**Problema**: `Rating` estendeva `BaseModel` e duplicava tutto il codice di `BaseRating`:
- `casts()` identico
- `$fillable` identico
- `linkedTo()` identico
- `registerMediaConversions()` identico
- `scopeWithExtraAttributes()` diverso (conflittuale)

**Fix**: `Rating` ora estende `BaseRating`, rimuovendo tutto il codice duplicato.

**Riferimento**: https://github.com/spatie/laravel-schemaless-attributes

### 2. Scope scopeWithExtraAttributes() Conflittuale

**Problema**: Due implementazioni diverse e incompatibili:

**Rating.php** (ERRATO - senza parametri, solo `modelScope()`):

## Schemaless Attributes: Rating Module

_Fonte: `schemaless-attributes.md`_

# Schemaless Attributes: Rating Module

**Package**: [`spatie/laravel-schemaless-attributes`](https://github.com/spatie/laravel-schemaless-attributes)
**Status**: ✅ CORRECT (Rating extends BaseRating)

---
## Architecture

```
Rating (Modules\Rating\Models\Rating)
  └── extends BaseRating (Modules\Rating\Models\BaseRating)
        └── extends BaseModel (Modules\Rating\Models\BaseModel)
              └── extends XotBaseModel (Modules\Xot\Models\XotBaseModel)
```

`BaseRating` is the single source of truth for:
- `casts()`: defines `'extra_attributes' => SchemalessAttributes::class`
- `scopeWithExtraAttributes()`: filters by JSON attributes
- `$fillable`, `linkedTo()`, `registerMediaConversions()`

> [!IMPORTANT]
> Never duplicate these methods in `Rating.php`. Extend `BaseRating` instead.

---

## Setup Checklist

### 1. Model: Correct Cast

## schemaless-attributes-casts

_Fonte: `wiki/concepts/schemaless-attributes-casts.md`_

aggiungere   al file laravel/Modules/IndennitaResponsabilita/app/Models/Rating.php
 /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'extra_attributes' => SchemalessAttributes::class,
            'rule' => RuleEnum::class,
            'is_disabled' => 'boolean',
            'is_readonly' => 'boolean',
        ];
    }

    /**
     * Scope to query by extra attributes.
     *
     * @param Builder $query
     * @param array<string, mixed>|string $attributes
     * @param mixed $value
     * @return Builder
     */
    public function scopeWithExtraAttributes(Builder $query, array|string $attributes = [], mixed $value = null): Builder
    {
        if (is_string($attributes) && $value !== null) {
            // Single attribute with value: withExtraAttributes('anno', 2024)
            return $query->where("extra_attributes->{$attributes}", $value);
