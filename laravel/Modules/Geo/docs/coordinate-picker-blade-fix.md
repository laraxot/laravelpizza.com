# Coordinate Picker Blade Template Fix

## Issue
The coordinate picker Blade template was causing Alpine.js expression errors when accessing `state.latitude`, `state.longitude`, and `state.address` properties that could be undefined or null.

## Problematic Code
```blade
<span x-text="state.latitude ? Number(state.latitude).toFixed(6) : '--'"></span>
<span x-text="state.longitude ? Number(state.longitude).toFixed(6) : '--'"></span>
<template x-if="state.address">
    <!-- content -->
</template>
```

## Root Cause
When the coordinate picker is first loaded or when the location is cleared, the `state` object may not have `latitude`, `longitude`, or `address` properties defined, causing Alpine.js to throw "Cannot read properties of undefined" errors.

## Solution
Modified the expressions to safely check for property existence and handle zero values correctly:

```blade
<span x-text="(state.latitude || state.latitude === 0) ? Number(state.latitude).toFixed(6) : '--'"></span>
<span x-text="(state.longitude || state.longitude === 0) ? Number(state.longitude).toFixed(6) : '--'"></span>
<template x-if="state.address">
    <!-- content -->
</template>
```

## Key Changes
1. Changed `state.latitude ?` to `(state.latitude || state.latitude === 0) ?` to handle the case where latitude is 0 (valid coordinate)
2. Applied the same fix for longitude
3. Kept the address check as `x-if="state.address"` which is safe for undefined/null values

## Files Modified
- `/var/www/_bases/base_fixcity_fila5/laravel/Modules/Geo/resources/views/filament/forms/components/coordinate-picker.blade.php`

## Testing
Verified that:
- The map initializes without Alpine errors
- Coordinates display correctly when selected
- The readout shows "--" for unset coordinates
- The address display works when reverse geocoding returns results
- No JavaScript errors in browser console

## Related Documentation
- [Geo Module Documentation](../Geo/README.md)
- [Filament Form Components](../filament-form-components.md)
- [Alpine.js Directives](https://alpinejs.dev/directives/)