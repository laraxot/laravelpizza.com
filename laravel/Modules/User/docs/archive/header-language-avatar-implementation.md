# Implementazione del Selettore di Lingua e Avatar Utente nell'Header

## Collegamenti correlati
- [README modulo User](./README.md)
- [Convenzioni Path](./PATH_CONVENTIONS.md)
- [Volt Folio Logout](./VOLT_FOLIO_LOGOUT.md)
- [Implementazione Logout](./LOGOUT_BLADE_IMPLEMENTATION.md)

## Panoramica

Questo documento descrive come implementare nell'header di SaluteOra:
1. Un selettore di lingua
2. Un dropdown con l'avatar dell'utente contenente il link di logout

## Struttura Attuale dell'Header

L'header di SaluteOra è gestito tramite:
- **Componente Blade**: `/Themes/One/resources/views/components/sections/header.blade.php`
- **Configurazione JSON**: `/config/local/saluteora/database/content/sections/1.json`

Il componente header legge i blocchi dal file JSON e li renderizza in base alla lingua corrente. Attualmente l'header contiene:
- Un logo
- Un menu di navigazione
- Un blocco di azioni con pulsanti

## Implementazione del Selettore di Lingua

### 1. Creazione del Componente Blade

Creare un nuovo componente per il selettore di lingua:

```php
// /Themes/One/resources/views/components/blocks/language-selector.blade.php
@props(['items' => [], 'currentLocale' => app()->getLocale()])

<div class="relative inline-block text-left" x-data="{ open: false }">
    <button
        @click="open = !open"
        @click.away="open = false"
        class="inline-flex items-center justify-center rounded-md p-2 text-gray-500 hover:bg-gray-100 hover:text-gray-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500"
    >
        <span class="uppercase font-medium">{{ $currentLocale }}</span>
        <svg class="ml-1 h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
            <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
        </svg>
    </button>
    
    <div
        x-show="open"
        x-transition:enter="transition ease-out duration-100"
        x-transition:enter-start="transform opacity-0 scale-95"
        x-transition:enter-end="transform opacity-100 scale-100"
        x-transition:leave="transition ease-in duration-75"
        x-transition:leave-start="transform opacity-100 scale-100"
        x-transition:leave-end="transform opacity-0 scale-95"
        class="absolute right-0 z-10 mt-2 w-40 origin-top-right rounded-md bg-white shadow-lg ring-1 ring-black ring-opacity-5 focus:outline-none"
    >
        <div class="py-1">
            @foreach($items as $locale => $label)
                <a
                    href="{{ '/' . $locale . request()->getPathInfo() }}"
                    class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 {{ $currentLocale === $locale ? 'bg-gray-100' : '' }}"
                >
                    {{ $label }}
                </a>
            @endforeach
        </div>
    </div>
</div>
```

### 2. Aggiornamento del File JSON

Aggiungere un nuovo blocco nel file JSON dell'header:

```json
{
    "name": {
        "it": "Selettore Lingua",
        "en": "Language Selector"
    },
    "type": "language-selector",
    "data": {
        "view": "pub_theme::components.blocks.language-selector",
        "items": {
            "it": "Italiano",
            "en": "English"
        }
    }
}
```

## Implementazione del Dropdown Avatar Utente

### 1. Creazione del Componente Blade

Creare un nuovo componente per l'avatar utente con dropdown:

```php
// /Themes/One/resources/views/components/blocks/user-avatar.blade.php
@props(['user' => Auth::user()])

@auth
    <div class="relative ml-3" x-data="{ open: false }">
        <div>
            <button
                @click="open = !open"
                @click.away="open = false"
                class="flex rounded-full bg-white text-sm focus:outline-none focus:ring-2 focus:ring-primary-500 focus:ring-offset-2"
            >
                <span class="sr-only">{{ __('user.dropdown.open_menu') }}</span>
                @if($user->profile_photo_path)
                    <img class="h-8 w-8 rounded-full" src="{{ Storage::url($user->profile_photo_path) }}" alt="{{ $user->name }}">
                @else
                    <div class="h-8 w-8 rounded-full bg-primary-100 flex items-center justify-center text-primary-800 font-semibold">
                        {{ substr($user->first_name, 0, 1) }}{{ substr($user->last_name, 0, 1) }}
                    </div>
                @endif
            </button>
        </div>
        
        <div
            x-show="open"
            x-transition:enter="transition ease-out duration-100"
            x-transition:enter-start="transform opacity-0 scale-95"
            x-transition:enter-end="transform opacity-100 scale-100"
            x-transition:leave="transition ease-in duration-75"
            x-transition:leave-start="transform opacity-100 scale-100"
            x-transition:leave-end="transform opacity-0 scale-95"
            class="absolute right-0 z-10 mt-2 w-48 origin-top-right rounded-md bg-white py-1 shadow-lg ring-1 ring-black ring-opacity-5 focus:outline-none"
        >
            <div class="px-4 py-2 text-sm text-gray-900 border-b">
                <div class="font-medium">{{ $user->first_name }} {{ $user->last_name }}</div>
                <div class="text-gray-500 truncate">{{ $user->email }}</div>
            </div>
            
            <a href="{{ '/' . app()->getLocale() . '/profile' }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                {{ __('user.profile.link') }}
            </a>
            
            <a href="{{ '/' . app()->getLocale() . '/dashboard' }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                {{ __('user.dashboard.link') }}
            </a>
            
            <form action="{{ '/' . app()->getLocale() . '/auth/logout' }}" method="post" class="border-t">
                @csrf
                <button type="submit" class="w-full text-left px-4 py-2 text-sm text-red-600 hover:bg-gray-100">
                    {{ __('auth.logout') }}
                </button>
            </form>
        </div>
    </div>
@else
    <div class="flex items-center space-x-4">
        <a href="{{ '/' . app()->getLocale() . '/auth/login' }}" class="text-sm font-medium text-gray-700 hover:text-gray-900">
            {{ __('auth.login.link') }}
        </a>
        <x-filament::button
            tag="a"
            href="{{ '/' . app()->getLocale() . '/auth/register' }}"
            size="sm"
        >
            {{ __('auth.register.link') }}
        </x-filament::button>
    </div>
@endauth
```

### 2. Aggiornamento del File JSON

Aggiungere un nuovo blocco nel file JSON dell'header:

```json
{
    "name": {
        "it": "Avatar Utente",
        "en": "User Avatar"
    },
    "type": "user-avatar",
    "data": {
        "view": "pub_theme::components.blocks.user-avatar"
    }
}
```

## Aggiornamento Completo del File JSON

Ecco come dovrebbe apparire il file JSON completo dell'header dopo le modifiche:

```json
{
    "id": "1",
    "name": {
        "it": "Header Principale",
        "en": "Main Header"
    },
    "slug": "header",
    "blocks": {
        "it": [
            {
                "name": {
                    "it": "Logo",
                    "en": "Logo"
                },
                "type": "logo",
                "data": {
                    "view": "pub_theme::components.blocks.logo",
                    "src": "patient::images/logo.svg",
                    "alt": "Logo SaluteOra",
                    "width": 150,
                    "height": 32
                }
            },
            {
                "name": {
                    "it": "Menu di Navigazione",
                    "en": "Navigation Menu"
                },
                "type": "navigation",
                "data": {
                    "view": "pub_theme::components.blocks.navigation",
                    "items": [
                        {
                            "label": "Home",
                            "url": "/",
                            "type": "link"
                        },
                        {
                            "label": "Servizi",
                            "url": "/servizi",
                            "type": "link"
                        },
                        {
                            "label": "Chi Siamo",
                            "url": "/chi-siamo",
                            "type": "link"
                        },
                        {
                            "label": "Contatti",
                            "url": "/contatti",
                            "type": "link"
                        }
                    ],
                    "alignment": "start",
                    "orientation": "horizontal"
                }
            },
            {
                "name": {
                    "it": "Selettore Lingua",
                    "en": "Language Selector"
                },
                "type": "language-selector",
                "data": {
                    "view": "pub_theme::components.blocks.language-selector",
                    "items": {
                        "it": "Italiano",
                        "en": "English"
                    }
                }
            },
            {
                "name": {
                    "it": "Avatar Utente",
                    "en": "User Avatar"
                },
                "type": "user-avatar",
                "data": {
                    "view": "pub_theme::components.blocks.user-avatar"
                }
            }
        ],
        "en": [
            {
                "name": {
                    "it": "Logo",
                    "en": "Logo"
                },
                "type": "logo",
                "data": {
                    "view": "pub_theme::components.blocks.logo",
                    "src": "patient::images/logo.svg",
                    "alt": "SaluteOra Logo",
                    "width": 150,
                    "height": 32
                }
            },
            {
                "name": {
                    "it": "Menu di Navigazione",
                    "en": "Navigation Menu"
                },
                "type": "navigation",
                "data": {
                    "view": "pub_theme::components.blocks.navigation",
                    "items": [
                        {
                            "label": "Home",
                            "url": "/",
                            "type": "link"
                        },
                        {
                            "label": "Services",
                            "url": "/services",
                            "type": "link"
                        },
                        {
                            "label": "About Us",
                            "url": "/about-us",
                            "type": "link"
                        },
                        {
                            "label": "Contact",
                            "url": "/contact",
                            "type": "link"
                        }
                    ],
                    "alignment": "start",
                    "orientation": "horizontal"
                }
            },
            {
                "name": {
                    "it": "Selettore Lingua",
                    "en": "Language Selector"
                },
                "type": "language-selector",
                "data": {
                    "view": "pub_theme::components.blocks.language-selector",
                    "items": {
                        "it": "Italiano",
                        "en": "English"
                    }
                }
            },
            {
                "name": {
                    "it": "Avatar Utente",
                    "en": "User Avatar"
                },
                "type": "user-avatar",
                "data": {
                    "view": "pub_theme::components.blocks.user-avatar"
                }
            }
        ]
    },
    "attributes": {
        "class": "sticky top-0 z-50 bg-white dark:bg-gray-900 border-b border-gray-200 dark:border-gray-800",
        "id": "main-header"
    }
}
```

## Considerazioni Importanti

1. **Localizzazione degli URL**: Tutti gli URL utilizzano `app()->getLocale()` per garantire che mantengano la lingua corrente.

2. **Componenti Filament**: Utilizziamo i componenti Blade nativi di Filament per garantire coerenza con il resto dell'applicazione.

3. **Accessibilità**: I componenti includono attributi ARIA e testo per screen reader.

4. **Responsive Design**: I componenti sono progettati per funzionare sia su desktop che su dispositivi mobili.

5. **Sicurezza**: Il form di logout utilizza il metodo POST con token CSRF per prevenire attacchi CSRF.

## Implementazione Tecnica

1. Creare i componenti Blade descritti sopra
2. Aggiornare il file JSON dell'header
3. Testare la funzionalità in diverse lingue
4. Verificare il comportamento per utenti autenticati e non autenticati

## Collegamenti Utili

- [Documentazione Alpine.js](https://alpinejs.dev/) - Per le interazioni dropdown
- [Documentazione Filament](https://filamentphp.com/docs) - Per i componenti UI
- [Documentazione Laravel Localization](https://laravel.com/docs/10.x/localization) - Per la gestione delle lingue
