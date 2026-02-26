# Filament v4 Icon Size Attribute Fix

## Issue Description
After upgrading to Filament v4, the application was throwing `TypeError` when using `x-filament::icon` components with string `size` attributes.

**Error Message:**
```
TypeError - Internal Server Error
Filament\Support\generate_icon_html(): Argument #4 ($size) must be of type ?Filament\Support\Enums\IconSize, string given
```

## Root Cause
In Filament v4, the `size` attribute for icons changed from accepting string values to requiring the `IconSize` enum type.

**Before (Filament v3):**
```blade
<x-filament::icon icon="fas-futbol" size="24" />
<x-filament::icon :icon="$icon" :size="24" />
```

**After (Filament v4):**
```blade
<x-filament::icon icon="fas-futbol" class="w-6 h-6" />
<x-filament::icon :icon="$icon" class="size-6" />
```

## Files Fixed

1. **Modules/UI/resources/views/filament/widgets/stat-with-icon.blade.php**
   - Removed `size="24"` from icon component
   - Kept `class="w-auto h-12"` for size control

2. **Modules/UI/resources/views/filament/widgets/overlook.blade.php**
   - Removed `:size="24"` from icon component
   - Size controlled via CSS classes `h-36`

3. **Modules/<nome progetto>/resources/views/filament/widgets/overlook-stats.blade.php**
   - Removed `:size="24"` from two icon instances
   - Size controlled via CSS classes `size-4` and `h-36`

4. **Modules/Chart/resources/views/filament/widgets/samples/overlook.blade.php**
   - Removed `:size="24"` from icon component
   - Size controlled via CSS classes `h-24`

5. **Modules/Chart/resources/views/filament/widgets/samples/overlook-v2.blade.php**
   - Removed `:size="24"` from icon component
   - Size controlled via CSS classes `h-36`

## Solution Applied
- **Removed all `size` attributes** from `x-filament::icon` components
- **Maintained sizing** using Tailwind CSS classes in the `class` attribute
- **Cleared view cache** to ensure changes are reflected

## Best Practices for Filament v4 Icons
1. Use CSS classes for icon sizing instead of the `size` attribute
2. Use Tailwind utilities like `size-4`, `w-6 h-6`, etc.
3. If enum is required, use `IconSize::ExtraLarge` etc.

## Verification
After applying these fixes:
- ✅ Server starts without errors on port 8002
- ✅ No more `TypeError` related to icon size
- ✅ Icons maintain their visual appearance through CSS classes
- ✅ All Blade templates compile successfully

## Related Documentation
- [Filament v4 Upgrade Guide](https://filamentphp.com/docs/4.x/upgrade-guide)
- [Filament v4 Icon Component](https://filamentphp.com/docs/4.x/support/icons)