# 🚀 Filament 5.x Installation Guide

This guide details the installation and configuration of Filament 5.x in the Meetup theme.

## 📋 Requirements

- **PHP**: 8.2+
- **Laravel**: v11.28+
- **Tailwind CSS**: v4.1+

## ⚙️ Installation Approaches

### 1. Panel Builder
For a cohesive admin panel experience:
```bash
composer require filament/filament:"^5.0"
php artisan filament:install --panels
```

### 2. Individual Components
For using components in existing Blade views:
```bash
composer require filament/tables:"^5.0" \
    filament/schemas:"^5.0" \
    filament/forms:"^5.0" \
    filament/infolists:"^5.0" \
    filament/actions:"^5.0" \
    filament/notifications:"^5.0" \
    filament/widgets:"^5.0"
```

## 🎨 Asset Configuration

### Tailwind CSS v4.1
Install Tailwind CSS and the Vite plugin:
```bash
npm install tailwindcss @tailwindcss/vite --save-dev
```

### Vite Configuration (`vite.config.js`)
Ensure the Tailwind Vite plugin is registered:
```javascript
import { defineConfig } from 'vite'
import laravel from 'laravel-vite-plugin'
import tailwindcss from '@tailwindcss/vite'

export default defineConfig({
    plugins: [
        laravel({
            input: ['resources/css/app.css', 'resources/js/app.js'],
            refresh: true,
        }),
        tailwindcss(),
    ],
})
```

### CSS Configuration (`resources/css/app.css`)
Import the necessary Filament styles:
```css
@import 'tailwindcss';
@import '../../vendor/filament/support/resources/css/index.css';
@import '../../vendor/filament/actions/resources/css/index.css';
@import '../../vendor/filament/forms/resources/css/index.css';
@import '../../vendor/filament/infolists/resources/css/index.css';
@import '../../vendor/filament/notifications/resources/css/index.css';
@import '../../vendor/filament/schemas/resources/css/index.css';
@import '../../vendor/filament/tables/resources/css/index.css';
@import '../../vendor/filament/widgets/resources/css/index.css';

@variant dark (&:where(.dark, .dark *));
```

## 🏗️ Layout Configuration

Ensure your `app.blade.php` includes the required directives:
```html
<head>
    <!-- ... -->
    @filamentStyles
    @vite('resources/css/app.css')
</head>
<body>
    {{ $slot }}
    @livewire('notifications')
    @filamentScripts
    @vite('resources/js/app.js')
</body>
```