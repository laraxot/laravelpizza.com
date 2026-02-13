# 🚨 DATABASE TESTING RULE - MySQL con Suffisso "_test"

## 📋 Regola Fondamentale

**ASSOLUTAMENTE MAI usare SQLite o database in-memory per i test in questo progetto.**

**USARE SEMPRE MySQL con suffisso "_test":**
- `DB_CONNECTION=mysql` ✅
- `DB_DATABASE=quaeris_data_test` ✅  
- `DB_DATABASE_LIMESURVEY=quaeris_survey_test` ✅
- `DB_DATABASE_USER=quaeris_user_test` ✅

## 🚫 MAI USARE

- ❌ SQLite (`:memory:`)
- ❌ Database senza suffisso `_test`
- ❌ Database di produzione (senza `_test`)
- ❌ Connessioni database inventate per moduli specifici (es. `NOTIFY_DB_DATABASE`)

 Il progetto usa un'architettura multi-database per garantire isolamento e scalabilità:
- `DB_DATABASE`: Database principale per i dati applicativi.
- `DB_DATABASE_USER`: Database centralizzato per la gestione utenti e profili (Modulo User).
- `DB_DATABASE_LIMESURVEY`: Database dedicato ai dati di LimeSurvey (Modulo Limesurvey).

Le connessioni vengono registrate dinamicamente da `TenantServiceProvider::registerDB()`, mantenendo `config/database.php` standard e pulito, **senza definizioni di connessioni specifiche per i moduli** (es. `notify`, `geo`, `media`, `job`, `xot`, `activity`, `cms`, `gdpr`, `lang`, `meetup`, `seo`, `tenant`).

## 🔧 Pattern XotData nei Test

**USARE SEMPRE XotData::make() pattern nei test:**

```php
// ❌ SBAGLIATO
$user = new User();
$profile = new Profile();

// ✅ CORRETTO
$userClass = XotData::make()->getUserClass();
$profileClass = XotData::make()->getProfileClass();
$user = new $userClass();
$profile = new $profileClass();
```

## 🔧 Test Migration Strategy (XotBaseTestCase)

In `Modules/Xot/tests/TestCase.php` (or any `TestCase.php` extending it), the `setUp()` method **DEVE** seguire queste regole:

1.  **Unica esecuzione `migrate`**: La migrazione deve essere eseguita **UNA SOLA VOLTA** all'inizio della test suite.
2.  **NO `--force`**: L'opzione `--force` **NON DEVE ESSERE UTILIZZATA** con `php artisan migrate`.
3.  **NO `if (! self::$migrated)`**: Il controllo condizionale `if (! self::$migrated)` e la flag `$migrated` **NON DEVONO ESSERE PRESENTI**.

```php
// Modules/Xot/tests/TestCase.php (Esempio Corretto)
abstract class TestCase extends BaseTestCase
{
    use DatabaseTransactions; // O RefreshDatabase se strettamente necessario e gestito correttamente

    protected function setUp(): void
    {
        parent::setUp();
        $this->artisan('migrate'); // Esegue tutte le migrazioni (app + moduli) una sola volta
    }
}
```

## ⚡ Vantaggi dell'Approccio Corretto (Updated)

1.  **Isolamento Test**: Database separati con suffisso `_test`
2.  **Compatibilità**: Stesso dialetto SQL (MySQL) della produzione
3.  **Struttura Multi-DB**: Supporta l'architettura modulare
4.  **Stabilità**: Evita problemi di locking di SQLite
5.  **Performance**: MySQL è più performante per test complessi
6.  **Realismo**: Test simili all'ambiente di produzione
7.  **Semplicità**: Unica chiamata `migrate` in `TestCase.php` senza logica complessa

## 🎯 Checklist per Nuovi Test



Prima di creare un nuovo test, verificare:



- [ ] `TestCase.php` segue la strategia di migrazione corretta (single `migrate`, no `--force`, no `if (! self::$migrated)`).

- [ ] `.env.testing` usa MySQL con suffisso `_test` per il `DB_DATABASE` principale e **non contiene connessioni database inventate per moduli specifici**.

- [ ] Nessuna connessione database è forzata (`config(['database.connections.notify' => ...])`) in `CreatesApplication` o `TestCase`.

- [ ] Usare `XotData::make()->getUserClass()` invece di `new User()`

- [ ] Usare `XotData::make()->getProfileClass()` invece di `new Profile()`

- [ ] Migrare tutti i database necessari (gestito dalla singola chiamata `migrate`)

- [ ] Pulire dati dopo il test (`tearDown()` se necessario, o affidarsi a `DatabaseTransactions`)

## 🔥 Perché SQLite è Proibito

1. **Incompatibilità SQL**: SQLite ha limitazioni (no foreign key constraints, types diversi)
2. **Problemi di Locking**: Database locking in file system
3. **Performance Scarsa**: Lento per test con molti dati
4. **Diff Dialect**: Comportamento diverso da MySQL (produzione)
5. **Complex Queries**: Mancano funzionalità avanzate di MySQL

## 📚 Documentazione Correlata

- [Test Configuration](../configuration.md)
- [XotData Pattern](../contracts.md)
- [Module Testing](../testing.md)
- [Database Guidelines](./database-guidelines.md)

---

**FIRMATO**: Questa regola è FONDAMENTALE per la stabilità dei test del progetto.