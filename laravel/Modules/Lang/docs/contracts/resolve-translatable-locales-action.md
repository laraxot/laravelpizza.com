---
title: "Contratto — ResolveTranslatableLocalesAction"
type: contract
owner: Lang
status: accepted
updated: 2026-11-24
action: "Modules\\Lang\\Actions\\ResolveTranslatableLocalesAction"
qmd: "ResolveTranslatableLocalesAction lingue editor traduzioni lista vuota default LangConfigData supported_locales LANG-TRANSLOC"
---

# ResolveTranslatableLocalesAction

Restituisce le lingue con cui lavora l'editor delle traduzioni. Codice: `app/Actions/ResolveTranslatableLocalesAction.php:14-30`.

## Input

- Nessun argomento. Legge `LangConfigData::make()->supported_locales`.

## Output

- `list<string>`: solo stringhe non vuote, riindicizzate.

## Invarianti

| ID | Regola | Test |
|---|---|---|
| `LANG-TRANSLOC-INV-1` | Mai lista vuota: se non resta nulla, torna il default della Data (`['it', 'en']`, `LangConfigData.php:40`). | `tests/Unit/Datas/LangConfigDataTest.php:75` («an empty list of languages never reaches the editors»). |
| `LANG-TRANSLOC-INV-2` | Valori non stringa o stringhe vuote vengono scartati. | Test: nessuno. |

## Effetti collaterali

- Nessuno.

## Errori

- Nessuna eccezione propria.

## Non fa

- Non verifica che le lingue siano codici validi.
- Chiamanti verificati: `Datas/LangConfigData.php`, `Filament/Resources/TranslationFileResource.php` (e la sua Page `EditTranslationFile.php`), `Filament/Resources/LangBaseResource.php`.
