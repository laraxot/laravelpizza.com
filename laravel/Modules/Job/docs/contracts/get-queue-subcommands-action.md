---
title: "Contratto — GetQueueSubcommandsAction"
type: contract
owner: Job
status: accepted
updated: 2026-11-24
action: "Modules\\Job\\Actions\\Console\\GetQueueSubcommandsAction"
qmd: "GetQueueSubcommandsAction sottocomandi queue clear failed flush retry restart JOB-CONSOLE"
---

# GetQueueSubcommandsAction

Elenca i sottocomandi `queue:*` ammessi. Codice: `app/Actions/Console/GetQueueSubcommandsAction.php:9-27`.

## Input

- Nessuno.

## Output

- `list<string>`: `clear`, `failed`, `flush`, `prune-batches`, `prune-failed`, `restart`, `retry` (senza il prefisso `queue:`).

## Invarianti

| ID | Regola | Test |
|---|---|---|
| `JOB-CONSOLE-INV-2` | L'output e' la lista letterale sopra, senza prefisso. | Test: nessuno. |

## Effetti collaterali

- Nessuno.

## Errori

- Nessuno.

## Non fa

- Non verifica che i sottocomandi esistano in Artisan.
- Chiamanti non trovati per nome fuori dai test.
