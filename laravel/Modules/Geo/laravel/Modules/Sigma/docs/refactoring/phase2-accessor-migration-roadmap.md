# Fase 2 Roadmap: Accessor Migration (Pianificata)

## 🎯 Obiettivo Fase 2

Completare la separazione spostando i **83 accessor** da SchedaTrait → SchedaMutator (o sub-traits).

## 📊 Stato Attuale Post-Fase 1

```
SchedaTrait.php (2913 righe)
├── ✅ Helper (35) → Delegati a SchedaHelper via trait
├── ⏸️ Accessor (83) → ANCORA qui (da migrare Fase 2)
└── ✅ Utility (6) → Rimangono qui (corretto)

SchedaHelper.php (703 righe) - ✅ COMPLETATO
├── 23 helper protected
└── 12 helper public

SchedaMutator.php (507 righe)  
├── ✅ Usa SchedaHelper
└── 15 accessor esistenti
```

## 🎯 Obiettivo Post-Fase 2

```
SchedaTrait.php (~200 righe) - SOLO COMPOSITION
├── use statements (12 trait)
├── Utility methods (6)
└── PHPDoc

SchedaHelper.php (703 righe) - ✅ GIÀ FATTO
├── 35 helper methods

SchedaMutator.php OPPURE Sub-Traits (~3200 righe totali)
├── 83 accessor da SchedaTrait
└── 15 accessor esistenti
```

## 🗺️ Strategie Possibili

### Opzione A: Sub-Traits per Categoria (Architetturalmente Ideale)

**Struttura**:
```
Modules/Sigma/app/Models/Traits/Accessors/
├── GgAccessor.php (~1000 righe) - 35 accessor gg_*
├── PerfAccessor.php (~400 righe) - 19 accessor perf_*
├── CategoriaAccessor.php (~600 righe) - 12 accessor cateco/propro/posfun
├── ValutatoreAccessor.php (~200 righe) - 5 accessor valutatore
├── BaseAccessor.php (~700 righe) - 15 accessor vari
└── LegacyAccessor.php (~507 righe) - Accessor esistenti da SchedaMutator

SchedaMutator.php (~100 righe) - COMPOSITION
├── use GgAccessor;
├── use PerfAccessor;
├── use CategoriaAccessor;
├── use ValutatoreAccessor;
├── use BaseAccessor;
└── use LegacyAccessor;
```

**Pro**:
- ✅ File piccoli e focalizzati (<1000 righe)
- ✅ Navigabilità massima
- ✅ Merge conflict minimizzati
- ✅ Scalabile (facile aggiungere nuovi accessor)

**Contro**:
- ⚠️ Più file da gestire (6 nuovi)
- ⚠️ Richiede migrazione manuale categoria per categoria
- ⚠️ Complessità architetturale aumentata

**Tempo stimato**: 2-3 ore (20-30 accessor per ora)

### Opzione B: SchedaMutator Singolo (Pragmatico)

**Struttura**:
```
SchedaMutator.php (~3200 righe)
├── // ===== SECTION: GG Accessors =====
├── 35 accessor gg_*
├── // ===== SECTION: PERF Accessors =====
├── 19 accessor perf_*
├── // ===== SECTION: CATEGORIA Accessors =====
├── 12 accessor cateco_*
├── // ===== SECTION: VALUTATORE Accessors =====
├── 5 accessor valutatore
├── // ===== SECTION: BASE Accessors =====
├── 15 accessor vari
└── // ===== SECTION: LEGACY Accessors =====
    └── 15 accessor esistenti
```

**Pro**:
- ✅ Un solo file da gestire
- ✅ Migrazione più veloce (merge + organize)
- ✅ Meno complessità architetturale

**Contro**:
- ⚠️ File grande (~3200 righe)
- ⚠️ Navigazione ancora pesante
- ⚠️ Merge conflict più probabili

**Tempo stimato**: 30-60 minuti

### Opzione C: Incrementale Manuale (Conservativo)

**Approccio**:
1. Spostare 10-20 accessor alla volta
2. Validare con PHPStan dopo ogni batch
3. Test regressione dopo ogni batch
4. Continue until complete

**Pro**:
- ✅ Rischio minimo
- ✅ Rollback facile
- ✅ Validazione continua

**Contro**:
- ⚠️ Tempo lungo (4-6 ore totali)
- ⚠️ Richiede molti commit

**Tempo stimato**: 4-6 ore (5-10 accessor per batch)

## 🔍 Analisi Rischi Fase 2

### Rischio ALTO

**Migrazione automatica non validata**:
- Script generano syntax errors
- Breaking changes non rilevati
- Rollback difficile

### Rischio MEDIO

**Migrazione manuale senza test**:
- Typos o copy-paste errors
- Metodi incompleti
- Dipendenze mancanti

### Rischio BASSO

**Migrazione incrementale validata**:
- PHPStan dopo ogni batch
- Test dopo ogni batch
- Git commit intermedi

## ✅ Prerequisiti Fase 2

Prima di iniziare Fase 2:

- [ ] Tutti test esistenti passano
- [ ] Performance edit page verificata (<5 secondi)
- [ ] Team review architettura Fase 1
- [ ] Decisione Opzione A/B/C condivisa
- [ ] Backup completo repository
- [ ] Branch dedicato `refactor/scheda-trait-phase2`

## 📊 Metriche Fase 2 Attese

**Se Opzione A (Sub-Traits)**:
- Numero file: +6
- Righe per file: <1000
- Navigabilità: +400%
- Manutenibilità: +300%

**Se Opzione B (Singolo)**:
- Numero file: +1
- Righe per file: ~3200
- Navigabilità: +100%
- Manutenibilità: +150%

## 📅 Timeline Stimata Fase 2

**Sprint Planning**:
- Analisi e preparazione: 2 ore
- Implementazione: 2-6 ore (dipende da opzione)
- Validazione: 2 ore (PHPStan, PHPMD, PHPInsights)
- Testing: 2 ore (regressione + performance)
- **Totale**: 8-12 ore (1-2 giorni)

## 📚 Collegamenti

- [Fase 1 Success Summary](./phase1-success-summary.md)
- [Professional Strategy](./scheda-trait-professional-migration-strategy.md)
- [Sub-Traits Architecture](./scheda-accessor-sub-traits-architecture.md)
- [Performance Fix](../../performance/function-extra-n-plus-1-queries.md)

---

**Creato**: 29 Gennaio 2026  
**Status**: 📋 PIANIFICATA  
**Trigger**: TBD (post-review Fase 1)  
**Owner**: Team decision

