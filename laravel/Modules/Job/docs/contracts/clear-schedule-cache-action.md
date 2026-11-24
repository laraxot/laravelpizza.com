---
<<<<<<< .merge_file_m9wlYD
<<<<<<< .merge_file_djp61H
<<<<<<< .merge_file_X52Y6E
title: "Contratto — ClearScheduleCacheAction (Schedule)"
type: contract
owner: Job
status: accepted
updated: 2026-11-24
action: "Modules\\Job\\Actions\\Schedule\\ClearScheduleCacheAction"
qmd: "ClearScheduleCacheAction schedule cache forget job::cache.store job::cache.key JOB-CACHE-INV"
---

# ClearScheduleCacheAction (Schedule)

Invalida la voce di cache degli schedule. Codice: `app/Actions/Schedule/ClearScheduleCacheAction.php:17-27`.

## Input

- Nessun argomento. Legge `config('job::cache.store')` e `config('job::cache.key')`, entrambe asserite `string` (righe 23-24).
=======
=======
>>>>>>> .merge_file_Bc5hrt
=======
>>>>>>> .merge_file_LNSZBa
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
<<<<<<< .merge_file_m9wlYD
<<<<<<< .merge_file_djp61H
>>>>>>> .merge_file_QFr01p
=======
>>>>>>> .merge_file_Bc5hrt
=======
>>>>>>> .merge_file_LNSZBa

## Output

- `void`.

## Invarianti

<<<<<<< .merge_file_m9wlYD
<<<<<<< .merge_file_djp61H
<<<<<<< .merge_file_X52Y6E
| ID | Regola | Test |
|---|---|---|
| `JOB-CACHE-INV-1` | Se le due config sono stringhe, viene dimenticata solo la chiave `job::cache.key` dallo store `job::cache.store`. | Nessuno comportamentale: `tests/Unit/Actions/ClearScheduleCacheActionTest.php:15-30` verifica solo struttura (reflection). |
| `JOB-CACHE-INV-2` | Se una delle due config non e' stringa, lancia `Webmozart\Assert\InvalidArgumentException` prima di toccare la cache. | Test: nessuno. |

Nota su INV-2: `job::cache.*` non e' definita in nessun file del modulo (`config/config.php` restituisce `[]`; `app/Datas/JobConfigData.php:18-19` dichiara le chiavi inesistenti). Con la configurazione attuale l'Action lancia sempre.

## Effetti collaterali

- Una sola operazione: `Cache::store($store)->forget($key)` (riga 26). Nessuna transazione, nessun evento, nessuna coda, nessun servizio esterno.

## Errori

- `Webmozart\Assert\InvalidArgumentException` se `job::cache.store` o `job::cache.key` non sono stringhe.

## Non fa

- Non controlla `job::cache.enabled`: il guardia sta nei chiamanti.
- Non svuota lo store intero e non tocca altre chiavi.
- Chiamanti verificati: `Observers/ScheduleObserver.php:62-66` (protetto da `config('job::cache.enabled')`, che e' null, quindi non raggiunge l'Action) e `Console/Commands/ScheduleClearCacheCommand.php:30` (comando `schedule:clear-cache`, **senza** guardia: con la config attuale fallisce). Da verificare a runtime.
=======
=======
>>>>>>> .merge_file_Bc5hrt
=======
>>>>>>> .merge_file_LNSZBa
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
<<<<<<< .merge_file_m9wlYD
<<<<<<< .merge_file_djp61H
>>>>>>> .merge_file_QFr01p
=======
>>>>>>> .merge_file_Bc5hrt
=======
>>>>>>> .merge_file_LNSZBa
