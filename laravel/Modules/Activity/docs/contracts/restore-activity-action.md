---
title: "Contratto — RestoreActivityAction"
type: contract
action: "Modules\Activity\Actions\RestoreActivityAction"
tags: [contract, action, activity-log, restore]
created: 2026-11-24
updated: 2026-11-24
related:
  - ../../app/Actions/RestoreActivityAction.php
  - ../../app/Filament/Pages/ListLogActivities.php
  - ../../tests/Unit/Actions/RestoreActivityActionExecuteTest.php
---

# RestoreActivityAction

Riporta un record ai valori che aveva prima di una modifica, presi dalle `properties.old` di un'attività registrata.
Chiamante: la pagina `app/Filament/Pages/ListLogActivities.php` (azione «ripristina» sulla cronologia di un record).
Sorgente: `app/Actions/RestoreActivityAction.php`.

Test: `cd laravel && vendor/bin/pest Modules/Activity/tests/Unit/Actions/RestoreActivityActionExecuteTest.php`.

## Input

- `Model $record`: il record da ripristinare.
- `array<string, mixed> $oldProperties`: i valori precedenti, così come stanno nell'attività.

## Output

- `void`.

## Invarianti

| ID | Regola | Group Pest |
|---|---|---|
| ACTIVITY-RESTORE-INV-1 | Il record riceve un solo `update()` con esattamente i valori passati. | `ACTIVITY-RESTORE-INV-1` |
| ACTIVITY-RESTORE-INV-2 | Valori vuoti = eccezione prima di toccare il record (`Assert::notEmpty`). | `ACTIVITY-RESTORE-INV-2` |
| ACTIVITY-RESTORE-INV-3 | Un errore dell'update esce come `Exception('Restore failed: …')` con l'eccezione originale come `previous`. | `ACTIVITY-RESTORE-INV-3` |

## Effetti collaterali

- `Model::update($oldProperties)`: scrive nel DB del record ed esegue eventi, observer e (se il modello usa
  `LogsActivity`) una nuova attività.

## Errori

- `Webmozart\Assert\InvalidArgumentException` per valori vuoti.
- `Exception('Restore failed: …')` per qualunque errore dell'update.

## Non fa

- Non filtra i campi: l'`update` rispetta solo `$fillable`/`$guarded` del modello; campi sensibili presenti nelle
  `properties` (password, token) verrebbero riscritti. La pulizia è del chiamante.
- Non apre transazioni né controlla i permessi (lo fa la pagina).
- Non ripristina record cancellati (`restore()` di SoftDeletes): aggiorna solo record esistenti.
