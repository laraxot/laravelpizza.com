---
title: "Handoff — LettF qua00f relazione filtrata"
type: handoff
module: IndennitaResponsabilita
status: completed
completed: 2026-06-15
related:
  - ../wiki/rules/relationship-filtered-naming.md
  - ../../laravel/Modules/IndennitaResponsabilita/docs/wiki/concepts/relationship-date-range-naming.md
---

# Handoff — LettF relazione Qua00f filtrata

## Fatto

- Rimosso `Qua00f()` (PascalCase + `whereRaw` lungo).
- Aggiunto `qua00fRetribuzioneDateRange()` con `->ofRangeDate($dalYmd, $alYmd)`.
- `rep00fByAnno()` al posto di `Rep00f()`.
- Helper `retribuzioneRangeYmd()` per `dalf`/`alf`.

## Nota naming

`qua00fDateRange` **non** usabile: PHP tratta `qua00fDateRange` ≡ `qua00fDaterange` (trait Sigma su `dal`/`al`).

## Prossimo

- ~~Valutare stesso pattern su `LettI.php`~~ — fatto: `updateFields` usa `ofRangeDate` su `$anag->qua00f()`.
- CondizioniLavoro / ServizioEsterno: stesso anti-pattern (`$qua00fDateRangeSql`).
