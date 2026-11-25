---
title: "Contratto — BuildQueueWorkerCommandAction"
type: contract
owner: Job
status: accepted
updated: 2026-11-24
action: "Modules\\Job\\Actions\\BuildQueueWorkerCommandAction"
qmd: "BuildQueueWorkerCommandAction riga shell worker queue:work timeout sleep tries worker:check JOB-WORKER-INV"
tags: [contract, action, queue, worker, shell]
created: 2026-11-24
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
Sorgente: `app/Actions/BuildQueueWorkerCommandAction.php`. Perché esiste:
[ADR flag del worker dalle impostazioni del tenant](../adr/queue-worker-flags-from-tenant-settings.md).
Unico chiamante: `Console/Commands/WorkerCheck.php::startQueueListener()`, che passa il risultato a `Safe\exec()`.

## Input

- Nessun parametro. Legge `JobConfigData::make()` (config `job` del tenant corrente).

## Output

- `string`: la riga di shell
  ` /usr/local/bin/php <base_path>/artisan queue:work --timeout=<int> --sleep=<int> --tries=<int> > /dev/null & echo $!`.

## Invarianti

| ID | Regola | Group Pest |
|---|---|---|
| JOB-WORKER-CMD-INV-1 | Senza impostazioni salvate la riga è identica byte per byte a quella storica (`--timeout=60 --sleep=5 --tries=3`). | `JOB-WORKER-CMD-INV-1` |
| JOB-WORKER-CMD-INV-2 | I tre flag sono i valori salvati in `JobConfigData` (`timeout_seconds`, `sleep_seconds`, `max_attempts`). | `JOB-WORKER-CMD-INV-2` |
| JOB-WORKER-CMD-INV-3 | Nella riga entrano solo interi (proprietà `int` della Data) e `base_path()`: nessun testo scelto da un utente. | — |

## Effetti collaterali

- Nessuno: costruisce una stringa. L'esecuzione (`exec`) e il salvataggio del PID in `queue.pid` sul disco `cache`
  sono di `WorkerCheck`.

## Errori

- Nessuna eccezione propria; un valore non intero nel file del tenant fa fallire la costruzione di `JobConfigData`.

## Non fa

- Non avvia il worker e non controlla se è già attivo (`WorkerCheck::isQueueListenerRunning()`).
- Non legge `config('queue.*')` né sceglie la connessione o la coda: `queue:work` usa i default dell'applicazione.
- Non verifica che `--timeout` sia sotto `retry_after` della connessione.
- Non va estesa con opzioni stringa libere: ogni valore nuovo nella riga passa da una proprietà tipizzata della Data.
