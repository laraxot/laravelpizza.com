---
title: "GetPaFilamentPaletteAction — contratto"
type: contract
owner: Xot
status: accepted
updated: 2026-11-24
action: "Modules\\Xot\\Actions\\Design\\GetPaFilamentPaletteAction"
qmd: "GetPaFilamentPaletteAction palette PA Filament colori primary institutional blue PaDesignColorsAction"
---

# GetPaFilamentPaletteAction

Restituisce la palette Filament dei design PA delegando a `PaDesignColorsAction`.

Codice: `app/Actions/Design/GetPaFilamentPaletteAction.php:16-33`.

## Input

- Nessun input.

## Output

`array<string, array<int, string>|string>`, ottenuto da `PaDesignColorsAction::filamentPalette()`.

## Invarianti

- `DESIGN-PAL-INV-1`: `execute` delega integralmente a `PaDesignColorsAction::filamentPalette()` senza logica propria (riga 31). Test: Nessun test dedicato.
- `DESIGN-PAL-INV-2`: le costanti `PRIMARY_HEX` e `INSTITUTIONAL_BLUE_HEX` derivano da `PaDesignColorEnum` (`Primary`, `InstitutionalBlue`) (righe 21, 24). Test: Nessun test dedicato.

## Effetti collaterali

Nessuno.

## Errori

Nessuna eccezione propria.

## Non fa

- Non calcola colori: la fonte è `PaDesignColorsAction`.
- Il docblock rimanda a `laravel/Themes/Sixteen/tailwind.config.js`; questo contract non verifica che la coerenza con il tema sia mantenuta.
