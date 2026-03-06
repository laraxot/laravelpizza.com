# Activity Module — Database Connection: Pattern Corretto

## Regola definitiva

**Tutti i modelli del modulo Activity DEVONO dichiarare:**

```php
/** @var string */
protected $connection = 'activity';
```

Questo vale per: `BaseModel`, `Activity`, `Snapshot`, `StoredEvent`.

---

## Perché `/** @var string */` e NON `/** @var string|null */`

- La connessione `'activity'` è **garantita e sempre presente** in `database.php`
- Il tipo `string` (non nullable) è più preciso — non c'è caso in cui la connessione sia null
- `XotBaseModel` usa la stessa convenzione: `/** @var string */ $connection = 'xot'`
- I moduli che sovrascrivono `$connection` mantengono il tipo `string` non nullable

```
Eloquent\Model::$connection      → protected $connection;     (implicitly nullable)
XotBaseModel::$connection        → /** @var string */ = 'xot' (stringa garantita)
BaseModel::$connection           → /** @var string */ = 'activity' (stessa convenzione)
Activity/Snapshot/StoredEvent    → /** @var string */ = 'activity' (tutti allineati)
```

---

## Configurazione in database.php

La connessione `activity` deve esistere in `config/database.php` con fallback ai valori default:

```php
'activity' => [
    'driver' => 'mysql',
    'url' => env('DB_URL'),
    'host' => env('DB_HOST_ACTIVITY', env('DB_HOST', '127.0.0.1')),
    'port' => env('DB_PORT_ACTIVITY', env('DB_PORT', '3306')),
    'database' => env('DB_DATABASE_ACTIVITY', env('DB_DATABASE', 'laravel')),
    'username' => env('DB_USERNAME_ACTIVITY', env('DB_USERNAME', 'root')),
    'password' => env('DB_PASSWORD_ACTIVITY', env('DB_PASSWORD', '')),
    // ... parametri standard mysql
],
```

Il **doppio fallback** `env('DB_DATABASE_ACTIVITY', env('DB_DATABASE'))` è la chiave:
- **In testing**: nessun `DB_DATABASE_ACTIVITY` in `.env.testing` → usa `DB_DATABASE` → stesso DB fisico
- **In production**: se si vuole DB separato, aggiungere `DB_DATABASE_ACTIVITY` al `.env`

---

## .env.testing — NESSUNA variabile ACTIVITY

```bash
# ✅ CORRETTO — .env.testing
DB_DATABASE=<nome progetto>_data_test
DB_USERNAME=marco
DB_PASSWORD=marco
# NESSUNA DB_DATABASE_ACTIVITY, DB_USERNAME_ACTIVITY, DB_PASSWORD_ACTIVITY
```

Il fallback in `database.php` garantisce che la connessione `activity` usi automaticamente
`<nome progetto>_data_test` senza configurazione aggiuntiva nei test.

---

## TestCase — connectionsToTransact

Il `TestCase` del modulo Activity deve includere `'activity'` per il rollback automatico:

```php
protected $connectionsToTransact = [
    'mysql',
    'activity',
    'user',
];
```

---

## Anti-Pattern da evitare

```php
// ❌ SBAGLIATO — nullable quando non serve
/** @var string|null */
protected $connection = 'activity';

// ❌ SBAGLIATO — null annulla la connessione dedicata, usa mysql default
protected $connection = null;

// ❌ SBAGLIATO — nessuna connessione = eredita 'xot' da XotBaseModel
// (per modelli Activity NON è corretto usare la connessione 'xot')
```

---

## Lezione appresa

- La connessione `'activity'` deve **esistere in database.php** — senza di essa tutti i test falliscono
- Il fallback `env('DB_DATABASE_ACTIVITY', env('DB_DATABASE'))` permette testing senza DB separato
- Il pattern `user` (OAuth/Passport) e il pattern `activity` seguono la stessa logica: connessione named con fallback
- Doc correlata: `laravel/Modules/Activity/docs/database-connections.md`
