# Sistema di Actions

## Panoramica
Il sistema di Actions utilizza `Spatie/Laravel-Queueable-Action` per gestire le azioni in modo asincrono e scalabile.

## Implementazione Base

### Action Class
```php
namespace Modules\YourModule\Actions;

use Spatie\QueueableAction\QueueableAction;

class CreateRecordAction implements QueueableAction
{
    use QueueableAction;

    protected $data;

    public function __construct(array $data)
    {
        $this->data = $data;
    }

    public function execute()
    {
        // Implementazione
        return $this->createRecord();
    }

    protected function createRecord()
    {
        // Logica di creazione
    }
}
```

## Best Practices

### Struttura
```php
// ❌ NON FARE
class CreateRecordService
{
    public function create(array $data)
    {
        // Implementazione
    }
}

// ✅ FARE
class CreateRecordAction implements QueueableAction
{
    use QueueableAction;

    public function execute(array $data)
    {
        // Implementazione
    }
}
```

### Queue
```php
// Configurazione queue
'connections' => [
    'redis' => [
        'driver' => 'redis',
        'connection' => 'default',
        'queue' => 'default',
        'retry_after' => 90,
        'block_for' => null,
    ],
],
```

### Error Handling
```php
try {
    $action->execute();
} catch (\Exception $e) {
    Log::error('Action failed', [
        'action' => get_class($action),
        'error' => $e->getMessage(),
    ]);
    
    throw $e;
}
```

## Metriche

### Performance
- Tempo di esecuzione: <5s
- Tasso di successo: >99%
- Retry rate: <1%

### Monitoraggio
- Log delle azioni
- Statistiche di esecuzione
- Errori e retry

## Collegamenti
- [Documentazione API](./api.md)
- [Guida Contribuzione](./CONTRIBUTING.md)
- [Best Practices](./best-practices.md)

## Note
- Testare le azioni in ambiente di sviluppo
- Monitorare le performance
- Gestire gli errori
- Documentare le modifiche 
