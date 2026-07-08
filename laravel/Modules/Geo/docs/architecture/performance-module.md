# Architettura del Modulo Performance

## Overview

Il modulo Performance è responsabile della gestione delle valutazioni delle performance del personale. Implementa un'architettura modulare basata su Domain-Driven Design (DDD) e SOLID principles.

## Struttura del Dominio

### Bounded Context

```
Performance/
├── Domain/
│   ├── Models/
│   │   ├── IndividualePesi.php
│   │   └── IndividualePoPesi.php
│   ├── Data/
│   │   ├── PerformanceScoreData.php
│   │   └── ValutazioneData.php
│   ├── Enums/
│   │   ├── WorkerType.php
│   │   └── PerformanceStatus.php
│   └── Events/
│       ├── PerformanceScoreCalculated.php
│       └── ValutazioneCompleted.php
└── Application/
    ├── Actions/
    │   ├── CalculatePerformanceScoreAction.php
    │   └── CopyFromLastYearAction.php
    ├── Queries/
    │   └── GetPerformanceScoreQuery.php
    └── Services/
        └── PerformanceCalculator.php
```

## Componenti Principali

### Domain Models

```php
declare(strict_types=1);

namespace Modules\Performance\Domain\Models;

use Modules\Xot\Models\XotBaseModel;
use Modules\Performance\Domain\Events\PerformanceScoreCalculated;

class IndividualePesi extends XotBaseModel
{
    protected $dispatchesEvents = [
        'saved' => PerformanceScoreCalculated::class,
    ];
    
    public function calculateTotalScore(): float
    {
        return $this->peso_esperienza_acquisita +
               $this->peso_risultati_ottenuti +
               $this->peso_arricchimento_professionale +
               $this->peso_impegno +
               $this->peso_qualita_prestazione;
    }
}
```

### Data Objects

```php
declare(strict_types=1);

namespace Modules\Performance\Domain\Data;

use Spatie\LaravelData\Data;
use Modules\Performance\Domain\Enums\WorkerType;

class PerformanceScoreData extends Data
{
    public function __construct(
        public readonly float $score,
        public readonly WorkerType $type,
        public readonly int $year,
    ) {
        $this->validate();
    }
    
    private function validate(): void
    {
        if ($this->score < 0 || $this->score > 100) {
            throw new InvalidArgumentException('Score must be between 0 and 100');
        }
    }
}
```

### Actions

```php
declare(strict_types=1);

namespace Modules\Performance\Application\Actions;

use Spatie\QueueableAction\QueueableAction;
use Modules\Performance\Domain\Models\IndividualePesi;
use Modules\Performance\Domain\Data\PerformanceScoreData;
use Modules\Performance\Application\Services\PerformanceCalculator;

class CalculatePerformanceScoreAction
{
    use QueueableAction;
    
    public function __construct(
        private readonly PerformanceCalculator $calculator
    ) {}
    
    public function execute(IndividualePesi $pesi): PerformanceScoreData
    {
        $score = $this->calculator->calculate($pesi);
        
        return new PerformanceScoreData(
            score: $score,
            type: $pesi->type,
            year: $pesi->anno
        );
    }
}
```

## Interfaccia Utente

### Filament Resources

```php
declare(strict_types=1);

namespace Modules\Performance\Infrastructure\Filament\Resources;

use Filament\Resources\Resource;
use Modules\Performance\Domain\Models\IndividualePesi;
use Modules\Performance\Domain\Data\PerformanceScoreData;

class IndividualePesiResource extends Resource
{
    protected static ?string $model = IndividualePesi::class;
    
    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('type')
                    ->enum(WorkerType::class)
                    ->required(),
                Forms\Components\TextInput::make('peso_esperienza_acquisita')
                    ->numeric()
                    ->rules(['min:0', 'max:100'])
                    ->required(),
                // ...
            ]);
    }
    
    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('type')
                    ->badge(),
                Tables\Columns\TextColumn::make('anno')
                    ->sortable(),
                Tables\Columns\TextColumn::make('total_score')
                    ->numeric(2)
                    ->sortable(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('type')
                    ->enum(WorkerType::class),
                Tables\Filters\Filter::make('anno')
                    ->form([
                        Forms\Components\TextInput::make('anno')
                            ->numeric(),
                    ]),
            ]);
    }
}
```

## Eventi e Listeners

### Events

```php
declare(strict_types=1);

namespace Modules\Performance\Domain\Events;

use Illuminate\Foundation\Events\Dispatchable;
use Modules\Performance\Domain\Models\IndividualePesi;

class PerformanceScoreCalculated
{
    use Dispatchable;
    
    public function __construct(
        public readonly IndividualePesi $pesi
    ) {}
}
```

### Listeners

```php
declare(strict_types=1);

namespace Modules\Performance\Domain\Listeners;

use Modules\Performance\Domain\Events\PerformanceScoreCalculated;
use Illuminate\Contracts\Queue\ShouldQueue;

class NotifyPerformanceScoreCalculated implements ShouldQueue
{
    public function handle(PerformanceScoreCalculated $event): void
    {
        // Implementazione notifica
    }
}
```

## Service Providers

```php
declare(strict_types=1);

namespace Modules\Performance\Infrastructure\Providers;

use Illuminate\Support\ServiceProvider;
use Modules\Performance\Application\Services\PerformanceCalculator;
use Modules\Performance\Infrastructure\Services\DefaultPerformanceCalculator;

class PerformanceServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->bind(
            PerformanceCalculator::class,
            DefaultPerformanceCalculator::class
        );
    }
    
    public function boot(): void
    {
        $this->loadMigrationsFrom(__DIR__ . '/../database/migrations');
        $this->loadRoutesFrom(__DIR__ . '/../routes/web.php');
        $this->loadViewsFrom(__DIR__ . '/../resources/views', 'performance');
    }
}
```

## Database

### Migrations

```php
declare(strict_types=1);

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Modules\Xot\Database\Migrations\XotBaseMigration;

return new class extends XotBaseMigration
{
    public function up(): void
    {
        Schema::connection('performance')->create('peso_performance_individuale', function (Blueprint $table) {
            $table->id();
            $table->string('type');
            $table->string('lista_propro');
            $table->text('descr')->nullable();
            $table->decimal('peso_esperienza_acquisita', 5, 2);
            $table->decimal('peso_risultati_ottenuti', 5, 2);
            $table->decimal('peso_arricchimento_professionale', 5, 2);
            $table->decimal('peso_impegno', 5, 2);
            $table->decimal('peso_qualita_prestazione', 5, 2);
            $table->year('anno');
            $table->timestamps();
            
            $table->unique(['type', 'anno']);
        });
    }
};
```

## Configurazione

```php
// config/performance.php

return [
    'database' => [
        'connection' => env('PERFORMANCE_DB_CONNECTION', 'performance'),
    ],
    
    'scoring' => [
        'min_score' => 0,
        'max_score' => 100,
        'decimal_places' => 2,
    ],
    
    'notifications' => [
        'channels' => [
            'mail',
            'database',
        ],
    ],
];
```

## Dipendenze

```json
{
    "require": {
        "php": "^8.2",
        "laravel/framework": "^10.0",
        "spatie/laravel-data": "^3.0",
        "spatie/laravel-queueable-action": "^2.0",
        "filament/filament": "^3.0"
    }
}
```

## Best Practices

1. **SOLID Principles**
   - Single Responsibility Principle: Ogni classe ha una singola responsabilità
   - Open/Closed Principle: Le classi sono aperte all'estensione ma chiuse alla modifica
   - Liskov Substitution Principle: Le classi derivate possono sostituire le classi base
   - Interface Segregation Principle: Le interfacce sono specifiche per il client
   - Dependency Inversion Principle: Dipendere dalle astrazioni, non dalle implementazioni

2. **Clean Architecture**
   - Separazione dei layer (Domain, Application, Infrastructure)
   - Inversione delle dipendenze
   - Domain-Driven Design

3. **Testing**
   - Unit test per il domain layer
   - Integration test per l'application layer
   - Feature test per l'infrastructure layer
   - Test coverage > 80%

4. **Performance**
   - Eager loading delle relazioni
   - Caching dei risultati
   - Query optimization
   - Background job processing 