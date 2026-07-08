# 🎨 Theme System - Dynamic Theme Registration

**Date**: 2026-03-30  
**Status**: ✅ **CORRECTED**  
**Principle**: Theme is a "vestito" (outfit) - configurable and swappable!

---

## 🎯 How It Works

### 1. Theme Configuration

The active theme is configured in:
```
config/{environment}/{domain}/xra.php
```

**Example** (`config/localhost/fixcity/xra.php`):
```php
<?php
return [
    'pub_theme' => 'Sixteen',           // Active theme
    'register_pub_theme' => true,       // Auto-register theme
    'adm_theme' => 'AdminLTE',          // Admin theme (legacy)
    // ... other config
];
```

### 2. Dynamic Registration

**DO NOT** hardcode theme registration in `AppServiceProvider.php`!

**WRONG** ❌:
```php
// app/Providers/AppServiceProvider.php
public function boot(): void
{
    $this->app->register(\Themes\Sixteen\Providers\ThemeServiceProvider::class);
}
```

**CORRECT** ✅:
```php
// app/Providers/AppServiceProvider.php
public function boot(): void
{
    // Theme registration is handled dynamically by Xot module
    // No hardcoded theme registration here!
}
```

### 3. Xot Module Auto-Registration

The Xot module reads the configuration and automatically registers the theme:

```php
// Modules/Xot/Providers/XotServiceProvider.php
public function boot(): void
{
    $config = config('xra');
    
    if ($config['register_pub_theme'] ?? false) {
        $theme = $config['pub_theme'] ?? 'Sixteen';
        $themeServiceProvider = "\\Themes\\{$theme}\\Providers\\ThemeServiceProvider";
        
        if (class_exists($themeServiceProvider)) {
            $this->app->register($themeServiceProvider);
        }
    }
}
```

---

## 🎨 Theme Structure

### Theme Directory
```
laravel/Themes/
├── Sixteen/
│   ├── app/
│   │   └── Providers/
│   │       ├── ThemeServiceProvider.php  ✅ Auto-registered
│   │       ├── RouteServiceProvider.php
│   │       └── EventServiceProvider.php
│   ├── resources/
│   │   ├── views/
│   │   └── lang/
│   └── composer.json
├── TwentyOne/
│   └── ...
└── ...
```

### Theme Service Provider
```php
// Themes/Sixteen/app/Providers/ThemeServiceProvider.php
namespace Themes\Sixteen\Providers;

use Modules\Xot\Providers\XotBaseThemeServiceProvider;

class ThemeServiceProvider extends XotBaseThemeServiceProvider
{
    public string $name = 'Sixteen';
    public string $nameLower = 'sixteen';
    
    public function boot(): void
    {
        parent::boot();
        // Theme-specific boot logic
    }
}
```

---

## 🔄 Switching Themes

### Method 1: Configuration File

1. Edit config file:
```php
// config/localhost/fixcity/xra.php
return [
    'pub_theme' => 'TwentyOne',  // Change theme
    'register_pub_theme' => true,
];
```

2. Clear cache:
```bash
php artisan config:clear
php artisan view:clear
```

### Method 2: Environment Variable

1. Add to `.env`:
```env
THEME_PUB=TwentyOne
THEME_REGISTER_PUB=true
```

2. Update config to read env:
```php
// config/localhost/fixcity/xra.php
return [
    'pub_theme' => env('THEME_PUB', 'Sixteen'),
    'register_pub_theme' => env('THEME_REGISTER_PUB', true),
];
```

---

## 📊 Available Themes

| Theme | Status | Composer | Description |
|-------|--------|----------|-------------|
| **Sixteen** | ✅ Active | `laraxot/theme-sixteen-fila5` | Bootstrap Italia, AGID compliant |
| **TwentyOne** | ✅ Available | `laraxot/theme-twentyone-fila5` | Modern, feature-rich |
| **Custom** | 🟡 Create your own | N/A | Extend XotBaseThemeServiceProvider |

---

## 🛠️ Creating a Custom Theme

### Step 1: Create Theme Structure
```bash
laravel/Themes/MyTheme/
├── app/
│   └── Providers/
│       ├── ThemeServiceProvider.php
│       ├── RouteServiceProvider.php
│       └── EventServiceProvider.php
├── resources/
│   ├── views/
│   │   ├── layouts/
│   │   └── components/
│   └── lang/
└── composer.json
```

### Step 2: Create Service Provider
```php
<?php

namespace Themes\MyTheme\Providers;

use Modules\Xot\Providers\XotBaseThemeServiceProvider;

class ThemeServiceProvider extends XotBaseThemeServiceProvider
{
    public string $name = 'MyTheme';
    public string $nameLower = 'mytheme';
}
```

### Step 3: Register Theme
```php
// config/localhost/fixcity/xra.php
return [
    'pub_theme' => 'MyTheme',
    'register_pub_theme' => true,
];
```

---

## ✅ Checklist

### AppServiceProvider
- [x] Removed hardcoded theme registration
- [x] Added documentation comment
- [x] Theme registration delegated to Xot module

### Xot Module
- [x] Reads theme from config
- [x] Auto-registers theme service provider
- [x] Supports dynamic theme switching

### Themes
- [x] Sixteen: Extends XotBaseThemeServiceProvider
- [x] TwentyOne: Extends XotBaseThemeServiceProvider
- [x] Custom themes: Can extend XotBaseThemeServiceProvider

---

## 📚 Related Documentation

| Document | Location |
|----------|----------|
| **Theme Configuration** | `config/{env}/{domain}/xra.php` |
| **XotBaseThemeServiceProvider** | `Modules/Xot/Providers/XotBaseThemeServiceProvider.php` |
| **Sixteen Theme** | `Themes/Sixteen/app/Providers/ThemeServiceProvider.php` |
| **TwentyOne Theme** | `Themes/TwentyOne/app/Providers/ThemeServiceProvider.php` |

---

## 🎯 Key Principles

### 1. Theme is a "Vestito" (Outfit)
- ✅ Configurable
- ✅ Swappable
- ✅ Not hardcoded
- ✅ Loaded dynamically

### 2. Separation of Concerns
- ✅ AppServiceProvider: Core app services only
- ✅ Xot Module: Theme registration logic
- ✅ Theme: Theme-specific services

### 3. Flexibility
- ✅ Switch themes via config
- ✅ Multiple themes per installation
- ✅ Custom themes supported

---

**Status**: ✅ **CORRECTED**  
**Principle**: Theme is dynamic, not hardcoded  
**Next**: Theme switching works via config only

**Theme system corrected! 🎨**
