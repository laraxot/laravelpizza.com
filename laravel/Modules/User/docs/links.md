# Collegamenti User

> **Nota:** Tutti i link devono essere corredati da una breve descrizione che spiega il contesto e l'utilità di ciascuna risorsa, per facilitare la consultazione e la manutenzione della documentazione.

## Pacchetti Frontend
- [themesberg/tailwind-laravel-starter](https://github.com/themesberg/tailwind-laravel-starter)
  > Starter kit per Laravel con Tailwind CSS. Fornisce un'interfaccia moderna e responsive per l'autenticazione.

- [themesberg/flowbite-laravel](https://github.com/themesberg/flowbite-laravel)
  > Componenti UI basati su Tailwind per Laravel. Ottimo per creare interfacce utente moderne.

## Pacchetti Autenticazione

### Autenticazione Base
- [laravel/sanctum](https://github.com/laravel/sanctum)
  > API token authentication per Laravel. Essenziale per l'autenticazione API e SPA.

- [laravel/fortify](https://github.com/laravel/fortify)
  > Backend authentication scaffolding. Fornisce funzionalità di autenticazione avanzate.

### Autenticazione Social
- [laravel/socialite](https://github.com/laravel/socialite)
  > OAuth authentication con provider social. Permette login con Google, Facebook, Twitter, etc.

### Gestione Permessi
- [spatie/laravel-permission](https://github.com/spatie/laravel-permission)
  > Gestione avanzata di ruoli e permessi. Sistema completo per il controllo degli accessi.

## Collegamenti ai Moduli Correlati

### Moduli Core
- [Modulo Lang](../../../Lang/docs/links.md)
  > Gestione delle traduzioni per l'interfaccia utente. Internazionalizzazione del sistema di autenticazione.

- [Modulo GDPR](../../../Gdpr/docs/links.md)
  > Gestione della privacy e dei consensi utente. Conformità con le normative sulla protezione dei dati.

### Moduli di Supporto
- [Modulo Notify](../../../Notify/docs/links.md)
  > Sistema di notifiche per gli utenti. Gestione delle notifiche di autenticazione e sicurezza.

- [Modulo Profile](../../../Profile/docs/links.md)
  > Gestione dei profili utente. Personalizzazione e gestione delle informazioni utente.

## Implementazioni di Esempio

### Model User
```php
namespace Modules\User\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Spatie\Permission\Traits\HasRoles;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasRoles;

    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];
}
```

### Controller Autenticazione
```php
namespace Modules\User\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Modules\User\Data\UserData;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::attempt($credentials)) {
            $token = $request->user()->createToken('auth-token');
            return response()->json([
                'token' => $token->plainTextToken,
                'user' => UserData::from($request->user()),
            ]);
        }

        return response()->json([
            'message' => 'Credenziali non valide',
        ], 401);
    }
}
```

## Best Practices

### 1. Sicurezza
- Implementare autenticazione a due fattori
- Gestire la rotazione delle password
- Monitorare i tentativi di accesso
- Implementare il rate limiting

### 2. Privacy
- Rispettare il GDPR
- Gestire i consensi
- Proteggere i dati sensibili
- Implementare la cancellazione account

### 3. Performance
- Ottimizzare le query
- Implementare il caching
- Gestire le sessioni
- Monitorare le prestazioni

### 4. Manutenzione
- Gestire gli aggiornamenti
- Implementare i backup
- Monitorare gli accessi
- Documentare le modifiche

## Strumenti Utili

### Comandi Artisan
```bash

# Creare un nuovo utente
php artisan user:create

# Assegnare un ruolo
php artisan user:role {user} {role}

# Revocare un ruolo
php artisan user:revoke-role {user} {role}

# Verificare gli utenti inattivi
php artisan user:inactive
```

### Middleware
```php
namespace Modules\User\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class EnsureUserHasRole
{
    public function handle(Request $request, Closure $next, $role)
    {
        if (!$request->user() || !$request->user()->hasRole($role)) {
            abort(403, 'Accesso non autorizzato.');
        }

        return $next($request);
    }
}
```

## Gestione Eventi

### Eventi Utente
```php
namespace Modules\User\Events;

use Illuminate\Foundation\Events\Dispatchable;
use Modules\User\Models\User;

class UserLoggedIn
{
    use Dispatchable;

    public function __construct(public User $user)
    {
    }
}
```

### Listener
```php
namespace Modules\User\Listeners;

use Modules\User\Events\UserLoggedIn;
use Illuminate\Support\Facades\Log;

class LogSuccessfulLogin
{
    public function handle(UserLoggedIn $event)
    {
        Log::info('Accesso utente', [
            'user_id' => $event->user->id,
            'email' => $event->user->email,
            'ip' => request()->ip(),
        ]);
    }
}
```

## Gestione Errori

### Exception Handler
```php
namespace Modules\User\Exceptions;

use Exception;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;

class Handler extends ExceptionHandler
{
    public function render($request, Exception $exception)
    {
        if ($exception instanceof AuthenticationException) {
            return response()->json([
                'message' => 'Non autenticato',
            ], 401);
        }

        return parent::render($request, $exception);
    }
}
```

### Logging
```php
use Illuminate\Support\Facades\Log;

Log::channel('user')->info('Azione utente', [
    'user' => auth()->user()->id,
    'action' => 'login',
    'timestamp' => now(),
]);
```

