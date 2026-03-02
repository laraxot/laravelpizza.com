# Architettura WhatsApp Provider per

Questo documento definisce l'architettura e gli standard per l'implementazione dei provider WhatsApp nel modulo Notify di , mantenendo coerenza con le architetture esistenti per SMS ed email.
# Architettura WhatsApp Provider per <nome progetto>

Questo documento definisce l'architettura e gli standard per l'implementazione dei provider WhatsApp nel modulo Notify di <nome progetto>, mantenendo coerenza con le architetture esistenti per SMS ed email.

## Principi Architetturali Fondamentali

L'architettura dei provider WhatsApp segue gli stessi principi dei provider SMS ed email, rispettando i seguenti punti:

1. **Separazione delle Interfacce**: Le interfacce sono definite in `app/Contracts/`, mai nelle directory di implementazione
2. **Implementazioni in Directory Dedicate**: Tutte le azioni di provider sono in `app/Actions/WhatsApp/`
3. **Data Transfer Objects (DTO)**: Utilizzo di DTO specifici per i messaggi WhatsApp in `app/Datas/`
4. **Configurazione Centralizzata**: Configurazione in `config/whatsapp.php`

## Struttura Directory e Namespace

```
Modules/Notify/
Modules/Notify/
Modules/Notify/
├── app/
│   ├── Actions/
│   │   └── WhatsApp/
│   │       ├── SendTwilioWhatsAppAction.php
│   │       ├── SendMeta360WhatsAppAction.php
│   │       └── SendVonageWhatsAppAction.php
│   ├── Contracts/
│   │   └── WhatsAppProviderActionInterface.php
│   ├── Datas/
│   │   └── WhatsAppData.php
│   └── Channels/
│       └── WhatsAppChannel.php
└── config/
    └── whatsapp.php
```

## Interfaccia del Provider WhatsApp

```php
<?php

declare(strict_types=1);

namespace Modules\Notify\Contracts;

use Modules\Notify\Datas\WhatsAppData;

/**
 * Interfaccia per tutte le azioni di invio WhatsApp.
 *
 * Tutte le implementazioni di provider WhatsApp devono implementare questa interfaccia
 * per garantire una coerenza nel modo in cui vengono gestiti i messaggi
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

## Data Transfer Object per WhatsApp

```php
<?php

declare(strict_types=1);

namespace Modules\Notify\Datas;

class WhatsAppData
{
    /**
     * @param string $to Numero di telefono del destinatario in formato internazionale E.164 (es. +393401234567)
     * @param string $from Numero di telefono o ID mittente (specifico del provider)
     * @param string $body Testo del messaggio
     * @param array $attachments Array di allegati (opzionale)
     * @param array $interactive Componenti interattivi come bottoni o liste (opzionale)
     * @param array $template Informazioni sul template da utilizzare (opzionale)
     * @param array $context Dati di contesto per il messaggio (opzionale)
     */
    public function __construct(
        public readonly string $to,
        public readonly string $from,
        public readonly string $body,
        public readonly array $attachments = [],
        public readonly array $interactive = [],
        public readonly array $template = [],
        public readonly array $context = []
    ) {
    }
}
```

## Configurazione WhatsApp

```php
// config/whatsapp.php

return [
    'default' => env('WHATSAPP_PROVIDER', 'twilio'),

    'providers' => [
        'twilio' => [
            'account_sid' => env('TWILIO_ACCOUNT_SID'),
            'auth_token' => env('TWILIO_AUTH_TOKEN'),
            'from_phone_number' => env('TWILIO_WHATSAPP_FROM'),
            'edge' => env('TWILIO_EDGE', 'frankfurt'),
        ],

        'meta360' => [
            'app_id' => env('META_APP_ID'),
            'app_secret' => env('META_APP_SECRET'),
            'business_account_id' => env('META_BUSINESS_ACCOUNT_ID'),
            'phone_number_id' => env('META_PHONE_NUMBER_ID'),
            'access_token' => env('META_WHATSAPP_ACCESS_TOKEN'),
        ],

        'vonage' => [
            'api_key' => env('VONAGE_API_KEY'),
            'api_secret' => env('VONAGE_API_SECRET'),
            'from_number' => env('VONAGE_WHATSAPP_FROM'),
        ],
    ],

    // Configurazioni globali per tutti i provider
    'from' => env('WHATSAPP_FROM'),
    'debug' => (bool) env('WHATSAPP_DEBUG', false),
    'timeout' => (int) env('WHATSAPP_TIMEOUT', 30),
    'retry' => [
        'enabled' => (bool) env('WHATSAPP_RETRY_ENABLED', true),
        'attempts' => (int) env('WHATSAPP_RETRY_ATTEMPTS', 3),
        'delay' => (int) env('WHATSAPP_RETRY_DELAY', 5),
    ],
];
```

## Implementazione dei Provider WhatsApp

### Provider Twilio (Esempio)

```php
<?php

declare(strict_types=1);

namespace Modules\Notify\Actions\WhatsApp;

use Exception;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Modules\Notify\Contracts\WhatsAppProviderActionInterface;
use Modules\Notify\Datas\WhatsAppData;
use Spatie\QueueableAction\QueueableAction;

final class SendTwilioWhatsAppAction implements WhatsAppProviderActionInterface
{
    use QueueableAction;

    private string $accountSid;
    private string $authToken;
    private string $fromPhoneNumber;
    private string $edge;
    private bool $debug;
    private int $timeout;

    /**
     * Create a new action instance.
     *
     * @throws Exception Se le credenziali non sono configurate
     */
    public function __construct()
    {
        $accountSid = config('whatsapp.providers.twilio.account_sid');
        $authToken = config('whatsapp.providers.twilio.auth_token');

        if (!is_string($accountSid) || !is_string($authToken)) {
            throw new Exception('Twilio Account SID e Auth Token devono essere configurati in config/whatsapp.php');
        }

        $this->accountSid = $accountSid;
        $this->authToken = $authToken;
        $this->fromPhoneNumber = config('whatsapp.providers.twilio.from_phone_number') ?? config('whatsapp.from');
        $this->edge = config('whatsapp.providers.twilio.edge', 'frankfurt');

        // Parametri globali
        $this->debug = (bool) config('whatsapp.debug', false);
        $this->timeout = (int) config('whatsapp.timeout', 30);
    }

    /**
     * Execute the action.
     *
     * @param WhatsAppData $whatsAppData I dati del messaggio WhatsApp
     * @return array Risultato dell'operazione
     * @throws Exception In caso di errore durante l'invio
     */
    public function execute(WhatsAppData $whatsAppData): array
    {
        // Normalizza il numero di telefono
        $to = $this->normalizePhoneNumber($whatsAppData->to);

        // Crea il client Twilio
        $client = new Client([
            'base_uri' => "https://api.{$this->edge}.twilio.com/2010-04-01/",
            'auth' => [$this->accountSid, $this->authToken],
            'timeout' => $this->timeout,
            'http_errors' => false,
        ]);

        // Prepara il payload del messaggio
        $from = "whatsapp:{$whatsAppData->from}";
        $to = "whatsapp:{$to}";

        try {
            $payload = [
                'form_params' => [
                    'From' => $from,
                    'To' => $to,
                    'Body' => $whatsAppData->body,
                ],
            ];

            // Gestione degli allegati
            if (!empty($whatsAppData->attachments)) {
                $payload['form_params']['MediaUrl'] = $whatsAppData->attachments[0];
            }

            // Invia la richiesta
            $response = $client->post(
                "Accounts/{$this->accountSid}/Messages.json",
                $payload
            );

            // Elabora la risposta
            $statusCode = $response->getStatusCode();
            $responseBody = json_decode((string) $response->getBody(), true);

            if ($statusCode >= 200 && $statusCode < 300) {
                return [
                    'success' => true,
                    'message_id' => $responseBody['sid'] ?? null,
                    'provider' => 'twilio',
                    'data' => $responseBody,
                ];
            }

            // Log in caso di errore
            if ($this->debug) {
                Log::error('Twilio WhatsApp error', [
                    'status_code' => $statusCode,
                    'response' => $responseBody,
                ]);
            }

            return [
                'success' => false,
                'error' => $responseBody['message'] ?? 'Unknown error',
                'provider' => 'twilio',
                'status_code' => $statusCode,
                'data' => $responseBody,
            ];
        } catch (ClientException $e) {
            // Log dell'errore dettagliato
            if ($this->debug) {
                Log::error('Twilio WhatsApp request error', [
                    'exception' => $e->getMessage(),
                    'response' => $e->getResponse() ? (string) $e->getResponse()->getBody() : null,
                ]);
            }

            throw new Exception('Errore durante l\'invio del messaggio WhatsApp con Twilio: ' . $e->getMessage(), 0, $e);
        } catch (Exception $e) {
            // Log dell'errore generico
            if ($this->debug) {
                Log::error('Twilio WhatsApp general error', [
                    'exception' => $e->getMessage(),
                ]);
            }

            throw new Exception('Errore durante l\'invio del messaggio WhatsApp con Twilio: ' . $e->getMessage(), 0, $e);
        }
    }

    /**
     * Normalizza il numero di telefono nel formato internazionale E.164.
     *
     * @param string $phoneNumber Il numero di telefono da normalizzare
     * @return string Il numero normalizzato
     */
    private function normalizePhoneNumber(string $phoneNumber): string
    {
        // Rimuovi tutti i caratteri non numerici
        $phoneNumber = preg_replace('/[^0-9+]/', '', $phoneNumber);

        // Se il numero inizia con 00, sostituisci con +
        if (Str::startsWith($phoneNumber, '00')) {
            $phoneNumber = '+' . mb_substr($phoneNumber, 2);
        }

        // Se il numero non ha prefisso internazionale, aggiungi +39 (Italia)
        if (!Str::startsWith($phoneNumber, '+')) {
            $phoneNumber = '+39' . $phoneNumber;
        }

        return $phoneNumber;
    }
}
```

## Notifica Laravel per WhatsApp

```php
<?php

declare(strict_types=1);

namespace Modules\Notify\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Notification;
use Modules\Notify\Channels\WhatsAppChannel;
use Modules\Notify\Datas\WhatsAppData;

class WhatsAppNotification extends Notification implements ShouldQueue
{
    use Queueable;

    /**
     * @param string $message Contenuto del messaggio
     * @param array $attachments Allegati opzionali
     * @param array $options Opzioni aggiuntive
     */
    public function __construct(
        public readonly string $message,
        public readonly array $attachments = [],
        public readonly array $options = []
    ) {
    }

    /**
     * Ottieni i canali di consegna.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return [WhatsAppChannel::class];
    }

    /**
     * Ottieni la rappresentazione WhatsApp della notifica.
     */
    public function toWhatsApp(object $notifiable): WhatsAppData
    {
        $from = $this->options['from'] ?? config('whatsapp.from');

        // Ottieni il numero dal notifiable
        $to = $notifiable->routeNotificationForWhatsApp($this);

        return new WhatsAppData(
            to: $to,
            from: $from,
            body: $this->message,
            attachments: $this->attachments,
            interactive: $this->options['interactive'] ?? [],
            template: $this->options['template'] ?? [],
            context: $this->options['context'] ?? []
        );
    }
}
```

## Canale WhatsApp

```php
<?php

declare(strict_types=1);

namespace Modules\Notify\Channels;

use Exception;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Log;
use Modules\Notify\Actions\WhatsApp\SendTwilioWhatsAppAction;
use Modules\Notify\Actions\WhatsApp\SendMeta360WhatsAppAction;
use Modules\Notify\Actions\WhatsApp\SendVonageWhatsAppAction;
use Modules\Notify\Datas\WhatsAppData;

class WhatsAppChannel
{
    /**
     * Invia la notifica specificata.
     *
     * @param mixed $notifiable
     * @param \Illuminate\Notifications\Notification $notification
     * @return array|null
     */
    public function send($notifiable, Notification $notification): ?array
    {
        if (! method_exists($notification, 'toWhatsApp')) {
            throw new Exception('La notifica deve implementare il metodo toWhatsApp()');
        }

        $whatsAppData = $notification->toWhatsApp($notifiable);

        if (! $whatsAppData instanceof WhatsAppData) {
            throw new Exception('Il metodo toWhatsApp() deve restituire un\'istanza di WhatsAppData');
        }

        // Recupera il provider predefinito dalla configurazione
        $provider = $whatsAppData->context['provider'] ?? config('whatsapp.default', 'twilio');

        // Seleziona l'azione appropriata in base al provider
        $action = match ($provider) {
            'twilio' => app(SendTwilioWhatsAppAction::class),
            'meta360' => app(SendMeta360WhatsAppAction::class),
            'vonage' => app(SendVonageWhatsAppAction::class),
            default => throw new Exception("Provider WhatsApp non supportato: {$provider}")
        };

        try {
            // Esegui l'azione e ottieni il risultato
            $result = $action->execute($whatsAppData);

            // Log del risultato se in debug mode
            if (config('whatsapp.debug', false)) {
                Log::info('WhatsApp message sent', [
                    'provider' => $provider,
                    'result' => $result,
                ]);
            }

            return $result;
        } catch (Exception $e) {
            Log::error('WhatsApp message sending failed', [
                'provider' => $provider,
                'exception' => $e->getMessage(),
            ]);

            // Rilancia l'eccezione solo in ambiente di sviluppo o se specificato nella configurazione
            if (config('app.debug', false) || config('whatsapp.throw_exceptions', false)) {
                throw $e;
            }

            return [
                'success' => false,
                'error' => $e->getMessage(),
                'provider' => $provider,
            ];
        }
    }
}
```

## Integrazione con Sistemi Esterni

### Meta Business Platform (WhatsApp Business API)

Per integrare con la Business API di Meta (Facebook), occorre:

1. Creare un'app su [Meta for Developers](https://developers.facebook.com/)
2. Configurare un Business Account e ottenere le credenziali
3. Implementare l'autenticazione OAuth2
4. Utilizzare l'endpoint `/{phone-number-id}/messages` per inviare messaggi

### Twilio API per WhatsApp

Per integrare con Twilio:

1. Creare un account su [Twilio](https://www.twilio.com/)
2. Acquisire un numero WhatsApp Business o configurare un Sandbox
3. Configurare Account SID e Auth Token
4. Utilizzare l'endpoint REST `/2010-04-01/Accounts/{AccountSid}/Messages.json`

### Vonage API per WhatsApp

Per integrare con Vonage (ex Nexmo):

1. Creare un account su [Vonage](https://www.vonage.com/)
2. Configurare un'applicazione per WhatsApp
3. Ottenere API Key e API Secret
4. Utilizzare l'endpoint `/v1/messages` con il canale `whatsapp`

## Gestione dei Template

WhatsApp Business richiede l'uso di template pre-approvati per i messaggi iniziali. Implementare una gestione dei template:

```php
// Esempio di struttura per template WhatsApp
$template = [
    'name' => 'appointment_reminder',
    'language' => 'it',
    'components' => [
        [
            'type' => 'header',
            'parameters' => [
                ['type' => 'text', 'text' => 'Promemoria Appuntamento'],
            ],
        ],
        [
            'type' => 'body',
            'parameters' => [
                ['type' => 'text', 'text' => 'Dr. Rossi'],
                ['type' => 'text', 'text' => '15 maggio 2025'],
                ['type' => 'text', 'text' => '10:30'],
            ],
        ],
    ],
];
```

## Best Practices per i Messaggi WhatsApp

1. **Rispettare le Policy di WhatsApp Business**: Seguire le linee guida ufficiali per evitare blocchi
2. **Utilizzare Template per Messaggi Iniziali**: Necessari per iniziare conversazioni
3. **Gestire Correttamente le Risposte**: Implementare webhook per ricevere risposte
4. **Mantenere Alta Qualità**: Evitare spam e rispettare le preferenze utente
5. **Normalizzare Numeri Telefonici**: Utilizzare sempre il formato E.164 (+393401234567)
6. **Implementare Retry con Backoff Esponenziale**: Per garantire la consegna
7. **Gestire Correttamente Media e Allegati**: Rispettare limiti di dimensione e formato

## Troubleshooting

### Problemi Comuni e Soluzioni

1. **Errore di Autenticazione**: Verificare credenziali e token di accesso
2. **Template Non Approvato**: Rivedere e modificare secondo le linee guida
3. **Numero Non Verificato**: Completare processo di verifica del numero
4. **Rate Limiting**: Implementare retry con backoff esponenziale
5. **Errori di Formattazione**: Verificare che i numeri siano in formato E.164

## Test e Development

Per sviluppo e test:

1. Utilizzare sandbox WhatsApp quando disponibili
2. Implementare mock per test unitari
3. Utilizzare numeri di test autorizzati durante lo sviluppo
4. Implementare logging dettagliato in ambiente di sviluppo
# Architettura WhatsApp Provider per <main module>

Questo documento definisce l'architettura e gli standard per l'implementazione dei provider WhatsApp nel modulo Notify di <main module>, mantenendo coerenza con le architetture esistenti per SMS ed email.

## Principi Architetturali Fondamentali

L'architettura dei provider WhatsApp segue gli stessi principi dei provider SMS ed email, rispettando i seguenti punti:

1. **Separazione delle Interfacce**: Le interfacce sono definite in `app/Contracts/`, mai nelle directory di implementazione
2. **Implementazioni in Directory Dedicate**: Tutte le azioni di provider sono in `app/Actions/WhatsApp/`
3. **Data Transfer Objects (DTO)**: Utilizzo di DTO specifici per i messaggi WhatsApp in `app/Datas/`
4. **Configurazione Centralizzata**: Configurazione in `config/whatsapp.php`

## Struttura Directory e Namespace

```
Modules/Notify/
├── app/
│   ├── Actions/
│   │   └── WhatsApp/
│   │       ├── SendTwilioWhatsAppAction.php
│   │       ├── SendMeta360WhatsAppAction.php
│   │       └── SendVonageWhatsAppAction.php
│   ├── Contracts/
│   │   └── WhatsAppProviderActionInterface.php
│   ├── Datas/
│   │   └── WhatsAppData.php
│   └── Channels/
│       └── WhatsAppChannel.php
└── config/
    └── whatsapp.php
```

## Interfaccia del Provider WhatsApp

```php
<?php

declare(strict_types=1);

namespace Modules\Notify\Contracts;

use Modules\Notify\Datas\WhatsAppData;

/**
 * Interfaccia per tutte le azioni di invio WhatsApp.
 *
 * Tutte le implementazioni di provider WhatsApp devono implementare questa interfaccia
 * per garantire una coerenza nel modo in cui vengono gestiti i messaggi
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

## Data Transfer Object per WhatsApp

```php
<?php

declare(strict_types=1);

namespace Modules\Notify\Datas;

class WhatsAppData
{
    /**
     * @param string $to Numero di telefono del destinatario in formato internazionale E.164 (es. +393401234567)
     * @param string $from Numero di telefono o ID mittente (specifico del provider)
     * @param string $body Testo del messaggio
     * @param array $attachments Array di allegati (opzionale)
     * @param array $interactive Componenti interattivi come bottoni o liste (opzionale)
     * @param array $template Informazioni sul template da utilizzare (opzionale)
     * @param array $context Dati di contesto per il messaggio (opzionale)
     */
    public function __construct(
        public readonly string $to,
        public readonly string $from,
        public readonly string $body,
        public readonly array $attachments = [],
        public readonly array $interactive = [],
        public readonly array $template = [],
        public readonly array $context = []
    ) {
    }
}
```

## Configurazione WhatsApp

```php
// config/whatsapp.php

return [
    'default' => env('WHATSAPP_PROVIDER', 'twilio'),

    'providers' => [
        'twilio' => [
            'account_sid' => env('TWILIO_ACCOUNT_SID'),
            'auth_token' => env('TWILIO_AUTH_TOKEN'),
            'from_phone_number' => env('TWILIO_WHATSAPP_FROM'),
            'edge' => env('TWILIO_EDGE', 'frankfurt'),
        ],

        'meta360' => [
            'app_id' => env('META_APP_ID'),
            'app_secret' => env('META_APP_SECRET'),
            'business_account_id' => env('META_BUSINESS_ACCOUNT_ID'),
            'phone_number_id' => env('META_PHONE_NUMBER_ID'),
            'access_token' => env('META_WHATSAPP_ACCESS_TOKEN'),
        ],

        'vonage' => [
            'api_key' => env('VONAGE_API_KEY'),
            'api_secret' => env('VONAGE_API_SECRET'),
            'from_number' => env('VONAGE_WHATSAPP_FROM'),
        ],
    ],

    // Configurazioni globali per tutti i provider
    'from' => env('WHATSAPP_FROM'),
    'debug' => (bool) env('WHATSAPP_DEBUG', false),
    'timeout' => (int) env('WHATSAPP_TIMEOUT', 30),
    'retry' => [
        'enabled' => (bool) env('WHATSAPP_RETRY_ENABLED', true),
        'attempts' => (int) env('WHATSAPP_RETRY_ATTEMPTS', 3),
        'delay' => (int) env('WHATSAPP_RETRY_DELAY', 5),
    ],
];
```

## Implementazione dei Provider WhatsApp

### Provider Twilio (Esempio)

```php
<?php

declare(strict_types=1);

namespace Modules\Notify\Actions\WhatsApp;

use Exception;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Modules\Notify\Contracts\WhatsAppProviderActionInterface;
use Modules\Notify\Datas\WhatsAppData;
use Spatie\QueueableAction\QueueableAction;

final class SendTwilioWhatsAppAction implements WhatsAppProviderActionInterface
{
    use QueueableAction;

    private string $accountSid;
    private string $authToken;
    private string $fromPhoneNumber;
    private string $edge;
    private bool $debug;
    private int $timeout;

    /**
     * Create a new action instance.
     *
     * @throws Exception Se le credenziali non sono configurate
     */
    public function __construct()
    {
        $accountSid = config('whatsapp.providers.twilio.account_sid');
        $authToken = config('whatsapp.providers.twilio.auth_token');

        if (!is_string($accountSid) || !is_string($authToken)) {
            throw new Exception('Twilio Account SID e Auth Token devono essere configurati in config/whatsapp.php');
        }

        $this->accountSid = $accountSid;
        $this->authToken = $authToken;
        $this->fromPhoneNumber = config('whatsapp.providers.twilio.from_phone_number') ?? config('whatsapp.from');
        $this->edge = config('whatsapp.providers.twilio.edge', 'frankfurt');

        // Parametri globali
        $this->debug = (bool) config('whatsapp.debug', false);
        $this->timeout = (int) config('whatsapp.timeout', 30);
    }

    /**
     * Execute the action.
     *
     * @param WhatsAppData $whatsAppData I dati del messaggio WhatsApp
     * @return array Risultato dell'operazione
     * @throws Exception In caso di errore durante l'invio
     */
    public function execute(WhatsAppData $whatsAppData): array
    {
        // Normalizza il numero di telefono
        $to = $this->normalizePhoneNumber($whatsAppData->to);

        // Crea il client Twilio
        $client = new Client([
            'base_uri' => "https://api.{$this->edge}.twilio.com/2010-04-01/",
            'auth' => [$this->accountSid, $this->authToken],
            'timeout' => $this->timeout,
            'http_errors' => false,
        ]);

        // Prepara il payload del messaggio
        $from = "whatsapp:{$whatsAppData->from}";
        $to = "whatsapp:{$to}";

        try {
            $payload = [
                'form_params' => [
                    'From' => $from,
                    'To' => $to,
                    'Body' => $whatsAppData->body,
                ],
            ];

            // Gestione degli allegati
            if (!empty($whatsAppData->attachments)) {
                $payload['form_params']['MediaUrl'] = $whatsAppData->attachments[0];
            }

            // Invia la richiesta
            $response = $client->post(
                "Accounts/{$this->accountSid}/Messages.json",
                $payload
            );

            // Elabora la risposta
            $statusCode = $response->getStatusCode();
            $responseBody = json_decode((string) $response->getBody(), true);

            if ($statusCode >= 200 && $statusCode < 300) {
                return [
                    'success' => true,
                    'message_id' => $responseBody['sid'] ?? null,
                    'provider' => 'twilio',
                    'data' => $responseBody,
                ];
            }

            // Log in caso di errore
            if ($this->debug) {
                Log::error('Twilio WhatsApp error', [
                    'status_code' => $statusCode,
                    'response' => $responseBody,
                ]);
            }

            return [
                'success' => false,
                'error' => $responseBody['message'] ?? 'Unknown error',
                'provider' => 'twilio',
                'status_code' => $statusCode,
                'data' => $responseBody,
            ];
        } catch (ClientException $e) {
            // Log dell'errore dettagliato
            if ($this->debug) {
                Log::error('Twilio WhatsApp request error', [
                    'exception' => $e->getMessage(),
                    'response' => $e->getResponse() ? (string) $e->getResponse()->getBody() : null,
                ]);
            }

            throw new Exception('Errore durante l\'invio del messaggio WhatsApp con Twilio: ' . $e->getMessage(), 0, $e);
        } catch (Exception $e) {
            // Log dell'errore generico
            if ($this->debug) {
                Log::error('Twilio WhatsApp general error', [
                    'exception' => $e->getMessage(),
                ]);
            }

            throw new Exception('Errore durante l\'invio del messaggio WhatsApp con Twilio: ' . $e->getMessage(), 0, $e);
        }
    }

    /**
     * Normalizza il numero di telefono nel formato internazionale E.164.
     *
     * @param string $phoneNumber Il numero di telefono da normalizzare
     * @return string Il numero normalizzato
     */
    private function normalizePhoneNumber(string $phoneNumber): string
    {
        // Rimuovi tutti i caratteri non numerici
        $phoneNumber = preg_replace('/[^0-9+]/', '', $phoneNumber);

        // Se il numero inizia con 00, sostituisci con +
        if (Str::startsWith($phoneNumber, '00')) {
            $phoneNumber = '+' . mb_substr($phoneNumber, 2);
        }

        // Se il numero non ha prefisso internazionale, aggiungi +39 (Italia)
        if (!Str::startsWith($phoneNumber, '+')) {
            $phoneNumber = '+39' . $phoneNumber;
        }

        return $phoneNumber;
    }
}
```

## Notifica Laravel per WhatsApp

```php
<?php

declare(strict_types=1);

namespace Modules\Notify\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Notification;
use Modules\Notify\Channels\WhatsAppChannel;
use Modules\Notify\Datas\WhatsAppData;

class WhatsAppNotification extends Notification implements ShouldQueue
{
    use Queueable;

    /**
     * @param string $message Contenuto del messaggio
     * @param array $attachments Allegati opzionali
     * @param array $options Opzioni aggiuntive
     */
    public function __construct(
        public readonly string $message,
        public readonly array $attachments = [],
        public readonly array $options = []
    ) {
    }

    /**
     * Ottieni i canali di consegna.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return [WhatsAppChannel::class];
    }

    /**
     * Ottieni la rappresentazione WhatsApp della notifica.
     */
    public function toWhatsApp(object $notifiable): WhatsAppData
    {
        $from = $this->options['from'] ?? config('whatsapp.from');

        // Ottieni il numero dal notifiable
        $to = $notifiable->routeNotificationForWhatsApp($this);

        return new WhatsAppData(
            to: $to,
            from: $from,
            body: $this->message,
            attachments: $this->attachments,
            interactive: $this->options['interactive'] ?? [],
            template: $this->options['template'] ?? [],
            context: $this->options['context'] ?? []
        );
    }
}
```

## Canale WhatsApp

```php
<?php

declare(strict_types=1);

namespace Modules\Notify\Channels;

use Exception;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Log;
use Modules\Notify\Actions\WhatsApp\SendTwilioWhatsAppAction;
use Modules\Notify\Actions\WhatsApp\SendMeta360WhatsAppAction;
use Modules\Notify\Actions\WhatsApp\SendVonageWhatsAppAction;
use Modules\Notify\Datas\WhatsAppData;

class WhatsAppChannel
{
    /**
     * Invia la notifica specificata.
     *
     * @param mixed $notifiable
     * @param \Illuminate\Notifications\Notification $notification
     * @return array|null
     */
    public function send($notifiable, Notification $notification): ?array
    {
        if (! method_exists($notification, 'toWhatsApp')) {
            throw new Exception('La notifica deve implementare il metodo toWhatsApp()');
        }

        $whatsAppData = $notification->toWhatsApp($notifiable);

        if (! $whatsAppData instanceof WhatsAppData) {
            throw new Exception('Il metodo toWhatsApp() deve restituire un\'istanza di WhatsAppData');
        }

        // Recupera il provider predefinito dalla configurazione
        $provider = $whatsAppData->context['provider'] ?? config('whatsapp.default', 'twilio');

        // Seleziona l'azione appropriata in base al provider
        $action = match ($provider) {
            'twilio' => app(SendTwilioWhatsAppAction::class),
            'meta360' => app(SendMeta360WhatsAppAction::class),
            'vonage' => app(SendVonageWhatsAppAction::class),
            default => throw new Exception("Provider WhatsApp non supportato: {$provider}")
        };

        try {
            // Esegui l'azione e ottieni il risultato
            $result = $action->execute($whatsAppData);

            // Log del risultato se in debug mode
            if (config('whatsapp.debug', false)) {
                Log::info('WhatsApp message sent', [
                    'provider' => $provider,
                    'result' => $result,
                ]);
            }

            return $result;
        } catch (Exception $e) {
            Log::error('WhatsApp message sending failed', [
                'provider' => $provider,
                'exception' => $e->getMessage(),
            ]);

            // Rilancia l'eccezione solo in ambiente di sviluppo o se specificato nella configurazione
            if (config('app.debug', false) || config('whatsapp.throw_exceptions', false)) {
                throw $e;
            }

            return [
                'success' => false,
                'error' => $e->getMessage(),
                'provider' => $provider,
            ];
        }
    }
}
```

## Integrazione con Sistemi Esterni

### Meta Business Platform (WhatsApp Business API)

Per integrare con la Business API di Meta (Facebook), occorre:

1. Creare un'app su [Meta for Developers](https://developers.facebook.com/)
2. Configurare un Business Account e ottenere le credenziali
3. Implementare l'autenticazione OAuth2
4. Utilizzare l'endpoint `/{phone-number-id}/messages` per inviare messaggi

### Twilio API per WhatsApp

Per integrare con Twilio:

1. Creare un account su [Twilio](https://www.twilio.com/)
2. Acquisire un numero WhatsApp Business o configurare un Sandbox
3. Configurare Account SID e Auth Token
4. Utilizzare l'endpoint REST `/2010-04-01/Accounts/{AccountSid}/Messages.json`

### Vonage API per WhatsApp

Per integrare con Vonage (ex Nexmo):

1. Creare un account su [Vonage](https://www.vonage.com/)
2. Configurare un'applicazione per WhatsApp
3. Ottenere API Key e API Secret
4. Utilizzare l'endpoint `/v1/messages` con il canale `whatsapp`

## Gestione dei Template

WhatsApp Business richiede l'uso di template pre-approvati per i messaggi iniziali. Implementare una gestione dei template:

```php
// Esempio di struttura per template WhatsApp
$template = [
    'name' => 'appointment_reminder',
    'language' => 'it',
    'components' => [
        [
            'type' => 'header',
            'parameters' => [
                ['type' => 'text', 'text' => 'Promemoria Appuntamento'],
            ],
        ],
        [
            'type' => 'body',
            'parameters' => [
                ['type' => 'text', 'text' => 'Dr. Rossi'],
                ['type' => 'text', 'text' => '15 maggio 2025'],
                ['type' => 'text', 'text' => '10:30'],
            ],
        ],
    ],
];
```

## Best Practices per i Messaggi WhatsApp

1. **Rispettare le Policy di WhatsApp Business**: Seguire le linee guida ufficiali per evitare blocchi
2. **Utilizzare Template per Messaggi Iniziali**: Necessari per iniziare conversazioni
3. **Gestire Correttamente le Risposte**: Implementare webhook per ricevere risposte
4. **Mantenere Alta Qualità**: Evitare spam e rispettare le preferenze utente
5. **Normalizzare Numeri Telefonici**: Utilizzare sempre il formato E.164 (+393401234567)
6. **Implementare Retry con Backoff Esponenziale**: Per garantire la consegna
7. **Gestire Correttamente Media e Allegati**: Rispettare limiti di dimensione e formato

## Troubleshooting

### Problemi Comuni e Soluzioni

1. **Errore di Autenticazione**: Verificare credenziali e token di accesso
2. **Template Non Approvato**: Rivedere e modificare secondo le linee guida
3. **Numero Non Verificato**: Completare processo di verifica del numero
4. **Rate Limiting**: Implementare retry con backoff esponenziale
5. **Errori di Formattazione**: Verificare che i numeri siano in formato E.164

## Test e Development

Per sviluppo e test:

1. Utilizzare sandbox WhatsApp quando disponibili
2. Implementare mock per test unitari
3. Utilizzare numeri di test autorizzati durante lo sviluppo
4. Implementare logging dettagliato in ambiente di sviluppo
