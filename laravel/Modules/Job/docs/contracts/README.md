---
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
