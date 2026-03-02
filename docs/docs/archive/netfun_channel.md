# Implementazione Canale Netfun

## 1. Struttura Base

### 1.1 Data Transfer Objects
```php
<?php

namespace Modules\Notify\Datas;

use Spatie\LaravelData\Data;

class NetfunSmsRequestData extends Data
{
    public function __construct(
        public string $to,
        public string $text,
        public string $from
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            to: $data['to'],
            text: $data['text'],
            from: $data['from']
        );
    }
}

class NetfunSmsResponseData extends Data
{
    public function __construct(
        public string $status,
        public ?string $message_id = null,
        public ?string $error = null
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            status: $data['status'],
            message_id: $data['message_id'] ?? null,
            error: $data['error'] ?? null
        );
    }
}

class NetfunSMSMessage extends Data
{
    public function __construct(
        public string $to,
        public string $text,
        public string $from,
        public ?string $reference = null,
        public ?string $scheduled_date = null
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            to: $data['to'],
            text: $data['text'],
            from: $data['from'],
            reference: $data['reference'] ?? null,
            scheduled_date: $data['scheduled_date'] ?? null
        );
    }
}
```

### 1.2 Canale Netfun
```php
<?php

namespace Modules\Notify\Notifications\Channels;

use Illuminate\Notifications\Notification;
use Modules\Notify\Actions\SendNetfunSmsAction;
use Illuminate\Support\Facades\Log;

class NetfunChannel
{
    /**
     * Invia la notifica tramite Netfun
     *
     * @param mixed $notifiable
     * @param \Illuminate\Notifications\Notification $notification
     * @return void
     * @throws \Exception
     */
    public function send($notifiable, Notification $notification)
    {
        try {
            $message = $notification->toNetfun($notifiable);
            
            // Validazione base
            if (empty($notifiable->phone_number)) {
                throw new \Exception('Numero di telefono mancante per il destinatario');
            }

            if (empty($message->content)) {
                throw new \Exception('Contenuto del messaggio mancante');
            }

            // Verifica formato numero
            if (!$this->isValidPhoneNumber($notifiable->phone_number)) {
                throw new \Exception('Formato numero di telefono non valido');
            }

            // Verifica lunghezza messaggio
            if (strlen($message->content) > 160) {
                throw new \Exception('Messaggio troppo lungo (max 160 caratteri)');
            }

            // Verifica sender
            $sender = $message->sender ?? config('notify.from.number');
            if (strlen($sender) > 11) {
                throw new \Exception('Sender troppo lungo (max 11 caratteri)');
            }

            SendNetfunSmsAction::make(
                to: $notifiable->phone_number,
                message: $message->content,
                sender: $sender
            )->onQueue('sms')->execute();

        } catch (\Exception $e) {
            Log::error('Errore invio SMS Netfun', [
                'error' => $e->getMessage(),
                'notifiable' => get_class($notifiable),
                'notification' => get_class($notification)
            ]);
            throw $e;
        }
    }

    /**
     * Verifica se il numero di telefono è valido
     *
     * @param string $phoneNumber
     * @return bool
     */
    protected function isValidPhoneNumber(string $phoneNumber): bool
    {
        // Formato italiano: +39XXXXXXXXXX
        return preg_match('/^\+39\d{10}$/', $phoneNumber) === 1;
    }
}
```

### 1.3 Action Queueable
```php
<?php

namespace Modules\Notify\Actions;

use Spatie\QueueableAction\QueueableAction;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Cache;
use Modules\Notify\Datas\NetfunSmsRequestData;
use Modules\Notify\Datas\NetfunSmsResponseData;

class SendNetfunSmsAction
{
    use QueueableAction;

    /**
     * @var string
     */
    protected string $to;

    /**
     * @var string
     */
    protected string $message;

    /**
     * @var string
     */
    protected string $sender;

    public function __construct(
        string $to,
        string $message,
        string $sender
    ) {
        $this->to = $to;
        $this->message = $message;
        $this->sender = $sender;
    }

    /**
     * Esegue l'azione di invio SMS
     *
     * @return NetfunSmsResponseData
     * @throws \Exception
     */
    public function execute(): NetfunSmsResponseData
    {
        // Verifica rate limiting
        $this->checkRateLimit();

        try {
            $requestData = new NetfunSmsRequestData(
                to: $this->to,
                text: $this->message,
                from: $this->sender
            );

            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . config('notify.drivers.netfun.token'),
                'Content-Type' => 'application/json',
                'Accept' => 'application/json'
            ])->timeout(config('notify.timeout'))->post(config('notify.drivers.netfun.endpoint'), [
                'messages' => [$requestData->toArray()]
            ]);

            if (!$response->successful()) {
                $this->handleError($response);
            }

            $result = $response->json();
            
            // Verifica lo stato della risposta
            if ($result['status'] !== 'success') {
                $this->handleError($response, $result);
            }

            // Registra il successo
            $this->logSuccess($result);

            return NetfunSmsResponseData::fromArray($result);

        } catch (\Exception $e) {
            $this->handleException($e);
        }
    }

    /**
     * Verifica il rate limiting
     *
     * @throws \Exception
     */
    protected function checkRateLimit(): void
    {
        if (!config('notify.rate_limit.enabled')) {
            return;
        }

        $key = 'netfun_rate_limit_' . date('YmdHis');
        $count = Cache::get($key, 0);

        if ($count >= config('notify.rate_limit.limit')) {
            throw new \Exception('Rate limit exceeded');
        }

        Cache::put($key, $count + 1, config('notify.rate_limit.window'));
    }

    /**
     * Gestisce gli errori della risposta
     *
     * @param \Illuminate\Http\Client\Response $response
     * @param array|null $result
     * @throws \Exception
     */
    protected function handleError($response, ?array $result = null): void
    {
        $error = $result['error'] ?? $response->body();
        $status = $result['status'] ?? 'error';

        Log::error('Errore invio SMS Netfun', [
            'status' => $status,
            'error' => $error,
            'to' => $this->to,
            'response' => $response->json()
        ]);

        throw new \Exception("Errore invio SMS: {$error}");
    }

    /**
     * Gestisce le eccezioni
     *
     * @param \Exception $e
     * @throws \Exception
     */
    protected function handleException(\Exception $e): void
    {
        Log::error('Eccezione invio SMS Netfun', [
            'error' => $e->getMessage(),
            'to' => $this->to,
            'message' => $this->message,
            'trace' => $e->getTraceAsString()
        ]);

        throw $e;
    }

    /**
     * Registra il successo dell'invio
     *
     * @param array $result
     */
    protected function logSuccess(array $result): void
    {
        Log::info('SMS inviato con successo', [
            'to' => $this->to,
            'message' => $this->message,
            'sender' => $this->sender,
            'message_id' => $result['message_id'] ?? null,
            'status' => $result['status'] ?? null
        ]);
    }
}
```

## 2. Configurazione

### 2.1 Config File
```php
<?php
// config/notify.php

return [
    'drivers' => [
        'netfun' => [
            'token' => env('NETFUN_TOKEN'),
            'endpoint' => env('NETFUN_ENDPOINT', 'https://v2.smsviainternet.it/api/rest/v1/sms-batch.json'),
        ],
    ],

    'from' => [
        'name' => env('SMS_FROM_NAME'),
        'number' => env('SMS_FROM_NUMBER'),
    ],

    'debug' => env('SMS_DEBUG', false),

    'retry' => [
        'attempts' => env('SMS_RETRY_ATTEMPTS', 3),
        'delay' => env('SMS_RETRY_DELAY', 60),
        'max_retries' => env('SMS_MAX_RETRIES', 3),
        'retry_delay' => env('SMS_RETRY_DELAY', 1),
    ],

    'rate_limit' => [
        'enabled' => env('SMS_RATE_LIMIT_ENABLED', true),
        'max_attempts' => env('SMS_RATE_LIMIT_MAX_ATTEMPTS', 60),
        'decay_minutes' => env('SMS_RATE_LIMIT_DECAY_MINUTES', 1),
        'limit' => env('SMS_RATE_LIMIT', 100),
        'window' => env('SMS_RATE_LIMIT_WINDOW', 60),
    ],

    'circuit_breaker' => [
        'enabled' => env('SMS_CIRCUIT_BREAKER_ENABLED', true),
        'threshold' => env('SMS_CIRCUIT_BREAKER_THRESHOLD', 5),
        'timeout' => env('SMS_CIRCUIT_BREAKER_TIMEOUT', 60),
    ],

    'timeout' => env('SMS_TIMEOUT', 30),
];
```

### 2.2 Environment Variables
```env

# Netfun specific
NETFUN_TOKEN=your_token_here
NETFUN_ENDPOINT=https://v2.smsviainternet.it/api/rest/v1/sms-batch.json

# Global SMS configuration
SMS_FROM_NAME=<nome progetto>
SMS_FROM_NAME=SaluteOra
SMS_FROM_NUMBER=+393331234567
SMS_DEBUG=false

# Retry configuration
SMS_RETRY_ATTEMPTS=3
SMS_RETRY_DELAY=60
SMS_MAX_RETRIES=3

# Rate limiting
SMS_RATE_LIMIT_ENABLED=true
SMS_RATE_LIMIT_MAX_ATTEMPTS=60
SMS_RATE_LIMIT_DECAY_MINUTES=1
SMS_RATE_LIMIT=100
SMS_RATE_LIMIT_WINDOW=60

# Circuit breaker
SMS_CIRCUIT_BREAKER_ENABLED=true
SMS_CIRCUIT_BREAKER_THRESHOLD=5
SMS_CIRCUIT_BREAKER_TIMEOUT=60

# Timeout
SMS_TIMEOUT=30
```

## 3. Utilizzo

### 3.1 Nel Model
```php
<?php

namespace Modules\Patient\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    use Notifiable;

    /**
     * Route notifications for the Netfun channel.
     *
     * @return string
     */
    public function routeNotificationForNetfun(): string
    {
        return $this->phone_number;
    }

    /**
     * Verifica se l'utente può ricevere SMS
     *
     * @return bool
     */
    public function canReceiveSms(): bool
    {
        return !empty($this->phone_number) && $this->consent_sms;
    }
}
```

### 3.2 Invio Notifica
```php
// Direttamente
$user->notify(new NetfunSmsNotification('Il tuo codice OTP è: 123456'));

// Con Action
SendNetfunSmsAction::make(
    to: $user->phone_number,
    message: 'Il tuo codice OTP è: 123456',
    sender: config('notify.from.number')
)->onQueue('sms')->execute();

// Con validazione
if ($user->canReceiveSms()) {
    $user->notify(new NetfunSmsNotification('Il tuo codice OTP è: 123456'));
}
```

## 4. Best Practices

### 4.1 Validazione
- Validare sempre il numero di telefono (formato italiano: +39XXXXXXXXXX)
- Verificare la lunghezza del messaggio (max 160 caratteri)
- Controllare il formato del sender (max 11 caratteri)
- Verificare il credito disponibile prima dell'invio
- Validare il consenso dell'utente per ricevere SMS
- Verificare il formato del messaggio (caratteri supportati)

### 4.2 Gestione Errori
- Usare try/catch per gestire le eccezioni
- Loggare gli errori con dettagli
- Implementare retry per fallimenti temporanei
- Gestire i codici di errore specifici di Netfun
- Implementare circuit breaker per errori persistenti
- Monitorare il tasso di errore

### 4.3 Performance
- Utilizzare le code per l'invio
- Implementare rate limiting (max 100 SMS/secondo)
- Monitorare l'uso dell'API
- Gestire il batch di invii per ottimizzare le performance
- Implementare caching per le configurazioni
- Ottimizzare le query al database

### 4.4 Sicurezza
- Validare l'input degli utenti
- Sanitizzare i messaggi
- Proteggere le chiavi API
- Implementare logging sicuro
- Gestire i timeout
- Implementare rate limiting per IP

## 5. Testing

### 5.1 Unit Test
```php
<?php

namespace Modules\Notify\Tests\Unit;

use Tests\TestCase;
use Modules\Notify\Actions\SendNetfunSmsAction;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;

class NetfunSmsTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        Cache::flush();
    }

    public function test_sms_sent_successfully()
    {
        Http::fake([
            config('notify.drivers.netfun.endpoint') => Http::response([
                'status' => 'success',
                'message_id' => '123456'
            ], 200)
        ]);

        $action = SendNetfunSmsAction::make(
            to: '+393331234567',
            message: 'Test message',
            sender: config('notify.from.number')
        );

        $result = $action->execute();

        $this->assertEquals('success', $result->status);
        $this->assertEquals('123456', $result->message_id);
        
        Http::assertSent(function ($request) {
            return $request->url() == config('notify.drivers.netfun.endpoint') &&
                   $request['messages'][0]['to'] == '+393331234567' &&
                   $request['messages'][0]['text'] == 'Test message' &&
                   $request['messages'][0]['from'] == config('notify.from.number');
        });
    }

    public function test_sms_fails_with_invalid_number()
    {
        Http::fake([
            config('notify.drivers.netfun.endpoint') => Http::response([
                'status' => 'error',
                'error' => 'Invalid phone number'
            ], 400)
        ]);

        $this->expectException(\Exception::class);

        $action = SendNetfunSmsAction::make(
            to: 'invalid',
            message: 'Test message',
            sender: config('notify.from.number')
        );

        $action->execute();
    }

    public function test_rate_limiting()
    {
        $action = SendNetfunSmsAction::make(
            to: '+393331234567',
            message: 'Test message',
            sender: config('notify.from.number')
        );

        // Simula il raggiungimento del rate limit
        Cache::put('netfun_rate_limit_' . date('YmdHis'), 100, 60);

        $this->expectException(\Exception::class);
        $this->expectExceptionMessage('Rate limit exceeded');

        $action->execute();
    }
}
```

### 5.2 Feature Test
```php
<?php

namespace Modules\Notify\Tests\Feature;

use Tests\TestCase;
use Modules\Patient\Models\User;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Queue;

class NetfunNotificationTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        Queue::fake();
    }

    public function test_user_can_receive_sms()
    {
        Http::fake([
            config('notify.drivers.netfun.endpoint') => Http::response([
                'status' => 'success',
                'message_id' => '123456'
            ], 200)
        ]);

        $user = User::factory()->create([
            'phone_number' => '+393331234567',
            'consent_sms' => true
        ]);

        $user->notify(new NetfunSmsNotification('Test message'));

        Http::assertSent(function ($request) {
            return $request->url() == config('notify.drivers.netfun.endpoint') &&
                   $request['messages'][0]['to'] == '+393331234567';
        });

        Queue::assertPushed(SendNetfunSmsAction::class);
    }

    public function test_user_cannot_receive_sms_without_consent()
    {
        $user = User::factory()->create([
            'phone_number' => '+393331234567',
            'consent_sms' => false
        ]);

        $user->notify(new NetfunSmsNotification('Test message'));

        Http::assertNothingSent();
        Queue::assertNothingPushed();
    }
}
```

## 6. Monitoraggio

### 6.1 Logging
```php
Log::info('SMS inviato', [
    'to' => $this->to,
    'message' => $this->message,
    'sender' => $this->sender,
    'response' => $response->json(),
    'message_id' => $response->json()['message_id'] ?? null,
    'timestamp' => now()->toIso8601String(),
    'duration' => microtime(true) - LARAVEL_START
]);
```

### 6.2 Metriche
- Numero di SMS inviati
- Tasso di successo
- Tempo di risposta
- Errori per tipo
- Credito residuo
- Costi per SMS
- Rate limit usage
- Retry attempts
- Queue length
- Processing time

### 6.3 Alerting
- Errori persistenti
- Rate limit raggiunto
- Credito basso
- Tempo di risposta alto
- Queue congestionata
- Tasso di errore alto

## 7. Collegamenti Utili

- [Documentazione Netfun](https://www.netfunitalia.it/)
- [API Netfun](https://v2.smsviainternet.it/api/rest/v1/)
- [Spatie Queueable Action](https://github.com/spatie/laravel-queueable-action)
- [Spatie Laravel Data](https://github.com/spatie/laravel-data)
- [Laravel Notifications](https://laravel.com/project_docs/notifications)
- [Laravel Queues](https://laravel.com/project_docs/queues)
- [Laravel Testing](https://laravel.com/project_docs/testing)
- [Laravel Logging](https://laravel.com/project_docs/logging)
- [Laravel Cache](https://laravel.com/project_docs/cache) 
- [Laravel Notifications](https://laravel.com/docs/notifications)
- [Laravel Queues](https://laravel.com/docs/queues)
- [Laravel Testing](https://laravel.com/docs/testing)
- [Laravel Logging](https://laravel.com/docs/logging)
- [Laravel Cache](https://laravel.com/docs/cache) 
- [Laravel Cache](https://laravel.com/docs/cache) 
