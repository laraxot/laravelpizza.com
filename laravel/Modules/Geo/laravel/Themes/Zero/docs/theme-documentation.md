# Zero Theme Documentation

## Overview

The Zero theme is the foundational theme for the Laraxot ecosystem, providing a clean, minimal starting point for custom theme development.

## Purpose

This theme serves as:
- **Base Template**: Minimal structure for custom themes
- **Development Reference**: Implementation patterns for theme development
- **Production Ready**: Lightweight theme for simple applications

## Theme Structure

```
Themes/Zero/
├── resources/
│   ├── views/
│   │   ├── components/     # Reusable blade components
│   │   ├── layouts/        # Page layout templates
│   │   └── pages/          # Specific page templates
│   ├── css/               # Stylesheet files
│   ├── js/                # JavaScript files
│   └── assets/            # Static assets (images, fonts)
├── docs/                  # Theme documentation
└── theme.json            # Theme configuration
```

## Configuration

### theme.json
```json
{
    "name": "Zero",
    "version": "1.0.0",
    "description": "Minimal base theme for Laraxot",
    "author": "Laraxot Team",
    "extends": null,
    "assets": {
        "css": ["resources/css/app.css"],
        "js": ["resources/js/app.js"]
    },
    "supports": {
        "dark_mode": false,
        "rtl": false,
        "responsive": true
    }
}
```

## Blade Components

### Layout Structure
```blade
<!-- resources/views/layouts/app.blade.php -->
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', config('app.name'))</title>
    
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased">
    @include('layouts.navigation')
    
    <main class="container mx-auto py-6">
        @yield('content')
    </main>
    
    @include('layouts.footer')
    
    @stack('scripts')
</body>
</html>
```

### Navigation Component
```blade
<!-- resources/views/components/navigation/header.blade.php -->
<header class="bg-white shadow-sm">
    <nav class="container mx-auto px-4">
        <div class="flex justify-between items-center h-16">
            <!-- Logo -->
            <div class="flex-shrink-0">
                <a href="{{ route('home') }}" class="text-xl font-bold">
                    {{ config('app.name') }}
                </a>
            </div>
            
            <!-- Main Navigation -->
            <div class="hidden md:flex space-x-8">
                @foreach ($navigationItems as $item)
                    <a href="{{ $item['url'] }}" 
                       class="text-gray-600 hover:text-gray-900 px-3 py-2 rounded-md text-sm font-medium">
                        {{ $item['label'] }}
                    </a>
                @endforeach
            </div>
            
            <!-- Mobile Menu Button -->
            <div class="md:hidden">
                <button type="button" class="mobile-menu-button">
                    <span class="sr-only">Open main menu</span>
                    <!-- Icon -->
                </button>
            </div>
        </div>
    </nav>
</header>
```

### Card Component
```blade
<!-- resources/views/components/ui/card.blade.php -->
@props([
    'title' => null,
    'description' => null,
    'footer' => null,
    'class' => null
])

<div {{ $attributes->merge(['class' => 'bg-white rounded-lg shadow-md overflow-hidden ' . ($class ?? '')]) }}>
    @if ($title)
        <div class="px-6 py-4 border-b border-gray-200">
            <h3 class="text-lg font-medium text-gray-900">{{ $title }}</h3>
            @if ($description)
                <p class="mt-1 text-sm text-gray-600">{{ $description }}</p>
            @endif
        </div>
    @endif
    
    <div class="px-6 py-4">
        {{ $slot }}
    </div>
    
    @if ($footer)
        <div class="px-6 py-4 bg-gray-50 border-t border-gray-200">
            {{ $footer }}
        </div>
    @endif
</div>
```

## Styling Architecture

### CSS Structure
```css
/* resources/css/app.css */
@import 'tailwindcss/base';
@import 'tailwindcss/components';
@import 'tailwindcss/utilities';

/* Custom Components */
@import './components/buttons.css';
@import './components/forms.css';
@import './components/navigation.css';

/* Utility Classes */
@import './utilities/spacing.css';
@import './utilities/typography.css';
```

### Component Styles
```css
/* resources/css/components/buttons.css */
.btn {
    @apply inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-offset-2;
}

.btn-primary {
    @apply bg-blue-600 text-white hover:bg-blue-700 focus:ring-blue-500;
}

.btn-secondary {
    @apply bg-gray-600 text-white hover:bg-gray-700 focus:ring-gray-500;
}

.btn-outline {
    @apply bg-transparent border-gray-300 text-gray-700 hover:bg-gray-50 focus:ring-blue-500;
}
```

## JavaScript Integration

### App JavaScript
```javascript
// resources/js/app.js
import './bootstrap';

// Components
import './components/navigation';
import './components/modal';
import './components/form';

// Utilities
import './utils/dom';
import './utils/events';

// Initialize application
document.addEventListener('DOMContentLoaded', () => {
    // Application initialization
    console.log('Zero theme initialized');
});
```

### Navigation Component
```javascript
// resources/js/components/navigation.js
class Navigation {
    constructor() {
        this.initMobileMenu();
        this.initDropdowns();
    }
    
    initMobileMenu() {
        const button = document.querySelector('.mobile-menu-button');
        const menu = document.querySelector('.mobile-menu');
        
        if (button && menu) {
            button.addEventListener('click', () => {
                menu.classList.toggle('hidden');
            });
        }
    }
    
    initDropdowns() {
        const dropdowns = document.querySelectorAll('.dropdown');
        
        dropdowns.forEach(dropdown => {
            const trigger = dropdown.querySelector('.dropdown-trigger');
            const content = dropdown.querySelector('.dropdown-content');
            
            if (trigger && content) {
                trigger.addEventListener('click', (e) => {
                    e.preventDefault();
                    content.classList.toggle('hidden');
                });
            }
        });
    }
}

new Navigation();
```

## Module Integration

### Filament Integration
```blade
<!-- resources/views/layouts/filament.blade.php -->
<x-filament-panels::page>
    <div class="zero-theme-wrapper">
        <!-- Custom header -->
        <header class="zero-theme-header">
            <!-- Theme-specific navigation -->
        </header>
        
        <!-- Main content -->
        <main class="zero-theme-main">
            {{ $filament->renderNavigation() }}
            {{ $slot }}
        </main>
        
        <!-- Custom footer -->
        <footer class="zero-theme-footer">
            <!-- Theme-specific footer -->
        </footer>
    </div>
</x-filament-panels::page>
```

### Module Component Override
```blade
<!-- resources/views/components/user/profile.blade.php -->
@props(['user' => null])

<div class="user-profile-card">
    @if ($user)
        <div class="user-avatar">
            <img src="{{ $user->avatar_url }}" alt="{{ $user->name }}">
        </div>
        
        <div class="user-info">
            <h3 class="user-name">{{ $user->name }}</h3>
            <p class="user-email">{{ $user->email }}</p>
        </div>
    @else
        <div class="guest-user">
            <p>Guest User</p>
        </div>
    @endif
</div>
```

## Customization Guide

### Creating Child Theme
```bash
# Create new theme directory
mkdir Themes/MyCustomTheme

# Copy Zero theme structure
cp -r Themes/Zero/* Themes/MyCustomTheme/

# Update theme.json
{
    "name": "MyCustomTheme",
    "extends": "Zero",
    "description": "Custom theme based on Zero"
}
```

### Adding Custom Components
```blade
<!-- resources/views/components/custom/alert.blade.php -->
@props(['type' => 'info', 'dismissible' => false])

<div class="alert alert-{{ $type }}" {{ $attributes }}>
    <div class="alert-content">
        {{ $slot }}
    </div>
    
    @if ($dismissible)
        <button type="button" class="alert-close" onclick="this.parentElement.remove()">
            ×
        </button>
    @endif
</div>
```

### Extending Styles
```css
/* resources/css/custom.css */
@import '../Zero/resources/css/app.css';

/* Custom theme colors */
:root {
    --primary-color: #3b82f6;
    --secondary-color: #6b7280;
    --success-color: #10b981;
    --warning-color: #f59e0b;
    --error-color: #ef4444;
}

/* Custom component overrides */
.btn-primary {
    background-color: var(--primary-color);
    border-color: var(--primary-color);
}
```

## Performance Optimization

### Asset Optimization
```javascript
// vite.config.js
export default defineConfig({
    build: {
        rollupOptions: {
            output: {
                manualChunks: {
                    vendor: ['vue', 'alpinejs'],
                    theme: ['./resources/js/theme.js'],
                    app: ['./resources/js/app.js']
                }
            }
        }
    }
});
```

### Lazy Loading
```blade
<!-- Lazy load heavy components -->
@if ($shouldLoadChart)
    <div x-data="chartComponent" x-init="init()">
        <!-- Chart content -->
    </div>
@endif
```

### CSS Purging
```css
/* tailwind.config.js */
module.exports = {
    content: [
        './Themes/Zero/resources/views/**/*.blade.php',
        './Themes/Zero/resources/js/**/*.js',
        './Modules/*/resources/views/**/*.blade.php'
    ],
    // ... other config
}
```

## Testing

### Component Testing
```php
// Tests/Feature/ThemeTest.php
class ThemeTest extends TestCase
{
    public function test_home_page_renders_with_theme()
    {
        $response = $this->get('/');
        
        $response->assertStatus(200);
        $response->assertSee('Zero Theme');
    }
    
    public function test_navigation_component_renders()
    {
        $view = $this->blade('<x-zero.navigation />');
        
        $view->assertSee('navigation');
    }
}
```

### JavaScript Testing
```javascript
// tests/js/navigation.test.js
import { expect, test } from 'vitest';
import { Navigation } from '../../resources/js/components/navigation';

test('navigation initializes mobile menu', () => {
    document.body.innerHTML = `
        <button class="mobile-menu-button"></button>
        <div class="mobile-menu hidden"></div>
    `;
    
    new Navigation();
    
    const button = document.querySelector('.mobile-menu-button');
    const menu = document.querySelector('.mobile-menu');
    
    button.click();
    expect(menu.classList.contains('hidden')).toBe(false);
});
```

## Deployment

### Asset Building
```bash
# Build for production
npm run build

# Optimize assets
php artisan optimize:clear
php artisan view:cache
```

### Theme Publishing
```bash
# Publish theme assets
php artisan theme:publish Zero

# Cache theme configuration
php artisan config:cache
```

## Best Practices

1. **Component-Based Design**: Build reusable blade components
2. **Mobile-First**: Design for mobile devices first
3. **Performance**: Lazy load heavy components and optimize assets
4. **Accessibility**: Include proper ARIA labels and semantic HTML
5. **Consistency**: Follow established design patterns
6. **Documentation**: Document custom components and usage patterns

## Troubleshooting

### Common Issues
1. **Assets not loading**: Check Vite configuration and routes
2. **Components not found**: Verify component namespace and path
3. **Styles not applying**: Check CSS import order and specificity
4. **JavaScript errors**: Verify script loading order and dependencies

### Debug Tools
```blade
<!-- Debug component rendering -->
@dump($componentData)
@dd($variables)
```

```javascript
// Debug JavaScript
console.log('Theme initialized', window.ZeroTheme);
```

## Related Documentation

- [Laraxot Theme Development Guide](../../../docs/theme-development.md)
- [Blade Components Documentation](../../../docs/blade-components.md)
- [Asset Management Guide](../../../docs/asset-management.md)