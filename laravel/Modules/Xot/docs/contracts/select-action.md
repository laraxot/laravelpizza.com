---
title: "SelectAction — contratto"
type: contract
owner: Xot
status: accepted
updated: 2026-11-24
action: "Modules\\Xot\\Actions\\ModelClass\\SelectAction"
qmd: "SelectAction query SQL grezza connessione modello select raw"
---

# SelectAction

Esegue una query SQL grezza sulla connessione del modello indicato. Codice: `app/Actions/ModelClass/SelectAction.php`.

## Input

- `string $modelClass`: FQCN del modello, usato solo per la connessione.
- `string $sql`: SQL completo, senza bind.

## Output

- `array`: righe restituite da `Connection::select()`.

## Invarianti

| ID | Regola | Test |
|---|---|---|
| `MODEL-SELECT-INV-1` | La query viene eseguita sulla connessione del modello. | Test: nessuno |

## Effetti collaterali

- Esegue l'SQL così com'è: lettura o scrittura dipendono solo dalla stringa. Nessuna transazione.

## Errori

- `QueryException` del database si propaga.

## Non fa

- Non usa binding: se `$sql` contiene dati esterni, il rischio è SQL injection. Il chiamante deve garantire che l'SQL sia costruito in modo sicuro.
- Non impone di essere in sola lettura.
