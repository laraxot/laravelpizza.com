# Struttura dei Layout e Componenti Blade in il progetto

Questo documento analizza in dettaglio la struttura dei layout e dei componenti Blade utilizzati in il progetto, con particolare attenzione all'architettura a cascata dei layout e all'integrazione con Filament e Livewire.

## Indice
1. [Architettura dei Layout](#architettura-dei-layout)
2. [Componenti UI](#componenti-ui)
3. [Integrazione Filament](#integrazione-filament)
4. [Integrazione Livewire](#integrazione-livewire)
5. [Best Practices](#best-practices)

## Architettura dei Layout

il progetto utilizza un'architettura a cascata per i layout, con tre livelli principali:

### 1. Layout Base (main.blade.php)

Il layout `main.blade.php` è il layout principale che fornisce la struttura HTML di base:

```blade
<!-- /Themes/One/resources/views/components/layouts/main.blade.php -->
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        
        <!-- Script per il dark mode -->
        <script>
            if (typeof(Storage) !== "undefined") {
                if(localStorage.getItem('dark_mode') && localStorage.getItem('dark_mode') == 'true'){
                    document.documentElement.classList.add('dark');
                }
            }
        </script>

        @filamentStyles
        @vite(['resources/css/app.css', 'resources/js/app.js'],'themes/One')

        <title>{{ $title ?? 'Genesis' }}</title>
    </head>
    <body class="min-h-screen antialiased bg-white dark:bg-gradient-to-b dark:from-gray-950 dark:to-gray-900">
        {{ $slot }}
        <livewire:toast />
        @livewire('notifications')
        @filamentScripts
        @vite(['resources/js/app.js'],'themes/One')
    </body>
</html>
```

Questo layout:
- Definisce la struttura HTML di base
- Carica gli stili e gli script di Filament
- Carica le risorse con Vite
- Fornisce uno slot per il contenuto
- Include componenti Livewire per notifiche

### 2. Layout Applicazione (app.blade.php)

Il layout `app.blade.php` estende il layout principale e aggiunge elementi specifici dell'applicazione:

```blade
<!-- /Themes/One/resources/views/components/layouts/app.blade.php -->
<x-layouts.main>
    <x-ui.marketing.header />
    
    <!-- Page Heading -->
    @if (isset($header))
        <header class="mb-5 bg-white border-b border-gray-200/80 dark:border-gray-200/10 dark:bg-gray-900/40">
            <div class="px-4 py-6 mx-auto max-w-7xl sm:px-6 lg:px-8">
                {{ $header }}
            </div>
        </header>
    @endif
    
    <div class="mx-auto mt-5 max-w-7xl">
        <div class="sm:px-6 lg:px-8">
            {{ $slot }}
        </div>
    </div>
</x-layouts.main>
```

Questo layout:
- Estende il layout principale
- Aggiunge l'header di marketing
- Fornisce uno slot opzionale per l'intestazione della pagina
- Definisce un contenitore per il contenuto principale

### 3. Pagine Specifiche

Le pagine specifiche utilizzano il layout dell'applicazione e forniscono il contenuto specifico:

```blade
<!-- /Themes/One/resources/views/pages/auth/register.blade.php -->
<x-layouts.app>
    <div class="max-w-lg mx-auto p-6">
        <h1 class="text-2xl font-medium text-blue-900 mb-8">Registrazione</h1>

        @livewire(\Modules\User\Filament\Widgets\RegistrationWidget::class)
    </div>
</x-layouts.app>
```

## Componenti UI

il progetto utilizza un sistema di componenti UI modulare, organizzato in namespace:

### Struttura dei Componenti UI

```
/Themes/One/resources/views/components/ui/
  ├── app/
  │   └── header.blade.php        # Header per l'applicazione
  ├── marketing/
  │   ├── header.blade.php        # Header per le pagine di marketing
  │   ├── breadcrumbs.blade.php   # Breadcrumbs per le pagine di marketing
  │   └── page-header.blade.php   # Intestazione pagina per marketing
  ├── badge.blade.php             # Componente badge
  ├── button.blade.php            # Componente pulsante
  ├── checkbox.blade.php          # Componente checkbox
  ├── input.blade.php             # Componente input
  ├── light-dark-switch.blade.php # Switch tema chiaro/scuro
  ├── link.blade.php              # Componente link
  ├── logo.blade.php              # Logo dell'applicazione
  ├── nav-link.blade.php          # Link di navigazione
  └── ...
```

### Header di Marketing

L'header di marketing (`<x-ui.marketing.header />`) è utilizzato nelle pagine pubbliche e di autenticazione:

```blade
<!-- /Themes/One/resources/views/components/ui/marketing/header.blade.php -->
<header class="w-full">
    <div class="relative z-20 flex items-center justify-between w-full h-20 max-w-6xl px-6 mx-auto">
        <div x-data="{ mobileMenuOpen: false }" class="relative flex items-center md:space-x-2 text-neutral-800">
            
            <div class="relative z-50 flex items-center w-auto h-full">
                <a href="{{ route('home') }}" class="flex items-center mr-0 md:mr-5 shrink-0">
                    <x-ui.logo class="block w-auto text-gray-800 fill-current h-7 dark:text-gray-200" />
                </a>
                <!-- Toggle menu mobile -->
            </div>
            
            <!-- Menu di navigazione -->
            <nav class="flex flex-col w-full p-6 space-y-2 bg-white md:p-0 md:flex-row md:space-x-2 md:space-y-0 md:w-auto md:bg-transparent md:flex">
                <x-ui.nav-link href="/">Home</x-ui.nav-link>
                <x-ui.nav-link href="/genesis/about">About</x-ui.nav-link>
                @if(view()->exists('pages.blog.index'))
                    <x-ui.nav-link href="/blog">Blog</x-ui.nav-link>
                @endif
                <x-ui.nav-link href="/genesis/power-ups">Power-ups</x-ui.nav-link>
            </nav>
        </div>
        
        <!-- Switch tema chiaro/scuro e pulsanti di autenticazione -->
    </div>
</header>
```

## Integrazione Filament

il progetto integra Filament per la gestione dei form e dei widget:

### Widget di Registrazione

Il widget di registrazione è implementato come un widget Filament:

```php
// /Modules/User/Filament/Widgets/RegistrationWidget.php
namespace Modules\User\Filament\Widgets;

use Filament\Forms\Form;
use Filament\Widgets\Widget;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Wizard;
use Filament\Forms\Components\Wizard\Step;
use Filament\Forms\Concerns\InteractsWithForms;
use Modules\Xot\Contracts\UserContract;

class RegistrationWidget extends Widget implements HasForms
{
    use InteractsWithForms;

    protected static string $view = 'user::filament.widgets.registration';
    protected int | string | array $columnSpan = 'full';

    public ?array $data = [];

    public function mount(): void
    {
        $this->form->fill();
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Wizard::make([
                    Step::make('Dati Personali')
                        ->schema([/* ... */]),
                    Step::make('Credenziali')
                        ->schema([/* ... */]),
                    Step::make('Privacy')
                        ->schema([/* ... */]),
                ])
            ])
            ->statePath('data');
    }

    public function register(): \Illuminate\Http\RedirectResponse
    {
        $state = $this->form->getState();

        /** @var UserContract $user */
        $user = app(UserContract::class)::create([
            'name' => $state['name'],
            'surname' => $state['surname'],
            'email' => $state['email'],
            'password' => Hash::make($state['password']),
        ]);

        event(new Registered($user));
        Auth::login($user);

        return redirect()->route('filament.admin.pages.dashboard');
    }
}
```

### Vista del Widget

La vista del widget è un semplice form Livewire:

```blade
<!-- /Modules/User/resources/views/filament/widgets/registration.blade.php -->
<div>
    <form wire:submit.prevent="register">
        {{ $this->form }}
    </form>

    <div class="text-sm text-center text-gray-600 mt-6">
        Hai già un account? <a href="{{ route('login') }}" class="text-blue-800 hover:underline">Accedi</a>
    </div>
</div>
```

## Integrazione Livewire

il progetto utilizza Livewire per componenti interattivi:

### Utilizzo di Livewire nelle Pagine

```blade
<!-- Esempio di utilizzo di un componente Livewire -->
@livewire(\Modules\User\Filament\Widgets\RegistrationWidget::class)
```

### Comunicazione tra Componenti

Livewire viene utilizzato per la comunicazione tra componenti:

- Eventi Livewire per notifiche
- Componenti Toast per feedback all'utente
- Aggiornamento dinamico dei form

## Best Practices

### Root Element Unico nei Componenti Blade/Livewire

**Regola fondamentale:** Ogni componente Blade o Livewire deve avere **un solo elemento radice** (root element). Se si inseriscono più elementi radice a livello superiore, Livewire restituirà un errore come:

```
Livewire\Features\SupportMultipleRootElementDetection\MultipleRootElementsDetectedException
Livewire only supports one HTML element per component. Multiple root elements detected for component: [...]
```

**Esempio di errore:**
```blade
<!-- ERRATO -->
<x-layouts.app>
    ...
</x-layouts.app>
<div>...</div>
```

**Soluzione corretta:**
```blade
<!-- CORRETTO -->
<x-layouts.app>
    ...
    <div>...</div>
</x-layouts.app>
```

Questa regola garantisce compatibilità con Livewire, Blade e le best practice frontend di il progetto. Consultare la sezione "Troubleshooting" per altri errori comuni e relative soluzioni.

[Approfondisci: Livewire Troubleshooting](./frontoffice/auth-blades.md#troubleshooting)


### 1. Struttura a Cascata dei Layout

il progetto utilizza una struttura a cascata dei layout:
- Layout base (`main.blade.php`) per la struttura HTML
- Layout applicazione (`app.blade.php`) per elementi comuni
- Pagine specifiche per il contenuto

### 2. Namespace dei Componenti

I componenti sono organizzati in namespace logici:
- `ui` per componenti UI generici
- `ui.app` per componenti specifici dell'applicazione
- `ui.marketing` per componenti di marketing
- `layouts` per i layout dell'applicazione

### 3. Convenzioni di Naming

il progetto segue convenzioni di naming coerenti:
- Layout: `layouts/nome-layout.blade.php`
- Componenti UI: `ui/nome-componente.blade.php`
- Componenti specifici: `ui/categoria/nome-componente.blade.php`

### 4. Integrazione Filament e Livewire

L'integrazione di Filament e Livewire segue queste best practices:
- Widget Filament in `Modules/NomeModulo/Filament/Widgets`
- Viste Blade in `Modules/NomeModulo/resources/views/filament/widgets`
- Utilizzo di `@livewire()` per includere componenti Livewire
- Utilizzo di `@filamentStyles` e `@filamentScripts` nei layout

### 5. Struttura dei Namespace

La struttura corretta dei namespace in il progetto è:
- `Modules\NomeModulo\Filament\Widgets` per i widget Filament
- `Modules\NomeModulo\Livewire` per i componenti Livewire
- `Modules\NomeModulo\Http\Controllers` per i controller
- `Modules\NomeModulo\Models` per i modelli

## Conclusione

La struttura dei layout e componenti Blade in il progetto è progettata per essere modulare, riutilizzabile e facile da mantenere. L'architettura a cascata dei layout, combinata con un sistema di componenti UI organizzato in namespace, consente di creare un'interfaccia coerente e flessibile.

L'integrazione con Filament e Livewire aggiunge potenti funzionalità di gestione dei form e interattività, mantenendo al contempo una struttura di codice pulita e organizzata.

Seguendo le best practices documentate in questo documento, gli sviluppatori possono estendere e mantenere efficacemente l'interfaccia utente di il progetto.
