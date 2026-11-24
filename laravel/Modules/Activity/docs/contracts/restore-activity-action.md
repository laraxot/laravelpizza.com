---
title: "Contratto — RestoreActivityAction"
type: contract
owner: Activity
status: accepted
updated: 2026-11-24
action: "Modules\\Activity\\Actions\\RestoreActivityAction"
qmd: "contract RestoreActivityAction activity ripristino record valori precedenti update fillable pagina log ACT-RESTORE"
---

# RestoreActivityAction

Ripristina un record con i valori precedenti di un'attività (`old` di un evento `updated`). Chiamata da `ListLogActivities` (riga 193).

## Input

- `Model $record`: record da aggiornare.
- `array<string, mixed> $oldProperties`: valori da riportare; non vuoto.

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

