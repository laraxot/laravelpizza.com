---
title: "ImportButton — contratto"
type: contract
owner: Xot
status: accepted
updated: 2026-11-24
action: "Modules\\Xot\\Actions\\Filament\\Actions\\ImportButton"
qmd: "ImportButton bottone import XLS non implementato LogicException Filament"
---

# ImportButton

Bottone Filament per l'import XLS. È visibile, ma l'azione non è implementata.

Codice: `app/Actions/Filament/Actions/ImportButton.php:10-21`.

## Input

- Nessuno.

## Output

`Filament\Actions\Action` con nome `import`.

## Invarianti

- `FIL-IMPBTN-INV-1`: al click lancia sempre `LogicException` "ImportButton action not implemented" (riga 20). Test: Nessun test dedicato.

## Effetti collaterali

Nessuno.

## Errori

`LogicException` al click.

## Non fa

- Non importa nulla.
- Il bottone resta visibile.
