---
title: "GetThemePathAction — contratto"
type: contract
owner: Xot
status: accepted
updated: 2026-11-24
action: "Modules\\Xot\\Actions\\Theme\\GetThemePathAction"
qmd: "GetThemePathAction percorso tema resource_path themes tema attivo"
---

# GetThemePathAction

Restituisce il percorso della cartella del tema attivo sotto `resources/themes`. Codice: `app/Actions/Theme/GetThemePathAction.php`.

## Input

- Nessuno. Il tema viene da `GetThemeAction`.

## Output

- `string`: `resource_path('themes/'.<tema attivo>)`.

## Invarianti

| ID | Regola | Test |
|---|---|---|
| `THEME-PATH-INV-1` | Il risultato è sempre `resource_path('themes/')` concatenato al nome del tema restituito da `GetThemeAction`. | `tests/Unit/Actions/Theme/ThemeActionsTest.php` (riferisce la classe) |
| `THEME-PATH-INV-2` | Il percorso è costruito senza verificare che la cartella esista. | Test: nessuno |

## Effetti collaterali

Nessuno. Nessuna lettura su disco.

## Errori

- Nessuno dall'Action. Eventuali errori della risoluzione di `app(GetThemeAction::class)` si propagano.

## Non fa

- Non crea né verifica la cartella del tema.
- Non valida il nome del tema.
