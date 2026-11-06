---
title: "no app/Support — business logic in QueueableAction"
type: concept
tags: [cms, actions, queueable-action, support, refactor]
created: 2026-07-12
updated: 2026-07-12
qmd: "Cms module no app Support PageSchemaBuilder QueueableAction"
issues:
  - "https://github.com/laraxot/base_fixcity_fila5/issues/372"
discussions:
  - "https://github.com/laraxot/base_fixcity_fila5/discussions/273"
related:
  - ../../../../../../docs/wiki/rules/queueable-action-trait-mandatory.md
status: draft
---

# no `app/Support/` — business logic in QueueableAction

## Scopo

Nel modulo Cms **non** esiste più `app/Support/`. La costruzione dello schema JSON-LD pagina è in `BuildPageSchemaAction`.

## Migrazione (2026-07-12)

| Legacy `app/Support/` | Action |
|-----------------------|--------|
| `PageSchemaBuilder` | `BuildPageSchemaAction` (`build()` → `execute()`) |

## Consumer

- `Cms\View\Components\Metatags` → `app(BuildPageSchemaAction::class)->execute(...)`

## Collegamenti

- [queueable-action-trait-mandatory](../../../../../../docs/wiki/rules/queueable-action-trait-mandatory.md)
