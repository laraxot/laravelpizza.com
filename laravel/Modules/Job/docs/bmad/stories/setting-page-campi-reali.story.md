---
title: "SettingPage di Job: le opzioni del worker avviato da worker:check"
status: done
module: Job
type: story
qmd: "Job SettingPage worker:check queue:work tries timeout sleep JobConfigData BuildQueueWorkerCommandAction"
related:
  - ../../../../Xot/docs/bmad/stories/setting-page-campi-reali.story.md
  - ./setting-page.story.md
---

# SettingPage di Job: le opzioni del worker avviato da worker:check

## Fase BMAD

Build, dentro la story madre di Xot [setting-page-campi-reali](../../../../Xot/docs/bmad/stories/setting-page-campi-reali.story.md).
Richiesta dell'utente (testuale): "nei SettingPage il metodo getFormSchema non puo restituire [] in ogni modulo c'e'
qualcosa da settare". Sostituisce la bozza [setting-page](./setting-page.story.md) (marcata superseded).

## Cosa si configura davvero

L'unico punto di Job che gira in produzione con parametri scelti dal codice e' `worker:check`: se non trova un worker
vivo avvia `queue:work`. Lo chiama `JobStatusWidget::mount()` (riga 52) a ogni apertura del monitor. I tre flag erano
scritti nel comando (`--timeout=60 --sleep=5 --tries=3`) e ora vengono da `JobConfigData`.

| Campo | Default | Chi lo legge | Note |
|-------|---------|--------------|------|
| `max_attempts` | `3` | `BuildQueueWorkerCommandAction` (`--tries`), chiamata da `WorkerCheck::startQueueListener()` | 1..20 |
| `timeout_seconds` | `60` | idem (`--timeout`) | 1..3600; deve restare sotto `retry_after` della connessione |
| `sleep_seconds` | `5` | idem (`--sleep`) | 1..60 |

Prova che il default e' il comportamento di oggi: il test confronta la riga di shell, byte per byte, con quella
vecchia. Un worker gia' in esecuzione tiene i suoi flag finche' non viene riavviato (detto nell'helper del campo).

## Lasciato fuori, e perche'

- `enabled` (bozza di Codex): nessuno lo legge. Inventare un interruttore che spenga `worker:check` e' una funzione nuova,
  non un'impostazione.
- `timeout_seconds` della bozza valeva `90`: il comando usa `60`. Il default e' stato riportato a `60`.
- `cache.enabled|store|key`: `GetActiveSchedulesAction`, `ClearScheduleCacheAction` e `ScheduleObserver` leggono
  `config('job::cache.*')`. La chiave con `::` non corrisponde a nessun file, quindi vale `NULL`. Ma il livello di cache
  e' codice morto: `GetActiveSchedulesAction` non ha chiamanti, `ScheduleObserver` non e' registrato, nessuno scrive la
  chiave in cache. Non e' una impostazione e non diventa un campo. L'unico effetto vivo e' un guasto: `schedule:clear-cache`
  (comando e pulsante di `ScheduleStatusWidget`) esegue `Assert::string(null)` e lancia sempre. Segnalato, non corretto
  qui: la correzione giusta e' togliere il livello di cache o collegarlo, scelta del proprietario del modulo.
- `jobs.pruning.activate|retention_days` (`JobManager::prunable()`): il modello non usa `Prunable`/`MassPrunable` e nessun
  comando lo richiama; dato morto. Nota: se qualcuno lo collegasse, con `activate` spento `prunable()` ritorna TUTTE le
  righe (cancellerebbe tutto).
- `job::model`, `job::history_collapsed`: stesso problema delle chiavi `job::`, nessun valore e nessun effetto.

## Verifica

- Pest `Modules/Job/tests/Unit/Datas/JobConfigDataTest.php`: 7 test, 13 asserzioni (senza override di `DB_DATABASE`: la
  `TestCase` di Job apre le connessioni sqlite del modulo).
- PHPStan livello max sui file toccati: 0 errori. Pint: passed.
- Non verificato: l'avvio reale di `queue:work` (`exec` non si prova in test; il test controlla la riga di shell e che
  `WorkerCheck` la chiami).
