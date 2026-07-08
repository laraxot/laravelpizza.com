# Theme Analysis - Theme One

**Date**: 2025-01-02  
**Status**: 📊 Analysis Complete  
**Framework**: Laravel 11 + Livewire 3 + Filament 3

---

## 📋 Executive Summary

Il tema One risulta attualmente in fase minima di sviluppo. La struttura contiene solo la cartella documentazione. Questa analisi fornisce linee guida per lo sviluppo futuro e l'integrazione con il sistema Laraxot.

---

## 🏗️ Struttura Attuale

### Directory Layout

```
Themes/One/
├── docs/
│   ├── README.md (vuoto)
│   ├── code-quality-tools.md
│   ├── common-errors.md
│   ├── links.md
│   └── namespace-conventions.md
```

### Status: Minimale

Il tema attualmente non contiene:
- ❌ Views/Blade templates
- ❌ Assets (CSS/JS)
- ❌ Components Livewire
- ❌ Configurazione
- ❌ Provider

---

## 🎯 Struttura Raccomandata per Temi Laraxot

### Layout Ideale

```
Themes/{ThemeName}/
├── resources/
│   ├── views/
│   │   ├── layouts/
│   │   │   ├── app.blade.php
│   │   │   ├── guest.blade.php
│   │   │   └── admin.blade.php
│   │   ├── components/
│   │   │   ├── header.blade.php
│   │   │   ├── footer.blade.php
│   │   │   ├── sidebar.blade.php
│   │   │   └── navigation.blade.php
│   │   └── partials/
│   │       ├── head.blade.php
│   │       ├── scripts.blade.php
│   │       └── styles.blade.php
│   ├── css/
│   │   ├── app.css
│   │   └── theme.css
│   ├── js/
│   │   ├── app.js
│   │   └── theme.js
│   └── assets/
│       ├── images/
│       ├── fonts/
│       └── icons/
├── config/
│   └── theme.php
├── lang/
│   ├── it/
│   ├── en/
│   └── de/
├── docs/
│   ├── README.md
│   ├── installation.md
│   ├── customization.md
│   └── components.md
├── tests/
│   └── Feature/
└── composer.json
```

---

## 📚 Best Practices per Temi

### 1. Separation of Concerns

**✅ DO**: Separare layout, components e partials

```blade
{{-- layouts/app.blade.php --}}
<!DOCTYPE html>
<html>
<head>
    @include('theme-one::partials.head')
    @yield('styles')
</head>
<body>
    @include('theme-one::components.header')
    
    <main>
        @yield('content')
    </main>
    
    @include('theme-one::components.footer')
    @include('theme-one::partials.scripts')
    @yield('scripts')
</body>
</html>
```

**❌ DON'T**: Tutto in un file monolitico

---

### 2. Component Riutilizzabili

**✅ DO**: Creare componenti Blade atomici

```blade
{{-- components/button.blade.php --}}
@props([
    'variant' => 'primary',
    'size' => 'md',
    'type' => 'button',
])

<button 
    type="{{ $type }}"
    {{ $attributes->merge([
        'class' => "btn btn-{$variant} btn-{$size}"
    ]) }}
>
    {{ $slot }}
</button>
```

**Utilizzo**:
```blade
<x-theme-one::button variant="success" size="lg">
    Save Changes
</x-theme-one::button>
```

---

### 3. Asset Management

**✅ DO**: Vite per bundling

```javascript
// vite.config.js
export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/css/app.css',
                'resources/js/app.js',
            ],
            refresh: true,
        }),
    ],
    build: {
        outDir: 'public/build/theme-one',
    },
});
```

**❌ DON'T**: CDN non versionati o webpack

---

### 4. Responsive Design

**✅ DO**: Mobile-first con Tailwind

```blade
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
    {{-- Content --}}
</div>
```

**❌ DON'T**: Fixed widths o desktop-first

---

### 5. Dark Mode Support

**✅ DO**: Implementare dark mode con Tailwind

```blade
<div class="bg-white dark:bg-gray-800 text-gray-900 dark:text-gray-100">
    {{-- Content --}}
</div>
```

**Configuration**:
```javascript
// tailwind.config.js
module.exports = {
    darkMode: 'class', // or 'media'
    // ...
}
```

---

### 6. Localizzazione

**✅ DO**: Tutte le stringhe traducibili

```blade
<h1>{{ __('theme-one::welcome.title') }}</h1>
<p>{{ __('theme-one::welcome.description') }}</p>
```

**File Traduzione**:
```php
// lang/it/welcome.php
return [
    'title' => 'Benvenuto',
    'description' => 'Questo è il tuo dashboard',
];
```

---

### 7. Accessibility (A11y)

**✅ DO**: ARIA labels e semantic HTML

```blade
<nav aria-label="{{ __('theme-one::navigation.main') }}">
    <ul role="menubar">
        <li role="none">
            <a href="/" role="menuitem">
                {{ __('theme-one::navigation.home') }}
            </a>
        </li>
    </ul>
</nav>
```

---

### 8. Performance

**✅ DO**: Lazy loading e optimization

```blade
{{-- Lazy load images --}}
<img 
    src="{{ $image }}" 
    loading="lazy"
    alt="{{ $alt }}"
>

{{-- Defer non-critical scripts --}}
<script src="{{ asset('js/analytics.js') }}" defer></script>
```

---

## 🔧 Configuration Pattern

### Theme Configuration File

```php
// config/theme.php
return [
    'name' => 'One',
    'version' => '1.0.0',
    'author' => 'Laraxot Team',
    
    'layouts' => [
        'default' => 'app',
        'guest' => 'guest',
        'admin' => 'admin',
    ],
    
    'assets' => [
        'css' => [
            'app' => 'build/theme-one/app.css',
            'theme' => 'build/theme-one/theme.css',
        ],
        'js' => [
            'app' => 'build/theme-one/app.js',
            'theme' => 'build/theme-one/theme.js',
        ],
    ],
    
    'features' => [
        'dark_mode' => true,
        'rtl_support' => false,
        'responsive' => true,
    ],
    
    'branding' => [
        'logo' => 'images/logo.svg',
        'favicon' => 'images/favicon.ico',
        'app_name' => env('APP_NAME', 'Laravel'),
    ],
];
```

---

## 🎨 Design System

### Color Palette

```css
/* theme.css */
:root {
    /* Primary */
    --color-primary-50: #eff6ff;
    --color-primary-500: #3b82f6;
    --color-primary-900: #1e3a8a;
    
    /* Success */
    --color-success-50: #f0fdf4;
    --color-success-500: #22c55e;
    --color-success-900: #14532d;
    
    /* Warning */
    --color-warning-50: #fffbeb;
    --color-warning-500: #f59e0b;
    --color-warning-900: #78350f;
    
    /* Danger */
    --color-danger-50: #fef2f2;
    --color-danger-500: #ef4444;
    --color-danger-900: #7f1d1d;
    
    /* Neutral */
    --color-gray-50: #f9fafb;
    --color-gray-500: #6b7280;
    --color-gray-900: #111827;
}

/* Dark mode */
.dark {
    --color-primary-500: #60a5fa;
    --color-gray-900: #f9fafb;
    /* ... altre variazioni */
}
```

---

### Typography

```css
/* theme.css */
body {
    font-family: 'Inter', system-ui, sans-serif;
    font-size: 16px;
    line-height: 1.5;
}

h1 { @apply text-4xl font-bold; }
h2 { @apply text-3xl font-semibold; }
h3 { @apply text-2xl font-semibold; }
h4 { @apply text-xl font-medium; }
h5 { @apply text-lg font-medium; }
h6 { @apply text-base font-medium; }
```

---

### Spacing System

```javascript
// tailwind.config.js
module.exports = {
    theme: {
        extend: {
            spacing: {
                '72': '18rem',
                '84': '21rem',
                '96': '24rem',
            }
        }
    }
}
```

---

## 🧪 Testing Themes

### Feature Tests

```php
<?php

namespace Themes\One\Tests\Feature;

use Tests\TestCase;

class ThemeLayoutTest extends TestCase
{
    /** @test */
    public function it_renders_app_layout_correctly(): void
    {
        $response = $this->get('/');
        
        $response->assertStatus(200);
        $response->assertViewIs('theme-one::layouts.app');
        $response->assertSee('header');
        $response->assertSee('footer');
    }
    
    /** @test */
    public function it_renders_dark_mode_toggle(): void
    {
        $response = $this->get('/');
        
        $response->assertSee('dark-mode-toggle');
    }
}
```

---

### Component Tests

```php
/** @test */
public function button_component_renders_correctly(): void
{
    $view = $this->blade(
        '<x-theme-one::button variant="success">Click Me</x-theme-one::button>'
    );
    
    $view->assertSee('Click Me');
    $view->assertSee('btn-success');
}
```

---

## 📦 Package Structure (Se tema standalone)

### composer.json

```json
{
    "name": "laraxot/theme-one",
    "description": "Modern Laravel theme with Tailwind and Livewire",
    "type": "library",
    "require": {
        "php": "^8.2",
        "laravel/framework": "^11.0",
        "livewire/livewire": "^3.0"
    },
    "require-dev": {
        "phpunit/phpunit": "^10.0",
        "phpstan/phpstan": "^1.10"
    },
    "autoload": {
        "psr-4": {
            "Laraxot\\ThemeOne\\": "src/"
        }
    },
    "extra": {
        "laravel": {
            "providers": [
                "Laraxot\\ThemeOne\\ThemeOneServiceProvider"
            ]
        }
    }
}
```

---

### Service Provider

```php
<?php

namespace Laraxot\ThemeOne;

use Illuminate\Support\ServiceProvider;

class ThemeOneServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        // Load views
        $this->loadViewsFrom(__DIR__.'/../resources/views', 'theme-one');
        
        // Load translations
        $this->loadTranslationsFrom(__DIR__.'/../lang', 'theme-one');
        
        // Publish assets
        $this->publishes([
            __DIR__.'/../resources/views' => resource_path('views/vendor/theme-one'),
        ], 'theme-one-views');
        
        $this->publishes([
            __DIR__.'/../config/theme.php' => config_path('theme.php'),
        ], 'theme-one-config');
    }
    
    public function register(): void
    {
        $this->mergeConfigFrom(
            __DIR__.'/../config/theme.php',
            'theme'
        );
    }
}
```

---

## 🔗 Integration con Filament

### Custom Filament Theme

```php
// config/filament.php
return [
    'theme' => [
        'default' => 'theme-one',
        'directory' => resource_path('views/vendor/theme-one'),
    ],
];
```

### Filament Components Override

```blade
{{-- resources/views/vendor/filament/components/button.blade.php --}}
@props([
    'color' => 'primary',
])

<x-theme-one::button 
    :variant="$color"
    {{ $attributes }}
>
    {{ $slot }}
</x-theme-one::button>
```

---

## ✅ Checklist Sviluppo Tema

### Foundation
- [ ] Struttura directory creata
- [ ] Service Provider configurato
- [ ] Configuration file creato
- [ ] Vite setup completato

### Layouts
- [ ] Layout app principale
- [ ] Layout guest
- [ ] Layout admin/dashboard
- [ ] Responsive verificato

### Components
- [ ] Navigation component
- [ ] Header component
- [ ] Footer component
- [ ] Button component
- [ ] Card component
- [ ] Form components
- [ ] Modal component

### Features
- [ ] Dark mode implementation
- [ ] RTL support (se necessario)
- [ ] Multi-language
- [ ] Accessibility (WCAG 2.1 AA)

### Assets
- [ ] CSS compilato
- [ ] JS bundle
- [ ] Images ottimizzate
- [ ] Icons set

### Testing
- [ ] Feature tests layouts
- [ ] Component tests
- [ ] Accessibility tests
- [ ] Performance tests

### Documentation
- [ ] README completo
- [ ] Installation guide
- [ ] Customization guide
- [ ] Component documentation

---

## 📊 Performance Targets

| Metric | Target | Tools |
|--------|--------|-------|
| First Contentful Paint | <1.5s | Lighthouse |
| Largest Contentful Paint | <2.5s | Lighthouse |
| Time to Interactive | <3.5s | Lighthouse |
| Bundle Size (CSS) | <50KB | Webpack Analyzer |
| Bundle Size (JS) | <150KB | Webpack Analyzer |
| Lighthouse Score | >90 | Lighthouse |

---

## 🔗 Riferimenti

### Documentation Links
- [Laravel Blade Components](https://laravel.com/docs/11.x/blade#components)
- [Tailwind CSS](https://tailwindcss.com/docs)
- [Livewire 3](https://livewire.laravel.com/docs/quickstart)
- [Filament Theming](https://filamentphp.com/docs/3.x/panels/themes)

### Related Docs
- [Modules/UI/docs/components.md](../../../laravel/Modules/UI/docs/components.md)
- [Themes/Zero/docs/README.md](../../Zero/docs/README.md)

---

---

**Autore**: AI Assistant  
**Versione**: 1.0  
**Ultimo Aggiornamento**: 2025-01-02

---

## 📄 Html2Pdf Integration nei Temi

### Scopo
I temi possono contenere template PDF personalizzati che utilizzano Html2Pdf per generazione documenti.

### Struttura Template PDF nei Temi

```
Themes/{ThemeName}/
├── resources/
│   ├── views/
│   │   ├── pdf/
│   │   │   ├── layouts/
│   │   │   │   ├── pdf.blade.php          # Layout base PDF
│   │   │   │   └── header-footer.blade.php # Header/footer comuni
│   │   │   ├── templates/
│   │   │   │   ├── report.blade.php       # Template report
│   │   │   │   ├── invoice.blade.php      # Template fattura
│   │   │   │   └── certificate.blade.php  # Template certificato
│   │   │   └── components/
│   │   │       ├── logo.blade.php         # Logo aziendale
│   │   │       ├── signature.blade.php    # Firma digitale
│   │   │       └── watermark.blade.php    # Filigrana
```

### Template PDF Base

```blade
{{-- resources/views/themes/one/pdf/layouts/pdf.blade.php --}}
<page backtop="25mm" backbottom="25mm" backleft="20mm" backright="20mm">
    <page_header>
        <table width="100%" style="border-bottom: 2px solid #0066CC;">
            <tr>
                <td width="70%">
                    @include('themes::one.pdf.components.logo')
                    <h1 style="font-size: 16pt; margin: 5pt 0; color: #0066CC;">
                        {{ $title ?? 'Documento' }}
                    </h1>
                </td>
                <td width="30%" align="right">
                    <p style="font-size: 10pt; margin: 0;">
                        Data: [[date_d/m/Y]]<br>
                        Pagina [[page_cu]] di [[page_nb]]
                    </p>
                </td>
            </tr>
        </table>
    </page_header>

    {{-- Contenuto principale --}}
    <div style="margin: 15mm 0;">
        {{ $slot }}
    </div>

    <page_footer>
        @include('themes::one.pdf.components.footer')
    </page_footer>
</page>
```

### Componenti PDF Tema

#### Logo Component
```blade
{{-- resources/views/themes/one/pdf/components/logo.blade.php --}}
<table width="100%">
    <tr>
        <td width="80%">
            <h2 style="font-size: 14pt; margin: 0; color: #333;">
                {{ config('app.name', 'Sistema') }}
            </h2>
            <p style="font-size: 10pt; margin: 2pt 0; color: #666;">
                Tema One - Documento Ufficiale
            </p>
        </td>
        <td width="20%" align="right">
            {{-- Logo come immagine base64 --}}
            <img src="data:image/png;base64,{{ $logoBase64 ?? '' }}" 
                 style="width: 50mm; height: auto;" />
        </td>
    </tr>
</table>
```

#### Footer Component
```blade
{{-- resources/views/themes/one/pdf/components/footer.blade.php --}}
<table width="100%" style="border-top: 1px solid #CCC; margin-top: 20pt;">
    <tr>
        <td width="60%">
            <p style="font-size: 8pt; margin: 0; color: #666;">
                Questo documento è generato automaticamente dal sistema.<br>
                Tema: One | Versione: {{ config('theme.version', '1.0') }}
            </p>
        </td>
        <td width="40%" align="right">
            <p style="font-size: 8pt; margin: 0; color: #666;">
                Generato il: [[date_d/m/Y H:i]]<br>
                Sistema: {{ config('app.name') }}
            </p>
        </td>
    </tr>
</table>
```

#### Nuove Funzionalità Html2Pdf v5.3.x

##### 🔒 Security Service
```php
// In PdfServiceProvider del tema
$securityService = new ThemeOneSecurityService();
$securityService->addAllowedHost('cdn.theme-one.com');
$html2pdf->setSecurityService($securityService);
```

##### 📄 Classe html2pdf-same-page
```blade
{{-- Previene divisione contenuti --}}
<div class="html2pdf-same-page">
    <table class="theme-one-table">
        <tr><td>Contenuto che rimane unito</td></tr>
    </table>
</div>
```

##### 📝 Supporto Readonly
```blade
{{-- Campi readonly ora supportati --}}
<input type="text" name="version" value="1.0" readonly />
```

##### 🎨 CSS Dinamico
```blade
<style>
    {{-- Styling basato su numero pagina --}}
    .page-[[page_cu]] {
        background: linear-gradient(90deg, #0066CC, #0099FF);
    }
</style>
```

### Best Practices per Temi PDF

#### 1. CSS Inline Only
```blade
{{-- ✅ CORRETTO - Tutto inline --}}
<div style="font-family: Arial; font-size: 12pt; color: #333;">
    <h1 style="font-size: 18pt; text-align: center;">Titolo</h1>
</div>

{{-- ❌ ERRATO - Tag style causano errori --}}
<style>
    .title { font-size: 18pt; }
</style>
```

#### 2. Immagini Base64
```blade
{{-- Converti sempre in base64 --}}
<img src="data:image/png;base64,{{ $logoBase64 }}" />
```

#### 3. Configurazione Centrale
- Usa file di configurazione per colori, font, dimensioni
- Permetti personalizzazione per cliente

### Risorse Utili

- [Documentazione Html2Pdf Ufficiale](https://github.com/spipu/html2pdf)
- [Guida Xot PDF Actions](../../Xot/docs/html2pdf-complete-guide.md)
- [TCPDF Manual](https://tcpdf.org/docs/)

---

**Tema:** One  
**Aggiornamento Html2Pdf:** Gennaio 2026
