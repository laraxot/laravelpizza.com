---
title: "PHPStan Fixes 2026-05-06"
type: troubleshooting
sources: ["phpstan_modules_initial.json"]
confidence: verified
created: 2026-05-06
updated: 2026-05-06
tags: [phpstan, ui, filament, component]
---

# PHPStan Fixes - 2026-05-06

## Issue: Modules\UI\Filament\Forms\Components\IconPicker

PHPStan reported:
- `varTag.variableNotFound`: `Variable $packsOptions in PHPDoc tag @var does not exist`.

## Root Cause
Likely a ghost error or a mismatched file version. Grep didn't find the variable.

## Issue: Modules\UI\Filament\Forms\Components\InlineDatePicker

PHPStan reported:
- `return.type`: `getViewData()` and `generateCalendarData()` return `array` instead of `array<string, mixed>`.

## Root Cause
`array_merge` and `collect()->toArray()` often return `array<mixed, mixed>` or just `array` in PHPStan's view, which violates level 10 strictness when a more specific array type is declared in PHPDoc.

## Fix Strategy
1. Use explicit type assertions for merged arrays.
2. Use `Webmozart\Assert\Assert` to validate array shapes.

## Learning
In level 10, complex array operations like `array_merge` require explicit casting or assertions to maintain specific key/value types in PHPDoc.
