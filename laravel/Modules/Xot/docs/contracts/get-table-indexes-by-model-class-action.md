---
title: "GetTableIndexesByModelClassAction — contratto"
type: contract
owner: Xot
status: accepted
updated: 2026-11-24
action: "Modules\\Xot\\Actions\\Model\\GetTableIndexesByModelClassAction"
qmd: "GetTableIndexesByModelClassAction indici tabella modello introspect Doctrine Index"
---

# GetTableIndexesByModelClassAction

Elenca gli indici della tabella di un modello, via schema manager Doctrine. Codice: `app/Actions/Model/GetTableIndexesByModelClassAction.php`.

## Input

- `string $modelClass`: FQCN del modello.

## Output

- `array<Index>`: indici introspezionati sulla tabella.

## Invarianti

- `GET-TABLE-INDEXES-INV-1` — Il nome tabella non può essere vuoto; il messaggio nomina la classe. Prova: `execute()`. Test: nessuno.
- `GET-TABLE-INDEXES-INV-2` — L'introspezione avviene solo tramite `GetSchemaManagerByModelClassAction`. Prova: `execute()`. Test: nessuno.

## Effetti collaterali

Sola lettura dello schema.

## Errori

- `InvalidArgumentException` se la tabella è vuota; `RuntimeException` ereditata da `GetSchemaManagerByModelClassAction`.

## Non fa

- Dipende interamente dal percorso Doctrine che nel vendor installato non esiste (vedi `GetSchemaManagerByModelClassAction`): oggi lancia sempre. Da correggere prima di usarla.
