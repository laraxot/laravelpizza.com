---
title: "SaveJsonArrayAction — contratto"
type: contract
owner: Xot
status: accepted
updated: 2026-11-24
action: "Modules\\Xot\\Actions\\Arr\\SaveJsonArrayAction"
qmd: "SaveJsonArrayAction salva array JSON pretty print crea cartella file_put_contents Safe sovrascrive"
---

# SaveJsonArrayAction

Scrive un array come JSON formattato su file, creando la cartella se manca. Codice: `app/Actions/Arr/SaveJsonArrayAction.php:13-29`.

## Input

- `array<int|string, mixed> $data` (`execute`, riga 20).
- `string $filename`: percorso assoluto o relativo di destinazione (riga 20).

## Output

- `bool`: `(bool)` dei byte scritti da `Safe\file_put_contents` (riga 28).

## Invarianti

| ID | Regola | Prova nel codice | Test esistente |
|---|---|---|---|
| `ARR-SAVEJSON-INV-1` | Il contenuto è `Safe\json_encode($data, JSON_PRETTY_PRINT)`. | riga 22 | `tests/Unit/Actions/ArrayArrActionsTest.php:96`, `tests/Unit/Actions/Arr/SaveArrayActionsTest.php:34` |
| `ARR-SAVEJSON-INV-2` | La cartella del file viene creata (`File::ensureDirectoryExists`) prima della scrittura. | riga 26 | Test: nessuno |
| `ARR-SAVEJSON-INV-3` | Un file esistente viene sovrascritto senza backup. | riga 28 | Test: nessuno |

## Effetti collaterali

Ordine: encode in memoria, creazione della cartella, scrittura del file. Nessuna transazione, nessun evento, nessuna coda.

## Errori

- Le funzioni `Safe\*` lanciano eccezioni su encode o I/O fallito. Nessuna gestione locale.

## Non fa

- Non scrive in modo atomico (nessun file temporaneo + rename).
- Marker `@contract` aggiunto nel docblock della classe.
