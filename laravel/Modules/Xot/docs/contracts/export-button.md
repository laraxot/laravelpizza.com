---
title: "ExportButton — contratto"
type: contract
owner: Xot
status: accepted
updated: 2026-11-24
action: "Modules\\Xot\\Actions\\Filament\\Actions\\ExportButton"
qmd: "ExportButton bottone export XLS non implementato LogicException Filament"
---

# ExportButton

Bottone Filament per l'export XLS. È visibile, ma l'azione non è implementata.

Codice: `app/Actions/Filament/Actions/ExportButton.php:10-21`.

## Input

- Nessuno.

## Output

`Filament\Actions\Action` con nome `export`.

## Invarianti

- `FIL-EXPBTN-INV-1`: al click lancia sempre `LogicException` "ExportButton action not implemented" (riga 20). Test: Nessun test dedicato.

## Effetti collaterali

Nessuno.

## Errori

`LogicException` al click.

## Non fa

- Non esporta nulla. L'export reale è nelle Action `Export\*`.
- Il bottone resta visibile: l'utente trova un errore, non un'azione disabilitata.
