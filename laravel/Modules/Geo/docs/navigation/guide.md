# 🧭 Navigation Guide - Trova Quello Che Ti Serve

> **GUIDA ALLA NAVIGAZIONE** - Dove trovare ogni argomento nella documentazione PTVX.

## 🎯 Per Argomento Specifico

| Argomento | File | Descrizione |
|-----------|------|-------------|
| **Filament 4** | [framework-specifics.md](../claude/framework-specifics.md#filament) | Resources, Actions, Forms |
| **Livewire 3** | [framework-specifics.md](../claude/framework-specifics.md#livewire) | Componenti reattivi |
| **Laravel Boost MCP** | [laravel-boost.md](../claude/laravel-boost.md) | Strumenti AI e automazione |
| **Testing (Pest)** | [code-quality.md](../claude/code-quality.md#testing) | Test automatici |
| **PHPStan Level 10** | [code-quality.md](../claude/code-quality.md#phpstan) | Analisi statica |
| **Traduzioni** | [documentation-policy.md](../claude/documentation-policy.md#translations) | Sistema i18n |
| **Modelli Eloquent** | [eloquent-properties.md](../claude/eloquent-properties.md) | ORM e relazioni |
| **Struttura Moduli** | [module-structure.md](../claude/module-structure.md) | Organizzazione moduli |

## 📂 Struttura Documentale

```
docs/
├── claude/                    # Documentazione tecnica principale
│   ├── README.md             # Entry point (LEGGI PRIMA)
│   ├── core.md               # Regole fondamentali
│   ├── architecture-rules.md # Architettura PTVX
│   ├── eloquent-properties.md # Proprietà Eloquent (CRITICO)
│   ├── common-pitfalls.md    # Errori da evitare
│   ├── code-quality.md       # PHPStan, testing, qualità
│   ├── framework-specifics.md # Filament, Livewire, Tailwind
│   ├── module-structure.md   # Come creare moduli
│   ├── development-tasks.md  # Workflow sviluppo
│   ├── conventions.md        # Convenzioni codice
│   ├── laravel-boost.md      # AI tools
│   ├── documentation-policy.md # Come scrivere docs
│   ├── dry-kiss-patterns.md  # Pattern architetturali
│   └── solid-principles.md   # Principi OOP
│
├── navigation/               # Guide navigazione
│   └── getting-started.md    # Guida per iniziare
│
├── quick-reference/          # Riferimenti rapidi
│   └── errors.md            # Errori comuni e soluzioni
│
├── patterns/                # Pattern architetturali
│   └── [pattern-files]      # Implementazioni pattern
│
├── getting-started/         # Guide introduttive
│   └── [guide-files]        # Tutorial passo-passo
│
├── modules.md               # Indice di tutti i moduli (42)
└── README.md               # Root documentation
```

## 🏷️ Tag e Categorie

### Per Ruolo
- **👨‍💻 Sviluppatore Backend** → [Architettura](../claude/architecture-rules.md), [Qualità Codice](../claude/code-quality.md)
- **🎨 Frontend Developer** → [Framework Specifici](../claude/framework-specifics.md), [UI Components](../ui_components/)
- **🧪 QA/Tester** → [Testing](../claude/code-quality.md#testing), [Common Pitfalls](../claude/common-pitfalls.md)
- **📚 Technical Writer** → [Documentation Policy](../claude/documentation-policy.md)

### Per Framework
- **Laravel** → [Architettura](../claude/architecture-rules.md), [Eloquent](../claude/eloquent-properties.md)
- **Filament** → [Framework Specifics](../claude/framework-specifics.md#filament)
- **Livewire** → [Framework Specifics](../claude/framework-specifics.md#livewire)
- **Tailwind** → [Framework Specifics](../claude/framework-specifics.md#tailwind)

### Per Task
- **Nuovo Modulo** → [Module Structure](../claude/module-structure.md#new-module)
- **Fix Bug** → [Common Pitfalls](../claude/common-pitfalls.md), [Troubleshooting](../troubleshooting/)
- **Code Review** → [Code Quality](../claude/code-quality.md), [Conventions](../claude/conventions.md)
- **Deploy** → [Development Tasks](../claude/development-tasks.md#deployment)

## 🔍 Ricerca Avanzata

### Per Parola Chiave
- **PDF** → Cerca "html2pdf" in [Xot Module](../../Modules/Xot/docs/)
- **Email** → [Notify Module](../../Modules/Notify/docs/)
- **Database** → [Migration Rules](../../Modules/Xot/docs/migrations/)
- **Testing** → [Pest Guide](../claude/code-quality.md#testing)

### Per Modulo Specifico
- **Xot** → [Core Framework](../../Modules/Xot/docs/)
- **User** → [Authentication](../../Modules/User/docs/)
- **Performance** → [HR Management](../../Modules/Performance/docs/)
- **Ptv** → [Business Logic](../../Modules/Ptv/docs/)

## 📊 Metriche Utilizzo

| Sezione | % Utilizzo | Motivo |
|---------|------------|--------|
| **Errori Comuni** | 65% | Problemi quotidiani |
| **Architettura** | 45% | Struttura progetto |
| **Qualità Codice** | 40% | Standard sviluppo |
| **Framework** | 35% | Implementazione specifica |

## 🚀 Workflow Consigliato

### Per Nuovo Sviluppatore
1. **[Getting Started](../navigation/getting-started.md)** (5 min)
2. **[Core Rules](../claude/core.md)** (10 min)
3. **[Architecture](../claude/architecture-rules.md)** (15 min)
4. **[Common Pitfalls](../claude/common-pitfalls.md)** (10 min)

### Per Task Specifico
1. **Quick Reference** → [Errori](../quick-reference/errors.md)
2. **Approfondimento** → File specifico in `claude/`
3. **Esempi** → [Patterns](../patterns/) o [Best Practices](../best-practices/)

---

**💡 Suggerimento**: Usa [Quick Reference](../quick-reference/errors.md) per problemi urgenti!

*Ultimo aggiornamento: Dicembre 2025*
