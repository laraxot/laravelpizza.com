<<<<<<< HEAD
---
title: "Rimando a filament_v4_upgrade.md"
description: "Documento unificato: il contenuto canonico vive in filament_v4_upgrade.md."
status: merged
tags: [merge, duplicato, case-only]
---

# Documento unificato

Questo file era un duplicato esatto che differiva solo per maiuscole/minuscole, in violazione della regola no-case-only-variations. Il contenuto canonico si trova in [filament_v4_upgrade.md](./filament_v4_upgrade.md).
=======
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
public static function getFormSchema(): array
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
>>>>>>> laraxot/dev
