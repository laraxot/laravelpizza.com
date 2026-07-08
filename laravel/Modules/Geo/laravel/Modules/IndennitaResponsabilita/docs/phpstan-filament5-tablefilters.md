# PHPStan Filament 5 - tableFilters Property

**Status**: ⏳ Pending Analysis  
**Date**: 2026-06-18  
**Issue Type**: `property.notFound`  
**Severity**: Low (functionality works, cosmetic PHPStan error)

## Problem

File uses `$this->tableFilters` to access Filament table filter state:
- `IndennitaResponsabilitasTable.php:39` — Pass filter state to URL builder
- `IndennitaResponsabilitasTable.php:127` — Access filter state in bulk actions

### Code Patterns
```php
// Line 39 — Header Actions
$filtersForUrl = $this->tableFilters;
->url(fn () => IndennitaResponsabilitaResource::getUrl('send-mail', $filtersForUrl ?? []))

// Line 127 — Bulk Actions
$tableFilters = $this->tableFilters ?? [];
$annoValutatoreFilter = Arr::get($tableFilters, 'anno/valutatore', []);
```

### Root Cause
- `$this->tableFilters` is a **Livewire public property**, not declared in PHP class
- PHPStan cannot infer its type statically
- Property is provided by Filament base class inheritance chain

## Solution

### Recommended: Add PHPDoc Declaration

Before first usage, add type hint:
```php
/**
 * Filament table filters state
 * @var array<string, mixed>|null $tableFilters
 */
```

This tells PHPStan the property exists and its expected type.

### Reference Implementation

Pattern already used in Xot module (ExportXlsAction, ExportPdfAction):
```php
// Xot/app/Filament/Actions/Header/ExportXlsAction.php
collect($livewire->tableFilters)->flatten()->implode('-')
```

Xot accesses same property without issues → indicates stable API.

## Why This Matters

1. **Filters are used for**:
   - Building URLs with filter state preserved (line 44)
   - Determining which template to use in bulk actions (line 135)
   - Passing context to SendSchedaBulkAction

2. **User expectation**: When clicking "Send Mail" with filters applied, email template should reflect current filter (e.g., specific year)

3. **Code correctness**: `Arr::get()` properly guards against missing keys, implementation is safe

## Implementation Note

The `tableFilters` property is part of Filament's ListRecords Livewire component, which is the base for table listing pages. It contains the currently applied filter values as an associative array.

## Filament 5 Context

Filament 5 restructured property visibility and type declarations. This property exists and works at runtime but lacks formal type declaration, causing PHPStan static analysis to report it as undefined.

This is a known quirk of Filament 5 integration with Livewire components.

## Impact

- ✅ **Functionality**: No impact (works at runtime)
- ⚠️ **Type checking**: PHPStan reports undefined property
- ✅ **Approach**: Add PHPDoc type hint for clarity

---

## Related

- See: IndennitaCondizioniLavoro/docs/phpstan-filament5-tablefilters.md (same issue)
- Pattern: Xot module ExportXlsAction.php
- Issue: Need systematic way to handle Livewire property access in Filament resources
