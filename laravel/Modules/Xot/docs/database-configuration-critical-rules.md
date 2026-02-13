# Database Configuration - Critical Rules

## REGOLE FONDAMENTALI

### 1. MAI Forzare le Connessioni in CreatesApplication

⚠️ **Vedi anche [TestCase Setup Rules](./testcase-setup-critical-rules.md)**

### 2. MAI Eseguire migrate in TestCase setUp()

Vedi [TestCase Setup Rules](./testcase-setup-critical-rules.md) per dettagli completi.

### 3. MAI Inventare Variabili Environment

**❌ SBAGLIATO - NESSUNO MAI FARE QUESTO:**

```php
// Modules/Xot/tests/CreatesApplication.php
$defaultConfig = $app['config']->get('database.connections.mysql');
$moduleConnections = ['user', 'notify', 'geo', 'media', 'job', ...];
foreach ($moduleConnections as $connection) {
    $app['config']->set("database.connections.{$connection}", $defaultConfig);
}
```

**Perché è SBAGLIATO:**
1. Distrugge il sistema di configurazione dinamica gestito da TenantServiceProvider
2. Non rispetta le variabili environment definite in `.env.testing`
3. È ridondante - TenantServiceProvider lo fa già automaticamente
4. Viola l'architettura Laraxot
5. Crea technical debt e problemi di manutenzione

**✅ CORRETTO - Lasciare che TenantServiceProvider gestisca tutto:**

```php
// Modules/Xot/tests/CreatesApplication.php
// Bootstrap kernel
$app->make(Kernel::class)->bootstrap();
$app->boot();

// CRITICAL: DO NOT force database connections!
// TenantServiceProvider automatically configures module connections
// by reading DB_DATABASE from .env.testing

return $app;
```

### 2. MAI Inventare Variabili Environment

**❌ SBAGLIATO - NESSUNO MAI FARE QUESTO:**

```bash
# .env.testing - WRONG!
NOTIFY_DB_DATABASE=laravelpizza_data_test
GEO_DB_DATABASE=laravelpizza_data_test
MEDIA_DB_DATABASE=laravelpizza_data_test
GDPR_DB_DATABASE=laravelpizza_data_test
MEETUP_DB_DATABASE=laravelpizza_meetup_test
# ... ecc
```

**Perché è SBAGLIATO:**
1. Queste variabili NON esistono nel file `.env` principale
2. Invenzione di variabili crea confusione e problemi di manutenzione
3. TenantServiceProvider NON legge queste variabili
4. Viola il principio di "copia carbone" per l'environment di testing

**✅ CORRETTO - Copia Carbone di .env:**

```bash
# Se .env ha:
DB_DATABASE=laravelpizza_data
DB_DATABASE_USER=laravelpizza_user

# Allora .env.testing deve avere:
DB_DATABASE=laravelpizza_data_test
DB_DATABASE_USER=laravelpizza_user_test

# Tutto il resto IDENTICO!
```

### 3. MAI Aggiungere Connessioni Hardcode in config/database.php

**❌ SBAGLIATO - NESSUNO MAI FARE QUESTO:**

```php
// config/database.php - WRONG!
'connections' => [
    'notify' => [
        'driver' => 'mysql',
        'database' => env('NOTIFY_DB_DATABASE', 'laravelpizza_notify_test'),
        // ...
    ],
    'geo' => [
        'driver' => 'mysql',
        'database' => env('GEO_DB_DATABASE', 'laravelpizza_geo_test'),
        // ...
    ],
    // ... ecc per tutti i moduli
],
```

**Perché è SBAGLIATO:**
1. Violazione del principio di configurazione dinamica
2. Duplicazione inutile - TenantServiceProvider crea già queste connessioni
3. Hardcoding rende difficile la manutenzione
4. Non rispetta l'architettura Laraxot
5. Crea conflitti con il sistema dinamico

**✅ CORRETTO - Lasciare solo le connessioni standard:**

```php
// config/database.php - CORRECT!
'connections' => [
    'sqlite' => [/* ... */],
    'mysql' => [/* ... */],
    'mariadb' => [/* ... */],
    'pgsql' => [/* ... */],
    'sqlsrv' => [/* ... */],
],
// Module connections are automatically created by TenantServiceProvider
```

## Come Funziona il Sistema Laraxot

### TenantServiceProvider

Il `TenantServiceProvider` gestisce le connessioni database in modo dinamico:

1. **Legge le variabili environment**: `DB_DATABASE`, `DB_HOST`, ecc.
2. **Crea connessioni per ogni modulo**: `user`, `notify`, `geo`, `media`, ecc.
3. **Usa il database configurato**: Tutte le connessioni puntano allo stesso database
4. **Automatico e centralizzato**: Non serve configurazione manuale

### Flusso di Configurazione

```
.env.testing
    ↓
DB_DATABASE=laravelpizza_data_test
    ↓
TenantServiceProvider::registerDB()
    ↓
Crea automaticamente:
  - database.connections.user → laravelpizza_data_test
  - database.connections.notify → laravelpizza_data_test
  - database.connections.geo → laravelpizza_data_test
  - ... ecc per tutti i moduli
```

## Testing Workflow Corretto

```bash
# 1. Configurazione ambiente di testing
cd laravel
cp .env .env.testing
# Modifica: DB_DATABASE → DB_DATABASE_test

# 2. Esegui migration (solo se necessario)
php artisan migrate --env=testing

# 3. Esegui test
php artisan test --env=testing
```

## Pattern nei Test

```php
// ✅ CORRETTO
it('renders page', function () {
    get('/en/auth/register')
        ->assertStatus(200);
});

// ✅ CORRETTO
it('creates user', function () {
    $user = User::factory()->create();
    expect($user->email)->not->toBeEmpty();
});

// ❌ SBAGLIATO - Non forzare connessioni!
it('test with wrong config', function () {
    config(['database.connections.notify' => config('database.connections.mysql')]);
    // ...
});
```

## Checklist Anti-Errori

Prima di scrivere codice di configurazione database:

- [ ] Ho forzato le connessioni con `config()`? → **STOP! Rimuovi il codice.**
- [ ] Ho inventato variabili environment tipo `NOTIFY_DB_DATABASE`? → **STOP! Usa solo variabili del .env.**
- [ ] Ho aggiunto connessioni hardcode in `config/database.php`? → **STOP! Rimuovile.**
- [ ] `.env.testing` è una copia carbone di `.env` con solo `_test`? → **OK!**

## Troubleshooting

### Problema: Test non trovano le tabelle

**Cause possibili:**
1. `.env.testing` non configurato correttamente
2. Migration non eseguite
3. Forzatura delle connessioni in CreatesApplication

**Soluzione:**
1. Verifica che `.env.testing` sia una copia di `.env` con `_test`
2. Esegui `php artisan migrate --env=testing`
3. Rimuovi forzatura delle connessioni in CreatesApplication

### Problema: Connessione "module_name" non configurata

**Causa errata (da NON fare):**
Aggiungere la connessione in `config/database.php`

**Causa reale e soluzione:**
TenantServiceProvider non è stato caricato. Assicurati che il ServiceProvider sia registrato correttamente.

### Problema: Migrations usano database di produzione

**Soluzione:**
1. Verifica `APP_ENV=testing` in `.env.testing`
2. Verifica che `DB_DATABASE` abbia `_test` suffix
3. Esegui test con `--env=testing` flag

## Documentazione Correlata

- [Database Testing Configuration](../Gdpr/docs/database-testing-configuration.md)
- [TenantServiceProvider](../Tenant/app/Providers/TenantServiceProvider.php)
- [Environment Development vs Testing](./environment-development-vs-testing-rules.md)

## Regole d'Oro

1. **Copia Carbone**: `.env.testing` = `.env` + `"_test"` sui database
2. **Niente Invenzioni**: Non creare variabili environment che non esistono in `.env`
3. **Niente Forzatura**: Non forzare connessioni con `config()`
4. **Niente Hardcoding**: Non aggiungere connessioni statiche in `config/database.php`
5. **Fiducia**: Lascia che TenantServiceProvider gestisca tutto automaticamente

Queste regole devono essere ricordate e applicate da TUTTI gli agenti AI (iFlow, Windsurf, Cursor, Gemini, Antigravity, ecc.).