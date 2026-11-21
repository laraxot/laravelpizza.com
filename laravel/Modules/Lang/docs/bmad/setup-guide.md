---
title: "Lang — setup guide"
type: note
tags: [lang, setup, environment, i18n, localization, mcamara]
created: 2026-09-28
updated: 2026-10-07
qmd: "Lang setup ambiente traduzioni localizzazione mcamara rinvex"
related:
  - ./README.md
  - ./quick-reference.md
  - ./architecture/module-boundary.md
  - ../../composer.json
  - ../../module.json
---

# Lang — setup guide

> **SUMMARY**: guida per configurare l'ambiente di sviluppo del modulo
> `Modules\Lang`. Copre composer, provider, config, migrazioni e verifica.
> Derivato da `module.json`, `composer.json`, `config/config.php`,
> `config/lang.php`, `app/Providers/LangServiceProvider.php`.

## Prerequisiti

| Requisito | Versione |
|---|---|
| PHP | ^8.3 |
| Laravel | 13 |
| Filament | 5 |

## Installazione dipendenze

Da `laravel/`:

```bash
composer install
```

## Provider

Registrati in `module.json` (priority: 4):

| Provider | File | Note |
|---|---|---|
| `LangServiceProvider` | `app/Providers/LangServiceProvider.php` | estende `XotBaseServiceProvider` |
| `AdminPanelProvider` | `app/Providers/Filament/AdminPanelProvider.php` | Filament admin |
| `LangBasePanelProvider` | `app/Providers/Filament/LangBasePanelProvider.php` | Filament lang base |
| `EventServiceProvider` | `app/Providers/EventServiceProvider.php` | eventi |
| `RouteServiceProvider` | `app/Providers/RouteServiceProvider.php` | route |

### Provider trait

- `app/Providers/Traits/TranslatorTrait.php`
- `app/Providers/TranslatorTraitPhpstanProbe.php`

## Configurazione

### File config

| File | Scopo |
|---|---|
| `config/config.php` | nome (`Lang`), icona (`lang-icon`), navigazione (sort: 50), provider |
| `config/lang.php` | configurazione lingua |

### Lingue supportate

| Lingua | Path |
|---|---|
| English | `lang/en/` |
| Deutsch | `lang/de/` |
| Italian (resources) | `resources/lang/it/` |

## Migrazioni

Da `laravel/` (forward-only, mai `migrate:fresh`):

```bash
php artisan module:migrate Lang
```

| File | Tabella | Dir |
|---|---|---|
| `2024_03_20_000001_create_language_lines_table.php` | `language_lines` | `database/migrations/` |
| `2026_01_21_211814_create_posts_table.php` | `posts` | `database/migrations/` |
| `2026_01_21_211815_create_translations_table.php` | `translations` | `database/migrations/` |
| `2026_08_06_190000_create_posts_table.php` | `posts` | `database/migrations/` |
| `2026_08_06_190100_create_translations_table.php` | `translations` | `database/migrations/` |

Nota: `database/Migrations/` contiene una copia duplicata di
`2024_03_20_000001_create_language_lines_table.php` — non migrare da lì.

## Dipendenze esterne

| Dipendenza | Versione |
|---|---|
| `mcamara/laravel-localization` | * |
| `lara-zeus/spatie-translatable` | * |
| `rinvex/countries` | ^9.1 |
| `spatie/laravel-sluggable` | * |

## Verifica ambiente

```bash
# PHPStan su questo modulo solo
php -d memory_limit=2G ./vendor/bin/phpstan analyse Modules/Lang
# Pest
./vendor/bin/pest Modules/Lang
```

## Locale applicativo

Impostare `APP_LOCALE=it` e `APP_FALLBACK_LOCALE=it` in `.env`. Il sync DB e file non usa comandi Artisan del modulo: passa da `SyncTranslationsAction` e `MergeTranslationsAction`.

## Regole del modulo

Buone pratiche:

- Documentare prima di implementare (PRD prima del codice).
- Estendere XotBase: modelli da `BaseModel` o `BaseModelLang`.
- Actions e non Services: I/O e merge in `app/Actions/` con `execute()`.
- PHPStan al livello massimo, nessun `ignoreErrors`, `phpstan.neon` non si modifica.
- Traduzioni da file: `trans('modulo::file.chiave')`, mai label hardcoded; array PHP con una chiave per riga.
- Tipizzare su `HasTranslationsContract`, mai su `BaseModel`.
- Ogni chiave deve esistere in tutte le lingue attive: una nuova label nasce come chiave, non come testo.

Da evitare:

- Estendere Filament direttamente, creare Services, hardcodare label nelle Resource.
- Scrivere una chiave solo in `it`.

## False friends

| Termine | Sembra | In realta |
|---|---|---|
| `LanguageLine` | una riga di lingua | record DB di una singola chiave tradotta (`language_lines`) |
| `TranslationFile` | un file | record che descrive un file di traduzione per modulo e locale |
| `Translation` | una traduzione | copia locale di un contenuto translatable (`spatie-translatable`) |
| Action | funzione generica | classe con `execute()` che usa `QueueableAction` |
| Service | servizio generico | vietato in Xot, si usano le Actions |

## Struttura directory

- `app/Actions/`: action core piu `Filament/` e `Translation/`.
- `app/Models/`: `LanguageLine`, `Translation`, `TranslationFile`, `Post`, `Contracts/`, `Traits/`.
- `app/Enums/`, `app/Datas/`, `app/Casts/`, `app/Adapters/`: supporto tipizzato.
- `app/View/Composers/`, `app/Providers/Traits/`: integrazione view e provider.
- `app/Filament/`: `TranslationFileResource`, `LangBaseResource`, `LanguageSwitcherWidget`.
- `docs/bmad/`: questa documentazione.

## Vedi anche

- [README](./README.md)
- [Quick reference](./quick-reference.md)
- [Architettura — module boundary](./architecture/module-boundary.md)
- [Epic translation infra](./epics/translation-infrastructure.epic.md)
