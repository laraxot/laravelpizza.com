---
title: "Job: risoluzione dei problemi"
type: troubleshooting
module: Job
status: active
qmd: "Job troubleshooting worker check queue.pid retry_after failed_jobs scheduler cache marker di conflitto"
related:
  - ./architecture.md
  - ./audit.md
  - ./adr/0003-queue-worker-flags-from-tenant-settings.md
---

# Job: risoluzione dei problemi

Sintomi realmente osservabili in questo modulo, con la causa nel codice. Per i problemi generici delle code di
Laravel (timeout, memoria, tentativi) valgono le opzioni standard di `queue:work` (`--timeout`, `--tries`,
`--max-jobs`, `--max-time`, `--memory`) e i comandi `queue:failed`, `queue:retry`, `queue:flush`.

| Sintomo | Causa e rimedio |
|---|---|
| Il worker non parte dal pulsante di `JobStatus` o da `worker:check` | Il comando avvia `queue:work` con una riga di shell (`> /dev/null & echo $!`) e controlla il PID salvato in `queue.pid` sul disco `cache`. Il percorso dell'eseguibile PHP (`/usr/local/bin/php`) e' scritto in `BuildQueueWorkerCommandAction`: vale per l'immagine attuale. Verificare il PID e il disco `cache` |
| I job vengono rieseguiti mentre sono ancora in corso | `timeout_seconds` di `SettingPage` deve restare **sotto** `retry_after` della connessione di coda; nessun controllo lo impone (ADR 0003) |
| Un job finisce in `failed_jobs` e non si capisce perche' | Aprire `FailedJobResource`; per gli import, `FailedImportRowResource` mostra riga ed errore di validazione (`validation_error`) |
| Le schedulazioni create dalla UI non girano mai | Atteso: lo scheduler su DB non e' cablato (`registerSchedule` commentato) e "esegui ora" lancia `BadMethodCallException`. Vedi D-2 e P0-2 in [audit.md](audit.md) |
| L'elenco delle schedulazioni attive sembra vecchio | Cache delle schedulazioni attive: `php artisan schedule:clear-cache`. `GetActiveSchedulesAction` legge `job::cache.*`, chiavi che nei file di config non esistono, quindi la cache e' di fatto spenta |
| Un comando Artisan dal pannello risponde "non ammesso" | L'allowlist e' a match esatto: nessun prefisso, nessun argomento libero (`AssertAllowedArtisanCommandAction`, ADR 0001). Per aggiungere un pulsante si aggiunge la voce all'Action di `Console/` che lo espone |
| `Class ... not found` o errori di parsing in un file di documentazione o di codice | Lo script di sincronizzazione dei repository puo' rigenerare i marcatori di conflitto. Controllare `grep -rlE '^(<<<<<<<\|=======\|>>>>>>>)( \|$)' app tests docs` e ripararli prima di lanciare PHPStan |
| I test falliscono in `setUp` con "Unknown database" | Lanciare con `DB_DATABASE_USER=` vuoto; il DB di test deve essere raggiungibile e Pest non si esegue in produzione. Mai `migrate:fresh`, `RefreshDatabase`, `--force` |
