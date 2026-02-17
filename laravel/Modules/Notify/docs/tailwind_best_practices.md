# Best Practices Implementazione Tailwind CSS nel Modulo Notify

## 1. Organizzazione del Codice

### 1.1 Struttura dei File
- Mantenere una struttura chiara e modulare
- Separare i componenti per responsabilità
- Utilizzare una nomenclatura consistente

```
Modules/Notify/
├── resources/
│   ├── views/
│   │   ├── components/    # Componenti Blade
│   │   ├── layouts/       # Layout principali
│   │   └── partials/      # Parti riutilizzabili
│   ├── css/
│   │   ├── components/    # Stili specifici dei componenti
│   │   ├── utilities/     # Utility classes
│   │   └── app.css        # File principale
│   └── js/
└── tailwind.config.js
```

### 1.2 Convenzioni di Naming
```css
/* Prefissi per componenti specifici del modulo */
.notify-btn { /* ... */ }
.notify-card { /* ... */ }

/* Utility classes specifiche */
.notify-shadow-sm { /* ... */ }
.notify-gradient { /* ... */ }
```

## 2. Componenti

### 2.1 Composizione dei Componenti
```php
// BAD
<div class="p-4 bg-white rounded-lg shadow-md">
    <h2 class="text-xl font-bold mb-4">{{ $title }}</h2>
    {{ $slot }}
</div>

// GOOD
@props(['title'])

<div class="notify-card">
    <h2 class="notify-card-title">{{ $title }}</h2>
    <div class="notify-card-body">
        {{ $slot }}
    </div>
</div>

// resources/css/components/card.css
.notify-card {
    @apply p-4 bg-white rounded-lg shadow-md;
}

.notify-card-title {
    @apply text-xl font-bold mb-4;
}

.notify-card-body {
    @apply space-y-4;
}
```

### 2.2 Riutilizzabilità
```php
// Componente base riutilizzabile
// resources/views/components/base/button.blade.php
@props([
    'variant' => 'primary',
    'size' => 'md',
])

@php
    $baseClasses = 'notify-btn';
    $variantClasses = [
        'primary' => 'notify-btn-primary',
        'secondary' => 'notify-btn-secondary',
    ];
    $sizeClasses = [
        'sm' => 'notify-btn-sm',
        'md' => 'notify-btn-md',
        'lg' => 'notify-btn-lg',
    ];
@endphp

<button {{ $attributes->merge(['class' => "{$baseClasses} {$variantClasses[$variant]} {$sizeClasses[$size]}"]) }}>
    {{ $slot }}
</button>

// resources/css/components/button.css
.notify-btn {
    @apply inline-flex items-center justify-center rounded-md font-medium transition-colors duration-200;
}

.notify-btn-primary {
    @apply bg-notify-600 text-white hover:bg-notify-700 focus:ring-notify-500;
}

.notify-btn-sm {
    @apply px-2 py-1 text-sm;
}
```

## 3. Responsive Design

### 3.1 Mobile First
```php
// BAD
<div class="w-1/2 md:w-full">
    <!-- Content -->
</div>

// GOOD
<div class="w-full md:w-1/2">
    <!-- Content -->
</div>

// Breakpoint Consistency
$breakpoints: {
    'sm': '640px',
    'md': '768px',
    'lg': '1024px',
    'xl': '1280px',
    '2xl': '1536px',
}
```

### 3.2 Container Queries
```php
// resources/views/components/responsive-card.blade.php
<div class="@container">
    <div class="@lg:grid @lg:grid-cols-2 gap-4">
        <div class="notify-card-content">
            {{ $content }}
        </div>
        <div class="notify-card-sidebar">
            {{ $sidebar }}
        </div>
    </div>
</div>
```

## 4. Performance

### 4.1 Ottimizzazione delle Classi
```javascript
// tailwind.config.js
module.exports = {
    content: [
        './Modules/Notify/**/*.{php,html,js,jsx,ts,tsx,vue}',
    ],
    options: {
        safelist: [
            'notify-btn-primary',
            'notify-btn-secondary',
        ],
    },
}
```

### 4.2 Caching e Build
```javascript
// vite.config.js
export default defineConfig({
    build: {
        cssMinify: true,
        cssCodeSplit: true,
        rollupOptions: {
            output: {
                manualChunks: {
                    notify: [
                        './Modules/Notify/resources/css/components/**/*.css',
                    ],
                },
            },
        },
    },
})
```

## 5. Accessibilità

### 5.1 Contrasto e Colori
```css
/* resources/css/utilities/colors.css */
:root {
    --notify-primary: #3B82F6;
    --notify-primary-dark: #1D4ED8;
    --notify-primary-light: #60A5FA;
}

.notify-text-primary {
    @apply text-notify-600 dark:text-notify-400;
}

/* Contrasto minimo 4.5:1 per testo normale */
.notify-text-body {
    @apply text-gray-900 dark:text-gray-100;
}
```

### 5.2 Focus e Interazioni
```php
// resources/views/components/accessible-button.blade.php
<button
    {{ $attributes->merge([
        'class' => 'notify-btn focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-notify-500',
        'role' => 'button',
        'aria-pressed' => 'false',
    ]) }}
>
    <span class="sr-only">{{ $srText }}</span>
    {{ $slot }}
</button>
```

## 6. Testing

### 6.1 Visual Regression Testing
```php
// tests/Browser/Components/ButtonTest.php
class ButtonTest extends DuskTestCase
{
    /** @test */
    public function button_styles_are_consistent()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/components/button')
                    ->assertPresent('.notify-btn-primary')
                    ->assertCssValue('.notify-btn-primary', 'background-color', 'rgb(37, 99, 235)');
        });
    }
}
```

### 6.2 Accessibility Testing
```php
// tests/Feature/Components/ButtonTest.php
class ButtonTest extends TestCase
{
    /** @test */
    public function button_has_correct_aria_attributes()
    {
        $view = $this->blade(
            '<x-notify::button sr-text="Test Button">Click me</x-notify::button>'
        );

        $view->assertSee('role="button"', false);
        $view->assertSee('class="sr-only"', false);
    }
}
```

## 7. Documentazione

### 7.1 Storybook
```javascript
// .storybook/main.js
module.exports = {
    stories: [
        '../Modules/Notify/**/*.stories.@(js|jsx|ts|tsx)',
    ],
    addons: [
        '@storybook/addon-links',
        '@storybook/addon-essentials',
        '@storybook/addon-a11y',
    ],
}
```

### 7.2 Esempi e Pattern
```php
// docs/examples/button-variants.md

# Varianti Bottoni

## Primario
```html
<x-notify::button variant="primary">
    Bottone Primario
</x-notify::button>
```

## Secondario con Icona
```html
<x-notify::button variant="secondary" icon="heroicon-o-plus">
    Bottone con Icona
</x-notify::button>
```
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
Per contribuire alla documentazione, seguire le [Linee Guida](../../../project_docs/linee-guida-documentazione.md) e le [Regole dei Collegamenti](../../../project_docs/regole_collegamenti_documentazione.md).
Per una lista completa di tutti i collegamenti tra i README.md, consultare il file [README_links.md](../../../docs/README_links.md). Per contribuire alla documentazione, seguire le [Linee Guida](../../../project_docs/linee-guida-documentazione.md) e le [Regole dei Collegamenti](../../../project_docs/regole_collegamenti_documentazione.md).

## Collegamenti Completi
Per una lista completa di tutti i collegamenti tra i README.md, consultare il file [README_links.md](../../../project_docs/README_links.md). 
