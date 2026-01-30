# Composer

## Installazione

### Requisiti
- PHP 8.2 o superiore
- PHP CLI
- PHP ZIP extension
- PHP OpenSSL extension

### Installazione Globale
1. Scaricare l'installer:
   ```bash
   php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');"
   ```

2. Verificare l'installer:
   ```bash
   php -r "if (hash_file('sha384', 'composer-setup.php') === 'dac665fdc30fdd8ec78b38b9800061b4150413ff2e3b6f88543c636f7cd84f6db9189d43a81e5503cda447da73c7e5b6') { echo 'Installer verified'.PHP_EOL; } else { echo 'Installer corrupt'.PHP_EOL; unlink('composer-setup.php'); exit(1); }"
   ```

3. Eseguire l'installer:
   ```bash
   php composer-setup.php
   ```

4. Rimuovere l'installer:
   ```bash
   php -r "unlink('composer-setup.php');"
   ```

5. Spostare composer in una directory del PATH:
   ```bash
   sudo mv composer.phar /usr/local/bin/composer
   ```

### Verifica Installazione
```bash
composer --version
```

## Configurazione

### Configurazione Globale
1. Directory di configurazione:
   ```bash
   mkdir -p ~/.composer
   ```

2. File di configurazione:
   ```bash
   composer config -g github-protocols https
   composer config -g process-timeout 2000
   ```

### Configurazione Progetto
1. File composer.json:
   ```json
   {
       "name": "<nome progetto>/app",
       "type": "project",
       "description": "Sistema di Gestione Salute Orale",
       "keywords": ["laravel", "framework"],
       "license": "MIT",
       "require": {
           "php": "^8.2",
           "laravel/framework": "^10.0",
           "nwidart/laravel-modules": "^10.0"
       },
       "autoload": {
           "psr-4": {
               "App\\": "app/",
               "Database\\Factories\\": "database/factories/",
               "Database\\Seeders\\": "database/seeders/"
           }
       },
       "autoload-dev": {
           "psr-4": {
               "Tests\\": "tests/"
           }
       },
       "scripts": {
           "post-autoload-dump": [
               "Illuminate\\Foundation\\ComposerScripts::postAutoloadDump",
               "@php artisan package:discover --ansi"
           ],
           "post-update-cmd": [
               "@php artisan vendor:publish --tag=laravel-assets --ansi --force"
           ],
           "post-root-package-install": [
               "@php -r \"file_exists('.env') || file_put_contents('.env', file_get_contents('.env.example'));\""
           ],
           "post-create-project-cmd": [
               "@php artisan key:generate --ansi"
           ]
       },
       "extra": {
           "laravel": {
               "dont-discover": []
           }
       },
       "config": {
           "optimize-autoloader": true,
           "preferred-install": "dist",
           "sort-packages": true,
           "allow-plugins": {
               "pestphp/pest-plugin": true,
               "php-http/discovery": true
           }
       },
       "minimum-stability": "stable",
       "prefer-stable": true
   }
   ```

## Comandi Utili

### Gestione Dipendenze
```bash

# Installare dipendenze
composer install

# Aggiornare dipendenze
composer update

# Rimuovere dipendenze
composer remove package/name

# Aggiungere dipendenze
composer require package/name
```

### Gestione Autoload
```bash

# Rigenerare autoload
composer dump-autoload

# Ottimizzare autoload
composer dump-autoload -o
```

### Diagnostica
```bash

# Verificare dipendenze
composer diagnose

# Verificare sicurezza
composer audit

# Verificare licenze
composer licenses
```

## Note
- Mantenere sempre aggiornato composer
- Verificare la compatibilità delle dipendenze
- Utilizzare versioni specifiche per stabilità
