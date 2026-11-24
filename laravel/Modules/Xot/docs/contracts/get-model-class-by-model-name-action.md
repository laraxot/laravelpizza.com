---
title: "GetModelClassByModelNameAction — contratto"
type: contract
owner: Xot
status: accepted
updated: 2026-11-24
action: "Modules\\Xot\\Actions\\Model\\GetModelClassByModelNameAction"
qmd: "GetModelClassByModelNameAction morph_map config classe modello fallback nome"
---

# GetModelClassByModelNameAction

Risolve il FQCN di un modello per nome, prima dal `morph_map` e poi, in mancanza, scansionando i moduli. Codice: `app/Actions/Model/GetModelClassByModelNameAction.php`.

## Input

- `string $modelName`: nome del modello.

## Output

- `string`: FQCN.

## Invarianti

- `GET-MODEL-CLASS-NAME-INV-1` — `config('morph_map')` deve essere un array, altrimenti lancia. Prova: `execute()`. Test: nessuno.
- `GET-MODEL-CLASS-NAME-INV-2` — Se la chiave non è nel `morph_map`, il risultato è quello di `GetFirstModelClassByModelNameAction`. Prova: `execute()`. Test: nessuno.
- `GET-MODEL-CLASS-NAME-INV-3` — Il valore trovato è una stringa. Prova: `execute()`. Test: nessuno.

## Effetti collaterali

Lettura di configurazione. Nel fallback, scansione dei moduli come in `GetFirstModelClassByModelNameAction`.

## Errori

- `Webmozart\Assert\InvalidArgumentException` se il `morph_map` non è un array o il valore non è stringa, o se il fallback non trova il modello.

## Non fa

- Non verifica che la classe trovata esista.
