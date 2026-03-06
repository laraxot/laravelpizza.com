# Activity Module - Errori Rilevati e Soluzioni

## Stato Test Attuale

```
Tests:    28 failed, 2 skipped, 203 passed (831 assertions)
```

### Test che passano: 203 ✅
### Test che falliscono: 28 ❌
### Test saltati: 2

## Errori di Test

### 1. QueryException: Column not found 'state' in 'users' (28 test)

**Descrizione:**
```
SQLSTATE[42S22]: Column not found: 1054 Unknown column 'state' in 'field list'
(Connection: user, Host: 127.0.0.1, Port: 3306, Database: <nome progetto>_data)
```

**Causa:**
- I test usano `User::factory()->create()` che cerca di inserire un record con colonna `state`
- La tabella `users` nella connessione `user` non ha la colonna `state`

**Soluzione:**
- Aggiungere la colonna `state` alla tabella users nella migrazione
- Oppure modificare la factory per non usare `state`

**File coinvolti:**
- `Modules/Activity/tests/Unit/Actions/ActivityLoggerTest.php`
- `Modules/Activity/tests/Feature/ActivityIntegrationTest.php`
- `Modules/Activity/tests/Feature/ActivityEventSourcingTest.php`
- `Modules/Activity/tests/Feature/ActivityManagementTest.php`
- `Modules/Activity/tests/Unit/Actions/LogActionsTest.php`
- `Modules/Activity/tests/Unit/Actions/LogActivityActionTest.php`
- `Modules/Activity/tests/Unit/Actions/LogModelCreatedActionTest.php`
- `Modules/Activity/tests/Feature/TempActivityTest.php`

## Errori di Configurazione Risolti

### 2. TenantServiceProvider non registrato nei test ✅

**Descrizione:**
```
SQLSTATE[42S22]: Column not found: 1054 Unknown column 'state' in 'field list'
(Connection: user, Host: 127.0.0.1, Port: 3306, Database: <nome progetto>_data)
```

**Causa:**
- I test usano `User::factory()->create()` che cerca di inserire un record con colonna `state`
- La tabella `users` nella connessione `user` non ha la colonna `state`

**Soluzione:**
- Aggiungere la colonna `state` alla tabella users nella migrazione
- Oppure modificare la factory per non usare `state`

**File coinvolti:**
- `Modules/Activity/tests/Unit/Actions/ActivityLoggerTest.php`
- `Modules/Activity/tests/Feature/ActivityIntegrationTest.php`
- `Modules/Activity/tests/Feature/ActivityEventSourcingTest.php`
- `Modules/Activity/tests/Feature/ActivityManagementTest.php`

## Errori di Configurazione

### 2. TenantServiceProvider non registrato nei test

**Problema risolto:**
- Il TestCase mancava di `TenantServiceProvider`
- La connessione 'activity' non veniva registrata
- I test fallivano con "Connection 'activity' not configured"

**Soluzione applicata:**
```php
// TestCase.php
protected function getPackageProviders($app): array
{
    return [
        XotServiceProvider::class,
        TenantServiceProvider::class,  // AGGIUNTO
        UserServiceProvider::class,
        ActivityServiceProvider::class,
    ];
}
```

### 3. BaseModel connection errata

**Problema risolto:**
- BaseModel aveva docblock `/** @var string|null */` invece di `/** @var string */`

**Soluzione applicata:**
```php
// BaseModel.php
/** @var string */
protected $connection = 'activity';
```

### 4. Variabili DB_*_ACTIVITY in .env.testing

**Problema risolto:**
- Le variabili `DB_DATABASE_ACTIVITY`, `DB_USERNAME_ACTIVITY`, `DB_PASSWORD_ACTIVITY` erano presenti
- Questo causava ricerca di database separato per i test

**Soluzione applicata:**
- Rimosse le variabili da `.env.testing`
- TenantServiceProvider ora usa fallback dal default

### 5. Entry 'activity' in database.php

**Problema risolto:**
- C'era una entry 'activity' manuale in `config/database.php`

**Soluzione applicata:**
- Rimosso - TenantServiceProvider crea la connessione automaticamente

## Errori di Coverage

### File con 0% Coverage

Vedi [coverage-analysis](coverage-analysis.md) per l'elenco completo dei file che necessitano test.

## Prossimi Passi

1. **Correggere schema database**: Aggiungere colonna `state` alla tabella users
2. **Aggiungere test mancanti**: Coprire Actions, Providers, Listeners, Policies
3. **Raggiungere 100% coverage**: Aggiungere test per tutti i file con coverage 0%

## Comandi Utili

```bash
# Verificare se colonna esiste
php artisan tinker --execute="echo DB::connection('user')->getSchemaBuilder()->hasColumn('users', 'state') ? 'YES' : 'NO';"

# Eseguire migrazioni
php artisan migrate --database=user --env=testing

# Verificare tabelle
php artisan tinker --execute="echo implode(', ', DB::connection('user')->getSchemaBuilder()->getTableListing());"
```
