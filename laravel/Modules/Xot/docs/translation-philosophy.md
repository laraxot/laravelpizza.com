# Laraxot Translation Philosophy

## Overview

This document outlines the Laraxot philosophy for handling translations in a consistent, maintainable, and scalable way across all modules.

## Core Principles

### 1. **No Hardcoded Text**
- **NEVER** use hardcoded labels, placeholders, or tooltips in Filament components
- **ALWAYS** use translation keys that resolve through the `LangServiceProvider`
- Translation keys are automatically resolved based on field name and module context

### 2. **Translation File Structure**
```
Modules/{ModuleName}/lang/{locale}/
├── {resource}.php
├── {model}.php
└── {component}.php
```

### 3. **Navigation Translation Standards**

#### Navigation Structure
Every navigation section should have complete translation data:

```php
'navigation' => [
    'name' => 'Proper Italian Name',           // Singular name
    'plural' => 'Proper Italian Plural Name',  // Plural name
    'group' => [
        'name' => 'Module Group Name',         // Navigation group
        'description' => 'Group description',  // Optional description
    ],
    'label' => 'Navigation Label',             // Display label
    'sort' => 85,                              // Sort order
    'icon' => 'heroicon-o-chart-bar',          // Actual icon identifier
],
```

#### Critical Rule: No `.navigation` Placeholders
**🚨 CRITICAL**: The string `.navigation` anywhere in a translation value indicates an **incomplete/placeholder translation** that MUST be fixed immediately.

**How to fix `.navigation` translations:**
1. **Read other module translation files** to understand the correct pattern
2. **navigation.label** should be a proper translation, not a placeholder
3. **navigation.icon** should reference an actual icon identifier, not contain `.navigation`
4. **navigation.group.name** should describe the navigation group properly

### 4. **Multi-Language Support**
- All modules must support at minimum: **Italian (it)**, **English (en)**, **German (de)**
- Translation files should be complete across all supported languages
- Use consistent terminology across languages

## Implementation Guidelines

### Filament Components
```php
// ❌ WRONG - Hardcoded text
TextInput::make('name')
    ->label('Full Name')
    ->placeholder('Enter your name')
    ->tooltip('This is required');

// ✅ CORRECT - Uses translation files
TextInput::make('name');
// Translation keys auto-resolved from:
// - resources/lang/{locale}/{module}::{field}.label
// - resources/lang/{locale}/{module}::{field}.placeholder
// - resources/lang/{locale}/{module}::{field}.tooltip
```

### Navigation Examples

#### Good Example (Activity/stored_event.php)
```php
'navigation' => [
    'name' => 'Eventi Archiviati',
    'plural' => 'Eventi Archiviati',
    'group' => [
        'name' => 'Monitoraggio',
        'description' => 'Gestione degli eventi di sistema archiviati',
    ],
    'label' => 'Eventi Archiviati',
    'sort' => 62,
    'icon' => 'activity-stored-event-animated',
],
```

#### Bad Example (Contains `.navigation` placeholders)
```php
'navigation' => [
    'label' => 'question chart.navigation',  // BAD - placeholder
    'icon' => 'survey pdf.navigation',        // BAD - placeholder
],
```

## Quality Assurance

### Commands for Checking Translations
```bash
# Find all translations with '.navigation' placeholders
grep -r "\.navigation" Modules/*/lang/**/*.php

# Check for missing translation files
find Modules -name "*.php" -path "*/lang/it/*" | sed 's|.*/lang/it/||' | sort
find Modules -name "*.php" -path "*/lang/en/*" | sed 's|.*/lang/en/||' | sort
find Modules -name "*.php" -path "*/lang/de/*" | sed 's|.*/lang/de/||' | sort

# Verify navigation structure consistency
grep -A 10 "'navigation' =>" Modules/*/lang/it/*.php | grep -E "(label|group|icon|sort)"
```

### Automated Fixes
When you find `.navigation` placeholders:
1. **Study existing patterns** from well-structured modules (Activity, Geo, etc.)
2. **Use proper Italian translations** for labels and descriptions
3. **Reference actual icon identifiers** from Heroicons or custom icons
4. **Maintain consistent sort order** across the navigation

## Common Patterns

### Module Group Names
- **Geo**: Geographic data management
- **Survey**: Survey management and reporting
- **Monitoraggio**: System monitoring and tracking
- **LimeSurvey**: External system integration

### Icon Standards
- Use `heroicon-o-*` for standard icons
- Use module-specific custom icons when needed
- Never use placeholder strings as icon identifiers

## Maintenance

### Regular Audits
- Monthly audit of all translation files
- Check for `.navigation` placeholders
- Verify consistency across all languages
- Update documentation as patterns evolve

### New Module Setup
When creating a new module:
1. Create complete translation files for all supported languages
2. Follow established navigation patterns
3. Use proper translations from the start
4. Never commit placeholder translations

---

**Maintained by**: Xot Module (Core Laraxot Engine)
**Last Updated**: 2025-11-17