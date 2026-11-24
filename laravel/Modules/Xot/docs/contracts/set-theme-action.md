---
title: "SetThemeAction — contratto"
type: contract
owner: Xot
status: accepted
updated: 2026-11-24
action: "Modules\\Xot\\Actions\\Theme\\SetThemeAction"
qmd: "SetThemeAction imposta tema attivo config theme.active in memoria"
---

# SetThemeAction

Imposta il tema attivo in memoria, cambiando `config('theme.active')`. Codice: `app/Actions/Theme/SetThemeAction.php`.

## Input

- `string $theme`: nome del tema da attivare.

## Output

- `void`.

## Invarianti

| ID | Regola | Test |
|---|---|---|
| `THEME-SET-INV-1` | Dopo la chiamata `config('theme.active')` vale `$theme`, quindi `GetThemeAction` restituisce `$theme`. | `tests/Unit/Actions/Theme/ThemeActionsTest.php` (riferisce la classe) |
| `THEME-SET-INV-2` | Il valore vive solo nella config del processo corrente. | Test: nessuno |

## Effetti collaterali

- Modifica `Config` in memoria. Nessuna persistenza (né `.env`, né DB, né cache), nessun evento, nessuna coda.
- In un processo long-running (worker di coda, Octane) la modifica resta attiva per i job successivi del processo. Questo è il comportamento del codice, non una garanzia documentata.

## Errori

- Nessuno. Il nome del tema non viene validato.

## Non fa

- Non verifica che la cartella del tema esista.
- Non persiste la scelta per l'utente o per la richiesta successiva.
