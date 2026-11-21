---
title: "Lang — quick reference"
type: note
tags: [lang, quick-reference, translations, i18n, localization, actions]
created: 2026-09-28
updated: 2026-10-07
qmd: "Lang quick reference traduzioni azioni adapter localizzazione"
related:
  - ./README.md
  - ./setup-guide.md
  - ./architecture/module-boundary.md
---

# Lang — quick reference

> **SUMMARY**: riferimento rapido per lo sviluppo su `Modules\Lang`:
> modelli, action traduzione, adapter, resource Filament, widget e config.
> Tutto derivato da file reali del modulo.

## Namespace e providers

- Namespace: `Modules\Lang`
- Provider principale: `Modules\Lang\Providers\LangServiceProvider`
  (`app/Providers/LangServiceProvider.php:25`, estende `XotBaseServiceProvider`)

## Modelli principali

| Modello | File | Estende | Tabella |
|---|---|---|---|
| `LanguageLine` | `app/Models/LanguageLine.php` | `BaseModel` | `language_lines` |
| `Translation` | `app/Models/Translation.php` | `BaseModel` | `translations` |
| `TranslationFile` | `app/Models/TranslationFile.php` | `BaseModel` | — |
| `Post` | `app/Models/Post.php` | `BaseModel` | `posts` |
| `BaseModel` | `app/Models/BaseModel.php` | `XotBaseModel` | — |
| `BaseModelLang` | `app/Models/BaseModelLang.php` | `BaseModel` | — |
| `BaseMorphPivot` | `app/Models/BaseMorphPivot.php` | — | — |

## Traits modello

| Trait | File |
|---|---|
| `HasStrictTranslations` | `app/Models/Traits/HasStrictTranslations.php` |
| `LinkedTrait` | `app/Models/Traits/LinkedTrait.php` |

### Trait modello (subdirs)

- `app/Models/Traits/Extras/`
- `app/Models/Traits/Mutators/`
- `app/Models/Traits/Relationships/`
- `app/Models/Traits/Scopes/`

## Contratti

| Contratto | File |
|---|---|
| `HasTranslationsContract` | `app/Models/Contracts/HasTranslationsContract.php` |

## Action principali

| Action | File | Scopo |
|---|---|---|
| `TranslatorAction` | `app/Actions/TranslatorAction.php` | traduzione principale |
| `GetAllTranslationAction` | `app/Actions/GetAllTranslationAction.php` | tutte traduzioni |
| `GetAllModuleTranslationAction` | `app/Actions/GetAllModuleTranslationAction.php` | traduzioni modulo |
| `ReadTranslationFileAction` | `app/Actions/ReadTranslationFileAction.php` | lettura file |
| `WriteTranslationFileAction` | `app/Actions/WriteTranslationFileAction.php` | scrittura file |
| `SyncTranslationsAction` | `app/Actions/SyncTranslationsAction.php` | sincronizza |
| `MergeTranslationsAction` | `app/Actions/MergeTranslationsAction.php` | merge |
| `SaveTransAction` | `app/Actions/SaveTransAction.php` | salva traduzione |
| `GetTransPathAction` | `app/Actions/GetTransPathAction.php` | path traduzione |
| `PublishTranslationAction` | `app/Actions/PublishTranslationAction.php` | pubblica |
| `TransArrayAction` | `app/Actions/TransArrayAction.php` | array traduzione |
| `TransCollectionAction` | `app/Actions/TransCollectionAction.php` | collection |
| `RecordMissingTranslationAction` | `app/Actions/Translation/RecordMissingTranslationAction.php` | registra mancante |
| `AutoLabelAction` | `app/Actions/Filament/AutoLabelAction.php` | label automatiche |

## Adapter

| Adapter | File | Estende |
|---|---|---|
| `TranslatorAdapter` | `app/Adapters/TranslatorAdapter.php` | `LaravelTranslator` |

### Provider trait

- `app/Providers/Traits/TranslatorTrait.php`
- `app/Providers/TranslatorTraitPhpstanProbe.php`

## Resource Filament

| Resource | Directory |
|---|---|
| `LangBaseResource` | `app/Filament/Resources/LangBaseResource.php` |
| `TranslationFileResource` | `app/Filament/Resources/TranslationFileResource/` |
| `Pages/LangBaseCreateRecord` | `app/Filament/Resources/Pages/LangBaseCreateRecord.php` |
| `Pages/LangBaseEditRecord` | `app/Filament/Resources/Pages/LangBaseEditRecord.php` |
| `Pages/LangBaseListRecords` | `app/Filament/Resources/Pages/LangBaseListRecords.php` |
| `Pages/LangBaseViewRecord` | `app/Filament/Resources/Pages/LangBaseViewRecord.php` |

## Widget

| Widget | File |
|---|---|
| `LanguageSwitcherWidget` | `app/Filament/Widgets/LanguageSwitcherWidget.php` |

## View components

| Component | File |
|---|---|
| `Flag` | `app/View/Components/Flag.php` |
| `LanguageSwitcher` | `app/View/Components/LanguageSwitcher.php` |
| `ThemeComposer` | `app/View/Composers/ThemeComposer.php` |

## Casts

| Cast | File |
|---|---|
| `LangField` | `app/Casts/LangField.php` |

## Config

| File | Scopo |
|---|---|
| `config/config.php` | nome, icona (`lang-icon`), navigazione (sort: 50) |
| `config/lang.php` | configurazione lingua |

## Lang files

| Lingua | Path |
|---|---|
| Deutsch | `lang/de/` |
| English | `lang/en/` |
| Italian (resources) | `resources/lang/it/` |

## Pattern del modulo

- Le chiavi di traduzione hanno forma `modulo::file.chiave`; nelle UI mai stringhe hardcoded.
- Nelle firme tipizzare su `HasTranslationsContract`, mai su `BaseModel`.
- `HasStrictTranslations` estende `Spatie\Translatable\HasTranslations` restringendo il tipo di ritorno di `getTranslation()` (normalizza array, bool, float, oggetti stringable); non controlla la presenza delle chiavi nelle altre lingue.
- Sorgenti di traduzione: DB (`LanguageLine`, `Translation`) e file PHP (`lang/<locale>/*.php`, letti da `ReadTranslationFileAction` con `require`, scritti da `WriteTranslationFileAction`). I file di traduzione sono array PHP, non YAML.
- Lingue presenti oggi: `de`, `en` in `lang/`, `it` in `resources/lang/`.
- Il modulo non espone comandi Artisan (`app/Console/Commands/` contiene solo `_components.json`): il sync DB e file passa da `SyncTranslationsAction` e `MergeTranslationsAction`.
- Altri simboli: `TranslationStatusEnum` (`app/Enums/`), `LangData` e `TranslationData` (`app/Datas/`).

## Comandi rapidi (da laravel/)

```bash
php -d memory_limit=2G ./vendor/bin/phpstan analyse Modules/Lang
./vendor/bin/pint Modules/Lang
./vendor/bin/pest Modules/Lang
```

## Comandi BMAD per Lang

Help: `bmad-help`. Flusso consigliato:

| Fase | Comandi |
|---|---|
| 1 Analisi | `bmad-domain-research` (i18n, locale, pluralizzazione), `bmad-technical-research` (sync file e DB) |
| 2 Pianificazione | `bmad-create-prd`, `bmad-create-architecture` (LanguageLine e file PHP) |
| 3 Soluzione | `bmad-create-epics-and-stories`, `bmad-check-implementation-readiness` |
| 4 Implementazione | `bmad-sprint-planning`, `bmad-create-story`, `bmad-dev-story`, `bmad-code-review` (focus: chiavi mancanti e fallback) |

Agenti: Mary (`bmad-agent-analyst`), John (`bmad-agent-pm`), Winston (`bmad-agent-architect`), Amelia (`bmad-agent-dev`), Quinn (`bmad-agent-qa`).
Scorciatoie: `bmad-quick-dev "<richiesta>"`, `bmad-quick-spec "<richiesta>"`.

## Vedi anche

- [README](./README.md)
- [Setup guide](./setup-guide.md)
- [Architettura — module boundary](./architecture/module-boundary.md)
- [Epic translation infra](./epics/translation-infrastructure.epic.md)
