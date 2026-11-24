---
title: "Contratto — GetUserActivitiesAction"
type: contract
owner: Activity
status: accepted
updated: 2026-11-24
action: "Modules\\Activity\\Actions\\Query\\GetUserActivitiesAction"
qmd: "contract GetUserActivitiesAction activity query attivita causate da utente causer_id causer_type ACT-QUSER"
---

# GetUserActivitiesAction

Restituisce le attività causate da un utente.

## Input

- `UserContract $user`: deve essere anche un Eloquent `Model`.
- `int $limit = 50`: numero massimo di righe, positivo.

## Output

- `Collection<int, Activity>`: dalla più recente, con `subject` eager-loaded.

## Invarianti

| ID | Regola | Test |
|---|---|---|
| `ACT-QUSER-INV-1` | Un utente che non è un `Model` lancia `InvalidArgumentException('User must be an Eloquent model')`. | Test: nessuno che asserisca il messaggio |
| `ACT-QUSER-INV-2` | `$limit <= 0` lancia `InvalidArgumentException('Limit must be positive')`. | Test: nessuno diretto |
| `ACT-QUSER-INV-3` | Un'attività è dell'utente solo se `causer_id` e `causer_type` coincidono entrambi. Attività con solo `causer_id` (fallback su `Auth::id()`, vedi `log-activity-action.md`) sono escluse. | Test: nessuno |

## Effetti collaterali

Sola lettura.

## Errori

- `InvalidArgumentException` (INV-1, INV-2).

## Non fa

- Non filtra per tipo evento.
- INV-3 è una conseguenza da segnalare: un'attività scritta con l'utente autenticato ma senza `$user` esplicito non appare qui.

