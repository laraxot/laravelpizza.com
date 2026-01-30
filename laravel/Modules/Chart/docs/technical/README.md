# Documentazione Tecnica - <nome progetto>

> **🔧 OBIETTIVO**: Documentazione tecnica completa per sviluppatori e amministratori di sistema

## 📋 Overview

Questa sezione contiene tutta la documentazione tecnica necessaria per lo sviluppo, deployment e manutenzione del sistema <nome progetto>, incluse specifiche architetturali, guide di installazione e procedure operative.

## 🏗️ Architettura Sistema

### Stack Tecnologico

```bash

# Backend
Laravel 10.x LTS
PHP 8.2+
Filament 4.x (Admin Panel)
MySQL 8.0+

# Frontend
Blade Templates
Alpine.js 3.x
Tailwind CSS 3.x
Livewire 3.x

# Server & Infrastructure
Ubuntu 22.04 LTS
Nginx 1.20+
PHP-FPM 8.2
Redis 7.x (Cache & Sessions)
Supervisor (Queue Worker)
```

### Architettura Moduli

```
app/
├── Modules/
│   ├── <nome progetto>/          # Modulo principale
│   │   ├── Filament/       # Admin panels
│   │   ├── Http/           # Controllers & API
│   │   ├── Models/         # Eloquent models
│   │   ├── Services/       # Business logic
│   │   ├── Actions/        # Domain actions
│   │   ├── Jobs/           # Background jobs
│   │   ├── Mail/           # Email templates
│   │   └── Notifications/  # Push notifications
│   ├── User/               # Gestione utenti
│   ├── Core/               # Funzionalità base
│   └── Notify/             # Sistema notifiche
```

## 🗄️ Database Design

### Schema Principale

```sql
-- Tabelle Core
patients (id, nome, cognome, codice_fiscale, email, ...)
studios (id, nome, partita_iva, indirizzo, ...)
dentists (id, studio_id, nome, cognome, specializzazioni, ...)
appointments (id, patient_id, studio_id, data_appuntamento, stato, ...)
availabilities (id, studio_id, dentista_id, data_ora, prenotato, ...)

-- Documenti
documents (id, patient_id, tipo_documento, file_path, stato_verifica, ...)
document_verifications (id, document_id, verificato_da, ...)

-- Notifiche
notifications (id, type, notifiable_type, notifiable_id, data, ...)
notification_preferences (id, user_id, email_enabled, sms_enabled, ...)
```

### Relazioni Chiave

```php
// Patient Model
class Patient extends User
{
    public function documents(): HasMany;
    public function appointments(): HasMany;
    public function notificationPreferences(): HasOne;
}

// Studio Model  
class Studio extends BaseModel
{
    public function dentisti(): HasMany;
    public function appointments(): HasMany;
    public function availabilities(): HasMany;
}

// Appointment Model
class Appointment extends BaseModel
{
    public function patient(): BelongsTo;
    public function studio(): BelongsTo;
    public function dentista(): BelongsTo;
    public function servizi(): BelongsToMany;
}
```

## 🔒 Sicurezza e Privacy

### Crittografia Dati

```php
// Configurazione crittografia
'encryption' => [
    'driver' => 'aes-256-gcm',
    'key' => env('APP_KEY'),
],

// Campi crittografati
protected function casts(): array
{
    return [
        'codice_fiscale' => 'encrypted',
        'telefono' => 'encrypted',
        'indirizzo_completo' => 'encrypted',
    ];
}
```

### Gestione Documenti Sensibili

```php
// Storage sicuro documenti
'documents' => [
    'driver' => 'local',
    'root' => storage_path('app/private/documents'),
    'throw' => false,
    'permissions' => [
        'file' => [
            'public' => 0600,
            'private' => 0600,
        ],
        'dir' => [
            'public' => 0755,
            'private' => 0755,
        ],
    ],
],
```

### Audit Trail

```php
// Log delle attività sensibili
use Spatie\Activitylog\LogOptions;

class Patient extends User
{
    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly(['nome', 'cognome', 'email', 'telefono'])
            ->logOnlyDirty()
            ->dontSubmitEmptyLogs();
    }
}
```

## 📡 API & Integrazione

### API REST Endpoints

```bash

# Autenticazione
POST /api/auth/login
POST /api/auth/logout  
POST /api/auth/register
POST /api/auth/password/reset

# Gestione Appuntamenti
GET    /api/studios                    # Lista studi
GET    /api/studios/{id}/availability  # Disponibilità studio
POST   /api/appointments               # Crea appuntamento
GET    /api/appointments/{id}          # Dettagli appuntamento
PUT    /api/appointments/{id}          # Modifica appuntamento
DELETE /api/appointments/{id}          # Annulla appuntamento

# Documenti
POST   /api/documents/upload           # Upload documento
GET    /api/documents/{id}             # Download documento
DELETE /api/documents/{id}             # Elimina documento
```

### Rate Limiting

```php
// Configurazione rate limiting
'api' => [
    'throttle:api',
    \Illuminate\Routing\Middleware\SubstituteBindings::class,
],

// Limiti specifici
Route::middleware('throttle:10,1')->group(function () {
    Route::post('/auth/login');
    Route::post('/auth/register');
});

Route::middleware('throttle:60,1')->group(function () {
    Route::apiResource('appointments', AppointmentController::class);
});
```

## 🚀 Deployment & DevOps

### Configurazione Server

```bash

# Nginx Configuration
server {
    listen 80;
    server_name <nome progetto>.local;
    root /var/www/html/_bases/base_<nome progetto>/public;
    
    index index.php;
    
    location / {
        try_files $uri $uri/ /index.php?$query_string;
    }
    
    location ~ \.php$ {
        fastcgi_pass unix:/var/run/php/php8.2-fpm.sock;
        fastcgi_index index.php;
        fastcgi_param SCRIPT_FILENAME $realpath_root$fastcgi_script_name;
        include fastcgi_params;
    }
}
```

### Environment Configuration

```bash

# .env Production
APP_ENV=production
APP_DEBUG=false
APP_URL=https://<nome progetto>.it

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=<nome progetto>_prod
DB_USERNAME=<nome progetto>_user
DB_PASSWORD=secure_password

CACHE_DRIVER=redis
SESSION_DRIVER=redis
QUEUE_CONNECTION=redis

MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=noreply@<nome progetto>.it
MAIL_PASSWORD=app_password
```

### Queue Workers

```bash

# Supervisor Configuration
[program:<nome progetto>-worker]
process_name=%(program_name)s_%(process_num)02d
command=php /var/www/html/_bases/base_<nome progetto>/artisan queue:work redis --sleep=3 --tries=3 --max-time=3600
autostart=true
autorestart=true
stopasgroup=true
killasgroup=true
user=www-data
numprocs=4
redirect_stderr=true
stdout_logfile=/var/log/supervisor/<nome progetto>-worker.log
stopwaitsecs=3600
```

## 📊 Monitoring & Logging

### Application Monitoring

```php
// Configurazione logging
'channels' => [
    'daily' => [
        'driver' => 'daily',
        'path' => storage_path('logs/laravel.log'),
        'level' => env('LOG_LEVEL', 'debug'),
        'days' => 14,
        'replace_placeholders' => true,
    ],
    
    'appointments' => [
        'driver' => 'daily',
        'path' => storage_path('logs/appointments.log'),
        'level' => 'info',
        'days' => 30,
    ],
],
```

### Performance Metrics

```php
// Key Performance Indicators
class PerformanceMetrics
{
    public function getMetrics(): array
    {
        return [
            'response_time_avg' => $this->getAverageResponseTime(),
            'database_queries_avg' => $this->getAverageQueriesPerRequest(),
            'memory_usage_peak' => $this->getPeakMemoryUsage(),
            'error_rate' => $this->getErrorRate(),
            'uptime_percentage' => $this->getUptimePercentage(),
        ];
    }
}
```

### Health Checks

```php
// Health check endpoints
Route::get('/health', function () {
    return response()->json([
        'status' => 'ok',
        'timestamp' => now()->toISOString(),
        'database' => DB::connection()->getPdo() ? 'connected' : 'disconnected',
        'cache' => Cache::get('health_check') ? 'working' : 'not_working',
        'queue' => Queue::size() < 1000 ? 'healthy' : 'overloaded',
    ]);
});
```

## 🧪 Testing & Quality Assurance

### Test Suite Structure

```bash
tests/
├── Feature/               # Test funzionali
│   ├── Auth/             # Test autenticazione
│   ├── Appointments/     # Test prenotazioni
│   ├── Documents/        # Test documenti
│   └── Notifications/    # Test notifiche
├── Unit/                 # Test unitari
│   ├── Models/           # Test modelli
│   ├── Services/         # Test servizi
│   └── Actions/          # Test azioni
└── Browser/              # Test browser (Dusk)
    ├── Registration/     # Test registrazione
    └── Booking/          # Test prenotazione
```

### Code Quality Tools

```bash

# PHPStan (Analisi statica)
./vendor/bin/phpstan analyse --level=8

# PHP CS Fixer (Code style)
./vendor/bin/php-cs-fixer fix

# PHPUnit (Test suite)
./vendor/bin/phpunit --coverage-html=coverage

# Larastan (Laravel + PHPStan)
./vendor/bin/phpstan analyse --memory-limit=2G
```

## 📚 Guide Operative

### Backup & Recovery

```bash

# Script backup database
#!/bin/bash
BACKUP_DIR="/backups/<nome progetto>"
DATE=$(date +%Y%m%d_%H%M%S)

mysqldump -u <nome progetto>_user -p <nome progetto>_prod > $BACKUP_DIR/db_backup_$DATE.sql
tar -czf $BACKUP_DIR/files_backup_$DATE.tar.gz /var/www/html/_bases/base_<nome progetto>/storage

# Retention: keep last 30 days
find $BACKUP_DIR -name "*.sql" -mtime +30 -delete
find $BACKUP_DIR -name "*.tar.gz" -mtime +30 -delete
```

### Maintenance Mode

```bash

# Entrata in manutenzione
php artisan down --refresh=15 --retry=60 --secret="maintenance-token"

# Uscita da manutenzione  
php artisan up

# Manutenzione programmata
php artisan schedule:run
```

### Performance Optimization

```bash

# Cache optimization
php artisan config:cache
php artisan route:cache
php artisan view:cache
php artisan event:cache

# Database optimization
php artisan model:prune
php artisan queue:prune-batches --hours=48

# Asset optimization
npm run production
php artisan storage:link
```

## 🔧 Troubleshooting

### Common Issues

```bash

# Permission issues
sudo chown -R www-data:www-data /var/www/html/_bases/base_<nome progetto>
sudo chmod -R 755 /var/www/html/_bases/base_<nome progetto>
sudo chmod -R 777 /var/www/html/_bases/base_<nome progetto>/storage
sudo chmod -R 777 /var/www/html/_bases/base_<nome progetto>/bootstrap/cache

# Queue issues
php artisan queue:restart
supervisorctl restart <nome progetto>-worker:*

# Cache issues
php artisan cache:clear
php artisan config:clear
php artisan view:clear
```

### Debug Tools

```php
// Laravel Telescope (Development)
'telescope' => [
    'enabled' => env('TELESCOPE_ENABLED', false),
    'path' => env('TELESCOPE_PATH', 'telescope'),
],

// Debug Bar (Development)
'debugbar' => [
    'enabled' => env('DEBUGBAR_ENABLED', false),
],
```

## 📞 Supporto e Contatti

### Team Tecnico
- **Lead Developer**: [email]
- **DevOps Engineer**: [email]  
- **QA Manager**: [email]

### Documentazione Aggiuntiva
- [Setup Ambiente Sviluppo](../roadmap_frontoffice/setup_ambiente_sviluppo.md)
- [Struttura Base Laravel](../roadmap_frontoffice/struttura_base_laravel.md)
- [Database e Migrazioni](../roadmap_frontoffice/database_migrazioni_base.md)

---

**📅 Ultimo aggiornamento**: 5 Giugno 2025  
**🔄 Versione documentazione**: 1.2  
