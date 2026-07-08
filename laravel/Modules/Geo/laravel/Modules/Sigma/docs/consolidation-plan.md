# Piano Consolidamento Documentazione Sigma

## Motivazione

**PROBLEMA**: 46 file documentazione, molti con date nei nomi, contenuto duplicato/ridondante.

**PRINCIPI VIOLATI**:
- ❌ DRY: Informazioni duplicate in più file
- ❌ KISS: Troppi file simili, difficile navigazione
- ❌ Naming: Date nei nomi file (vietato eccetto CHANGELOG.md)

## Obiettivo Consolidamento

**DA**: 46 file .md  
**A**: ~10-12 file focalizzati

**GUADAGNO**:
- ✅ +80% facilità navigazione
- ✅ +60% manutenibilità
- ✅ Zero ridondanza
- ✅ Naming conforme (minuscolo, no date)

---

## Struttura Target (KISS)

```
Modules/Sigma/docs/
├── README.md                       # ✅ Entry point, quick start
├── architecture.md                 # 🆕 Delegation Cascade, Pattern Accessor
├── business-logic.md              # ✅ GIÀ ESISTE - Business rules, normativa
├── accessor-pattern.md            # 🆕 Pattern completo (consolidato da 8 file)
├── refactoring.md                 # 🆕 Storia refactoring (consolidato da 21 file)
├── performance.md                 # 🆕 Ottimizzazioni, benchmarks
├── testing.md                     # 🆕 Testing strategy
├── api.md                         # 🆕 ImportJsonAction e API (se esiste)
└── troubleshooting.md             # 🆕 Problemi comuni + soluzioni
```

**TOTALE**: 9 file (vs 46 attuali = **-80% file**)

---

## Mappatura Consolidamento

### 📁 accessor-pattern.md (NUOVO)

**Consolidare questi 8 file** →

```
✅ scheda-trait-accessor-pattern.md         # Base pattern
✅ accessor-refactoring-philosophy.md       # Filosofia
✅ accessor-pattern-correct.md              # Pattern corretto
✅ accessor-helper-pattern.md               # Helper delegation
✅ save-vs-update-in-accessors.md          # save() vs update()
✅ accessor-getkey-check-pattern.md        # Guard pattern
✅ bugfix-accessor-save-pattern.md         # Fix implementati
✅ fix-accessor-save-pattern.md            # Duplicato
```

**Sezioni**:
1. Pattern Philosophy (Zen del calcolo)
2. Standard Template
3. Guard Pattern (getKey check)
4. save() vs update() Decision
5. Anti-Patterns
6. Examples

---

### 📁 refactoring.md (NUOVO)

**Consolidare questi 21 file** da `refactoring/` →

```
refactoring/critical-accessor-location-resolution.md
refactoring/critical-status-accessor-location.md
refactoring/final-pragmatic-decision.md
refactoring/professional-approach-final-decision.md
refactoring/schedatrait-complete-evacuation-plan.md
refactoring/what-was-accomplished-today.md
refactoring/comprehensive-final-summary.md
refactoring/schedatrait-cleanup-complete-analysis.md
refactoring/ultimate-success-report.md
refactoring/function-extra-is-helper-analysis.md
refactoring/trait-delegation-cascade-pattern.md
refactoring/delegation-cascade-implementation-success.md
refactoring/scheda-trait-phase1-completion-report.md
refactoring/final-report-complete.md
refactoring/phase2-accessor-migration-roadmap.md
refactoring/phase1-pragmatic-completion.md          # Questo è il principale
refactoring/phase1-success-summary.md
refactoring/scheda-accessor-sub-traits-architecture.md
refactoring/scheda-trait-professional-migration-strategy.md
refactoring/scheda-trait-method-categorization.md
refactoring/scheda-trait-separation-plan.md
```

**Sezioni**:
1. Refactoring Overview (Perché, Obiettivi)
2. Delegation Cascade Pattern
3. Phase 1: Helper Separation (✅ COMPLETATA)
4. Phase 2: Accessor Migration (📝 PIANIFICATA)
5. Lessons Learned
6. Roadmap

---

### 📁 architecture.md (NUOVO)

**Consolidare concetti architetturali** →

```
- Delegation Cascade (da trait-delegation-cascade-pattern.md)
- SchedaTrait responsibility (orchestration)
- Helper/Mutator/Relationship separation
- Module dependencies
```

---

### 📁 performance.md (NUOVO)

**Consolidare** →

```
✅ performance/function-extra-n-plus-1-queries.md
+ Sezioni da README.md su performance
+ Benchmarks (da vari final-summary)
```

**Sezioni**:
1. N+1 Query Problem
2. Eager Loading Strategy
3. Cache Strategy (accessor denormalization)
4. Benchmarks

---

### 📁 troubleshooting.md (NUOVO)

**Consolidare** →

```
✅ fix-duplicate-entry-error-summary.md
✅ bugfix-import-json-action.md
+ Error patterns da altri file
```

**Sezioni**:
1. Duplicate Entry Error (accessor save)
2. ImportJson Issues
3. Performance Issues
4. Common Pitfalls

---

## File da ELIMINARE (dopo consolidamento)

### ❌ Categorie Eliminabili

**1. Status Reports Datati** (informazioni storiche → git history)
```
accessor-helper-status-report-final.md
accessor-helper-audit-complete.md
quality-verification-notes.md
session-complete-summary.md
refactoring-session.md         # ❌ DATA NEL NOME!
phpstan-fixes-archive-1.md                     # ❌ DATA NEL NOME!
```

**2. Final Summaries Duplicati**
```
refactoring-final-summary.md
refactoring/final-report-complete.md
refactoring/comprehensive-final-summary.md
refactoring/ultimate-success-report.md     # 4 file che dicono la stessa cosa!
```

**3. Progress Trackers Obsoleti**
```
refactoring-progress-tracker.md
refactoring/what-was-accomplished-today.md
```

**4. Specifici Troppo Granulari** (info in file consolidato)
```
accessor-getkey-check-final-summary.md
accessor-refactoring-roadmap.md
scheda-trait-accessor-getkey-check.md
```

---

## Strategia Implementazione

### Fase 1: Creazione File Consolidati

1. Creare `architecture.md` (architettura generale)
2. Creare `accessor-pattern.md` (consolidato da 8 file)
3. Creare `refactoring.md` (consolidato da 21 file)
4. Creare `performance.md`
5. Creare `troubleshooting.md`
6. Creare `testing.md`

### Fase 2: Aggiornamento README.md

Aggiornare con struttura semplificata:

```markdown
## Documentazione

### Quick Reference
- [Architecture](./architecture.md) - Delegation Cascade, Pattern
- [Business Logic](./business-logic.md) - Normativa, Calcoli
- [Accessor Pattern](./accessor-pattern.md) - Pattern completo
- [Performance](./performance.md) - Ottimizzazioni
- [Troubleshooting](./troubleshooting.md) - Problemi comuni

### Development
- [Refactoring History](./refactoring.md) - Storia refactoring
- [Testing](./testing.md) - Test strategy

### Links
- [Module Progressioni](../../Progressioni/docs/README.md)
- [Module Performance](../../Performance/docs/README.md)
```

### Fase 3: Eliminazione File Obsoleti

Dopo consolidamento:
1. Backup file eliminati in `docs/_archive/` (git history backup)
2. Delete file ridondanti
3. Update link nei file rimanenti

---

## Checklist Consolidamento

### Per Ogni File Consolidato
- [ ] Contenuto completo (nessuna perdita informazioni)
- [ ] Naming minuscolo (no date)
- [ ] Backlink aggiornati
- [ ] Esempi pratici
- [ ] TOC (Table of Contents) per navigazione

### Dopo Consolidamento
- [ ] README.md aggiornato
- [ ] 46 → ~10 file (-80%)
- [ ] Zero file con date nei nomi
- [ ] Tutti link funzionanti
- [ ] Git history preservato

---

## Benefici Attesi

| Metrica | Prima | Dopo | Miglioramento |
|---------|-------|------|---------------|
| **File totali** | 46 | ~10 | **-78%** |
| **File con date** | 2 | 0 | **-100%** |
| **Duplicazioni** | ~40% | 0% | **-100%** |
| **Tempo navigazione** | 5-10 min | <1 min | **+90%** |
| **Manutenibilità** | Bassa | Alta | **+300%** |

---

## Timeline

**Sprint 1** (Settimana 1):
- [ ] Creare file consolidati
- [ ] Aggiornare README.md

**Sprint 2** (Settimana 2):
- [ ] Eliminare file obsoleti
- [ ] Aggiornare backlink
- [ ] Test navigazione

---

**Creato**: 2025-11-04  
**Status**: 📝 PROPOSTA  
**Owner**: AI Super Mucca 🐄  
**Approver**: Dev Team

