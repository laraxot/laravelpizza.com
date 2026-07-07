---
title: "AI harness — modulo User"
type: concept
module: User
tags: [user, ai, harness, auth, filament, religion-r1]
created: 2026-06-05
updated: 2026-06-05
qmd: "user module ai harness auth widget xotbase schemawidget register login"
issues:
  - "https://github.com/laraxot/module_user_fila5/issues/25"
  - "https://github.com/laraxot/base_fixcity_fila5/issues/264"
discussions:
  - "https://github.com/laraxot/module_user_fila5/discussions/26"
  - "https://github.com/laraxot/base_fixcity_fila5/discussions/265"
related:
  - ../../../r1-form-fields-self-validate.md
  - ../../../../Xot/docs/xotbase-schemawidget-pattern.md
  - ../../../../docs/wiki/concepts/ai-harness-module-discipline.md
  - ../../../../../../docs/wiki/concepts/hackernoon-ai-coding-tips-fixcity-map.md
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
| 020 | [r1-form-fields-self-validate.md](../../../r1-form-fields-self-validate.md) |

## Collegamenti

- [filament-widget-resource-form-delegation](./filament-widget-resource-form-delegation.md)
