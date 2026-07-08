# Framework Laraxot

## Introduzione

Laraxot è un framework modulare costruito su Laravel che fornisce una solida base per lo sviluppo di applicazioni web scalabili. Questo documento riassume le caratteristiche principali, le best practices e le convenzioni utilizzate nel framework.

## Architettura Core

### Principi Fondamentali

- **Modularità**: Il sistema è organizzato in moduli indipendenti
- **Domain-Driven Design**: Separazione delle responsabilità e focus sul dominio
- **Tipizzazione Stretta**: Utilizzo di `declare(strict_types=1)` e type hints
- **Immutabilità**: Preferenza per oggetti immutabili, specialmente per i DTO

### Moduli Principali

- **Xot**: Modulo core che fornisce le funzionalità base
- **UI**: Gestione dell'interfaccia utente
- **User**: Gestione utenti e autenticazione
- **Tenant**: Gestione multi-tenant
- **Setting**: Configurazioni di sistema
- **Notify**: Sistema di notifiche
- **Media**: Gestione file e media

## Data Transfer Objects

### Spatie Laravel Data

Laraxot utilizza Spatie Laravel Data per la gestione dei DTO, garantendo:
- Tipizzazione stretta
- Validazione integrata
- Immutabilità dei dati
- Serializzazione consistente

```php
declare(strict_types=1);

namespace Modules\ModuleName\Data;

use Spatie\LaravelData\Data;
use Spatie\LaravelData\Attributes\Validation;

class ExampleData extends Data
{
    public function __construct(
        #[Validation('required|string|max:255')]
        public readonly string $nome,
        
        #[Validation('nullable|date')]
        public readonly ?Carbon $data = null,
    ) {}
}
```

### Best Practices per i DTO

- Utilizzare sempre `readonly` per garantire l'immutabilità
- Implementare metodi `with` per modifiche
- Definire regole di validazione chiare con attributi
- Utilizzare tipi di ritorno espliciti

## Actions vs Services

### Spatie QueueableActions

Laraxot preferisce l'utilizzo di Spatie QueueableActions rispetto ai tradizionali Services:

```php
declare(strict_types=1);

namespace Modules\ModuleName\Actions;

use Spatie\QueueableAction\QueueableAction;

class CreateExampleAction
{
    use QueueableAction;

    public function execute(ExampleData $data): Example
    {
        // Implementazione
    }
}
```

### Vantaggi delle Actions

- Responsabilità singola e ben definita
- Facilmente testabili
- Possibilità di accodamento
- Migliore separazione delle responsabilità rispetto ai Services

## Filament Admin

### XotBaseResource

Tutte le risorse Filament devono estendere `XotBaseResource`:

```php
declare(strict_types=1);

namespace Modules\ModuleName\Filament\Resources;

use Modules\Xot\Filament\Resources\XotBaseResource;

class ExampleResource extends XotBaseResource
{
    public static function getFormSchema(): array
    {
        return [
            // Componenti del form
        ];
    }
}
```

### Convenzioni per Filament

- Implementare sempre `getFormSchema()` invece di `form()`
- Utilizzare i file di traduzione per le label
- Seguire la struttura standard per le risorse
- Estendere le classi base di Xot

## Pattern di Design

### Repository Pattern
- Interfacce per l'accesso ai dati
- Implementazioni concrete per ogni modello
- Caching integrato quando necessario

### Factory Pattern
- Creazione standardizzata di oggetti
- Implementazione di interfacce comuni
- Supporto per test e mock

### Observer Pattern
- Eventi del dominio
- Listeners per side effects
- Separazione delle responsabilità

### Strategy Pattern
- Implementazioni intercambiabili
- Configurazione runtime
- Estensibilità del sistema

## Testing

- Scrivere test per tutte le Actions
- Utilizzare factories per i dati di test
- Seguire la convenzione AAA (Arrange, Act, Assert)
- Testare i casi limite e gli errori

## Sicurezza

- Validare tutti gli input
- Utilizzare Gate e Policy per l'autorizzazione
- Seguire le best practices OWASP
- Implementare autenticazione robusta

## Performance

- Utilizzare il caching quando appropriato
- Ottimizzare le query N+1
- Utilizzare le code per operazioni pesanti
- Monitorare le prestazioni

## Convenzioni di Codice

- Seguire PSR-12 per lo stile del codice
- Utilizzare la tipizzazione stretta
- Documentare tutte le classi e i metodi pubblici
- Seguire le convenzioni di naming di Laravel

## Documentazione

- Mantenere la documentazione aggiornata nelle cartelle `docs/`
- Documentare tutte le API
- Includere esempi di utilizzo
- Seguire il formato Markdown standard 