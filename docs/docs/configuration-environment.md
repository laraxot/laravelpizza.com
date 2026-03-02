# Laravel Pizza Configuration & Environment Setup

## Environment Configuration

### Main Environment File (.env)

The main environment configuration file contains essential settings for the application:

```env
APP_NAME=LaravelPizza
APP_ENV=local
APP_KEY=base64:your-app-key-here
APP_DEBUG=true
APP_URL=http://localhost

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=laravelpizza
DB_USERNAME=root
DB_PASSWORD=

BROADCAST_DRIVER=log
CACHE_DRIVER=redis
QUEUE_CONNECTION=redis
SESSION_DRIVER=redis
SESSION_LIFETIME=120

REDIS_HOST=127.0.0.1
REDIS_PASSWORD=null
REDIS_PORT=6379

MAIL_MAILER=smtp
MAIL_HOST=mailhog
MAIL_PORT=1025
MAIL_USERNAME=null
MAIL_PASSWORD=null
MAIL_ENCRYPTION=null
MAIL_FROM_ADDRESS="hello@example.com"

AWS_ACCESS_KEY_ID=
AWS_SECRET_ACCESS_KEY=
AWS_DEFAULT_REGION=us-east-1
AWS_BUCKET=

PUSHER_APP_ID=
PUSHER_APP_KEY=
PUSHER_APP_SECRET=
PUSHER_APP_CLUSTER=mt1

MIX_PUSHER_APP_KEY="${PUSHER_APP_KEY}"
MIX_PUSHER_APP_CLUSTER="${PUSHER_APP_CLUSTER}"

# Module-specific configurations
MCP_FILESYSTEM_ENABLED=true
MCP_DATABASE_ENABLED=true
MCP_GIT_ENABLED=true
MCP_ARTISAN_ENABLED=true
MCP_PHPSTAN_ENABLED=true
MCP_COMPOSER_ENABLED=true
```

### Environment-Specific Configurations

#### Local Development (config/localhost/)
The project uses a special configuration directory for local development:

```
config/localhost/
├── activitylog.php
├── app.php
├── auth.php
├── database.php
├── event-sourcing.php
├── filesystems.php
├── google.php
├── media-library.php
├── metatag.php
├── modules_statuses.json
├── morph_map.php
├── orbit.php
├── passport.php
├── permission.php
├── policy.md
├── quaeris.php
├── services.php
├── social.php
├── terms.md
├── totem.php
├── xra.php
├── database/
└── lang/
```

#### Key Local Configurations

**XRA Configuration (config/localhost/xra.php)**:
```php
return [
    'main_module' => env('MAIN_MODULE', 'user'),
    'param_name' => env('PARAM_NAME', 'noset'),
    'adm_home' => env('ADM_HOME', '01'),
    'adm_theme' => env('ADM_THEME', ''),
    'pub_theme' => env('PUB_THEME', 'Meetup'), // Current public theme
    'primary_lang' => env('PRIMARY_LANG', 'it'),
    'search_action' => env('SEARCH_ACTION', 'it/videos'),
    'show_trans_key' => env('SHOW_TRANS_KEY', false),
    'register_type' => env('REGISTER_TYPE', '0'),
    'verification_type' => env('VERIFICATION_TYPE', ''),
    'login_verified' => env('LOGIN_VERIFIED', false),
    'force_ssl' => env('FORCE_SSL', false),
    'disable_frontend_dynamic_route' => env('DISABLE_FRONTEND_DYNAMIC_ROUTE', false),
    'disable_admin_dynamic_route' => env('DISABLE_ADMIN_DYNAMIC_ROUTE', false),
    'disable_database_notifications' => env('DISABLE_DATABASE_NOTIFICATIONS', true),
    'register_adm_theme' => env('REGISTER_ADM_THEME', false),
    'register_pub_theme' => env('REGISTER_PUB_THEME', false),
    'register_collective' => env('REGISTER_COLLECTIVE', false),
    'team_class' => env('TEAM_CLASS', 'Modules\User\Models\Team'),
    'tenant_class' => env('TENANT_CLASS', 'Modules\User\Models\Tenant'),
    'membership_class' => env('MEMBERSHIP_CLASS', 'Modules\User\Models\Membership'),
    'tenant_pivot_class' => env('TENANT_PIVOT_CLASS', 'Modules\User\Models\TenantUser'),
    'super_admin' => env('SUPER_ADMIN'),
    'video_player' => env('VIDEO_PLAYER', 'html5'),
];
```

**Database Configuration (config/localhost/database.php)**:
Enhanced database configuration with multiple connections and advanced features.

## Module configuration: `Modules/Meetup/config/config.php`

Questo progetto usa uno schema coerente per i file `Modules/*/config/config.php` (vedi anche `Modules/User`, `Modules/Tenant`, `Modules/Xot`, `Modules/UI`).

La scelta “vince” su DRY/KISS perché evita varianti non necessarie tra moduli e rende prevedibile l’autodiscovery (providers, navigation, routes).

Chiavi standard mantenute:

- **`name`**
- **`description`**
- **`icon`**
- **`navigation`** (`enabled`, `sort`)
- **`routes`** (`enabled`, `middleware`)
- **`providers`** (FQCN Laraxot, namespace `Modules\\Meetup\\...` senza segmenti `App`)

### Database Configuration

#### Multiple Database Connections
The application supports multiple database connections:

```php
// config/database.php (or config/localhost/database.php)
'connections' => [
    'mysql' => [
        'driver' => 'mysql',
        'url' => env('DATABASE_URL'),
        'host' => env('DB_HOST', '127.0.0.1'),
        'port' => env('DB_PORT', '3306'),
        'database' => env('DB_DATABASE', 'laravel'),
        'username' => env('DB_USERNAME', 'root'),
        'password' => env('DB_PASSWORD', ''),
        'unix_socket' => env('DB_SOCKET', ''),
        'charset' => 'utf8mb4',
        'collation' => 'utf8mb4_unicode_ci',
        'prefix' => '',
        'prefix_indexes' => true,
        'strict' => true,
        'engine' => null,
        'options' => extension_loaded('pdo_mysql') ? array_filter([
            PDO::MYSQL_ATTR_SSL_CA => env('MYSQL_ATTR_SSL_CA'),
        ]) : [],
    ],

    'pgsql' => [
        'driver' => 'pgsql',
        'url' => env('DATABASE_URL'),
        'host' => env('DB_HOST', '127.0.0.1'),
        'port' => env('DB_PORT', '5432'),
        'database' => env('DB_DATABASE', 'laravel'),
        'username' => env('DB_USERNAME', 'root'),
        'password' => env('DB_PASSWORD', ''),
        'charset' => 'utf8',
        'prefix' => '',
        'prefix_indexes' => true,
        'search_path' => 'public',
        'sslmode' => 'prefer',
    ],
],
```

#### Redis Configuration
```php
// config/database.php
'redis' => [
    'client' => env('REDIS_CLIENT', 'phpredis'),

    'options' => [
        'cluster' => env('REDIS_CLUSTER', 'redis'),
        'prefix' => env('REDIS_PREFIX', Str::slug(env('APP_NAME', 'laravel'), '_').'_database_'),
    ],

    'default' => [
        'url' => env('REDIS_URL'),
        'host' => env('REDIS_HOST', '127.0.0.1'),
        'username' => env('REDIS_USERNAME'),
        'password' => env('REDIS_PASSWORD'),
        'port' => env('REDIS_PORT', '6379'),
        'database' => env('REDIS_DB', '0'),
    ],
],
```

### Cache Configuration

#### Multiple Cache Drivers
The application supports various cache drivers configured in `config/cache.php`:

```php
'default' => env('CACHE_DRIVER', 'file'),

'stores' => [
    'apc' => [
        'driver' => 'apc',
    ],

    'array' => [
        'driver' => 'array',
        'serialize' => false,
    ],

    'database' => [
        'driver' => 'database',
        'table' => 'cache',
        'connection' => null,
        'lock_connection' => null,
    ],

    'file' => [
        'driver' => 'file',
        'path' => storage_path('framework/cache/data'),
    ],

    'memcached' => [
        'driver' => 'memcached',
        'persistent_id' => env('MEMCACHED_PERSISTENT_ID'),
        'sasl' => [
            env('MEMCACHED_USERNAME'),
            env('MEMCACHED_PASSWORD'),
        ],
        'options' => [
            // Memcached options
        ],
        'servers' => [
            [
                'host' => env('MEMCACHED_HOST', '127.0.0.1'),
                'port' => env('MEMCACHED_PORT', 11211),
                'weight' => 100,
            ],
        ],
    ],

    'redis' => [
        'driver' => 'redis',
        'connection' => 'cache',
        'lock_connection' => 'default',
    ],
],
```

### Queue Configuration

#### Redis Queue Driver
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
],
```

### File Storage Configuration

#### Multiple Filesystem Disks
```php
// config/filesystems.php
'disks' => [
    'local' => [
        'driver' => 'local',
        'root' => storage_path('app'),
    ],

    'public' => [
        'driver' => 'local',
        'root' => storage_path('app/public'),
        'url' => env('APP_URL').'/storage',
        'visibility' => 'public',
    ],

    's3' => [
        'driver' => 's3',
        'key' => env('AWS_ACCESS_KEY_ID'),
        'secret' => env('AWS_SECRET_ACCESS_KEY'),
        'region' => env('AWS_DEFAULT_REGION'),
        'bucket' => env('AWS_BUCKET'),
        'url' => env('AWS_URL'),
        'endpoint' => env('AWS_ENDPOINT'),
        'use_path_style_endpoint' => env('AWS_USE_PATH_STYLE_ENDPOINT', false),
        'throw' => false,
    ],
],
```

### Module-Specific Configuration

#### Modules Status Configuration
The `modules_statuses.json` file controls which modules are enabled:

```json
{
    "Activity": true,
    "Cms": true,
    "Gdpr": true,
    "Geo": true,
    "Job": true,
    "Lang": true,
    "Media": true,
    "Notify": true,
    "Seo": true,
    "Tenant": true,
    "UI": true,
    "User": true,
    "Xot": true
}
```

#### Individual Module Configurations
Each module can have its own configuration files in `Modules/{ModuleName}/config/`:

```php
// Example: Modules/User/config/config.php
<?php

return [
    'name' => 'User',

    'providers' => [
        // Service providers for the User module
    ],

    'files' => [
        // Module-specific files
    ],

    // Module-specific settings
];
```

### Authentication Configuration

#### Laravel Fortify Configuration
```php
// config/fortify.php
<?php

use Laravel\Fortify\Features;

return [
    'guard' => 'web',

    'passwords' => 'users',

    'username' => 'email',

    'email' => 'email',

    'home' => '/dashboard',

    'prefix' => '',

    'domain' => null,

    'middleware' => ['web'],

    'auth_middleware' => 'auth',

    'limiters' => [
        'login' => 'login',
        'two-factor' => 'two-factor',
    ],

    'redirects' => [
        'login' => null,
        'logout' => null,
        'password-confirmation' => null,
        'register' => null,
        'email-verification' => null,
        'password-reset' => null,
    ],

    'features' => [
        Features::registration(),
        Features::resetPasswords(),
        Features::emailVerification(),
        Features::updateProfileInformation(),
        Features::updatePasswords(),
        Features::twoFactorAuthentication([
            'confirm' => true,
            'confirmPassword' => true,
            // 'window' => 0,
        ]),
    ],
];
```

### Localization Configuration

#### Multi-language Support
```php
// config/laravellocalization.php
<?php

return [
    'supportedLocales' => [
        'en' => ['name' => 'English', 'script' => 'Latn', 'native' => 'English'],
        'it' => ['name' => 'Italian', 'script' => 'Latn', 'native' => 'Italiano'],
        'de' => ['name' => 'German', 'script' => 'Latn', 'native' => 'Deutsch'],
    ],

    'useAcceptLanguageHeader' => true,

    'hideDefaultLocaleInURL' => false,

    'localesOrder' => ['en', 'it', 'de'],
];
```

### Custom Application Configuration

#### Xot Module Configuration
The Xot module contains core configuration that affects the entire application:

```php
// config/localhost/xra.php (already shown above)
// This configuration controls:
// - Main module selection
// - Theme selection (pub_theme: 'Meetup')
// - Language settings
// - Feature flags
// - Class mappings for various models
```

### Development vs Production Configuration

#### Environment-Specific Settings

**Development (`APP_ENV=local`)**:
- Debug mode enabled
- Detailed error reporting
- File-based session and cache
- Mailhog for email testing
- Development-specific module configurations

**Production (`APP_ENV=production`)**:
- Debug mode disabled
- Optimized performance settings
- Redis for session and cache
- Real email services
- Security hardening

#### Environment Variables Management

**Sensitive Data**:
- Database credentials
- API keys
- OAuth secrets
- Payment gateway credentials

**Application Settings**:
- Feature flags
- Performance settings
- Third-party service configurations

This comprehensive configuration system allows for flexible deployment across different environments while maintaining consistent behavior across the modular Laravel Pizza application.
