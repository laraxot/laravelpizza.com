# 🎨 FILAMENT V5 SETUP GUIDE - Base Predict Fila5

**Version**: 5.x  
**Last Updated**: 2026-03-21  
**Status**: ✅ INSTALLED - Livewire v4 + Filament v5  
**Migration**: Da Filament v3 → v5 COMPLETATA  

---

## 📋 REQUISITI FILAMENT V5

| Requisito | Versione Richiesta | Stato Attuale |
|-----------|-------------------|---------------|
| **PHP** | 8.2+ | ✅ 8.3.30 |
| **Laravel** | 11.28+ | ✅ 12.55.1 |
| **Tailwind CSS** | 4.1+ | ✅ 4.x (vite plugin) |
| **Livewire** | 3.0+ | ✅ 4.1.4 |
| **Vite** | 5.0+ | ✅ Installato |

---

## 🚀 INSTALLAZIONE COMPLETATA

### Composer Packages Installati

**Root composer.json** (`laravel/composer.json`):
```json
{
  "require": {
    "filament/actions": "^5.0",
    "filament/filament": "^5.0",
    "filament/forms": "^5.0",
    "filament/infolists": "^5.0",
    "filament/notifications": "^5.0",
    "filament/schemas": "^5.0",
    "filament/support": "^5.0",
    "filament/tables": "^5.0",
    "filament/widgets": "^5.0"
  }
}
```

**Moduli** (esempio: `Modules/User/composer.json`):
```json
{
  "require": {
    "filament/actions": "^5.0",
    "filament/tables": "^5.0"
  }
}
```

---

## 🎨 CSS SETUP (Tailwind v4 + Vite)

### File CSS Principale

**File**: `Themes/TwentyOne/resources/css/app.css`

```css
@import "tailwindcss";

@source "../../Modules/**/resources/views/**/*.blade.php";
@source "./resources/views/**/*.blade.php";
@source "../../resources/views/**/*.blade.php";

/* Filament v5 CSS Imports */
@import '../../../vendor/filament/support/resources/css/index.css';
@import '../../../vendor/filament/actions/resources/css/index.css';
@import '../../../vendor/filament/forms/resources/css/index.css';
@import '../../../vendor/filament/infolists/resources/css/index.css';
@import '../../../vendor/filament/notifications/resources/css/index.css';
@import '../../../vendor/filament/schemas/resources/css/index.css';
@import '../../../vendor/filament/tables/resources/css/index.css';
@import '../../../vendor/filament/widgets/resources/css/index.css';

@variant dark (&:where(.dark, .dark *));

/* Custom theme variables */
:root {
    --ag-pointer-x: 50%;
    --ag-pointer-y: 50%;
}

/* Kinetic Cinematic Enhancements */
/* ... animazioni custom ... */
```

### Vite Configuration

**File**: `Themes/TwentyOne/vite.config.js`

```javascript
import { defineConfig } from 'vite'
import laravel from 'laravel-vite-plugin'
import tailwindcss from '@tailwindcss/vite'

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/css/app.css',
                'resources/js/app.js'
            ],
            refresh: true,
        }),
        tailwindcss(),
    ],
})
```

### Build Assets

```bash
# Development (con hot reload)
cd Themes/TwentyOne
npm run dev

# Production build
npm run build
```

**Output**:
- `Themes/TwentyOne/public/assets/app-*.css`
- `Themes/TwentyOne/public/assets/app-*.js`
- `Themes/TwentyOne/public/manifest.json`

---

## 🏗️ LAYOUT CONFIGURATION

### Layout Principale

**File**: `Themes/TwentyOne/resources/views/components/layouts/app.blade.php`

```blade
<x-layouts.main :title="$title" :meta-description="$metaDescription" body-class="bg-slate-950">

    {{-- SEO Meta Tags --}}
    @push('head')
        <!-- Meta, OG, Twitter Card, etc. -->
    @endpush

    {{-- Header Navigation --}}
    <x-section slug="header" />

    {{-- Main Content --}}
    {{ $slot }}

    {{-- Footer --}}
    <x-section slug="footer" />

    {{-- Livewire Notifications --}}
    @livewire('notifications')

    {{-- Scripts --}}
    @push('scripts')
        <!-- Cookie consent, etc. -->
    @endpush

</x-layouts.app>
```

### Layout Base (main.blade.php)

**File**: `Themes/TwentyOne/resources/views/components/layouts/main.blade.php`

```blade
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ $title }}</title>

        @stack('head')

        {{-- Vite + Tailwind CSS v4 --}}
        @vite(['resources/css/app.css'], 'themes/TwentyOne')

        {{-- Filament Styles --}}
        @filamentStyles
        @livewireStyles
    </head>

    <body class="{{ $bodyClass }} antialiased text-base leading-relaxed bg-slate-950 text-slate-100">
        {{-- Skip to Content (WCAG 2.2 AA) --}}
        <a href="#main-content" class="sr-only focus:not-sr-only">
            {{ __('predict::predict.labels.navigation.skip_to_content') }}
        </a>

        {{-- Main Content --}}
        <main id="main-content" role="main" tabindex="-1">
            {{ $slot }}
        </main>

        {{-- Scripts --}}
        @vite(['resources/js/app.js'], 'themes/TwentyOne')

        @filamentScripts
        @livewireScripts

        @stack('scripts')
    </body>
</html>
```

---

## 📦 COMPONENTI FILAMENT DISPONIBILI

### 1. Tables Widget

**Package**: `filament/tables`

**Usage**:
```php
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;
use Modules\Xot\Filament\Widgets\XotBaseTableWidget;

class PredictTableWidget extends XotBaseTableWidget
{
    public function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('title')->sortable()->searchable(),
            ])
            ->filters([...])
            ->paginated([12, 24, 48]);
    }
}
```

**View**:
```blade
@livewire(\Modules\Predict\Filament\Widgets\PredictTableWidget::class)
```

---

### 2. Forms

**Package**: `filament/forms`

**Usage**:
```php
use Filament\Forms\Form;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Concerns\InteractsWithForms;

class MyComponent extends Component implements FormsContract
{
    use InteractsWithForms;
    
    public ?array $data = [];
    
    public function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('name')->required(),
            ])
            ->statePath('data');
    }
}
```

---

### 3. Actions

**Package**: `filament/actions`

**Usage**:
```php
use Filament\Actions\Action;

public function deleteAction(): Action
{
    return Action::make('delete')
        ->requiresConfirmation()
        ->modalHeading('Confirm Delete')
        ->action(function () {
            // Delete logic
        });
}
```

---

### 4. Notifications

**Package**: `filament/notifications`

**Usage**:
```php
use Filament\Notifications\Notification;

Notification::make()
    ->title('Success!')
    ->body('Operation completed successfully.')
    ->success()
    ->send();
```

**Layout requirement**:
```blade
@livewire('notifications')
```

---

### 5. Widgets

**Package**: `filament/widgets`

**Usage**:
```php
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class StatsOverviewWidget extends BaseWidget
{
    protected function getStats(): array
    {
        return [
            Stat::make('Total Users', '1,234'),
            Stat::make('Revenue', '$56,789'),
        ];
    }
}
```

---

### 6. Infolists

**Package**: `filament/infolists`

**Usage**:
```php
use Filament\Infolists\Infolist;
use Filament\Infolists\Components\TextEntry;

public function infolist(Infolist $infolist): Infolist
{
    return $infolist
        ->schema([
            TextEntry::make('name'),
            TextEntry::make('email'),
        ]);
}
```

---

## 🔧 CONFIGURAZIONE

### Publish Config (Optional)

```bash
php artisan vendor:publish --tag=filament-config
```

**File**: `config/filament.php`

```php
return [
    'default_filesystem_disk' => env('FILAMENT_FILESYSTEM_DISK', 'public'),
    'generate_assets' => false,
];
```

---

## 🎯 BEST PRACTICES PER IL PROGETTO

### 1. XotBase Wrappers

**REGOLA**: Tutti i widget Filament DEVONO estendere le classi XotBase

```php
// ✅ CORRETTO
use Modules\Xot\Filament\Widgets\XotBaseTableWidget;

class PredictTableWidget extends XotBaseTableWidget
{
    // ...
}

// ❌ SBAGLIATO
use Filament\Widgets\TableWidget;

class PredictTableWidget extends TableWidget  // NO!
{
    // ...
}
```

**Perché**:
- ✅ Consistenza architetturale
- ✅ Funzionalità aggiuntive Laraxot
- ✅ Gestione connection multi-db
- ✅ Traduzioni automatiche

---

### 2. CSS Imports Order

**Ordine corretto** (IMPORTANTE per cascade CSS):

```css
1. @import "tailwindcss";
2. @import 'filament/support/...'
3. @import 'filament/actions/...'
4. @import 'filament/forms/...'
5. @import 'filament/infolists/...'
6. @import 'filament/notifications/...'
7. @import 'filament/schemas/...'
8. @import 'filament/tables/...'
9. @import 'filament/widgets/...'
10. Custom styles
```

---

### 3. Layout Directives

**Posizione corretta**:

```blade
<head>
    @vite(['resources/css/app.css'], 'themes/TwentyOne')
    @filamentStyles     <!-- DOPO vite CSS -->
    @livewireStyles     <!-- DOPO filamentStyles -->
</head>

<body>
    <!-- Content -->
    
    @vite(['resources/js/app.js'], 'themes/TwentyOne')
    @filamentScripts    <!-- DOPO vite JS -->
    @livewireScripts    <!-- DOPO filamentScripts -->
    @livewire('notifications')  <!-- SOLO se serve -->
</body>
```

---

### 4. Module-Specific CSS

**Per moduli che usano Filament**:

Ogni modulo può avere il proprio CSS:

```css
/* Modules/Predict/resources/css/predict.css */

/* Predict-specific Filament overrides */
.fi-ta-content-grid {
    gap: 1.5rem;
}

/* Custom Predict styles */
.predict-card {
    @apply rounded-2xl bg-white/5 backdrop-blur-sm;
}
```

**Import in app.css**:
```css
@import '../../Modules/Predict/resources/css/predict.css';
```

---

## 🐛 TROUBLESHOOTING

### 1. Filament Styles Not Loading

**Sintomi**: Tabelle senza style, bottoni non stilizzati

**Soluzioni**:
```bash
# 1. Verifica npm run dev in esecuzione
cd Themes/TwentyOne
npm run dev

# 2. Pulisci cache
php artisan view:clear
php artisan config:clear

# 3. Verifica @filamentStyles nel layout
grep -r "@filamentStyles" Themes/TwentyOne/resources/views/
```

---

### 2. Livewire Components Not Working

**Sintomi**: Click non rispondono, AJAX non funziona

**Soluzioni**:
```bash
# 1. Verifica Livewire v4 installato
composer show livewire/livewire | grep versions

# 2. Verifica @livewireScripts
grep -r "@livewireScripts" Themes/TwentyOne/resources/views/

# 3. Clear cache
php artisan livewire:clear
php artisan view:clear
```

---

### 3. CSS Conflicts con Tailwind

**Sintomi**: Style di Filament sovrascritti da Tailwind

**Soluzione**:
```css
/* Assicurati che Filament CSS sia importato DOPO Tailwind */
@import "tailwindcss";
@import '../../../vendor/filament/...';  /* DOPO */
```

---

### 4. Search Icon Spacing Issue

**Sintomi**: Icona lente occupa troppo spazio

**Soluzione**:
```blade
<!-- CORRETTO: Icona con dimensioni fisse -->
<x-heroicon-o-magnifying-glass class="w-5 h-5 text-slate-400" />

<!-- SBAGLIATO: Icona senza classi -->
<x-heroicon-o-magnifying-glass />
```

---

## 📊 CHECKLIST INSTALLAZIONE TEMI

### TwentyOne Theme Checklist

- [x] ✅ `composer.json` con Filament v5 packages
- [x] ✅ `resources/css/app.css` con Filament imports
- [x] ✅ `vite.config.js` con Tailwind v4 plugin
- [x] ✅ `resources/views/components/layouts/main.blade.php` con:
  - [x] `@vite(['resources/css/app.css'])`
  - [x] `@filamentStyles`
  - [x] `@livewireStyles`
  - [x] `@vite(['resources/js/app.js'])`
  - [x] `@filamentScripts`
  - [x] `@livewireScripts`
  - [x] `@livewire('notifications')`
- [x] ✅ `public/manifest.json` generato
- [x] ✅ `public/assets/app-*.css` compilato
- [x] ✅ `public/assets/app-*.js` compilato

---

## 🔗 RIFERIMENTI

### Documentazione Ufficiale
- [Filament v5 Docs](https://filamentphp.com/docs/5.x)
- [Installation Guide](https://filamentphp.com/docs/5.x/introduction/installation)
- [Individual Components](https://filamentphp.com/docs/5.x/support/individual-components)

### Documentazione Progetto
- `docs/project/VOLT_CLASS_BASED_COMPONENTS.md`
- `docs/project/FILAMENT_WIDGETS_FOR_LISTS_RULE.md`
- `Modules/Predict/docs/FILAMENT_TABLE_FEATURES_IMPLEMENTED.md`

### GitHub Issues
- [Filament v5 Migration](https://github.com/laraxot/base_predict_fila5/issues/TBD)

---

## 🎯 NEXT STEPS

### Per i Sviluppatori

1. ✅ Leggere questa documentazione
2. ✅ Verificare che tutti i temi abbiano Filament setup corretto
3. ✅ Usare SEMPRE XotBase wrappers
4. ✅ Rispettare CSS import order
5. ✅ Testare in browser dopo ogni modifica

### Per il Progetto

1. [ ] Audit completo di tutti i temi (Sixteen, Seventeen, etc.)
2. [ ] Creare template layout standardizzato
3. [ ] Documentare ogni modulo che usa Filament
4. [ ] Creare GitHub Issue per eventuali fix

---

**Creato**: 2026-03-21  
**Stato**: ✅ COMPLETATO  
**Review**: Dopo audit completo di tutti i temi  

---

## 📝 NOTE IMPORTANTI

### ⚠️ REGOLA D'ORO: XotBase Wrappers

**MAI** usare direttamente le classi Filament:
```php
// ❌ NO
extends TableWidget
extends FormWidget
extends StatsOverviewWidget

// ✅ SI
extends XotBaseTableWidget
extends XotBaseFormWidget
extends XotBaseStatsOverviewWidget
```

### ⚠️ CSS Bundle Size

Importare SOLO i CSS dei package usati:
```css
/* Se usi SOLO Tables */
@import '../../../vendor/filament/support/...';
@import '../../../vendor/filament/actions/...';
@import '../../../vendor/filament/tables/...';

/* NON importare forms, infolists, etc. se non li usi */
```

### ⚠️ Vite Hot Reload

In sviluppo, tenere SEMPRE attivo:
```bash
cd Themes/TwentyOne
npm run dev
```

Senza `npm run dev`, le modifiche CSS/JS non sono visibili!

---

**Fine Documentazione**
