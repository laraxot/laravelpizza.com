# 📚 Xot Module - Documentation Index

**Path**: `Modules/Xot/docs/`  
**Modulo**: @Modules/Xot  
**Last Updated**: 2026-04-21  
**Status**: ✅ COMPLETE + BMAD INTEGRATED

---

## 🎯 Scopo

Documentazione completa per il modulo **Xot** - Core architecture del progetto Laraxot.

**Visione**: Fornire le fondamenta architetturali per tutti i moduli (Predict, Blog, User, etc.).

## 🤖 BMad Integration

Questo progetto usa BMad Method per lo sviluppo AI-driven. Le skill sono in `.opencode/skills/`.

**Comandi**:
```bash
bmad-help           # AI guida il prossimo passo
bmad-create-story  # Crea uno story file
bmad-dev-story    # Implementa una story
```

---

## 📦 Struttura

```
docs/
├── 00-INDEX.md                    ← Questo file
├── README.md                      ← Panoramica modulo
├── ARCHITECTURE.md                ← Architettura tecnica
├── XOTBASE_ARCHITECTURE_PHILOSOPHY.md ← Filosofia XotBase (CRITICAL!)
│
├── 01-architecture/
│   ├── 00-INDEX.md
│   ├── base-class-hierarchy.md
│   └── traits-composable-pattern.md
│
├── 02-filament/
│   ├── 00-INDEX.md
│   ├── xotbase-table-widget.md
│   ├── xotbase-widget.md
│   └── xotbase-resource.md
│
└── 03-traits/
    ├── 00-INDEX.md
    ├── HasXotTable.md
    └── TransTrait.md
```

---

## 📄 Documenti Principali

### Regole Fondamentali (CRITICAL!)
| File | Descrizione | Link |
|------|-------------|------|
| no-root-folders-rule.md | Lang/docs/tests nei moduli | [📖](../wiki/concepts/no-root-folders-rule.md) |
| no-lang-lang-and-no-underscore-docs-rule.md | No lang/lang/ o _docs/ | [📖](../wiki/concepts/no-lang-lang-and-no-underscore-docs-rule.md) |
| no-root-test-docs-rule.md | Test docs nei moduli/temi | [📖](./concepts/no-root-test-docs-rule.md) |
| no-root-docs-rule.md | Cartelle docs root VIETATE | [📖](./no-root-docs-rule.md) |
| DIRECTORY_STRUCTURE_RULES.md | Regole struttura directory | [📖](./DIRECTORY_STRUCTURE_RULES.md) |

### Architettura
| File | Descrizione | Link |
|------|-------------|------|
| XOTBASE_ARCHITECTURE_PHILOSOPHY.md | **FILOSOFIA PROFONDA**: Perché estendere XotBase | [Link](./XOTBASE_ARCHITECTURE_PHILOSOPHY.md) |
| ARCHITECTURE.md | Architettura tecnica del modulo | [Link](./ARCHITECTURE.md) |
| accessor-delegation-pattern.md | **PATTERN SACRO**: Delegazione e auto-persistenza accessor | [Link](./accessor-delegation-pattern.md) |

### XotBase Rules (CRITICAL!)
| File | Descrizione | Link |
|------|-------------|------|
| XotBase NO table() Method | CHI ESTENDE XotBaseTableWidget NON DEVE AVERE table() | [Link](../../.qwen/rules/xotbase-no-table-method.mdc) |
| XotBase Architecture | Tutti i widget DEVONO estendere XotBase | [Link](../../.qwen/rules/xotbase-architecture.mdc) |

### Filament Widgets
| File | Descrizione | Link |
|------|-------------|------|
| XotBaseTableWidget | Table widget base per TUTTI i moduli | [Source](../app/Filament/Widgets/XotBaseTableWidget.php) |
| XotBaseWidget | Widget base per tutti i moduli | [Source](../app/Filament/Widgets/XotBaseWidget.php) |
| XotBaseWizardWidget | Base dedicata ai widget con `Wizard` / `Step` Filament, query-step policy e normalizzazione stato wrapper | [Doc](./filament/widgets/xot-base-wizard-widget.md) |

### Filament — pagine resource (pannello)
| File | Descrizione | Link |
|------|-------------|------|
| CreateRecord (Filament) | Pipeline `create()`, hook, eventi, differenza vs wizard frontoffice | [Doc](./filament/pages/create-record-page.md) |

### Traits
| File | Descrizione | Link |
|------|-------------|------|
| HasXotTable | Trait per tabelle Laraxot | [Source](../Filament/Traits/HasXotTable.php) |
| TransTrait | Trait per i18n | [Source](../Filament/Traits/TransTrait.php) |

---

## 🔗 Link Bidirezionali

### Dal Modulo Xot verso Esterno

| Da | A | Tipo |
|----|---|------|
| Xot Module | [Predict Module](../../Modules/Predict/docs/00-INDEX.md) | Consumer |
| Xot Module | [Blog Module](../../Modules/Blog/docs/00-INDEX.md) | Consumer |
| Xot Module | [User Module](../../Modules/User/docs/00-INDEX.md) | Consumer |
| Xot Module | [Theme TwentyOne](../../Themes/TwentyOne/docs/00-INDEX.md) | Integration |

### Dall'Esterno verso Xot Module

| Da | A | Tipo |
|----|---|------|
| [Predict Module Index](../../Modules/Predict/docs/00-INDEX.md) | XotBase Philosophy | Dependency |
| [Architecture Index](../../Modules/Predict/docs/01-architecture/00-INDEX.md) | XotBase Architecture | Reference |
| [Filament Widgets Rule](../../docs/project/FILAMENT_WIDGETS_FOR_LISTS_RULE.md) | XotBaseTableWidget | Implementation |
| [AGENTS.md](../../AGENTS.md) | XotBase Philosophy | Critical Rule |
| [QWEN.md](../../QWEN.md) | XotBase Philosophy | Critical Rule |

---

## 🧘 XotBase Philosophy (CRITICAL!)

### Il Pattern

```
Filament\Widgets\TableWidget (Vendor)
    ↑
Modules\Xot\Filament\Widgets\XotBaseTableWidget (Laraxot)
    ↑
Modules\Predict\Filament\Widgets\OutcomesTableWidget (Business Logic)
```

### Perché Estendere XotBaseTableWidget?

1. **DRY** (Don't Repeat Yourself)
   - Codice scritto UNA volta, ereditato ovunque
   - Modifichi XotBase → tutti i widget aggiornati

2. **KISS** (Keep It Simple, Stupid)
   - API semplice, chiara, consistente
   - Nuovo developer capisce subito pattern

3. **Zen** (Composable Architecture)
   - Traits come mattoncini LEGO
   - XotBase "vuoto" → riempibile con business logic

4. **Technical Excellence**
   - Livewire keys gestite centralmente (PREVIENE BUG!)
   - Filters integration standardizzata
   - i18n con TransTrait

### I 10 Comandamenti

1. ✅ Thou shalt extend XotBase
2. ✅ Thou shalt NOT duplicate
3. ✅ Thou shalt use traits
4. ✅ Thou shalt implement getTableQuery
5. ✅ Thou shalt implement getTableColumns
6. ✅ Thou shalt respect Livewire keys
7. ✅ Thou shalt type hint
8. ✅ Thou shalt use i18n
9. ✅ Thou shalt document
10. ✅ Thou shalt test

**Documentazione Completa**: [XOTBASE_ARCHITECTURE_PHILOSOPHY.md](./XOTBASE_ARCHITECTURE_PHILOSOPHY.md)

---

## 🎯 Quick Start

### Per Sviluppatori

```bash
# 1. Leggi la filosofia
cat Modules/Xot/docs/XOTBASE_ARCHITECTURE_PHILOSOPHY.md

# 2. Studia XotBaseTableWidget
cat Modules/Xot/app/Filament/Widgets/XotBaseTableWidget.php

# 3. Vedi esempio Predict
cat Modules/Predict/Filament/Widgets/OutcomesTableWidget.php

# 4. Crea il tuo widget
php artisan make:filament-widget MyWidget
# Poi: class MyWidget extends XotBaseTableWidget
```

### Per AI Agents

1. **Prima di creare widget**: Leggi [XOTBASE_ARCHITECTURE_PHILOSOPHY.md](./XOTBASE_ARCHITECTURE_PHILOSOPHY.md)
2. **Controlla source**: [XotBaseTableWidget.php](../app/Filament/Widgets/XotBaseTableWidget.php)
3. **Vedi esempi**: [OutcomesTableWidget.php](../../Modules/Predict/Filament/Widgets/OutcomesTableWidget.php)
4. **Rules**: [.qwen/rules/](../../.qwen/rules/)

---

## 📊 Stato Documentazione

| Categoria | Completeness | Last Review |
|-----------|-------------|-------------|
| Philosophy | ✅ 100% | 2026-03-26 |
| Architecture | ✅ 100% | 2026-03-26 |
| Filament Widgets | 🔄 80% | 2026-03-26 |
| Traits | 🔄 70% | 2026-03-26 |
| Testing | ⏳ 40% | TODO |

---

## 🎓 Learning Resources

### Esempi nei Moduli
- [Predict Module Widgets](../../Modules/Predict/Filament/Widgets/)
- [Blog Module Widgets](../../Modules/Blog/Filament/Widgets/)
- [User Module Widgets](../../Modules/User/Filament/Widgets/)

### Documentazione Esterna
- [Filament Docs](https://filamentphp.com/docs)
- [Livewire Docs](https://livewire.laravel.com/docs)
- [Laravel Docs](https://laravel.com/docs)

---

## 🔗 Navigation

### Indici Correlati
- [Main Project Index](../../.agents/docs/00-INDEX.md)
- [Predict Module Index](../../Modules/Predict/docs/00-INDEX.md)
- [Project Docs Index](../../docs/project/00-INDEX.md)

### Prossimi Documenti
- [XOTBASE_ARCHITECTURE_PHILOSOPHY.md](./XOTBASE_ARCHITECTURE_PHILOSOPHY.md) - Filosofia
- [ARCHITECTURE.md](./ARCHITECTURE.md) - Architettura tecnica
- [Filament Index](./02-filament/00-INDEX.md) - Filament widgets

---

**Maintained By**: AI Agents Team  
**Review Cycle**: Every sprint  
**Next Review**: 2026-04-02  
**Perfection Goal**: 🎯 100% complete, 0% redundancy
