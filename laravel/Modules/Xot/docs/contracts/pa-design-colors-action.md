---
title: "PaDesignColorsAction — contratto"
type: contract
owner: Xot
status: accepted
updated: 2026-11-24
action: "Modules\\Xot\\Actions\\PaDesignColorsAction"
qmd: "PaDesignColorsAction colori design system PA verde blu istituzionale palette Filament"
---

# PaDesignColorsAction

Espone i colori del design system PA e la palette Filament corrispondente. Codice: `app/Actions/PaDesignColorsAction.php` (classe a riga 21, `execute()` a riga 30).

## Input

- Nessuno.

## Output

- `execute()`: array di stringhe (primary, institutional_blue, danger, gray, info, success, warning).
- `filamentPalette()`: array di oggetti `Color` Filament.

## Invarianti

- `PA-COLORS-INV-1` — I colori primari e blu istituzionale vengono da `PaDesignColorEnum`. Test: `tests/Unit/MetatagDataTest.php` (menzione).
- `PA-COLORS-INV-2` — La palette Filament usa `Color::hex` per primario e blu, e i colori Filament nominati per gli altri. Test: come sopra.

## Effetti collaterali

Nessuno.

## Errori

- Nessuno.

## Non fa

- Non valida gli esadecimali.
