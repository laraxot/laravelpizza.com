# Filament Widgets for Frontend Components

## Overview
This document outlines the guidelines and best practices for using Filament widgets instead of Livewire components in frontend views.

## Key Principles

### 1. Module-Based Widget Organization
- **UI Module**: Contains common UI widgets (DarkModeSwitcher, ThemeSwitcher, etc.)
- **Lang Module**: Contains language-related widgets (LanguageSwitcher, TranslationManager, etc.)
- **User Module**: Contains authentication widgets (Login, Register, Logout, etc.)

### 2. Widget Structure
```php
namespace Modules\{Module}\Filament\Widgets;

use Modules\Xot\Filament\Widgets\XotBaseWidget;

class WidgetName extends XotBaseWidget
{
    protected static string $view = 'module::filament.widgets.widget-name';

    // Widget logic here
}
```

### 3. View Usage in Blade Templates
Replace Livewire components:
```blade
{{-- OLD: Livewire components --}}
<livewire:dark-mode-switcher />
<livewire:lang.switcher />

{{-- NEW: Filament widgets --}}
<x-filament-widgets::widget :widget="\Modules\UI\Filament\Widgets\DarkModeSwitcherWidget::class" />
<x-filament-widgets::widget :widget="\Modules\Lang\Filament\Widgets\LanguageSwitcherWidget::class" />
```

## Benefits of Filament Widgets over Livewire

1. **Better Integration**: Seamless integration with Filament admin panel
2. **Consistent Patterns**: Uniform widget structure across the application
3. **Enhanced Security**: Built-in Filament security features
4. **Performance**: Optimized rendering and state management
5. **Maintainability**: Clear separation of concerns by module

## Implementation Examples

### Dark Mode Switcher Widget (UI Module)
**Location**: `Modules/UI/app/Filament/Widgets/DarkModeSwitcherWidget.php`
**View**: `Modules/UI/resources/views/filament/widgets/dark-mode-switcher.blade.php`

### Language Switcher Widget (Lang Module)
**Location**: `Modules/Lang/app/Filament/Widgets/LanguageSwitcherWidget.php`
**View**: `Modules/Lang/resources/views/filament/widgets/language-switcher.blade.php`

## Migration Checklist

1. ✅ Identify Livewire components in frontend views
2. ✅ Create corresponding Filament widgets in appropriate modules
3. ✅ Update blade templates to use Filament widgets
4. ✅ Test functionality and ensure proper rendering
5. ✅ Remove deprecated Livewire components
6. ✅ Update documentation and guidelines

## Rules and Conventions

1. **Naming**: Widget classes should end with "Widget" (e.g., `DarkModeSwitcherWidget`)
2. **Location**: Widgets must be placed in their respective module's `Filament/Widgets` directory
3. **Views**: Widget views should use module namespace (e.g., `ui::filament.widgets.widget-name`)
4. **Inheritance**: All widgets should extend `XotBaseWidget` for consistency
5. **Dependencies**: Widgets should not have external dependencies outside their module

## Common Patterns

### State Management
```php
public bool $darkMode = false;

public function mount(): void
{
    $this->darkMode = filter_var(request()->cookie('dark_mode', 'false'), FILTER_VALIDATE_BOOLEAN);
}

public function toggleDarkMode(): void
{
    $this->darkMode = !$this->darkMode;
    Cookie::queue('dark_mode', $this->darkMode ? 'true' : 'false', 60 * 24 * 30);
    $this->dispatch('darkModeUpdated', ['darkMode' => $this->darkMode]);
}
```

### Event Handling
```blade
<button
    x-data="{ darkMode: {{ $darkMode ? 'true' : 'false' }} }"
    @click="
        darkMode = !darkMode;
        $dispatch('darkModeUpdated', { darkMode: darkMode });
        $wire.toggleDarkMode();
    "
>
    <!-- Content -->
</button>
```

## Testing

Widgets should be tested for:
- ✅ Proper rendering in different contexts
- ✅ State management and persistence
- ✅ Event handling and dispatching
- ✅ Cross-browser compatibility
- ✅ Accessibility compliance

## Performance Considerations

1. **Minimal JavaScript**: Use Alpine.js for simple interactions
2. **Efficient Rendering**: Leverage Filament's optimized rendering
3. **Caching**: Implement appropriate caching strategies for static content
4. **Lazy Loading**: Consider lazy loading for complex widgets

## Security Considerations

1. **CSRF Protection**: Filament widgets include built-in CSRF protection
2. **XSS Prevention**: Use proper escaping in blade templates
3. **Input Validation**: Validate all user inputs in widget methods
4. **Authorization**: Implement proper authorization checks where needed

## Troubleshooting

### Common Issues
1. **Widget not rendering**: Check if widget is properly registered
2. **Events not firing**: Verify Alpine.js and Livewire integration
3. **State not persisting**: Check cookie/localStorage implementation
4. **Styling issues**: Ensure proper CSS classes and responsive design

### Debugging Tips
1. Use browser developer tools to inspect widget elements
2. Check Laravel logs for any backend errors
3. Verify widget view paths and namespaces
4. Test widget functionality in isolation

## Future Enhancements

1. **Widget Registry**: Centralized widget registration system
2. **Theme Support**: Widget theming capabilities
3. **Internationalization**: Multi-language support for widget labels
4. **Accessibility**: Enhanced accessibility features
5. **Analytics**: Usage tracking and analytics integration
