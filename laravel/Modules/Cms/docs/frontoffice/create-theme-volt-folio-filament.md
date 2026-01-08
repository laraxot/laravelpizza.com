# Creazione di un Tema con Volt, Folio e Filament

## Introduzione

Questa guida descrive come creare un nuovo tema per il CMS utilizzando una combinazione di tecnologie moderne tra cui Volt, Folio, Filament, Flowbite e Tailwind CSS. Questa soluzione offre un approccio full-stack Laravel con componenti reattivi e un'interfaccia amministrativa potente.

## Prerequisiti

1. Node.js e npm installati
2. Accesso alla directory dei temi
3. Conoscenza base di Vite e Tailwind CSS
4. PHP 8.1+
5. Laravel v10.0+
6. Flowbite v2.0+

## Passo 1: Installazione e Configurazione Base

```bash
# Installare il pacchetto Flowbite Laravel
composer require flowbite/flowbite-laravel

# Installare Folio
composer require livewire/folio

# Installare Volt
composer require livewire/volt

# Installare Filament
composer require filament/filament

# Pubblicare le migrazioni
php artisan vendor:publish --tag="flowbite-laravel-migrations"
php artisan migrate

# Pubblicare il file di configurazione
php artisan vendor:publish --tag="flowbite-laravel-config"

# Pubblicare le viste
php artisan vendor:publish --tag="flowbite-laravel-views"
```

## Passo 2: Configurazione di Vite

```javascript
// vite.config.js
import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import path from 'path';

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
    resolve: {
        alias: {
            '@': path.resolve(__dirname, './resources/js'),
        },
    },
});
```

## Passo 3: Configurazione di Flowbite e Tailwind

```javascript
// tailwind.config.js
import preset from './vendor/filament/support/tailwind.config.preset'

/** @type {import('tailwindcss').Config} */
export default {
    presets: [preset],
    content: [
        "./index.html",
        "./src/**/*.{vue,js,ts,jsx,tsx}",
        "./node_modules/flowbite/**/*.js",
        './app/Filament/**/*.php',
        './resources/views/filament/**/*.blade.php',
        './vendor/filament/**/*.blade.php',
        './vendor/flowbite/**/*.blade.php',
        './resources/views/**/*.blade.php',
        './resources/js/**/*.js',
    ],
    theme: {
        extend: {
            colors: {
                primary: {
                    50: '#f0f9ff',
                    100: '#e0f2fe',
                    200: '#bae6fd',
                    300: '#7dd3fc',
                    400: '#38bdf8',
                    500: '#0ea5e9',
                    600: '#0284c7',
                    700: '#0369a1',
                    800: '#075985',
                    900: '#0c4a6e',
                },
            },
        },
    },
    plugins: [
        require('@tailwindcss/forms'),
        require('@tailwindcss/typography'),
        require('flowbite/plugin'),
    ],
}
```

## Passo 4: Componenti Volt con Flowbite

```php
<?php

use Livewire\Volt\Component;
use Livewire\Attributes\Layout;

new #[Layout('components.layouts.app')] class extends Component {
    public $name = '';
    public $email = '';
    public $password = '';
    public $password_confirmation = '';

    public function mount()
    {
        $this->name = auth()->user()->name;
        $this->email = auth()->user()->email;
    }

    public function updateProfile()
    {
        $this->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email,' . auth()->id()],
        ]);

        auth()->user()->update([
            'name' => $this->name,
            'email' => $this->email,
        ]);

        $this->dispatch('profile-updated');
    }

    public function updatePassword()
    {
        $this->validate([
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        auth()->user()->update([
            'password' => Hash::make($this->password),
        ]);

        $this->reset('password', 'password_confirmation');
        $this->dispatch('password-updated');
    }
}; ?>

<div>
    <div class="max-w-7xl mx-auto py-10 sm:px-6 lg:px-8">
        <div class="md:grid md:grid-cols-3 md:gap-6">
            <div class="md:col-span-1">
                <div class="px-4 sm:px-0">
                    <h3 class="text-lg font-medium leading-6 text-gray-900">Informazioni Profilo</h3>
                    <p class="mt-1 text-sm text-gray-600">
                        Aggiorna le informazioni del tuo profilo e l'indirizzo email.
                    </p>
                </div>
            </div>

            <div class="mt-5 md:mt-0 md:col-span-2">
                <form wire:submit="updateProfile">
                    <div class="px-4 py-5 bg-white sm:p-6 shadow sm:rounded-tl-md sm:rounded-tr-md">
                        <div class="grid grid-cols-6 gap-6">
                            <div class="col-span-6 sm:col-span-4">
                                <label for="name" class="block text-sm font-medium text-gray-700">Nome</label>
                                <input type="text" wire:model="name" id="name" class="mt-1 focus:ring-primary-500 focus:border-primary-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                                @error('name') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                            </div>

                            <div class="col-span-6 sm:col-span-4">
                                <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                                <input type="email" wire:model="email" id="email" class="mt-1 focus:ring-primary-500 focus:border-primary-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                                @error('email') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                            </div>
                        </div>
                    </div>

                    <div class="flex items-center justify-end px-4 py-3 bg-gray-50 text-right sm:px-6 shadow sm:rounded-bl-md sm:rounded-br-md">
                        <button type="submit" class="inline-flex items-center px-4 py-2 bg-primary-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-primary-700 focus:bg-primary-700 active:bg-primary-900 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:ring-offset-2 transition ease-in-out duration-150">
                            Salva
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <div class="hidden sm:block" aria-hidden="true">
            <div class="py-5">
                <div class="border-t border-gray-200"></div>
            </div>
        </div>

        <div class="mt-10 sm:mt-0">
            <div class="md:grid md:grid-cols-3 md:gap-6">
                <div class="md:col-span-1">
                    <div class="px-4 sm:px-0">
                        <h3 class="text-lg font-medium leading-6 text-gray-900">Aggiorna Password</h3>
                        <p class="mt-1 text-sm text-gray-600">
                            Assicurati che il tuo account utilizzi una password lunga e casuale per rimanere sicuro.
                        </p>
                    </div>
                </div>

                <div class="mt-5 md:mt-0 md:col-span-2">
                    <form wire:submit="updatePassword">
                        <div class="px-4 py-5 bg-white sm:p-6 shadow sm:rounded-tl-md sm:rounded-tr-md">
                            <div class="grid grid-cols-6 gap-6">
                                <div class="col-span-6 sm:col-span-4">
                                    <label for="password" class="block text-sm font-medium text-gray-700">Nuova Password</label>
                                    <input type="password" wire:model="password" id="password" class="mt-1 focus:ring-primary-500 focus:border-primary-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                                    @error('password') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                                </div>

                                <div class="col-span-6 sm:col-span-4">
                                    <label for="password_confirmation" class="block text-sm font-medium text-gray-700">Conferma Password</label>
                                    <input type="password" wire:model="password_confirmation" id="password_confirmation" class="mt-1 focus:ring-primary-500 focus:border-primary-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                                </div>
                            </div>
                        </div>

                        <div class="flex items-center justify-end px-4 py-3 bg-gray-50 text-right sm:px-6 shadow sm:rounded-bl-md sm:rounded-br-md">
                            <button type="submit" class="inline-flex items-center px-4 py-2 bg-primary-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-primary-700 focus:bg-primary-700 active:bg-primary-900 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                Salva
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
```

## Passo 5: Layout Base con Folio

```php
<?php

use Livewire\Volt\Component;
use Livewire\Attributes\Layout;

new #[Layout('components.layouts.app')] class extends Component {
    public function mount()
    {
        //
    }
}; ?>

<div>
    <div class="min-h-screen bg-gray-100">
        <nav class="bg-white border-b border-gray-100">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between h-16">
                    <div class="flex">
                        <div class="shrink-0 flex items-center">
                            <a href="{{ route('dashboard') }}">
                                <x-application-logo class="block h-9 w-auto fill-current text-gray-800" />
                            </a>
                        </div>

                        <div class="hidden space-x-8 sm:-my-px sm:ml-10 sm:flex">
                            <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                                Dashboard
                            </x-nav-link>
                        </div>
                    </div>

                    <div class="hidden sm:flex sm:items-center sm:ml-6">
                        <x-dropdown align="right" width="48">
                            <x-slot name="trigger">
                                <button class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 bg-white hover:text-gray-700 focus:outline-none transition ease-in-out duration-150">
                                    <div>{{ Auth::user()->name }}</div>

                                    <div class="ml-1">
                                        <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                        </svg>
                                    </div>
                                </button>
                            </x-slot>

                            <x-slot name="content">
                                <x-dropdown-link :href="route('profile.edit')">
                                    Profilo
                                </x-dropdown-link>

                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <x-dropdown-link :href="route('logout')"
                                            onclick="event.preventDefault();
                                                        this.closest('form').submit();">
                                        Logout
                                    </x-dropdown-link>
                                </form>
                            </x-slot>
                        </x-dropdown>
                    </div>

                    <div class="-mr-2 flex items-center sm:hidden">
                        <button @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 focus:text-gray-500 transition duration-150 ease-in-out">
                            <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                                <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                                <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>
                </div>
            </div>

            <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden">
                <div class="pt-2 pb-3 space-y-1">
                    <x-responsive-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                        Dashboard
                    </x-responsive-nav-link>
                </div>

                <div class="pt-4 pb-1 border-t border-gray-200">
                    <div class="px-4">
                        <div class="font-medium text-base text-gray-800">{{ Auth::user()->name }}</div>
                        <div class="font-medium text-sm text-gray-500">{{ Auth::user()->email }}</div>
                    </div>

                    <div class="mt-3 space-y-1">
                        <x-responsive-nav-link :href="route('profile.edit')">
                            Profilo
                        </x-responsive-nav-link>

                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <x-responsive-nav-link :href="route('logout')"
                                    onclick="event.preventDefault();
                                                this.closest('form').submit();">
                                Logout
                            </x-responsive-nav-link>
                        </form>
                    </div>
                </div>
            </div>
        </nav>

        <header class="bg-white shadow">
            <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                    {{ $header }}
                </h2>
            </div>
        </header>

        <main>
            {{ $slot }}
        </main>
    </div>
</div>
```

## Passo 6: Struttura Directory

```
resources/
├── js/
│   ├── Components/
│   │   ├── Button.js
│   │   ├── Card.js
│   │   └── Navbar.js
│   ├── Layouts/
│   │   └── AppLayout.js
│   ├── Pages/
│   │   ├── Dashboard/
│   │   ├── Blog/
│   │   └── Portfolio/
│   └── app.js
└── views/
    └── pages/
        ├── auth/
        ├── dashboard/
        ├── genesis/
        ├── learn/
        ├── profile/
        └── index.blade.php
```

## Passo 7: Deployment e Manutenzione

1. **Build del Tema**
```bash
npm run build
```

2. **Verifica della Build**
```bash
npm run preview
```

3. **Copiatura degli Asset**
```bash
npm run copy
```

## Troubleshooting

### Problemi Comuni

1. **Errori di Build**
   - Verificare le versioni delle dipendenze
   - Controllare la configurazione di Vite
   - Assicurarsi che tutti i file necessari siano presenti

2. **Problemi di Stile**
   - Verificare la configurazione di Tailwind
   - Controllare l'ordine degli import CSS
   - Assicurarsi che i plugin siano configurati correttamente

3. **Problemi di Volt**
   - Verificare la configurazione di Volt
   - Controllare i componenti
   - Assicurarsi che le dipendenze siano installate correttamente

4. **Problemi di Filament**
   - Verificare la configurazione di Filament
   - Controllare i provider
   - Assicurarsi che le rotte siano configurate correttamente

## Risorse Utili

- [Documentazione Folio](https://github.com/livewire/folio)
- [Documentazione Volt](https://github.com/livewire/volt)
- [Documentazione Filament](https://filamentphp.com/docs)
- [Documentazione Flowbite](https://flowbite.com/docs/getting-started/introduction/)
- [Documentazione Flowbite Laravel](https://github.com/themesberg/flowbite-laravel)

## Alternative

Se preferisci utilizzare un framework frontend moderno, puoi consultare le guide per:
- [Creazione di un tema con Vue.js](create_theme_vue.md)
- [Creazione di un tema con React](create_theme_react.md)
- [Creazione di un tema con Laravel](create_theme.md)
