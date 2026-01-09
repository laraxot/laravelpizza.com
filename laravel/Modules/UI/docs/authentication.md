# Autenticazione

## Architettura

Il sistema di autenticazione utilizza:
- **Folio** per la gestione delle pagine di autenticazione
- **Livewire Volt** per la gestione dello stato e delle interazioni
- **Laravel Localization** per la gestione delle traduzioni

## Struttura

### Pagine di Autenticazione
Le pagine di autenticazione si trovano in `Themes/One/resources/views/pages/auth/`:
- `login.blade.php` - Pagina di accesso
- `register.blade.php` - Pagina di registrazione
- `forgot-password.blade.php` - Pagina di recupero password
- `reset-password.blade.php` - Pagina di reset password

### Componenti UI
I componenti UI utilizzati si trovano in `Themes/One/resources/views/components/ui/`:
- `input.blade.php` - Campo di input
- `button.blade.php` - Pulsante
- `checkbox.blade.php` - Checkbox
- `text-link.blade.php` - Link testuale
- `logo.blade.php` - Logo

## Best Practices

### 1. Folio
- Utilizzare il middleware `guest` per le pagine di autenticazione
- Definire il nome della pagina con `name()`
- Utilizzare il layout principale con `<x-layouts.main>`

```php
use function Laravel\Folio\{middleware, name};

middleware(['guest']);
name('login');
```

### 2. Livewire Volt
- Utilizzare attributi di validazione
- Gestire gli eventi di autenticazione
- Utilizzare i componenti UI esistenti

```php
use Livewire\Attributes\Validate;
use Livewire\Volt\Component;

new class extends Component
{
    #[Validate('required|email')]
    public $email = '';

    #[Validate('required')]
    public $password = '';

    public function authenticate()
    {
        $this->validate();
        // Logica di autenticazione
    }
};
```

### 3. Localizzazione
- Utilizzare le chiavi di traduzione per i testi
- Non hardcodare i testi nelle view
- Utilizzare i file di traduzione in `resources/lang`

```blade
<h2>{{ __('auth.login.title') }}</h2>
<x-ui.button>{{ __('auth.login.submit') }}</x-ui.button>
```

### 4. UI/UX
- Utilizzare i componenti UI esistenti
- Mantenere la coerenza visiva
- Supportare il tema scuro
- Rendere l'interfaccia responsive

```blade
<x-ui.input
    label="{{ __('auth.login.email') }}"
    type="email"
    id="email"
    name="email"
    wire:model="email"
/>
```

## Esempi

### ❌ Non Fare

```php
// Non creare controller manualmente
class AuthController extends Controller
{
    public function login()
    {
        return view('auth.login');
    }
}

// Non aggiungere route manualmente
Route::get('/login', [AuthController::class, 'login']);

// Non hardcodare i testi
<h2>Sign in to your account</h2>
```

### ✅ Fare

```php
// Utilizzare Folio per la pagina
use function Laravel\Folio\{middleware, name};

middleware(['guest']);
name('login');

// Utilizzare Livewire Volt per la logica
new class extends Component
{
    #[Validate('required|email')]
    public $email = '';

    public function authenticate()
    {
        $this->validate();
        // Logica di autenticazione
    }
};

// Utilizzare i componenti UI e le traduzioni
<x-layouts.main>
    <h2>{{ __('auth.login.title') }}</h2>
    <x-ui.input label="{{ __('auth.login.email') }}" />
</x-layouts.main>
```

## Collegamenti Correlati
- [Documentazione Folio](https://laravel.com/docs/folio)
- [Documentazione Livewire Volt](https://livewire.laravel.com/docs/volt)
- [Documentazione Laravel Localization](https://github.com/mcamara/laravel-localization)
- [Best Practices UI](./UI_BEST_PRACTICES.md)
- [Regole Architetturali](./ARCHITECTURE_RULES.md)
