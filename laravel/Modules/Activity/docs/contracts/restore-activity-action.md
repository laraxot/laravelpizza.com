---
title: "Contratto — RestoreActivityAction"
type: contract
owner: Activity
status: accepted
updated: 2026-11-24
action: "Modules\\Activity\\Actions\\RestoreActivityAction"
qmd: "contract RestoreActivityAction activity ripristino record valori precedenti update fillable pagina log ACT-RESTORE"
tags: [contract, action, activity-log, restore]
created: 2026-11-24
related:
  - ../../app/Actions/RestoreActivityAction.php
  - ../../app/Filament/Pages/ListLogActivities.php
  - ../../tests/Unit/Actions/RestoreActivityActionExecuteTest.php
---

# RestoreActivityAction

Ripristina un record con i valori precedenti di un'attività (`old` di un evento `updated`). Chiamata da `ListLogActivities` (riga 193).

## Input

- `Model $record`: record da aggiornare.
- `array<string, mixed> $oldProperties`: valori da riportare; non vuoto.
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

| ID | Regola | Test |
|---|---|---|
| `ACT-RESTORE-INV-1` | `$oldProperties` vuoto lancia `InvalidArgumentException('Old properties cannot be empty')` prima di toccare il record (fuori dal `try`). | `RestoreActivityActionTest.php`, `RestoreActivityActionExecuteTest.php` (percorsi, non verificati nel dettaglio) |
| `ACT-RESTORE-INV-2` | Il record è aggiornato con `update($oldProperties)`: valgono `$fillable` e la gestione del modello per gli attributi non assegnabili. | `RestoreActivityActionExecuteTest.php` (fixture `RestoreActivityEmptyModel`) |
| `ACT-RESTORE-INV-3` | Ogni eccezione di `update()` è rilanciata come `Exception('Restore failed: <messaggio>')` con codice `(int) getCode()` e precedente incapsulato. | Fixture `RestoreActivityActionFails` (verifica da confermare) |

## Effetti collaterali

- `UPDATE` del record tramite `update()`: scattano gli eventi Eloquent del modello.
- Nessuna transazione. Nessuna attività registrata per il ripristino dentro l'Action.

## Errori

- `Webmozart\Assert\InvalidArgumentException` se l'array è vuoto (INV-1).
- `Exception('Restore failed: ...')` per errori di update (INV-3). Il codice SQL, spesso stringa, diventa `0`.

## Non fa

- Non verifica che `$oldProperties` appartenga al record né che le chiavi siano attese (per esempio `id`, `created_at`).
- Non controlla l'autorizzazione: è responsabilità della pagina.

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
