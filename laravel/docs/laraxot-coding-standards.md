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
- **Supported Keys**: Use `LaravelLocalization::getSupportedLanguagesKeys()` to get the array of locale codes (e.g., `['it', 'en']`). **NEVER** use `getSupportedLocalesKeys()` as it does not exist.

### URL Localization
- For all internal links, use `LaravelLocalization::localizeUrl($url)` to ensure the current locale is preserved.
- Example: `<a href="{{ LaravelLocalization::localizeUrl('/events') }}">`

### Configuration Access
- **Facade First**: Access configuration via `LaravelLocalization` Facade methods whenever possible, rather than `config('laravellocalization...')`.

### Flags & UI
- Integrate with the Icon Management standard: use `x-filament::icon` with the `ui-flags.` prefix.
- Note: Use `gb` for the English flag if the locale is `en`.

## Design & Branding Standards

Laraxot follows the **"Symbolic Minimalism"** religion for all branding and UI assets.

### Principles
1. **Symbolic Over Literal**: Avoid detailed or photorealistic representations. A logo should be a stylized geometric symbol (e.g., Lucide-style line-art).
2. **Premium Simplicity**: Professional, high-end design is achieved through geometric balance and clean strokes, not complex fills or many-colored gradients.
3. **Asset Integrity**: Logos must be vector-based (`.svg`) and share uniform design tokens (stroke-width, caps, colors) with the site-wide icon set.
4. **Learning from Failure**: The "Pizza Slice Error" (a complex, multi-colored slice with toppings) represents a low-end design failure. The correct standard is a stylized triangular geometry with minimalist points (as seen in `meetup-logo.svg`).

## Super Mucca Methodology (Laraxot Zen)

The "Super Mucca" methodology is the advanced operational framework for AI agents and developers working on Laraxot projects.

### Core Principles
1.  **Level 3 Confidence**: Act with maximum autonomy. Analyze deeply, decide based on Laraxot principles, and verify rigorously.
2.  **DRY + KISS + SOLID**: Always prioritize code reuse (Actions), simplicity (Cyclomatic Complexity < 10), and robust object-oriented design.
3.  **ROBUST (Type Safety)**: Use `declare(strict_types=1);`, strict type hints, and Webmozart Assert. NO `mixed` types.
4.  **Filament Resources & Pages**:
    - NEVER extend `Filament` classes directly. Always extend `XotBase` classes (e.g., `XotBaseResource`, `XotBasePage`, `XotBaseWidget`, `XotBaseCreateRecord`).
    - `XotBaseResource` extensions MUST NOT have `getTableColumns()`, `getPages()`, `getRelations()`, `getTableActions()`, or `getTableBulkActions()` if they only return standard values.
    - `XotBasePage` extensions MUST NOT have `$navigationIcon`, `$title`, or `$navigationLabel` properties.
    - **Translations**:
        - NEVER use `->label()`, `->placeholder()`, `->tooltip()`, `->helperText()`, or `->validationAttribute()` explicitly.
        - Rely on `Lang` module's automatic resolution.
        - Define translations in `Modules/{Module}/lang/{locale}/{resource}.php` (e.g., `Fields`, `Actions`).
        - Keys correspond to the component name (e.g., `first_name` -> `fields.first_name.label`).
5.  **Architecture First**: NEVER extend third-party or framework classes directly. Always use `XotBase*` equivalents.
6.  **Documentation as Memory**: The `docs/` folders are the technical memory of the project. Study them *before* acting; update them *after* making changes.

### File Naming & Structural Rules
- **Markdown**: All `.md` files must be lowercase, without dates or special characters (except README/CHANGELOG).
- **No Dates**: NEVER include "Last Updated" or dates in documentation content.
- **Relative Links**: All documentation links MUST be relative.
- **Prompts**: Standard AI prompts are stored in `bashscripts/tools/prompts` and must be project-agnostic.

### Prohibited Patterns
- **Property Checking**: NEVER use `property_exists()` on Eloquent models. Use `isset()` or `SafeEloquentCastAction`.
- **Traditional Controllers**: Use Filament for the back office and Folio + Volt for the front office.
- **Service Classes**: Business logic MUST be implemented as Spatie Queueable Actions.
- **Livewire Usage**: DO NOT use Livewire directly in the back office; use **Filament Widgets** instead.
- **Volt Patterns (Front Office)**: Follow the **Model-First** pattern. NEVER explode model attributes into separate public properties. Keep the model instance as a single public property (e.g., `public ?Event $event`) and access attributes in Blade via `$this->event->attribute`.

**Embody the Super Mucca: Analyze, Decide, Implement, Verify, Document.**
