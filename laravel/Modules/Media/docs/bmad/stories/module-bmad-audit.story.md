---
title: "Module BMAD audit — Media"
type: story
status: review
updated: 2026-11-16
module: Media
bmad: true
qmd: "story BMAD audit modulo Media inventario gate pest phpstan finding guard prunable cast id"
related:
  - ../audits/media-audit.md
  - ../epics.md
  - ../piano-miglioramento.md
---

# Story: audit BMAD profondo del modulo Media

## Contesto

Audit source-first del modulo che custodisce i file-prova e le loro conversioni ([purpose](../purpose.md)).

## Acceptance

- [x] Inventario misurato e finding con `path:line` ([audit profondo](../audits/media-audit.md)).
- [x] Sintesi + gate ([audit](../audit.md)), checklist ([ECC](../../ecc/media-ecc-audit.md)).
- [x] Gap-fill: [architecture](../architecture.md) (riscritta), [decision-log](../decision-log.md), [epics](../epics.md), [brainstorming](../brainstorming.md), [purpose](../purpose.md) (stato del codice).
- [x] Audit + piano in `docs/bmad/`; pack ECC in `docs/ecc/`.
- [x] PHPStan `Modules/Media`: 0 errori.
- [ ] Pest `Modules/Media`: `tests/Unit/Models` 49 pass / 1 fail (`MediaTest.php:369`, E3); resto non eseguito.
- [ ] Pest modulo eseguito per intero in ambiente testing stabile.
- [ ] E1–E6 (finding P1) chiuse con test di regressione.

## Riferimenti

- [audit](../audit.md)
- [piano](../piano-miglioramento.md)
- [ECC](../../ecc/media-ecc-audit.md)

## Procedura seguita

1. Lock dei file di `docs/` del modulo (`bashscripts/lock/`), unlock a fine lavoro.
2. Audit codice → docs; nessun PHP toccato.
3. Pack ECC e indici aggiornati; `qmd update`.

## Esito

Baseline audit aggiornata: PHPStan `Modules/Media` a 0; Pest parziale. 0 P0 dimostrati, 6 P1, P2 elencati. Il primo da chiudere è E1 (guard sulle pagine di diagnostica S3), poi E2 (prune).

