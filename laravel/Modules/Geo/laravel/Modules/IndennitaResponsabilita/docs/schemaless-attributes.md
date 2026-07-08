# Schemaless Attributes - IndennitaResponsabilita Module

This module utilizes `spatie/laravel-schemaless-attributes` for managing year-specific ratings.

## 🚨 CRITICAL ARCHITECTURE RULE

> [!CAUTION]
> **NEVER** use `wherePivot('anno', ...)` on the `ratings()` relationship.
> 
> The `anno` attribute is stored in the `extra_attributes` JSON column of the `Rating` model, **NOT** as a column in the pivot table. Using `wherePivot` will result in empty sets or errors.

## ✅ Correct Implementation Pattern

When you need to fetch ratings for a specific year (e.g., in a Filament Page):

```php
// 1. Let the model handle the sync/filtering logic via HasRatingsTrait
$ratings = $record->syncRatingsWhere(['anno' => $record->anno]);

// 2. Or query Rating model directly using withExtraAttributes
$ratingIds = Rating::withExtraAttributes('anno', 2024)->pluck('id');
$ratingsForYear = $record->ratings()->whereIn('rating_id', $ratingIds)->get();
```

## 🛠 Model Configuration

The `Rating` model must include the `@property` annotation for schemaless attributes to satisfy PHPStan Level 10:

```php
/**
 * @property int|null $anno
 * @property \Spatie\SchemalessAttributes\SchemalessAttributes|null $extra_attributes
 */
class Rating extends BaseRating { ... }
```

## 🔗 See Also
- [Rating Module Schemaless Docs](../../Rating/docs/schemaless-attributes.md)
- [Spatie Documentation](https://github.com/spatie/laravel-schemaless-attributes)
