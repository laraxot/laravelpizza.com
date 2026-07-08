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

## Files Affected
- `Modules/Rating/app/Models/Contracts/HasRatingContract.php`
- `Modules/Rating/app/Models/Traits/HasRating.php`

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
