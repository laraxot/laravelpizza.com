---
title: "second brain module tests docs error"
type: note
status: draft
updated: 2026-10-20
tags: [docs, user]
qmd: "second brain module tests docs error user"
---
## Second Brain: Module Tests & Docs Convention

**Concept:** `module-docs-tests-convention`

**Rule:** Ogni modulo ha `tests/` e `docs/` a livello di modulo, mai `laravel/tests/Modules/`.

**Error learned:** Used `laravel/tests/Modules/` path incorrectly: not verified before suggesting. The actual structure is:

| Scope | Tests | Docs |
|-------|-------|------|
| Module Xot | `laravel/Modules/Xot/tests/` | `laravel/Modules/Xot/docs/` |
| Module User | `laravel/Modules/User/tests/` | `laravel/Modules/User/docs/` |
| Theme Sixteen | `laravel/Themes/Sixteen/tests/` | `laravel/Themes/Sixteen/docs/` |

**BMAD reference:** `laravel/Modules/User/docs/bmad/module-tests-docs-convention.md`
