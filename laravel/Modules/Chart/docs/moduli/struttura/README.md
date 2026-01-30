# Struttura Standard Moduli il progetto

## Directory Structure
```
ModuleName/
├── Config/          # Configurazioni del modulo
│   ├── config.php   # Configurazione principale
│   └── permissions.php # Permessi del modulo
├── Console/         # Comandi Artisan
│   └── Commands/    # Comandi personalizzati
├── Database/        # Migrazioni e seeders
│   ├── Migrations/  # Migrazioni database
│   └── Seeders/    # Seeder per dati di test
├── Entities/        # Modelli e relazioni
│   ├── Models/     # Modelli Eloquent
│   └── Traits/     # Traits riutilizzabili
├── Http/           # Controllers e middleware
│   ├── Controllers/ # Controllers
│   ├── Requests/   # Form requests
│   ├── Resources/  # API resources
│   └── Middleware/ # Middleware
├── Providers/      # Service providers
│   └── ModuleServiceProvider.php
├── Resources/      # Views, assets e traduzioni
│   ├── views/     # Blade views
│   ├── js/        # JavaScript
│   ├── css/       # Stili
│   └── lang/      # Traduzioni
├── Routes/         # Definizione rotte
│   ├── api.php    # API routes
│   └── web.php    # Web routes
├── Services/       # Logica di business
│   └── Contracts/ # Interfaces
└── Tests/          # Test unitari e feature
    ├── Unit/      # Test unitari
    └── Feature/   # Test funzionali
```

## File Principali

### Config/config.php
```php
return [
    'name' => 'ModuleName',
    'version' => '1.0.0',
    'providers' => [
        ModuleServiceProvider::class,
    ],
    'aliases' => [
        'ModuleName' => ModuleNameFacade::class,
    ],
];
```

### Providers/ModuleServiceProvider.php
```php
class ModuleServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->loadRoutes();
        $this->loadViews();
        $this->loadMigrations();
        $this->loadTranslations();
    }
}
```

### Routes/web.php
```php
Route::group([
    'prefix' => 'module-name',
    'middleware' => ['web', 'auth'],
], function () {
    // Routes
});
```

## Convenzioni

### Naming
- Classi: PascalCase
- Metodi: camelCase
- Variabili: camelCase
- Costanti: UPPER_CASE
- File: kebab-case

### Namespace
```php
namespace Modules\ModuleName;
```

### Service Provider
- Registrare in `config/app.php`
- Caricare assets in `boot()`
- Registrare routes in `map()`

### Views
- Usare componenti Blade
- Organizzare in sottocartelle
- Seguire BEM per CSS
- Usare traduzioni

### Testing
- Test per ogni feature
- Test per ogni model
- Test per ogni service
- Coverage minimo 80% 
## Collegamenti tra versioni di README.md
* [README.md](bashscripts/docs/README.md)
* [README.md](bashscripts/docs/it/README.md)
* [README.md](docs/laravel-app/phpstan/README.md)
* [README.md](docs/laravel-app/README.md)
* [README.md](docs/moduli/struttura/README.md)
* [README.md](docs/moduli/README.md)
* [README.md](docs/moduli/manutenzione/README.md)
* [README.md](docs/moduli/core/README.md)
* [README.md](docs/moduli/installati/README.md)
* [README.md](docs/moduli/comandi/README.md)
* [README.md](docs/phpstan/README.md)
* [README.md](docs/README.md)
* [README.md](docs/module-links/README.md)
* [README.md](docs/troubleshooting/git-conflicts/README.md)
* [README.md](docs/tecnico/laraxot/README.md)
* [README.md](docs/modules/README.md)
* [README.md](docs/conventions/README.md)
* [README.md](docs/amministrazione/backup/README.md)
* [README.md](docs/amministrazione/monitoraggio/README.md)
* [README.md](docs/amministrazione/deployment/README.md)
* [README.md](docs/translations/README.md)
* [README.md](docs/roadmap/README.md)
* [README.md](docs/ide/cursor/README.md)
* [README.md](docs/implementazione/api/README.md)
* [README.md](docs/implementazione/testing/README.md)
* [README.md](docs/implementazione/pazienti/README.md)
* [README.md](docs/implementazione/ui/README.md)
* [README.md](docs/implementazione/dental/README.md)
* [README.md](docs/implementazione/core/README.md)
* [README.md](docs/implementazione/reporting/README.md)
* [README.md](docs/implementazione/isee/README.md)
* [README.md](docs/it/README.md)
* [README.md](laravel/vendor/mockery/mockery/docs/README.md)
* [README.md](laravel/Modules/Chart/docs/README.md)
* [README.md](laravel/Modules/Reporting/docs/README.md)
* [README.md](laravel/Modules/Gdpr/docs/phpstan/README.md)
* [README.md](laravel/Modules/Gdpr/docs/README.md)
* [README.md](laravel/Modules/Notify/docs/phpstan/README.md)
* [README.md](laravel/Modules/Notify/docs/README.md)
* [README.md](laravel/Modules/Xot/docs/filament/README.md)
* [README.md](laravel/Modules/Xot/docs/phpstan/README.md)
* [README.md](laravel/Modules/Xot/docs/exceptions/README.md)
* [README.md](laravel/Modules/Xot/docs/README.md)
* [README.md](laravel/Modules/Xot/docs/standards/README.md)
* [README.md](laravel/Modules/Xot/docs/conventions/README.md)
* [README.md](laravel/Modules/Xot/docs/development/README.md)
* [README.md](laravel/Modules/Dental/docs/README.md)
* [README.md](laravel/Modules/User/docs/phpstan/README.md)
* [README.md](laravel/Modules/User/docs/README.md)
* [README.md](laravel/Modules/User/resources/views/docs/README.md)
* [README.md](laravel/Modules/UI/docs/phpstan/README.md)
* [README.md](laravel/Modules/UI/docs/README.md)
* [README.md](laravel/Modules/UI/docs/standards/README.md)
* [README.md](laravel/Modules/UI/docs/themes/README.md)
* [README.md](laravel/Modules/UI/docs/components/README.md)
* [README.md](laravel/Modules/Lang/docs/phpstan/README.md)
* [README.md](laravel/Modules/Lang/docs/README.md)
* [README.md](laravel/Modules/Job/docs/phpstan/README.md)
* [README.md](laravel/Modules/Job/docs/README.md)
* [README.md](laravel/Modules/Media/docs/phpstan/README.md)
* [README.md](laravel/Modules/Media/docs/README.md)
* [README.md](laravel/Modules/Tenant/docs/phpstan/README.md)
* [README.md](laravel/Modules/Tenant/docs/README.md)
* [README.md](laravel/Modules/Activity/docs/phpstan/README.md)
* [README.md](laravel/Modules/Activity/docs/README.md)
* [README.md](laravel/Modules/Patient/docs/README.md)
* [README.md](laravel/Modules/Patient/docs/standards/README.md)
* [README.md](laravel/Modules/Patient/docs/value-objects/README.md)
* [README.md](laravel/Modules/Cms/docs/blocks/README.md)
* [README.md](laravel/Modules/Cms/docs/README.md)
* [README.md](laravel/Modules/Cms/docs/standards/README.md)
* [README.md](laravel/Modules/Cms/docs/content/README.md)
* [README.md](laravel/Modules/Cms/docs/frontoffice/README.md)
* [README.md](laravel/Modules/Cms/docs/components/README.md)
* [README.md](laravel/Themes/Two/docs/README.md)
* [README.md](laravel/Themes/One/docs/README.md)

