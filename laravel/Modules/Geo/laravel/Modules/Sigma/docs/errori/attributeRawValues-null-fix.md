# Fix: Activity Log `attributeRawValues` Null Error

## Problem

When using **Spatie Activity Log** with models that have **accessors/mutators** which automatically save calculated values via `update()`, a critical error occurs:

```
Attempt to read property "attributeRawValues" on null
```

**Location**: `vendor/spatie/laravel-activitylog/src/Traits/LogsActivity.php:359`

### Root Cause

The error happens due to a **recursive loop**:

1. Accessor is called (e.g., `$model->calculated_field`)
2. Accessor calculates value and calls `$this->update([...])`
3. `update()` triggers Eloquent's `saved` event
4. **LogsActivity** trait listens to `saved` event
5. LogsActivity tries to read model attributes to log changes
6. While reading attributes, it triggers **the same accessor again**
7. Accessor tries to `update()` again → **infinite loop**
8. During the loop, internal Eloquent state (`attributeRawValues`) becomes null
9. **CRASH** when LogsActivity tries to access `attributeRawValues`

### Affected Models

This issue affects models that:
- Use `LogsActivity` trait (from `spatie/laravel-activitylog`)
- Have accessors that calculate and persist values via `update()`
- Common in **Performance** and **Sigma** modules for calculated fields

## Solution

### Pattern: Static Guard Flag + `withoutEvents()`

Add a static guard flag to prevent recursive accessor execution:

```php
trait YourMutatorTrait
{
    /**
     * Guard against recursive updates from accessors.
     * Prevents "attributeRawValues null" crash with spatie/activitylog:
     * accessor → update() → LogsActivity reads attributes → accessor again → crash.
     */
    private static bool $isUpdatingFromAccessor = false;

    protected function getCalculatedFieldAttribute($value)
    {
        if ($value !== null) {
            return $value;
        }

        // Calculate value
        $value = $this->expensiveCalculation();

        // Guard: must have PK before saving
        if ($this->getKey() == null) {
            return $value;
        }

        // Prevent recursive activitylog crash
        if (! static::$isUpdatingFromAccessor) {
            static::$isUpdatingFromAccessor = true;
            try {
                static::withoutEvents(function () use ($value): void {
                    $this->update(['calculated_field' => $value]);
                });
            } finally {
                static::$isUpdatingFromAccessor = false;
            }
        }

        return $value;
    }
}
```

### Key Components

1. **Static Flag**: `private static bool $isUpdatingFromAccessor = false;`
   - Shared across all instances of the trait
   - Prevents re-entrancy during accessor execution

2. **Guard Check**: `if (! static::$isUpdatingFromAccessor)`
   - Only first call proceeds with update
   - Recursive calls skip the update (value already cached in DB)

3. **`static::withoutEvents()`**: 
   - Wraps the `update()` call
   - Prevents Eloquent events from firing during the update
   - **Critical**: Prevents LogsActivity from intercepting this internal update

4. **`try-finally` Block**:
   - Ensures flag is **always** reset, even if update fails
   - Prevents permanent lockout of future updates

### Updated Files

The following files have been updated with this pattern:

#### Sigma Module
- `Modules/Sigma/app/Models/Traits/Mutators/EnteMatrMutator.php` ✅ (already had fix)
- `Modules/Sigma/app/Models/Traits/Mutators/EnteMatrAnnoMutator.php` ✅
- `Modules/Sigma/app/Models/Traits/Mutators/EnteMatrDateRangeMutator.php` ✅

#### Performance Module
- `Modules/Performance/app/Models/Traits/MutatorTrait.php` ✅

### Alternative: Disable Activity Log (Not Recommended)

The `BaseScheda` model uses a blanket approach that **disables all activity logging**:

```php
public function getActivitylogOptions(): LogOptions
{
    return LogOptions::defaults()
        ->logOnly(['*'])
        ->logOnlyDirty()
        ->dontSubmitEmptyLogs()
        ->skip(function () {
            // Skip ALL logging - too aggressive!
            return true;
        });
}
```

**⚠️ This is NOT recommended** because:
- You lose **all audit trail** for the model
- Doesn't fix the root cause, just avoids it
- Makes debugging harder

**✅ Recommended**: Use the static guard flag pattern instead.

## Testing

After applying the fix:

1. **Clear caches**:
   ```bash
   php artisan optimize:clear
   ```

2. **Test the affected page**:
   - Navigate to `/performance/admin/individuales`
   - Load the table with calculated fields
   - Verify no errors occur

3. **Verify activity log still works**:
   ```php
   // Check that activity is logged for normal updates
   $model->some_field = 'value';
   $model->save();
   
   // Should have activity log entry
   expect($model->activities)->count()->toBeGreaterThan(0);
   ```

## Related Documentation

- [Sigma Troubleshooting Guide](../../Sigma/docs/troubleshooting.md)
- [Activity Log Error Docs](../../Activity/docs/errori/attributerawvalues-null-firstorfree.md)
- [BaseScheda Activity Log Config](../../Ptv/docs/models/base-scheda-activity-log.md)

## Prevention

When creating new accessors that persist values:

1. **Always use the guard flag pattern**
2. **Wrap updates in `withoutEvents()`**
3. **Check for PK existence first**
4. **Document the pattern in comments**
5. **Add PHPStan ignore if needed**: `// @phpstan-ignore staticProperty.access`

## See Also

- [Laravel withoutEvents()](https://laravel.com/docs/eloquent#disabling-events)
- [Spatie Activity Log Issues](https://github.com/spatie/laravel-activitylog/issues)
- [Eloquent Accessor Best Practices](https://laravel.com/docs/eloquent-mutators#defining-an-accessor)
