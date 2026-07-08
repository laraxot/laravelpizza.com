# Setup e Configurazione PTVX

Guida completa per installazione e configurazione del sistema PTVX.

## 📋 Requisiti

### Requisiti Sistema

- **PHP**: 8.2+ (8.3 consigliato)
- **Composer**: 2.6+
- **Node.js**: 18+ (per asset compilation)
- **Database**: MySQL 8.0+ o PostgreSQL 14+
- **Redis**: 6.0+ (opzionale, per caching e queue)
- **Git**: 2.30+

### Estensioni PHP Richieste

```bash
# Verifica estensioni PHP
php -m | grep -E 'pdo|mbstring|xml|ctype|json|bcmath|curl|fileinfo|openssl|tokenizer'
```

Estensioni necessarie:
- `pdo_mysql` o `pdo_pgsql`
- `mbstring`
- `xml`
- `ctype`
- `json`
- `bcmath`
- `curl`
- `fileinfo`
- `openssl`
- `tokenizer`
- `gd` o `imagick` (per manipolazione immagini)
- `redis` (opzionale)

### Requisiti Hardware

**Minimo**:
- CPU: 2 core
- RAM: 4 GB
- Disco: 20 GB SSD

**Consigliato**:
- CPU: 4+ core
- RAM: 8+ GB
- Disco: 50+ GB SSD
- Backup storage separato

---

## 🚀 Installazione

### 1. Clone Repository

```bash
# Clone del repository
git clone https://github.com/laraxot/ptvx.git
cd ptvx

# Oppure con SSH
git clone git@github.com:laraxot/ptvx.git
cd ptvx
```

### 2. Configurazione Laravel

```bash
cd laravel

# Installa dipendenze PHP
composer install

# Copia file environment
cp .env.example .env

# Genera chiave applicazione
php artisan key:generate
```

### 3. Configurazione Database

#### MySQL

```env
# .env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=ptvx
DB_USERNAME=ptvx_user
DB_PASSWORD=secure_password_here
```

#### PostgreSQL

```env
# .env
DB_CONNECTION=pgsql
DB_HOST=127.0.0.1
DB_PORT=5432
DB_DATABASE=ptvx
DB_USERNAME=ptvx_user
DB_PASSWORD=secure_password_here
```

#### Database Multipli

```env
# Database principale
DB_CONNECTION=mysql
DB_DATABASE=ptvx

# Database Performance
PERFORMANCE_DB_CONNECTION=mysql
PERFORMANCE_DB_HOST=127.0.0.1
PERFORMANCE_DB_PORT=3306
PERFORMANCE_DB_DATABASE=ptvx_performance
PERFORMANCE_DB_USERNAME=ptvx_user
PERFORMANCE_DB_PASSWORD=secure_password_here

# Database User (GDPR)
USER_DB_CONNECTION=mysql
USER_DB_HOST=127.0.0.1
USER_DB_PORT=3306
USER_DB_DATABASE=ptvx_user
USER_DB_USERNAME=ptvx_user
USER_DB_PASSWORD=secure_password_here
```

### 4. Creazione Database

```bash
# MySQL
mysql -u root -p
CREATE DATABASE ptvx CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
CREATE DATABASE ptvx_performance CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
CREATE DATABASE ptvx_user CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
CREATE USER 'ptvx_user'@'localhost' IDENTIFIED BY 'secure_password_here';
GRANT ALL PRIVILEGES ON ptvx.* TO 'ptvx_user'@'localhost';
GRANT ALL PRIVILEGES ON ptvx_performance.* TO 'ptvx_user'@'localhost';
GRANT ALL PRIVILEGES ON ptvx_user.* TO 'ptvx_user'@'localhost';
FLUSH PRIVILEGES;
EXIT;

# PostgreSQL
sudo -u postgres psql
CREATE DATABASE ptvx ENCODING 'UTF8';
CREATE DATABASE ptvx_performance ENCODING 'UTF8';
CREATE DATABASE ptvx_user ENCODING 'UTF8';
CREATE USER ptvx_user WITH PASSWORD 'secure_password_here';
GRANT ALL PRIVILEGES ON DATABASE ptvx TO ptvx_user;
GRANT ALL PRIVILEGES ON DATABASE ptvx_performance TO ptvx_user;
GRANT ALL PRIVILEGES ON DATABASE ptvx_user TO ptvx_user;
\q
```

### 5. Migrazioni e Seed

```bash
# Esegui migrazioni
php artisan migrate

# Seed database con dati iniziali (opzionale)
php artisan db:seed

# Seed specifico per modulo
php artisan db:seed --class=Modules\\User\\Database\\Seeders\\UserSeeder
```

### 6. Abilitazione Moduli

```bash
# Abilita moduli core
php artisan module:enable Xot User UI Lang

# Abilita moduli business
php artisan module:enable Performance Gdpr Activity

# Abilita moduli amministrativi
php artisan module:enable IndennitaResponsabilita IndennitaCondizioniLavoro Incentivi

# Lista moduli disponibili
php artisan module:list
```

### 7. Storage e Permessi

```bash
# Crea link storage
php artisan storage:link

# Imposta permessi (Linux/Mac)
chmod -R 775 storage bootstrap/cache
chown -R www-data:www-data storage bootstrap/cache

# Imposta permessi (Development)
chmod -R 777 storage bootstrap/cache
```

### 8. Asset Compilation

```bash
# Installa dipendenze NPM
npm install

# Build assets per development
npm run dev

# Build assets per production
npm run build

# Watch mode per development
npm run dev -- --watch
```

### 9. Configurazione Queue (Opzionale)

```env
# .env
QUEUE_CONNECTION=redis

# Redis configuration
REDIS_HOST=127.0.0.1
REDIS_PASSWORD=null
REDIS_PORT=6379
```

```bash
# Start queue worker
php artisan queue:work

# Start queue worker con supervisor (production)
# Vedi sezione Supervisor più avanti
```

---

## ⚙️ Configurazione Ambiente

### Configurazione Base

```env
# .env

# Application
APP_NAME="PTVX Sistema Integrato"
APP_ENV=production
APP_KEY=base64:your_generated_key_here
APP_DEBUG=false
APP_URL=https://your-domain.com
APP_TIMEZONE=Europe/Rome
APP_LOCALE=it

# Database (vedi sezione Database sopra)

# Cache
CACHE_DRIVER=redis
SESSION_DRIVER=redis
QUEUE_CONNECTION=redis

# Redis
REDIS_CLIENT=phpredis
REDIS_HOST=127.0.0.1
REDIS_PASSWORD=null
REDIS_PORT=6379

# Mail
MAIL_MAILER=smtp
MAIL_HOST=smtp.example.com
MAIL_PORT=587
MAIL_USERNAME=your_username
MAIL_PASSWORD=your_password
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=noreply@your-domain.com
MAIL_FROM_NAME="${APP_NAME}"

# Filesystem
FILESYSTEM_DISK=local

# Broadcasting (opzionale)
BROADCAST_DRIVER=pusher
PUSHER_APP_ID=your_app_id
PUSHER_APP_KEY=your_app_key
PUSHER_APP_SECRET=your_app_secret
PUSHER_APP_CLUSTER=eu

# Logging
LOG_CHANNEL=stack
LOG_LEVEL=info
```

### Configurazione Moduli

#### Filament

```env
# Filament Admin Panel
FILAMENT_PATH=admin
FILAMENT_DOMAIN=null
```

#### Passport (OAuth)

```bash
# Installa Passport
php artisan passport:install

# Salva i client keys nel .env
PASSPORT_CLIENT_ID=your_client_id
PASSPORT_CLIENT_SECRET=your_client_secret
```

#### Multi-Tenancy

```env
# Tenant Configuration
TENANT_CENTRAL_DOMAINS=localhost,127.0.0.1
TENANT_MODEL=Modules\Tenant\Models\Tenant
```

---

## 🔒 Configurazione Sicurezza

### HTTPS e SSL

```env
# Force HTTPS
APP_FORCE_HTTPS=true
SESSION_SECURE_COOKIE=true
```

### CORS

```env
# config/cors.php
SANCTUM_STATEFUL_DOMAINS=your-domain.com,www.your-domain.com
SESSION_DOMAIN=.your-domain.com
```

### Rate Limiting

```php
// app/Http/Kernel.php o config/routing.php
'api' => [
    'throttle:60,1', // 60 requests per minute
    \Illuminate\Routing\Middleware\SubstituteBindings::class,
],
```

### Backup Configuration

```env
# Backup
BACKUP_DRIVER=local
BACKUP_PATH=storage/app/backups
BACKUP_DISK=backups
```

---

## 🚀 Deployment Production

### 1. Ottimizzazione

```bash
# Cache configuration
php artisan config:cache

# Cache routes
php artisan route:cache

# Cache views
php artisan view:cache

# Optimize autoloader
composer install --optimize-autoloader --no-dev

# Cache events and listeners
php artisan event:cache
```

### 2. Supervisor (Queue Workers)

```bash
# Installa supervisor
sudo apt-get install supervisor

# Crea config file
sudo nano /etc/supervisor/conf.d/ptvx-worker.conf
```

```ini
# /etc/supervisor/conf.d/ptvx-worker.conf
[program:ptvx-worker]
process_name=%(program_name)s_%(process_num)02d
command=php /var/www/ptvx/laravel/artisan queue:work redis --sleep=3 --tries=3 --max-time=3600
autostart=true
autorestart=true
stopasgroup=true
killasgroup=true
user=www-data
numprocs=4
redirect_stderr=true
stdout_logfile=/var/www/ptvx/laravel/storage/logs/worker.log
stopwaitsecs=3600
```

```bash
# Ricarica supervisor
sudo supervisorctl reread
sudo supervisorctl update
sudo supervisorctl start ptvx-worker:*

# Check status
sudo supervisorctl status
```

### 3. Cron Jobs

```bash
# Apri crontab
crontab -e

# Aggiungi scheduler Laravel
* * * * * cd /var/www/ptvx/laravel && php artisan schedule:run >> /dev/null 2>&1
```

### 4. Nginx Configuration

```nginx
# /etc/nginx/sites-available/ptvx
server {
    listen 80;
    listen [::]:80;
    server_name your-domain.com;

    # Redirect to HTTPS
    return 301 https://$server_name$request_uri;
}

server {
    listen 443 ssl http2;
    listen [::]:443 ssl http2;
    server_name your-domain.com;

    root /var/www/ptvx/laravel/public;
    index index.php;

    # SSL Configuration
    ssl_certificate /etc/letsencrypt/live/your-domain.com/fullchain.pem;
    ssl_certificate_key /etc/letsencrypt/live/your-domain.com/privkey.pem;
    ssl_protocols TLSv1.2 TLSv1.3;
    ssl_ciphers HIGH:!aNULL:!MD5;

    # Security Headers
    add_header X-Frame-Options "SAMEORIGIN" always;
    add_header X-Content-Type-Options "nosniff" always;
    add_header X-XSS-Protection "1; mode=block" always;
    add_header Referrer-Policy "no-referrer-when-downgrade" always;
    add_header Content-Security-Policy "default-src 'self' http: https: data: blob: 'unsafe-inline'" always;

    # Logging
    access_log /var/log/nginx/ptvx-access.log;
    error_log /var/log/nginx/ptvx-error.log;

    # Max upload size
    client_max_body_size 100M;

    location / {
        try_files $uri $uri/ /index.php?$query_string;
    }

    location ~ \.php$ {
        fastcgi_pass unix:/var/run/php/php8.3-fpm.sock;
        fastcgi_param SCRIPT_FILENAME $realpath_root$fastcgi_script_name;
        include fastcgi_params;
    }

    location ~ /\.(?!well-known).* {
        deny all;
    }
}
```

```bash
# Abilita sito
sudo ln -s /etc/nginx/sites-available/ptvx /etc/nginx/sites-enabled/
sudo nginx -t
sudo systemctl reload nginx
```

### 5. Apache Configuration

```apache
# /etc/apache2/sites-available/ptvx.conf
<VirtualHost *:80>
    ServerName your-domain.com
    Redirect permanent / https://your-domain.com/
</VirtualHost>

<VirtualHost *:443>
    ServerName your-domain.com
    DocumentRoot /var/www/ptvx/laravel/public

    SSLEngine on
    SSLCertificateFile /etc/letsencrypt/live/your-domain.com/fullchain.pem
    SSLCertificateKeyFile /etc/letsencrypt/live/your-domain.com/privkey.pem

    <Directory /var/www/ptvx/laravel/public>
        Options -Indexes +FollowSymLinks
        AllowOverride All
        Require all granted
    </Directory>

    ErrorLog ${APACHE_LOG_DIR}/ptvx-error.log
    CustomLog ${APACHE_LOG_DIR}/ptvx-access.log combined
</VirtualHost>
```

```bash
# Abilita moduli
sudo a2enmod rewrite ssl
sudo a2ensite ptvx
sudo systemctl reload apache2
```

---

## 🧪 Verifica Installazione

### Health Check

```bash
# Verifica connessione database
php artisan db:show

# Verifica moduli attivi
php artisan module:list

# Verifica configurazione
php artisan about

# Test cache
php artisan cache:clear
php artisan config:cache
```

### Test Accesso

1. **Frontend**: `https://your-domain.com`
2. **Admin Panel**: `https://your-domain.com/admin`
3. **API**: `https://your-domain.com/api/health`

### Credenziali Default

```bash
# Crea admin user
php artisan user:create-admin

# Output:
# Email: admin@example.com
# Password: [generated-password]
```

---

## 🔧 Troubleshooting

### Errore: "Class not found"

```bash
# Rigenera autoload
composer dump-autoload
php artisan optimize:clear
```

### Errore: "Permission denied"

```bash
# Fix permessi storage
chmod -R 775 storage bootstrap/cache
chown -R www-data:www-data storage bootstrap/cache
```

### Errore Database Connection

```bash
# Verifica connessione
php artisan db:show

# Test manuale
mysql -u ptvx_user -p ptvx
```

### Queue non funziona

```bash
# Restart queue worker
php artisan queue:restart

# Clear failed jobs
php artisan queue:flush

# Restart supervisor
sudo supervisorctl restart ptvx-worker:*
```

---

## 📚 Prossimi Passi

Dopo l'installazione:

1. [Configurazione Moduli](modules.md)
2. [Sviluppo](development.md)
3. [Qualità Codice](code-quality.md)
4. [Regole Laraxot](laraxot-rules.md)

---

## 🆘 Supporto

- **Documentazione**: [docs/README.md](README.md)
- **GitHub Issues**: https://github.com/laraxot/ptvx/issues
- **Email**: support@ptvx.example.com
