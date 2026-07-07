---
title: PHPStan Standards - Tenant Module (SushiToJson Traits)
type: technical
tags: [phpstan, sushi, traits, tenant, json]
created: 2026-06-10
updated: 2026-06-10
qmd: docs/wiki/phpstan-tenant-module.md
---

# PHPStan Level 10 Standards - Tenant Module

## SushiToJson Traits

The Tenant module provides two traits for Sushi JSON storage with full PHPStan compliance.

### SushiToJson (Single File per Model)

```php
trait SushiToJson
{
    use Sushi;

    /**
     * Get JSON file path for current model.
     * @return string Full path to tenant-specific JSON file
     */
    public function getJsonFile(): string
    
    /**
     * Required by Sushi to populate in-memory table.
     * @return array<int, array<string, mixed>> Records for Sushi
     */
    public function getRows(): array
    
    /**
     * Get normalized data from JSON file.
     * @return array<int, array<string, mixed>> Normalized records
     * @throws Exception If data format is invalid
     */
    public function getSushiRows(): array
}
```

### SushiToJsons (Multiple Files per Model)

```php
trait SushiToJsons
{
    use Sushi;
    
    /**
     * Get data from multiple JSON files.
     * @return array<int, array<string, mixed>> Merged records
     */
    public function getSushiRows(): array
    
    /**
     * Get individual JSON file path for a record.
     * Format: database/content/{table}/{id}.json
     * @return string Path to record JSON file
     */
    public function getJsonFile(): string
    
    /**
     * Boot trait with model events.
     * Handles creating, updating, deleting with JSON persistence.
     */
    protected static function bootSushiToJsons(): void
}
```

## Models Using Traits

| Model | Trait | Purpose |
|-------|-------|---------|
| `Page` | `SushiToJsons` | Page content blocks |
| `Section` | `SushiToJsons` | Section blocks |
| `PageContent` | `SushiToJsons` | Page content JSON |
| `Attachment` | `SushiToJsons` | File attachments |
| `InformationSchemaTable` | `SushiToJson` | Table statistics |

## PHPDoc Pattern for Models

```php
/**
 * @method static array<int, array<string, mixed>> getSushiRows()
 * @method string getJsonFile()
 */
class Page extends BaseModelLang
{
    use SushiToJsons;
}
```

## Type Safety in bootSushiToJsons

```php
static::creating(function ($model): void {
    /** @var static $model */
    if (! $model instanceof Model) {
        throw new InvalidArgumentException('Model must be instance of Model');
    }
    
    // PHPStan Level 10: Type-safe max() call
    $maxId = $model->max('id');
    $newId = is_numeric($maxId) ? (int) $maxId + 1 : 1;
    
    $model->setAttribute('id', $newId);
});
```

## Common PHPStan Annotations

```php
/** @var array<string, mixed> $data */
/** @var array<int, array<string, mixed>> $rows */
/** @var string $file */
```

## Compliance

Last PHPStan Check: 2026-06-10
Status: ✅ All trait methods documented and typed
