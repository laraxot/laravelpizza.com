# Disabled/Stale Components in UI Module

**Status**: Documentation of unavailable dependencies  
**Date**: 2026-06-18

## Overview

UI module contains several components that depend on modules not installed in this project.
These are documented here for reference and future restoration if those modules are added.

## Disabled Components

### 1. InteractiveMap.php (Livewire Component)

**Location**: `app/Livewire/Components/Map/InteractiveMap.php.old`  
**Status**: ❌ Disabled (renamed to .old)  
**Reason**: Depends on `Modules\Geo\Services` which is not installed

#### Dependencies
```php
use Modules\Geo\Services\GeocodingService;
use Modules\Geo\Services\MapService;
```

#### Functionality
- Interactive map display with markers
- Geocoding (address search to coordinates)
- Map filters and statistics
- Data export (JSON, CSV, GeoJSON, KML)

#### Geo Module Services Required
- `MapService::getMarkers()` — Fetch markers for map display
- `MapService::getMapStats()` — Get map statistics
- `MapService::exportData()` — Export map data
- `GeocodingService::geocodeAddress()` — Convert address to coordinates
- `GeocodingService::getSuggestions()` — Autocomplete address suggestions

#### Restoration Steps
If `Modules/Geo` is installed:
1. Rename `InteractiveMap.php.old` → `InteractiveMap.php`
2. Verify Geo module exports the required services
3. Test geocoding and export functionality

### 2. Cms Action Dependency

**Location**: `app/View/Components/Render/Block.php`  
**Status**: ⚠️ Conditional (tries to load but handles missing module)  
**Dependency**: `Modules\Cms\Actions\ResolveLocalizedBlockDataAction`

#### Code
```php
if (class_exists('Modules\\Cms\\Actions\\ResolveLocalizedBlockDataAction')) {
    $view_params = app('Modules\\Cms\\Actions\\ResolveLocalizedBlockDataAction')->execute($view_params);
}
```

#### Functionality
- Resolves localized block data (if Cms module available)
- Falls back to unprocessed view params if module not installed

#### Cms Module Services Required
- `ResolveLocalizedBlockDataAction::execute()` — Process view parameters for localization

#### Status
- ✅ Gracefully handles missing module (uses class_exists() check)
- ⚠️ PHPStan still reports method.notFound (expected for optional dependency)
- Functionality not broken if module absent

---

## Guidelines for Optional Module Dependencies

When UI module needs features from optional modules:

1. **Use `class_exists()` checks** for conditional loading
   ```php
   if (class_exists('Modules\\SomeModule\\Class')) {
       $service = app('Modules\\SomeModule\\Class');
   }
   ```

2. **Handle missing gracefully** — No exceptions, fallback to defaults
   ```php
   $result = class_exists('...') ? $service->execute(...) : $default;
   ```

3. **Document in this file** — List the disabled component and reason

4. **Use .old extension** for completely disabled components
   - Rename if module becomes unavailable
   - Easy to restore: `mv Component.php.old Component.php`

5. **Accept PHPStan errors** for optional dependencies
   ```php
   /** @phpstan-ignore-next-line method.notFound */
   $result = $service->methodThatMayNotExist();
   ```

---

## Related Documentation

- [Modular Architecture Patterns](../../docs/laraxot/filament-integration.md)
- [Optional Module Pattern](../../docs/wiki/rules/optional-modules.md) (if exists)
- [PHPStan Configuration](../../laravel/phpstan.neon)

## Future Work

- [ ] Create `Modules/Geo` when geographic features are needed
- [ ] Merge CMS localization pattern into Xot base
- [ ] Document pattern for optional module dependencies in wiki

---

**Last Updated**: 2026-06-18  
**Updated By**: Development team  
**Review Frequency**: When modules are added/removed
