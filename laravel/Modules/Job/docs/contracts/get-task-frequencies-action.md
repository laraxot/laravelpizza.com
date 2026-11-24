---
title: "Contratto — GetTaskFrequenciesAction"
type: contract
owner: Job
status: accepted
updated: 2026-11-24
action: "Modules\\Job\\Actions\\GetTaskFrequenciesAction"
qmd: "GetTaskFrequenciesAction frequenze totem config schedule JOB-FREQ"
---

# GetTaskFrequenciesAction

Restituisce le frequenze di schedulazione definite in `totem.frequencies`. Codice: `app/Actions/GetTaskFrequenciesAction.php:10-28`.

## Input

- Nessun argomento. Legge `config('totem.frequencies')`.

## Output

- `array<int|string, mixed>`: il valore di configurazione, senza trasformazioni.

## Invarianti

| ID | Regola | Test |
|---|---|---|
| `JOB-FREQ-INV-1` | Se la config e' un array, lo restituisce tale e quale. | `tests/Unit/JobDeepCoverageTest.php:22-24` ("execute returns config array"). |
| `JOB-FREQ-INV-2` | Se la config non e' un array lancia `\Exception` con messaggio `[<riga>][GetTaskFrequenciesAction]`. | Test: nessuno comportamentale; `tests/Unit/GetTaskFrequenciesActionTest.php:13-98` verifica solo struttura. |

## Effetti collaterali

- Nessuno.

## Errori

- `\Exception` se `totem.frequencies` non e' un array (o manca).

## Non fa

- Non fornisce valori di default: la chiave deve esistere nella config del pacchetto `totem`.
- Nessun chiamante di produzione trovato fuori dai test.
