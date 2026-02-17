# Implementazione Corretta delle Pagine Auth

## Collegamenti correlati
- [Documentazione centrale](../../../docs/README.md)
- [Collegamenti documentazione](../../../docs/collegamenti-documentazione.md)
- [README modulo User](./README.md)
- [Convenzioni Path](./PATH_CONVENTIONS.md)
- [Volt Errors](./VOLT_ERRORS.md)
- [Volt Folio Logout](./VOLT_FOLIO_LOGOUT.md)
- [Volt Logout Action](./VOLT_LOGOUT_ACTION.md)

## Introduzione

Questo documento descrive l'implementazione corretta delle pagine di autenticazione nel tema One di <nome progetto>, utilizzando Laravel Folio, Livewire Volt e seguendo le convenzioni del progetto.

## Struttura delle Directory

```
laravel/Themes/One/resources/views/pages/auth/
├── login.blade.php      # Pagina di login
├── register.blade.php   # Pagina di registrazione
├── logout.blade.php     # Pagina di logout
├── [type]/              # Registrazione per tipo utente
│   └── register.blade.php
├── password/            # Gestione password
│   ├── [token].blade.php  # Reset password
│   ├── confirm.blade.php  # Conferma password
│   └── reset.blade.php    # Richiesta reset
├── thank-you.blade.php  # Conferma registrazione
└── verify.blade.php     # Verifica email
```

## Approcci di Implementazione

, ci sono tre approcci principali per implementare le pagine di autenticazione:

1. **Folio con Volt (Raccomandato)**: Utilizza Laravel Folio per il routing e Volt per la logica del componente.
2. **Volt Action dedicata**: Utilizza attributi PHP 8 per definire rotte specifiche.
3. **Folio con PHP puro**: Utilizza Laravel Folio senza Volt per pagine semplici come il logout.

## Implementazione delle Pagine Auth

### 1. Login (login.blade.php)

```blade
@volt('auth.login')
    use Illuminate\Support\Facades\Auth;
    use function Livewire\Volt\{state, rules, mount};

    state([
        'email' => '',
        'password' => '',
        'remember' => false,
    ]);

    rules([
        'email' => ['required', 'email'],
        'password' => ['required'],
    ]);

    $login = function() {
        $this->validate();

        if (Auth::attempt(['email' => $this->email, 'password' => $this->password], $this->remember)) {
            session()->regenerate();

            // Reindirizza alla home page localizzata
            return redirect()->to('/' . app()->getLocale());
        }

        $this->addError('email', __('Le credenziali fornite non sono corrette.'));
    };
@endvolt

<x-layout>
    <x-slot:title>
        {{ __('Accedi') }}
    </x-slot>

    <div class="min-h-screen flex items-center justify-center bg-gray-100">
        <div class="max-w-md w-full space-y-8 p-8 bg-white rounded-lg shadow-lg">
            <div class="text-center">
                <h2 class="mt-6 text-3xl font-extrabold text-gray-900">
                    {{ __('Accedi al tuo account') }}
                </h2>
            </div>

            <form wire:submit="login" class="mt-8 space-y-6">
                <div class="space-y-4">
                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-700">
                            {{ __('Email') }}
                        </label>
                        <div class="mt-1">
                            <input id="email" wire:model="email" type="email" required
                                   class="appearance-none block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                        </div>
                        @error('email') <p class="mt-2 text-sm text-red-600">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label for="password" class="block text-sm font-medium text-gray-700">
                            {{ __('Password') }}
                        </label>
                        <div class="mt-1">
                            <input id="password" wire:model="password" type="password" required
                                   class="appearance-none block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                        </div>
                        @error('password') <p class="mt-2 text-sm text-red-600">{{ $message }}</p> @enderror
                    </div>

                    <div class="flex items-center justify-between">
                        <div class="flex items-center">
                            <input id="remember" wire:model="remember" type="checkbox"
                                   class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded">
                            <label for="remember" class="ml-2 block text-sm text-gray-900">
                                {{ __('Ricordami') }}
                            </label>
                        </div>

                        <div class="text-sm">
                            <a href="{{ url(app()->getLocale() . '/auth/password/reset') }}" class="font-medium text-indigo-600 hover:text-indigo-500">
                                {{ __('Password dimenticata?') }}
                            </a>
                        </div>
                    </div>
                </div>

                <div>
                    <x-filament::button
                        type="submit"
                        size="lg"
                        color="primary"
                        class="w-full justify-center">
                        {{ __('Accedi') }}
                    </x-filament::button>
                </div>
            </form>

            <div class="mt-6 text-center">
                <p class="text-sm text-gray-600">
                    {{ __('Non hai un account?') }}
                    <a href="{{ url(app()->getLocale() . '/auth/register') }}" class="font-medium text-indigo-600 hover:text-indigo-500">
                        {{ __('Registrati') }}
                    </a>
                </p>
            </div>
        </div>
    </div>
</x-layout>
```

### 2. Registrazione (register.blade.php)

```blade
@volt('auth.register')
    use Illuminate\Support\Facades\Auth;
    use Illuminate\Support\Facades\Hash;
    use Illuminate\Auth\Events\Registered;
    use Modules\User\Models\User;
    use function Livewire\Volt\{state, rules, mount};

    state([
        'name' => '',
        'email' => '',
        'password' => '',
        'password_confirmation' => '',
        'terms' => false,
    ]);

    rules([
        'name' => ['required', 'string', 'max:255'],
        'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
        'password' => ['required', 'string', 'min:8', 'confirmed'],
        'terms' => ['accepted'],
    ]);

    $register = function() {
        $this->validate();

        $user = User::create([
            'name' => $this->name,
            'email' => $this->email,
            'password' => Hash::make($this->password),
        ]);

        event(new Registered($user));

        Auth::login($user);

        // Reindirizza alla pagina di conferma localizzata
        return redirect()->to('/' . app()->getLocale() . '/auth/thank-you');
    };
@endvolt

<x-layout>
    <x-slot:title>
        {{ __('Registrazione') }}
    </x-slot>

    <div class="min-h-screen flex items-center justify-center bg-gray-100">
        <div class="max-w-md w-full space-y-8 p-8 bg-white rounded-lg shadow-lg">
            <div class="text-center">
                <h2 class="mt-6 text-3xl font-extrabold text-gray-900">
                    {{ __('Crea il tuo account') }}
                </h2>
            </div>

            <form wire:submit="register" class="mt-8 space-y-6">
                <div class="space-y-4">
                    <div>
                        <label for="name" class="block text-sm font-medium text-gray-700">
                            {{ __('Nome completo') }}
                        </label>
                        <div class="mt-1">
                            <input id="name" wire:model="name" type="text" required
                                   class="appearance-none block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                        </div>
                        @error('name') <p class="mt-2 text-sm text-red-600">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-700">
                            {{ __('Email') }}
                        </label>
                        <div class="mt-1">
                            <input id="email" wire:model="email" type="email" required
                                   class="appearance-none block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                        </div>
                        @error('email') <p class="mt-2 text-sm text-red-600">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label for="password" class="block text-sm font-medium text-gray-700">
                            {{ __('Password') }}
                        </label>
                        <div class="mt-1">
                            <input id="password" wire:model="password" type="password" required
                                   class="appearance-none block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                        </div>
                        @error('password') <p class="mt-2 text-sm text-red-600">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label for="password_confirmation" class="block text-sm font-medium text-gray-700">
                            {{ __('Conferma Password') }}
                        </label>
                        <div class="mt-1">
                            <input id="password_confirmation" wire:model="password_confirmation" type="password" required
                                   class="appearance-none block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                        </div>
                    </div>

                    <div class="flex items-center">
                        <input id="terms" wire:model="terms" type="checkbox" required
                               class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded">
                        <label for="terms" class="ml-2 block text-sm text-gray-900">
                            {{ __('Accetto i termini e le condizioni') }}
                        </label>
                        @error('terms') <p class="mt-2 text-sm text-red-600">{{ $message }}</p> @enderror
                    </div>
                </div>

                <div>
                    <x-filament::button
                        type="submit"
                        size="lg"
                        color="primary"
                        class="w-full justify-center">
                        {{ __('Registrati') }}
                    </x-filament::button>
                </div>
            </form>

            <div class="mt-6 text-center">
                <p class="text-sm text-gray-600">
                    {{ __('Hai già un account?') }}
                    <a href="{{ url(app()->getLocale() . '/auth/login') }}" class="font-medium text-indigo-600 hover:text-indigo-500">
                        {{ __('Accedi') }}
                    </a>
                </p>
            </div>
        </div>
    </div>
</x-layout>
```

### 3. Logout (logout.blade.php)

#### Approccio 1: Folio con PHP puro (Raccomandato per logout)

```php
<?php
declare(strict_types=1);

use Illuminate\Support\Facades\Auth;
use function Laravel\Folio\{middleware, name};

middleware(['auth']);
name('logout');

if(Auth::check()) {
    // Esegui il logout
    Auth::logout();

    // Invalida e rigenera la sessione per prevenire session fixation
    request()->session()->invalidate();
    request()->session()->regenerateToken();
}

// Reindirizza l'utente alla home page localizzata
$locale = app()->getLocale();
return redirect()->to('/' . $locale);
?>
```

#### Approccio 2: Volt Action dedicata

Creare un file `Modules/User/app/Http/Volt/LogoutAction.php`:

```php
<?php

declare(strict_types=1);

namespace Modules\User\Http\Volt;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\RedirectResponse;
use Volt\Routing\Attribute\Post;

#[Post('/logout', name: 'logout', middleware: ['web', 'auth'])]
final class LogoutAction
{
    public function __invoke(): RedirectResponse
    {
        Auth::logout();
        session()->invalidate();
        session()->regenerateToken();

        // Reindirizza alla home page localizzata
        $locale = app()->getLocale();
        return redirect()->to('/' . $locale);
    }
}
```

Quindi nel form:

```blade
<form action="{{ route('logout') }}" method="post">
    @csrf
    <x-filament::button type="submit" color="danger">
        {{ __('Logout') }}
    </x-filament::button>
</form>
```

#### Approccio 3: Folio con Volt

```blade
@volt('auth.logout')
    use Illuminate\Support\Facades\Auth;
    use function Livewire\Volt\{mount};

    mount(function() {
        if(Auth::check()) {
            Auth::logout();
            session()->invalidate();
            session()->regenerateToken();
        }

        // Reindirizza alla home page localizzata
        $this->redirect('/' . app()->getLocale());
    });
@endvolt

<x-layout>
    <x-slot:title>
        {{ __('Logout') }}
    </x-slot>

    <div class="min-h-screen flex items-center justify-center bg-gray-100">
        <div class="max-w-md w-full space-y-8 p-8 bg-white rounded-lg shadow-lg">
            <div class="text-center">
                <h2 class="mt-6 text-3xl font-extrabold text-gray-900">
                    {{ __('Logout in corso...') }}
                </h2>
                <p class="mt-2 text-sm text-gray-600">
                    {{ __('Verrai reindirizzato alla home page.') }}
                </p>
            </div>
        </div>
    </div>
</x-layout>
```

## Best Practices

### 1. Struttura dei Componenti Volt

- Iniziare sempre con la direttiva `@volt('namespace.componente')`
- Utilizzare le funzioni helper di Volt (`state`, `mount`, `rules`, ecc.)
- Separare chiaramente la logica PHP dalla vista
- Terminare con `@endvolt`

### 2. Localizzazione degli URL

Includere sempre il prefisso della lingua corrente nei link:

```php
url(app()->getLocale() . '/percorso')
```

### 3. Componenti UI Filament

Utilizzare sempre i componenti Blade nativi di Filament:

```blade
<x-filament::button
    type="submit"
    size="lg"
    color="primary"
    class="w-full justify-center">
    {{ __('Accedi') }}
</x-filament::button>
```

### 4. Gestione delle Traduzioni

Utilizzare sempre la funzione `__()` per le stringhe visualizzate all'utente:

```blade
{{ __('Accedi al tuo account') }}
```

### 5. Sicurezza

- Validare sempre gli input utente
- Rigenerare la sessione dopo login/logout
- Utilizzare Hash per le password
- Implementare protezione CSRF

### 6. Folio vs. Volt vs. PHP puro

- **Pagine complesse con form**: Utilizzare Volt per gestire stato e validazione
- **Pagine semplici di reindirizzamento**: Utilizzare Folio con PHP puro
- **Azioni specifiche**: Utilizzare Volt Action con attributi PHP 8

## Errori Comuni da Evitare

1. **Namespace errati**: Non includere `App` nel namespace dei componenti Livewire
2. **URL non localizzati**: Includere sempre `app()->getLocale()` nei link
3. **Componenti UI personalizzati**: Utilizzare sempre i componenti Filament nativi
4. **Mancanza della direttiva `@volt`**: Necessaria per i componenti Volt
5. **Rotte in `routes/web.php`**: Utilizzare Folio o attributi PHP 8 per le rotte
6. **Mancata rigenerazione della sessione**: Importante per la sicurezza

## Risorse Utili

- [Documentazione ufficiale Volt](https://livewire.laravel.com/docs/volt)
- [Documentazione Laravel Folio](https://laravel.com/docs/10.x/folio)
- [Componenti Filament](https://filamentphp.com/docs/3.x/support/blade-components/overview)
