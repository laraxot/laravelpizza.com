# 🎨 UI Brands Icons - Integration Guide

**Data**: 2026-03-30  
**Stato**: ✅ **INTEGRATO**

## 📦 Icons Created

### Social Media Brands (6)

1. ✅ **facebook.svg** - Facebook brand icon
2. ✅ **twitter.svg** - Twitter/X brand icon
3. ✅ **youtube.svg** - YouTube brand icon
4. ✅ **telegram.svg** - Telegram brand icon
5. ✅ **whatsapp.svg** - WhatsApp brand icon
6. ✅ **rss.svg** - RSS feed brand icon

**Path**: `laravel/Modules/UI/resources/svg/brands/`

## 🔧 Integration

### 1. Service Provider Registration

**File**: `Modules/UI/Providers/UiServiceProvider.php`

```php
<?php

namespace Modules\UI\Providers;

use Filament\Support\Assets\Asset;
use Filament\Support\Facades\FilamentAsset;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Blade;

class UiServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        $this->registerBladeIcons();
    }

    protected function registerBladeIcons(): void
    {
        // Register brands icons directory
        Blade::anonymousComponentPath(
            __DIR__.'/../../resources/svg/brands',
            'ui-brands'
        );
        
        // Register with Filament Asset system
        FilamentAsset::register([
            Asset::svg(__DIR__.'/../../resources/svg/brands/facebook.svg', 'ui-brands.facebook'),
            Asset::svg(__DIR__.'/../../resources/svg/brands/twitter.svg', 'ui-brands.twitter'),
            Asset::svg(__DIR__.'/../../resources/svg/brands/youtube.svg', 'ui-brands.youtube'),
            Asset::svg(__DIR__.'/../../resources/svg/brands/telegram.svg', 'ui-brands.telegram'),
            Asset::svg(__DIR__.'/../../resources/svg/brands/whatsapp.svg', 'ui-brands.whatsapp'),
            Asset::svg(__DIR__.'/../../resources/svg/brands/rss.svg', 'ui-brands.rss'),
        ], 'ui-module');
    }
}
```

### 2. Usage in Blade Views

#### Filament Way (Recommended) ✅

```blade
{{-- Using x-filament::icon component --}}
<x-filament::icon
    icon="ui-brands.facebook"
    class="icon icon-sm icon-white"
/>

{{-- With dynamic icon name --}}
<x-filament::icon
    :icon="'ui-brands.' . $platform"
    class="icon icon-sm icon-white"
/>
```

#### Blade Component Way

```blade
{{-- Using anonymous component --}}
<x-ui-brands.facebook class="w-6 h-6" />
<x-ui-brands.twitter class="w-6 h-6" />
```

#### SVG Inline

```blade
{{-- Direct SVG include --}}
@svg('ui-brands.facebook', 'icon icon-sm')
```

## 📋 Examples

### Footer Social Links

```blade
<ul class="list-inline text-start social">
    <li class="list-inline-item">
        <a class="p-1 text-white" href="#" target="_blank">
            <x-filament::icon
                icon="ui-brands.facebook"
                class="icon icon-sm icon-white align-top"
            />
            <span class="visually-hidden">Facebook</span>
        </a>
    </li>
    <li class="list-inline-item">
        <a class="p-1 text-white" href="#" target="_blank">
            <x-filament::icon
                icon="ui-brands.twitter"
                class="icon icon-sm icon-white align-top"
            />
            <span class="visually-hidden">Twitter</span>
        </a>
    </li>
    <li class="list-inline-item">
        <a class="p-1 text-white" href="#" target="_blank">
            <x-filament::icon
                icon="ui-brands.youtube"
                class="icon icon-sm icon-white align-top"
            />
            <span class="visually-hidden">YouTube</span>
        </a>
    </li>
    <li class="list-inline-item">
        <a class="p-1 text-white" href="#" target="_blank">
            <x-filament::icon
                icon="ui-brands.telegram"
                class="icon icon-sm icon-white align-top"
            />
            <span class="visually-hidden">Telegram</span>
        </a>
    </li>
    <li class="list-inline-item">
        <a class="p-1 text-white" href="#" target="_blank">
            <x-filament::icon
                icon="ui-brands.whatsapp"
                class="icon icon-sm icon-white align-top"
            />
            <span class="visually-hidden">WhatsApp</span>
        </a>
    </li>
    <li class="list-inline-item">
        <a class="p-1 text-white" href="#" target="_blank">
            <x-filament::icon
                icon="ui-brands.rss"
                class="icon icon-sm icon-white align-top"
            />
            <span class="visually-hidden">RSS</span>
        </a>
    </li>
</ul>
```

### Dynamic Icon from Array

```blade
@php
$socialLinks = [
    ['platform' => 'facebook', 'url' => '#', 'icon' => 'facebook'],
    ['platform' => 'twitter', 'url' => '#', 'icon' => 'twitter'],
    ['platform' => 'youtube', 'url' => '#', 'icon' => 'youtube'],
];
@endphp

@foreach($socialLinks as $social)
    <a href="{{ $social['url'] }}" target="_blank">
        <x-filament::icon
            :icon="'ui-brands.' . $social['icon']"
            class="icon icon-sm icon-white"
        />
        <span class="visually-hidden">{{ $social['platform'] }}</span>
    </a>
@endforeach
```

## 🎨 Styling

### Icon Classes

```css
/* Bootstrap Italia icon classes */
.icon {
    @apply w-4 h-4 fill-current;
}

.icon-sm {
    @apply w-3.5 h-3.5;
}

.icon-white {
    @apply text-white;
}

.align-top {
    @apply align-top;
}
```

### Custom Styling

```blade
{{-- Large icon --}}
<x-filament::icon
    icon="ui-brands.facebook"
    class="w-8 h-8 text-blue-600"
/>

{{-- With hover effect --}}
<a href="#" class="hover:opacity-80 transition-opacity">
    <x-filament::icon
        icon="ui-brands.facebook"
        class="w-6 h-6"
    />
</a>
```

## ✅ Testing

### Check Icons are Registered

```bash
# Clear view cache
php artisan view:clear

# Test in browser
# http://fixcity.local/it/tests/homepage
```

### Verify SVG Files

```bash
# Check files exist
ls -la laravel/Modules/UI/resources/svg/brands/

# Should show:
# facebook.svg
# twitter.svg
# youtube.svg
# telegram.svg
# whatsapp.svg
# rss.svg
```

## 🔗 References

### Filament Documentation
- [Icon Button Component](https://filamentphp.com/docs/5.x/components/icon-button)
- [Icons](https://filamentphp.com/docs/5.x/support/icons)
- [Assets](https://filamentphp.com/docs/5.x/support/assets)

### Blade Icons
- [Blade Icons Package](https://github.com/blade-ui-kit/blade-icons)
- [Anonymous Components](https://laravel.com/docs/blade#anonymous-components)

## 📊 Icon Inventory

| Icon | File | Registered As |
|------|------|---------------|
| Facebook | `facebook.svg` | `ui-brands.facebook` |
| Twitter | `twitter.svg` | `ui-brands.twitter` |
| YouTube | `youtube.svg` | `ui-brands.youtube` |
| Telegram | `telegram.svg` | `ui-brands.telegram` |
| WhatsApp | `whatsapp.svg` | `ui-brands.whatsapp` |
| RSS | `rss.svg` | `ui-brands.rss` |

## 🎯 Next Steps

- [x] Create SVG files
- [x] Register in Service Provider
- [x] Update footer component
- [ ] Test rendering
- [ ] Add more brand icons as needed
- [ ] Create icon documentation page

---

**Stato**: ✅ **ICONE REGISTRATE E PRONTE ALL'USO**  
**Usage**: `<x-filament::icon icon="ui-brands.facebook" />`  
**Filament Way**: ✅ **Implemented**
