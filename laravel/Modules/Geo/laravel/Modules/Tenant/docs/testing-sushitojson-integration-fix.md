# Fix: SushiToJsonIntegrationTest - Database Connection Configuration

**Problema**: Test fallisce con "Database connection [tenant] not configured"
**Principio**: Il sito funziona, quindi il test deve essere corretto per riflettere il comportamento reale

## 🔍 Analisi del Problema

### Errore Originale
```
InvalidArgumentException: Database connection [tenant] not configured.
```

### Causa
- Il modello `Tenant` estende `BaseModel` che ha `protected $connection = 'tenant'`
- Il test `SushiToJsonIntegrationTest` non configura la connessione 'tenant' nel setUp()
- Il test estende `Tests\TestCase` che non configura automaticamente la connessione 'tenant'

### Confronto con Test Funzionanti
- `TenantBusinessLogicTest` funziona e usa `Tenant::factory()->create()`
- `TenantBusinessLogicTest` estende `Tests\TestCase` (stesso del test fallito)
- Differenza: probabilmente le migrazioni vengono eseguite sulla connessione default, non su 'tenant'

## 🛠️ Soluzione

### Pattern Corretto (da User\Tests\TestCase)
```php
// Configure all connections including tenant
$dbName = ':memory:';
$connections = ['sqlite', 'user', 'xot', 'activity', 'tenant', ...];

foreach ($connections as $conn) {
    $this->app['config']->set("database.connections.{$conn}.database", $dbName);
    $this->app['config']->set("database.connections.{$conn}.driver", 'sqlite');
}

// Run migrations
$this->artisan('module:migrate', ['module' => 'Tenant', '--force' => true]);
```

### Implementazione nel Test
1. Configurare connessione 'tenant' nel setUp()
2. Eseguire migrazioni per il modulo Tenant
3. Verificare che le migrazioni creino la tabella 'tenants' sulla connessione 'tenant'

## 📝 Note

- Il modello `Tenant` usa connessione 'tenant' (da `BaseModel`)
- Le migrazioni devono essere eseguite sulla connessione corretta
- Il TestCase base non configura automaticamente tutte le connessioni

## 🔗 Collegamenti

- [Testing Rules](testing-rules.md)
- [User TestCase](../../User/tests/TestCase.php) - Esempio di configurazione corretta
- [TenantBusinessLogicTest](../Tests/Feature/TenantBusinessLogicTest.php) - Test funzionante

---

**Status**: In Progress
**Prossimo step**: Implementare configurazione connessione seguendo pattern User TestCase

## ✅ Soluzione Implementata

### Pattern Corretto
```php
// Configure all connections (following User TestCase pattern)
$connections = ['sqlite', 'tenant', 'user', 'xot'];
foreach ($connections as $conn) {
    $this->app['config']->set("database.connections.{$conn}", [
        'driver' => 'sqlite',
        'database' => ':memory:',
        'prefix' => '',
    ]);
}

// Purge connections
foreach ($connections as $conn) {
    DB::purge($conn);
}

// Run migrations
$this->artisan('module:migrate', ['module' => 'Tenant', '--force' => true]);
```

### Problema Attuale
- Errore: "no such table: tenants (Connection: tenant)"
- Le migrazioni vengono eseguite sulla connessione default
- SQLite :memory: crea database separati per ogni connessione
- Soluzione tentata: database condiviso `file:memdb_...?mode=memory&cache=shared`
- **Status**: Ancora in corso di risoluzione - test fallisce con QueryException

### Note
- Il sito funziona, quindi il test deve riflettere il comportamento reale
- Potrebbe essere necessario verificare dove sono le migrazioni del modulo Tenant
- Oppure verificare se il modello Tenant può usare la connessione default durante i test

## 🔍 Scoperta Chiave

### Problema Root Cause
- La migrazione `create_tenants_table` è nel modulo **User**, non Tenant
- La migrazione usa `Modules\User\Models\Tenant` che ha connessione **'user'**
- Il test usa `Modules\Tenant\Models\Tenant` che ha connessione **'tenant'**
- `XotBaseMigration::getConn()` usa `Schema::connection($this->model->getConnectionName())`
- Quindi la migrazione crea la tabella sulla connessione **'user'**, non **'tenant'**

### Tentativi di Soluzione
1. ✅ Configurato database condiviso SQLite (`file:memdb_...?mode=memory&cache=shared`)
2. ✅ Configurate tutte le connessioni (sqlite, tenant, user, xot)
3. ✅ Eseguite migrazioni User e Tenant
4. ❌ Creazione manuale tabella su connessione 'tenant' - ancora fallisce

### Status Attuale
- **Errore**: "no such table: tenants (Connection: tenant)"
- **Causa**: SQLite non condivide tabelle tra connessioni diverse, anche con `cache=shared`
- **Soluzione necessaria**: Usare la stessa connessione per migrazione e modello, oppure copiare i dati tra connessioni

### Prossimi Step
1. Verificare se il modello `Modules\Tenant\Models\Tenant` può usare connessione 'user' durante i test
2. Oppure modificare la migrazione per creare la tabella anche sulla connessione 'tenant'
3. Oppure usare un approccio diverso per i test (es: usare `Modules\User\Models\Tenant` nel test)
