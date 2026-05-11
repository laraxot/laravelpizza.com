# Regole Environment Development vs Testing in Laraxot

## Panoramica
In Laraxot è fondamentale comprendere la differenza tra le configurazioni di ambiente di sviluppo e di test, specialmente riguardo all'uso dei database.

## REGOLA FONDAMENTALE: .env.testing è COPIA CARBONE del .env

### Principio
Il file `.env.testing` deve essere una copia esatta del `.env` con una sola modifica: il suffisso `_test` aggiunto ai nomi dei database.

### Esempio
```bash
# .env (produzione/sviluppo)
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=<nome progetto>_data
DB_USERNAME=marco
DB_PASSWORD=marco

DB_DATABASE_USER=<nome progetto>_user
DB_USERNAME_USER=marco
DB_PASSWORD_USER=marco
```

```bash
# .env.testing (test)
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=<nome progetto>_data_test
DB_USERNAME=marco
DB_PASSWORD=marco

DB_DATABASE_USER=<nome progetto>_user_test
DB_USERNAME_USER=marco
DB_PASSWORD_USER=marco
```

### MAI FARE QUESTO (ERRORI COMUNI)
```bash
# ❌ SBAGLIATO - Inventare database che non esistono nel .env
NOTIFY_DB_DATABASE=<nome progetto>_data_test
GEO_DB_DATABASE=<nome progetto>_data_test
MEDIA_DB_DATABASE=<nome progetto>_data_test

# ❌ SBAGLIATO - Cambiare la struttura delle connessioni
DB_CONNECTION=user
```

### REGOLA FONDAMENTALE: config/database.php
**NON aggiungere connessioni separate per modulo nel database.php principale!**

Le connessioni per i moduli (notify, geo, media, etc.) vengono create **automaticamente** dal `TenantServiceProvider` che:
1. Legge la connessione di default (`mysql`)
2. Crea una copia per ogni modulo basandosi sul nome del modulo

```php
// ❌ SBAGLIATO - Non fare mai questo nel database.php
'notify' => [
    'driver' => 'mysql',
    'database' => env('NOTIFY_DB_DATABASE', '<nome progetto>_notify_test'),
    ...
],
'geo' => [
    'driver' => 'mysql',
    'database' => env('GEO_DB_DATABASE', '<nome progetto>_geo_test'),
    ...
],

// ✅ CORRETTO - Le connessioni modulo sono create automaticamente
// Il TenantServiceProvider crea 'notify', 'geo', etc. come copia di 'mysql'
```

### Motivazione
- **Evita errori**: Non si inventano configurazioni inesistenti
- **DRY**: Una sola fonte di verità (.env)
- **Manutenibilità**: Cambiamenti al .env si riflettono automaticamente nei test
- **TenantServiceProvider**: Gestisce automaticamente le connessioni modulo

## Configurazione per Sviluppo (.env.development)

### Database
- `DB_CONNECTION=sqlite`: Usa SQLite per setup immediato
- `DB_DATABASE=$PROJECT_ROOT/database/database.sqlite`: Percorso al database
- Questa configurazione è corretta per lo sviluppo perché:
  - Permette di iniziare immediatamente senza setup database
  - È ideale per sviluppo locale rapido
  - Non richiede configurazioni aggiuntive

### Altre Impostazioni
- `CACHE_DRIVER=array`: Caching in memoria (non persistente)
- `QUEUE_CONNECTION=sync`: Esecuzione immediata delle code
- `MAIL_MAILER=log`: Logging email invece di invio reale
- `SESSION_DRIVER=array`: Sessioni in memoria (non persistenti)

## Configurazione per Test (.env.testing)

### Database
- `DB_CONNECTION=mysql`: Usa MySQL per i test
- Database con suffisso "_test" (es. `healthcare_app_data_test`, `healthcare_app_user_test`)
- **MAI** usare SQLite per i test, nemmeno per convenienza

### Motivazione
La configurazione di test richiede MySQL perché:
- Garantisce corretto isolamento multi-tenant
- Supporta tutte le funzionalità richieste per i test
- Mantiene l'integrità dell'architettura multi-database
- Permette test accurati delle funzionalità specifiche del sistema

## Best Practices

### Per gli Sviluppatori
- Usa `.env.development` per lavoro quotidiano
- Usa `.env.testing` per esecuzione test
- Non modificare mai la configurazione di test per usare SQLite
- Rispetta sempre la configurazione definita nei file .env

### Per i Test
- Assicurati che i test utilizzino la configurazione corretta
- Non forzare connessioni SQLite nei test
- Usa `DatabaseTransactions` invece di `RefreshDatabase`
- Verifica che i dati siano correttamente isolati per tenant

## Conformità con Architettura Laraxot

Questa differenziazione rispetta i principi fondamentali:
- **DRY**: Configurazioni separate per scopi diversi
- **KISS**: Semplicità per sviluppo, completezza per test
- **Robustezza**: Isolamento adeguato nei test
- **Multi-tenancy**: Supporto completo per architettura multi-database

## REGOLA CRITICA: TestCase setUp()

### NON duplicare la configurazione delle connessioni database nel setUp()!

Il trait `CreatesApplication` già configura automaticamente TUTTE le connessioni dei moduli. Duplicare questa logica nel `setUp()` del TestCase è **FONDAMENTALMENTE SBAGLIATO**.

**Esempio CORRETTO:**
```php
protected function setUp(): void
{
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

**Esempio SBAGLIATO (DA NON FARE MAI!):**
```php
protected function setUp(): void
{
    parent::setUp();

    // ❌ SBAGLIATO - Duplicazione pericolosa!
    // CreatesApplication::createApplication() lo fa già!
    config(['database.connections.notify' => config('database.connections.mysql')]);
    config(['database.connections.geo' => config('database.connections.mysql')]);
    config(['database.connections.media' => config('database.connections.mysql')]);
    // ... ecc per tutti i moduli

    // ❌ SBAGLIATO - Anche questo è ridondante!
    \Illuminate\Support\Facades\DB::purge('notify');
    \Illuminate\Support\Facades\DB::purge('mysql');

    if (! self::$migrated) {
        $this->artisan('migrate:fresh', ['--force' => true]);
        $this->artisan('module:migrate', ['--force' => true]);
        self::$migrated = true;
    }
}
```

### Perché è sbagliato duplicare:

1. **CreatesApplication lo fa già**: Il trait `CreatesApplication::createApplication()` configura automaticamente TUTTE le connessioni dei moduli (notify, geo, media, job, activity, cms, gdpr, lang, meetup, seo, tenant, xot) mappandole alla connessione `mysql` definita nel `.env.testing`.

2. **Conflitti**: Duplicare può causare conflitti e problemi di inizializzazione, specialmente errori come "Call to a member function connection() on null".

3. **Violazione DRY**: È una duplicazione inutile di logica che esiste già.

### Cosa fa CreatesApplication automaticamente:

```php
// In Modules/Xot/tests/CreatesApplication.php
$moduleConnections = [
    'user', 'notify', 'geo', 'media', 'job', 'xot',
    'activity', 'cms', 'gdpr', 'lang', 'meetup', 'seo', 'tenant',
    'healthcare_app', 'limesurvey',
];

foreach ($moduleConnections as $connection) {
    $app['config']->set("database.connections.{$connection}", $defaultConfig);
}
```

### Quando usare setUp() nel TestCase:

Il `setUp()` deve essere usato SOLO per:
- Configurare il tema (xra.pub_theme)
- Configurare il modulo principale (xra.main_module)
- Eseguire migrate:fresh e module:migrate (una sola volta)
- Non MAI per configurare connessioni database!