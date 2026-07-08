# Filament 5 Migration Guide for Lang Module

## Overview
This document describes the migration of the Lang module from Filament 4 with `lara-zeus/spatie-translatable` to Filament 5 with built-in translation support.

## Key Changes

### 1. Updated LangBase Classes
- **LangBasePanelProvider**: Replaced `SpatieTranslatablePlugin` with Filament 5's native `TranslatablePanel` trait
- **LangBaseResource**: Updated to use `Filament\Resources\Concerns\Translatable`
- **LangBaseListRecords**: Updated to use `Filament\Resources\Pages\ListRecords\Concerns\Translatable`
- **LangBaseCreateRecord**: Updated to use `Filament\Resources\Pages\CreateRecord\Concerns\Translatable`
- **LangBaseEditRecord**: Updated to use `Filament\Resources\Pages\EditRecord\Concerns\Translatable`
- **LangBaseViewRecord**: Updated to use `Filament\Resources\Pages\ViewRecord\Concerns\Translatable`

### 2. Model Updates
- Removed `Spatie\Translatable\HasTranslations` trait from models
- Translation functionality now handled by database schema (JSON fields) and Filament 5's translation system
- Models like `MailTemplate` and `PageContent` no longer use the HasTranslations trait

### 3. Configuration Changes
- Replaced `lara-zeus/spatie-translatable` dependency with Filament 5's built-in translation features
- Updated panel configuration to use `->locales(['en', 'it'])` instead of plugin configuration

## Files Updated

### Panel Provider
- `Modules/Lang/app/Providers/Filament/LangBasePanelProvider.php`

### Resource Classes
- `Modules/Lang/app/Filament/Resources/LangBaseResource.php`
- `Modules/Lang/app/Filament/Resources/Pages/LangBaseListRecords.php`
- `Modules/Lang/app/Filament/Resources/Pages/LangBaseCreateRecord.php`
- `Modules/Lang/app/Filament/Resources/Pages/LangBaseEditRecord.php`
- `Modules/Lang/app/Filament/Resources/Pages/LangBaseViewRecord.php`

### Affected Models
- `Modules/Notify/app/Models/MailTemplate.php`
- `Modules/Cms/app/Models/PageContent.php`

## Database Requirements
- Ensure translation fields (e.g., `subject`, `html_template`, `name`) are stored as JSON in the database
- Migration files should update column types from string to JSON for translatable fields

## Implementation Notes
- The new translation system relies on JSON columns in the database
- The locale switcher is now provided by Filament 5's built-in translation concerns
- Previously, translation functionality was provided by the `lara-zeus/spatie-translatable` package
- Now translation handling is built into Filament 5's core

## Modules Affected
- Cms module (Page, Section, PageContent resources)
- Notify module (MailTemplate resource)
- Any other module using LangBase classes for multilingual support

## Testing Checklist
- [ ] Verify locale switcher appears in List, Create, Edit, and View pages
- [ ] Test creating records with multiple translations
- [ ] Verify translation fields are properly saved and retrieved
- [ ] Ensure proper fallback behavior for missing translations
- [ ] Test that non-translatable resources continue to work normally