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
*This document is maintained as a living record of the module's quality status.*
