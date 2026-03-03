# Laraxot Documentation Patterns & Best Practices

## 🎯 Philosophy Overview

**Laraxot = Laravel + Architettura Modulare + DRY + KISS + SOLID + ROBUST**

Questo documento guida l'approccio completo alla scrittura e manutenzione della documentazione nel progetto LaravelPizza Meetups.

---

## 📋 1. Comprensione Iniziale (Understanding Phase)

### Prima di Scrivere Documentazione
- **Logica del codice**: Capisci il flusso e lo scopo
- **Politica architetturale**: Rispetta patterns XotBase, Folio+Volt, Filament
- **Business logic**: Comprendi il dominio (Laravel meetups, non pizzeria!)
- **Filosofia del progetto**: Community-driven, tech-focused
- **Storia del modulo**: Evolutione e decisioni passate
- **Religione architetturale**: Pattern consolidati da NON violare
- **Zen del codice**: Approccio meditativo alla chiarezza e semplicità

---

## 📚 2. Documentazione (Documentation Phase)

### Principi Fondamentali DRY + KISS

**DRY (Don't Repeat Yourself)**:
- Un solo posto per ogni concetto
- Pattern centralizzati in `docs/`
- Riferimenti incrociati invece di duplicazioni

**KISS (Keep It Simple, Stupid)**:
- Linguaggio diretto, non accademico
- Esempi pratici, non teoria astratta
- Structure chiara, non complessa

### Struttura Cartelle `docs/`

```
Modules/{ModuleName}/docs/
├── architecture-reference.md          # Architettura del modulo
├── best-practices.md                # Best practices specifiche
├── troubleshooting.md               # Problemi comuni e soluzioni
├── workflow.md                     # Flussi di lavoro
└── patterns/                       # Pattern riutilizzabili
    ├── repository-pattern.md
    ├── action-pattern.md
    └── view-patterns.md

Themes/{ThemeName}/docs/
├── theme-development.md             # Sviluppo tema
├── component-guide.md              # Guida componenti
├── styling-patterns.md            # Pattern CSS/Tailwind
└── replikate/                     # Replicazione siti
    ├── README.md                   # Overview processo
    ├── replicate.md                # Analisi target
    └── prompts/                    # Prompt strutturati
```

---

## 🔥 3. Analisi Critica (Critical Analysis Phase)

### "Litigata Interiore" Process

**Phase 1 - La Litigata**:
- Metti in discussione ogni tua decisione
- Trova difetti nel tuo ragionamento
- Sfida le tue stesse assunzioni
- Cerca edge cases e problemi nascosti

**Phase 2 - Il Vincitore Spiega**:
- Documenta perché la soluzione scelta è migliore
- Spiega i trade-off considerati
- Giustifica ogni decisione architetturale
- Prevedi possibili problemi futuri

**Phase 3 - Approfondimento**:
- Ricerca pattern simili in altri progetti
- Studia best practices della community Laravel
- Verifica coerenza con rest del codebase

---

## 🛠️ 4. Implementazione (Implementation Phase)

### Checklist Documentazione Pre-Code

**Prima di scrivere codice**:
1. **Studia documentazione esistente** nella stessa area
2. **Cerca pattern simili** in altri moduli
3. **Verifica regole del progetto** in `CLAUDE.md`
4. **Controlla naming conventions** e file structure
5. **Conferma compliance architetturale** (XotBase, Folio, etc.)

### Documentazione Contemporanea

**Mentre scrivi il codice**:
- Aggiorna esempi nei docs
- Aggiungi note su decisioni prese
- Documenta workaround o soluzioni temporanee
- Crea troubleshooting proattivo

---

## 🔍 5. Qualità Codice (Quality Assurance Phase)

### PHPStan Level 10 (ROBUST Principle)

```bash
# Analisi statica strict
./vendor/bin/phpstan analyse Modules/{Module} --level=10

# Verifica type safety
./vendor/bin/phpstan analyse Modules/Cms --level=10 --memory-limit=2G
```

### Code Quality Tools

```bash
# PSR-12 Formatting
./vendor/bin/pint --dirty

# PHPMD - Mess Detector
./vendor/bin/phpmd Modules/{Module} text codesize,unusedcode,naming

# PHP Insights - Comprehensive analysis
./vendor/bin/phpinsights analyse Modules/{Module}
```

### Documentation Quality Tests

**Verifica finale**:
- ✅ Tutti gli esempi di codice funzionano
- ✅ Path relativi corretti (no assoluti)
- ✅ Link interni validi
- ✅ Nomi file follows conventions (kebab-case.md)
- ✅ Struttura coerente con altri docs

---

## 🎓 6. Apprendimento Continuo (Continuous Learning Phase)

### Root Cause Analysis

**Quando trovi un errore**:
1. **Identifica la causa profonda**, non il sintomo
2. **Cerca una regola generale** per prevenirlo
3. **Crea/Aggiorna memory files** in `.cursor/memories/`
4. **Documenta il pattern** in docs appropriate
5. **Condividi la conoscenza** con il team

### Memory System Updates

**File da aggiornare regolarmente**:
- `.cursor/rules/` - Regole di scrittura
- `.cursor/memories/` - Pattern architetturali
- `Modules/*/docs/` - Documentazione modulo
- `Themes/*/docs/` - Documentazione tema

---

## ⚡ 7. Principi Laraxot (SOLID+ROBUST)

### DRY - Don't Repeat Yourself
- **Single source of truth** per ogni concetto
- **Componenti riutilizzabili** invece di copia-incolla
- **Centralizza knowledge** in docs, non disperso nel codice

### KISS - Keep It Simple, Stupid
- **Soluzioni dirette**, non over-engineered
- **Less code = less bugs**
- **Linguaggio semplice** nei docs e commenti

### SOLID Principles
- **Single Responsibility**: Una classe, una responsabilità
- **Open/Closed**: Aperto per estensione, chiuso per modifica
- **Liskov Substitution**: Subtypes must be substitutable
- **Interface Segregation**: Interfacce piccole e specifiche
- **Dependency Inversion**: Dipende da astrazioni, non implementazioni

### ROBUST Principles
- **Type Safety**: Strict types, PHPStan level 10
- **Error Handling**: Gestione prevedibile degli errori
- **Input Validation**: Validazione严密 a tutti i livelli
- **Performance**: Code efficiente e scalabile

### Laraxot Specific Rules
- **XotBase Always**: Estendi classi XotBase, mai Filament diretto
- **belongsToManyX**: Usa sempre, mai belongsToMany tradizionale
- **Folio+Volt**: Frontend SOLO con Folio routing + Volt components
- **CMS-Driven**: Pagine pubbliche = JSON content, no Blade dedicated
- **Localization**: mcamara/laravel-localization per URL multilingua

---

## 📝 Documentation Templates

### Standard Template Pattern

```markdown
# {Document Title}

## Overview
Breve descrizione dello scopo del documento.

## Critical Rules (URGENT)
⚠️ **REGOLA CRITICA**: ...
🚨 **SEMPRE**: ...
✅ **MAI**: ...

## Implementation Examples

### ❌ WRONG - Bad Pattern
```php
// Code showing what NOT to do
```

### ✅ CORRECT - Laraxot Pattern
```php
// Code showing correct approach
```

## Troubleshooting
### Common Issues
- **Problem**: Description
- **Solution**: Fix steps

## References
- `Modules/Xot/docs/pattern-name.md`
- `Themes/Meetup/docs/component-guide.md`
- Related documentation links

---
*Status: ✅ Verified | ⚠️ Needs Review*
```

---

## 🔄 Workflow Ricorsivo

### Loop Continuo di Miglioramento

1. **Study** → Studia docs esistenti
2. **Plan** → Piana approccio Laraxot
3. **Implement** → Codifica seguendo pattern
4. **Test** → Verifica con PHPStan level 10
5. **Document** → Aggiorna docs con scoperte
6. **Share** → Condividi knowledge con team
7. **Repeat** → Ricomincia ciclo migliorato

### Metriche di Successo

**Qualità Documentation**:
- Zero esempi di codice non funzionanti
- Tutti i path relativi e corretti
- Struttura coerente across tutti i docs
- Link interni funzionanti

**Qualità Code**:
- PHPStan level 10 senza errori
- PSR-12 compliant
- Zero duplicazioni (DRY)
- SOLID principles applicati

---

## 🎯 Mission Statement

**"Documentazione che non è solo informativa, ma formativa. Ogni documento rende gli sviluppatori migliori, non solo più informati."**

Focus sull'apprendimento continuo e sulla condivisione della conoscenza architetturale per mantenere coerenza e qualità in tutto l'ecosistema Laraxot.

---

*Generated with Laraxot Philosophy*
*