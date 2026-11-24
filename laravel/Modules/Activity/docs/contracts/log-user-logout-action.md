---
title: "Contratto — LogUserLogoutAction"
type: contract
owner: Activity
status: accepted
updated: 2026-11-24
action: "Modules\\Activity\\Actions\\LogUserLogoutAction"
qmd: "contract LogUserLogoutAction activity evento logout utente causer subject ACT-LOGOUT"
---

# LogUserLogoutAction

Registra il logout di un utente. Il soggetto e il causer sono l'utente stesso.

## Input

- Costruttore: `?UserContract $user`. `execute(?UserContract $user = null)`: se passato, prevale sul costruttore.

## Output

- `Activity` con `event = 'logout'`, `description = 'User logged out'`, `subject` e `causer` = l'utente.

## Invarianti

| ID | Regola | Test |
|---|---|---|
| `ACT-LOGOUT-INV-1` | Se l'utente risolto non è un `Model` lancia `InvalidArgumentException('User must implement UserContract and extend Model')`. | `LogUserLogoutActionTest.php`, `ActivityActionsUnitTest.php` (percorsi, non verificati nel dettaglio) |
| `ACT-LOGOUT-INV-2` | Il tipo è `logout`; `subject_type` è la classe dell'utente. | Test: nessuno diretto |

## Effetti collaterali

- Un `INSERT` in `activity_log` tramite `LogActivityAction`.

## Errori

- `InvalidArgumentException` (INV-1).

## Non fa

- Non invalida la sessione.
- Il listener che la chiama non è in questo contract.

