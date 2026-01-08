# Integrazione con Laravel e Event Sourcing

## 1. Configurazione Iniziale

### 1.1 Installazione dei Pacchetti
```bash
composer require spatie/laravel-event-sourcing
composer require spatie/laravel-event-sourcing-projections
```

### 1.2 Pubblicazione delle Configurazioni
```bash
php artisan vendor:publish --provider="Spatie\EventSourcing\EventSourcingServiceProvider" --tag="event-sourcing-config"
php artisan vendor:publish --provider="Spatie\EventSourcing\ProjectionistServiceProvider" --tag="event-sourcing-projections-config"
```

## 2. Modellazione degli Eventi

### 2.1 Struttura Base degli Eventi
```php
namespace App\Events;

use Spatie\EventSourcing\StoredEvents\ShouldBeStored;

class MarketCreated extends ShouldBeStored
{
    public function __construct(
        public string $marketUuid,
        public string $title,
        public string $description,
        public string $outcomeType,
        public array $outcomes,
        public string $resolvesAt,
        public int $creatorId
    ) {}
}
```

### 2.2 Esempio di Evento di Trading
```php
class TradeExecuted extends ShouldBeStored
{
    public function __construct(
        public string $tradeUuid,
        public string $marketUuid,
        public string $contractId,
        public int $userId,
        public string $type, // 'buy' or 'sell'
        public float $price,
        public int $quantity,
        public float $totalAmount
    ) {}
}
```

## 3. Aggregati

### 3.1 Market Aggregate
```php
namespace App\Aggregates;

use Spatie\EventSourcing\AggregateRoots\AggregateRoot;
use App\Events\MarketCreated;
use App\Events\MarketResolved;

class MarketAggregate extends AggregateRoot
{
    private bool $isResolved = false;
    private array $outcomes = [];
    private string $resolvedOutcome = '';

    public function createMarket(array $marketData)
    {
        $this->recordThat(new MarketCreated(
            marketUuid: $this->uuid(),
            title: $marketData['title'],
            description: $marketData['description'],
            outcomeType: $marketData['outcome_type'],
            outcomes: $marketData['outcomes'],
            resolvesAt: $marketData['resolves_at'],
            creatorId: auth()->id()
        ));

        return $this;
    }

    public function resolveMarket(string $outcome)
    {
        if ($this->isResolved) {
            throw new \Exception('Market already resolved');
        }

        $this->recordThat(new MarketResolved(
            marketUuid: $this->uuid(),
            outcome: $outcome,
            resolvedAt: now()
        ));

        return $this;
    }

    protected function applyMarketCreated(MarketCreated $event)
    {
        $this->outcomes = $event->outcomes;
    }

    protected function applyMarketResolved(MarketResolved $event)
    {
        $this->isResolved = true;
        $this->resolvedOutcome = $event->outcome;
    }
}
```

## 4. Proiettori

### 4.1 MarketProjector
```php
namespace App\Projectors;

use App\Events\MarketCreated;
use App\Events\MarketResolved;
use App\Models\Market;
use Spatie\EventSourcing\EventHandlers\Projectors\Projector;

class MarketProjector extends Projector
{
    public function onMarketCreated(MarketCreated $event)
    {
        Market::create([
            'uuid' => $event->marketUuid,
            'title' => $event->title,
            'description' => $event->description,
            'outcome_type' => $event->outcomeType,
            'outcomes' => $event->outcomes,
            'resolves_at' => $event->resolvesAt,
            'creator_id' => $event->creatorId,
            'is_resolved' => false,
        ]);
    }

    public function onMarketResolved(MarketResolved $event)
    {
        $market = Market::where('uuid', $event->marketUuid)->firstOrFail();
        $market->update([
            'is_resolved' => true,
            'resolved_outcome' => $event->outcome,
            'resolved_at' => $event->resolvedAt,
        ]);
    }
}
```

## 5. Comandi Artisan

### 5.1 Creazione di un Nuovo Mercato
```php
namespace App\Console\Commands;

use App\Aggregates\MarketAggregate;
use Illuminate\Console\Command;

class CreateMarket extends Command
{
    protected $signature = 'market:create';
    protected $description = 'Create a new prediction market';

    public function handle()
    {
        $data = [
            'title' => $this->ask('Market title'),
            'description' => $this->ask('Market description'),
            'outcome_type' => $this->choice('Outcome type', ['binary', 'categorical', 'scalar'], 0),
            'outcomes' => $this->getOutcomes(),
            'resolves_at' => $this->ask('Resolution date (Y-m-d H:i:s)'),
        ];

        $aggregate = MarketAggregate::retrieve($uuid = (string) \Illuminate\Support\Str::uuid())
            ->createMarket($data);

        $this->info("Market created with UUID: {$uuid}");
        return 0;
    }

    private function getOutcomes(): array
    {
        $outcomes = [];
        while (true) {
            $outcome = $this->ask('Add an outcome (leave empty to finish)');
            if (empty($outcome)) {
                break;
            }
            $outcomes[] = $outcome;
        }
        return $outcomes;
    }
}
```

## 6. Test

### 6.1 Test di Unità per MarketAggregate
```php
namespace Tests\Unit;

use App\Aggregates\MarketAggregate;
use App\Events\MarketCreated;
use App\Events\MarketResolved;
use Tests\TestCase;

class MarketAggregateTest extends TestCase
{
    private string $marketUuid;

    protected function setUp(): void
    {
        parent::setUp();
        $this->marketUuid = (string) \Illuminate\Support\Str::uuid();
    }

    /** @test */
    public function it_creates_a_market()
    {
        $aggregate = MarketAggregate::retrieve($this->marketUuid);

        $aggregate->createMarket([
            'title' => 'Test Market',
            'description' => 'Test Description',
            'outcome_type' => 'binary',
            'outcomes' => ['Yes', 'No'],
            'resolves_at' => now()->addDays(7),
        ]);

        $this->assertCount(1, $aggregate->getRecordedEvents());
        $this->assertInstanceOf(MarketCreated::class, $aggregate->getRecordedEvents()[0]);
    }

    /** @test */
    public function it_resolves_a_market()
    {
        $aggregate = MarketAggregate::retrieve($this->marketUuid);

        $aggregate->createMarket([
            'title' => 'Test Market',
            'description' => 'Test Description',
            'outcome_type' => 'binary',
            'outcomes' => ['Yes', 'No'],
            'resolves_at' => now()->addDays(7),
        ]);

        $aggregate->resolveMarket('Yes');

        $events = $aggregate->getRecordedEvents();
        $this->assertCount(2, $events);
        $this->assertInstanceOf(MarketResolved::class, $events[1]);
        $this->assertEquals('Yes', $events[1]->outcome);
    }
}
```

## 7. API Endpoints

### 7.1 Creazione di un Mercato
```php
// routes/api.php

use App\Aggregates\MarketAggregate;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

Route::middleware('auth:api')->group(function () {
    Route::post('/markets', function (Request $request) {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'outcome_type' => 'required|in:binary,categorical,scalar',
            'outcomes' => 'required|array|min:1',
            'outcomes.*' => 'required|string|distinct',
            'resolves_at' => 'required|date|after:now',
        ]);

        $uuid = (string) Str::uuid();

        MarketAggregate::retrieve($uuid)
            ->createMarket(array_merge($validated, [
                'creator_id' => auth()->id(),
            ]));

        return response()->json([
            'message' => 'Market created successfully',
            'market_uuid' => $uuid,
        ], 201);
    });
});
```

## 8. Monitoraggio e Manutenzione

### 8.1 Comandi per il Monitoraggio
```bash

# Visualizza lo stato dei proiettori
php artisan event-sourcing:list-projectors

# Rigioca gli eventi per un proiettore specifico
php artisan event-sourcing:replay App\\Projectors\\MarketProjector

# Monitora gli eventi in tempo reale
php artisan event-sourcing:monitor
```

### 8.2 Pianificazione delle Attività
```php
// app/Console/Kernel.php

protected function schedule(Schedule $schedule)
{
    // Controlla e risolve i mercati scaduti ogni ora
    $schedule->command('markets:resolve-expired')
             ->hourly();
             
    // Esegui il backup degli eventi ogni giorno
    $schedule->command('event-sourcing:backup')
             ->dailyAt('02:00');
}
```

## 9. Considerazioni sulle Prestazioni

### 9.1 Snapshot
Per migliorare le prestazioni con un gran numero di eventi, implementa lo snapshot:

```php
// config/event-sourcing.php

'stored_event_model' => \App\Models\StoredEvent::class,

'snapshot_repository' => \Spatie\EventSourcing\Snapshots\EloquentSnapshotRepository::class,

'snapshot' => [
    'interval' => 500, // Crea uno snapshot ogni 500 eventi
],
```

### 9.2 Indicizzazione del Database
Assicurati di avere indici appropriati sulle tabelle degli eventi:

```php
// migration per la tabella degli eventi

Schema::create('stored_events', function (Blueprint $table) {
    $table->id();
    $table->uuid('aggregate_uuid')->nullable();
    $table->unsignedBigInteger('aggregate_version')->nullable();
    $table->string('event_class');
    $table->json('event_properties');
    $table->json('meta_data');
    $table->timestamp('created_at');
    $table->index('aggregate_uuid');
    $table->index('event_class');
    $table->index('created_at');
});
```

## 10. Sicurezza

### 10.1 Autorizzazioni
Implementa le policy di Laravel per gestire le autorizzazioni:

```php
// app/Policies/MarketPolicy.php

public function create(User $user)
{
    return $user->hasVerifiedEmail();
}

public function resolve(User $user, Market $market)
{
    return $user->id === $market->creator_id || $user->isAdmin();
}
```

### 10.2 Validazione degli Input
```php
// app/Http/Requests/ResolveMarketRequest.php

public function rules()
{
    return [
        'outcome' => [
            'required',
            'string',
            Rule::in($this->market->outcomes),
        ],
    ];
}
```

## Conclusione

Questa documentazione fornisce una solida base per implementare un prediction market utilizzando Laravel e l'event sourcing. Con questa architettura, il sistema è scalabile, mantenibile e in grado di gestire un elevato volume di transazioni in modo affidabile.
