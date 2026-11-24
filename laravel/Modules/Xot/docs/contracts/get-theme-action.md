---
title: "GetThemeAction — contratto"
type: contract
owner: Xot
status: accepted
updated: 2026-11-24
action: "Modules\\Xot\\Actions\\Theme\\GetThemeAction"
qmd: "GetThemeAction tema attivo config theme.active default contratto Xot"
---

# GetThemeAction

Restituisce il nome del tema attivo letto da `config('theme.active')`. Codice: `app/Actions/Theme/GetThemeAction.php`.

## Input

- Nessuno. `execute()` non ha parametri; legge la config.

## Output

- `string`: il valore di `theme.active` se è una stringa, altrimenti `'default'`.

## Invarianti

| ID | Regola | Test |
|---|---|---|
| `THEME-GET-INV-1` | Se `theme.active` è una stringa, il risultato è quella stringa. | `tests/Unit/Actions/Theme/ThemeActionsTest.php` (riferisce la classe) |
| `THEME-GET-INV-2` | Se la chiave manca o non è una stringa, il risultato è `'default'`. | `tests/Unit/Actions/Theme/ThemeActionsTest.php` (riferisce la classe) |

## Effetti collaterali

Nessuno. Sola lettura della config, nessuna scrittura, nessun evento.

## Errori

- Nessuno. L'Action non lancia eccezioni.

## Non fa

- Non verifica che il tema esista su disco o in `resources/themes`.
- Non legge sessione, cookie o richiesta: il tema è quello in config del processo.
