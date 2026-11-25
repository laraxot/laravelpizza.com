---
title: "ADR — I flag del worker di coda vengono dalle impostazioni del tenant, solo come interi"
type: decision
status: accepted
created: 2026-11-24
updated: 2026-11-24
module: Job
tags: [adr, queue, worker, settings, tenant, shell]
related:
  - ../contracts/build-queue-worker-command-action.md
qmd: "queue worker flags from tenant settings"
---

# ADR: flag del worker dalle impostazioni del tenant

## Contesto

`Console/Commands/WorkerCheck.php` (`worker:check`, lanciato anche dal pulsante di `JobStatus`) avvia il worker con
`Safe\exec()` di una riga di shell `php artisan queue:work ... > /dev/null & echo $!` e salva il PID in
`queue.pid` sul disco `cache`. I valori `--timeout=60 --sleep=5 --tries=3` erano scritti nel comando. Servivano
diversi per tenant (job lunghi, code lente), ma qualunque valore che arriva in una riga passata a `exec()` è un
punto di iniezione. Come si rendono configurabili i flag senza aprire la shell a un testo scelto da un utente?

## Decisione

- I flag stanno in `app/Datas/JobConfigData.php` (`MakesFromTenantConfig`, file di config `job` del tenant) come
  proprietà **`int`**: `max_attempts` (3), `timeout_seconds` (60), `sleep_seconds` (5). I default sono i valori di
  prima, quindi finché nessuno salva il comando è identico byte per byte.
- La riga di shell la costruisce solo `app/Actions/BuildQueueWorkerCommandAction.php`; `WorkerCheck` la usa così
  com'è. Si modificano da `Filament/Pages/SettingPage.php`, il cui form espone esattamente le proprietà della Data.
- Le chiavi `cache.*` e `jobs.pruning.*` restano fuori dalla pagina di proposito (nessun lettore reale, vedi il
  docblock di `JobConfigData`).

## Alternative scartate

- **Valori in `config/job.php` o `.env`**: uguali per tutti i tenant, e modificabili solo con un deploy.
- **Campo testo libero "argomenti aggiuntivi"**: andrebbe in `exec()` così com'è.
- **`Process` con array di argomenti invece della stringa**: più sicuro in astratto, ma il worker deve restare in
  background con `& echo $!` per ricavare il PID che `WorkerCheck` controlla; cambiare il meccanismo di avvio è una
  decisione separata.

## Conseguenze

- Buono: ogni tenant regola il worker dal pannello; il tipo `int` della Data è la sanificazione.
- Cattivo: il percorso `/usr/local/bin/php` resta scritto nell'Action (vale per l'immagine attuale).
- Vincolo: `timeout_seconds` deve restare sotto `retry_after` della connessione di coda; nessun controllo lo impone.

## Verifica

- `cd laravel && vendor/bin/pest Modules/Job/tests/Unit/Datas/JobConfigDataTest.php`: fallisce se senza impostazioni
  salvate il comando cambia anche di un byte, se i flag salvati non arrivano nel comando, se `WorkerCheck` non usa
  l'Action o se la pagina espone campi diversi dalle proprietà della Data.
- `--group=JOB-WORKER-CMD-INV-1` e `--group=JOB-WORKER-CMD-INV-2` (contratto di `BuildQueueWorkerCommandAction`).
- Solo revisione: una proprietà nuova di `JobConfigData` che finisce nella riga di shell deve essere `int` o `bool`.
