# PHPStan Fatal Errors: Eloquent Property Redeclaration

## Problem
PHPStan/Larastan throws fatal errors when child classes redeclare properties that already exist in parent Eloquent Model:

```
PHP Fatal error: Type of Modules\Xot\Models\XotBaseModel::$appends must not be defined (as in class Illuminate\Database\Eloquent\Model)
```

## Root Cause
Eloquent Model (and its traits like `HasAttributes`) declares properties without type hints:
- `$appends = []` (in `Illuminate\Database\Eloquent\Concerns\HasAttributes`)
- `$casts` (in `Illuminate\Database\Eloquent\Model`)
- `$listen` (in `Illuminate\Foundation\Support\Providers\EventServiceProvider`)

When child classes redeclare these with typed properties (`protected array $appends = []`), PHPStan/Larastan considers this a fatal type mismatch.

## Solution
**Never redeclare parent properties with different types.** Instead:
1. Remove the property redeclaration entirely (inherit from parent)
2. Use PHPDoc `@var` to document the expected type without redeclaring
3. If you need to set a default value different from parent, do it in constructor

## Bad Practice (Causes Fatal Error)
```php
// XotBaseModel.php - WRONG
abstract class XotBaseModel extends EloquentModel
{
    protected array $appends = []; // FATAL: redeclares parent property with type
}
```

## Good Practice (Correct)
```php
// XotBaseModel.php - CORRECT
abstract class XotBaseModel extends EloquentModel
{
    // Don't redeclare $appends, it's already in HasAttributes trait
    // Document with PHPDoc if needed:
    /** @var list<string> */
}
```

## False Friends
- **Property redeclaration in PHP is valid** - PHP allows it, but PHPStan/Larastan treats it as fatal
- **Typed properties seem better** - adding `array` type hint seems right, but breaks PHPStan analysis

## Files Fixed
- `Modules/Xot/app/Models/XotBaseModel.php` - removed `$appends` redeclaration
- `Modules/AI/app/Providers/EventServiceProvider.php` - removed `$listen` redeclaration
- `Modules/Blog/app/Models/Profile.php` - removed `$casts` redeclaration

## Related Errors
- `Type of Modules\Blog\Models\Profile::$casts must not be defined`
- `Type of Modules\AI\Providers\EventServiceProvider::$listen must not be defined`
- `Type of Modules\Xot\Models\XotBaseModel::$appends must not be defined`

## PHPStan Protocol
- **0 ignores, 0 baselines, 0 @phpstan-ignore** - never modify `phpstan.neon`
- Fix the code, never hide the error
- Clear cache: `rm -rf bootstrap/cache/phpstan-*`

## References
- `laravel/phpstan.neon` - NEVER MODIFY
- Story 8-121: PHPStan Modules Full Quality Gate
- Memory: S60, S62, S64, S65
