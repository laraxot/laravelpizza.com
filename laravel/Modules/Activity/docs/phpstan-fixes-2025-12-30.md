# PHPStan Fixes for Activity Module (2025-12-30)

This document outlines the errors found by PHPStan in the `Activity` module and the plan to resolve them.

## File: `app/Actions/ActivityLogger.php`

### Error 1: Invalid return type for `getStatistics()`

- **Line:** 261
- **Message:** The method's PHPDoc specifies a return type of `array{..., by_type: array<string, int>, ...}`, but the implementation returns a generic `array` for the `by_type` key.
- **Analysis:** The `mapWithKeys` operation within the method does not produce a sufficiently typed array.

### Error 2: Incorrect closure type in `mapWithKeys()`

- **Line:** 274
- **Message:** The closure provided to `mapWithKeys` does not match the expected signature. It's receiving a `stdClass` and returning a generic array, while an `array<string, int>` is expected.

## Remediation Plan

1.  **Read `ActivityLogger.php`:** Examine the `getStatistics` method to understand the current logic.
2.  **Add Type Hinting:** Modify the `mapWithKeys` closure. The parameter `$item` will be correctly typed as `object{event: string, count: int}`. This will allow PHPStan to understand the structure.
3.  **Ensure Correct Return:** The closure will be updated to explicitly return `[$item->event => $item->count]`, ensuring the resulting collection is of type `array<string, int>`.
4.  **Verify:** Run `phpstan`, `phpmd`, and `phpinsights` on the modified `app/Actions/ActivityLogger.php` to ensure the fix is correct and introduces no new issues.
5.  **Commit:** Once verified, commit the changes with a descriptive message.
