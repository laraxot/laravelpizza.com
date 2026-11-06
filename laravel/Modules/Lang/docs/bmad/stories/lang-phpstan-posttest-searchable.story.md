---
title: "Lang: PHPStan PostTest toSearchableArray"
type: story
module: Lang
status: done
phase: quality-gates
priority: P1
related:
  - lang-phpstan-l10.story.md
tags: [lang, phpstan, pest, post]
qmd: "lang phpstan posttest tosearchablearray searchable fields"
updated: 2026-10-21
---

# Lang: PHPStan PostTest toSearchableArray

## Scopo funzionale

`Post::toSearchableArray()` alimenta l’indice Scout/Meilisearch: deve esporre solo i campi definiti in `Post::SEARCHABLE_FIELDS` (`title`, `guid`, `txt`), coerenti con il contenuto del modello.

## Problema PHPStan

`PostTest.php:50`: `Assert::assertIsArray()` su valore già tipizzato `array` (`staticMethod.alreadyNarrowedType`).

## Fix

Sostituito assert di tipo con assert comportamentali: stesso payload atteso e chiavi allineate a `Post::SEARCHABLE_FIELDS`.

## Lock

- File: `laravel/Modules/Lang/tests/Unit/Models/PostTest.php`
- Task: `phpstan-lang-posttest`
- Agent: `php-backend-agent`

## Verifica

```bash
cd laravel
php -d memory_limit=2G ./vendor/bin/phpstan analyse Modules/Lang
./vendor/bin/pest Modules/Lang/tests/Unit/Models/PostTest.php
```

Esito registrato in chiusura story dal agente esecutore.
