# Struttura dei Moduli

## Core Module

### Struttura
```
Modules/Core/
├── Config/
├── Console/
├── Database/
│   ├── Migrations/
│   └── Seeders/
├── Entities/
├── Http/
│   ├── Controllers/
│   ├── Middleware/
│   └── Requests/
├── Providers/
├── Resources/
├── Routes/
└── Services/
```

### Responsabilità
- Gestione utenti e autenticazione
- Gestione tenant
- Gestione permessi e ruoli
- Configurazione base del sistema

### Componenti Principali
1. **User Management**
   - CRUD utenti
   - Gestione profili
   - Reset password

2. **Tenant Management**
   - CRUD tenant
   - Configurazione tenant
   - Isolamento dati

3. **Role & Permission**
   - Gestione ruoli
   - Gestione permessi
   - Assegnazione ruoli

## Patient Module

### Struttura
```
Modules/Patient/
├── Config/
├── Console/
├── Database/
│   ├── Migrations/
│   └── Seeders/
├── Entities/
├── Filament/
│   └── Resources/
├── Http/
│   ├── Controllers/
│   └── Requests/
├── Providers/
├── Resources/
├── Routes/
└── Services/
```

### Responsabilità
- Gestione anagrafica gestanti
- Gestione ISEE
- Gestione stato gravidanza

### Componenti Principali
1. **Patient Management**
   - CRUD gestanti
   - Validazione ISEE
   - Gestione documenti

2. **Pregnancy Tracking**
   - Monitoraggio gravidanza
   - Calcolo date
   - Alert e notifiche

3. **Document Management**
   - Upload documenti
   - Gestione consensi
   - Retention policy

## Dental Module

### Struttura
```
Modules/Dental/
├── Config/
├── Console/
├── Database/
│   ├── Migrations/
│   └── Seeders/
├── Entities/
├── Filament/
│   └── Resources/
├── Http/
│   ├── Controllers/
│   └── Requests/
├── Providers/
├── Resources/
├── Routes/
└── Services/
```

### Responsabilità
- Gestione visite odontoiatriche
- Gestione trattamenti
- Gestione note cliniche

### Componenti Principali
1. **Visit Management**
   - CRUD visite
   - Form dinamici
   - Upload file

2. **Treatment Planning**
   - Piano trattamenti
   - Follow-up
   - Note cliniche

3. **Clinical Records**
   - Storico visite
   - Documenti clinici
   - Referti

## Reporting Module

### Struttura
```
Modules/Reporting/
├── Config/
├── Console/
├── Database/
│   ├── Migrations/
│   └── Seeders/
├── Entities/
├── Filament/
│   └── Resources/
├── Http/
│   ├── Controllers/
│   └── Requests/
├── Providers/
├── Resources/
├── Routes/
└── Services/
```

### Responsabilità
- Generazione report
- Analisi dati
- Export dati

### Componenti Principali
1. **Report Generation**
   - Report personalizzati
   - Template
   - Scheduling

2. **Data Analysis**
   - Statistiche
   - Grafici
   - Trend

3. **Data Export**
   - Export CSV/Excel
   - Anonimizzazione
   - Validazione

## Service Providers

### CoreServiceProvider
```php
class CoreServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->loadMigrationsFrom(__DIR__ . '/Database/Migrations');
        $this->loadRoutesFrom(__DIR__ . '/Routes/web.php');
        $this->loadViewsFrom(__DIR__ . '/Resources/views', 'core');
        
        $this->publishes([
            __DIR__ . '/Config/core.php' => config_path('core.php'),
        ], 'config');
    }
}
```

### PatientServiceProvider
```php
class PatientServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->loadMigrationsFrom(__DIR__ . '/Database/Migrations');
        $this->loadRoutesFrom(__DIR__ . '/Routes/web.php');
        
        Filament::serving(function () {
            Filament::registerResources([
                PatientResource::class,
            ]);
        });
    }
}
```

## Registrazione Moduli

### config/app.php
```php
'providers' => [
    // ...
    Modules\Core\Providers\CoreServiceProvider::class,
    Modules\Patient\Providers\PatientServiceProvider::class,
    Modules\Dental\Providers\DentalServiceProvider::class,
    Modules\Reporting\Providers\ReportingServiceProvider::class,
],
```

### composer.json
```json
{
    "autoload": {
        "psr-4": {
            "Modules\\Core\\": "Modules/Core/",
            "Modules\\Patient\\": "Modules/Patient/",
            "Modules\\Dental\\": "Modules/Dental/",
            "Modules\\Reporting\\": "Modules/Reporting/"
        }
    }
}
```

## Dipendenze tra Moduli

### Core
- Nessuna dipendenza

### Patient
- Dipende da Core
  - User management
  - Tenant management
  - Permission system

### Dental
- Dipende da Core
  - User management
  - Tenant management
- Dipende da Patient
  - Patient management
  - Document management

### Reporting
- Dipende da Core
  - User management
  - Tenant management
- Dipende da Patient
  - Patient data
- Dipende da Dental
  - Visit data
  - Treatment data

## Comandi Artisan

### Core
```bash
php artisan core:setup
php artisan core:create-tenant
php artisan core:assign-role
```

### Patient
```bash
php artisan patient:import
php artisan patient:export
php artisan patient:validate-isee
```

### Dental
```bash
php artisan dental:create-visit
php artisan dental:generate-report
php artisan dental:archive-records
```

### Reporting
```bash
php artisan reporting:generate
php artisan reporting:schedule
php artisan reporting:export
``` 
## Collegamenti tra versioni di moduli.md
* [moduli.md](docs/tecnico/moduli.md)
* [moduli.md](docs/implementazione/moduli.md)

