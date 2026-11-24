---
title: "Contratti del modulo Job"
type: index
module: Job
status: active
created: 2026-11-18
updated: 2026-11-24
qmd: "job contracts readme azioni invarianti pest group"
---

# Contratti del modulo Job

Un contract descrive il comportamento promesso da una singola Action con effetti collaterali o invarianti di dominio
(cache degli schedule, comandi Artisan dal pannello, avvio del worker). Standard: `Modules/Xot/docs/contracts/contract-authoring-standard.md`,
governance: `Modules/Xot/docs/adr/0012-behavioral-contract-governance.md`.

## Formato

- Frontmatter con `type: contract` e `action: "Modules\\Job\\Actions\\..."`.
- Sezioni nell'ordine: `## Input`, `## Output`, `## Invarianti`, `## Effetti collaterali`, `## Errori`, `## Non fa`.
- Invarianti con ID stabile `JOB-<AREA>-INV-<N>`; ciascuno dovrebbe avere un test Pest con `->group('<ID>')`.
- La classe riporta `@see` e `@contract docs/contracts/<file>.md` nel docblock.

## File presenti

- [clear-schedule-cache-action.md](clear-schedule-cache-action.md) (`JOB-CACHE-INV-1..2`)
- [assert-allowed-artisan-command-action.md](assert-allowed-artisan-command-action.md) (`JOB-CMD-INV-1..2`)
- [build-queue-worker-command-action.md](build-queue-worker-command-action.md) (`JOB-WORKER-INV-1..2`)
- `_template.md`: modello per i nuovi contract.

## Stato di copertura

Nessun test del modulo usa `->group('JOB-...')` (`rg "group\('JOB-" Modules/Job/tests` senza risultati): tutti gli
invarianti sono «non coperti» in senso stretto. Dettagli e backlog in [INDEX.md](INDEX.md).
