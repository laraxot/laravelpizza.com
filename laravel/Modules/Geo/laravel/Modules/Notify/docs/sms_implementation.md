# Implementazione SMS in Laravel

## Panoramica
Questo documento descrive l'implementazione del sistema di invio SMS nel modulo Notify, utilizzando il pacchetto `gr8shivam/laravel-sms-api` come driver principale **e** il pacchetto [`spatie/laravel-queueable-action`](https://github.com/spatie/laravel-queueable-action) per la gestione delle azioni asincrone e sincrone.

## Architettura Data-Driven

Il sistema SMS utilizza classi Data di Spatie per gestire la configurazione dei provider in modo centralizzato e tipizzato:

- **SmsFactorData**: Gestisce configurazione e autenticazione per SMSFactor
- **AgiletelecomData**: Gestisce configurazione e autenticazione per Agiletelecom

Queste classi implementano il pattern singleton e forniscono metodi helper per l'autenticazione e la configurazione.

## Architettura

### 1. Driver Supportati
- **SMSFactor** (Driver principale)
- **Twilio** (Alternativa)
- **Nexmo/Vonage** (Alternativa)
- **Plivo** (Alternativa)
- **Gammu** (Per server GSM)

### 2. Configurazione
```php
// config/sms.php
return [
    'default' => env('SMS_DRIVER', 'smsfactor'),
    
    'drivers' => [
        'smsfactor' => [
            'token' => env('SMSFACTOR_TOKEN'),
            'base_url' => env('SMSFACTOR_BASE_URL', 'https://api.smsfactor.com'),
        ],
        'agiletelecom' => [
            'username' => env('AGILETELECOM_USERNAME'),
            'password' => env('AGILETELECOM_PASSWORD'),
            'sender' => env('AGILETELECOM_SENDER'),
            'endpoint' => env('AGILETELECOM_ENDPOINT'),
            'auth_type' => env('AGILETELECOM_AUTH_TYPE', 'basic'),
        ],
        'twilio' => [
            'account_sid' => env('TWILIO_ACCOUNT_SID'),
            'auth_token' => env('TWILIO_AUTH_TOKEN'),
            'from' => env('TWILIO_FROM'),
        ],
        // Altri driver...
    ]
];
```

### 3. Classi Data per Provider

#### SmsFactorData
```php
use Modules\Notify\Datas\SMS\SmsFactorData;

// Utilizzo singleton
$smsFactorData = SmsFactorData::make();

// Metodi helper
$headers = $smsFactorData->getAuthHeaders();
$baseUrl = $smsFactorData->getBaseUrl();
$timeout = $smsFactorData->getTimeout();
```

#### AgiletelecomData
```php
use Modules\Notify\Datas\SMS\AgiletelecomData;

// Utilizzo singleton
$agiletelecomData = AgiletelecomData::make();

// Metodi helper
$headers = $agiletelecomData->getAuthHeaders();
```

### 3. Struttura del Database
```sql
CREATE TABLE sms_templates (
    id bigint unsigned NOT NULL AUTO_INCREMENT,
    name varchar(255) NOT NULL,
    content text NOT NULL,
    variables json,
    created_at timestamp NULL DEFAULT NULL,
    updated_at timestamp NULL DEFAULT NULL,
    PRIMARY KEY (id)
);

CREATE TABLE sms_logs (
    id bigint unsigned NOT NULL AUTO_INCREMENT,
    template_id bigint unsigned NOT NULL,
    recipient varchar(255) NOT NULL,
    content text NOT NULL,
    status varchar(50) NOT NULL,
    error_message text,
    created_at timestamp NULL DEFAULT NULL,
    updated_at timestamp NULL DEFAULT NULL,
    PRIMARY KEY (id),
    FOREIGN KEY (template_id) REFERENCES sms_templates(id)
);
```

## Implementazione

### 1. Service Provider
```php
namespace Modules\Notify\Providers;

use Illuminate\Support\ServiceProvider;
use Gr8Shivam\SmsApi\SmsApiServiceProvider;

class NotifyServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->register(SmsApiServiceProvider::class);
    }
}
```

### 2. Notification Channel
```php
namespace Modules\Notify\Notifications\Channels;

use Illuminate\Notifications\Notification;
use Gr8Shivam\SmsApi\SmsApi;

class SmsChannel
{
    protected $sms;

    public function __construct(SmsApi $sms)
    {
        $this->sms = $sms;
    }

    public function send($notifiable, Notification $notification)
    {
        $message = $notification->toSms($notifiable);
        
        return $this->sms->send(
            $notifiable->phone_number,
            $message
        );
    }
}
```

### 3. Template System

> **Nota:** La logica di rendering dei template può essere gestita tramite una action queueable, non tramite un service custom.

Esempio di Action per invio SMS:

```php
namespace Modules\Notify\Actions;

use Spatie\QueueableAction\QueueableAction;
use Gr8Shivam\SmsApi\SmsApi;

class SendSmsAction
{
    use QueueableAction;

    public function execute(string $to, string $template, array $variables = [])
    {
        // Recupera il template dal database
        $smsTemplate = SmsTemplate::where('name', $template)->firstOrFail();
        $content = $smsTemplate->content;
        foreach ($variables as $key => $value) {
            $content = str_replace("{{$key}}", $value, $content);
        }
        // Invia SMS
        app(SmsApi::class)->send($to, $content);
        // Log, gestione errori, ecc.
    }
}
```

#### Esecuzione Sincrona
```php
app(SendSmsAction::class)->execute('+393331234567', 'welcome', ['name' => 'Mario']);
```

#### Esecuzione Asincrona (in coda)
```php
app(SendSmsAction::class)
    ->onQueue('sms')
    ->execute('+393331234567', 'welcome', ['name' => 'Mario']);
```

### 4. Queueable Actions

Per la gestione di azioni asincrone e sincrone, utilizziamo il pacchetto [`spatie/laravel-queueable-action`](https://github.com/spatie/laravel-queueable-action):

- Permette di scrivere azioni riutilizzabili, testabili e iniettate via costruttore
- Supporta esecuzione immediata o in coda (`onQueue()`)
- Supporta chaining, middleware, backoff, tagging per Horizon

#### Esempio di Action con Middleware e Tag
```php
class SendSmsAction
{
    use QueueableAction;

    public function middleware()
    {
        return [new RateLimited()];
    }

    public function tags()
    {
        return ['sms', 'notify'];
    }

    public function execute(string $to, string $template, array $variables = [])
    {
        // ... come sopra
    }
}
```

#### Testing
```php
use Spatie\QueueableAction\Testing\QueueableActionFake;
use Illuminate\Support\Facades\Queue;

Queue::fake();
app(SendSmsAction::class)->onQueue()->execute('+393331234567', 'welcome', ['name' => 'Mario']);
QueueableActionFake::assertPushed(SendSmsAction::class);
```

#### Chaining
```php
use Spatie\QueueableAction\ActionJob;

app(SendSmsAction::class)
    ->onQueue()
    ->execute($to, $template, $vars)
    ->chain([
        new ActionJob(AnotherAction::class, [$to, $template, $vars]),
    ]);
```

#### Riferimenti
- [spatie/laravel-queueable-action - GitHub](https://github.com/spatie/laravel-queueable-action)
- [Blog post: Queueable Actions](https://stitcher.io/blog/laravel-queueable-actions)

## Best Practices

- Utilizzare sempre le Actions per la business logic riutilizzabile
- Usare la coda per invii massivi o lenti
- Testare le Actions con Queue::fake e QueueableActionFake
- Gestire errori e retry tramite le features del pacchetto
- Documentare ogni Action

## Testing

### 1. Unit Tests
```php
namespace Modules\Notify\Tests\Unit;

use Tests\TestCase;
use Modules\Notify\Services\SmsService;

class SmsServiceTest extends TestCase
{
    public function test_sms_sending()
    {
        $service = new SmsService();
        $result = $service->send('+1234567890', 'Test message');
        $this->assertTrue($result);
    }
}
```

### 2. Integration Tests
```php
namespace Modules\Notify\Tests\Feature;

use Tests\TestCase;
use Modules\Notify\Models\SmsTemplate;

class SmsIntegrationTest extends TestCase
{
    public function test_template_rendering()
    {
        $template = SmsTemplate::create([
            'name' => 'Test',
            'content' => 'Hello {{name}}!'
        ]);
        
        $result = $template->render(['name' => 'John']);
        $this->assertEquals('Hello John!', $result);
    }
}
```

## Monitoraggio e Logging

### 1. Log Structure
```json
{
    "timestamp": "2024-03-20 10:00:00",
    "template_id": 1,
    "recipient": "+1234567890",
    "content": "Test message",
    "status": "sent",
    "provider": "smsfactor",
    "response": {
        "message_id": "123456",
        "status": "success"
    }
}
```

### 2. Metrics
- Tasso di consegna
- Tempo di consegna
- Errori per provider
- Costi per provider

## Deployment

### 1. Requisiti
- PHP 8.1+
- Laravel 10+
- Estensione cURL
- Configurazione SSL

### 2. Variabili d'Ambiente
```env
SMS_DRIVER=smsfactor
SMSFACTOR_API_KEY=your_api_key
SMSFACTOR_SENDER=YourApp
```

## Manutenzione

### 1. Backup
- Backup giornaliero dei template
- Backup dei log
- Backup delle configurazioni

### 2. Aggiornamenti
- Monitoraggio delle versioni
- Test di compatibilità
- Piano di rollback

## Troubleshooting

### 1. Errori Comuni
- Invalid phone number
- API rate limit
- Network issues
- Template rendering errors

### 2. Soluzioni
- Validazione numeri
- Implementazione retry
- Timeout handling
- Error logging

## Riferimenti
- [spatie/laravel-queueable-action](https://github.com/spatie/laravel-queueable-action)
- [Documentazione SMSFactor](https://www.smsfactor.com)
- [Documentazione Twilio](https://www.twilio.com/docs)
- [Documentazione Nexmo](https://developer.nexmo.com)
- [Documentazione Plivo](https://www.plivo.com/docs) 
