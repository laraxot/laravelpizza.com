---
id: user-phpstan-filter-form-schema-20261123
title: UsersRelationManager table filter resta su form()
type: story
module: User
epic: quality/phpstan
status: done
qmd: "phpstan UsersRelationManager form schema BaseFilter table filter"
related:
  - ../../../../Xot/docs/bmad/filament-filter-schema-to-form.md
  - ../../../../Xot/docs/bmad/stories/phpstan-filterbuilder-schema.story.md
---

# Scopo

Verificare il residuale PHPStan su
`RoleResource/RelationManagers/UsersRelationManager` (filtro `created_at`).

## Acceptance criteria

- [x] `Filter::make(...)->form([...])` conservato (API corretta tables ≥ 5.11.2).
- [x] Nessun passaggio a `->schema()` (deprecato su `BaseFilter`).
- [x] Story collegata a Xot `phpstan-filterbuilder-schema`.

## Root cause

Report che chiede `form()` → `schema()` è invertito rispetto a
`Filament\Tables\Filters\Concerns\HasForm` su filament/tables v5.12.0.
Il call-site User era già corretto; nessuna patch applicativa.

## Gate

- `php -l` OK sul RelationManager.
- PHPStan mirato (flock, con Xot): **[OK] No errors** — `->form()` non segnalato.
- Pest: **skip** — nessuna patch applicativa User; gate DB testing remoto rifiutato
  da `TestDatabaseGuard` (vedi story Xot gemella).
