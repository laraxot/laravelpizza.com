---
title: "Contratto — LogActivityAction"
type: contract
owner: Activity
status: accepted
updated: 2026-11-24
action: "Modules\\Activity\\Actions\\LogActivityAction"
qmd: "contract LogActivityAction activity scrittura singola attivita causer subject properties log_name Auth fallback ACT-LOGACT"
---

# LogActivityAction

Scrive una riga in `activity_log`. È il punto comune usato da `LogModel*Action`, `LogUser*Action`.

## Input

- Costruttore: `string $type` (non vuoto), `?Model $user`, `?Model $subject`, `?array $properties`, `?string $description`.
- `execute()`: nessun argomento.

## Output

- `Activity`: la riga creata.

## Invarianti

| ID | Regola | Test |
|---|---|---|
| `ACT-LOGACT-INV-1` | `$type` vuoto lancia `InvalidArgumentException('Type cannot be empty')` al costruttore. | `LogActivityActionConstructorTest.php` |
| `ACT-LOGACT-INV-2` | Un `$user` non null che non è `UserContract` lancia `InvalidArgumentException('User must implement UserContract')` in `execute()`. | `LogActivityActionExecuteValidationTest.php` |
| `ACT-LOGACT-INV-3` | `causer_id` è l'id dell'utente passato; senza utente è `Auth::id()` solo se int o stringa. `causer_type` è la classe dell'utente passato, altrimenti `null`. | Test: nessuno sul caso senza utente |
| `ACT-LOGACT-INV-4` | `description` di default è `Activity: <type>`; `log_name` è il tipo; `event` è il tipo. | Test: nessuno |

## Effetti collaterali

- `INSERT` in `activity_log` tramite `Activity::typedQuery()->create()`. Nessuna transazione esplicita, nessun evento dispatchato dall'Action.

## Errori

- `InvalidArgumentException` (INV-1, INV-2). Errori di database si propagano.

## Non fa

- Non redige `properties`.
- Non verifica che la classe del soggetto esista.
- Incoerenze da segnalare:
  - `causer_id` può valorizzarsi da `Auth::id()` con `causer_type = null` (INV-3): l'attività non compare in `GetUserActivitiesAction`.
  - `log_name` vale il tipo qui, mentre `ActivityLogger::log()` e `RecordSubjectActivityAction` usano `'default'`.

