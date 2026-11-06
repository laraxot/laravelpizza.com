---
qmd: "whatsapp consolidated"
issues: []
discussions: []
title: "whatsapp: Consolidated Documentation"
module: notify
type: integration
tags: [integrations, modules, notify]
created: 2026-08-24
updated: 2026-08-24
status: draft
---

# whatsapp: Consolidated Documentation

Consolidated from **12** individual files.

## Table of Contents

- [Implementazione Canale WhatsApp](#whatsapp-channel-1)
- [---](#whatsapp-channel-2)
- [Implementazione Canale WhatsApp](#whatsapp-channel)
- [Integrazione WhatsApp](#whatsapp-integration-1)
- [---](#whatsapp-integration-2)
- [Integrazione WhatsApp ](#whatsapp-integration)
- [---](#whatsapp-sending-standard-1)
- [Standard per Invio Messaggi WhatsApp nel Modulo Notify](#whatsapp-sending-standard)
- [https://levelup.gitconnected.com/how-to-send-whatsapp-messages-with-laravel-ed6426b4be96](#whatsapp)
- [Implementazione Canale WhatsApp](#whatsapp_channel)
- [<<<<<<< HEAD](#whatsapp_integration)
- [Standard per Invio Messaggi WhatsApp nel Modulo Notify](#whatsapp_sending_standard)

---

## whatsapp-channel-1

*Consolidated from: `whatsapp-channel-implementazione-canale.md`*


## 1. Struttura Base

Il canale WhatsApp implementa le funzionalità per l'invio di messaggi tramite l'API di WhatsApp. La struttura include:

- Provider specifici (Twilio, Vonage, Meta)
- Azioni per l'invio dei messaggi
- Configurazione del canale
- Gestione della logica di invio

## 2. Provider WhatsApp Supportati

### 2.1 Twilio WhatsApp
- Provider: `twilio`
- Configurazione richiesta: `TWILIO_ACCOUNT_SID`, `TWILIO_AUTH_TOKEN`, `TWILIO_WHATSAPP_NUMBER`
- API: Twilio WhatsApp API

### 2.2 Vonage WhatsApp
- Provider: `vonage`
- Configurazione richiesta: `VONAGE_API_KEY`, `VONAGE_API_SECRET`, `VONAGE_WHATSAPP_NUMBER`
- API: Vonage WhatsApp API

### 2.3 Meta WhatsApp Cloud API
- Provider: `meta`
- Configurazione richiesta: `META_ACCESS_TOKEN`, `META_PHONE_NUMBER_ID`
- API: Meta WhatsApp Cloud API

## 3. Azioni di Invio

### 3.1 SendTwilioWhatsAppAction
Azione per inviare messaggi tramite Twilio WhatsApp.

### 3.2 SendVonageWhatsAppAction
Azione per inviare messaggi tramite Vonage WhatsApp.

### 3.3 SendMetaWhatsAppAction
Azione per inviare messaggi tramite Meta WhatsApp Cloud API.

## 4. Configurazione

### 4.1 File di Configurazione
- `config/whatsapp.php`: Configurazione generale del canale WhatsApp
- `.env`: Variabili d'ambiente per i provider WhatsApp

### 4.2 Provider Supportati
La configurazione permette di specificare quale provider utilizzare e le relative credenziali.

## 5. Modalità di Utilizzo

### 5.1 Facade Notify
```php
Notify::via('whatsapp')
    ->to($phone)
    ->message($message)
    ->send();
```

### 5.2 Azione Specifica
```php
app(SendTwilioWhatsAppAction::class)->execute([
    'to' => $phone,
    'message' => $message,
]);
```

## 6. Logica di Selezione Provider

La logica di selezione del provider WhatsApp è implementata in `WhatsAppProviderSelectionLogicAction` che permette di:

- Determinare quale provider utilizzare in base alla configurazione
- Gestire fallback tra diversi provider
- Applicare logiche specifiche per la selezione del provider

## 7. Collegamenti Utili

- [Twilio WhatsApp API](https://www.twilio.com/whatsapp)
- [Vonage WhatsApp API](https://developer.vonage.com/messaging/whatsapp/overview)
- [Meta WhatsApp Business API](https://developers.facebook.com/docs/whatsapp/cloud-api)
- [Laravel Notifications](https://laravel.com/docs/notifications)
- [Laravel Queues](https://laravel.com/docs/queues)
- [Laravel Testing](https://laravel.com/docs/testing)
- [Laravel Logging](https://laravel.com/docs/logging)
- [Laravel Cache](https://laravel.com/docs/cache)

---

## whatsapp-channel-2

*Consolidated from: `whatsapp-channel.md`*

title: "Implementazione Canale WhatsApp"
type: concept
tags: [whatsapp, channel]
created: 2026-07-14
updated: 2026-07-14
qmd: "whatsapp-channel-2 implementazione canale whatsapp"
issues: ["https://github.com/provtv/<nome repository>/issues/124"]
discussions: ["https://github.com/provtv/<nome repository>/discussions/1"]
related:
  - "./00-index.md"
  - "./00-index-2.md"
  - "./00-index.md"
  - "./absolute-completion.md"
  - "./acronym-naming-conventions.md"
  - "./00-index-documentation.md"
  - "./00-index-2.md"
  - "./00-index.md"
  - "./absolute-completion-completamento-assoluto.md"
  - "./acronym-naming-conventions.md"
  - "./acronym-naming-conventions.md"
  - "./acronym-naming-conventions.md"
  - "./action-plan-immediate.md"
---

# Implementazione Canale WhatsApp

## 1. Struttura Base

### 1.1 Data Transfer Objects
```php
<?php

namespace Modules\Notify\Datas;

use Spatie\LaravelData\Data;

class WhatsAppMessageData extends Data
{
    public function __construct(
        public string $to,
        public string $message,
        public ?string $template = null,
        public ?array $parameters = null,
        public ?string $mediaUrl = null,
        public ?string $mediaType = null
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            to: $data['to'],
            message: $data['message'],
            template: $data['template'] ?? null,
            parameters: $data['parameters'] ?? null,
            mediaUrl: $data['media_url'] ?? null,
            mediaType: $data['media_type'] ?? null
        );
    }
}
```

### 1.2 Interfaccia
```php
<?php

namespace Modules\Notify\Contracts\WhatsApp;

use Modules\Notify\Datas\WhatsAppMessageData;

interface WhatsAppActionInterface
{
    /**
     * Esegue l'invio del messaggio WhatsApp
     *
     * @param WhatsAppMessageData $messageData I dati del messaggio
     * @return array Risultato dell'operazione
     * @throws \Exception In caso di errore durante l'invio
     */
    public function execute(WhatsAppMessageData $messageData): array;
}
```

## 2. Configurazione

### 2.1 Config File
```php
<?php
// config/notify.php

return [
    'drivers' => [
        'whatsapp' => [
            'twilio' => [
                'account_sid' => env('TWILIO_ACCOUNT_SID'),
                'auth_token' => env('TWILIO_AUTH_TOKEN'),
                'from' => env('TWILIO_WHATSAPP_FROM'),
                'endpoint' => env('TWILIO_WHATSAPP_ENDPOINT', 'https://api.twilio.com/2010-04-01/Accounts/{AccountSid}/Messages.json'),
            ],
            'vonage' => [
                'api_key' => env('VONAGE_API_KEY'),
                'api_secret' => env('VONAGE_API_SECRET'),
                'from' => env('VONAGE_WHATSAPP_FROM'),
                'endpoint' => env('VONAGE_WHATSAPP_ENDPOINT', 'https://api.nexmo.com/v1/messages'),
            ],
            'meta' => [
                'access_token' => env('META_WHATSAPP_ACCESS_TOKEN'),
                'phone_number_id' => env('META_WHATSAPP_PHONE_NUMBER_ID'),
                'business_account_id' => env('META_WHATSAPP_BUSINESS_ACCOUNT_ID'),
                'endpoint' => env('META_WHATSAPP_ENDPOINT', 'https://graph.facebook.com/v17.0/{Phone-Number-ID}/messages'),
            ],
        ],
    ],

    'default' => env('WHATSAPP_DRIVER', 'twilio'),

    'debug' => env('WHATSAPP_DEBUG', false),

    'retry' => [
        'attempts' => env('WHATSAPP_RETRY_ATTEMPTS', 3),
        'delay' => env('WHATSAPP_RETRY_DELAY', 60),
    ],

    'rate_limit' => [
        'enabled' => env('WHATSAPP_RATE_LIMIT_ENABLED', true),
        'max_attempts' => env('WHATSAPP_RATE_LIMIT_MAX_ATTEMPTS', 60),
        'decay_minutes' => env('WHATSAPP_RATE_LIMIT_DECAY_MINUTES', 1),
    ],
];
```

### 2.2 Environment Variables
```env

# Twilio WhatsApp
TWILIO_ACCOUNT_SID=your_account_sid
TWILIO_AUTH_TOKEN=your_auth_token
TWILIO_WHATSAPP_FROM=whatsapp:+14155238886

# Vonage WhatsApp
VONAGE_API_KEY=your_api_key
VONAGE_API_SECRET=your_api_secret
VONAGE_WHATSAPP_FROM=whatsapp:+14155238886

# Meta WhatsApp
META_WHATSAPP_ACCESS_TOKEN=your_access_token
META_WHATSAPP_PHONE_NUMBER_ID=your_phone_number_id
META_WHATSAPP_BUSINESS_ACCOUNT_ID=your_business_account_id

# Global WhatsApp configuration
WHATSAPP_DRIVER=twilio
WHATSAPP_DEBUG=false
WHATSAPP_RETRY_ATTEMPTS=3
WHATSAPP_RETRY_DELAY=60
WHATSAPP_RATE_LIMIT_ENABLED=true
WHATSAPP_RATE_LIMIT_MAX_ATTEMPTS=60
WHATSAPP_RATE_LIMIT_DECAY_MINUTES=1
```

## 3. Implementazione

### 3.1 Action Base
```php
<?php

namespace Modules\Notify\Actions\WhatsApp;

use Modules\Notify\Contracts\WhatsApp\WhatsAppActionInterface;
use Modules\Notify\Datas\WhatsAppMessageData;
use Spatie\QueueableAction\QueueableAction;

abstract class BaseWhatsAppAction implements WhatsAppActionInterface
{
    use QueueableAction;

    protected string $driver;
    protected array $config;
    protected bool $debug;
    protected int $timeout;

    public function __construct(string $driver = null)
    {
        $this->driver = $driver ?? config('notify.default');
        $this->config = config("notify.drivers.whatsapp.{$this->driver}");
        $this->debug = (bool) config('notify.debug', false);
        $this->timeout = (int) config('notify.timeout', 30);
    }

    abstract public function execute(WhatsAppMessageData $messageData): array;
}
```

### 3.2 Provider Specifici
```php
<?php

namespace Modules\Notify\Actions\WhatsApp;

use Modules\Notify\Datas\WhatsAppMessageData;

class TwilioWhatsAppAction extends BaseWhatsAppAction
{
    public function execute(WhatsAppMessageData $messageData): array
    {
        // Implementazione specifica per Twilio
    }
}

class VonageWhatsAppAction extends BaseWhatsAppAction
{
    public function execute(WhatsAppMessageData $messageData): array
    {
        // Implementazione specifica per Vonage
    }
}

class MetaWhatsAppAction extends BaseWhatsAppAction
{
    public function execute(WhatsAppMessageData $messageData): array
    {
        // Implementazione specifica per Meta
    }
}
```

## 4. Utilizzo

### 4.1 Nel Model
```php
<?php

namespace Modules\Patient\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    use Notifiable;

    /**
     * Route notifications for the WhatsApp channel.
     *
     * @return string
     */
    public function routeNotificationForWhatsApp(): string
    {
        return $this->whatsapp_number;
    }

    /**
     * Verifica se l'utente può ricevere WhatsApp
     *
     * @return bool
     */
    public function canReceiveWhatsApp(): bool
    {
        return !empty($this->whatsapp_number) && $this->consent_whatsapp;
    }
}
```

### 4.2 Invio Notifica
```php
// Direttamente
$user->notify(new WhatsAppNotification('Il tuo codice OTP è: 123456'));

// Con Action
$action = new TwilioWhatsAppAction();
$result = $action->execute(new WhatsAppMessageData(
    to: $user->whatsapp_number,
    message: 'Il tuo codice OTP è: 123456'
));

// Con validazione
if ($user->canReceiveWhatsApp()) {
    $user->notify(new WhatsAppNotification('Il tuo codice OTP è: 123456'));
}
```

## 5. Best Practices

### 5.1 Validazione
- Validare sempre il numero WhatsApp
- Verificare la lunghezza del messaggio
- Controllare il formato dei template
- Validare i parametri dei template
- Verificare il consenso dell'utente
- Controllare i limiti di rate

### 5.2 Gestione Errori
- Usare try/catch per gestire le eccezioni
- Loggare gli errori con dettagli
- Implementare retry per fallimenti temporanei
- Gestire i codici di errore specifici
- Implementare circuit breaker
- Monitorare il tasso di errore

### 5.3 Performance
- Utilizzare le code per l'invio
- Implementare rate limiting
- Monitorare l'uso dell'API
- Gestire il batch di invii
- Implementare caching
- Ottimizzare le query

### 5.4 Sicurezza
- Validare l'input degli utenti
- Sanitizzare i messaggi
- Proteggere le chiavi API
- Implementare logging sicuro
- Gestire i timeout
- Implementare rate limiting per IP

## 6. Testing

### 6.1 Unit Test
```php
<?php

namespace Modules\Notify\Tests\Unit;

use Tests\TestCase;
use Modules\Notify\Actions\WhatsApp\TwilioWhatsAppAction;
use Modules\Notify\Datas\WhatsAppMessageData;
use Illuminate\Support\Facades\Http;

class WhatsAppTest extends TestCase
{
    public function test_whatsapp_sent_successfully()
    {
        Http::fake([
            'api.twilio.com/*' => Http::response([
                'status' => 'sent',
                'sid' => 'SM123456'
            ], 200)
        ]);

        $action = new TwilioWhatsAppAction();
        $result = $action->execute(new WhatsAppMessageData(
            to: '+393331234567',
            message: 'Test message'
        ));

        $this->assertTrue($result['success']);
        $this->assertEquals('SM123456', $result['message_id']);
    }
}
```

## 7. Collegamenti Utili

- [Twilio WhatsApp API](https://www.twilio.com/whatsapp)
- [Vonage WhatsApp API](https://developer.vonage.com/messaging/whatsapp/overview)
- [Meta WhatsApp Business API](https://developers.facebook.com/project_docs/whatsapp/cloud-api)
- [Laravel Notifications](https://laravel.com/project_docs/notifications)
- [Laravel Queues](https://laravel.com/project_docs/queues)
- [Laravel Testing](https://laravel.com/project_docs/testing)
- [Laravel Logging](https://laravel.com/project_docs/logging)
- [Laravel Cache](https://laravel.com/project_docs/cache) 
- [Meta WhatsApp Business API](https://developers.facebook.com/docs/whatsapp/cloud-api)
- [Laravel Notifications](https://laravel.com/docs/notifications)
- [Laravel Queues](https://laravel.com/docs/queues)
- [Laravel Testing](https://laravel.com/docs/testing)
- [Laravel Logging](https://laravel.com/docs/logging)
- [Laravel Cache](https://laravel.com/docs/cache) 

---

## whatsapp-channel

*Consolidated from: `whatsapp-channel.md`*


## 1. Struttura Base

### 1.1 Data Transfer Objects
```php
<?php

namespace Modules\Notify\Datas;

use Spatie\LaravelData\Data;

class WhatsAppMessageData extends Data
{
    public function __construct(
        public string $to,
        public string $message,
        public ?string $template = null,
        public ?array $parameters = null,
        public ?string $mediaUrl = null,
        public ?string $mediaType = null
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            to: $data['to'],
            message: $data['message'],
            template: $data['template'] ?? null,
            parameters: $data['parameters'] ?? null,
            mediaUrl: $data['media_url'] ?? null,
            mediaType: $data['media_type'] ?? null
        );
    }
}
```

### 1.2 Interfaccia
```php
<?php

namespace Modules\Notify\Contracts\WhatsApp;

use Modules\Notify\Datas\WhatsAppMessageData;

interface WhatsAppActionInterface
{
    /**
     * Esegue l'invio del messaggio WhatsApp
     *
     * @param WhatsAppMessageData $messageData I dati del messaggio
     * @return array Risultato dell'operazione
     * @throws \Exception In caso di errore durante l'invio
     */
    public function execute(WhatsAppMessageData $messageData): array;
}
```

## 2. Configurazione

### 2.1 Config File
```php
<?php
// config/notify.php

return [
    'drivers' => [
        'whatsapp' => [
            'twilio' => [
                'account_sid' => env('TWILIO_ACCOUNT_SID'),
                'auth_token' => env('TWILIO_AUTH_TOKEN'),
                'from' => env('TWILIO_WHATSAPP_FROM'),
                'endpoint' => env('TWILIO_WHATSAPP_ENDPOINT', 'https://api.twilio.com/[DATE]/Accounts/{AccountSid}/Messages.json'),
            ],
            'vonage' => [
                'api_key' => env('VONAGE_API_KEY'),
                'api_secret' => env('VONAGE_API_SECRET'),
                'from' => env('VONAGE_WHATSAPP_FROM'),
                'endpoint' => env('VONAGE_WHATSAPP_ENDPOINT', 'https://api.nexmo.com/v1/messages'),
            ],
            'meta' => [
                'access_token' => env('META_WHATSAPP_ACCESS_TOKEN'),
                'phone_number_id' => env('META_WHATSAPP_PHONE_NUMBER_ID'),
                'business_account_id' => env('META_WHATSAPP_BUSINESS_ACCOUNT_ID'),
                'endpoint' => env('META_WHATSAPP_ENDPOINT', 'https://graph.facebook.com/v17.0/{Phone-Number-ID}/messages'),
            ],
        ],
    ],

    'default' => env('WHATSAPP_DRIVER', 'twilio'),

    'debug' => env('WHATSAPP_DEBUG', false),

    'retry' => [
        'attempts' => env('WHATSAPP_RETRY_ATTEMPTS', 3),
        'delay' => env('WHATSAPP_RETRY_DELAY', 60),
    ],

    'rate_limit' => [
        'enabled' => env('WHATSAPP_RATE_LIMIT_ENABLED', true),
        'max_attempts' => env('WHATSAPP_RATE_LIMIT_MAX_ATTEMPTS', 60),
        'decay_minutes' => env('WHATSAPP_RATE_LIMIT_DECAY_MINUTES', 1),
    ],
];
```

### 2.2 Environment Variables
```env

# Twilio WhatsApp
TWILIO_ACCOUNT_SID=your_account_sid
TWILIO_AUTH_TOKEN=your_auth_token
TWILIO_WHATSAPP_FROM=whatsapp:+14155238886

# Vonage WhatsApp
VONAGE_API_KEY=your_api_key
VONAGE_API_SECRET=your_api_secret
VONAGE_WHATSAPP_FROM=whatsapp:+14155238886

# Meta WhatsApp
META_WHATSAPP_ACCESS_TOKEN=your_access_token
META_WHATSAPP_PHONE_NUMBER_ID=your_phone_number_id
META_WHATSAPP_BUSINESS_ACCOUNT_ID=your_business_account_id

# Global WhatsApp configuration
WHATSAPP_DRIVER=twilio
WHATSAPP_DEBUG=false
WHATSAPP_RETRY_ATTEMPTS=3
WHATSAPP_RETRY_DELAY=60
WHATSAPP_RATE_LIMIT_ENABLED=true
WHATSAPP_RATE_LIMIT_MAX_ATTEMPTS=60
WHATSAPP_RATE_LIMIT_DECAY_MINUTES=1
```

## 3. Implementazione

### 3.1 Action Base
```php
<?php

namespace Modules\Notify\Actions\WhatsApp;

use Modules\Notify\Contracts\WhatsApp\WhatsAppActionInterface;
use Modules\Notify\Datas\WhatsAppMessageData;
use Spatie\QueueableAction\QueueableAction;

abstract class BaseWhatsAppAction implements WhatsAppActionInterface
{
    use QueueableAction;

    protected string $driver;
    protected array $config;
    protected bool $debug;
    protected int $timeout;

    public function __construct(string $driver = null)
    {
        $this->driver = $driver ?? config('notify.default');
        $this->config = config("notify.drivers.whatsapp.{$this->driver}");
        $this->debug = (bool) config('notify.debug', false);
        $this->timeout = (int) config('notify.timeout', 30);
    }

    abstract public function execute(WhatsAppMessageData $messageData): array;
}
```

### 3.2 Provider Specifici
```php
<?php

namespace Modules\Notify\Actions\WhatsApp;

use Modules\Notify\Datas\WhatsAppMessageData;

class TwilioWhatsAppAction extends BaseWhatsAppAction
{
    public function execute(WhatsAppMessageData $messageData): array
    {
        // Implementazione specifica per Twilio
    }
}

class VonageWhatsAppAction extends BaseWhatsAppAction
{
    public function execute(WhatsAppMessageData $messageData): array
    {
        // Implementazione specifica per Vonage
    }
}

class MetaWhatsAppAction extends BaseWhatsAppAction
{
    public function execute(WhatsAppMessageData $messageData): array
    {
        // Implementazione specifica per Meta
    }
}
```

## 4. Utilizzo

### 4.1 Nel Model
```php
<?php

namespace Modules\Patient\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    use Notifiable;

    /**
     * Route notifications for the WhatsApp channel.
     *
     * @return string
     */
    public function routeNotificationForWhatsApp(): string
    {
        return $this->whatsapp_number;
    }

    /**
     * Verifica se l'utente può ricevere WhatsApp
     *
     * @return bool
     */
    public function canReceiveWhatsApp(): bool
    {
        return !empty($this->whatsapp_number) && $this->consent_whatsapp;
    }
}
```

### 4.2 Invio Notifica
```php
// Direttamente
$user->notify(new WhatsAppNotification('Il tuo codice OTP è: 123456'));

// Con Action
$action = new TwilioWhatsAppAction();
$result = $action->execute(new WhatsAppMessageData(
    to: $user->whatsapp_number,
    message: 'Il tuo codice OTP è: 123456'
));

// Con validazione
if ($user->canReceiveWhatsApp()) {
    $user->notify(new WhatsAppNotification('Il tuo codice OTP è: 123456'));
}
```

## 5. Best Practices

### 5.1 Validazione
- Validare sempre il numero WhatsApp
- Verificare la lunghezza del messaggio
- Controllare il formato dei template
- Validare i parametri dei template
- Verificare il consenso dell'utente
- Controllare i limiti di rate

### 5.2 Gestione Errori
- Usare try/catch per gestire le eccezioni
- Loggare gli errori con dettagli
- Implementare retry per fallimenti temporanei
- Gestire i codici di errore specifici
- Implementare circuit breaker
- Monitorare il tasso di errore

### 5.3 Performance
- Utilizzare le code per l'invio
- Implementare rate limiting
- Monitorare l'uso dell'API
- Gestire il batch di invii
- Implementare caching
- Ottimizzare le query

### 5.4 Sicurezza
- Validare l'input degli utenti
- Sanitizzare i messaggi
- Proteggere le chiavi API
- Implementare logging sicuro
- Gestire i timeout
- Implementare rate limiting per IP

## 6. Testing

### 6.1 Unit Test
```php
<?php

namespace Modules\Notify\Tests\Unit;

use Tests\TestCase;
use Modules\Notify\Actions\WhatsApp\TwilioWhatsAppAction;
use Modules\Notify\Datas\WhatsAppMessageData;
use Illuminate\Support\Facades\Http;

class WhatsAppTest extends TestCase
{
    public function test_whatsapp_sent_successfully()
    {
        Http::fake([
            'api.twilio.com/*' => Http::response([
                'status' => 'sent',
                'sid' => 'SM123456'
            ], 200)
        ]);

        $action = new TwilioWhatsAppAction();
        $result = $action->execute(new WhatsAppMessageData(
            to: '+393331234567',
            message: 'Test message'
        ));

        $this->assertTrue($result['success']);
        $this->assertEquals('SM123456', $result['message_id']);
    }
}
```

## 7. Collegamenti Utili

- [Twilio WhatsApp API](https://www.twilio.com/whatsapp)
- [Vonage WhatsApp API](https://developer.vonage.com/messaging/whatsapp/overview)
- [Meta WhatsApp Business API](https://developers.facebook.com/project_docs/whatsapp/cloud-api)
- [Laravel Notifications](https://laravel.com/project_docs/notifications)
- [Laravel Queues](https://laravel.com/project_docs/queues)
- [Laravel Testing](https://laravel.com/project_docs/testing)
- [Laravel Logging](https://laravel.com/project_docs/logging)
- [Laravel Cache](https://laravel.com/project_docs/cache) 
- [Meta WhatsApp Business API](https://developers.facebook.com/docs/whatsapp/cloud-api)
- [Laravel Notifications](https://laravel.com/docs/notifications)
- [Laravel Queues](https://laravel.com/docs/queues)
- [Laravel Testing](https://laravel.com/docs/testing)
- [Laravel Logging](https://laravel.com/docs/logging)
- [Laravel Cache](https://laravel.com/docs/cache) 

---

## whatsapp-integration-1

*Consolidated from: `whatsapp-integration.md`*


## Panoramica

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

Seguendo questa architettura, l'integrazione WhatsApp si inserisce perfettamente nell'ecosistema di notifiche di <nome progetto>, mantenendo la coerenza con le altre modalità di comunicazione.

---

*Ultimo aggiornamento: 2023-05-12*

---

## whatsapp-integration-2

*Consolidated from: `whatsapp-integration.md`*

title: "Integrazione WhatsApp"
type: concept
tags: [whatsapp, integration]
created: 2026-07-14
updated: 2026-07-14
qmd: "whatsapp-integration-2 integrazione whatsapp"
issues: ["https://github.com/provtv/<nome repository>/issues/124"]
discussions: ["https://github.com/provtv/<nome repository>/discussions/1"]
related:
  - "./00-index.md"
  - "./00-index-2.md"
  - "./00-index.md"
  - "./absolute-completion.md"
  - "./acronym-naming-conventions.md"
  - "./00-index-documentation.md"
  - "./00-index-2.md"
  - "./00-index.md"
  - "./absolute-completion-completamento-assoluto.md"
  - "./acronym-naming-conventions.md"
  - "./acronym-naming-conventions.md"
  - "./acronym-naming-conventions.md"
  - "./action-plan-immediate.md"
---

# Integrazione WhatsApp 

## Panoramica

Questo documento descrive l'architettura e l'implementazione dell'integrazione WhatsApp nel modulo Notify di App, seguendo gli stessi standard e pattern utilizzati per l'invio di email e SMS.

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
body: 'Questo è un messaggio di test da App',
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

*Ultimo aggiornamento: 2023-05-12*
Seguendo questa architettura, l'integrazione WhatsApp si inserisce perfettamente nell'ecosistema di notifiche di App, mantenendo la coerenza con le altre modalità di comunicazione.

---

*Ultimo aggiornamento: 2023-05-12*
---

## whatsapp-integration

*Consolidated from: `whatsapp-integration.md`*


## Panoramica

Questo documento descrive l'architettura e l'implementazione dell'integrazione WhatsApp nel modulo Notify di App, seguendo gli stessi standard e pattern utilizzati per l'invio di email e SMS.
Questo documento descrive l'architettura e l'implementazione dell'integrazione WhatsApp nel modulo Notify di Quaeris, seguendo gli stessi standard e pattern utilizzati per l'invio di email e SMS.

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
    private string $baseUrl = 'https://api.twilio.com/[DATE]';
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
body: 'Questo è un messaggio di test da App',
body: 'Questo è un messaggio di test da Quaeris',
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

Seguendo questa architettura, l'integrazione WhatsApp si inserisce perfettamente nell'ecosistema di notifiche di App, mantenendo la coerenza con le altre modalità di comunicazione.
Seguendo questa architettura, l'integrazione WhatsApp si inserisce perfettamente nell'ecosistema di notifiche di Quaeris, mantenendo la coerenza con le altre modalità di comunicazione.

---

## whatsapp-sending-standard-1

*Consolidated from: `whatsapp-sending-standard.md`*

title: "Standard per Invio Messaggi WhatsApp nel Modulo Notify"
type: rule
tags: [whatsapp, sending, standard]
created: 2026-07-14
updated: 2026-07-14
qmd: "whatsapp-sending-standard-1 standard per invio messaggi whatsapp nel modulo notify"
issues: ["https://github.com/provtv/<nome repository>/issues/124"]
discussions: ["https://github.com/provtv/<nome repository>/discussions/1"]
related:
  - "./00-index.md"
  - "./00-index-2.md"
  - "./00-index.md"
  - "./absolute-completion.md"
  - "./acronym-naming-conventions.md"
  - "./00-index-documentation.md"
  - "./00-index-2.md"
  - "./00-index.md"
  - "./absolute-completion-completamento-assoluto.md"
  - "./acronym-naming-conventions.md"
  - "./acronym-naming-conventions.md"
  - "./acronym-naming-conventions.md"
  - "./action-plan-immediate.md"
---

# Standard per Invio Messaggi WhatsApp nel Modulo Notify

## Introduzione
Questa guida definisce lo standard per l'invio di messaggi WhatsApp all'interno del modulo Notify, seguendo la stessa architettura modulare, configurazione e best practice già adottate per email e SMS. L'obiettivo è garantire coerenza, riusabilità e facilità di manutenzione, indipendentemente dal provider utilizzato (Twilio, Vonage, WhatsApp Business API, ecc.).

---

## 1. Struttura delle Azioni WhatsApp

- Ogni provider WhatsApp deve avere una propria action in `app/Actions/WhatsApp`.
- Tutte le azioni devono implementare una interfaccia comune, ad esempio `WhatsAppActionInterface` (da posizionare in `app/Contracts`).
- Le azioni devono accettare un DTO standardizzato (es. `WhatsAppMessageData` in `app/Datas`).
- La naming convention è: `Send<Provider>WhatsAppAction.php` (es. `SendTwilioWhatsAppAction.php`).

**Esempio di interfaccia:**
```php
namespace Modules\Notify\Contracts;

use Modules\Notify\Datas\WhatsAppMessageData;

interface WhatsAppActionInterface
{
    /**
     * Invia un messaggio WhatsApp tramite provider specifico.
     * @param WhatsAppMessageData $data
     * @return array
     */
    public function execute(WhatsAppMessageData $data): array;
}
```

---

## 2. Configurazione

- Tutti i provider WhatsApp vanno configurati in `config/whatsapp.php` (o in una sezione dedicata di `config/services.php` o `config/notify.php`).
- I parametri generici (retry, rate_limit, timeout, circuit_breaker, debug) devono essere globali e non duplicati nei singoli driver.
- I parametri specifici del provider (es. api_key, sender, endpoint) vanno nella sezione del driver.

**Esempio di configurazione:**
```php
return [
    'default' => env('WHATSAPP_DRIVER', 'twilio'),
    'drivers' => [
        'twilio' => [
            'account_sid' => env('TWILIO_ACCOUNT_SID'),
            'auth_token' => env('TWILIO_AUTH_TOKEN'),
            'from' => env('TWILIO_WHATSAPP_FROM'),
        ],
        'vonage' => [
            'api_key' => env('VONAGE_API_KEY'),
            'api_secret' => env('VONAGE_API_SECRET'),
            'from' => env('VONAGE_WHATSAPP_FROM'),
        ],
        // ... altri provider
    ],
    'debug' => env('WHATSAPP_DEBUG', false),
    'retry' => [
        'attempts' => env('WHATSAPP_RETRY_ATTEMPTS', 3),
        'delay' => env('WHATSAPP_RETRY_DELAY', 60),
    ],
    'rate_limit' => [
        'enabled' => env('WHATSAPP_RATE_LIMIT_ENABLED', true),
        'max_attempts' => env('WHATSAPP_RATE_LIMIT_MAX_ATTEMPTS', 60),
        'decay_minutes' => env('WHATSAPP_RATE_LIMIT_DECAY_MINUTES', 1),
    ],
    'timeout' => env('WHATSAPP_TIMEOUT', 30),
];
```

---

## 3. DTO Standardizzato

- I dati del messaggio WhatsApp devono essere incapsulati in un DTO in `app/Datas/WhatsAppMessageData.php`.
- Utilizzare `spatie/laravel-data` per la validazione e la tipizzazione.

**Esempio:**
```php
namespace Modules\Notify\Datas;

use Spatie\LaravelData\Data;

class WhatsAppMessageData extends Data
{
    public string $to;
    public string $from;
    public string $body;
    public ?array $media = null; // opzionale, per immagini/documenti
}
```

---

## 4. Esempio di Implementazione di una Action

```php
namespace Modules\Notify\Actions\WhatsApp;

use Exception;
use GuzzleHttp\Client;
use Modules\Notify\Contracts\WhatsAppActionInterface;
use Modules\Notify\Datas\WhatsAppMessageData;
use Spatie\QueueableAction\QueueableAction;

final class SendTwilioWhatsAppAction implements WhatsAppActionInterface
{
    use QueueableAction;

    public function execute(WhatsAppMessageData $data): array
    {
        $client = new Client();
        $endpoint = 'https://api.twilio.com/2010-04-01/Accounts/' . config('whatsapp.drivers.twilio.account_sid') . '/Messages.json';
        $auth = [config('whatsapp.drivers.twilio.account_sid'), config('whatsapp.drivers.twilio.auth_token')];

        $body = [
            'From' => config('whatsapp.drivers.twilio.from'),
            'To' => $data->to,
            'Body' => $data->body,
        ];
        if ($data->media) {
            $body['MediaUrl'] = $data->media;
        }

        try {
            $response = $client->post($endpoint, [
                'auth' => $auth,
                'form_params' => $body,
            ]);
            return [
                'status_code' => $response->getStatusCode(),
                'body' => $response->getBody()->getContents(),
            ];
        } catch (Exception $e) {
            throw new Exception('Errore invio WhatsApp: ' . $e->getMessage(), $e->getCode(), $e);
        }
    }
}
```

---

## 5. Utilizzo e Queue

**Invio sincrono:**
```php
use Modules\Notify\Datas\WhatsAppMessageData;
use Modules\Notify\Actions\WhatsApp\SendTwilioWhatsAppAction;

$data = new WhatsAppMessageData(
    to: '+393331234567',
    from: 'whatsapp:+14155238886',
    body: 'Messaggio di test'
);

$action = new SendTwilioWhatsAppAction();
$result = $action->execute($data);
```

**Invio asincrono (in coda):**
```php
$action->onQueue('whatsapp')->execute($data);
```

---

## 6. Gestione Errori e Logging

- Gestire tutte le eccezioni e loggare errori critici.
- Restituire sempre un array con `status_code` e `body`.
- Implementare retry e circuit breaker secondo la configurazione globale.

---

## 7. Best Practice

- **Non duplicare parametri generici nei driver**: retry, rate_limit, timeout, debug sono globali.
- **DTO obbligatorio**: nessun invio senza validazione dati.
- **Naming e path**: rispettare PSR-4, tutto minuscolo per `app/`.
- **Mai riferimenti a progetti specifici**.
- **Documentare ogni provider aggiunto**.
- **Testare ogni action in modo indipendente**.
- **Aggiornare la documentazione ad ogni modifica strutturale**.

---

## 8. Provider Supportati e Link Utili

- [Twilio WhatsApp API](https://www.twilio.com/docs/whatsapp)
- [Vonage WhatsApp API](https://developer.vonage.com/en/messages/whatsapp/overview)
- [WhatsApp Business API Facebook](https://developers.facebook.com/docs/whatsapp)
- [spatie/laravel-queueable-action](https://github.com/spatie/laravel-queueable-action)
- [Esempi community](https://laracasts.com/discuss/channels/laravel/send-whatsapp-message-with-laravel)
- [Altri pacchetti open source](https://github.com/netflie/laravel-notification-whatsapp), [MissaelAnda/laravel-whatsapp](https://github.com/MissaelAnda/laravel-whatsapp), [xaamin/whatsapi](https://github.com/xaamin/whatsapi), [cipto-hd/laravel-whatsapp-notification](https://github.com/cipto-hd/laravel-whatsapp-notification), [7span/laravel-whatsapp](https://github.com/7span/laravel-whatsapp), [sawirricardo/laravel-whatsapp](https://github.com/sawirricardo/laravel-whatsapp)

---

## 9. Testing

- Ogni action deve avere test di unità e di integrazione.
- Simulare risposte dei provider e gestire casi di errore.
- Verificare la validazione dei DTO.

---

## 10. Troubleshooting

- Verificare sempre la configurazione delle credenziali.
- Controllare i log in caso di errori di invio.
- Usare strumenti di monitoraggio per le code e i retry.

---

## 11. Aggiornamento Regole e Memorie

- Aggiornare sempre le regole interne, la documentazione e le memorie ogni volta che si aggiunge o modifica un provider WhatsApp.
- Non ripetere mai errori di path, naming, duplicazione parametri o riferimenti a progetti specifici.

---

**Seguendo questo standard, l'invio di messaggi WhatsApp sarà sempre coerente, sicuro, testabile e facilmente estendibile.** 

---

## whatsapp-sending-standard

*Consolidated from: `whatsapp-sending-standard.md`*


## Introduzione
Questa guida definisce lo standard per l'invio di messaggi WhatsApp all'interno del modulo Notify, seguendo la stessa architettura modulare, configurazione e best practice già adottate per email e SMS. L'obiettivo è garantire coerenza, riusabilità e facilità di manutenzione, indipendentemente dal provider utilizzato (Twilio, Vonage, WhatsApp Business API, ecc.).

---

## 1. Struttura delle Azioni WhatsApp

- Ogni provider WhatsApp deve avere una propria action in `app/Actions/WhatsApp`.
- Tutte le azioni devono implementare una interfaccia comune, ad esempio `WhatsAppActionInterface` (da posizionare in `app/Contracts`).
- Le azioni devono accettare un DTO standardizzato (es. `WhatsAppMessageData` in `app/Datas`).
- La naming convention è: `Send<Provider>WhatsAppAction.php` (es. `SendTwilioWhatsAppAction.php`).

**Esempio di interfaccia:**
```php
namespace Modules\Notify\Contracts;

use Modules\Notify\Datas\WhatsAppMessageData;

interface WhatsAppActionInterface
{
    /**
     * Invia un messaggio WhatsApp tramite provider specifico.
     * @param WhatsAppMessageData $data
     * @return array
     */
    public function execute(WhatsAppMessageData $data): array;
}
```

---

## 2. Configurazione

- Tutti i provider WhatsApp vanno configurati in `config/whatsapp.php` (o in una sezione dedicata di `config/services.php` o `config/notify.php`).
- I parametri generici (retry, rate_limit, timeout, circuit_breaker, debug) devono essere globali e non duplicati nei singoli driver.
- I parametri specifici del provider (es. api_key, sender, endpoint) vanno nella sezione del driver.

**Esempio di configurazione:**
```php
return [
    'default' => env('WHATSAPP_DRIVER', 'twilio'),
    'drivers' => [
        'twilio' => [
            'account_sid' => env('TWILIO_ACCOUNT_SID'),
            'auth_token' => env('TWILIO_AUTH_TOKEN'),
            'from' => env('TWILIO_WHATSAPP_FROM'),
        ],
        'vonage' => [
            'api_key' => env('VONAGE_API_KEY'),
            'api_secret' => env('VONAGE_API_SECRET'),
            'from' => env('VONAGE_WHATSAPP_FROM'),
        ],
        // ... altri provider
    ],
    'debug' => env('WHATSAPP_DEBUG', false),
    'retry' => [
        'attempts' => env('WHATSAPP_RETRY_ATTEMPTS', 3),
        'delay' => env('WHATSAPP_RETRY_DELAY', 60),
    ],
    'rate_limit' => [
        'enabled' => env('WHATSAPP_RATE_LIMIT_ENABLED', true),
        'max_attempts' => env('WHATSAPP_RATE_LIMIT_MAX_ATTEMPTS', 60),
        'decay_minutes' => env('WHATSAPP_RATE_LIMIT_DECAY_MINUTES', 1),
    ],
    'timeout' => env('WHATSAPP_TIMEOUT', 30),
];
```

---

## 3. DTO Standardizzato

- I dati del messaggio WhatsApp devono essere incapsulati in un DTO in `app/Datas/WhatsAppMessageData.php`.
- Utilizzare `spatie/laravel-data` per la validazione e la tipizzazione.

**Esempio:**
```php
namespace Modules\Notify\Datas;

use Spatie\LaravelData\Data;

class WhatsAppMessageData extends Data
{
    public string $to;
    public string $from;
    public string $body;
    public ?array $media = null; // opzionale, per immagini/documenti
}
```

---

## 4. Esempio di Implementazione di una Action

```php
namespace Modules\Notify\Actions\WhatsApp;

use Exception;
use GuzzleHttp\Client;
use Modules\Notify\Contracts\WhatsAppActionInterface;
use Modules\Notify\Datas\WhatsAppMessageData;
use Spatie\QueueableAction\QueueableAction;

final class SendTwilioWhatsAppAction implements WhatsAppActionInterface
{
    use QueueableAction;

    public function execute(WhatsAppMessageData $data): array
    {
        $client = new Client();
        $endpoint = 'https://api.twilio.com/[DATE]/Accounts/' . config('whatsapp.drivers.twilio.account_sid') . '/Messages.json';
        $auth = [config('whatsapp.drivers.twilio.account_sid'), config('whatsapp.drivers.twilio.auth_token')];

        $body = [
            'From' => config('whatsapp.drivers.twilio.from'),
            'To' => $data->to,
            'Body' => $data->body,
        ];
        if ($data->media) {
            $body['MediaUrl'] = $data->media;
        }

        try {
            $response = $client->post($endpoint, [
                'auth' => $auth,
                'form_params' => $body,
            ]);
            return [
                'status_code' => $response->getStatusCode(),
                'body' => $response->getBody()->getContents(),
            ];
        } catch (Exception $e) {
            throw new Exception('Errore invio WhatsApp: ' . $e->getMessage(), $e->getCode(), $e);
        }
    }
}
```

---

## 5. Utilizzo e Queue

**Invio sincrono:**
```php
use Modules\Notify\Datas\WhatsAppMessageData;
use Modules\Notify\Actions\WhatsApp\SendTwilioWhatsAppAction;

$data = new WhatsAppMessageData(
    to: '+393331234567',
    from: 'whatsapp:+14155238886',
    body: 'Messaggio di test'
);

$action = new SendTwilioWhatsAppAction();
$result = $action->execute($data);
```

**Invio asincrono (in coda):**
```php
$action->onQueue('whatsapp')->execute($data);
```

---

## 6. Gestione Errori e Logging

- Gestire tutte le eccezioni e loggare errori critici.
- Restituire sempre un array con `status_code` e `body`.
- Implementare retry e circuit breaker secondo la configurazione globale.

---

## 7. Best Practice

- **Non duplicare parametri generici nei driver**: retry, rate_limit, timeout, debug sono globali.
- **DTO obbligatorio**: nessun invio senza validazione dati.
- **Naming e path**: rispettare PSR-4, tutto minuscolo per `app/`.
- **Mai riferimenti a progetti specifici**.
- **Documentare ogni provider aggiunto**.
- **Testare ogni action in modo indipendente**.
- **Aggiornare la documentazione ad ogni modifica strutturale**.

---

## 8. Provider Supportati e Link Utili

- [Twilio WhatsApp API](https://www.twilio.com/docs/whatsapp)
- [Vonage WhatsApp API](https://developer.vonage.com/en/messages/whatsapp/overview)
- [WhatsApp Business API Facebook](https://developers.facebook.com/docs/whatsapp)
- [spatie/laravel-queueable-action](https://github.com/spatie/laravel-queueable-action)
- [Esempi community](https://laracasts.com/discuss/channels/laravel/send-whatsapp-message-with-laravel)
- [Altri pacchetti open source](https://github.com/netflie/laravel-notification-whatsapp), [MissaelAnda/laravel-whatsapp](https://github.com/MissaelAnda/laravel-whatsapp), [xaamin/whatsapi](https://github.com/xaamin/whatsapi), [cipto-hd/laravel-whatsapp-notification](https://github.com/cipto-hd/laravel-whatsapp-notification), [7span/laravel-whatsapp](https://github.com/7span/laravel-whatsapp), [sawirricardo/laravel-whatsapp](https://github.com/sawirricardo/laravel-whatsapp)

---

## 9. Testing

- Ogni action deve avere test di unità e di integrazione.
- Simulare risposte dei provider e gestire casi di errore.
- Verificare la validazione dei DTO.

---

## 10. Troubleshooting

- Verificare sempre la configurazione delle credenziali.
- Controllare i log in caso di errori di invio.
- Usare strumenti di monitoraggio per le code e i retry.

---

## 11. Aggiornamento Regole e Memorie

- Aggiornare sempre le regole interne, la documentazione e le memorie ogni volta che si aggiunge o modifica un provider WhatsApp.
- Non ripetere mai errori di path, naming, duplicazione parametri o riferimenti a progetti specifici.

---

**Seguendo questo standard, l'invio di messaggi WhatsApp sarà sempre coerente, sicuro, testabile e facilmente estendibile.** 

---

## whatsapp

*Consolidated from: `whatsapp.md`*


tutorial
https://medium.com/@snomanali1996/whatsapp-integration-with-laravel-using-twilio-api-9bd8ecd06dbf#id_token=eyJhbGciOiJSUzI1NiIsImtpZCI6ImEzYjc2MmY4NzFjZGIzYmFlMDA0NGM2NDk2MjJmYzEzOTZlZGEzZTMiLCJ0eXAiOiJKV1QifQ.eyJpc3MiOiJodHRwczovL2FjY291bnRzLmdvb2dsZS5jb20iLCJhenAiOiIyMTYyOTYwMzU4MzQtazFrNnFlMDYwczJ0cDJhMmphbTRsamRjbXMwMHN0dGcuYXBwcy5nb29nbGV1c2VyY29udGVudC5jb20iLCJhdWQiOiIyMTYyOTYwMzU4MzQtazFrNnFlMDYwczJ0cDJhMmphbTRsamRjbXMwMHN0dGcuYXBwcy5nb29nbGV1c2VyY29udGVudC5jb20iLCJzdWIiOiIxMTU5MDIwMjQzMjQ3MDkwMzIyMDkiLCJlbWFpbCI6Im1hcmNvLnNvdHRhbmFAZ21haWwuY29tIiwiZW1haWxfdmVyaWZpZWQiOnRydWUsIm5iZiI6MTcxNTg0MzUyMSwibmFtZSI6Ik1hcmNvIFNvdHRhbmEiLCJwaWN0dXJlIjoiaHR0cHM6Ly9saDMuZ29vZ2xldXNlcmNvbnRlbnQuY29tL2EvQUNnOG9jSUYxbWNZSmp0S0lfazl5TUlfMFlTVlprMmxlWTdJMlBwV3ljNk1MR0I5N2h2MHA1dzI9czk2LWMiLCJnaXZlbl9uYW1lIjoiTWFyY28iLCJmYW1pbHlfbmFtZSI6IlNvdHRhbmEiLCJpYXQiOjE3MTU4NDM4MjEsImV4cCI6MTcxNTg0NzQyMSwianRpIjoiZjdiYjEwNDhhNTkwMWYzMWIwY2E4NDhmY2Q2Zjk1ZjhhY2FmZmUxMiJ9.KKOALFgLe1bPDydIwVMMKxm13eUptiYbadyytOc0bV2bdahDDsc-LUROZR3mIYvbheUcYChJNWkgK7ulHWnp4H36-FdNhKMrLuGIqU79jwEUwgJITYW9s7HJ6OxrTY5ieFJ3b8ituoAOHz8cSxmLOJt_XnnHpTSan_JUXe61In7nz72fX6dMBBv90KzNSZuTge2NqN3kply8qAFO7cDgxcMd11uy0-fVPBXNXIZGdj9wJhL2E0DOv9VjYcj1NHZov906NpyOB4c7siz0SaQHyD2IFUEi5Z5RGoEcsAqU7uhxylKv82rELgr7LHCSuuubtp-7a7eMMIfgJQDNrYoO9A


twilio - vonage
https://www.twilio.com/blog/create-laravel-php-notification-channel-whatsapp-twilio

ufficial 
https://developers.facebook.com/docs/whatsapp/cloud-api/get-started


---

## whatsapp_channel

*Consolidated from: `whatsapp_channel.md`*


## 1. Struttura Base

### 1.1 Data Transfer Objects
```php
<?php

namespace Modules\Notify\Datas;

use Spatie\LaravelData\Data;

class WhatsAppMessageData extends Data
{
    public function __construct(
        public string $to,
        public string $message,
        public ?string $template = null,
        public ?array $parameters = null,
        public ?string $mediaUrl = null,
        public ?string $mediaType = null
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            to: $data['to'],
            message: $data['message'],
            template: $data['template'] ?? null,
            parameters: $data['parameters'] ?? null,
            mediaUrl: $data['media_url'] ?? null,
            mediaType: $data['media_type'] ?? null
        );
    }
}
```

### 1.2 Interfaccia
```php
<?php

namespace Modules\Notify\Contracts\WhatsApp;

use Modules\Notify\Datas\WhatsAppMessageData;

interface WhatsAppActionInterface
{
    /**
     * Esegue l'invio del messaggio WhatsApp
     *
     * @param WhatsAppMessageData $messageData I dati del messaggio
     * @return array Risultato dell'operazione
     * @throws \Exception In caso di errore durante l'invio
     */
    public function execute(WhatsAppMessageData $messageData): array;
}
```

## 2. Configurazione

### 2.1 Config File
```php
<?php
// config/notify.php

return [
    'drivers' => [
        'whatsapp' => [
            'twilio' => [
                'account_sid' => env('TWILIO_ACCOUNT_SID'),
                'auth_token' => env('TWILIO_AUTH_TOKEN'),
                'from' => env('TWILIO_WHATSAPP_FROM'),
                'endpoint' => env('TWILIO_WHATSAPP_ENDPOINT', 'https://api.twilio.com/2010-04-01/Accounts/{AccountSid}/Messages.json'),
            ],
            'vonage' => [
                'api_key' => env('VONAGE_API_KEY'),
                'api_secret' => env('VONAGE_API_SECRET'),
                'from' => env('VONAGE_WHATSAPP_FROM'),
                'endpoint' => env('VONAGE_WHATSAPP_ENDPOINT', 'https://api.nexmo.com/v1/messages'),
            ],
            'meta' => [
                'access_token' => env('META_WHATSAPP_ACCESS_TOKEN'),
                'phone_number_id' => env('META_WHATSAPP_PHONE_NUMBER_ID'),
                'business_account_id' => env('META_WHATSAPP_BUSINESS_ACCOUNT_ID'),
                'endpoint' => env('META_WHATSAPP_ENDPOINT', 'https://graph.facebook.com/v17.0/{Phone-Number-ID}/messages'),
            ],
        ],
    ],

    'default' => env('WHATSAPP_DRIVER', 'twilio'),

    'debug' => env('WHATSAPP_DEBUG', false),

    'retry' => [
        'attempts' => env('WHATSAPP_RETRY_ATTEMPTS', 3),
        'delay' => env('WHATSAPP_RETRY_DELAY', 60),
    ],

    'rate_limit' => [
        'enabled' => env('WHATSAPP_RATE_LIMIT_ENABLED', true),
        'max_attempts' => env('WHATSAPP_RATE_LIMIT_MAX_ATTEMPTS', 60),
        'decay_minutes' => env('WHATSAPP_RATE_LIMIT_DECAY_MINUTES', 1),
    ],
];
```

### 2.2 Environment Variables
```env

# Twilio WhatsApp
TWILIO_ACCOUNT_SID=your_account_sid
TWILIO_AUTH_TOKEN=your_auth_token
TWILIO_WHATSAPP_FROM=whatsapp:+14155238886

# Vonage WhatsApp
VONAGE_API_KEY=your_api_key
VONAGE_API_SECRET=your_api_secret
VONAGE_WHATSAPP_FROM=whatsapp:+14155238886

# Meta WhatsApp
META_WHATSAPP_ACCESS_TOKEN=your_access_token
META_WHATSAPP_PHONE_NUMBER_ID=your_phone_number_id
META_WHATSAPP_BUSINESS_ACCOUNT_ID=your_business_account_id

# Global WhatsApp configuration
WHATSAPP_DRIVER=twilio
WHATSAPP_DEBUG=false
WHATSAPP_RETRY_ATTEMPTS=3
WHATSAPP_RETRY_DELAY=60
WHATSAPP_RATE_LIMIT_ENABLED=true
WHATSAPP_RATE_LIMIT_MAX_ATTEMPTS=60
WHATSAPP_RATE_LIMIT_DECAY_MINUTES=1
```

## 3. Implementazione

### 3.1 Action Base
```php
<?php

namespace Modules\Notify\Actions\WhatsApp;

use Modules\Notify\Contracts\WhatsApp\WhatsAppActionInterface;
use Modules\Notify\Datas\WhatsAppMessageData;
use Spatie\QueueableAction\QueueableAction;

abstract class BaseWhatsAppAction implements WhatsAppActionInterface
{
    use QueueableAction;

    protected string $driver;
    protected array $config;
    protected bool $debug;
    protected int $timeout;

    public function __construct(string $driver = null)
    {
        $this->driver = $driver ?? config('notify.default');
        $this->config = config("notify.drivers.whatsapp.{$this->driver}");
        $this->debug = (bool) config('notify.debug', false);
        $this->timeout = (int) config('notify.timeout', 30);
    }

    abstract public function execute(WhatsAppMessageData $messageData): array;
}
```

### 3.2 Provider Specifici
```php
<?php

namespace Modules\Notify\Actions\WhatsApp;

use Modules\Notify\Datas\WhatsAppMessageData;

class TwilioWhatsAppAction extends BaseWhatsAppAction
{
    public function execute(WhatsAppMessageData $messageData): array
    {
        // Implementazione specifica per Twilio
    }
}

class VonageWhatsAppAction extends BaseWhatsAppAction
{
    public function execute(WhatsAppMessageData $messageData): array
    {
        // Implementazione specifica per Vonage
    }
}

class MetaWhatsAppAction extends BaseWhatsAppAction
{
    public function execute(WhatsAppMessageData $messageData): array
    {
        // Implementazione specifica per Meta
    }
}
```

## 4. Utilizzo

### 4.1 Nel Model
```php
<?php

namespace Modules\Patient\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    use Notifiable;

    /**
     * Route notifications for the WhatsApp channel.
     *
     * @return string
     */
    public function routeNotificationForWhatsApp(): string
    {
        return $this->whatsapp_number;
    }

    /**
     * Verifica se l'utente può ricevere WhatsApp
     *
     * @return bool
     */
    public function canReceiveWhatsApp(): bool
    {
        return !empty($this->whatsapp_number) && $this->consent_whatsapp;
    }
}
```

### 4.2 Invio Notifica
```php
// Direttamente
$user->notify(new WhatsAppNotification('Il tuo codice OTP è: 123456'));

// Con Action
$action = new TwilioWhatsAppAction();
$result = $action->execute(new WhatsAppMessageData(
    to: $user->whatsapp_number,
    message: 'Il tuo codice OTP è: 123456'
));

// Con validazione
if ($user->canReceiveWhatsApp()) {
    $user->notify(new WhatsAppNotification('Il tuo codice OTP è: 123456'));
}
```

## 5. Best Practices

### 5.1 Validazione
- Validare sempre il numero WhatsApp
- Verificare la lunghezza del messaggio
- Controllare il formato dei template
- Validare i parametri dei template
- Verificare il consenso dell'utente
- Controllare i limiti di rate

### 5.2 Gestione Errori
- Usare try/catch per gestire le eccezioni
- Loggare gli errori con dettagli
- Implementare retry per fallimenti temporanei
- Gestire i codici di errore specifici
- Implementare circuit breaker
- Monitorare il tasso di errore

### 5.3 Performance
- Utilizzare le code per l'invio
- Implementare rate limiting
- Monitorare l'uso dell'API
- Gestire il batch di invii
- Implementare caching
- Ottimizzare le query

### 5.4 Sicurezza
- Validare l'input degli utenti
- Sanitizzare i messaggi
- Proteggere le chiavi API
- Implementare logging sicuro
- Gestire i timeout
- Implementare rate limiting per IP

## 6. Testing

### 6.1 Unit Test
```php
<?php

namespace Modules\Notify\Tests\Unit;

use Tests\TestCase;
use Modules\Notify\Actions\WhatsApp\TwilioWhatsAppAction;
use Modules\Notify\Datas\WhatsAppMessageData;
use Illuminate\Support\Facades\Http;

class WhatsAppTest extends TestCase
{
    public function test_whatsapp_sent_successfully()
    {
        Http::fake([
            'api.twilio.com/*' => Http::response([
                'status' => 'sent',
                'sid' => 'SM123456'
            ], 200)
        ]);

        $action = new TwilioWhatsAppAction();
        $result = $action->execute(new WhatsAppMessageData(
            to: '+393331234567',
            message: 'Test message'
        ));

        $this->assertTrue($result['success']);
        $this->assertEquals('SM123456', $result['message_id']);
    }
}
```

## 7. Collegamenti Utili

- [Twilio WhatsApp API](https://www.twilio.com/whatsapp)
- [Vonage WhatsApp API](https://developer.vonage.com/messaging/whatsapp/overview)
- [Meta WhatsApp Business API](https://developers.facebook.com/project_docs/whatsapp/cloud-api)
- [Laravel Notifications](https://laravel.com/project_docs/notifications)
- [Laravel Queues](https://laravel.com/project_docs/queues)
- [Laravel Testing](https://laravel.com/project_docs/testing)
- [Laravel Logging](https://laravel.com/project_docs/logging)
- [Laravel Cache](https://laravel.com/project_docs/cache) 
- [Meta WhatsApp Business API](https://developers.facebook.com/docs/whatsapp/cloud-api)
- [Laravel Notifications](https://laravel.com/docs/notifications)
- [Laravel Queues](https://laravel.com/docs/queues)
- [Laravel Testing](https://laravel.com/docs/testing)
- [Laravel Logging](https://laravel.com/docs/logging)
- [Laravel Cache](https://laravel.com/docs/cache) 

---

## whatsapp_integration

*Consolidated from: `whatsapp_integration.md`*

# Integrazione WhatsApp

## Panoramica

Questo documento descrive l'architettura e l'implementazione dell'integrazione WhatsApp nel modulo Notify di <nome progetto>, seguendo gli stessi standard e pattern utilizzati per l'invio di email e SMS.
# Integrazione WhatsApp 

## Panoramica

Questo documento descrive l'architettura e l'implementazione dell'integrazione WhatsApp nel modulo Notify di SaluteOra, seguendo gli stessi standard e pattern utilizzati per l'invio di email e SMS.

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
    body: 'Questo è un messaggio di test da <nome progetto>',
    body: 'Questo è un messaggio di test da SaluteOra',
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

Seguendo questa architettura, l'integrazione WhatsApp si inserisce perfettamente nell'ecosistema di notifiche di <nome progetto>, mantenendo la coerenza con le altre modalità di comunicazione.
Seguendo questa architettura, l'integrazione WhatsApp si inserisce perfettamente nell'ecosistema di notifiche di SaluteOra, mantenendo la coerenza con le altre modalità di comunicazione.

---

*Ultimo aggiornamento: 2023-05-12*

---

## whatsapp_sending_standard

*Consolidated from: `whatsapp_sending_standard.md`*


## Introduzione
Questa guida definisce lo standard per l'invio di messaggi WhatsApp all'interno del modulo Notify, seguendo la stessa architettura modulare, configurazione e best practice già adottate per email e SMS. L'obiettivo è garantire coerenza, riusabilità e facilità di manutenzione, indipendentemente dal provider utilizzato (Twilio, Vonage, WhatsApp Business API, ecc.).

---

## 1. Struttura delle Azioni WhatsApp

- Ogni provider WhatsApp deve avere una propria action in `app/Actions/WhatsApp`.
- Tutte le azioni devono implementare una interfaccia comune, ad esempio `WhatsAppActionInterface` (da posizionare in `app/Contracts`).
- Le azioni devono accettare un DTO standardizzato (es. `WhatsAppMessageData` in `app/Datas`).
- La naming convention è: `Send<Provider>WhatsAppAction.php` (es. `SendTwilioWhatsAppAction.php`).

**Esempio di interfaccia:**
```php
namespace Modules\Notify\Contracts;

use Modules\Notify\Datas\WhatsAppMessageData;

interface WhatsAppActionInterface
{
    /**
     * Invia un messaggio WhatsApp tramite provider specifico.
     * @param WhatsAppMessageData $data
     * @return array
     */
    public function execute(WhatsAppMessageData $data): array;
}
```

---

## 2. Configurazione

- Tutti i provider WhatsApp vanno configurati in `config/whatsapp.php` (o in una sezione dedicata di `config/services.php` o `config/notify.php`).
- I parametri generici (retry, rate_limit, timeout, circuit_breaker, debug) devono essere globali e non duplicati nei singoli driver.
- I parametri specifici del provider (es. api_key, sender, endpoint) vanno nella sezione del driver.

**Esempio di configurazione:**
```php
return [
    'default' => env('WHATSAPP_DRIVER', 'twilio'),
    'drivers' => [
        'twilio' => [
            'account_sid' => env('TWILIO_ACCOUNT_SID'),
            'auth_token' => env('TWILIO_AUTH_TOKEN'),
            'from' => env('TWILIO_WHATSAPP_FROM'),
        ],
        'vonage' => [
            'api_key' => env('VONAGE_API_KEY'),
            'api_secret' => env('VONAGE_API_SECRET'),
            'from' => env('VONAGE_WHATSAPP_FROM'),
        ],
        // ... altri provider
    ],
    'debug' => env('WHATSAPP_DEBUG', false),
    'retry' => [
        'attempts' => env('WHATSAPP_RETRY_ATTEMPTS', 3),
        'delay' => env('WHATSAPP_RETRY_DELAY', 60),
    ],
    'rate_limit' => [
        'enabled' => env('WHATSAPP_RATE_LIMIT_ENABLED', true),
        'max_attempts' => env('WHATSAPP_RATE_LIMIT_MAX_ATTEMPTS', 60),
        'decay_minutes' => env('WHATSAPP_RATE_LIMIT_DECAY_MINUTES', 1),
    ],
    'timeout' => env('WHATSAPP_TIMEOUT', 30),
];
```

---

## 3. DTO Standardizzato

- I dati del messaggio WhatsApp devono essere incapsulati in un DTO in `app/Datas/WhatsAppMessageData.php`.
- Utilizzare `spatie/laravel-data` per la validazione e la tipizzazione.

**Esempio:**
```php
namespace Modules\Notify\Datas;

use Spatie\LaravelData\Data;

class WhatsAppMessageData extends Data
{
    public string $to;
    public string $from;
    public string $body;
    public ?array $media = null; // opzionale, per immagini/documenti
}
```

---

## 4. Esempio di Implementazione di una Action

```php
namespace Modules\Notify\Actions\WhatsApp;

use Exception;
use GuzzleHttp\Client;
use Modules\Notify\Contracts\WhatsAppActionInterface;
use Modules\Notify\Datas\WhatsAppMessageData;
use Spatie\QueueableAction\QueueableAction;

final class SendTwilioWhatsAppAction implements WhatsAppActionInterface
{
    use QueueableAction;

    public function execute(WhatsAppMessageData $data): array
    {
        $client = new Client();
        $endpoint = 'https://api.twilio.com/2010-04-01/Accounts/' . config('whatsapp.drivers.twilio.account_sid') . '/Messages.json';
        $auth = [config('whatsapp.drivers.twilio.account_sid'), config('whatsapp.drivers.twilio.auth_token')];

        $body = [
            'From' => config('whatsapp.drivers.twilio.from'),
            'To' => $data->to,
            'Body' => $data->body,
        ];
        if ($data->media) {
            $body['MediaUrl'] = $data->media;
        }

        try {
            $response = $client->post($endpoint, [
                'auth' => $auth,
                'form_params' => $body,
            ]);
            return [
                'status_code' => $response->getStatusCode(),
                'body' => $response->getBody()->getContents(),
            ];
        } catch (Exception $e) {
            throw new Exception('Errore invio WhatsApp: ' . $e->getMessage(), $e->getCode(), $e);
        }
    }
}
```

---

## 5. Utilizzo e Queue

**Invio sincrono:**
```php
use Modules\Notify\Datas\WhatsAppMessageData;
use Modules\Notify\Actions\WhatsApp\SendTwilioWhatsAppAction;

$data = new WhatsAppMessageData(
    to: '+393331234567',
    from: 'whatsapp:+14155238886',
    body: 'Messaggio di test'
);

$action = new SendTwilioWhatsAppAction();
$result = $action->execute($data);
```

**Invio asincrono (in coda):**
```php
$action->onQueue('whatsapp')->execute($data);
```

---

## 6. Gestione Errori e Logging

- Gestire tutte le eccezioni e loggare errori critici.
- Restituire sempre un array con `status_code` e `body`.
- Implementare retry e circuit breaker secondo la configurazione globale.

---

## 7. Best Practice

- **Non duplicare parametri generici nei driver**: retry, rate_limit, timeout, debug sono globali.
- **DTO obbligatorio**: nessun invio senza validazione dati.
- **Naming e path**: rispettare PSR-4, tutto minuscolo per `app/`.
- **Mai riferimenti a progetti specifici**.
- **Documentare ogni provider aggiunto**.
- **Testare ogni action in modo indipendente**.
- **Aggiornare la documentazione ad ogni modifica strutturale**.

---

## 8. Provider Supportati e Link Utili

- [Twilio WhatsApp API](https://www.twilio.com/docs/whatsapp)
- [Vonage WhatsApp API](https://developer.vonage.com/en/messages/whatsapp/overview)
- [WhatsApp Business API Facebook](https://developers.facebook.com/docs/whatsapp)
- [spatie/laravel-queueable-action](https://github.com/spatie/laravel-queueable-action)
- [Esempi community](https://laracasts.com/discuss/channels/laravel/send-whatsapp-message-with-laravel)
- [Altri pacchetti open source](https://github.com/netflie/laravel-notification-whatsapp), [MissaelAnda/laravel-whatsapp](https://github.com/MissaelAnda/laravel-whatsapp), [xaamin/whatsapi](https://github.com/xaamin/whatsapi), [cipto-hd/laravel-whatsapp-notification](https://github.com/cipto-hd/laravel-whatsapp-notification), [7span/laravel-whatsapp](https://github.com/7span/laravel-whatsapp), [sawirricardo/laravel-whatsapp](https://github.com/sawirricardo/laravel-whatsapp)

---

## 9. Testing

- Ogni action deve avere test di unità e di integrazione.
- Simulare risposte dei provider e gestire casi di errore.
- Verificare la validazione dei DTO.

---

## 10. Troubleshooting

- Verificare sempre la configurazione delle credenziali.
- Controllare i log in caso di errori di invio.
- Usare strumenti di monitoraggio per le code e i retry.

---

## 11. Aggiornamento Regole e Memorie

- Aggiornare sempre le regole interne, la documentazione e le memorie ogni volta che si aggiunge o modifica un provider WhatsApp.
- Non ripetere mai errori di path, naming, duplicazione parametri o riferimenti a progetti specifici.

---

**Seguendo questo standard, l'invio di messaggi WhatsApp sarà sempre coerente, sicuro, testabile e facilmente estendibile.** 

---

**Consolidated by:** Phase 2f intelligent merging
**Date:** 2026-08-04