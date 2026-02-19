# Fix: Media TestCase - Database Connection Configuration

**Problema**: Test Media falliscono con QueryException per database connection 'media'
**Principio**: Il sito funziona, quindi il test deve riflettere il comportamento reale

## 🔍 Analisi del Problema

### Errore Originale
- Test Media falliscono con: `QueryException` e problemi di connessione database
- Il TestCase di Media aveva logica complessa che saltava i test se MySQL non configurato
- Il modello Media BaseModel usa esplicitamente `protected $connection = 'media'`

### Causa
- `Media/tests/TestCase.php` richiedeva MySQL da `.env.testing` e saltava i test se non presente
- Il modello Media BaseModel usa esplicitamente connection 'media'
- Il test non configurava le connessioni per SQLite in-memory

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
    $dbName = 'file:memdb_media_'.Str::random(10).'?mode=memory&cache=shared';

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
    $this->artisan('module:migrate', ['module' => 'Media', '--force' => true]);
}
```

### Cambiamenti Principali
1. **Rimossa logica complessa**: Eliminati `markTestSkipped` che richiedevano MySQL
2. **SQLite shared memory**: Usato pattern Activity/TestCase.php per coerenza
3. **Type check PHPStan**: Aggiunto `instanceof \PDO` per PHPStan L10
4. **Migrations esplicite**: Eseguiti migrate per Xot, User, Media

## 📝 Note

- Il sito funziona, quindi il test deve riflettere il comportamento reale
- Pattern unificato con Activity/TestCase.php per coerenza
- Rimossa dipendenza da MySQL in `.env.testing`
- Il modello Media BaseModel usa esplicitamente connection 'media', quindi deve essere configurata

## 🔗 Collegamenti

- [Testing Rules](testing-rules.md)
- [Activity TestCase Fix](../../activity/docs/testing-testcase-database-connection-fix.md)
- [Geo TestCase Fix](../../geo/docs/testing-testcase-database-connection-fix.md)

---

**Status**: Completed
**Risultato**: Test Media ora configurano correttamente le connessioni database senza dipendere da MySQL
