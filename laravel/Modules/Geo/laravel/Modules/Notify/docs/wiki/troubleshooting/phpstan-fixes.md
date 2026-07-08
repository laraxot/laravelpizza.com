---
title: "PHPStan Fixes 2026-05-06"
type: troubleshooting
sources: ["phpstan_modules_initial.json"]
confidence: verified
created: 2026-05-06
updated: 2026-05-06
tags: [phpstan, notify, data, action]
---

# PHPStan Fixes - 2026-05-06

## Issue: Modules\Notify\Actions\BuildMailMessageAction

PHPStan reported:
- `offsetAccess.nonOffsetAccessible`: `Cannot access offset 'from_email' on mixed`.

## Root Cause
`app(Get::class)` returns `mixed`. Even though `execute()` return type is known, PHPStan doesn't automatically resolve the service container output without a type hint or `@var`.

## Fix Strategy
1. Add explicit `@var` for the `$theme` object.

## Issue: Modules\Notify\Datas\*

PHPStan reported:
- `missingType.property`: Properties like `$view`, `$title`, `$colors` have no type specified.

## Root Cause
In level 10, even with PHP 8.x typed properties, PHPStan might require explicit PHPDoc types for properties that are uninitialized or have complex array types.

## Fix Strategy
1. Add explicit PHPDoc `@var` for all properties reporting this error.
2. Specify array shapes/types (e.g., `array<string, mixed>`).
