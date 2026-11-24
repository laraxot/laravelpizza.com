---
title: "PlainTextFromFilamentValueAction — contratto"
type: contract
owner: Xot
status: accepted
updated: 2026-11-24
action: "Modules\\Xot\\Actions\\Filament\\PlainTextFromFilamentValueAction"
qmd: "PlainTextFromFilamentValueAction testo semplice Htmlable HasLabel scalar strip_tags etichetta griglia fallback"
---

# PlainTextFromFilamentValueAction

Converte un valore Filament eterogeneo (Htmlable, enum `HasLabel`, scalare) in testo semplice.

Codice: `app/Actions/Filament/PlainTextFromFilamentValueAction.php:14-55`.

## Input

- `mixed $value`.
- `string|int|float|bool|Stringable|null $fallback`: usato se il valore non è testuale.

## Output

`string`.

## Invarianti

- `FIL-PLAIN-INV-1`: un `Htmlable` diventa testo con `strip_tags` (righe 24-26). Test: Nessun test dedicato.
- `FIL-PLAIN-INV-2`: un `HasLabel` è convertito tramite `getLabel()` ricorsivamente (righe 36-37). Test: Nessun test dedicato.
- `FIL-PLAIN-INV-3`: array, oggetti non Stringable e null non diventano testo: si usa il fallback se è scalare o Stringable, altrimenti `''` (righe 40-44). Test: Nessun test dedicato.

## Effetti collaterali

Nessuno.

## Errori

Nessuna eccezione propria.

## Non fa

- `strip_tags` non decodifica le entità HTML (`&amp;` resta).
- Gli array sono scartati in silenzio.
