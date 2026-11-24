---
title: "CreateJsonFileByRecordAction — contratto"
type: contract
owner: Tenant
status: accepted
updated: 2026-11-24
action: "Modules\\Tenant\\Actions\\Json\\CreateJsonFileByRecordAction"
qmd: "CreateJsonFileByRecordAction creazione record file JSON tenant sushi id max timestamp"
---

# CreateJsonFileByRecordAction

Aggiunge al file JSON del tenant la riga del record nuovo. Codice: `app/Actions/Json/CreateJsonFileByRecordAction.php:22-48`.

## Input

- `Model&HasSushiToJson $record`: record nuovo, senza chiave assegnata.

## Output

- `void`.

## Invarianti

| ID | Regola | Prova nel codice | Test esistente |
|---|---|---|---|
| `CREATE-JSON-INV-1` | L'id nuovo è `max(0, id esistenti) + 1`; con il massimo cancellato, l'id viene riusato. | righe 35-40 | `tests/Unit/Actions/CreateJsonFileByRecordActionStringIdTest.php` |
| `CREATE-JSON-INV-2` | `created_at` e `updated_at` valgono `now()`. | righe 30-31 | `tests/Unit/Actions/Json/JsonFileByRecordActionsTest.php` |
| `CREATE-JSON-INV-3` | Il file viene riscritto come lista, con le chiavi dello schema garantite. | righe 42-47 | `tests/Unit/Actions/Json/JsonFileByRecordActionsTest.php` |

## Effetti collaterali

Ordine: lettura righe, `setAttribute` su timestamp e id (il record viene modificato), `EnsureKeysAction`, `SaveArrayAction` sul file. Nessuna transazione, nessun lock, nessun evento dell'Action.

## Errori

- Le eccezioni di `SaveArrayAction` si propagano.

## Non fa

- Non valida gli attributi.
- Due creazioni concorrenti possono ottenere lo stesso id: non c'è lock.
- Non garantisce id monotoni.
