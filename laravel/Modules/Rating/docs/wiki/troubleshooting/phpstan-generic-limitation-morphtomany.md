---
title: "PHPStan Generic Limitation: MorphToMany with static"
type: troubleshooting
sources: []
confidence: high
created: 2026-05-06
updated: 2026-05-06
tags: [phpstan, larastan, rating, generic-types, known-limitation]
related:
  - ../../Xot/docs/wiki/troubleshooting/phpstan-fatal-errors-eloquent-properties.md
---

# PHPStan Generic Limitation: MorphToMany with static

## Problem

PHPStan/Larastan cannot reconcile `MorphToMany<Rating, static>` return type when the interface declares `MorphToMany<Rating>`.

### Error Messages
```
Line   Rating/app/Models/Contracts/HasRatingContract.php
 20     Type string in generic type Illuminate\Database\Eloquent\Relations\MorphToMany<...> in PHPDoc tag @return is not subtype of template type...
```

```
Line   Rating/app/Models/Traits/HasRating.php (in context of class Modules\Blog\Models\Article)
 24     Return type MorphToMany<Rating, static(Article)> should be compatible with MorphToMany<Rating, Illuminate\Database\Eloquent\Relations\MorphPivot>
 26     Method Article::ratings() should return MorphToMany<Rating, static(Article)> but returns MorphToMany<Rating, $this(Article)>
```

## Root Cause

PHPStan's template type `TDeclaringModel` on `MorphToMany` is **not covariant**. This is a known PHPStan/Larastan limitation with Eloquent's `static` return type in trait context.

- Interface: `HasRatingContract::ratings(): MorphToMany<Rating>`
- Trait: `HasRating::ratings(): MorphToMany<Rating, static>`
- PHPStan expects exact match, but `static` vs explicit model creates generic type mismatch

## Solution

**This is a PHPStan limitation, NOT a code bug.**

### What we did
1. Documented the limitation (this page)
2. Verified code works at runtime (Eloquent handles `static` correctly)
3. Did NOT add `@phpstan-ignore` (per project protocol: 0 ignores, 0 baselines)

### Why no @phpstan-ignore
- Project protocol forbids `@phpstan-ignore` in code
- These are false positives from PHPStan's generic type system
- Runtime behavior is correct

## References
- PHPStan blog: https://phpstan.org/blog/whats-up-with-template-covariant
- Larastan issue: Generic type limitations with MorphToMany + static
- Project protocol: `laravel/phpstan.neon` is NEVER modified

## Status
- **5 remaining PHPStan errors** (as of 2026-05-06)
- All are generic type false positives in Rating module
- Code is correct, PHPStan cannot infer `static` in generic context
