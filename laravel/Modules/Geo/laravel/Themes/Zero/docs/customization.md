# Personalizzazione del Tema Zero

## Panoramica

Il tema Zero è progettato per essere altamente personalizzabile. Questa guida ti aiuterà a personalizzare l'aspetto e il comportamento del tema secondo le tue esigenze.

## Personalizzazione dei Colori

### Palette di Colori Predefinita

Il tema Zero utilizza una palette di colori moderna e accessibile:

```css
/* Colori principali */
--primary-color: #3b82f6;      /* Blu */
--secondary-color: #64748b;     /* Grigio */
--accent-color: #f59e0b;        /* Arancione */
--success-color: #10b981;       /* Verde */
--warning-color: #f59e0b;       /* Giallo */
--error-color: #ef4444;         /* Rosso */

/* Colori di sfondo */
--bg-primary: #ffffff;          /* Bianco */
--bg-secondary: #f8fafc;        /* Grigio chiaro */
--bg-dark: #1e293b;             /* Grigio scuro */

/* Colori del testo */
--text-primary: #1e293b;        /* Grigio scuro */
--text-secondary: #64748b;      /* Grigio medio */
--text-light: #94a3b8;          /* Grigio chiaro */
```

### Modifica della Palette

#### 1. Tramite Tailwind Config

```javascript
// tailwind.config.js
module.exports = {
  theme: {
    extend: {
      colors: {
        primary: {
          50: '#eff6ff',
          100: '#dbeafe',
          500: '#3b82f6',
          600: '#2563eb',
          700: '#1d4ed8',
          900: '#1e3a8a',
        },
        secondary: {
          50: '#f8fafc',
          100: '#f1f5f9',
          500: '#64748b',
          600: '#475569',
          700: '#334155',
          900: '#0f172a',
        },
      },
    },
  },
}
```

#### 2. Tramite CSS Variables

```css
/* resources/css/app.css */
:root {
  --primary-color: #8b5cf6;     /* Viola */
  --secondary-color: #06b6d4;   /* Ciano */
  --accent-color: #f97316;      /* Arancione */
}

/* Applicazione delle variabili */
.btn-primary {
  background-color: var(--primary-color);
}

.text-primary {
  color: var(--primary-color);
}
```

### Temi Dinamici

```javascript
// Alpine.js per cambio tema
function toggleTheme() {
  const html = document.documentElement;
  const currentTheme = html.getAttribute('data-theme');
  const newTheme = currentTheme === 'dark' ? 'light' : 'dark';
  
  html.setAttribute('data-theme', newTheme);
  localStorage.setItem('theme', newTheme);
}
```

## Personalizzazione della Tipografia

### Font Predefiniti

Il tema Zero utilizza il font Nunito per una migliore leggibilità:

```css
/* Font principale */
font-family: 'Nunito', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;

/* Font per codice */
font-family: 'Fira Code', 'Monaco', 'Consolas', monospace;
```

### Modifica dei Font

#### 1. Cambio Font Principale

```css
/* resources/css/app.css */
@import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap');

:root {
  --font-primary: 'Inter', sans-serif;
  --font-secondary: 'Nunito', sans-serif;
}

body {
  font-family: var(--font-primary);
}
```

#### 2. Configurazione Tailwind

```javascript
// tailwind.config.js
module.exports = {
  theme: {
    extend: {
      fontFamily: {
        sans: ['Inter', 'sans-serif'],
        display: ['Poppins', 'sans-serif'],
        mono: ['Fira Code', 'monospace'],
      },
    },
  },
}
```

### Dimensioni del Testo

```css
/* Scala tipografica personalizzata */
.text-xs { font-size: 0.75rem; line-height: 1rem; }
.text-sm { font-size: 0.875rem; line-height: 1.25rem; }
.text-base { font-size: 1rem; line-height: 1.5rem; }
.text-lg { font-size: 1.125rem; line-height: 1.75rem; }
.text-xl { font-size: 1.25rem; line-height: 1.75rem; }
.text-2xl { font-size: 1.5rem; line-height: 2rem; }
.text-3xl { font-size: 1.875rem; line-height: 2.25rem; }
.text-4xl { font-size: 2.25rem; line-height: 2.5rem; }
```

## Personalizzazione del Layout

### Spaziature

```css
/* Sistema di spaziatura personalizzato */
:root {
  --spacing-xs: 0.25rem;    /* 4px */
  --spacing-sm: 0.5rem;     /* 8px */
  --spacing-md: 1rem;       /* 16px */
  --spacing-lg: 1.5rem;     /* 24px */
  --spacing-xl: 2rem;       /* 32px */
  --spacing-2xl: 3rem;      /* 48px */
  --spacing-3xl: 4rem;      /* 64px */
}
```

### Container

```css
/* Container personalizzati */
.container-sm {
  max-width: 640px;
  margin: 0 auto;
  padding: 0 var(--spacing-md);
}

.container-md {
  max-width: 768px;
  margin: 0 auto;
  padding: 0 var(--spacing-md);
}

.container-lg {
  max-width: 1024px;
  margin: 0 auto;
  padding: 0 var(--spacing-md);
}

.container-xl {
  max-width: 1280px;
  margin: 0 auto;
  padding: 0 var(--spacing-md);
}
```

### Grid System

```css
/* Grid personalizzato */
.grid-custom {
  display: grid;
  grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
  gap: var(--spacing-lg);
}

.grid-sidebar {
  display: grid;
  grid-template-columns: 250px 1fr;
  gap: var(--spacing-xl);
}

@media (max-width: 768px) {
  .grid-sidebar {
    grid-template-columns: 1fr;
  }
}
```

## Personalizzazione dei Componenti

### Button Component

```css
/* Stili personalizzati per i bottoni */
.btn {
  @apply px-4 py-2 rounded-md font-medium transition-all duration-200;
}

.btn-primary {
  @apply bg-primary-500 text-white hover:bg-primary-600 focus:ring-2 focus:ring-primary-500;
}

.btn-secondary {
  @apply bg-gray-200 text-gray-800 hover:bg-gray-300 focus:ring-2 focus:ring-gray-500;
}

.btn-outline {
  @apply border-2 border-primary-500 text-primary-500 hover:bg-primary-500 hover:text-white;
}
```

### Card Component

```css
/* Stili personalizzati per le card */
.card {
  @apply bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden;
}

.card-header {
  @apply px-6 py-4 border-b border-gray-200 bg-gray-50;
}

.card-body {
  @apply px-6 py-4;
}

.card-footer {
  @apply px-6 py-4 border-t border-gray-200 bg-gray-50;
}
```

### Form Components

```css
/* Stili personalizzati per i form */
.form-input {
  @apply w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-transparent;
}

.form-label {
  @apply block text-sm font-medium text-gray-700 mb-1;
}

.form-error {
  @apply text-red-600 text-sm mt-1;
}

.form-help {
  @apply text-gray-500 text-sm mt-1;
}
```

## Personalizzazione delle Animazioni

### Transizioni

```css
/* Transizioni personalizzate */
.transition-smooth {
  transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
}

.transition-bounce {
  transition: all 0.5s cubic-bezier(0.68, -0.55, 0.265, 1.55);
}

.transition-elastic {
  transition: all 0.6s cubic-bezier(0.175, 0.885, 0.32, 1.275);
}
```

### Animazioni CSS

```css
/* Animazioni personalizzate */
@keyframes fadeIn {
  from { opacity: 0; transform: translateY(20px); }
  to { opacity: 1; transform: translateY(0); }
}

@keyframes slideIn {
  from { transform: translateX(-100%); }
  to { transform: translateX(0); }
}

@keyframes pulse {
  0%, 100% { transform: scale(1); }
  50% { transform: scale(1.05); }
}

.animate-fade-in {
  animation: fadeIn 0.5s ease-out;
}

.animate-slide-in {
  animation: slideIn 0.3s ease-out;
}

.animate-pulse-custom {
  animation: pulse 2s infinite;
}
```

## Personalizzazione Responsive

### Breakpoint Personalizzati

```css
/* Breakpoint personalizzati */
@media (min-width: 480px) {
  /* Mobile landscape */
}

@media (min-width: 768px) {
  /* Tablet */
}

@media (min-width: 1024px) {
  /* Desktop */
}

@media (min-width: 1280px) {
  /* Large desktop */
}

@media (min-width: 1536px) {
  /* Extra large desktop */
}
```

### Utility Classes Responsive

```css
/* Utility classes responsive */
.responsive-text {
  font-size: 1rem; /* Mobile */
}

@media (min-width: 768px) {
  .responsive-text {
    font-size: 1.125rem; /* Tablet */
  }
}

@media (min-width: 1024px) {
  .responsive-text {
    font-size: 1.25rem; /* Desktop */
  }
}
```

## Personalizzazione Dark Mode

### Implementazione Dark Mode

```css
/* Dark mode con CSS variables */
[data-theme="dark"] {
  --bg-primary: #1e293b;
  --bg-secondary: #334155;
  --text-primary: #f1f5f9;
  --text-secondary: #cbd5e1;
  --border-color: #475569;
}

[data-theme="dark"] .card {
  @apply bg-gray-800 border-gray-700;
}

[data-theme="dark"] .btn-primary {
  @apply bg-blue-600 hover:bg-blue-700;
}
```

### Toggle Dark Mode

```javascript
// Alpine.js component per dark mode
function darkMode() {
  return {
    dark: false,
    init() {
      this.dark = localStorage.getItem('dark') === 'true';
      this.updateTheme();
    },
    toggle() {
      this.dark = !this.dark;
      localStorage.setItem('dark', this.dark);
      this.updateTheme();
    },
    updateTheme() {
      document.documentElement.setAttribute('data-theme', this.dark ? 'dark' : 'light');
    }
  }
}
```

## Personalizzazione Performance

### Lazy Loading

```css
/* Lazy loading per immagini */
.lazy-image {
  opacity: 0;
  transition: opacity 0.3s;
}

.lazy-image.loaded {
  opacity: 1;
}
```

### Critical CSS

```css
/* CSS critico inline */
.critical {
  /* Stili essenziali per il primo render */
}
```

### Font Loading

```css
/* Ottimizzazione caricamento font */
@font-face {
  font-family: 'Nunito';
  font-display: swap;
  src: url('/fonts/nunito.woff2') format('woff2');
}
```

## Best Practices

### 1. Organizzazione CSS

- Utilizzare CSS custom properties per valori riutilizzabili
- Organizzare il CSS in sezioni logiche
- Commentare le sezioni importanti
- Mantenere la specificità bassa

### 2. Performance

- Minimizzare il numero di regole CSS
- Utilizzare classi utility quando possibile
- Evitare selettori complessi
- Ottimizzare le animazioni

### 3. Accessibilità

- Mantenere un contrasto adeguato
- Utilizzare dimensioni di testo leggibili
- Fornire focus states visibili
- Testare con screen reader

### 4. Manutenibilità

- Utilizzare naming conventions consistenti
- Documentare le personalizzazioni
- Versionare le modifiche
- Testare su diversi browser

## Troubleshooting

### Problemi Comuni

1. **Stili non applicati**: Verificare l'ordine di caricamento CSS
2. **Specificità CSS**: Utilizzare `!important` solo quando necessario
3. **Cache browser**: Pulire la cache del browser
4. **Compilazione asset**: Riavviare il processo di build

### Debug

```bash
# Verificare la compilazione CSS
npm run build

# Controllare la cache
php artisan view:clear
php artisan config:clear

# Verificare i log
tail -f storage/logs/laravel.log
```

## Riferimenti

- [Documentazione Tailwind CSS](https://tailwindcss.com/docs)
- [CSS Custom Properties](https://developer.mozilla.org/en-US/docs/Web/CSS/Using_CSS_custom_properties)
- [CSS Grid](https://developer.mozilla.org/en-US/docs/Web/CSS/CSS_Grid_Layout)
- [CSS Animations](https://developer.mozilla.org/en-US/docs/Web/CSS/CSS_Animations) 