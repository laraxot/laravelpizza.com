---
type: epic-story
title: UI Module BMAD Setup
status: ready-for-dev
links:
  github_issue: 0
  module: UI
qmd: "ui bmad setup story"
---

# UI Module BMAD Setup

## Overview
Initial BMAD documentation setup for the UI module.

## Acceptance Criteria
- [ ] All BMAD docs created in `Modules/UI/docs/`
- [ ] decision-log.md updated
- [ ] PHPStan passes on UI module
- [ ] Pint --dirty passes

## Standing claim (2026-11-24)

- Merge markers cleared in `app/` + `routes/` (8 entrypoints) so PHPStan can parse the module.
- Routes are empty stubs; no `require` of `Modules/Xot/routes/empty.php`.
- Kept `@contract` docs and Cms `class_exists` guard in `ResolveLocalizedBlockDataAction`.
- Inventory: [git-merge-conflict-inventory](../wiki/troubleshooting/git-merge-conflict-inventory.md).

## Notes
Module has 1 Controller and 5 Service directories that may need refactoring.
