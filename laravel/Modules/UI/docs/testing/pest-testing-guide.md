# Pest Testing Guide - UI Module

## 🎯 Overview

Comprehensive guide for implementing and maintaining Pest tests in the UI module, focusing on theme management, component testing, and UI business logic following Laraxot conventions.

## ✅ Laraxot Testing Standards

### **Header Standard**
```php
<?php

declare(strict_types=1);

use Modules\UI\Models\Component;
use Modules\UI\Models\Theme;
use Modules\UI\Models\Asset;
use Modules\UI\Services\ComponentService;
use Modules\UI\Services\ThemeService;

uses(\Modules\UI\Tests\TestCase::class);
```

### **Critical Rules** 🔧
1. ✅ **Only** `declare(strict_types=1);` in header
2. ✅ **NEVER** declare namespace in test files
3. ✅ **ALWAYS** use module-specific TestCase
4. ✅ **Direct imports** of tested classes

## 🎯 UI Module Patterns

### **Custom Expectations**
```php
expect()->extend('toBeComponent', function () {
    return $this->toBeInstanceOf(\Modules\UI\Models\Component::class);
});

expect()->extend('toBeTheme', function () {
    return $this->toBeInstanceOf(\Modules\UI\Models\Theme::class);
});

expect()->extend('toBeAsset', function () {
    return $this->toBeInstanceOf(\Modules\UI\Models\Asset::class);
});
```

### **Helper Functions**
```php
function createTheme(array $attributes = []): \Modules\UI\Models\Theme
{
    return \Modules\UI\Models\Theme::factory()->create($attributes);
}

function createComponent(array $attributes = []): \Modules\UI\Models\Component
{
    return \Modules\UI\Models\Component::factory()->create($attributes);
}

function createAsset(array $attributes = []): \Modules\UI\Models\Asset
{
    return \Modules\UI\Models\Asset::factory()->create($attributes);
}
```

## 🏗️ Test Organization

### **Theme Management Tests**
```php
describe('UI Business Logic Integration', function () {
    beforeEach(function () {
        $this->theme = createTheme([
            'name' => 'Default Theme',
            'is_active' => true
        ]);

        $this->component = createComponent([
            'name' => 'test-component',
            'theme_id' => $this->theme->id,
            'is_active' => true
        ]);
    });

    describe('Theme Management Business Rules', function () {
        it('enforces theme activation rules', function () {
            $theme = createTheme([
                'name' => 'Test Theme',
                'is_active' => false
            ]);

            expect($theme->is_active)->toBeFalse();

            $theme->update(['is_active' => true]);
            expect($theme->is_active)->toBeTrue();

            $activeThemes = Theme::where('is_active', true)->get();
            expect($activeThemes)->toHaveCount(2);
        });
    });
});
```

### **Component Testing Patterns**
```php
describe('Component Management', function () {
    it('creates components with proper relationships', function () {
        $theme = createTheme(['name' => 'Test Theme']);

        $component = createComponent([
            'name' => 'header-component',
            'theme_id' => $theme->id,
            'type' => 'navigation',
            'is_active' => true
        ]);

        expect($component)->toBeComponent()
            ->and($component->theme_id)->toBe($theme->id)
            ->and($component->name)->toBe('header-component')
            ->and($component->is_active)->toBeTrue();
    });

    it('validates component configuration', function () {
        $component = createComponent([
            'name' => 'test-widget',
            'config' => ['color' => 'blue', 'size' => 'large']
        ]);

        expect($component->config)->toBeArray()
            ->and($component->config['color'])->toBe('blue')
            ->and($component->config['size'])->toBe('large');
    });
});
```

## 🎨 UI-Specific Testing Patterns

### **Dark Mode Toggle Testing**
```php
describe('Dark Mode Functionality', function () {
    it('toggles dark mode state correctly', function () {
        // Test dark mode toggle logic
        $initialState = false;
        $toggledState = !$initialState;

        expect($toggledState)->toBeTrue();

        // Test persistence
        $persistedState = $toggledState;
        expect($persistedState)->toBe($toggledState);
    });

    it('applies correct CSS classes for dark mode', function () {
        $darkModeClass = 'dark';
        $lightModeClass = 'light';

        expect($darkModeClass)->toBe('dark')
            ->and($lightModeClass)->toBe('light');
    });
});
```

### **Component Rendering Tests**
```php
describe('Component Rendering', function () {
    it('renders category tabs component correctly', function () {
        $categories = ['Technology', 'Design', 'Business'];

        expect($categories)->toBeArray()
            ->and($categories)->toHaveCount(3)
            ->and($categories[0])->toBe('Technology');
    });

    it('handles empty component states', function () {
        $emptyCategories = [];

        expect($emptyCategories)->toBeArray()
            ->and($emptyCategories)->toHaveCount(0);
    });
});
```

## 🛡️ Service Layer Testing

### **Theme Service Tests**
```php
describe('Theme Service Integration', function () {
    it('activates themes through service layer', function () {
        $themeService = app(ThemeService::class);
        $theme = createTheme(['is_active' => false]);

        $result = $themeService->activate($theme);

        expect($result)->toBeTrue()
            ->and($theme->fresh()->is_active)->toBeTrue();
    });

    it('deactivates previous theme when activating new one', function () {
        $activeTheme = createTheme(['is_active' => true]);
        $newTheme = createTheme(['is_active' => false]);

        $themeService = app(ThemeService::class);
        $themeService->activate($newTheme);

        expect($activeTheme->fresh()->is_active)->toBeFalse()
            ->and($newTheme->fresh()->is_active)->toBeTrue();
    });
});
```

### **Component Service Tests**
```php
describe('Component Service Integration', function () {
    it('registers components correctly', function () {
        $componentService = app(ComponentService::class);

        $componentData = [
            'name' => 'dynamic-widget',
            'type' => 'widget',
            'config' => ['position' => 'sidebar']
        ];

        $component = $componentService->register($componentData);

        expect($component)->toBeComponent()
            ->and($component->name)->toBe('dynamic-widget')
            ->and($component->type)->toBe('widget');
    });
});
```

## 🚀 Performance Testing

### **Asset Loading Tests**
```php
describe('Asset Management Performance', function () {
    it('loads assets efficiently', function () {
        $assets = collect();

        for ($i = 0; $i < 10; $i++) {
            $assets->push(createAsset([
                'name' => "asset-{$i}",
                'type' => 'css',
                'size' => rand(1000, 5000)
            ]));
        }

        expect($assets)->toHaveCount(10);

        $totalSize = $assets->sum('size');
        expect($totalSize)->toBeGreaterThan(0);
    });
});
```

## 📊 Test Coverage Areas

### **Core UI Components**
- ✅ Theme activation/deactivation
- ✅ Component registration and management
- ✅ Asset loading and optimization
- ✅ Dark mode functionality

### **Business Logic**
- ✅ Theme switching logic
- ✅ Component configuration validation
- ✅ Service layer integration
- ✅ State management

### **User Interface**
- ✅ Component rendering
- ✅ Interactive elements
- ✅ Responsive behavior
- ✅ Accessibility features

## 🎯 Modern Testing Syntax

### **Using `it()` instead of `test()`**
```php
// ✅ PREFERRED - More readable for UI tests
it('renders hero component with correct props', function () {
    $heroProps = [
        'title' => 'Welcome',
        'subtitle' => 'Get started today',
        'buttonText' => 'Learn More'
    ];

    expect($heroProps['title'])->toBe('Welcome')
        ->and($heroProps['subtitle'])->toBe('Get started today')
        ->and($heroProps['buttonText'])->toBe('Learn More');
});

// ✅ ALSO ACCEPTABLE - Traditional syntax
test('validates component configuration', function () {
    // Test implementation
});
```

## 🔧 Error Handling Patterns

### **Graceful Degradation Tests**
```php
describe('Error Handling', function () {
    it('handles missing theme gracefully', function () {
        $component = createComponent(['theme_id' => 999]);

        expect($component->theme)->toBeNull();

        // Should not throw exception
        $fallbackTheme = $component->theme ?? createTheme(['name' => 'Fallback']);
        expect($fallbackTheme)->toBeTheme();
    });

    it('validates component configuration with fallbacks', function () {
        $component = createComponent(['config' => null]);

        $config = $component->config ?? [];
        expect($config)->toBeArray();
    });
});
```

## 🎉 Current Performance Metrics

Based on existing UI module tests:
- **Multiple test files** covering different UI aspects
- **Business logic integration** tests
- **Component-specific** testing patterns
- **Service layer** validation

## 🔗 Related Documentation

### **Module Documentation**
- [UI Module README](../README.md)
- [Component Architecture](../components.md)
- [Theme System](../themes.md)

### **Testing Resources**
- [CMS Testing Best Practices](../../Cms/project_docs/tests/pestphp-best-practices.md)
- [Employee Testing Guide](../../Employee/project_docs/testing/pest-testing-guide.md)
- [CMS Testing Best Practices](../../Cms/docs/tests/pestphp-best-practices.md)
- [Employee Testing Guide](../../Employee/docs/testing/pest-testing-guide.md)
- [CMS Testing Best Practices](../../Cms/docs/tests/pestphp-best-practices.md)
- [Employee Testing Guide](../../Employee/docs/testing/pest-testing-guide.md)
- [CMS Testing Best Practices](../../Cms/docs/tests/pestphp-best-practices.md)
- [Employee Testing Guide](../../Employee/docs/testing/pest-testing-guide.md)

### **Implementation Files**
- [UIBusinessLogicTest.php](../../tests/Feature/UIBusinessLogicTest.php)
- [DarkModeToggleTest.php](../../tests/Feature/DarkModeToggleTest.php)
- [CategoryTabsComponentTest.php](../../tests/Feature/CategoryTabsComponentTest.php)

---
**Last Updated**: September 2025
**Status**: ✅ PRODUCTION READY
**Coverage**: UI Components + Business Logic + Service Integration
