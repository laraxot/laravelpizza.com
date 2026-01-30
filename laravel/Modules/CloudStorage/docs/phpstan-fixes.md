# PHPStan Fixes - CloudStorage Module

This document describes the fixes applied to resolve PHPStan errors in the CloudStorage module.

## Summary of Fixes

### 1. Array Merge Issues
Fixed array_merge calls with mixed types in all factory files by replacing SafeArrayCastAction with explicit type checking:

**Before:**
```php
'metadata' => array_merge(SafeArrayCastAction::cast($attributes['metadata'] ?? []), [
    'key' => 'value',
]),
```

**After:**
```php
'metadata' => array_merge(is_array($attributes['metadata'] ?? null) ? $attributes['metadata'] : [], [
    'key' => 'value',
]),
```

### 2. Binary Operations with Mixed Types
Fixed binary operations with mixed types by ensuring proper type checking before operations:

**Before:**
```php
(int) ((is_numeric($attributes['limit'] ?? 0) ? (float) $attributes['limit'] : 0) * 0.8)
```

**After:**
```php
(int) ((is_numeric($attributes['limit'] ?? 0) ? (float) ($attributes['limit'] ?? 0) : 0) * 0.8)
```

## Files Modified

1. `database/factories/CloudStorageFileFactory.php`
2. `database/factories/CloudStorageFolderFactory.php`
3. `database/factories/CloudStorageProviderFactory.php`
4. `database/factories/CloudStorageQuotaFactory.php`
5. `database/factories/CloudStorageShareFactory.php`
6. `database/factories/CloudStorageUploadFactory.php`

## Error Types Fixed

- **array_merge() with mixed types**: All array_merge calls now properly handle mixed types
- **Binary operations with mixed types**: All mathematical operations now have proper type checking
- **Undefined method calls**: Fixed any undefined method references (fileName method issue)

## Approach Used

The "fix, don't ignore" approach was used to resolve all PHPStan errors without modifying the phpstan.neon configuration file. All fixes maintain type safety and follow the project's coding standards.

## Validation

All factory files have been checked for PHP syntax errors and are valid PHP code.