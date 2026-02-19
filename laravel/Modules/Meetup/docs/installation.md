# 📦 Guida Installazione - Modulo Meetup

## Prerequisiti

### Requisiti di Sistema
- PHP >= 8.2
- Composer >= 2.5
- Node.js >= 18.x
- npm >= 9.x
- SQLite >= 3.35 (o PostgreSQL/MySQL)
- Git

### Dipendenze Laravel
- Laravel 11.x
- Filament 4.x
- nwidart/laravel-modules

### Moduli Richiesti
I seguenti moduli devono essere installati e attivati:
- **Xot** (base framework)
- **Cms** (Laravel Folio + Livewire Volt)
- **UI** (componenti UI)
- **Media** (gestione immagini)
- **User** (autenticazione)
- **Tenant** (multi-tenancy, opzionale)

## Installazione Step-by-Step

### 1. Clone del Repository

Se il modulo non è già presente:

```bash
cd Modules/
git clone [URL_REPOSITORY] Meetup
```

Se usi git subtree:

```bash
# Dalla root del progetto Laravel
git subtree add --prefix=Modules/Meetup [URL_REPOSITORY] master --squash
```

### 2. Installazione Dipendenze Composer

Il modulo Meetup ha un proprio `composer.json` che viene mergiato automaticamente grazie a `wikimedia/composer-merge-plugin`.

```bash
# Dalla root del progetto Laravel
composer update
```

### 3. Verifica Moduli Attivati

Controlla che il modulo Meetup sia attivo:

```bash
php artisan module:list
```

Se non è attivo:

```bash
php artisan module:enable Meetup
```

### 4. Pubblicazione Assets

```bash
# Pubblica assets del modulo (se presenti)
php artisan module:publish Meetup

# Pubblica configurazioni (se necessario)
php artisan vendor:publish --tag=meetup-config
```

### 5. Configurazione Database

#### Opzione A: SQLite (Default)

Il database SQLite è già configurato in `.env`:

```env
DB_CONNECTION=sqlite
DB_DATABASE=/var/www/_bases/base_laravelpizza/laravel/database/database.sqlite
```

Assicurati che il file esista:

```bash
touch database/database.sqlite
```

#### Opzione B: PostgreSQL/MySQL

Modifica `.env`:

```env
DB_CONNECTION=pgsql
DB_HOST=127.0.0.1
DB_PORT=5432
DB_DATABASE=laravelpizza
DB_USERNAME=your_username
DB_PASSWORD=your_password
```

### 6. Esecuzione Migrazioni

Esegui le migrazioni del modulo Meetup:

```bash
php artisan migrate

# O specificando il modulo
php artisan module:migrate Meetup
```

Le migrazioni creeranno le seguenti tabelle:
- `meetup_pizzas`
- `meetup_categories`
- `meetup_ingredients`
- `meetup_pizza_ingredient` (pivot)
- `meetup_orders`
- `meetup_order_items`

### 7. Seeding Dati Iniziali

Popola il database con dati di esempio:

```bash
# Seed completo
php artisan db:seed --class=Database\\Seeders\\MeetupModuleSeeder

# O seed specifici
php artisan db:seed --class=Modules\\Meetup\\Database\\Seeders\\PizzaSeeder
php artisan db:seed --class=Modules\\Meetup\\Database\\Seeders\\CategorySeeder
```

### 8. Installazione Tema Meetup

Il tema è separato e va nella directory `Themes/`:

```bash
cd Themes/
git clone [URL_TEMA_REPOSITORY] Meetup
```

Se usi git subtree:

```bash
# Dalla root del progetto
git subtree add --prefix=Themes/Meetup [URL_TEMA_REPOSITORY] master --squash
```

### 9. Configurazione Tema

Nel file di configurazione del modulo Xot (o tenant-specific):

```php
// config/xot.php o config/{tenant}/xot.php
return [
    'theme' => 'Meetup',
    'theme_path' => base_path('Themes/Meetup'),
];
```

### 10. Build Assets Frontend

```bash
# Installazione dipendenze Node
npm install

# Development
npm run dev

# Production
npm run build
```

### 11. Configurazione MCP (Opzionale)

Se usi Claude Code/Cursor per lo sviluppo:

```bash
# Copia il file example
cp .cursor/mcp.json.example .cursor/mcp.json

# Configura i server necessari (vedi mcp_configuration.md)
```

### 12. Permissions e Storage

```bash
# Assicura i permessi corretti
chmod -R 775 storage bootstrap/cache
chmod -R 775 ../public_html

# Link storage pubblico
php artisan storage:link
```

### 13. Verifica Installazione

```bash
# Controlla che l'applicazione funzioni
php artisan serve

# Visita:
# http://localhost:8000 - Homepage
# http://localhost:8000/admin - Admin panel (Filament)
```

### 14. Setup Admin User

Se non hai ancora un admin:

```bash
php artisan make:filament-user

# Inserisci:
# Name: Admin
# Email: admin@laravelpizza.test
# Password: password
```

## Post-Installazione

### Configurazione .env

Assicurati di configurare:

```env
APP_NAME="Laravel Pizza"
APP_ENV=local
APP_DEBUG=true
APP_URL=http://localhost:8000

# Mailer (per notifiche ordini)
MAIL_MAILER=smtp
MAIL_HOST=mailpit
MAIL_PORT=1025

# Queue (per job asincroni)
QUEUE_CONNECTION=database

# Tenant (opzionale)
TENANT_NAME=default
```

### Configurazione Code Quality Tools

```bash
# PHPStan
vendor/bin/phpstan analyse Modules/Meetup

# PHP Pint
vendor/bin/pint Modules/Meetup

# Pest Tests
vendor/bin/pest Modules/Meetup
```

## Troubleshooting

### Problema: Modulo non viene riconosciuto

**Soluzione:**
```bash
composer dump-autoload
php artisan module:list
php artisan cache:clear
```

### Problema: Tema non viene caricato

**Soluzione:**
```bash
# Verifica configurazione XotData
php artisan tinker
>>> XotData::make()->theme
>>> XotData::make()->getPubThemePath()

# Cancella cache viste
php artisan view:clear
```

### Problema: Migrazioni già eseguite

**Soluzione:**
```bash
# Rollback specifico modulo
php artisan module:migrate-rollback Meetup

# Fresh migration
php artisan module:migrate-refresh Meetup
```

### Problema: Assets non si compilano

**Soluzione:**
```bash
# Pulisci cache npm
npm cache clean --force
rm -rf node_modules package-lock.json
npm install

# Ricompila
npm run build
```

### Problema: Permessi file

**Soluzione:**
```bash
# Linux/Mac
sudo chown -R $USER:www-data storage bootstrap/cache
chmod -R 775 storage bootstrap/cache

# WSL
chmod -R 777 storage bootstrap/cache  # Solo in dev!
```

## Aggiornamento

### Aggiornamento Modulo

```bash
# Se git subtree
git subtree pull --prefix=Modules/Meetup [URL_REPOSITORY] master --squash

# Se git clone
cd Modules/Meetup
git pull origin master
cd ../..

# Sempre dopo l'update
composer update
php artisan migrate
php artisan cache:clear
npm run build
```

### Aggiornamento Tema

```bash
# Se git subtree
git subtree pull --prefix=Themes/Meetup [URL_TEMA] master --squash

# Se git clone
cd Themes/Meetup
git pull origin master
cd ../..

# Rebuild assets
npm run build
php artisan view:clear
```

## Configurazioni Avanzate

### Multi-Tenancy

Se usi il sistema tenant:

```bash
# Crea configurazione tenant
mkdir -p config/tenant1
cp config/xot.php config/tenant1/

# Modifica config/tenant1/xot.php
```

### Custom Domain

```bash
# Configura virtual host per dominio locale
# Apache
sudo nano /etc/apache2/sites-available/laravelpizza.local.conf

# Nginx
sudo nano /etc/nginx/sites-available/laravelpizza.local

# Aggiungi al /etc/hosts
127.0.0.1 laravelpizza.local
```

### Queue Workers

```bash
# Installa supervisor
sudo apt install supervisor

# Crea config supervisor
sudo nano /etc/supervisor/conf.d/laravelpizza-worker.conf

# Riavvia
sudo supervisorctl reread
sudo supervisorctl update
sudo supervisorctl start laravelpizza-worker:*
```

## Checklist Installazione

- [ ] PHP >= 8.2 installato
- [ ] Composer installato
- [ ] Node.js >= 18 installato
- [ ] Database creato e configurato
- [ ] Modulo Meetup clonato in `Modules/Meetup`
- [ ] Tema Meetup clonato in `Themes/Meetup`
- [ ] `composer update` eseguito
- [ ] Modulo Meetup abilitato
- [ ] Migrazioni eseguite
- [ ] Seeder eseguiti (opzionale)
- [ ] Assets compilati (`npm run build`)
- [ ] Storage permissions corretti
- [ ] Admin user creato
- [ ] Homepage e admin panel accessibili
- [ ] MCP configurato (opzionale)

## Supporto

Per problemi o domande:
- Documentazione: `Modules/Meetup/docs/`
- Issues: [Repository GitHub]
- Xot Docs: `Modules/Xot/docs/`

## Prossimi Passi

Dopo l'installazione:
1. Leggi [DEVELOPMENT.md](./development.md) per iniziare lo sviluppo
2. Consulta [architecture.md](./architecture.md) per comprendere l'architettura
3. Vedi [business-logic.md](./business-logic.md) per la logica di business
4. Consulta [todo.md](./todo.md) per le feature da implementare
