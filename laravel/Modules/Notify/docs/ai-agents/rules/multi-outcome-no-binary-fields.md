# 🔴 MULTI-OUTCOME UNIVERSAL - NO BINARY FIELDS

**Path**: `.agents/docs/rules/multi-outcome-no-binary-fields.md`  
**Last Updated**: 2026-03-26  
**Status**: ✅ CRITICAL RULE  
**Priority**: BLOCKER

---

## 🎯 The Rule

> **NON ESISTONO** predict di tipo SÌ/NO!
> **TUTTO** è multi-risposta (2-30+ outcomes)!
> **MAI** usare `sum_credit_yes`, `sum_credit_no`, `count_credit_yes`, `count_credit_no`!

**Example**:
```php
// ❌ SBAGLIATO - Campi binary DEPRECATI
$pivot->sum_credit_yes
$pivot->sum_credit_no
$pivot->count_credit_yes
$pivot->count_credit_no

// ✅ CORRETTO - Usare SOLO rating_morph
$pivot->percentage  // Unico campo valido
```

---

## 🧠 The WHY (Philosophy)

### Level 1: Domain Reality ❌

```
❌ SBAGLIATO:
- Sanremo vincerà? SÌ/NO
- sum_credit_yes, sum_credit_no

✅ CORRETTO:
- Chi vincerà Sanremo fra questi 6 cantanti?
  1. Marco Mengoni (25%)
  2. Mahmood (22%)
  3. Geolier (18%)
  4. Angelina Mango (15%)
  5. Annalisa (12%)
  6. Irama (8%)
- SOLO rating_morph per TUTTI gli outcomes
```

**Reality**: La vita non è SÌ/NO. La vita è **QUALI** tra TANTE opzioni.

---

### Level 2: Database Schema ⚠️

```sql
-- ❌ SBAGLIATO: Campi binary
CREATE TABLE rating_morph (
    sum_credit_yes DECIMAL,  -- ❌ DEPRECATO
    sum_credit_no DECIMAL,   -- ❌ DEPRECATO
    count_credit_yes INT,    -- ❌ DEPRECATO
    count_credit_no INT,     -- ❌ DEPRECATO
);

-- ✅ CORRETTO: Solo percentage
CREATE TABLE rating_morph (
    percentage DECIMAL(5,2)  -- ✅ Unico campo valido
);
```

**Schema**: I campi binary sono tenuti SOLO per backward compatibility.

---

### Level 3: Code Impact ✅

```php
// ❌ SBAGLIATO: Usare campi binary
$predict->ratings->first()->pivot->sum_credit_yes;  // ❌ ERROR!
$predict->ratings->first()->pivot->count_credit_no; // ❌ ERROR!

// ✅ CORRETTO: Usare SOLO percentage
$predict->ratings->first()->pivot->percentage;  // ✅ WORKS!
```

**Impact**: Rimuovere riferimenti a campi binary da TUTTO il codice.

---

### Level 4: Multi-Outcome Architecture ✅✅

```
TUTTI i predict sono MULTI-RISPOSTA:

1. Binary (2 outcomes) - CASO PARTICOLARE
   - SÌ/NO è solo un caso con 2 outcomes
   - NON è un tipo speciale!

2. Multi-Outcome (3-30+ outcomes) - CASO GENERALE
   - F1: 6 piloti
   - Sanremo: 6 cantanti
   - Elezioni: 4 candidati
   - Oscar: 5 film

TUTTI usano SOLO rating_morph!
```

**Architecture**: Non c'è distinzione tra binary e multi-outcome.

---

### Level 5: Zen Philosophy ✅✅✅

> "Il vuoto è forma, la forma è vuoto."

```
rating_morph è VUOTO di campi binary.
La sua forza è la sua VUOTEZZA.
Può contenere QUALSIASI outcome (2-30+).

Non c'è SÌ, non c'è NO.
C'è SOLO percentage.
```

**Zen**: I campi binary sono illusione. percentage è realtà.

---

## 📊 Migration Guide

### Before (Wrong) ❌

```php
// ❌ Campi binary
$volume = $pivot->sum_credit_yes + $pivot->sum_credit_no;
$participants = $pivot->count_credit_yes + $pivot->count_credit_no;
```

### After (Correct) ✅

```php
// ✅ Usare SOLO percentage
$probability = $pivot->percentage;

// Per volume/participants, usare query separate
$volume = BetHistory::where('predict_id', $predict->id)->sum('value');
$participants = RatingMorph::where('model_id', $predict->id)
    ->distinct('user_id')
    ->count('user_id');
```

---

## 🔍 How to Spot the Violation

### Red Flag 🚩

```php
// 🚩 RED FLAG: Campi binary
$pivot->sum_credit_yes
$pivot->sum_credit_no
$pivot->count_credit_yes
$pivot->count_credit_no
```

**Immediate Fix**:
```php
// ✅ Rimuovere riferimenti
$pivot->percentage  // ✅ Unico campo valido
```

---

## 📋 Checklist

**BEFORE** committing code:

- [ ] **NO** riferimenti a `sum_credit_yes`
- [ ] **NO** riferimenti a `sum_credit_no`
- [ ] **NO** riferimenti a `count_credit_yes`
- [ ] **NO** riferimenti a `count_credit_no`
- [ ] **YES** uso di `pivot->percentage`
- [ ] **YES** query separate per volume/participants

**IF** trovi campi binary → **RIMUOVERLI!**

---

## 🔗 Related Documentation

### AI Agents Docs
- **[Rules Index](00-INDEX.md)** - All rules
- **[Multi-Outcome Universal](multi-outcome-universal.md)** - Core principle
- **[Use Models Not DB::Table](use-models-not-db-table.md)** - Model usage

### Module Docs
- **[MULTI-OUTCOME-FUNDAMENTAL.md](../../laravel/Modules/Predict/docs/MULTI-OUTCOME-FUNDAMENTAL.md)** - Fundamental rule
- **[ADR-003 Deprecate Binary Fields](../../laravel/Modules/Predict/docs/ADR-003_DEPRECATE_BINARY_CREDIT_FIELDS.md)** - Deprecation plan

---

## 📝 Changelog

### 2026-03-26 - CRITICAL RULE ADDED
- ✅ Added "NO BINARY FIELDS" rule
- ✅ Documented 5 levels of philosophy
- ✅ Migration guide
- ✅ Checklist

---

**Maintained By**: AI Agents Team  
**Review Cycle**: Per-release  
**Next Review**: 2026-04-02  
**Enforcement**: 🔴 CRITICAL (violation = code review failure)
