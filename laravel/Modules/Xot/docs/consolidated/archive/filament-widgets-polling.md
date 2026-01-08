# Polling nei Widget Filament

Questo documento descrive come implementare il polling automatico nei widget Filament utilizzando il trait `CanPoll` nel progetto il progetto.

## Introduzione

Il polling automatico permette ai widget Filament di aggiornarsi periodicamente senza richiedere l'intervento dell'utente. Questa funzionalità è particolarmente utile per widget che mostrano dati in tempo reale, come statistiche, notifiche o dashboard.

## Implementazione

### Trait CanPoll

Il trait `CanPoll` è fornito dal pacchetto Filament e può essere utilizzato nei widget che estendono `XotBaseWidget`:

```php
<?php

namespace Filament\Widgets\Concerns;

trait CanPoll
{
    protected static ?string $pollingInterval = '5s';

    protected function getPollingInterval(): ?string
    {
        return static::$pollingInterval;
    }
}
```

### Utilizzo con XotBaseWidget

Per implementare il polling in un widget personalizzato:

```php
<?php

namespace Modules\User\Filament\Widgets;

use Filament\Widgets\Concerns\CanPoll;
use Modules\Xot\Filament\Widgets\XotBaseWidget;

class DashboardStatsWidget extends XotBaseWidget
{
    use CanPoll;
    
    // Personalizzare l'intervallo di polling (default: 5s)
    protected static ?string $pollingInterval = '10s';
    
    // Opzionale: sovrascrivere il metodo getPollingInterval
    protected function getPollingInterval(): ?string
    {
        // Logica personalizzata per determinare l'intervallo
        return static::$pollingInterval;
    }
    
    // Il contenuto del widget verrà aggiornato automaticamente
    public function getFormSchema(): array
    {
        return [
            // Schema del form che verrà aggiornato automaticamente
        ];
    }
}
```

## Configurazione dell'Intervallo

L'intervallo di polling può essere configurato in diversi modi:

| Formato | Esempio | Descrizione |
|---------|---------|-------------|
| Secondi | `'5s'` | Aggiorna ogni 5 secondi |
| Minuti | `'2m'` | Aggiorna ogni 2 minuti |
| Null | `null` | Disabilita il polling |

## Best Practices

1. **Prestazioni**: Utilizzare intervalli ragionevoli (non troppo frequenti) per evitare sovraccarichi del server
2. **Dati Sensibili**: Considerare l'impatto sulla sicurezza quando si aggiornano dati sensibili
3. **UX**: Fornire indicatori visivi dell'aggiornamento per migliorare l'esperienza utente
4. **Timeout**: Implementare gestione dei timeout per evitare problemi con richieste bloccate

## Esempio Completo

```php
<?php

namespace Modules\Dashboard\Filament\Widgets;

use Filament\Widgets\Concerns\CanPoll;
use Modules\Xot\Filament\Widgets\XotBaseWidget;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Card;

class ActiveUsersWidget extends XotBaseWidget
{
    use CanPoll;
    
    protected static ?string $pollingInterval = '30s';
    protected int | string | array $columnSpan = 'full';
    public string $title = 'Utenti Attivi';
    
    public function getFormSchema(): array
    {
        $activeUsers = $this->getActiveUsers();
        
        return [
            'stats' => Card::make()
                ->schema([
                    TextInput::make('active_users')
                        ->label('Utenti attivi ora')
                        ->default($activeUsers)
                        ->disabled()
                        ->hint('Aggiornato automaticamente ogni 30 secondi'),
                ]),
        ];
    }
    
    private function getActiveUsers(): int
    {
        // Logica per ottenere il numero di utenti attivi
        return rand(5, 100); // Esempio
    }
}
```

## Compatibilità

Questa funzionalità è compatibile con:
- Filament 3.x
- Laravel 12.x
- PHP 8.2+

## Collegamenti Bidirezionali

- [README.md](../../README.md) - Indice principale della documentazione
- [xot-base-widget.md](./xot-base-widget.md) - Documentazione su XotBaseWidget
- [FOLIO_VOLT_FILAMENT_INTEGRATION.md](../../FOLIO_VOLT_FILAMENT_INTEGRATION.md) - Integrazione Folio, Volt e Filament
- [MODULE_STRUCTURE.md](../../MODULE_STRUCTURE.md) - Struttura standard dei moduli
- [Documentazione Filament](https://filamentphp.com/project_docs/3.x/widgets/installation)
