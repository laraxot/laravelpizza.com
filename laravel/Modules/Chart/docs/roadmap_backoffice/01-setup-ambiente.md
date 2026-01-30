# Task 1: Setup Ambiente di Sviluppo Backoffice

## Descrizione
Configurazione dell'ambiente di sviluppo per il backoffice di il progetto, includendo tutti gli strumenti e le configurazioni necessarie per lo sviluppo con Filament.

## Sottotask

### 1.1 Configurazione Ambiente Laravel
- [ ] Installazione Laravel 11.x
- [ ] Configurazione ambiente di sviluppo
- [ ] Setup .env
- [ ] Configurazione composer.json
- [ ] Installazione dipendenze base

### 1.2 Setup Database PostgreSQL
- [ ] Installazione PostgreSQL
- [ ] Creazione database
- [ ] Configurazione connessione
- [ ] Setup migrazioni base
- [ ] Configurazione seeder

### 1.3 Configurazione Redis
- [ ] Installazione Redis
- [ ] Configurazione connessione
- [ ] Setup cache
- [ ] Configurazione queue
- [ ] Test performance

### 1.4 Setup Ambiente Testing
- [ ] Configurazione PHPUnit
- [ ] Setup database testing
- [ ] Configurazione GitHub Actions
- [ ] Setup code coverage
- [ ] Test automation

## Dettagli Tecnici

### Requisiti di Sistema
- PHP 8.2+
- PostgreSQL 15+
- Redis 7+
- Composer 2.5+
- Node.js 18+
- npm 9+

### Configurazione Laravel e Filament
```bash
composer create-project laravel/laravel <nome progetto>-back
cd <nome progetto>-back
composer require filament/filament:"^3.0"
php artisan filament:install --panels
```

### Configurazione Database
```sql
CREATE DATABASE <nome progetto>_back;
CREATE USER <nome progetto>_back WITH PASSWORD 'password';
GRANT ALL PRIVILEGES ON DATABASE <nome progetto>_back TO <nome progetto>_back;
```

### Configurazione Redis
```bash
sudo apt-get install redis-server
sudo systemctl enable redis-server
sudo systemctl start redis-server
```

### Configurazione Testing
```bash
composer require --dev phpunit/phpunit
composer require --dev nunomaduro/collision
```

## Checklist di Verifica
- [ ] Ambiente Laravel funzionante
- [ ] Filament installato e configurato
- [ ] Database accessibile
- [ ] Redis funzionante
- [ ] Test eseguibili
- [ ] CI/CD configurato

## Note
- Mantenere aggiornato il file .env.example
- Documentare tutte le configurazioni
- Verificare le versioni delle dipendenze
- Testare l'ambiente su diversi sistemi operativi

## Collegamenti
- [Task 2: Architettura Base](../roadmap_backoffice/02-architettura-base.md)
- [Task 3: UI/UX Base](../roadmap_backoffice/03-ui-ux-base.md) 
## Collegamenti tra versioni di 01-setup-ambiente.md
* [01-setup-ambiente.md](docs/roadmap_frontoffice/01-setup-ambiente.md)
* [01-setup-ambiente.md](docs/roadmap/01-setup-ambiente.md)
* [01-setup-ambiente.md](docs/roadmap_backoffice/01-setup-ambiente.md)

