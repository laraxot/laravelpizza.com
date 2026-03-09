# Guida Completa ai Provider di Notifiche

Questo documento fornisce una panoramica completa dell'architettura standardizzata per tutti i provider di notifiche supportati nel modulo Notify di <nome progetto>.

## Principi Architetturali per Tutti i Provider

I seguenti principi si applicano a **tutti** i provider di notifiche (SMS, Email, WhatsApp):

1. **Struttura Directory Standardizzata**:
   - Interfacce: `/app/Contracts/`
   - Implementazioni: `/app/Actions/{Type}/`
   - Data Transfer Objects: `/app/Datas/`
   - Configurazioni: `/config/{type}.php`

2. **Nomenclatura Coerente**:
   - Interfacce: `{Type}ProviderActionInterface`
   - Azioni: `Send{Provider}{Type}Action`
   - DTO: `{Type}Data`

3. **Implementazione Interfacce**:
   - Ogni provider DEVE implementare l'interfaccia specifica
   - Ogni provider DEVE accettare il DTO appropriato nel metodo `execute()`

## Panoramica dei Provider Supportati

| Tipo di Provider | Interfaccia | Directory Azioni | DTO |
|------------------|-------------|-----------------|-----|
| SMS | `SmsProviderActionInterface` | `/app/Actions/SMS/` | `SmsData` |
| Email | `EmailProviderActionInterface` | `/app/Actions/Email/` | `EmailData` |
| WhatsApp | `WhatsAppProviderActionInterface` | `/app/Actions/WhatsApp/` | `WhatsAppData` |

## Implementazione Standardizzata

### 1. Definizione dell'Interfaccia Provider

```php
// app/Contracts/{Type}ProviderActionInterface.php
namespace Modules\Notify\Contracts;

use Modules\Notify\Datas\{Type}Data;

interface {Type}ProviderActionInterface
{
    public function execute({Type}Data $data): array;
}
```

### 2. Implementazione Provider

```php
// app/Actions/{Type}/Send{Provider}{Type}Action.php
namespace Modules\Notify\Actions\{Type};

use Modules\Notify\Contracts\{Type}ProviderActionInterface;
use Modules\Notify\Datas\{Type}Data;
use Spatie\QueueableAction\QueueableAction;

final class Send{Provider}{Type}Action implements {Type}ProviderActionInterface
{
    use QueueableAction;

    // Costruttore con configurazione

    // Metodo execute standardizzato
    public function execute({Type}Data $data): array
    {
        // Implementazione specifica del provider
    }
}
```

### 3. Configurazione Provider

```php
// config/{type}.php
return [
    'default' => env('{TYPE}_PROVIDER', 'default_provider'),

    'providers' => [
        'provider1' => [
            // Configurazione specifica
        ],
        'provider2' => [
            // Configurazione specifica
        ],
    ],

    // Parametri globali
    'from' => env('{TYPE}_FROM'),
    'debug' => (bool) env('{TYPE}_DEBUG', false),
    'timeout' => (int) env('{TYPE}_TIMEOUT', 30),
];
```

### 4. Canale di Notifica Laravel

```php
// app/Channels/{Type}Channel.php
namespace Modules\Notify\Channels;

use Illuminate\Notifications\Notification;
use Modules\Notify\Datas\{Type}Data;

class {Type}Channel
{
    public function send($notifiable, Notification $notification): ?array
    {
        // Recupero provider dalla configurazione
        // Esecuzione azione appropriata
    }
}
```

## Flusso di Implementazione per Nuovi Provider

Quando si implementa un nuovo provider (es. WhatsApp, Push, ecc.):

1. **Creare l'Interfaccia** in `/app/Contracts/`
2. **Creare il DTO** in `/app/Datas/`
3. **Creare le Azioni Provider** in `/app/Actions/{Type}/`
4. **Creare la Configurazione** in `/config/{type}.php`
5. **Creare il Canale** in `/app/Channels/`
6. **Documentare** in `/docs/`

## Conclusioni e Migliori Pratiche

1. **Consistenza Architetturale**: Mantenere la stessa struttura per tutti i provider
2. **Single Responsibility**: Ogni classe ha una responsabilità specifica
3. **Dependency Injection**: Utilizzare DI per configurazioni e dipendenze
4. **Testing**: Creare test per ogni provider e canale
5. **Documentazione**: Mantenere aggiornata la documentazione con nuovi provider

Per implementazioni specifiche, vedere i documenti:
- [PROVIDER_ACTIONS_ARCHITECTURE.md](./PROVIDER_ACTIONS_ARCHITECTURE.md)
- [SMS_ACTIONS_PATTERN.md](./SMS_ACTIONS_PATTERN.md)
- [WHATSAPP_PROVIDER_ARCHITECTURE.md](./WHATSAPP_PROVIDER_ARCHITECTURE.md)
