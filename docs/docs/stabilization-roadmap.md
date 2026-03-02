# Stabilization Roadmap - Geo Module

## Context & Philosophy
The `Geo` module is central to spatial data management within Laraxot. Current PHPStan Level 10 analysis reveals several "mixed" type issues and PHPDoc mismatches that threaten robust type safety.

## The Great Debate ("Litigata")
Internal debate regarding the handling of dynamic data (JSON/API) in `Geo` services:
- **Thesis (KISS)**: If a method returns data from a JSON file or API, `mixed` is acceptable because the structure can be unpredictable.
- **Antithesis (SOLID/Robust)**: Unpredictability is a failure of narrowing. Use union types, or at least `@var` tags for collections with specific shapes. Avoid `mixed` at all costs in Method signatures.
- **Winner**: Antithesis. We will use specific collection shapes (e.g., `Collection<int, array{name: string, code: string}>`) and explicit casts.

## Target Area 1: Actions & Services
Status: Multiple `return.type` and `varTag.variableNotFound` errors.

| File | Issue | Planned Action |
|------|-------|----------------|
| `Bing/GetAddressFromBingMapsAction.php` | `makeApiRequest` returns `mixed` | Cast to `array` and update signature. |
| `GeoDataService.php` | Multiple methods returning `mixed` | Narrow to `Collection<int, array<string, mixed>>` or specific shapes. |
| `UpdateCoordinatesResult.php` | `getErrorMessages` returns `array<mixed>` | Narrow to `array<int, string>`. |

## Target Area 2: Models (Sushi/JSON)
Status: `ComuneJson.php` and `Locality.php` have `mixed` return types.

| File | Issue | Planned Action |
|------|-------|----------------|
| `ComuneJson.php` | Methods like `byRegion` return `mixed` | Cast to `Collection` and use `@var` for the specific shape. |
| `Locality.php` | `varTag.variableNotFound` | Rename/fix the PHPDoc variable name match. |

## Verification Plan
1. `./vendor/bin/phpstan analyse Modules/Geo --level=10`
2. `./vendor/bin/phpinsights analyse Modules/Geo --disable-security-check`
3. Update `phpstan-corrections-january-2026.md` with results.

## Zen Note
"Geography is the art of precise location. In code, a mixed type is a location that is everywhere and nowhere. We choose 'somewhere' specifically."
