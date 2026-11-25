---
title: "Topic log-model"
type: digest
status: active
qmd: "digest ceiling 100 log-model"
---

# Topic log-model

Sintesi automatica di 3 documenti (chiave `log-model`).

## LogModelCreatedAction

_Fonte: `contracts/log-model-created-action.md`_

# LogModelCreatedAction

Registra l'evento `created` di un modello Eloquent con i suoi attributi.

## Input

- Costruttore: `?Model $model`, `?Model $user`. `execute(?Model $model = null)`: se passato, prevale sul costruttore.

## Output

- `Activity` con `event = 'created'`, `description = '<Basename> created'`, `properties = ['attributes' => getAttributes()]`.

## Invarianti

| ID | Regola | Test |
|---|---|---|
| `ACT-MCREATE-INV-1` | Senza modello lancia `InvalidArgumentException('A model is required')`. | Test: nessuno che asserisca il messaggio |
| `ACT-MCREATE-INV-2` | Il tipo è `created`; l'utente è considerato solo se è un `Model`. | `CoverageHundredActionsTest.php` (~riga 177, `event = 'created'`) |
| `ACT-MCREATE-INV-3` | Gli attributi sono salvati così come sono in `getAttributes()`, senza redazione. | Test: nessuno |

## Effetti collaterali

- Un `INSERT` in `activity_log` tramite `LogActivityAction`.

## Errori

- `InvalidArgumentException` (INV-1).

## Non fa

## LogModelDeletedAction

_Fonte: `contracts/log-model-deleted-action.md`_

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

## LogModelUpdatedAction

_Fonte: `contracts/log-model-updated-action.md`_

# LogModelUpdatedAction

Registra l'evento `updated` di un modello Eloquent con valori precedenti, nuovi e modificati.

## Input

- Costruttore: `?Model $model`, `?Model $user`. `execute(?Model $model = null)`: se passato, prevale sul costruttore.

## Output

- `Activity` con `event = 'updated'`, `description = '<Basename> updated'`, `properties = ['old' => getOriginal(), 'new' => getAttributes(), 'changes' => getChanges()]`.

## Invarianti

| ID | Regola | Test |
|---|---|---|
| `ACT-MUPDATE-INV-1` | Senza modello lancia `InvalidArgumentException('A model is required')`. | Test: nessuno che asserisca il messaggio |
| `ACT-MUPDATE-INV-2` | Il tipo è `updated`; `properties` ha le chiavi `old`, `new`, `changes`. | Test: nessuno sulle chiavi |
| `ACT-MUPDATE-INV-3` | `changes` è quello che il modello espone al momento della chiamata: l'Action è valida se chiamata dopo il `save()`. | Test: nessuno |

## Effetti collaterali

- Un `INSERT` in `activity_log` tramite `LogActivityAction`. Il modello non viene modificato.

## Errori

- `InvalidArgumentException` (INV-1).

## Non fa
