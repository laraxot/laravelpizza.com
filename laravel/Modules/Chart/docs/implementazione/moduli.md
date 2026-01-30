# Struttura dei Moduli

## Moduli Principali

### 1. Core Module (module_xot_fila3)
- Gestione base del sistema
- Configurazioni globali
- Middleware di autenticazione
- Gestione multi-tenant
- Logging e monitoraggio
- Funzionalità base condivise tra moduli

### 2. Patient Module
- Gestione pazienti
- Gestione ISEE
- Documenti paziente
- Anamnesi
- Storico visite

### 3. Dental Module
- Gestione odontoiatri
- Gestione appuntamenti
- Gestione visite
- Gestione referti
- Gestione rimborsi

### 4. Reporting Module
- Statistiche e report
- Esportazione dati
- Dashboard
- Analisi trend

### 5. User Module
- Gestione utenti
- Gestione ruoli e permessi
- Profili utente
- Log di accesso

### 6. Tenant Module
- Gestione multi-tenant
- Configurazioni per tenant
- Isolamento dati
- Gestione risorse

### 7. Notify Module
- Sistema di notifiche
- Email
- SMS
- Notifiche in-app

## Struttura Standard Modulo

```
laravel/Modules/[NomeModulo]/
├── Config/
│   └── config.php
├── Console/
│   └── Commands/
├── Database/
│   ├── Migrations/
│   └── Seeders/
├── Entities/
│   └── Models/
├── Http/
│   ├── Controllers/
│   ├── Middleware/
│   └── Requests/
├── Providers/
│   └── [NomeModulo]ServiceProvider.php
├── Resources/
│   ├── assets/
│   │   ├── js/
│   │   └── sass/
│   └── views/
├── Routes/
│   ├── api.php
│   └── web.php
├── Services/
│   └── [NomeModulo]Service.php
├── Tests/
│   ├── Feature/
│   └── Unit/
└── module.json
```

## Dipendenze tra Moduli

### Core Dependencies
- module_xot_fila3 → module_tenant_fila3
- module_xot_fila3 → module_notify_fila3
- Tutti i moduli dipendono da module_xot_fila3

### Patient Dependencies
- Patient → module_xot_fila3
- Patient → module_tenant_fila3
- Patient → module_notify_fila3

### Dental Dependencies
- Dental → module_xot_fila3
- Dental → Patient
- Dental → module_tenant_fila3
- Dental → module_notify_fila3

### Reporting Dependencies
- Reporting → module_xot_fila3
- Reporting → Patient
- Reporting → Dental
- Reporting → module_tenant_fila3

## Configurazione Moduli

### 1. Registrazione
```php
// config/app.php
'providers' => [
    Modules\Xot\Providers\XotServiceProvider::class,
    Modules\Tenant\Providers\TenantServiceProvider::class,
    Modules\Notify\Providers\NotifyServiceProvider::class,
    Modules\Patient\Providers\PatientServiceProvider::class,
    // ...
]
```

### 2. Middleware
```php
// app/Http/Kernel.php
protected $middlewareGroups = [
    'web' => [
        \Modules\Xot\Http\Middleware\TenantMiddleware::class,
        // ...
    ]
];
```

### 3. Routes
```php
// routes/web.php
Route::middleware(['web', 'auth'])->group(function () {
    Route::module('patient');
    Route::module('dental');
    // ...
});
```

## Best Practices

### 1. Naming Conventions
- Nome modulo: PascalCase (Patient, Dental, etc.)
- Nome file: snake_case
- Nome classe: PascalCase
- Nome tabella: snake_case plurale

### 2. Database
- Prefisso tabelle: `module_name_`
- Foreign keys: `module_name_id`
- Indici per performance
- Soft deletes dove appropriato

### 3. API
- Versioning: v1, v2, etc.
- Resource controllers
- API Resources per trasformazione dati
- Validazione requests

### 4. Testing
- Unit tests per services
- Feature tests per controllers
- Test di integrazione per moduli
- Coverage minimo 80%

### 5. Security
- Middleware di autenticazione
- Policy per autorizzazioni
- Validazione input
- Sanitizzazione output

## Deployment

### 1. Composer
```json
{
    "require": {
        "laravel/Modules": "^8.0",
        "laravel/framework": "^10.0"
    }
}
```

### 2. Environment
```env
MODULE_STATUS=true
MODULE_CACHE=true
```

### 3. Cache
```bash
php artisan module:cache
php artisan module:config:cache
php artisan module:route:cache
```

## Manutenzione

### 1. Aggiornamento
```bash
composer update
php artisan module:update [NomeModulo]
```

### 2. Cache
```bash
php artisan module:cache:clear
php artisan module:config:clear
php artisan module:route:clear
```

### 3. Logs
```bash
tail -f storage/logs/module_[nome].log
``` 
## Collegamenti tra versioni di moduli.md
* [moduli.md](docs/tecnico/moduli.md)
* [moduli.md](docs/implementazione/moduli.md)

