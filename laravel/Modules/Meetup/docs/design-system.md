# 🎨 Design System - LaravelPizza

## Overview

Questo documento descrive il design system completo per il progetto LaravelPizza, includendo palette colori, tipografia, componenti UI, spacing system e guidelines Tailwind CSS.

## 🎨 Palette Colori

### Colori Primari

```css
/* Brand Colors - Pizza Theme */
--color-primary-50: #FFF7ED;    /* Lightest orange */
--color-primary-100: #FFEDD5;
--color-primary-200: #FED7AA;
--color-primary-300: #FDBA74;
--color-primary-400: #FB923C;
--color-primary-500: #F97316;   /* Main Brand Orange */
--color-primary-600: #EA580C;
--color-primary-700: #C2410C;
--color-primary-800: #9A3412;
--color-primary-900: #7C2D12;   /* Darkest orange */
```

**Tailwind Config:**
```javascript
colors: {
  primary: {
    50: '#FFF7ED',
    100: '#FFEDD5',
    200: '#FED7AA',
    300: '#FDBA74',
    400: '#FB923C',
    500: '#F97316',  // Main
    600: '#EA580C',
    700: '#C2410C',
    800: '#9A3412',
    900: '#7C2D12',
  }
}
```

### Colori Secondari

```css
/* Tomato Red - For accents and CTAs */
--color-secondary-50: #FEF2F2;
--color-secondary-100: #FEE2E2;
--color-secondary-200: #FECACA;
--color-secondary-300: #FCA5A5;
--color-secondary-400: #F87171;
--color-secondary-500: #EF4444;   /* Main Red */
--color-secondary-600: #DC2626;
--color-secondary-700: #B91C1C;
--color-secondary-800: #991B1B;
--color-secondary-900: #7F1D1D;
```

### Colori Neutri

```css
/* Gray Scale */
--color-gray-50: #F9FAFB;
--color-gray-100: #F3F4F6;
--color-gray-200: #E5E7EB;
--color-gray-300: #D1D5DB;
--color-gray-400: #9CA3AF;
--color-gray-500: #6B7280;
--color-gray-600: #4B5563;
--color-gray-700: #374151;
--color-gray-800: #1F2937;
--color-gray-900: #111827;
```

### Colori Semantici

```css
/* Success - Green */
--color-success: #10B981;
--color-success-light: #D1FAE5;
--color-success-dark: #065F46;

/* Warning - Yellow */
--color-warning: #F59E0B;
--color-warning-light: #FEF3C7;
--color-warning-dark: #92400E;

/* Error - Red */
--color-error: #EF4444;
--color-error-light: #FEE2E2;
--color-error-dark: #991B1B;

/* Info - Blue */
--color-info: #3B82F6;
--color-info-light: #DBEAFE;
--color-info-dark: #1E40AF;
```

### Colori Badge/Tags

```css
/* Vegetarian */
--badge-vegetarian-bg: #D1FAE5;
--badge-vegetarian-text: #065F46;

/* Vegan */
--badge-vegan-bg: #A7F3D0;
--badge-vegan-text: #064E3B;

/* Spicy */
--badge-spicy-bg: #FEE2E2;
--badge-spicy-text: #991B1B;

/* Featured */
--badge-featured-bg: #FEF3C7;
--badge-featured-text: #92400E;

/* New */
--badge-new-bg: #DBEAFE;
--badge-new-text: #1E40AF;
```

## 📝 Tipografia

### Font Families

```css
/* Primary Font - Headings */
--font-heading: 'Poppins', system-ui, -apple-system, sans-serif;

/* Body Font - Content */
--font-body: 'Inter', system-ui, -apple-system, sans-serif;

/* Monospace - Code/Numbers */
--font-mono: 'JetBrains Mono', 'Fira Code', monospace;
```

**Google Fonts Import:**
```html
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800&family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
```

### Type Scale

```css
/* Headings */
.text-h1 {
  font-family: var(--font-heading);
  font-size: 3.5rem;      /* 56px */
  line-height: 1.2;
  font-weight: 800;
  letter-spacing: -0.02em;
}

.text-h2 {
  font-family: var(--font-heading);
  font-size: 2.5rem;      /* 40px */
  line-height: 1.3;
  font-weight: 700;
  letter-spacing: -0.01em;
}

.text-h3 {
  font-family: var(--font-heading);
  font-size: 2rem;        /* 32px */
  line-height: 1.3;
  font-weight: 600;
}

.text-h4 {
  font-family: var(--font-heading);
  font-size: 1.5rem;      /* 24px */
  line-height: 1.4;
  font-weight: 600;
}

.text-h5 {
  font-family: var(--font-heading);
  font-size: 1.25rem;     /* 20px */
  line-height: 1.4;
  font-weight: 600;
}

.text-h6 {
  font-family: var(--font-heading);
  font-size: 1rem;        /* 16px */
  line-height: 1.5;
  font-weight: 600;
}

/* Body Text */
.text-body-lg {
  font-size: 1.125rem;    /* 18px */
  line-height: 1.75;
  font-weight: 400;
}

.text-body {
  font-size: 1rem;        /* 16px */
  line-height: 1.625;
  font-weight: 400;
}

.text-body-sm {
  font-size: 0.875rem;    /* 14px */
  line-height: 1.5;
  font-weight: 400;
}

/* Captions */
.text-caption {
  font-size: 0.75rem;     /* 12px */
  line-height: 1.5;
  font-weight: 500;
  text-transform: uppercase;
  letter-spacing: 0.05em;
}
```

### Tailwind Typography Classes

```javascript
// tailwind.config.js
theme: {
  fontFamily: {
    sans: ['Inter', 'system-ui', 'sans-serif'],
    heading: ['Poppins', 'system-ui', 'sans-serif'],
    mono: ['JetBrains Mono', 'monospace'],
  },
  fontSize: {
    'xs': ['0.75rem', { lineHeight: '1.5' }],
    'sm': ['0.875rem', { lineHeight: '1.5' }],
    'base': ['1rem', { lineHeight: '1.625' }],
    'lg': ['1.125rem', { lineHeight: '1.75' }],
    'xl': ['1.25rem', { lineHeight: '1.75' }],
    '2xl': ['1.5rem', { lineHeight: '1.4' }],
    '3xl': ['2rem', { lineHeight: '1.3' }],
    '4xl': ['2.5rem', { lineHeight: '1.3' }],
    '5xl': ['3.5rem', { lineHeight: '1.2' }],
  }
}
```

## 📏 Spacing System

### Base Unit: 4px (0.25rem)

```javascript
// tailwind.config.js
theme: {
  spacing: {
    '0': '0',
    'px': '1px',
    '0.5': '0.125rem',  // 2px
    '1': '0.25rem',     // 4px
    '2': '0.5rem',      // 8px
    '3': '0.75rem',     // 12px
    '4': '1rem',        // 16px
    '5': '1.25rem',     // 20px
    '6': '1.5rem',      // 24px
    '8': '2rem',        // 32px
    '10': '2.5rem',     // 40px
    '12': '3rem',       // 48px
    '16': '4rem',       // 64px
    '20': '5rem',       // 80px
    '24': '6rem',       // 96px
    '32': '8rem',       // 128px
  }
}
```

### Component Spacing Guidelines

- **Tight**: 0.5rem (8px) - Labels, small gaps
- **Normal**: 1rem (16px) - Default component spacing
- **Relaxed**: 1.5rem (24px) - Card padding
- **Loose**: 2rem (32px) - Section spacing
- **Extra Loose**: 4rem (64px) - Section dividers

## 🧩 Componenti UI

### Buttons

#### Primary Button
```html
<button class="btn btn-primary">
  Ordina Ora
</button>
```

```css
.btn {
  @apply inline-flex items-center justify-center px-6 py-3 rounded-lg font-medium transition-all duration-200 focus:outline-none focus:ring-2 focus:ring-offset-2;
}

.btn-primary {
  @apply bg-primary-500 text-white hover:bg-primary-600 focus:ring-primary-500 shadow-lg hover:shadow-xl transform hover:-translate-y-0.5;
}

.btn-secondary {
  @apply bg-secondary-500 text-white hover:bg-secondary-600 focus:ring-secondary-500;
}

.btn-outline {
  @apply border-2 border-primary-500 text-primary-600 hover:bg-primary-50;
}

.btn-ghost {
  @apply text-gray-700 hover:bg-gray-100;
}

/* Sizes */
.btn-sm {
  @apply px-4 py-2 text-sm;
}

.btn-lg {
  @apply px-8 py-4 text-lg;
}
```

### Cards

```html
<div class="card">
  <img src="pizza.jpg" alt="Pizza" class="card-image">
  <div class="card-body">
    <h3 class="card-title">Margherita</h3>
    <p class="card-text">Pomodoro, mozzarella, basilico</p>
    <div class="card-footer">
      <span class="card-price">€8.50</span>
      <button class="btn btn-primary">Aggiungi</button>
    </div>
  </div>
</div>
```

```css
.card {
  @apply bg-white rounded-xl shadow-md hover:shadow-xl transition-shadow duration-300 overflow-hidden;
}

.card-image {
  @apply w-full h-48 object-cover;
}

.card-body {
  @apply p-6;
}

.card-title {
  @apply text-xl font-heading font-semibold text-gray-900 mb-2;
}

.card-text {
  @apply text-gray-600 mb-4;
}

.card-footer {
  @apply flex justify-between items-center;
}

.card-price {
  @apply text-2xl font-bold text-primary-600;
}
```

### Badges

```html
<span class="badge badge-vegetarian">Vegetariana</span>
<span class="badge badge-vegan">Vegana</span>
<span class="badge badge-spicy">Piccante</span>
<span class="badge badge-featured">In Evidenza</span>
```

```css
.badge {
  @apply inline-flex items-center px-3 py-1 rounded-full text-xs font-medium;
}

.badge-vegetarian {
  @apply bg-green-100 text-green-800;
}

.badge-vegan {
  @apply bg-emerald-100 text-emerald-800;
}

.badge-spicy {
  @apply bg-red-100 text-red-800;
}

.badge-featured {
  @apply bg-yellow-100 text-yellow-800;
}
```

### Forms

```html
<div class="form-group">
  <label class="form-label" for="email">Email</label>
  <input type="email" id="email" class="form-input" placeholder="tua@email.com">
  <p class="form-help">Inserisci il tuo indirizzo email</p>
</div>
```

```css
.form-group {
  @apply mb-6;
}

.form-label {
  @apply block text-sm font-medium text-gray-700 mb-2;
}

.form-input {
  @apply w-full px-4 py-3 rounded-lg border-2 border-gray-300 focus:border-primary-500 focus:ring-2 focus:ring-primary-200 transition-colors;
}

.form-textarea {
  @apply w-full px-4 py-3 rounded-lg border-2 border-gray-300 focus:border-primary-500 focus:ring-2 focus:ring-primary-200 resize-none;
}

.form-select {
  @apply w-full px-4 py-3 rounded-lg border-2 border-gray-300 focus:border-primary-500 bg-white;
}

.form-checkbox {
  @apply w-5 h-5 text-primary-600 rounded focus:ring-primary-500;
}

.form-radio {
  @apply w-5 h-5 text-primary-600 focus:ring-primary-500;
}

.form-help {
  @apply mt-2 text-sm text-gray-500;
}

.form-error {
  @apply mt-2 text-sm text-red-600;
}
```

## 🌓 Dark Mode Support

```javascript
// tailwind.config.js
module.exports = {
  darkMode: 'class', // or 'media'
  // ...
}
```

```css
/* Dark mode variants */
.dark .card {
  @apply bg-gray-800 text-white;
}

.dark .btn-primary {
  @apply bg-primary-600 hover:bg-primary-700;
}
```

## 📱 Breakpoints

```javascript
// tailwind.config.js
theme: {
  screens: {
    'xs': '320px',
    'sm': '640px',
    'md': '768px',
    'lg': '1024px',
    'xl': '1280px',
    '2xl': '1536px',
  }
}
```

### Responsive Design Rules

- **Mobile First**: Design partendo da mobile (xs)
- **Touch Targets**: Min 44px x 44px per elementi interattivi
- **Viewport Units**: Usare con cautela, preferire rem/px
- **Fluid Typography**: Considerare clamp() per testi scalabili

## 🎭 Animations

```css
/* Fade In */
@keyframes fadeIn {
  from { opacity: 0; }
  to { opacity: 1; }
}

.animate-fade-in {
  animation: fadeIn 0.3s ease-in;
}

/* Slide Up */
@keyframes slideUp {
  from {
    transform: translateY(20px);
    opacity: 0;
  }
  to {
    transform: translateY(0);
    opacity: 1;
  }
}

.animate-slide-up {
  animation: slideUp 0.4s ease-out;
}

/* Bounce */
.animate-bounce-subtle {
  animation: bounce 1s ease-in-out infinite;
}

@keyframes bounce {
  0%, 100% { transform: translateY(0); }
  50% { transform: translateY(-10px); }
}
```

## 🔧 Tailwind Configuration Completa

```javascript
// tailwind.config.js
const defaultTheme = require('tailwindcss/defaultTheme')

module.exports = {
  content: [
    './resources/**/*.blade.php',
    './resources/**/*.js',
    './resources/**/*.vue',
    './Themes/**/*.blade.php',
    './Modules/**/*.blade.php',
  ],
  darkMode: 'class',
  theme: {
    extend: {
      colors: {
        primary: {
          50: '#FFF7ED',
          500: '#F97316',
          900: '#7C2D12',
        },
        secondary: {
          50: '#FEF2F2',
          500: '#EF4444',
          900: '#7F1D1D',
        },
      },
      fontFamily: {
        sans: ['Inter', ...defaultTheme.fontFamily.sans],
        heading: ['Poppins', ...defaultTheme.fontFamily.sans],
      },
      spacing: {
        '18': '4.5rem',
        '88': '22rem',
        '112': '28rem',
      },
      borderRadius: {
        '4xl': '2rem',
      },
      boxShadow: {
        'soft': '0 2px 15px -3px rgba(0, 0, 0, 0.07), 0 10px 20px -2px rgba(0, 0, 0, 0.04)',
      },
    },
  },
  plugins: [
    require('@tailwindcss/forms'),
    require('@tailwindcss/typography'),
    require('@tailwindcss/aspect-ratio'),
  ],
}
```

## 📚 Risorse e Tool

### Design Tools
- **Figma**: Design mockups e prototipi
- **ColorHunt**: Palette inspiration
- **Coolors**: Color palette generator
- **Hero Icons**: Icon set (Tailwind-friendly)
- **Lucide Icons**: Alternative icon set

### Tailwind Tools
- **Tailwind UI**: Premium components
- **Headless UI**: Unstyled accessible components
- **DaisyUI**: Component library
- **Flowbite**: UI components

### Testing UI/UX
- **Puppeteer MCP**: Browser automation e testing
- **Lighthouse**: Performance e accessibility audit
- **WAVE**: Accessibility evaluation

## ✅ Best Practices

1. **Consistenza**: Usare sempre classi utility definite nel design system
2. **Accessibilità**: Contrast ratio minimo 4.5:1 per testo
3. **Performance**: Purge unused CSS in production
4. **Manutenibilità**: Documentare custom components
5. **Responsive**: Test su tutti i breakpoints
6. **Dark Mode**: Prevedere varianti dark dove necessario

## 🎨 Component Library

Tutti i componenti documentati devono essere implementati come:
- Blade Components riutilizzabili
- Livewire Components per interattività
- Volt Components per rapidità sviluppo

Esempio path:
- `Themes/Meetup/resources/views/components/button.blade.php`
- `Modules/UI/app/View/Components/Card.php`
