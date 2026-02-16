# Architettura Telegram Provider per SaluteOra

Questo documento definisce l'architettura e gli standard per l'implementazione dei provider Telegram nel modulo Notify di SaluteOra, mantenendo coerenza con le architetture esistenti per SMS, email e WhatsApp.

## Principi Architetturali Fondamentali

L'architettura dei provider Telegram segue gli stessi principi dei provider SMS, email e WhatsApp, rispettando i seguenti punti:

1. **Separazione delle Interfacce**: Le interfacce sono definite in `app/Contracts/`, mai nelle directory di implementazione
2. **Implementazioni in Directory Dedicate**: Tutte le azioni di provider sono in `app/Actions/Telegram/`
3. **Data Transfer Objects (DTO)**: Utilizzo di DTO specifici per i messaggi Telegram in `app/Datas/`
4. **Configurazione Centralizzata**: Configurazione in `config/telegram.php`

## Struttura Directory e Namespace

```
/var/www/html/saluteora/laravel/Modules/Notify/
├── app/
│   ├── Actions/
│   │   └── Telegram/
│   │       ├── SendBotTelegramAction.php
│   │       └── SendApiTelegramAction.php
│   ├── Contracts/
│   │   └── TelegramProviderActionInterface.php
│   ├── Datas/
│   │   └── TelegramData.php
│   └── Channels/
│       └── TelegramChannel.php
└── config/
    └── telegram.php
```

## Interfaccia del Provider Telegram

```php
<?php

declare(strict_types=1);

namespace Modules\Notify\Contracts;

use Modules\Notify\Datas\TelegramData;

/**
 * Interfaccia per tutte le azioni di invio Telegram.
 * 
 * Tutte le implementazioni di provider Telegram devono implementare questa interfaccia
 * per garantire una coerenza nel modo in cui vengono gestiti i messaggi
 * indipendentemente dal provider specifico utilizzato.
 */
interface TelegramProviderActionInterface
{
    /**
     * Invia un messaggio Telegram utilizzando il provider specifico.
     *
     * @param TelegramData $telegramData I dati del messaggio Telegram da inviare
     * @return array Risultato dell'operazione con almeno la chiave 'success'
     * @throws \Exception Se l'invio fallisce per motivi tecnici
     */
    public function execute(TelegramData $telegramData): array;
}
```

## Data Transfer Object per Telegram

```php
<?php

declare(strict_types=1);

namespace Modules\Notify\Datas;

class TelegramData
{
    /**
     * @param string $chatId ID della chat di destinazione
     * @param string $text Testo del messaggio
     * @param string|null $parseMode Modalità di parsing del testo (HTML, Markdown, MarkdownV2)
     * @param bool $disableWebPagePreview Se disabilitare l'anteprima dei link
     * @param bool $disableNotification Se inviare il messaggio silenziosamente
     * @param int|null $replyToMessageId ID del messaggio a cui rispondere
     * @param array $replyMarkup Markup di risposta come tastiere inline o normali
     * @param array $files Array di file da inviare (opzionale)
     * @param array $buttons Array di bottoni inline (opzionale)
     * @param array $context Dati di contesto aggiuntivi (opzionale)
     */
    public function __construct(
        public readonly string $chatId,
        public readonly string $text,
        public readonly ?string $parseMode = null,
        public readonly bool $disableWebPagePreview = false,
        public readonly bool $disableNotification = false,
        public readonly ?int $replyToMessageId = null,
        public readonly array $replyMarkup = [],
        public readonly array $files = [],
        public readonly array $buttons = [],
        public readonly array $context = []
    ) {
    }
}
```

## Configurazione Telegram

```php
<?php

// config/telegram.php

return [
    /*
    |--------------------------------------------------------------------------
    | Default Telegram Provider
    |--------------------------------------------------------------------------
    |
    | This option controls the default provider that will be used to send
    | telegram messages.
    |
    */
    'default' => env('TELEGRAM_PROVIDER', 'bot'),
    
    /*
    |--------------------------------------------------------------------------
    | Telegram Providers
    |--------------------------------------------------------------------------
    |
    | Here you may configure the telegram providers for your application.
    |
    */
    'providers' => [
        'bot' => [
            'token' => env('TELEGRAM_BOT_TOKEN'),
            'api_url' => env('TELEGRAM_API_URL', 'https://api.telegram.org'),
            'certificate_path' => env('TELEGRAM_CERTIFICATE_PATH'),
        ],
        
        'api' => [
            'token' => env('TELEGRAM_API_TOKEN'),
            'api_id' => env('TELEGRAM_API_ID'),
            'api_hash' => env('TELEGRAM_API_HASH'),
            'proxy' => env('TELEGRAM_PROXY'),
        ],
    ],
    
    /*
    |--------------------------------------------------------------------------
    | Global Debug Mode
    |--------------------------------------------------------------------------
    */
    'debug' => env('TELEGRAM_DEBUG', false),

    /*
    |--------------------------------------------------------------------------
    | Telegram Queue
    |--------------------------------------------------------------------------
    */
    'queue' => env('TELEGRAM_QUEUE', 'default'),

    /*
    |--------------------------------------------------------------------------
    | Global Timeout
    |--------------------------------------------------------------------------
    */
    'timeout' => env('TELEGRAM_TIMEOUT', 30),

    /*
    |--------------------------------------------------------------------------
    | Default Chat ID
    |--------------------------------------------------------------------------
    */
    'default_chat_id' => env('TELEGRAM_DEFAULT_CHAT_ID'),

    /*
    |--------------------------------------------------------------------------
    | Retry Configuration
    |--------------------------------------------------------------------------
    */
    'retry' => [
        'attempts' => env('TELEGRAM_RETRY_ATTEMPTS', 3),
        'delay' => env('TELEGRAM_RETRY_DELAY', 60),
    ],

    /*
    |--------------------------------------------------------------------------
    | Rate Limiting
    |--------------------------------------------------------------------------
    */
    'rate_limit' => [
        'enabled' => env('TELEGRAM_RATE_LIMIT_ENABLED', true),
        'max_attempts' => env('TELEGRAM_RATE_LIMIT_MAX_ATTEMPTS', 30),
        'decay_minutes' => env('TELEGRAM_RATE_LIMIT_DECAY_MINUTES', 1),
    ],
];
```

## Implementazione dei Provider Telegram

### Provider Bot Telegram (Esempio)

```php
<?php

declare(strict_types=1);

namespace Modules\Notify\Actions\Telegram;

use Exception;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use Illuminate\Support\Facades\Log;
use Modules\Notify\Contracts\TelegramProviderActionInterface;
use Modules\Notify\Datas\TelegramData;
use Spatie\QueueableAction\QueueableAction;

final class SendBotTelegramAction implements TelegramProviderActionInterface
{
    use QueueableAction;

    private string $token;
    private string $apiUrl;
    private ?string $certificatePath;
    private bool $debug;
    private int $timeout;

    /**
     * Create a new action instance.
     *
     * @throws Exception Se le credenziali non sono configurate
     */
    public function __construct()
    {
        $token = config('telegram.providers.bot.token');
        
        if (!is_string($token)) {
            throw new Exception('Il token del bot Telegram deve essere configurato in config/telegram.php');
        }
        
        $this->token = $token;
        $this->apiUrl = rtrim(config('telegram.providers.bot.api_url', 'https://api.telegram.org'), '/');
        $this->certificatePath = config('telegram.providers.bot.certificate_path');
        
        // Parametri globali
        $this->debug = (bool) config('telegram.debug', false);
        $this->timeout = (int) config('telegram.timeout', 30);
    }

    /**
     * Execute the action.
     *
     * @param TelegramData $telegramData I dati del messaggio Telegram
     * @return array Risultato dell'operazione
     * @throws Exception In caso di errore durante l'invio
     */
    public function execute(TelegramData $telegramData): array
    {
        $client = new Client([
            'base_uri' => $this->apiUrl,
            'timeout' => $this->timeout,
            'http_errors' => false,
        ]);
        
        try {
            // Prepara i parametri per la richiesta
            $params = [
                'chat_id' => $telegramData->chatId,
                'text' => $telegramData->text,
            ];
            
            // Aggiungi parametri opzionali se presenti
            if ($telegramData->parseMode) {
                $params['parse_mode'] = $telegramData->parseMode;
            }
            
            if ($telegramData->disableWebPagePreview) {
                $params['disable_web_page_preview'] = true;
            }
            
            if ($telegramData->disableNotification) {
                $params['disable_notification'] = true;
            }
            
            if ($telegramData->replyToMessageId) {
                $params['reply_to_message_id'] = $telegramData->replyToMessageId;
            }
            
            // Gestione dei pulsanti
            if (!empty($telegramData->buttons)) {
                $params['reply_markup'] = json_encode([
                    'inline_keyboard' => $this->formatButtons($telegramData->buttons),
                ]);
            } elseif (!empty($telegramData->replyMarkup)) {
                $params['reply_markup'] = json_encode($telegramData->replyMarkup);
            }
            
            // Determina se inviare un messaggio semplice o con file
            if (empty($telegramData->files)) {
                // Messaggio semplice
                $response = $client->post(
                    "/bot{$this->token}/sendMessage",
                    ['form_params' => $params]
                );
            } else {
                // Messaggio con file (solo primo file supportato)
                $file = $telegramData->files[0];
                $method = $this->determineFileMethod($file);
                
                // Aggiunge il file come multipart
                $multipart = [
                    [
                        'name' => 'chat_id',
                        'contents' => $telegramData->chatId,
                    ],
                    [
                        'name' => 'caption',
                        'contents' => $telegramData->text,
                    ],
                ];
                
                // Aggiunge il file alla richiesta multipart
                $multipart[] = [
                    'name' => $this->getFileParameterName($method),
                    'contents' => fopen($file['path'], 'r'),
                    'filename' => $file['name'] ?? basename($file['path']),
                ];
                
                // Aggiunge parametri opzionali
                if ($telegramData->parseMode) {
                    $multipart[] = [
                        'name' => 'parse_mode',
                        'contents' => $telegramData->parseMode,
                    ];
                }
                
                if (!empty($telegramData->buttons)) {
                    $multipart[] = [
                        'name' => 'reply_markup',
                        'contents' => json_encode([
                            'inline_keyboard' => $this->formatButtons($telegramData->buttons),
                        ]),
                    ];
                }
                
                $response = $client->post(
                    "/bot{$this->token}/{$method}",
                    ['multipart' => $multipart]
                );
            }
            
            // Elabora la risposta
            $statusCode = $response->getStatusCode();
            $responseBody = json_decode((string) $response->getBody(), true);
            
            if ($statusCode === 200 && ($responseBody['ok'] ?? false)) {
                return [
                    'success' => true,
                    'message_id' => $responseBody['result']['message_id'] ?? null,
                    'provider' => 'telegram-bot',
                    'data' => $responseBody['result'] ?? [],
                ];
            }
            
            // Log in caso di errore
            if ($this->debug) {
                Log::error('Telegram error', [
                    'status_code' => $statusCode,
                    'response' => $responseBody,
                ]);
            }
            
            return [
                'success' => false,
                'error' => $responseBody['description'] ?? 'Unknown error',
                'provider' => 'telegram-bot',
                'status_code' => $statusCode,
                'data' => $responseBody,
            ];
        } catch (ClientException $e) {
            // Log dell'errore dettagliato
            if ($this->debug) {
                Log::error('Telegram request error', [
                    'exception' => $e->getMessage(),
                    'response' => $e->getResponse() ? (string) $e->getResponse()->getBody() : null,
                ]);
            }
            
            throw new Exception('Errore durante l\'invio del messaggio Telegram: ' . $e->getMessage(), 0, $e);
        } catch (Exception $e) {
            // Log dell'errore generico
            if ($this->debug) {
                Log::error('Telegram general error', [
                    'exception' => $e->getMessage(),
                ]);
            }
            
            throw new Exception('Errore durante l\'invio del messaggio Telegram: ' . $e->getMessage(), 0, $e);
        }
    }
    
    /**
     * Formatta i pulsanti per Telegram.
     *
     * @param array $buttons Array di pulsanti
     * @return array Pulsanti formattati per Telegram
     */
    private function formatButtons(array $buttons): array
    {
        $formattedButtons = [];
        $row = [];
        
        foreach ($buttons as $button) {
            $buttonData = [];
            
            if (isset($button['text'])) {
                $buttonData['text'] = $button['text'];
            }
            
            if (isset($button['url'])) {
                $buttonData['url'] = $button['url'];
            } elseif (isset($button['callback_data'])) {
                $buttonData['callback_data'] = $button['callback_data'];
            }
            
            $row[] = $buttonData;
            
            // Se è impostato 'new_row' o è l'ultimo pulsante, aggiungi la riga
            if (($button['new_row'] ?? false) || end($buttons) === $button) {
                $formattedButtons[] = $row;
                $row = [];
            }
        }
        
        return $formattedButtons;
    }
    
    /**
     * Determina il metodo API appropriato per inviare un determinato tipo di file.
     *
     * @param array $file Informazioni sul file
     * @return string Nome del metodo API Telegram
     */
    private function determineFileMethod(array $file): string
    {
        $type = $file['type'] ?? $this->guessFileType($file['path']);
        
        return match ($type) {
            'photo' => 'sendPhoto',
            'audio' => 'sendAudio',
            'document' => 'sendDocument',
            'video' => 'sendVideo',
            'animation' => 'sendAnimation',
            'voice' => 'sendVoice',
            'video_note' => 'sendVideoNote',
            default => 'sendDocument',
        };
    }
    
    /**
     * Ottiene il nome del parametro per il file in base al metodo.
     *
     * @param string $method Nome del metodo API
     * @return string Nome del parametro per il file
     */
    private function getFileParameterName(string $method): string
    {
        return match ($method) {
            'sendPhoto' => 'photo',
            'sendAudio' => 'audio',
            'sendDocument' => 'document',
            'sendVideo' => 'video',
            'sendAnimation' => 'animation',
            'sendVoice' => 'voice',
            'sendVideoNote' => 'video_note',
            default => 'document',
        };
    }
    
    /**
     * Indovina il tipo di file in base all'estensione.
     *
     * @param string $path Percorso del file
     * @return string Tipo di file per Telegram
     */
    private function guessFileType(string $path): string
    {
        $extension = strtolower(pathinfo($path, PATHINFO_EXTENSION));
        
        return match ($extension) {
            'jpg', 'jpeg', 'png', 'gif', 'webp' => 'photo',
            'mp3', 'm4a', 'ogg' => 'audio',
            'mp4' => 'video',
            'gif' => 'animation',
            'ogg', 'oga' => 'voice',
            default => 'document',
        };
    }
}
```

## Notifica Laravel per Telegram

```php
<?php

declare(strict_types=1);

namespace Modules\Notify\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Notification;
use Modules\Notify\Channels\TelegramChannel;
use Modules\Notify\Datas\TelegramData;

class TelegramNotification extends Notification implements ShouldQueue
{
    use Queueable;

    /**
     * @param string $text Testo del messaggio
     * @param array $files Allegati opzionali
     * @param array $buttons Pulsanti inline opzionali
     * @param array $options Opzioni aggiuntive
     */
    public function __construct(
        public readonly string $text,
        public readonly array $files = [],
        public readonly array $buttons = [],
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
        return [TelegramChannel::class];
    }

    /**
     * Ottieni la rappresentazione Telegram della notifica.
     */
    public function toTelegram(object $notifiable): TelegramData
    {
        // Ottieni il chat_id dal notifiable o dalla configurazione predefinita
        $chatId = $notifiable->routeNotificationForTelegram($this) 
            ?? config('telegram.default_chat_id');
        
        if (!$chatId) {
            throw new \Exception('Nessun chat_id specificato per la notifica Telegram');
        }
        
        // Prepara i parametri opzionali
        $parseMode = $this->options['parse_mode'] ?? 'HTML';
        $disableWebPagePreview = $this->options['disable_web_page_preview'] ?? false;
        $disableNotification = $this->options['disable_notification'] ?? false;
        $replyToMessageId = $this->options['reply_to_message_id'] ?? null;
        $replyMarkup = $this->options['reply_markup'] ?? [];
        
        return new TelegramData(
            chatId: $chatId,
            text: $this->text,
            parseMode: $parseMode,
            disableWebPagePreview: $disableWebPagePreview,
            disableNotification: $disableNotification,
            replyToMessageId: $replyToMessageId,
            replyMarkup: $replyMarkup,
            files: $this->files,
            buttons: $this->buttons,
            context: $this->options
        );
    }
}
```

## Canale Telegram

```php
<?php

declare(strict_types=1);

namespace Modules\Notify\Channels;

use Exception;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Log;
use Modules\Notify\Actions\Telegram\SendBotTelegramAction;
use Modules\Notify\Actions\Telegram\SendApiTelegramAction;
use Modules\Notify\Datas\TelegramData;

class TelegramChannel
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
        if (! method_exists($notification, 'toTelegram')) {
            throw new Exception('La notifica deve implementare il metodo toTelegram()');
        }

        $telegramData = $notification->toTelegram($notifiable);

        if (! $telegramData instanceof TelegramData) {
            throw new Exception('Il metodo toTelegram() deve restituire un\'istanza di TelegramData');
        }

        // Recupera il provider predefinito dalla configurazione
        $provider = $telegramData->context['provider'] ?? config('telegram.default', 'bot');

        // Seleziona l'azione appropriata in base al provider
        $action = match ($provider) {
            'bot' => app(SendBotTelegramAction::class),
            'api' => app(SendApiTelegramAction::class),
            default => throw new Exception("Provider Telegram non supportato: {$provider}")
        };

        try {
            // Esegui l'azione e ottieni il risultato
            $result = $action->execute($telegramData);

            // Log del risultato se in debug mode
            if (config('telegram.debug', false)) {
                Log::info('Telegram message sent', [
                    'provider' => $provider,
                    'result' => $result,
                ]);
            }

            return $result;
        } catch (Exception $e) {
            Log::error('Telegram message sending failed', [
                'provider' => $provider,
                'exception' => $e->getMessage(),
            ]);

            // Rilancia l'eccezione solo in ambiente di sviluppo o se specificato nella configurazione
            if (config('app.debug', false) || config('telegram.throw_exceptions', false)) {
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

## Integrazione con l'API di Telegram

### Bot API di Telegram

La Bot API di Telegram è la soluzione più comune per integrare Telegram nelle applicazioni:

1. **Creazione di un Bot**: Utilizzare @BotFather su Telegram per creare un nuovo bot
2. **Ottenere il Token**: Una volta creato il bot, BotFather fornirà un token API
3. **Configurazione Webhook**: Per ricevere aggiornamenti in tempo reale, configurare un webhook
4. **Gestione degli Aggiornamenti**: Implementare endpoint per ricevere aggiornamenti dal bot

### TDLib (Telegram Database Library)

Per funzionalità avanzate o accesso all'API client completa:

1. **Installazione di TDLib**: Compilare o installare la libreria TDLib
2. **Configurazione Credenziali**: Ottenere API ID e API Hash da my.telegram.org
3. **Autenticazione Utente**: Implementare flusso di autenticazione utente o bot
4. **Operazioni API**: Utilizzare metodi TDLib per operazioni avanzate

## Best Practices per i Messaggi Telegram

1. **Rispettare i Limiti di Rate**: Telegram limita le richieste API a 30 messaggi al secondo
2. **Utilizzare ParseMode Appropriato**: Supporto per formattazione HTML e Markdown
3. **Gestire Correttamente i File**: Rispettare i limiti di dimensione per i file allegati
4. **Implementare Retry con Backoff**: Per gestire interruzioni temporanee del servizio
5. **Utilizzare Webhooks**: Per ricevere risposte in tempo reale
6. **Sicurezza**: Proteggere token bot e credenziali API
7. **Localizzazione**: Supportare più lingue nei messaggi

## Aggiornamento della Configurazione

In fase di installazione:

1. Creare un bot Telegram tramite @BotFather
2. Ottenere il token bot e aggiungerlo al file `.env`
3. Implementare l'endpoint webhook se necessario
4. Configurare l'URL del webhook se si utilizza la Bot API

## Troubleshooting

### Problemi Comuni e Soluzioni

1. **Errore di Autenticazione**: Verificare token del bot e credenziali API
2. **Rate Limiting**: Implementare coda e pausa tra le richieste
3. **Errori di Formattazione**: Verificare la correttezza della sintassi HTML/Markdown
4. **Errori Webhook**: Verificare che l'URL sia accessibile e con SSL valido
5. **Dimensione File**: Rispettare i limiti di dimensione dei file
