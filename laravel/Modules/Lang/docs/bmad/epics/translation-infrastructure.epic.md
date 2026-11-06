---
title: "Lang: epic 5.252: infrastruttura traduzioni e file"
type: epic
tags: [lang, epic, translations, i18n, localization, infrastructure]
created: 2026-09-28
updated: 2026-09-28
qmd: "Lang epic traduzioni file localizzazione infrastructure"
related:
  - ../architecture.md
  - ../architecture/module-boundary.md
  - ../brainstorming.md
  - ./module-roadmap.md
  - ../stories/module-bmad-audit.story.md
status: draft
---

# Epic 5.252: infrastruttura traduzioni e file di localizzazione

> **SUMMARY**: epic per documentare l'infrastruttura delle traduzioni nel
> modulo `Modules\Lang`: lettura/scrittura file, sincronizzazione, action di
> traduzione, adapter e config. Scope: documentazione derivata dal codice reale,
> zero modifiche PHP. Grounded in `app/Actions/`, `app/Adapters/`,
> `app/Models/`, `config/`.

## Scope

Il modulo Lang gestisce localizzazione e traduzioni (i18n/l10n) su 3 linguaggi,
con action per leggere/scrivere/sincronizzare file PHP, un adapter che
estende il traduttore Laravel e risorse Filament per la gestione. Questa epic
documenta:

1. Action di traduzione in `app/Actions/`
2. Adapter `TranslatorAdapter` in `app/Adapters/`
3. Provider con traits in `app/Providers/Traits/`
4. Modelli `LanguageLine`, `Translation`, `TranslationFile`
5. Config `config/config.php` e `config/lang.php`
6. Lang files in `lang/` e `resources/lang/`

## Fonti verificate

| Fonte | Path |
|---|---|
| Actions | `app/Actions/` (14 file) |
| Adapter | `app/Adapters/TranslatorAdapter.php` |
| Models | `app/Models/` (8 file) |
| Traits | `app/Models/Traits/` (2 file + 4 subdir) |
| Contracts | `app/Models/Contracts/HasTranslationsContract.php` |
| Provider traits | `app/Providers/Traits/TranslatorTrait.php` |
| Resources | `app/Filament/Resources/` (2 resource) |
| Config | `config/config.php`, `config/lang.php` |
| Lang files | `lang/en/` (~26 file), `lang/de/` (~15 file), `resources/lang/it/` |
| Migrations | `database/migrations/` (5 file) |
| Tests | `tests/` (62 file) |

## Task

- [x] T1: Inventariare action traduzione in `app/Actions/`
- [x] T2: Documentare `TranslatorAdapter` e provider traits
- [x] T3: Mappare modelli e traits in `app/Models/`
- [x] T4: Redigere `architecture.md` (indice root → shard)
- [x] T5: Redigere `README.md` (indice verificato)
- [x] T6: Redigere `quick-reference.md` e `setup-guide.md`

## Acceptance Criteria

- [AC1] Tutte le action in `app/Actions/` sono documentate con file e scopo
- [AC2] `TranslatorAdapter` estende `LaravelTranslator`: verificato
- [AC3] Config e lang files documentati con path reali
- [AC4] Migrazioni duplicate segnalate (`database/migrations/` vs `database/Migrations/`)
- [AC5] Nessun file PHP modificato (`git status` mostra solo `docs/`)
- [AC6] Ogni path citato nel corpo esiste: `test -e <path>` verificato

## Rischi

- Migrazione duplicata in `database/Migrations/` può confondere
- Adapter estende Laravel core: fragilità al upgrade

## DoD

- Documentazione infrastruttura traduzione completa e linkata
- Tutti i path verificati con `test -e`
- Lock rispettati per ogni scrittura
- Esito riportato in story correlata
