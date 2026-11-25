---
title: "PHPStan Generic Type Limitations in Laravel"
type: guide
tags: [phpstan, generic, limitations, rating]
created: 2026-07-14
updated: 2026-07-14
qmd: "phpstan generic limitations"
---

# PHPStan Generic Type Limitations in Laravel

## Problem
PHPStan/Larastan reports errors about generic types in Eloquent relationships:

```
Type $this(Modules\Rating\Models\Contracts\HasRatingContract) in generic type 
Illuminate\Database\Eloquent\Relations\MorphToMany<Modules\Rating\Models\Rating, $this, ...> 
is not subtype of template type TDeclaringModel of Illuminate\Database\Eloquent\Model
```

## Root Cause
PHPStan/Larastan can't fully resolve Laravel's generic relationship types when using:
- `MorphToMany` with `MorphPivot` and `$this` type
- Interface contracts with generic return types
- `static::class` in generic type parameters

## Workaround attuale (HasRatingsTrait)

Il trait vivo è `HasRatingsTrait` (`@template TModel of Model`). Sull'host, finché **non** sta su `Ptv\BaseScheda` (story 7.2 ancora non implementata):

```php
/** @use HasRatingsTrait<static> */
use HasRatingsTrait;
```

Consumer: `IndennitaResponsabilita`, `LettF`, `LettI` (valutatore che compila voti). Non è il consolidamento DRY: è il ponte PHPStan. Non `@phpstan-ignore`.

## Files Affected (storico HasRating)

- `Modules/Rating/app/Models/Contracts/HasRatingContract.php` — contratto legacy
- `Modules/Rating/app/Models/Traits/HasRatingsTrait.php` — SSoT attuale

## Workaround
This is a **PHPStan/Larastan limitation**, not a code bug. The code works correctly at runtime.

### Option 1: Document and Accept (Recommended)
Mark as known limitation in project docs. These errors won't be fixed until PHPStan/Larastan improves generic support.

### Option 2: Simplify Contracts
Remove generic types from interfaces (lose some type safety):

```php
interface HasRatingContract
{
    // Remove generic: MorphToMany<Rating, static>
    public function ratings(): MorphToMany;
}
```

## Permanent Guardrail
**Never add `@phpstan-ignore` or baselines for generic type errors** - document them instead in `docs/wiki/`.

## Status
- [ ] PHPStan level 5: **3 generic type errors** (known limitation)
- [x] All other Modules: **0 errors**
- [x] 4918 files analyzed

## Related
- Story 8-121: PHPStan Modules Full Quality Gate
- PHPStan: https://phpstan.org/blog/whats-up-with-template-covariant
- Larastan generic support: limited for Eloquent relationships

## False Friend
- "Generic type errors are code bugs" → FALSE. These are PHPStan/Larastan type inference limitations.
