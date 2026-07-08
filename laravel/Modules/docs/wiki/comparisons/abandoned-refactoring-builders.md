---
title: "Cross-Module Redundancy: Analysis Files and Abandoned Refactoring"
type: comparison
tags: [redundancy, refactoring, documentation, dry, xot]
created: "2026-05-25"
updated: "2026-05-25"
---

# Cross-Module Redundancy: Analysis Files and Abandoned Refactoring

## 1. Duplicated Analysis Files (`METODI_DUPLICATI_ANALISI.md`)

An identical 14KB analysis file titled **"🐄⚡ ANALISI METODI DUPLICATI - SUPER MUCCA EDITION"** is present in the `docs/` folder of at least 10 modules:
- `AI`, `Activity`, `Cms`, `Comment`, `Gdpr`, `Geo`, `Rating`, `Seo`, `Tenant`, `UI`.

### Issue
This file is a generic proposal for refactoring Filament List pages. While it contains valuable suggestions, its duplication across modules is ironic and violates the DRY (Don't Repeat Yourself) principle it advocates for.

### Recommended Action
- Move a single copy to `laravel/Modules/docs/wiki/comparisons/filament-list-refactoring-proposal.md`.
- Remove the duplicates from individual modules.

## 2. Abandoned Refactoring: `ColumnBuilder` and `FilterBuilder`

The "Super Mucca" analysis proposed creating `ColumnBuilder` and `FilterBuilder` classes in the `Xot` module to reduce code duplication in Filament resources.

### Current State
- ✅ **Implemented**: `Modules\Xot\Filament\Builders\ColumnBuilder` and `FilterBuilder` exist.
- ❌ **Unused**: A codebase-wide scan reveals **zero usage** of these builders in actual PHP code. They are only mentioned in the duplicated documentation files.

### Evidence
- `grep -r "use .*ColumnBuilder" laravel/Modules` returns no results.
- Filament List pages still use the long-form, repetitive `TextColumn::make(...)` declarations.

### Impact
The project currently carries the "technical debt" of the builder classes and their documentation without reaping any of the "ROI" (estimated at +159% in the report).

### Recommended Action
- Start a pilot refactoring of one core module (e.g., `User` or `Fixcity`) using these builders.
- Update the documentation to reflect that the builders are ready for use but not yet adopted.
