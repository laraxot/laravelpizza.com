# HeaderNavBlock - Filament Builder Documentation

## Overview

`HeaderNavBlock` is the Filament Builder block that allows administrators to manage header navigation items via the admin panel. It manages the `header.json` file through the `SushiToJsons` trait.

## Architecture

```
Filament Admin Panel
    ↓ (Form submission)
HeaderNavBlock::getBlockSchema()
    ↓ (saves to JSON via SushiToJsons)
laravel/config/local/fixcity/database/content/sections/header.json
    ↓ (read by)
Section.php → v1.blade.php → nav-primary.blade.php
    ↓ (rendered in)
<x-section slug="header" />
```

## Block Schema Fields

| Field | Type | Description |
|-------|------|-------------|
| `label` | TextInput | Display name (e.g., "Amministrazione") |
| `url` | TextInput | Link URL (e.g., "/it/amministrazione") |
| `data_element` | TextInput | HTML data-element attribute for tracking |
| `nav_group` | Select | "primary" or "secondary" |
| `type` | Select | "link" or "dropdown" |
| `order` | TextInput (numeric) | Sort order (10, 20, 30...) |
| `enabled` | Toggle | Enable/disable the item |
| `visible` | Toggle | Show/hide in navigation |
| `active_patterns` | Repeater | URL patterns for active state detection |
| `children` | Repeater | Sub-items for dropdown type |

## How It Works

### 1. Reading Data
```php
// Section.php line 53
$this->blocks = SectionModel::getBlocksBySlug($this->slug);
```

`SectionModel` uses `SushiToJsons` trait which reads from `header.json`.

### 2. Writing Data
When admin saves the block in Filament panel:
1. `HeaderNavBlock::getBlockSchema()` defines the form
2. Data is saved to `header.json` via `SushiToJsons`
3. Next page load reads updated JSON automatically

### 3. Rendering
```php
// v1.blade.php lines 47-58
$headerNavJsonPath = \Modules\Tenant\Services\TenantService::filePath('database/content/sections/header.json');
if (is_string($headerNavJsonPath) && file_exists($headerNavJsonPath)) {
    $headerNavConfig = \Illuminate\Support\Facades\File::json($headerNavJsonPath);
}
```

## Filament Builder Pattern

Based on https://filamentphp.com/docs/5.x/forms/builder#builder

The `HeaderNavBlock` uses:
- **Repeater** for `active_patterns` (multiple URL patterns per item)
- **Repeater** for `children` (nested dropdown items)
- **Toggle** for boolean fields (`enabled`, `visible`)
- **Select** for enum-like fields (`nav_group`, `type`)

## PHPStan Results

```bash
php -d memory_limit=512M vendor/bin/phpstan analyse Modules/Cms/app/Filament/Blocks/HeaderNavBlock.php --level=5
# Result: [OK] No errors ✓
```

## Related Files

- **Block**: `laravel/Modules/Cms/app/Filament/Blocks/HeaderNavBlock.php`
- **Component**: `laravel/Modules/Cms/app/View/Components/Section.php`
- **View**: `laravel/Themes/Sixteen/resources/views/components/sections/header/v1.blade.php`
- **JSON Config**: `laravel/config/local/fixcity/database/content/sections/header.json`
- **Partials**: 
  - `laravel/Themes/Sixteen/resources/views/components/sections/header/partials/nav-primary.blade.php`
  - `laravel/Themes/Sixteen/resources/views/components/sections/header/partials/nav-secondary.blade.php`

## Zen Philosophy

> "One JSON to rule them all, One JSON to find them,
> One JSON to bring them all, and in the darkness bind them."

The header.json is the **Single Source of Truth**. No hardcoded links. No duplication. Filament Builder is the interface. Blade is the presentation layer. Clean separation of concerns.

## Next Steps

1. ✅ Dynamic navigation from header.json (already working)
2. ✅ PHPStan validation passed
3. ⏳ Test with Pest (visual regression)
4. ⏳ Document in module docs (`laravel/Modules/Cms/docs/wiki/`)
5. ⏳ Ingest into QMD (when database issue resolved)
