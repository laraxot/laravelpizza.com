# Testing

## Struttura dei Test

### Unit Tests
- Test per singole unita di codice
- Focus su Actions e Data Objects
- Isolamento dalle dipendenze

### Feature Tests
- Test end-to-end
- Verifica flussi completi
- Integrazione tra componenti

### Browser Tests
- Test dell'interfaccia utente con Pest 4 Browser Testing
- Verifica interazioni utente
- Compatibilita browser

## TestCase Pattern (CANONICO)

Ogni modulo DEVE avere un `tests/TestCase.php` che segue questo pattern esatto:

```php
<?php

declare(strict_types=1);

namespace Modules\{Module}\Tests;

use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Modules\{Module}\Providers\{Module}ServiceProvider;
use Modules\User\Providers\UserServiceProvider;
use Modules\Xot\Providers\XotServiceProvider;
use Modules\Xot\Tests\CreatesApplication;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;
    use DatabaseTransactions;

    /** @var array<int, string> */
    protected $connectionsToTransact = [
        'mysql',
        '{module_snake}',  // DEVE corrispondere a $connection nei Model del modulo
        'user',
    ];

    /** @return array<int, class-string> */
    protected function getPackageProviders($app): array
    {
        return [
            XotServiceProvider::class,
            UserServiceProvider::class,
            {Module}ServiceProvider::class,
        ];
    }
}
```

### Regole CRITICHE

1. **SEMPRE `DatabaseTransactions`** - MAI `RefreshDatabase` (rompe architettura multi-connessione)
2. **MAI SQLite per i test** - il progetto usa MySQL, SQLite da falsi positivi
3. **MAI migrazioni in setUp()** - no `migrate:fresh`, no `module:migrate`, no flag `$migrated`
4. **MAI override config in setUp()** - no `config(['xra.pub_theme' => ...])`, no `XotData::make()->update()`
5. **`$connectionsToTransact` DEVE includere la connessione del modulo** (es. `'activity'` per Activity)
6. **Usare `Modules\Xot\Tests\CreatesApplication`** - MAI `Tests\CreatesApplication` del root

### Come Funzionano le Migrazioni per i Test

Le migrazioni si eseguono UNA VOLTA esternamente:
```bash
php artisan migrate --env=testing
```
- Crea tutte le tabelle nei database `_test`
- `DatabaseTransactions` gestisce BEGIN/ROLLBACK automaticamente tra i test
- Nessuna logica di migrazione nel TestCase

### .env.testing

Deve essere una copia carbone di `.env` con SOLO i nomi DB suffissati `_test`:
- `DB_CONNECTION=mysql` (MAI sqlite)
- `DB_HOST=` stesso di .env
- `DB_DATABASE=ptv_lara_test`
- `DB_DATABASE_USER=ptv_user_test`
- Stesse credenziali, stesse porte, tutto il resto identico

### $connectionsToTransact - Perche e Fondamentale

Ogni modulo ha i Model con `protected $connection = '<snake_name>'`:
- Activity: `$connection = 'activity'`
- User: `$connection = 'user'`
- Notify: `$connection = 'notify'`

`DatabaseTransactions` wrappa in transazione SOLO le connessioni elencate.
Se la connessione del modulo NON e nella lista, i dati di test NON vengono rollbackati.

TenantServiceProvider crea dinamicamente le connessioni dei moduli copiando la config `mysql`.

## Testing QueueableActions

```php
declare(strict_types=1);

class UpdatePerformanceActionTest extends TestCase
{
    /** @test */
    public function it_updates_performance_synchronously(): void
    {
        // Arrange
        $performance = Performance::factory()->create([
            'punteggio' => 80,
        ]);

        $data = new PerformanceData(
            nome: $performance->nome,
            punteggio: 90,
            data_valutazione: now(),
        );

        // Act
        $result = app(UpdatePerformanceAction::class)->execute($data);

        // Assert
        $this->assertEquals(90, $result->punteggio);
        $this->assertDatabaseHas('performances', [
            'id' => $performance->id,
            'punteggio' => 90,
        ]);
    }

    /** @test */
    public function it_handles_queued_execution(): void
    {
        Queue::fake();

        $data = new PerformanceData(
            nome: 'Test Performance',
            punteggio: 85,
            data_valutazione: now(),
        );

        app(UpdatePerformanceAction::class)->onQueue()->execute($data);

        Queue::assertPushed(function (CallQueuedAction $job) use ($data) {
            return $job->action instanceof UpdatePerformanceAction
                && $job->parameters[0] instanceof PerformanceData
                && $job->parameters[0]->punteggio === $data->punteggio;
        });
    }
}
```

## Best Practices

### Naming
- Un test per ogni caso d'uso
- Nomi descrittivi: `it_creates_a_user_with_valid_data`
- Pattern Arrange/Act/Assert

### Organizzazione
```
tests/
├── TestCase.php
├── Pest.php
├── Unit/
│   ├── Actions/
│   ├── Data/
│   └── Models/
├── Feature/
│   ├── Api/
│   ├── Web/
│   └── Filament/
└── Browser/
    └── Pages/
```

### Coverage
- Copertura del codice > 80%
- Focus sui componenti critici (Actions, Models)
- Test di edge cases e scenari di errore

### Mock e Stub
```php
public function test_external_service_integration(): void
{
    $this->mock(ExternalService::class, function ($mock) {
        $mock->shouldReceive('fetch')
             ->once()
             ->andReturn(['data' => 'response']);
    });
}
```

---

**Related**: [Conventions](conventions.md) | [Architecture](../architecture.md)
