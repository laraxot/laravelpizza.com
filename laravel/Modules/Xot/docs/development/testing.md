# Testing

## Struttura dei Test

### Unit Tests
- Test per singole unità di codice
- Focus su Actions e Data Objects
- Isolamento dalle dipendenze

### Testing QueueableActions
```php
declare(strict_types=1);

class UpdatePerformanceActionTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_updates_performance_synchronously(): void
    {
        // Arrange
        $performance = Performance::factory()->create([
            'punteggio' => 80
        ]);
        
        $data = new PerformanceData(
            nome: $performance->nome,
            punteggio: 90,
            data_valutazione: now()
        );

        // Act
        $action = app(UpdatePerformanceAction::class);
        $result = $action->execute($data);

        // Assert
        $this->assertEquals(90, $result->punteggio);
        $this->assertDatabaseHas('performances', [
            'id' => $performance->id,
            'punteggio' => 90
        ]);
    }

    /** @test */
    public function it_handles_queued_execution(): void
    {
        // Arrange
        Queue::fake();
        
        $data = new PerformanceData(
            nome: 'Test Performance',
            punteggio: 85,
            data_valutazione: now()
        );

        // Act
        $action = app(UpdatePerformanceAction::class);
        $action->onQueue()->execute($data);

        // Assert
        Queue::assertPushed(function (CallQueuedAction $job) use ($data) {
            return $job->action instanceof UpdatePerformanceAction
                && $job->parameters[0] instanceof PerformanceData
                && $job->parameters[0]->punteggio === $data->punteggio;
        });
    }

    /** @test */
    public function it_handles_action_failure(): void
    {
        // Arrange
        $this->expectException(ValidationException::class);
        
        $data = new PerformanceData(
            nome: 'Test Performance',
            punteggio: 101, // Oltre il massimo consentito
            data_valutazione: now()
        );

        // Act
        $action = app(UpdatePerformanceAction::class);
        $action->execute($data);
    }

    /** @test */
    public function it_respects_database_transaction(): void
    {
        // Arrange
        $performance = Performance::factory()->create();
        
        $data = new PerformanceData(
            nome: $performance->nome,
            punteggio: 95,
            data_valutazione: now()
        );

        // Act
        DB::transaction(function () use ($data, $performance) {
            $action = app(UpdatePerformanceAction::class);
            $action->execute($data);
            
            throw new Exception('Rollback test');
        });

        // Assert
        $this->assertDatabaseHas('performances', [
            'id' => $performance->id,
            'punteggio' => $performance->punteggio // Valore originale
        ]);
    }
}
```

### Best Practices per Testing QueueableActions

1. **Test Sincroni e Asincroni**
   - Testare sia l'esecuzione diretta che in coda
   - Verificare il corretto dispatching delle job
   - Controllare la gestione delle code

2. **Gestione delle Dipendenze**
   - Utilizzare dependency injection nei test
   - Mock delle dipendenze esterne
   - Isolamento del codice testato

3. **Validazione Input**
   - Test con dati validi e invalidi
   - Verifica delle regole di validazione
   - Test dei messaggi di errore

4. **Transazioni Database**
   - Test del comportamento transazionale
   - Verifica dei rollback
   - Controllo dell'integrità dei dati

5. **Eventi e Listeners**
   - Test della dispatch degli eventi
   - Verifica della gestione degli eventi
   - Controllo dei side effects

6. **Performance**
   - Test dei tempi di esecuzione
   - Verifica del consumo di memoria
   - Ottimizzazione delle query

7. **Retry e Fallimenti**
   - Test della logica di retry
   - Gestione degli errori
   - Logging appropriato

### Feature Tests
- Test end-to-end
- Verifica flussi completi
- Integrazione tra componenti

### Browser Tests
- Test dell'interfaccia utente
- Verifica interazioni utente
- Compatibilità browser

## Best Practices

### Naming
```php
class CreateUserActionTest extends TestCase
{
    /** @test */
    public function it_creates_a_user_with_valid_data(): void
    {
        // Arrange
        $userData = UserData::from([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);

        // Act
        $action = app(CreateUserAction::class);
        $user = $action->execute($userData);

        // Assert
        $this->assertDatabaseHas('users', [
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);
    }
}
```

### Data Factory
```php
class UserFactory extends Factory
{
    protected $model = User::class;

    public function definition(): array
    {
        return [
            'name' => fake()->name(),
            'email' => fake()->unique()->safeEmail(),
            'password' => Hash::make('password'),
        ];
    }
}
```

### Assertions
- Utilizzare assertions specifiche e descrittive
- Verificare lo stato del database dopo ogni operazione
- Controllare le risposte HTTP e i loro status code
- Validare la struttura dei dati restituiti

### Coverage
- Mantenere una copertura del codice > 80%
- Focus sui componenti critici
- Test di edge cases e scenari di errore

### Organizzazione
```
tests/
├── Unit/
│   ├── Actions/
│   ├── Data/
│   └── Services/
├── Feature/
│   ├── Api/
│   ├── Web/
│   └── Console/
└── Browser/
    └── Pages/
```

### Test Database
- Utilizzare SQLite in memory per i test
- Refresh del database tra i test
- Seeders specifici per i test

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

### Continuous Integration
- Eseguire i test ad ogni commit
- Verificare la copertura del codice
- Generare report di test

### Best Practices Specifiche
1. Un test per ogni caso d'uso
2. Test indipendenti tra loro
3. Nomi descrittivi dei test
4. Setup minimo necessario
5. Evitare logica condizionale nei test

### Debugging
- Utilizzare dump() e dd() per debug
- Laravel Dusk per debug visuale
- Log dettagliati in caso di fallimento

### Manutenzione
- Aggiornare i test con il codice
- Rimuovere test obsoleti
- Refactoring quando necessario
