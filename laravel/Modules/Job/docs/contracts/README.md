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
title: "Contratti — Job"
type: index
tags: [contracts, actions, job]
created: 2026-11-18
updated: 2026-11-24
---

# Contratti — Job

Cosa promettono le Action di Job che decidono se un comando gira, costruiscono la riga di shell del worker o
toccano la cache delle schedulazioni, e cosa **non** fanno (l'autorizzazione e l'esecuzione restano ai chiamanti).

**Quando leggerli**: prima di chiamare, modificare o imitare una di queste Action, o di aggiungere un chiamante a
`exec()` / `Artisan::call()` nel modulo.

Formato (6 sezioni, tabella invarianti con ID e group Pest, `@contract` nel docblock):
[action-behavioral-contract](../../../Xot/docs/rules/action-behavioral-contract.md). Un'invariante con group si
verifica con `vendor/bin/pest Modules/Job/tests --group=<ID>`; `—` è debito dichiarato.

## Contratti

- [AssertAllowedArtisanCommandAction](assert-allowed-artisan-command-action.md) — ammette un comando solo se identico a una voce dell'allowlist.
- [BuildQueueWorkerCommandAction](build-queue-worker-command-action.md) — la riga `queue:work` di `worker:check`, con i flag interi del tenant.
- [ClearScheduleCacheAction](clear-schedule-cache-action.md) — dimentica la cache delle schedulazioni attive (legacy, chiavi di config assenti).
