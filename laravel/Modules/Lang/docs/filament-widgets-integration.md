# Language Module - Filament Widgets Integration

## Overview
This document provides guidelines for implementing Filament widgets in the Lang module, specifically for language switching functionality.

## Language Switcher Widget

### Location
- **Class**: `Modules/Lang/app/Filament/Widgets/LanguageSwitcherWidget.php`
- **View**: `Modules/Lang/resources/views/filament/widgets/language-switcher.blade.php`

### Implementation Details

#### Widget Class Structure
```php
namespace Modules\Lang\Filament\Widgets;

use Modules\Xot\Filament\Widgets\XotBaseWidget;

class LanguageSwitcherWidget extends XotBaseWidget
{
    protected static string $view = 'lang::filament.widgets.language-switcher';
    
    public function getViewData(): array
    {
        return [
            'current_locale' => app()->getLocale(),
            'available_locales' => $this->getAvailableLocales(),
        ];
    }
    
    protected function getAvailableLocales(): Collection
    {
        // Implementation for retrieving available languages
    }
    
    public function changeLanguage(string $locale): void
    {
        // Language switching logic
    }
}
```

#### View Template Structure
```blade
<li class="language-switcher-container">
    <details class="dropdown">
        <summary>
            {{-- Current language display --}}
        </summary>
        <ul class="dropdown-content">
            @foreach($available_locales as $locale)
                <li>
                    <a 
                        href="{{ $this->getLanguageUrl($locale['code']) }}"
                        wire:click="changeLanguage('{{ $locale['code'] }}')"
                    >
                        {{-- Language options --}}
                    </a>
                </li>
            @endforeach
        </ul>
    </details>
</li>
```

## Key Features

### 1. Multi-language Support
- Supports multiple languages from database or configuration
- Fallback to default languages if database not available
- Proper locale validation

### 2. URL Generation
- Smart URL generation preserving current route parameters
- Proper handling of locale prefixes
- Support for both route-based and parameter-based localization

### 3. User Experience
- Dropdown interface with flags and native names
- Visual indication of current language
- Smooth animations and transitions
- Mobile-responsive design

### 4. Persistence
- Session-based language preference
- LocalStorage for client-side persistence
- Cookie-based fallback

## Integration Guidelines

### 1. Header Integration
Replace Livewire component with Filament widget:

```blade
{{-- OLD --}}
<livewire:lang.switcher />

{{-- NEW --}}
<x-filament-widgets::widget 
    :widget="\Modules\Lang\Filament\Widgets\LanguageSwitcherWidget::class" 
/>
```

### 2. Configuration
Ensure proper Laravel localization setup:
- Configure supported locales in `config/app.php`
- Set up route localization if needed
- Configure LaravelLocalization package if used

### 3. Styling
- Use Tailwind CSS classes for consistency
- Implement dark mode support
- Ensure accessibility compliance
- Responsive design for mobile devices

## Best Practices

### 1. Performance
- Cache language lists where appropriate
- Use efficient database queries
- Minimize JavaScript for better performance

### 2. Security
- Validate locale parameters
- Prevent XSS attacks in language names
- Secure session handling

### 3. Accessibility
- Proper ARIA labels
- Keyboard navigation support
- Screen reader compatibility
- High contrast support

### 4. Internationalization
- Translate widget interface elements
- Support RTL languages
- Proper text direction handling

## Testing

### Unit Tests
- Test locale validation
- Test URL generation
- Test language switching functionality

### Integration Tests  
- Test widget rendering in different contexts
- Test with different language configurations
- Test error handling scenarios

### Browser Tests
- Test dropdown functionality
- Test mobile responsiveness
- Test accessibility features

## Troubleshooting

### Common Issues
1. **Widget not appearing**: Check widget registration and view path
2. **Languages not loading**: Verify database connection and fallback config
3. **URL generation errors**: Check route localization setup
4. **Styling issues**: Verify CSS classes and responsive design

### Debugging Tips
- Use `dd()` in widget methods for debugging
- Check browser console for JavaScript errors
- Verify session and cookie settings
- Test with different browser locales

## Migration from Livewire

### Steps
1. Create Filament widget class
2. Implement equivalent functionality
3. Create blade template
4. Update references in views
5. Test thoroughly
6. Remove old Livewire component

### Benefits
- Better integration with Filament ecosystem
- Consistent code patterns
- Enhanced security features
- Improved performance

## Future Enhancements

### Planned Features
- User preference persistence in database
- Automatic language detection
- Geolocation-based language suggestions
- Language learning progress tracking
- Translation memory integration

### Technical Improvements
- AJAX-based language switching
- Offline language support
- Progressive Web App capabilities
- Enhanced caching strategies
- Better error handling and fallbacks