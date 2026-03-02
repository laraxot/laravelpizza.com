# UI Module Documentation

## Overview

The UI module provides common Filament components, themes, and utilities used across all PTVX modules.

## Core Components

### GroupColumn
**Location:** `app/Filament/Tables/Columns/GroupColumn.php`  
**View:** `resources/views/filament/tables/columns/group.blade.php`  
**Documentation:** `docs/GroupColumn.md`

A flexible table column that groups multiple fields in a single cell with support for:
- Dot notation relationships (`valutatore.nome_diri`)
- Automatic label translation
- Empty value handling
- Search capabilities

### Theme System
**Location:** `resources/views/themes/`

The UI module provides centralized theming for:
- Table layouts
- Form components  
- Navigation elements
- Responsive design patterns

## Translation System

### Auto-Translation Keys
The module uses structured translation keys following the pattern:
```php
'ui::table.columns.{field_name}.label'
'ui::form.fields.{field_name}.label'
```

### Supported Languages
- `it` (Italian) - Primary language
- `en` (English) - Secondary language

## Utilities

### LangServiceProvider
Provides automatic translation resolution with fallback to auto-generated labels from field names.

### View Components
Reusable Blade components for:
- Form layouts
- Table displays
- Navigation elements
- Status indicators

## Development Guidelines

### Adding New Components
1. Extend base Filament classes when customizing behavior
2. Use translation keys instead of hardcoded strings
3. Follow the established naming conventions
4. Add comprehensive documentation

### Testing
- All components must have feature tests
- Test relationship access with dot notation
- Verify translation fallbacks work correctly
- Ensure graceful handling of null values

## Best Practices

1. **Always use GroupColumn** for multi-field displays
2. **Preload relationships** before using dot notation
3. **Add translation keys** for better UX
4. **Test with empty data** to ensure robustness
5. **Follow the established patterns** from existing components

## Integration with Other Modules

The UI module is designed to be dependency-free but provides:
- Base classes for extension (`XotBaseResource`, `XotBasePage`)
- Shared components for consistent UI
- Translation infrastructure
- Theme utilities

## Configuration

### Module Dependencies
- Laravel Framework
- Filament v5.0+
- PHP 8.2+

### Composer Scripts
No specific scripts - relies on the main project's tooling.

## File Structure

```
Modules/UI/
├── app/
│   └── Filament/
│       └── Tables/
│           └── Columns/
│               └── GroupColumn.php
├── resources/
│   ├── views/
│   │   ├── filament/
│   │   │   └── tables/
│   │   │       └── columns/
│   │   │           └── group.blade.php
│   │   └── themes/
│   └── lang/
│       ├── it/
│       └── en/
├── docs/
│   └── GroupColumn.md
└── tests/
    └── Feature/
        └── GroupColumnTest.php
```