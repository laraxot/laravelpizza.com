---
title: "Contratto — BuildQueueWorkerCommandAction"
type: contract
action: "Modules\Job\Actions\BuildQueueWorkerCommandAction"
tags: [contract, action, queue, worker, shell]
created: 2026-11-24
updated: 2026-11-24
---

# BuildQueueWorkerCommandAction

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
