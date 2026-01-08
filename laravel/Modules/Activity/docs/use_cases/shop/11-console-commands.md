# Console Commands per Shop Event Sourced

## Introduzione
I console commands permettono di gestire operazioni batch, manutenzione, import/export, simulazioni e automazioni nello shop event sourced.

## Struttura Consigliata
- Tutti i comandi vanno in `app/Console/Commands` del modulo Shop.
- Naming: usare nomi descrittivi, es: `shop:close-expired-orders`, `shop:import-products`, `shop:simulate-orders`.
- Ogni comando deve:
  - Usare dependency injection per servizi e repository
  - Gestire errori e logging
  - Restituire output chiaro e codici di exit

## Esempio di Comando
```php
namespace Modules\Shop\Console\Commands;

use Illuminate\Console\Command;
use Modules\Shop\Services\OrderService;

class CloseExpiredOrders extends Command
{
    protected $signature = 'shop:close-expired-orders';
    protected $description = 'Chiude tutti gli ordini scaduti e aggiorna lo stato';

    public function __construct(private OrderService $orderService) {
        parent::__construct();
    }

    public function handle(): int
    {
        $count = $this->orderService->closeExpiredOrders();
        $this->info("Ordini chiusi: $count");
        return self::SUCCESS;
    }
}
```

## Best Practice
- Usare signature descrittive (`shop:close-expired-orders`)
- Gestire eccezioni e loggare errori
- Scrivere test per ogni comando (feature test)
- Documentare ogni comando in README del modulo

## Errori da evitare
- Logica di business nei comandi (deve stare nei servizi)
- Output non chiaro o non standard
- Mancanza di test

## Collegamenti correlati
- [Architettura shop](./02_architettura.md)
- [Best practice shop](./04_best_practice.md)
- [Testing shop](./09_test.md)
- [API shop](./08_api.md)
- [Glossario shop](./10_glossario.md) 
