---
title: "Contratto — ActivityMaintenanceAction"
type: contract
owner: Activity
status: accepted
updated: 2026-11-24
action: "Modules\\Activity\\Actions\\ActivityMaintenanceAction"
qmd: "contract ActivityMaintenanceAction activity cleanup cancellazione vecchie attivita ACT-CLEAN-INV"
---

# ActivityMaintenanceAction

Cancella le attivita' piu' vecchie di N giorni, a blocchi. Raggiunta da `Adapters/ActivityLogger::cleanOld()` (`app/Adapters/ActivityLogger.php:122`).
Tensione da notare con l'[ADR append-oriented](../adr/activity-audit-is-append-oriented.md): questa e' l'unica operazione che rimuove righe di audit.


## Input

- `int $days` (default 90): soglia di anzianita' in giorni.

## Output

- `int`: numero di attivita' cancellate.

## Invarianti

- **ACT-CLEAN-INV-1** — `$days <= 0` lancia `InvalidArgumentException('Days must be positive')` prima di toccare il database.
  Non coperto: nessun test dedicato trovato; `Modules/Activity/tests/Unit/Actions/CoverageHundredActionsTest.php:164` esercita il percorso positivo; nessun `->group('ACT-CLEAN-INV-1')`.
- **ACT-CLEAN-INV-2** — Vengono cancellate solo le attivita' con `created_at < now() - $days giorni`, a blocchi di 1000 (`chunkById`), per evitare lock lunghi.
  Non coperto (nessun `->group('ACT-CLEAN-INV-2')`).

## Effetti collaterali

- `DELETE` sulle righe selezionate del modello `Activity`; se la cancellazione sia soft o fisica dipende dal modello e non e' stata verificata qui.
- `Log::debug('Old activities cleaned', ['deleted_count', 'older_than_days'])`.
- Nessuna transazione unica: un errore a meta' lascia cancellati i blocchi precedenti.

## Errori

- `InvalidArgumentException` (INV-1); le eccezioni del database si propagano.

## Non fa

- Non archivia ne' esporta le righe prima di cancellarle.
- Non filtra per `log_name`, soggetto o causer.
- Non tocca `StoredEvent` ne' `Snapshot`.
