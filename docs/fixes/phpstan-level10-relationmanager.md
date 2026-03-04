# PHPStan Fix: XotBaseRelationManager Type Narrowing

## Problem
PHPStan Level 10 reported errors in `Modules\Xot\Filament\Resources\RelationManagers\XotBaseRelationManager`:
- `Call to function is_object() with ... will always evaluate to true`
- `Call to function is_bool() with bool will always evaluate to true`

## Analysis
The code contained redundant type checks for variables that PHPStan's static analysis had already determined were of the correct type (narrowed types).
- `$column` in `getTableColumns` was already identified as an object.
- `$result` in `getTableActions` closures was already identified as boolean based on the return type of `canEdit/canDetach`.

## Solution
Removed the redundant `is_object()` and `is_bool()` checks, trusting the strict typing and static analysis.

```php
// Before
if (\is_object($column)) { ... }

// After
// Direct usage as $column is known to be object
```

## Status
- Fix applied.
- Verification in progress (PHPStan Level 10).
