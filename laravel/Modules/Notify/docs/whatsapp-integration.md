# Integrazione WhatsApp 

## Panoramica

Questo documento descrive l'architettura e l'implementazione dell'integrazione WhatsApp nel modulo Notify di , seguendo gli stessi standard e pattern utilizzati per l'invio di email e SMS.
Questo documento descrive l'architettura e l'implementazione dell'integrazione WhatsApp nel modulo Notify di <nome progetto>, seguendo gli stessi standard e pattern utilizzati per l'invio di email e SMS.

## Architettura

L'integrazione WhatsApp segue la stessa architettura modulare utilizzata per SMS ed email, basata su:

1. **Interfaccia comune** (`WhatsAppProviderActionInterface`)
2. **Implementazioni specifiche per provider** (`Send{Provider}WhatsAppAction`)
3. **Data Transfer Objects** (DTO) per i dati dei messaggi
4. **Configurazione standardizzata** nel file `config/whatsapp.php`

## 1. Interfaccia Comune

Tutte le azioni di invio WhatsApp devono implementare l'interfaccia `WhatsAppProviderActionInterface`:

```php
<?php

declare(strict_types=1);

namespace Modules\Notify\Contracts;

use Modules\Notify\Datas\WhatsAppData;

/**
 * Interface per tutte le azioni di invio WhatsApp.
 * 
 * Tutte le implementazioni di provider WhatsApp devono implementare questa interfaccia
 * per garantire una coerenza nel modo in cui vengono gestiti i messaggi WhatsApp
 * indipendentemente dal provider specifico utilizzato.
 */
interface WhatsAppProviderActionInterface
{
    /**
     * Invia un messaggio WhatsApp utilizzando il provider specifico.
     *
     * @param WhatsAppData $whatsAppData I dati del messaggio WhatsApp da inviare
     * @return array Risultato dell'operazione con almeno la chiave 'success'
     * @throws \Exception Se l'invio fallisce per motivi tecnici
     */
    public function execute(WhatsAppData $whatsAppData): array;
}
```

## 2. Data Transfer Object (DTO)

Per standardizzare i dati dei messaggi WhatsApp, utilizziamo un DTO dedicato:

```php
<?php

declare(strict_types=1);

namespace Modules\Notify\Datas;

use Spatie\LaravelData\Data;

class WhatsAppData extends Data
{
    public function __construct(
        public string $to,
        public string $body,
        public ?string $from = null,
        public ?array $media = null,
        public ?array $buttons = null,
        public ?array $template = null,
        public ?string $type = 'text',
    ) {}
}
```

## 3. Configurazione

La configurazione per i provider WhatsApp segue lo stesso pattern standardizzato utilizzato per SMS ed email:

```php
// config/whatsapp.php
return [
    /*
    |--------------------------------------------------------------------------
    | Default WhatsApp Driver
    |--------------------------------------------------------------------------
    |
    | Supported drivers: "twilio", "vonage", "facebook", "360dialog"
    |
    */
    'default' => env('WHATSAPP_DRIVER', 'twilio'),

    /*
    |--------------------------------------------------------------------------
    | WhatsApp Drivers
    |--------------------------------------------------------------------------
    */
    'drivers' => [
        'twilio' => [
            'account_sid' => env('TWILIO_ACCOUNT_SID'),
            'auth_token' => env('TWILIO_AUTH_TOKEN'),
            'from' => env('TWILIO_WHATSAPP_FROM'),
        ],
        
        'vonage' => [
            'api_key' => env('VONAGE_KEY'),
            'api_secret' => env('VONAGE_SECRET'),
            'from' => env('VONAGE_WHATSAPP_FROM'),
        ],
        
        'facebook' => [
            'app_id' => env('FACEBOOK_APP_ID'),
            'app_secret' => env('FACEBOOK_APP_SECRET'),
            'access_token' => env('FACEBOOK_ACCESS_TOKEN'),
            'phone_number_id' => env('FACEBOOK_PHONE_NUMBER_ID'),
        ],
        
        '360dialog' => [
            'api_key' => env('360DIALOG_API_KEY'),
            'phone_number_id' => env('360DIALOG_PHONE_NUMBER_ID'),
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Global Debug Mode
    |--------------------------------------------------------------------------
    */
    'debug' => env('WHATSAPP_DEBUG', false),

    /*
    |--------------------------------------------------------------------------
    | WhatsApp Queue
    |--------------------------------------------------------------------------
    */
    'queue' => env('WHATSAPP_QUEUE', 'default'),

    /*
    |--------------------------------------------------------------------------
    | Global Timeout
    |--------------------------------------------------------------------------
    */
    'timeout' => env('WHATSAPP_TIMEOUT', 30),

    /*
    |--------------------------------------------------------------------------
    | Default Sender
    |--------------------------------------------------------------------------
    */
    'from' => env('WHATSAPP_FROM'),

    /*
    |--------------------------------------------------------------------------
    | Retry Configuration
    |--------------------------------------------------------------------------
    */
    'retry' => [
        'attempts' => env('WHATSAPP_RETRY_ATTEMPTS', 3),
        'delay' => env('WHATSAPP_RETRY_DELAY', 60),
    ],

    /*
    |--------------------------------------------------------------------------
    | Rate Limiting
    |--------------------------------------------------------------------------
    */
    'rate_limit' => [
        'enabled' => env('WHATSAPP_RATE_LIMIT_ENABLED', true),
        'max_attempts' => env('WHATSAPP_RATE_LIMIT_MAX_ATTEMPTS', 60),
        'decay_minutes' => env('WHATSAPP_RATE_LIMIT_DECAY_MINUTES', 1),
    ],
];
```

## 4. Implementazioni per Provider

### 4.1 Twilio

```php
<?php

declare(strict_types=1);

namespace Modules\Notify\Actions\WhatsApp;

use Exception;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use Illuminate\Support\Facades\Log;
use Modules\Notify\Contracts\WhatsAppProviderActionInterface;
use Modules\Notify\Datas\WhatsAppData;
use Spatie\QueueableAction\QueueableAction;

final class SendTwilioWhatsAppAction implements WhatsAppProviderActionInterface
{
    use QueueableAction;

    private string $accountSid;
    private string $authToken;
    private string $baseUrl = 'https://api.twilio.com/2010-04-01';
    private array $vars = [];
    protected bool $debug;
    protected int $timeout;
    protected ?string $defaultSender;

    public function __construct()
    {
        $accountSid = config('services.twilio.account_sid');
        if (!is_string($accountSid)) {
            throw new Exception('put [TWILIO_ACCOUNT_SID] variable to your .env and config [services.twilio.account_sid]');
        }
        $this->accountSid = $accountSid;

        $authToken = config('services.twilio.auth_token');
        if (!is_string($authToken)) {
            throw new Exception('put [TWILIO_AUTH_TOKEN] variable to your .env and config [services.twilio.auth_token]');
        }
        $this->authToken = $authToken;

        // Parametri a livello di root
        $this->defaultSender = config('whatsapp.from');
        $this->debug = (bool) config('whatsapp.debug', false);
        $this->timeout = (int) config('whatsapp.timeout', 30);
    }

    public function execute(WhatsAppData $whatsAppData): array
    {
        $from = 'whatsapp:' . ($whatsAppData->from ?? $this->defaultSender);
        $to = 'whatsapp:' . $whatsAppData->to;
        
        $client = new Client([
            'timeout' => $this->timeout,
            'auth' => [$this->accountSid, $this->authToken]
        ]);
        
        $endpoint = $this->baseUrl . '/Accounts/' . $this->accountSid . '/Messages.json';
        
        $payload = [
            'To' => $to,
            'From' => $from,
            'Body' => $whatsAppData->body,
        ];
        
        // Aggiungi media se presente
        if (!empty($whatsAppData->media)) {
            $payload['MediaUrl'] = $whatsAppData->media[0];
        }
        
        try {
            $response = $client->post($endpoint, [
                'form_params' => $payload
            ]);
            
            $this->vars['status_code'] = $response->getStatusCode();
            $this->vars['status_txt'] = $response->getBody()->getContents();
            
            return [
                'success' => true,
                'message_id' => json_decode($this->vars['status_txt'], true)['sid'] ?? null,
                'vars' => $this->vars,
            ];
        } catch (ClientException $clientException) {
            throw new Exception(
                $clientException->getMessage() . '[' . __LINE__ . '][' . class_basename($this) . ']',
                $clientException->getCode(),
                $clientException
            );
        }
    }
}
```

### 4.2 Facebook (Meta)

```php
<?php

declare(strict_types=1);

namespace Modules\Notify\Actions\WhatsApp;

use Exception;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use Illuminate\Support\Facades\Log;
use Modules\Notify\Contracts\WhatsAppProviderActionInterface;
use Modules\Notify\Datas\WhatsAppData;
use Spatie\QueueableAction\QueueableAction;

final class SendFacebookWhatsAppAction implements WhatsAppProviderActionInterface
{
    use QueueableAction;

    private string $accessToken;
    private string $phoneNumberId;
    private string $baseUrl = 'https://graph.facebook.com/v17.0';
    private array $vars = [];
    protected bool $debug;
    protected int $timeout;

    public function __construct()
    {
        $accessToken = config('services.facebook.access_token');
        if (!is_string($accessToken)) {
            throw new Exception('put [FACEBOOK_ACCESS_TOKEN] variable to your .env and config [services.facebook.access_token]');
        }
        $this->accessToken = $accessToken;

        $phoneNumberId = config('services.facebook.phone_number_id');
        if (!is_string($phoneNumberId)) {
            throw new Exception('put [FACEBOOK_PHONE_NUMBER_ID] variable to your .env and config [services.facebook.phone_number_id]');
        }
        $this->phoneNumberId = $phoneNumberId;

        // Parametri a livello di root
        $this->debug = (bool) config('whatsapp.debug', false);
        $this->timeout = (int) config('whatsapp.timeout', 30);
    }

    public function execute(WhatsAppData $whatsAppData): array
    {
        $client = new Client([
            'timeout' => $this->timeout,
            'headers' => [
                'Authorization' => 'Bearer ' . $this->accessToken,
                'Content-Type' => 'application/json',
            ]
        ]);
        
        $endpoint = $this->baseUrl . '/' . $this->phoneNumberId . '/messages';
        
        $payload = [
            'messaging_product' => 'whatsapp',
            'recipient_type' => 'individual',
            'to' => $whatsAppData->to,
        ];
        
        // Gestione diversi tipi di messaggi
        if ($whatsAppData->type === 'text') {
            $payload['type'] = 'text';
            $payload['text'] = [
                'preview_url' => false,
                'body' => $whatsAppData->body,
            ];
        } elseif ($whatsAppData->type === 'template' && !empty($whatsAppData->template)) {
            $payload['type'] = 'template';
            $payload['template'] = $whatsAppData->template;
        } elseif ($whatsAppData->type === 'media' && !empty($whatsAppData->media)) {
            $payload['type'] = 'image'; // o video, document, audio
            $payload['image'] = [
                'link' => $whatsAppData->media[0],
            ];
        }
        
        try {
            $response = $client->post($endpoint, [
                'json' => $payload
            ]);
            
            $this->vars['status_code'] = $response->getStatusCode();
            $this->vars['status_txt'] = $response->getBody()->getContents();
            
            $responseData = json_decode($this->vars['status_txt'], true);
            
            return [
                'success' => true,
                'message_id' => $responseData['messages'][0]['id'] ?? null,
                'vars' => $this->vars,
            ];
        } catch (ClientException $clientException) {
            throw new Exception(
                $clientException->getMessage() . '[' . __LINE__ . '][' . class_basename($this) . ']',
                $clientException->getCode(),
                $clientException
            );
        }
    }
}
```

## 5. Regola Fondamentale: Corrispondenza Driver-Azione

**Per ogni driver configurato in `config/whatsapp.php` deve esistere una corrispondente azione in `app/Actions/WhatsApp/`.**

Esempio:
- Driver `twilio` → Azione `SendTwilioWhatsAppAction`
- Driver `facebook` → Azione `SendFacebookWhatsAppAction`
- Driver `vonage` → Azione `SendVonageWhatsAppAction`

## 6. Utilizzo

### 6.1 Invio Diretto

```php
use Modules\Notify\Actions\WhatsApp\SendTwilioWhatsAppAction;
use Modules\Notify\Datas\WhatsAppData;

$action = app(SendTwilioWhatsAppAction::class);

$whatsAppData = new WhatsAppData(
    to: '+393401234567',
    body: 'Questo è un messaggio di test da ',
    body: 'Questo è un messaggio di test da <nome progetto>',
);

$result = $action->execute($whatsAppData);
```

### 6.2 Utilizzo con Notifiche Laravel

```php
<?php

namespace Modules\Notify\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Notification;
use Modules\Notify\Channels\WhatsAppChannel;
use Modules\Notify\Datas\WhatsAppData;

class AppointmentReminder extends Notification implements ShouldQueue
{
    use Queueable;

    private $appointment;

    public function __construct($appointment)
    {
        $this->appointment = $appointment;
    }

    public function via($notifiable)
    {
        return [WhatsAppChannel::class];
    }

    public function toWhatsApp($notifiable)
    {
        return new WhatsAppData(
            to: $notifiable->phone_number,
            body: "Promemoria: hai un appuntamento il {$this->appointment->date->format('d/m/Y')} alle {$this->appointment->time}.",
        );
    }
}
```

## 7. Implementazione del Canale di Notifica

```php
<?php

namespace Modules\Notify\Channels;

use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Config;
use Modules\Notify\Actions\WhatsApp\SendTwilioWhatsAppAction;
use Modules\Notify\Actions\WhatsApp\SendFacebookWhatsAppAction;
use Modules\Notify\Actions\WhatsApp\SendVonageWhatsAppAction;
use Modules\Notify\Actions\WhatsApp\Send360dialogWhatsAppAction;

class WhatsAppChannel
{
    public function send($notifiable, Notification $notification)
    {
        if (! method_exists($notification, 'toWhatsApp')) {
            throw new \Exception('Notification does not have toWhatsApp method');
        }

        $whatsAppData = $notification->toWhatsApp($notifiable);
        
        $driver = Config::get('whatsapp.default', 'twilio');
        
        $action = match ($driver) {
            'twilio' => app(SendTwilioWhatsAppAction::class),
            'facebook' => app(SendFacebookWhatsAppAction::class),
            'vonage' => app(SendVonageWhatsAppAction::class),
            '360dialog' => app(Send360dialogWhatsAppAction::class),
            default => throw new \Exception("Unsupported WhatsApp driver: {$driver}"),
        };
        
        return $action->execute($whatsAppData);
    }
}
```

## 8. Test e Debugging

Per facilitare il testing e il debugging dell'integrazione WhatsApp, è consigliabile implementare un driver di log che non invia effettivamente messaggi ma li registra solo nei log:

```php
<?php

declare(strict_types=1);

namespace Modules\Notify\Actions\WhatsApp;

use Illuminate\Support\Facades\Log;
use Modules\Notify\Contracts\WhatsAppProviderActionInterface;
use Modules\Notify\Datas\WhatsAppData;
use Spatie\QueueableAction\QueueableAction;

final class SendLogWhatsAppAction implements WhatsAppProviderActionInterface
{
    use QueueableAction;

    public function execute(WhatsAppData $whatsAppData): array
    {
        Log::channel('whatsapp')->info('WhatsApp message would be sent', [
            'to' => $whatsAppData->to,
            'body' => $whatsAppData->body,
            'from' => $whatsAppData->from,
            'media' => $whatsAppData->media,
            'template' => $whatsAppData->template,
            'type' => $whatsAppData->type,
        ]);
        
        return [
            'success' => true,
            'message_id' => 'log-' . uniqid(),
            'vars' => [],
        ];
    }
}
```

## 9. Conclusioni

L'integrazione WhatsApp  segue gli stessi pattern e standard utilizzati per l'invio di email e SMS, garantendo:

1. **Coerenza**: Tutte le azioni WhatsApp hanno la stessa interfaccia
2. **Manutenibilità**: Il codice è più facile da mantenere e aggiornare
3. **Estensibilità**: È facile aggiungere nuovi provider WhatsApp
4. **Testabilità**: Le azioni sono facilmente testabili grazie all'interfaccia comune

Seguendo questa architettura, l'integrazione WhatsApp si inserisce perfettamente nell'ecosistema di notifiche di , mantenendo la coerenza con le altre modalità di comunicazione.
Seguendo questa architettura, l'integrazione WhatsApp si inserisce perfettamente nell'ecosistema di notifiche di <nome progetto>, mantenendo la coerenza con le altre modalità di comunicazione.

---

*Ultimo aggiornamento: 2023-05-12*
