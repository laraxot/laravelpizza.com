# Approfondimento Implementazione Tailwind CSS nel Modulo Notify

## 1. Architettura e Configurazione

### 1.1 Struttura dei File
```
Modules/Notify/
├── resources/
│   ├── views/
│   │   ├── components/
│   │   │   ├── email/
│   │   │   │   ├── button.blade.php
│   │   │   │   ├── header.blade.php
│   │   │   │   └── footer.blade.php
│   │   │   ├── card.blade.php
│   │   │   ├── alert.blade.php
│   │   │   └── ...
│   ├── css/
│   │   ├── app.css
│   │   └── email.css
│   └── js/
│       └── app.js
├── tailwind.config.js
└── package.json
```

### 1.2 Sistema di Design
```javascript
// tailwind.config.js
const colors = require('tailwindcss/colors')

module.exports = {
  theme: {
    extend: {
      colors: {
        'notify': {
          50: '#f0f9ff',
          100: '#e0f2fe',
          200: '#bae6fd',
          300: '#7dd3fc',
          400: '#38bdf8',
          500: '#0ea5e9',
          600: '#0284c7',
          700: '#0369a1',
          800: '#075985',
          900: '#0c4a6e',
        }
      },
      fontFamily: {
        sans: ['Inter var', ...defaultTheme.fontFamily.sans],
      },
      spacing: {
        '128': '32rem',
        '144': '36rem',
      },
    },
  },
}
```

## 2. Sistema di Componenti

### 2.1 Componenti Base Estesi
```php
// resources/views/components/button.blade.php
@props([
    'variant' => 'primary',
    'size' => 'md',
    'icon' => null,
    'iconPosition' => 'left',
    'loading' => false,
    'disabled' => false
])

@php
$variants = [
    'primary' => 'bg-notify-600 hover:bg-notify-700 text-white',
    'secondary' => 'bg-gray-200 hover:bg-gray-300 text-gray-900',
    'danger' => 'bg-red-600 hover:bg-red-700 text-white',
];

$sizes = [
    'sm' => 'px-2 py-1 text-sm',
    'md' => 'px-4 py-2 text-base',
    'lg' => 'px-6 py-3 text-lg',
];

$baseClasses = 'inline-flex items-center justify-center rounded-md font-medium focus:outline-none focus:ring-2 focus:ring-offset-2 transition-colors duration-200';
@endphp

<button 
    {{ $attributes->merge(['class' => "{$baseClasses} {$variants[$variant]} {$sizes[$size]}"]) }}
    {{ $disabled ? 'disabled' : '' }}
>
    @if($loading)
        <svg class="animate-spin -ml-1 mr-3 h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
        </svg>
    @elseif($icon && $iconPosition === 'left')
        <x-dynamic-component :component="$icon" class="-ml-1 mr-2 h-5 w-5"/>
    @endif

    {{ $slot }}

    @if($icon && $iconPosition === 'right')
        <x-dynamic-component :component="$icon" class="ml-2 -mr-1 h-5 w-5"/>
    @endif
</button>
```

### 2.2 Sistema di Layout Avanzato
```php
// resources/views/components/layout/section.blade.php
@props([
    'title' => null,
    'description' => null,
    'actions' => null,
    'divided' => false,
])

<section {{ $attributes->merge(['class' => 'py-8']) }}>
    @if($title || $description || $actions)
        <div class="flex items-center justify-between mb-6">
            <div>
                @if($title)
                    <h2 class="text-2xl font-bold text-gray-900">{{ $title }}</h2>
                @endif
                
                @if($description)
                    <p class="mt-1 text-sm text-gray-500">{{ $description }}</p>
                @endif
            </div>

            @if($actions)
                <div class="flex items-center space-x-4">
                    {{ $actions }}
                </div>
            @endif
        </div>
    @endif

    <div @class([
        'rounded-lg bg-white shadow',
        'divide-y divide-gray-200' => $divided,
    ])>
        {{ $slot }}
    </div>
</section>
```

## 3. Sistema di Email

### 3.1 Layout Email Avanzato
```php
// resources/views/vendor/notifications/email/layout.blade.php
<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="color-scheme" content="light">
    <meta name="supported-color-schemes" content="light">
    @vite('resources/css/email.css')
</head>
<body class="font-sans antialiased bg-gray-50">
    <div class="email-wrapper">
        <div class="email-header">
            <x-email.logo />
            @yield('header')
        </div>

        <div class="email-body">
            @yield('content')
        </div>

        <div class="email-footer">
            @yield('footer')
            <p class="text-sm text-gray-500 text-center mt-4">
                © {{ date('Y') }} {{ config('app.name') }}. Tutti i diritti riservati.
            </p>
        </div>
    </div>

    <style>
        .email-wrapper {
            @apply max-w-2xl mx-auto my-8 bg-white rounded-lg shadow-lg overflow-hidden;
        }
        .email-header {
            @apply px-6 py-4 bg-gray-50 border-b border-gray-200;
        }
        .email-body {
            @apply px-6 py-8;
        }
        .email-footer {
            @apply px-6 py-4 bg-gray-50 border-t border-gray-200;
        }
    </style>
</body>
</html>
```

### 3.2 Componenti Email Avanzati
```php
// resources/views/components/email/action-button.blade.php
@props([
    'url',
    'color' => 'primary',
    'align' => 'center',
    'fullWidth' => false
])

@php
$colors = [
    'primary' => 'bg-notify-600 hover:bg-notify-700',
    'secondary' => 'bg-gray-600 hover:bg-gray-700',
    'success' => 'bg-green-600 hover:bg-green-700',
    'danger' => 'bg-red-600 hover:bg-red-700',
];

$alignment = [
    'left' => 'text-left',
    'center' => 'text-center',
    'right' => 'text-right',
];
@endphp

<div class="{{ $alignment[$align] }}">
    <a href="{{ $url }}" 
       class="inline-flex items-center justify-center px-6 py-3 border border-transparent text-base font-medium rounded-md text-white {{ $colors[$color] }} {{ $fullWidth ? 'w-full' : '' }}"
       target="_blank">
        {{ $slot }}
    </a>
</div>
```

## 4. Utility e Helper

### 4.1 Mixins Tailwind
```css
/* resources/css/app.css */
@layer components {
    .input-base {
        @apply mt-1 block w-full rounded-md border-gray-300 shadow-sm;
        @apply focus:border-notify-500 focus:ring focus:ring-notify-500 focus:ring-opacity-50;
        @apply disabled:bg-gray-100 disabled:cursor-not-allowed;
    }

    .btn-base {
        @apply inline-flex items-center justify-center px-4 py-2 border border-transparent;
        @apply rounded-md font-medium focus:outline-none focus:ring-2 focus:ring-offset-2;
        @apply transition-colors duration-200;
    }

    .card-base {
        @apply bg-white overflow-hidden shadow-sm sm:rounded-lg;
        @apply border border-gray-200;
    }
}
```

### 4.2 Funzioni Helper
```php
// app/Helpers/TailwindHelper.php
class TailwindHelper
{
    public static function getColorClass($color, $variant = 500, $type = 'bg')
    {
        return "{$type}-notify-{$color}-{$variant}";
    }

    public static function getTextSize($size)
    {
        return match ($size) {
            'xs' => 'text-xs',
            'sm' => 'text-sm',
            'base' => 'text-base',
            'lg' => 'text-lg',
            'xl' => 'text-xl',
            '2xl' => 'text-2xl',
            '3xl' => 'text-3xl',
            default => 'text-base',
        };
    }

    public static function getSpacing($size)
    {
        return "p-{$size}";
    }
}
```

## 5. Ottimizzazione e Performance

### 5.1 Configurazione PurgeCSS
```javascript
// tailwind.config.js
module.exports = {
  content: [
    './Modules/Notify/resources/views/**/*.blade.php',
    './Modules/Notify/resources/js/**/*.{js,vue,ts}',
  ],
  options: {
    safelist: [
      'bg-notify-500',
      'text-notify-600',
      /^bg-notify-/,
      /^text-notify-/,
    ],
  },
}
```

### 5.2 Ottimizzazione Build
```javascript
// vite.config.js
import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/css/app.css',
                'resources/js/app.js',
                'Modules/Notify/resources/css/email.css',
            ],
            refresh: true,
        }),
    ],
    build: {
        rollupOptions: {
            output: {
                manualChunks: {
                    'notify': [
                        './Modules/Notify/resources/css/email.css',
                    ],
                },
            },
        },
    },
});
```

## 6. Testing e Qualità

### 6.1 Test Visivi
```php
// tests/Feature/Components/ButtonTest.php
class ButtonTest extends TestCase
{
    /** @test */
    public function it_renders_button_with_correct_classes()
    {
        $view = $this->blade(
            '<x-button variant="primary" size="md">Test</x-button>'
        );

        $view->assertSee('bg-notify-600', false);
        $view->assertSee('px-4 py-2', false);
    }

    /** @test */
    public function it_shows_loading_state()
    {
        $view = $this->blade(
            '<x-button loading>Test</x-button>'
        );

        $view->assertSee('animate-spin', false);
    }
}
```

### 6.2 Test Responsivi
```php
// tests/Browser/EmailTemplateTest.php
class EmailTemplateTest extends DuskTestCase
{
    /** @test */
    public function email_template_is_responsive()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/email-preview')
                    ->resize(375, 667) // Mobile
                    ->assertVisible('.email-wrapper')
                    ->assertCssValue('.email-wrapper', 'max-width', '100%')
                    ->resize(1920, 1080) // Desktop
                    ->assertCssValue('.email-wrapper', 'max-width', '672px');
        });
    }
}
```

## Note
- Tutti i collegamenti sono relativi
- La documentazione è mantenuta in italiano
- I collegamenti sono bidirezionali quando appropriato
- Ogni sezione ha il suo README.md specifico

## Contribuire
Per contribuire alla documentazione, seguire le [Linee Guida](../../../docs/linee-guida-documentazione.md) e le [Regole dei Collegamenti](../../../docs/regole_collegamenti_documentazione.md).

## Collegamenti Completi
Per una lista completa di tutti i collegamenti tra i README.md, consultare il file [README_links.md](../../../docs/README_links.md). 
