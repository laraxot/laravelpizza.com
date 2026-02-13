# Pacchetti

## Configurazione Base

### Composer
```json
{
    "name": "laravel/laravel",
    "type": "project",
    "description": "The Laravel Framework.",
    "keywords": ["framework", "laravel"],
    "license": "MIT",
    "require": {
        "php": "^8.1",
        "guzzlehttp/guzzle": "^7.2",
        "laravel/framework": "^10.0",
        "laravel/sanctum": "^3.2",
        "laravel/tinker": "^2.8"
    },
    "require-dev": {
        "fakerphp/faker": "^1.9.1",
        "laravel/pint": "^1.0",
        "laravel/sail": "^1.18",
        "mockery/mockery": "^1.4.4",
        "nunomaduro/collision": "^7.0",
        "phpunit/phpunit": "^10.1",
        "spatie/laravel-ignition": "^2.0"
    },
    "autoload": {
        "psr-4": {
            "App\\": "app/",
            "Database\\Factories\\": "database/factories/",
            "Database\\Seeders\\": "database/seeders/"
        }
    },
    "autoload-dev": {
        "psr-4": {
            "Tests\\": "tests/"
        }
    },
    "scripts": {
        "post-autoload-dump": [
            "Illuminate\\Foundation\\ComposerScripts::postAutoloadDump",
            "@php artisan package:discover --ansi"
        ],
        "post-update-cmd": [
            "@php artisan vendor:publish --tag=laravel-assets --ansi --force"
        ],
        "post-root-package-install": [
            "@php -r \"file_exists('.env') || copy('.env.example', '.env');\""
        ],
        "post-create-project-cmd": [
            "@php artisan key:generate --ansi"
        ]
    },
    "extra": {
        "laravel": {
            "dont-discover": []
        }
    },
    "config": {
        "optimize-autoloader": true,
        "preferred-install": "dist",
        "sort-packages": true,
        "allow-plugins": {
            "pestphp/pest-plugin": true,
            "php-http/discovery": true
        }
    },
    "minimum-stability": "stable",
    "prefer-stable": true
}
```

## Pacchetti Base

### Pacchetti Essenziali
```bash
# Autenticazione
composer require laravel/sanctum

# Cache
composer require predis/predis

# Queue
composer require laravel/horizon

# Testing
composer require --dev phpunit/phpunit
composer require --dev laravel/dusk
```

### Pacchetti di Sviluppo
```bash
# IDE Helper
composer require --dev barryvdh/laravel-ide-helper

# Debug
composer require --dev barryvdh/laravel-debugbar

# Code Style
composer require --dev laravel/pint
```

## Best Practices

### 1. Struttura
- Organizzare per dominio
- Gestire le versioni
- Documentare i pacchetti
- Mantenere le dipendenze

### 2. Performance
- Ottimizzare l'autoload
- Utilizzare il caching
- Implementare il lazy loading
- Monitorare i pacchetti

### 3. Sicurezza
- Verificare le fonti
- Aggiornare regolarmente
- Implementare il logging
- Gestire i fallimenti

### 4. Manutenzione
- Monitorare i pacchetti
- Gestire le versioni
- Implementare alerting
- Documentare i pacchetti

## Esempi di Utilizzo

### Installazione Pacchetto
```bash
# Installare un pacchetto
composer require spatie/laravel-permission

# Installare un pacchetto di sviluppo
composer require --dev spatie/laravel-ray

# Aggiornare un pacchetto
composer update spatie/laravel-permission
```

### Configurazione Pacchetto
```php
// config/permission.php
return [
    'models' => [
        'permission' => Spatie\Permission\Models\Permission::class,
        'role' => Spatie\Permission\Models\Role::class,
    ],
    'table_names' => [
        'roles' => 'roles',
        'permissions' => 'permissions',
        'model_has_permissions' => 'model_has_permissions',
        'model_has_roles' => 'model_has_roles',
        'role_has_permissions' => 'role_has_permissions',
    ],
];
```

## Strumenti Utili

### Comandi Composer
```bash
# Aggiornare i pacchetti
composer update

# Rimuovere un pacchetto
composer remove spatie/laravel-permission

# Ottimizzare l'autoload
composer dump-autoload -o
```

### Comandi Artisan
```bash
# Pubblicare le configurazioni
php artisan vendor:publish --provider="Spatie\Permission\PermissionServiceProvider"

# Pubblicare le migrazioni
php artisan vendor:publish --provider="Spatie\Permission\PermissionServiceProvider" --tag="migrations"
```

## Gestione degli Errori

### Errori di Pacchetto
```php
try {
    // Logica del pacchetto
} catch (\Exception $e) {
    Log::error('Errore nel pacchetto', [
        'package' => 'spatie/laravel-permission',
        'error' => $e->getMessage(),
    ]);

    throw $e;
}
```

### Logging
```php
use Illuminate\Support\Facades\Log;

public function handle()
{
    Log::info('Inizio utilizzo pacchetto', [
        'package' => 'spatie/laravel-permission',
    ]);

    // Logica del pacchetto

    Log::info('Pacchetto utilizzato con successo', [
        'package' => 'spatie/laravel-permission',
    ]);
}
```

## Pacchetti Avanzati

### Pacchetti di Cache
```php
// config/cache.php
'stores' => [
    'redis' => [
        'driver' => 'redis',
        'connection' => 'cache',
        'lock_connection' => 'default',
    ],
    'memcached' => [
        'driver' => 'memcached',
        'persistent_id' => env('MEMCACHED_PERSISTENT_ID'),
        'sasl' => [
            env('MEMCACHED_USERNAME'),
            env('MEMCACHED_PASSWORD'),
        ],
        'options' => [
            // Memcached::OPT_CONNECT_TIMEOUT => 2000,
        ],
        'servers' => [
            [
                'host' => env('MEMCACHED_HOST', '127.0.0.1'),
                'port' => env('MEMCACHED_PORT', 11211),
                'weight' => 100,
            ],
        ],
    ],
],
```

### Pacchetti di Queue
```php
// config/queue.php
'connections' => [
    'redis' => [
        'driver' => 'redis',
        'connection' => 'default',
        'queue' => env('REDIS_QUEUE', 'default'),
        'retry_after' => 90,
        'block_for' => null,
        'after_commit' => false,
    ],
    'beanstalkd' => [
        'driver' => 'beanstalkd',
        'host' => 'localhost',
        'queue' => 'default',
        'retry_after' => 90,
        'block_for' => 0,
        'after_commit' => false,
    ],
],
```
