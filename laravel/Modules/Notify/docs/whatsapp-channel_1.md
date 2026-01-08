


=======
>>>>>>> 75179b85 (.)
=======
>>>>>>> f963d2c0 (.)
=======
>>>>>>> ee18dd92 (.)
=======
>>>>>>> 66453ace (.)
=======
>>>>>>> 2a97406c (.)
=======
>>>>>>> 4f042b88 (.)
=======
>>>>>>> 36321fcb (.)
=======
>>>>>>> 712617d3 (.)
=======
>>>>>>> fdb24863 (rebase 210)
=======
>>>>>>> 4fc21b78 (rebase 210)

=======
>>>>>>> 4f3927d7 (.)
=======
>>>>>>> c8b1c8bf (.)

=======
>>>>>>> 75179b855 (.)
=======
>>>>>>> f963d2c0 (.)
=======
>>>>>>> ee18dd92 (.)
=======
>>>>>>> 66453ace (.)
=======
>>>>>>> 2a97406c (.)
=======
>>>>>>> 4f042b88 (.)
=======
>>>>>>> 36321fcb (.)
=======
>>>>>>> 712617d3 (.)
>>>>>>> laraxot/develop
=======
>>>>>>> 2a97406c (.)
>>>>>>> 998e6866b (.)
=======
>>>>>>> 36136dcfa (.)
=======
=======
>>>>>>> 36321fcb (.)
>>>>>>> 70175d0c4 (.)
=======
>>>>>>> 731b801a8 (.)
=======
=======
>>>>>>> fdb24863 (rebase 210)
>>>>>>> b85076e48 (.)
=======
>>>>>>> 43dd68f4b (.)
=======
=======
>>>>>>> 9c45d9bd (rebase 210)
>>>>>>> ce1853afd (.)
=======
>>>>>>> 7a142b4f5 (.)
=======
>>>>>>> c31e900eb (.)
=======
=======
>>>>>>> 36ac4fc1 (.)
>>>>>>> fea359347 (.)
=======
>>>>>>> d9e649ac3 (.)
=======
=======
>>>>>>> 4f3927d7 (.)
>>>>>>> 602b8a0a9 (.)
=======
>>>>>>> 7ceb00286 (.)
=======
=======
>>>>>>> 9cf0dc90 (.)
>>>>>>> 379ffe3f3 (.)
=======
>>>>>>> a55aa5e96 (.)
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

=======
>>>>>>> d09cb759 (.)
=======
>>>>>>> 75179b85 (.)

=======
>>>>>>> 7325acf3 (.)
=======
>>>>>>> 2a97406c (.)
=======
>>>>>>> f2e64178 (.)
=======
>>>>>>> 4f042b88 (.)
=======
>>>>>>> c4bdacbf (.)

=======
>>>>>>> c8b1c8bf (.)
=======
>>>>>>> 9cf0dc90 (.)
=======
>>>>>>> 75179b85 (.)
=======
>>>>>>> ee18dd92 (.)
=======
>>>>>>> 4689a827 (.)

=======
>>>>>>> c4bdacbf (.)
=======
>>>>>>> 36321fcb (.)
=======
>>>>>>> dceba960 (.)
=======
>>>>>>> 712617d3 (.)
=======
>>>>>>> bd804d67 (.)

=======
>>>>>>> fd1fcc4c (.)
=======
>>>>>>> e790eb33 (.)
=======
>>>>>>> 4f3927d7 (.)

=======
>>>>>>> d09cb759 (.)
=======
>>>>>>> 75179b855 (.)
=======
>>>>>>> f963d2c0 (.)
=======
>>>>>>> d09cb759 (.)
=======
>>>>>>> ee18dd92 (.)
=======
>>>>>>> 4689a827 (.)
=======
>>>>>>> 66453ace (.)
=======
>>>>>>> 7325acf3 (.)
=======
>>>>>>> 2a97406c (.)

=======
>>>>>>> 712617d3 (.)
=======
>>>>>>> bd804d67 (.)
>>>>>>> laraxot/develop
=======
>>>>>>> 1487fe812 (.)
=======
=======
>>>>>>> f963d2c0 (.)
>>>>>>> 12a7e2462 (.)
=======
>>>>>>> 510809c6f (.)
=======
=======
>>>>>>> ee18dd92 (.)
>>>>>>> 4bec160e6 (.)
=======
>>>>>>> 8dc1f2ed6 (.)
=======
=======
>>>>>>> 66453ace (.)
>>>>>>> 138485550 (.)
=======
>>>>>>> 2e9bd58c3 (.)
=======
>>>>>>> 998e6866b (.)
=======
=======
>>>>>>> f2e64178 (.)
>>>>>>> 23f115647 (.)
=======
>>>>>>> 36136dcfa (.)
=======
>>>>>>> a115e2aad (.)
=======
=======
>>>>>>> 36321fcb (.)
>>>>>>> 70175d0c4 (.)
=======
>>>>>>> 9cb55171f (.)
=======
=======
>>>>>>> 712617d3 (.)
>>>>>>> 731b801a8 (.)
=======
>>>>>>> 848f79b79 (.)
=======
=======
>>>>>>> fdb24863 (rebase 210)
>>>>>>> b85076e48 (.)
=======
>>>>>>> 3e757cee2 (.)
=======
>>>>>>> 43dd68f4b (.)
=======
=======
>>>>>>> 9c45d9bd (rebase 210)
>>>>>>> ce1853afd (.)
=======
>>>>>>> c188e2a18 (.)
=======
=======
>>>>>>> eb62d6cf (rebase 210)
>>>>>>> 7a142b4f5 (.)
=======
>>>>>>> cd5474106 (.)
=======
=======
>>>>>>> 8c8937e7 (rebase 210)
>>>>>>> c31e900eb (.)
=======
>>>>>>> 01750b107 (.)
=======
>>>>>>> fea359347 (.)
=======
=======
>>>>>>> 2effe245 (.)
>>>>>>> 26d39e2eb (.)
=======
>>>>>>> d9e649ac3 (.)
=======
=======
>>>>>>> e790eb33 (.)
>>>>>>> 2dab69c8a (.)
=======
>>>>>>> 602b8a0a9 (.)
=======
=======
>>>>>>> 3ee54c5d (.)
>>>>>>> 763771402 (.)
=======
>>>>>>> 7ceb00286 (.)
=======
>>>>>>> 379ffe3f3 (.)
=======
>>>>>>> a55aa5e96 (.)
- [Meta WhatsApp Business API](https://developers.facebook.com/project_docs/whatsapp/cloud-api)
- [Laravel Notifications](https://laravel.com/project_docs/notifications)
- [Laravel Queues](https://laravel.com/project_docs/queues)
- [Laravel Testing](https://laravel.com/project_docs/testing)
- [Laravel Logging](https://laravel.com/project_docs/logging)
- [Laravel Cache](https://laravel.com/project_docs/cache) 

=======
=======
>>>>>>> 4e2ebfb (.)
>>>>>>> 207ac35e (.)
=======
>>>>>>> 9777d1b3 (.)
=======
>>>>>>> f963d2c0 (.)
=======
=======
>>>>>>> d284d65 (.)
>>>>>>> d09cb759 (.)
=======
>>>>>>> 75179b85 (.)
=======
>>>>>>> 82ae73be (.)
=======
=======
>>>>>>> 4e2ebfb (.)
>>>>>>> 207ac35e (.)
=======
>>>>>>> 9777d1b3 (.)
=======
>>>>>>> f963d2c0 (.)
=======
=======
>>>>>>> d284d65 (.)
>>>>>>> d09cb759 (.)
=======
>>>>>>> 75179b85 (.)

=======
>>>>>>> 9777d1b3 (.)
>>>>>>> d09cb759 (.)
=======
>>>>>>> de02998b (.)
=======
=======
>>>>>>> 4e2ebfb (.)
>>>>>>> 011072e4 (.)
=======
>>>>>>> 161887a2 (.)
=======
>>>>>>> ee18dd92 (.)
=======
=======
>>>>>>> d284d65 (.)
>>>>>>> 4689a827 (.)
=======
>>>>>>> e7a9a2bf (.)

=======
>>>>>>> ba564870 (.)
>>>>>>> 7325acf3 (.)
=======
>>>>>>> 9cdf6146 (.)
=======
=======
>>>>>>> 4e2ebfb (.)
>>>>>>> 80f054e0 (.)
=======
>>>>>>> 7c39b1fe (.)
=======
>>>>>>> 3f39ac8b (.)
=======
=======
>>>>>>> 4e2ebfb (.)
>>>>>>> 4d2eb53e (.)
=======
>>>>>>> 888799d0 (.)
=======
>>>>>>> 2a97406c (.)


=======
>>>>>>> c6c33175 (.)
=======
>>>>>>> 4f042b88 (.)
=======
=======
>>>>>>> d284d65 (.)
>>>>>>> c4bdacbf (.)
=======
>>>>>>> 3b4c9907 (.)

=======
>>>>>>> 503981fd (.)
>>>>>>> dceba960 (.)
=======
>>>>>>> 8e5817bc (.)
=======
=======
>>>>>>> 4e2ebfb (.)
>>>>>>> e0d9c9be (.)
=======
>>>>>>> 7a2f131f (.)
=======
>>>>>>> 712617d3 (.)
=======
=======
>>>>>>> d284d65 (.)
>>>>>>> bd804d67 (.)
=======
>>>>>>> 51182e3c (rebase 210)

>>>>>>> 5aedc39c (rebase 210)

=======
=======
>>>>>>> d284d65 (.)
>>>>>>> 2effe245 (.)

=======
>>>>>>> 59916c8f (.)
>>>>>>> e790eb33 (.)
=======
>>>>>>> f81a620f (.)
=======
=======
>>>>>>> 4e2ebfb (.)
>>>>>>> 06e3078e (.)
=======
>>>>>>> 70e8274e (.)
=======
>>>>>>> 4f3927d7 (.)


>>>>>>> ce89c8bb (.)
=======
>>>>>>> 58816034 (.)
=======
>>>>>>> 9cf0dc90 (.)
=======
>>>>>>> 75179b85 (.)
>>>>>>> 207ac35e (.)
=======
>>>>>>> 9777d1b3 (.)
=======
>>>>>>> f963d2c0 (.)

=======
>>>>>>> de02998b (.)
>>>>>>> 011072e4 (.)
=======
>>>>>>> 161887a2 (.)
=======
>>>>>>> ee18dd92 (.)
=======
=======
>>>>>>> d284d65 (.)
>>>>>>> 4689a827 (.)
=======
>>>>>>> e7a9a2bf (.)
=======
=======
>>>>>>> 4e2ebfb (.)
>>>>>>> 9d67cabd (.)
=======
>>>>>>> ba564870 (.)
=======
>>>>>>> 66453ace (.)

=======
>>>>>>> 9cdf6146 (.)
>>>>>>> 80f054e0 (.)
=======
>>>>>>> 7c39b1fe (.)
=======
>>>>>>> 3f39ac8b (.)

=======
>>>>>>> 888799d0 (.)
>>>>>>> f2e64178 (.)
=======
>>>>>>> 6d08c01b (.)
=======
=======
>>>>>>> 4e2ebfb (.)
>>>>>>> 6b6b9e41 (.)
=======
>>>>>>> c6c33175 (.)
>>>>>>> c4bdacbf (.)
=======
>>>>>>> 3b4c9907 (.)
=======
=======
>>>>>>> 4e2ebfb (.)
>>>>>>> 5fe4f466 (.)
=======
>>>>>>> 503981fd (.)
=======
>>>>>>> 36321fcb (.)


=======
>>>>>>> 7a2f131f (.)
=======
>>>>>>> 712617d3 (.)
=======
=======
>>>>>>> d284d65 (.)
>>>>>>> bd804d67 (.)
=======
>>>>>>> 51182e3c (rebase 210)
=======
=======
>>>>>>> 4e2ebfb (.)
>>>>>>> cb85c538 (rebase 210)
=======
>>>>>>> 1c0eb9c7 (rebase 210)
=======
>>>>>>> fdb24863 (rebase 210)

>>>>>>> 1375c94d (rebase 210)
=======
>>>>>>> 52cd5f85 (rebase 210)
>>>>>>> 5aedc39c (rebase 210)
=======
>>>>>>> c5c038f2 (rebase 210)
=======
=======
>>>>>>> 4e2ebfb (.)
>>>>>>> 030c9674 (rebase 210)
=======
>>>>>>> bb00ab64 (rebase 210)
=======
>>>>>>> 8c8937e7 (rebase 210)

=======
>>>>>>> 77edd94a (.)
=======
=======
>>>>>>> 4e2ebfb (.)
>>>>>>> eea68ec9 (.)
=======
>>>>>>> 59916c8f (.)
=======
>>>>>>> fd1fcc4c (.)


=======
>>>>>>> 70e8274e (.)
>>>>>>> 3ee54c5d (.)
=======
>>>>>>> c8b1c8bf (.)
=======
>>>>>>> 2fc60436 (.)

=======
>>>>>>> 58816034 (.)
=======
>>>>>>> 82ae73be (.)
=======
=======
>>>>>>> 4e2ebfb (.)
>>>>>>> 207ac35e (.)
=======
>>>>>>> 9777d1b3 (.)
=======
>>>>>>> f963d2c0 (.)
=======
=======
>>>>>>> d284d65 (.)
>>>>>>> d09cb759 (.)
=======
>>>>>>> 75179b855 (.)
>>>>>>> 207ac35e (.)
=======
>>>>>>> 9777d1b3 (.)
=======
>>>>>>> f963d2c0 (.)
=======
=======
>>>>>>> d284d65 (.)
>>>>>>> d09cb759 (.)
=======
>>>>>>> de02998b (.)
=======
=======
>>>>>>> 4e2ebfb (.)
>>>>>>> 011072e4 (.)
=======
>>>>>>> 161887a2 (.)
=======
=======
>>>>>>> d284d65 (.)
>>>>>>> 4689a827 (.)
=======
>>>>>>> e7a9a2bf (.)
>>>>>>> 9d67cabd (.)
=======
>>>>>>> ba564870 (.)
=======
>>>>>>> 66453ace (.)
=======
=======
>>>>>>> d284d65 (.)
>>>>>>> 7325acf3 (.)
=======
>>>>>>> 9cdf6146 (.)

=======
>>>>>>> 7c39b1fe (.)
>>>>>>> 4d2eb53e (.)
=======
>>>>>>> 888799d0 (.)
=======
>>>>>>> 2a97406c (.)
=======
=======
>>>>>>> d284d65 (.)
>>>>>>> f2e64178 (.)
=======
>>>>>>> 6d08c01b (.)
=======
=======
>>>>>>> 4e2ebfb (.)
>>>>>>> 6b6b9e41 (.)
=======
>>>>>>> c6c33175 (.)
=======
>>>>>>> 4f042b88 (.)

=======
>>>>>>> 3b4c9907 (.)
>>>>>>> 5fe4f466 (.)
=======
>>>>>>> 503981fd (.)
=======
>>>>>>> 36321fcb (.)
=======
=======
>>>>>>> d284d65 (.)
>>>>>>> dceba960 (.)
=======
>>>>>>> 8e5817bc (.)
=======
=======
>>>>>>> 4e2ebfb (.)
>>>>>>> e0d9c9be (.)
=======
>>>>>>> 7a2f131f (.)
=======
=======
>>>>>>> d284d65 (.)
>>>>>>> bd804d67 (.)
>>>>>>> laraxot/develop
>>>>>>> 10292b60a (.)
=======
>>>>>>> bf5d31b0f (.)
=======
>>>>>>> 12a7e2462 (.)
=======
>>>>>>> 510809c6f (.)
=======
>>>>>>> de02998b (.)
>>>>>>> b207a9b1a (.)
=======
>>>>>>> 1619767d8 (.)
=======
>>>>>>> 4bec160e6 (.)
=======
>>>>>>> 8dc1f2ed6 (.)
=======
>>>>>>> d3a8af4d5 (.)
=======
>>>>>>> 4f19d70d2 (.)
=======
>>>>>>> 138485550 (.)
=======
>>>>>>> 2e9bd58c3 (.)
=======
>>>>>>> c22b35d1e (.)
=======
>>>>>>> 8f2456941 (.)
=======
>>>>>>> f87b41c3b (.)
=======
>>>>>>> 2f135ef98 (.)
=======
>>>>>>> 998e6866b (.)
=======
>>>>>>> 23f115647 (.)
=======
=======
>>>>>>> 6d08c01b (.)
>>>>>>> 138fcd4b0 (.)
=======
>>>>>>> be45a0b8d (.)
=======
>>>>>>> 36136dcfa (.)
=======
>>>>>>> a115e2aad (.)
=======
>>>>>>> db0bc148f (.)
=======
>>>>>>> 49639b815 (.)
=======
>>>>>>> 70175d0c4 (.)
=======
>>>>>>> 9cb55171f (.)
=======
=======
>>>>>>> 8e5817bc (.)
>>>>>>> 2641c2944 (.)
=======
>>>>>>> 968ed47cd (.)
=======
>>>>>>> 731b801a8 (.)
=======
>>>>>>> 848f79b79 (.)
=======
>>>>>>> 13655a7ed (.)
=======
>>>>>>> e0836b102 (.)
=======
>>>>>>> b85076e48 (.)
=======
>>>>>>> 3e757cee2 (.)
=======
>>>>>>> 903e3e2cd (.)
=======
>>>>>>> 47a873f13 (.)
=======
>>>>>>> 43dd68f4b (.)
=======
=======
>>>>>>> 9fe1b60e (rebase 210)
>>>>>>> a0788fa28 (.)
=======
>>>>>>> 69f695548 (.)
=======
>>>>>>> ce1853afd (.)
=======
>>>>>>> c188e2a18 (.)
=======
=======
>>>>>>> b4f93b3a (rebase 210)
>>>>>>> 5d49e093a (.)
=======
>>>>>>> 7a9167faf (.)
=======
>>>>>>> 7a142b4f5 (.)
=======
>>>>>>> cd5474106 (.)
=======
=======
>>>>>>> c5c038f2 (rebase 210)
>>>>>>> 17f6b8617 (.)
=======
>>>>>>> db6bec044 (.)
=======
>>>>>>> c31e900eb (.)
=======
>>>>>>> 01750b107 (.)
=======
=======
>>>>>>> 36ac4fc1 (.)
>>>>>>> fea359347 (.)
=======
>>>>>>> 26d39e2eb (.)
=======
=======
>>>>>>> 77edd94a (.)
>>>>>>> 2e1ac1f20 (.)
=======
>>>>>>> 6dad70a87 (.)
=======
>>>>>>> d9e649ac3 (.)
=======
>>>>>>> 2dab69c8a (.)
=======
=======
>>>>>>> f81a620f (.)
>>>>>>> e95dfc210 (.)
=======
>>>>>>> ec24613a1 (.)
=======
>>>>>>> 602b8a0a9 (.)
=======
>>>>>>> 763771402 (.)
=======
=======
>>>>>>> c8b1c8bf (.)
>>>>>>> 7ceb00286 (.)
=======
>>>>>>> be698cf2c (.)
=======
>>>>>>> cbb586cb0 (.)
=======
>>>>>>> 379ffe3f3 (.)
=======
>>>>>>> a55aa5e96 (.)
- [Meta WhatsApp Business API](https://developers.facebook.com/docs/whatsapp/cloud-api)
- [Laravel Notifications](https://laravel.com/docs/notifications)
- [Laravel Queues](https://laravel.com/docs/queues)
- [Laravel Testing](https://laravel.com/docs/testing)
- [Laravel Logging](https://laravel.com/docs/logging)
- [Laravel Cache](https://laravel.com/docs/cache) 

=======
>>>>>>> b207a9b1a (.)
=======
>>>>>>> 1619767d8 (.)
=======
>>>>>>> d3a8af4d5 (.)
=======
>>>>>>> 4f19d70d2 (.)
=======
>>>>>>> c22b35d1e (.)
=======
>>>>>>> 8f2456941 (.)
=======
>>>>>>> f87b41c3b (.)
=======
>>>>>>> 2f135ef98 (.)
=======
>>>>>>> 138fcd4b0 (.)
=======
>>>>>>> be45a0b8d (.)
=======
>>>>>>> db0bc148f (.)
=======
>>>>>>> 49639b815 (.)
=======
>>>>>>> 2641c2944 (.)
=======
>>>>>>> 968ed47cd (.)
=======
>>>>>>> 13655a7ed (.)
=======
>>>>>>> e0836b102 (.)
=======
>>>>>>> 903e3e2cd (.)
=======
>>>>>>> 47a873f13 (.)
=======
>>>>>>> a0788fa28 (.)
=======
>>>>>>> 69f695548 (.)
=======
>>>>>>> 5d49e093a (.)
=======
>>>>>>> 7a9167faf (.)
=======
>>>>>>> 17f6b8617 (.)
=======
>>>>>>> db6bec044 (.)
=======
>>>>>>> 2e1ac1f20 (.)
=======
>>>>>>> 6dad70a87 (.)
=======
>>>>>>> e95dfc210 (.)
=======
>>>>>>> ec24613a1 (.)
=======
>>>>>>> be698cf2c (.)
=======
>>>>>>> cbb586cb0 (.)
=======
>>>>>>> b19cd40 (.)
=======
>>>>>>> 75179b85 (.)
=======
=======
>>>>>>> b19cd40 (.)
>>>>>>> 82ae73be (.)
=======
=======
>>>>>>> b19cd40 (.)
=======
>>>>>>> 4e2ebfb (.)
>>>>>>> 207ac35e (.)
=======
>>>>>>> 9777d1b3 (.)
=======
>>>>>>> f963d2c0 (.)
=======
=======
>>>>>>> d284d65 (.)
>>>>>>> d09cb759 (.)
=======
- [Laravel Cache](https://laravel.com/docs/cache) 
>>>>>>> 75179b85 (.)
=======
=======
>>>>>>> b19cd40 (.)
>>>>>>> 82ae73be (.)
=======
=======
>>>>>>> b19cd40 (.)
=======
>>>>>>> 4e2ebfb (.)
>>>>>>> 207ac35e (.)
=======
>>>>>>> 9777d1b3 (.)
=======
- [Laravel Cache](https://laravel.com/docs/cache) 
>>>>>>> f963d2c0 (.)
=======
- [Laravel Cache](https://laravel.com/docs/cache) 
=======
>>>>>>> d284d65 (.)
>>>>>>> d09cb759 (.)
=======
- [Laravel Cache](https://laravel.com/docs/cache) 
>>>>>>> 75179b85 (.)


>>>>>>> 207ac35e (.)
=======
>>>>>>> 9777d1b3 (.)
=======
- [Laravel Cache](https://laravel.com/docs/cache) 
=======
>>>>>>> d284d65 (.)
>>>>>>> d09cb759 (.)
=======
=======
>>>>>>> b19cd40 (.)
>>>>>>> de02998b (.)
=======
=======
>>>>>>> b19cd40 (.)
=======
>>>>>>> 4e2ebfb (.)
>>>>>>> 011072e4 (.)
=======
>>>>>>> 161887a2 (.)
=======
- [Laravel Cache](https://laravel.com/docs/cache) 
>>>>>>> ee18dd92 (.)
=======
- [Laravel Cache](https://laravel.com/docs/cache) 
=======
>>>>>>> d284d65 (.)
>>>>>>> 4689a827 (.)
=======
=======
>>>>>>> b19cd40 (.)
>>>>>>> e7a9a2bf (.)

>>>>>>> 9d67cabd (.)
=======
>>>>>>> ba564870 (.)
=======
- [Laravel Cache](https://laravel.com/docs/cache) 
=======
>>>>>>> d284d65 (.)
>>>>>>> 7325acf3 (.)
=======
=======
>>>>>>> b19cd40 (.)
>>>>>>> 9cdf6146 (.)
=======
=======
>>>>>>> b19cd40 (.)
=======
>>>>>>> 4e2ebfb (.)
>>>>>>> 80f054e0 (.)
=======
>>>>>>> 7c39b1fe (.)
=======
>>>>>>> 5fd545e4 (.)
=======
=======
>>>>>>> b19cd40 (.)
>>>>>>> 3f39ac8b (.)

>>>>>>> 4d2eb53e (.)
=======
>>>>>>> 888799d0 (.)
=======
- [Laravel Cache](https://laravel.com/docs/cache) 
=======
>>>>>>> d284d65 (.)
>>>>>>> f2e64178 (.)
=======
=======
>>>>>>> b19cd40 (.)
>>>>>>> 6d08c01b (.)
=======
=======
>>>>>>> b19cd40 (.)
=======
>>>>>>> 4e2ebfb (.)
>>>>>>> 6b6b9e41 (.)
=======
>>>>>>> c6c33175 (.)
=======
- [Laravel Cache](https://laravel.com/docs/cache) 
>>>>>>> 4f042b88 (.)


=======
>>>>>>> 5fe4f466 (.)
=======
>>>>>>> 503981fd (.)
=======
- [Laravel Cache](https://laravel.com/docs/cache) 
>>>>>>> 36321fcb (.)
=======
- [Laravel Cache](https://laravel.com/docs/cache) 
=======
>>>>>>> d284d65 (.)
>>>>>>> dceba960 (.)
=======
=======
>>>>>>> b19cd40 (.)
>>>>>>> 8e5817bc (.)
=======
=======
>>>>>>> b19cd40 (.)
=======
>>>>>>> 4e2ebfb (.)
>>>>>>> e0d9c9be (.)
=======
>>>>>>> 7a2f131f (.)
=======
- [Laravel Cache](https://laravel.com/docs/cache) 
>>>>>>> 712617d3 (.)
=======
- [Laravel Cache](https://laravel.com/docs/cache) 
=======
>>>>>>> d284d65 (.)
>>>>>>> bd804d67 (.)
=======
=======
>>>>>>> b19cd40 (.)
>>>>>>> 51182e3c (rebase 210)

>>>>>>> cb85c538 (rebase 210)
=======
>>>>>>> 1c0eb9c7 (rebase 210)
>>>>>>> 229a065a (rebase 210)
=======
=======
>>>>>>> b19cd40 (.)
>>>>>>> a9bf0423 (rebase 210)
=======
=======
>>>>>>> b19cd40 (.)
=======
>>>>>>> 4e2ebfb (.)
>>>>>>> 460b8f5b (rebase 210)
=======
>>>>>>> 4d253d2c (rebase 210)
=======
=======
>>>>>>> b19cd40 (.)
>>>>>>> 9fe1b60e (rebase 210)
=======
>>>>>>> 8a8a8e2f (rebase 210)
=======
>>>>>>> efb0f8d9 (rebase 210)
=======
- [Laravel Cache](https://laravel.com/docs/cache) 
>>>>>>> 9c45d9bd (rebase 210)
=======
- [Laravel Cache](https://laravel.com/docs/cache) 
=======
>>>>>>> d284d65 (.)
>>>>>>> 9f8e680a (rebase 210)
=======
=======
>>>>>>> b19cd40 (.)
>>>>>>> b4f93b3a (rebase 210)
=======
=======
>>>>>>> b19cd40 (.)
=======
>>>>>>> 4e2ebfb (.)
>>>>>>> 1375c94d (rebase 210)
=======
>>>>>>> 52cd5f85 (rebase 210)
=======
- [Laravel Cache](https://laravel.com/docs/cache) 
>>>>>>> eb62d6cf (rebase 210)

>>>>>>> 22baa66d (rebase 210)
=======
- [Laravel Cache](https://laravel.com/docs/cache) 
>>>>>>> 36ac4fc1 (.)


=======
>>>>>>> eea68ec9 (.)
=======
>>>>>>> 59916c8f (.)
=======
- [Laravel Cache](https://laravel.com/docs/cache) 
>>>>>>> fd1fcc4c (.)
=======
- [Laravel Cache](https://laravel.com/docs/cache) 
=======
>>>>>>> d284d65 (.)
>>>>>>> e790eb33 (.)
=======
=======
>>>>>>> b19cd40 (.)
>>>>>>> f81a620f (.)

>>>>>>> 06e3078e (.)
=======
>>>>>>> 70e8274e (.)
=======
- [Laravel Cache](https://laravel.com/docs/cache) 
=======
>>>>>>> d284d65 (.)
>>>>>>> 3ee54c5d (.)
=======
- [Laravel Cache](https://laravel.com/docs/cache) 
>>>>>>> c8b1c8bf (.)
=======
=======
>>>>>>> b19cd40 (.)
>>>>>>> 2fc60436 (.)

>>>>>>> ce89c8bb (.)
=======
>>>>>>> 58816034 (.)
=======
- [Laravel Cache](https://laravel.com/docs/cache) 
>>>>>>> 75179b85 (.)
=======
=======
>>>>>>> b19cd40 (.)
>>>>>>> 82ae73be (.)
=======
=======
>>>>>>> b19cd40 (.)
=======
>>>>>>> 4e2ebfb (.)
>>>>>>> 207ac35e (.)
=======
>>>>>>> 9777d1b3 (.)
=======
- [Laravel Cache](https://laravel.com/docs/cache) 
>>>>>>> f963d2c0 (.)

=======
=======
=======
>>>>>>> b19cd40 (.)
=======
>>>>>>> 4e2ebfb (.)
>>>>>>> 011072e4 (.)
=======
>>>>>>> 161887a2 (.)
=======
- [Laravel Cache](https://laravel.com/docs/cache) 
>>>>>>> ee18dd92 (.)
=======
- [Laravel Cache](https://laravel.com/docs/cache) 
=======
>>>>>>> d284d65 (.)
>>>>>>> 4689a827 (.)
=======
=======
>>>>>>> b19cd40 (.)
>>>>>>> e7a9a2bf (.)
=======
=======
>>>>>>> b19cd40 (.)
=======
>>>>>>> 4e2ebfb (.)
>>>>>>> 9d67cabd (.)
=======
>>>>>>> ba564870 (.)
=======
- [Laravel Cache](https://laravel.com/docs/cache) 
>>>>>>> 66453ace (.)


=======
>>>>>>> 80f054e0 (.)
=======
>>>>>>> 7c39b1fe (.)
=======
>>>>>>> 5fd545e4 (.)
=======
=======
>>>>>>> b19cd40 (.)
>>>>>>> 3f39ac8b (.)
=======
=======
>>>>>>> b19cd40 (.)
=======
>>>>>>> 4e2ebfb (.)
>>>>>>> 4d2eb53e (.)
=======
>>>>>>> 888799d0 (.)
=======
- [Laravel Cache](https://laravel.com/docs/cache) 
>>>>>>> 2a97406c (.)

=======
=======
=======
>>>>>>> b19cd40 (.)
=======
>>>>>>> 4e2ebfb (.)
>>>>>>> 6b6b9e41 (.)
=======
>>>>>>> c6c33175 (.)
=======
- [Laravel Cache](https://laravel.com/docs/cache) 
>>>>>>> 4f042b88 (.)
=======
- [Laravel Cache](https://laravel.com/docs/cache) 
=======
>>>>>>> d284d65 (.)
>>>>>>> c4bdacbf (.)
=======
=======
>>>>>>> b19cd40 (.)
>>>>>>> 3b4c9907 (.)
=======
=======
>>>>>>> b19cd40 (.)
=======
>>>>>>> 4e2ebfb (.)
>>>>>>> 5fe4f466 (.)
=======
>>>>>>> 503981fd (.)

=======
=======
=======
>>>>>>> b19cd40 (.)
=======
>>>>>>> 4e2ebfb (.)
>>>>>>> e0d9c9be (.)
=======
>>>>>>> 7a2f131f (.)
=======
- [Laravel Cache](https://laravel.com/docs/cache) 
>>>>>>> 712617d3 (.)
=======
- [Laravel Cache](https://laravel.com/docs/cache) 
=======
>>>>>>> d284d65 (.)
>>>>>>> bd804d67 (.)
=======
=======
>>>>>>> b19cd40 (.)
>>>>>>> 51182e3c (rebase 210)
=======
=======
>>>>>>> b19cd40 (.)
=======
>>>>>>> 4e2ebfb (.)
>>>>>>> cb85c538 (rebase 210)
=======
>>>>>>> 1c0eb9c7 (rebase 210)
=======
- [Laravel Cache](https://laravel.com/docs/cache) 
>>>>>>> fdb24863 (rebase 210)

>>>>>>> 9fe1b60e (rebase 210)
=======
=======
>>>>>>> b19cd40 (.)
=======
>>>>>>> 4e2ebfb (.)
>>>>>>> 8a8a8e2f (rebase 210)
=======
>>>>>>> efb0f8d9 (rebase 210)
=======
- [Laravel Cache](https://laravel.com/docs/cache) 
=======
>>>>>>> d284d65 (.)
>>>>>>> 9f8e680a (rebase 210)

>>>>>>> 1375c94d (rebase 210)
=======
>>>>>>> 52cd5f85 (rebase 210)
>>>>>>> 5aedc39c (rebase 210)
=======
=======
>>>>>>> b19cd40 (.)
>>>>>>> c5c038f2 (rebase 210)
=======
=======
>>>>>>> b19cd40 (.)
=======
>>>>>>> 4e2ebfb (.)
>>>>>>> 030c9674 (rebase 210)
=======
>>>>>>> bb00ab64 (rebase 210)
=======
- [Laravel Cache](https://laravel.com/docs/cache) 
=======
>>>>>>> d284d65 (.)
>>>>>>> 22baa66d (rebase 210)
=======
- [Laravel Cache](https://laravel.com/docs/cache) 
>>>>>>> 36ac4fc1 (.)
>>>>>>> 2effe245 (.)
=======
=======
>>>>>>> b19cd40 (.)
>>>>>>> 77edd94a (.)
=======
=======
>>>>>>> b19cd40 (.)
=======
>>>>>>> 4e2ebfb (.)
>>>>>>> eea68ec9 (.)
=======
>>>>>>> 59916c8f (.)

=======
=======
=======
>>>>>>> b19cd40 (.)
=======
>>>>>>> 4e2ebfb (.)
>>>>>>> 06e3078e (.)
=======
>>>>>>> 70e8274e (.)
=======
- [Laravel Cache](https://laravel.com/docs/cache) 
>>>>>>> 4f3927d7 (.)


>>>>>>> 2fc60436 (.)
=======
=======
>>>>>>> b19cd40 (.)
=======
>>>>>>> 4e2ebfb (.)
>>>>>>> ce89c8bb (.)
=======
>>>>>>> 58816034 (.)
=======
- [Laravel Cache](https://laravel.com/docs/cache) 
>>>>>>> 9cf0dc90 (.)
=======
- [Laravel Cache](https://laravel.com/docs/cache) 
>>>>>>> 75179b85 (.)
>>>>>>> 82ae73be (.)
=======
=======
>>>>>>> b19cd40 (.)
=======
>>>>>>> 4e2ebfb (.)
>>>>>>> 207ac35e (.)
=======
>>>>>>> 9777d1b3 (.)
=======
- [Laravel Cache](https://laravel.com/docs/cache) 
>>>>>>> f963d2c0 (.)
=======
- [Laravel Cache](https://laravel.com/docs/cache) 
=======
>>>>>>> d284d65 (.)
>>>>>>> d09cb759 (.)
=======
- [Laravel Cache](https://laravel.com/docs/cache) 
>>>>>>> 75179b855 (.)
>>>>>>> 82ae73be (.)
=======
=======
>>>>>>> b19cd40 (.)
=======
>>>>>>> 4e2ebfb (.)
>>>>>>> 207ac35e (.)
=======
>>>>>>> 9777d1b3 (.)
=======
- [Laravel Cache](https://laravel.com/docs/cache) 
>>>>>>> f963d2c0 (.)
=======
- [Laravel Cache](https://laravel.com/docs/cache) 
=======
>>>>>>> d284d65 (.)
>>>>>>> d09cb759 (.)
=======
=======
>>>>>>> b19cd40 (.)
>>>>>>> de02998b (.)
=======
=======
>>>>>>> b19cd40 (.)
=======
>>>>>>> 4e2ebfb (.)
>>>>>>> 011072e4 (.)
=======
>>>>>>> 161887a2 (.)

=======
=======
=======
>>>>>>> b19cd40 (.)
=======
>>>>>>> 4e2ebfb (.)
>>>>>>> 9d67cabd (.)
=======
>>>>>>> ba564870 (.)
=======
- [Laravel Cache](https://laravel.com/docs/cache) 
>>>>>>> 66453ace (.)
=======
- [Laravel Cache](https://laravel.com/docs/cache) 
=======
>>>>>>> d284d65 (.)
>>>>>>> 7325acf3 (.)
=======
=======
>>>>>>> b19cd40 (.)
>>>>>>> 9cdf6146 (.)
=======
=======
>>>>>>> b19cd40 (.)
=======
>>>>>>> 4e2ebfb (.)
>>>>>>> 80f054e0 (.)
=======
>>>>>>> 7c39b1fe (.)
>>>>>>> 3f39ac8b (.)
=======
=======
>>>>>>> b19cd40 (.)
=======
>>>>>>> 4e2ebfb (.)
>>>>>>> 4d2eb53e (.)
=======
>>>>>>> 888799d0 (.)
=======
- [Laravel Cache](https://laravel.com/docs/cache) 
>>>>>>> 2a97406c (.)
=======
- [Laravel Cache](https://laravel.com/docs/cache) 
=======
>>>>>>> d284d65 (.)
>>>>>>> f2e64178 (.)
=======
=======
>>>>>>> b19cd40 (.)
>>>>>>> 6d08c01b (.)

>>>>>>> 6b6b9e41 (.)
=======
>>>>>>> c6c33175 (.)
=======
- [Laravel Cache](https://laravel.com/docs/cache) 
=======
>>>>>>> d284d65 (.)
>>>>>>> c4bdacbf (.)
=======
=======
>>>>>>> b19cd40 (.)
>>>>>>> 3b4c9907 (.)
=======
=======
>>>>>>> b19cd40 (.)
=======
>>>>>>> 4e2ebfb (.)
>>>>>>> 5fe4f466 (.)
=======
>>>>>>> 503981fd (.)
=======
- [Laravel Cache](https://laravel.com/docs/cache) 
>>>>>>> 36321fcb (.)
=======
- [Laravel Cache](https://laravel.com/docs/cache) 
=======
>>>>>>> d284d65 (.)
>>>>>>> dceba960 (.)
=======
=======
>>>>>>> b19cd40 (.)
>>>>>>> 8e5817bc (.)

>>>>>>> e0d9c9be (.)
=======
>>>>>>> 7a2f131f (.)

>>>>>>> laraxot/develop
=======
>>>>>>> 10292b60a (.)
=======
>>>>>>> bf5d31b0f (.)
=======
>>>>>>> 12a7e2462 (.)
=======
>>>>>>> 510809c6f (.)
=======
=======
>>>>>>> b19cd40 (.)
>>>>>>> de02998b (.)
>>>>>>> b207a9b1a (.)
=======
>>>>>>> 1619767d8 (.)
=======
>>>>>>> 4bec160e6 (.)
=======
>>>>>>> 8dc1f2ed6 (.)
=======
>>>>>>> d3a8af4d5 (.)
=======
>>>>>>> 4f19d70d2 (.)
=======
>>>>>>> 138485550 (.)
=======
>>>>>>> 2e9bd58c3 (.)
=======
>>>>>>> c22b35d1e (.)
=======
>>>>>>> 8f2456941 (.)
=======
>>>>>>> f87b41c3b (.)
=======
>>>>>>> 2f135ef98 (.)
=======
>>>>>>> 998e6866b (.)
=======
>>>>>>> 23f115647 (.)
=======
>>>>>>> 138fcd4b0 (.)
=======
>>>>>>> be45a0b8d (.)
=======
>>>>>>> 36136dcfa (.)
=======
>>>>>>> a115e2aad (.)
=======
>>>>>>> db0bc148f (.)
=======
>>>>>>> 49639b815 (.)
=======
>>>>>>> 70175d0c4 (.)
=======
>>>>>>> 9cb55171f (.)
=======
>>>>>>> 2641c2944 (.)
=======
>>>>>>> 968ed47cd (.)
=======
>>>>>>> 731b801a8 (.)
=======
>>>>>>> 848f79b79 (.)
=======
>>>>>>> 13655a7ed (.)
=======
>>>>>>> e0836b102 (.)
=======
>>>>>>> b85076e48 (.)
=======
>>>>>>> 3e757cee2 (.)
=======
>>>>>>> 903e3e2cd (.)
=======
>>>>>>> 47a873f13 (.)
=======
>>>>>>> 43dd68f4b (.)
=======
>>>>>>> a0788fa28 (.)
=======
>>>>>>> 69f695548 (.)
=======
>>>>>>> ce1853afd (.)
=======
>>>>>>> c188e2a18 (.)
=======
>>>>>>> 5d49e093a (.)
=======
>>>>>>> 7a9167faf (.)
=======
>>>>>>> 7a142b4f5 (.)
=======
>>>>>>> cd5474106 (.)
=======
>>>>>>> 17f6b8617 (.)
=======
>>>>>>> db6bec044 (.)
=======
>>>>>>> c31e900eb (.)
=======
>>>>>>> 01750b107 (.)
=======
>>>>>>> fea359347 (.)
=======
>>>>>>> 26d39e2eb (.)
=======
>>>>>>> 2e1ac1f20 (.)
=======
>>>>>>> 6dad70a87 (.)
=======
>>>>>>> d9e649ac3 (.)
=======
>>>>>>> 2dab69c8a (.)
=======
>>>>>>> e95dfc210 (.)
=======
>>>>>>> ec24613a1 (.)
=======
>>>>>>> 602b8a0a9 (.)
=======
>>>>>>> 763771402 (.)
=======
=======
- [Laravel Cache](https://laravel.com/docs/cache) 
>>>>>>> c8b1c8bf (.)
>>>>>>> 7ceb00286 (.)
=======
>>>>>>> be698cf2c (.)
=======
>>>>>>> cbb586cb0 (.)
=======
>>>>>>> 379ffe3f3 (.)
=======
- [Laravel Cache](https://laravel.com/docs/cache) 
>>>>>>> a55aa5e96 (.)
