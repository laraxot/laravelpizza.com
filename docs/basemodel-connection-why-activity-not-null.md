# BaseModel Activity: Perché $connection = 'activity' e NON null

## Risposta diretta

**NO, non è corretto avere `protected $connection = null` nel BaseModel del modulo Activity.**

Il BaseModel deve avere `protected $connection = 'activity'`.

## Ragionamento

### 1. Architettura TenantServiceProvider

TenantServiceProvider crea a runtime una connessione per ogni modulo attivo. Per il modulo Activity, `getSnakeName()` restituisce `'activity'`, quindi la connessione si chiama `'activity'`. La connessione punta allo stesso DB del default (o a `DB_DATABASE_ACTIVITY` se configurato).

### 2. Cosa significa $connection = null

In Eloquent, `$connection = null` significa: **usa la connessione default** (`config('database.default')` = `'mysql'`).

### 3. Cosa significa $connection = 'activity'

Usa la connessione dedicata creata da TenantServiceProvider per il modulo Activity.

### 4. Perché il modulo Activity deve usare 'activity'

- **DatabaseTransactions**: il TestCase ha `$connectionsToTransact = ['mysql', 'activity', 'user']`. Se i modelli usassero `null` (mysql), i dati Activity andrebbero su mysql. Ma Activity, Snapshot, StoredEvent devono usare la connessione `'activity'` per coerenza e per permettere il rollback corretto.
- **Coerenza**: Activity, Snapshot, StoredEvent hanno tutti `$connection = 'activity'`. BaseModel è la base astratta del modulo: i modelli che lo estendono (TestActivityModel, eventuali modelli custom futuri) devono ereditare la stessa connessione.
- **Multi-tenant**: con `DB_DATABASE_ACTIVITY` in .env si può separare il database degli eventi. Con `null` si perderebbe questa possibilità.

### 5. Se BaseModel avesse $connection = null

- I modelli che estendono BaseModel userebbero mysql
- Inconsistenza: Activity, Snapshot, StoredEvent usano `'activity'`, altri modelli del modulo userebbero mysql
- I test BaseModelTest e BaseModelBusinessLogicTest fallirebbero (aspettano `getConnectionName() === 'activity'`)

## Conclusione

```php
// ✅ CORRETTO
/** @var string */
protected $connection = 'activity';

// ❌ ERRATO - non usare null
protected $connection = null;
```

## Collegamenti

- [fix01](prompts/fix01.txt)
- [database-connections](database-connections.md)
- [testing-testcase-database-connection-fix](testing-testcase-database-connection-fix.md)
