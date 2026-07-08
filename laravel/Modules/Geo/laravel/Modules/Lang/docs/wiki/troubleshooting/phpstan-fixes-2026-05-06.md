---
title: "PHPStan Fixes 2026-05-06"
type: troubleshooting
sources: ["phpstan_modules_initial.json"]
confidence: verified
created: 2026-05-06
updated: 2026-05-06
tags: [phpstan, lang, action, type-safety]
---

# PHPStan Fixes - 2026-05-06

## Issue: Modules\Lang\Actions\ReadTranslationFileAction

PHPStan reported:
1. `execute()` returns `array<mixed, mixed>` instead of `array<string, mixed>`.
2. `arrayToPhp()` receives `array<mixed, mixed>` instead of `array<string, mixed>` in recursion.

## Root Cause
PHPStan level 10 requires explicit verification that array keys are strings when expected. `require` returns `mixed`, and nested arrays are also inferred as `mixed` until checked.

## Fix Strategy
1. Use `Webmozart\Assert\Assert` to validate array keys.
2. Ensure recursive calls are type-safe.

## Learning
When dealing with translation files (nested arrays), we must verify that EVERY level has string keys to satisfy strict typing.
