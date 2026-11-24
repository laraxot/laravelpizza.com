---
title: "IsThemeAction — contratto"
type: contract
owner: Xot
status: accepted
updated: 2026-11-24
action: "Modules\\Xot\\Actions\\Theme\\IsThemeAction"
qmd: "IsThemeAction verifica tema attivo confronto stringa GetThemeAction"
---

# IsThemeAction

Dice se il tema passato è quello attivo. Codice: `app/Actions/Theme/IsThemeAction.php`.

## Input

- `string $theme`: nome del tema da confrontare.

## Output

- `bool`: `true` se `$theme` è identico (confronto stretto `===`, case-sensitive) al tema restituito da `GetThemeAction`.

## Invarianti

| ID | Regola | Test |
|---|---|---|
| `THEME-IS-INV-1` | Il risultato è `true` se e solo se `$theme === GetThemeAction::execute()`. | `tests/Unit/Actions/Theme/ThemeActionsTest.php` (riferisce la classe) |
| `THEME-IS-INV-2` | Se la config non contiene un tema valido, il confronto avviene con `'default'`. | Test: nessuno |

## Effetti collaterali

Nessuno.

## Errori

- Nessuno.

## Non fa

- Non verifica che `$theme` esista.
- Non normalizza maiuscole o minuscole.
