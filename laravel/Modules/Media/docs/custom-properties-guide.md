# Custom Properties — spatie/laravel-medialibrary

**Package**: [`spatie/laravel-medialibrary`](https://spatie.be/docs/laravel-medialibrary/v11/advanced-usage/using-custom-properties)
**Relation**: Conceptually similar to `spatie/laravel-schemaless-attributes` — both store JSON metadata

---

## Overview

Custom properties let you attach arbitrary metadata to media items as JSON. They are stored in the `custom_properties` column of the `media` table.

---

## Setting Custom Properties

```php
// During upload
$model->addMedia($pathToFile)
    ->withCustomProperties([
        'primary_color' => 'red',
        'category' => 'featured',
        'metadata' => ['width' => 1920, 'height' => 1080],
    ])
    ->toMediaCollection('images');

// After upload
$mediaItem = $model->getFirstMedia('images');
$mediaItem->setCustomProperty('primary_color', 'blue');
$mediaItem->save();

// Forget
$mediaItem->forgetCustomProperty('category');
$mediaItem->save();
```

---

## Getting Custom Properties

```php
// Single property
$color = $mediaItem->getCustomProperty('primary_color');

// With default
$category = $mediaItem->getCustomProperty('category', 'uncategorized');

// Dot notation for nested values
$width = $mediaItem->getCustomProperty('metadata.width');

// Check existence
if ($mediaItem->hasCustomProperty('primary_color')) {
    // ...
}
```

---

## Filtering by Custom Properties

```php
// Filter media collection by custom properties
$filteredMedia = $model->getMedia('images', ['primary_color' => 'red']);

// Filter with callback
$filteredMedia = $model->getMedia('images', function ($media) {
    return $media->getCustomProperty('category') === 'featured';
});
```

---

## ZIP Folder Support

When exporting media as ZIP, custom properties control the folder structure:

```php
$model->addMedia($pathToFile)
    ->withCustomProperties(['zip_folder' => 'documents/2024'])
    ->toMediaCollection('downloads');
```

---

## PHPStan Compliance

```php
// ✅ Type-safe access
/** @var string|null $color */
$color = $mediaItem->getCustomProperty('primary_color');

// ✅ With assertion
$color = $mediaItem->getCustomProperty('primary_color');
assert(is_string($color));
```

---

## Comparison with SchemalessAttributes

| Feature | `custom_properties` (Media) | `extra_attributes` (Schemaless) |
|---------|---------------------------|-------------------------------|
| Storage | `media` table JSON column | Model's own JSON column |
| Scope | Per-media-item | Per-model-record |
| Package | `laravel-medialibrary` | `laravel-schemaless-attributes` |
| Query | `getMedia()` filter | `where('extra_attributes->key', v)` |
| Dot notation | ✅ | ✅ |
| Auto-save | ❌ (call `save()`) | ❌ (call `save()`) |

---

## References

- [Official Docs: Custom Properties](https://spatie.be/docs/laravel-medialibrary/v11/advanced-usage/using-custom-properties)
- [Xot Schemaless Guide](../../xot/docs/spatie-schemaless-attributes.md)
