# Laraxot Coding Standards

This document outlines key coding standards and best practices specific to the Laraxot methodology. Adhering to these conventions is mandatory to ensure code quality, consistency, and maintainability.

## Eloquent Models

### `casts()` Method vs. `$casts` Property

In alignment with modern Laravel (version 11+), the `protected $casts` property is **deprecated**. All Eloquent models **must** use the `casts()` method to define attribute casting.

**Bad:**
```php
class User extends Model
{
    protected $casts = [
        'is_admin' => 'boolean',
        'options' => 'array',
    ];
}
```

**Good:**
```php
class User extends Model
{
    protected function casts(): array
    {
        return [
            'is_admin' => 'boolean',
            'options' => 'array',
        ];
    }
}
```
This approach is more consistent with other method-based configurations in Laravel and avoids potential issues with property overriding in complex inheritance scenarios.

### Relationships: `belongsToManyX()` and `morphToManyX()`

The Laraxot methodology requires using custom relationship wrappers instead of the standard Laravel methods for many-to-many relationships. This ensures automatic pivot model resolution, attribute mapping, and timestamp handling.

**CRITICAL RULE:** Use `$this->belongsToManyX()` instead of `$this->belongsToMany()` and `$this->morphToManyX()` instead of `$this->morphToMany()`.

**Why:**
- **Automatic Pivot Resultion:** Automatically guesses the pivot class name (e.g., `User` + `Role` = `RoleUser`).
- **DRY Attributes:** Automatically applies `withPivot()` using the pivot model's `$fillable` array.
- **Consistent Timestamps:** Automatically applies `withTimestamps()`.
- **Multi-Database Support:** Handles cross-database relationships by automatically prefixing table names with the database name.

**Example:**
```php
public function attendees(): BelongsToMany
{
    return $this->belongsToManyX(User::class);
}
```

## Configuration Files

### `config/database.php` Synchronization

The `config/database.php` file should be kept in sync with the version from the official [laravel/laravel](https://github.com/laravel/laravel) repository for the project's current major Laravel version.

**Action**: Before a major Laravel upgrade or when debugging database connection issues, always compare the project's `config/database.php` with the upstream version.

### Modular Dynamic Database Connections

In the Laraxot multi-tenant architecture, modular database connections (e.g., `notify`, `geo`, `xot`) MUST NOT be hardcoded in `config/database.php`.

**Rule:**
1. Keep `database.php` as close as possible to the Laravel 12.x standard.
2. Modular connections are automatically registered by `TenantServiceProvider::registerDB()`.
3. If a module requires a separate database, configure it via tenant-specific config or environment variables (e.g., `DB_DATABASE_USER`).

## Filament 4/5 Components

### Form Definitions
The `form()` method is deprecated in many Filament contexts; always use `schema()` or `getFormSchema()` instead.

### Chart Widgets
Always use the pattern of returning a PHP array for options and use `RawJs` only for JavaScript callbacks.

**Good:**
```php
public function getOptions(): array
{
    return [
        'scales' => [
            'y' => [
                'beginAtZero' => true,
            ],
        ],
    ];
}
```

## Icon Management

The Laraxot methodology follows a strict pattern for SVG icons to ensure DRY principles and clean Blade files.

### Standalone SVG Files
- NEVER include hardcoded SVG code directly in `.blade.php` files.
- All icons MUST be stored as standalone `.svg` files within the `resources/svg` directory of the relevant module (e.g., `Modules/Meetup/resources/svg/logo.svg`).

### Icon Usage
- Icons are rendered using the `x-filament::icon` component.
- The `icon` attribute should follow the pattern `{module-slash-name}-{filename}`.
- For example, a file at `Modules/Meetup/resources/svg/logo.svg` is referenced as:
  ```html
  <x-filament::icon
      icon="meetup-logo"
      class="h-12 w-12 text-red-500"
  />
  ```

### Registration
- Icon sets are automatically registered by `XotBaseServiceProvider` via `BladeUI\Icons\Factory`.

## Localization Management

Laraxot uses `mcamara/laravel-localization` as the exclusive solution for multi-language support.

### Routing & Switching
- **NO Custom Routes**: Never create routes like `language.switch` or controllers to handle locale changes.
- **Native Re-routing**: Use `LaravelLocalization::getLocalizedURL($locale)` to generate the URL for switching languages.
- **Middleware**: Ensure `LaravelLocalizationRedirectFilter`, `LaravelLocalizationViewPath`, and `LaravelLocalizationRoutes` are active (handled by core providers).

### Helpers vs. App Locale
- **Preferred Helper**: Always use `LaravelLocalization::getCurrentLocale()` instead of `app()->getLocale()`.
- **Supported Locales**: Use `LaravelLocalization::getSupportedLocales()` to iterate over active languages.

### URL Localization
- For all internal links, use `LaravelLocalization::localizeUrl($url)` to ensure the current locale is preserved.
- Example: `<a href="{{ LaravelLocalization::localizeUrl('/events') }}">`

### Flags & UI
- Integrate with the Icon Management standard: use `x-filament::icon` with the `ui-flags.` prefix.
- Note: Use `gb` for the English flag if the locale is `en`.
