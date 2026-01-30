# Documentazione Moduli

Questa cartella contiene la documentazione relativa ai moduli del sistema.

## Contenuti

### Indice e Relazioni
- [Indice Moduli](modules-index.md) - Indice completo dei moduli
- [Relazioni Moduli](modules-relationships.md) - Relazioni tra i moduli
- [Collegamenti Moduli](module-links/README.md) - Collegamenti tra i moduli

### Moduli Core
- [Xot](xot.md) - Modulo base del sistema
- [User](user.md) - Gestione utenti
- [Lang](lang.md) - Gestione lingue
- [Tenant](tenant.md) - Gestione multi-tenant

### Moduli Business
- [Patient](patient.md) - Gestione pazienti
- [Dental](dental.md) - Gestione odontoiatrica
- [Gdpr](gdpr.md) - Gestione privacy

### Moduli Support
- [Activity](activity.md) - Logging attività
- [Media](media.md) - Gestione media
- [Notify](notify.md) - Sistema notifiche
- [Chart](chart.md) - Visualizzazione dati

## Note
- Ogni modulo ha la sua documentazione specifica
- Mantenere aggiornate le relazioni tra moduli
- Documentare tutte le API pubbliche

# Documentazione dei Moduli il progetto

## Panoramica
Questo documento fornisce una guida completa alla struttura e organizzazione dei moduli in il progetto.

## Struttura Base dei Moduli

### Directory Standard
```
Modules/
├── ModuleName/
│   ├── app/
│   ├── config/
│   ├── database/
│   ├── docs/
│   ├── resources/
│   ├── routes/
│   ├── tests/
│   ├── composer.json
│   └── module.json
```

### Convenzioni di Naming
- Directory in minuscolo: `resources`, `config`, `database`, `app`
- Namespace: `Modules\ModuleName`
- Classi: PascalCase
- File: kebab-case

## Moduli Principali

### 1. Modulo Xot (Core)
- Base per tutti gli altri moduli
- Classi e traits condivisi
- Configurazioni globali
- Service providers base

### 2. Modulo UI
- Componenti interfaccia
- Temi e layout
- Widget Filament
- Assets condivisi

### 3. Modulo Lang
- Gestione traduzioni
- File di lingua
- Service provider traduzioni
- Helpers multilingua

### 4. Modulo Tenant
- Gestione multi-tenant
- Isolamento dati
- Configurazioni tenant
- Middleware tenant

### 5. Modulo Patient
- Gestione pazienti
- Cartelle cliniche
- Appuntamenti
- Documenti sanitari

### 6. Modulo Dental
- Procedure dentali
- Trattamenti
- Diagnosi
- Piani di cura

## Documentazione Moduli

### 1. Struttura Docs
```markdown
docs/
├── README.md           # Panoramica
├── INSTALLATION.md     # Guida installazione
├── CONFIGURATION.md    # Configurazione
├── USAGE.md           # Utilizzo
├── API.md             # API reference
└── components/        # Documentazione componenti
    └── README.md
```

### 2. Collegamenti Bidirezionali
- Ogni modulo deve avere collegamenti agli altri moduli correlati
- La documentazione root contiene solo indici e collegamenti
- Mantenere aggiornati i riferimenti

### 3. Gestione Versioni
- Seguire semantic versioning
- Documentare breaking changes
- Mantenere changelog aggiornato

## Sviluppo Moduli

### 1. Creazione Nuovo Modulo
```bash
php artisan module:make ModuleName
```

### 2. Struttura Base
```php
namespace Modules\ModuleName;

class ModuleNameServiceProvider extends XotBaseServiceProvider
{
    protected $moduleNameLower = 'modulename';
    
    public function boot()
    {
        $this->registerTranslations();
        $this->registerConfig();
        $this->registerViews();
        $this->loadMigrationsFrom(__DIR__.'/../database/migrations');
    }
}
```

### 3. Configurazione
```php
// config/config.php
return [
    'name' => 'ModuleName',
    'prefix' => 'module-prefix',
    'middleware' => ['web', 'auth'],
];
```

## Best Practices

### 1. Organizzazione Codice
- Seguire PSR-4 per autoloading
- Usare namespace appropriati
- Mantenere single responsibility
- Documentare le classi

### 2. Testing
```php
namespace Modules\ModuleName\Tests;

class ModuleTest extends TestCase
{
    public function test_module_loads()
    {
        $response = $this->get('/module-route');
        $response->assertStatus(200);
    }
}
```

## Integrazione Filament

### 1. Resources
```php
namespace Modules\ModuleName\Filament\Resources;

class ExampleResource extends XotBaseResource
{
    protected static function getNavigationGroup(): ?string
    {
        return __('modulename::navigation.group');
    }
}
```

### 2. Widgets
```php
namespace Modules\ModuleName\Filament\Widgets;

class StatsWidget extends XotBaseWidget
{
    protected static string $view = 'modulename::widgets.stats';
}
```

### 3. Forms
```php
public static function form(Form $form): Form
{
    return $form->schema([
        TextInput::make('title')
            ->required()
            ->translateLabel(),
    ]);
}
```

## Collegamenti Bidirezionali

### Documentazione Interna
- [Struttura Generale](../struttura-moduli.md)
- [Convenzioni Codice](../conventions/README.md)
- [Workflow Sviluppo](../workflow.md)

### Documentazione Moduli
- [Xot Core](../../laravel/Modules/Xot/docs/README.md)
- [UI Module](../../laravel/Modules/UI/docs/README.md)
- [Lang Module](../../laravel/Modules/Lang/docs/README.md)
- [Tenant Module](../../laravel/Modules/Tenant/docs/README.md)
- [Patient Module](../../laravel/Modules/Patient/docs/README.md)
- [Dental Module](../../laravel/Modules/Dental/docs/README.md)

## Manutenzione

### 1. Aggiornamenti
- Mantenere dipendenze aggiornate
- Seguire le release di Laravel
- Aggiornare la documentazione
- Testare le integrazioni

### 2. Monitoraggio
- Logging errori
- Metriche performance
- Utilizzo risorse
- Sicurezza

### 3. Backup
- Database per modulo
- File di configurazione
- Assets e media
- Documentazione 

# Documentazione Moduli

## Moduli Core

### Xot
- [Documentazione Principale](../../laravel/Modules/Xot/docs/README.md)
- [Filament](../../laravel/Modules/Xot/docs/filament/README.md)
- [PHPStan](../../laravel/Modules/Xot/docs/phpstan/README.md)
- [Eccezioni](../../laravel/Modules/Xot/docs/exceptions/README.md)

### User
- [Documentazione Principale](../../laravel/Modules/User/docs/README.md)
- [Profilo Utente](../../laravel/Modules/User/docs/user_profile_models.md)
- [Permessi](../../laravel/Modules/User/docs/permissions.md)

### Lang
- [Documentazione Principale](../../laravel/Modules/Lang/docs/README.md)
- [Traduzioni](../../laravel/Modules/Lang/docs/translations.md)

## Moduli Business

### Patient
- [Documentazione Principale](../../laravel/Modules/Patient/docs/README.md)
- [Gestione Pazienti](../../laravel/Modules/Patient/docs/patient_management.md)
- [Privacy](../../laravel/Modules/Patient/docs/privacy.md)

### Dental
- [Documentazione Principale](../../laravel/Modules/Dental/docs/README.md)
- [Cartella Clinica](../../laravel/Modules/Dental/docs/clinical_record.md)
- [Report](../../laravel/Modules/Dental/docs/reports.md)

## Moduli Support

### Activity
- [Documentazione Principale](../../laravel/Modules/Activity/docs/README.md)
- [Filament](../../laravel/Modules/Activity/docs/filament.md)
- [Log](../../laravel/Modules/Activity/docs/logs.md)

### Chart
- [Documentazione Principale](../../laravel/Modules/Chart/docs/README.md)
- [Visualizzazioni](../../laravel/Modules/Chart/docs/visualizations.md)

### Gdpr
- [Documentazione Principale](../../laravel/Modules/Gdpr/docs/README.md)
- [PHPStan](../../laravel/Modules/Gdpr/docs/phpstan/README.md)
- [Privacy](../../laravel/Modules/Gdpr/docs/privacy.md)

### Media
- [Documentazione Principale](../../laravel/Modules/Media/docs/README.md)
- [Gestione File](../../laravel/Modules/Media/docs/file_management.md)

### Notify
- [Documentazione Principale](../../laravel/Modules/Notify/docs/README.md)
- [PHPStan](../../laravel/Modules/Notify/docs/phpstan/README.md)
- [Notifiche](../../laravel/Modules/Notify/docs/notifications.md)

### Reporting
- [Documentazione Principale](../../laravel/Modules/Reporting/docs/README.md)
- [Report](../../laravel/Modules/Reporting/docs/reports.md)

### Tenant
- [Documentazione Principale](../../laravel/Modules/Tenant/docs/README.md)
- [Multi-tenancy](../../laravel/Modules/Tenant/docs/multi_tenancy.md)

## Note
- Tutti i collegamenti sono relativi
- Ogni modulo ha la sua documentazione specifica
- I collegamenti sono bidirezionali quando appropriato
- La documentazione è mantenuta in italiano

## Contribuire
Per contribuire alla documentazione dei moduli, seguire le [Linee Guida](../linee-guida-documentazione.md) e le [Regole dei Collegamenti](../regole_collegamenti_documentazione.md).

## Collegamenti Completi
Per una lista completa di tutti i collegamenti tra i README.md, consultare il file [README_links.md](../README_links.md).

