---
title: FailedJobs e JobsWaiting, tabelle nelle Table class
status: done
module: Job (owner)
created: 2026-11-04
related:
  - ../../../Activity/docs/stories/snapshot-list-page-table-class.story.md
  - ../../../Xot/docs/stories/setting-page-tutti-i-moduli.story.md
---

# FailedJobs e JobsWaiting, tabelle nelle Table class

## Fase BMAD

Bugfix e pulizia (blocca la suite: override `final` della base).

## Problema

1. `ListFailedJobs` dichiarava `getTableColumns()` (final nella base). Le colonne ricche
   (uuid, payload, exception) erano nella pagina, mentre `FailedJobsTable` ne aveva una versione
   ridotta: due fonti di verita' diverse, e la pagina era quella rotta.
2. `ListJobsWaiting` (singolare) era un duplicato di `ListJobsWaitings` (plurale). La base costruisce
   l'indice come `List` + plurale del nome Resource, quindi il singolare non veniva mai usato.
3. Il guard `ListPageHasTableClassTest` segnalava un `include` su `JobsTable.php` inesistente: la
   classmap di Composer conservava una voce stale (`JobsWaitingResource\Tables\JobsTable`).

## Intervento

- `FailedJobsTable`: unite le colonne (set ricco) e le header action gia' presenti.
- `ListFailedJobs`: solo `$resource`. Rimossa la copia delle header action dalla pagina.
- Rimosso `Pages/ListJobsWaiting.php` (duplicato non referenziato). Backup in scratchpad.
- `composer dump-autoload -o`: rigenerata la classmap (nessun sorgente toccato).

## Verifica

- `ListPageHasTableClassTest`: verde.
