# Task 2: Architettura Base Backoffice

## Descrizione
Definizione e implementazione dell'architettura base del backoffice di il progetto, includendo la struttura dei moduli, l'autenticazione, le API e il sistema di logging, utilizzando Filament come framework admin.

## Sottotask

### 2.1 Definizione Struttura Moduli
- [ ] Analisi requisiti
- [ ] Definizione moduli
- [ ] Struttura directory
- [ ] Configurazione namespace
- [ ] Documentazione moduli

### 2.2 Setup Autenticazione
- [ ] Configurazione Filament Auth
- [ ] Implementazione login
- [ ] Gestione ruoli
- [ ] Recupero password
- [ ] 2FA

### 2.3 Configurazione API
- [ ] Definizione endpoints
- [ ] Documentazione Swagger
- [ ] Rate limiting
- [ ] CORS
- [ ] Versioning

### 2.4 Setup Logging
- [ ] Configurazione Log
- [ ] Error tracking
- [ ] Performance monitoring
- [ ] Audit trail
- [ ] Alerting

## Dettagli Tecnici

### Struttura Moduli
```
app/
├── Filament/
│   ├── Resources/
│   │   ├── UserResource.php
│   │   ├── PatientResource.php
│   │   └── DentistResource.php
│   ├── Pages/
│   │   ├── Dashboard.php
│   │   └── Settings.php
│   └── Widgets/
├── Models/
├── Services/
└── Providers/
```

### Configurazione Autenticazione Filament
```php
// config/filament/auth.php
'guard' => 'web',
'pages' => [
    'login' => \Filament\Pages\Auth\Login::class,
],
```

### Configurazione API
```php
// routes/api.php
Route::prefix('v1')->group(function () {
    Route::post('login', [AuthController::class, 'login']);
    Route::middleware('auth:sanctum')->group(function () {
        Route::apiResource('users', UserController::class);
        Route::apiResource('patients', PatientController::class);
    });
});
```

### Configurazione Logging
```php
// config/logging.php
'channels' => [
    'stack' => [
        'driver' => 'stack',
        'channels' => ['single', 'slack'],
    ],
    'single' => [
        'driver' => 'single',
        'path' => storage_path('logs/laravel.log'),
        'level' => 'debug',
    ],
    'slack' => [
        'driver' => 'slack',
        'url' => env('LOG_SLACK_WEBHOOK_URL'),
        'username' => 'Laravel Log',
        'emoji' => ':boom:',
        'level' => 'critical',
    ],
],
```

## Checklist di Verifica
- [ ] Moduli definiti e documentati
- [ ] Autenticazione Filament funzionante
- [ ] API testate e documentate
- [ ] Logging configurato
- [ ] Monitoring attivo

## Note
- Seguire le convenzioni PSR-12
- Documentare tutte le API
- Implementare test per ogni modulo
- Verificare la sicurezza

## Collegamenti
- [Task 1: Setup Ambiente](../roadmap_backoffice/01-setup-ambiente.md)
- [Task 3: UI/UX Base](../roadmap_backoffice/03-ui-ux-base.md) 
## Collegamenti tra versioni di 02-architettura-base.md
* [02-architettura-base.md](docs/roadmap_frontoffice/02-architettura-base.md)
* [02-architettura-base.md](docs/roadmap_backoffice/02-architettura-base.md)

