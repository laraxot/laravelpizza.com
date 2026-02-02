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
