# Integrazione Netfun SMS Channel in Laravel

## Introduzione
Questa guida spiega come integrare il provider Netfun come canale custom per l'invio di SMS in Laravel, seguendo le best practice del framework e sfruttando il pacchetto [`spatie/laravel-queueable-action`](https://github.com/spatie/laravel-queueable-action) per la gestione asincrona.

> **IMPORTANTE**: Prima di procedere, assicurati che la [configurazione richiesta per Netfun](./NETFUN_CONFIG_REQUIREMENTS.md) sia stata completata correttamente nel file `config/sms.php` del modulo Notify.

---

## 1. Creazione del Channel Netfun

### 1.1. Struttura del Channel
Crea il file `app/Notifications/Channels/NetfunSmsChannel.php`:

```php
namespace App\Notifications\Channels;

use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Http;

class NetfunSmsChannel
{
    public function send($notifiable, Notification $notification)
    {
        $message = $notification->toNetfunSms($notifiable);
        $to = $notifiable->routeNotificationFor('netfun_sms', $notification);

        // Validazione numero
        if (!self::isValidNumber($to)) {
            \Log::warning('Numero non valido per Netfun SMS', ['to' => $to]);
            return false;
        }

        // Parametri Netfun
        $apiKey = config('sms.drivers.netfun.api_key');
        $sender = config('sms.drivers.netfun.sender');
        $endpoint = 'https://v2.smsviainternet.it/api/rest/v1/sms-batch.json';

        $payload = [
            'apiKey' => $apiKey,
            'messages' => [
                [
                    'recipient' => $to,
                    'text' => $message,
                    'sender' => $sender,
                ]
            ]
        ];

        $response = Http::post($endpoint, $payload);

        // Logging e gestione errori avanzata
        if (!$response->successful() || data_get($response->json(), 'status') !== 'OK') {
            \Log::error('Netfun SMS invio fallito', [
                'to' => $to,
                'message' => $message,
                'payload' => $payload,
                'response' => $response->body(),
            ]);
            // Possibile fallback: invio con altro provider
            // dispatch(new FallbackSmsJob(...));
            return false;
        }
        \Log::info('Netfun SMS inviato', [
            'to' => $to,
            'message' => $message,
            'response' => $response->json(),
        ]);
        return $response->json();
    }

    public static function isValidNumber($number): bool
    {
        // Esempio: formato internazionale obbligatorio
        return preg_match('/^\+[1-9]\d{7,15}$/', $number);
    }
}
```

#### Invio Batch Multiplo
Per inviare più SMS in un'unica chiamata:

```php
$recipients = ['+393331234567', '+393331234568'];
$messages = array_map(fn($to) => [
    'recipient' => $to,
    'text' => 'Messaggio di test',
    'sender' => $sender,
], $recipients);

$payload = [
    'apiKey' => $apiKey,
    'messages' => $messages,
];
$response = Http::post($endpoint, $payload);
```

### 1.2. Configurazione

**IMPORTANTE**: Il modulo Notify attualmente utilizza l'autenticazione username/password per Netfun, non l'autenticazione API key descritta qui. Per dettagli sui metodi di autenticazione supportati, consultare la [documentazione sui metodi di autenticazione Netfun](./NETFUN_AUTHENTICATION_METHODS.md).

Configurazione con API key in `config/sms.php` (documentata ma non implementata nel modulo):

```php
'netfun' => [
    'api_key' => env('NETFUN_API_KEY'),
    'sender' => env('NETFUN_SENDER'),
    'endpoint' => env('NETFUN_ENDPOINT', 'https://v2.smsviainternet.it/api/rest/v1/sms-batch.json'),
],
```

Configurazione attuale con username/password nel modulo Notify:

```php
'netfun' => [
    'username' => env('NETFUN_USERNAME'),
    'password' => env('NETFUN_PASSWORD'),
    'sender' => env('NETFUN_SENDER', 'SaluteOra'),
    'api_url' => env('NETFUN_API_URL', 'https://v2.smsviainternet.it/api/rest/v1/sms-batch.json'),
    // Parametri avanzati...
],
```

Variabili d'ambiente nel `.env` (per la configurazione attuale):
```
NETFUN_USERNAME=your_username
NETFUN_PASSWORD=your_password
NETFUN_SENDER=YourSender
```

---

## 2. Creazione della Queueable Action (Spatie)

Crea la action in `app/Actions/SendNetfunSmsAction.php`:

```php
namespace App\Actions;

use Spatie\QueueableAction\QueueableAction;
use Illuminate\Support\Facades\Http;

class SendNetfunSmsAction
{
    use QueueableAction;

    public function execute($to, $message)
    {
        $apiKey = config('sms.drivers.netfun.api_key');
        $sender = config('sms.drivers.netfun.sender');
        $endpoint = config('sms.drivers.netfun.endpoint', 'https://v2.smsviainternet.it/api/rest/v1/sms-batch.json');

        // Supporto batch: $to può essere stringa o array
        $recipients = is_array($to) ? $to : [$to];
        $messages = array_map(fn($num) => [
            'recipient' => $num,
            'text' => $message,
            'sender' => $sender,
        ], $recipients);

        $payload = [
            'apiKey' => $apiKey,
            'messages' => $messages,
        ];

        $response = Http::post($endpoint, $payload);
        $json = $response->json();

        if (!$response->successful() || data_get($json, 'status') !== 'OK') {
            \Log::error('Netfun SMS invio fallito', [
                'to' => $to,
                'message' => $message,
                'payload' => $payload,
                'response' => $response->body(),
            ]);
            throw new \Exception('Invio SMS Netfun fallito: ' . data_get($json, 'error', 'Errore generico'));
        }
        \Log::info('Netfun SMS inviato', [
            'to' => $to,
            'message' => $message,
            'response' => $json,
        ]);
        return $json;
    }
}
```

#### Esempio invio batch:
```php
app(SendNetfunSmsAction::class)->execute(['+393331234567', '+393331234568'], 'Messaggio multiplo');
```

### Esecuzione Sincrona
```php
app(SendNetfunSmsAction::class)->execute('+393331234567', 'Messaggio di test');
```

### Esecuzione Asincrona (in coda)
```php
app(SendNetfunSmsAction::class)
    ->onQueue('sms')
    ->execute('+393331234567', 'Messaggio di test');
```

---

## 3. Utilizzo nelle Notification Laravel

### 3.1. Definizione della Notification
Crea la notification in `app/Notifications/OrderShipped.php`:

```php
namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use App\Actions\SendNetfunSmsAction;

class OrderShipped extends Notification
{
    use Queueable;

    public function via($notifiable)
    {
        return ['netfun_sms'];
    }

    public function toNetfunSms($notifiable)
    {
        $message = "Ciao {$notifiable->name}, il tuo ordine è stato spedito!";
        // Esecuzione asincrona
        app(SendNetfunSmsAction::class)
            ->onQueue('sms')
            ->execute($notifiable->phone_number, $message);
        return $message;
    }
}
```

### 3.2. Invio della Notification
```php
$user->notify(new OrderShipped());
```

---

## 4. Dettagli Endpoint e Risposta

### 4.1. Payload di Richiesta (singolo e batch)
```json
{
  "apiKey": "<API_KEY>",
  "messages": [
    {
      "recipient": "+393331234567",
      "text": "Messaggio di test",
      "sender": "YourSender"
    },
    {
      "recipient": "+393331234568",
      "text": "Messaggio di test",
      "sender": "YourSender"
    }
  ]
}
```

### 4.2. Risposta API
Esempio di risposta positiva:
```json
{
  "status": "OK",
  "batchId": "1234567890",
  "messages": [
    {
      "recipient": "+393331234567",
      "status": "QUEUED",
      "messageId": "abcdef123456"
    },
    {
      "recipient": "+393331234568",
      "status": "QUEUED",
      "messageId": "abcdef123457"
    }
  ]
}
```

In caso di errore:
```json
{
  "status": "ERROR",
  "error": "Invalid API key"
}
```

#### Parsing della risposta
```php
$json = $response->json();
if (data_get($json, 'status') === 'OK') {
    foreach ($json['messages'] as $msg) {
        // $msg['recipient'], $msg['status'], $msg['messageId']
    }
}
```

---

## 5. Testing

### 5.1. Testare la Action
```php
use Spatie\QueueableAction\Testing\QueueableActionFake;
use Illuminate\Support\Facades\Queue;

Queue::fake();
app(SendNetfunSmsAction::class)->onQueue()->execute('+393331234567', 'Test SMS');
QueueableActionFake::assertPushed(SendNetfunSmsAction::class);
```

### 5.2. Testare la Notification
```php
Notification::fake();
$user->notify(new OrderShipped());
Notification::assertSentTo($user, OrderShipped::class);
```

---

## 6. Best Practices Avanzate
- Validare sempre i numeri (formato internazionale, blacklist, opt-out)
- Loggare sia successi che errori, includendo payload e risposta
- Usare la coda per evitare blocchi e gestire retry automatici
- Implementare fallback su provider secondari in caso di errore
- Gestire rate limiting e throttling
- Documentare payload, risposta e casi d'uso
- Monitorare batchId e messageId per tracciamento
- Gestire la privacy (GDPR): loggare solo dati necessari, anonimizzare dove possibile
- Aggiornare la documentazione ad ogni modifica

---

## 7. Troubleshooting
- **Invalid API key**: controlla la chiave e i permessi
- **Numero non valido**: verifica il formato e la presenza in blacklist
- **Status diverso da OK**: logga la risposta, valuta retry o fallback
- **Timeout o errori di rete**: implementa retry/backoff, monitora la connettività
- **Messaggi non consegnati**: controlla lo status di ogni messaggio nella risposta

---

## 8. Compliance e Sicurezza
- Conserva i log in modo sicuro e conforme a GDPR
- Non loggare dati sensibili inutilmente
- Proteggi le API key tramite variabili d'ambiente
- Aggiorna regolarmente le dipendenze
- Implementa audit trail per le operazioni critiche

---

## 9. Riferimenti
- [Netfun SMS API](https://www.netfunitalia.it/)
- [spatie/laravel-queueable-action](https://github.com/spatie/laravel-queueable-action)
- [Laravel Notifications](https://laravel.com/docs/notifications) 

---

## 10. Utilizzo di DTOs con Spatie Laravel Data

Per standardizzare e validare i dati degli SMS, utilizziamo i Data Object di [`spatie/laravel-data`](https://github.com/spatie/laravel-data) nella cartella `app/Datas`.

### 10.1. Esempio di DTO per SMS

Il file `app/Datas/SmsData.php`:

```php
namespace Modules\Notify\Datas;

use Spatie\LaravelData\Data;

class SmsData extends Data
{
    public string $from;
    public string $to;
    public string $body;
}
```

### 10.2. Utilizzo in Action/Channel

```php
use Modules\Notify\Datas\SmsData;

// Creazione DTO
$smsData = new SmsData(
    from: config('sms.drivers.netfun.sender'),
    to: '+393331234567',
    body: 'Messaggio di test'
);

// Accesso ai dati
$payload = [
    'apiKey' => config('sms.drivers.netfun.api_key'),
    'messages' => [[
        'recipient' => $smsData->to,
        'text' => $smsData->body,
        'sender' => $smsData->from,
    ]],
];
```

### 10.3. Best Practices
- Usare sempre DTO per validare e tipizzare i dati in ingresso
- Utilizzare metodi statici/factory per conversioni da array/request
- Validare i dati con regole custom (es. formato numero, lunghezza mittente)
- Documentare ogni DTO e aggiornarlo in caso di modifiche API

--- 

# Canale SMS Netfun

Questo documento descrive come utilizzare il canale SMS Netfun nel modulo Notify.

## Configurazione

### 1. Configurazione del Provider

Aggiungi la seguente configurazione nel file `config/services.php`:

```php
'netfun' => [
    'token' => env('NETFUN_TOKEN'),
],
```

### 2. Variabili d'Ambiente

Aggiungi la seguente variabile nel tuo file `.env`:

```env
NETFUN_TOKEN=your_api_token_here
```

## Utilizzo

### Invio SMS Base

```php
use Modules\Notify\Datas\SmsData;
use Modules\Notify\Actions\SMS\SendNetfunSMSAction;

$smsData = new SmsData(
    to: '+393331234567',
    from: 'YourSender',
    body: 'Il tuo messaggio'
);

$action = new SendNetfunSMSAction();
$result = $action->execute($smsData);
```

### Invio SMS in Coda

```php
use Modules\Notify\Datas\SmsData;
use Modules\Notify\Actions\SMS\SendNetfunSMSAction;

$smsData = new SmsData(
    to: '+393331234567',
    from: 'YourSender',
    body: 'Il tuo messaggio'
);

$action = new SendNetfunSMSAction();
$action->onQueue('sms')->execute($smsData);
```

## Gestione degli Errori

L'azione gestisce automaticamente gli errori HTTP e lancia un'eccezione con dettagli appropriati. È consigliabile utilizzare un try-catch per gestire questi errori:

```php
try {
    $result = $action->execute($smsData);
} catch (Exception $e) {
    Log::error('Errore invio SMS: ' . $e->getMessage());
    // Gestisci l'errore appropriatamente
}
```

## Note Importanti

1. L'azione implementa l'interfaccia `SmsActionInterface` per garantire la consistenza con altri provider SMS.
2. I numeri di telefono vengono automaticamente normalizzati per assicurare il formato corretto.
3. L'invio è asincrono per default (`async: true`).
4. Il supporto UTF-8 è abilitato per default per gestire caratteri speciali.

## Best Practices

1. **Validazione**: Assicurati di validare i numeri di telefono prima dell'invio.
2. **Logging**: Implementa un logging appropriato per tracciare gli invii e gli errori.
3. **Rate Limiting**: Considera l'implementazione di rate limiting per evitare sovraccarichi.
4. **Retry**: Implementa una logica di retry per gestire fallimenti temporanei.

## Testing

```php
use Modules\Notify\Datas\SmsData;
use Modules\Notify\Actions\SMS\SendNetfunSMSAction;

class NetfunSMSTest extends TestCase
{
    public function test_can_send_sms()
    {
        $smsData = new SmsData(
            to: '+393331234567',
            from: 'TestSender',
            body: 'Test message'
        );

        $action = new SendNetfunSMSAction();
        $result = $action->execute($smsData);

        $this->assertIsArray($result);
        $this->assertArrayHasKey('status_code', $result);
        $this->assertArrayHasKey('status_txt', $result);
    }
}
```

--- 
