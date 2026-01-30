# Testing e Deployment del Progetto il progetto

Questo documento fornisce le linee guida per il testing completo e il deployment in produzione del progetto il progetto.

## Fase 1: Preparazione dell'Ambiente di Testing

### 1.1 Setup dell'Ambiente di Testing

```bash

# Creazione di un database specifico per i test
mysql -u root -p -e "CREATE DATABASE <nome progetto>_test CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;"
mysql -u root -p -e "GRANT ALL PRIVILEGES ON <nome progetto>_test.* TO '<nome progetto>'@'localhost';"

# Configurazione del file .env.testing
cp .env .env.testing
```

Modificare il file `.env.testing`:

```
APP_ENV=testing
DB_DATABASE=<nome progetto>_test
CACHE_DRIVER=array
SESSION_DRIVER=array
QUEUE_CONNECTION=sync
```

### 1.2 Installazione degli Strumenti di Testing

```bash

# Installazione di PHPUnit e altri strumenti di testing
composer require --dev phpunit/phpunit laravel/dusk laravel/browser-kit-testing spatie/phpunit-snapshot-assertions
```

## Fase 2: Testing Automatizzato

### 2.1 Test Unitari

Creare test unitari per i modelli, servizi e altre componenti principali:

```bash

# Generazione dei test unitari per i modelli principali
php artisan make:test Models/PatientTest --unit
php artisan make:test Models/DentistTest --unit
php artisan make:test Models/AppointmentTest --unit
php artisan make:test Models/ReimbursementTest --unit
```

Esempio di implementazione di un test unitario per il modello Patient:

```php
// tests/Unit/Models/PatientTest.php
namespace Tests\Unit\Models;

use App\Models\Patient;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PatientTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_create_patient()
    {
        $user = User::factory()->create();
        
        $patient = Patient::create([
            'user_id' => $user->id,
            'name' => 'Maria',
            'surname' => 'Rossi',
            'birth_date' => '1990-01-01',
            'status' => 'pending',
        ]);
        
        $this->assertDatabaseHas('patients', [
            'name' => 'Maria',
            'surname' => 'Rossi',
        ]);
    }
    
    public function test_patient_has_appointments_relation()
    {
        $patient = Patient::factory()
            ->hasAppointments(3)
            ->create();
        
        $this->assertCount(3, $patient->appointments);
    }
    
    public function test_patient_can_be_approved()
    {
        $patient = Patient::factory()->create(['status' => 'pending']);
        
        $patient->approve();
        
        $this->assertEquals('approved', $patient->status);
    }
}
```

### 2.2 Test di Integrazione

Creare test di integrazione per verificare l'interazione tra i diversi componenti:

```bash
php artisan make:test AppointmentCreationTest
php artisan make:test PatientRegistrationTest
php artisan make:test ReimbursementTest
```

Esempio di test di integrazione per la creazione di un appuntamento:

```php
// tests/Feature/AppointmentCreationTest.php
namespace Tests\Feature;

use App\Models\Dentist;
use App\Models\Patient;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AppointmentCreationTest extends TestCase
{
    use RefreshDatabase;
    
    public function test_patient_can_request_appointment()
    {
        $patient = Patient::factory()->create(['status' => 'approved']);
        $dentist = Dentist::factory()->create(['status' => 'approved']);
        
        $this->actingAs($patient->user)
            ->post(route('patient.appointments.store'), [
                'dentist_id' => $dentist->id,
                'date' => now()->addDays(5)->format('Y-m-d'),
                'time' => '10:00',
                'notes' => 'Visita di controllo',
            ])
            ->assertRedirect()
            ->assertSessionHas('success');
        
        $this->assertDatabaseHas('appointments', [
            'patient_id' => $patient->id,
            'dentist_id' => $dentist->id,
            'status' => 'pending',
        ]);
    }
    
    public function test_dentist_can_confirm_appointment()
    {
        $patient = Patient::factory()->create(['status' => 'approved']);
        $dentist = Dentist::factory()->create(['status' => 'approved']);
        
        $appointment = $patient->appointments()->create([
            'dentist_id' => $dentist->id,
            'date' => now()->addDays(5)->format('Y-m-d'),
            'time' => '10:00',
            'status' => 'pending',
        ]);
        
        $this->actingAs($dentist->user)
            ->patch(route('dentist.appointments.update', $appointment), [
                'status' => 'confirmed',
            ])
            ->assertRedirect()
            ->assertSessionHas('success');
        
        $this->assertDatabaseHas('appointments', [
            'id' => $appointment->id,
            'status' => 'confirmed',
        ]);
    }
}
```

### 2.3 Test dell'Interfaccia Utente con Laravel Dusk

Configurazione iniziale di Laravel Dusk:

```bash
php artisan dusk:install
```

Creazione di test per l'interfaccia utente:

```bash
php artisan dusk:make PatientRegistrationTest
php artisan dusk:make DentistDashboardTest
php artisan dusk:make AdminPanelTest
```

Esempio di test Dusk per la registrazione di un paziente:

```php
// tests/Browser/PatientRegistrationTest.php
namespace Tests\Browser;

use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class PatientRegistrationTest extends DuskTestCase
{
    public function test_patient_can_register()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/')
                ->clickLink('Partecipa al Progetto')
                ->assertSee('Registrazione Paziente')
                ->type('name', 'Maria')
                ->type('surname', 'Rossi')
                ->type('email', 'maria.rossi@example.com')
                ->type('password', 'password')
                ->type('password_confirmation', 'password')
                ->attach('isee_document', storage_path('testing/isee_sample.pdf'))
                ->attach('pregnancy_document', storage_path('testing/pregnancy_sample.pdf'))
                ->check('privacy_policy')
                ->press('Registrati')
                ->assertPathIs('/patient/dashboard')
                ->assertSee('Grazie per la tua registrazione');
        });
    }
}
```

### 2.4 Test di Privacy e GDPR

Creare test specifici per verificare la conformità GDPR:

```bash
php artisan make:test GdprComplianceTest
```

Esempio di test per la conformità GDPR:

```php
// tests/Feature/GdprComplianceTest.php
namespace Tests\Feature;

use App\Models\Patient;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class GdprComplianceTest extends TestCase
{
    use RefreshDatabase;
    
    public function test_user_can_download_personal_data()
    {
        $user = User::factory()->create();
        $patient = Patient::factory()->create(['user_id' => $user->id]);
        
        $this->actingAs($user)
            ->get(route('gdpr.export'))
            ->assertOk()
            ->assertHeader('Content-Type', 'application/json');
    }
    
    public function test_user_can_request_data_deletion()
    {
        $user = User::factory()->create();
        
        $this->actingAs($user)
            ->post(route('gdpr.delete-request'))
            ->assertRedirect()
            ->assertSessionHas('success');
        
        $this->assertDatabaseHas('data_deletion_requests', [
            'user_id' => $user->id,
            'status' => 'pending',
        ]);
    }
}
```

### 2.5 Test di Sicurezza

Eseguire test di sicurezza per verificare la protezione contro vulnerabilità comuni:

```bash

# Installazione di strumenti per il test di sicurezza
composer require --dev enlightn/enlightn

# Esecuzione dell'analisi di sicurezza
php artisan enlightn
```

## Fase 3: Preparazione al Deployment

### 3.1 Ottimizzazione della Performance

```bash

# Ottimizzazione dell'autoloader
composer install --optimize-autoloader --no-dev

# Compilazione degli asset
npm run build

# Generazione del cache per configurazione, routes e views
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

### 3.2 Creazione dello Script di Deployment

Creare un file `deploy.sh` nella root del progetto:

```bash
#!/bin/bash

# Script di deployment per il progetto

# Variabili di configurazione
DEPLOY_DIR="/var/www/<nome progetto>"
REPO_URL="git@github.com:organizzazione/<nome progetto>.git"
BRANCH="main"
BACKUP_DIR="/var/backups/<nome progetto>"

# Creazione backup
echo "Creazione backup..."
TIMESTAMP=$(date +%Y%m%d%H%M%S)
mkdir -p $BACKUP_DIR
mysqldump -u <nome progetto> -p <nome progetto> > $BACKUP_DIR/<nome progetto>_$TIMESTAMP.sql
cp -r $DEPLOY_DIR/storage $BACKUP_DIR/storage_$TIMESTAMP

# Aggiornamento del codice
echo "Aggiornamento codice..."
cd $DEPLOY_DIR
git fetch origin
git reset --hard origin/$BRANCH

# Installazione dipendenze
echo "Installazione dipendenze..."
composer install --optimize-autoloader --no-dev
npm ci
npm run build

# Migrazioni database
echo "Esecuzione migrazioni..."
php artisan migrate --force

# Pulizia cache
echo "Rigenerazione cache..."
php artisan optimize:clear
php artisan config:cache
php artisan route:cache
php artisan view:cache
php artisan filament:cache-resources

# Aggiornamento permessi
echo "Aggiornamento permessi..."
chown -R www-data:www-data $DEPLOY_DIR
chmod -R 755 $DEPLOY_DIR/storage $DEPLOY_DIR/bootstrap/cache

echo "Deployment completato con successo!"
```

Rendere lo script eseguibile:

```bash
chmod +x deploy.sh
```

## Fase 4: Deployment in Produzione

### 4.1 Preparazione del Server di Produzione

Requisiti server:

- Ubuntu 22.04 LTS o successivo
- Nginx 1.18+ o Apache 2.4+
- PHP 8.2+
- MySQL 8.0+
- Redis 7.0+ (opzionale, per cache e code)
- Supervisord (per la gestione dei processi in background)

Configurazione del server web (Nginx):

```nginx
server {
    listen 80;
    server_name <nome progetto>.org www.<nome progetto>.org;
    return 301 https://$host$request_uri;
}

server {
    listen 443 ssl http2;
    server_name <nome progetto>.org www.<nome progetto>.org;
    
    ssl_certificate /etc/letsencrypt/live/<nome progetto>.org/fullchain.pem;
    ssl_certificate_key /etc/letsencrypt/live/<nome progetto>.org/privkey.pem;
    
    root /var/www/<nome progetto>/public;
    
    add_header X-Frame-Options "SAMEORIGIN";
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

### 4.2 Configurazione del CI/CD con GitHub Actions

Creare un file `.github/workflows/deploy.yml`:

```yaml
name: Deploy il progetto

on:
  push:
    branches: [ main ]

jobs:
  deploy:
    runs-on: ubuntu-latest
    steps:
      - uses: actions/checkout@v3
      
      - name: Setup PHP
        uses: shivammathur/setup-php@v2
        with:
          php-version: '8.2'
          extensions: mbstring, pdo_mysql, zip, exif, pcntl, bcmath, gd
          
      - name: Install Composer Dependencies
        run: composer install --no-dev --optimize-autoloader
        
      - name: Setup Node.js
        uses: actions/setup-node@v3
        with:
          node-version: '18'
          
      - name: Install NPM Dependencies and Build Assets
        run: |
          npm ci
          npm run build
          
      - name: Run Tests
        run: vendor/bin/phpunit
        
      - name: Deploy to Production Server
        uses: appleboy/ssh-action@master
        with:
          host: ${{ secrets.SERVER_HOST }}
          username: ${{ secrets.SERVER_USERNAME }}
          key: ${{ secrets.SERVER_SSH_KEY }}
          script: |
            cd /var/www/<nome progetto>
            git pull origin main
            composer install --no-dev --optimize-autoloader
            npm ci
            npm run build
            php artisan migrate --force
            php artisan optimize:clear
            php artisan config:cache
            php artisan route:cache
            php artisan view:cache
            php artisan filament:cache-resources
            chown -R www-data:www-data /var/www/<nome progetto>
            chmod -R 755 /var/www/<nome progetto>/storage /var/www/<nome progetto>/bootstrap/cache
```

### 4.3 Configurazione di Supervisord per i Worker di Coda

Creare un file di configurazione per Supervisord:

```ini

# /etc/supervisor/conf.d/<nome progetto>-worker.conf
[program:<nome progetto>-worker]
process_name=%(program_name)s_%(process_num)02d
command=php /var/www/<nome progetto>/artisan queue:work redis --sleep=3 --tries=3 --max-time=3600
autostart=true
autorestart=true
stopasgroup=true
killasgroup=true
user=www-data
numprocs=4
redirect_stderr=true
stdout_logfile=/var/www/<nome progetto>/storage/logs/worker.log
stopwaitsecs=3600
```

Attivare la configurazione:

```bash
supervisorctl reread
supervisorctl update
supervisorctl start all
```

### 4.4 Configurazione Backup Automatici

Creare uno script di backup automatico:

```bash
#!/bin/bash

# /usr/local/bin/<nome progetto>-backup.sh

TIMESTAMP=$(date +%Y%m%d%H%M%S)
BACKUP_DIR="/var/backups/<nome progetto>"

# Backup del database
mysqldump -u <nome progetto> -p'password' <nome progetto> | gzip > $BACKUP_DIR/database_$TIMESTAMP.sql.gz

# Backup dei file
tar -czf $BACKUP_DIR/files_$TIMESTAMP.tar.gz /var/www/<nome progetto>/storage/app

# Eliminazione backup più vecchi di 30 giorni
find $BACKUP_DIR -name "database_*.sql.gz" -mtime +30 -delete
find $BACKUP_DIR -name "files_*.tar.gz" -mtime +30 -delete
```

Aggiungere al crontab:

```
0 2 * * * /usr/local/bin/<nome progetto>-backup.sh > /dev/null 2>&1
```

## Fase 5: Monitoraggio e Manutenzione

### 5.1 Setup del Monitoraggio

Configurazione di Sentry per il monitoraggio degli errori:

```bash
composer require sentry/sentry-laravel
php artisan vendor:publish --provider="Sentry\Laravel\ServiceProvider"
```

Aggiungere la configurazione Sentry in `.env`:

```
SENTRY_LARAVEL_DSN=https://your-sentry-dsn@sentry.io/project-id
```

### 5.2 Monitoraggio delle Performance

Installazione di Laravel Telescope per monitoraggio interno:

```bash
composer require laravel/telescope --dev
php artisan telescope:install
php artisan migrate
```

Configurare Telescope solo per ambienti non di produzione in `app/Providers/AppServiceProvider.php`:

```php
public function register()
{
    if ($this->app->environment('local', 'staging')) {
        $this->app->register(\Laravel\Telescope\TelescopeServiceProvider::class);
        $this->app->register(TelescopeServiceProvider::class);
    }
}
```

### 5.3 Procedure di Rollback

Creare uno script di rollback per situazioni di emergenza:

```bash
#!/bin/bash

# /usr/local/bin/<nome progetto>-rollback.sh

# Rollback all'ultima versione stabile
cd /var/www/<nome progetto>
git checkout stable-tag
composer install --optimize-autoloader --no-dev
npm ci
npm run build
php artisan migrate:rollback --step=1
php artisan optimize:clear
php artisan config:cache
php artisan route:cache
php artisan view:cache

# Riavviare i servizi
supervisorctl restart all
```

### 5.4 Procedure di Aggiornamento Regolare

Pianificare aggiornamenti regolari delle dipendenze e delle patch di sicurezza:

```bash
#!/bin/bash

# /usr/local/bin/<nome progetto>-update-deps.sh

cd /var/www/<nome progetto>
composer update --no-dev
npm update
git add composer.lock package-lock.json
git commit -m "Update dependencies"
git push
```

## Conclusione

Seguendo queste linee guida per il testing e il deployment, il progetto il progetto potrà essere gestito in modo sicuro e affidabile. Le procedure di test garantiranno la qualità del codice e la conformità ai requisiti, mentre il processo di deployment automatizzato ridurrà il rischio di errori umani e semplificherà l'aggiornamento dell'applicazione.

