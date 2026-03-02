# Database config standard (Laravel 12.x)

**Status**: da verificare  
**Data**: da aggiornare

## Obiettivo

Il file `config/database.php` deve essere allineato allo standard di Laravel 12.x per garantire compatibilita' e manutenibilita'.

## Motivazione

### Perche' standard Laravel 12.x

1. **Gestione Dinamica Connessioni Modulari**
   - Le connessioni modulari vengono aggiunte **automaticamente** da `TenantServiceProvider::registerDB()`
   - Non serve hardcodare connessioni nel file principale
   - Il sistema gestisce tutto dinamicamente

2. **Compatibilità Aggiornamenti**
   - File standard = compatibilita' garantita con aggiornamenti Laravel
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
Aggiunte automaticamente da `TenantServiceProvider::registerDB()`.

**Pattern**: ogni modulo ottiene una connessione basata sulla connessione di default, configurata automaticamente.

### Connessioni Custom (config tenant-specific)
Configurate via file tenant-specific in `config/<locale>/<tenant>/database.php`.

**Pattern**: usare variabili env specifiche per connessioni dedicate (es. `DB_DATABASE_<NOME>`).

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
// config/<locale>/<tenant>/database.php
return [
    'connections' => [
        'user' => [
            'database' => env('DB_DATABASE_USER', 'app_user'),
            // Configurazione custom per user
        ],
    ],
];
```

## Modifiche Applicate

### File Sostituito
- `config/database.php` → Standard Laravel 12.x

### Rimozioni
- ❌ Tutte le connessioni modulari hardcoded (activity, cms, gdpr, geo, job, lang, media, meetup, notify, seo, tenant, ui, user, xot duplicate)
- ❌ Errori di sintassi (virgole doppie `,,`, parentesi errate `) : []`)
- ❌ Configurazioni custom hardcoded

### Aggiunte
- ✅ Struttura standard Laravel 12.x
- ✅ `transaction_mode` per SQLite
- ✅ `sslmode` per PostgreSQL
- ✅ Redis config aggiornato (max_retries, backoff_algorithm, ecc.)
- ✅ Compatibilita' PHP 8.3+ (`\PDO::MYSQL_ATTR_SSL_CA` dove richiesto)

## Verifica Funzionamento

### Test Connessioni Modulari
```php
// Le connessioni modulari devono essere disponibili dopo bootstrap
config('database.connections.user'); // ✅ Disponibile (aggiunta da TenantServiceProvider)
config('database.connections.xot'); // ✅ Disponibile (aggiunta da TenantServiceProvider)
config('database.connections.<module>'); // ✅ Disponibile (aggiunta da TenantServiceProvider)
```

### Test Connessioni Custom
```php
// Connessioni custom devono essere configurate via tenant-specific
config('database.connections.<custom>'); // ✅ Disponibile (da config tenant o default)
```

## Note Importanti

1. **NON aggiungere connessioni modulari** in `config/database.php` - vengono aggiunte automaticamente
2. **Connessioni custom** possono essere configurate via:
   - File tenant-specific: `config/<locale>/<tenant>/database.php`
   - Variabili env: `DB_DATABASE_<NOME>`
3. **File standard** garantisce compatibilità con aggiornamenti Laravel

## Riferimenti
- [TenantServiceProvider Database Registration](../app/Providers/TenantServiceProvider.php)
- [DatabaseConfigResolver](../app/Services/Config/Resolvers/DatabaseConfigResolver.php)
