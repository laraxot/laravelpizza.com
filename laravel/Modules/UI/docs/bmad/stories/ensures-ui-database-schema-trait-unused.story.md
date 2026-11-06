---
title: "Story: trait.unused EnsuresUiDatabaseSchema (delete)"
type: story
module: UI
epic: phpstan-modules-2026-09-24
status: done
related:
  - ../../../../Xot/docs/stories/17.1.phpstan-modules-202-errors-fix.story.md
  - ../../wiki/concepts/testing.md
  - ../../../../../../docs/wiki/memories/ensures-ui-database-schema-trait-deleted.md
updated: 2026-10-15
tags: [docs, ui, bmad]
qmd: "ensures-ui-database-schema-trait-unused ui"
---

# ensures-ui-database-schema-trait-unused

## Obiettivo

Azzerare l'errore PHPStan `trait.unused` su
`Modules/UI/tests/Support/EnsuresUiDatabaseSchema.php`.

## Decisione: **delete** (già applicata in history)

Non **wire**. Motivazioni:

1. Il file **non esiste** nel working tree né in `HEAD` (`tests/Support/` assente).
2. `rg EnsuresUiDatabaseSchema Modules/UI` → zero match di codice.
3. `git log -S EnsuresUiDatabaseSchema`: trait creato e usato da `TestCase`
   (`use EnsuresUiDatabaseSchema` + `ensureUiSchema()`), poi rimosso in
   `e4d16be2d` (2026-08-19) insieme all'uso in `TestCase`.
4. Pattern attuale: skip offline via `TestCase::uiDbUnavailable()` /
   gruppi Pest `ui-db` / `no-ui-db`: **non** bootstrap DDL in-test
   (allineato a dati sacri / sqlite condiviso).
5. `tests/Pest.php` vieta `tests/Support/` (ADR-002).

Wire avrebbe ricreato DDL runtime in test e violato ADR-002: fuori scope.

## Verifica

```bash
rg EnsuresUiDatabaseSchema Modules/UI   # vuoto
cd laravel && php -d memory_limit=2G ./vendor/bin/phpstan analyse Modules/UI --no-progress
# [OK] No errors
```

Nessun edit codice (dead code già cancellato). Nessun `@phpstan-ignore`,
nessun edit `phpstan.neon`, nessun PhpstanProbe.

## Pest gate

Skip documentato: host di lavoro con vincolo no-Pest su produzione
(`10.100.200.15`); AC di questa story è solo PHPStan + assenza trait.
PHPUnit/Pest non applicabile a file già assente.

## Status

**done**: 2026-09-24, agent `cursor-swarm-ui`.
