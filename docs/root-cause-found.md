# Root Cause Analysis - Homepage Layout Issue

## Problem Identified

The homepage at `/it` is rendering with the **WRONG LAYOUT**.

## Current (WRONG) Setup

### File: `Themes/Meetup/resources/views/pages/index.blade.php`

```blade
<x-layouts.app>
    @volt('home')
        <div>
            <x-page side="content" slug="home" :type="auth()->user()?->type?->value" />
        </div>
    @endvolt
</x-layouts.app>
```

**Issue**: Uses `<x-layouts.app>` which resolves to:
- `resources/views/components/layouts/app/sidebar.blade.php`
- This is a **Flux UI dashboard layout** with:
  - Sidebar navigation
  - User menu
  - Admin/dashboard interface
  - Light theme (white/zinc colors)
  - NOT the Laravel Pizza Meetups theme!

## What Should Happen

The homepage should use the **theme's layout**:
- `Themes/Meetup/resources/views/components/layouts/main.blade.php`
- Dark theme (slate-900 background)
- Laravel Pizza Meetups branding
- Navigation bar (not sidebar)
- Public-facing design (not dashboard)

## Why This is Wrong

1. **Layout Mismatch**:
   - Using admin/dashboard layout for public homepage
   - Flux UI sidebar vs. public navigation bar
   - Light theme vs. dark theme

2. **Requires Authentication**:
   - The layout expects `auth()->user()` to exist
   - Shows user menu, settings, logout
   - Not appropriate for public visitors

3. **Wrong Components**:
   - Flux sidebar, navlist, dropdown, etc.
   - Should use custom Laravel Pizza components
   - Icons and styling don't match brand

## Solution

Change the Folio page to use the theme layout.

### Option 1: Use Theme Layout Directly

```blade
<x-pub_theme::components.layouts.main>
    @volt('home')
        <div>
            <x-page side="content" slug="home" :type="auth()->user()?->type?->value" />
        </div>
    @endvolt
</x-pub_theme::components.layouts.main>
```

### Option 2: Create Alias Layout

Create a new layout component that wraps the theme layout:
- Location: `resources/views/components/layouts/public.blade.php`
- Content: Delegates to theme layout

```blade
<x-pub_theme::components.layouts.main>
    {{ $slot }}
</x-pub_theme::components.layouts.main>
```

Then in Folio page:

```blade
<x-layouts.public>
    @volt('home')
        <div>
            <x-page side="content" slug="home" />
        </div>
    @endvolt
</x-layouts.public>
```

## Additional Issues Found

### The `<x-page>` Component

The `<x-page>` component is rendering the content blocks, but we need to verify:
1. Does it find the navigation component?
2. Are the block views resolving correctly with `pub_theme::` prefix?
3. Is the content coming from database or JSON?

### Navigation Component Missing

The theme layout (`main.blade.php`) doesn't include navigation. Options:
1. Add navigation to layout
2. Make navigation a content block in home.json
3. Create separate navigation component

## Next Steps

1. ✅ Identify root cause (this document)
2. ⏳ Change Folio page to use theme layout
3. ⏳ Add navigation component to theme
4. ⏳ Verify content blocks render correctly
5. ⏳ Test and verify visual match with target (01b.png)
