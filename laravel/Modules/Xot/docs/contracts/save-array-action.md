---
title: "SaveArrayAction — contratto"
type: contract
owner: Xot
status: accepted
updated: 2026-11-24
action: "Modules\\Xot\\Actions\\Arr\\SaveArrayAction"
qmd: "SaveArrayAction salva array formato json php delega SaveJsonArrayAction SavePhpArrayAction formato non supportato"
---

# SaveArrayAction

Punto di ingresso unico per salvare un array su file, scegliendo il formato. Codice: `app/Actions/Arr/SaveArrayAction.php:9-23`.

## Input

- `array<int|string, mixed> $data`: dati da salvare (`execute`, riga 16).
- `string $filename`: percorso di destinazione (riga 16).
- `string $format = 'php'`: `json` oppure `php` (riga 16).

## Output

- `bool`: il valore restituito dall'Action delegata (riga 18-22).

## Invarianti

| ID | Regola | Prova nel codice | Test esistente |
|---|---|---|---|
| `ARR-SAVE-INV-1` | `json` delega a `SaveJsonArrayAction`, `php` delega a `SavePhpArrayAction`. | righe 18-21 | `tests/Unit/Actions/ArrayArrActionsTest.php:107` |
| `ARR-SAVE-INV-2` | Qualsiasi altro formato lancia `\InvalidArgumentException` ("Formato non supportato"). | riga 21 | `tests/Unit/Actions/ArrayArrActionsTest.php:119` |

## Effetti collaterali

Quelli dell'Action delegata: scrittura del file (vedi `save-json-array-action` e `save-php-array-action`).

## Errori

- `\InvalidArgumentException` per formato non supportato.

## Non fa

- Non valida `$filename`.
- Il confronto del formato è case-sensitive: `JSON` non è accettato.
- Marker `@contract` aggiunto nel docblock della classe.
