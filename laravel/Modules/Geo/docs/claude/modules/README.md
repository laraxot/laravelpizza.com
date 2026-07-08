# Module Structure

## Directory Structure

```
Modules/ModuleName/
├── app/
│   ├── Actions/              # Business logic (Spatie QueueableAction)
│   ├── Data/ or Datas/       # DTOs (Spatie Laravel Data)
│   ├── Enums/                # Type-safe enums
│   ├── Filament/
│   │   ├── Resources/        # Resource definitions
│   │   ├── Pages/            # Create/Edit/List pages
│   │   ├── Widgets/          # Dashboard widgets
│   │   └── Actions/          # Custom Filament actions
│   ├── Http/
│   │   ├── Controllers/      # Controllers
│   │   ├── Middleware/       # Middleware
│   │   └── Requests/         # Form requests
│   ├── Models/               # Eloquent models + BaseModel
│   ├── Notifications/        # Notifications
│   ├── Observers/            # Model observers
│   ├── Policies/             # Authorization policies
│   ├── Providers/            # Service providers
│   └── Traits/               # Reusable traits
├── config/                   # Module configuration
├── database/
│   ├── factories/            # Model factories
│   ├── migrations/           # Database migrations
│   └── seeders/              # Seeders
├── docs/                     # Module documentation
├── resources/
│   ├── lang/                 # Translation files (en/, it/)
│   └── views/                # Blade templates
├── routes/                   # api.php, web.php
├── tests/
│   ├── Feature/              # Feature tests
│   └── Unit/                 # Unit tests
├── composer.json             # Module dependencies
└── module.json               # Module metadata
```

## Key Modules

### Core Modules
- **Xot**: Framework foundation (base classes, traits, utilities)
- **User**: Auth, roles, permissions, multi-type users, teams
- **Lang**: Multi-language translation system
- **Tenant**: Multi-tenancy support
- **UI**: Shared UI components

### Business Domain Modules
- Performance, PresenzeAssenze, Questionari
- Incentivi, IndennitaResponsabilita, IndennitaCondizioniLavoro
- Legge104, Legge109, Mensa, Progressioni
- Gdpr, Activity (audit logging)
- Media (file management)

### External Integration Modules
- Pdnd, Ptv, Sigma, Europa, Inail, Sindacati

## Creating a New Module

```bash
# Create new module
php artisan module:make ModuleName

# Enable module
php artisan module:enable ModuleName
```

## Module Dependencies

Add dependencies in `Modules/ModuleName/composer.json`:

```json
{
    "require": {
        "nwidart/laravel-modules": "^10.0",
        "spatie/laravel-data": "^4.0",
        "spatie/laravel-queueable-action": "^2.0"
    }
}
```

## Module Configuration

Each module can have its own config files in `config/`:

```php
// Modules/ModuleName/config/config.php
return [
    'default_setting' => env('MODULE_DEFAULT_SETTING', 'value'),
    'features' => [
        'feature_one' => true,
        'feature_two' => false,
    ],
];
```

Access with:
```php
config('module_name.default_setting');
```

## Module Service Providers

```php
// Modules/ModuleName/app/Providers/ModuleServiceProvider.php
class ModuleServiceProvider extends XotBaseServiceProvider
{
    public function register(): void
    {
        $this->mergeConfigFrom(__DIR__.'/../config/module.php', 'module');
    }

    public function boot(): void
    {
        $this->loadViewsFrom(__DIR__.'/../resources/views', 'module');
        $this->loadTranslationsFrom(__DIR__.'/../resources/lang', 'module');
    }
}
```