---
title: "censimento omonimi metodi — modulo Lang"
type: analysis
module: Lang
updated: 2026-06-15
related:
  - ../../../../../../docs/wiki/method-name-homonym-census.md
  - ../../../../../../bashscripts/docs/method-homonym-census.json
---

# Censimento omonimi metodi — Lang

> **39** nomi metodo omonimi coinvolgono questo modulo (su 689 totali progetto).

## Riepilogo categoria (solo Lang)

| Categoria | Metodi |
|-----------|--------|
| `A_filament_framework` | 19 |
| `E_scheda_stack` | 1 |
| `G_module_local` | 4 |
| `H_cross_module_homonym` | 15 |

## Dettaglio

### `A_filament_framework` (19 metodi)

Hook Filament/Laravel ripetuti — **non** debito. Elenco omesso.

### `E_scheda_stack`

#### `before` — 14 classi

- `Lang` · `LangBasePolicy` · `Modules/Lang/app/Models/Policies/LangBasePolicy.php`

### `G_module_local`

#### `getTranslatableLocales` — 3 classi

- `Lang` · `LangBaseResource` · `Modules/Lang/app/Filament/Resources/LangBaseResource.php`
- `Lang` · `TranslationFileResource` · `Modules/Lang/app/Filament/Resources/TranslationFileResource.php`
- `Lang` · `EditTranslationFile` · `Modules/Lang/app/Filament/Resources/TranslationFileResource/Pages/EditTranslationFile.php`

#### `arrayToPhp` — 2 classi

- `Lang` · `ReadTranslationFileAction` · `Modules/Lang/app/Actions/ReadTranslationFileAction.php`
- `Lang` · `SyncTranslationsAction` · `Modules/Lang/app/Actions/SyncTranslationsAction.php`

#### `getDefaultTranslatableLocale` — 2 classi

- `Lang` · `LangBaseResource` · `Modules/Lang/app/Filament/Resources/LangBaseResource.php`
- `Lang` · `TranslationFileResource` · `Modules/Lang/app/Filament/Resources/TranslationFileResource.php`

#### `registerTranslator` — 2 classi

- `Lang` · `LangServiceProvider` · `Modules/Lang/app/Providers/LangServiceProvider.php`
- `Lang` · `trait:TranslatorTrait` · `Modules/Lang/app/Providers/Traits/TranslatorTrait.php`

### `H_cross_module_homonym`

#### `getRows` — 11 classi

- `Lang` · `TranslationFile` · `Modules/Lang/app/Models/TranslationFile.php`

#### `get` — 9 classi

- `Lang` · `LangField` · `Modules/Lang/app/Casts/LangField.php`
- `Lang` · `TranslatorService` · `Modules/Lang/app/Services/TranslatorService.php`

#### `getData` — 8 classi

- `Lang` · `TranslationData` · `Modules/Lang/app/Datas/TranslationData.php`

#### `afterSave` — 6 classi

- `Lang` · `EditTranslationFile` · `Modules/Lang/app/Filament/Resources/TranslationFileResource/Pages/EditTranslationFile.php`

#### `canView` — 6 classi

- `Lang` · `LanguageSwitcherWidget` · `Modules/Lang/app/Filament/Widgets/LanguageSwitcherWidget.php`

#### `collection` — 6 classi

- `Lang` · `LangData` · `Modules/Lang/app/Datas/LangData.php`

#### `trans` — 6 classi

- `Lang` · `TransArrayAction` · `Modules/Lang/app/Actions/TransArrayAction.php`
- `Lang` · `TransCollectionAction` · `Modules/Lang/app/Actions/TransCollectionAction.php`

#### `mutateFormDataBeforeSave` — 5 classi

- `Lang` · `EditTranslationFile` · `Modules/Lang/app/Filament/Resources/TranslationFileResource/Pages/EditTranslationFile.php`

#### `getSlugOptions` — 4 classi

- `Lang` · `Post` · `Modules/Lang/app/Models/Post.php`

#### `panel` — 4 classi

- `Lang` · `AdminPanelProvider` · `Modules/Lang/app/Providers/Filament/AdminPanelProvider.php`
- `Lang` · `LangBasePanelProvider` · `Modules/Lang/app/Providers/Filament/LangBasePanelProvider.php`

#### `getModules` — 3 classi

- `Lang` · `SyncTranslationsAction` · `Modules/Lang/app/Actions/SyncTranslationsAction.php`

#### `linkable` — 3 classi

- `Lang` · `Post` · `Modules/Lang/app/Models/Post.php`

_… +3 metodi in questa categoria_




## Rigenerazione

```bash
python3 bashscripts/tools/census-method-homonyms.py
```
