# Configurazione Provider SMS per le Notifiche 

Questa documentazione descrive le opzioni disponibili per l'integrazione di servizi SMS nei sistemi di notifica di <nome progetto>, con focus sui diversi provider e sulla loro configurazione.
Questa documentazione descrive le opzioni disponibili per l'integrazione di servizi SMS nei sistemi di notifica di <nome progetto>, con focus sui diversi provider e sulla loro configurazione.

## Indice

- [Panoramica Provider SMS](#panoramica-provider-sms)
- [Twilio](#twilio)
- [Vonage (ex Nexmo)](#vonage-ex-nexmo)
- [Plivo](#plivo)
- [Provider Italiani](#provider-italiani)
- [Implementazione Custom Channel](#implementazione-custom-channel)
- [Testing e Simulazione](#testing-e-simulazione)
- [Best Practices](#best-practices)

## Panoramica Provider SMS

| Provider | Pro | Contro | Best per |
|----------|-----|--------|----------|
| Twilio | API robusta, supporto globale, documentazione eccellente | Costo più elevato | Progetti enterprise, copertura globale |
| Vonage | Buona copertura in Europa, API semplice | Documentazione meno dettagliata | Progetti medi, focus europeo |
| Plivo | Tariffe competitive, buona qualità | Copertura minore in alcuni paesi | Progetti con budget limitato |
| SMShosting | Provider italiano, supporto locale | Copertura principalmente italiana | Progetti locali italiani |
| Telcob | Ottimizzato per il mercato italiano | API meno estesa | Cliniche e strutture sanitarie in Italia |

## Twilio

### Installazione

```bash
composer require laravel-notification-channels/twilio
```

### Configurazione

```php
// config/services.php
'twilio' => [
    'account_sid' => env('TWILIO_ACCOUNT_SID'),
    'auth_token' => env('TWILIO_AUTH_TOKEN'),
    'from' => env('TWILIO_FROM_NUMBER'),
],
```

```dotenv

# .env
TWILIO_ACCOUNT_SID=AC123...
TWILIO_AUTH_TOKEN=abc123...
TWILIO_FROM_NUMBER=+39XXXXXXXXXX
```

### Implementazione Notifica

```php
use NotificationChannels\Twilio\TwilioChannel;
use NotificationChannels\Twilio\TwilioSmsMessage;

class AppointmentNotification extends Notification
{
    public function via($notifiable)
    {
        return ['mail', TwilioChannel::class];
    }
    
    public function toTwilio($notifiable)
    {
        return (new TwilioSmsMessage())
            ->content("Il tuo appuntamento è stato confermato per il {$this->appointment->date}.");
    }
}
```

### Configurazione Notifiable

```php
// App/Models/User.php
public function routeNotificationForTwilio()
{
    // Assicurati che il numero sia in formato E.164
    return '+39' . ltrim($this->phone_number, '0');
}
```

## Vonage (ex Nexmo)

### Installazione

```bash
composer require laravel-notification-channels/vonage
```

### Configurazione

```php
// config/services.php
'vonage' => [
    'key' => env('VONAGE_KEY'),
    'secret' => env('VONAGE_SECRET'),
    'sms_from' => env('VONAGE_SMS_FROM'),
],
```

```dotenv

# .env
VONAGE_KEY=abcd1234
VONAGE_SECRET=xyz789...
VONAGE_SMS_FROM=<nome progetto>
VONAGE_SMS_FROM=<nome progetto>
```

### Implementazione Notifica

```php
use NotificationChannels\Vonage\VonageChannel;
use NotificationChannels\Vonage\VonageMessage;

class AppointmentNotification extends Notification
{
    public function via($notifiable)
    {
        return ['mail', VonageChannel::class];
    }
    
    public function toVonage($notifiable)
    {
        return (new VonageMessage())
            ->content("Il tuo appuntamento è stato confermato per il {$this->appointment->date}.");
    }
}
```

### Configurazione Notifiable

```php
public function routeNotificationForVonage()
{
    return $this->phone_number;
}
```

## Plivo

### Installazione

Plivo non ha un pacchetto Laravel ufficiale, ma può essere implementato come canale custom.

```bash
composer require plivo/plivo-php
```

### Creazione Channel Custom

```php
namespace Modules\Notify\Channels;

use Illuminate\Notifications\Notification;
use Plivo\RestClient;

class PlivoChannel
{
    protected $client;

    public function __construct(RestClient $client)
    {
        $this->client = $client;
    }

    public function send($notifiable, Notification $notification)
    {
        if (! $to = $notifiable->routeNotificationFor('plivo')) {
            return;
        }

        $message = $notification->toPlivo($notifiable);

        $this->client->messages->create(
            config('services.plivo.from'),
            [$to],
            $message->content
        );
    }
}
```

### Configurazione

```php
// config/services.php
'plivo' => [
    'auth_id' => env('PLIVO_AUTH_ID'),
    'auth_token' => env('PLIVO_AUTH_TOKEN'),
    'from' => env('PLIVO_FROM_NUMBER'),
],
```

```dotenv

# .env
PLIVO_AUTH_ID=MAXXXXXXXXXXXXXXXXXX
PLIVO_AUTH_TOKEN=ZmIwZTcyZWVkY2UXXXXXXXXXXXXXXXXX
PLIVO_FROM_NUMBER=+39XXXXXXXXXX
```

### Implementazione ServiceProvider

```php
namespace Modules\Notify\Providers;

use Illuminate\Support\ServiceProvider;
use Modules\Notify\Channels\PlivoChannel;
use Plivo\RestClient;

class PlivoServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->singleton(PlivoChannel::class, function ($app) {
            return new PlivoChannel(
                new RestClient(
                    config('services.plivo.auth_id'),
                    config('services.plivo.auth_token')
                )
            );
        });
    }
}
```

## Provider Italiani

### SMShosting

Un provider italiano con API ben documentata e supporto per Laravel.

#### Installazione

```bash
composer require smshosting/smshosting-php-sdk
```

#### Implementazione

```php
namespace Modules\Notify\Channels;

use Illuminate\Notifications\Notification;
use SMSHosting\Rest\Client as SMSHostingClient;

class SMSHostingChannel
{
    protected $client;

    public function __construct(SMSHostingClient $client)
    {
        $this->client = $client;
    }

    public function send($notifiable, Notification $notification)
    {
        if (! $to = $notifiable->routeNotificationFor('smshosting')) {
            return;
        }

        $message = $notification->toSMSHosting($notifiable);

        $this->client->messages->send([
            'to' => $to,
            'text' => $message->content,
            'from' => config('services.smshosting.sender'),
        ]);
    }
}
```

### Telcob

Telcob è un provider SMS italiano specifico per il settore sanitario.

#### Configurazione API

```php
// config/services.php
'telcob' => [
    'key' => env('TELCOB_API_KEY'),
    'sender' => env('TELCOB_SENDER'),
],
```

## Implementazione Custom Channel

Se nessuno dei provider esistenti soddisfa le esigenze, è possibile implementare un canale personalizzato.

### Creazione Messaggio

```php
namespace Modules\Notify\Messages;

class SMSMessage
{
    protected $content;
    protected $options = [];

    public function __construct(string $content = '')
    {
        $this->content = $content;
    }

    public function content(string $content): self
    {
        $this->content = $content;

        return $this;
    }

    public function option(string $key, $value): self
    {
        $this->options[$key] = $value;

        return $this;
    }

    public function getContent(): string
    {
        return $this->content;
    }

    public function getOptions(): array
    {
        return $this->options;
    }
}
```

### Creazione Channel

```php
namespace Modules\Notify\Channels;

use Illuminate\Notifications\Notification;
use GuzzleHttp\Client as HttpClient;

class CustomSMSChannel
{
    protected $client;
    protected $baseUrl;
    protected $apiKey;

    public function __construct(HttpClient $client, string $baseUrl, string $apiKey)
    {
        $this->client = $client;
        $this->baseUrl = $baseUrl;
        $this->apiKey = $apiKey;
    }

    public function send($notifiable, Notification $notification)
    {
        if (! $to = $notifiable->routeNotificationFor('sms')) {
            return;
        }

        $message = $notification->toSMS($notifiable);

        return $this->client->post("{$this->baseUrl}/send", [
            'headers' => [
                'Authorization' => "Bearer {$this->apiKey}",
                'Content-Type' => 'application/json',
            ],
            'json' => [
                'to' => $to,
                'message' => $message->getContent(),
                'from' => config('services.sms.sender'),
                'options' => $message->getOptions(),
            ],
        ]);
    }
}
```

## Testing e Simulazione

Per testare l'invio di SMS senza utilizzare un servizio reale:

### Creazione Driver di Test

```php
namespace Modules\Notify\Testing;

use Modules\Notify\Channels\CustomSMSChannel;

class TestSMSChannel extends CustomSMSChannel
{
    public $messages = [];

    public function send($notifiable, $notification)
    {
        if (! $to = $notifiable->routeNotificationFor('sms')) {
            return;
        }

        $message = $notification->toSMS($notifiable);

        $this->messages[] = [
            'to' => $to,
            'content' => $message->getContent(),
            'options' => $message->getOptions(),
        ];
    }
}
```

### Configurazione per Test

```php
// In un service provider
$this->app->bind(CustomSMSChannel::class, function ($app) {
    if ($app->environment('testing')) {
        return new TestSMSChannel();
    }
    
    return new CustomSMSChannel(
        new HttpClient(),
        config('services.sms.base_url'),
        config('services.sms.api_key')
    );
});
```

## Best Practices

1. **Formattazione Numeri**: Standardizza sempre i numeri in formato E.164 (+39XXXXXXXXXX).

2. **Gestione Fallimenti**: Implementa logica per gestire fallimenti nell'invio.

3. **Controllo Lunghezza**: Gli SMS hanno un limite di caratteri, verifica la lunghezza.

4. **Contenuto Appropriato**: Evita caratteri speciali o emoji che potrebbero causare problemi.

5. **Rate Limiting**: Implementa limiti di invio per evitare abusi o costi eccessivi.

6. **Conformità GDPR**: Includi sempre un modo per disiscriversi dalle comunicazioni SMS.

7. **Monitoraggio Costi**: Implementa un sistema di tracking per monitorare i costi degli SMS.

8. **Validazione Numeri**: Valida i numeri di telefono prima dell'invio.

9. **Queueing**: Utilizza le code per invii massivi.

```php
class AppointmentNotification extends Notification implements ShouldQueue
{
    // Implementazione...
}
```

10. **Logging**: Registra tutti i tentativi di invio, successi e fallimenti.

```php
Log::info('SMS sent', [
    'to' => $to,
    'message' => $message->getContent(),
    'status' => $response->getStatusCode(),
]);
```

## Collegamenti alla Documentazione Correlata

- [MULTI_CHANNEL_NOTIFICATIONS.md](./MULTI_CHANNEL_NOTIFICATIONS.md)
- [NOTIFICATIONS_IMPLEMENTATION_GUIDE.md](./NOTIFICATIONS_IMPLEMENTATION_GUIDE.md)
- [TELEGRAM_NOTIFICATIONS_GUIDE.md](./TELEGRAM_NOTIFICATIONS_GUIDE.md)
