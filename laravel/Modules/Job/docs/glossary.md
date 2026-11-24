---
title: "Glossario di dominio Job"
type: glossary
owner: Job
updated: 2026-11-24
qmd: "job glossario dominio schedule task frequency job batch failed job worker whitelist"
---

# Glossario di dominio Job

Termini verificati nel codice con `rg`. Se glossario e codice divergono vale il codice.

| Termine | Significato | Nel codice |
|---|---|---|
| Schedule | Comando Artisan pianificato con espressione cron, parametri, ambienti, opzioni, log e flag `without_overlapping` / `even_in_maintenance_mode`. | `app/Models/Schedule.php`; risorsa `app/Filament/Resources/ScheduleResource.php` |
| Schedule attivo | Schedule il cui `status` e' in `Status::activeCases()`: e' quello eseguito dallo scheduler. | `Schedule::scopeActive()` (`app/Models/Schedule.php:167`), `app/Enums/Status.php` |
| Status | Stato di uno Schedule: `active`, `inactive`, `trashed`, piu' `One` = valore legacy `'1'`, equivalente ad `active`. | `app/Enums/Status.php` |
| Storico esecuzioni | Output e parametri di ogni esecuzione di uno Schedule. | `app/Models/ScheduleHistory.php`, relazione `Schedule::histories` |
| Task | Attivita' pianificata con descrizione, comando, espressione, timezone, flag `is_active`, `dont_overlap`, `run_in_maintenance`. | `app/Models/Task.php` |
| Frequency | Intervallo etichettato (`label`, `interval`) collegato a un Task. | `app/Models/Frequency.php` |
| Parameter | Coppia `name`/`value` collegata a una Frequency. | `app/Models/Parameter.php` |
| Result | Esito di un'esecuzione di Task (`ran_at`, `duration`, `result`). | `app/Models/Result.php` |
| Job in coda | Riga della coda database con `queue`, `payload`, `attempts`, `reserved_at`, `available_at`. | `app/Models/Job.php`, `app/Models/JobsWaiting.php` |
| Failed job | Job fallito con `uuid`, `connection`, `queue`, `payload`, `exception`, `failed_at`. | `app/Models/FailedJob.php`, `app/Filament/Resources/FailedJobResource.php` |
| Job batch | Lotto di job con contatori `total_jobs`, `pending_jobs`, `failed_jobs` e `cancelled_at`. | `app/Models/JobBatch.php` |
| Job manager | Registro di esecuzione di un job (`started_at`, `finished_at`, `failed`, `attempt`, `progress`). | `app/Models/JobManager.php` |
| Import / Export | Esecuzioni di import/export con righe processate/riuscite e, per gli import, righe scartate. | `app/Models/Import.php`, `app/Models/Export.php`, `app/Models/FailedImportRow.php` |
| Pannello di stato | Pagina super-admin che lancia solo comandi Artisan in whitelist. | `app/Filament/Pages/JobStatus.php` (`artisan()`, `getAllowedCommands()`) |
| Whitelist comandi | Elenco dei comandi ammessi dal pannello; il confronto e' esatto. | `app/Actions/Console/AssertAllowedArtisanCommandAction.php` |
| Worker check | Comando che controlla e avvia `queue:work` con i flag di `JobConfigData`. | `app/Console/Commands/WorkerCheck.php` (`worker:check`), `app/Actions/BuildQueueWorkerCommandAction.php` |
| Impostazioni worker | `max_attempts` (`--tries`), `timeout_seconds` (`--timeout`), `sleep_seconds` (`--sleep`) del tenant. | `app/Datas/JobConfigData.php`, pagina `app/Filament/Pages/SettingPage.php` |
| Cache degli schedule | Voce di cache con store e chiave letti da `job::cache.store` / `job::cache.key`, invalidata da `schedule:clear-cache`. | `app/Actions/Schedule/ClearScheduleCacheAction.php`, `app/Console/Commands/ScheduleClearCacheCommand.php` |
