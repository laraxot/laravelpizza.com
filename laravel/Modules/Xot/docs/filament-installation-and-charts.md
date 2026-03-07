# Filament 5.x Installation and Chart Widget Guide

## Overview

This document provides comprehensive guidance on Filament 5.x installation and ChartWidget implementation following Laraxot architectural patterns. The project follows strict conventions to ensure consistency and maintainability.

## ⚠️ CRITICAL: Filament 5.x Requirements

The project requires:
- PHP 8.2+
- Laravel v11.28+
- **Tailwind CSS v4.1+** (⚠️ **CRITICAL** - Filament 5.x requires v4.1+, NOT compatible with v3.x)
- Filament v5.0+

**⚠️ IMPORTANT**: Tailwind CSS v3.x is **NOT compatible** with Filament 5.x. All modules and themes must use Tailwind CSS v4.1+.

### Panel Builder Installation

For panel-based applications, install using:

```bash
composer require filament/filament:"^5.0"
php artisan filament:install --panels
```

This creates a service provider at `app/Providers/Filament/AdminPanelProvider.php`.

For Windows PowerShell users:
```bash
composer require filament/filament:"~5.0"
php artisan filament:install --panels
```

### Individual Components Installation

For Blade-based applications, install specific components:

```bash
composer require
    filament/tables:"^5.0"
    filament/schemas:"^5.0"
    filament/forms:"^5.0"
    filament/infolists:"^5.0"
    filament/actions:"^5.0"
    filament/notifications:"^5.0"
    filament/widgets:"^5.0"
```

For Windows PowerShell users:
```bash
composer require
    filament/tables:"~5.0"
    filament/schemas:"~5.0"
    filament/forms:"~5.0"
    filament/infolists:"~5.0"
    filament/actions:"~5.0"
    filament/notifications:"~5.0"
    filament/widgets:"~5.0"
```

## Frontend Asset Installation

### Installing Tailwind CSS v4.1+

**⚠️ CRITICO**: Filament 5.x richiede Tailwind CSS v4.1+. La versione v3.x **NON è compatibile**.

```bash
npm install tailwindcss@^4.1.0 @tailwindcss/vite@^4.1.0 --save-dev
```

**⚠️ IMPORTANTE**: Specificare esplicitamente la versione `^4.1.0` per garantire compatibilità con Filament 5.x.

### Vite Configuration

Configure your Vite configuration (`vite.config.js`) with the Tailwind CSS plugin:

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

### CSS Configuration

Import Filament CSS files in `resources/css/app.css`:

```css
@import 'tailwindcss';
/* Required by all components */
@import '../../vendor/filament/support/resources/css/index.css';
/* Required by actions and tables */
@import '../../vendor/filament/actions/resources/css/index.css';
/* Required by actions, forms and tables */
@import '../../vendor/filament/forms/resources/css/index.css';
/* Required by actions and infolists */
@import '../../vendor/filament/infolists/resources/css/index.css';
/* Required by notifications */
@import '../../vendor/filament/notifications/resources/css/index.css';
/* Required by actions, infolists, forms, schemas and tables */
@import '../../vendor/filament/schemas/resources/css/index.css';
/* Required by tables */
@import '../../vendor/filament/tables/resources/css/index.css';
/* Required by widgets */
@import '../../vendor/filament/widgets/resources/css/index.css';
@variant dark (&:where(.dark, .dark *));
```

### Layout Configuration

Add Filament styles and scripts to your layout file:

```html
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="application-name" content="{{ config('app.name') }}">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>{{ config('app.name') }}</title>
        <style>
            [x-cloak] {
                display: none !important;
            }
        </style>
        @filamentStyles
        @vite('resources/css/app.css')
    </head>
    <body class="antialiased">
        {{ $slot }}
        @livewire('notifications') {{-- Only required if you wish to send flash notifications --}}
        @filamentScripts
        @vite('resources/js/app.js')
    </body>
</html>
```

## Chart Widget Installation and Configuration

### Chart.js Dependencies

Install Chart.js and related plugins for advanced charting capabilities:

```bash
npm install chart.js chartjs-plugin-datalabels chartjs-plugin-annotation chartjs-plugin-zoom --save-dev
```

The project already includes these dependencies in the Chart module's `package.json`.

### ChartWidget Implementation

#### ❌ NEVER extend Filament's ChartWidget directly
```php
use Filament\Widgets\ChartWidget;

class MyChart extends ChartWidget { } // WRONG!
```

#### ✅ ALWAYS extend XotBaseChartWidget
```php
use Modules\Xot\Filament\Widgets\XotBaseChartWidget;

class MyChartWidget extends XotBaseChartWidget { } // CORRECT!
```

### XotBaseChartWidget Structure

The base chart widget provides the following structure:

```php
<?php

declare(strict_types=1);

namespace Modules\Xot\Filament\Widgets;

use Filament\Widgets\ChartWidget as FilamentChartWidget;
use Filament\Widgets\Concerns\InteractsWithPageFilters;
use Modules\Xot\Filament\Traits\TransTrait;

abstract class XotBaseChartWidget extends FilamentChartWidget
{
    use InteractsWithPageFilters;
    use TransTrait;

    protected ?string $heading = null;
    protected static ?int $sort = 1;
    protected static bool $isLazy = true;
    protected ?string $pollingInterval = null;

    public function getHeading(): ?string { /* ... */ }
    protected function getData(): array { /* ... */ }
    protected function getType(): string { /* ... */ }
    protected function getOptions(): array { /* ... */ }
    protected function getHeight(): ?string { /* ... */ }
}
```

### Implementing Custom ChartWidgets

```php
<?php

declare(strict_types=1);

namespace Modules\YourModule\Filament\Widgets;

use Modules\Xot\Filament\Widgets\XotBaseChartWidget;

class YourChartWidget extends XotBaseChartWidget
{
    protected static ?string $heading = 'Your Chart';

    protected function getData(): array
    {
        return [
            'datasets' => [
                [
                    'label' => 'Sample Data',
                    'data' => [10, 20, 30, 40],
                ],
            ],
            'labels' => ['Jan', 'Feb', 'Mar', 'Apr'],
        ];
    }

    protected function getType(): string
    {
        return 'line'; // or 'bar', 'doughnut', 'pie', etc.
    }
}
```

### Chart.js Plugin Configuration (Filament 5.x)

**⚠️ IMPORTANTE**: Filament 5.x usa il pattern `window.filamentChartJsPlugins` (NON `Chart.register()`).

To use advanced Chart.js plugins, create a JavaScript file to register them:

**Pattern Corretto** (✅ USARE):

```javascript
// resources/js/filament-chart-js-plugins.js
import annotationPlugin from 'chartjs-plugin-annotation';
import zoomPlugin from 'chartjs-plugin-zoom';
import ChartDataLabels from 'chartjs-plugin-datalabels';

// ✅ Inizializza array se non esiste (nullish coalescing assignment)
window.filamentChartJsPlugins ??= [];

// ✅ Registra plugin
window.filamentChartJsPlugins.push(annotationPlugin, zoomPlugin, ChartDataLabels);

// ✅ Per plugin globali (Chart.register), usare:
window.filamentChartJsGlobalPlugins ??= [];
window.filamentChartJsGlobalPlugins.push(ChartDataLabels);
```

**Pattern Legacy** (❌ NON USARE):

```javascript
// ❌ ERRATO - NON registrare direttamente con Chart.register()
import Chart from 'chart.js/auto';
Chart.register(ChartDataLabels);  // ❌ NON funziona con Filament 5.x
```

Include this file in your Vite configuration:

```javascript
import tailwindcss from '@tailwindcss/vite';  // ✅ Tailwind v4.1+

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/css/app.css',
                'resources/js/app.js',
                'resources/js/filament-chart-js-plugins.js', // ✅ Aggiungere qui
            ],
            refresh: true,
        }),
        tailwindcss(),  // ✅ Plugin Vite per Tailwind v4
    ],
});
```

**Registrare Asset in PanelProvider**:

**⚠️ REGOLA CRITICA: Centralizzazione Asset Chart**

**Le configurazioni JS/CSS per Chart.js plugins DEVONO essere registrate SOLO nel modulo Chart.**

```php
// ✅ CORRETTO - Modules/Chart/app/Providers/Filament/AdminPanelProvider.php

use Filament\Support\Facades\FilamentAsset;
use Filament\Support\Assets\Js;
use Filament\Support\Assets\Css;
use Illuminate\Support\Facades\Vite;

public function panel(Panel $panel): Panel
{
    $panel = parent::panel($panel);
    
    // ✅ CORRETTO: Registrazione centralizzata nel modulo Chart
    FilamentAsset::register([
        Js::make('chart-js-plugins', Vite::asset('resources/js/filament-chart-js-plugins.js', 'assets/chart'))->module(),
        Css::make('chart-js-plugins', Vite::asset('resources/css/app.css', 'assets/chart')),
    ]);
    
    return $panel;
}
```

```php
// ❌ ERRATO - NON registrare asset chart in altri moduli
// Modules/healthcare_app/app/Providers/Filament/AdminPanelProvider.php
// Modules/UI/app/Providers/Filament/AdminPanelProvider.php
// Themes/Zero/app/Providers/Filament/AdminPanelProvider.php

public function panel(Panel $panel): Panel
{
    $panel = parent::panel($panel);
    
    // ❌ NON fare questo - causa duplicazioni e conflitti
    // FilamentAsset::register([
    //     Js::make('chart-js-plugins', Vite::asset('resources/js/filament-chart-js-plugins.js', 'assets/healthcare_app'))->module(),
    // ]);
    
    return $panel;
}
```

**Motivazione Architetturale:**
- **DRY**: Un'unica fonte di verità per tutti gli asset chart
- **KISS**: Configurazione semplice e centralizzata
- **Coerenza**: Tutti i moduli ereditano automaticamente gli asset chart

Per dettagli completi, vedere [chart-assets-centralization-rule.md](../../chart/docs/chart-assets-centralization-rule.md).

## Configuration Files

Publish Filament configuration after installation:

```bash
php artisan vendor:publish --tag=filament-config
```

This creates `config/filament.php` with default settings for filesystem disks, file generation flags, and UI defaults.

## Layout Blade Configuration

### Pattern Corretto (✅ USARE)

```blade
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="application-name" content="{{ config('app.name') }}">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>{{ config('app.name') }}</title>

        <style>
            [x-cloak] {
                display: none !important;
            }
        </style>

        @filamentStyles  {{-- ✅ Filament 5.x styles --}}
        @vite('resources/css/app.css')
    </head>

    <body class="antialiased">
        {{ $slot }}

        @livewire('notifications')  {{-- Solo se Notifications package installato --}}

        @filamentScripts  {{-- ✅ Filament 5.x scripts --}}
        @vite('resources/js/app.js')
    </body>
</html>
```

## Key Architectural Rules

1. **CRITICAL**: Always extend `Modules\Xot\Filament\Widgets\XotBaseChartWidget` for charts - NEVER extend Filament's ChartWidget directly.
2. **CRITICAL**: Filament 5.x requires Tailwind CSS v4.1+ - NOT compatible with v3.x
3. **CRITICAL**: Chart.js plugins must use `window.filamentChartJsPlugins` pattern - NEVER use `Chart.register()` directly
4. **Type Safety**: Use proper return types in all methods
5. **Translation**: Use TransTrait for proper localization
6. **Caching**: Implement appropriate caching strategies for chart data
7. **Performance**: Use lazy loading (`static bool $isLazy = true`) for performance
8. **Polling**: Set appropriate polling intervals if needed

## Multi-module Considerations

The project uses a modular architecture where:
- Each module can have its own chart implementations
- All chart widgets must extend the common XotBaseChartWidget
- Shared chart functionality is provided by the Xot module
- Module-specific chart configurations are handled through the module's service provider

## Security Considerations

- Validate all chart data inputs
- Implement proper authorization for chart access
- Sanitize chart labels and data to prevent XSS
- Use appropriate caching strategies to prevent resource exhaustion

## Performance Optimization

- Implement proper caching for chart data
- Use lazy loading for charts on dashboard pages
- Optimize queries used to generate chart data
- Consider pagination for large datasets
- Implement proper error handling for chart rendering failures

## Filament 5.x Specific Requirements

### Tailwind CSS v4.1+

- **Installation**: `npm install tailwindcss@^4.1.0 @tailwindcss/vite@^4.1.0 --save-dev`
- **Vite Plugin**: Use `tailwindcss()` plugin (NOT PostCSS config)
- **CSS Import**: Use `@import 'tailwindcss'` (NOT `@tailwind` directives)

### Chart.js Plugins

- **Registration**: Use `window.filamentChartJsPlugins ??= []` pattern
- **Asset Registration**: Register in PanelProvider with `FilamentAsset::register()`
- **Vite Config**: Include plugin JS file in `input` array

## Documentazione Completa

Per guide dettagliate, consultare:
- [Chart Module Installation Guide](../../chart/docs/filament-5-installation-guide.md)
- [Filament 5.x Requirements](./filament-5-requirements.md)
- [Filament 5.x Official Docs](https://filamentphp.com/docs/5.x/introduction/installation)