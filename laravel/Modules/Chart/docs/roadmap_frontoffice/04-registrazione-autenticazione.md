# Implementazione Registrazione e Autenticazione

## Descrizione del Task
Questo documento descrive l'implementazione del sistema di registrazione e autenticazione per il frontoffice di il progetto, dedicato sia alle gestanti che agli odontoiatri.

## Stato Attuale
- **Completamento**: 85%
- **Responsabile**: Team Frontoffice
- **Ultimo aggiornamento**: Aprile 2025

## Implementazione

### 1. Modulo User (Completato)
Il modulo User di base è già implementato utilizzando il pacchetto Laravel Modules di nwidart e le estensioni Laraxot. Il modulo gestisce:

- Registrazione utenti
- Autenticazione
- Recupero password
- Profili utente base

#### Configurazione attuale
```php
// laravel/Modules/User/Config/config.php
return [
    'name' => 'User',
    'guard' => 'web',
    'registration' => [
        'enabled' => true,
        'requires_verification' => true,
        'requires_approval' => true,
    ],
    'roles' => [
        'gestante',
        'odontoiatra',
        'admin'
    ]
];
```

### 2. Sistema di Ruoli e Permessi (Completato)
Utilizziamo Spatie Permission con estensioni custom per gestire i diversi ruoli dell'applicazione:

```php
// laravel/Modules/User/Providers/UserServiceProvider.php
public function boot()
{
    // Altre configurazioni...
    
    // Registrazione ruoli base
    if (Schema::hasTable('roles') && Role::count() === 0) {
        Role::create(['name' => 'admin']);
        Role::create(['name' => 'gestante']);
        Role::create(['name' => 'odontoiatra']);
    }
}
```

### 3. Registrazione Gestanti (Completato)
La registrazione delle gestanti include:

- Form di registrazione con validazione
- Upload documentazione ISEE
- Upload documentazione gravidanza
- Verifica email
- Attesa approvazione amministratore

#### Livewire Component implementato:
```php
// laravel/Modules/User/Http/Livewire/Registration/GestanteForm.php
namespace Modules\User\Http\Livewire\Registration;

use Livewire\Component;
use Livewire\WithFileUploads;
use Modules\User\Models\User;
use Illuminate\Support\Facades\Hash;
use Spatie\LaravelData\Data;

class GestanteForm extends Component
{
    use WithFileUploads;
    
    public string $name = '';
    public string $email = '';
    public string $password = '';
    public string $password_confirmation = '';
    public $isee_document = null;
    public $pregnancy_document = null;
    
    // Regole di validazione
    protected $rules = [
        'name' => 'required|string|max:255',
        'email' => 'required|string|email|max:255|unique:users',
        'password' => 'required|string|min:8|confirmed',
        'isee_document' => 'required|file|mimes:pdf,jpg,png|max:5120',
        'pregnancy_document' => 'required|file|mimes:pdf,jpg,png|max:5120',
    ];
    
    // Implementazione metodo save
    // ...
}
```

### 4. Registrazione Odontoiatri (In corso - 80%)
La registrazione degli odontoiatri include:

- Form di registrazione con validazione
- Upload documenti professionali
- Verifica multi-step
- Approvazione amministrativa

#### Cosa manca:
- Completare validazione documenti professionali
- Finire workflow approvazione multi-step

### 5. Autenticazione Multi-Fattore (Da completare - 0%)
Sarà implementata utilizzando il pacchetto Laravel Fortify con:

- Autenticazione tramite email/password
- Seconda verifica tramite codice SMS
- Opzione per utilizzo app autenticatore

## Implementazione URL con Locale

Tutte le rotte di autenticazione rispettano la convenzione URL con locale come primo segmento:

```php
// laravel/Modules/User/Routes/web.php
Route::prefix('{locale}')->middleware('locale')->group(function () {
    Route::prefix('auth')->group(function () {
        Route::get('login', [AuthController::class, 'showLoginForm'])->name('login');
        Route::post('login', [AuthController::class, 'login']);
        Route::post('logout', [AuthController::class, 'logout'])->name('logout');
        
        Route::get('register', [RegisterController::class, 'showRegistrationForm'])->name('register');
        Route::post('register', [RegisterController::class, 'register']);
        
        Route::get('password/reset', [ForgotPasswordController::class, 'showLinkRequestForm'])->name('password.request');
        // Altre rotte...
    });
});
```

Tutte le URL generate nei form e nei link utilizzano la locale corrente:

```php
<form method="POST" action="{{ route('login', ['locale' => app()->getLocale()]) }}">
    <!-- Form content -->
</form>
```

## Dipendenze

- ✅ Modulo User
- ✅ Modulo UI (per componenti form)
- ✅ Modulo Notification (per email di verifica)
- ✅ Modulo GDPR (per consensi privacy)
- ⚠️ Modulo Patient (per collegamento gestante)
- ⚠️ Modulo Dental (per collegamento odontoiatra)

## Test

Tutti i test sono implementati utilizzando Pest (non PHPUnit):

```php
// laravel/Modules/User/Tests/Feature/RegistrationTest.php
use Modules\User\Models\User;

test('gestante can register with valid data', function () {
    $response = $this->post(route('register', ['locale' => 'it']), [
        'name' => 'Test Gestante',
        'email' => 'gestante@example.com',
        'password' => 'password',
        'password_confirmation' => 'password',
        'role' => 'gestante',
        // Altri dati...
    ]);
    
    $response->assertRedirect(route('verification.notice', ['locale' => 'it']));
    $this->assertDatabaseHas('users', [
        'email' => 'gestante@example.com',
    ]);
});
```

## Prossimi Passi

1. Completare la registrazione odontoiatri con validazione documenti professionali
2. Implementare l'autenticazione a due fattori
3. Migliorare il processo di recupero password
4. Aggiungere opzione di login con SPID (Sistema Pubblico di Identità Digitale)

## Links ai File Principali

- [Modulo User](/var/www/html/base_<nome progetto>/laravel/Modules/User/)
- [Modulo GDPR](/var/www/html/base_<nome progetto>/laravel/Modules/Gdpr/)
- [Roadmap Frontoffice](/var/www/html/base_<nome progetto>/docs/roadmap_frontoffice.md)
