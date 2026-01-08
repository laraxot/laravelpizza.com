# Convenzioni di Codifica del Modulo Performance

## Struttura delle Directory

```
Modules/Performance/
├── app/
│   ├── Actions/
│   ├── Data/
│   ├── Enums/
│   ├── Filament/
│   │   └── Resources/
│   ├── Models/
│   │   └── Policies/
│   └── Providers/
├── config/
├── database/
│   ├── Migrations/
│   └── Seeders/
├── resources/
│   ├── lang/
│   └── views/
└── tests/
```

## Convenzioni di Denominazione

### Modelli
- Nomi dei modelli in PascalCase al singolare
- Estendere `BaseModel` o `XotBaseModel` quando appropriato
- Utilizzare trait per organizzare la logica comune
- Esempio: `IndividualePesi`, `IndividualePoPesi`

### Filament Resources
- Suffisso `Resource` per tutte le classi resource
- Organizzare le Pages in sottodirectory dedicate
- Utilizzare i trait di Filament per funzionalità comuni
- Esempio: `IndividualePesiResource`, `IndividualePoResource`

### Enums
- Suffisso `Type` o `Status` per gli enum
- Utilizzare PHP 8.1+ enum features
- Documentare ogni caso dell'enum
- Esempio: `WorkerType`, `PerformanceStatus`

### Actions
- Suffisso `Action` per tutte le azioni
- Una singola responsabilità per azione
- Utilizzare Spatie QueueableAction quando appropriato
- Esempio: `CalculatePerformanceScoreAction`, `CopyFromLastYearAction`

### Data Objects
- Suffisso `Data` per gli oggetti dati
- Utilizzare Spatie Laravel Data
- Implementare casting e validazione
- Esempio: `PerformanceScoreData`, `IndividualePesiData`

## Stile di Codifica

### Generale
- Strict typing ovunque (`declare(strict_types=1);`)
- Utilizzare type hints per proprietà e metodi
- Documentare le eccezioni lanciate
- Evitare abbreviazioni nei nomi

### Modelli
```php
declare(strict_types=1);

namespace Modules\Performance\Models;

use Modules\Xot\Models\XotBaseModel;

class IndividualePesi extends XotBaseModel
{
    protected $connection = 'performance';
    protected $table = 'peso_performance_individuale';
    
    protected $fillable = [
        'type',
        'lista_propro',
        // ...
    ];
    
    protected $casts = [
        'type' => WorkerType::class,
        // ...
    ];
}
```

### Filament Resources
```php
declare(strict_types=1);

namespace Modules\Performance\Filament\Resources;

use Filament\Resources\Resource;
use Modules\Performance\Models\IndividualePesi;

class IndividualePesiResource extends Resource
{
    protected static ?string $model = IndividualePesi::class;
    
    public static function getNavigationGroup(): ?string
    {
        return __('Performance');
    }
    
    // ...
}
```

### Actions
```php
declare(strict_types=1);

namespace Modules\Performance\Actions;

use Spatie\QueueableAction\QueueableAction;

class CalculatePerformanceScoreAction
{
    use QueueableAction;
    
    public function execute(IndividualePesi $pesi): float
    {
        // Implementazione
    }
}
```

### Data Objects
```php
declare(strict_types=1);

namespace Modules\Performance\Data;

use Spatie\LaravelData\Data;

class PerformanceScoreData extends Data
{
    public function __construct(
        public readonly float $score,
        public readonly string $type,
        public readonly int $year,
    ) {}
}
```

## Testing

### Unit Tests
- Un test per ogni modello
- Testare le relazioni e gli scope
- Utilizzare factories per i dati di test
- Esempio: `IndividualePesiTest`

### Feature Tests
- Testare le azioni Filament
- Verificare i permessi e le policy
- Testare i flussi completi
- Esempio: `ManageIndividualePesiTest`

## Documentazione

### PHPDoc
- Documentare tutti i metodi pubblici
- Specificare i tipi di parametri e return
- Documentare le eccezioni
- Esempio:
```php
/**
 * Calcola il punteggio totale della performance.
 *
 * @param IndividualePesi $pesi I pesi da utilizzare per il calcolo
 * @return float Il punteggio totale calcolato
 * @throws InvalidArgumentException Se i pesi non sono validi
 */
public function calculateTotalScore(IndividualePesi $pesi): float
```

### README
- Mantenere aggiornata la documentazione nel README
- Includere esempi di utilizzo
- Documentare le dipendenze
- Spiegare il processo di installazione

## Gestione delle Eccezioni

### Custom Exceptions
- Creare eccezioni specifiche del dominio
- Estendere da appropriate classi base
- Esempio: `InvalidPerformanceScoreException`

### Error Handling
- Gestire gli errori al livello appropriato
- Loggare gli errori significativi
- Fornire messaggi di errore utili
- Esempio:
```php
try {
    $score = $this->calculateScore($pesi);
} catch (InvalidPerformanceScoreException $e) {
    Log::error('Errore nel calcolo del punteggio', [
        'pesi_id' => $pesi->id,
        'error' => $e->getMessage(),
    ]);
    throw $e;
}
``` 