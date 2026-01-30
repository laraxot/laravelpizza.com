# Fase 1: Setup Ambiente e Struttura Base

## Stato di Avanzamento
- [x] Definizione dei requisiti di sistema
- [x] Documentazione della struttura modulare 
- [x] Analisi dei moduli necessari
- [x] Documentazione della configurazione dei moduli
- [x] Analisi dell'architettura del sistema
- [x] Analisi della sicurezza e compliance GDPR
- [x] Definizione dei flussi utente e interfacce
- [ ] Setup dell'ambiente di sviluppo
- [ ] Implementazione della struttura modulare
- [ ] Integrazione dei moduli Laraxot
- [ ] Configurazione dell'autenticazione multi-tenant con Filament
- [ ] Setup del testing automatizzato

## Obiettivi
- Setup dell'ambiente di sviluppo completo
- Implementazione della struttura modulare
- Configurazione dell'autenticazione con Filament
- Setup del testing automatizzato
- Documentazione tecnica dettagliata
- Preparazione al deployment in ambiente di produzione

## Setup Ambiente di Sviluppo (Da completare)

### Requisiti di Sistema

#### Requisiti Software Obbligatori
- **PHP 8.2+**
  - Estensioni richieste: BCMath, Ctype, Fileinfo, JSON, Mbstring, OpenSSL, PDO, Tokenizer, XML, cURL, GD
  - Impostazioni php.ini: `memory_limit=256M`, `max_execution_time=120`, `opcache.save_comments=1` (per doctrine/annotations)
  - `session.cookie_secure=1` e `session.cookie_httponly=1` per sicurezza

- **Composer 2.5+**
  - Limite di memoria PHP-CLI aumentato a 2G per gestire le dipendenze dei moduli Laraxot

- **MySQL 8.0+**
  - Configurazione: `character-set-server=utf8mb4`, `collation-server=utf8mb4_unicode_ci`
  - User con privilegi per la creazione/modifica di database e tabelle
  - InnoDB come storage engine per supporto transazioni e foreign keys

- **Node.js 18+**
  - npm 9.0+ o pnpm 8+
  - Pacchetti globali: `npm i -g vite`

- **Git 2.3+**

#### Requisiti Software Opzionali
- **Docker 24.0+**
  - Docker Compose v2.20+
  - Risorse minime allocate: 4GB RAM, 2 CPU

- **Redis 7.0+** (consigliato per cache, sessioni e code)

- **Ambiente di CI/CD**
  - GitHub Actions o GitLab CI/CD
  - Account Sentry per il monitoraggio degli errori

#### Requisiti Hardware (Sviluppo)
- CPU: 4 core o superiore
- RAM: 8GB minimo, 16GB consigliati
- Spazio su disco: 20GB minimo
- Connessione Internet stabile (per installazione dipendenze e deploy)

#### Strumenti di Sviluppo Consigliati
- IDE: PhpStorm o VSCode con estensioni PHP, Laravel, Tailwind
- Laravel Telescope (per debugging)
- Tinkerwell (per interazione rapida con il codice)
- Postman o Insomnia (per test API)
- Table Plus o MySQL Workbench (per gestione database)

### Passi di Setup

#### 1. Clonare il repository
Per iniziare, è necessario clonare il repository del progetto:

```bash
git clone git@github.com:organization/<nome progetto>.git
cd <nome progetto>
```

**Stato**: Da completare
**Data target**: 29/03/2024
**Note**: È necessario creare il repository GitHub prima di questo passo.

#### 2. Configurare l'ambiente locale
Ci sono due opzioni per configurare l'ambiente:

**Opzione A: Docker** (consigliata)

Creare un ambiente Docker completo con tutti i servizi necessari per il progetto:

```bash

# Creare il docker-compose.yml nella root del progetto
cat > docker-compose.yml << 'EOL'
version: '3.8'

services:
  # PHP Application with Nginx
  app:
    image: serversideup/php:8.2-fpm-nginx
    container_name: <nome progetto>-app
    restart: unless-stopped
    volumes:
      - ./:/var/www/html
      - ./docker/nginx/default.conf:/etc/nginx/sites-available/default.conf
      - ./docker/php/local.ini:/usr/local/etc/php/conf.d/local.ini
    environment:
      - APP_ENV=local
      - CONTAINER_ROLE=app
      - DB_HOST=db
      - DB_PORT=3306
      - DB_DATABASE=<nome progetto>
      - DB_USERNAME=<nome progetto>
      - DB_PASSWORD=secret_password
      - REDIS_HOST=redis
      - CACHE_DRIVER=redis
      - SESSION_DRIVER=redis
      - QUEUE_CONNECTION=redis
    ports:
      - "8080:80"
    depends_on:
      - db
      - redis
    networks:
      - <nome progetto>-network

  # Database
  db:
    image: mysql:8.0
    container_name: <nome progetto>-db
    restart: unless-stopped
    ports:
      - "33060:3306"
    environment:
      - MYSQL_DATABASE=<nome progetto>
      - MYSQL_USER=<nome progetto>
      - MYSQL_PASSWORD=secret_password
      - MYSQL_ROOT_PASSWORD=root_password
    volumes:
      - db_data:/var/lib/mysql
      - ./docker/mysql/my.cnf:/etc/mysql/conf.d/my.cnf
    networks:
      - <nome progetto>-network
    command: ['mysqld', '--character-set-server=utf8mb4', '--collation-server=utf8mb4_unicode_ci']

  # Redis for Cache & Queue
  redis:
    image: redis:7-alpine
    container_name: <nome progetto>-redis
    restart: unless-stopped
    ports:
      - "63790:6379"
    volumes:
      - redis_data:/data
    networks:
      - <nome progetto>-network
    command: redis-server --appendonly yes --requirepass "redis_password"

  # Queue Worker
  queue:
    image: serversideup/php:8.2-cli
    container_name: <nome progetto>-queue
    restart: unless-stopped
    volumes:
      - ./:/var/www/html
    environment:
      - APP_ENV=local
      - CONTAINER_ROLE=queue
    depends_on:
      - app
      - db
      - redis
    networks:
      - <nome progetto>-network
    command: php artisan queue:work --sleep=3 --tries=3 --timeout=90

  # Mailhog for Email Testing
  mailhog:
    image: mailhog/mailhog
    container_name: <nome progetto>-mailhog
    restart: unless-stopped
    ports:
      - "1025:1025" # SMTP port
      - "8025:8025" # Web UI port
    networks:
      - <nome progetto>-network

networks:
  <nome progetto>-network:
    driver: bridge

volumes:
  db_data:
  redis_data:
EOL

# Creare directory necessarie per i file di configurazione
mkdir -p docker/nginx docker/php docker/mysql

# Configurazione Nginx
cat > docker/nginx/default.conf << 'EOL'
server {
    listen 80;
    index index.php index.html;
    error_log  /var/log/nginx/error.log;
    access_log /var/log/nginx/access.log;
    root /var/www/html/public;
    client_max_body_size 100M;

    location ~ \.php$ {
        try_files $uri =404;
        fastcgi_split_path_info ^(.+\.php)(/.+)$;
        fastcgi_pass unix:/var/run/php-fpm.sock;
        fastcgi_index index.php;
        include fastcgi_params;
        fastcgi_param SCRIPT_FILENAME $document_root$fastcgi_script_name;
        fastcgi_param PATH_INFO $fastcgi_path_info;
    }

    location / {
        try_files $uri $uri/ /index.php?$query_string;
        gzip_static on;
    }

    # Deny access to . files
    location ~ /\. {
        deny all;
    }
}
EOL

# Configurazione PHP
cat > docker/php/local.ini << 'EOL'
upload_max_filesize = 40M
post_max_size = 40M
memory_limit = 512M
max_execution_time = 600
opcache.memory_consumption = 128
opcache.interned_strings_buffer = 16
opcache.max_accelerated_files = 16000
opcache.revalidate_freq = 0
opcache.save_comments = 1
EOL

# Configurazione MySQL
cat > docker/mysql/my.cnf << 'EOL'
[mysqld]
character-set-server = utf8mb4
collation-server = utf8mb4_unicode_ci
default_authentication_plugin = mysql_native_password
innodb_buffer_pool_size = 256M
max_allowed_packet = 64M
sql_mode = "STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION"

[client]
default-character-set = utf8mb4
EOL

# Avviare i container
docker-compose up -d

# Generare il file .env da .env.example nell'ambiente Docker
docker-compose exec app cp .env.example .env
docker-compose exec app php artisan key:generate

# Installare le dipendenze e compilare gli assets
docker-compose exec app composer install
docker-compose exec app npm install
docker-compose exec app npm run build

# Eseguire le migrazioni con seed
docker-compose exec app php artisan migrate --seed
```

**Opzione B: Setup Manuale**
1. Installare PHP 8.2+, Composer, Node.js, e MySQL
2. Configurare il server web (Apache/Nginx)
3. Creare il database MySQL

**Stato**: Da completare
**Data target**: 29/03/2024

#### 3. Installare le dipendenze
Dopo aver clonato il repository e configurato l'ambiente, è necessario installare le dipendenze:

```bash

# Installare le dipendenze PHP
composer install

# Installare le dipendenze NPM
npm install
```

**Stato**: Da completare
**Data target**: 29/03/2024

#### 4. Configurare il file .env
Copiare il file `.env.example` in `.env` e generare la chiave dell'applicazione:

```bash
cp .env.example .env
php artisan key:generate
```

Configurare le variabili d'ambiente nel file `.env`:

```
APP_NAME=il progetto
APP_ENV=local
APP_DEBUG=true
APP_URL=http://localhost:8000

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=<nome progetto>
DB_USERNAME=root
DB_PASSWORD=

CACHE_DRIVER=file
SESSION_DRIVER=file
QUEUE_CONNECTION=sync

MAIL_MAILER=smtp
MAIL_HOST=mailhog
MAIL_PORT=1025
MAIL_USERNAME=null
MAIL_PASSWORD=null
MAIL_ENCRYPTION=null
MAIL_FROM_ADDRESS="hello@example.com"
MAIL_FROM_NAME="${APP_NAME}"
```

Se si utilizza Docker, modificare le variabili DB_* per puntare al container MySQL.

**Stato**: Da completare
**Data target**: 29/03/2024

## Implementazione Struttura Modulare (In corso)

### 1. Creazione della Struttura Laravel
Prima di tutto, è necessario creare una nuova installazione Laravel:

```bash
composer create-project --prefer-dist laravel/laravel laravel
cd laravel
```

**Stato**: Da completare
**Data target**: 30/03/2024

### 2. Installazione Laravel Modules
Per implementare la struttura modulare, installeremo Laravel Modules:

```bash
composer require nwidart/laravel-modules
```

Pubblicare i file di configurazione:

```bash
php artisan vendor:publish --provider="Nwidart\Modules\LaravelModulesServiceProvider"
```

**Stato**: Da completare
**Data target**: 30/03/2024

### 3. Configurazione composer.json
Modificare il file `composer.json` per aggiungere l'autoloading dei moduli:

```bash

# Aprire il file composer.json e modificare la sezione "autoload" e "extra"
cat > composer.json << 'EOL'
{
    "name": "laravel/laravel",
    "type": "project",
    "description": "The skeleton application for the Laravel framework.",
    "keywords": ["laravel", "framework"],
    "license": "MIT",
    "require": {
        "php": "^8.2",
        "laravel/framework": "^11.0",
        "nwidart/laravel-modules": "^10.0"
    },
    "autoload": {
        "psr-4": {
            "App\\": "app/",
            "Database\\Factories\\": "database/factories/",
            "Database\\Seeders\\": "database/seeders/",
            "Modules\\": "Modules/"
        }
    },
    "extra": {
        "laravel": {
            "dont-discover": []
        },
        "merge-plugin": {
            "include": [
                "Modules/*/composer.json"
            ],
            "recurse": true,
            "replace": false,
            "ignore-duplicates": false,
            "merge-dev": true,
            "merge-extra": false,
            "merge-extra-deep": false,
            "merge-scripts": false
        }
    }
}
EOL

# Aggiornare le dipendenze
composer dump-autoload
```

**Stato**: Da completare
**Data target**: 30/03/2024

### 4. Creazione dei Moduli Base
Creare i moduli custom necessari:

```bash

# Creare il modulo Patient
php artisan module:make Patient

# Creare il modulo Dental
php artisan module:make Dental
```

**Stato**: Da completare
**Data target**: 31/03/2024

### 5. Importazione dei Moduli Laraxot
Per integrare i moduli Laraxot, utilizzeremo git subtree:

```bash

# Creare la directory Modules se non esiste
mkdir -p laravel/Modules

# Importare i moduli Laraxot tramite git subtree

# Moduli Core
git subtree add --prefix laravel/Modules/Xot git@github.com:laraxot/module_xot_fila3.git dev
git subtree add --prefix laravel/Modules/Lang git@github.com:laraxot/module_lang_fila3.git dev
git subtree add --prefix laravel/Modules/Tenant git@github.com:laraxot/module_tenant_fila3.git dev
git subtree add --prefix laravel/Modules/User git@github.com:laraxot/module_user_fila3.git dev
git subtree add --prefix laravel/Modules/Media git@github.com:laraxot/module_media_fila3.git dev
git subtree add --prefix laravel/Modules/Activity git@github.com:laraxot/module_activity_fila3.git dev
git subtree add --prefix laravel/Modules/Gdpr git@github.com:laraxot/module_gdpr_fila3.git dev

# Moduli Frontend
git subtree add --prefix laravel/Modules/UI git@github.com:laraxot/module_ui_fila3.git dev
git subtree add --prefix laravel/Themes/One git@github.com:laraxot/theme_one_fila3.git dev

# Moduli Funzionali
git subtree add --prefix laravel/Modules/Notify git@github.com:laraxot/module_notify_fila3.git dev
git subtree add --prefix laravel/Modules/Cms git@github.com:laraxot/module_cms_fila3.git dev

# Moduli Utilità
git subtree add --prefix laravel/Modules/Job git@github.com:laraxot/module_job_fila3.git dev
git subtree add --prefix laravel/Modules/Chart git@github.com:laraxot/module_chart_fila3.git dev
```

#### Note importanti sull'importazione dei moduli Laraxot:
1. L'ordine di importazione è importante: prima i moduli core, poi i moduli frontend, infine i moduli funzionali e di utilità
2. Dopo l'importazione, verificare che tutti i moduli siano stati correttamente installati
3. In caso di conflitti, utilizzare l'opzione `--squash` per appiattire la storia

**Stato**: Da completare
**Data target**: 2-3/04/2024

### 6. Configurazione dei Moduli
Per ogni modulo, dobbiamo configurare correttamente il file `module.json` e creare o aggiornare il Service Provider:

#### 6.1 Service Provider per i Moduli Custom
Per ogni modulo custom (Patient, Dental), creare un Service Provider che estende XotBaseServiceProvider:

```php
// File: laravel/Modules/Patient/Providers/PatientServiceProvider.php
<?php

namespace Modules\Patient\Providers;

use Modules\Xot\Providers\XotBaseServiceProvider;

class PatientServiceProvider extends XotBaseServiceProvider
{
    public string $name = 'Patient';
    protected string $module_dir = __DIR__;
    protected string $module_ns = __NAMESPACE__;
}
```

```php
// File: laravel/Modules/Dental/Providers/DentalServiceProvider.php
<?php

namespace Modules\Dental\Providers;

use Modules\Xot\Providers\XotBaseServiceProvider;

class DentalServiceProvider extends XotBaseServiceProvider
{
    public string $name = 'Dental';
    protected string $module_dir = __DIR__;
    protected string $module_ns = __NAMESPACE__;
}
```

#### 6.2 Configurazione module.json
Aggiornare il file `module.json` per ogni modulo custom:

```json
// File: laravel/Modules/Patient/module.json
{
    "name": "Patient",
    "alias": "patient",
    "description": "Gestione pazienti e ISEE",
    "keywords": [],
    "priority": 10,
    "active": 1,
    "order": 10,
    "providers": [
        "Modules\\Patient\\Providers\\PatientServiceProvider"
    ],
    "aliases": {},
    "files": [],
    "requires": [
        "Xot",
        "User",
        "Media",
        "Gdpr"
    ]
}
```

```json
// File: laravel/Modules/Dental/module.json
{
    "name": "Dental",
    "alias": "dental",
    "description": "Gestione visite e trattamenti dentali",
    "keywords": [],
    "priority": 11,
    "active": 1,
    "order": 11,
    "providers": [
        "Modules\\Dental\\Providers\\DentalServiceProvider"
    ],
    "aliases": {},
    "files": [],
    "requires": [
        "Xot",
        "Patient",
        "User",
        "Media"
    ]
}
```

**Stato**: Da completare
**Data target**: 3-4/04/2024

## Configurazione Autenticazione Multi-Tenant con Filament (Da completare)

### 1. Installazione del Sistema di Autenticazione Avanzato

Questo passo integra Filament, Spatie Permission e altri componenti necessari per un'autenticazione robusta e multi-tenant:

```bash

# Installazione del pannello amministrativo Filament e plugin per ruoli e permessi
composer require filament/filament:"^3.2" \
    filament/spatie-laravel-permission-plugin:"^3.0" \
    spatie/laravel-permission:"^6.0" \
    spatie/laravel-activitylog:"^4.7" \
    bezhanSalleh/filament-shield:"^3.0" \
    filipfonal/filament-log-manager:"^2.0"

# Installazione pacchetti per autenticazione forte
composer require laravel/fortify:"^1.18" \
    bacon/bacon-qr-code:"^2.0" \
    pragmarx/google2fa-laravel:"^2.1"

# Pubblicazione file di configurazione
php artisan vendor:publish --provider="Laravel\Fortify\FortifyServiceProvider"
php artisan vendor:publish --provider="Spatie\Permission\PermissionServiceProvider"
php artisan vendor:publish --provider="Spatie\Activitylog\ActivitylogServiceProvider" --tag="migrations"
php artisan vendor:publish --tag="filament-config"
php artisan shield:install --fresh
```

**Stato**: Da completare  
**Data target**: 4/04/2024  
**Responsabile**: Team Backend

### 2. Configurazione Multi-Tenant

Configure il sistema per supportare più tenant (cliniche), con isolamento dei dati e permessi specifici:

```php
// File: config/tenancy.php
<?php

return [
    'tenant_model' => \Modules\Tenant\Models\Tenant::class,
    
    'tenant_user_model' => \Modules\Tenant\Models\TenantUser::class,
    
    'tenant_types' => [
        'clinic' => [
            'name' => 'Clinica',
            'fields' => [
                'name' => 'required|string|max:100',
                'address' => 'required|string|max:255',
                'vat_number' => 'required|string|max:20',
                'email' => 'required|email',
                'phone' => 'required|string|max:20',
            ],
        ],
        'lab' => [
            'name' => 'Laboratorio',
            'fields' => [
                'name' => 'required|string|max:100',
                'address' => 'required|string|max:255',
                'vat_number' => 'required|string|max:20',
                'email' => 'required|email',
                'phone' => 'required|string|max:20',
                'lab_type' => 'required|string|in:analysis,production',
            ],
        ],
    ],
    
    'database' => [
        'separator' => '_',
        'prefix' => 'tenant',
        'suffix' => '',
    ],
    
    'cache' => [
        'tenant_key_prefix' => 'tenant_',
        'ttl' => 3600, // 1 hour
    ],
];
```

**Stato**: Da completare  
**Data target**: 4/04/2024  
**Responsabile**: Team Backend

### 3. Implementazione Sicurezza e Login Multi-Factor

Configurare la sicurezza avanzata includendo autenticazione a due fattori e logging dettagliato degli accessi:

```php
// File: config/fortify.php (aggiunte)
'features' => [
    Features::registration(),
    Features::resetPasswords(),
    Features::emailVerification(),
    Features::updateProfileInformation(),
    Features::updatePasswords(),
    Features::twoFactorAuthentication([
        'confirm' => true,
        'confirmPassword' => true,
    ]),
],

'password_rules' => 'min:10|regex:/^.*(?=.{3,})(?=.*[a-zA-Z])(?=.*[0-9])(?=.*[\d\x])(?=.*[!$@%]).*$/|confirmed',

'login_throttling' => [
    'enabled' => true,
    'max_attempts' => 5,
    'lockout_time' => 300, // 5 minuti
],
```

```php
// File: app/Actions/LoginLoggingAction.php
<?php

namespace App\Actions;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Modules\Activity\Models\LoginActivity;
use Spatie\QueueableAction\QueueableAction;

class LoginLoggingAction
{
    use QueueableAction;

    public function execute(Request $request, $user = null, $successful = false)
    {
        // Registra il tentativo di login, sia riuscito che fallito
        LoginActivity::create([
            'user_id' => $user ? $user->id : null,
            'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent(),
            'successful' => $successful,
            'tenant_id' => session('tenant_id'),
        ]);

        // Verifica pattern sospetti (tentativi multipli, IP insoliti)
        if (!$successful) {
            $recentFailures = LoginActivity::where('ip_address', $request->ip())
                ->where('successful', false)
                ->where('created_at', '>=', now()->subHour())
                ->count();

            if ($recentFailures >= 10) {
                Log::channel('security')->warning(
                    'Possibile attacco brute force rilevato',
                    [
                        'ip' => $request->ip(),
                        'user_agent' => $request->userAgent(),
                        'attempts' => $recentFailures
                    ]
                );
            }
        }
    }
}
```

**Stato**: Da completare  
**Data target**: 4/04/2024  
**Responsabile**: Team Backend

### 3. Configurazione dei Ruoli e Permessi
Creare un seeder per i ruoli e i permessi:

```php
// File: laravel/database/seeders/RoleAndPermissionSeeder.php
<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RoleAndPermissionSeeder extends Seeder
{
    public function run()
    {
        // Crea ruoli
        $admin = Role::create(['name' => 'admin']);
        $doctor = Role::create(['name' => 'doctor']);
        $assistant = Role::create(['name' => 'assistant']);
        $patient = Role::create(['name' => 'patient']);

        // Crea permessi
        $permissions = [
            'view_patients',
            'create_patients',
            'edit_patients',
            'delete_patients',
            'view_visits',
            'create_visits',
            'edit_visits',
            'delete_visits',
            'view_isee',
            'create_isee',
            'edit_isee',
            'delete_isee',
        ];

        foreach ($permissions as $permission) {
            Permission::create(['name' => $permission]);
        }

        // Assegna permessi ai ruoli
        $admin->givePermissionTo(Permission::all());
        
        $doctor->givePermissionTo([
            'view_patients',
            'create_patients',
            'edit_patients',
            'view_visits',
            'create_visits',
            'edit_visits',
            'view_isee',
            'create_isee',
            'edit_isee',
        ]);
        
        $assistant->givePermissionTo([
            'view_patients',
            'create_patients',
            'view_visits',
            'create_visits',
            'view_isee',
        ]);
        
        $patient->givePermissionTo([
            'view_patients',
            'view_visits',
            'view_isee',
        ]);
    }
}
```

Aggiornare il seeder principale:

```php
// File: laravel/database/seeders/DatabaseSeeder.php
<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        $this->call([
            RoleAndPermissionSeeder::class,
        ]);
    }
}
```

Eseguire il seeder:

```bash
php artisan db:seed
```

**Stato**: Da completare
**Data target**: 5/04/2024

### 4. Configurazione Filament Panel
Creare un provider per il pannello amministrativo di Filament:

```php
// File: laravel/app/Providers/Filament/AdminPanelProvider.php
<?php

namespace App\Providers\Filament;

use Filament\Panel;
use Filament\PanelProvider;
use Filament\Support\Colors\Color;
use Filament\Http\Middleware\Authenticate;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\Cookie\Middleware\EncryptCookies;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Session\Middleware\AuthenticateSession;
use Illuminate\View\Middleware\ShareErrorsFromSession;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use Modules\Tenant\Http\Middleware\TenantMiddleware;
use Modules\Gdpr\Http\Middleware\GdprComplianceMiddleware;

class AdminPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        return $panel
            ->default()
            ->id('admin')
            ->path('admin')
            ->login()
            ->colors([
                'primary' => Color::Amber,
            ])
            ->discoverResources(in: app_path('Filament/Resources'), for: 'App\\Filament\\Resources')
            ->discoverPages(in: app_path('Filament/Pages'), for: 'App\\Filament\\Pages')
            ->discoverWidgets(in: app_path('Filament/Widgets'), for: 'App\\Filament\\Widgets')
            ->middleware([
                EncryptCookies::class,
                AddQueuedCookiesToResponse::class,
                StartSession::class,
                AuthenticateSession::class,
                ShareErrorsFromSession::class,
                VerifyCsrfToken::class,
                SubstituteBindings::class,
                TenantMiddleware::class,
                GdprComplianceMiddleware::class,
            ])
            ->authMiddleware([
                Authenticate::class,
            ]);
    }
}
```

**Stato**: Da completare
**Data target**: 5/04/2024

## Setup Testing (Da completare)

### 1. Configurazione PHPUnit
Aggiornare il file `phpunit.xml` per configurare l'ambiente di test:

```xml
<?xml version="1.0" encoding="UTF-8"?>
<phpunit xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance"
         xsi:noNamespaceSchemaLocation="vendor/phpunit/phpunit/phpunit.xsd"
         bootstrap="vendor/autoload.php"
         colors="true"
>
    <testsuites>
        <testsuite name="Unit">
            <directory>tests/Unit</directory>
        </testsuite>
        <testsuite name="Feature">
            <directory>tests/Feature</directory>
        </testsuite>
        <testsuite name="Modules">
            <directory>Modules/*/Tests</directory>
        </testsuite>
    </testsuites>
    <source>
        <include>
            <directory>app</directory>
            <directory>Modules</directory>
        </include>
    </source>
    <php>
        <env name="APP_ENV" value="testing"/>
        <env name="BCRYPT_ROUNDS" value="4"/>
        <env name="CACHE_DRIVER" value="array"/>
        <env name="DB_CONNECTION" value="sqlite"/>
        <env name="DB_DATABASE" value=":memory:"/>
        <env name="MAIL_MAILER" value="array"/>
        <env name="PULSE_ENABLED" value="false"/>
        <env name="QUEUE_CONNECTION" value="sync"/>
        <env name="SESSION_DRIVER" value="array"/>
        <env name="TELESCOPE_ENABLED" value="false"/>
    </php>
</phpunit>
```

**Stato**: Da completare
**Data target**: 6/04/2024

### 2. Creazione Test Base per Moduli
Creare test base per verificare il corretto funzionamento dei moduli:

```php
// File: laravel/tests/Feature/ModuleTest.php
<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ModuleTest extends TestCase
{
    use RefreshDatabase;
    
    /**
     * Verifica che i moduli siano caricati correttamente.
     */
    public function test_modules_are_loaded()
    {
        $modules = app('modules')->all();
        $this->assertNotEmpty($modules);
        
        // Verifica moduli core
        $this->assertArrayHasKey('Xot', $modules);
        $this->assertArrayHasKey('User', $modules);
        $this->assertArrayHasKey('Media', $modules);
        $this->assertArrayHasKey('Gdpr', $modules);
        
        // Verifica moduli custom
        $this->assertArrayHasKey('Patient', $modules);
        $this->assertArrayHasKey('Dental', $modules);
    }
    
    /**
     * Verifica che i service provider dei moduli siano registrati.
     */
    public function test_module_providers_are_registered()
    {
        $this->assertTrue(app()->providerIsLoaded('Modules\Xot\Providers\XotServiceProvider'));
        $this->assertTrue(app()->providerIsLoaded('Modules\Patient\Providers\PatientServiceProvider'));
        $this->assertTrue(app()->providerIsLoaded('Modules\Dental\Providers\DentalServiceProvider'));
    }
}
```

**Stato**: Da completare
**Data target**: 6/04/2024

## Deployment Iniziale (Da completare)

### 1. Preparazione script di deployment
Creare uno script bash per automatizzare il deployment:

```bash
#!/bin/bash

# File: deploy.sh

echo "Deploying il progetto..."

# Entra nella directory del progetto
cd /path/to/project

# Pull delle ultime modifiche
git pull origin main

# Installa le dipendenze
composer install --no-interaction --prefer-dist --optimize-autoloader --no-dev

# Cancella le cache
php artisan optimize:clear

# Esegui le migrazioni
php artisan migrate --force

# Compila gli asset
npm ci
npm run build

# Riavvia i worker delle code
php artisan queue:restart

echo "Deployment completato con successo!"
```

**Stato**: Da completare
**Data target**: 7/04/2024

### 2. Configurazione server web
Configurare il server web (Apache o Nginx) per servire l'applicazione:

**Apache (.htaccess)**:
```apache
<IfModule mod_rewrite.c>
    <IfModule mod_negotiation.c>
        Options -MultiViews -Indexes
    </IfModule>

    RewriteEngine On

    # Handle Authorization Header
    RewriteCond %{HTTP:Authorization} .
    RewriteRule .* - [E=HTTP_AUTHORIZATION:%{HTTP:Authorization}]

    # Redirect Trailing Slashes If Not A Folder...
    RewriteCond %{REQUEST_FILENAME} !-d
    RewriteCond %{REQUEST_URI} (.+)/$
    RewriteRule ^ %1 [L,R=301]

    # Send Requests To Front Controller...
    RewriteCond %{REQUEST_FILENAME} !-d
    RewriteCond %{REQUEST_FILENAME} !-f
    RewriteRule ^ index.php [L]
</IfModule>
```

**Nginx (nginx.conf)**:
```nginx
server {
    listen 80;
    server_name example.com;
    root /path/to/project/public;

    add_header X-Frame-Options "SAMEORIGIN";
    add_header X-XSS-Protection "1; mode=block";
    add_header X-Content-Type-Options "nosniff";

    index index.php;

    charset utf-8;

    location / {
        try_files $uri $uri/ /index.php?$query_string;
    }

    location = /favicon.ico { access_log off; log_not_found off; }
    location = /robots.txt  { access_log off; log_not_found off; }

    error_page 404 /index.php;

    location ~ \.php$ {
        fastcgi_pass unix:/var/run/php/php8.2-fpm.sock;
        fastcgi_param SCRIPT_FILENAME $realpath_root$fastcgi_script_name;
        include fastcgi_params;
    }

    location ~ /\.(?!well-known).* {
        deny all;
    }
}
```

**Stato**: Da completare
**Data target**: 7/04/2024

## Verifica e Collaudo (Da completare)

### 1. Verifica delle Funzionalità Base
Eseguire una verifica manuale delle funzionalità base:

- [ ] Verifica che l'applicazione si avvii correttamente
- [ ] Verifica che i moduli siano caricati
- [ ] Verifica che le migrazioni funzionino
- [ ] Verifica che i seeder funzionino
- [ ] Verifica che il pannello Filament sia accessibile
- [ ] Verifica che l'autenticazione funzioni

**Stato**: Da completare
**Data target**: 8/04/2024

### 2. Esecuzione dei Test Automatizzati
Eseguire i test automatizzati per verificare il corretto funzionamento del sistema:

```bash
php artisan test
```

**Stato**: Da completare
**Data target**: 8/04/2024

## Documentazione Tecnica (In corso)

### 1. Aggiornamento della Documentazione
Aggiornare la documentazione tecnica con i dettagli dell'implementazione:

- [ ] Documentazione della struttura del progetto
- [ ] Documentazione dei moduli installati
- [ ] Documentazione delle configurazioni
- [ ] Documentazione delle procedure di deployment
- [ ] Documentazione delle procedure di testing

**Stato**: In corso
**Data target**: 9/04/2024

### 2. Creazione di un README completo
Creare un file README.md completo per il progetto:

```markdown

# il progetto

## Descrizione
il progetto è un sistema di gestione per il progetto "Promozione della salute orale per le gestanti in condizioni di vulnerabilità socio-economica".

## Requisiti di Sistema
- PHP 8.2+
- Composer 2.5+
- Node.js 18+ e npm
- MySQL 8.0+
- Git 2.3+

## Installazione
1. Clonare il repository
2. Installare le dipendenze
3. Configurare il file .env
4. Eseguire le migrazioni
5. Compilare gli asset

```

**Stato**: In corso
**Data target**: 9/04/2024

## Prossimi Passi
Una volta completato il setup dell'ambiente e della struttura base, i prossimi passi saranno:

1. Sviluppo dei moduli core (Patient, Dental)
2. Implementazione delle interfacce utente con Filament
3. Implementazione della gestione dei dati
4. Testing e validazione
5. Deployment e manutenzione

Questi passaggi sono dettagliati nei file:
- `02-gestione-dati.md`
- `03-interfaccia-utente.md`
- `04-reporting.md`
- `05-deployment.md` 

## Collegamenti tra versioni di 01-setup-ambiente.md
* [01-setup-ambiente.md](docs/roadmap_frontoffice/01-setup-ambiente.md)
* [01-setup-ambiente.md](docs/roadmap/01-setup-ambiente.md)
* [01-setup-ambiente.md](docs/roadmap_backoffice/01-setup-ambiente.md)

