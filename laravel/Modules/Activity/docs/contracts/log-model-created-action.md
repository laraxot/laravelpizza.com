---
title: "Contratto — LogModelCreatedAction"
type: contract
owner: Activity
status: accepted
updated: 2026-11-24
action: "Modules\\Activity\\Actions\\LogModelCreatedAction"
qmd: "contract LogModelCreatedAction activity evento created modello attributi non redatti password ACT-MCREATE"
---

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

- Non redige password, `remember_token` o campi 2FA: `RedactModelAttributesAction` non è chiamata. Gli attributi finiscono in `properties` in chiaro (vedi report).

