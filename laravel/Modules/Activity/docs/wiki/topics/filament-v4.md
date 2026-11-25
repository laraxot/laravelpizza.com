---
title: "Topic filament-v4"
type: digest
status: active
qmd: "digest ceiling 100 filament-v4"
---

# Topic filament-v4

Sintesi automatica di 4 documenti (chiave `filament-v4`).

## Filament v4 Icon Size Attribute Fix

_Fonte: `filament/archive/filament-v4-icon-size-fix.md`_

# Filament v4 Icon Size Attribute Fix

## Issue Description
After upgrading to Filament v4, the application was throwing `TypeError` when using `x-filament::icon` components with string `size` attributes.

**Error Message:**
```
TypeError - Internal Server Error
Filament\Support\generate_icon_html(): Argument #4 ($size) must be of type ?Filament\Support\Enums\IconSize, string given
```

## Root Cause
In Filament v4, the `size` attribute for icons changed from accepting string values to requiring the `IconSize` enum type.

**Before (Filament v3):**
```blade
<x-filament::icon icon="fas-futbol" size="24" />
<x-filament::icon :icon="$icon" :size="24" />
```

**After (Filament v4):**
```blade
<x-filament::icon icon="fas-futbol" class="w-6 h-6" />
<x-filament::icon :icon="$icon" class="size-6" />
```

## Files Fixed

1. **Modules/UI/resources/views/filament/widgets/stat-with-icon.blade.php**
   - Removed `size="24"` from icon component

## Filament v4 Upgrade Documentation

_Fonte: `filament/archive/filament-v4-upgrade.md`_

# Filament v4 Upgrade Documentation

This archived copy points to the maintained module documentation: [filament-v4-upgrade.md](../filament-v4-upgrade.md).

## Contenuto fuso da `filament-v4-upgrade.md`

# Documento unificato

Questo file era un duplicato esatto che differiva solo per maiuscole/minuscole, in violazione della regola no-case-only-variations. Il contenuto canonico si trova in [filament_v4_upgrade.md](filament-v4-upgrade.md).
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

## Filament v4 Icon Size Attribute Fix

_Fonte: `filament/filament-v4-icon-size-fix.md`_

# Filament v4 Icon Size Attribute Fix

## Issue Description
After upgrading to Filament v4, the application was throwing `TypeError` when using `x-filament::icon` components with string `size` attributes.

**Error Message:**
```
TypeError - Internal Server Error
Filament\Support\generate_icon_html(): Argument #4 ($size) must be of type ?Filament\Support\Enums\IconSize, string given
```

## Root Cause
In Filament v4, the `size` attribute for icons changed from accepting string values to requiring the `IconSize` enum type.

**Before (Filament v3):**
```blade
<x-filament::icon icon="fas-futbol" size="24" />
<x-filament::icon :icon="$icon" :size="24" />
```

**After (Filament v4):**
```blade
<x-filament::icon icon="fas-futbol" class="w-6 h-6" />
<x-filament::icon :icon="$icon" class="size-6" />
```

## Files Fixed

1. **Modules/UI/resources/views/filament/widgets/stat-with-icon.blade.php**

## Filament v4 Upgrade Documentation

_Fonte: `filament/filament-v4-upgrade.md`_

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
