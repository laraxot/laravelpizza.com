# Best Practices per Volt e Folio

## Collegamenti correlati
- [README modulo Xot](./README.md)
- [Struttura dei moduli](./MODULE_STRUCTURE.md)
- [Convenzioni di Path](../User/docs/PATH_CONVENTIONS.md)
- [Implementazione Auth con Volt e Folio](../User/docs/VOLT_FOLIO_AUTH_IMPLEMENTATION.md)
- [Analisi Logout Blade](../User/docs/LOGOUT_BLADE_ANALYSIS.md)

## Introduzione

Questo documento definisce le best practices per l'utilizzo di Laravel Folio e Livewire Volt , con particolare attenzione alle pagine di autenticazione e alle convenzioni di progetto.

## Approcci Raccomandati per Volt e Folio

### 1. Approccio Folio con PHP puro

Questo approccio è raccomandato per operazioni semplici che non richiedono gestione dello stato o interazione complessa con l'utente.

```php
<?php
declare(strict_types=1);

use Illuminate\Support\Facades\Auth;
use function Laravel\Folio\{middleware, name};

middleware(['auth']);
name('logout');

// Esegui il logout
if (Auth::check()) {
    Auth::logout();
    session()->invalidate();
    session()->regenerateToken();
}

// Reindirizza l'utente alla home page localizzata
$locale = app()->getLocale();
return redirect()->to('/' . $locale);
?>
```

### 2. Volt Action dedicata

Questo approccio utilizza una Volt Action dedicata con attributi PHP 8 per definire la rotta:

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

### 3. Folio con Volt

Questo approccio utilizza Volt all'interno di una pagina Folio:

```blade
<?php
declare(strict_types=1);

use Illuminate\Support\Facades\Auth;
use function Laravel\Folio\{middleware, name};
use function Livewire\Volt\{state, mount};

middleware(['auth']);
name('logout');

state([]);

mount(function() {
    if(Auth::check()) {
        Auth::logout();
        session()->invalidate();
        session()->regenerateToken();
    }
    
    // Reindirizza alla home page localizzata
    $this->redirect('/' . app()->getLocale());
});
?>

<x-layouts.main>
    @volt('auth.logout')
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
    @endvolt
</x-layouts.main>
```

## Linee Guida Generali

### Struttura del File

1. **Dichiarazione PHP**: Iniziare sempre con `<?php declare(strict_types=1);`
2. **Namespace e Import**: Importare tutte le classi e funzioni necessarie
3. **Direttive Folio**: Utilizzare `middleware()` e `name()` per definire il middleware e il nome della rotta
4. **Logica PHP**: Posizionare tutta la logica PHP all'inizio del file
5. **Template Blade**: Posizionare il template Blade dopo la logica PHP

### Convenzioni di Naming

1. **File e Cartelle**: Tutto in lowercase, separare parole con `-`
2. **Componenti Volt**: Utilizzare nomi descrittivi in PascalCase
3. **Variabili di Stato**: Utilizzare nomi descrittivi in camelCase
4. **Azioni**: Utilizzare nomi descrittivi in camelCase che descrivono l'azione (es. `logout`, `authenticate`)

### Localizzazione degli URL

1. **Recuperare la Locale**: Utilizzare sempre `app()->getLocale()` per ottenere la lingua corrente
2. **Generare URL Localizzati**: Includere sempre la locale negli URL generati
3. **Reindirizzamenti**: Utilizzare sempre URL localizzati nei reindirizzamenti

```php
$locale = app()->getLocale();
return redirect()->to('/' . $locale . '/dashboard');
```

### Componenti UI

1. **Componenti Filament**: Utilizzare sempre i componenti Blade nativi di Filament
2. **Evitare HTML Diretto**: Non utilizzare HTML diretto per elementi UI
3. **Traduzione**: Utilizzare sempre `{{ __('chiave') }}` per le traduzioni

```blade
<x-filament::button
    wire:click="logout"
    color="danger"
    class="w-full"
>
    {{ __('Logout') }}
</x-filament::button>
```

## Scelta dell'Approccio

La scelta dell'approccio dipende dalla complessità del componente:

1. **Approccio Folio con PHP puro**: Per operazioni semplici senza gestione dello stato
2. **Volt Action dedicata**: Per operazioni che richiedono validazione o logica complessa
3. **Folio con Volt**: Per componenti che richiedono gestione dello stato e interazione con l'utente

## Esempi di Implementazione

### Login

```php
<?php
declare(strict_types=1);

use Illuminate\Auth\Events\Login;
use Illuminate\Support\Facades\Auth;
use function Laravel\Folio\{middleware, name};
use function Livewire\Volt\{state};
use Livewire\Attributes\Validate;
use Livewire\Volt\Component;

middleware(['guest']);
name('login');

new class extends Component {
    #[Validate('required|email')]
    public $email = '';

    #[Validate('required')]
    public $password = '';

    public $remember = false;

    public function authenticate()
    {
        $this->validate();

        if (!Auth::attempt(['email' => $this->email, 'password' => $this->password], $this->remember)) {
            $this->addError('email', trans('auth.failed'));
            return;
        }

        event(new Login(auth()->guard('web'), auth()->user(), $this->remember));

        // Reindirizzamento localizzato
        $locale = app()->getLocale();
        return redirect()->intended('/' . $locale);
    }
};
?>

<x-layouts.main>
    <!-- Template Blade qui -->
</x-layouts.main>
```

### Logout

```php
<?php
declare(strict_types=1);

use Illuminate\Support\Facades\Auth;
use function Laravel\Folio\{middleware, name};

middleware(['auth']);
name('logout');

// Esegui il logout
if (Auth::check()) {
    Auth::logout();
    session()->invalidate();
    session()->regenerateToken();
}

// Reindirizza l'utente alla home page localizzata
$locale = app()->getLocale();
return redirect()->to('/' . $locale);
?>
```

## Conclusione

Seguendo queste best practices per l'utilizzo di Volt e Folio, garantirai che il tuo codice sia conforme alle convenzioni di <nome progetto>, sia facile da mantenere e sfrutti al meglio le capacità di Laravel, Livewire, Volt e Folio.

## Riferimenti

- [Documentazione Volt](https://livewire.laravel.com/docs/volt)
- [Documentazione Folio](https://laravel.com/docs/10.x/folio)
- [Documentazione Livewire](https://livewire.laravel.com/docs)
- [Documentazione Filament](https://filamentphp.com/docs)
