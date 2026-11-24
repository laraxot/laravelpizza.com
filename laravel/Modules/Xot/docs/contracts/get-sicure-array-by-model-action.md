---
title: "GetSicureArrayByModelAction — contratto"
type: contract
owner: Xot
status: accepted
updated: 2026-11-24
action: "Modules\\Xot\\Actions\\Model\\GetSicureArrayByModelAction"
qmd: "GetSicureArrayByModelAction array modello attributesToArray enum ValueError fallback attributi sicuri"
---

# GetSicureArrayByModelAction

Converte un modello in array tollerando valori enum non validi. Codice: `app/Actions/Model/GetSicureArrayByModelAction.php`.

## Input

- `Model $model`.

## Output

- `array<string, mixed>`: `attributesToArray()` se non fallisce, altrimenti gli attributi letti uno per uno.

## Invarianti

- `GET-SICURE-ARRAY-INV-1` — Primo tentativo: `attributesToArray()`. Se lancia `ValueError` o `Error`, si passa al fallback. Prova: `execute()`. Test: nessuno.
- `GET-SICURE-ARRAY-INV-2` — Nel fallback, un attributo che lancia `ValueError` viene omesso dal risultato, senza log. Prova: `execute()`. Test: nessuno.

## Effetti collaterali

Nessuno. Il fallback invoca `getAttribute()` che può eseguire accessor e cast.

## Errori

- Gli errori diversi da `ValueError` nel fallback si propagano; `Error` nel fallback non è catturato.

## Non fa

- Non garantisce completezza: gli attributi con enum non validi spariscono dal risultato senza segnalazione.
