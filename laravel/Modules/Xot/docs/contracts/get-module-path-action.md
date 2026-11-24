---
title: "GetModulePathAction (File) — contratto"
type: contract
owner: Xot
status: accepted
updated: 2026-11-24
action: "Modules\\Xot\\Actions\\File\\GetModulePathAction"
qmd: "GetModulePathAction percorso modulo nwidart fallback base_path Modules case insensitive __DIR__ bug"
---

# GetModulePathAction (File)

Restituisce la cartella di un modulo, con fallback su `base_path('Modules')` se nwidart non lo trova. Codice: `app/Actions/File/GetModulePathAction.php:14-52`.

## Input

- `string $moduleName`: nome del modulo (`execute`, riga 24).

## Output

- `string`: percorso della cartella del modulo (righe 27, 31, 44, 50).

## Invarianti

| ID | Regola | Prova nel codice | Test esistente |
|---|---|---|---|
| `FILE-MODPATH-INV-1` | Se `Module::getModulePath` riesce, ritorna quel percorso, con il trailing slash che restituisce nwidart. | righe 26-27, 50 | `tests/Unit/Actions/File/GetModulePathActionTest.php:5`; `tests/Unit/Actions/File/AssetActionsTest.php:58,88` |
| `FILE-MODPATH-INV-2` | Se nwidart fallisce e `base_path('Modules')` non esiste, ritorna `__DIR__.'/../'`: è la cartella `app/Actions`, **non** un modulo. | righe 28-32 | Test: nessuno |
| `FILE-MODPATH-INV-3` | Altrimenti cerca in `base_path('Modules')` una cartella con nome uguale senza distinguere maiuscole/minuscole. Se la trova, ritorna `base_path('Modules/{trovato})` senza slash finale. | righe 34-47 | come sopra |
| `FILE-MODPATH-INV-4` | Se non trova nulla, ritorna `base_path('Modules/{nome})` senza verificarne l'esistenza. | righe 43-45 | Test: nessuno |

## Effetti collaterali

Lettura della cartella `Modules` con `Safe\scandir`. Nessuna scrittura.

## Errori

- Nessuna eccezione propria. Le eccezioni di `scandir` si propagano se la cartella esiste ma non si legge.

## Non fa

- **Bug** (`FILE-MODPATH-INV-2`, riga 31): il fallback `__DIR__.'/../'` non è una cartella di modulo. Chi lo riceve lavora sul percorso sbagliato. Segnalato nel report; non corretto in questa task.
- Il trailing slash è incoerente tra i rami: `AssetAction` lo gestisce con `Str::endsWith`.
- Marker `@contract` aggiunto nel docblock della classe.
