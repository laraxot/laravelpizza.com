---
title: "Contratto — GetAllModuleTranslationAction"
type: contract
owner: Lang
status: accepted
updated: 2026-11-24
action: "Modules\\Lang\\Actions\\GetAllModuleTranslationAction"
qmd: "GetAllModuleTranslationAction elenco file lingua moduli locale sessione glob key path LANG-ALLMOD"
---

# GetAllModuleTranslationAction

Elenca i file di lingua di tutti i moduli per la lingua corrente. Codice: `app/Actions/GetAllModuleTranslationAction.php:12-50`. Corpo identico a [get-all-translation-action](get-all-translation-action.md): duplicato.

## Input

- Nessun argomento. Legge `session('locale')`: se e' `it` o `en`, imposta la locale dell'app (righe 23-26).

## Output

- `list<array{key: string, path: string}>`: `key` = `<modulo minuscolo>::<nome file senza .php>`, `path` = percorso assoluto.

## Invarianti

| ID | Regola | Test |
|---|---|---|
| `LANG-ALLMOD-INV-1` | Un elemento per file `Modules/*/lang/<locale>/*.php`, con la locale corrente dopo l'eventuale override di sessione. | Riferimento in `tests/Unit/LangHundredPercentCoverageTest.php`, contenuto non letto. |

## Effetti collaterali

- `app()->setLocale()` quando la sessione ha `it` o `en`: effetto globale sulla richiesta, non solo sul risultato.
- Sola lettura del filesystem (`glob`).

## Errori

- Nessuna eccezione propria. Voci non stringa del glob vengono saltate (righe 34-36).

## Non fa

- Il percorso e' fisso su `base_path('Modules/...')`: non usa il generatore dei moduli.
- Non verifica che il file sia leggibile o valido.
- Chiamanti non trovati fuori dai test.
