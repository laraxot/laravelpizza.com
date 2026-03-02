# Folio Routing System

## Overview
This document explains the Folio routing system used in the CMS module for handling page routing and language prefixes.

## How It Works

The Folio routing system is integrated with Laravel's routing system to provide a file-based routing approach. Here's how it works:

1. **Page Discovery**: Folio automatically discovers page components in the `resources/views/pages` directory of each theme.

2. **Language Support**: The system supports multi-language routing with language prefixes (e.g., `/it/about`, `/en/about`).

3. **Route Registration**: Routes are registered in the `CmsServiceProvider` with the following middleware stack:
   - `LocaleSessionRedirect` - Handles locale session management
   - `LaravelLocalizationRoutes` - Manages localized routes
   - `LaravelLocalizationRedirectFilter` - Handles language redirection

## Configuration

### Supported Languages
Languages are configured in `config/laravellocalization.php`:

```php
'supportedLocales' => [
    'it' => ['name' => 'Italian', 'script' => 'Latn', 'native' => 'italiano', 'regional' => 'it_IT'],
    'en' => ['name' => 'English', 'script' => 'Latn', 'native' => 'English', 'regional' => 'en_GB'],
],
```

### Route Registration

Routes are registered in `Modules/Cms/app/Providers/CmsServiceProvider.php`:

```php
$theme_path = XotData::make()->getPubThemeViewPath('pages');

Folio::path($theme_path)
    ->middleware([
        '*' => array_merge($base_middleware, [
            \Mcamara\LaravelLocalization\Middleware\LocaleSessionRedirect::class,
            \Mcamara\LaravelLocalization\Middleware\LaravelLocalizationRoutes::class,
            \Mcamara\LaravelLocalization\Middleware\LaravelLocalizationRedirectFilter::class,
        ]),
    ]);
```

## Creating Pages

1. Create a new Blade file in your theme's `resources/views/pages` directory
2. The file path determines the route (e.g., `pages/about.blade.php` becomes `/about`)
3. Use the `<x-page>` component to define content areas

Example page:

```blade
<x-page side="content" slug="about">
    <h1>About Us</h1>
    <p>This is the about page content.</p>
</x-page>
```

## Language Switching

The system automatically handles language switching through the following process:

1. User visits a page with a language prefix (e.g., `/it/about`)
2. The `LocaleSessionRedirect` middleware sets the application locale
3. The `LaravelLocalizationRoutes` middleware handles the route localization
4. The page is rendered in the selected language

## Troubleshooting

### Pages Not Found
- Verify the file exists in the correct theme's `pages` directory
- Check for case sensitivity in file names
- Clear the route cache: `php artisan route:clear`

### Language Switching Issues
- Ensure the language is listed in `supportedLocales`
- Verify the language files exist in `resources/lang/{locale}`
- Check for proper middleware registration in `CmsServiceProvider`

## Best Practices

1. Keep page components in the theme's `pages` directory
2. Use the `<x-page>` component for consistent layout
3. Store language-specific content in language files
4. Test all routes with different language settings
5. Clear caches after making changes to routes or language files
