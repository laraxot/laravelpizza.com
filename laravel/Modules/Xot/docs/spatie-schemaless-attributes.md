# spatie/laravel-schemaless-attributes — Central Reference

**Package**: [`spatie/laravel-schemaless-attributes`](https://github.com/spatie/laravel-schemaless-attributes)
**PHPStan**: Level 10 ✅

---

## Overview

Store arbitrary JSON data in a single database column on Eloquent models. Use for **metadata, user preferences, external API responses**. Avoid for core business logic data.

---

## Setup

### 1. Migration

```php
// In XotBaseMigration (Blueprint macro)
$table->schemalessAttributes('extra_attributes');
```

### 2. Model Cast

```php
use Spatie\SchemalessAttributes\Casts\SchemalessAttributes;

/** @return array<string, string> */
protected function casts(): array
{
    return [
        'extra_attributes' => SchemalessAttributes::class,
    ];
}
```

> [!WARNING]
> Import from `Spatie\SchemalessAttributes\Casts\SchemalessAttributes`.
> NOT `Spatie\SchemalessAttributes\SchemalessAttributes` (that is the value object class).

### 3. PHPDoc

```php
/**
 * @property \Spatie\SchemalessAttributes\SchemalessAttributes $extra_attributes
 * @method static Builder|self withExtraAttributes(array|string $attributes = [], mixed $value = null)
 */
```

---

## CRUD Operations

```php
// SET — always call save() after
$model->extra_attributes->set('key', 'value');
$model->extra_attributes->set(['key1' => 'v1', 'key2' => 'v2']);
$model->save();

// GET — with optional default
$value = $model->extra_attributes->get('key', 'default');

// GET nested (dot notation)
$nested = $model->extra_attributes->get('user.settings.theme', 'light');

// FORGET
$model->extra_attributes->forget('key');
$model->save();

// ALL
$all = $model->extra_attributes->all();
```

---

## Query Scopes

### Custom Scope Pattern (Recommended)

```php
public function scopeWithExtraAttributes(
    Builder $query,
    array|string $attributes = [],
    mixed $value = null
): Builder {
    if (is_string($attributes) && $value !== null) {
        return $query->where("extra_attributes->{$attributes}", $value);
    }
    if (is_array($attributes)) {
        foreach ($attributes as $key => $val) {
            $query = $query->where("extra_attributes->{$key}", $val);
        }
    }
    return $query;
}
```

### Usage

```php
// Single attribute
Model::withExtraAttributes('anno', 2024)->get();

// Multiple attributes (AND)
Model::withExtraAttributes(['anno' => 2024, 'type' => 'review'])->get();

// Direct JSON where (alternative)
Model::where('extra_attributes->anno', 2024)->get();
```

---

## PHPStan Level 10 Compliance

### Type-Safe Access

```php
// ✅ Safe access with type checking
$value = $model->extra_attributes->get('key');
if (is_string($value)) {
    // use $value as string
}

// ✅ With default value
/** @var int $anno */
$anno = $model->extra_attributes->get('anno', (int) date('Y'));

// ❌ Unsafe — PHPStan mixed type
$value = $model->extra_attributes->key; // Returns mixed
```

### HasExtraTrait Pattern (Xot)

```php
// Modules\Xot\Models\Traits\HasExtraTrait
// Uses MorphOne relationship to Extra model
// Provides getExtra(string $name) and setExtra(string $name, mixed $value)
// Type-safe: returns array|bool|float|int|string|null
```

---

## Common Errors

| # | Error | Fix |
|---|-------|-----|
| 1 | `protected $casts = [...]` | Use `protected function casts(): array` (deprecated property) |
| 2 | `use Spatie\SchemalessAttributes\SchemalessAttributes` in cast | Use `...\Casts\SchemalessAttributes` |
| 3 | `property_exists($this, 'extra_attributes')` | Use `isset()` or `getAttribute()` — casts are not real properties |
| 4 | Scope ignoring parameters | Use `where("extra_attributes->{$key}", $value)`, not `modelScope()` |
| 5 | Forgetting `$model->save()` after set | Schemaless attributes are not auto-saved |
| 6 | Missing `@property` PHPDoc | Add `@property \Spatie\SchemalessAttributes\SchemalessAttributes $extra_attributes` |

---

## Modules Using SchemalessAttributes

| Module | Model | Column |
|--------|-------|--------|
| Rating | `BaseRating`, `Rating` | `extra_attributes` |
| IndennitaResponsabilita | `Rating` (extends BaseRating) | `extra_attributes` |
| Xot | `HasExtraTrait`, `BaseExtra`, `Extra` | `extra_attributes` |
| User | `BaseProfile`, `Profile`, `Extra` | `extra_attributes` |
| Ptv | `BaseScheda`, `Profile` | `extra_attributes` |
| Gdpr | `Profile` | `extra_attributes` |
| Activity | `StoredEvent` | `extra_attributes` |

---

## Performance Tips

```php
// ✅ Batch update (single save)
$model->extra_attributes->set([
    'key1' => 'value1',
    'key2' => 'value2',
    'key3' => 'value3',
]);
$model->save();

// ❌ Multiple saves
$model->extra_attributes->set('key1', 'value1'); $model->save();
$model->extra_attributes->set('key2', 'value2'); $model->save();
```

> [!TIP]
> For frequently queried JSON keys, consider adding a MySQL generated column index:
> ```sql
> ALTER TABLE ratings ADD INDEX idx_anno ((CAST(extra_attributes->>'$.anno' AS UNSIGNED)));
> ```

---

## References

- [GitHub: spatie/laravel-schemaless-attributes](https://github.com/spatie/laravel-schemaless-attributes)
- [Laravel News: Schemaless Attributes](https://laravel-news.com/laravel-schemaless-attributes-package)
- [Laracasts: Dynamic Columns](https://laracasts.com/discuss/channels/eloquent/dynamic-columns-with-schemaless-attributes)
- [Rating Module Docs](../../Rating/docs/schemaless-attributes.md)
- [IndennitaResponsabilita Docs](../../IndennitaResponsabilita/docs/rating-schemaless-usage.md)
- [UI Themes Schemaless Guide](../../UI/docs/themes/schemaless-attributes-guide.md)
