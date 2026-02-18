# Folio Route Precedence - Why the Wrong Blade is Matched

## Problem

When accessing `/it/events/laravel-beginners-pizza-night`, the wrong Blade file was being rendered.

### Root Cause

The `events` directory was **deleted** from `Themes/Meetup/resources/views/pages/`, so Folio couldn't find the specific route and fell back to the catch-all `[slug].blade.php`.

### Why This Happens

Folio searches for routes in this priority order:

1. **Exact match**: `pages/events/index.blade.php` → `/events`
2. **Static routes**: `pages/about.blade.php` → `/about`
3. **Nested routes**: `pages/events/detail.blade.php` → `/events/detail`
4. **Parameter routes**: `pages/events/[slug].blade.php` → `/events/{slug}`

When the `events` directory doesn't exist, Folio:
1. Can't find `/events/{slug}` route
2. Falls back to the catch-all `[slug].blade.php` at the root level

## Solution Applied

1. Created `pages/events/` directory
2. Created `pages/events/index.blade.php` for `/events` (list)
3. Created `pages/events/[slug].blade.php` for `/events/{slug}` (detail)

## Route Precedence for Same URL

If you have multiple routes that could match, Folio uses **alphabetical order** of directories:

```
pages/
├── events/
│   ├── index.blade.php      → /events (HIGHEST priority)
│   └── [slug].blade.php    → /events/{slug}
└── [slug].blade.php        → /{slug} (LOWEST priority - catch-all)
```

The more **specific** route always wins over the **generic** one.

## How to Give Precedence to a Specific Route

### Option 1: More Specific Directory (Recommended)

Create a dedicated directory with the exact route you want:

```
pages/events/
├── index.blade.php     → /events
└── [slug].blade.php   → /events/{slug}
```

This ALWAYS has higher precedence than `pages/[slug].blade.php`.

### Option 2: Use Route Order via Folio Service Provider

In `app/Providers/FolioServiceProvider.php`:

```php
Folio::path(resource_path('views/pages/events'))
    ->middleware(['*' => []]);

Folio::path(resource_path('views/pages'))
    ->middleware(['*' => []]);
```

The first path registered gets higher priority.

### Option 3: Rename the Catch-All

Rename `[slug].blade.php` to something less generic:

```
pages/
├── events/
│   ├── index.blade.php
│   └── [slug].blade.php
└── cms/
    └── [slug].blade.php    → Only catches non-events routes
```

## Important Notes

1. **Never delete a route directory** - It will break the specific routes
2. **Always create index.blade.php** - For list pages like `/events`
3. **Use [slug].blade.php** - Only inside specific directories, not at root level
4. **Check routes with**: `php artisan folio:list`

## Current Correct Structure

```
Themes/Meetup/resources/views/pages/
├── [slug].blade.php              → CMS catch-all (/{slug})
└── events/
    ├── index.blade.php          → /events
    └── [slug].blade.php         → /events/{slug}
```

## Testing

```bash
# Check all Folio routes
php artisan folio:list

# Filter specific routes
php artisan folio:list | grep events

# Test the URL
curl http://127.0.0.1:8000/it/events
curl http://127.0.0.1:8000/it/events/laravel-beginners-pizza-night
```
