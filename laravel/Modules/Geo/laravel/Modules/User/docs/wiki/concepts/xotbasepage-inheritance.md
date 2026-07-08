# XotBasePage Inheritance Architecture

## Overview
This document explains the inheritance pattern for Filament pages in the User module when extending `Modules\Xot\Filament\Pages\XotBasePage`.

## Core Rule: No Property Redefinition
**CRITICAL**: Never declare properties like `$view`, `$navigationIcon`, `$navigationGroup`, or `$navigationSort` in classes extending `XotBasePage`. These are already handled by the base class.

## Architecture Pattern

### XotBasePage Responsibilities
- Centralized view management via `$view` property
- Standardized navigation configuration
- Automatic translation resolution via LangServiceProvider
- Common form handling patterns

### Inheritance Best Practices

#### ✅ Correct Implementation
```php
class SocialiteProviderSettingsPage extends XotBasePage
{
    // Navigation properties are inherited from XotBasePage
    // No need to redeclare $view, $navigationIcon, etc.
    
    public function form(Schema $schema): Schema
    {
        // Form definition
    }
    
    // Other page logic
}
```

#### ❌ Incorrect Implementation
```php
class SocialiteProviderSettingsPage extends XotBasePage
{
    // These declarations cause errors:
    protected static ?string $view = 'user::filament.pages.socialite-settings';
    protected static ?string $navigationIcon = 'heroicon-o-key';
    
    // Error: "Cannot redeclare non static XotBasePage::$view as static"
}
```

## Files Affected
- `laravel/Modules/User/app/Filament/Pages/SocialiteProviderSettingsPage.php` - Corrected implementation
- `laravel/Modules/User/docs/wiki/concepts/xotbasepage-inheritance.md` - This documentation
- `bashscripts/ai/.claude/rules/xotbasepage-inheritance.md` - Rule reference

## Migration Guide
1. Remove any `$view` property declarations
2. Remove navigation property declarations (`$navigationIcon`, `$navigationGroup`, `$navigationSort`)
3. Use method overrides for custom navigation labels if needed
4. Ensure view path follows `module::filament.pages.pagename` pattern

## Testing
- Run `php artisan make:filament-user` to verify no inheritance errors
- Check Filament admin panel for page registration
- Verify navigation works correctly

## Related Documentation
- [Filament Widget + Template as Dress Rule](../../../bashscripts/ai/.claude/rules/filament-template-as-dress.md)
- [Translation 5-Element Rule](../../../bashscripts/ai/.claude/rules/translation-5-elements.md)
- [Xot Module Architecture](../../Xot/docs/wiki/concepts/xotbasepage.md)