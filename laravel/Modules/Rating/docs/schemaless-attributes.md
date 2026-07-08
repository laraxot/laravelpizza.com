# Spatie Laravel Schemaless Attributes - Usage in Rating Module

This document outlines the correct usage patterns for `spatie/laravel-schemaless-attributes` within the `Rating` module. For a comprehensive guide on schemaless attributes across the PTVX project, please refer to the [main project documentation](../../../docs/claude/schemaless-attributes.md).

## 🎯 Overview

The `Rating` module heavily utilizes schemaless attributes to store dynamic configurations for ratings, such as `anno` (year), and other specific settings that can vary.

## 🚨 CRITICAL ARCHITECTURE RULE

> [!CAUTION]
> **NEVER** use `wherePivot('anno', ...)` to filter ratings by year.
> 
> The `anno` attribute is a schemaless property of the `Rating` model itself (stored in `extra_attributes`), **NOT** a column in the `rating_morph` pivot table. Applying `wherePivot` on it will fail or yield incorrect results.

### Correct Relationship Filtering Pattern

To get ratings for a specific year linked to a model:

1.  **Filter Ratings first**: Find the `Rating` records for that year using `withExtraAttributes`.
2.  **Match via relationship**: Use the Eloquent relationship on your model and filter by the retrieved Rating IDs (usually via `syncRatingsWhere` or manual ID matching).

---

## ✅ Correct Usage Patterns

As detailed in the main guide, all three patterns for using `withExtraAttributes()` are valid and correct:

### Pattern 1: Array Parameter (RECOMMENDED)

Use this for single or multiple conditions when readability is a priority.

```php
// ✅ CORRECT - Pass an array of conditions
$ratings = Rating::withExtraAttributes(['anno' => 2025])->get();

// ✅ CORRECT - Multiple conditions
$ratings = Rating::withExtraAttributes([
    'anno' => 2025,
    'is_readonly' => false
])->get();
```

### Pattern 2: String + Value Parameters (ALTERNATIVE)

Suitable for simple queries with a single condition.

```php
// ✅ CORRECT - Pass key and value separately
$ratings = Rating::withExtraAttributes('anno', 2025)->get();
```

### Pattern 3: Direct JSON Query (FOR COMPLEX QUERIES)

Use for complex conditions, nested JSON paths, or when maximum SQL control is needed.

```php
// ✅ CORRECT - Direct query on JSON path
$ratings = Rating::where('extra_attributes->anno', 2025)->get();

// ✅ CORRECT - Complex JSON queries with operators
$ratings = Rating::where('extra_attributes->anno', '>=', 2024)
    ->where('extra_attributes->is_readonly', false)
    ->get();
```

## 🚨 PHPStan False Positive

PHPStan may incorrectly report errors on `withExtraAttributes()` due to its use of Laravel's magic scope methods and `debug_backtrace()`. Refer to the [main guide](../../../docs/claude/schemaless-attributes.md#fix-per-phpstan) for solutions, including PHPDoc annotations and configuration adjustments.

## 🔗 Related Documentation

*   [Main Schemaless Attributes Guide (PTVX)](../../../docs/claude/schemaless-attributes.md)
*   [Rating Module README](../README.md)
*   [HasRatingsTrait Best Practices (IndennitaResponsabilita Module)](../../IndennitaResponsabilita/docs/rating-schemaless-usage.md) - *Note: This document provides context specific to IndennitaResponsabilita's usage.*
