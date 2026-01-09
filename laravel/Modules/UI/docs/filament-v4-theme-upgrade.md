# Filament v4 Theme Upgrade Guide - Modulo UI
**Data**: 10 Dicembre 2025
**Modulo**: UI (Theme Components)
**Versione**: 4.0
**Stato**: Ready for Implementation

## 🎨 TAILWIND CSS V4 MIGRATION

### 1. 🚨 CRITICAL: Custom Theme CSS Changes

#### Problema
Filament v4 richiede Tailwind CSS v4 con sintassi completamente diversa.

#### File da Aggiornare
- [ ] `resources/css/filament/theme.css`
- [ ] `tailwind.config.js` → NON PIÙ UTILIZZATO
- [ ] Componenti custom UI

#### ✅ Nuova Sintassi Tailwind v4
```css
/* ❌ VECCHIO - tailwind.config.js */
@import '../../../../vendor/filament/filament/resources/css/theme.css';
@config 'tailwind.config.js';

/* ✅ NUOVO - Tailwind v4 */
@import '../../../../vendor/filament/filament/resources/css/theme.css';
@source '../../../../app/Filament';
@source '../../../../resources/views/filament';
@source '../../../../laravel/Modules/*/resources/views/filament';

/* Configurazione Tailwind v4 in CSS */
@theme {
  /* Colori custom PTVX */
  --color-primary: #3b82f6;
  --color-secondary: #64748b;
  --color-success: #10b981;
  --color-warning: #f59e0b;
  --color-danger: #ef4444;

  /* Font custom */
  --font-family-sans: 'Inter', system-ui, sans-serif;

  /* Spazi custom */
  --spacing-xs: 0.25rem;
  --spacing-sm: 0.5rem;
  --spacing-md: 1rem;
  --spacing-lg: 1.5rem;
  --spacing-xl: 2rem;
}
```

### 2. 🎯 COMPONENTI CUSTOM UI

#### Componenti da Verificare
- [ ] `CardComponent` - Layout con Grid
- [ ] `StatComponent` - Layout responsive
- [ ] `ChartComponent` - Container sizing
- [ ] `TableComponent` - Layout tabelle
- [ ] `FormComponent` - Layout form

#### ✅ Pattern Corretto per Componenti
```php
// CardComponent - Layout corretto v4
class CardComponent extends Component
{
    public function render(): View
    {
        return view('ui::components.card')
            ->with('columnSpanFull', true); // Supporto layout v4
    }
}
```

```blade
<!-- resources/views/components/ui/card.blade.php -->
<div {{ $attributes->merge(['class' => 'bg-white rounded-lg shadow-md p-6']) }}>
    <!-- Layout con supporto columnSpanFull -->
    <div class="space-y-4 {{ $columnSpanFull ? 'col-span-full' : '' }}">
        {{ $slot }}
    </div>
</div>
```

### 3. 🎨 FILAMENT PANEL CUSTOMIZATIONS

#### File di Configurazione
- [ ] `config/filament.php`
- [ ] Panel provider custom
- [ ] Theme configurations

#### ✅ Configurazione Panel v4
```php
// config/filament.php
return [
    'panels' => [
        'default' => [
            'brand' => [
                'name' => 'PTVX',
                'logo' => asset('images/logo-ptvx.png'),
            ],
            'colors' => [
                'primary' => '#3b82f6',
                'secondary' => '#64748b',
                'success' => '#10b981',
                'warning' => '#f59e0b',
                'danger' => '#ef4444',
            ],
            'font' => 'Inter',
            'theme' => [
                'dark' => false,
            ],
        ],
    ],
];
```

### 4. 📱 RESPONSIVE DESIGN UPDATES

#### Breakpoint Changes
Tailwind v4 ha breakpoints di default diversi:

```css
/* ✅ Tailwind v4 breakpoints */
@theme {
  --breakpoint-sm: 640px;
  --breakpoint-md: 768px;
  --breakpoint-lg: 1024px;
  --breakpoint-xl: 1280px;
  --breakpoint-2xl: 1536px;
}
```

#### Componenti Responsive
```blade
<!-- Componente responsive corretto -->
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
    <!-- Cards responsive -->
</div>
```

### 5. 🎯 UI COMPONENTS LIBRARY

#### Componenti Core da Aggiornare
- [ ] `ButtonComponent` - Stili e varianti
- [ ] `InputComponent` - Form styling
- [ ] `ModalComponent` - Layout e overlay
- [ ] `TableComponent` - Layout tabelle
- [ ] `CardComponent` - Layout cards
- [ ] `BadgeComponent` - Stili badge

#### ✅ ButtonComponent v4
```php
// ButtonComponent con supporto v4
class ButtonComponent extends Component
{
    public string $variant = 'primary';
    public string $size = 'md';
    public bool $disabled = false;

    public function render(): View
    {
        return view('ui::components.button');
    }
}
```

```blade
<!-- resources/views/components/ui/button.blade.php -->
<button
    {{ $attributes->merge([
        'class' => match($variant) {
            'primary' => 'bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 px-4 rounded-md transition-colors',
            'secondary' => 'bg-gray-200 hover:bg-gray-300 text-gray-800 font-medium py-2 px-4 rounded-md transition-colors',
            'success' => 'bg-green-600 hover:bg-green-700 text-white font-medium py-2 px-4 rounded-md transition-colors',
            'warning' => 'bg-yellow-600 hover:bg-yellow-700 text-white font-medium py-2 px-4 rounded-md transition-colors',
            'danger' => 'bg-red-600 hover:bg-red-700 text-white font-medium py-2 px-4 rounded-md transition-colors',
            default => 'bg-gray-600 hover:bg-gray-700 text-white font-medium py-2 px-4 rounded-md transition-colors',
        },
        'disabled' => $disabled ? 'opacity-50 cursor-not-allowed' : ''
    ]) }}
>
    {{ $slot }}
</button>
```

### 6. 🎨 THEME CUSTOMIZATIONS

#### Colori PTVX
```css
/* Colori brand PTVX */
@theme {
  --color-ptvx-blue: #1e40af;
  --color-ptvx-blue-light: #3b82f6;
  --color-ptvx-blue-dark: #1e3a8a;

  --color-ptvx-green: #059669;
  --color-ptvx-green-light: #10b981;

  --color-ptvx-orange: #ea580c;
  --color-ptvx-orange-light: #f97316;

  --color-ptvx-red: #dc2626;
  --color-ptvx-red-light: #ef4444;

  --color-ptvx-gray: #374151;
  --color-ptvx-gray-light: #6b7280;
}
```

#### Componenti Brand
```blade
<!-- Logo PTVX -->
<div class="flex items-center space-x-2">
    <div class="w-8 h-8 bg-ptvx-blue rounded-lg flex items-center justify-center">
        <span class="text-white font-bold text-sm">PTV</span>
    </div>
    <span class="text-xl font-semibold text-gray-800">X</span>
</div>
```

### 7. 📱 MOBILE OPTIMIZATIONS

#### Touch Targets
```blade
<!-- Touch targets ottimizzati per mobile -->
<button class="min-h-[44px] min-w-[44px] p-4 md:p-2">
    <!-- Icona o testo -->
</button>
```

#### Responsive Typography
```css
/* Tipografia responsive */
@theme {
  --font-size-xs: clamp(0.75rem, 0.7rem + 0.25vw, 0.875rem);
  --font-size-sm: clamp(0.875rem, 0.8rem + 0.375vw, 1rem);
  --font-size-base: clamp(1rem, 0.9rem + 0.5vw, 1.125rem);
  --font-size-lg: clamp(1.125rem, 1rem + 0.625vw, 1.25rem);
  --font-size-xl: clamp(1.25rem, 1.1rem + 0.75vw, 1.5rem);
}
```

## 🔄 MIGRATION PROCESS

### 1. Backup Current Theme
```bash
# Backup tema esistente
cp -r resources/css/filament resources/css/filament.backup
cp tailwind.config.js tailwind.config.backup
```

### 2. Install Tailwind v4
```bash
# Upgrade a Tailwind v4
npm uninstall tailwindcss @tailwindcss/forms @tailwindcss/typography
npm install @tailwindcss/v4@next
```

### 3. Run Migration Tool
```bash
# Strumento di migrazione automatica
npx @tailwindcss/upgrade
```

### 4. Update Theme Files
```bash
# Aggiornare file tema
cp resources/css/filament/theme.css.new resources/css/filament/theme.css
```

### 5. Build Assets
```bash
# Ricompilare assets
npm run build
```

## 🧪 TESTING CHECKLIST

### Visual Testing
- [ ] Layout forms corretto
- [ ] Componenti responsive
- [ ] Colori brand applicati
- [ ] Tipografia leggibile
- [ ] Icone allineate

### Functional Testing
- [ ] Button interactions
- [ ] Form submissions
- [ ] Modal overlays
- [ ] Table sorting
- [ ] Mobile navigation

### Browser Testing
- [ ] Chrome/Chromium
- [ ] Firefox
- [ ] Safari
- [ ] Edge
- [ ] Mobile browsers

## 📊 PERFORMANCE OPTIMIZATIONS

### CSS Purge
```css
/* Ottimizzazione CSS */
@source 'resources/views/**/*.blade';
@source 'app/Filament/**/*.php';
@source 'laravel/Modules/*/resources/views/**/*.blade';
```

### Lazy Loading Components
```blade
<!-- Lazy loading per componenti pesanti -->
<div x-data="{ open: false }">
    <button @click="open = true">Carica Dettagli</button>
    <div x-show="open" x-transition>
        <!-- Contenuto caricato su richiesta -->
    </div>
</div>
```

## 🚨 RISCHI E MITIGAZIONI

### 1. Breaking Changes
- **Rischio**: Layout rotto in componenti custom
- **Mitigazione**: Test completo su tutti i componenti

### 2. Performance Impact
- **Rischio**: CSS size aumentato
- **Mitigazione**: Ottimizzazione purging e lazy loading

### 3. Browser Compatibility
- **Rischio**: Problemi browser legacy
- **Mitigazione**: Polyfills e fallback CSS

---

## 🎯 NEXT STEPS

1. **Week 1**: Migrare tema base e componenti core
2. **Week 2**: Test responsive e mobile
3. **Week 3**: Ottimizzazione performance
4. **Week 4**: Documentazione e formazione

---

**Versione**: 1.0
**Stato**: Ready for Implementation
**Priority**: HIGH
**Deadline**: 31 Dicembre 2025
