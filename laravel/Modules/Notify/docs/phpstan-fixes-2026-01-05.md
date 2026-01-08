# PHPStan Level 10 Fixes - Session 2026-01-05

## Module: Notify (2 errors)

### Priority: MEDIUM - Notification system

## Error 1: NormalizePhoneNumberAction.php:24

**Error:** Parameter #1 $string of function ltrim expects string, array<string>|string given.

**Location:** `app/Actions/SMS/NormalizePhoneNumberAction.php:24`

**Analysis:**
The `ltrim()` function receives a variable that can be either `string` or `array<string>`, but `ltrim()` only accepts `string`.

**Root Cause:** The input parameter is typed as `array<string>|string` (likely from a config or validation that allows both), but `ltrim()` requires a string.

**Solution:** Add type narrowing to ensure we only pass strings to `ltrim()`:

```php
// Before
$normalized = ltrim($phoneNumber, '+');

// After
if (is_string($phoneNumber)) {
    $normalized = ltrim($phoneNumber, '+');
} else {
    // Handle array case - concatenate or take first element
    $normalized = ltrim(implode('', $phoneNumber), '+');
}

// Or simpler - cast to string first
$normalized = ltrim((string) $phoneNumber, '+');
```

**Recommended approach:** Use Safe function wrapper:

```php
use function Safe\ltrim;

$normalized = ltrim((string) $phoneNumber, '+');
```

---

## Error 2: WhatsAppActionFactory.php:46

**Error:** Part $normalizedDriver (array<string>|string) of encapsed string cannot be cast to string.

**Location:** `app/Factories/WhatsAppActionFactory.php:46`

**Analysis:**
The code tries to use a variable in a string interpolation, but the variable can be either `string` or `array<string>`, which can't be directly cast to string in interpolation.

**Root Cause:** Similar to Error 1 - the driver name can be an array or string.

**Solution:** Cast to string before interpolation:

```php
// Before
$message = "Using driver: {$normalizedDriver}";

// After
$message = "Using driver: " . (string) $normalizedDriver;

// Or ensure it's always a string
$driverString = is_array($normalizedDriver) ? implode('|', $normalizedDriver) : $normalizedDriver;
$message = "Using driver: {$driverString}";
```

---

## Implementation Strategy

### Phase 1: Fix NormalizePhoneNumberAction
1. Read the file to understand the context
2. Add type narrowing for the input parameter
3. Use Safe function wrapper or explicit cast
4. Test with both string and array inputs

### Phase 2: Fix WhatsAppActionFactory
1. Read the file to understand the context
2. Cast driver to string before interpolation
3. Handle array case appropriately (implode or take first)
4. Test with different driver configurations

## Testing Checklist

- [ ] Run PHPStan Level 10 on Notify module - expect 0 errors
- [ ] Run PHPMD on Notify module
- [ ] Run PHPInsights on Notify module
- [ ] Test SMS normalization with various formats
- [ ] Test WhatsApp action factory with different drivers
- [ ] Git commit changes

## Related Documentation

- [Safe Functions Guide](../Xot/docs/safe-functions.md)
- [Type Narrowing Patterns](../Xot/docs/type-narrowing.md)
- [SMS Configuration](./sms_global_vs_specific_params.md)