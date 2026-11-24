---
title: "Contratto — ClearScheduleCacheAction"
type: contract
action: "Modules\Job\Actions\ClearScheduleCacheAction"
tags: [contract, action, cache, schedule, legacy]
created: 2026-11-24
updated: 2026-11-24
---

# ClearScheduleCacheAction

Sorgente: `app/Actions/ClearScheduleCacheAction.php`. Chiamanti: `Observers/ScheduleObserver.php::clearCache()`
(su created/updated/saved/deleted di `Schedule`, solo se `config('job::cache.enabled')`) e
`Console/Commands/ScheduleClearCacheCommand.php` (sempre). Contratto di codice legacy: descrive com'è.

## Input

- Nessun parametro. Legge `config('job::cache.store')` e `config('job::cache.key')`.

## Output

- `void`.

## Invarianti

| ID | Regola | Group Pest |
|---|---|---|
| JOB-SCHED-CACHE-INV-1 | Cancella una sola chiave (`job::cache.key`) su un solo store (`job::cache.store`), mai un flush dello store. | — |
| JOB-SCHED-CACHE-INV-2 | Store e chiave sono gli stessi che `GetActiveSchedulesAction` usa per `rememberForever`. | — |

## Effetti collaterali

- `Cache::store($store)->forget($key)`.

## Errori

- `Webmozart\Assert\InvalidArgumentException` se `job::cache.store` o `job::cache.key` non sono stringhe. Nel checkout
  attuale `config/config.php` di Job ritorna `[]` e queste chiavi non esistono (vedi docblock di `JobConfigData`):
  l'observer non chiama mai l'Action (`enabled` è null), mentre `ScheduleClearCacheCommand` fallisce su questa Assert.

## Non fa

- Non ricarica la cache: la ripopola il prossimo `GetActiveSchedulesAction::execute()` con cache attiva.
- Non tocca la cache dello scheduler di Laravel (`schedule:clear-cache` è un altro comando).
- Esiste un duplicato con lo stesso corpo, `Modules\Job\Actions\Schedule\ClearScheduleCacheAction`, senza chiamanti in
  produzione (la story `../stories/job-services-to-actions.story.md` lo dichiara come versione da tenere, il codice usa questa):
  non creare una terza copia; chi consolida sceglie una delle due e aggiorna questo contratto.
