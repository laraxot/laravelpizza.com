---
title: "GetYearFilter — contratto"
type: contract
owner: Xot
status: accepted
updated: 2026-11-24
action: "Modules\\Xot\\Actions\\Filament\\Filter\\GetYearFilter"
qmd: "GetYearFilter filtro tabella anni SelectFilter Filament intervallo anni opzioni"
---

# GetYearFilter

Costruisce un `SelectFilter` Filament con le opzioni di anno da un valore iniziale a uno finale, inclusi.

Codice: `app/Actions/Filament/Filter/GetYearFilter.php:10-27`.

## Input

- `string $fieldName`.
- `int $from`, `int $to`.

## Output

`Filament\Tables\Filters\SelectFilter`.

## Invarianti

- `FIL-YEAR-INV-1`: le opzioni sono gli anni da `$from` a `$to` inclusi, chiave e valore stringa (righe 20-24). Test: Nessun test dedicato.
- `FIL-YEAR-INV-2`: con `$from` maggiore di `$to` le opzioni sono vuote, senza errore (riga 20). Test: Nessun test dedicato.

## Effetti collaterali

Nessuno.

## Errori

Nessuna eccezione propria.

## Non fa

- Non applica il filtro alla query: lo fa Filament.
- Non ordina le opzioni (l'ordine è quello di costruzione).
