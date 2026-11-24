---
title: "MeasureAction — contratto"
type: contract
owner: Xot
status: accepted
updated: 2026-11-24
action: "Modules\\Xot\\Actions\\Debug\\MeasureAction"
qmd: "MeasureAction misura tempo memoria closure notifica Filament debug performance"
---

# MeasureAction

Esegue una closure, misura tempo e memoria, e mostra il risultato come notifica. Codice: `app/Actions/Debug/MeasureAction.php` (classe a riga 17, `execute()` a riga 24).

## Input

- `Closure $closure`: codice da eseguire.
- `string $label`: etichetta opzionale.

## Output

- `mixed`: il risultato della closure.

## Invarianti

- `MEASURE-INV-1` — La closure è eseguita una sola volta e il suo risultato è restituito invariato. Test: `tests/Unit/Actions/Debug/MeasureActionTest.php`.
- `MEASURE-INV-2` — Dopo l'esecuzione è inviata una notifica persistente con tempo (ms) e memoria (KB). Test: come sopra.
- `MEASURE-INV-3` — Se la closure lancia, la notifica non è inviata e l'eccezione si propaga. Test: non verificato.

## Effetti collaterali

Invio di una notifica Filament alla sessione corrente.

## Errori

- Quelli della closure.

## Non fa

- Non scrive log. La memoria è una differenza approssimata di `memory_get_usage()`.
