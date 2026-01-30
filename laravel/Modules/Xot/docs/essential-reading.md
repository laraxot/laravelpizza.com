# Essential Reading - Xot Module

Questa guida contiene le letture essenziali per comprendere e lavorare con il modulo Xot e l'architettura Laraxot.

## 📚 Documentazione Fondamentale

### Per Iniziare
1. [xot-engine-complete-guide.md](xot-engine-complete-guide.md) - Guida completa al motore Xot
2. [project-conventions.md](../project-conventions.md) - Convenzioni del progetto
3. [structure.md](structure.md) - Struttura del modulo Xot

### Filament
1. [filament.md](filament.md) - Best practices Filament centralizzate
2. [filament-4-laraxot-rules.md](filament-4-laraxot-rules.md) - Regole Laraxot per Filament 4
3. [filament-5-laraxot-rules.md](filament-5-laraxot-rules.md) - ⭐ Regole Laraxot per Filament 5 (NUOVO)
4. [filament-5-upgrade-guide.md](filament-5-upgrade-guide.md) - Guida upgrade Filament 5 (aggiornato)
5. [filament-5-livewire-4-complete-guide.md](filament-5-livewire-4-complete-guide.md) - ⭐ Guida completa Filament 5 + Livewire 4 (NUOVO)

### Architettura
1. [xot-base-classes.md](xot-base-classes.md) - Classi base Xot
2. [xotbase-architecture-complete.md](xotbase-architecture-complete.md) - Architettura completa XotBase

## 🎯 Guide Specifiche

### Testing
1. [testing-best-practices.md](testing/testing-best-practices.md) - Best practices testing
2. [testing-philosophy-unified.md](testing/testing-philosophy-unified.md) - Filosofia testing unificata
3. [testing-strategy.md](testing/testing-strategy.md) - Strategia testing

### Traduzioni
1. [translation-system.md](translation-system.md) - Sistema di traduzione
2. [translation-best-practices.md](translation/translation-best-practices.md) - Best practices traduzioni

### Servizi
1. [services.md](services.md) - Panoramica servizi
2. [service-provider-best-practices.md](service-provider-best-practices.md) - Best practices service provider

## 🔧 Troubleshooting

1. [troubleshooting/README.md](troubleshooting/README.md) - Indice troubleshooting
2. [common-issues.md](troubleshooting/common-issues.md) - Problemi comuni
3. [phpstan.md](troubleshooting/phpstan.md) - PHPStan troubleshooting

## 📋 Quick Reference

### Filament 5 Upgrade Checklist
- [x] Studio breaking changes completato
- [x] Documentazione aggiornata
- [ ] Config Livewire aggiornato
- [ ] Composer verificato
- [ ] Conflitti git risolti
- [ ] Script upgrade eseguito
- [ ] Livewire v4 installato
- [ ] Plugin verificati
- [ ] Moduli documentati
- [ ] Test completati

Vedi: [Guida Completa Filament 5 + Livewire 4](filament-5-livewire-4-complete-guide.md)

## 🏗️ Architettura e Pattern (3 docs)

### 4. [laraxot-architecture-rules.md](./laraxot-architecture-rules.md) ⭐⭐⭐
**Cosa:** Regole architetturali MUST-FOLLOW
**Perché:** Evitare errori critici (XotBase, no labels, ecc.)
**Tempo:** 12 minuti

### 5. [namespace-conventions.md](./namespace-conventions.md) ⭐⭐⭐
**Cosa:** Convenzioni PSR-4 Laraxot (namespace NON include `app/`)
**Perché:** Evitare "does not comply with psr-4" warnings
**Tempo:** 7 minuti

### 6. [actions-pattern.md](./actions-pattern.md) ⭐⭐
**Cosa:** Spatie QueueableActions vs Services
**Perché:** Pattern obbligatorio Laraxot (no Services!)
**Tempo:** 10 minuti

## 🎨 Filament e UI (2 docs)

### 7. [filament-best-practices.md](./filament-best-practices.md) ⭐⭐⭐
**Cosa:** Best practices Filament, XotBase classes, no ->label()
**Perché:** Evitare violazioni architetturali in Filament
**Tempo:** 15 minuti

### 8. [filament-guide.md](./filament-guide.md) ⭐⭐
**Cosa:** Guida completa Filament integration
**Perché:** Reference per Resources, Pages, Widgets
**Tempo:** 20 minuti

**Upgrade Filament 5:** [filament-5-upgrade-guide.md](./filament-5-upgrade-guide.md) - Requisiti, passi ufficiali, compatibilità Laraxot.

## 🆕 Nuove Regole (2 docs)

### 9. [file-locking-pattern.md](./file-locking-pattern.md) ⭐⭐⭐ 🆕
**Cosa:** Pattern file locking per modifiche concorrenti sicure
**Perché:** Prevenire race conditions e merge conflicts
**Tempo:** 8 minuti
**Creato:** 2025-11-04

```bash
# Regola fondamentale
touch file.php.lock  # Prima di modificare
# Se .lock esiste → SKIPPA
rm file.php.lock     # Dopo modifica
```

### 10. [merge-conflict-resolution-2025-11-04.md](./merge-conflict-resolution-2025-11-04.md) ⭐⭐ 🆕
**Cosa:** Report tecnico risoluzione 18 file con merge conflicts
**Perché:** Case study completo, pattern da evitare
**Tempo:** 15 minuti
**Creato:** 2025-11-04

## 📚 Letture Complementari (Opzionali)

### Code Quality
- [code-quality-standards.md](./code-quality-standards.md) - PHPStan Level 10 + Laravel Pint
- [phpstan-usage.md](./phpstan-usage.md) - Come eseguire analisi statica

### Service Providers
- [service-providers.md](./service-providers.md) - Pattern e best practices
- [service-provider-architecture.md](./service-provider-architecture.md) - Architettura dettagliata

### Models e Database
- [model-base-rules.md](./model-base-rules.md) - BaseModel conventions
- [migrations.md](./consolidated/migrations.md) - Migration standards

### Testing
- [testing.md](./consolidated/testing.md) - Pest v3 testing guide

### Lessons Learned
- [lessons-learned-2025-11-04-merge-conflicts.md](./lessons-learned-2025-11-04-merge-conflicts.md) - Processo filosofico 10-step

## 🗺️ Learning Path Consigliato

### Path per Nuovi Sviluppatori (2 ore)
1. README.md (5min)
2. laraxot-framework.md (10min)
3. architecture-overview.md (8min)
4. laraxot-architecture-rules.md (12min) ← **CRITICO**
5. namespace-conventions.md (7min) ← **CRITICO**
6. filament-best-practices.md (15min) ← **CRITICO**
7. actions-pattern.md (10min)
8. file-locking-pattern.md (8min) ← **NUOVO**
9. Break & Practice (30min)
10. Code quality & testing docs (25min)

### Path per Debug Urgenti (30 min)
1. README.md - Check "Correzioni Recenti"
2. merge-conflict-resolution-2025-11-04.md - Pattern errori comuni
3. troubleshooting.md (se esiste)
4. File specifico al problema (cerca in index.md)

### Path per Contribuire (1 ora)
1. laraxot-architecture-rules.md ← **OBBLIGATORIO**
2. namespace-conventions.md ← **OBBLIGATORIO**
3. filament-best-practices.md ← **OBBLIGATORIO**
4. file-locking-pattern.md ← **NUOVO - OBBLIGATORIO**
5. code-quality-standards.md
6. testing.md

## ⏱️ Tempo Totale Lettura Essenziali

- **Minimo** (solo MUST-READ): ~45 minuti (docs 1,2,4,5,7,9)
- **Raccomandato** (tutti i 10): ~105 minuti (~1h 45min)
- **Completo** (con complementari): ~3 ore

## 📌 Priorità Lettura

### ⭐⭐⭐ MUST READ (Prima di scrivere codice)
1. README.md
2. laraxot-framework.md
3. laraxot-architecture-rules.md
4. namespace-conventions.md
5. filament-best-practices.md
6. file-locking-pattern.md 🆕

### ⭐⭐ SHOULD READ (Prima di commit)
7. actions-pattern.md
8. filament-guide.md
9. code-quality-standards.md

### ⭐ NICE TO READ (Per approfondimento)
10. merge-conflict-resolution-2025-11-04.md
11. lessons-learned-2025-11-04-merge-conflicts.md
12. service-providers.md

## 🎓 Quiz Auto-Valutazione

Dopo aver letto le docs essenziali, dovresti saper rispondere:

1. ✅ I namespace Laraxot includono il segmento `app/`? (NO!)
2. ✅ Devo estendere `Filament\Resources\Pages\EditRecord`? (NO! Usa XotBaseEditRecord)
3. ✅ Posso usare `->label('Testo')` nei componenti Filament? (NO! Traduzioni automatiche)
4. ✅ Devo creare Service classes? (NO! Usa Actions con QueueableAction trait)
5. ✅ Prima di modificare un file devo...? (Creare file.lock!)
6. ✅ Se trovo `file.php.lock` devo...? (SKIPPARE il file!)
7. ✅ Dove vanno le traduzioni nei moduli? (`lang/` nella root del modulo, NON `app/lang/`)
8. ✅ Posso usare `BadgeColumn`? (NO! Usa `TextColumn::make()->badge()`)

Se hai risposto correttamente a tutte, sei pronto per contribuire! 🎉

---

**Creato:** 2025-11-04
**Scopo:** Ridurre cognitive load navigando 2,560+ docs
**Aggiornato:** Dopo risoluzione massiva merge conflicts
