# Implementazione Corretta delle Pagine di Autenticazione con Volt e Folio

## Collegamenti correlati
- [README modulo User](./README.md)
- [Convenzioni Path](./PATH_CONVENTIONS.md)
- [Volt Errors](./VOLT_ERRORS.md)
- [Volt Folio Logout](./VOLT_FOLIO_LOGOUT.md)

## Introduzione

Questo documento descrive l'implementazione corretta delle pagine di autenticazione (login, logout, registrazione, ecc.) utilizzando Laravel Folio e Volt . Seguendo queste linee guida, garantirai che le tue implementazioni siano conformi alle convenzioni del progetto e sfruttino al meglio le capacità di Volt e Folio.

## Cos'è Volt e Folio?

**Volt** è un'API funzionale per Livewire che supporta componenti a file singolo, permettendo alla logica PHP e ai template Blade di coesistere nello stesso file. Dietro le quinte, l'API funzionale viene compilata in componenti di classe Livewire.

**Folio** è un sistema di routing basato su file per Laravel che permette di creare pagine semplicemente aggiungendo file nella directory `resources/views/pages`.

## Struttura Corretta dei File

Le pagine di autenticazione devono essere collocate in:
```
Themes/One/resources/views/pages/auth/
```

### Esempi di File
- `login.blade.php` - Pagina di login
- `logout.blade.php` - Pagina di logout
- `register.blade.php` - Pagina di registrazione
- `password/reset.blade.php` - Reset password
- `password/email.blade.php` - Richiesta reset password
- `verify.blade.php` - Verifica email

## Implementazione Corretta

### 1. Approccio Funzionale (Raccomandato)

Questo approccio utilizza l'API funzionale di Volt:

```php
<?php
declare(strict_types=1);

use Illuminate\Support\Facades\Auth;
use function Laravel\Folio\{middleware, name};
use function Livewire\Volt\{state};

middleware(['auth']);
name('logout');

// Stato del componente
state([]);

// Azione di logout
$logout = function () {
    if (Auth::check()) {
        Auth::logout();
        request()->session()->invalidate();
        request()->session()->regenerateToken();
    }

    // Reindirizzamento localizzato
    $locale = app()->getLocale();
    return redirect()->to('/' . $locale);
};
?>

<x-layouts.main>
    @volt
    <div class="min-h-screen flex items-center justify-center bg-gray-100">
        <div class="max-w-md w-full space-y-8 p-8 bg-white rounded-lg shadow-lg">
            <div class="text-center">
                <h2 class="mt-6 text-3xl font-extrabold text-gray-900">
                    {{ __('Logout effettuato con successo') }}
                </h2>
                <p class="mt-2 text-sm text-gray-600">
                    {{ __('Verrai reindirizzato alla home page tra pochi secondi...') }}
                </p>
            </div>

            <div class="mt-8">
                <x-filament::button
                    tag="a"
                    href="{{ url('/' . app()->getLocale()) }}"
                    color="primary"
                    class="w-full"
                >
                    {{ __('Torna alla Home') }}
                </x-filament::button>
            </div>
        </div>
    </div>

    <script>
        // Esegui il logout immediatamente
        window.livewire.dispatch('logout');

        // Reindirizza dopo 3 secondi
        setTimeout(() => {
            window.location.href = "{{ url('/' . app()->getLocale()) }}";
        }, 3000);
    </script>
    @endvolt
</x-layouts.main>
```

### 2. Approccio con Classe Anonima

Questo approccio utilizza una classe anonima che estende `Livewire\Volt\Component`:

```php
<?php
declare(strict_types=1);

use Illuminate\Support\Facades\Auth;
use function Laravel\Folio\{middleware, name};
use Livewire\Volt\Component;

middleware(['auth']);
name('logout');

new class extends Component {
    public function mount()
    {
        if (Auth::check()) {
            Auth::logout();
            request()->session()->invalidate();
            request()->session()->regenerateToken();
        }
    }

    public function logout()
    {
        $locale = app()->getLocale();
        return redirect()->to('/' . $locale);
    }

    public function render()
    {
        return <<<'BLADE'
        <div class="min-h-screen flex items-center justify-center bg-gray-100">
            <div class="max-w-md w-full space-y-8 p-8 bg-white rounded-lg shadow-lg">
                <div class="text-center">
                    <h2 class="mt-6 text-3xl font-extrabold text-gray-900">
                        {{ __('Logout effettuato con successo') }}
                    </h2>
                    <p class="mt-2 text-sm text-gray-600">
                        {{ __('Verrai reindirizzato alla home page tra pochi secondi...') }}
                    </p>
                </div>

                <div class="mt-8">
                    <x-filament::button
                        tag="a"
                        href="{{ url('/' . app()->getLocale()) }}"
                        color="primary"
                        class="w-full"
                    >
                        {{ __('Torna alla Home') }}
                    </x-filament::button>
                </div>
            </div>
        </div>

        <script>
            setTimeout(() => {
                window.location.href = "{{ url('/' . app()->getLocale()) }}";
            }, 3000);
        </script>
        BLADE;
    }
};
?>

<x-layouts.main>
    @volt('logout')
    @endvolt
</x-layouts.main>
```

### 3. Approccio Diretto (Solo per Pagine Semplici)

Per pagine molto semplici, puoi utilizzare un approccio diretto con Folio:

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
    request()->session()->invalidate();
    request()->session()->regenerateToken();
}

// Reindirizza l'utente alla home page localizzata
$locale = app()->getLocale();
return redirect()->to('/' . $locale);
?>
```

## Esempi di Implementazione per Altre Pagine di Autenticazione

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
    <div class="flex flex-col items-stretch justify-center w-screen min-h-screen py-10 sm:items-center">
        <div class="sm:mx-auto sm:w-full sm:max-w-md">
            <x-filament::section>
                <x-slot:heading>
                    {{ __('Accedi al tuo account') }}
                </x-slot:heading>

                <form wire:submit="authenticate">
                    <div class="space-y-6">
                        <div>
                            <x-filament::input.wrapper
                                wire:model="email"
                                label="{{ __('Email') }}"
                                required
                            >
                                <x-filament::input
                                    type="email"
                                    placeholder="{{ __('nome@esempio.com') }}"
                                    autofocus
                                    autocomplete="email"
                                />
                            </x-filament::input.wrapper>
                        </div>

                        <div>
                            <x-filament::input.wrapper
                                wire:model="password"
                                label="{{ __('Password') }}"
                                required
                            >
                                <x-filament::input
                                    type="password"
                                    autocomplete="current-password"
                                />
                            </x-filament::input.wrapper>
                        </div>

                        <div class="flex items-center justify-between">
                            <x-filament::input.checkbox
                                wire:model="remember"
                                label="{{ __('Ricordami') }}"
                            />

                            <x-filament::link
                                href="{{ url('/' . app()->getLocale() . '/auth/password/reset') }}"
                                color="primary"
                            >
                                {{ __('Password dimenticata?') }}
                            </x-filament::link>
                        </div>

                        <div>
                            <x-filament::button
                                type="submit"
                                color="primary"
                                class="w-full"
                            >
                                {{ __('Accedi') }}
                            </x-filament::button>
                        </div>
                    </div>
                </form>

                <div class="mt-6 text-center">
                    <x-filament::link
                        href="{{ url('/' . app()->getLocale() . '/auth/register') }}"
                        color="primary"
                    >
                        {{ __('Non hai un account? Registrati') }}
                    </x-filament::link>
                </div>
            </x-filament::section>
        </div>
    </div>
</x-layouts.main>
```

### Registrazione

```php
<?php
declare(strict_types=1);

use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use function Laravel\Folio\{middleware, name};
use function Livewire\Volt\{state};
use Livewire\Attributes\Validate;
use Livewire\Volt\Component;
use Modules\User\Models\User;

middleware(['guest']);
name('register');

new class extends Component {
    #[Validate('required|string|max:255')]
    public $name = '';

    #[Validate('required|email|max:255|unique:users,email')]
    public $email = '';

    #[Validate('required|string|min:8|confirmed')]
    public $password = '';

    public $password_confirmation = '';

    public function register()
    {
        $this->validate();

        $user = User::create([
            'name' => $this->name,
            'email' => $this->email,
            'password' => Hash::make($this->password),
        ]);

        event(new Registered($user));

        Auth::login($user);

        // Reindirizzamento localizzato
        $locale = app()->getLocale();
        return redirect()->to('/' . $locale . '/auth/verify');
    }
};
?>

<x-layouts.main>
    <div class="flex flex-col items-stretch justify-center w-screen min-h-screen py-10 sm:items-center">
        <div class="sm:mx-auto sm:w-full sm:max-w-md">
            <x-filament::section>
                <x-slot:heading>
                    {{ __('Crea un nuovo account') }}
                </x-slot:heading>

                <form wire:submit="register">
                    <div class="space-y-6">
                        <div>
                            <x-filament::input.wrapper
                                wire:model="name"
                                label="{{ __('Nome') }}"
                                required
                            >
                                <x-filament::input
                                    type="text"
                                    autofocus
                                    autocomplete="name"
                                />
                            </x-filament::input.wrapper>
                        </div>

                        <div>
                            <x-filament::input.wrapper
                                wire:model="email"
                                label="{{ __('Email') }}"
                                required
                            >
                                <x-filament::input
                                    type="email"
                                    placeholder="{{ __('nome@esempio.com') }}"
                                    autocomplete="email"
                                />
                            </x-filament::input.wrapper>
                        </div>

                        <div>
                            <x-filament::input.wrapper
                                wire:model="password"
                                label="{{ __('Password') }}"
                                required
                            >
                                <x-filament::input
                                    type="password"
                                    autocomplete="new-password"
                                />
                            </x-filament::input.wrapper>
                        </div>

                        <div>
                            <x-filament::input.wrapper
                                wire:model="password_confirmation"
                                label="{{ __('Conferma Password') }}"
                                required
                            >
                                <x-filament::input
                                    type="password"
                                    autocomplete="new-password"
                                />
                            </x-filament::input.wrapper>
                        </div>

                        <div>
                            <x-filament::button
                                type="submit"
                                color="primary"
                                class="w-full"
                            >
                                {{ __('Registrati') }}
                            </x-filament::button>
                        </div>
                    </div>
                </form>

                <div class="mt-6 text-center">
                    <x-filament::link
                        href="{{ url('/' . app()->getLocale() . '/auth/login') }}"
                        color="primary"
                    >
                        {{ __('Hai già un account? Accedi') }}
                    </x-filament::link>
                </div>
            </x-filament::section>
        </div>
    </div>
</x-layouts.main>
```

## Regole Importanti da Seguire

1. **Localizzazione degli URL**
   - Tutti gli URL devono includere il prefisso della lingua come primo segmento del percorso
   - Usa sempre `app()->getLocale()` per ottenere la lingua corrente
   - Genera link localizzati con `url('/' . app()->getLocale() . '/percorso')`

2. **Componenti UI**
   - Usa sempre i componenti Blade nativi di Filament (es. `<x-filament::button>`, `<x-filament::input>`)
   - Non usare componenti UI personalizzati o HTML diretto
   - Non usare il metodo `->label()` nei componenti Filament

3. **Struttura del Codice**
   - Separa la logica PHP dal template Blade
   - Usa l'approccio funzionale o la classe anonima in base alla complessità
   - Segui le convenzioni di naming e struttura di <nome progetto>

4. **Sicurezza**
   - Invalida e rigenera sempre la sessione dopo il logout
   - Usa la validazione per tutti gli input
   - Implementa la protezione CSRF

## Troubleshooting

### Problemi Comuni

1. **Errore: Component not found**
   - Verifica che il namespace del componente sia corretto
   - Assicurati che il componente sia registrato correttamente

2. **Errore: Property not found on component**
   - Verifica che tutte le proprietà siano definite correttamente
   - Controlla che le proprietà siano accessibili nel template

3. **Errore: Route not found**
   - Verifica che il file sia nella directory corretta
   - Controlla che il nome della route sia definito correttamente

### Soluzioni

1. **Pulizia della Cache**
   ```bash
   php artisan view:clear
   php artisan route:clear
   php artisan cache:clear
   ```

2. **Rigenerazione dell'Autoloader**
   ```bash
   composer dump-autoload
   ```

3. **Verifica delle Route**
   ```bash
   php artisan route:list
   ```

## Conclusione

Seguendo queste linee guida per l'implementazione delle pagine di autenticazione con Volt e Folio, garantirai che il tuo codice sia conforme alle convenzioni di <nome progetto>, sia facile da mantenere e sfrutti al meglio le capacità di Laravel, Livewire, Volt e Folio.

## Riferimenti

- [Documentazione Volt](https://livewire.laravel.com/docs/volt)
- [Documentazione Folio](https://laravel.com/docs/10.x/folio)
- [Documentazione Livewire](https://livewire.laravel.com/docs)
