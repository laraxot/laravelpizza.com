<<<<<<< .merge_file_Mwe2PQ
<<<<<<< HEAD
# Filament v4 Upgrade Documentation

## Overview
This document outlines the key changes and upgrades implemented for Filament v4 in the Activity module.

## Key Changes Made

### 1. Schema-based Resource Definitions
- **Updated**: `ActivityResource` now uses `getFormSchema()` method
- **New Pattern**: Returns array of `Filament\Schemas\Components\Component`
- **Migration**: Moved from v3 `form(Form $form)` to v4 schema approach

```php
// v4 Approach (Current)
public function getFormSchema(): array
{
    return [
        'log_name' => TextInput::make('log_name')->required()->maxLength(255),
        'description' => TextInput::make('description')->required()->maxLength(255),
        // ...
    ];
}
```

### 2. Table Method Updates
- **Updated**: Table actions now use `recordActions()` instead of `actions()`
- **Updated**: Bulk actions now use `toolbarActions()`
- **Base Class**: `XotBaseListRecords` properly implements v4 table patterns

### 3. Base Resource Updates
- **XotBaseResource**: Updated to use `Filament\Schemas\Schema`
- **Form Method**: Uses `$schema->components(static::getFormSchema())`
- **Component Types**: Properly typed with `Filament\Schemas\Components\Component`

## Verification Steps Completed

1. ✅ Composer dependencies updated to Filament 4.0.18
2. ✅ Resource classes using new schema patterns
3. ✅ Table methods updated to v4 API
4. ✅ Base classes properly configured

## Next Steps

- Run PHPStan analysis to ensure type safety
- Test all Filament resources in browser
- Verify all module integrations work correctly

## References

- [Filament v4 Upgrade Guide](https://filamentphp.com/docs/4.x/upgrade-guide)
- [Filament v4 Schema Documentation](https://filamentphp.com/docs/4.x/forms/fields)
=======
<<<<<<< HEAD
<<<<<<< HEAD
# Filament v4 Upgrade Documentation
=======
---
title: "Filament v4 Upgrade Documentation"
type: note
status: draft
updated: 2026-10-08
tags: [docs, activity, filament]
qmd: "filament v4 upgrade documentation activity"
---
# Filament v4 Upgrade Documentation

> **Storico** — migrazione verso Filament v4 (2025). **Stack attuale del progetto: Filament v5.** Vedi [filament-version.md](../filament-version.md) e [filament-version-policy.md](../../../../../docs/wiki/memories/filament-version-policy.md).
>>>>>>> .merge_file_BjyKjK

## Overview
This document outlines the key changes and upgrades implemented for Filament v4 in the Activity module.

## Key Changes Made

### 1. Schema-based Resource Definitions
- **Updated**: `ActivityResource` now uses `getFormSchema()` method
- **New Pattern**: Returns array of `Filament\Schemas\Components\Component`
- **Migration**: Moved from v3 `form(Form $form)` to v4 schema approach

```php
// v4 Approach (Current)
public function getFormSchema(): array
{
    return [
        'log_name' => TextInput::make('log_name')->required()->maxLength(255),
        'description' => TextInput::make('description')->required()->maxLength(255),
        // ...
    ];
}
```

### 2. Table Method Updates
- **Updated**: Table actions now use `recordActions()` instead of `actions()`
- **Updated**: Bulk actions now use `toolbarActions()`
- **Base Class**: `XotBaseListRecords` properly implements v4 table patterns

### 3. Base Resource Updates
- **XotBaseResource**: Updated to use `Filament\Schemas\Schema`
- **Form Method**: Uses `$schema->components(static::getFormSchema())`
- **Component Types**: Properly typed with `Filament\Schemas\Components\Component`

## Verification Steps Completed

1. ✅ Composer dependencies updated to Filament 4.0.18
2. ✅ Resource classes using new schema patterns
3. ✅ Table methods updated to v4 API
4. ✅ Base classes properly configured

## Next Steps

- Run PHPStan analysis to ensure type safety
- Test all Filament resources in browser
- Verify all module integrations work correctly

## References

- [Filament v4 Upgrade Guide](https://filamentphp.com/docs/4.x/upgrade-guide)
- [Filament v4 Schema Documentation](https://filamentphp.com/docs/4.x/forms/fields)
<<<<<<< .merge_file_Mwe2PQ
=======
=======
>>>>>>> 35d8cf69 (Initial commit)
---
module: theme
topic: filament-v4-upgrade
canonical: ../../../../Themes/docs/shared-components/FILAMENT_V4_UPGRADE.md
---

See canonical documentation: ../../../../Themes/docs/shared-components/FILAMENT_V4_UPGRADE.md
<<<<<<< HEAD
>>>>>>> 0a02158a (.)
=======
>>>>>>> 35d8cf69 (Initial commit)
>>>>>>> laraxot/dev
=======
>>>>>>> .merge_file_BjyKjK
