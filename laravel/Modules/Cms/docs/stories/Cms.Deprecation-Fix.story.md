---
title: "Cms.Deprecation Fix.story"
type: note
tags: [documentation]
created: 2026-09-26
updated: 2026-09-26
qmd: "Cms.Deprecation Fix.story"
issues: []
discussions: []
---

# Cms.Deprecation-Fix: Spatie LaravelData v5 Migration

**Story ID:** Cms.Deprecation-Fix
**Epic:** Cms — PHPStan Quality
**Slug:** laravel-data-v5-migration
**Status:** backlog

## Story

As a **CI/CD pipeline**,
I want **deprecated DataCollection methods migrated to Laravel collections**,
so that **code is ready for Spatie\LaravelData v5**.

## Acceptance Criteria

1. `filter()` on DataCollection replaced with `filter()` on Laravel collection
2. `each()` on DataCollection replaced with `each()` on Laravel collection
3. PHPStan returns 0 errors on Cms module
4. Tests still pass

## Tasks / Subtasks

- [ ] Read `tests/Feature/HomepageFilamentBlocksArchitectureTest.php` lines 95-97 (AC: #1, #2)
- [ ] Identify DataCollection → Laravel collection conversion pattern (AC: #1, #2)
- [ ] Replace deprecated methods (AC: #3, #4)
- [ ] Run PHPStan on Cms module (AC: #3)
- [ ] Run Pest on Cms module (AC: #4)
- [ ] Git sync Cms module

## Dev Notes

- **Spatie\LaravelData v5**: Use regular Laravel collection instead of DataCollection for `filter()`/`each()`
- **Pattern**: `$data->toCollection()->filter(...)` instead of `$data->filter(...)`
- **Source**: [PHPStan error identifier: method.deprecated](https://phpstan.org/error-identifiers/method.deprecated)

## Owned File/Module Scope

- `Modules/Cms/tests/Feature/HomepageFilamentBlocksArchitectureTest.php`

## Learnings from Previous Stories

- LaravelData v5 migration: DataCollection methods deprecated (from Cms module analysis)

## Dev Agent Record

_(empty — to be completed by the external dev tool)_
