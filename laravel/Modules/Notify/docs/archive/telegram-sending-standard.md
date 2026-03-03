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
