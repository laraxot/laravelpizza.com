---
title: "04 datas"
type: note
tags: [documentation]
created: 2026-09-26
updated: 2026-09-26
qmd: "04 datas"
issues: []
discussions: []
status: active
---

# Datas in Seo Module

All data objects in the Seo module use the `Spatie\LaravelData\Data` contract for type safety and serialization.

## Available Data Classes

Located in `Seo/app/Datas/`:

- `MetatagData` - Meta tag data structure for SEO optimization
- `SocialShareData` - Social sharing metadata (Open Graph, Twitter Cards)

## Usage Examples

### Creating Meta Tag Data
```php
use Modules\Seo\app\Datas\MetatagData;

$metatag = MetatagData::from([
    'title' => 'Page Title',
    'description' => 'Page Description',
    'keywords' => ['keyword1', 'keyword2'],
]);
```

### Social Sharing Data
```php
use Modules\Seo\app\Datas\SocialShareData;

$sharing = SocialShareData::from([
    'title' => 'Shared Title',
    'description' => 'Shared Description',
    'image' => 'https://example.com/image.jpg',
]);
```

## Migration Notes

Previously located in `app/Data/` folder, all data classes were migrated to `app/Datas/` following the Laraxot standard:
- All classes extend `Spatie\LaravelData\Data`
- Naming convention: `*Data.php`
- Automatic serialization/deserialization support
- Full PHPStan level max compliance