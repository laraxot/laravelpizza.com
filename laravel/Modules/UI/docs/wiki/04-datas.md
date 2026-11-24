---
title: "04 datas"
type: note
tags: [documentation]
created: 2026-09-26
updated: 2026-09-26
qmd: "04 datas"
issues: []
discussions: []
---

# Datas in UI Module

All data objects in the UI module use the `Spatie\LaravelData\Data` contract for type safety and serialization.

## Available Data Classes

Located in `UI/app/Datas/`:

- `UserData` - User data representation with permissions and settings
- `SliderData` - Slider component data
- `SliderDataCollection` - Collection of slider items

## Usage Examples

### User Data
```php
use Modules\UI\app\Datas\UserData;

$user = UserData::from([
    'id' => 1,
    'name' => 'John Doe',
    'email' => 'john@example.com',
    'permissions' => ['read', 'write'],
    'settings' => ['theme' => 'dark'],
]);
```

### Slider Data
```php
use Modules\UI\app\Datas\SliderData;

$slider = SliderData::from([
    'title' => 'Featured Products',
    'items' => $items,
]);
```

## Migration Notes

Previously located in `app/Data/` folder, all data classes were migrated to `app/Datas/` following the Laraxot standard:
- All classes extend `Spatie\LaravelData\Data`
- Naming convention: `*Data.php`
- Automatic serialization/deserialization support
- Full PHPStan level max compliance