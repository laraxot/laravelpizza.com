# Anti-Pattern: Environment-Specific Logic in Models

## Il Problema

```php
// ❌ ERRATO - MAI FARE QUESTO
class Activity extends Model
{
    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
        
        // HACK: Anti-pattern!
        if (app()->environment('testing')) {
            $this->connection = config('database.default');
        }
    }
}
```

## Perché è una Cagata

1. **Violazione Single Responsibility Principle**
   - Il modello gestisce dati, non configurazione ambientale
   - Mescola logica di business con logica di deployment

2. **Mascheramento del Problema Reale**
   - Il problema è la configurazione DB di test, non il modello
   - Invece di fixare `.env.testing` o `TestCase`, si bypassa
   - Il debito tecnico rimane nascosto

3. **Comportamento Implicito e Pericoloso**
   - Non è ovvio leggendo il codice
   - Può causare bug subdoli in produzione
   - Difficile da debuggare quando fallisce

4. **Accoppiamento Indesiderato**
   - Il modello dipende dall'ambiente
   - Non è più riutilizzabile in contesti diversi
   - Testing diventa più difficile, non più facile

## Soluzione Corretta

### Opzione 1: Configurazione TestCase (Consigliata)

```php
// ✅ CORRETTO
class TestCase extends XotBaseTestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        
        // Configura DB per test
        config(['database.connections.activity' => [
            'driver' => 'mysql',
            'database' => 'test_db',
            // ...
        ]]);
    }
}
```

### Opzione 2: phpunit.xml Configuration

```xml
<!-- ✅ CORRETTO -->
<phpunit>
    <php>
        <env name="DB_CONNECTION" value="mysql"/>

        <env name="DB_DATABASE" value="<nome progetto>_test"/>

        <env name="DB_DATABASE" value="laravelpizza_test"/>

        <env name="DB_DATABASE" value="<nome progetto>_test"/>

        <env name="DB_DATABASE" value="laravelpizza_test"/>

        <env name="DB_DATABASE" value="<nome progetto>_test"/>

        <env name="DB_DATABASE" value="laravelpizza_test"/>

        <env name="DB_DATABASE" value="<nome progetto>_test"/>

        <env name="DB_DATABASE" value="<nome progetto>_test"/>
        
        <env name="DB_DATABASE" value="<nome progetto>_test"/>

        <env name="DB_DATABASE" value="laravelpizza_test"/>

        <env name="DB_DATABASE" value="<nome progetto>_test"/>

    </php>
</phpunit>
```

### Opzione 3: TenantServiceProvider per Test

```php
// ✅ CORRETTO - Configurazione dinamica nel provider
class TenantServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        if ($this->app->environment('testing')) {
            // Clona connessione di default per tenant
            $this->cloneDefaultConnectionForTesting();
        }
    }
}
```

## Zen del Testing

> "Se il test richiede un hack nel modello, il test sbagliato non è."

La filosofia DRY + KISS + Laraxot richiede:
- Configurazione esplicita, non implicita
- Separazione chiara tra codice e configurazione
- Nessun accoppiamento tra modelli e ambiente

## Collegamenti

- [Testing Strategy](./testing-strategy.md)
- [XotBaseTestCase Rule](./xotbasetestcase-rule.md)
