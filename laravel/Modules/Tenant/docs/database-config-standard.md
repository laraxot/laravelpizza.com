# Database Config Standard Laravel 12.x - 2026-01-21

**Status**: ✅ Completato  
**Data**: 2026-01-21

## Obiettivo

Il file `config/database.php` è stato aggiornato per essere identico a quello standard di Laravel 12.x, garantendo compatibilità e manutenibilità.

## Motivazione

### Perché Standard Laravel 12.x

1. **Gestione Dinamica Connessioni Modulari**
   - Le connessioni modulari vengono aggiunte **automaticamente** da `TenantServiceProvider::registerDB()`
   - Non serve hardcodare connessioni nel file principale
   - Il sistema Laraxot gestisce tutto dinamicamente

2. **Compatibilità Aggiornamenti**
   - File standard = compatibilità garantita con aggiornamenti Laravel
   - Nessuna modifica custom da mantenere
   - Struttura sempre allineata con Laravel core

3. **Configurazione Pulita**
   - File pulito e leggibile
   - Solo connessioni standard (sqlite, mysql, mariadb, pgsql, sqlsrv)
   - Connessioni custom gestite via file tenant-specific o env

## Architettura Connessioni

### Connessioni Standard (in database.php)
- `sqlite` - SQLite database
- `mysql` - MySQL database (default)
- `mariadb` - MariaDB database
- `pgsql` - PostgreSQL database
- `sqlsrv` - SQL Server database

### Connessioni Modulari (aggiunte dinamicamente)
Aggiunte automaticamente da `TenantServiceProvider::registerDB()`:
- `activity`, `cms`, `gdpr`, `geo`, `job`, `lang`, `media`, `meetup`, `notify`, `seo`, `tenant`, `ui`, `user`, `xot`, `quaeris`, `chart`, `limesurvey`

**Pattern**: Ogni modulo ottiene una connessione basata sulla connessione default, configurata automaticamente.

### Connessioni Custom (config tenant-specific)
Configurate via file tenant-specific in `config/it/{tenant}/database.php`:
- `user` - Database utenti (se diverso da default)
- `limesurvey` - Database LimeSurvey (se diverso da default)
- `quaeris` - Database Quaeris (se diverso da default)

**Pattern**: Usano variabili env specifiche:
- `DB_DATABASE_USER` / `DB_USERNAME_USER` / `DB_PASSWORD_USER`
- `DB_DATABASE_LIMESURVEY` / `DB_USERNAME_LIMESURVEY` / `DB_PASSWORD_LIMESURVEY`

## Come Funziona

### 1. Bootstrap Standard
```php
// config/database.php (standard Laravel 12.x)
'default' => env('DB_CONNECTION', 'sqlite'),
'connections' => [
    'mysql' => [...], // Configurazione standard
    // Nessuna connessione modulare hardcoded
]
```

### 2. Registrazione Dinamica (TenantServiceProvider)
```php
// Modules/Tenant/app/Providers/TenantServiceProvider.php
public function registerDB(): void
{
    // Legge configurazione da TenantService::config('database')
    // Aggiunge automaticamente connessioni per ogni modulo
    foreach ($modules as $module) {
        $name = $module->getSnakeName();
        if (!isset($connections[$name])) {
            $connections[$name] = $connections[$default]; // Copia default
        }
    }
    Config::set('database', $data);
}
```

### 3. Configurazione Tenant-Specific (opzionale)
```php
// config/it/quaeris/database.php
return [
    'connections' => [
        'user' => [
            'database' => env('DB_DATABASE_USER', 'quaeris_user'),
            // Configurazione custom per user
        ],
        'limesurvey' => [
            'database' => env('DB_DATABASE_LIMESURVEY', 'quaeris_survey'),
            // Configurazione custom per limesurvey
        ],
    ],
];
```

## Modifiche Applicate

### File Sostituito
- `laravel/config/database.php` → Standard Laravel 12.x

### Rimozioni
- ❌ Tutte le connessioni modulari hardcoded (activity, cms, gdpr, geo, job, lang, media, meetup, notify, seo, tenant, ui, user, xot duplicate)
- ❌ Errori di sintassi (virgole doppie `,,`, parentesi errate `) : []`)
- ❌ Configurazioni custom hardcoded

### Aggiunte
- ✅ Struttura standard Laravel 12.x
- ✅ `transaction_mode` per SQLite
- ✅ `sslmode` per PostgreSQL
- ✅ Redis config aggiornato (max_retries, backoff_algorithm, etc.)
- ✅ PHP 8.3+ compatibility (usato `\PDO::MYSQL_ATTR_SSL_CA` invece di `\Pdo\Mysql::ATTR_SSL_CA`)

## Verifica Funzionamento

### Test Connessioni Modulari
```php
// Le connessioni modulari devono essere disponibili dopo bootstrap
config('database.connections.user'); // ✅ Disponibile (aggiunta da TenantServiceProvider)
config('database.connections.xot'); // ✅ Disponibile (aggiunta da TenantServiceProvider)
config('database.connections.quaeris'); // ✅ Disponibile (aggiunta da TenantServiceProvider)
```

### Test Connessioni Custom
```php
// Connessioni custom devono essere configurate via tenant-specific
config('database.connections.limesurvey'); // ✅ Disponibile (da config tenant o default)
```

## Note Importanti

1. **NON aggiungere connessioni modulari** in `config/database.php` - vengono aggiunte automaticamente
2. **Connessioni custom** (`user`, `limesurvey`) possono essere configurate via:
   - File tenant-specific: `config/it/{tenant}/database.php`
   - Variabili env: `DB_DATABASE_USER`, `DB_DATABASE_LIMESURVEY`
3. **File standard** garantisce compatibilità con aggiornamenti Laravel

## Riferimenti

- [Database Config Standard Laravel 12](../../../docs/config/database-standard-laravel-12.md)
- [Database Config Standard Rule](../../../../.cursor/rules/database-config-standard.mdc)
- [TenantServiceProvider Database Registration](../app/Providers/TenantServiceProvider.php)
- [DatabaseConfigResolver](../app/Services/Config/Resolvers/DatabaseConfigResolver.php)

**Versione**: 1.0  
**Ultimo aggiornamento**: 2026-01-21  
**Status**: ✅ Completato
