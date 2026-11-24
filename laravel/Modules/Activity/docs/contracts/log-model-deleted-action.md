---
title: "Contratto — LogModelDeletedAction"
type: contract
owner: Activity
status: accepted
updated: 2026-11-24
action: "Modules\\Activity\\Actions\\LogModelDeletedAction"
qmd: "contract LogModelDeletedAction activity evento deleted modello attributi non redatti ACT-MDELETE"
---

# LogModelDeletedAction

Registra l'evento `deleted` di un modello Eloquent con i suoi attributi.

## Input

- Costruttore: `?Model $model`, `?Model $user`. `execute(?Model $model = null)`: se passato, prevale sul costruttore.

## Output

- `Activity` con `event = 'deleted'`, `description = '<Basename> deleted'`, `properties = ['attributes' => getAttributes()]`.

## Invarianti

| ID | Regola | Test |
|---|---|---|
| `ACT-MDELETE-INV-1` | Senza modello lancia `InvalidArgumentException('A model is required')`. | Test: nessuno che asserisca il messaggio |
| `ACT-MDELETE-INV-2` | Il tipo è `deleted`; l'utente è considerato solo se è un `Model`. | `ActivityActionsUnitTest.php`, `CoverageHundredActionsTest.php` (percorso, non verificato nel dettaglio) |
| `ACT-MDELETE-INV-3` | Gli attributi sono salvati senza redazione. | Test: nessuno |

## Effetti collaterali

- Un `INSERT` in `activity_log` tramite `LogActivityAction`. Il modello non viene modificato.

## Errori

- `InvalidArgumentException` (INV-1).

## Non fa

- Non distingue cancellazione soft da fisica.
- Non redige gli attributi sensibili (vedi `redact-model-attributes-action.md`).

