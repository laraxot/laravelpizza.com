# Route

## Configurazione Base

### Route
```php
// config/route.php
return [
    'default' => 'web',
    'middleware' => [
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
    ],
];
```

## Route Base

### Web Routes
```php
// routes/web.php
use App\Http\Controllers\HomeController;
use App\Http\Controllers\UserController;

Route::get('/', [HomeController::class, 'index'])->name('home');

Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    
    Route::resource('users', UserController::class);
    
    Route::prefix('admin')->middleware(['role:admin'])->group(function () {
        Route::get('/settings', [SettingController::class, 'index'])->name('settings');
    });
});
```

### API Routes
```php
// routes/api.php
use App\Http\Controllers\Api\UserController;

Route::prefix('v1')->group(function () {
    Route::post('/login', [AuthController::class, 'login']);
    
    Route::middleware(['auth:sanctum'])->group(function () {
        Route::get('/user', [UserController::class, 'show']);
        Route::apiResource('users', UserController::class);
    });
});
```

## Best Practices

### 1. Struttura
- Organizzare per dominio
- Utilizzare i gruppi
- Implementare i middleware
- Documentare le route

### 2. Performance
- Ottimizzare le query
- Utilizzare le cache
- Implementare il rate limiting
- Monitorare le route

### 3. Sicurezza
- Proteggere le route
- Implementare l'autenticazione
- Gestire i permessi
- Implementare il logging

### 4. Manutenzione
- Monitorare le route
- Gestire le versioni
- Implementare alerting
- Documentare le route

## Esempi di Utilizzo

### Route con Parametri
```php
Route::get('/users/{user}/posts/{post}', [PostController::class, 'show'])
    ->name('users.posts.show')
    ->where('user', '[0-9]+')
    ->where('post', '[0-9]+');
```

### Route con Middleware
```php
Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});
```

## Strumenti Utili

### Comandi Artisan
```bash
# Listare le route
php artisan route:list

# Pulire la cache delle route
php artisan route:clear

# Generare la cache delle route
php artisan route:cache
```

### Middleware
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

## Gestione degli Errori

### Errori di Route
```php
try {
    Route::get('/users/{user}', [UserController::class, 'show']);
} catch (\Exception $e) {
    Log::error('Errore nella route', [
        'route' => '/users/{user}',
        'error' => $e->getMessage(),
    ]);
}
```

### Logging
```php
use Illuminate\Support\Facades\Route;

Route::matched(function ($route, $request) {
    Log::info('Route matched', [
        'uri' => $request->getUri(),
        'method' => $request->getMethod(),
        'name' => $route->getName(),
    ]);
});
```

## Cache delle Route

### Cache Manuale
```php
use Illuminate\Support\Facades\Route;

$routes = Route::getRoutes();
Cache::put('routes', $routes, 3600);
```

### Cache Automatica
```php
// In un service provider
use Illuminate\Support\Facades\Route;

Route::pattern('id', '[0-9]+');
Route::pattern('slug', '[a-z0-9-]+');
``` 