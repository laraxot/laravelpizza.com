# 🛠️ Guida allo Sviluppo del Modulo Prediction Market

## 📋 Prerequisiti

- PHP 8.2+
- Composer 2.0+
- Laravel 10.x
- Redis 6.0+
- MySQL 8.0+ o PostgreSQL 13+
- Node.js 16+ (per gli asset frontend)

## 🚀 Configurazione Iniziale

### 1. Installazione delle Dipendenze

```bash

# Installare le dipendenze PHP
composer require spatie/laravel-event-sourcing laravel/sanctum

# Installare le dipendenze frontend
npm install && npm run dev
```

### 2. Configurazione Ambiente

Copia il file di ambiente di esempio e genera la chiave dell'applicazione:

```bash
cp .env.example .env
php artisan key:generate
```

Configura le variabili d'ambiente nel file `.env`:

```ini
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=prediction_market
DB_USERNAME=root
DB_PASSWORD=

REDIS_HOST=127.0.0.1
REDIS_PASSWORD=null
REDIS_PORT=6379

EVENT_SOURCING_CACHE_DRIVER=redis
```

### 3. Esecuzione delle Migrazioni

```bash
php artisan migrate
```

### 4. Avvio dei Worker

Avvia i worker per elaborare le code:

```bash
php artisan queue:work --tries=3 --timeout=300
```

## 🏗️ Struttura del Progetto

```
app/
  Console/
    Commands/
      Market/           # Comandi Artisan per la gestione dei mercati
      Bet/              # Comandi Artisan per la gestione delle scommesse
  
  Domain/
    PredictionMarket/
      Models/          # Modelli Eloquent
      Events/           # Eventi di dominio
      Commands/         # Comandi CQRS
      Queries/          # Query CQRS
      Projectors/       # Proiettori per gli eventi
      Listeners/        # Listener per gli eventi
      Jobs/             # Job in coda
      
  Http/
    Controllers/
      Api/
        V1/            # API Controllers
    Requests/           # Form requests
    Resources/          # API Resources

config/
  prediction-market.php  # Configurazione del modulo

database/
  migrations/          # Migrazioni del database
  seeders/             # Seeder per i dati di test

resources/
  js/
    Pages/
      Markets/       # Componenti Livewire/Vue per i mercati
      Bets/           # Componenti Livewire/Vue per le scommesse
  lang/               # Traduzioni

tests/
  Feature/
    Api/
      V1/            # Test delle API
    Console/         # Test dei comandi
  Unit/
    Domain/        # Test di unità del dominio
```

## 🧪 Test

### Esecuzione dei Test

```bash

# Esegui tutti i test
php artisan test

# Esegui i test di unità
php artisan test --testsuite=Unit

# Esegui i test di feature
php artisan test --testsuite=Feature

# Esegui un singolo test
php artisan test --filter=test_can_create_market
```

### Test di Integrazione

I test di integrazione verificano l'interazione tra i vari componenti del sistema:

```php
// tests/Feature/Api/V1/MarketTest.php

public function test_can_create_market()
{
    $user = User::factory()->create();
    
    $response = $this->actingAs($user, 'sanctum')
        ->postJson('/api/v1/markets', [
            'title' => 'Test Market',
            'description' => 'Test Description',
            'outcomes' => ['Yes', 'No'],
            'closes_at' => now()->addDays(7)->toDateTimeString(),
        ]);

    $response->assertStatus(201)
        ->assertJsonStructure([
            'data' => [
                'id',
                'title',
                'status',
                'created_at',
            ]
        ]);
}
```

## 🔄 Sviluppo di Nuove Funzionalità

### 1. Aggiungere un Nuovo Comando

1. Crea un nuovo comando Artisan:

```bash
php artisan make:command Market/CloseExpiredMarketsCommand
```

2. Implementa la logica del comando:

```php
// app/Console/Commands/Market/CloseExpiredMarketsCommand.php

protected $signature = 'market:close-expired';
protected $description = 'Close markets that have passed their closing time';

public function handle()
{
    $count = Market::query()
        ->where('status', MarketStatus::OPEN)
        ->where('closes_at', '<=', now())
        ->each(function (Market $market) {
            $market->close();
        })
        ->count();

    $this->info("Closed {$count} expired markets.");
    
    return Command::SUCCESS;
}
```

### 2. Aggiungere un Nuovo Endpoint API

1. Crea una nuova route in `routes/api.php`:

```php
// routes/api.php

use App\Http\Controllers\Api\V1\MarketController;

Route::middleware('auth:sanctum')->group(function () {
    Route::apiResource('markets', MarketController::class);
    
    // Altri endpoint...
});
```

2. Crea un nuovo controller:

```php
// app/Http/Controllers/Api/V1/MarketController.php

class MarketController extends Controller
{
    public function index(MarketRepository $repository)
    {
        $markets = $repository->getActiveMarkets();
        
        return MarketResource::collection($markets);
    }
    
    public function store(StoreMarketRequest $request, CreateMarketHandler $handler)
    {
        $market = $handler->handle($request->validated());
        
        return new MarketResource($market);
    }
    
    // Altri metodi...
}
```

## 🐛 Debugging

### Logging

Il modulo utilizza il sistema di logging di Laravel. Puoi accedere ai log in `storage/logs/laravel.log`.

### Tinker

Usa Tinker per interagire con il codice in modalità REPL:

```bash
php artisan tinker

// Esempio: Creare un mercato di test
$market = \App\Models\Market::create([
    'title' => 'Test Market',
    'description' => 'Test Description',
    'status' => 'open',
    'closes_at' => now()->addDays(7),
]);
```

### Telescope

Per il debug in fase di sviluppo, installa e configura Laravel Telescope:

```bash
composer require laravel/telescope --dev
php artisan telescope:install
php artisan migrate
```

## 🔄 Deployment

### Ambiente di Produzione

1. **Ottimizzazione**

```bash

# Ottimizza il caricamento delle classi
composer install --optimize-autoloader --no-dev

# Cache delle configurazioni
php artisan config:cache

# Cache delle rotte
php artisan route:cache

# Cache delle viste
php artisan view:cache
```

2. **Code di Lavoro**

Configura un gestore di processi come Supervisor per gestire i worker:

```ini
[program:prediction-market-worker]
process_name=%(program_name)s_%(process_num)02d
command=php /var/www/prediction-market/artisan queue:work --sleep=3 --tries=3 --max-time=3600
autostart=true
autorestart=true
stopasgroup=true
killasgroup=true
user=www-data
numprocs=8
directory=/var/www/prediction-market
redirect_stderr=true
stdout_logfile=/var/log/supervisor/prediction-market-worker.log
stopwaitsecs=3600
```

### Monitoraggio

Configura strumenti di monitoraggio come:

- **Laravel Horizon** per il monitoraggio delle code
- **Sentry** per il tracciamento degli errori
- **Prometheus** + **Grafana** per le metriche

## 🤝 Contributi

1. Forka il repository
2. Crea un branch per la tua feature (`git checkout -b feature/amazing-feature`)
3. Fai commit delle tue modifiche (`git commit -m 'Add some amazing feature'`)
4. Pusha il branch (`git push origin feature/amazing-feature`)
5. Apri una Pull Request

### Convenzioni di Codice

- Segui lo [PSR-12](https://www.php-fig.org/psr/psr-12/)
- Scrivi test per il nuovo codice
- Documenta le nuove funzionalità
- Aggiorna il CHANGELOG.md

## 📚 Risorse Aggiuntive

- [Documentazione Ufficiale Laravel](https://laravel.com/docs)
- [Event Sourcing in Laravel](https://spatie.be/docs/laravel-event-sourcing/v5/introduction)
- [Domain-Driven Design](https://domainlanguage.com/ddd/)
- [CQRS Pattern](https://martinfowler.com/bliki/CQRS.html)

## 📄 Licenza

Questo progetto è open-source con licenza [MIT](LICENSE).
