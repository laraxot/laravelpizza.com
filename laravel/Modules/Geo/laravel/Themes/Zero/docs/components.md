# Componenti del Tema Zero

## Panoramica

Il tema Zero fornisce una serie di componenti Blade riutilizzabili per costruire interfacce consistenti e moderne. Tutti i componenti sono progettati per essere accessibili, responsive e facilmente personalizzabili.

## Componenti Disponibili

### 1. Navigation Component

**File**: `resources/views/components/navigation.blade.php`

Componente per la navigazione principale dell'applicazione.

#### Caratteristiche

- Logo personalizzabile
- Menu di navigazione responsive
- Supporto per link attivi
- Design pulito e moderno

#### Utilizzo

```blade
<x-navigation />
```

#### Personalizzazione

```blade
<x-navigation class="custom-navigation">
    <x-slot name="logo">
        <img src="/logo.png" alt="Logo" class="h-8 w-auto">
    </x-slot>
    
    <x-slot name="menu">
        <x-nav-link href="{{ route('home') }}" :active="request()->routeIs('home')">
            Home
        </x-nav-link>
        <x-nav-link href="{{ route('about') }}" :active="request()->routeIs('about')">
            Chi Siamo
        </x-nav-link>
    </x-slot>
</x-navigation>
```

### 2. Nav Link Component

**File**: `resources/views/components/nav-link.blade.php`

Componente per i singoli link di navigazione.

#### Caratteristiche

- Stato attivo automatico
- Stili hover e focus
- Accessibilità integrata
- Responsive design

#### Utilizzo

```blade
<x-nav-link href="{{ route('dashboard') }}" :active="request()->routeIs('dashboard')">
    Dashboard
</x-nav-link>
```

#### Proprietà

- `href`: URL del link
- `active`: Stato attivo del link
- `class`: Classi CSS aggiuntive

### 3. Responsive Nav Link Component

**File**: `resources/views/components/responsive-nav-link.blade.php`

Versione responsive del componente nav-link per menu mobile.

#### Caratteristiche

- Ottimizzato per dispositivi mobili
- Menu hamburger integrato
- Animazioni fluide
- Touch-friendly

#### Utilizzo

```blade
<x-responsive-nav-link href="{{ route('profile') }}" :active="request()->routeIs('profile')">
    Profilo
</x-responsive-nav-link>
```

## Struttura dei Componenti

### Organizzazione

```
resources/views/components/
├── layouts/
│   ├── app.blade.php
│   └── main.blade.php
├── navigation.blade.php
├── nav-link.blade.php
└── responsive-nav-link.blade.php
```

### Convenzioni di Naming

- **kebab-case**: Per i nomi dei file (es: `nav-link.blade.php`)
- **camelCase**: Per le variabili PHP
- **snake_case**: Per gli attributi HTML

## Personalizzazione

### Stili CSS

Tutti i componenti utilizzano Tailwind CSS. È possibile personalizzare:

```css
/* resources/css/app.css */
@layer components {
    .nav-link {
        @apply px-3 py-2 rounded-md text-sm font-medium transition-colors duration-200;
    }
    
    .nav-link-active {
        @apply bg-blue-100 text-blue-700;
    }
    
    .nav-link-hover {
        @apply hover:bg-gray-100 hover:text-gray-900;
    }
}
```

### Variabili CSS

```css
:root {
    --nav-bg-color: #ffffff;
    --nav-text-color: #374151;
    --nav-hover-color: #f3f4f6;
    --nav-active-color: #3b82f6;
    --nav-border-color: #e5e7eb;
}
```

### Temi

È possibile creare varianti tematiche dei componenti:

```blade
<!-- Tema scuro -->
<x-navigation class="dark-theme" />

<!-- Tema colorato -->
<x-navigation class="colored-theme" />

<!-- Tema minimalista -->
<x-navigation class="minimal-theme" />
```

## Accessibilità

### Attributi ARIA

Tutti i componenti includono attributi ARIA appropriati:

```blade
<nav role="navigation" aria-label="Main navigation">
    <button aria-expanded="false" aria-controls="mobile-menu">
        <span class="sr-only">Open main menu</span>
        <!-- Icona hamburger -->
    </button>
</nav>
```

### Supporto Keyboard

- Navigazione con Tab
- Attivazione con Enter/Space
- Escape per chiudere menu
- Arrow keys per navigazione

### Screen Reader

- Testi alternativi per icone
- Descrizioni per elementi interattivi
- Annunci di stato per menu

## Responsive Design

### Breakpoint

```css
/* Mobile First */
.nav-mobile { /* Stili mobile */ }

/* Tablet */
@media (min-width: 768px) {
    .nav-tablet { /* Stili tablet */ }
}

/* Desktop */
@media (min-width: 1024px) {
    .nav-desktop { /* Stili desktop */ }
}
```

### Menu Mobile

```blade
<!-- Menu hamburger per mobile -->
<div class="md:hidden">
    <button @click="mobileMenuOpen = !mobileMenuOpen">
        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
        </svg>
    </button>
</div>

<!-- Menu mobile -->
<div x-show="mobileMenuOpen" class="md:hidden">
    <!-- Link mobile -->
</div>
```

## Performance

### Lazy Loading

```blade
<!-- Caricamento condizionale -->
@if($showNavigation)
    <x-navigation />
@endif
```

### Caching

```blade
<!-- Cache dei componenti -->
@cache('navigation', 3600)
    <x-navigation />
@endcache
```

### Ottimizzazione

- Minimizzazione degli asset
- Compressione delle immagini
- CDN per font e icone
- Lazy loading per contenuti pesanti

## Testing

### Test Unitari

```php
// tests/Feature/NavigationTest.php
public function test_navigation_component_renders()
{
    $view = $this->blade('<x-navigation />');
    
    $view->assertSee('Home');
    $view->assertSee('About');
}
```

### Test Browser

```php
// tests/Browser/NavigationTest.php
public function test_navigation_is_responsive()
{
    $this->browse(function (Browser $browser) {
        $browser->visit('/')
                ->resize(375, 667) // Mobile
                ->assertSee('Menu')
                ->resize(1920, 1080) // Desktop
                ->assertDontSee('Menu');
    });
}
```

## Best Practices

### 1. Semantica HTML

- Utilizzare tag semantici appropriati
- Strutturare correttamente i heading
- Includere landmark roles

### 2. CSS

- Preferire classi Tailwind
- Evitare CSS inline
- Utilizzare variabili CSS
- Mantenere la specificità bassa

### 3. JavaScript

- Utilizzare Alpine.js per interattività
- Evitare jQuery quando possibile
- Implementare fallback per JavaScript disabilitato

### 4. Performance

- Minimizzare le dipendenze
- Ottimizzare le immagini
- Utilizzare lazy loading
- Implementare caching

## Troubleshooting

### Problemi Comuni

1. **Componente non trovato**: Verificare il nome del file
2. **Stili non applicati**: Controllare l'ordine CSS
3. **JavaScript non funziona**: Verificare Alpine.js
4. **Responsive non funziona**: Controllare i breakpoint

### Debug

```bash
# Verificare la cache delle viste
php artisan view:clear

# Controllare i log
tail -f storage/logs/laravel.log

# Verificare la compilazione degli asset
npm run build
```

## Riferimenti

- [Documentazione Blade](https://laravel.com/docs/blade)
- [Documentazione Alpine.js](https://alpinejs.dev/)
- [Documentazione Tailwind CSS](https://tailwindcss.com/docs)
- [Guida Accessibilità](https://www.w3.org/WAI/WCAG21/quickref/) 