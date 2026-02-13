# Pattern per le Azioni SMS 

## Struttura e Convenzioni

, le azioni di invio SMS seguono un pattern ben definito per garantire coerenza, manutenibilità e estensibilità. Questo documento descrive il pattern corretto da seguire per tutte le azioni SMS.

## Regola Fondamentale: Corrispondenza Driver-Azione

**Per ogni driver configurato in `config/sms.php` deve esistere una corrispondente azione in `app/Actions/SMS/`.**

Esempio:
- Driver `netfun` → Azione `SendNetfunSMSAction`
- Driver `twilio` → Azione `SendTwilioSMSAction`
- Driver `smsfactor` → Azione `SendSmsFactorSMSAction`

Questa corrispondenza è essenziale per garantire che tutti i driver configurati possano essere utilizzati in modo coerente attraverso l'interfaccia comune.

## 1. Interfaccia Comune

Tutte le azioni di invio SMS devono implementare l'interfaccia `SmsActionInterface`:

```php
<?php

namespace Modules\Notify\Contracts;

use Modules\Notify\Datas\SmsData;

interface SmsActionInterface
{
    /**
     * Invia un SMS utilizzando il provider specifico.
     *
     * @param SmsData $smsData I dati del messaggio SMS
     * @return array Risultato dell'operazione
     */
    public function execute(SmsData $smsData): array;
}
```

Questa interfaccia garantisce che tutte le azioni SMS abbiano un metodo `execute` che accetta un oggetto `SmsData` come parametro.

## 2. Struttura delle Azioni SMS

Le azioni SMS devono essere posizionate nella directory `/Modules/Notify/app/Actions/SMS/` e seguire questa convenzione di nomenclatura:

```
Send{DriverName}SMSAction.php
```

Dove `{DriverName}` è il nome del driver in PascalCase (es. `Netfun`, `Twilio`, `SmsFactor`).

Ogni azione deve seguire questa struttura:

```php
<?php

declare(strict_types=1);

namespace Modules\Notify\Actions\SMS;

use Exception;
use Modules\Notify\Contracts\SmsActionInterface;
use Modules\Notify\Datas\SmsData;
use Spatie\QueueableAction\QueueableAction;

final class Send{Provider}SMSAction implements SmsActionInterface
{
    use QueueableAction;

    // Proprietà specifiche del provider
    
    /**
     * Create a new action instance.
     */
    public function __construct()
    {
        // Inizializzazione delle proprietà dal file di configurazione
    }

    /**
     * Invia un SMS tramite l'API del provider
     *
     * @param SmsData $smsData I dati del messaggio SMS
     * @return array Risultato dell'operazione
     * @throws Exception In caso di errore durante l'invio
     */
    public function execute(SmsData $smsData): array
    {
        // Implementazione specifica per il provider
    }
}
```

## 3. Configurazione

La configurazione per i provider SMS deve seguire il pattern standardizzato nel file `config/sms.php`:

```php
return [
    'default' => env('SMS_DRIVER', 'netfun'),
    
    'from' => env('SMS_FROM'),
    'debug' => env('SMS_DEBUG', false),
    'timeout' => env('SMS_TIMEOUT', 30),
    
    'drivers' => [
        'netfun' => [
            'token' => env('NETFUN_TOKEN'),
            'api_url' => env('NETFUN_API_URL', 'https://v2.smsviainternet.it/api/rest/v1/sms-batch.json'),
        ],
        'esendex' => [
            'username' => env('ESENDEX_USERNAME'),
            'password' => env('ESENDEX_PASSWORD'),
            'sender' => env('ESENDEX_SENDER'),
        ],
        // Altri provider...
    ],
    
    'retry' => [
        'attempts' => env('SMS_RETRY_ATTEMPTS', 3),
        'delay' => env('SMS_RETRY_DELAY', 60),
    ],
    
    'rate_limit' => [
        'enabled' => env('SMS_RATE_LIMIT_ENABLED', true),
        'max_attempts' => env('SMS_RATE_LIMIT_MAX_ATTEMPTS', 60),
        'decay_minutes' => env('SMS_RATE_LIMIT_DECAY_MINUTES', 1),
    ],
];
```

## 4. Data Transfer Objects (DTO)

Per l'invio di SMS, si deve utilizzare esclusivamente il DTO `SmsData`:

```php
<?php

declare(strict_types=1);

namespace Modules\Notify\Datas;

use Spatie\LaravelData\Data;

class SmsData extends Data
{
    public string $from;
    public string $to;
    public string $body;
}
```

Se un provider richiede parametri aggiuntivi, questi devono essere gestiti internamente all'azione specifica, senza modificare l'interfaccia pubblica.

## 5. Gestione di Provider Specifici

Se un provider richiede parametri aggiuntivi non presenti in `SmsData`, è possibile:

1. Estendere `SmsData` per usi interni all'azione
2. Convertire `SmsData` in un formato specifico per il provider
3. Utilizzare valori predefiniti o configurazioni per i parametri mancanti

Esempio di conversione interna:

```php
public function execute(SmsData $smsData): array
{
    // Conversione interna per adattarsi alle esigenze del provider
    $providerSpecificData = [
        'recipient' => $this->normalizePhoneNumber($smsData->to),
        'message' => $smsData->body,
        'sender' => $smsData->from ?? $this->defaultSender,
        'reference' => (string) Str::uuid(), // Generato internamente
        'scheduledDate' => null, // Non supportato da SmsData, usa valore predefinito
    ];
    
    // Resto dell'implementazione...
}
```

## 6. Errori Comuni da Evitare

1. **Modificare l'interfaccia pubblica**: Mai modificare la firma del metodo `execute` per accettare tipi diversi da `SmsData`
2. **Duplicare la logica**: Utilizzare metodi privati/protetti per la logica comune tra le azioni
3. **Accesso diretto alla configurazione**: Utilizzare il pattern corretto per accedere alla configurazione
4. **Ignorare la gestione degli errori**: Implementare sempre una gestione robusta degli errori

## 7. Esempi di Implementazione

### SendNetfunSMSAction

```php
<?php

declare(strict_types=1);

namespace Modules\Notify\Actions\SMS;

use Exception;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Modules\Notify\Actions\SMS\SmsActionInterface;
use Modules\Notify\Datas\SmsData;
use Spatie\QueueableAction\QueueableAction;

final class SendNetfunSMSAction implements SmsActionInterface
{
    use QueueableAction;

    public string $token;
    public string $endpoint;
    public array $vars = [];
    protected bool $debug;
    protected int $timeout;
    protected ?string $defaultSender;

    public function __construct()
    {
        // Parametri specifici del provider
        $token = config('sms.drivers.netfun.token');
        if (!is_string($token)) {
            throw new Exception('Token API Netfun non configurato. Aggiungere NETFUN_TOKEN al file .env');
        }
        $this->token = $token;
        $this->endpoint = config('sms.drivers.netfun.api_url', 'https://v2.smsviainternet.it/api/rest/v1/sms-batch.json');

        // Parametri a livello di root
        $this->defaultSender = config('sms.from');
        $this->debug = (bool) config('sms.debug', false);
        $this->timeout = (int) config('sms.timeout', 30);
    }

    public function execute(SmsData $smsData): array
    {
        // Implementazione...
    }
}
```

## 8. Conclusioni

Seguire questo pattern garantisce:

1. **Coerenza**: Tutte le azioni SMS hanno la stessa interfaccia
2. **Manutenibilità**: Il codice è più facile da mantenere e aggiornare
3. **Estensibilità**: È facile aggiungere nuovi provider SMS
4. **Testabilità**: Le azioni sono facilmente testabili grazie all'interfaccia comune

---

*Ultimo aggiornamento: 2023-05-12*
