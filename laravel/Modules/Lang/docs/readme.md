# Lang Module Documentation

## Overview

The Lang module handles internationalization (i18n) and localization for the LaravelPizza project.

## Structure

- `docs/` - Module documentation
- `package.json` - NPM dependencies (if any)
- `composer.json` - PHP dependencies
- `resources/lang/` - Translation files

## Key Documentation

- [laravel-localization-reference](./laravel-localization-reference.md) - Complete reference for mcamara/laravel-localization
- [translation-strategies](./translation-strategies.md) - Translation approach
- [multilingual-setup](./multilingual-setup.md) - Setup for 6 languages

## Dependencies

- `mcamara/laravel-localization` - URL-based localization
- `spatie/laravel-translatable` - Model translations

## Quick Reference

```bash
# Clear translation cache
php artisan translation:clear

# Show missing translations
php artisan translation:show
```

## Related Modules

- [Cms](../Cms/docs/) - Content blocks with translations
- [User](../User/docs/) - User-facing translations
