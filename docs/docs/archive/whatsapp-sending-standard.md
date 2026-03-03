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
