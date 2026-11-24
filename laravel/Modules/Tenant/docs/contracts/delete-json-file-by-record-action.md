---
title: "DeleteJsonFileByRecordAction — contratto"
type: contract
owner: Tenant
status: accepted
updated: 2026-11-24
action: "Modules\\Tenant\\Actions\\Json\\DeleteJsonFileByRecordAction"
qmd: "DeleteJsonFileByRecordAction cancellazione record file JSON tenant chiave numerica Assert riscrittura"
---

# DeleteJsonFileByRecordAction

Rimuove dal file JSON del tenant la riga del record cancellato. Codice: `app/Actions/Json/DeleteJsonFileByRecordAction.php:22-52`.

## Input

- `Model&HasSushiToJson $record`: record con chiave.

## Output

- `void`.

## Invarianti

| ID | Regola | Prova nel codice | Test esistente |
|---|---|---|---|
| `DELETE-JSON-INV-1` | La chiave deve essere un intero o una stringa di sole cifre; altrimenti `Assert` lancia. Questo esclude le chiavi UUID, che `UpdateJsonFileByRecordAction` accetta: incoerenza tra le due Action. | riga 34 | nessuno |
| `DELETE-JSON-INV-2` | La riga con quella chiave è rimossa e il file è riscritto come lista. | righe 38-50 | nessuno |
| `DELETE-JSON-INV-3` | Se la chiave non esiste, il file è riscritto invariato. | righe 40-50 | nessuno |

## Effetti collaterali

Ordine: lettura righe, `Arr::forget`, `EnsureKeysAction`, `SaveArrayAction`. Nessuna transazione, nessun evento dell'Action. Non cancella nulla dal database (Sushi usa SQLite in memoria).

## Errori

- `Webmozart\Assert` lancia `InvalidArgumentException` per chiavi non numeriche.
- Le eccezioni di `SaveArrayAction` si propagano.

## Non fa

- Non verifica dipendenze o relazioni con altri record.
- Non rimuove record dal database.
