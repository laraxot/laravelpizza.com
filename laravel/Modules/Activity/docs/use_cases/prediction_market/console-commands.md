# Comandi da Console per il Caso d'Uso Prediction Market

## Introduzione

Questo documento descrive in dettaglio come creare e utilizzare comandi da console personalizzati per il caso d'uso `Prediction Market` nel modulo `Activity`. I comandi da console in Laravel consentono di eseguire operazioni amministrative, di manutenzione o di debug direttamente dalla riga di comando. Qui spiegheremo come crearli, registrarli e utilizzarli per gestire mercati delle previsioni, scommesse e risoluzioni.

## Creazione di un Comando da Console

### 1. Generazione del Comando

Laravel fornisce un comando Artisan per generare la struttura base di un comando da console. Per creare un comando per il caso d'uso `Prediction Market`, esegui:

```bash
php artisan make:command MarketCreateCommand
```

Questo creerà un file in `app/Console/Commands/MarketCreateCommand.php`. Spostiamo questo file in una directory più appropriata per il nostro modulo, ad esempio `Modules/Activity/app/Console/Commands/`.

**Motivazione**: Organizzare i comandi nel modulo `Activity` mantiene la struttura coerente e isolata.

### 2. Struttura del Comando

Modifichiamo il file `MarketCreateCommand.php` per adattarlo al nostro caso d'uso:

```php
namespace Modules\Activity\App\Console\Commands;

use Illuminate\Console\Command;
use Modules\Activity\App\Domain\PredictionMarket\MarketAggregate;

class MarketCreateCommand extends Command
{
    protected $signature = 'activity:market:create {title} {description} {endDate}';
    
    protected $description = 'Crea un nuovo mercato delle previsioni nel modulo Activity';

    public function handle()
    {
        $title = $this->argument('title');
        $description = $this->argument('description');
        $endDate = $this->argument('endDate');

        $marketUuid = uniqid('market_');
        $market = MarketAggregate::retrieve($marketUuid);
        
        $market->createMarket($title, $description, $endDate);
        $market->persist();

        $this->info("Mercato delle previsioni creato con UUID: {$marketUuid}, Titolo: {$title}, Data di fine: {$endDate}");
    }
}
```

**Dettagli**:
- **Namespace**: Usiamo `Modules\Activity\App\Console\Commands` per mantenere l'organizzazione modulare.
- **Signature**: Definisce il comando come `activity:market:create` con tre parametri obbligatori: `title`, `description` e `endDate`.
- **Description**: Una breve descrizione del comando, visibile con `php artisan list`.
- **Handle**: Contiene la logica per creare un mercato delle previsioni utilizzando un aggregate root `MarketAggregate` (ipotetico, basato su Event Sourcing).

### 3. Registrazione del Comando

I comandi da console in Laravel vengono automaticamente registrati se si trovano nella directory `app/Console/Commands`. Tuttavia, poiché abbiamo spostato il comando nel modulo `Activity`, dobbiamo registrarlo manualmente nel `Kernel.php` o nel service provider del modulo.

Aggiungiamo il comando in `Modules/Activity/app/Providers/ActivityServiceProvider.php`:

```php
namespace Modules\Activity\App\Providers;

use Illuminate\Support\ServiceProvider;
use Modules\Activity\App\Console\Commands\MarketCreateCommand;

class ActivityServiceProvider extends ServiceProvider
{
    protected $commands = [
        MarketCreateCommand::class,
    ];

    public function boot()
    {
        $this->commands($this->commands);
    }
}
```

**Motivazione**: Questo approccio mantiene i comandi specifici del modulo isolati e gestiti dal modulo stesso.

### 4. Utilizzo del Comando

Ora possiamo eseguire il comando da console:

```bash
php artisan activity:market:create "Chi vincerà le elezioni?" "Prevedi il vincitore delle elezioni del 2024" "2024-11-30"
```

**Output Atteso**:
```
Mercato delle previsioni creato con UUID: market_xxxxxxxxxx, Titolo: Chi vincerà le elezioni?, Data di fine: 2024-11-30
```

## Altri Comandi Utili per il Caso d'Uso Prediction Market

### Comando per Piazzare una Scommessa

Creiamo un comando per permettere agli utenti di piazzare scommesse su un mercato:

```bash
php artisan make:command MarketPlaceBetCommand
```

Modifichiamo il file `MarketPlaceBetCommand.php`:

```php
namespace Modules\Activity\App\Console\Commands;

use Illuminate\Console\Command;
use Modules\Activity\App\Domain\PredictionMarket\MarketAggregate;

class MarketPlaceBetCommand extends Command
{
    protected $signature = 'activity:market:place-bet {marketUuid} {userId} {prediction} {amount}';
    
    protected $description = 'Piazza una scommessa su un mercato delle previsioni nel modulo Activity';

    public function handle()
    {
        $marketUuid = $this->argument('marketUuid');
        $userId = $this->argument('userId');
        $prediction = $this->argument('prediction');
        $amount = (float) $this->argument('amount');

        $market = MarketAggregate::retrieve($marketUuid);
        
        $market->placeBet($userId, $prediction, $amount);
        $market->persist();

        $this->info("Scommessa piazzata sul mercato {$marketUuid} dall'utente {$userId}: {$amount} su {$prediction}");
    }
}
```

**Utilizzo**:

```bash
php artisan activity:market:place-bet market_xxxxxxxxxx 12345 "Candidato A" 100
```

**Motivazione**: Questo comando è utile per testare il sistema o per piazzare scommesse manualmente in caso di necessità amministrativa.

### Comando per Risolvere un Mercato

Creiamo un comando per risolvere un mercato delle previsioni, determinando il risultato finale:

```bash
php artisan make:command MarketResolveCommand
```

Modifichiamo il file `MarketResolveCommand.php`:

```php
namespace Modules\Activity\App\Console\Commands;

use Illuminate\Console\Command;
use Modules\Activity\App\Domain\PredictionMarket\MarketAggregate;

class MarketResolveCommand extends Command
{
    protected $signature = 'activity:market:resolve {marketUuid} {outcome}';
    
    protected $description = 'Risolve un mercato delle previsioni con un risultato nel modulo Activity';

    public function handle()
    {
        $marketUuid = $this->argument('marketUuid');
        $outcome = $this->argument('outcome');

        $market = MarketAggregate::retrieve($marketUuid);
        
        $market->resolveMarket($outcome);
        $market->persist();

        $this->info("Mercato {$marketUuid} risolto con risultato: {$outcome}");
    }
}
```

**Utilizzo**:

```bash
php artisan activity:market:resolve market_xxxxxxxxxx "Candidato A"
```

**Motivazione**: Questo comando permette di chiudere un mercato e determinare i vincitori, utile per amministratori o per test.

## Comandi Aggiuntivi Ispirati a Event Sourcing con Laravel (cnastasi)

Prendendo spunto dal repository [event-sourcing-with-laravel](https://github.com/cnastasi/event-sourcing-with-laravel) di cnastasi, possiamo estendere i comandi da console per il caso d'uso `Prediction Market` con un approccio minimalista e didattico. Questi comandi aggiuntivi sono progettati per gestire operazioni di mercato delle previsioni in modo semplice, generando eventi che possono essere tracciati per ricostruire lo stato del sistema.

### Comando per Simulare una Scommessa Massiva

Creiamo un comando per simulare scommesse massive su un mercato, utile per test di stress o demo:

```bash
php artisan make:command MarketMassBetCommand
```

Modifichiamo il file `MarketMassBetCommand.php`:

```php
namespace Modules\Activity\App\Console\Commands;

use Illuminate\Console\Command;
use Modules\Activity\App\Domain\PredictionMarket\MarketAggregate;

class MarketMassBetCommand extends Command
{
    protected $signature = 'activity:market:mass-bet {marketUuid} {numberOfBets} {minAmount=10} {maxAmount=100}';
    
    protected $description = 'Simula scommesse massive su un mercato di previsione nel modulo Activity';

    public function handle()
    {
        $marketUuid = $this->argument('marketUuid');
        $numberOfBets = (int) $this->argument('numberOfBets');
        $minAmount = (float) $this->argument('minAmount');
        $maxAmount = (float) $this->argument('maxAmount');

        $market = MarketAggregate::retrieve($marketUuid);
        
        for ($i = 0; $i < $numberOfBets; $i++) {
            $userId = 'user_' . uniqid();
            $prediction = rand(0, 1) ? 'yes' : 'no';
            $amount = rand($minAmount * 100, $maxAmount * 100) / 100;
            $market->placeBet($userId, $prediction, $amount);
            $this->info("Scommessa #$i: Utente {$userId} ha scommesso {$amount} su {$prediction}");
        }
        
        $market->persist();

        $this->info("Simulazione completata: {$numberOfBets} scommesse piazzate sul mercato {$marketUuid}");
    }
}
```

**Utilizzo**:

```bash
php artisan activity:market:mass-bet market_12345_xxxxxxxxxx 50 10 100
```

**Motivazione**: Questo comando, ispirato ai comandi semplici di cnastasi come `product:purchase`, permette di simulare attività su larga scala per testare la robustezza del sistema di mercato delle previsioni. Genera eventi `BetPlaced` multipli, che possono essere usati per ricostruire lo stato del mercato.

### Comando per Elencare Tutti i Mercati Attivi

Creiamo un comando per elencare tutti i mercati attivi, simile a `product:list` di cnastasi:

```bash
php artisan make:command MarketListActiveCommand
```

Modifichiamo il file `MarketListActiveCommand.php`:

```php
namespace Modules\Activity\App\Console\Commands;

use Illuminate\Console\Command;
use Modules\Activity\App\Domain\PredictionMarket\MarketRepository;

class MarketListActiveCommand extends Command
{
    protected $signature = 'activity:market:list-active';
    
    protected $description = 'Elenca tutti i mercati di previsione attivi nel modulo Activity';

    public function handle()
    {
        $repository = new MarketRepository();
        $markets = $repository->getActiveMarkets();

        if ($markets->isEmpty()) {
            $this->info('Nessun mercato attivo trovato.');
            return;
        }

        $this->table(
            ['UUID', 'Titolo', 'Data di Fine', 'Scommesse Totali'],
            $markets->map(function ($market) {
                return [
                    $market->uuid,
                    $market->title,
                    $market->endDate->format('Y-m-d H:i:s'),
                    $market->totalBets,
                ];
            })
        );
    }
}
```

**Utilizzo**:

```bash
php artisan activity:market:list-active
```

**Motivazione**: Ispirato a `product:list` di cnastasi, questo comando fornisce una panoramica rapida dei mercati attivi, utile per amministratori o per demo. Probabilmente si basa su una proiezione o modello di lettura generato dagli eventi, un concetto chiave di Event Sourcing.

### Comando per Registrare un Nuovo Mercato con Parametri Minimi

Creiamo un comando per registrare un nuovo mercato con parametri minimi, simile a `product:register` di cnastasi:

```bash
php artisan make:command MarketQuickCreateCommand
```

Modifichiamo il file `MarketQuickCreateCommand.php`:

```php
namespace Modules\Activity\App\Console\Commands;

use Illuminate\Console\Command;
use Modules\Activity\App\Domain\PredictionMarket\MarketAggregate;

class MarketQuickCreateCommand extends Command
{
    protected $signature = 'activity:market:quick-create {title} {daysFromNow=7}';
    
    protected $description = 'Crea rapidamente un mercato di previsione con parametri minimi nel modulo Activity';

    public function handle()
    {
        $title = $this->argument('title');
        $daysFromNow = (int) $this->argument('daysFromNow');

        $marketUuid = uniqid('market_');
        $endDate = now()->addDays($daysFromNow);
        $description = "Mercato rapido: {$title}";

        $market = MarketAggregate::retrieve($marketUuid);
        $market->createMarket($title, $description, $endDate);
        $market->persist();

        $this->info("Mercato rapido creato con UUID: {$marketUuid}, Titolo: {$title}, Fine: {$endDate}");
    }
}
```

**Utilizzo**:

```bash
php artisan activity:market:quick-create "Prossimo Campionato" 14
```

**Motivazione**: Ispirato a `product:register` di cnastasi, questo comando semplifica la creazione di un mercato per demo o test rapidi, generando un evento `MarketCreated`. Riduce la complessità rispetto al comando `activity:market:create`, concentrandosi su parametri essenziali.

## Best Practices per i Comandi da Console

- **Namespace Coerente**: Usa un namespace che rifletta la posizione del modulo (`Modules\Activity\App\Console\Commands`) per mantenere l'organizzazione.
- **Nomi Descrittivi**: Usa nomi di comandi chiari e specifici (es. `activity:market:create`) per evitare ambiguità.
- **Parametri e Opzioni**: Definisci parametri obbligatori e opzioni facoltative per rendere i comandi flessibili.
- **Feedback Utente**: Usa `$this->info()`, `$this->error()`, ecc., per fornire feedback chiaro durante l'esecuzione.
- **Gestione Errori**: Implementa controlli per prevenire errori e fornire messaggi utili.
- **Registrazione**: Registra i comandi nel service provider del modulo per mantenere l'isolamento.

## Best Practices Ispirate a cnastasi

- **Semplicità nei Comandi**: Come cnastasi, mantenere i comandi da console focalizzati su singole operazioni di business (es. creare, scommettere, elencare) per facilitare l'uso e la comprensione.
- **Output Chiaro**: Fornire feedback dettagliato (es. tabelle per elenchi, messaggi di conferma per azioni) per migliorare l'esperienza utente, come visto in `product:list`.
- **Approccio Didattico**: Creare comandi che non solo svolgono funzioni amministrative, ma servono anche a dimostrare i principi di Event Sourcing, come la generazione di eventi per ogni azione.

## Conclusione

I comandi da console sono strumenti essenziali per gestire operazioni nel caso d'uso `Prediction Market` del modulo `Activity`. Seguendo i passaggi descritti, puoi creare comandi personalizzati per creare mercati, piazzare scommesse e risolvere mercati, migliorando la gestione e il debug del sistema. Questi comandi possono essere ulteriormente estesi per coprire altre funzionalità specifiche come report di mercato, simulazioni di scommesse o gestione degli utenti.

Integrando l'approccio minimalista e didattico del repository di cnastasi, abbiamo esteso i comandi da console per il caso d'uso `Prediction Market` con strumenti pratici come `activity:market:mass-bet`, `activity:market:list-active` e `activity:market:quick-create`. Questi comandi, ispirati a quelli di cnastasi per la gestione del magazzino, migliorano la capacità di testare, dimostrare e amministrare i mercati di previsioni, mantenendo un focus sugli eventi come fonte di verità. Questo approccio ci permette di bilanciare semplicità e potenza, rendendo il sistema accessibile a sviluppatori di diversi livelli di esperienza.
