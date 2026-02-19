# Fix: Geo TestCase - Database Connection Configuration

**Problema**: Test Geo falliscono con InvalidArgumentException per database connection 'geo'
**Principio**: Il sito funziona, quindi il test deve riflettere il comportamento reale

## 🔍 Analisi del Problema

### Errore Originale
- Test Geo falliscono con: `InvalidArgumentException: Database connection [geo] not configured`
- Il TestCase di Geo non configura la connessione 'geo' prima di usarla
- Il modello Geo BaseModel usa esplicitamente `protected $connection = 'geo'`

### Causa
- `Geo/tests/TestCase.php` eseguiva solo `module:migrate` senza configurare le connessioni
- Il modello Geo BaseModel usa esplicitamente connection 'geo'
- Il test non configura tutte le connessioni necessarie

### Comportamento Reale
Il sito funziona perché:
- Le connessioni sono configurate nel database.php
- Il TestCase deve configurare le connessioni per i test

## 🛠️ Soluzione

### Pattern Corretto (come Activity/TestCase.php)
```php
protected function setUp(): void
{
    parent::setUp();

    // Il sito funziona, quindi i test devono riflettere il comportamento reale
    // Usiamo SQLite shared memory seguendo pattern Activity/TestCase.php
    $dbName = 'file:memdb_geo_'.Str::random(10).'?mode=memory&cache=shared';

    $connections = [
        'sqlite', 'mysql', 'mariadb', 'pgsql',
        'activity', 'cms', 'gdpr', 'geo', 'job', 'lang', 'media',
        'meetup', 'notify', 'seo', 'tenant', 'ui', 'user', 'xot',
    ];

    foreach ($connections as $conn) {
        $this->app['config']->set("database.connections.{$conn}.driver", 'sqlite');
        $this->app['config']->set("database.connections.{$conn}.database", $dbName);
    }

    foreach ($connections as $conn) {
        DB::purge($conn);
    }

    foreach ($connections as $conn) {
        try {
            $pdo = DB::connection($conn)->getPdo();
            if ($pdo instanceof \PDO && method_exists($pdo, 'sqliteCreateFunction')) {
                $pdo->sqliteCreateFunction('md5', static fn (?string $value): ?string => $value === null ? null : md5($value));
                $pdo->sqliteCreateFunction('unhex', static fn (?string $value): ?string => $value);
            }
        } catch (\Throwable) {
        }
    }

    $this->artisan('module:migrate', ['module' => 'Xot', '--force' => true]);
    $this->artisan('module:migrate', ['module' => 'User', '--force' => true]);
    $this->artisan('module:migrate', ['module' => 'Geo', '--force' => true]);
}
```

### Implementazione
1. Configurare tutte le connessioni mancanti usando SQLite shared memory
2. Seguire lo stesso pattern di Activity/TestCase.php per coerenza
3. Aggiungere type check `instanceof \PDO` per PHPStan L10
4. Eseguire migrate solo dopo aver configurato le connessioni

## 📝 Note

- Il sito funziona, quindi il test deve riflettere il comportamento reale
- Pattern unificato con Activity/TestCase.php per coerenza
- Configurazione connessioni prima di eseguire migrate è obbligatoria
- Il modello Geo BaseModel usa esplicitamente connection 'geo', quindi deve essere configurata
- Type check `instanceof \PDO` necessario per PHPStan L10

## 🔗 Collegamenti

- [Testing Rules](testing-rules.md)
- [Activity TestCase Fix](../../activity/docs/testing-testcase-database-connection-fix.md)
- [User TestCase](../../User/tests/TestCase.php)

---

**Status**: Completed
**Risultato**: Test Geo ora configurano correttamente le connessioni database
