# 🔴 TRANSLATION STRUCTURE - 5 LEVELS REQUIRED

**Path**: `.agents/docs/rules/translation-structure-5-levels.md`  
**Last Updated**: 2026-03-26  
**Status**: ✅ CRITICAL RULE  
**Priority**: BLOCKER

---

## 🎯 The Rule

> **SEMPRE** usare traduzioni a **5 LIVELLI**:
> `__('namespace::context.collection.element.type')`

**Example**:
```php
// ✅ CORRETTO - 5 livelli
__('predict::user.fields.first_name.label')
__('predict::fields.outcome.title.label')
__('predict::labels.market.status.label')

// ❌ SBAGLIATO - MENO di 5 livelli
__('predict::titles.outcomes')           // ❌ SOLO 2 livelli!
__('predict::labels.volume')             // ❌ SOLO 2 livelli!
__('predict::messages.success')          // ❌ SOLO 2 livelli!
```

---

## 📚 Translation Structure

### Level 1: Namespace
```
predict::
```
Il namespace del modulo (predict, blog, user, etc.)

### Level 2: Context
```
predict::user.
predict::fields.
predict::labels.
predict::messages.
predict::titles.
predict::actions.
predict::validation.
```
Il **CONTESTO** della traduzione.

### Level 3: Collection
```
predict::user.fields.
predict::fields.outcome.
predict::labels.market.
predict::messages.bet.
```
La **COLLEZIONE** di elementi.

### Level 4: Element
```
predict::user.fields.first_name.
predict::fields.outcome.title.
predict::labels.market.status.
```
L'**ELEMENTO** specifico.

### Level 5: Type
```
predict::user.fields.first_name.label
predict::fields.outcome.title.label
predict::labels.market.status.label
predict::messages.bet.success.message
```
Il **TIPO** (label, placeholder, helper, message, etc.)

---

## 🔍 Examples

### Correct Examples ✅

```php
// User fields
__('predict::user.fields.first_name.label')
__('predict::user.fields.last_name.label')
__('predict::user.fields.email.placeholder')
__('predict::user.fields.email.helper')

// Fields
__('predict::fields.outcome.title.label')
__('predict::fields.outcome.probability.label')
__('predict::fields.predict.ends_at.label')

// Labels
__('predict::labels.market.status.label')
__('predict::labels.market.volume.label')
__('predict::labels.outcome.probability.label')

// Messages
__('predict::messages.bet.success.message')
__('predict::messages.bet.error.message')

// Titles
__('predict::titles.outcome.title.label')
__('predict::titles.market.title.label')

// Actions
__('predict::actions.bet.submit.label')
__('predict::actions.bet.cancel.label')

// Validation
__('predict::validation.outcome.required')
__('predict::validation.predict.ends_at.after')
```

### Wrong Examples ❌

```php
// ❌ MENO di 5 livelli
__('predict::titles.outcomes')           // ❌ SOLO 2!
__('predict::labels.volume')             // ❌ SOLO 2!
__('predict::messages.success')          // ❌ SOLO 2!
__('predict::fields.title')              // ❌ SOLO 2!
__('predict::user.first_name')           // ❌ SOLO 2!

// ❌ SOLO 3 livelli
__('predict::fields.outcome.title')      // ❌ SOLO 3!
__('predict::labels.market.status')      // ❌ SOLO 3!
__('predict::messages.bet.success')      // ❌ SOLO 3!

// ❌ SOLO 4 livelli
__('predict::fields.outcome.title')      // ❌ SOLO 4! (manca .label)
__('predict::labels.market.status')      // ❌ SOLO 4! (manca .label)
```

---

## 🧠 The WHY (5 Levels)

### Level 1: Organization
```
predict::  → Modulo Predict
blog::     → Modulo Blog
user::     → Modulo User
```
**Why**: Separare moduli diversi.

### Level 2: Context
```
fields::   → Campi database
labels::   → Etichette UI
messages:: → Messaggi
titles::   → Titoli
```
**Why**: Separare contesti diversi.

### Level 3: Collection
```
outcome::  → Collezione outcome
predict::  → Collezione predict
market::   → Collezione market
```
**Why**: Raggruppare elementi correlati.

### Level 4: Element
```
first_name:: → Elemento first_name
title::      → Elemento title
status::     → Elemento status
```
**Why**: Identificare elemento specifico.

### Level 5: Type
```
.label      → Etichetta
.placeholder → Placeholder
.helper     → Helper text
.message    → Messaggio
```
**Why**: Specificare tipo di traduzione.

---

## 📋 Checklist

**BEFORE** committing translations:

- [ ] Contare i livelli: `namespace::context.collection.element.type`
- [ ] **ESATTAMENTE** 5 livelli (separati da `.`)
- [ ] **SEMPRE** `::` dopo namespace
- [ ] **SEMPRE** `.label` per etichette (5° livello)
- [ ] **MAI** meno di 5 livelli
- [ ] **MAI** più di 5 livelli

**IF** meno di 5 livelli → **FIX IMMEDIATE!**

---

## 🔍 How to Spot the Violation

### Red Flag 🚩

```php
// 🚩 RED FLAG: MENO di 5 livelli
__('predict::titles.outcomes')      // 🚩 SOLO 2!
__('predict::labels.volume')        // 🚩 SOLO 2!
__('predict::fields.title')         // 🚩 SOLO 2!
```

**Immediate Fix**:
```php
// ✅ CORRETTO: 5 livelli
__('predict::titles.outcome.title.label')
__('predict::labels.market.volume.label')
__('predict::fields.predict.title.label')
```

---

## 📊 Migration Guide

### Before (Wrong) ❌

```php
// ❌ 2 livelli
__('predict::titles.outcomes')
__('predict::labels.volume')
__('predict::messages.success')

// ❌ 3 livelli
__('predict::fields.outcome.title')
__('predict::labels.market.volume')

// ❌ 4 livelli
__('predict::fields.outcome.title')  // manca .label
```

### After (Correct) ✅

```php
// ✅ 5 livelli
__('predict::titles.outcome.title.label')
__('predict::labels.market.volume.label')
__('predict::messages.bet.success.message')

// ✅ 5 livelli
__('predict::fields.outcome.title.label')
__('predict::labels.market.volume.label')

// ✅ 5 livelli
__('predict::fields.outcome.title.label')  // aggiunto .label
```

---

## 🔗 Related Documentation

### AI Agents Docs
- **[Rules Index](00-INDEX.md)** - All rules
- **[Multi-Outcome Universal](multi-outcome-universal.md)** - Core principle
- **[Use Models Not DB::Table](use-models-not-db-table.md)** - Model usage

### Module Docs
- **[Translation Structure](../../laravel/Modules/Predict/docs/translation-structure.md)** - Translation guide
- **[ADR-003 Deprecate Binary Fields](../../laravel/Modules/Predict/docs/ADR-003_DEPRECATE_BINARY_CREDIT_FIELDS.md)** - Deprecation plan

---

## 📝 Changelog

### 2026-03-26 - CRITICAL RULE ADDED (AGAIN!)
- ✅ Added "5 LEVELS REQUIRED" rule
- ✅ Documented 5 levels structure
- ✅ Examples (CORRECT vs WRONG)
- ✅ Migration guide
- ✅ Checklist

**NOTE**: Questa regola è stata scritta **MILLE VOLTE**.
**ORA È PERMANENTE**. **MAI PIÙ** violazioni!

---

**Maintained By**: AI Agents Team  
**Review Cycle**: Per-release  
**Next Review**: 2026-04-02  
**Enforcement**: 🔴 CRITICAL (violation = code review failure)
