---
title: "CountAction — contratto"
type: contract
owner: Xot
status: accepted
updated: 2026-11-24
action: "Modules\\Xot\\Actions\\ModelClass\\CountAction"
qmd: "CountAction conteggio record modello information_schema table_rows cache contatore"
---

# CountAction

Restituisce il numero di record di un modello dal contatore memorizzato in `InformationSchemaTable`. Codice: `app/Actions/ModelClass/CountAction.php`.

## Input

- `string $modelClass`: FQCN del modello.

## Output

- `int`: valore di `table_rows` memorizzato.

## Invarianti

| ID | Regola | Test |
|---|---|---|
| `MODEL-COUNT-INV-1` | Se `table_rows` è valorizzato, il risultato è quel valore, anche se non riflette lo stato attuale della tabella. | `tests/Unit/Actions/ModelClass/CountActionsTest.php` (riferisce la classe) |
| `MODEL-COUNT-INV-2` | Se `table_rows` è null, il valore viene calcolato con `count()` e salvato. | Test: nessuno |

## Effetti collaterali

- Può creare una riga in `information_schema_tables` (`firstOrCreate`).
- Se il contatore è null, esegue un `COUNT` e aggiorna la riga. Scritture sul DB anche in una lettura.

## Errori

- Errori della risoluzione del modello sono gestiti dal trait `InformationSchemaTableCounters`, non dall'Action.

## Non fa

- Non ricalcola il conteggio se il valore è già presente: il dato può essere vecchio.
