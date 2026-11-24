---
title: "AI harness — modulo User"
type: concept
module: User
tags: [user, ai, harness, auth, filament, religion-r1]
created: 2026-06-05
updated: 2026-06-05
qmd: "user module ai harness auth widget xotbase schemawidget register login"
issues:
discussions:
related:
  - "./baseuser-hierarchy.md"
  - "./code-redundancy-user.md"
  - "./context-mode-user-discipline.md"
  - "./context-overflow-prevention.md"
  - "./filament-langserviceprovider-governance.md"
  - "./filament-widget-linear-crud-model-create.md"
  - "./filament-widget-resource-form-delegation.md"
  - "./folio-pages-owner-pattern.md"
---

# AI harness — User

Estensione di [ai-harness-module-discipline](../../../../docs/wiki/concepts/ai-harness-module-discipline.md).

## Scope

Auth widgets, UserForm, ruoli/permessi, Socialite.

## Regole agenti

| Tip | User |
|-----|------|
| 004/015 | Widget auth → `XotBaseSchemaWidget` + `formClass()`/`schemaMethod()` |
| 008 | STORY prima di refactor Register/Login |
| 010 | grep `Filament/Widgets/Auth` prima di nuovi widget |
| 020 | [r1-form-fields-self-validate.md](../../r1-form-fields-self-validate.md) |

## Collegamenti

- [filament-widget-resource-form-delegation](./filament-widget-resource-form-delegation.md)
