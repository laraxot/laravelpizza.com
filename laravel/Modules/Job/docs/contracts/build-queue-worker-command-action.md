---
title: "Contratto — BuildQueueWorkerCommandAction"
type: contract
owner: Job
status: accepted
updated: 2026-11-24
action: "Modules\\Job\\Actions\\BuildQueueWorkerCommandAction"
qmd: "BuildQueueWorkerCommandAction riga shell worker queue:work timeout sleep tries worker:check JOB-WORKER-INV"
---

# BuildQueueWorkerCommandAction

Costruisce la riga di shell con cui `worker:check` avvia `queue:work`. Codice: `app/Actions/BuildQueueWorkerCommandAction.php:14-27`.

## Input

- Nessun argomento. Legge `JobConfigData::make()`: `timeout_seconds`, `sleep_seconds`, `max_attempts`, tutti `int` (`app/Datas/JobConfigData.php:30-36`, default 60, 5, 3).

## Output

- `string`, con uno spazio iniziale: ` /usr/local/bin/php <base_path()>/artisan queue:work --timeout=<n> --sleep=<n> --tries=<n> > /dev/null & echo $!` (righe 22-26).

## Invarianti

| ID | Regola | Test |
|---|---|---|
| `JOB-WORKER-INV-1` | Le uniche parti variabili della riga sono i tre interi di `JobConfigData`: nessun valore scelto da un utente entra nella shell se non come numero. | `tests/Unit/Datas/JobConfigDataTest.php:48,59,66` |
| `JOB-WORKER-INV-2` | Senza impostazioni salvate la stringa e' identica a quella storica (`--timeout=60 --sleep=5 --tries=3`). | `tests/Unit/Datas/JobConfigDataTest.php:48` |

## Effetti collaterali

Nessuno: restituisce solo la stringa. Non avvia processi (lo fa `WorkerCheck` con `exec`).

## Errori

- Nessuna eccezione propria. Eventuali errori di risoluzione di `JobConfigData::make()` si propagano.

## Non fa

- Non esegue il comando e non verifica se un worker e' gia' attivo.
- Non controlla che `timeout_seconds` resti sotto `retry_after` della connessione (solo nel docblock di `JobConfigData`).
- Il percorso `/usr/local/bin/php` e' fisso nel codice.
- Nota: `base_path()` non viene escapato; un percorso con spazi o caratteri di shell romperebbe la riga. Non verificato a runtime.
