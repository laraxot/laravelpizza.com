# Aggiornamenti a SendNetfunSMSAction

## Panoramica delle Modifiche

La classe `SendNetfunSMSAction` è stata completamente rivista per allinearla con le best practice del progetto  e con il pattern di configurazione standardizzato per i servizi SMS. Inoltre, è stato creato un nuovo DTO `SmsMessageData` per standardizzare la gestione dei dati SMS.
La classe `SendNetfunSMSAction` è stata completamente rivista per allinearla con le best practice del progetto <nome progetto> e con il pattern di configurazione standardizzato per i servizi SMS. Inoltre, è stato creato un nuovo DTO `SmsMessageData` per standardizzare la gestione dei dati SMS.

## 1. Correzioni alla Configurazione

### 1.1. Accesso Corretto alla Configurazione

**Prima**:
```php
$token = config('services.netfun.token');
```

**Dopo**:
```php
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
```

**Miglioramenti**:
- Accesso corretto a `sms.drivers.netfun.*` invece di `services.netfun.*`
- Implementazione della logica di precedenza tra parametri a livello di root e specifici per provider
- Validazione dei parametri di configurazione obbligatori
- Tipizzazione corretta dei parametri di configurazione

## 2. Autenticazione con Token

### 2.1. Implementazione dell'Autenticazione con Token

**Prima**:
```php
// Mancava una chiara implementazione dell'autenticazione
```

**Dopo**:
```php
// Prepara il corpo della richiesta secondo le specifiche dell'API Netfun
$body = [
    'api_token' => $this->token,
    'sender' => $sender,
    'text_template' => $message,
    'async' => true,
    'utf8_enabled' => true,
    'destinations' => [
        [
            'number' => $recipient,
        ],
    ],
];
```

**Miglioramenti**:
- Implementazione corretta dell'autenticazione tramite token
- Struttura della richiesta conforme alle specifiche dell'API Netfun
- Parametri aggiuntivi per migliorare la compatibilità con l'API

## 3. Gestione DTO

### 3.1. Supporto per Diversi Tipi di DTO

**Prima**:
```php
// Supporto limitato per i diversi tipi di DTO
```

**Dopo**:
```php
// Gestione di diversi tipi di DTO
if ($smsData instanceof SmsData) {
    $recipient = $this->normalizePhoneNumber($smsData->to);
    $message = $smsData->body;
    $sender = $smsData->from ?? $this->defaultSender;
    $reference = (string) Str::uuid();
    $scheduledDate = null;
} elseif ($smsData instanceof NetfunSmsData) {
    $recipient = $this->normalizePhoneNumber($smsData->recipient);
    $message = $smsData->message;
    $sender = $smsData->sender ?? $this->defaultSender;
    $reference = $smsData->reference ?? (string) Str::uuid();
    $scheduledDate = $smsData->scheduledDate;
} else {
    throw new Exception('Tipo di dati SMS non supportato. Utilizzare NetfunSmsData o SmsData.');
}
```

**Miglioramenti**:
- Supporto completo per diversi tipi di DTO (`SmsData`, `NetfunSmsData`)
- Implementazione della logica di fallback per i campi mancanti
- Validazione del tipo di DTO in ingresso
- Generazione automatica di un reference UUID se non fornito

### 3.2. Nuovo DTO SmsMessageData

È stato creato un nuovo DTO `SmsMessageData` per standardizzare la gestione dei dati SMS:

```php
<?php

declare(strict_types=1);

namespace Modules\Notify\Datas;

readonly class SmsMessageData
{
    public function __construct(
        public string $recipient,
        public string $message,
        public ?string $sender = null,
        public ?string $reference = null,
        public ?string $scheduledDate = null,
    ) {}
}
```

**Caratteristiche**:
- Classe `readonly` per garantire l'immutabilità dei dati
- Proprietà tipizzate con tipi nullable dove appropriato
- Namespace corretto `Modules\Notify\Datas` (senza `App`)
- Posizionato direttamente nella directory `Datas/` e non in sottodirectory

## 4. Gestione Errori

### 4.1. Gestione Errori Robusta

**Prima**:
```php
try {
    $response = $client->post($endpoint, ['json' => $body]);
} catch (ClientException $clientException) {
    throw new Exception($clientException->getMessage().'['.__LINE__.']['.class_basename($this).']', $clientException->getCode(), $clientException);
}
```

**Dopo**:
```php
try {
    $response = $client->post($this->endpoint, ['json' => $body]);
    $statusCode = $response->getStatusCode();
    $responseContent = $response->getBody()->getContents();
    $responseData = json_decode($responseContent, true);
    
    // Salva i dati della risposta nelle variabili dell'azione
    $this->vars['status_code'] = $statusCode;
    $this->vars['status_txt'] = $responseContent;
    $this->vars['response_data'] = $responseData;
    
    Log::info('SMS Netfun inviato con successo', [
        'to' => $recipient,
        'reference' => $reference,
        'response_code' => $statusCode,
    ]);
    
    return [
        'success' => ($statusCode >= 200 && $statusCode < 300),
        'message_id' => $responseData['id'] ?? null,
        'reference' => $reference,
        'response' => $responseData,
        'vars' => $this->vars,
    ];
} catch (ClientException $e) {
    $response = $e->getResponse();
    $statusCode = $response->getStatusCode();
    $responseBody = json_decode($response->getBody()->getContents(), true);
    
    // Salva i dati dell'errore nelle variabili dell'azione
    $this->vars['error_code'] = $statusCode;
    $this->vars['error_message'] = $e->getMessage();
    $this->vars['error_response'] = $responseBody;
    
    Log::warning('Errore invio SMS Netfun', [
        'to' => $recipient,
        'reference' => $reference,
        'status' => $statusCode,
        'response' => $responseBody,
    ]);
    
    return [
        'success' => false,
        'error' => $responseBody['message'] ?? 'Errore sconosciuto',
        'reference' => $reference,
        'status_code' => $statusCode,
        'vars' => $this->vars,
    ];
}
```

**Miglioramenti**:
- Gestione dettagliata degli errori HTTP
- Logging completo degli errori e delle risposte
- Struttura di risposta standardizzata con campi `success`, `error`, `reference`, ecc.
- Salvataggio dei dati della risposta nelle variabili dell'azione per debugging

### 4.2. Logging Avanzato

**Prima**:
```php
// Logging limitato
```

**Dopo**:
```php
// Log di debug se abilitato
if ($this->debug) {
    Log::debug('Invio SMS Netfun', [
        'to' => $recipient,
        'from' => $sender,
        'message_length' => strlen($message),
        'reference' => $reference,
    ]);
}

// Log di successo
Log::info('SMS Netfun inviato con successo', [
    'to' => $recipient,
    'reference' => $reference,
    'response_code' => $statusCode,
]);

// Log di errore
Log::warning('Errore invio SMS Netfun', [
    'to' => $recipient,
    'reference' => $reference,
    'status' => $statusCode,
    'response' => $responseBody,
]);

// Log di eccezione
Log::error('Eccezione durante invio SMS Netfun', [
    'to' => $recipient,
    'reference' => $reference,
    'error' => $e->getMessage(),
    'exception' => get_class($e),
    'line' => __LINE__,
    'class' => class_basename($this),
]);
```

**Miglioramenti**:
- Logging differenziato per livello (debug, info, warning, error)
- Inclusione di dettagli rilevanti nei log (recipient, reference, status code, ecc.)
- Logging condizionale basato sul flag di debug
- Tracciamento completo delle eccezioni

## 5. Normalizzazione dei Numeri di Telefono

### 5.1. Implementazione della Normalizzazione

```php
/**
 * Normalizza il numero di telefono nel formato E.164
 * 
 * @param string $phoneNumber Numero di telefono da normalizzare
 * @return string Numero di telefono normalizzato in formato E.164
 */
protected function normalizePhoneNumber(string $phoneNumber): string
{
    // Rimuovi tutti i caratteri non numerici tranne il +
    $cleaned = preg_replace('/[^0-9+]/', '', $phoneNumber);
    
    // Se il numero non inizia con '+'
    if (!Str::startsWith($cleaned, '+')) {
        // Se il numero inizia con '00', sostituisci con '+'
        if (Str::startsWith($cleaned, '00')) {
            $cleaned = '+' . substr($cleaned, 2);
        } 
        // Se il numero inizia con '3' (cellulare italiano), aggiungi prefisso italiano
        elseif (Str::startsWith($cleaned, '3')) {
            $cleaned = '+39' . $cleaned;
        }
        // Altri numeri senza prefisso internazionale, assumiamo Italia
        else {
            $cleaned = '+39' . $cleaned;
        }
    }
    
    // Valida il numero secondo il formato E.164
    $pattern = '/^\+[1-9]\d{1,14}$/';
    if (!preg_match($pattern, $cleaned)) {
        Log::warning('Numero di telefono non valido secondo formato E.164', [
            'original' => $phoneNumber,
            'normalized' => $cleaned,
        ]);
    }
    
    return $cleaned;
}
```

**Caratteristiche**:
- Normalizzazione dei numeri di telefono nel formato E.164
- Gestione di diversi formati di input (con/senza prefisso internazionale)
- Validazione del formato E.164
- Logging dei numeri di telefono non validi

## 6. Conclusioni

Le modifiche apportate a `SendNetfunSMSAction` e l'aggiunta del nuovo DTO `SmsMessageData` hanno migliorato significativamente la qualità e la robustezza del codice, allineandolo con le best practice del progetto  e con i pattern di configurazione standardizzati.
Le modifiche apportate a `SendNetfunSMSAction` e l'aggiunta del nuovo DTO `SmsMessageData` hanno migliorato significativamente la qualità e la robustezza del codice, allineandolo con le best practice del progetto <nome progetto> e con i pattern di configurazione standardizzati.

Questi miglioramenti garantiscono:
1. Maggiore manutenibilità del codice
2. Migliore gestione degli errori e logging
3. Supporto per diversi tipi di DTO
4. Normalizzazione corretta dei numeri di telefono
5. Configurazione standardizzata e coerente

---

*Ultimo aggiornamento: 2023-05-12*
