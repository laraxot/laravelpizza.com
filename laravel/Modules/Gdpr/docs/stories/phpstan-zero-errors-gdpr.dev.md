---
title: "[DEV] PHPStan zero errori — modulo Gdpr"
type: dev
module: Gdpr
story: "./phpstan-zero-errors-gdpr.story.md"
status: done
created: 2026-10-28
updated: 2026-10-28
tags: [phpstan, gdpr, bmad, swarm]
---

# [DEV] PHPStan zero errori — modulo Gdpr

## Technical Plan

Per ogni errore `class.notFound`/`property.staticAccess`: `git log -S` per capire se il simbolo e' stato spostato, cancellato per scelta o perso in un merge. Qui: perso in un merge, ancora usato → ripristino.

## Files to Modify

- `app/Filament/Resources/TreatmentResource/Tables/TreatmentsTable.php` — `use IconColumn`
- `tests/Feature/ConflictResolutionTest.php` — `use PHPUnit\Framework\Assert`
- `tests/TestCase.php` — `$currentTest`, `setUp`, `tearDown`
- `docs/wiki/troubleshooting/git-merge-conflict-inventory.md` (da `...-2026-04-28.md`), `docs/index.md` (riga duplicata), `docs/wiki/concepts/testing.md` (write-back)

## Implementation Steps

- [x] `git show b8c56ce^:tests/TestCase.php` come riferimento (sola lettura)
- [x] `git mv -f` del file con data sul nome canonico; frontmatter `created: 2026-04-28`
- [x] `php -l` + `phpstan analyse` modulo e full-tree

## Testing

Pest non eseguito (MySQL in `.env.testing`).

## Verification

```bash
cd laravel && ./vendor/bin/phpstan analyse Modules/Gdpr --memory-limit=-1 --no-progress --error-format=raw
```
