# REGOLA CRITICA: config/database.php

## NESSUNA connessione hardcoded per i moduli!

I file `config/*/database.php` NON devono contenere connessioni hardcoded per i moduli (notify, geo, media, job, xot, activity, cms, gdpr, lang, meetup, seo, tenant).

## ❌ SBAGLIATO (MAI FARE QUESTO!)

```php
// config/database.php
'connections' => [
    'mysql' => [...],
    
    // ❌ SBAGLIATO - Non definire connessioni modulo!
    'notify' => [
        'driver' => 'mysql',
        'database' => env('NOTIFY_DB_DATABASE', 'laravelpizza_notify_test'),
        'username' => env('NOTIFY_DB_USERNAME', 'root'),
        'password' => env('NOTIFY_DB_PASSWORD', ''),
        ...
    ],
    'geo' => [
        'driver' => 'mysql',
        'database' => env('GEO_DB_DATABASE', 'laravelpizza_geo_test'),
        ...
    ],
    // ... ecc per tutti i moduli
],
```

## ✅ CORRETTO

```php
// config/database.php
'connections' => [
    'mysql' => [...],
    'sqlite' => [...],
    'pgsql' => [...],
    'sqlsrv' => [...],
    // SOLO connessioni standard di Laravel!
],
```

## Perché è SBAGLIATO definire connessioni modulo in database.php?

1. **Violates Laraxot Architecture**: Le connessioni dei moduli vengono create DINAMICAMENTE dal `TenantServiceProvider::registerDB()`
2. **DRY Violation**: Duplica logica che è già gestita centralmente
3. **Maintenance Nightmare**: Modifiche devono essere fatte in più posti
4. **Breaks Isolation**: Rende difficile isolare i database per testing
5. **Conflicts**: Può causare conflitti con la configurazione dinamica

## Come funziona il sistema corretto?

Il `TenantServiceProvider` (in `Modules/Tenant/app/Providers/TenantServiceProvider.php`) ha un metodo `registerDB()` che:

1. Legge la connessione di default (`mysql`)
2. Crea automaticamente una copia per ogni modulo
3. Usa i nomi delle connessioni dei moduli
4. Applica la configurazione dell'ambiente (.env, .env.testing)

```php
// TenantServiceProvider::registerDB()
$moduleConnections = [
    'user', 'notify', 'geo', 'media', 'job', 'xot',
    'activity', 'cms', 'gdpr', 'lang', 'meetup', 'seo', 'tenant',
];

$defaultConfig = $app['config']->get('database.connections.mysql');

foreach ($moduleConnections as $connection) {
    $app['config']->set("database.connections.{$connection}", $defaultConfig);
}
```

## Cosa deve contenere il file config/database.php?

```php
return [
    'default' => env('DB_CONNECTION', 'mysql'),
    
    'connections' => [
        // Solo connessioni STANDARD di Laravel
        'mysql' => [
            'driver' => 'mysql',
            'host' => env('DB_HOST', '127.0.0.1'),
            'port' => env('DB_PORT', '3306'),
            'database' => env('DB_DATABASE', 'forge'),
            'username' => env('DB_USERNAME', 'forge'),
            'password' => env('DB_PASSWORD', ''),
            'unix_socket' => env('DB_SOCKET', ''),
            'charset' => env('DB_CHARSET', 'utf8mb4'),
            'collation' => env('DB_COLLATION', 'utf8mb4_unicode_ci'),
            'prefix' => '',
            'prefix_indexes' => true,
            'strict' => true,
            'engine' => null,
            'options' => extension_loaded('pdo_mysql') ? array_filter([
                PDO::MYSQL_ATTR_SSL_CA => env('MYSQL_ATTR_SSL_CA'),
            ]) : [],
        ],
        
        'sqlite' => [
            'driver' => 'sqlite',
            'url' => env('DATABASE_URL'),
            'database' => env('DB_DATABASE', database_path('database.sqlite')),
            'prefix' => '',
            'foreign_key_constraints' => env('DB_FOREIGN_KEYS', true),
        ],
        
        'pgsql' => [...],
        'sqlsrv' => [...],
    ],
];
```

## Commento consigliato

Aggiungi questo commento nel file `config/database.php` per ricordare agli sviluppatori:

```php
/*
|--------------------------------------------------------------------------
| Database Connections
|--------------------------------------------------------------------------
|
| Here are each of the database connections setup for your application.
|
| IMPORTANT: Module-specific connections (notify, geo, media, job, xot, 
| activity, cms, gdpr, lang, meetup, seo, tenant) are automatically added
| by TenantServiceProvider based on the mysql connection - no need to 
| define them here.
|
*/
```

## Riepilogo delle 3 Regole Critiche

### 1. .env.testing Rule
```
.env.testing = Copia carbone di .env con solo "_test" aggiunto ai nomi database
```

**❌ SBAGLIATO:**
```bash
NOTIFY_DB_DATABASE=laravelpizza_data_test
GEO_DB_DATABASE=laravelpizza_data_test
```

**✅ CORRETTO:**
```bash
# Se .env ha:
DB_DATABASE=laravelpizza_data

# .env.testing ha:
DB_DATABASE=laravelpizza_data_test  # Solo aggiungi "_test"!
```

### 2. TestCase setUp() Rule
```
setUp() deve SOLO configurare tema/modulo + migrate, niente connessioni
```

**❌ SBAGLIATO:**
```php
protected function setUp(): void {
    parent::setUp();
    
    // ❌ SBAGLIATO - CreatesApplication lo fa già!
    config(['database.connections.notify' => config('database.connections.mysql')]);
    config(['database.connections.geo' => config('database.connections.mysql')]);
    // ... ecc
}
```

**✅ CORRETTO:**
```php
protected function setUp(): void {
    parent::setUp();
    
    config(['xra.pub_theme' => 'Meetup']);
    config(['xra.main_module' => 'User']);
    
    \Modules\Xot\Datas\XotData::make()->update([
        'pub_theme' => 'Meetup',
        'main_module' => 'User',
    ]);
    
    if (! self::$migrated) {
        $this->artisan('migrate:fresh', ['--force' => true]);
        $this->artisan('module:migrate', ['--force' => true]);
        self::$migrated = true;
    }
}
```

### 3. database.php Rule
```
database.php deve avere SOLO connessioni standard, nessuna connessione modulo
```

**❌ SBAGLIATO:**
```php
'connections' => [
    'mysql' => [...],
    'notify' => [...],   // ❌ Non aggiungere!
    'geo' => [...],      // ❌ Non aggiungere!
    'media' => [...],    // ❌ Non aggiungere!
],
```

**✅ CORRETTO:**
```php
'connections' => [
    'mysql' => [...],
    'sqlite' => [...],
    'pgsql' => [...],
    'sqlsrv' => [...],
    // SOLO connessioni standard!
],
```

## Conclusione

Le connessioni dei moduli sono create AUTOMATICAMENTE dal TenantServiceProvider:

1. Legge `.env.testing` (o `.env`)
2. Prende la configurazione della connessione `mysql`
3. Crea automaticamente connessioni per tutti i moduli
4. Applica i nomi dei database con suffisso `_test` quando necessario

**NESSUNA duplicazione manuale è necessata o permessa!**

## Riferimenti

- [TenantServiceProvider](../../Tenant/app/Providers/TenantServiceProvider.php)
- [CreatesApplication Trait](../Xot/tests/CreatesApplication.php)
- [Environment Development vs Testing Rules](./environment-development-vs-testing-rules.md)
- [Testing Database Configuration](./database-testing-configuration.md)