# Guida all'Installazione Base PTVX

## Prerequisiti

### Software Richiesto
- PHP >= 8.1
- Composer 2.x
- MySQL/MariaDB >= 8.0
- Node.js >= 16.x
- Git

### Estensioni PHP Richieste
- BCMath PHP Extension
- Ctype PHP Extension
- JSON PHP Extension
- Mbstring PHP Extension
- OpenSSL PHP Extension
- PDO PHP Extension
- Tokenizer PHP Extension
- XML PHP Extension
- Fileinfo PHP Extension
- GD PHP Extension

## Processo di Installazione

### 1. Preparazione dell'Ambiente
```bash
# Verifica versione PHP
php -v

# Verifica versione Composer
composer -V

# Verifica versione Node
node -v
```

### 2. Clonazione del Repository
```bash
# Clona il repository principale
git clone https://github.com/laraxot/base_ptvx.git

# Entra nella directory del progetto
cd base_ptvx
```

### 3. Configurazione dell'Ambiente
```bash
# Copia il file di ambiente
cp .env.example .env

# Genera la chiave dell'applicazione
php artisan key:generate
```

### 4. Configurazione del Database
Modifica il file `.env` con i parametri del tuo database:
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=base_ptvx
DB_USERNAME=your_username
DB_PASSWORD=your_password
```

### 5. Installazione Dipendenze
```bash
# Installa dipendenze PHP
composer install

# Installa dipendenze Node.js
npm install

# Compila assets
npm run dev
```

### 6. Configurazione del Progetto
```bash
# Esegui le migrazioni del database
php artisan migrate

# Pulisci la cache
php artisan optimize:clear

# Genera i link simbolici per lo storage
php artisan storage:link
```

### 7. Configurazione dei Moduli
```bash
# Pubblica i file di configurazione dei moduli
php artisan module:publish-config

# Esegui le migrazioni dei moduli
php artisan module:migrate
```

## Configurazione Server di Sviluppo

### Utilizzo del Server Integrato di Laravel
```bash
php artisan serve
```
Il sito sarà accessibile all'indirizzo: `http://localhost:8000`

### Configurazione Apache (Alternativa)
Aggiungi al tuo virtual host:
```apache
<VirtualHost *:80>
    ServerName base_ptvx.local
    DocumentRoot "/path/to/base_ptvx/public"
    
    <Directory "/path/to/base_ptvx/public">
        AllowOverride All
        Require all granted
    </Directory>
</VirtualHost>
```

### Configurazione Nginx (Alternativa)
```nginx
server {
    listen 80;
    server_name base_ptvx.local;
    root /path/to/base_ptvx/public;

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
        fastcgi_pass unix:/var/run/php/php8.1-fpm.sock;
        fastcgi_param SCRIPT_FILENAME $realpath_root$fastcgi_script_name;
        include fastcgi_params;
    }

    location ~ /\.(?!well-known).* {
        deny all;
    }
}
```

## Verifica dell'Installazione

### Test del Sistema
```bash
# Verifica lo stato del sistema
php artisan about

# Esegui i test
php artisan test
```

### Controlli Post-Installazione
1. Verifica che il sito sia accessibile
2. Controlla il funzionamento del login
3. Verifica l'accesso al pannello admin
4. Controlla i log in `storage/logs` per eventuali errori

## Troubleshooting

### Problemi Comuni

#### Permessi dei File
```bash
# Imposta i permessi corretti
chmod -R 775 storage bootstrap/cache
chown -R www-data:www-data storage bootstrap/cache
```

#### Errori di Composer
```bash
# Pulisci la cache di Composer
composer clear-cache

# Aggiorna le dipendenze
composer update
```

#### Errori di Cache
```bash
# Pulisci tutte le cache
php artisan optimize:clear
php artisan config:clear
php artisan cache:clear
```

## Aggiornamenti

### Aggiornamento del Sistema
```bash
# Aggiorna il codice
git pull origin main

# Aggiorna le dipendenze
composer update
npm update

# Aggiorna il database
php artisan migrate

# Ricompila gli assets
npm run build
```

## Supporto

Per problemi o domande:
1. Consulta la documentazione in `/docs`
2. Verifica i file di log in `storage/logs`
3. Apri una issue su GitHub
