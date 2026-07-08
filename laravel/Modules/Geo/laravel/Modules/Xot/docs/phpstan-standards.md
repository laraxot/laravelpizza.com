---
title: PHPStan Standards - Xot Module (Base Classes)
type: technical
tags: [phpstan, xot, base-model, information-schema]
created: 2026-06-10
updated: 2026-06-10
qmd: docs/wiki/phpstan-xot-module.md
---

# PHPStan Level 10 Standards - Xot Module

## InformationSchemaTable Model

Provides table row counting with static methods fully typed.

### Static Methods

```php
/**
 * @property int|null $table_rows
 * @property string $table_schema
 * @property string $table_name
 * @property string|null $model_class
 */
class InformationSchemaTable extends BaseModel
{
    /**
     * Update model count in information schema.
     * @param class-string<Model> $modelClass Fully qualified model class
     * @param int $total Record count
     * @throws InvalidArgumentException If model class invalid
     */
    public static function updateModelCount(string $modelClass, int $total): void
    
    /**
     * Get model count from information schema.
     * @param class-string<Model> $modelClass Fully qualified model class
     * @return int Record count
     */
    public static function getModelCount(string $modelClass): int
}
```

## Actions Using InformationSchemaTable

### CountAction

```php
/**
 * Counts records for a given model class.
 * @param class-string<Model> $modelClass The model class name
 * @return int Total count
 * @throws InvalidArgumentException If model class invalid
 */
public function execute(string $modelClass): int
{
    return InformationSchemaTable::getModelCount($modelClass);
}
```

### UpdateCountAction

```php
/**
 * Updates count for a model class.
 * @param class-string<Model> $modelClass The model class name
 * @param int $total New count value
 */
public function execute(string $modelClass, int $total): void
{
    InformationSchemaTable::updateModelCount($modelClass, $total);
}
```

## Generic Type Parameters

```php
// ✅ CORRECT - With generic type
/** @return Builder<static>|Page */
public static function query()

// ✅ CORRECT - Class string with constraint
/** @param class-string<Model> $modelClass */
public static function getModelCount(string $modelClass): int
```

## BaseModel Pattern

```php
/**
 * @property int|string $id
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property Carbon|null $deleted_at
 * @property string|null $created_by
 * @property string|null $updated_by
 * @property string|null $deleted_by
 */
abstract class BaseModel extends Model
{
    // Common functionality for all models
}
```

## Compliance

Last PHPStan Check: 2026-06-10
Status: ✅ All static methods typed with class-string parameters
