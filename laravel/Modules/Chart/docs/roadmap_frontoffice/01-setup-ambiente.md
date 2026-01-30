# Task 1: Setup Ambiente di Sviluppo

## Descrizione
Configurazione dell'ambiente di sviluppo per il frontoffice di il progetto, includendo tutti gli strumenti e le configurazioni necessarie per lo sviluppo.

## Stato Attuale (Aprile 2024)
✅ Completato al 100%

## Sottotask

### 1.1 Configurazione Ambiente Laravel
- [x] Installazione Laravel 12.x
- [x] Configurazione ambiente di sviluppo
- [x] Setup .env
- [x] Configurazione composer.json
- [x] Installazione dipendenze base

### 1.2 Setup Database
- [x] Configurazione SQLite per sviluppo
- [x] Configurazione MySQL per produzione
- [x] Setup migrazioni
- [x] Configurazione backup
- [x] Test connessioni

### 1.3 Configurazione Redis
- [x] Installazione Redis
- [x] Configurazione connessione
- [x] Setup cache
- [x] Configurazione queue
- [x] Test performance

### 1.4 Setup Ambiente Testing
- [x] Configurazione Pest
- [x] Setup database testing
- [x] Configurazione GitHub Actions
- [x] Setup code coverage
- [x] Test automation

## Dettagli Tecnici

### Requisiti di Sistema
- PHP 8.2+
- SQLite 3.x (sviluppo)
- MySQL 8.x (produzione)
- Redis 7+
- Composer 2.5+
- Node.js 18+
- npm 9+

### Configurazione Laravel
```bash
composer create-project laravel/laravel <nome progetto>-front
cd <nome progetto>-front

# Pacchetti core
composer require nwidart/laravel-modules
composer require laraxot/modules
composer require spatie/laravel-permission
composer require spatie/laravel-activitylog
composer require spatie/laravel-medialibrary
composer require spatie/laravel-backup

# Pacchetti sviluppo
composer require --dev pestphp/pest
composer require --dev pestphp/pest-plugin-laravel
composer require --dev laravel/dusk
```

### Configurazione Database
```env

# Sviluppo (.env)
DB_CONNECTION=sqlite
DB_DATABASE=/absolute/path/to/database.sqlite

# Produzione (.env.production)
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=<nome progetto>_front
DB_USERNAME=<nome progetto>_front
DB_PASSWORD=password
```

### Configurazione Redis
```bash
sudo apt-get install redis-server
sudo systemctl enable redis-server
sudo systemctl start redis-server
```

### Configurazione Testing
```bash

# Configurazione Pest
php artisan pest:install

# Configurazione Dusk
php artisan dusk:install

# Configurazione GitHub Actions
mkdir -p .github/workflows
```

## Checklist di Verifica
- [x] Ambiente Laravel funzionante
- [x] Database SQLite accessibile (sviluppo)
- [x] Database MySQL accessibile (produzione)
- [x] Redis funzionante
- [x] Test eseguibili
- [x] CI/CD configurato

## Note
- Mantenere aggiornato il file .env.example
- Documentare tutte le configurazioni
- Verificare le versioni delle dipendenze
- Testare l'ambiente su diversi sistemi operativi
- Usare SQLite per sviluppo locale
- Usare MySQL per ambiente di produzione
- Seguire le convenzioni di Laraxot per i moduli
- Utilizzare i pacchetti Spatie per funzionalità comuni

## Collegamenti
- [Task 2: Architettura Base](../roadmap_frontoffice/02-architettura-base.md)
- [Task 3: UI/UX Base](../roadmap_frontoffice/03-ui-ux-base.md)
- [Configurazione Database](../tecnico/database-configuration.md)
- [Documentazione Nwidart Modules](https://nwidart.com/laravel-modules/v6/introduction)
- [Documentazione Laraxot](https://github.com/laraxot/modules)
- [Documentazione Spatie](https://spatie.be/open-source) 

## Collegamenti tra versioni di 01-setup-ambiente.md
* [01-setup-ambiente.md](docs/roadmap_frontoffice/01-setup-ambiente.md)
* [01-setup-ambiente.md](docs/roadmap/01-setup-ambiente.md)
* [01-setup-ambiente.md](docs/roadmap_backoffice/01-setup-ambiente.md)

