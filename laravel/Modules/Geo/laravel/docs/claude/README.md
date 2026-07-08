# 📖 Documentazione PTVX - Indice Principale

> **🚀 START HERE** - Benvenuto nella documentazione modulare PTVX

## 🎯 Come Usare Questa Documentazione

### 📚 Navigazione Rapida

| Per Chi | Cosa Leggere Prima | Dove Andare |
|---------|-------------------|-------------|
| **Sviluppatori Nuovi** | [Regole Fondamentali](core.md) | 1️⃣ → [Architettura](architecture-rules.md) → [Errori Comuni](common-pitfalls.md) |
| **Sviluppatori Esperti** | [Checklist Commit](core.md#checklist) | [Code Quality](code-quality.md) → [Framework Specifics](framework-specifics.md) |
| **DevOps/SysAdmin** | [Code Quality](code-quality.md) | [Development Tasks](development-tasks.md) → [Testing](code-quality.md#testing) |
| **Team Lead** | [Architecture Rules](architecture-rules.md) | [Module Structure](module-structure.md) → [Conventions](conventions.md) |

### 🏗️ Percorsi Guidati

#### 🚀 **Quick Start (15 min)**
1. [Regole Fondamentali](core.md) - *5 min*
2. [Errori Critici da Evitare](common-pitfalls.md) - *5 min*
3. [Checklist Pre-Commit](core.md#checklist) - *5 min*

#### 🏛️ **Architettura Completa (45 min)**
1. [Regole Architetturali](architecture-rules.md) - *15 min*
2. [Struttura Moduli](module-structure.md) - *10 min*
3. [Proprietà Eloquent](eloquent-properties.md) - *10 min*
4. [Convenzioni Codice](conventions.md) - *10 min*

#### 🧪 **Qualità & Testing (30 min)**
1. [PHPStan Level 10](code-quality.md#phpstan) - *10 min*
2. [Testing con Pest](code-quality.md#testing) - *15 min*
3. [Code Style](conventions.md#code-style) - *5 min*

---

## 📋 Indice Completo dei Documenti

### 🔥 **FONDAMENTALI (Leggi PRIMA)**

| Documento | Descrizione | Priorità |
|-----------|-------------|----------|
| [🎯 Core Rules](core.md) | **CRITICO** - Regole fondamentali PTVX | 🔥 URGENTE |
| [🚨 Common Pitfalls](common-pitfalls.md) | Errori da evitare assolutamente | 🔥 URGENTE |
| [🏗️ Architecture Rules](architecture-rules.md) | Architettura e pattern PTVX | ⚡ ALTA |

### 🛠️ **SVILUPPO**

| Documento | Descrizione | Priorità |
|-----------|-------------|----------|
| [🧪 Code Quality](code-quality.md) | PHPStan, Pest, PSR-12 | ⚡ ALTA |
| [🎨 Framework Specifics](framework-specifics.md) | Filament 4, Livewire 3, Tailwind | ⚡ ALTA |
| [📁 Module Structure](module-structure.md) | Struttura moduli Laraxot | 📡 MEDIA |
| [🔧 Development Tasks](development-tasks.md) | Task e script di sviluppo | 📡 MEDIA |

### 📚 **RIFERIMENTO**

| Documento | Descrizione | Priorità |
|-----------|-------------|----------|
| [🏛️ Eloquent Properties](eloquent-properties.md) | **CRITICO** - Gestione proprietà magiche | 🔥 URGENTE |
| [📝 Conventions](conventions.md) | Stile e convenzioni codice | 📡 MEDIA |
| [🚀 Laravel Boost](laravel-boost.md) | MCP tools e automazioni | 📡 MEDIA |
| [📖 Documentation Policy](documentation-policy.md) | Come documentare correttamente | 📡 MEDIA |

---

## 🔍 Ricerca Rapida per Argomento

### Filament 4
- Resource Pattern → [Framework Specifics → Filament](framework-specifics.md#filament)
- Custom Actions → [Architecture Rules → Actions](architecture-rules.md#actions)
- Tables & Forms → [Framework Specifics → Filament](framework-specifics.md#filament)

### Laravel
- Models & Relationships → [Eloquent Properties](eloquent-properties.md)
- Testing → [Code Quality → Testing](code-quality.md#testing)
- Queue & Jobs → [Architecture Rules → Actions](architecture-rules.md#actions)

### Architettura
- Moduli Laraxot → [Module Structure](module-structure.md)
- Pattern Repository → [Architecture Rules → Repository Pattern](architecture-rules.md#repository-pattern)
- Cross-Database → [Common Pitfalls → Database](common-pitfalls.md#database)

### Code Quality
- PHPStan Level 10 → [Code Quality → PHPStan](code-quality.md#phpstan)
- PSR-12 Style → [Conventions → Code Style](conventions.md#code-style)
- Testing Strategy → [Code Quality → Testing](code-quality.md#testing)

---

## ⚡ Quick Reference - Errori Critici

| ❌ MAI Fare | ✅ Fare Invece | Documento |
|-------------|----------------|-----------|
| `property_exists($model, 'field')` | `isset($model->field)` | [Eloquent Properties](eloquent-properties.md) |
| `extends Resource` | `extends XotBaseResource` | [Architecture Rules](architecture-rules.md) |
| `->label('Nome')` | Traduzioni automatiche | [Documentation Policy](documentation-policy.md) |
| Script in `laravel/` | Script in `../bashscripts/` | [Development Tasks](development-tasks.md) |
| `DB::` raw queries | Eloquent Models | [Architecture Rules](architecture-rules.md) |

---

## 🎯 Metriche della Documentazione

| Metrica | Valore | Note |
|---------|--------|------|
| **Documenti Totali** | 12 focalizzati | DRY + KISS |
| **Lunghezza Media** | 15-20 pagine | Focalizzati |
| **Click Navigazione** | 1-2 max | Veloci |
| **Duplicazioni** | 0% | Single Source of Truth |
| **Aggiornamento** | Dicembre 2025 | Versione 3.0 |

---

## 🚀 Prossimi Passi

1. **Sei nuovo?** → Inizia con [Core Rules](core.md)
2. **Hai bisogno di aiuto?** → Cerca nell'indice sopra
3. **Vuoi contribuire?** → Leggi [Documentation Policy](documentation-policy.md)
4. **Problemi specifici?** → Vedi [Common Pitfalls](common-pitfalls.md)

---

**Versione**: 3.0 (Refactor DRY + KISS + SOLID)  
**Ultimo Aggiornamento**: Dicembre 2025  
**Maintainer**: Sistema Documentazione PTVX

> **💡 Tip**: Usa `Ctrl+F` nel tuo browser per cercare rapidamente negli argomenti qui sopra!