# Sicurezza

## Configurazione Base

### Autenticazione
```php
// config/auth.php
return [
    'defaults' => [
        'guard' => 'web',
        'passwords' => 'users',
    ],
    'guards' => [
        'web' => [
            'driver' => 'session',
            'provider' => 'users',
        ],
        'api' => [
            'driver' => 'sanctum',
            'provider' => 'users',
        ],
    ],
];
```

### CORS
```php
// config/cors.php
return [
    'paths' => ['api/*'],
    'allowed_methods' => ['*'],
    'allowed_origins' => [env('FRONTEND_URL', 'http://localhost:3000')],
    'allowed_origins_patterns' => [],
    'allowed_headers' => ['*'],
    'exposed_headers' => [],
    'max_age' => 0,
    'supports_credentials' => true,
];
```

## Sicurezza Base

### Middleware di Sicurezza
```php
namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class SecurityHeaders
{
    public function handle(Request $request, Closure $next)
    {
        $response = $next($request);

        $response->headers->set('X-Frame-Options', 'SAMEORIGIN');
        $response->headers->set('X-XSS-Protection', '1; mode=block');
        $response->headers->set('X-Content-Type-Options', 'nosniff');
        $response->headers->set('Referrer-Policy', 'strict-origin-when-cross-origin');
        $response->headers->set('Content-Security-Policy', "default-src 'self'");

        return $response;
    }
}
```

### Validazione Input
```php
namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends FormRequest
{
    public function rules()
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ];
    }
}
```

## Best Practices

### 1. Autenticazione
- Utilizzare password forti
- Implementare 2FA
- Gestire le sessioni
- Implementare rate limiting

### 2. Autorizzazione
- Utilizzare i gates
- Implementare i policies
- Verificare i permessi
- Loggare gli accessi

### 3. Input
- Sanitizzare gli input
- Validare i dati
- Utilizzare prepared statements
- Implementare CSRF protection

### 4. Output
- Sanitizzare l'output
- Utilizzare escape appropriati
- Implementare Content Security Policy
- Proteggere contro XSS

## Esempi di Utilizzo

### Autenticazione a Due Fattori
```php
namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\Hash;

class TwoFactorAuth
{
    public function enable(User $user)
    {
        $user->two_factor_secret = encrypt(random_bytes(32));
        $user->two_factor_enabled = true;
        $user->save();
    }

    public function verify(User $user, $code)
    {
        return Hash::check($code, $user->two_factor_secret);
    }
}
```

### Rate Limiting
```php
// routes/api.php
Route::middleware(['throttle:60,1'])->group(function () {
    Route::post('/login', [AuthController::class, 'login']);
    Route::post('/register', [AuthController::class, 'register']);
});
```

## Strumenti Utili

### Pacchetti Consigliati
- [Laravel Sanctum](https://laravel.com/docs/sanctum)
- [Laravel Security](https://laravel.com/docs/security)
- [Laravel Fortify](https://laravel.com/docs/fortify)
- [Laravel Breeze](https://laravel.com/docs/breeze)

### Comandi Artisan
```bash
# Generare una nuova chiave
php artisan key:generate

# Pulire la cache
php artisan cache:clear

# Rigenerare le chiavi
php artisan config:clear
```

## Monitoraggio della Sicurezza

### Logging degli Accessi
```php
namespace App\Services;

use Illuminate\Support\Facades\Log;

class SecurityLogger
{
    public function logAccess($user, $action)
    {
        Log::channel('security')->info('Accesso', [
            'user_id' => $user->id,
            'action' => $action,
            'ip' => request()->ip(),
            'user_agent' => request()->userAgent(),
            'timestamp' => now(),
        ]);
    }
}
```

### Monitoraggio delle Violazioni
```php
namespace App\Services;

use Illuminate\Support\Facades\Log;

class SecurityMonitor
{
    public function logViolation($type, $details)
    {
        Log::channel('security')->warning('Violazione di Sicurezza', [
            'type' => $type,
            'details' => $details,
            'ip' => request()->ip(),
            'timestamp' => now(),
        ]);
    }
}
``` 