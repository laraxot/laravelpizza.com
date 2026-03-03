# Implementazione Canale Telegram

## 1. Struttura Base

### 1.1 Data Transfer Objects
```php
<?php

namespace Modules\Notify\Datas;

use Spatie\LaravelData\Data;

class TelegramMessageData extends Data
{
    public function __construct(
        public string $chat_id,
        public string $text,
        public ?string $parse_mode = null,
        public ?bool $disable_web_page_preview = null,
        public ?bool $disable_notification = null,
        public ?int $reply_to_message_id = null,
        public ?array $reply_markup = null,
        public ?string $media_url = null,
        public ?string $media_type = null,
        public ?string $caption = null
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            chat_id: $data['chat_id'],
            text: $data['text'],
            parse_mode: $data['parse_mode'] ?? null,
            disable_web_page_preview: $data['disable_web_page_preview'] ?? null,
            disable_notification: $data['disable_notification'] ?? null,
            reply_to_message_id: $data['reply_to_message_id'] ?? null,
            reply_markup: $data['reply_markup'] ?? null,
            media_url: $data['media_url'] ?? null,
            media_type: $data['media_type'] ?? null,
            caption: $data['caption'] ?? null
        );
    }
}
```

### 1.2 Interfaccia
```php
<?php

namespace Modules\Notify\Contracts\Telegram;

use Modules\Notify\Datas\TelegramMessageData;

interface TelegramActionInterface
{
    /**
     * Esegue l'invio del messaggio Telegram
     *
     * @param TelegramMessageData $messageData I dati del messaggio
     * @return array Risultato dell'operazione
     * @throws \Exception In caso di errore durante l'invio
     */
    public function execute(TelegramMessageData $messageData): array;
}
```

## 2. Configurazione

### 2.1 Config File
```php
<?php
// config/notify.php

return [
    'drivers' => [
        'telegram' => [
            'bot' => [
                'token' => env('TELEGRAM_BOT_TOKEN'),
                'username' => env('TELEGRAM_BOT_USERNAME'),
                'endpoint' => env('TELEGRAM_API_ENDPOINT', 'https://api.telegram.org/bot{token}'),
            ],
            'webhook' => [
                'enabled' => env('TELEGRAM_WEBHOOK_ENABLED', false),
                'url' => env('TELEGRAM_WEBHOOK_URL'),
                'secret_token' => env('TELEGRAM_WEBHOOK_SECRET'),
            ],
        ],
    ],

    'default' => env('TELEGRAM_DRIVER', 'bot'),

    'debug' => env('TELEGRAM_DEBUG', false),

    'retry' => [
        'attempts' => env('TELEGRAM_RETRY_ATTEMPTS', 3),
        'delay' => env('TELEGRAM_RETRY_DELAY', 60),
    ],

    'rate_limit' => [
        'enabled' => env('TELEGRAM_RATE_LIMIT_ENABLED', true),
        'max_attempts' => env('TELEGRAM_RATE_LIMIT_MAX_ATTEMPTS', 30),
        'decay_minutes' => env('TELEGRAM_RATE_LIMIT_DECAY_MINUTES', 1),
    ],
];
```

### 2.2 Environment Variables
```env

# Telegram Bot
TELEGRAM_BOT_TOKEN=your_bot_token
TELEGRAM_BOT_USERNAME=your_bot_username
TELEGRAM_API_ENDPOINT=https://api.telegram.org/bot{token}

# Telegram Webhook
TELEGRAM_WEBHOOK_ENABLED=false
TELEGRAM_WEBHOOK_URL=https://your-domain.com/api/telegram/webhook
TELEGRAM_WEBHOOK_SECRET=your_webhook_secret

# Global Telegram configuration
TELEGRAM_DRIVER=bot
TELEGRAM_DEBUG=false
TELEGRAM_RETRY_ATTEMPTS=3
TELEGRAM_RETRY_DELAY=60
TELEGRAM_RATE_LIMIT_ENABLED=true
TELEGRAM_RATE_LIMIT_MAX_ATTEMPTS=30
TELEGRAM_RATE_LIMIT_DECAY_MINUTES=1
```

## 3. Implementazione

### 3.1 Action Base
```php
<?php

namespace Modules\Notify\Actions\Telegram;

use Modules\Notify\Contracts\Telegram\TelegramActionInterface;
use Modules\Notify\Datas\TelegramMessageData;
use Spatie\QueueableAction\QueueableAction;

abstract class BaseTelegramAction implements TelegramActionInterface
{
    use QueueableAction;

    protected string $driver;
    protected array $config;
    protected bool $debug;
    protected int $timeout;

    public function __construct(string $driver = null)
    {
        $this->driver = $driver ?? config('notify.default');
        $this->config = config("notify.drivers.telegram.{$this->driver}");
        $this->debug = (bool) config('notify.debug', false);
        $this->timeout = (int) config('notify.timeout', 30);
    }

    abstract public function execute(TelegramMessageData $messageData): array;
}
```

### 3.2 Provider Specifici
```php
<?php

namespace Modules\Notify\Actions\Telegram;

use Modules\Notify\Datas\TelegramMessageData;

class BotTelegramAction extends BaseTelegramAction
{
    public function execute(TelegramMessageData $messageData): array
    {
        // Implementazione specifica per Bot API
    }
}

class WebhookTelegramAction extends BaseTelegramAction
{
    public function execute(TelegramMessageData $messageData): array
    {
        // Implementazione specifica per Webhook
    }
}
```

### 3.3 Canale di Notifica
```php
<?php

namespace Modules\Notify\Notifications\Channels;

use Illuminate\Notifications\Notification;
use Modules\Notify\Actions\Telegram\BotTelegramAction;
use Modules\Notify\Datas\TelegramMessageData;

class TelegramChannel
{
    /**
     * Invia la notifica tramite Telegram.
     *
     * @param mixed $notifiable
     * @param \Illuminate\Notifications\Notification $notification
     * @return void
     */
    public function send($notifiable, Notification $notification)
    {
        if (!method_exists($notification, 'toTelegram')) {
            throw new \Exception('Il metodo toTelegram() non è definito nella notifica.');
        }

        if (!method_exists($notifiable, 'routeNotificationForTelegram')) {
            throw new \Exception('Il metodo routeNotificationForTelegram() non è definito nel notifiable.');
        }

        $message = $notification->toTelegram($notifiable);
        $chatId = $notifiable->routeNotificationForTelegram();

        if (empty($chatId)) {
            throw new \Exception('Chat ID Telegram non trovato per il notifiable.');
        }

        $action = new BotTelegramAction();
        $result = $action->execute(new TelegramMessageData(
            chat_id: $chatId,
            text: $message
        ));

        if (!$result['success']) {
            throw new \Exception('Errore nell\'invio del messaggio Telegram: ' . ($result['error'] ?? 'Errore sconosciuto'));
        }
    }
}
```

### 3.4 Notifica Base
```php
<?php

namespace Modules\Notify\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Notification;
use Modules\Notify\Notifications\Channels\TelegramChannel;

class TelegramNotification extends Notification implements ShouldQueue
{
    use Queueable;

    /**
     * @var string
     */
    protected string $message;

    /**
     * @var array
     */
    protected array $options;

    /**
     * Create a new notification instance.
     *
     * @param string $message
     * @param array $options
     */
    public function __construct(string $message, array $options = [])
    {
        $this->message = $message;
        $this->options = $options;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param mixed $notifiable
     * @return array
     */
    public function via($notifiable): array
    {
        return [TelegramChannel::class];
    }

    /**
     * Get the Telegram representation of the notification.
     *
     * @param mixed $notifiable
     * @return string
     */
    public function toTelegram($notifiable): string
    {
        return $this->message;
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
     * Route notifications for the Telegram channel.
     *
     * @return string
     */
    public function routeNotificationForTelegram(): string
    {
        return $this->telegram_chat_id;
    }

    /**
     * Verifica se l'utente può ricevere Telegram
     *
     * @return bool
     */
    public function canReceiveTelegram(): bool
    {
        return !empty($this->telegram_chat_id) && $this->consent_telegram;
    }
}
```

### 4.2 Invio Notifica
```php
// Direttamente
$user->notify(new TelegramNotification('Il tuo codice OTP è: 123456'));

// Con Action
$action = new BotTelegramAction();
$result = $action->execute(new TelegramMessageData(
    chat_id: $user->telegram_chat_id,
    text: 'Il tuo codice OTP è: 123456'
));

// Con validazione
if ($user->canReceiveTelegram()) {
    $user->notify(new TelegramNotification('Il tuo codice OTP è: 123456'));
}
```

## 5. Best Practices

### 5.1 Validazione
- Validare sempre il chat_id
- Verificare la lunghezza del messaggio
- Controllare il formato del markup
- Validare i parametri dei comandi
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
- Proteggere i token del bot
- Implementare logging sicuro
- Gestire i timeout
- Implementare rate limiting per IP

## 6. Testing

### 6.1 Unit Test
```php
<?php

namespace Modules\Notify\Tests\Unit;

use Tests\TestCase;
use Modules\Notify\Actions\Telegram\BotTelegramAction;
use Modules\Notify\Datas\TelegramMessageData;
use Illuminate\Support\Facades\Http;

class TelegramTest extends TestCase
{
    public function test_telegram_sent_successfully()
    {
        Http::fake([
            'api.telegram.org/*' => Http::response([
                'ok' => true,
                'result' => [
                    'message_id' => 123,
                    'chat' => ['id' => 456]
                ]
            ], 200)
        ]);

        $action = new BotTelegramAction();
        $result = $action->execute(new TelegramMessageData(
            chat_id: '123456',
            text: 'Test message'
        ));

        $this->assertTrue($result['success']);
        $this->assertEquals(123, $result['message_id']);
    }
}
```

## 7. Collegamenti Utili

- [Telegram Bot API](https://core.telegram.org/bots/api)
- [Telegram Webhook API](https://core.telegram.org/bots/api#setwebhook)
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
