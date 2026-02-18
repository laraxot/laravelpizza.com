# Laravel Folio - Page Based Routing

## Overview

Laravel Folio is a page-based router for Laravel that simplifies routing by using Blade templates in the `resources/views/pages` directory.

## Basic Concepts

### Route Parameters

Folio uses square brackets in filenames to capture URL segments:

```
pages/users/[id].blade.php      → /users/1, /users/123
pages/events/[slug].blade.php  → /events/laravel-11-release-pizza-party
```

### Nested Routes

```
pages/events/index.blade.php    → /events (index of events)
pages/events/[slug].blade.php  → /events/{slug}
```

### Model Binding

Folio automatically resolves Eloquent models using two syntaxes:

**Simple (model in App\Models):**
```
pages/users/[User].blade.php       → /users/1 (resolves User model by id)
pages/events/[Event:slug].blade.php → /events/laravel-11 (resolves by slug)
```

**FQCN (model in module namespace — dots replace backslashes):**
```
pages/events/[.Modules.Meetup.Models.Event].blade.php → /events/{slug}
```
Folio converts dots to backslashes: `.Modules.Meetup.Models.Event` → `Modules\Meetup\Models\Event`.
The model's `getRouteKeyName()` determines which column is used for binding (e.g., `slug`).

## Common Issues

### 1. Catch-all [container0] Intercepting Routes

**Problem:** Test directories like `[container0]/index.blade.php` intercept all Folio routes because nested directory parameters have higher priority than single-parameter catch-alls like `[slug].blade.php`.

**Solution:**
- Remove any `[container0]` or similar test directories
- Clear compiled views: `php artisan view:clear`
- Clear route cache: `php artisan route:clear`

### 2. Index Routes

**Problem:** `/events` matching `/events/{slug}` incorrectly

**Solution:** Create separate index file:
```
pages/events/index.blade.php  → /events (list)
pages/events/[slug].blade.php → /events/{slug} (detail)
```

### 3. Route Order

Folio matches routes in this order:
1. Exact matches (index.blade.php)
2. Static routes (about.blade.php)
3. Nested routes (users/profile.blade.php)
4. Parameter routes ([slug].blade.php)

**Critical:** When both `[container0]/[container1]/index.blade.php` and `[container0]/[slug].blade.php` match the same URL, Folio prefers `index.blade.php` because it's considered more specific. See [Folio Container Routing Priority](folio-container-routing-priority.md) for details and solutions.

## File Structure

```
resources/views/pages/
├── index.blade.php              → /
├── about.blade.php              → /about
├── [slug].blade.php             → /{slug} (CMS catch-all)
├── events/
│   ├── index.blade.php          → /events
│   └── [slug].blade.php         → /events/{slug}
└── auth/
    ├── login.blade.php          → /auth/login
    └── register.blade.php       → /auth/register
```

## Key Files in LaravelPizza

- `Themes/Meetup/resources/views/pages/[slug].blade.php` - CMS catch-all (loads pages from JSON via SushiToJsons)
- `Themes/Meetup/resources/views/pages/events/[.Modules.Meetup.Models.Event].blade.php` - Event detail (Folio model binding by slug)

**Note:** The events list (`/it/events`) is CMS-driven via `events.json`, rendered by `[slug].blade.php`. There is NO `events/index.blade.php`.

## Commands

```bash
# List all Folio routes
php artisan folio:list

# Create a new page
php artisan folio:page path/to/page

# Install Folio
php artisan folio:install
```

## Best Practices

1. Always create index.blade.php for list pages
2. Use descriptive parameter names (slug, id, username)
3. For model binding, use: `[ModelName]` or `[ModelName:column]`
4. Keep route parameters simple (avoid complex names)
5. Test routes with `php artisan folio:list`
