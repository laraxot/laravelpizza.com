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
