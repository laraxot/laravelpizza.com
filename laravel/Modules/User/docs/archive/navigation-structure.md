# Struttura Navigazione

## Overview

La navigazione è composta da tre componenti principali:
1. Language Switcher
2. User Dropdown
3. Avatar

## Struttura File

```
laravel/Themes/One/resources/views/
├── components/
│   └── blocks/
│       └── navigation/
│           ├── index.blade.php           # Componente principale
│           ├── language-switcher.blade.php
│           ├── user-dropdown.blade.php
│           └── avatar.blade.php
└── layouts/
    └── navigation.blade.php              # Layout della navigazione
```

## Componenti

### 1. Navigation (index.blade.php)
- Container principale
- Responsive design
- Gestione stati mobile/desktop

### 2. Language Switcher
- Lista lingue disponibili
- Indicatore lingua corrente
- Gestione cambio lingua
- Persistenza scelta

### 3. User Dropdown
- Informazioni utente
- Menu opzioni
- Gestione logout
- Link amministrazione

### 4. Avatar
- Immagine profilo
- Fallback image
- Gestione upload
- Cache immagini

## Stati

### Desktop
```blade
<nav class="hidden md:flex">
    <!-- Language Switcher -->
    <!-- User Dropdown -->
    <!-- Avatar -->
</nav>
```

### Mobile
```blade
<nav class="md:hidden">
    <!-- Mobile Menu -->
    <!-- Language Switcher -->
    <!-- User Dropdown -->
    <!-- Avatar -->
</nav>
```

## Eventi

### Language Change
```php
Event::dispatch('language.changed', [
    'old' => $oldLocale,
    'new' => $newLocale,
    'user_id' => Auth::id()
]);
```

### User Actions
```php
Event::dispatch('user.action', [
    'action' => 'logout',
    'user_id' => Auth::id(),
    'timestamp' => now()
]);
```

## Stili

### Filament Integration
```css
.filament-header {
    @apply bg-white dark:bg-gray-800;
}

.filament-nav-link {
    @apply text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white;
}
```

### Custom Components
```css
.language-switcher {
    @apply flex items-center space-x-2;
}

.user-dropdown {
    @apply relative inline-block;
}

.avatar {
    @apply rounded-full;
}
```

## Best Practices

1. **Performance**
   - Lazy loading immagini
   - Caching componenti
   - Ottimizzazione bundle

2. **Accessibilità**
   - ARIA labels
   - Keyboard navigation
   - Screen reader support

3. **Responsive**
   - Mobile-first approach
   - Breakpoints consistenti
   - Touch-friendly

4. **Sicurezza**
   - CSRF protection
   - XSS prevention
   - Input validation

## Collegamenti Correlati
- [Header Components](./HEADER_COMPONENTS.md)
- [Security Best Practices](./SECURITY_BEST_PRACTICES.md)
- [Session Management](./SESSION_MANAGEMENT.md) 
