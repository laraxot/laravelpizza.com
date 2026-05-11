---
title: GeopointPicker Constructor Error Fix
---

## Problem
Fatal error: `Cannot override final method Filament\Forms\Components\Field::__construct()` occurred when accessing `/it/tests/segnalazione-crea`.

## Root Cause
- `GeopointPicker` defined a public `__construct()` method
- Parent class `Filament\Forms\Components\Field` has `__construct()` marked as `final`
- Attempting to override a final method causes PHP Fatal Error

## Solution
1. **Removed the `__construct()` method entirely** – not needed since `XotBaseField` already handles initialization
2. **Removed unused `$search` property** – was leftover from experimentation and never used
3. **Kept only necessary properties** – `$latitude` and `$longitude` for coordinate storage
4. **Preserved `setUp()` method** – this is where initialization should happen in XotBaseField pattern

## Prevention
- **Always check parent class methods** before adding `__construct()` to any class extending Filament components
- **Use `setUp()` for initialization** – this is the XotBaseField/Filament pattern for field setup
- **Search for `final` keywords** in parent classes when getting inheritance errors

## Files Modified
- `laravel/Modules/Geo/app/Filament/Forms/Components/GeopointPicker.php`

## Testing
Verified the error is resolved by accessing `/it/tests/segnalazione-crea` – map now loads correctly in wizard step.

---
*Added automatically by Claude Code on 2026-04-23.*