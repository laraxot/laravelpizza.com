---
title: "PHPStan Fixes 2026-05-06"
type: troubleshooting
sources: ["phpstan_modules_initial.json"]
confidence: verified
created: 2026-05-06
updated: 2026-05-06
tags: [phpstan, media, ffmpeg, type-safety]
---

# PHPStan Fixes - 2026-05-06

## Issue: Modules\Media\Actions\Video\ConvertVideoAction

PHPStan reported:
- `method.nonObject`: `Cannot call method inFormat() on mixed` and `Cannot call method save() on mixed`.

## Root Cause
Fluent APIs in `laravel-ffmpeg` can return `mixed` or complex generic types that PHPStan cannot resolve without explicit assertions.

## Fix Strategy
1. Replace `@var` PHPDoc with `Webmozart\Assert\Assert::isInstanceOf()` for runtime and static verification.
2. Ensure fluent chains are broken and verified at each step if necessary.

## Issue: Modules\Media\Actions\Video\ConvertVideoByConvertDataAction

PHPStan reported:
- `method.notFound`: `Call to an undefined method ProtoneMedia\LaravelFFMpeg\Drivers\PHPFFMpeg::save()`.

## Root Cause
Incorrect type inference during fluent chain. `inFormat()` might return a driver instead of the exporter.

## Fix Strategy
1. BREAK the fluent chain.
2. Assert type after `inFormat()`.
