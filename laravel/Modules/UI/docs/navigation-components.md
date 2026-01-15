# Componenti di Navigazione

## Indice
- [Panoramica](#panoramica)
- [Componenti Disponibili](#componenti-disponibili)
- [Gestione dell'Autenticazione](#gestione-dellautenticazione)
- [Localizzazione](#localizzazione)
- [Best Practices](#best-practices)

## Panoramica

Questo documento descrive l'utilizzo corretto dei componenti di navigazione , con particolare attenzione alla gestione condizionale dell'autenticazione e alla localizzazione.

## Componenti Disponibili

### Componenti di Navigazione Principali

- `<x-blocks.navigation.user-dropdown>` - Dropdown utente (visualizzato solo per utenti autenticati)
- `<x-blocks.navigation.login-buttons>` - Pulsanti di login/registrazione (visualizzati solo per utenti non autenticati)
- `<x-blocks.navigation.language-switcher>` - Selettore della lingua

## Gestione dell'Autenticazione

Il componente `user-dropdown` è progettato per gestire automaticamente la visualizzazione condizionale in base allo stato di autenticazione dell'utente:

```blade
@props([
    'alignment' => 'right',
    'width' => '48',
    'contentClasses' => 'py-1 bg-white dark:bg-gray-800',
      </li>
    </ul>
  </div>
</nav>
```

## 📑 Breadcrumbs
```html
<nav aria-label="breadcrumb">
  <ol class="breadcrumb">
    <li class="breadcrumb-item">
      <a href="/">Home</a>
    </li>
    <li class="breadcrumb-item">
      <a href="/categoria">Categoria</a>
    </li>
    <li class="breadcrumb-item active" aria-current="page">
      Pagina Corrente
    </li>
  </ol>
</nav>
```

## 📱 Menu Mobile
```html
<div class="mobile-menu">
  <div class="mobile-menu-header">
    <button class="close-menu" aria-label="Chiudi menu">
      <i class="fas fa-times"></i>
    </button>
  </div>

  <nav class="mobile-menu-nav">
    <ul>
      <li class="active">
        <a href="/">
          <i class="fas fa-home"></i>
          Home
        </a>
      </li>
      <li class="has-submenu">
        <a href="#">
          <i class="fas fa-cog"></i>
          Impostazioni
        </a>
        <ul class="submenu">
          <li><a href="#">Profilo</a></li>
          <li><a href="#">Sicurezza</a></li>
        </ul>
      </li>
    </ul>
  </nav>
</div>
```

## 🎯 Paginazione
```html
<nav aria-label="Paginazione">
  <ul class="pagination">
    <li class="page-item disabled">
      <span class="page-link">Precedente</span>
    </li>
    <li class="page-item active">
      <span class="page-link">1</span>
    </li>
    <li class="page-item">
      <a class="page-link" href="#">2</a>
    </li>
    <li class="page-item">
      <a class="page-link" href="#">3</a>
    </li>
    <li class="page-item">
      <a class="page-link" href="#">Successivo</a>
    </li>
  </ul>
</nav>
```

## 🔗 Tabs
```html
<div class="tabs">
  <ul class="nav nav-tabs" role="tablist">
    <li class="nav-item">
      <a class="nav-link active" data-bs-toggle="tab" href="#tab1">
        Tab 1
      </a>
    </li>
    <li class="nav-item">
      <a class="nav-link" data-bs-toggle="tab" href="#tab2">
        Tab 2
      </a>
    </li>
  </ul>

  <div class="tab-content">
    <div class="tab-pane active" id="tab1">
      Contenuto Tab 1
    </div>
    <div class="tab-pane" id="tab2">
      Contenuto Tab 2
    </div>
  </div>
</div>
```

## 🎨 Stili e Comportamenti

### Dropdown
```scss
.dropdown {
  position: relative;

  &-menu {
    position: absolute;
    top: 100%;
    left: 0;
    z-index: 1000;
    display: none;

    &.show {
      display: block;
    }
  }
}
```

### Mobile Menu
```scss
.mobile-menu {
  position: fixed;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  background: white;
  z-index: 1000;
  transform: translateX(-100%);
  transition: transform 0.3s ease;

  &.show {
    transform: translateX(0);
  }
}
```

## 🔗 Collegamenti
- [Componenti Base](./base-components.md)
- [Layout](./layout-components.md)
- [Accessibilità](./standards/accessibility.md)
# Componenti di Navigazione

## Indice
- [Panoramica](#panoramica)
- [Componenti Disponibili](#componenti-disponibili)
- [Gestione dell'Autenticazione](#gestione-dellautenticazione)
- [Localizzazione](#localizzazione)
- [Best Practices](#best-practices)

## Panoramica

Questo documento descrive l'utilizzo corretto dei componenti di navigazione , con particolare attenzione alla gestione condizionale dell'autenticazione e alla localizzazione.

## Componenti Disponibili

### Componenti di Navigazione Principali

- `<x-blocks.navigation.user-dropdown>` - Dropdown utente (visualizzato solo per utenti autenticati)
- `<x-blocks.navigation.login-buttons>` - Pulsanti di login/registrazione (visualizzati solo per utenti non autenticati)
- `<x-blocks.navigation.language-switcher>` - Selettore della lingua

## Gestione dell'Autenticazione

Il componente `user-dropdown` è progettato per gestire automaticamente la visualizzazione condizionale in base allo stato di autenticazione dell'utente:

```blade
@props([
    'alignment' => 'right',
    'width' => '48',
    'contentClasses' => 'py-1 bg-white dark:bg-gray-800',
])

@php
    use Mcamara\LaravelLocalization\Facades\LaravelLocalization;
    $user = $user ?? auth()->user();
    $locale = LaravelLocalization::getCurrentLocale();
    $isLoggedIn = auth()->check();
@endphp

@if($isLoggedIn)
    {{-- Dropdown per utente loggato --}}
    <!-- Contenuto del dropdown utente -->
@else
    {{-- Link di login/register per utente non loggato --}}
    <div class="flex items-center space-x-4">
        <a href="/{{ $locale }}/auth/login" class="text-sm font-medium text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-300">
            {{ __('auth.login.title') }}
        </a>
        <a href="/{{ $locale }}/auth/register" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-primary-600 hover:bg-primary-700">
            {{ __('auth.register.title') }}
        </a>
    </div>
@endif
```

## Localizzazione

I componenti di navigazione devono utilizzare sempre le funzioni di localizzazione di Laravel e mcamara/laravel-localization:

```blade
@php
    use Mcamara\LaravelLocalization\Facades\LaravelLocalization;
    $locale = LaravelLocalization::getCurrentLocale();
@endphp

<a href="/{{ $locale }}/profile">{{ __('auth.user_dropdown.profile') }}</a>
```

### Traduzioni Necessarie

Assicurarsi che le seguenti chiavi di traduzione siano definite in `lang/{locale}/auth.php`:

```php
return [
    'login' => [
        'title' => 'Accedi',
        // altri campi
    ],
    'register' => [
        'title' => 'Registrati',
        // altri campi
    ],
    'user_dropdown' => [
        'manage_account' => 'Gestisci Account',
        'profile' => 'Profilo',
        'settings' => 'Impostazioni',
        'logout' => 'Esci',
    ],
    // altre sezioni
];
```

## Best Practices

1. **Gestione condizionale dell'autenticazione**:
   - Utilizzare sempre `auth()->check()` per verificare lo stato di autenticazione
   - Mostrare il dropdown utente solo per utenti autenticati
   - Mostrare i pulsanti di login/registrazione solo per utenti non autenticati

2. **Percorsi localizzati**:
   - Utilizzare sempre `LaravelLocalization::getCurrentLocale()` per ottenere la lingua corrente
   - Costruire i percorsi con il prefisso della lingua: `/{{ $locale }}/percorso`
   - Non utilizzare `route()` per percorsi frontend, a meno che non siano rotte predefinite di Laravel

3. **Traduzioni**:
   - Utilizzare sempre le chiavi di traduzione complete (es. `auth.user_dropdown.profile`)
   - Non utilizzare stringhe hardcoded
   - Assicurarsi che tutte le chiavi utilizzate esistano nei file di traduzione

4. **Componenti Filament**:
   - Utilizzare i componenti Filament per icone e avatar: `<x-filament::icon>`, `<x-filament::avatar>`
   - Utilizzare i componenti Filament per i dropdown quando possibile
   - Utilizzare i separatori corretti nei dropdown (div con bordo, non componenti inesistenti)
