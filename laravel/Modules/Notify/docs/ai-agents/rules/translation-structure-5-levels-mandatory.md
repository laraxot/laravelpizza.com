---
title: "translation structure 5 levels mandatory"
type: note
tags: [documentation]
created: 2026-09-26
updated: 2026-09-26
qmd: "translation structure 5 levels mandatory"
issues: []
discussions: []
---

# 🔴 TRANSLATION STRUCTURE - 5 LEVELS MANDATORY

**Path**: `.agents/docs/rules/translation-structure-5-levels-mandatory.md`  
**Last Updated**: 2026-03-26  
**Status**: ✅ CRITICAL RULE  
**Priority**: BLOCKER

---

title: "translation structure 5 levels mandatory"
type: note
tags: [documentation]
created: 2026-09-26
updated: 2026-09-26
qmd: "translation structure 5 levels mandatory"
issues: []
discussions: []
## 🎯 The Rule

> **SEMPRE** usare traduzioni a **5 LIVELLI** con `__()`:
> `__('namespace::context.collection.element.type')`

**MAI** usare `$tx()` o traduzioni con meno di 5 livelli!

---

## ❌ WRONG Examples (NEVER DO THIS)

```blade
// ❌ SBAGLIATO: $tx() helper (VIETATO!)
{{ $tx('forecast::labels.outcomes.title', 'Outcomes') }}
{{ $tx('forecast::labels.volume', 'Volume') }}
{{ $tx('forecast::messages.loading', 'Loading...') }}

// ❌ SBAGLIATO: MENO di 5 livelli
{{ __('forecast::labels.volume') }}              // ❌ SOLO 2 livelli!
{{ __('forecast::messages.loading') }}           // ❌ SOLO 2 livelli!
{{ __('forecast::titles.order.book') }}          // ❌ SOLO 3 livelli!
{{ __('forecast::labels.market.status') }}       // ❌ SOLO 3 livelli!
{{ __('forecast::fields.outcome.title') }}       // ❌ SOLO 3 livelli!

// ❌ SBAGLIATO: Fallback inline
{{ __('forecast::labels.volume', 'Volume') }}    // ❌ Fallback VIETATO!
```

---

## ✅ CORRECT Examples (ALWAYS DO THIS)

```blade
// ✅ CORRETTO: 5 livelli con __()
{{ __('forecast::labels.market.volume.label') }}
{{ __('forecast::messages.bet.loading.message') }}
{{ __('forecast::titles.order.book.title.label') }}
{{ __('forecast::labels.market.status.label') }}
{{ __('forecast::fields.outcome.title.label') }}

// ✅ CORRETTO: Strutture comuni
{{ __('forecast::labels.{entity}.{attribute}.label') }}
{{ __('forecast::messages.{action}.{type}.message') }}
{{ __('forecast::titles.{section}.{element}.label') }}
{{ __('forecast::fields.{entity}.{attribute}.label') }}
{{ __('forecast::actions.{action}.{target}.label') }}
```

---

## 📚 Translation Structure

### Level 1: Namespace
```
forecast::
```
Il modulo (forecast, blog, user, etc.)

### Level 2: Context
```
labels::     → Etichette UI
messages::   → Messaggi
titles::     → Titoli
fields::     → Campi
actions::    → Azioni
validation:: → Validazioni
```

### Level 3: Collection
```
labels.market.     → Etichette mercato
messages.bet.      → Messaggi scommesse
titles.order.      → Titoli order
fields.outcome.    → Campi outcome
actions.trade.     → Azioni trade
```

### Level 4: Element
```
labels.market.volume.     → Volume mercato
messages.bet.loading.     → Caricamento scommessa
titles.order.book.        → Titolo order book
fields.outcome.title.     → Titolo outcome
actions.trade.market.     → Azione trade mercato
```

### Level 5: Type
```
labels.market.volume.label      → Etichetta volume
messages.bet.loading.message    → Messaggio caricamento
titles.order.book.title.label   → Etichetta titolo order book
fields.outcome.title.label      → Etichetta titolo outcome
actions.trade.market.label      → Etichetta azione trade
```

---

## 🔍 How to Spot the Violation

### Red Flag 🚩

```blade
// 🚩 RED FLAG: $tx() helper
{{ $tx('forecast::labels.volume', 'Volume') }}

// 🚩 RED FLAG: Meno di 5 livelli
{{ __('forecast::labels.volume') }}
{{ __('forecast::messages.loading') }}

// 🚩 RED FLAG: Fallback inline
{{ __('forecast::labels.volume', 'Volume') }}
```

**Immediate Fix**:
```blade
// ✅ CORRETTO: 5 livelli con __()
{{ __('predict::labels.market.volume.label') }}
{{ __('predict::messages.bet.loading.message') }}
{{ __('forecast::labels.market.volume.label') }}
{{ __('forecast::messages.bet.loading.message') }}
```

---

## 📋 Checklist

**BEFORE** committing blade files:

- [ ] **ZERO** `$tx()` calls
- [ ] **SOLO** `__('')` calls
- [ ] **ESATTAMENTE** 5 livelli in ogni traduzione
- [ ] **ZERO** fallback inline
- [ ] **STRUTTURA**: namespace::context.collection.element.type

**IF** violazione → **FIX IMMEDIATE!**

---

## 🔗 Related Documentation

### AI Agents Docs
- **[Rules Index](00-index.md)** - All rules
- **[Translation Structure](translation-structure-5-levels.md)** - Original rule

### Module Docs
- **[Translation Files](../../laravel/Modules/Forecast/lang/)** - Translation files
- **[Blade Components](../../laravel/Modules/Forecast/resources/views/components/)** - Blade components

---

## 📝 Changelog

### 2026-03-26 - CRITICAL RULE ADDED
- ✅ Added "5 LEVELS MANDATORY" rule
- ✅ Banned $tx() helper
- ✅ Examples (CORRECT vs WRONG)
- ✅ Checklist

**NOTE**: Questa regola è **ASSOLUTA**.
**MAI** `$tx()`, **SEMPRE** `__('')` con 5 livelli.
**ORA È PERMANENTE**.

---

**Maintained By**: AI Agents Team  
**Review Cycle**: Per-release  
**Next Review**: 2026-04-02  
**Enforcement**: 🔴 CRITICAL (violation = code review failure)
