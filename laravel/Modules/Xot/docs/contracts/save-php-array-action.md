---
title: "SavePhpArrayAction — contratto"
type: contract
owner: Xot
status: accepted
updated: 2026-11-24
action: "Modules\\Xot\\Actions\\Arr\\SavePhpArrayAction"
qmd: "SavePhpArrayAction array PHP una chiave per riga var_export return file lang nested inline clean code"
---

# SavePhpArrayAction

Salva un array come file PHP `return [...]` con una chiave per riga, senza array annidati inline. Codice: `app/Actions/Arr/SavePhpArrayAction.php:19-66`.

## Input

- `array<int|string, mixed> $data` (`execute`, riga 26).
- `string $filename`: file di destinazione (riga 26).

## Output

- `bool`: `(bool)` dei byte scritti da `Safe\file_put_contents` (riga 31).

## Invarianti

| ID | Regola | Prova nel codice | Test esistente |
|---|---|---|---|
| `ARR-SAVEPHP-INV-1` | Ogni chiave è su una riga propria; un array annidato è esploso su righe indentate di 4 spazi per livello. Un array vuoto è `[]`. | righe 37-55 | `tests/Unit/Actions/ArrayArrActionsTest.php:97`; `tests/Arch/debt.php:16` |
| `ARR-SAVEPHP-INV-2` | Le chiavi intere sono scritte senza apici; le chiavi stringa con `var_export`. | righe 47-48 | come sopra |
| `ARR-SAVEPHP-INV-3` | Il file ha la forma `<?php`, `declare(strict_types=1)`, `return <array>;`. | riga 29 | come sopra |
| `ARR-SAVEPHP-INV-4` | I valori non array sono scritti con `var_export`. | righe 57-65 | come sopra |

## Effetti collaterali

Scrittura del file (sovrascrive). Non crea la cartella di destinazione, a differenza di `SaveJsonArrayAction`.

## Errori

- Le funzioni `Safe\*` lanciano eccezioni su I/O fallito.

## Non fa

- Non scrive in modo atomico.
- Non valida il contenuto né la leggibilità della chiave.
- Marker `@contract` aggiunto nel docblock della classe.
