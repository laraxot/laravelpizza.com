# Middleware

## Configurazione Base

### Kernel
```php
// app/Http/Kernel.php
namespace App\Http;

use Illuminate\Foundation\Http\Kernel as HttpKernel;

class Kernel extends HttpKernel
{
    protected $middleware = [
        \App\Http\Middleware\TrustProxies::class,
        \Illuminate\Http\Middleware\HandleCors::class,
        \App\Http\Middleware\PreventRequestsDuringMaintenance::class,
        \Illuminate\Foundation\Http\Middleware\ValidatePostSize::class,
        \App\Http\Middleware\TrimStrings::class,
        \Illuminate\Foundation\Http\Middleware\ConvertEmptyStringsToNull::class,
    ];

    protected $middlewareGroups = [
        'web' => [
            \App\Http\Middleware\EncryptCookies::class,
            \Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse::class,
            \Illuminate\Session\Middleware\StartSession::class,
            \Illuminate\View\Middleware\ShareErrorsFromSession::class,
            \App\Http\Middleware\VerifyCsrfToken::class,
            \Illuminate\Routing\Middleware\SubstituteBindings::class,
        ],

        'api' => [
            'throttle:api',
            \Illuminate\Routing\Middleware\SubstituteBindings::class,
        ],
    ];

    protected $routeMiddleware = [
        'auth' => \App\Http\Middleware\Authenticate::class,
        'auth.basic' => \Illuminate\Auth\Middleware\AuthenticateWithBasicAuth::class,
        'cache.headers' => \Illuminate\Http\Middleware\SetCacheHeaders::class,
        'can' => \Illuminate\Auth\Middleware\Authorize::class,
        'guest' => \App\Http\Middleware\RedirectIfAuthenticated::class,
        'password.confirm' => \Illuminate\Auth\Middleware\RequirePassword::class,
        'signed' => \Illuminate\Routing\Middleware\ValidateSignature::class,
        'throttle' => \Illuminate\Routing\Middleware\ThrottleRequests::class,
        'verified' => \Illuminate\Auth\Middleware\EnsureEmailIsVerified::class,
    ];
}
```

## Middleware Base

### Middleware Semplice
```php
namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CheckAge
{
    public function handle(Request $request, Closure $next)
    {
        if ($request->age < 18) {
            return redirect('home');
        }

        return $next($request);
    }
}
```

### Middleware con Parametri
```php
namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CheckRole
{
    public function handle(Request $request, Closure $next, $role)
    {
        if (!$request->user() || !$request->user()->hasRole($role)) {
            abort(403);
        }

        return $next($request);
    }
}
```

## Best Practices

### 1. Struttura
- Organizzare per dominio
- Utilizzare i gruppi
- Implementare i parametri
- Documentare i middleware

### 2. Performance
- Ottimizzare le query
- Utilizzare le cache
- Implementare il rate limiting
- Monitorare i middleware

### 3. Sicurezza
- Validare i dati
- Proteggere le route
- Implementare il logging
- Gestire i fallimenti

### 4. Manutenzione
- Monitorare i middleware
- Gestire le versioni
- Implementare alerting
- Documentare i middleware

## Esempi di Utilizzo

### Middleware di Autenticazione
```php
namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class Authenticate
{
    public function handle(Request $request, Closure $next)
    {
        if (!auth()->check()) {
            return redirect()->route('login');
        }

        return $next($request);
    }
}
```

### Middleware di Cache
```php
namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CacheResponse
{
    public function handle(Request $request, Closure $next)
    {
        $response = $next($request);

        if ($request->isMethod('GET')) {
            $response->header('Cache-Control', 'public, max-age=3600');
        }

        return $response;
    }
}
```

## Strumenti Utili

### Comandi Artisan
```bash
# Creare un middleware
php artisan make:middleware CheckRole

# Listare i middleware
php artisan middleware:list
```

### Registrazione
```php
// In un service provider
use Illuminate\Support\Facades\Route;

Route::aliasMiddleware('role', \App\Http\Middleware\CheckRole::class);
```

## Gestione degli Errori

### Errori di Middleware
```php
try {
    return $next($request);
} catch (\Exception $e) {
    Log::error('Errore nel middleware', [
        'middleware' => get_class($this),
        'error' => $e->getMessage(),
    ]);
    
    return response()->json([
        'message' => 'Errore interno del server',
    ], 500);
}
```

### Logging
```php
use Illuminate\Support\Facades\Log;

public function handle(Request $request, Closure $next)
{
    Log::info('Richiesta in entrata', [
        'url' => $request->fullUrl(),
        'method' => $request->method(),
    ]);

    $response = $next($request);

    Log::info('Risposta in uscita', [
        'status' => $response->status(),
    ]);

    return $response;
}
```

## Middleware Avanzati

### Rate Limiting
```php
namespace App\Http\Middleware;

use Closure;
use Illuminate\Cache\RateLimiter;
use Illuminate\Http\Request;

class RateLimit
{
    protected $limiter;

    public function __construct(RateLimiter $limiter)
    {
        $this->limiter = $limiter;
    }

    public function handle(Request $request, Closure $next, $maxAttempts = 60)
    {
        $key = $request->ip();

        if ($this->limiter->tooManyAttempts($key, $maxAttempts)) {
            return response()->json([
                'message' => 'Troppe richieste',
            ], 429);
        }

        $this->limiter->hit($key);

        return $next($request);
    }
}
```

### CORS
```php
namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class Cors
{
    public function handle(Request $request, Closure $next)
    {
        $response = $next($request);

        $response->headers->set('Access-Control-Allow-Origin', '*');
        $response->headers->set('Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE, OPTIONS');
        $response->headers->set('Access-Control-Allow-Headers', 'Content-Type, Authorization');

        return $response;
    }
}
``` 