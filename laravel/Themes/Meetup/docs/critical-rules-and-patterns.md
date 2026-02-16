# Critical Rules and Patterns - Laravel Pizza Meetups

## Architecture Overview

**Framework Stack**:
- Laravel 11.28+
- Livewire Volt (functional API)
- Laravel Folio (file-based routing)
- Filament 5.x (admin panel only; componenti singoli nel tema per form/notifiche/widget)
- Tailwind CSS 4 (using `@theme` syntax)
- Alpine.js 3.x

Riferimento Filament 5 e uso nel tema: [filament-5-theme-reference](filament-5-theme-reference.md).

**Core Principle**: NO Controllers, NO web.php routes - ONLY Folio + Volt + Filament

## Critical Rules

### 1. Theme Asset Build System

**RULE**: Themes have TWO separate asset systems:

```
Themes/Meetup/
├── resources/html/          # Static HTML prototypes (SOURCE)
│   ├── css/app.css         # Built by Theme's vite.config.js
│   └── js/app.js
├── public/                  # Static HTML build output (OUTPUT) ← DEPLOY THIS
│   ├── assets/             # Vite compiled CSS/JS
│   └── manifest.json
└── resources/               # Laravel integration
    ├── css/app.css         # Built by ROOT vite.config.js  ← USE THIS
    └── js/app.js           # Built by ROOT vite.config.js  ← USE THIS
```

**Static HTML Build Flow**:
```
1. Source: resources/html/ (index.html, CSS, JS)
   ↓
2. Vite Build: Reads from resources/html/ (configured in Theme's vite.config.js)
   ↓
3. Output: public/ (compiled assets ready for deployment)
   ↓
4. Deploy: Copy public/* to web server directory
```

**WHY public/* NOT resources/html/dist/**:
- `vite.config.js` line 21 sets `outDir: './public'`
- `public/` represents production-ready, optimized assets
- Standard web server convention for publicly accessible files
- The `resources/html/dist/` may exist but `public/` is canonical

**Build Commands**:
```bash
# For Laravel integration at http://127.0.0.1:8000/it (MOST COMMON)
cd /var/www/_bases/base_laravelpizza/laravel/Themes/Meetup
npm run build && npm run copy    # BOTH needed to see changes!

# Breakdown:
# 1. npm run build  → Compiles resources/* to public/
# 2. npm run copy   → Deploys public/* to ../../../public_html/themes/Meetup

# For static HTML prototypes (DESIGN ONLY)
cd /var/www/_bases/base_laravelpizza/laravel/Themes/Meetup
npm run build               # Vite outputs to ./public/
npm run copy                # Copies ./public/* to ../../../public_html/themes/Meetup
```

**CRITICAL**: To see changes in http://127.0.0.1:8000/it you MUST run BOTH `npm run build && npm run copy`

**Critical package.json Commands**:
```json
{
  "scripts": {
    "build": "vite build",
    "copy": "cp -r ./public/* ../../../public_html/themes/Meetup"
  }
}
```

**RULE**: ALWAYS copy from `./public/*` NOT `./resources/html/dist/*`

### 2. Vite Configuration

**Root vite.config.js MUST point to correct paths**:

```javascript
// ✅ CORRECT
laravel({
    input: [
        'Themes/Meetup/resources/css/app.css',
        'Themes/Meetup/resources/js/app.css',
    ],
})

// ❌ WRONG - Do NOT point to resources/html/
laravel({
    input: [
        'Themes/Meetup/resources/html/css/app.css',  // ❌ WRONG
    ],
})
```

### 3. Use Metatags Component (NOT Raw <head>)

**RULE**: NEVER use raw `<head>` tags in layouts. ALWAYS use `<x-metatags>` component.

**Why**:
- Centralizes SEO management (title, description, keywords)
- Includes Open Graph / Twitter Cards automatically
- Handles favicons, preconnect, DNS prefetch
- **Already includes @vite() with correct theme path**
- Uses `$meta` object for dynamic metadata

**Correct Usage**:
```blade
{{-- Themes/Meetup/resources/views/components/layouts/main.blade.php --}}
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
    <x-metatags>
        {{-- Theme-specific additions go in slot --}}
        <link href="https://fonts.googleapis.com/css2?family=Inter..." rel="stylesheet">
        <script type="application/ld+json">...</script>
    </x-metatags>
    <body>
        {{ $slot }}
    </body>
</html>
```

**Wrong Usage**:
```blade
{{-- ❌ NEVER DO THIS --}}
<head>
    <meta charset="utf-8">
    <title>My Site</title>
    @vite([...])
</head>
```

**Component Location**: `Modules/Cms/resources/views/components/metatags.blade.php`

**Key Features**:
- Automatically loads assets via `@vite()` using `$meta->getPubTheme()`
- Manages SEO tags dynamically
- Includes structured data support
- Handles multi-language support

### 4. Namespace Resolution

**pub_theme namespace** resolves to configured theme:

```php
// config/local/laravelpizza/xot.php
return [
    'pub_theme' => 'Meetup',
    'register_pub_theme' => true,
];
```

**Resolution path**:
```
pub_theme::components.blocks.hero.main
↓
Themes/Meetup/resources/views/components/blocks/hero/main.blade.php
```

**Registered in**: `Modules/Cms/app/Providers/CmsServiceProvider.php`

### 5. Blade Comments and Directives

**RULE**: NEVER put Blade directives inside comment blocks unless complete and balanced.

**Why**: Blade still parses directives inside `{{-- --}}` comment blocks, which can cause syntax errors.

**Wrong**:
```blade
{{-- ❌ NEVER DO THIS
@foreach($items as $item)
    <div>{{ $item }}</div>
--}}
```

**Correct Options**:

**Option 1** - Simple comment without directives:
```blade
{{-- ✅ This is safe --}}
```

**Option 2** - Use `@if(false)` for conditional code:
```blade
@if(false)
    @foreach($items as $item)
        <div>{{ $item }}</div>
    @endforeach
@endif
```

**Option 3** - HTML comments for non-directive content:
```blade
<!-- Regular HTML comment -->
```

**Error Example**:
```
ParseError: syntax error, unexpected end of file, expecting "elseif" or "else" or "endif"
```

**Cause**: Unclosed `@foreach`, `@if`, or other directive inside comment block.

### 6. Content Blocks System

**JSON structure**:
```json
{
    "slug": "home",
    "content_blocks": {
        "it": [{
            "type": "hero",
            "slug": "hero-section",
            "data": {
                "view": "pub_theme::components.blocks.hero.main",
                "title": "Laravel Developers. Pizza. Community.",
                "subtitle": "Join fellow Laravel enthusiasts..."
            }
        }]
    }
}
```

**Component receives** `$data` array with all parameters.

### 7. Block Component Props Pattern (CRITICAL!)

**RULE**: All block components MUST handle BOTH data formats

**Why**: `page-content.blade.php` uses `@include($block->view, $block->data)` which expands the array into separate variables.

**Pattern**:
```blade
@props([
    'data' => [],          # Fallback array format
    'title' => null,       # Individual variables from @include
    'description' => null,
    'events' => [],
])

@php
    // Normalize: check individual var first, then $data array, then default
    $title = $title ?? ($data['title'] ?? 'Default Value');
    $description = $description ?? ($data['description'] ?? 'Default');
    $events = $events ?? ($data['events'] ?? []);
@endphp

{{-- Use normalized variables --}}
<h2>{{ $title }}</h2>
@foreach($events as $event)
    {{ $event['title'] }}
@endforeach
```

**Why This Works**:
1. When `@include('view', ['title' => 'foo', 'events' => []])` → Laravel creates `$title` and `$events` variables
2. Component `@props` declares both individual props AND `$data` array
3. PHP block normalizes using null coalescing: `$var ?? $data['var'] ?? 'default'`
4. Template uses the normalized variables

**WRONG Pattern**:
```blade
❌ @props(['data'])
❌ {{ $data['title'] }}  # Fails because $data doesn't exist
```

**Reference**: `Themes/Meetup/docs/[DATE]-block-component-props-pattern.md`

### 8. Tailwind CSS 4 Syntax

**Use `@import` instead of `@tailwind`**:

```css
/* ✅ CORRECT - Tailwind CSS 4 */
@import 'tailwindcss';

@source '../views';

@theme {
    --font-sans: 'Inter', ui-sans-serif, system-ui, sans-serif;
    --color-red-600: #dc2626;
}

/* ❌ WRONG - Tailwind CSS 3 */
@tailwind base;
@tailwind components;
@tailwind utilities;
```

### 7. Meetup Theme Colors

**Primary brand colors**:
- Primary: Red (`#dc2626` / `red-600`)
- Background: Slate (`#0f172a` / `slate-900`)
- Accents: Gray shades

**Dark theme by default**: `bg-slate-900 text-white`

### 8. Cache Clearing Workflow

**After ANY code change**:

```bash
php artisan view:clear
php artisan cache:clear
php artisan optimize:clear
```

**After asset changes**:

```bash
npm run build
php artisan view:clear
php artisan optimize:clear
```

### 9. Component Section Pattern

**Section components** resolve via slug + template:

```blade
<x-section slug="header" tpl="v1" />
↓
pub_theme::components.sections.header.v1
↓
Themes/Meetup/resources/views/components/sections/header/v1.blade.php
```

**Logic**: `Modules/Cms/app/View/Components/Section.php`

### 10. File Naming Convention

**All docs must be lowercase** except:
- `README.md`
- `CHANGELOG.md`
- `CLAUDE.md`

```
✅ architecture-folio-volt-filament.md
❌ Architecture-Folio-Volt-Filament.md
```

## Folio + Volt Patterns

### 1. File-Based Routing

**File location** → **Route**:

```
resources/views/pages/index.blade.php → /
resources/views/pages/events/index.blade.php → /events
resources/views/pages/dashboard/index.blade.php → /dashboard
```

### 2. Volt Functional Components

```blade
{{-- resources/views/pages/events/index.blade.php --}}
<?php

use function Livewire\Volt\{state, mount};

state(['events' => []]);

mount(function () {
    $this->events = Event::upcoming()->get();
});

?>

<div>
    @foreach($events as $event)
        <x-event-card :event="$event" />
    @endforeach
</div>
```

### 3. Layout Hierarchy

**3-level structure**:

```
main.blade.php (HTML shell, loads assets)
    ↓
app.blade.php (header + footer)
    ↓
page.blade.php (content)
```

### 4. State Management

**Use `locked()` for immutable data**:

```php
use function Livewire\Volt\{state, locked};

locked(['eventId' => fn() => $this->event->id]);
state(['attendees' => []]);
```

## Common Issues & Solutions

### Issue: View Not Found

**Symptom**: `View pub_theme::components.blocks.hero.main not found`

**Causes**:
1. File doesn't exist
2. Namespace not registered
3. Cache not cleared

**Solution**:
```bash
# 1. Verify file exists
ls -la Themes/Meetup/resources/views/components/blocks/hero/

# 2. Check config
php artisan tinker
> config('xot.pub_theme')
> config('xot.register_pub_theme')

# 3. Clear caches
php artisan optimize:clear
```

### Issue: Styles Not Applied

**Symptom**: Page renders but no Tailwind styles

**Causes**:
1. Assets not built
2. Wrong vite config paths
3. Cached assets

**Solution**:
```bash
# 1. Check vite.config.js paths
cat vite.config.js | grep "Themes/Meetup"

# 2. Rebuild assets
npm run build

# 3. Clear caches
php artisan view:clear
php artisan optimize:clear

# 4. Hard refresh browser (Ctrl+Shift+R)
```

### Issue: Alpine.js Not Working

**Symptom**: `x-data` directives don't work

**Causes**:
1. Alpine.js not installed
2. Not imported in app.js
3. Assets not rebuilt

**Solution**:
```bash
# 1. Install Alpine.js
npm install alpinejs --save-dev

# 2. Import in Themes/Meetup/resources/js/app.js
import Alpine from 'alpinejs'
window.Alpine = Alpine
Alpine.start()

# 3. Rebuild
npm run build
```

## Development Workflow

### 1. Static HTML Prototype Phase

```bash
cd Themes/Meetup
npm run dev  # Port 5173
```

Work in `resources/html/` for rapid prototyping.

### 2. Laravel Integration Phase

```bash
# Copy finalized assets
cp resources/html/css/app.css resources/css/app.css
cp resources/html/js/app.js resources/js/app.js

# Build for Laravel
cd ../../  # Back to Laravel root
npm run build

# Clear caches
php artisan optimize:clear

# Test
php artisan serve
```

### 3. Content Blocks Phase

1. Create block component in `Themes/Meetup/resources/views/components/blocks/{type}/{name}.blade.php`
2. Add block to JSON in `config/local/laravelpizza/database/content/pages/{slug}.json`
3. Clear caches and test

## Quick Reference

### Essential Commands

```bash
# Laravel root
cd /var/www/_bases/base_laravelpizza/laravel

# Build assets
npm run build

# Clear all caches
php artisan optimize:clear

# Start server
php artisan serve

# List Folio routes
php artisan folio:list
```

### Essential Paths

```
Root: /var/www/_bases/base_laravelpizza/laravel/
Theme: Themes/Meetup/
Config: config/local/laravelpizza/
Content: config/local/laravelpizza/database/content/
Pages: resources/views/pages/ (Folio)
Modules: Modules/
```

### Essential Files

```
vite.config.js                              # Root Vite config
Themes/Meetup/resources/css/app.css         # Theme CSS (Laravel)
Themes/Meetup/resources/js/app.js           # Theme JS (Laravel)
Themes/Meetup/resources/views/components/layouts/main.blade.php  # Main layout
config/local/laravelpizza/xot.php           # Theme config
```

## Documentation Structure

```
Themes/Meetup/docs/
├── critical-rules-and-patterns.md          # THIS FILE
├── theme-asset-build-system.md             # Asset compilation
├── block-components-structure.md           # Content blocks
├── frontend-asset-management.md            # Asset workflow
├── architecture-folio-volt-filament.md     # Architecture
└── troubleshooting/                        # Common issues
```

## Key Takeaways

1. ✅ **Assets**: Use `Themes/Meetup/resources/css` NOT `resources/html/css` for Laravel
2. ✅ **Build**: Run `npm run build && npm run copy` from theme directory to see changes at http://127.0.0.1:8000/it
3. ✅ **Static HTML Deploy**: ALWAYS copy from `./public/*` NOT `./resources/html/dist/*`
4. ✅ **Vite**: Root vite.config.js must point to correct theme paths
5. ✅ **Metatags**: Use `<x-metatags>` component, NEVER raw `<head>` tags
6. ✅ **Blade Comments**: NEVER put directives inside `{{-- --}}` unless balanced
7. ✅ **Cache**: Always clear after changes: `php artisan optimize:clear`
8. ✅ **Tailwind**: Use `@import 'tailwindcss'` and `@theme {}` syntax
9. ✅ **Colors**: Red (primary) + Slate (background) for Meetup theme
10. ✅ **Namespace**: `pub_theme::` resolves to configured theme directory
11. ✅ **Content**: JSON defines blocks, components receive `$data` array
12. ✅ **Block Props**: ALWAYS use dual-format props pattern (individual vars + $data array)
13. ✅ **Layouts**: Use `<x-layouts.app>` NOT `<x-layouts.public>` (avoid redundant wrappers)

---

**Purpose**: Master reference for all critical patterns and rules
