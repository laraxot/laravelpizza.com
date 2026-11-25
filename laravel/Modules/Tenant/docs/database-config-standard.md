---
title: "Standard della config database e connessioni dei moduli"
type: rule
module: Tenant
updated: 2026-11-25
qmd: "database config standard laravel connessioni modulari registerDB alias default user_sqlite user_mysql hasSameDatabaseConfig mergeModuleConnections"
---

# Standard della config database

**Regola**: `config/database.php` e `config/<tenant>/database.php` restano **come nello scheletro Laravel**. Le connessioni
per modulo non si scrivono a mano: le aggiunge `TenantServiceProvider::registerDB()` a ogni avvio.

## Cosa ci sta nei file

- Connessioni **driver**: `sqlite`, `mysql`, `mariadb`, `pgsql`, `sqlsrv`, con i parametri letti da `.env`.
- Le connessioni utenti `user_sqlite`, `user_mysql`, `user_mariadb` (database separato per gli utenti, `DB_DATABASE_USER`,
  `DB_USERNAME_USER`, `DB_PASSWORD_USER`). Nel repository e' presente anche una `user` esplicita in entrambi i file; quando
  manca, `registerDB()` la ricava da `connections.user_<default>`.
- Nessuna connessione chiamata come un modulo (`notify`, `geo`, `media`, `job`, `xot`, `activity`, `cms`, `gdpr`, `lang`,
  `meetup`, `seo`, `tenant`...): sarebbe una copia che diverge dalla default senza che nessuno se ne accorga.
- Unica modifica ammessa allo scheletro: compatibilita' di versione PHP (una costante `Pdo\Mysql::ATTR_SSL_CA` che non esiste
  su versioni vecchie va scelta con un ternario, non importata con `use`).

## Cosa fa `registerDB()` (in ordine)

1. `Schema::defaultStringLength(191)`.
2. Legge `database` con l'overlay del tenant ([configuration](configuration.md)); se manca `default`, tiene la connessione
   di default precedente (`mysql` come ultimo ripiego); crea `connections.user` da `user_<default>` se assente.
3. **`mergeModuleConnections()`**: per ogni modulo attivo (`Module::getOrdered()`) senza connessione dichiarata, la
   connessione `<modulo in snake_case>` e' una **copia** della default.
4. **`aliasModuleConnectionsToDefault()`**: per quelle connessioni `DB::extend()` restituisce **la stessa istanza**
   `Connection` della default finche' la config coincide (`hasSameDatabaseConfig()`, chiave `name` esclusa). Una config diversa,
   dichiarata nel `database.php` del tenant o cambiata a runtime, apre una connessione propria.
5. Fuori da `testing`, `DB::purge()` e `DB::reconnect()` sulla default. Con `?act=migrate` nella richiesta la default viene
   purgata e riconnessa prima di leggere la config.

Perche' l'alias: i modelli dichiarano la connessione col nome del loro modulo (`protected $connection = 'user'`), cosi' un
modulo si puo' spostare su un altro database solo con la config. Ma nel caso comune tutti stanno sullo stesso database, e una
connessione PHP per modulo romperebbe l'atomicita' di una transazione che scrive su due moduli. Con l'alias `DB::transaction()`
copre tutto e c'e' una sola sessione per richiesta. Decisione completa, alternative e costi:
[ADR 0001](adr/0001-module-connections-alias-default.md). Guardia: `tests/Feature/ModuleConnectionAliasTest.php`.

## Come si sposta un modulo su un altro database

Si dichiara la sua connessione in `config/<tenant>/database.php`, con lo stesso nome del modulo in snake_case:

```php
'connections' => [
    'user' => [
        'driver' => 'mysql',
        'database' => env('DB_DATABASE_USER', 'app_user'),
        // host, credenziali: come per mysql
    ],
],
```

Quel modulo esce dall'alias per scelta: perde l'atomicita' con gli altri moduli e non puo' avere chiavi esterne verso tabelle
dell'altro database.

## Verifica

```php
// dopo il bootstrap
config('database.connections.<modulo>');                           // presente, copia della default
DB::connection('<modulo>') === DB::connection(config('database.default'));  // true se non e' stata dichiarata a parte
```

Se un modulo nuovo non ha connessione, di norma non e' attivo: `Module::getOrdered()` elenca solo quelli abilitati
([module-registry](module-registry.md)).

Codice: `app/Providers/TenantServiceProvider.php`. Ordine di avvio e rischi: [tenant-resolution](tenant-resolution.md).
