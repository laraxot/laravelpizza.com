# Installazione

## Requisiti di Sistema

### 1. Software Richiesto
- PHP 8.2 o superiore
- Composer 2.0 o superiore
- Node.js 18 o superiore
- NPM 9 o superiore
- MySQL 8.0 o superiore

### 2. Estensioni PHP
- BCMath
- Ctype
- cURL
- DOM
- Fileinfo
- JSON
- Mbstring
- OpenSSL
- PDO
- Tokenizer
- XML

## Installazione

### 1. Clonare il Repository
```bash
git clone https://github.com/your-organization/<nome progetto>.git
cd <nome progetto>
```

### 2. Installare le Dipendenze
```bash

# Installare le dipendenze PHP
composer install

# Installare le dipendenze NPM
npm install
```

### 3. Configurazione
```bash

# Copiare il file di ambiente
cp .env.example .env

# Generare la chiave dell'applicazione
php artisan key:generate

# Configurare il database nel file .env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=<nome progetto>
DB_USERNAME=root
DB_PASSWORD=password
```

### 4. Migrazione del Database
```bash

# Eseguire le migrazioni
php artisan migrate

# Popolare il database con i dati di esempio
php artisan db:seed
```

### 5. Compilazione degli Assets
```bash

# Compilare gli assets
npm run build
```

## Configurazione dei Moduli

### 1. Attivare i Moduli
```bash

# Attivare il modulo Xot
php artisan module:enable Xot

# Attivare altri moduli necessari
php artisan module:enable Cms
```

### 2. Configurare i Temi
```bash

# Pubblicare gli assets del tema
php artisan vendor:publish --tag=theme-one-assets

# Compilare gli assets del tema
npm run theme:build
```

## Verifica dell'Installazione

### 1. Avviare il Server di Sviluppo
```bash
php artisan serve
```

### 2. Verificare l'Accesso
- Aprire http://localhost:8000 nel browser
- Verificare che l'applicazione carichi correttamente
- Controllare che tutti i moduli siano attivi

## Troubleshooting

### 1. Problemi Comuni
- **Errori di Permessi**: Verificare i permessi delle directory
- **Errori di Database**: Controllare le credenziali nel .env
- **Errori di Compilazione**: Verificare le versioni di Node.js e NPM

### 2. Log
- Controllare `storage/logs/laravel.log` per errori
- Verificare i log del server web
- Controllare i log del database

## Collegamenti

- [Configurazione](configuration.md)
- [Troubleshooting](troubleshooting.md)
- [Regole di Documentazione](documentation-rules.md)

## Collegamenti tra versioni di installation.md
* [installation.md](../../../Xot/docs/filament/installation.md)
* [installation.md](../../../Xot/docs/installation.md)
* [installation.md](../../../Xot/docs/base/installation.md)
* [installation.md](../../../User/docs/installation.md)
* [installation.md](../../../Lang/docs/installation.md)
* [installation.md](../../../Cms/docs/installation.md)
* [installation.md](../../../../Themes/One/docs/installation.md)

