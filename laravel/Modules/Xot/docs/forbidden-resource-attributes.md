# Forbidden Attributes in XotBaseResource Classes

## Date: 2026-01-09

## Overview

XotBaseResource classes must not define the following attributes as they are handled by the LangServiceProvider translation system:

- `protected static ?string $recordTitleAttribute`
- `protected static string|\BackedEnum|null $navigationIcon`
- `protected static ?string $modelLabel`
- `protected static ?string $pluralModelLabel`

## Philosophy and Business Logic

The Laraxot architecture follows the principle of centralized translation management through the LangServiceProvider. Instead of hardcoding these values in the resource classes, the system automatically determines appropriate labels, navigation icons, and titles from translation files based on the resource class name and context.

### The Translation System Approach

- **Automatic Labeling**: The LangServiceProvider intercepts Filament component creation and applies translations automatically
- **Convention-based Keys**: Translation keys are generated based on the class structure (e.g., module, resource, field names)
- **Maintainability**: Centralized translations are easier to update and maintain across different languages
- **DRY Principle**: Avoid duplication between hard-coded values and translation files

### Why These Attributes Are Forbidden

1. **`recordTitleAttribute`**: Should be determined by the translation system for consistency
2. **`navigationIcon`**: Should be resolved through translation files to support dynamic icons
3. **`modelLabel`**: Should come from translation files for proper localization
4. **`pluralModelLabel`**: Should be translated and managed centrally

## Implementation Approach

**Winner: Complete Removal + Translation Support**

Remove all forbidden attributes from XotBaseResource classes and ensure proper translation files exist. This approach:

- ✅ Follows project architecture rules exactly
- ✅ Enables automatic translation system
- ✅ Maintains DRY principle by using translation files
- ✅ Ensures consistency across the application

## Consequences of Violation

- Violates Laraxot architectural patterns
- Creates maintenance overhead with duplicated content
- Bypasses the automatic translation system
- Reduces maintainability and localization capabilities

## Resolution Strategy

1. Identify all XotBaseResource classes with forbidden attributes
2. Remove the attributes from the classes
3. Ensure proper translation files exist or are created
4. Verify that the LangServiceProvider can properly resolve the labels