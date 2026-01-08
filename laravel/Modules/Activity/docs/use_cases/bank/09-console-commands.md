# Console Commands per Bank (Event Sourcing)

## Introduzione
I console commands permettono di gestire operazioni batch, manutenzione, simulazioni e automazioni nel sistema bancario event sourced.

## Struttura Consigliata
- Tutti i comandi vanno in `app/Console/Commands` del modulo Bank.
- Naming: usare nomi descrittivi, es: `Bank:close-overdrafts`, `Bank:propose-loans`, `Bank:import-transactions`.
- Ogni comando deve:
  - Usare dependency injection per servizi e repository
  - Gestire errori e logging
  - Restituire output chiaro e codici di exit

## Esempio di Comando
```php
namespace Modules\Bank\Console\Commands;

use Illuminate\Console\Command;
use Modules\Bank\Services\AccountService;

class ProposeLoans extends Command
{
    protected $signature = 'bank:propose-loans';
    protected $description = 'Propone prestiti agli utenti che hanno raggiunto il limite più volte';

    public function __construct(private AccountService $accountService) {
        parent::__construct();
    }

    public function handle(): int
    {
        $count = $this->accountService->proposeLoansToEligibleAccounts();
        $this->info("Prestiti proposti: $count");
        return self::SUCCESS;
    }
}
```

## Best Practice
- Usare signature descrittive (`bank:propose-loans`)
- Gestire eccezioni e loggare errori
- Scrivere test per ogni comando (feature test)
- Documentare ogni comando in README del modulo

## Errori da evitare
- Logica di business nei comandi (deve stare nei servizi)
- Output non chiaro o non standard
- Mancanza di test

## Collegamenti correlati
- [Architettura bank](./02_architettura.md)
- [Best practice bank](./04_best_practice.md)
- [Testing bank](./07_test.md)
- [API bank](./06_api.md)
- [Glossario bank](./08_glossario.md) 
