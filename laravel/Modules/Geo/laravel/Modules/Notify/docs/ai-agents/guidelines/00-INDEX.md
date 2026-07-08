# 📖 Guidelines Index

**Path**: `.agents/docs/guidelines/`  
**Last Updated**: 2026-03-26  
**Status**: ✅ Production Ready  
**Files**: 2 guidelines

---

## 🎯 Purpose

Guidelines sono **best practices** e **raccomandazioni** per AI agents.  
A differenza delle rules (obbligatorie), le guidelines sono **consigli** per scrivere codice migliore.

---

## 📁 Guidelines

### 1. Reusable Components Philosophy

**File**: [`reusable-components-philosophy.md`](reusable-components-philosophy.md)  
**Priority**: 🟠 HIGH  
**Purpose**: Perché e come creare componenti riutilizzabili

**Key Points**:
- ✅ DRY: Scrivi una volta, usa ovunque
- ✅ KISS: Componenti semplici, composabili
- ✅ Scalabilità: 2 → 30+ outcomes
- ✅ Manutenibilità: Fix in 1 file
- ✅ Consistenza: Stessa UX per tutti

**Sections**:
- 5 Architecture Principles
- 3 Component Categories
- Component Template
- Performance Guidelines
- Testing Strategy

---

### 2. Filament Tables Guide

**File**: [`filament-tables.md`](filament-tables.md) ⏳ TODO  
**Priority**: 🔴 CRITICAL  
**Purpose**: Come usare Filament Tables per liste

**Key Points**:
- ✅ Search automatico (debounce 400ms)
- ✅ Sorting automatico (multi-column)
- ✅ Filters automatici
- ✅ Pagination automatica
- ✅ Livewire reactivity

**Status**: ⏳ TO BE CREATED

---

## 🔗 Cross-References

### Parent Index
- **[Master Index](../00-INDEX.md)** - AI Agents documentation hub

### Related Indices
- **[Rules Index](rules/00-INDEX.md)** - CRITICAL rules (BLOCKER)
- **[Skills Index](skills/00-INDEX.md)** - AI capabilities
- **[Memories Index](memories/00-INDEX.md)** - Project context
- **[Workflows Index](workflows/00-INDEX.md)** - BMAD, GSD workflows

### Module Docs
- **[Components Index](../../laravel/Modules/Predict/resources/views/components/predict-view/00-INDEX.md)** - 14 components
- **[Reusable Architecture](../../laravel/Modules/Predict/docs/components/reusable-architecture.md)** - Design principles

### Theme Docs
- **[Theme Zero Components](../../laravel/Themes/Zero/docs/components/00-INDEX.md)** - Theme components
- **[TwentyOne Integration](../../laravel/Themes/TwentyOne/docs/predict-integration.md)** - Theme integration

---

## 📝 Changelog

### 2026-03-26
- ✅ Created guidelines index
- ✅ Added reusable-components-philosophy.md
- ⏳ Filament tables guide (TODO)

---

**Maintained By**: AI Agents Team  
**Review Cycle**: Weekly  
**Next Review**: 2026-04-02  
**Status**: ✅ Production Ready
