# Service Provider

## Configurazione Base

### Provider di Base
```php
// config/app.php
'providers' => [
    // Laravel Framework Service Providers...
    Illuminate\Auth\AuthServiceProvider::class,
    Illuminate\Broadcasting\BroadcastServiceProvider::class,
    Illuminate\Bus\BusServiceProvider::class,
    Illuminate\Cache\CacheServiceProvider::class,
    Illuminate\Foundation\Providers\ConsoleSupportServiceProvider::class,
    Illuminate\Cookie\CookieServiceProvider::class,
    Illuminate\Database\DatabaseServiceProvider::class,
    Illuminate\Encryption\EncryptionServiceProvider::class,
    Illuminate\Filesystem\FilesystemServiceProvider::class,
    Illuminate\Foundation\Providers\FoundationServiceProvider::class,
    Illuminate\Hashing\HashServiceProvider::class,
    Illuminate\Mail\MailServiceProvider::class,
    Illuminate\Notifications\NotificationServiceProvider::class,
    Illuminate\Pagination\PaginationServiceProvider::class,
    Illuminate\Pipeline\PipelineServiceProvider::class,
    Illuminate\Queue\QueueServiceProvider::class,
    Illuminate\Redis\RedisServiceProvider::class,
    Illuminate\Auth\Passwords\PasswordResetServiceProvider::class,
    Illuminate\Session\SessionServiceProvider::class,
    Illuminate\Translation\TranslationServiceProvider::class,
    Illuminate\Validation\ValidationServiceProvider::class,
    Illuminate\View\ViewServiceProvider::class,

    // Application Service Providers...
    App\Providers\AppServiceProvider::class,
    App\Providers\AuthServiceProvider::class,
    App\Providers\EventServiceProvider::class,
    App\Providers\RouteServiceProvider::class,
],
```

## Service Provider Base

### Provider Semplice
```php
namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class CustomServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->singleton('custom', function ($app) {
            return new \App\Services\CustomService;
        });
    }

    public function boot()
    {
        // Boot logic here
    }
}
```

### Provider con Configurazione
```php
namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class ConfigServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->mergeConfigFrom(
            __DIR__.'/../config/custom.php', 'custom'
        );
    }

    public function boot()
    {
        $this->publishes([
            __DIR__.'/../config/custom.php' => config_path('custom.php'),
        ], 'config');
    }
}
```

## Best Practices

### 1. Struttura
- Organizzare per dominio
- Separare register e boot
- Documentare i provider
- Gestire le dipendenze

### 2. Performance
- Ottimizzare il boot
- Utilizzare il lazy loading
- Implementare il caching
- Monitorare i provider

### 3. Sicurezza
- Validare le configurazioni
- Proteggere i servizi
- Implementare il logging
- Gestire i fallimenti

### 4. Manutenzione
- Monitorare i provider
- Gestire le versioni
- Implementare alerting
- Documentare i provider

## Esempi di Utilizzo

### Provider di Eventi
```php
namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Event;

class EventServiceProvider extends ServiceProvider
{
    public function boot()
    {
        Event::listen('user.created', function ($user) {
            // Handle user created event
        });

        Event::listen('order.completed', function ($order) {
            // Handle order completed event
        });
    }
}
```

### Provider di Comandi
```php
namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Console\Scheduling\Schedule;

class CommandServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->app->booted(function () {
            $schedule = $this->app->make(Schedule::class);
            
            $schedule->command('emails:send')
                    ->daily()
                    ->at('13:00');
        });
    }
}
```

## Strumenti Utili

### Comandi Artisan
```bash
# Creare un provider
php artisan make:provider CustomServiceProvider

# Listare i provider
php artisan provider:list
```

### Registrazione
```php
// In config/app.php
'providers' => [
    // ...
    App\Providers\CustomServiceProvider::class,
],
```

## Gestione degli Errori

### Errori di Provider
```php
try {
    $this->app->singleton('custom', function ($app) {
        return new \App\Services\CustomService;
    });
} catch (\Exception $e) {
    Log::error('Errore nel provider', [
        'provider' => get_class($this),
        'error' => $e->getMessage(),
    ]);
    
    throw $e;
}
```

### Logging
```php
use Illuminate\Support\Facades\Log;

public function boot()
{
    Log::info('Booting provider', [
        'provider' => get_class($this),
    ]);

    // Boot logic here

    Log::info('Provider booted', [
        'provider' => get_class($this),
    ]);
}
```

## Provider Avanzati

### Provider di Cache
```php
namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Cache;

class CacheServiceProvider extends ServiceProvider
{
    public function boot()
    {
        Cache::extend('custom', function ($app, $config) {
            return Cache::repository(new CustomStore);
        });
    }
}
```

### Provider di Validazione
```php
namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Validator;

class ValidationServiceProvider extends ServiceProvider
{
    public function boot()
    {
        Validator::extend('custom_rule', function ($attribute, $value, $parameters, $validator) {
            return $value === 'custom_value';
        });

        Validator::replacer('custom_rule', function ($message, $attribute, $rule, $parameters) {
            return str_replace(':attribute', $attribute, $message);
        });
    }
}
```

## 🔧 Merge Conflicts Resolution - 2025-11-04

### Problema Risolto
Il `RouteServiceProvider` e `XotBaseRouteServiceProvider` nel modulo Xot contenevano **merge conflicts massivi non risolti** che impedivano l'avvio del server Laravel.

### File Corretti

#### RouteServiceProvider.php (Xot)
- **Problema**: Metodo `registerRoutePattern()` con TRE `if` statements duplicati e solo UNA chiusura `}`
- **Soluzione**: Rimosso duplicazioni, mantenuta versione con spacing coerente

#### XotBaseRouteServiceProvider.php
- **Problema**: Route middleware 'web' registrato 3 volte (linee 60-62)
- **Soluzione**: Mantenuta solo UNA registrazione

#### Pattern Identificati
```php
// ❌ MERGE CONFLICT NON RISOLTO
if (! is_array($langs)) {
if (! is_array($langs)) {
if (!is_array($langs)) {
    $langs = ['it' => 'it', 'en' => 'en'];
}

// ✅ CORRETTO
if (! is_array($langs)) {
    $langs = ['it' => 'it', 'en' => 'en'];
}
```

### Regole PSR-4 Applicate

**FONDAMENTALE**: I namespace Laraxot NON includono il segmento `app/`!

```php
// File location: Modules/Xot/app/Providers/RouteServiceProvider.php
// ✅ CORRECT namespace:
namespace Modules\Xot\Providers;

// ❌ WRONG:
namespace Modules\Xot\App\Providers;
```

### File Locking Pattern Implementato

Prima di ogni modifica di file, creare un file `.lock`:

```bash
# Prima della modifica
touch file.php.lock

# Se .lock esiste, SKIPPA e vai oltre

# Dopo la modifica
rm file.php.lock
```

**Benefici:**
- Prevenzione race conditions
- Tracciabilità modifiche in corso
- Coordinamento team/processi multipli

### Verifica Finale
```bash
# Test server
php artisan serve --host=0.0.0.0 --port=8000
# ✅ Server running on http://0.0.0.0:8000

# PHPStan analysis
./vendor/bin/phpstan analyse Modules/Xot/app/Providers
# ✅ Completato (alcuni type safety warnings non bloccanti)

# Code formatting
vendor/bin/pint --dirty Modules/Xot/app
# ✅ Formattazione applicata
```

### References
- [Merge Conflict Resolution 2025-11-04](./merge-conflict-resolution-2025-11-04.md) - Report completo
- [File Locking Pattern](./file-locking-pattern.md) - Nuova regola fondamentale
- [RouteServiceProvider Documentation](./consolidated/route-service-provider.md) - Linee guida esistenti
- [Laraxot Architecture Rules](./laraxot-architecture-rules.md) - Convenzioni namespace 