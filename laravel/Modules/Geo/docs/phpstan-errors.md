# PHPStan Errors - Geo Module

**Date**: 2025-12-16
**PHPStan Level**: 10
**Total Errors in Module**: ~50+ (majority in AddressItemEnum.php)

## File: app/Enums/AddressItemEnum.php

### Error Category 1: Access to Undefined Constants

**Error Pattern:**
```
Access to undefined constant Modules\Geo\Enums\AddressItemEnum::PHONE
Access to undefined constant Modules\Geo\Enums\AddressItemEnum::NAME
Access to undefined constant Modules\Geo\Enums\AddressItemEnum::DESCRIPTION
Access to undefined constant Modules\Geo\Enums\AddressItemEnum::FORMATTED_ADDRESS
Access to undefined constant Modules\Geo\Enums\AddressItemEnum::PLACE_ID
```

**Lines Affected**: 196, 197, 201, 202, 206, 207, 251, 252, 256, and more

**Root Cause:**
The code is accessing enum cases as constants using `::CONSTANT_NAME` syntax, but these cases may not be defined or PHPStan cannot infer their existence.

**Probable Code Pattern:**
```php
// Line 196-197 (example)
$columns[self::PHONE->value] = function (Blueprint $table): void {
    $table->string(self::PHONE->value)->nullable();
};
```

**Issue:**
- Enum cases are being accessed as constants
- PHPStan cannot verify these constants exist
- `->value` is being called on what PHPStan sees as `mixed`

### Error Category 2: Cannot Access Property on Mixed

**Error Pattern:**
```
Cannot access property $value on mixed.
```

**Lines Affected**: 196, 197, 201, 202, 206, 207, 251, 252

**Root Cause:**
When enum case constants are not found, PHPStan treats them as `mixed` type, then complains about accessing `->value` property.

**Chain of Errors:**
1. Constant not found → type becomes `mixed`
2. `->value` access on `mixed` → second error
3. Using as array key → third error

### Error Category 3: Invalid Array Key Type

**Error Pattern:**
```
Possibly invalid array key type mixed.
```

**Lines Affected**: 196, 201, 206, 251

**Root Cause:**
Array keys must be `string|int`, but because the enum case is `mixed` (error #1), using it as array key triggers this error.

### Error Category 4: Invalid Parameter Type

**Error Pattern:**
```
Parameter #1 $column of method Illuminate\Database\Schema\Blueprint::string() expects string, mixed given.
Parameter #1 $column of method Illuminate\Database\Schema\Blueprint::text() expects string, mixed given.
```

**Lines Affected**: 197, 202, 207, 252

**Root Cause:**
Similar cascading error - enum `->value` is `mixed`, so passing it to Blueprint methods fails type check.

### Error Category 5: Return Type Mismatch

**Error Pattern:**
```
Method Modules\Geo\Enums\AddressItemEnum::getColumnDefinitions() should return
array<string, callable(Illuminate\Database\Schema\Blueprint): void> but returns
non-empty-array<Closure(Illuminate\Database\Schema\Blueprint): void>.
```

**Line**: 195

**Root Cause:**
PHPStan expects array keys to be explicitly `string`, but infers `non-empty-array` without string key guarantee.

## Recommended Fixes

### Fix 1: Define All Enum Cases

Ensure all enum cases are properly defined:

```php
enum AddressItemEnum: string
{
    case PHONE = 'phone';
    case NAME = 'name';
    case DESCRIPTION = 'description';
    case FORMATTED_ADDRESS = 'formatted_address';
    case PLACE_ID = 'place_id';
    // ... all other cases
}
```

### Fix 2: Add PHPStan Type Hints

If enum cases are dynamically determined, add PHPStan hints:

```php
/**
 * @return array<string, callable(Blueprint): void>
 */
public static function getColumnDefinitions(): array
{
    $columns = [];

    foreach (self::cases() as $case) {
        /** @var self $case */
        $columns[$case->value] = function (Blueprint $table) use ($case): void {
            // Column definition
        };
    }

    return $columns;
}
```

### Fix 3: Use Explicit Type Assertions

```php
$columns = [];

/** @var string $key */
$key = self::PHONE->value;
$columns[$key] = function (Blueprint $table) use ($key): void {
    $table->string($key)->nullable();
};
```

### Fix 4: Refactor to Avoid Dynamic Access

If possible, use match expressions or explicit mapping:

```php
public static function getColumnDefinitions(): array
{
    return [
        'phone' => fn(Blueprint $table) => $table->string('phone')->nullable(),
        'name' => fn(Blueprint $table) => $table->string('name')->nullable(),
        'description' => fn(Blueprint $table) => $table->text('description')->nullable(),
        // ...
    ];
}
```

## Investigation Required

1. **Review AddressItemEnum.php** - Check if all enum cases are defined
2. **Check method getColumnDefinitions()** - Understand the pattern used
3. **Verify enum usage** - Is it backed enum? String-backed?
4. **Test in runtime** - Do these errors occur at runtime or only in static analysis?

## Priority

**HIGH** - Over 30+ errors in single file affecting type safety

## Next Steps

1. Read the actual AddressItemEnum.php file
2. Understand the pattern being used
3. Apply appropriate fix based on actual code
4. Run PHPStan again to verify fix
5. Document the chosen solution

---

**Status**: 🔴 CRITICAL - Needs immediate attention
**Module Owner**: Geo Module Team

