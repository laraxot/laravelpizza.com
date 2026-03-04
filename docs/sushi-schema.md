# User Module - Sushi Schema Fix (`SocialProvider` Model)

This document details the resolution of an SQL syntax error encountered during the analysis of the `SocialProvider` model, which utilizes the `calebporzio/sushi` package.

## **Issue: `SQLSTATE[HY000]: General error: 1 near ")": syntax error`**

- **Problem:** During static analysis (e.g., by Laravel IDE Helper, which inspects models for schema generation), the `Modules\User\Models\SocialProvider` model was causing a fatal SQL error: `create table "social_providers" ()`. This indicated that `Sushi` was attempting to create an in-memory table without any column definitions, resulting in invalid SQL syntax.
- **Root Cause:** The `SocialProvider` model relied on `Sushi` row inference to build the table schema. When `getSushiRows()` returns an empty array (common during `ide-helper:models` or when tenant config is missing), `Sushi` ends up attempting to create the table with **no columns**, generating `create table "social_providers" ()`.

## **Resolution: Explicit `$schema` Definition for Sushi**

- **File Modified:** `laravel/Modules/User/app/Models/SocialProvider.php`
- **Change:** Added an explicit `protected array $schema` property so Sushi can always create a valid in-memory table even when rows are empty.

```php
// BEFORE (simplified)
class SocialProvider extends BaseModel
{
    use SushiToPhpArray;

    // ...
    protected $fillable = [...];

    /**
     * Logical form definition for this Sushi-backed model.
     *
     * @var array<string, string>
     */
    protected array $form = [...];

    // No explicit $schema, so Sushi may try to infer columns from rows.
}

// AFTER (simplified)
class SocialProvider extends BaseModel
{
    use SushiToPhpArray;

    // ...

    /** @var array<string, string> */
    protected array $schema = [
        'id' => 'integer',
        'name' => 'string',
        'scopes' => 'text',
        'parameters' => 'text',
        'stateless' => 'boolean',
        'active' => 'boolean',
        'socialite' => 'boolean',
        'svg' => 'text',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'created_by' => 'string',
        'updated_by' => 'string',
    ];
}
```

- **Impact:** By providing a valid `$schema`, `Sushi` always has columns to create, preventing the SQL syntax error and allowing `ide-helper:models` (and other tooling) to analyze the class.

## **DRY (Don't Repeat Yourself) / KISS (Keep It Simple, Stupid) Principles:**

- **Eliminating Redundancy:** Providing an explicit `$schema` gives Sushi a single source of truth for the in-memory table definition.
- **Clarity and Correctness:** The fix improves correctness, ensuring that the model's behavior with `Sushi` is predictable and free from runtime errors during schema inference.

This resolution ensures that the `SocialProvider` model can be properly analyzed by static analysis tools and functions as intended within the application.
