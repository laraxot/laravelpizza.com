<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
=======
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
=======
>>>>>>> 2a97406c (.)
=======
>>>>>>> 4f042b88 (.)
<<<<<<< HEAD
<<<<<<< HEAD
=======
>>>>>>> 712617d3 (.)
=======
>>>>>>> fdb24863 (rebase 210)
<<<<<<< HEAD
<<<<<<< HEAD
=======
>>>>>>> 4fc21b78 (rebase 210)
=======
>>>>>>> 9c45d9bd (rebase 210)
=======
>>>>>>> eb62d6cf (rebase 210)
=======
>>>>>>> 8c8937e7 (rebase 210)
=======
>>>>>>> 36ac4fc1 (.)
<<<<<<< HEAD
<<<<<<< HEAD
=======
>>>>>>> fd1fcc4c (.)
=======
>>>>>>> c8b1c8bf (.)
<<<<<<< HEAD
<<<<<<< HEAD
=======
>>>>>>> 9cf0dc90 (.)
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
>>>>>>> 712617d3 (.)
=======
>>>>>>> fdb24863 (rebase 210)
=======
>>>>>>> 4fc21b78 (rebase 210)
=======
>>>>>>> 9c45d9bd (rebase 210)
<<<<<<< HEAD
<<<<<<< HEAD
=======
>>>>>>> eb62d6cf (rebase 210)
=======
>>>>>>> 8c8937e7 (rebase 210)
<<<<<<< HEAD
=======
>>>>>>> 36ac4fc1 (.)
=======
>>>>>>> fd1fcc4c (.)
=======
>>>>>>> c8b1c8bf (.)
=======
>>>>>>> 9cf0dc90 (.)
=======
>>>>>>> 75179b85 (.)
=======
>>>>>>> f963d2c0 (.)
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
>>>>>>> 712617d3 (.)
>>>>>>> laraxot/develop
=======
>>>>>>> 2a97406c (.)
>>>>>>> 998e6866b (.)
=======
>>>>>>> 36136dcfa (.)
=======
=======
>>>>>>> 712617d3 (.)
>>>>>>> 731b801a8 (.)
=======
>>>>>>> b85076e48 (.)
=======
=======
>>>>>>> 4fc21b78 (rebase 210)
>>>>>>> 43dd68f4b (.)
=======
>>>>>>> ce1853afd (.)
=======
=======
>>>>>>> eb62d6cf (rebase 210)
>>>>>>> 7a142b4f5 (.)
=======
>>>>>>> c31e900eb (.)
=======
>>>>>>> fea359347 (.)
=======
=======
>>>>>>> fd1fcc4c (.)
>>>>>>> d9e649ac3 (.)
=======
>>>>>>> 7ceb00286 (.)
=======
=======
>>>>>>> 9cf0dc90 (.)
>>>>>>> 379ffe3f3 (.)
=======
>>>>>>> a55aa5e96 (.)
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
<<<<<<< HEAD
<<<<<<< HEAD
SMS_FROM_NAME=<nome progetto>
SMS_FROM_NAME=<nome progetto>
=======
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
SMS_FROM_NAME=<nome progetto>
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
=======
>>>>>>> 01af324fe (.)
=======
>>>>>>> 53eef8d8d (.)
=======
>>>>>>> 13aa25113 (.)
=======
>>>>>>> 7aae79847 (.)
=======
>>>>>>> 74eb2e964 (.)
=======
>>>>>>> 0a5473e16 (.)
=======
>>>>>>> 1c96b91fe (.)
=======
>>>>>>> ad905ce9c (.)
=======
>>>>>>> c7d5eaf96 (.)
=======
>>>>>>> a2f3c239e (.)
SMS_FROM_NAME=<nome progetto>
=======
=======
=======
>>>>>>> b19cd40 (.)
<<<<<<< HEAD
>>>>>>> 82ae73be (.)
=======
=======
SMS_FROM_NAME=<nome progetto>
>>>>>>> 4e2ebfb (.)
>>>>>>> 207ac35e (.)
=======
>>>>>>> 9777d1b3 (.)
=======
=======
>>>>>>> d284d65 (.)
>>>>>>> d09cb759 (.)
=======
=======
>>>>>>> b19cd40 (.)
>>>>>>> de02998b (.)
=======
SMS_FROM_NAME=<nome progetto>
=======
>>>>>>> b19cd40 (.)
>>>>>>> de02998b (.)
<<<<<<< HEAD
<<<<<<< HEAD
=======
>>>>>>> 1619767d8 (.)
=======
SMS_FROM_NAME=<nome progetto>
=======
>>>>>>> b19cd40 (.)
=======
SMS_FROM_NAME=<nome progetto>
>>>>>>> 4e2ebfb (.)
>>>>>>> 011072e4 (.)
<<<<<<< HEAD
=======
SMS_FROM_NAME=<nome progetto>
>>>>>>> 161887a2 (.)
=======
SMS_FROM_NAME=<nome progetto>
=======
>>>>>>> b19cd40 (.)
>>>>>>> e7a9a2bf (.)
<<<<<<< HEAD
<<<<<<< HEAD
=======
>>>>>>> 4f19d70d2 (.)
=======
SMS_FROM_NAME=<nome progetto>
=======
>>>>>>> b19cd40 (.)
=======
SMS_FROM_NAME=<nome progetto>
>>>>>>> 4e2ebfb (.)
>>>>>>> 9d67cabd (.)
<<<<<<< HEAD
=======
SMS_FROM_NAME=<nome progetto>
>>>>>>> ba564870 (.)
=======
SMS_FROM_NAME=<nome progetto>
=======
>>>>>>> b19cd40 (.)
>>>>>>> 9cdf6146 (.)
<<<<<<< HEAD
<<<<<<< HEAD
=======
>>>>>>> 8f2456941 (.)
=======
SMS_FROM_NAME=<nome progetto>
=======
>>>>>>> b19cd40 (.)
=======
SMS_FROM_NAME=<nome progetto>
>>>>>>> 4e2ebfb (.)
>>>>>>> 80f054e0 (.)
<<<<<<< HEAD
=======
SMS_FROM_NAME=<nome progetto>
>>>>>>> 7c39b1fe (.)
=======
SMS_FROM_NAME=<nome progetto>
=======
>>>>>>> b19cd40 (.)
>>>>>>> 3f39ac8b (.)
=======
SMS_FROM_NAME=<nome progetto>
=======
>>>>>>> b19cd40 (.)
=======
SMS_FROM_NAME=<nome progetto>
>>>>>>> 4e2ebfb (.)
>>>>>>> 4d2eb53e (.)
=======
SMS_FROM_NAME=<nome progetto>
>>>>>>> 888799d0 (.)
=======
SMS_FROM_NAME=<nome progetto>
=======
>>>>>>> b19cd40 (.)
>>>>>>> 6d08c01b (.)
=======
SMS_FROM_NAME=<nome progetto>
=======
>>>>>>> b19cd40 (.)
=======
SMS_FROM_NAME=<nome progetto>
>>>>>>> 4e2ebfb (.)
>>>>>>> 6b6b9e41 (.)
<<<<<<< HEAD
=======
SMS_FROM_NAME=<nome progetto>
>>>>>>> c6c33175 (.)
=======
SMS_FROM_NAME=<nome progetto>
=======
>>>>>>> b19cd40 (.)
>>>>>>> 8e5817bc (.)
<<<<<<< HEAD
<<<<<<< HEAD
=======
>>>>>>> 968ed47cd (.)
=======
SMS_FROM_NAME=<nome progetto>
=======
>>>>>>> b19cd40 (.)
=======
SMS_FROM_NAME=<nome progetto>
>>>>>>> 4e2ebfb (.)
>>>>>>> e0d9c9be (.)
<<<<<<< HEAD
=======
SMS_FROM_NAME=<nome progetto>
>>>>>>> 7a2f131f (.)
=======
SMS_FROM_NAME=<nome progetto>
=======
>>>>>>> b19cd40 (.)
>>>>>>> 51182e3c (rebase 210)
=======
SMS_FROM_NAME=<nome progetto>
=======
>>>>>>> b19cd40 (.)
=======
SMS_FROM_NAME=<nome progetto>
>>>>>>> 4e2ebfb (.)
>>>>>>> cb85c538 (rebase 210)
=======
SMS_FROM_NAME=<nome progetto>
>>>>>>> 1c0eb9c7 (rebase 210)
=======
SMS_FROM_NAME=<nome progetto>
=======
>>>>>>> b19cd40 (.)
>>>>>>> a9bf0423 (rebase 210)
=======
SMS_FROM_NAME=<nome progetto>
=======
>>>>>>> b19cd40 (.)
=======
SMS_FROM_NAME=<nome progetto>
>>>>>>> 4e2ebfb (.)
>>>>>>> 460b8f5b (rebase 210)
=======
SMS_FROM_NAME=<nome progetto>
>>>>>>> 4d253d2c (rebase 210)
=======
SMS_FROM_NAME=<nome progetto>
=======
>>>>>>> b19cd40 (.)
>>>>>>> b4f93b3a (rebase 210)
<<<<<<< HEAD
<<<<<<< HEAD
=======
>>>>>>> 7a9167faf (.)
=======
SMS_FROM_NAME=<nome progetto>
=======
>>>>>>> b19cd40 (.)
=======
SMS_FROM_NAME=<nome progetto>
>>>>>>> 4e2ebfb (.)
>>>>>>> 1375c94d (rebase 210)
<<<<<<< HEAD
=======
SMS_FROM_NAME=<nome progetto>
>>>>>>> 52cd5f85 (rebase 210)
=======
SMS_FROM_NAME=<nome progetto>
=======
>>>>>>> b19cd40 (.)
>>>>>>> c5c038f2 (rebase 210)
=======
SMS_FROM_NAME=<nome progetto>
=======
>>>>>>> b19cd40 (.)
=======
SMS_FROM_NAME=<nome progetto>
>>>>>>> 4e2ebfb (.)
>>>>>>> 030c9674 (rebase 210)
=======
SMS_FROM_NAME=<nome progetto>
>>>>>>> bb00ab64 (rebase 210)
=======
SMS_FROM_NAME=<nome progetto>
=======
>>>>>>> b19cd40 (.)
>>>>>>> 77edd94a (.)
=======
SMS_FROM_NAME=<nome progetto>
=======
>>>>>>> b19cd40 (.)
=======
SMS_FROM_NAME=<nome progetto>
>>>>>>> 4e2ebfb (.)
>>>>>>> eea68ec9 (.)
=======
SMS_FROM_NAME=<nome progetto>
>>>>>>> 59916c8f (.)
=======
SMS_FROM_NAME=<nome progetto>
=======
>>>>>>> b19cd40 (.)
>>>>>>> 9cdf6146 (.)
=======
SMS_FROM_NAME=<nome progetto>
=======
>>>>>>> b19cd40 (.)
=======
SMS_FROM_NAME=<nome progetto>
>>>>>>> 4e2ebfb (.)
>>>>>>> 80f054e0 (.)
=======
SMS_FROM_NAME=<nome progetto>
>>>>>>> 7c39b1fe (.)
=======
SMS_FROM_NAME=<nome progetto>
=======
>>>>>>> b19cd40 (.)
>>>>>>> 3f39ac8b (.)
<<<<<<< HEAD
<<<<<<< HEAD
=======
>>>>>>> 2f135ef98 (.)
=======
SMS_FROM_NAME=<nome progetto>
=======
>>>>>>> b19cd40 (.)
=======
SMS_FROM_NAME=<nome progetto>
>>>>>>> 4e2ebfb (.)
>>>>>>> 4d2eb53e (.)
<<<<<<< HEAD
=======
SMS_FROM_NAME=<nome progetto>
>>>>>>> 888799d0 (.)
=======
SMS_FROM_NAME=<nome progetto>
=======
>>>>>>> b19cd40 (.)
>>>>>>> 6d08c01b (.)
<<<<<<< HEAD
=======
SMS_FROM_NAME=<nome progetto>
=======
>>>>>>> b19cd40 (.)
=======
SMS_FROM_NAME=<nome progetto>
>>>>>>> 4e2ebfb (.)
>>>>>>> 6b6b9e41 (.)
=======
SMS_FROM_NAME=<nome progetto>
>>>>>>> c6c33175 (.)
=======
SMS_FROM_NAME=<nome progetto>
=======
>>>>>>> b19cd40 (.)
>>>>>>> 8e5817bc (.)
=======
SMS_FROM_NAME=<nome progetto>
=======
>>>>>>> b19cd40 (.)
=======
SMS_FROM_NAME=<nome progetto>
>>>>>>> 4e2ebfb (.)
>>>>>>> e0d9c9be (.)
=======
SMS_FROM_NAME=<nome progetto>
>>>>>>> 7a2f131f (.)
=======
SMS_FROM_NAME=<nome progetto>
=======
>>>>>>> b19cd40 (.)
>>>>>>> 51182e3c (rebase 210)
<<<<<<< HEAD
=======
SMS_FROM_NAME=<nome progetto>
=======
>>>>>>> b19cd40 (.)
=======
SMS_FROM_NAME=<nome progetto>
>>>>>>> 4e2ebfb (.)
>>>>>>> cb85c538 (rebase 210)
=======
SMS_FROM_NAME=<nome progetto>
>>>>>>> 1c0eb9c7 (rebase 210)
=======
SMS_FROM_NAME=<nome progetto>
=======
>>>>>>> b19cd40 (.)
>>>>>>> a9bf0423 (rebase 210)
=======
SMS_FROM_NAME=<nome progetto>
=======
>>>>>>> b19cd40 (.)
=======
SMS_FROM_NAME=<nome progetto>
>>>>>>> 4e2ebfb (.)
>>>>>>> 460b8f5b (rebase 210)
=======
SMS_FROM_NAME=<nome progetto>
>>>>>>> 4d253d2c (rebase 210)
=======
SMS_FROM_NAME=<nome progetto>
=======
>>>>>>> b19cd40 (.)
>>>>>>> b4f93b3a (rebase 210)
=======
SMS_FROM_NAME=<nome progetto>
=======
>>>>>>> b19cd40 (.)
=======
SMS_FROM_NAME=<nome progetto>
>>>>>>> 4e2ebfb (.)
>>>>>>> 1375c94d (rebase 210)
=======
SMS_FROM_NAME=<nome progetto>
>>>>>>> 52cd5f85 (rebase 210)
=======
SMS_FROM_NAME=<nome progetto>
=======
>>>>>>> b19cd40 (.)
>>>>>>> c5c038f2 (rebase 210)
<<<<<<< HEAD
<<<<<<< HEAD
=======
>>>>>>> db6bec044 (.)
=======
SMS_FROM_NAME=<nome progetto>
=======
>>>>>>> b19cd40 (.)
=======
SMS_FROM_NAME=<nome progetto>
>>>>>>> 4e2ebfb (.)
>>>>>>> 030c9674 (rebase 210)
<<<<<<< HEAD
=======
SMS_FROM_NAME=<nome progetto>
>>>>>>> bb00ab64 (rebase 210)
=======
SMS_FROM_NAME=<nome progetto>
=======
>>>>>>> b19cd40 (.)
>>>>>>> 77edd94a (.)
<<<<<<< HEAD
<<<<<<< HEAD
=======
>>>>>>> 6dad70a87 (.)
=======
SMS_FROM_NAME=<nome progetto>
=======
>>>>>>> b19cd40 (.)
=======
SMS_FROM_NAME=<nome progetto>
>>>>>>> 4e2ebfb (.)
>>>>>>> eea68ec9 (.)
<<<<<<< HEAD
=======
SMS_FROM_NAME=<nome progetto>
>>>>>>> 59916c8f (.)
=======
SMS_FROM_NAME=<nome progetto>
=======
>>>>>>> b19cd40 (.)
>>>>>>> 6d08c01b (.)
=======
SMS_FROM_NAME=<nome progetto>
=======
>>>>>>> b19cd40 (.)
=======
SMS_FROM_NAME=<nome progetto>
>>>>>>> 4e2ebfb (.)
>>>>>>> 6b6b9e41 (.)
=======
SMS_FROM_NAME=<nome progetto>
>>>>>>> c6c33175 (.)
=======
SMS_FROM_NAME=<nome progetto>
=======
>>>>>>> b19cd40 (.)
>>>>>>> 8e5817bc (.)
=======
SMS_FROM_NAME=<nome progetto>
=======
>>>>>>> b19cd40 (.)
=======
SMS_FROM_NAME=<nome progetto>
>>>>>>> 4e2ebfb (.)
>>>>>>> e0d9c9be (.)
=======
SMS_FROM_NAME=<nome progetto>
>>>>>>> 7a2f131f (.)
=======
>>>>>>> b207a9b1a (.)
=======
<<<<<<< HEAD
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
>>>>>>> 2641c2944 (.)
=======
>>>>>>> 968ed47cd (.)
=======
>>>>>>> 13655a7ed (.)
=======
>>>>>>> b19cd40 (.)
>>>>>>> 51182e3c (rebase 210)
=======
SMS_FROM_NAME=<nome progetto>
=======
>>>>>>> b19cd40 (.)
=======
SMS_FROM_NAME=<nome progetto>
>>>>>>> 4e2ebfb (.)
>>>>>>> cb85c538 (rebase 210)
<<<<<<< HEAD
>>>>>>> e0836b102 (.)
=======
=======
SMS_FROM_NAME=<nome progetto>
>>>>>>> 1c0eb9c7 (rebase 210)
=======
SMS_FROM_NAME=<nome progetto>
=======
>>>>>>> b19cd40 (.)
>>>>>>> a9bf0423 (rebase 210)
<<<<<<< HEAD
>>>>>>> 903e3e2cd (.)
=======
=======
SMS_FROM_NAME=<nome progetto>
=======
>>>>>>> b19cd40 (.)
=======
SMS_FROM_NAME=<nome progetto>
>>>>>>> 4e2ebfb (.)
>>>>>>> 460b8f5b (rebase 210)
>>>>>>> 47a873f13 (.)
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
SMS_FROM_NAME=SaluteOra
>>>>>>> 75179b85 (.)
=======
SMS_FROM_NAME=SaluteOra
>>>>>>> f963d2c0 (.)
=======
SMS_FROM_NAME=SaluteOra
=======
SMS_FROM_NAME=<nome progetto>
>>>>>>> bf479cc (.)
>>>>>>> 31f5d28f (.)
=======
=======
>>>>>>> 82ae73be (.)
=======
>>>>>>> 207ac35e (.)
=======
>>>>>>> 9777d1b3 (.)
=======
>>>>>>> d09cb759 (.)
SMS_FROM_NAME=<nome progetto>
=======
>>>>>>> d284d65 (.)
SMS_FROM_NAME=SaluteOra
>>>>>>> 75179b85 (.)
=======
SMS_FROM_NAME=<nome progetto>
<<<<<<< HEAD
SMS_FROM_NAME=SaluteOra
<<<<<<< HEAD
>>>>>>> f963d2c0 (.)
=======
=======
SMS_FROM_NAME=<nome progetto>
>>>>>>> bf479cc (.)
>>>>>>> 31f5d28f (.)
=======
=======
>>>>>>> 82ae73be (.)
=======
>>>>>>> 207ac35e (.)
=======
>>>>>>> 9777d1b3 (.)
=======
>>>>>>> d09cb759 (.)
SMS_FROM_NAME=<nome progetto>
=======
>>>>>>> d284d65 (.)
SMS_FROM_NAME=SaluteOra
>>>>>>> 75179b85 (.)
=======
SMS_FROM_NAME=<nome progetto>
<<<<<<< HEAD
SMS_FROM_NAME=SaluteOra
<<<<<<< HEAD
>>>>>>> f963d2c0 (.)
=======
=======
SMS_FROM_NAME=<nome progetto>
>>>>>>> bf479cc (.)
>>>>>>> 31f5d28f (.)
=======
<<<<<<< HEAD
<<<<<<< HEAD
=======
>>>>>>> 82ae73be (.)
=======
>>>>>>> 207ac35e (.)
<<<<<<< HEAD
=======
>>>>>>> 9777d1b3 (.)
=======
>>>>>>> d09cb759 (.)
SMS_FROM_NAME=<nome progetto>
=======
>>>>>>> d284d65 (.)
SMS_FROM_NAME=SaluteOra
>>>>>>> 75179b85 (.)
=======
SMS_FROM_NAME=<nome progetto>
<<<<<<< HEAD
SMS_FROM_NAME=SaluteOra
<<<<<<< HEAD
>>>>>>> f963d2c0 (.)
=======
=======
SMS_FROM_NAME=<nome progetto>
>>>>>>> bf479cc (.)
>>>>>>> 31f5d28f (.)
=======
<<<<<<< HEAD
<<<<<<< HEAD
=======
>>>>>>> 4689a827 (.)
SMS_FROM_NAME=<nome progetto>
=======
>>>>>>> d284d65 (.)
SMS_FROM_NAME=SaluteOra
>>>>>>> ee18dd92 (.)
=======
SMS_FROM_NAME=SaluteOra
=======
SMS_FROM_NAME=<nome progetto>
>>>>>>> bf479cc (.)
>>>>>>> 6608a1a0 (.)
<<<<<<< HEAD
<<<<<<< HEAD
=======
=======
>>>>>>> 7325acf3 (.)
SMS_FROM_NAME=<nome progetto>
=======
>>>>>>> d284d65 (.)
SMS_FROM_NAME=SaluteOra
>>>>>>> 66453ace (.)
=======
SMS_FROM_NAME=SaluteOra
=======
SMS_FROM_NAME=<nome progetto>
>>>>>>> bf479cc (.)
>>>>>>> 23cbbaf5 (.)
<<<<<<< HEAD
<<<<<<< HEAD
=======
=======
>>>>>>> f2e64178 (.)
SMS_FROM_NAME=<nome progetto>
=======
>>>>>>> d284d65 (.)
SMS_FROM_NAME=SaluteOra
>>>>>>> 2a97406c (.)
=======
SMS_FROM_NAME=SaluteOra
=======
SMS_FROM_NAME=<nome progetto>
>>>>>>> bf479cc (.)
>>>>>>> 909e45af (.)
<<<<<<< HEAD
=======
=======
>>>>>>> c4bdacbf (.)
SMS_FROM_NAME=<nome progetto>
=======
>>>>>>> d284d65 (.)
SMS_FROM_NAME=SaluteOra
>>>>>>> 4f042b88 (.)
=======
SMS_FROM_NAME=SaluteOra
=======
SMS_FROM_NAME=<nome progetto>
>>>>>>> bf479cc (.)
>>>>>>> bb7e77c2 (.)
=======
=======
>>>>>>> bd804d67 (.)
SMS_FROM_NAME=<nome progetto>
=======
>>>>>>> d284d65 (.)
SMS_FROM_NAME=SaluteOra
>>>>>>> 712617d3 (.)
=======
SMS_FROM_NAME=SaluteOra
=======
SMS_FROM_NAME=<nome progetto>
>>>>>>> bf479cc (.)
>>>>>>> f3086887 (rebase 210)
<<<<<<< HEAD
<<<<<<< HEAD
=======
=======
>>>>>>> 229a065a (rebase 210)
SMS_FROM_NAME=<nome progetto>
=======
>>>>>>> d284d65 (.)
SMS_FROM_NAME=SaluteOra
>>>>>>> fdb24863 (rebase 210)
=======
SMS_FROM_NAME=SaluteOra
=======
SMS_FROM_NAME=<nome progetto>
>>>>>>> bf479cc (.)
>>>>>>> 3d462363 (rebase 210)
<<<<<<< HEAD
<<<<<<< HEAD
=======
=======
>>>>>>> 9fe1b60e (rebase 210)
=======
>>>>>>> 8a8a8e2f (rebase 210)
=======
>>>>>>> efb0f8d9 (rebase 210)
=======
>>>>>>> 9f8e680a (rebase 210)
SMS_FROM_NAME=<nome progetto>
=======
>>>>>>> d284d65 (.)
SMS_FROM_NAME=SaluteOra
>>>>>>> 4fc21b78 (rebase 210)
=======
SMS_FROM_NAME=<nome progetto>
<<<<<<< HEAD
SMS_FROM_NAME=SaluteOra
<<<<<<< HEAD
>>>>>>> 9c45d9bd (rebase 210)
=======
=======
SMS_FROM_NAME=<nome progetto>
>>>>>>> bf479cc (.)
>>>>>>> 54ad93c4 (rebase 210)
=======
=======
>>>>>>> 5aedc39c (rebase 210)
SMS_FROM_NAME=<nome progetto>
=======
>>>>>>> d284d65 (.)
SMS_FROM_NAME=SaluteOra
>>>>>>> eb62d6cf (rebase 210)
=======
SMS_FROM_NAME=SaluteOra
=======
SMS_FROM_NAME=<nome progetto>
>>>>>>> bf479cc (.)
>>>>>>> 6e12a84b (rebase 210)
<<<<<<< HEAD
<<<<<<< HEAD
=======
=======
>>>>>>> 22baa66d (rebase 210)
SMS_FROM_NAME=<nome progetto>
=======
>>>>>>> d284d65 (.)
SMS_FROM_NAME=SaluteOra
>>>>>>> 8c8937e7 (rebase 210)
=======
SMS_FROM_NAME=SaluteOra
=======
SMS_FROM_NAME=<nome progetto>
>>>>>>> bf479cc (.)
>>>>>>> 545977c8 (rebase 210)
<<<<<<< HEAD
<<<<<<< HEAD
=======
=======
>>>>>>> 2effe245 (.)
SMS_FROM_NAME=<nome progetto>
=======
>>>>>>> d284d65 (.)
SMS_FROM_NAME=SaluteOra
>>>>>>> 36ac4fc1 (.)
=======
SMS_FROM_NAME=SaluteOra
=======
SMS_FROM_NAME=<nome progetto>
>>>>>>> bf479cc (.)
>>>>>>> 69fa7d37 (.)
=======
=======
>>>>>>> e790eb33 (.)
SMS_FROM_NAME=<nome progetto>
=======
>>>>>>> d284d65 (.)
SMS_FROM_NAME=SaluteOra
>>>>>>> fd1fcc4c (.)
=======
SMS_FROM_NAME=SaluteOra
=======
SMS_FROM_NAME=<nome progetto>
>>>>>>> bf479cc (.)
>>>>>>> eb71492d (.)
<<<<<<< HEAD
=======
>>>>>>> cca10a64 (.)
=======
<<<<<<< HEAD
<<<<<<< HEAD
=======
>>>>>>> 2fc60436 (.)
=======
>>>>>>> ce89c8bb (.)
=======
>>>>>>> 58816034 (.)
=======
>>>>>>> 82ae73be (.)
=======
>>>>>>> 207ac35e (.)
=======
>>>>>>> 9777d1b3 (.)
=======
>>>>>>> d09cb759 (.)
SMS_FROM_NAME=<nome progetto>
=======
>>>>>>> d284d65 (.)
<<<<<<< HEAD
SMS_FROM_NAME=SaluteOra
>>>>>>> c8b1c8bf (.)
=======
SMS_FROM_NAME=<nome progetto>
<<<<<<< HEAD
SMS_FROM_NAME=SaluteOra
<<<<<<< HEAD
>>>>>>> 9cf0dc90 (.)
=======
=======
>>>>>>> de02998b (.)
=======
>>>>>>> 011072e4 (.)
=======
>>>>>>> 161887a2 (.)
=======
>>>>>>> 4689a827 (.)
SMS_FROM_NAME=<nome progetto>
=======
>>>>>>> d284d65 (.)
=======
>>>>>>> 510809c6f (.)
SMS_FROM_NAME=SaluteOra
>>>>>>> 75179b85 (.)
=======
SMS_FROM_NAME=<nome progetto>
<<<<<<< HEAD
<<<<<<< HEAD
SMS_FROM_NAME=SaluteOra
<<<<<<< HEAD
>>>>>>> f963d2c0 (.)
=======
=======
SMS_FROM_NAME=<nome progetto>
>>>>>>> bf479cc (.)
>>>>>>> 31f5d28f (.)
=======
=======
>>>>>>> e7a9a2bf (.)
=======
>>>>>>> 9d67cabd (.)
=======
>>>>>>> ba564870 (.)
=======
>>>>>>> 7325acf3 (.)
SMS_FROM_NAME=<nome progetto>
=======
>>>>>>> d284d65 (.)
SMS_FROM_NAME=SaluteOra
>>>>>>> ee18dd92 (.)
=======
=======
SMS_FROM_NAME=<nome progetto>
>>>>>>> bf479cc (.)
>>>>>>> 6608a1a0 (.)
=======
SMS_FROM_NAME=<nome progetto>
<<<<<<< HEAD
SMS_FROM_NAME=SaluteOra
<<<<<<< HEAD
>>>>>>> 66453ace (.)
=======
=======
SMS_FROM_NAME=<nome progetto>
>>>>>>> bf479cc (.)
>>>>>>> 23cbbaf5 (.)
=======
=======
>>>>>>> f2e64178 (.)
SMS_FROM_NAME=<nome progetto>
=======
>>>>>>> d284d65 (.)
SMS_FROM_NAME=SaluteOra
>>>>>>> 2a97406c (.)
=======
SMS_FROM_NAME=SaluteOra
=======
SMS_FROM_NAME=<nome progetto>
>>>>>>> bf479cc (.)
>>>>>>> 909e45af (.)
=======
<<<<<<< HEAD
<<<<<<< HEAD
=======
>>>>>>> c4bdacbf (.)
SMS_FROM_NAME=<nome progetto>
=======
>>>>>>> d284d65 (.)
SMS_FROM_NAME=SaluteOra
>>>>>>> 4f042b88 (.)
=======
SMS_FROM_NAME=SaluteOra
=======
SMS_FROM_NAME=<nome progetto>
>>>>>>> bf479cc (.)
>>>>>>> bb7e77c2 (.)
<<<<<<< HEAD
<<<<<<< HEAD
=======
=======
>>>>>>> bd804d67 (.)
SMS_FROM_NAME=<nome progetto>
=======
>>>>>>> d284d65 (.)
SMS_FROM_NAME=SaluteOra
>>>>>>> 712617d3 (.)
=======
SMS_FROM_NAME=SaluteOra
=======
SMS_FROM_NAME=<nome progetto>
>>>>>>> bf479cc (.)
>>>>>>> f3086887 (rebase 210)
=======
=======
>>>>>>> 229a065a (rebase 210)
SMS_FROM_NAME=<nome progetto>
=======
>>>>>>> d284d65 (.)
SMS_FROM_NAME=SaluteOra
>>>>>>> fdb24863 (rebase 210)
=======
SMS_FROM_NAME=SaluteOra
=======
SMS_FROM_NAME=<nome progetto>
>>>>>>> bf479cc (.)
>>>>>>> 3d462363 (rebase 210)
=======
=======
>>>>>>> 9fe1b60e (rebase 210)
<<<<<<< HEAD
<<<<<<< HEAD
=======
>>>>>>> 8a8a8e2f (rebase 210)
=======
>>>>>>> efb0f8d9 (rebase 210)
=======
>>>>>>> 9f8e680a (rebase 210)
SMS_FROM_NAME=<nome progetto>
=======
>>>>>>> d284d65 (.)
SMS_FROM_NAME=SaluteOra
>>>>>>> 4fc21b78 (rebase 210)
=======
SMS_FROM_NAME=<nome progetto>
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
SMS_FROM_NAME=SaluteOra
<<<<<<< HEAD
>>>>>>> 9c45d9bd (rebase 210)
=======
=======
SMS_FROM_NAME=<nome progetto>
>>>>>>> bf479cc (.)
>>>>>>> 54ad93c4 (rebase 210)
=======
<<<<<<< HEAD
<<<<<<< HEAD
=======
>>>>>>> 5aedc39c (rebase 210)
SMS_FROM_NAME=<nome progetto>
=======
>>>>>>> d284d65 (.)
SMS_FROM_NAME=SaluteOra
>>>>>>> eb62d6cf (rebase 210)
=======
SMS_FROM_NAME=SaluteOra
=======
SMS_FROM_NAME=<nome progetto>
>>>>>>> bf479cc (.)
>>>>>>> 6e12a84b (rebase 210)
=======
=======
>>>>>>> 22baa66d (rebase 210)
SMS_FROM_NAME=<nome progetto>
=======
>>>>>>> d284d65 (.)
SMS_FROM_NAME=SaluteOra
>>>>>>> 8c8937e7 (rebase 210)
=======
SMS_FROM_NAME=SaluteOra
=======
SMS_FROM_NAME=<nome progetto>
>>>>>>> bf479cc (.)
>>>>>>> 545977c8 (rebase 210)
=======
=======
>>>>>>> 2effe245 (.)
<<<<<<< HEAD
SMS_FROM_NAME=<nome progetto>
=======
>>>>>>> d284d65 (.)
SMS_FROM_NAME=SaluteOra
>>>>>>> 36ac4fc1 (.)
=======
SMS_FROM_NAME=SaluteOra
=======
SMS_FROM_NAME=<nome progetto>
>>>>>>> bf479cc (.)
>>>>>>> 69fa7d37 (.)
<<<<<<< HEAD
<<<<<<< HEAD
=======
=======
>>>>>>> e790eb33 (.)
SMS_FROM_NAME=<nome progetto>
=======
>>>>>>> d284d65 (.)
SMS_FROM_NAME=SaluteOra
>>>>>>> fd1fcc4c (.)
=======
SMS_FROM_NAME=SaluteOra
=======
SMS_FROM_NAME=<nome progetto>
>>>>>>> bf479cc (.)
>>>>>>> eb71492d (.)
=======
>>>>>>> cca10a64 (.)
=======
=======
>>>>>>> 2fc60436 (.)
=======
>>>>>>> ce89c8bb (.)
<<<<<<< HEAD
=======
>>>>>>> 58816034 (.)
=======
>>>>>>> 82ae73be (.)
=======
>>>>>>> 207ac35e (.)
=======
>>>>>>> 9777d1b3 (.)
=======
>>>>>>> d09cb759 (.)
SMS_FROM_NAME=<nome progetto>
=======
>>>>>>> d284d65 (.)
SMS_FROM_NAME=SaluteOra
>>>>>>> c8b1c8bf (.)
=======
<<<<<<< HEAD
=======
>>>>>>> 82ae73be (.)
=======
>>>>>>> 207ac35e (.)
=======
>>>>>>> 9777d1b3 (.)
=======
>>>>>>> d09cb759 (.)
SMS_FROM_NAME=<nome progetto>
=======
>>>>>>> d284d65 (.)
SMS_FROM_NAME=SaluteOra
>>>>>>> 9cf0dc90 (.)
=======
SMS_FROM_NAME=<nome progetto>
<<<<<<< HEAD
<<<<<<< HEAD
SMS_FROM_NAME=SaluteOra
<<<<<<< HEAD
>>>>>>> 75179b85 (.)
=======
=======
>>>>>>> de02998b (.)
=======
>>>>>>> 011072e4 (.)
=======
>>>>>>> 161887a2 (.)
=======
>>>>>>> 4689a827 (.)
SMS_FROM_NAME=<nome progetto>
=======
>>>>>>> d284d65 (.)
=======
>>>>>>> e2f1a4045 (.)
SMS_FROM_NAME=SaluteOra
<<<<<<< HEAD
>>>>>>> f963d2c0 (.)
=======
<<<<<<< HEAD
SMS_FROM_NAME=<nome progetto>
<<<<<<< HEAD
SMS_FROM_NAME=SaluteOra
<<<<<<< HEAD
>>>>>>> 75179b855 (.)
=======
=======
>>>>>>> e7a9a2bf (.)
=======
>>>>>>> 9d67cabd (.)
=======
>>>>>>> ba564870 (.)
=======
>>>>>>> 7325acf3 (.)
SMS_FROM_NAME=<nome progetto>
=======
>>>>>>> d284d65 (.)
SMS_FROM_NAME=SaluteOra
>>>>>>> f963d2c0 (.)
=======
=======
>>>>>>> e2f1a4045 (.)
=======
SMS_FROM_NAME=<nome progetto>
>>>>>>> bf479cc (.)
>>>>>>> 31f5d28f (.)
<<<<<<< HEAD
=======
SMS_FROM_NAME=<nome progetto>
<<<<<<< HEAD
SMS_FROM_NAME=SaluteOra
<<<<<<< HEAD
>>>>>>> ee18dd92 (.)
=======
=======
SMS_FROM_NAME=<nome progetto>
>>>>>>> bf479cc (.)
>>>>>>> 6608a1a0 (.)
=======
=======
>>>>>>> 9cdf6146 (.)
=======
>>>>>>> 80f054e0 (.)
=======
>>>>>>> 7c39b1fe (.)
=======
>>>>>>> 3f39ac8b (.)
=======
>>>>>>> 4d2eb53e (.)
=======
>>>>>>> 888799d0 (.)
=======
>>>>>>> f2e64178 (.)
SMS_FROM_NAME=<nome progetto>
=======
>>>>>>> d284d65 (.)
SMS_FROM_NAME=SaluteOra
>>>>>>> 66453ace (.)
=======
=======
SMS_FROM_NAME=<nome progetto>
>>>>>>> bf479cc (.)
>>>>>>> 23cbbaf5 (.)
=======
SMS_FROM_NAME=<nome progetto>
<<<<<<< HEAD
SMS_FROM_NAME=SaluteOra
<<<<<<< HEAD
>>>>>>> 2a97406c (.)
=======
=======
SMS_FROM_NAME=<nome progetto>
>>>>>>> bf479cc (.)
>>>>>>> 909e45af (.)
=======
=======
>>>>>>> c4bdacbf (.)
SMS_FROM_NAME=<nome progetto>
=======
>>>>>>> d284d65 (.)
SMS_FROM_NAME=SaluteOra
>>>>>>> 4f042b88 (.)
=======
SMS_FROM_NAME=SaluteOra
=======
SMS_FROM_NAME=<nome progetto>
>>>>>>> bf479cc (.)
>>>>>>> bb7e77c2 (.)
=======
=======
>>>>>>> bd804d67 (.)
<<<<<<< HEAD
SMS_FROM_NAME=<nome progetto>
=======
>>>>>>> d284d65 (.)
SMS_FROM_NAME=SaluteOra
>>>>>>> 712617d3 (.)
=======
SMS_FROM_NAME=SaluteOra
=======
SMS_FROM_NAME=<nome progetto>
>>>>>>> bf479cc (.)
>>>>>>> f3086887 (rebase 210)
>>>>>>> laraxot/develop
=======
=======
=======
>>>>>>> 82ae73be (.)
>>>>>>> 10292b60a (.)
=======
>>>>>>> bf5d31b0f (.)
SMS_FROM_NAME=<nome progetto>
=======
>>>>>>> b19cd40 (.)
=======
SMS_FROM_NAME=<nome progetto>
>>>>>>> 4e2ebfb (.)
SMS_FROM_NAME=SaluteOra
>>>>>>> 75179b85 (.)
>>>>>>> 1487fe812 (.)
=======
SMS_FROM_NAME=SaluteOra
>>>>>>> f963d2c0 (.)
>>>>>>> 12a7e2462 (.)
=======
>>>>>>> e2f1a4045 (.)
=======
=======
=======
>>>>>>> 4689a827 (.)
>>>>>>> 8dc1f2ed6 (.)
SMS_FROM_NAME=<nome progetto>
=======
>>>>>>> d284d65 (.)
SMS_FROM_NAME=SaluteOra
>>>>>>> ee18dd92 (.)
>>>>>>> 4bec160e6 (.)
=======
>>>>>>> 01af324fe (.)
=======
=======
=======
>>>>>>> 7325acf3 (.)
SMS_FROM_NAME=<nome progetto>
=======
>>>>>>> d284d65 (.)
SMS_FROM_NAME=SaluteOra
>>>>>>> 66453ace (.)
>>>>>>> 138485550 (.)
=======
>>>>>>> 53eef8d8d (.)
=======
=======
=======
>>>>>>> f2e64178 (.)
SMS_FROM_NAME=<nome progetto>
=======
>>>>>>> d284d65 (.)
SMS_FROM_NAME=SaluteOra
>>>>>>> 2a97406c (.)
>>>>>>> 998e6866b (.)
=======
>>>>>>> 13aa25113 (.)
=======
=======
=======
>>>>>>> c4bdacbf (.)
>>>>>>> a115e2aad (.)
SMS_FROM_NAME=<nome progetto>
=======
>>>>>>> d284d65 (.)
SMS_FROM_NAME=SaluteOra
>>>>>>> 4f042b88 (.)
>>>>>>> 36136dcfa (.)
=======
>>>>>>> 7aae79847 (.)
=======
=======
=======
>>>>>>> 848f79b79 (.)
SMS_FROM_NAME=<nome progetto>
=======
>>>>>>> d284d65 (.)
SMS_FROM_NAME=SaluteOra
>>>>>>> 712617d3 (.)
>>>>>>> 731b801a8 (.)
=======
>>>>>>> 74eb2e964 (.)
=======
=======
=======
>>>>>>> 229a065a (rebase 210)
SMS_FROM_NAME=<nome progetto>
=======
>>>>>>> d284d65 (.)
SMS_FROM_NAME=SaluteOra
>>>>>>> fdb24863 (rebase 210)
>>>>>>> b85076e48 (.)
=======
>>>>>>> 0a5473e16 (.)
=======
=======
=======
>>>>>>> a0788fa28 (.)
=======
=======
>>>>>>> 8a8a8e2f (rebase 210)
>>>>>>> 69f695548 (.)
SMS_FROM_NAME=<nome progetto>
=======
>>>>>>> b19cd40 (.)
=======
SMS_FROM_NAME=<nome progetto>
>>>>>>> 4e2ebfb (.)
SMS_FROM_NAME=SaluteOra
>>>>>>> 4fc21b78 (rebase 210)
>>>>>>> 43dd68f4b (.)
=======
=======
>>>>>>> 6ad5224fb (.)
SMS_FROM_NAME=SaluteOra
<<<<<<< HEAD
>>>>>>> 9c45d9bd (rebase 210)
<<<<<<< HEAD
>>>>>>> ce1853afd (.)
=======
=======
=======
SMS_FROM_NAME=<nome progetto>
>>>>>>> bf479cc (.)
>>>>>>> 54ad93c4 (rebase 210)
>>>>>>> 6ad5224fb (.)
=======
=======
=======
>>>>>>> 5aedc39c (rebase 210)
>>>>>>> cd5474106 (.)
SMS_FROM_NAME=<nome progetto>
=======
>>>>>>> d284d65 (.)
SMS_FROM_NAME=SaluteOra
>>>>>>> eb62d6cf (rebase 210)
>>>>>>> 7a142b4f5 (.)
=======
>>>>>>> 1c96b91fe (.)
=======
=======
=======
>>>>>>> 22baa66d (rebase 210)
SMS_FROM_NAME=<nome progetto>
=======
>>>>>>> d284d65 (.)
SMS_FROM_NAME=SaluteOra
>>>>>>> 8c8937e7 (rebase 210)
>>>>>>> c31e900eb (.)
=======
>>>>>>> ad905ce9c (.)
=======
=======
=======
>>>>>>> 26d39e2eb (.)
SMS_FROM_NAME=<nome progetto>
=======
>>>>>>> d284d65 (.)
SMS_FROM_NAME=SaluteOra
>>>>>>> 36ac4fc1 (.)
>>>>>>> fea359347 (.)
=======
>>>>>>> c7d5eaf96 (.)
=======
=======
=======
>>>>>>> e790eb33 (.)
SMS_FROM_NAME=<nome progetto>
=======
>>>>>>> d284d65 (.)
SMS_FROM_NAME=SaluteOra
>>>>>>> fd1fcc4c (.)
>>>>>>> d9e649ac3 (.)
=======
>>>>>>> a2f3c239e (.)
=======
=======
=======
>>>>>>> 2fc60436 (.)
>>>>>>> be698cf2c (.)
=======
>>>>>>> cbb586cb0 (.)
SMS_FROM_NAME=<nome progetto>
=======
>>>>>>> b19cd40 (.)
=======
SMS_FROM_NAME=<nome progetto>
>>>>>>> 4e2ebfb (.)
SMS_FROM_NAME=SaluteOra
>>>>>>> c8b1c8bf (.)
>>>>>>> 7ceb00286 (.)
=======
SMS_FROM_NAME=<nome progetto>
SMS_FROM_NAME=SaluteOra
>>>>>>> 9cf0dc90 (.)
>>>>>>> 379ffe3f3 (.)
=======
SMS_FROM_NAME=<nome progetto>
SMS_FROM_NAME=<nome progetto>
>>>>>>> a55aa5e96 (.)
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
<<<<<<< HEAD
<<<<<<< HEAD
=======
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
=======
>>>>>>> 75179b85 (.)
=======
>>>>>>> f963d2c0 (.)
=======
>>>>>>> d09cb759 (.)
=======
>>>>>>> 75179b85 (.)
=======
>>>>>>> f963d2c0 (.)
=======
>>>>>>> d09cb759 (.)
=======
>>>>>>> 75179b85 (.)
<<<<<<< HEAD
<<<<<<< HEAD
=======
>>>>>>> f963d2c0 (.)
=======
>>>>>>> d09cb759 (.)
<<<<<<< HEAD
<<<<<<< HEAD
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
>>>>>>> f2e64178 (.)
=======
>>>>>>> 4f042b88 (.)
=======
>>>>>>> c4bdacbf (.)
<<<<<<< HEAD
<<<<<<< HEAD
=======
>>>>>>> 712617d3 (.)
=======
>>>>>>> bd804d67 (.)
<<<<<<< HEAD
<<<<<<< HEAD
=======
>>>>>>> fdb24863 (rebase 210)
=======
>>>>>>> 229a065a (rebase 210)
=======
>>>>>>> 4fc21b78 (rebase 210)
=======
>>>>>>> 9c45d9bd (rebase 210)
=======
>>>>>>> 9f8e680a (rebase 210)
<<<<<<< HEAD
<<<<<<< HEAD
=======
>>>>>>> eb62d6cf (rebase 210)
=======
>>>>>>> 5aedc39c (rebase 210)
<<<<<<< HEAD
<<<<<<< HEAD
=======
>>>>>>> 8c8937e7 (rebase 210)
=======
>>>>>>> 22baa66d (rebase 210)
=======
>>>>>>> 36ac4fc1 (.)
=======
>>>>>>> 2effe245 (.)
=======
>>>>>>> fd1fcc4c (.)
<<<<<<< HEAD
<<<<<<< HEAD
=======
>>>>>>> e790eb33 (.)
=======
>>>>>>> c8b1c8bf (.)
<<<<<<< HEAD
<<<<<<< HEAD
=======
>>>>>>> 9cf0dc90 (.)
=======
>>>>>>> 75179b85 (.)
=======
>>>>>>> f963d2c0 (.)
=======
>>>>>>> d09cb759 (.)
=======
>>>>>>> ee18dd92 (.)
=======
>>>>>>> 4689a827 (.)
<<<<<<< HEAD
<<<<<<< HEAD
=======
>>>>>>> 66453ace (.)
=======
>>>>>>> 7325acf3 (.)
<<<<<<< HEAD
=======
>>>>>>> 2a97406c (.)
=======
>>>>>>> f2e64178 (.)
=======
>>>>>>> 4f042b88 (.)
=======
>>>>>>> c4bdacbf (.)
=======
>>>>>>> 712617d3 (.)
=======
>>>>>>> bd804d67 (.)
=======
>>>>>>> fdb24863 (rebase 210)
=======
>>>>>>> 229a065a (rebase 210)
<<<<<<< HEAD
<<<<<<< HEAD
=======
>>>>>>> 4fc21b78 (rebase 210)
=======
>>>>>>> 9c45d9bd (rebase 210)
<<<<<<< HEAD
=======
>>>>>>> 9f8e680a (rebase 210)
=======
>>>>>>> eb62d6cf (rebase 210)
=======
>>>>>>> 5aedc39c (rebase 210)
=======
>>>>>>> 8c8937e7 (rebase 210)
=======
>>>>>>> 22baa66d (rebase 210)
<<<<<<< HEAD
<<<<<<< HEAD
=======
>>>>>>> 36ac4fc1 (.)
=======
>>>>>>> 2effe245 (.)
<<<<<<< HEAD
=======
>>>>>>> fd1fcc4c (.)
=======
>>>>>>> e790eb33 (.)
=======
>>>>>>> c8b1c8bf (.)
=======
>>>>>>> 9cf0dc90 (.)
=======
>>>>>>> 75179b85 (.)
=======
>>>>>>> f963d2c0 (.)
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
<<<<<<< HEAD
<<<<<<< HEAD
=======
>>>>>>> f2e64178 (.)
=======
>>>>>>> 4f042b88 (.)
<<<<<<< HEAD
=======
>>>>>>> c4bdacbf (.)
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
=======
>>>>>>> 4fc21b78 (rebase 210)
>>>>>>> 43dd68f4b (.)
=======
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
=======
>>>>>>> 36ac4fc1 (.)
>>>>>>> fea359347 (.)
=======
>>>>>>> 26d39e2eb (.)
=======
>>>>>>> d9e649ac3 (.)
=======
=======
>>>>>>> e790eb33 (.)
>>>>>>> 2dab69c8a (.)
=======
>>>>>>> 7ceb00286 (.)
=======
=======
>>>>>>> 9cf0dc90 (.)
>>>>>>> 379ffe3f3 (.)
=======
>>>>>>> a55aa5e96 (.)
- [Laravel Notifications](https://laravel.com/project_docs/notifications)
- [Laravel Queues](https://laravel.com/project_docs/queues)
- [Laravel Testing](https://laravel.com/project_docs/testing)
- [Laravel Logging](https://laravel.com/project_docs/logging)
- [Laravel Cache](https://laravel.com/project_docs/cache) 
<<<<<<< HEAD
<<<<<<< HEAD
=======
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
=======
>>>>>>> d284d65 (.)
=======
<<<<<<< HEAD
>>>>>>> de02998b (.)
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
<<<<<<< HEAD
<<<<<<< HEAD
=======
>>>>>>> 82ae73be (.)
=======
=======
>>>>>>> 4e2ebfb (.)
>>>>>>> 207ac35e (.)
<<<<<<< HEAD
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
>>>>>>> ee18dd92 (.)
=======
=======
>>>>>>> d284d65 (.)
>>>>>>> 4689a827 (.)
=======
>>>>>>> e7a9a2bf (.)
<<<<<<< HEAD
<<<<<<< HEAD
=======
>>>>>>> 4f19d70d2 (.)
=======
=======
>>>>>>> 4e2ebfb (.)
>>>>>>> 9d67cabd (.)
<<<<<<< HEAD
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
<<<<<<< HEAD
<<<<<<< HEAD
=======
>>>>>>> 23f115647 (.)
=======
=======
>>>>>>> d284d65 (.)
>>>>>>> f2e64178 (.)
<<<<<<< HEAD
<<<<<<< HEAD
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
=======
>>>>>>> d284d65 (.)
>>>>>>> c4bdacbf (.)
=======
>>>>>>> 8e5817bc (.)
<<<<<<< HEAD
<<<<<<< HEAD
=======
>>>>>>> 968ed47cd (.)
=======
=======
>>>>>>> 4e2ebfb (.)
>>>>>>> e0d9c9be (.)
<<<<<<< HEAD
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
=======
=======
>>>>>>> d284d65 (.)
>>>>>>> 229a065a (rebase 210)
<<<<<<< HEAD
<<<<<<< HEAD
=======
>>>>>>> a9bf0423 (rebase 210)
=======
=======
>>>>>>> 4e2ebfb (.)
>>>>>>> 460b8f5b (rebase 210)
<<<<<<< HEAD
=======
>>>>>>> 4d253d2c (rebase 210)
=======
>>>>>>> 4fc21b78 (rebase 210)
=======
>>>>>>> 9fe1b60e (rebase 210)
=======
=======
>>>>>>> 4e2ebfb (.)
>>>>>>> 8a8a8e2f (rebase 210)
=======
>>>>>>> efb0f8d9 (rebase 210)
=======
>>>>>>> 9c45d9bd (rebase 210)
<<<<<<< HEAD
<<<<<<< HEAD
=======
>>>>>>> c188e2a18 (.)
=======
=======
>>>>>>> d284d65 (.)
>>>>>>> 9f8e680a (rebase 210)
<<<<<<< HEAD
<<<<<<< HEAD
=======
>>>>>>> b4f93b3a (rebase 210)
=======
=======
>>>>>>> 4e2ebfb (.)
>>>>>>> 1375c94d (rebase 210)
=======
>>>>>>> 52cd5f85 (rebase 210)
=======
>>>>>>> eb62d6cf (rebase 210)
=======
=======
>>>>>>> d284d65 (.)
>>>>>>> 5aedc39c (rebase 210)
<<<<<<< HEAD
<<<<<<< HEAD
=======
>>>>>>> c5c038f2 (rebase 210)
=======
=======
>>>>>>> 4e2ebfb (.)
>>>>>>> 030c9674 (rebase 210)
<<<<<<< HEAD
=======
>>>>>>> bb00ab64 (rebase 210)
=======
>>>>>>> 8c8937e7 (rebase 210)
=======
=======
>>>>>>> d284d65 (.)
>>>>>>> 22baa66d (rebase 210)
=======
>>>>>>> 36ac4fc1 (.)
=======
=======
>>>>>>> d284d65 (.)
>>>>>>> 2effe245 (.)
<<<<<<< HEAD
<<<<<<< HEAD
=======
>>>>>>> 77edd94a (.)
=======
=======
>>>>>>> 4e2ebfb (.)
>>>>>>> eea68ec9 (.)
<<<<<<< HEAD
=======
>>>>>>> 59916c8f (.)
=======
>>>>>>> fd1fcc4c (.)
=======
=======
>>>>>>> d284d65 (.)
>>>>>>> e790eb33 (.)
=======
>>>>>>> c8b1c8bf (.)
=======
>>>>>>> 2fc60436 (.)
=======
=======
>>>>>>> 4e2ebfb (.)
>>>>>>> ce89c8bb (.)
=======
>>>>>>> 58816034 (.)
=======
>>>>>>> 9cf0dc90 (.)
<<<<<<< HEAD
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
<<<<<<< HEAD
<<<<<<< HEAD
=======
>>>>>>> 510809c6f (.)
=======
=======
>>>>>>> d284d65 (.)
>>>>>>> d09cb759 (.)
<<<<<<< HEAD
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
=======
>>>>>>> 4e2ebfb (.)
>>>>>>> 9d67cabd (.)
=======
>>>>>>> ba564870 (.)
=======
>>>>>>> 66453ace (.)
<<<<<<< HEAD
<<<<<<< HEAD
=======
>>>>>>> 2e9bd58c3 (.)
=======
=======
>>>>>>> d284d65 (.)
>>>>>>> 7325acf3 (.)
<<<<<<< HEAD
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
<<<<<<< HEAD
<<<<<<< HEAD
=======
>>>>>>> 2f135ef98 (.)
=======
=======
>>>>>>> 4e2ebfb (.)
>>>>>>> 4d2eb53e (.)
<<<<<<< HEAD
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
<<<<<<< HEAD
=======
>>>>>>> c6c33175 (.)
=======
>>>>>>> 4f042b88 (.)
=======
=======
>>>>>>> d284d65 (.)
>>>>>>> c4bdacbf (.)
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
<<<<<<< HEAD
<<<<<<< HEAD
=======
>>>>>>> 848f79b79 (.)
=======
=======
>>>>>>> d284d65 (.)
>>>>>>> bd804d67 (.)
<<<<<<< HEAD
<<<<<<< HEAD
=======
>>>>>>> 51182e3c (rebase 210)
=======
=======
>>>>>>> 4e2ebfb (.)
>>>>>>> cb85c538 (rebase 210)
<<<<<<< HEAD
=======
>>>>>>> 1c0eb9c7 (rebase 210)
=======
>>>>>>> fdb24863 (rebase 210)
<<<<<<< HEAD
=======
=======
>>>>>>> d284d65 (.)
>>>>>>> 229a065a (rebase 210)
=======
>>>>>>> a9bf0423 (rebase 210)
=======
=======
>>>>>>> 4e2ebfb (.)
>>>>>>> 460b8f5b (rebase 210)
=======
>>>>>>> 4d253d2c (rebase 210)
=======
>>>>>>> 4fc21b78 (rebase 210)
<<<<<<< HEAD
<<<<<<< HEAD
=======
>>>>>>> 9fe1b60e (rebase 210)
=======
=======
>>>>>>> 4e2ebfb (.)
>>>>>>> 8a8a8e2f (rebase 210)
<<<<<<< HEAD
=======
>>>>>>> efb0f8d9 (rebase 210)
=======
>>>>>>> 9c45d9bd (rebase 210)
=======
=======
>>>>>>> d284d65 (.)
>>>>>>> 9f8e680a (rebase 210)
=======
>>>>>>> b4f93b3a (rebase 210)
=======
=======
>>>>>>> 4e2ebfb (.)
>>>>>>> 1375c94d (rebase 210)
<<<<<<< HEAD
=======
>>>>>>> 52cd5f85 (rebase 210)
=======
>>>>>>> eb62d6cf (rebase 210)
<<<<<<< HEAD
=======
=======
>>>>>>> d284d65 (.)
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
<<<<<<< HEAD
<<<<<<< HEAD
=======
>>>>>>> 01750b107 (.)
=======
=======
>>>>>>> d284d65 (.)
>>>>>>> 22baa66d (rebase 210)
<<<<<<< HEAD
<<<<<<< HEAD
=======
>>>>>>> 36ac4fc1 (.)
=======
=======
>>>>>>> d284d65 (.)
>>>>>>> 2effe245 (.)
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
<<<<<<< HEAD
<<<<<<< HEAD
=======
>>>>>>> 2dab69c8a (.)
=======
=======
>>>>>>> d284d65 (.)
>>>>>>> e790eb33 (.)
<<<<<<< HEAD
<<<<<<< HEAD
=======
>>>>>>> c8b1c8bf (.)
=======
>>>>>>> 2fc60436 (.)
<<<<<<< HEAD
<<<<<<< HEAD
=======
>>>>>>> cbb586cb0 (.)
=======
=======
>>>>>>> 4e2ebfb (.)
>>>>>>> ce89c8bb (.)
<<<<<<< HEAD
=======
>>>>>>> 58816034 (.)
=======
>>>>>>> 9cf0dc90 (.)
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
<<<<<<< HEAD
>>>>>>> 75179b855 (.)
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
>>>>>>> de02998b (.)
=======
=======
>>>>>>> 4e2ebfb (.)
>>>>>>> 011072e4 (.)
<<<<<<< HEAD
=======
>>>>>>> 161887a2 (.)
=======
>>>>>>> ee18dd92 (.)
<<<<<<< HEAD
<<<<<<< HEAD
=======
>>>>>>> 8dc1f2ed6 (.)
=======
=======
>>>>>>> d284d65 (.)
>>>>>>> 4689a827 (.)
<<<<<<< HEAD
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
=======
>>>>>>> d284d65 (.)
>>>>>>> 7325acf3 (.)
=======
>>>>>>> 9cdf6146 (.)
<<<<<<< HEAD
<<<<<<< HEAD
=======
>>>>>>> 8f2456941 (.)
=======
=======
>>>>>>> 4e2ebfb (.)
>>>>>>> 80f054e0 (.)
<<<<<<< HEAD
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
<<<<<<< HEAD
<<<<<<< HEAD
=======
>>>>>>> a115e2aad (.)
=======
=======
>>>>>>> d284d65 (.)
>>>>>>> c4bdacbf (.)
<<<<<<< HEAD
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
>>>>>>> laraxot/develop
=======
>>>>>>> 1487fe812 (.)
=======
=======
>>>>>>> 82ae73be (.)
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
>>>>>>> 2641c2944 (.)
=======
>>>>>>> 968ed47cd (.)
=======
>>>>>>> 731b801a8 (.)
=======
>>>>>>> 848f79b79 (.)
=======
=======
>>>>>>> 51182e3c (rebase 210)
>>>>>>> 13655a7ed (.)
=======
>>>>>>> e0836b102 (.)
=======
>>>>>>> b85076e48 (.)
=======
>>>>>>> 3e757cee2 (.)
=======
=======
>>>>>>> a9bf0423 (rebase 210)
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
- [Laravel Notifications](https://laravel.com/docs/notifications)
- [Laravel Queues](https://laravel.com/docs/queues)
- [Laravel Testing](https://laravel.com/docs/testing)
- [Laravel Logging](https://laravel.com/docs/logging)
- [Laravel Cache](https://laravel.com/docs/cache) 
<<<<<<< HEAD
<<<<<<< HEAD
- [Laravel Cache](https://laravel.com/docs/cache) 
=======
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
- [Laravel Cache](https://laravel.com/docs/cache) 
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
=======
>>>>>>> 10292b60a (.)
=======
>>>>>>> bf5d31b0f (.)
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
>>>>>>> be698cf2c (.)
=======
>>>>>>> cbb586cb0 (.)
=======
<<<<<<< HEAD
<<<<<<< HEAD
>>>>>>> d284d65 (.)
=======
>>>>>>> b19cd40 (.)
<<<<<<< HEAD
>>>>>>> de02998b (.)
=======
- [Laravel Cache](https://laravel.com/docs/cache) 
>>>>>>> 75179b85 (.)
=======
>>>>>>> b19cd40 (.)
>>>>>>> 82ae73be (.)
=======
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
<<<<<<< HEAD
<<<<<<< HEAD
=======
>>>>>>> 10292b60a (.)
=======
=======
>>>>>>> b19cd40 (.)
>>>>>>> 82ae73be (.)
<<<<<<< HEAD
<<<<<<< HEAD
=======
>>>>>>> bf5d31b0f (.)
=======
=======
>>>>>>> b19cd40 (.)
=======
>>>>>>> 4e2ebfb (.)
>>>>>>> 207ac35e (.)
<<<<<<< HEAD
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
<<<<<<< HEAD
<<<<<<< HEAD
=======
>>>>>>> 4f19d70d2 (.)
=======
=======
>>>>>>> b19cd40 (.)
=======
>>>>>>> 4e2ebfb (.)
>>>>>>> 9d67cabd (.)
<<<<<<< HEAD
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
=======
>>>>>>> 5fd545e4 (.)
=======
=======
>>>>>>> b19cd40 (.)
>>>>>>> 3f39ac8b (.)
<<<<<<< HEAD
<<<<<<< HEAD
=======
>>>>>>> 2f135ef98 (.)
=======
=======
>>>>>>> b19cd40 (.)
=======
>>>>>>> 4e2ebfb (.)
>>>>>>> 4d2eb53e (.)
<<<<<<< HEAD
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
<<<<<<< HEAD
<<<<<<< HEAD
=======
>>>>>>> a115e2aad (.)
=======
- [Laravel Cache](https://laravel.com/docs/cache) 
=======
>>>>>>> d284d65 (.)
>>>>>>> c4bdacbf (.)
<<<<<<< HEAD
<<<<<<< HEAD
=======
>>>>>>> 2641c2944 (.)
=======
=======
>>>>>>> b19cd40 (.)
>>>>>>> 8e5817bc (.)
<<<<<<< HEAD
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
=======
- [Laravel Cache](https://laravel.com/docs/cache) 
=======
>>>>>>> d284d65 (.)
>>>>>>> 229a065a (rebase 210)
<<<<<<< HEAD
<<<<<<< HEAD
=======
>>>>>>> 903e3e2cd (.)
=======
=======
>>>>>>> b19cd40 (.)
>>>>>>> a9bf0423 (rebase 210)
<<<<<<< HEAD
<<<<<<< HEAD
=======
>>>>>>> 47a873f13 (.)
=======
=======
>>>>>>> b19cd40 (.)
=======
>>>>>>> 4e2ebfb (.)
>>>>>>> 460b8f5b (rebase 210)
<<<<<<< HEAD
=======
>>>>>>> 4d253d2c (rebase 210)
=======
>>>>>>> 54220b28 (rebase 210)
=======
- [Laravel Cache](https://laravel.com/docs/cache) 
>>>>>>> 4fc21b78 (rebase 210)
=======
=======
>>>>>>> b19cd40 (.)
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
>>>>>>> 9c45d9bd (rebase 210)
<<<<<<< HEAD
<<<<<<< HEAD
=======
>>>>>>> c188e2a18 (.)
=======
- [Laravel Cache](https://laravel.com/docs/cache) 
=======
>>>>>>> d284d65 (.)
>>>>>>> 9f8e680a (rebase 210)
<<<<<<< HEAD
<<<<<<< HEAD
=======
>>>>>>> 5d49e093a (.)
=======
=======
>>>>>>> b19cd40 (.)
>>>>>>> b4f93b3a (rebase 210)
<<<<<<< HEAD
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
=======
- [Laravel Cache](https://laravel.com/docs/cache) 
=======
>>>>>>> d284d65 (.)
>>>>>>> 5aedc39c (rebase 210)
=======
=======
>>>>>>> b19cd40 (.)
>>>>>>> c5c038f2 (rebase 210)
<<<<<<< HEAD
<<<<<<< HEAD
=======
>>>>>>> db6bec044 (.)
=======
=======
>>>>>>> b19cd40 (.)
=======
>>>>>>> 4e2ebfb (.)
>>>>>>> 030c9674 (rebase 210)
<<<<<<< HEAD
=======
>>>>>>> bb00ab64 (rebase 210)
=======
- [Laravel Cache](https://laravel.com/docs/cache) 
>>>>>>> 8c8937e7 (rebase 210)
=======
- [Laravel Cache](https://laravel.com/docs/cache) 
=======
>>>>>>> d284d65 (.)
>>>>>>> 22baa66d (rebase 210)
=======
- [Laravel Cache](https://laravel.com/docs/cache) 
>>>>>>> 36ac4fc1 (.)
=======
- [Laravel Cache](https://laravel.com/docs/cache) 
=======
>>>>>>> d284d65 (.)
>>>>>>> 2effe245 (.)
<<<<<<< HEAD
<<<<<<< HEAD
=======
>>>>>>> 2e1ac1f20 (.)
=======
=======
>>>>>>> b19cd40 (.)
>>>>>>> 77edd94a (.)
<<<<<<< HEAD
<<<<<<< HEAD
=======
>>>>>>> 6dad70a87 (.)
=======
=======
>>>>>>> b19cd40 (.)
=======
>>>>>>> 4e2ebfb (.)
>>>>>>> eea68ec9 (.)
<<<<<<< HEAD
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
- [Laravel Cache](https://laravel.com/docs/cache) 
>>>>>>> c8b1c8bf (.)
=======
=======
>>>>>>> b19cd40 (.)
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
<<<<<<< HEAD
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
<<<<<<< HEAD
<<<<<<< HEAD
=======
>>>>>>> 510809c6f (.)
=======
- [Laravel Cache](https://laravel.com/docs/cache) 
=======
>>>>>>> d284d65 (.)
>>>>>>> d09cb759 (.)
<<<<<<< HEAD
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
<<<<<<< HEAD
<<<<<<< HEAD
=======
>>>>>>> 2e9bd58c3 (.)
=======
- [Laravel Cache](https://laravel.com/docs/cache) 
=======
>>>>>>> d284d65 (.)
>>>>>>> 7325acf3 (.)
<<<<<<< HEAD
<<<<<<< HEAD
=======
>>>>>>> c22b35d1e (.)
=======
=======
>>>>>>> b19cd40 (.)
>>>>>>> 9cdf6146 (.)
<<<<<<< HEAD
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
<<<<<<< HEAD
<<<<<<< HEAD
=======
>>>>>>> 23f115647 (.)
=======
- [Laravel Cache](https://laravel.com/docs/cache) 
=======
>>>>>>> d284d65 (.)
>>>>>>> f2e64178 (.)
<<<<<<< HEAD
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
- [Laravel Cache](https://laravel.com/docs/cache) 
=======
>>>>>>> d284d65 (.)
>>>>>>> c4bdacbf (.)
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
<<<<<<< HEAD
=======
>>>>>>> 7a2f131f (.)
=======
- [Laravel Cache](https://laravel.com/docs/cache) 
>>>>>>> 712617d3 (.)
<<<<<<< HEAD
<<<<<<< HEAD
=======
>>>>>>> 848f79b79 (.)
=======
- [Laravel Cache](https://laravel.com/docs/cache) 
=======
>>>>>>> d284d65 (.)
>>>>>>> bd804d67 (.)
<<<<<<< HEAD
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
<<<<<<< HEAD
=======
- [Laravel Cache](https://laravel.com/docs/cache) 
=======
>>>>>>> d284d65 (.)
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
>>>>>>> 54220b28 (rebase 210)
=======
- [Laravel Cache](https://laravel.com/docs/cache) 
>>>>>>> 4fc21b78 (rebase 210)
<<<<<<< HEAD
<<<<<<< HEAD
=======
>>>>>>> a0788fa28 (.)
=======
=======
>>>>>>> b19cd40 (.)
>>>>>>> 9fe1b60e (rebase 210)
<<<<<<< HEAD
<<<<<<< HEAD
=======
>>>>>>> 69f695548 (.)
=======
=======
>>>>>>> b19cd40 (.)
=======
>>>>>>> 4e2ebfb (.)
>>>>>>> 8a8a8e2f (rebase 210)
<<<<<<< HEAD
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
<<<<<<< HEAD
=======
>>>>>>> 52cd5f85 (rebase 210)
=======
- [Laravel Cache](https://laravel.com/docs/cache) 
>>>>>>> eb62d6cf (rebase 210)
<<<<<<< HEAD
<<<<<<< HEAD
=======
>>>>>>> cd5474106 (.)
=======
- [Laravel Cache](https://laravel.com/docs/cache) 
=======
>>>>>>> d284d65 (.)
>>>>>>> 5aedc39c (rebase 210)
<<<<<<< HEAD
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
>>>>>>> 8c8937e7 (rebase 210)
<<<<<<< HEAD
<<<<<<< HEAD
=======
>>>>>>> 01750b107 (.)
=======
- [Laravel Cache](https://laravel.com/docs/cache) 
=======
>>>>>>> d284d65 (.)
>>>>>>> 22baa66d (rebase 210)
<<<<<<< HEAD
<<<<<<< HEAD
=======
- [Laravel Cache](https://laravel.com/docs/cache) 
>>>>>>> 36ac4fc1 (.)
=======
- [Laravel Cache](https://laravel.com/docs/cache) 
=======
>>>>>>> d284d65 (.)
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
- [Laravel Cache](https://laravel.com/docs/cache) 
>>>>>>> fd1fcc4c (.)
<<<<<<< HEAD
<<<<<<< HEAD
=======
>>>>>>> 2dab69c8a (.)
=======
- [Laravel Cache](https://laravel.com/docs/cache) 
=======
>>>>>>> d284d65 (.)
>>>>>>> e790eb33 (.)
<<<<<<< HEAD
<<<<<<< HEAD
=======
- [Laravel Cache](https://laravel.com/docs/cache) 
>>>>>>> c8b1c8bf (.)
=======
=======
>>>>>>> b19cd40 (.)
>>>>>>> 2fc60436 (.)
<<<<<<< HEAD
<<<<<<< HEAD
=======
>>>>>>> cbb586cb0 (.)
=======
=======
>>>>>>> b19cd40 (.)
=======
>>>>>>> 4e2ebfb (.)
>>>>>>> ce89c8bb (.)
<<<<<<< HEAD
=======
>>>>>>> 58816034 (.)
=======
- [Laravel Cache](https://laravel.com/docs/cache) 
>>>>>>> 9cf0dc90 (.)
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
<<<<<<< HEAD
- [Laravel Cache](https://laravel.com/docs/cache) 
>>>>>>> 75179b855 (.)
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
=======
>>>>>>> b19cd40 (.)
>>>>>>> de02998b (.)
=======
=======
>>>>>>> b19cd40 (.)
=======
>>>>>>> 4e2ebfb (.)
>>>>>>> 011072e4 (.)
<<<<<<< HEAD
=======
>>>>>>> 161887a2 (.)
=======
- [Laravel Cache](https://laravel.com/docs/cache) 
>>>>>>> ee18dd92 (.)
<<<<<<< HEAD
<<<<<<< HEAD
=======
>>>>>>> 8dc1f2ed6 (.)
=======
- [Laravel Cache](https://laravel.com/docs/cache) 
=======
>>>>>>> d284d65 (.)
>>>>>>> 4689a827 (.)
<<<<<<< HEAD
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
<<<<<<< HEAD
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
- [Laravel Cache](https://laravel.com/docs/cache) 
=======
>>>>>>> d284d65 (.)
>>>>>>> f2e64178 (.)
=======
=======
>>>>>>> b19cd40 (.)
>>>>>>> 6d08c01b (.)
<<<<<<< HEAD
<<<<<<< HEAD
=======
>>>>>>> be45a0b8d (.)
=======
=======
>>>>>>> b19cd40 (.)
=======
>>>>>>> 4e2ebfb (.)
>>>>>>> 6b6b9e41 (.)
<<<<<<< HEAD
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
<<<<<<< HEAD
>>>>>>> laraxot/develop
=======
>>>>>>> 301ad8b44 (.)
=======
>>>>>>> 1487fe812 (.)
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
>>>>>>> 2641c2944 (.)
=======
>>>>>>> 968ed47cd (.)
=======
>>>>>>> 731b801a8 (.)
=======
>>>>>>> 848f79b79 (.)
=======
=======
=======
>>>>>>> b19cd40 (.)
>>>>>>> 51182e3c (rebase 210)
<<<<<<< HEAD
>>>>>>> 13655a7ed (.)
=======
=======
=======
>>>>>>> b19cd40 (.)
=======
>>>>>>> 4e2ebfb (.)
>>>>>>> cb85c538 (rebase 210)
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
=======
- [Laravel Cache](https://laravel.com/docs/cache) 
>>>>>>> 36ac4fc1 (.)
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
