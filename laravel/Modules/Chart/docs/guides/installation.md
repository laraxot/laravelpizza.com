# 💾 Guida Installazione - Setup DRY + KISS

## 🎯 Prerequisiti

### Sistema Operativo
- **Linux**: Ubuntu 20.04+ / CentOS 8+ (raccomandato)
- **macOS**: 10.15+ con Homebrew
- **Windows**: WSL2 con Ubuntu

### Software Richiesto
- **PHP**: 8.2+ con estensioni: mbstring, xml, pdo, mysql, gd, curl
- **Composer**: 2.5+
- **Node.js**: 18+ con npm/yarn
- **MySQL**: 8.0+ o MariaDB 10.6+
- **Redis**: 6.0+ (per cache e sessioni)
- **Git**: 2.30+

## 🚀 Installazione Rapida

### Step 1: Clone Repository
```bash
cd /var/www/html
git clone https://github.com/laraxot/<nome progetto>.git
cd <nome progetto>
```

### Step 2: Setup Laravel
```bash
cd laravel
composer install --optimize-autoloader
cp .env.example .env
php artisan key:generate
```

### Step 3: Configurazione Database
```bash

# Modifica .env con le tue credenziali
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=<nome progetto>
DB_USERNAME=your_username
DB_PASSWORD=your_password
```

### Step 4: Migrazioni e Seeding
```bash
php artisan migrate
php artisan db:seed
```

### Step 5: Assets Frontend
```bash
npm install
npm run build
```

### Step 6: Permessi e Storage
```bash
chmod -R 775 storage bootstrap/cache
php artisan storage:link
```

## ⚙️ Configurazione Avanzata

### Environment Variables
```env

# App Configuration
APP_NAME="<nome progetto>"
APP_ENV=local
APP_DEBUG=true
APP_URL=http://localhost

# Database
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=<nome progetto>
DB_USERNAME=root
DB_PASSWORD=

# Cache & Sessions
CACHE_DRIVER=redis
SESSION_DRIVER=redis
QUEUE_CONNECTION=redis

# Redis
REDIS_HOST=127.0.0.1
REDIS_PASSWORD=null
REDIS_PORT=6379

# Mail
MAIL_MAILER=smtp
MAIL_HOST=mailhog
MAIL_PORT=1025
MAIL_USERNAME=null
MAIL_PASSWORD=null
MAIL_ENCRYPTION=null

# Filament
FILAMENT_DOMAIN=admin.<nome progetto>.local
```

### Configurazione Moduli
```bash

# Pubblica configurazioni moduli
php artisan vendor:publish --provider="Nwidart\Modules\LaravelModulesServiceProvider"

# Abilita moduli
php artisan module:enable Xot
php artisan module:enable User
php artisan module:enable UI
php artisan module:enable <nome progetto>
```

## 🐳 Installazione Docker

### Docker Compose Setup
```yaml
version: '3.8'
services:
  app:
    build: .
    ports:
      - "8000:8000"
    volumes:
      - .:/var/www/html
    environment:
      - DB_HOST=mysql
      - REDIS_HOST=redis
    depends_on:
      - mysql
      - redis

  mysql:
    image: mysql:8.0
    environment:
      MYSQL_ROOT_PASSWORD: secret
      MYSQL_DATABASE: <nome progetto>
    ports:
      - "3306:3306"

  redis:
    image: redis:7-alpine
    ports:
      - "6379:6379"
```

### Comandi Docker
```bash

# Build e avvio
docker-compose up -d

# Installazione dipendenze
docker-compose exec app composer install
docker-compose exec app npm install

# Migrazioni
docker-compose exec app php artisan migrate
```

## 🔧 Configurazione Web Server

### Apache Virtual Host
```apache
<VirtualHost *:80>
    ServerName <nome progetto>.local
    DocumentRoot /var/www/html/<nome progetto>/laravel/public
    
    <Directory /var/www/html/<nome progetto>/laravel/public>
        AllowOverride All
        Require all granted
    </Directory>
    
    ErrorLog ${APACHE_LOG_DIR}/<nome progetto>_error.log
    CustomLog ${APACHE_LOG_DIR}/<nome progetto>_access.log combined
</VirtualHost>
```

### Nginx Configuration
```nginx
server {
    listen 80;
    server_name <nome progetto>.local;
    root /var/www/html/<nome progetto>/laravel/public;
    
    index index.php index.html;
    
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

## ✅ Verifica Installazione

### Health Check
```bash

# Verifica sistema
php artisan about

# Test database
php artisan migrate:status

# Test cache
php artisan cache:clear
php artisan config:cache

# Test queue
php artisan queue:work --once

# Test moduli
php artisan module:list
```

### Accesso Applicazione
- **Frontend**: http://<nome progetto>.local
- **Admin Panel**: http://<nome progetto>.local/admin
- **API**: http://<nome progetto>.local/api

### Credenziali Default
```
Admin User:
Email: admin@<nome progetto>.local
Password: password

Test Doctor:
Email: doctor@<nome progetto>.local
Password: password

Test Patient:
Email: patient@<nome progetto>.local
Password: password
```

## 🚨 Troubleshooting

### Problemi Comuni

#### Errore: "Class not found"
```bash
composer dump-autoload
php artisan clear-compiled
php artisan config:clear
```

#### Errore: "Permission denied"
```bash
sudo chown -R www-data:www-data storage bootstrap/cache
chmod -R 775 storage bootstrap/cache
```

#### Errore: "Connection refused"
```bash

# Verifica servizi
sudo systemctl status mysql
sudo systemctl status redis
sudo systemctl status php8.2-fpm
```

### Log Files
- **Laravel**: `storage/logs/laravel.log`
- **Web Server**: `/var/log/apache2/` o `/var/log/nginx/`
- **PHP**: `/var/log/php8.2-fpm.log`

## 🔗 Prossimi Passi

1. [⚙️ Configurazione](configuration.md) - Configurazione dettagliata
2. [🚀 Deployment](deployment.md) - Deploy in produzione
3. [📏 Coding Standards](../development/coding-standards.md) - Standard di sviluppo
4. [🧪 Testing](../development/testing.md) - Setup testing

---

*Guida consolidata secondo principi DRY + KISS*  
*Ultimo aggiornamento: 2025-08-04*
