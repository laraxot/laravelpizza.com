# Database config standard (Laravel 13.x)

**Status**: attivo  
**Riferimento**: https://github.com/laravel/laravel/blob/13.x/config/database.php

## Obiettivo

Il file `config/database.php` deve essere **identico** allo standard Laravel 13.x per garantire compatibilita' e manutenibilita'.

## Motivazione

### Perche' standard Laravel 13.x

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

### Connessioni standard (in database.php)
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
// config/database.php (standard Laravel 13.x)
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

### File sostituito
- `config/database.php` → Standard Laravel 13.x (identico a https://github.com/laravel/laravel/blob/13.x/config/database.php)

### Compatibilita' PHP 8.3
- Unica modifica ammessa: `use Pdo\Mysql` rimosso, uso di `\Pdo\Mysql::ATTR_SSL_CA` nel ternary (PHP 8.5+) per evitare fatal error su PHP 8.3 dove la classe non esiste

### Rimozioni
- ❌ Tutte le connessioni modulari hardcoded (predict, blog, cms, activity, user, ecc.)
- ❌ Configurazioni custom in database.php

### Aggiunte
- ✅ Connessioni modulari in `config/local/<tenant>/database.php` (predict, blog, cms, activity)
- ✅ Struttura standard Laravel 13.x
- ✅ `busy_timeout`, `journal_mode`, `synchronous`, `transaction_mode` per SQLite
- ✅ `sslmode` env per PostgreSQL
- ✅ Redis: `max_retries`, `backoff_algorithm`, `backoff_base`, `backoff_cap`

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
