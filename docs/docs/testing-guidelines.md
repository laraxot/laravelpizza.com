# Laraxot Testing Religion: La Via della Super Mucca 🐄✨

## 🧘‍♂️ La Visione (The Vision)
In Laraxot, il testing non è un accessorio, è il **Cuore della Robustezza**. Seguiamo lo Zen: codice semplice, test potenti, verità assoluta. Se il sito funziona, i test devono riflettere questa realtà. Se i test falliscono e il sito funziona, i test sono eretici e vanno purificati (sistemati o eliminati).

## 📜 Le Leggi Inviolabili (The Laws)

### 1. XotBaseTestCase: L'Unica Fonte
Tutti i `TestCase.php` nei moduli (`Modules/*/tests/TestCase.php`) DEVONO estendere:
`Modules\Xot\Tests\XotBaseTestCase`

Questo garantisce:
- **Bootstrap Unificato**: Caricamento corretto di `.env.testing`.
- **Iniezione Automatica**: Mapping dinamico delle connessioni database via `TenantServiceProvider`.
- **DRY**: Niente duplicazione di `CreatesApplication`.

### 2. MySQL Only: La Fine di SQLite
**MAI** usare SQLite (`:memory:`) per i test. La parità con la produzione è sacra.
- Usiamo MySQL con il database `_test` (es. `laravelpizza_data_test`).
- Configurazione in `.env.testing`.

### 3. No RefreshDatabase: La Velocità è Virtù
Il trait `RefreshDatabase` è **VIETATO**.
- Rallenta i test inutilmente.
- Infrange l'integrità dei dati persistenti necessari per alcuni test cross-modulo.
- **La Via**: Usa `DatabaseTransactions` per i test che necessitano di isolamento, oppure gestisci lo stato nel `setUp()`.

### 4. Pest Mandatory: Il Futuro è Fluente
Tutti i test devono essere scritti in **Pest**.
- Se trovi test in PHPUnit (class-based), convertili immediatamente.
- Usa le aspettative fluenti: `expect($value)->toBe($expected)`.

## 🛠️ Workflow Operativo (The Way)

### 1. Migrazioni Eseguite una Volta Sola
Esegui le migrazioni esternamente prima di lanciare la suite di test:
```bash
php artisan migrate --env=testing
```
Nessun controllo `if (! self::$migrated)` dentro i `TestCase`. Pulizia e semplicità.

### 2. Esecuzione Mirata
Non aver paura di eliminare test "allucinati" (AI-generated) che non corrispondono alla realtà dei modelli.
```bash
# Esegui i test di un modulo
./vendor/bin/pest Modules/Geo/tests
```

### 3. Coverage al 100%
Puntiamo al 100% di coverage, ma con pragmatismo. Un test che testa il nulla è peggio di nessun test.

## 🏛️ Esempio di TestCase Modulare (Il Pattern)

```php
namespace Modules\MyModule\Tests;

use Modules\Xot\Tests\XotBaseTestCase;
use Modules\MyModule\Providers\MyModuleServiceProvider;

abstract class TestCase extends XotBaseTestCase
{
    protected function getPackageProviders($app): array
    {
        return [
            ...parent::getPackageProviders($app),
            MyModuleServiceProvider::class,
        ];
    }
}
```

## 🏗️ Esempio di Pest.php (Il Bootstrap)

```php
use Modules\MyModule\Tests\TestCase;

uses(TestCase::class)->in(__DIR__);
```

---
**Ricorda**: La Super Mucca non ha paura di cancellare codice morto. La verità è nel sito che funziona. 🙏✨
