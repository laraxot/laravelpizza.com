---
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

## Output

- `void`.

## Invarianti

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
