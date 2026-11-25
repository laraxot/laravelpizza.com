---
title: "Contratto: RestoreActivityAction"
type: contract
owner: Activity
status: accepted
updated: 2026-11-25
action: "Modules\\Activity\\Actions\\RestoreActivityAction"
qmd: "contract RestoreActivityAction activity ripristino record valori precedenti update fillable pagina log"
related:
  - ../actions.md
  - ../../app/Actions/RestoreActivityAction.php
  - ../../app/Filament/Pages/ListLogActivities.php
  - ../../tests/Unit/Actions/RestoreActivityActionExecuteTest.php
---

# RestoreActivityAction

Riporta un record ai valori che aveva prima di una modifica, presi dalle `properties.old` di un'attivita'. Chiamata dalla pagina `ListLogActivities` (azione di ripristino sulla cronologia di un record).

## Input

- `Model $record`: il record da aggiornare.
- `array<string, mixed> $oldProperties`: i valori da riportare, non vuoto.

## Output

- `void`.

## Invarianti

| ID | Regola | Test |
|---|---|---|
| ACT-RESTORE-INV-1 | `$oldProperties` vuoto e' rifiutato (`Assert::notEmpty`) prima di toccare il record. | `RestoreActivityActionExecuteTest.php` |
| ACT-RESTORE-INV-2 | Il record riceve un solo `update($oldProperties)`: valgono `$fillable` e `$guarded` del modello. | `RestoreActivityActionExecuteTest.php` |
| ACT-RESTORE-INV-3 | Ogni eccezione dell'`update()` esce come `Exception('Restore failed: <messaggio>')`, con codice `(int) getCode()` e l'originale come `previous`. | `RestoreActivityActionTest.php` |

## Effetti collaterali

- `UPDATE` del record di dominio: scattano eventi Eloquent, observer e, se il modello usa `LogsActivity`, una nuova attivita'. Nessuna transazione.

## Errori

- `Webmozart\Assert\InvalidArgumentException` per valori vuoti.
- `Exception('Restore failed: ...')` per errori di update (un codice SQL stringa diventa `0`).

## Non fa

- Non controlla i permessi: li controlla la pagina (`canRestoreActivity()`).
- Non filtra i campi: segreti presenti nelle `properties` verrebbero riscritti.
- Non ripristina record cancellati con SoftDeletes: aggiorna solo record esistenti.
