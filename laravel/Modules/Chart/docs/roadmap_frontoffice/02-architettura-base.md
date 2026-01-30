# Task 2: Architettura Base

## Descrizione
Definizione e implementazione dell'architettura base del frontoffice, inclusa la struttura modulare, l'autenticazione, le API e il sistema di logging.

## Stato Attuale (Aprile 2024)
✅ Completato al 100%

## Sottotask

### 2.1 Struttura Moduli
- [x] Configurazione Nwidart Modules
- [x] Configurazione Laraxot Modules
- [x] Creazione struttura base moduli
- [x] Setup autoloading
- [x] Configurazione routing moduli

### 2.2 Autenticazione e Autorizzazione
- [x] Setup Spatie Laravel-permission
- [x] Configurazione ruoli e permessi
- [x] Implementazione middleware
- [x] Setup Sanctum per API
- [x] Configurazione 2FA

### 2.3 API REST
- [x] Configurazione OpenAPI/Swagger
- [x] Setup rate limiting
- [x] Implementazione versioning
- [x] Documentazione API
- [x] Test API

### 2.4 Logging e Monitoring
- [x] Setup Spatie Activity Log
- [x] Configurazione Sentry
- [x] Setup New Relic
- [x] Implementazione custom logging
- [x] Monitoraggio performance

## Dettagli Tecnici

### Struttura Moduli
```
laravel/
├── Modules/
│   ├── Activity/
│   ├── Chart/
│   ├── Cms/
│   ├── Dental/
│   ├── Gdpr/
│   ├── Job/
│   ├── Lang/
│   ├── Media/
│   ├── Notify/
│   ├── Patient/
│   ├── Reporting/
│   ├── Tenant/
│   ├── Theme/
│   ├── UI/
│   ├── User/
│   │   ├── app/
│   │   │   ├── Console/
│   │   │   ├── Http/
│   │   │   ├── Models/
│   │   │   ├── Providers/
│   │   │   └── Resources/
│   │   ├── config/
│   │   │   └── config.php
│   │   ├── database/
│   │   │   ├── factories/
│   │   │   │   └── UserFactory.php
│   │   │   ├── migrations/
│   │   │   │   ├── create_users_table.php
│   │   │   │   ├── create_password_reset_tokens_table.php
│   │   │   │   └── ...
│   │   │   └── seeders/
│   │   │       └── UserSeeder.php
│   │   ├── docs/
│   │   │   ├── img/
│   │   │   ├── OAuth/
│   │   │   ├── module_user.md
│   │   │   ├── password.md
│   │   │   ├── repositories.md
│   │   │   ├── FILAMENT_BEST_PRACTICES.md
│   │   │   ├── PHPSTAN_FIXES.md
│   │   │   └── ...
│   │   ├── lang/
│   │   │   ├── ar/
│   │   │   ├── cs/
│   │   │   ├── de/
│   │   │   ├── el/
│   │   │   ├── en/
│   │   │   ├── es/
│   │   │   ├── fa/
│   │   │   ├── fi/
│   │   │   ├── fr/
│   │   │   ├── he/
│   │   │   ├── hu/
│   │   │   ├── id/
│   │   │   ├── it/
│   │   │   ├── ja/
│   │   │   ├── ko/
│   │   │   ├── ms/
│   │   │   ├── nl/
│   │   │   ├── pl/
│   │   │   ├── pt_BR/
│   │   │   ├── pt_PT/
│   │   │   ├── ro/
│   │   │   ├── ru/
│   │   │   ├── sk/
│   │   │   ├── sl/
│   │   │   ├── sq/
│   │   │   ├── tr/
│   │   │   ├── uk/
│   │   │   ├── vi/
│   │   │   └── zh_TW/
│   │   ├── resources/
│   │   │   ├── assets/
│   │   │   ├── css/
│   │   │   ├── img/
│   │   │   ├── js/
│   │   │   ├── svg/
│   │   │   └── views/
│   │   │       ├── auth/
│   │   │       ├── components/
│   │   │       ├── layouts/
│   │   │       └── ...
│   │   ├── routes/
│   │   │   ├── api.php
│   │   │   ├── auth.php
│   │   │   ├── web.php
│   │   │   └── web_tall.php
│   │   ├── tests/
│   │   │   ├── Feature/
│   │   │   └── Unit/
│   │   ├── .github/
│   │   ├── .vscode/
│   │   ├── composer.json
│   │   ├── module.json
│   │   ├── package.json
│   │   ├── phpinsights.php
│   │   ├── phpstan.neon
│   │   ├── phpunit.xml.dist
│   │   ├── README.md
│   │   └── vite.config.js
│   └── Xot/
├── app/
│   ├── Console/
│   ├── Http/
│   ├── Models/
│   ├── Providers/
│   └── Resources/
└── ...
```

### Configurazione Moduli
```php
// config/modules.php
return [
    'namespace' => 'Modules',
    'paths' => [
        'modules' => base_path('Modules'),
        'assets' => public_path('modules'),
    ],
    'cache' => [
        'enabled' => false,
        'key' => 'laravel-modules',
        'lifetime' => 60,
    ],
];
```

### Autenticazione e Autorizzazione
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

### API Configuration
```php
// config/api.php
return [
    'version' => 'v1',
    'prefix' => 'api',
    'middleware' => ['api', 'auth:sanctum'],
    'rate_limit' => 60,
    'rate_limit_per_minute' => 60,
];
```

### Logging Configuration
```php
// config/activitylog.php
return [
    'default_log_name' => 'default',
    'subject_returns_soft_deleted_models' => true,
    'activity_model' => Spatie\Activitylog\Models\Activity::class,
];
```

## Checklist di Verifica
- [x] Moduli correttamente configurati
- [x] Autenticazione funzionante
- [x] API documentate e testate
- [x] Logging e monitoring attivi
- [x] Performance monitorata

## Note
- Seguire le convenzioni di Laraxot per i moduli
- Utilizzare i pacchetti Spatie per funzionalità comuni
- Mantenere la documentazione aggiornata
- Testare regolarmente le API
- Monitorare le performance

## Collegamenti
- [Task 1: Setup Ambiente](../roadmap_frontoffice/01-setup-ambiente.md)
- [Task 3: UI/UX Base](../roadmap_frontoffice/03-ui-ux-base.md)
- [Documentazione Nwidart Modules](https://nwidart.com/laravel-modules/v6/introduction)
- [Documentazione Laraxot](https://github.com/laraxot/modules)
- [Documentazione Spatie](https://spatie.be/open-source) 
## Collegamenti tra versioni di 02-architettura-base.md
* [02-architettura-base.md](docs/roadmap_frontoffice/02-architettura-base.md)
* [02-architettura-base.md](docs/roadmap_backoffice/02-architettura-base.md)

