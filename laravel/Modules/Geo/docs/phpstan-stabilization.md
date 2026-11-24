---
title: "phpstan stabilization"
type: note
tags: [documentation]
created: 2026-09-26
updated: 2026-09-26
qmd: "phpstan stabilization"
issues: []
discussions: []
---

# PHPStan Stabilization - Geo Module

This document tracks the systematic effort to achieve and maintain PHPStan Level 10 compliance for the Geo module, focusing on type narrowing, static data management, and architectural integrity.

## Strategy: "Type Narrowing over Mixed"

To satisfy Level 10 requirements for dynamic geographic data, the module employs a strict type narrowing strategy:
- **Hardened Base Models**: `GeoJsonModel` uses explicit `array` type-hints and Collection generics to provide a safe foundation for descendants.
- **Explicit Casting**: Method returns from `Cache::remember` or `json_decode` are explicitly cast and documented via `@var` tags to avoid `mixed` leaks.
- **Collection Shapes**: PHPDocs specify detailed shapes for geographic data collections (e.g., `Collection<int, array{nome: string, codice: string, ...}>`).

## Corrections History

### 1. GeoJsonModel Foundational Refactor
- **Issue**: Cascading `mixed` errors in all `Sushi` and JSON models.
- **Action**: Narrowed `where()` and `loadData()` types. Added explicit variable assignment with `@var` tags before returning from cache.

### 2. Service Layer Optimization
- **Files**: `GeoDataService.php`, `GeoDataValidator.php`
- **Action**: Resolved `return mixed` from `Cache::remember` by using intermediate variables with precise PHPDocs. Fixed `variableNotFound` errors in PHPDocs.

### 3. Model Specialization
- **Files**: `ComuneJson.php`, `Locality.php`
- **Action**: Implemented deep shape definitions for geographic attributes. Standardized return types in `searchByName()` and `getPostalCodeOptions()`.

---
title: "phpstan stabilization"
type: note
tags: [documentation]
created: 2026-09-26
updated: 2026-09-26
qmd: "phpstan stabilization"
issues: []
discussions: []
*This document is maintained as a living record of the module's quality status.*

## Wave PHPStan Modules/Geo (zero)

### Cause radice riusabili

1. **`class.notFound` / `missingType.iterableValue` su `HasCoordinatePicker`**
   - Sintomo: senza `use`, PHPStan risolve `CoordinatePickerHelpers` sotto `Traits\` → `class.notFound`; con corpi Nominatim nel trait, L10 perde i generics `array` (× ogni consumer: MapPicker, GeopointPicker, …).
   - Fix: `use Modules\Geo\Filament\Forms\Components\CoordinatePickerHelpers`; delegare `searchAddress` / `reverseGeocode` / `normalize` / `extract` agli Helpers (fonte unica Nominatim). Wrapper `#[Exposed]` restano nel trait.
2. **`trait.unused` su doppioni morti** (`GeographicalScopes`, `HasPlaceTrait`, `SushiToJsons` Geo, `HasAddresses`)
   - Gia' decisi come morti (canon: `GeoTrait`, `HasAddress`, `Tenant\SushiToJsons`); ricomparsi da merge.
   - Fix: rimozione + `scopeOrderByDistance` assorbito in `GeoTrait`; probe `*PhpstanProbe*` eliminati (vietati).
3. **Mai** `@phpstan-ignore` / probe per silenziare `trait.unused`.

Verifica: `cd laravel && ./vendor/bin/phpstan analyse Modules/Geo --no-progress`

Verifica: `./vendor/bin/phpstan analyse Modules/Geo --no-progress` → **0 errori** (exit 0).
