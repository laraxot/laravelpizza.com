# Console Commands per Prediction Market

## Introduzione
I console commands permettono di gestire operazioni batch, manutenzione, import/export, simulazioni e automazioni nel prediction market.

## Struttura Consigliata
- Tutti i comandi vanno in `app/Console/Commands` del modulo PredictionMarket.
- Naming: usare nomi descrittivi, es: `CloseExpiredMarkets`, `ImportMarketData`, `SimulateMarketOutcome`.
- Ogni comando deve:
  - Usare dependency injection per servizi e repository
  - Gestire errori e logging
  - Restituire output chiaro e codici di exit

## Esempio di Comando
```php
namespace Modules\PredictionMarket\Console\Commands;

use Illuminate\Console\Command;
use Modules\PredictionMarket\Services\MarketService;

class CloseExpiredMarkets extends Command
{
    protected $signature = 'prediction:close-expired';
    protected $description = 'Chiude tutti i mercati scaduti e distribuisce i payout';

    public function __construct(private MarketService $marketService) {
        parent::__construct();
    }

    public function handle(): int
    {
        $count = $this->marketService->closeExpiredMarkets();
        $this->info("Mercati chiusi: $count");
        return self::SUCCESS;
    }
}
```

## Best Practice
- Usare signature descrittive (`prediction:close-expired`)
- Gestire eccezioni e loggare errori
- Scrivere test per ogni comando (feature test)
- Documentare ogni comando in README del modulo

## Errori da evitare
- Logica di business nei comandi (deve stare nei servizi)
- Output non chiaro o non standard
- Mancanza di test

## Collegamenti correlati
- [Architettura prediction_market](./02_architettura.md)
- [Best practice prediction_market](./04_best_practice.md)
- [Testing prediction_market](./07_test.md)
- [API prediction_market](./06_api.md)
- [Glossario prediction_market](./08_glossario.md) 
