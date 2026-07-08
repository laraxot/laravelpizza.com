---
title: "PHPStan Fixes 2026-05-06"
type: troubleshooting
sources: ["phpstan_modules_initial.json"]
confidence: verified
created: 2026-05-06
updated: 2026-05-06
tags: [phpstan, tenant, trait, sushi]
---

# PHPStan Fixes - 2026-05-06

## Issue: Modules\Tenant\Models\Traits\SushiToJsons

PHPStan reported:
- `foreach.nonIterable`: `Argument of an invalid type mixed supplied for foreach` in `resolveSchema()`.

## Root Cause
Reflection `getValue()` returns `mixed`. Even after `is_iterable()` check, PHPStan might still complain if the type is not explicitly narrowed to `array` or `Traversable` in a way it understands for `foreach`.

## Fix Strategy
1. Use `is_array()` check and explicit return type.
2. Use `Webmozart\Assert\Assert` for additional safety.

## Learning
When using Reflection to get property values, always validate and cast to the expected type before iterating.
