---
title: "Contratto — GetTransPathAction"
type: contract
owner: Lang
status: accepted
updated: 2026-11-24
action: "Modules\\Lang\\Actions\\GetTransPathAction"
qmd: "GetTransPathAction percorso file traduzione chiave modulo lingua locale GetModulePathByGeneratorAction LANG-PATH"
---

# GetTransPathAction

Dalla chiave di traduzione ricava il percorso del file PHP di lingua. Codice: `app/Actions/GetTransPathAction.php:11-33`.

## Input

- `string $key`: forma `<modulo>::<gruppo>.<voce>...`.

## Output

- `string`: `<cartella lang del modulo>/<locale corrente>/<primo segmento di gruppo>.php`.

## Invarianti

| ID | Regola | Test |
|---|---|---|
| `LANG-PATH-INV-1` | Il file e' quello della locale corrente (`app()->getLocale()`) e del primo segmento del gruppo (`explode('.')[0]`). | `tests/Unit/Actions/GetTransPathActionTest.php:19-48` (percorso per chiave valida, namespace e file, chiave con piu' punti, locale da app). |
| `LANG-PATH-INV-2` | Se il generatore non risolve il modulo, usa `base_path('Modules/<modulo>/lang')` senza errore. | Test: nessuno esplicito (riferimento in `LangHundredPercentCoverageTest`, non letto). |

## Effetti collaterali

- Nessuno: calcolo puro, nessuna creazione di cartelle ne' verifica di esistenza.

## Errori

- Nessuna eccezione propria. Qualsiasi `\Throwable` dal generatore viene ingoiato senza log (righe 26-27).

## Non fa

- Non crea la cartella ne' il file.
- Dubbio: una chiave senza `::` usa l'intera chiave come namespace (`Str::before` restituisce la stringa intera). Non verificato a runtime.
- Chiamanti verificati: `SaveTransAction::persist()`.
