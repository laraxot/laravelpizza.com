# DRY & KISS Refactoring - Modelli Base

## Data: 15 Ottobre 2025

## 🔴 Problemi Critici

### 1. BasePivot NON estende XotBasePivot

**Moduli**: Cms, Geo

**Problema**: 50+ righe duplicate in ogni modulo

**Soluzione**:
```php
// ❌ PRIMA (61 righe)
abstract class BasePivot extends Pivot {
    use Updater;
    public static $snakeAttributes = true;
    public $incrementing = true;
    protected $perPage = 30;
    protected $connection = 'cms';
    // ... altre 40+ righe
}

// ✅ DOPO (11 righe)
abstract class BasePivot extends XotBasePivot {
    protected $connection = 'cms';
}
```

---

### 2. BaseMorphPivot NON estende XotBaseMorphPivot

**Moduli**: Cms, Geo

**Problema**: 60+ righe duplicate

**Soluzione**: Come BasePivot, estendere `XotBaseMorphPivot`

---

### 3. BaseMorphPivot Ridondante

**Modulo**: Gdpr (e altri)

**Problema**: Ridefinisce TUTTO ciò che è già in XotBaseMorphPivot

```php
// ❌ PRIMA (81 righe) - Gdpr/BaseMorphPivot.php
abstract class BaseMorphPivot extends XotBaseMorphPivot {
    use HasXotFactory;  // ❌ Già in parent
    use Updater;        // ❌ Già in parent
    public $incrementing = true;     // ❌ Già in parent
    protected $connection = 'user';  // ❌ ERRORE! Dovrebbe essere 'gdpr'
    // ... altre 70 righe duplicate
}

// ✅ DOPO (11 righe)
abstract class BaseMorphPivot extends XotBaseMorphPivot {
    protected $connection = 'gdpr';
}
```

---

## 📊 Statistiche

| Tipo | Moduli OK | Moduli KO | Righe Duplicate |
|------|-----------|-----------|-----------------|
| BasePivot | 3 (Gdpr, Notify, User) | 2 (Cms, Geo) | ~100 |
| BaseMorphPivot | 1 (Notify) | 5 (Cms, Geo, Gdpr, Job, Lang) | ~300 |

**Totale risparmio potenziale**: ~400 righe

---

## 🎯 Piano Azione

### Priorità 1: Cms e Geo
1. `Cms/BasePivot.php` → Estendere `XotBasePivot`
2. `Cms/BaseMorphPivot.php` → Estendere `XotBaseMorphPivot`
3. `Geo/BasePivot.php` → Estendere `XotBasePivot`
4. `Geo/BaseMorphPivot.php` → Estendere `XotBaseMorphPivot`

### Priorità 2: Gdpr, Job, Lang
Semplificare `BaseMorphPivot` rimuovendo duplicazioni

---

## ✅ Template Corretto

```php
<?php

declare(strict_types=1);

namespace Modules\[MODULE]\Models;

use Modules\Xot\Models\XotBase[Model|Pivot|MorphPivot];

/**
 * Base [Model|Pivot|MorphPivot] for [MODULE] module.
 */
abstract class Base[Model|Pivot|MorphPivot] extends XotBase[Model|Pivot|MorphPivot]
{
    protected $connection = '[module]';
}
```

**Regola**: SOLO la proprietà `$connection`!

---

## Collegamenti

- [Audit Completo](./MODEL_INHERITANCE_AUDIT.md)
- [XotBaseModel](../app/Models/XotBaseModel.php)
- [XotBasePivot](../app/Models/XotBasePivot.php)
- [XotBaseMorphPivot](../app/Models/XotBaseMorphPivot.php)
