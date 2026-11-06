---
title: "Translation factory: auto-increment id"
type: rule
module: Lang
tags: [lang, pest, factory, sqlite, auto-increment]
created: 2026-06-12
updated: 2026-06-12
qmd: "Lang TranslationFactory auto increment id sqlite unique constraint randomNumber factory"
issues:
  - "https://github.com/laraxot/platform/issues/345"
discussions:
  - "https://github.com/laraxot/platform/discussions/273"
related:
  - ../../../../../docs/wiki/rules/testing-modules-pest.md
  - ../../../../../docs/wiki/bmad/architecture-phpunit-central-config.md
  - ../../../../../../docs/wiki/rules/testing-modules-pest.md
  - ../../../../../../docs/wiki/bmad/architecture-phpunit-central-config.md
status: draft
---

# Translation factory: auto-increment id

## Regola

`translations.id` e' creato con `$table->id()`, quindi `TranslationFactory` non deve valorizzare manualmente `id`.

Vietato:

```php
'id' => fake()->randomNumber(5),
```

Corretto: lasciare che sqlite/mysql assegnino l'id auto-increment.

## Perche'

Durante i run Pest coverage di STORY-345, `TranslationFactory` ha generato un `id` gia' presente nel database condiviso `database.sqlite`, causando:

```text
UNIQUE constraint failed: translations.id
```

Il problema non appartiene a PHPUnit/Pest: e' una factory che contraddice lo schema.

## Checklist

- Se la migration usa `$table->id()`, la factory non imposta `id`.
- Se serve un id specifico in un test, passarlo esplicitamente solo in quel test e garantire isolamento.
- Le factory devono produrre dati ripetibili senza dipendere da collisioni probabilistiche.

## Verifica

```bash
cd laravel
./vendor/bin/pest Modules/Lang/tests/ --configuration phpunit.xml --coverage --coverage-filter=Modules/Lang/app --only-summary-for-coverage-text --colors=never --compact
```