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
