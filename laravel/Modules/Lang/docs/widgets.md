# Lang Module Widgets

## Overview

This document provides documentation for the widgets available in the Lang module for language management and internationalization.

## LanguageSwitcherWidget

A widget that provides a dropdown selector for changing the application language.

### Features

- Dynamic language detection from database or fallback configuration
- Support for language flags and native names
- Persistent language preference
- Accessible dropdown with proper ARIA labels
- Automatic URL generation for different locales
- Graceful fallback when Language model is not available

### Configuration

The widget requires no configuration and can be used directly in themes:

```blade
<x-lang::language-switcher />
```

### Usage in Themes

```blade
{{-- In theme header or navigation --}}
<ul class="menu menu-horizontal">
    <x-lang::language-switcher />
    <!-- Other menu items -->
</ul>
```

### Supported Languages

The widget supports the following languages by default:

- **Italian** (it) 🇮🇹
- **English** (en) 🇬🇧  
- **German** (de) 🇩🇪

Additional languages can be added through the Language model or by extending the `getDefaultLanguages()` method.

### Database Integration

If the `Language` model exists and contains data, the widget will automatically load active languages from the database. The expected structure is:

```php
// Language model fields
- code (string): Language code (e.g., 'it', 'en', 'de')
- name (string): English name of the language
- native_name (string): Native name of the language
- flag (string): Flag emoji or icon
- active (boolean): Whether the language is active
- order (integer): Display order
```

### Fallback Configuration

When the Language model is not available, the widget uses a hardcoded configuration:

```php
[
    [
        'code' => 'it',
        'name' => 'Italian',
        'native_name' => 'Italiano',
        'flag' => '🇮🇹',
    ],
    [
        'code' => 'en',
        'name' => 'English',
        'native_name' => 'English',
        'flag' => '🇬🇧',
    ],
    [
        'code' => 'de',
        'name' => 'German',
        'native_name' => 'Deutsch',
        'flag' => '🇩🇪',
    ],
]
```

### URL Generation

The widget automatically generates proper URLs for each language by:

1. Detecting the current locale in the URL
2. Replacing or adding the new locale
3. Maintaining the current path structure

### JavaScript Integration

The widget includes JavaScript functionality for:

- Language preference persistence in localStorage
- Smooth transitions during language changes
- Loading indicators during language switches

### Translations

The widget uses translations from the Lang module:

```php
// lang/it/widgets.php
'language_switcher' => [
    'select_language' => 'Seleziona lingua',
    'current_language' => 'Lingua corrente',
    'change_to' => 'Cambia a :language',
    // ...
],
```

### Accessibility

The widget follows accessibility best practices:

- Proper ARIA labels for screen readers
- Keyboard navigation support
- Clear visual indicators for the current language
- High contrast support for different themes

### Customization

To customize the widget appearance or behavior:

1. **Extend the widget class**:
   ```php
   class CustomLanguageSwitcherWidget extends LanguageSwitcherWidget
   {
       protected function getDefaultLanguages(): array
       {
           // Custom language configuration
       }
   }
   ```

2. **Override the view**:
   ```blade
   {{-- Create custom view at lang::filament.widgets.custom-language-switcher --}}
   ```

3. **Add custom styling**:
   ```css
   .language-switcher-container {
       /* Custom styles */
   }
   ```

### Error Handling

The widget includes robust error handling:

- Graceful degradation when Language model is unavailable
- Logging of database connection issues
- Fallback to default languages configuration
- Validation of locale codes before applying changes

### Performance Considerations

- Language data is cached per request
- Minimal database queries (only active languages)
- Efficient URL generation algorithms
- Optimized JavaScript for smooth interactions

## Best Practices

1. **Language Management**:
   - Keep the Language model updated with all supported languages
   - Use consistent language codes across the application
   - Provide proper translations for all supported languages

2. **Theme Integration**:
   - Place the widget in a consistent location across themes
   - Ensure proper styling integration with the theme design
   - Test with different screen sizes and devices

3. **Accessibility**:
   - Always provide alternative text for flag images
   - Ensure keyboard navigation works properly
   - Test with screen readers

4. **Performance**:
   - Monitor database queries if using the Language model
   - Consider caching language configurations for high-traffic sites
   - Optimize JavaScript for mobile devices

## Links

- [Lang Module Documentation](../README.md)
- [Translation Management](./translations.md)
- [Internationalization Best Practices](./i18n-best-practices.md)
- [Widget vs Livewire Components](../../../project_docs/widget_vs_livewire_components.md)

*Last updated: January 2025*
