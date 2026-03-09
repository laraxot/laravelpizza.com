## Objective
Apply Schema.org page-level typing across LaravelPizza pages:
- `WebPage` baseline
- `ProfilePage` for real profile pages
- correct subtypes (`CollectionPage`, `ItemPage`, `AboutPage`, `ContactPage`) by route context

## Why now
Entity-level schema (`Event`) exists in specific blocks, but page-level semantics are not centralized.

## Proposed implementation
1. Centralize page JSON-LD emission in shared metatags/layout layer.
2. Map route context -> page `@type` with DRY helper.
3. Keep `ProfilePage` strict: use only where page is truly a profile representation.
4. Add Pest tests for type mapping and JSON-LD output.

## Known constraint
Current User pages expose `/profile/edit` (authenticated edit page), not a clear public profile show route. We should avoid fake `ProfilePage` semantics where page purpose is account settings only.

## Tracking
- Issue: #550
