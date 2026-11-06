---
title: Decision log
module: Activity
type: note
status: draft
updated: 2026-10-20
tags: [docs, activity, bmad]
qmd: "decision log - modulo activity activity"
---

# Decision Log - Modulo Activity

## Formato

- **Data:** YYYY-MM-DD
- **Decisione:** Breve descrizione della decisione presa
- **Stato:** PROPOSTA, APPROVATA, RIFIUTATA, OBSOLETA
- **Impatto:** Alto/Medio/Basso
- **Alternatives considerate:** Elenco delle alternative valutate
- **Conseguenze:** Implicazioni della decisione

## Registro delle decisioni

### 2026-10-20: Gate PHPStan Modules: rieseguito OK

- **Verifica:** `cd laravel && php -d memory_limit=2G ./vendor/bin/phpstan analyse Modules/Activity` (audit random) → exit 0; allineato a [decision-log.md](../decision-log.md) (wave test 2026-10-20).
- **Docs:** `md-filenames.py check` su `docs/` → 0 date/suffissi; legacy maiuscole in radice (73 file): inventory only.
- **Track:** [phpstan-fixes.md](../phpstan-fixes.md), [00-INDEX.md](../00-index.md), [phpstan-test-wave-activity.story.md](../stories/phpstan-test-wave-activity.story.md).

### 2026-09-29
**Decisione:** [Esempio: Utilizzare Filament Widget invece di Livewire per i componenti di UI]
**Stato:** APPROVATA
**Impatto:** Alto
**Alternatives considerate:** 
- Mantenere Livewire
- Utilizzare componenti Blade tradizionali
**Conseguenze:** 
- Migliore integrazione con Filament
- Riduzione della complessità del codice
- Necessità di migrare componenti esistenti

### 2026-09-30
**Decisione:** [Esempio: Adottare la convenzione "una chiave per riga" per gli array PHP]
**Stato:** APPROVATA
**Impatto:** Medio
**Alternatives considerate:** 
- Array inline
- Array multi-linea senza convenzione fissa
**Conseguenze:** 
- Migliore leggibilità e gestione dei conflitti in git
- Necessità di refactor esistente
