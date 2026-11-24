---
title: "CopyFromLastYearButton — contratto"
type: contract
owner: Xot
status: accepted
updated: 2026-11-24
action: "Modules\\Xot\\Actions\\Filament\\Actions\\CopyFromLastYearButton"
qmd: "CopyFromLastYearButton bottone copia anno precedente visibile year null Action Filament"
---

# CopyFromLastYearButton

Costruisce un bottone Filament che copia i dati dell'anno precedente tramite `ModelClass\CopyFromLastYearAction`.

Codice: `app/Actions/Filament/Actions/CopyFromLastYearButton.php:11-23`.

## Input

- `string $modelClass`, `string $fieldName`, `?string $year`.

## Output

`Filament\Actions\Action` con nome `copy_from_last_year`.

## Invarianti

- `FIL-COPYBTN-INV-1`: il bottone è visibile solo se `$year` non è nullo (riga 20). Test: Nessun test dedicato.
- `FIL-COPYBTN-INV-2`: al click delega a `ModelClass\CopyFromLastYearAction` con gli argomenti ricevuti (riga 21). Test: Nessun test dedicato.

## Effetti collaterali

Scrittura dati tramite la Action delegata, al click.

## Errori

Nessuna eccezione propria.

## Non fa

- Non richiede conferma, a differenza di `CopyFromLastYearAction`.
- Non valida `$modelClass` né `$fieldName`.
