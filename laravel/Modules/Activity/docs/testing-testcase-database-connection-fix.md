# Fix: Activity TestCase - Database Connection Configuration

**Data**: 2025-01-22
**Problema**: Test Activity falliscono con "Database connection [activity] not configured"
**Principio**: Il sito funziona, quindi il test deve riflettere il comportamento reale

## 🔍 Analisi del Problema

### Errore Originale
- Test Activity falliscono con: `InvalidArgumentException: Database connection [activity] not configured`
- Il TestCase di Activity tenta di eseguire migrate con `--database => 'activity'`
- La connessione 'activity' non è configurata nel setUp()

### Causa
- `Activity/tests/TestCase.php` non configura la connessione 'activity' prima di eseguire migrate
- Il modello Activity usa esplicitamente `protected $connection = 'activity'`
- Il test non configura tutte le connessioni necessarie come fa User/tests/TestCase.php

### Comportamento Reale
Il sito funziona perché:
- Le connessioni sono configurate nel database.php
- Il TestCase deve configurare le connessioni per i test

## 🛠️ Soluzione

### Pattern Corretto (come User/TestCase.php)
```php
protected function setUp(): void
{
    parent::setUp();

    // Configure missing connections for testing by aliasing them to the main test connection
    // Il sito funziona, quindi i test devono riflettere il comportamento reale
    $defaultConnection = config('database.default');
    $defaultConfig = config("database.connections.{$defaultConnection}");

    $modules = [
        'activity', 'cms', 'gdpr', 'geo', 'job', 'lang', 'media', 'meetup',
        'notify', 'seo', 'tenant', 'ui', 'user', 'xot',
    ];

    foreach ($modules as $module) {
        config(["database.connections.{$module}" => $defaultConfig]);
    }

    $this->app->bind(EventSubscriber::class, function (): EventSubscriber {
        return new EventSubscriber(EloquentStoredEventRepository::class);
    });

    $this->artisan('migrate', ['--database' => 'activity']);
    $this->artisan('migrate', ['--database' => 'user']);
    $this->artisan('migrate', ['--database' => 'xot']);
}
```

### Implementazione
1. Configurare tutte le connessioni mancanti aliasing alla connessione default
2. Seguire lo stesso pattern di User/tests/TestCase.php per coerenza
3. Mantenere il binding di EventSubscriber per event sourcing
4. Eseguire migrate solo dopo aver configurato le connessioni

## 📝 Note

- Il sito funziona, quindi il test deve riflettere il comportamento reale
- Pattern unificato con User/tests/TestCase.php per coerenza
- Configurazione connessioni prima di eseguire migrate è obbligatoria
- Il modello Activity usa esplicitamente connection 'activity', quindi deve essere configurata

## 🔗 Collegamenti

- [Testing Rules](../testing-rules.md)
- [TestCase SQLite to MySQL Fix](testcase-sqlite-to-mysql-fix.md)
- [User TestCase](../../User/tests/TestCase.php)

---

**Status**: Completed
**Risultato**: Test Activity ora configurano correttamente le connessioni database
