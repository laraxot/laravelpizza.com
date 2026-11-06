---
title: "Lang: brainstorming"
type: brainstorming
tags: [lang, brainstorming, risks, open-questions, decisions, translations]
created: 2026-09-28
updated: 2026-10-07
qmd: "Lang brainstorming decisioni aperte scartate rischi traduzioni localizzazione"
related:
  - ./README.md
  - ./architecture.md
  - ./brainstorming/module-opportunities.md
  - ./epics/module-roadmap.md
  - ./epics/translation-infrastructure.epic.md
bmad: true
module: Lang
status: active
---

# Lang: brainstorming

> **SUMMARY**: indice dei contenuti di brainstorming per `Modules\Lang`.
> Le domande ad alto valore, ipotesi, rischi e output attesi sono nei **shard**
> sottostanti (non sovrascritti). Questo file root funge da indice con
> decisioni e rischi verificati nel codice.

## Shard brainstorming

| Shard | Descrizione |
|---|---|
| [brainstorming/module-opportunities.md](./brainstorming/module-opportunities.md) | domande ad alto valore, ipotesi da validare, rischi |

## Decisioni prese

| Decisione | Stato | Riferimento |
|---|---|---|
| `LangServiceProvider` estende `XotBaseServiceProvider` | approvata | `app/Providers/LangServiceProvider.php:25` |
| `TranslationFile` carica con `Safe\json_encode` | approvata | `app/Models/TranslationFile.php:20` |
| `Translation` usa query builder scopes (`ofTranslatedGroup`, `orderByGroupKeys`, `selectDistinctGroup`) | approvata | `app/Models/Translation.php:85-122` |
| `TranslatorAdapter` estende `LaravelTranslator` | approvata | `app/Adapters/TranslatorAdapter.php:22` |
| `Post` usa slug (`SlugOptions`) e `toSearchableArray()` | approvata | `app/Models/Post.php:183,297` |
| `Post` usa `HasStrictTranslations` trait | approvata | `app/Models/Traits/HasStrictTranslations.php` |
| Provider priority 4 (da `module.json`) | approvata | `module.json:8` |
| `database/Migrations/` duplicato non migrato | approvata | `database/Migrations/2024_03_20_000001_create_language_lines_table.php` |

## Domande aperte

| Domanda | Fonte | Priorità |
|---|---|---|
| API pubblica e invarianti del modulo | `architecture/module-boundary.md` sezione "Decisioni da confermare" | alta |
| Flussi con transazioni, autorizzazione e audit | `architecture/module-boundary.md` sezione "Decisioni da confermare" | alta |
| Copertura Pest rappresentativa (62 test) | `tests/` | media |
| Integrazioni esterne obbligatorie vs opzionali | `composer.json` | media |
| Gestione `mcamara/laravel-localization` vs `lara-zeus/spatie-translatable` | `composer.json`, `app/Adapters/` | media |
| Risoluzione path traduzione (`GetTransPathAction`) | `app/Actions/GetTransPathAction.php` | bassa |

## Rischi

| Rischio | Evidenza |
|---|---|
| Contratti impliciti Eloquent | `app/Models/Translation.php` relazioni via `@property` |
| Drift docs / codice / stories | `docs/bmad/stories/` multipli |
| WIP concorrente e marker merge | `stories/git-status-fleet-merge-markers-lang.story.md` |
| Migrazioni duplicate | `database/migrations/` vs `database/Migrations/` |
| Lingue sparse | `lang/de/`, `lang/en/`, `resources/lang/it/`: 3 source distinti |
| Adapter estende Laravel core | `app/Adapters/TranslatorAdapter.php:22` può rompersi al upgrade |

## Elementi non approvati (scartati o fuori scope)

| Elemento | Motivo |
|---|---|
| Refactor proposto in architettura | da marcare esplicitamente come proposta non applicata |

## Vedi anche

- [README](./README.md)
- [Architecture](./architecture.md)
- [Epic roadmap](./epics/module-roadmap.md)
- [Epic translation infra](./epics/translation-infrastructure.epic.md)
- [Module opportunities (shard)](./brainstorming/module-opportunities.md)
