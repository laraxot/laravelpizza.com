---
title: "Contratto — GetRecentActivitiesAction"
type: contract
owner: Activity
status: accepted
updated: 2026-11-24
action: "Modules\\Activity\\Actions\\Query\\GetRecentActivitiesAction"
qmd: "contract GetRecentActivitiesAction activity query attivita recenti ultime limite ACT-QRECENT"
---

# GetRecentActivitiesAction

Restituisce le ultime attività registrate, senza filtri.

## Input

- `int $limit = 50`: numero massimo di righe, positivo.

## Output

- `Collection<int, Activity>`: dalla più recente, con `causer` e `subject` eager-loaded.

## Invarianti

| ID | Regola | Test |
|---|---|---|
| `ACT-QRECENT-INV-1` | `$limit <= 0` lancia `InvalidArgumentException('Limit must be positive')` prima della query. | Test: nessuno diretto (il messaggio compare solo in un mock di `AdapterActivityLoggerDelegationTest.php`) |
| `ACT-QRECENT-INV-2` | Nessun filtro, ordine `created_at` decrescente, massimo `$limit` righe. | `QueryAndValidationTest.php` (richiama l'Action, non verificato) |

## Effetti collaterali

Sola lettura.

## Errori

- `InvalidArgumentException` (INV-1).

## Non fa

- Non filtra per utente, tipo o soggetto.

