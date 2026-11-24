---
title: "ThemeAction — contratto"
type: contract
owner: Xot
status: accepted
updated: 2026-11-24
action: "Modules\\Xot\\Actions\\ThemeAction"
qmd: "ThemeAction tema attivo statico config theme.active percorso resources themes"
---

# ThemeAction

Gestisce il nome del tema attivo con stato statico del processo. Codice: `app/Actions/ThemeAction.php` (classe a riga 16, `execute()` a riga 56 vuoto).

## Input

- `setTheme(string $theme)`, `isTheme(string $theme)`.

## Output

- `getTheme()`: `string`. `isTheme()`: `bool`. `getThemePath()`: percorso `resources/themes/<tema>`.

## Invarianti

- `THEME-INV-1` — Il tema di default è `default`. Test: nessuno.
- `THEME-INV-2` — `setTheme` aggiorna sia lo stato statico sia `config('theme.active')`, per tutto il processo. Test: nessuno.

## Effetti collaterali

Modifica della configurazione del processo (`Config::set`). Nessuna persistenza tra richieste.

## Errori

- Nessuno.

## Non fa

- Non valida il nome del tema: `getThemePath()` lo concatena senza sanificazione, quindi un valore con `..` produce un percorso fuori dalla cartella dei temi. Da correggere se il valore può arrivare dall'esterno.
- `execute()` è vuoto.
