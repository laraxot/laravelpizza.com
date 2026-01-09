# AddressColumn Implementation Plan

**Date**: 2025-12-12
**Module**: Geo
**Status**: 📋 **PLANNING**

## Overview

This document outlines the implementation of AddressColumn as a centralized helper for address-related database columns, following the DRY + KISS principles and the Laraxot migration philosophy.

## Current State Analysis

### 1. AddressItemEnum Structure
The `AddressItemEnum` defines all address-related fields but is **missing the critical `columns()` method** that is referenced 489 times throughout the codebase.

### 2. Existing Patterns

#### Modern Pattern (Preferred)
```php
// In CREATE block:
AddressItemEnum::columns($table, null, true);

// In UPDATE block:
AddressItemEnum::columns($table, $this, true);
```

#### Legacy Pattern (To be replaced)
```php
$address_components = Place::$address_components;
foreach ($address_components as $el) {
    if (! $this->hasColumn($el)) {
        $table->string($el)->nullable();
    }
}
```

### 3. Issues Identified

1. **Missing Implementation**: `AddressItemEnum::columns()` method not implemented
2. **DRY Violations**: 208+ repetitive address column definitions
3. **Inconsistent Patterns**: Mix of modern and legacy approaches
4. **Code Duplication**: Same column definitions repeated across modules

## Implementation Plan

### Phase 1: Implement AddressItemEnum::columns()

Following the ContactTypeEnum pattern, implement:

```php
public static function columns(Blueprint $table, ?XotBaseMigration $migration = null, bool $withLegacy = false): void
{
    // Standard AddressItemEnum fields
    foreach (self::getColumnDefinitions() as $name => $definition) {
        if ($migration === null || !$migration->hasColumn($name)) {
            $definition($table);
        }
    }

    // Legacy compatibility fields
    if ($withLegacy) {
        self::addLegacyColumns($table, $migration);
    }
}
```

### Phase 2: Create AddressColumn Trait

Create a centralized trait for common address operations:

```php
trait AddressColumn
{
    public static function addAddressColumns(Blueprint $table, ?XotBaseMigration $migration = null): void
    {
        AddressItemEnum::columns($table, $migration);
    }

    public static function addFullAddressColumns(Blueprint $table, ?XotBaseMigration $migration = null): void
    {
        AddressItemEnum::columns($table, $migration, true);
    }
}
```

### Phase 3: Standardize Migrations

Update all migrations to use the centralized approach:

```php
// Before
$table->string('route')->nullable();
$table->string('locality')->nullable();
// ... 15+ more lines

// After
AddressItemEnum::columns($table, $this);
```

## Column Definitions

### Core Address Fields
- `route` - Street name (Via/Piazza)
- `street_number` - Street number
- `locality` - City/Comune
- `administrative_area_level_3` - Comune
- `administrative_area_level_2` - Provincia
- `administrative_area_level_1` - Regione
- `country` - Country/Stato
- `postal_code` - CAP

### Geocoding Fields
- `latitude` - Latitude coordinate
- `longitude` - Longitude coordinate
- `formatted_address` - Complete formatted address
- `place_id` - Google Place ID

### Contact Fields
- `phone` - Phone number
- `name` - Location name
- `description` - Address description

### Legacy Fields (withLegacy=true)
- `address` - Full address string (legacy)
- `city` - City name (legacy)
- `province` - Province (legacy)
- `region` - Region (legacy)

## Benefits

1. **DRY Compliance**: Single source of truth for address columns
2. **KISS Principle**: Simple, reusable method
3. **Type Safety**: Enum-based column definitions
4. **Consistency**: Standardized across all modules
5. **Maintainability**: Changes in one place affect all migrations

## Migration Strategy

1. **Implement AddressItemEnum::columns()** method
2. **Create AddressColumn trait** for convenience
3. **Update TechPlanner module** migrations first
4. **Progressively update other modules**
5. **Test with PHPStan level 10**

## Testing Plan

1. **Unit Tests**: Test column definitions
2. **Migration Tests**: Verify CREATE/UPDATE blocks
3. **Integration Tests**: Test with real data
4. **PHPStan Level 10**: Ensure type safety

## Next Steps

1. Implement `AddressItemEnum::columns()` method
2. Create `AddressColumn` trait
3. Update documentation in other modules
4. Begin migration updates
