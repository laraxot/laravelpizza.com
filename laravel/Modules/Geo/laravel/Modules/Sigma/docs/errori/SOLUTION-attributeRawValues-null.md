# Solution: Activity Log `attributeRawValues` Null Error

## ✅ Status: FIXED

The fix for the "Attempt to read property 'attributeRawValues' on null" error has been **implemented and committed** to the codebase.

## Problem

When accessing the Performance admin page (`/performance/admin/individuales`), users encountered:

```
ErrorException: Attempt to read property "attributeRawValues" on null
Location: vendor/spatie/laravel-activitylog/src/Traits/LogsActivity.php:359
```

## Root Cause

The error occurred due to a **recursive loop** when:
1. Models with `LogsActivity` trait have accessors that auto-save calculated values
2. Accessor calls `$this->update()` → triggers `saved` event
3. LogsActivity intercepts the event and reads attributes
4. Reading attributes triggers the **same accessor again**
5. Infinite loop → Eloquent internal state becomes null → **CRASH**

## Solution Implemented

The fix uses a **static guard flag** + `withoutEvents()` pattern:

```php
trait YourMutatorTrait
{
    private static bool $isUpdatingFromAccessor = false;

    protected function getCalculatedFieldAttribute($value)
    {
        if ($value !== null) {
            return $value;
        }

        $value = $this->calculateValue();

        if ($this->getKey() == null) {
            return $value;
        }

        // Prevent recursive activitylog crash
        if (! static::$isUpdatingFromAccessor) {
            static::$isUpdatingFromAccessor = true;
            try {
                static::withoutEvents(function () use ($value): void {
                    $this->update(['field' => $value]);
                });
            } finally {
                static::$isUpdatingFromAccessor = false;
            }
        }

        return $value;
    }
}
```

## Files Updated

### ✅ Already Fixed in HEAD
- `Modules/Performance/app/Models/Traits/MutatorTrait.php` - Fixed
- `Modules/Sigma/app/Models/Traits/Mutators/EnteMatrMutator.php` - Fixed
- `Modules/Sigma/app/Models/Traits/Mutators/EnteMatrAnnoMutator.php` - Fixed

### 🔄 Additional Improvements (in progress)
- `Modules/Sigma/app/Models/Traits/Mutators/EnteMatrDateRangeMutator.php` - Enhanced
- `Modules/Sigma/app/Models/Traits/Mutators/SchedaMutator.php` - Enhanced

## Testing Steps

1. **Clear all caches**:
   ```bash
   cd /var/www/_bases/base_ptvx_fila5/laravel
   php artisan optimize:clear
   ```

2. **Test the affected page**:
   - Navigate to: `http://ptvx.local/performance/admin/individuales`
   - Load the table with calculated fields
   - Verify no errors occur

3. **Verify activity logging still works**:
   ```bash
   # Check activity log table
   php artisan tinker
   >>> \Spatie\Activitylog\Models\Activity::latest()->limit(5)->get();
   ```

## Documentation

- **Detailed Fix Guide**: `Modules/Sigma/docs/errori/attributeRawValues-null-fix.md`
- **Troubleshooting**: `Modules/Sigma/docs/troubleshooting.md`
- **Activity Log Config**: `Modules/Ptv/docs/models/base-scheda-activity-log.md`

## Prevention

When creating new accessors that persist values:

1. ✅ **Always use the guard flag pattern**
2. ✅ **Wrap updates in `withoutEvents()`**
3. ✅ **Check for PK existence first**
4. ✅ **Document the pattern in comments**
5. ✅ **Use `try-finally` to ensure flag reset**

## Related Issues

- **Spatie Activity Log Issue**: https://github.com/spatie/laravel-activitylog/issues
- **Laravel withoutEvents()**: https://laravel.com/docs/eloquent#disabling-events

## Next Steps

If the error **still occurs** after clearing caches:

1. **Check PHP version**:
   ```bash
   php -v  # Should be 8.3+
   ```

2. **Verify composer dependencies**:
   ```bash
   composer install --no-dev
   ```

3. **Check file permissions**:
   ```bash
   chmod -R 755 storage bootstrap/cache
   ```

4. **Review logs**:
   ```bash
   tail -f storage/logs/laravel.log
   ```

## Contact

For questions or issues, refer to:
- **AI Agent Coordination**: `docs/ai-agent-coordination.md`
- **GitHub Issues**: https://github.com/provtv/base_ptv_fila5_mono/issues

---

**Last Updated**: 2026-03-24  
**Fix Status**: ✅ Implemented and Committed  
**Test Status**: ⏳ Pending verification after cache clear
