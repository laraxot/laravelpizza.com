# XotBaseTestCase: La Nostra Religione del Testing (Laraxot Zen)

## 🧘‍♂️ La Visione e la Filosofia
In Laraxot, il testing non è un obbligo burocratico, ma una disciplina spirituale che garantisce la **Robustezza** e la **Pace Mentale**. La nostra "religione" si basa su tre pilastri:
1. **DRY (Don't Repeat Yourself)**: Un solo bootstrap per dominarli tutti.
2. **KISS (Keep It Simple, Stupid)**: Test chiari, lineari, senza over-engineering.
3. **SOLID**: Ogni test ha una responsabilità chiara.

## 🐄 Regola d'Oro (Super Mucca)
Tutti i file `Modules/*/tests/TestCase.php` DEVONO estendere:
```php
Modules\Xot\Tests\XotBaseTestCase
```

## 📜 Lo Zen del TestCase
Estendere `XotBaseTestCase` significa abbracciare un setup unificato che:
- **Bootstrap Consistente**: Usa `CreatesApplication` per caricare `.env.testing` e mappare le connessioni database in modo dinamico via `TenantServiceProvider`.
- **MySQL Only**: In Laraxot testiamo contro MySQL (non SQLite) per garantire parità assoluta con la produzione.
- **No RefreshDatabase**: Il trait `RefreshDatabase` è **ERETICO**. Usiamo `DatabaseTransactions` o migrazioni mirate nel `setUp()` per mantenere la velocità senza sacrificare l'integrità.
- **Helper Comuni**: Accesso immediato a traduttori, configurazioni Xot e factory di utenti tramite `XotData`.

## 🚨 Regola Assoluta: MAI `migrate:fresh` nei Test

`migrate:fresh` **distrugge TUTTE le tabelle** del database condiviso, causando fallimenti a cascata in tutti i moduli. È **PROIBITO** nei test.

```php
// 🚫 ERESIA ASSOLUTA - distrugge il DB per tutti
$this->artisan('migrate:fresh', ['--force' => true]);

// ✅ CORRETTO - XotBaseTestCase gestisce automaticamente:
//    1. Creazione database se non esiste (ensureTestDatabasesExist)
//    2. Migrazioni automatiche (module:migrate --env=testing)
//    Una sola volta per processo di test
```

## 🔄 Sistema Automatico di Database e Migrazioni

XotBaseTestCase ora gestisce automaticamente:

1. **Creazione Database di Test**:
   - Legge le variabili env (DB_DATABASE, DB_DATABASE_USER, DB_DATABASE_ACTIVITY)
   - Crea i database automaticamente se non esistono
   - Eseguita PRIMA di migrate per evitare errori "Unknown database"

2. **Migrazioni Automatiche**:
   - Esegue `module:migrate` per i moduli: Xot, User, Activity
   - Usa `--env=testing` per usare .env.testing
   - Eseguita UNA SOLA VOLTA per processo di test

3. **Isolamento Test**:
   - Usa `DatabaseTransactions` per rollback automatico dopo ogni test
   - Ogni test è indipendente e idempotente

Se un test chiama `migrate:fresh`, marcalo immediatamente con:
```php
$this->markTestSkipped('migrate:fresh è distruttivo per il DB condiviso - eseguire migrazioni esternamente.');
```

## ❌ L'Anti-pattern (L'Eresia)
Evita di estendere direttamente le classi del framework:
```php
// 🚫 ERESIA: Disaccoppiato dalla visione Laraxot
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
}
```

## ✅ Il Pattern Corretto (La Via)
```php
// 🙏 LA VIA: Allineato alla filosofia Laraxot
use Modules\Xot\Tests\XotBaseTestCase;

abstract class TestCase extends XotBaseTestCase
{
    /**
     * @return array<int, class-string<\Illuminate\Support\ServiceProvider>>
     */
    protected function getPackageProviders($app): array
    {
        return [
            ...parent::getPackageProviders($app),
            MyModuleServiceProvider::class,
        ];
    }
}
```

## 🚀 Verso il 100% di Coverage
Se un test fallisce, hai due strade maestre:
1. **Sistemalo**: Se la logica è corretta ma il test è obsoleto o mal configurato.
2. **Eliminalo**: Se il test è ridondante, inutile o non riflette più la realtà funzionale del sito che **FUNZIONA**.

Il nostro obiettivo è il 100% di coverage, ma sempre con pragmatismo: il sito che funziona è la nostra verità ultima.
