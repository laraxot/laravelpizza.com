---
title: "Contratto — ResolveDefaultTranslatableLocaleAction"
type: contract
owner: Lang
status: accepted
updated: 2026-11-24
action: "Modules\\Lang\\Actions\\ResolveDefaultTranslatableLocaleAction"
qmd: "ResolveDefaultTranslatableLocaleAction lingua di apertura editor default_locale fallback LangConfigData LANG-DEFLOC"
---

# ResolveDefaultTranslatableLocaleAction

Sceglie la lingua con cui si apre l'editor delle traduzioni. Codice: `app/Actions/ResolveDefaultTranslatableLocaleAction.php:14-28`.

## Input

- `string $fallback`: lingua di ripiego del chiamante (es. `app.locale` per le Resource, `it` per il selettore).

## Output

- `string`: il `default_locale` salvato se e' tra le lingue scelte, altrimenti `$fallback`.

## Invarianti

| ID | Regola | Test |
|---|---|---|
| `LANG-DEFLOC-INV-1` | Un default salvato fuori dalle lingue scelte viene ignorato e si usa `$fallback`. | `tests/Unit/Datas/LangConfigDataTest.php:66` («a default language outside the chosen ones is ignored»). |
| `LANG-DEFLOC-INV-2` | Senza default salvato (`null`) si usa `$fallback`. | `tests/Unit/Datas/LangConfigDataTest.php:26` («without a saved value…»), verifica indiretta. |

## Effetti collaterali

- Nessuno: lettura di `LangConfigData::make()`.

## Errori

- Nessuna eccezione propria.

## Non fa

- Non salva nulla e non valida `$fallback`.
- Chiamanti verificati: `Datas/LangConfigData.php`, `Filament/Resources/TranslationFileResource.php`, `Filament/Resources/LangBaseResource.php`.
