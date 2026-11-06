---
qmd: "telegram consolidated"
issues: []
discussions: []
title: "telegram: Consolidated Documentation"
module: notify
type: integration
tags: [integrations, modules, notify]
created: 2026-08-24
updated: 2026-08-24
status: draft
---

# telegram: Consolidated Documentation

Consolidated from **13** individual files.

## Table of Contents

- [Implementazione Canale Telegram](#telegram-channel-1)
- [---](#telegram-channel-2)
- [Implementazione Canale Telegram](#telegram-channel)
- [Integrazione Telegram](#telegram-integration-1)
- [---](#telegram-integration-2)
- [Integrazione Telegram ](#telegram-integration)
- [---](#telegram-sending-standard-1)
- [Standard per Invio Messaggi Telegram nel Modulo Notify](#telegram-sending-standard)
- [Telegram/WhatsApp provider action interface compliance fix](#telegram-whatsapp-provider-interface-compliance-fix)
- [https://dev.to/millykhamroev/laravel-package-to-integrate-telegram-bot-api-3l6e](#telegram)
- [Implementazione Canale Telegram](#telegram_channel)
- [<<<<<<< HEAD](#telegram_integration)
- [Standard per Invio Messaggi Telegram nel Modulo Notify](#telegram_sending_standard)

---

## telegram-channel-1

*Consolidated from: `telegram-channel.md`*


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
- [Laravel Cache](https://laravel.com/docs/cache)
- [Laravel Cache](https://laravel.com/docs/cache)
- [Laravel Cache](https://laravel.com/docs/cache)
- [Laravel Cache](https://laravel.com/docs/cache)
- [Laravel Cache](https://laravel.com/docs/cache)
- [Laravel Cache](https://laravel.com/docs/cache)
- [Laravel Cache](https://laravel.com/docs/cache)
- [Laravel Cache](https://laravel.com/docs/cache)
- [Laravel Cache](https://laravel.com/docs/cache)
- [Laravel Cache](https://laravel.com/docs/cache)
- [Laravel Cache](https://laravel.com/docs/cache)
- [Laravel Cache](https://laravel.com/docs/cache)
- [Laravel Cache](https://laravel.com/docs/cache)
- [Laravel Cache](https://laravel.com/docs/cache)
- [Laravel Cache](https://laravel.com/docs/cache)
- [Laravel Cache](https://laravel.com/docs/cache)
- [Laravel Cache](https://laravel.com/docs/cache)
- [Laravel Cache](https://laravel.com/docs/cache)
- [Laravel Cache](https://laravel.com/docs/cache)
- [Laravel Cache](https://laravel.com/docs/cache)
- [Laravel Cache](https://laravel.com/docs/cache)
- [Laravel Cache](https://laravel.com/docs/cache)
- [Laravel Cache](https://laravel.com/docs/cache)
- [Laravel Cache](https://laravel.com/docs/cache)
- [Laravel Cache](https://laravel.com/docs/cache)
- [Laravel Cache](https://laravel.com/docs/cache)
- [Laravel Cache](https://laravel.com/docs/cache)
- [Laravel Cache](https://laravel.com/docs/cache)
- [Laravel Cache](https://laravel.com/docs/cache)
- [Laravel Cache](https://laravel.com/docs/cache)
- [Laravel Cache](https://laravel.com/docs/cache)
- [Laravel Cache](https://laravel.com/docs/cache)
- [Laravel Cache](https://laravel.com/docs/cache)
- [Laravel Cache](https://laravel.com/docs/cache)
- [Laravel Cache](https://laravel.com/docs/cache)
- [Laravel Cache](https://laravel.com/docs/cache)
- [Laravel Cache](https://laravel.com/docs/cache)
- [Laravel Cache](https://laravel.com/docs/cache)
- [Laravel Cache](https://laravel.com/docs/cache)
- [Laravel Cache](https://laravel.com/docs/cache)
- [Laravel Cache](https://laravel.com/docs/cache)
- [Laravel Cache](https://laravel.com/docs/cache)
- [Laravel Cache](https://laravel.com/docs/cache)
- [Laravel Cache](https://laravel.com/docs/cache)
- [Laravel Cache](https://laravel.com/docs/cache)
- [Laravel Cache](https://laravel.com/docs/cache)
- [Laravel Cache](https://laravel.com/docs/cache)
- [Laravel Cache](https://laravel.com/docs/cache)
- [Laravel Cache](https://laravel.com/docs/cache)
- [Laravel Cache](https://laravel.com/docs/cache)
- [Laravel Cache](https://laravel.com/docs/cache)
- [Laravel Cache](https://laravel.com/docs/cache)
- [Laravel Cache](https://laravel.com/docs/cache)
- [Laravel Cache](https://laravel.com/docs/cache)
- [Laravel Cache](https://laravel.com/docs/cache)
- [Laravel Cache](https://laravel.com/docs/cache)
- [Laravel Cache](https://laravel.com/docs/cache)
- [Laravel Cache](https://laravel.com/docs/cache)
- [Laravel Cache](https://laravel.com/docs/cache)
- [Laravel Cache](https://laravel.com/docs/cache)
- [Laravel Cache](https://laravel.com/docs/cache)
- [Laravel Cache](https://laravel.com/docs/cache)
- [Laravel Cache](https://laravel.com/docs/cache)
- [Laravel Cache](https://laravel.com/docs/cache)
- [Laravel Cache](https://laravel.com/docs/cache)
- [Laravel Cache](https://laravel.com/docs/cache)
- [Laravel Cache](https://laravel.com/docs/cache)
- [Laravel Cache](https://laravel.com/docs/cache)
- [Laravel Cache](https://laravel.com/docs/cache)
- [Laravel Cache](https://laravel.com/docs/cache)
- [Laravel Cache](https://laravel.com/docs/cache)
- [Laravel Cache](https://laravel.com/docs/cache)
- [Laravel Cache](https://laravel.com/docs/cache)
- [Laravel Cache](https://laravel.com/docs/cache)
- [Laravel Cache](https://laravel.com/docs/cache)
- [Laravel Cache](https://laravel.com/docs/cache)
- [Laravel Cache](https://laravel.com/docs/cache)
- [Laravel Cache](https://laravel.com/docs/cache)
- [Laravel Cache](https://laravel.com/docs/cache)
- [Laravel Cache](https://laravel.com/docs/cache)
- [Laravel Cache](https://laravel.com/docs/cache)
- [Laravel Cache](https://laravel.com/docs/cache)
- [Laravel Cache](https://laravel.com/docs/cache)
- [Laravel Cache](https://laravel.com/docs/cache)
- [Laravel Cache](https://laravel.com/docs/cache)

---

## telegram-channel-2

*Consolidated from: `telegram-channel.md`*

title: "Implementazione Canale Telegram"
type: concept
tags: [telegram, channel]
created: 2026-07-14
updated: 2026-07-14
qmd: "telegram-channel-2 implementazione canale telegram"
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

---

## telegram-channel

*Consolidated from: `telegram-channel.md`*


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

---

## telegram-integration-1

*Consolidated from: `telegram-integration.md`*


Questo documento descrive l'architettura e l'implementazione dell'integrazione Telegram nel progetto <nome progetto>, seguendo gli stessi pattern di design utilizzati per SMS, Email e WhatsApp.

## Architettura

L'integrazione Telegram segue un'architettura modulare e standardizzata:

1. **Interfaccia comune**: Tutti i provider Telegram implementano la stessa interfaccia
2. **DTO standardizzato**: I dati dei messaggi sono gestiti tramite un Data Transfer Object tipizzato
3. **Configurazione centralizzata**: Impostazioni gestite tramite file di configurazione dedicato
4. **Implementazioni specifiche per provider**: Ogni driver ha una propria implementazione
5. **Canale di notifica Laravel**: Integrazione con il sistema di notifiche di Laravel

## Interfaccia

L'interfaccia `TelegramProviderActionInterface` definisce il contratto che tutte le implementazioni di provider Telegram devono rispettare:

```php
interface TelegramProviderActionInterface
{
    public function execute(TelegramData $telegramData): array;
}
```

## Data Transfer Object

Il DTO `TelegramData` standardizza i dati necessari per l'invio di messaggi Telegram:

```php
class TelegramData extends Data
{
    public function __construct(
        public string $chatId,
        public string $text,
        public ?string $parseMode = null,
        public bool $disableWebPagePreview = false,
        public bool $disableNotification = false,
        public ?int $replyToMessageId = null,
        public ?array $replyMarkup = null,
        public ?array $media = null,
        public string $type = 'text',
    ) {}
}
```

## Configurazione

Il file `config/telegram.php` contiene tutte le impostazioni per i diversi provider Telegram:

```php
return [
    'default' => env('TELEGRAM_DRIVER', 'official'),

    'drivers' => [
        'official' => [
            'token' => env('TELEGRAM_BOT_TOKEN'),
            'api_url' => env('TELEGRAM_API_URL', 'https://api.telegram.org'),
        ],
        'botman' => [
            // configurazione...
        ],
        'nutgram' => [
            // configurazione...
        ],
    ],

    // altre configurazioni...
];
```

## Implementazioni

Per ogni driver configurato esiste una corrispondente implementazione:

1. **SendOfficialTelegramAction**: Utilizza l'API ufficiale di Telegram
2. **SendBotmanTelegramAction**: Utilizza BotMan per l'invio di messaggi
3. **SendNutgramTelegramAction**: Utilizza Nutgram per l'invio di messaggi

Ogni implementazione segue lo stesso pattern:
- Implementa l'interfaccia `TelegramProviderActionInterface`
- Accetta un oggetto `TelegramData` come parametro
- Restituisce un array con il risultato dell'operazione

## Canale di Notifica

Il canale `TelegramChannel` integra le azioni Telegram con il sistema di notifiche di Laravel:

```php
class TelegramChannel
{
    public function send($notifiable, Notification $notification)
    {
        $telegramData = $notification->toTelegram($notifiable);
        $driver = Config::get('telegram.default', 'official');

        $action = match ($driver) {
            'official' => app(SendOfficialTelegramAction::class),
            'botman' => app(SendBotmanTelegramAction::class),
            'nutgram' => app(SendNutgramTelegramAction::class),
            default => throw new Exception("Unsupported Telegram driver: {$driver}"),
        };

        return $action->execute($telegramData);
    }
}
```

## Utilizzo

### Invio Diretto

```php
use Modules\Notify\Actions\Telegram\SendOfficialTelegramAction;
use Modules\Notify\Datas\TelegramData;

$telegramData = new TelegramData(
    chatId: '123456789',
    text: 'Messaggio di test',
    parseMode: 'HTML',
);

$action = app(SendOfficialTelegramAction::class);
$result = $action->execute($telegramData);
```

### Tramite Notifica Laravel

```php
use Illuminate\Notifications\Notification;
use Modules\Notify\Channels\TelegramChannel;
use Modules\Notify\Datas\TelegramData;

class AppointmentReminder extends Notification
{
    public function via($notifiable)
    {
        return [TelegramChannel::class];
    }

    public function toTelegram($notifiable)
    {
        return new TelegramData(
            chatId: $notifiable->telegram_chat_id,
            text: "Promemoria: hai un appuntamento domani alle 15:00",
            parseMode: 'HTML',
        );
    }
}
```

## Regole di Implementazione

1. **Interfaccia comune**: Tutte le azioni devono implementare `TelegramProviderActionInterface`
2. **DTO standardizzato**: Utilizzare sempre `TelegramData` per i dati dei messaggi
3. **Corrispondenza driver-azione**: Per ogni driver in `config/telegram.php` deve esistere una corrispondente azione
4. **Naming convention**: Le azioni devono seguire il pattern `Send{DriverName}TelegramAction`
5. **Gestione errori**: Tutte le azioni devono gestire correttamente gli errori e registrarli nei log

## Variabili d'Ambiente

```
TELEGRAM_DRIVER=official
TELEGRAM_BOT_TOKEN=your_bot_token
TELEGRAM_API_URL=https://api.telegram.org
TELEGRAM_WEBHOOK_URL=https://your-domain.com/webhook/telegram
TELEGRAM_POLLING=false
TELEGRAM_DEBUG=false
TELEGRAM_PARSE_MODE=HTML
```

## Considerazioni sulla Sicurezza

1. **Token del bot**: Conservare sempre il token del bot in variabili d'ambiente, mai nel codice
2. **Rate limiting**: Utilizzare il rate limiting per prevenire abusi
3. **Validazione input**: Validare sempre i dati in ingresso prima dell'invio
4. **Logging**: Registrare tutte le operazioni critiche nei log, ma evitare di loggare dati sensibili

---

## telegram-integration-2

*Consolidated from: `telegram-integration.md`*

title: "Integrazione Telegram"
type: concept
tags: [telegram, integration]
created: 2026-07-14
updated: 2026-07-14
qmd: "telegram-integration-2 integrazione telegram"
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

# Integrazione Telegram 

Questo documento descrive l'architettura e l'implementazione dell'integrazione Telegram nel progetto App, seguendo gli stessi pattern di design utilizzati per SMS, Email e WhatsApp.

## Architettura

L'integrazione Telegram segue un'architettura modulare e standardizzata:

1. **Interfaccia comune**: Tutti i provider Telegram implementano la stessa interfaccia
2. **DTO standardizzato**: I dati dei messaggi sono gestiti tramite un Data Transfer Object tipizzato
3. **Configurazione centralizzata**: Impostazioni gestite tramite file di configurazione dedicato
4. **Implementazioni specifiche per provider**: Ogni driver ha una propria implementazione
5. **Canale di notifica Laravel**: Integrazione con il sistema di notifiche di Laravel

## Interfaccia

L'interfaccia `TelegramProviderActionInterface` definisce il contratto che tutte le implementazioni di provider Telegram devono rispettare:

```php
interface TelegramProviderActionInterface
{
    public function execute(TelegramData $telegramData): array;
}
```

## Data Transfer Object

Il DTO `TelegramData` standardizza i dati necessari per l'invio di messaggi Telegram:

```php
class TelegramData extends Data
{
    public function __construct(
        public string $chatId,
        public string $text,
        public ?string $parseMode = null,
        public bool $disableWebPagePreview = false,
        public bool $disableNotification = false,
        public ?int $replyToMessageId = null,
        public ?array $replyMarkup = null,
        public ?array $media = null,
        public string $type = 'text',
    ) {}
}
```

## Configurazione

Il file `config/telegram.php` contiene tutte le impostazioni per i diversi provider Telegram:

```php
return [
    'default' => env('TELEGRAM_DRIVER', 'official'),
    
    'drivers' => [
        'official' => [
            'token' => env('TELEGRAM_BOT_TOKEN'),
            'api_url' => env('TELEGRAM_API_URL', 'https://api.telegram.org'),
        ],
        'botman' => [
            // configurazione...
        ],
        'nutgram' => [
            // configurazione...
        ],
    ],
    
    // altre configurazioni...
];
```

## Implementazioni

Per ogni driver configurato esiste una corrispondente implementazione:

1. **SendOfficialTelegramAction**: Utilizza l'API ufficiale di Telegram
2. **SendBotmanTelegramAction**: Utilizza BotMan per l'invio di messaggi
3. **SendNutgramTelegramAction**: Utilizza Nutgram per l'invio di messaggi

Ogni implementazione segue lo stesso pattern:
- Implementa l'interfaccia `TelegramProviderActionInterface`
- Accetta un oggetto `TelegramData` come parametro
- Restituisce un array con il risultato dell'operazione

## Canale di Notifica

Il canale `TelegramChannel` integra le azioni Telegram con il sistema di notifiche di Laravel:

```php
class TelegramChannel
{
    public function send($notifiable, Notification $notification)
    {
        $telegramData = $notification->toTelegram($notifiable);
        $driver = Config::get('telegram.default', 'official');
        
        $action = match ($driver) {
            'official' => app(SendOfficialTelegramAction::class),
            'botman' => app(SendBotmanTelegramAction::class),
            'nutgram' => app(SendNutgramTelegramAction::class),
            default => throw new Exception("Unsupported Telegram driver: {$driver}"),
        };
        
        return $action->execute($telegramData);
    }
}
```

## Utilizzo

### Invio Diretto

```php
use Modules\Notify\Actions\Telegram\SendOfficialTelegramAction;
use Modules\Notify\Datas\TelegramData;

$telegramData = new TelegramData(
    chatId: '123456789',
    text: 'Messaggio di test',
    parseMode: 'HTML',
);

$action = app(SendOfficialTelegramAction::class);
$result = $action->execute($telegramData);
```

### Tramite Notifica Laravel

```php
use Illuminate\Notifications\Notification;
use Modules\Notify\Channels\TelegramChannel;
use Modules\Notify\Datas\TelegramData;

class AppointmentReminder extends Notification
{
    public function via($notifiable)
    {
        return [TelegramChannel::class];
    }
    
    public function toTelegram($notifiable)
    {
        return new TelegramData(
            chatId: $notifiable->telegram_chat_id,
            text: "Promemoria: hai un appuntamento domani alle 15:00",
            parseMode: 'HTML',
        );
    }
}
```

## Regole di Implementazione

1. **Interfaccia comune**: Tutte le azioni devono implementare `TelegramProviderActionInterface`
2. **DTO standardizzato**: Utilizzare sempre `TelegramData` per i dati dei messaggi
3. **Corrispondenza driver-azione**: Per ogni driver in `config/telegram.php` deve esistere una corrispondente azione
4. **Naming convention**: Le azioni devono seguire il pattern `Send{DriverName}TelegramAction`
5. **Gestione errori**: Tutte le azioni devono gestire correttamente gli errori e registrarli nei log

## Variabili d'Ambiente

```
TELEGRAM_DRIVER=official
TELEGRAM_BOT_TOKEN=your_bot_token
TELEGRAM_API_URL=https://api.telegram.org
TELEGRAM_WEBHOOK_URL=https://your-domain.com/webhook/telegram
TELEGRAM_POLLING=false
TELEGRAM_DEBUG=false
TELEGRAM_PARSE_MODE=HTML
```

## Considerazioni sulla Sicurezza

1. **Token del bot**: Conservare sempre il token del bot in variabili d'ambiente, mai nel codice
2. **Rate limiting**: Utilizzare il rate limiting per prevenire abusi
3. **Validazione input**: Validare sempre i dati in ingresso prima dell'invio
4. **Logging**: Registrare tutte le operazioni critiche nei log, ma evitare di loggare dati sensibili
---

## telegram-integration

*Consolidated from: `telegram-integration.md`*


Questo documento descrive l'architettura e l'implementazione dell'integrazione Telegram nel progetto , seguendo gli stessi pattern di design utilizzati per SMS, Email e WhatsApp.
Questo documento descrive l'architettura e l'implementazione dell'integrazione Telegram nel progetto <nome progetto>, seguendo gli stessi pattern di design utilizzati per SMS, Email e WhatsApp.

## Architettura

L'integrazione Telegram segue un'architettura modulare e standardizzata:

1. **Interfaccia comune**: Tutti i provider Telegram implementano la stessa interfaccia
2. **DTO standardizzato**: I dati dei messaggi sono gestiti tramite un Data Transfer Object tipizzato
3. **Configurazione centralizzata**: Impostazioni gestite tramite file di configurazione dedicato
4. **Implementazioni specifiche per provider**: Ogni driver ha una propria implementazione
5. **Canale di notifica Laravel**: Integrazione con il sistema di notifiche di Laravel

## Interfaccia

L'interfaccia `TelegramProviderActionInterface` definisce il contratto che tutte le implementazioni di provider Telegram devono rispettare:

```php
interface TelegramProviderActionInterface
{
    public function execute(TelegramData $telegramData): array;
}
```

## Data Transfer Object

Il DTO `TelegramData` standardizza i dati necessari per l'invio di messaggi Telegram:

```php
class TelegramData extends Data
{
    public function __construct(
        public string $chatId,
        public string $text,
        public ?string $parseMode = null,
        public bool $disableWebPagePreview = false,
        public bool $disableNotification = false,
        public ?int $replyToMessageId = null,
        public ?array $replyMarkup = null,
        public ?array $media = null,
        public string $type = 'text',
    ) {}
}
```

## Configurazione

Il file `config/telegram.php` contiene tutte le impostazioni per i diversi provider Telegram:

```php
return [
    'default' => env('TELEGRAM_DRIVER', 'official'),
    
    'drivers' => [
        'official' => [
            'token' => env('TELEGRAM_BOT_TOKEN'),
            'api_url' => env('TELEGRAM_API_URL', 'https://api.telegram.org'),
        ],
        'botman' => [
            // configurazione...
        ],
        'nutgram' => [
            // configurazione...
        ],
    ],
    
    // altre configurazioni...
];
```

## Implementazioni

Per ogni driver configurato esiste una corrispondente implementazione:

1. **SendOfficialTelegramAction**: Utilizza l'API ufficiale di Telegram
2. **SendBotmanTelegramAction**: Utilizza BotMan per l'invio di messaggi
3. **SendNutgramTelegramAction**: Utilizza Nutgram per l'invio di messaggi

Ogni implementazione segue lo stesso pattern:
- Implementa l'interfaccia `TelegramProviderActionInterface`
- Accetta un oggetto `TelegramData` come parametro
- Restituisce un array con il risultato dell'operazione

## Canale di Notifica

Il canale `TelegramChannel` integra le azioni Telegram con il sistema di notifiche di Laravel:

```php
class TelegramChannel
{
    public function send($notifiable, Notification $notification)
    {
        $telegramData = $notification->toTelegram($notifiable);
        $driver = Config::get('telegram.default', 'official');
        
        $action = match ($driver) {
            'official' => app(SendOfficialTelegramAction::class),
            'botman' => app(SendBotmanTelegramAction::class),
            'nutgram' => app(SendNutgramTelegramAction::class),
            default => throw new Exception("Unsupported Telegram driver: {$driver}"),
        };
        
        return $action->execute($telegramData);
    }
}
```

## Utilizzo

### Invio Diretto

```php
use Modules\Notify\Actions\Telegram\SendOfficialTelegramAction;
use Modules\Notify\Datas\TelegramData;

$telegramData = new TelegramData(
    chatId: '123456789',
    text: 'Messaggio di test',
    parseMode: 'HTML',
);

$action = app(SendOfficialTelegramAction::class);
$result = $action->execute($telegramData);
```

### Tramite Notifica Laravel

```php
use Illuminate\Notifications\Notification;
use Modules\Notify\Channels\TelegramChannel;
use Modules\Notify\Datas\TelegramData;

class AppointmentReminder extends Notification
{
    public function via($notifiable)
    {
        return [TelegramChannel::class];
    }
    
    public function toTelegram($notifiable)
    {
        return new TelegramData(
            chatId: $notifiable->telegram_chat_id,
            text: "Promemoria: hai un appuntamento domani alle 15:00",
            parseMode: 'HTML',
        );
    }
}
```

## Regole di Implementazione

1. **Interfaccia comune**: Tutte le azioni devono implementare `TelegramProviderActionInterface`
2. **DTO standardizzato**: Utilizzare sempre `TelegramData` per i dati dei messaggi
3. **Corrispondenza driver-azione**: Per ogni driver in `config/telegram.php` deve esistere una corrispondente azione
4. **Naming convention**: Le azioni devono seguire il pattern `Send{DriverName}TelegramAction`
5. **Gestione errori**: Tutte le azioni devono gestire correttamente gli errori e registrarli nei log

## Variabili d'Ambiente

```
TELEGRAM_DRIVER=official
TELEGRAM_BOT_TOKEN=your_bot_token
TELEGRAM_API_URL=https://api.telegram.org
TELEGRAM_WEBHOOK_URL=https://your-domain.com/webhook/telegram
TELEGRAM_POLLING=false
TELEGRAM_DEBUG=false
TELEGRAM_PARSE_MODE=HTML
```

## Considerazioni sulla Sicurezza

1. **Token del bot**: Conservare sempre il token del bot in variabili d'ambiente, mai nel codice
2. **Rate limiting**: Utilizzare il rate limiting per prevenire abusi
3. **Validazione input**: Validare sempre i dati in ingresso prima dell'invio
4. **Logging**: Registrare tutte le operazioni critiche nei log, ma evitare di loggare dati sensibili

---

## telegram-sending-standard-1

*Consolidated from: `telegram-sending-standard.md`*

title: "Standard per Invio Messaggi Telegram nel Modulo Notify"
type: rule
tags: [telegram, sending, standard]
created: 2026-07-14
updated: 2026-07-14
qmd: "telegram-sending-standard-1 standard per invio messaggi telegram nel modulo notify"
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

# Standard per Invio Messaggi Telegram nel Modulo Notify

## Introduzione
Questa guida definisce lo standard per l'invio di messaggi Telegram all'interno del modulo Notify, seguendo la stessa architettura modulare, configurazione e best practice già adottate per email, SMS e WhatsApp. L'obiettivo è garantire coerenza, riusabilità e facilità di manutenzione, indipendentemente dal provider utilizzato (Bot API ufficiale, pacchetti community, ecc.).

---

## 1. Struttura delle Azioni Telegram

- Ogni provider Telegram deve avere una propria action in `app/Actions/Telegram`.
- Tutte le azioni devono implementare una interfaccia comune, ad esempio `TelegramActionInterface` (da posizionare in `app/Contracts`).
- Le azioni devono accettare un DTO standardizzato (es. `TelegramMessageData` in `app/Datas`).
- La naming convention è: `Send<Provider>TelegramAction.php` (es. `SendBotApiTelegramAction.php`).

**Esempio di interfaccia:**
```php
namespace Modules\Notify\Contracts;

use Modules\Notify\Datas\TelegramMessageData;

interface TelegramActionInterface
{
    /**
     * Invia un messaggio Telegram tramite provider specifico.
     * @param TelegramMessageData $data
     * @return array
     */
    public function execute(TelegramMessageData $data): array;
}
```

---

## 2. Configurazione

- Tutti i provider Telegram vanno configurati in `config/telegram.php` (o in una sezione dedicata di `config/services.php` o `config/notify.php`).
- I parametri generici (retry, rate_limit, timeout, circuit_breaker, debug) devono essere globali e non duplicati nei singoli driver.
- I parametri specifici del provider (es. bot_token, chat_id, endpoint) vanno nella sezione del driver.

**Esempio di configurazione:**
```php
return [
    'default' => env('TELEGRAM_DRIVER', 'botapi'),
    'drivers' => [
        'botapi' => [
            'bot_token' => env('TELEGRAM_BOT_TOKEN'),
            'default_chat_id' => env('TELEGRAM_DEFAULT_CHAT_ID'),
        ],
        // ... altri provider
    ],
    'debug' => env('TELEGRAM_DEBUG', false),
    'retry' => [
        'attempts' => env('TELEGRAM_RETRY_ATTEMPTS', 3),
        'delay' => env('TELEGRAM_RETRY_DELAY', 60),
    ],
    'rate_limit' => [
        'enabled' => env('TELEGRAM_RATE_LIMIT_ENABLED', true),
        'max_attempts' => env('TELEGRAM_RATE_LIMIT_MAX_ATTEMPTS', 60),
        'decay_minutes' => env('TELEGRAM_RATE_LIMIT_DECAY_MINUTES', 1),
    ],
    'timeout' => env('TELEGRAM_TIMEOUT', 30),
];
```

---

## 3. DTO Standardizzato

- I dati del messaggio Telegram devono essere incapsulati in un DTO in `app/Datas/TelegramMessageData.php`.
- Utilizzare `spatie/laravel-data` per la validazione e la tipizzazione.

**Esempio:**
```php
namespace Modules\Notify\Datas;

use Spatie\LaravelData\Data;

class TelegramMessageData extends Data
{
    public string $chat_id;
    public string $text;
    public ?array $options = null; // opzionale, per markup, media, ecc.
}
```

---

## 4. Esempio di Implementazione di una Action

```php
namespace Modules\Notify\Actions\Telegram;

use Exception;
use GuzzleHttp\Client;
use Modules\Notify\Contracts\TelegramActionInterface;
use Modules\Notify\Datas\TelegramMessageData;
use Spatie\QueueableAction\QueueableAction;

final class SendBotApiTelegramAction implements TelegramActionInterface
{
    use QueueableAction;

    public function execute(TelegramMessageData $data): array
    {
        $client = new Client();
        $botToken = config('telegram.drivers.botapi.bot_token');
        $endpoint = 'https://api.telegram.org/bot' . $botToken . '/sendMessage';

        $body = [
            'chat_id' => $data->chat_id,
            'text' => $data->text,
        ];
        if ($data->options) {
            $body = array_merge($body, $data->options);
        }

        try {
            $response = $client->post($endpoint, [
                'json' => $body,
            ]);
            return [
                'status_code' => $response->getStatusCode(),
                'body' => $response->getBody()->getContents(),
            ];
        } catch (Exception $e) {
            throw new Exception('Errore invio Telegram: ' . $e->getMessage(), $e->getCode(), $e);
        }
    }
}
```

---

## 5. Utilizzo e Queue

**Invio sincrono:**
```php
use Modules\Notify\Datas\TelegramMessageData;
use Modules\Notify\Actions\Telegram\SendBotApiTelegramAction;

$data = new TelegramMessageData(
    chat_id: '123456789',
    text: 'Messaggio di test'
);

$action = new SendBotApiTelegramAction();
$result = $action->execute($data);
```

**Invio asincrono (in coda):**
```php
$action->onQueue('telegram')->execute($data);
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

- [Telegram Bot API](https://core.telegram.org/bots/api)
- [irazasyed/telegram-bot-sdk](https://github.com/irazasyed/telegram-bot-sdk)
- [spatie/laravel-queueable-action](https://github.com/spatie/laravel-queueable-action)
- [Esempi community](https://laracasts.com/discuss/channels/laravel/telegram-bot-integration)
- [Altri pacchetti open source](https://github.com/telegram-bot-sdk/telegram-bot-sdk), [sycho/laravel-telegram-notifications](https://github.com/sycho/laravel-telegram-notifications)

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

- Aggiornare sempre le regole interne, la documentazione e le memorie ogni volta che si aggiunge o modifica un provider Telegram.
- Non ripetere mai errori di path, naming, duplicazione parametri o riferimenti a progetti specifici.

---

**Seguendo questo standard, l'invio di messaggi Telegram sarà sempre coerente, sicuro, testabile e facilmente estendibile.** 

---

## telegram-sending-standard

*Consolidated from: `telegram-sending-standard.md`*


## Introduzione
Questa guida definisce lo standard per l'invio di messaggi Telegram all'interno del modulo Notify, seguendo la stessa architettura modulare, configurazione e best practice già adottate per email, SMS e WhatsApp. L'obiettivo è garantire coerenza, riusabilità e facilità di manutenzione, indipendentemente dal provider utilizzato (Bot API ufficiale, pacchetti community, ecc.).

---

## 1. Struttura delle Azioni Telegram

- Ogni provider Telegram deve avere una propria action in `app/Actions/Telegram`.
- Tutte le azioni devono implementare una interfaccia comune, ad esempio `TelegramActionInterface` (da posizionare in `app/Contracts`).
- Le azioni devono accettare un DTO standardizzato (es. `TelegramMessageData` in `app/Datas`).
- La naming convention è: `Send<Provider>TelegramAction.php` (es. `SendBotApiTelegramAction.php`).

**Esempio di interfaccia:**
```php
namespace Modules\Notify\Contracts;

use Modules\Notify\Datas\TelegramMessageData;

interface TelegramActionInterface
{
    /**
     * Invia un messaggio Telegram tramite provider specifico.
     * @param TelegramMessageData $data
     * @return array
     */
    public function execute(TelegramMessageData $data): array;
}
```

---

## 2. Configurazione

- Tutti i provider Telegram vanno configurati in `config/telegram.php` (o in una sezione dedicata di `config/services.php` o `config/notify.php`).
- I parametri generici (retry, rate_limit, timeout, circuit_breaker, debug) devono essere globali e non duplicati nei singoli driver.
- I parametri specifici del provider (es. bot_token, chat_id, endpoint) vanno nella sezione del driver.

**Esempio di configurazione:**
```php
return [
    'default' => env('TELEGRAM_DRIVER', 'botapi'),
    'drivers' => [
        'botapi' => [
            'bot_token' => env('TELEGRAM_BOT_TOKEN'),
            'default_chat_id' => env('TELEGRAM_DEFAULT_CHAT_ID'),
        ],
        // ... altri provider
    ],
    'debug' => env('TELEGRAM_DEBUG', false),
    'retry' => [
        'attempts' => env('TELEGRAM_RETRY_ATTEMPTS', 3),
        'delay' => env('TELEGRAM_RETRY_DELAY', 60),
    ],
    'rate_limit' => [
        'enabled' => env('TELEGRAM_RATE_LIMIT_ENABLED', true),
        'max_attempts' => env('TELEGRAM_RATE_LIMIT_MAX_ATTEMPTS', 60),
        'decay_minutes' => env('TELEGRAM_RATE_LIMIT_DECAY_MINUTES', 1),
    ],
    'timeout' => env('TELEGRAM_TIMEOUT', 30),
];
```

---

## 3. DTO Standardizzato

- I dati del messaggio Telegram devono essere incapsulati in un DTO in `app/Datas/TelegramMessageData.php`.
- Utilizzare `spatie/laravel-data` per la validazione e la tipizzazione.

**Esempio:**
```php
namespace Modules\Notify\Datas;

use Spatie\LaravelData\Data;

class TelegramMessageData extends Data
{
    public string $chat_id;
    public string $text;
    public ?array $options = null; // opzionale, per markup, media, ecc.
}
```

---

## 4. Esempio di Implementazione di una Action

```php
namespace Modules\Notify\Actions\Telegram;

use Exception;
use GuzzleHttp\Client;
use Modules\Notify\Contracts\TelegramActionInterface;
use Modules\Notify\Datas\TelegramMessageData;
use Spatie\QueueableAction\QueueableAction;

final class SendBotApiTelegramAction implements TelegramActionInterface
{
    use QueueableAction;

    public function execute(TelegramMessageData $data): array
    {
        $client = new Client();
        $botToken = config('telegram.drivers.botapi.bot_token');
        $endpoint = 'https://api.telegram.org/bot' . $botToken . '/sendMessage';

        $body = [
            'chat_id' => $data->chat_id,
            'text' => $data->text,
        ];
        if ($data->options) {
            $body = array_merge($body, $data->options);
        }

        try {
            $response = $client->post($endpoint, [
                'json' => $body,
            ]);
            return [
                'status_code' => $response->getStatusCode(),
                'body' => $response->getBody()->getContents(),
            ];
        } catch (Exception $e) {
            throw new Exception('Errore invio Telegram: ' . $e->getMessage(), $e->getCode(), $e);
        }
    }
}
```

---

## 5. Utilizzo e Queue

**Invio sincrono:**
```php
use Modules\Notify\Datas\TelegramMessageData;
use Modules\Notify\Actions\Telegram\SendBotApiTelegramAction;

$data = new TelegramMessageData(
    chat_id: '123456789',
    text: 'Messaggio di test'
);

$action = new SendBotApiTelegramAction();
$result = $action->execute($data);
```

**Invio asincrono (in coda):**
```php
$action->onQueue('telegram')->execute($data);
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

- [Telegram Bot API](https://core.telegram.org/bots/api)
- [irazasyed/telegram-bot-sdk](https://github.com/irazasyed/telegram-bot-sdk)
- [spatie/laravel-queueable-action](https://github.com/spatie/laravel-queueable-action)
- [Esempi community](https://laracasts.com/discuss/channels/laravel/telegram-bot-integration)
- [Altri pacchetti open source](https://github.com/telegram-bot-sdk/telegram-bot-sdk), [sycho/laravel-telegram-notifications](https://github.com/sycho/laravel-telegram-notifications)

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

- Aggiornare sempre le regole interne, la documentazione e le memorie ogni volta che si aggiunge o modifica un provider Telegram.
- Non ripetere mai errori di path, naming, duplicazione parametri o riferimenti a progetti specifici.

---

**Seguendo questo standard, l'invio di messaggi Telegram sarà sempre coerente, sicuro, testabile e facilmente estendibile.** 

---

## telegram-whatsapp-provider-interface-compliance-fix

*Consolidated from: `telegram-whatsapp-provider-interface-compliance-fix.md`*


## Summary

A codebase audit (ponytail-audit) found two related problems in the Telegram
and WhatsApp provider action layer of the Notify module. One was dead code,
the other was a real runtime bug. Both are fixed as of this document.

## Problem A: `SmsProviderContract` removed (dead interface)

`Modules/Notify/app/Contracts/SmsProviderContract.php` had zero usages
anywhere in the project besides its own declaration. SMS providers actually
implement `Modules\Notify\Contracts\SMS\SmsActionContract` instead (see
`Modules/Notify/app/Actions/SMS/`). The unused `SmsProviderContract` file has
been deleted. No other file referenced it, so this is a pure removal with no
behavior change.

## Problem B: provider actions not implementing their own interface (real bug)

`TelegramActionFactory::create()` and `WhatsAppActionFactory::create()` both
resolve a driver class name at runtime (for example
`Send{Driver}TelegramAction`) and then guard with:

```php
if (! is_subclass_of($className, TelegramProviderActionInterface::class)) {
    throw new Exception("Class {$className} does not implement TelegramProviderActionInterface.");
}
```

Before this fix, only **one** concrete action per channel actually declared
`implements` the corresponding interface:

- Telegram: only the default driver implicitly worked by luck of factory
  defaults; none of `SendOfficialTelegramAction`, `SendNutgramTelegramAction`,
  `SendBotmanTelegramAction` declared `implements
  TelegramProviderActionInterface`.
- WhatsApp: only `SendTwilioWhatsAppAction` declared `implements
  WhatsAppProviderActionInterface`. `SendVonageWhatsAppAction`,
  `Send360dialogWhatsAppAction`, and `SendFacebookWhatsAppAction` did not.

**Effect in production**: selecting any Telegram driver other than the
implicit default, or any WhatsApp driver other than Twilio (e.g. via
`config('telegram.default')` / `config('whatsapp.default')` or an explicit
`$driver` argument), caused `TelegramActionFactory::create()` /
`WhatsAppActionFactory::create()` to throw immediately, even though the
selected action class was otherwise fully functional and its `execute()`
method signature already matched the interface exactly (same parameter type,
same `array<string, mixed>` return type).

### Fix

Added the missing `implements` declaration (plus the corresponding `use`
import) to the six action classes below. No other code in these classes was
changed: the method bodies were already interface-compliant:

- `Modules/Notify/app/Actions/Telegram/SendOfficialTelegramAction.php`
- `Modules/Notify/app/Actions/Telegram/SendNutgramTelegramAction.php`
- `Modules/Notify/app/Actions/Telegram/SendBotmanTelegramAction.php`
- `Modules/Notify/app/Actions/WhatsApp/SendVonageWhatsAppAction.php`
- `Modules/Notify/app/Actions/WhatsApp/Send360dialogWhatsAppAction.php`
- `Modules/Notify/app/Actions/WhatsApp/SendFacebookWhatsAppAction.php`

`SendTwilioWhatsAppAction` already implemented `WhatsAppProviderActionInterface`
and was left untouched.

All six classes now implement their respective interface:

- `Modules\Notify\Contracts\TelegramProviderActionInterface`: requires
  `execute(TelegramData $telegramData): array`.
- `Modules\Notify\Contracts\WhatsAppProviderActionInterface`: requires
  `execute(WhatsAppData $whatsappData): array`. The concrete classes use the
  parameter name `$whatsAppData` (capital A); PHP does not require parameter
  names to match between an interface and its implementation, so this is not
  a conflict.

### Test updated

`Modules/Notify/tests/Unit/Factories/ActionFactoriesTest.php` had a test named
`'telegram action factory throws when selected class does not implement
interface'` that asserted `TelegramActionFactory->create('official')` threw
an exception: i.e. it encoded the bug as expected behavior. That test was
rewritten to `'telegram action factory creates official driver instance'`,
asserting the factory now returns a valid
`TelegramProviderActionInterface` instance, mirroring the existing WhatsApp
Twilio test.

## Verification performed

- `php -l` on all six modified files: no syntax errors.
- `./vendor/bin/phpstan analyse Modules/Notify` (single-process/`--debug`
  mode, to avoid an unrelated pre-existing parallel-worker crash in
  `Modules/Xot/app/Filament/Resources/Pages/XotBaseManageRelatedRecords.php`):
  no errors.
- `php tools/phpmd.phar` against `app/Contracts`, `app/Actions/Telegram`,
  `app/Actions/WhatsApp` (cleancode, codesize, design, unusedcode rulesets):
  only pre-existing complexity/style warnings already present on the
  untouched `SendTwilioWhatsAppAction`, i.e. nothing newly introduced by
  adding `implements`.
- `./vendor/bin/phpinsights analyse Modules/Notify`: no new architecture
  violations related to the interface changes.
- `./vendor/bin/pest` against the Notify Telegram/WhatsApp/Factories/Channels
  test files: 116 passing, 1 pre-existing unrelated failure in
  `NotificationsChannelsTest` (`TelegramChannel` calls `Log::debug()` but the
  test mocks `Log::shouldReceive('info')`): untouched by this fix, confirmed
  via `git log` to predate this change.
- No browser/Playwright/Puppeteer testing was performed: these are outbound
  HTTP actions calling external Telegram/WhatsApp APIs with no UI surface to
  drive.

## Related docs

- `Modules/Notify/docs/telegram_provider_architecture.md` and
  `Modules/Notify/docs/whatsapp-provider-architecture.md` describe an
  aspirational/example architecture (e.g. `SendBotTelegramAction`,
  `SendApiTelegramAction`) that does not match the actual driver class names
  in this codebase (`SendOfficialTelegramAction`, `SendNutgramTelegramAction`,
  `SendBotmanTelegramAction`, `SendVonageWhatsAppAction`,
  `Send360dialogWhatsAppAction`, `SendFacebookWhatsAppAction`,
  `SendTwilioWhatsAppAction`). This document intentionally describes the real
  , current implementation instead of duplicating or rewriting those files.

---

## telegram

*Consolidated from: `telegram.md`*


https://medium.com/modulr/send-telegram-notifications-with-laravel-9-342cc87b406


Add telegram service into config/service.php file.

# config/services.php

'telegram-bot-api' => [
    'token' => env('TELEGRAM_BOT_TOKEN', 'YOUR BOT TOKEN HERE')
],


--- TUTORIAL ---
https://abstractentropy.com/laravel-notifications-telegram-bot/

---

## telegram_channel

*Consolidated from: `telegram_channel.md`*


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

---

## telegram_integration

*Consolidated from: `telegram_integration.md`*

# Integrazione Telegram

Questo documento descrive l'architettura e l'implementazione dell'integrazione Telegram nel progetto <nome progetto>, seguendo gli stessi pattern di design utilizzati per SMS, Email e WhatsApp.
# Integrazione Telegram 

Questo documento descrive l'architettura e l'implementazione dell'integrazione Telegram nel progetto SaluteOra, seguendo gli stessi pattern di design utilizzati per SMS, Email e WhatsApp.

## Architettura

L'integrazione Telegram segue un'architettura modulare e standardizzata:

1. **Interfaccia comune**: Tutti i provider Telegram implementano la stessa interfaccia
2. **DTO standardizzato**: I dati dei messaggi sono gestiti tramite un Data Transfer Object tipizzato
3. **Configurazione centralizzata**: Impostazioni gestite tramite file di configurazione dedicato
4. **Implementazioni specifiche per provider**: Ogni driver ha una propria implementazione
5. **Canale di notifica Laravel**: Integrazione con il sistema di notifiche di Laravel

## Interfaccia

L'interfaccia `TelegramProviderActionInterface` definisce il contratto che tutte le implementazioni di provider Telegram devono rispettare:

```php
interface TelegramProviderActionInterface
{
    public function execute(TelegramData $telegramData): array;
}
```

## Data Transfer Object

Il DTO `TelegramData` standardizza i dati necessari per l'invio di messaggi Telegram:

```php
class TelegramData extends Data
{
    public function __construct(
        public string $chatId,
        public string $text,
        public ?string $parseMode = null,
        public bool $disableWebPagePreview = false,
        public bool $disableNotification = false,
        public ?int $replyToMessageId = null,
        public ?array $replyMarkup = null,
        public ?array $media = null,
        public string $type = 'text',
    ) {}
}
```

## Configurazione

Il file `config/telegram.php` contiene tutte le impostazioni per i diversi provider Telegram:

```php
return [
    'default' => env('TELEGRAM_DRIVER', 'official'),
    'drivers' => [
        'official' => [
            'token' => env('TELEGRAM_BOT_TOKEN'),
            'api_url' => env('TELEGRAM_API_URL', 'https://api.telegram.org'),
        ],
        'botman' => [
            // configurazione...
        ],
        'nutgram' => [
            // configurazione...
        ],
    ],
    // altre configurazioni...
];
```

## Implementazioni

Per ogni driver configurato esiste una corrispondente implementazione:

1. **SendOfficialTelegramAction**: Utilizza l'API ufficiale di Telegram
2. **SendBotmanTelegramAction**: Utilizza BotMan per l'invio di messaggi
3. **SendNutgramTelegramAction**: Utilizza Nutgram per l'invio di messaggi

Ogni implementazione segue lo stesso pattern:
- Implementa l'interfaccia `TelegramProviderActionInterface`
- Accetta un oggetto `TelegramData` come parametro
- Restituisce un array con il risultato dell'operazione

## Canale di Notifica

Il canale `TelegramChannel` integra le azioni Telegram con il sistema di notifiche di Laravel:

```php
class TelegramChannel
{
    public function send($notifiable, Notification $notification)
    {
        $telegramData = $notification->toTelegram($notifiable);
        $driver = Config::get('telegram.default', 'official');
        $action = match ($driver) {
            'official' => app(SendOfficialTelegramAction::class),
            'botman' => app(SendBotmanTelegramAction::class),
            'nutgram' => app(SendNutgramTelegramAction::class),
            default => throw new Exception("Unsupported Telegram driver: {$driver}"),
        };
        return $action->execute($telegramData);
    }
}
```

## Utilizzo

### Invio Diretto

```php
use Modules\Notify\Actions\Telegram\SendOfficialTelegramAction;
use Modules\Notify\Datas\TelegramData;

$telegramData = new TelegramData(
    chatId: '123456789',
    text: 'Messaggio di test',
    parseMode: 'HTML',
);

$action = app(SendOfficialTelegramAction::class);
$result = $action->execute($telegramData);
```

### Tramite Notifica Laravel

```php
use Illuminate\Notifications\Notification;
use Modules\Notify\Channels\TelegramChannel;
use Modules\Notify\Datas\TelegramData;

class AppointmentReminder extends Notification
{
    public function via($notifiable)
    {
        return [TelegramChannel::class];
    }
    public function toTelegram($notifiable)
    {
        return new TelegramData(
            chatId: $notifiable->telegram_chat_id,
            text: "Promemoria: hai un appuntamento domani alle 15:00",
            parseMode: 'HTML',
        );
    }
}
```

## Regole di Implementazione

1. **Interfaccia comune**: Tutte le azioni devono implementare `TelegramProviderActionInterface`
2. **DTO standardizzato**: Utilizzare sempre `TelegramData` per i dati dei messaggi
3. **Corrispondenza driver-azione**: Per ogni driver in `config/telegram.php` deve esistere una corrispondente azione
4. **Naming convention**: Le azioni devono seguire il pattern `Send{DriverName}TelegramAction`
5. **Gestione errori**: Tutte le azioni devono gestire correttamente gli errori e registrarli nei log

## Variabili d'Ambiente

```
TELEGRAM_DRIVER=official
TELEGRAM_BOT_TOKEN=your_bot_token
TELEGRAM_API_URL=https://api.telegram.org
TELEGRAM_WEBHOOK_URL=https://your-domain.com/webhook/telegram
TELEGRAM_POLLING=false
TELEGRAM_DEBUG=false
TELEGRAM_PARSE_MODE=HTML
```

## Considerazioni sulla Sicurezza

1. **Token del bot**: Conservare sempre il token del bot in variabili d'ambiente, mai nel codice
2. **Rate limiting**: Utilizzare il rate limiting per prevenire abusi
3. **Validazione input**: Validare sempre i dati in ingresso prima dell'invio
4. **Logging**: Registrare tutte le operazioni critiche nei log, ma evitare di loggare dati sensibili

---

## telegram_sending_standard

*Consolidated from: `telegram_sending_standard.md`*


## Introduzione
Questa guida definisce lo standard per l'invio di messaggi Telegram all'interno del modulo Notify, seguendo la stessa architettura modulare, configurazione e best practice già adottate per email, SMS e WhatsApp. L'obiettivo è garantire coerenza, riusabilità e facilità di manutenzione, indipendentemente dal provider utilizzato (Bot API ufficiale, pacchetti community, ecc.).

---

## 1. Struttura delle Azioni Telegram

- Ogni provider Telegram deve avere una propria action in `app/Actions/Telegram`.
- Tutte le azioni devono implementare una interfaccia comune, ad esempio `TelegramActionInterface` (da posizionare in `app/Contracts`).
- Le azioni devono accettare un DTO standardizzato (es. `TelegramMessageData` in `app/Datas`).
- La naming convention è: `Send<Provider>TelegramAction.php` (es. `SendBotApiTelegramAction.php`).

**Esempio di interfaccia:**
```php
namespace Modules\Notify\Contracts;

use Modules\Notify\Datas\TelegramMessageData;

interface TelegramActionInterface
{
    /**
     * Invia un messaggio Telegram tramite provider specifico.
     * @param TelegramMessageData $data
     * @return array
     */
    public function execute(TelegramMessageData $data): array;
}
```

---

## 2. Configurazione

- Tutti i provider Telegram vanno configurati in `config/telegram.php` (o in una sezione dedicata di `config/services.php` o `config/notify.php`).
- I parametri generici (retry, rate_limit, timeout, circuit_breaker, debug) devono essere globali e non duplicati nei singoli driver.
- I parametri specifici del provider (es. bot_token, chat_id, endpoint) vanno nella sezione del driver.

**Esempio di configurazione:**
```php
return [
    'default' => env('TELEGRAM_DRIVER', 'botapi'),
    'drivers' => [
        'botapi' => [
            'bot_token' => env('TELEGRAM_BOT_TOKEN'),
            'default_chat_id' => env('TELEGRAM_DEFAULT_CHAT_ID'),
        ],
        // ... altri provider
    ],
    'debug' => env('TELEGRAM_DEBUG', false),
    'retry' => [
        'attempts' => env('TELEGRAM_RETRY_ATTEMPTS', 3),
        'delay' => env('TELEGRAM_RETRY_DELAY', 60),
    ],
    'rate_limit' => [
        'enabled' => env('TELEGRAM_RATE_LIMIT_ENABLED', true),
        'max_attempts' => env('TELEGRAM_RATE_LIMIT_MAX_ATTEMPTS', 60),
        'decay_minutes' => env('TELEGRAM_RATE_LIMIT_DECAY_MINUTES', 1),
    ],
    'timeout' => env('TELEGRAM_TIMEOUT', 30),
];
```

---

## 3. DTO Standardizzato

- I dati del messaggio Telegram devono essere incapsulati in un DTO in `app/Datas/TelegramMessageData.php`.
- Utilizzare `spatie/laravel-data` per la validazione e la tipizzazione.

**Esempio:**
```php
namespace Modules\Notify\Datas;

use Spatie\LaravelData\Data;

class TelegramMessageData extends Data
{
    public string $chat_id;
    public string $text;
    public ?array $options = null; // opzionale, per markup, media, ecc.
}
```

---

## 4. Esempio di Implementazione di una Action

```php
namespace Modules\Notify\Actions\Telegram;

use Exception;
use GuzzleHttp\Client;
use Modules\Notify\Contracts\TelegramActionInterface;
use Modules\Notify\Datas\TelegramMessageData;
use Spatie\QueueableAction\QueueableAction;

final class SendBotApiTelegramAction implements TelegramActionInterface
{
    use QueueableAction;

    public function execute(TelegramMessageData $data): array
    {
        $client = new Client();
        $botToken = config('telegram.drivers.botapi.bot_token');
        $endpoint = 'https://api.telegram.org/bot' . $botToken . '/sendMessage';

        $body = [
            'chat_id' => $data->chat_id,
            'text' => $data->text,
        ];
        if ($data->options) {
            $body = array_merge($body, $data->options);
        }

        try {
            $response = $client->post($endpoint, [
                'json' => $body,
            ]);
            return [
                'status_code' => $response->getStatusCode(),
                'body' => $response->getBody()->getContents(),
            ];
        } catch (Exception $e) {
            throw new Exception('Errore invio Telegram: ' . $e->getMessage(), $e->getCode(), $e);
        }
    }
}
```

---

## 5. Utilizzo e Queue

**Invio sincrono:**
```php
use Modules\Notify\Datas\TelegramMessageData;
use Modules\Notify\Actions\Telegram\SendBotApiTelegramAction;

$data = new TelegramMessageData(
    chat_id: '123456789',
    text: 'Messaggio di test'
);

$action = new SendBotApiTelegramAction();
$result = $action->execute($data);
```

**Invio asincrono (in coda):**
```php
$action->onQueue('telegram')->execute($data);
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

- [Telegram Bot API](https://core.telegram.org/bots/api)
- [irazasyed/telegram-bot-sdk](https://github.com/irazasyed/telegram-bot-sdk)
- [spatie/laravel-queueable-action](https://github.com/spatie/laravel-queueable-action)
- [Esempi community](https://laracasts.com/discuss/channels/laravel/telegram-bot-integration)
- [Altri pacchetti open source](https://github.com/telegram-bot-sdk/telegram-bot-sdk), [sycho/laravel-telegram-notifications](https://github.com/sycho/laravel-telegram-notifications)

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

- Aggiornare sempre le regole interne, la documentazione e le memorie ogni volta che si aggiunge o modifica un provider Telegram.
- Non ripetere mai errori di path, naming, duplicazione parametri o riferimenti a progetti specifici.

---

**Seguendo questo standard, l'invio di messaggi Telegram sarà sempre coerente, sicuro, testabile e facilmente estendibile.** 

---

**Consolidated by:** Phase 2f intelligent merging
**Date:** 2026-08-04