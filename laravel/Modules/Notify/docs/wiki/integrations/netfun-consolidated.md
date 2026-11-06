---
qmd: "netfun consolidated"
issues: []
discussions: []
title: "netfun: Consolidated Documentation"
module: notify
type: integration
tags: [integrations, modules, notify]
created: 2026-08-24
updated: 2026-08-24
status: draft
---

# netfun: Consolidated Documentation

Consolidated from **20** individual files.

## Table of Contents

- [---](#netfun-action-errors-1)
- [Errori in SendNetfunSMSAction e Correzioni](#netfun-action-errors)
- [Aggiornamenti a SendNetfunSMSAction](#netfun-action-updates-1)
- [---](#netfun-action-updates-2)
- [Aggiornamenti a SendNetfunSMSAction](#netfun-action-updates)
- [Errori in SendNetfunSMSAction e Correzioni](#netfun-actions)
- [Implementazione Canale Netfun](#netfun-channel-1)
- [---](#netfun-channel-2)
- [Implementazione Canale Netfun](#netfun-channel)
- [---](#netfun-config-requirements-1)
- [Requisiti di Configurazione per Netfun SMS](#netfun-config-requirements)
- [Esempi Pratici Netfun](#netfun-examples-1)
- [---](#netfun-examples-2)
- [Esempi Pratici Netfun](#netfun-examples)
- [Errori in SendNetfunSMSAction e Correzioni](#netfun_action_errors)
- [Aggiornamenti a SendNetfunSMSAction](#netfun_action_updates)
- [Implementazione Canale Netfun](#netfun_channel)
- [Requisiti di Configurazione per Netfun SMS](#netfun_config_requirements)
- [Esempi Pratici Netfun](#netfun_examples)
- [Risoluzione conflitto NetfunChannel.php](#netfunchannel-conflict-resolution)

---

## netfun-action-errors-1

*Consolidated from: `netfun-action-errors.md`*

title: "Errori in SendNetfunSMSAction e Correzioni"
type: concept
tags: [netfun, action, errors]
created: 2026-07-14
updated: 2026-07-14
qmd: "netfun-action-errors-1 errori in sendnetfunsmsaction e correzioni"
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

# Errori in SendNetfunSMSAction e Correzioni

## Errori Identificati

Nella classe `SendNetfunSMSAction` sono stati identificati diversi errori che non rispettano le best practice e la configurazione standardizzata SMS. Questo documento elenca gli errori e le correzioni apportate.

## 1. Errori di Configurazione

### 1.1. Accesso Diretto alla Configurazione Specifica

**Errore**:
```php
$this->username = config('sms.netfun.username');
$this->password = config('sms.netfun.password');
$this->sender = config('sms.netfun.sender');
$this->apiUrl = config('sms.netfun.api_url');
```

**Problemi**:
- Accesso diretto a `sms.netfun.*` invece di `sms.drivers.netfun.*`
- Non rispetta la struttura standardizzata della configurazione
- Non implementa la logica di precedenza tra parametri a livello di root e specifici per provider

**Correzione**:
```php
$config = config('sms');
$driver = 'netfun';

// Parametri specifici per provider
$this->token = $config['drivers'][$driver]['token'] ?? null;
$this->apiUrl = $config['drivers'][$driver]['api_url'] ?? null;

// Parametri a livello di root con logica di precedenza
$this->from = $config['drivers'][$driver]['from'] ?? $config['from'] ?? null;
$this->debug = $config['drivers'][$driver]['debug'] ?? $config['debug'] ?? false;
```

## 2. Errori di Autenticazione

### 2.1. Uso di Username/Password invece di Token

**Errore**:
```php
protected string $username;
protected string $password;
// ...
$response = Http::post($this->apiUrl, [
    'username' => $this->username,
    'password' => $this->password,
    // ...
]);
```

**Problemi**:
- Utilizza `username` e `password` per l'autenticazione
- Netfun utilizza esclusivamente token (API key) per l'autenticazione

**Correzione**:
```php
protected ?string $token;
// ...
$response = Http::post($this->apiUrl, [
    'token' => $this->token,
    // ...
]);
```

## 3. Errori di Nomenclatura

### 3.1. Uso di 'sender' invece di 'from'

**Errore**:
```php
protected string $sender;
// ...
'sender' => $options['sender'] ?? $this->sender,
```

**Problemi**:
- Utilizza `sender` invece del nome standardizzato `from`
- Non rispetta la nomenclatura coerente tra i provider

**Correzione**:
```php
protected ?string $from;
// ...
'from' => $from,
```

## 4. Errori di Tipizzazione

### 4.1. Mancato Utilizzo di Tipi Nullable

**Errore**:
```php
protected string $username;
protected string $password;
protected string $sender;
protected string $apiUrl;
```

**Problemi**:
- Le proprietà sono dichiarate come `string` non nullable
- I valori potrebbero essere null se la configurazione non è presente

**Correzione**:
```php
protected ?string $token;
protected ?string $from;
protected ?string $apiUrl;
protected bool $debug;
```

## 5. Errori di Design

### 5.1. Mancato Utilizzo di DTO

**Errore**:
```php
public function execute(string $to, string $message, array $options = [])
```

**Problemi**:
- Accetta parametri primitivi invece di un DTO strutturato
- Rende difficile l'evoluzione dell'API senza breaking changes

**Correzione**:
```php
/**
 * @param SmsMessageData|string $to Destinatario o oggetto SmsMessageData
 * @param string|null $message Testo del messaggio (opzionale se si usa SmsMessageData)
 */
public function execute($to, ?string $message = null, array $options = [])
{
    // Gestione di SmsMessageData o parametri separati
    if ($to instanceof SmsMessageData) {
        $smsData = $to;
        $recipient = $this->normalizePhoneNumber($smsData->recipient);
        $messageText = $smsData->message;
        $from = $smsData->from ?? $this->from;
        // ...
    } else {
        // Retrocompatibilità
        // ...
    }
}
```

### 5.2. Mancata Validazione dei Parametri di Configurazione

**Errore**: Nessuna validazione dei parametri di configurazione obbligatori.

**Correzione**:
```php
// Verifica se i parametri di configurazione sono presenti
if (!$this->token || !$this->apiUrl) {
    throw new \RuntimeException('Configurazione Netfun incompleta: token o api_url mancanti');
}
```

### 5.3. Mancato Utilizzo del Debug Flag

**Errore**: Nessun utilizzo del flag di debug per il logging dettagliato.

**Correzione**:
```php
// Log di debug se abilitato
if ($this->debug) {
    Log::debug('Invio SMS Netfun', [
        'to' => $recipient,
        'from' => $from,
        'message_length' => strlen($messageText),
        'reference' => $reference,
    ]);
}
```

## 6. Conclusioni

Le correzioni apportate allineano la classe `SendNetfunSMSAction` con:

1. La struttura standardizzata della configurazione SMS
2. Le best practice di Laravel e PHP 8.2+
3. L'uso corretto dell'autenticazione Netfun con token
4. La nomenclatura standardizzata tra i provider
5. L'utilizzo di DTO per i dati in ingresso
6. La validazione appropriata dei parametri di configurazione
7. L'implementazione della logica di precedenza tra parametri a livello di root e specifici per provider

Queste correzioni garantiscono che l'azione funzioni correttamente con la configurazione standardizzata e sia più robusta, manutenibile ed estensibile.

---

*Ultimo aggiornamento: 2025-05-12*
---

## netfun-action-errors

*Consolidated from: `netfun-action-errors.md`*


## Errori Identificati

Nella classe `SendNetfunSMSAction` sono stati identificati diversi errori che non rispettano le best practice e la configurazione standardizzata SMS. Questo documento elenca gli errori e le correzioni apportate.

## 1. Errori di Configurazione

### 1.1. Accesso Diretto alla Configurazione Specifica

**Errore**:
```php
$this->username = config('sms.netfun.username');
$this->password = config('sms.netfun.password');
$this->sender = config('sms.netfun.sender');
$this->apiUrl = config('sms.netfun.api_url');
```

**Problemi**:
- Accesso diretto a `sms.netfun.*` invece di `sms.drivers.netfun.*`
- Non rispetta la struttura standardizzata della configurazione
- Non implementa la logica di precedenza tra parametri a livello di root e specifici per provider

**Correzione**:
```php
$config = config('sms');
$driver = 'netfun';

// Parametri specifici per provider
$this->token = $config['drivers'][$driver]['token'] ?? null;
$this->apiUrl = $config['drivers'][$driver]['api_url'] ?? null;

// Parametri a livello di root con logica di precedenza
$this->from = $config['drivers'][$driver]['from'] ?? $config['from'] ?? null;
$this->debug = $config['drivers'][$driver]['debug'] ?? $config['debug'] ?? false;
```

## 2. Errori di Autenticazione

### 2.1. Uso di Username/Password invece di Token

**Errore**:
```php
protected string $username;
protected string $password;
// ...
$response = Http::post($this->apiUrl, [
    'username' => $this->username,
    'password' => $this->password,
    // ...
]);
```

**Problemi**:
- Utilizza `username` e `password` per l'autenticazione
- Netfun utilizza esclusivamente token (API key) per l'autenticazione

**Correzione**:
```php
protected ?string $token;
// ...
$response = Http::post($this->apiUrl, [
    'token' => $this->token,
    // ...
]);
```

## 3. Errori di Nomenclatura

### 3.1. Uso di 'sender' invece di 'from'

**Errore**:
```php
protected string $sender;
// ...
'sender' => $options['sender'] ?? $this->sender,
```

**Problemi**:
- Utilizza `sender` invece del nome standardizzato `from`
- Non rispetta la nomenclatura coerente tra i provider

**Correzione**:
```php
protected ?string $from;
// ...
'from' => $from,
```

## 4. Errori di Tipizzazione

### 4.1. Mancato Utilizzo di Tipi Nullable

**Errore**:
```php
protected string $username;
protected string $password;
protected string $sender;
protected string $apiUrl;
```

**Problemi**:
- Le proprietà sono dichiarate come `string` non nullable
- I valori potrebbero essere null se la configurazione non è presente

**Correzione**:
```php
protected ?string $token;
protected ?string $from;
protected ?string $apiUrl;
protected bool $debug;
```

## 5. Errori di Design

### 5.1. Mancato Utilizzo di DTO

**Errore**:
```php
public function execute(string $to, string $message, array $options = [])
```

**Problemi**:
- Accetta parametri primitivi invece di un DTO strutturato
- Rende difficile l'evoluzione dell'API senza breaking changes

**Correzione**:
```php
/**
 * @param SmsMessageData|string $to Destinatario o oggetto SmsMessageData
 * @param string|null $message Testo del messaggio (opzionale se si usa SmsMessageData)
 */
public function execute($to, ?string $message = null, array $options = [])
{
    // Gestione di SmsMessageData o parametri separati
    if ($to instanceof SmsMessageData) {
        $smsData = $to;
        $recipient = $this->normalizePhoneNumber($smsData->recipient);
        $messageText = $smsData->message;
        $from = $smsData->from ?? $this->from;
        // ...
    } else {
        // Retrocompatibilità
        // ...
    }
}
```

### 5.2. Mancata Validazione dei Parametri di Configurazione

**Errore**: Nessuna validazione dei parametri di configurazione obbligatori.

**Correzione**:
```php
// Verifica se i parametri di configurazione sono presenti
if (!$this->token || !$this->apiUrl) {
    throw new \RuntimeException('Configurazione Netfun incompleta: token o api_url mancanti');
}
```

### 5.3. Mancato Utilizzo del Debug Flag

**Errore**: Nessun utilizzo del flag di debug per il logging dettagliato.

**Correzione**:
```php
// Log di debug se abilitato
if ($this->debug) {
    Log::debug('Invio SMS Netfun', [
        'to' => $recipient,
        'from' => $from,
        'message_length' => strlen($messageText),
        'reference' => $reference,
    ]);
}
```

## 6. Conclusioni

Le correzioni apportate allineano la classe `SendNetfunSMSAction` con:

1. La struttura standardizzata della configurazione SMS
2. Le best practice di Laravel e PHP 8.2+
3. L'uso corretto dell'autenticazione Netfun con token
4. La nomenclatura standardizzata tra i provider
5. L'utilizzo di DTO per i dati in ingresso
6. La validazione appropriata dei parametri di configurazione
7. L'implementazione della logica di precedenza tra parametri a livello di root e specifici per provider

Queste correzioni garantiscono che l'azione funzioni correttamente con la configurazione standardizzata e sia più robusta, manutenibile ed estensibile.

---

*Ultimo aggiornamento: [DATE]*

---

## netfun-action-updates-1

*Consolidated from: `netfun-action-updates.md`*


## Panoramica delle Modifiche

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

Le modifiche apportate a `SendNetfunSMSAction` e l'aggiunta del nuovo DTO `SmsMessageData` hanno migliorato significativamente la qualità e la robustezza del codice, allineandolo con le best practice del progetto <nome progetto> e con i pattern di configurazione standardizzati.

Questi miglioramenti garantiscono:
1. Maggiore manutenibilità del codice
2. Migliore gestione degli errori e logging
3. Supporto per diversi tipi di DTO
4. Normalizzazione corretta dei numeri di telefono
5. Configurazione standardizzata e coerente

---

*Ultimo aggiornamento: 2023-05-12*

---

## netfun-action-updates-2

*Consolidated from: `netfun-action-updates.md`*

title: "Aggiornamenti a SendNetfunSMSAction"
type: concept
tags: [netfun, action, updates]
created: 2026-07-14
updated: 2026-07-14
qmd: "netfun-action-updates-2 aggiornamenti a sendnetfunsmsaction"
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

# Aggiornamenti a SendNetfunSMSAction

## Panoramica delle Modifiche

La classe `SendNetfunSMSAction` è stata completamente rivista per allinearla con le best practice del progetto App e con il pattern di configurazione standardizzato per i servizi SMS. Inoltre, è stato creato un nuovo DTO `SmsMessageData` per standardizzare la gestione dei dati SMS.

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

Le modifiche apportate a `SendNetfunSMSAction` e l'aggiunta del nuovo DTO `SmsMessageData` hanno migliorato significativamente la qualità e la robustezza del codice, allineandolo con le best practice del progetto App e con i pattern di configurazione standardizzati.

Questi miglioramenti garantiscono:
1. Maggiore manutenibilità del codice
2. Migliore gestione degli errori e logging
3. Supporto per diversi tipi di DTO
4. Normalizzazione corretta dei numeri di telefono
5. Configurazione standardizzata e coerente

---

*Ultimo aggiornamento: 2023-05-12*
---

## netfun-action-updates

*Consolidated from: `netfun-action-updates.md`*


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

*Ultimo aggiornamento: [DATE]*

---

## netfun-actions

*Consolidated from: `netfun-actions.md`*


## Errori Identificati

Nella classe `SendNetfunSMSAction` sono stati identificati diversi errori che non rispettano le best practice e la configurazione standardizzata SMS. Questo documento elenca gli errori e le correzioni apportate.

## 1. Errori di Configurazione

### 1.1. Accesso Diretto alla Configurazione Specifica

**Errore**:
```php
$this->username = config('sms.netfun.username');
$this->password = config('sms.netfun.password');
$this->sender = config('sms.netfun.sender');
$this->apiUrl = config('sms.netfun.api_url');
```

**Problemi**:
- Accesso diretto a `sms.netfun.*` invece di `sms.drivers.netfun.*`
- Non rispetta la struttura standardizzata della configurazione
- Non implementa la logica di precedenza tra parametri a livello di root e specifici per provider

**Correzione**:
```php
$config = config('sms');
$driver = 'netfun';

// Parametri specifici per provider
$this->token = $config['drivers'][$driver]['token'] ?? null;
$this->apiUrl = $config['drivers'][$driver]['api_url'] ?? null;

// Parametri a livello di root con logica di precedenza
$this->from = $config['drivers'][$driver]['from'] ?? $config['from'] ?? null;
$this->debug = $config['drivers'][$driver]['debug'] ?? $config['debug'] ?? false;
```

## 2. Errori di Autenticazione

### 2.1. Uso di Username/Password invece di Token

**Errore**:
```php
protected string $username;
protected string $password;
// ...
$response = Http::post($this->apiUrl, [
    'username' => $this->username,
    'password' => $this->password,
    // ...
]);
```

**Problemi**:
- Utilizza `username` e `password` per l'autenticazione
- Netfun utilizza esclusivamente token (API key) per l'autenticazione

**Correzione**:
```php
protected ?string $token;
// ...
$response = Http::post($this->apiUrl, [
    'token' => $this->token,
    // ...
]);
```

## 3. Errori di Nomenclatura

### 3.1. Uso di 'sender' invece di 'from'

**Errore**:
```php
protected string $sender;
// ...
'sender' => $options['sender'] ?? $this->sender,
```

**Problemi**:
- Utilizza `sender` invece del nome standardizzato `from`
- Non rispetta la nomenclatura coerente tra i provider

**Correzione**:
```php
protected ?string $from;
// ...
'from' => $from,
```

## 4. Errori di Tipizzazione

### 4.1. Mancato Utilizzo di Tipi Nullable

**Errore**:
```php
protected string $username;
protected string $password;
protected string $sender;
protected string $apiUrl;
```

**Problemi**:
- Le proprietà sono dichiarate come `string` non nullable
- I valori potrebbero essere null se la configurazione non è presente

**Correzione**:
```php
protected ?string $token;
protected ?string $from;
protected ?string $apiUrl;
protected bool $debug;
```

## 5. Errori di Design

### 5.1. Mancato Utilizzo di DTO

**Errore**:
```php
public function execute(string $to, string $message, array $options = [])
```

**Problemi**:
- Accetta parametri primitivi invece di un DTO strutturato
- Rende difficile l'evoluzione dell'API senza breaking changes

**Correzione**:
```php
/**
 * @param SmsMessageData|string $to Destinatario o oggetto SmsMessageData
 * @param string|null $message Testo del messaggio (opzionale se si usa SmsMessageData)
 */
public function execute($to, ?string $message = null, array $options = [])
{
    // Gestione di SmsMessageData o parametri separati
    if ($to instanceof SmsMessageData) {
        $smsData = $to;
        $recipient = $this->normalizePhoneNumber($smsData->recipient);
        $messageText = $smsData->message;
        $from = $smsData->from ?? $this->from;
        // ...
    } else {
        // Retrocompatibilità
        // ...
    }
}
```

### 5.2. Mancata Validazione dei Parametri di Configurazione

**Errore**: Nessuna validazione dei parametri di configurazione obbligatori.

**Correzione**:
```php
// Verifica se i parametri di configurazione sono presenti
if (!$this->token || !$this->apiUrl) {
    throw new \RuntimeException('Configurazione Netfun incompleta: token o api_url mancanti');
}
```

### 5.3. Mancato Utilizzo del Debug Flag

**Errore**: Nessun utilizzo del flag di debug per il logging dettagliato.

**Correzione**:
```php
// Log di debug se abilitato
if ($this->debug) {
    Log::debug('Invio SMS Netfun', [
        'to' => $recipient,
        'from' => $from,
        'message_length' => strlen($messageText),
        'reference' => $reference,
    ]);
}
```

## 6. Conclusioni

Le correzioni apportate allineano la classe `SendNetfunSMSAction` con:

1. La struttura standardizzata della configurazione SMS
2. Le best practice di Laravel e PHP 8.2+
3. L'uso corretto dell'autenticazione Netfun con token
4. La nomenclatura standardizzata tra i provider
5. L'utilizzo di DTO per i dati in ingresso
6. La validazione appropriata dei parametri di configurazione
7. L'implementazione della logica di precedenza tra parametri a livello di root e specifici per provider

Queste correzioni garantiscono che l'azione funzioni correttamente con la configurazione standardizzata e sia più robusta, manutenibile ed estensibile.

---

## netfun-channel-1

*Consolidated from: `netfun-channel.md`*


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
SMS_FROM_NAME=<nome progetto>
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

---

## netfun-channel-2

*Consolidated from: `netfun-channel.md`*

title: "Implementazione Canale Netfun"
type: concept
tags: [netfun, channel]
created: 2026-07-14
updated: 2026-07-14
qmd: "netfun-channel-2 implementazione canale netfun"
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
SMS_FROM_NAME=<nome progetto>
SMS_FROM_NAME=App
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
---

## netfun-channel

*Consolidated from: `netfun-channel.md`*


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
SMS_FROM_NAME=
SMS_FROM_NAME=<nome progetto>
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

---

## netfun-config-requirements-1

*Consolidated from: `netfun-config-requirements.md`*

title: "Requisiti di Configurazione per Netfun SMS"
type: concept
tags: [netfun, config, requirements]
created: 2026-07-14
updated: 2026-07-14
qmd: "netfun-config-requirements-1 requisiti di configurazione per netfun sms"
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

# Requisiti di Configurazione per Netfun SMS

Questa guida descrive la configurazione necessaria per utilizzare il provider Netfun come driver SMS nel modulo Notify.

## 1. Parametri Obbligatori

Aggiungi la seguente sezione nel file `config/sms.php`:

```php
'netfun' => [
    //# Requisiti di Configurazione Netfun SMS

## Introduzione

Questo documento descrive i requisiti di configurazione per l'integrazione con il provider SMS Netfun nel modulo Notify, seguendo la [struttura standardizzata della configurazione SMS](./standardized-sms-config-structure.md).

## Struttura di Configurazione

La configurazione di Netfun segue la struttura standardizzata con parametri globali e specifici:

### Parametri Globali (a livello di root)

```php
// Configurazioni globali applicabili a tutti i provider
'from' => env('SMS_FROM'),
'debug' => env('SMS_DEBUG', false),
'retry' => [
    'attempts' => env('SMS_RETRY_ATTEMPTS', 3),
    'delay' => env('SMS_RETRY_DELAY', 60),
],
'rate_limit' => [
    'enabled' => env('SMS_RATE_LIMIT_ENABLED', true),
    'max_attempts' => env('SMS_RATE_LIMIT_MAX_ATTEMPTS', 60),
    'decay_minutes' => env('SMS_RATE_LIMIT_DECAY_MINUTES', 1),
],
```

### Parametri Specifici per Netfun (nella sezione drivers)

```php
'drivers' => [
    'netfun' => [
        // SOLO parametri specifici per Netfun
        'token' => env('NETFUN_TOKEN'),  // Token di autenticazione Netfun
        'api_url' => env('NETFUN_API_URL', 'https://v2.smsviainternet.it/api/rest/v1/sms-batch.json'),
        'circuit_breaker' => [
            'threshold' => env('NETFUN_CIRCUIT_BREAKER_THRESHOLD', 5),
            'timeout' => env('NETFUN_CIRCUIT_BREAKER_TIMEOUT', 60),
        ],
    ],
],
```

## Variabili d'Ambiente Richieste

Le seguenti variabili d'ambiente devono essere configurate nel file `.env` dell'applicazione:

```

# Parametri globali
SMS_FROM=YourSender
SMS_DEBUG=false

# Parametri specifici per Netfun
NETFUN_TOKEN=your_token
NETFUN_API_URL=https://v2.smsviainternet.it/api/rest/v1/sms-batch.json
```

## Note Importanti

1. **Autenticazione**: Netfun richiede un token di autenticazione per accedere alle sue API.
2. **Mittente (from)**: Il mittente è un parametro globale definito come `SMS_FROM` e non deve essere duplicato nella configurazione specifica di Netfun.
3. **Debug**: Il parametro debug è globale e non deve essere duplicato nella configurazione specifica di Netfun.
4. **Nomenclatura**: Utilizzare `token` (non `api_key`) per l'autenticazione Netfun, seguendo la nomenclatura standardizzata.

## Errori Comuni da Evitare

1. **Duplicazione di parametri globali**: Non duplicare parametri come `from`, `debug`, `retry` o `rate_limit` nella configurazione specifica di Netfun.
2. **Nomenclatura inconsistente**: Non utilizzare nomi alternativi come `api_key` invece di `token` o `sender` invece di `from`.
3. **Valori predefiniti hardcoded**: Non includere valori predefiniti hardcoded per parametri che dovrebbero essere configurati nell'ambiente.

## Documentazione Correlata

- [Struttura Standardizzata della Configurazione SMS](./standardized-sms-config-structure.md)
- [Canale SMS Netfun](./sms-netfun-channel.md)
- [Struttura Standardizzata della Configurazione SMS](./standardized-sms-config-structure.md)
- [Canale SMS Netfun](./sms-netfun-channel.md)

## Supporto

Per problemi di configurazione o domande sull'integrazione con Netfun, consultare la documentazione ufficiale di Netfun o contattare il team di supporto.

---

*Ultimo aggiornamento: 2025-05-12*

## 2. Esempio di .env

```
NETFUN_TOKEN=la_tua_api_key
NETFUN_SENDER=MittenteSMS
NETFUN_ENDPOINT=https://v2.smsviainternet.it/api/rest/v1/sms-batch.json

# NETFUN_CALLBACK_URL=https://tuodominio.it/sms/callback
```

## 3. Descrizione Parametri
- **token**: Token di autenticazione Netfun, obbligatoria per autenticazione.
- **sender**: Nome mittente (max 11 caratteri alfanumerici o 15 numerici, secondo policy Netfun).
- **endpoint**: URL endpoint batch Netfun (default consigliato).
- **callback_url**: (Opzionale) URL per ricevere report di consegna (delivery report).
- **options**: (Opzionale) Array per parametri avanzati (es. priorità, report, ecc).

## 4. Note Importanti
- Verifica che la chiave API sia attiva e abbia i permessi per l'invio.
- Il mittente deve essere registrato e approvato da Netfun.
- L'endpoint batch supporta invio multiplo e singolo.
- Per ricevere i report di consegna, configura il callback e assicurati che sia raggiungibile da Netfun.
- Tutti i parametri sensibili devono essere gestiti tramite variabili d'ambiente.

## 5. Riferimenti
- [Documentazione Netfun](https://www.netfunitalia.it/)
- [API Reference Netfun](https://v2.smsviainternet.it/api/rest/v1/sms-batch.json)

## Errori Comuni

1. **Mancata inclusione nel file di configurazione**: Se il provider Netfun non è incluso nella sezione 'drivers' del file `config/sms.php`, si verificheranno errori quando si tenta di utilizzare questo provider.

2. **API Key non valida**: Verificare sempre che l'API Key sia corretta e attiva.

3. **Endpoint errato**: L'endpoint corretto per l'invio di SMS batch è `https://v2.smsviainternet.it/api/rest/v1/sms-batch.json`.

## Checklist di Verifica

- [ ] Configurazione 'netfun' presente nel file `config/sms.php`
- [ ] Variabili d'ambiente configurate nel file `.env`
- [ ] Netfun incluso nei driver supportati nel commento del file di configurazione
- [ ] Endpoint corretto specificato nella configurazione

## Collegamenti

- [Documentazione Completa Netfun Channel](./sms-netfun-channel.md)
- [Esempi di Utilizzo Netfun](./netfun-examples.md)
- [Documentazione Completa Netfun Channel](./sms-netfun-channel.md)
- [Esempi di Utilizzo Netfun](./netfun-examples.md)
- [Risoluzione Conflitti Netfun](./netfunchannel-conflict-resolution.md)

---

*Ultimo aggiornamento: 2025-05-12*
---

## netfun-config-requirements

*Consolidated from: `netfun-config-requirements.md`*


Questa guida descrive la configurazione necessaria per utilizzare il provider Netfun come driver SMS nel modulo Notify.

## 1. Parametri Obbligatori

Aggiungi la seguente sezione nel file `config/sms.php`:

```php
'netfun' => [
    //# Requisiti di Configurazione Netfun SMS

## Introduzione

Questo documento descrive i requisiti di configurazione per l'integrazione con il provider SMS Netfun nel modulo Notify, seguendo la [struttura standardizzata della configurazione SMS](./standardized_sms_config_structure.md).
Questo documento descrive i requisiti di configurazione per l'integrazione con il provider SMS Netfun nel modulo Notify, seguendo la [struttura standardizzata della configurazione SMS](../../standardized_sms_config_structure.md).

## Struttura di Configurazione

La configurazione di Netfun segue la struttura standardizzata con parametri globali e specifici:

### Parametri Globali (a livello di root)

```php
// Configurazioni globali applicabili a tutti i provider
'from' => env('SMS_FROM'),
'debug' => env('SMS_DEBUG', false),
'retry' => [
    'attempts' => env('SMS_RETRY_ATTEMPTS', 3),
    'delay' => env('SMS_RETRY_DELAY', 60),
],
'rate_limit' => [
    'enabled' => env('SMS_RATE_LIMIT_ENABLED', true),
    'max_attempts' => env('SMS_RATE_LIMIT_MAX_ATTEMPTS', 60),
    'decay_minutes' => env('SMS_RATE_LIMIT_DECAY_MINUTES', 1),
],
```

### Parametri Specifici per Netfun (nella sezione drivers)

```php
'drivers' => [
    'netfun' => [
        // SOLO parametri specifici per Netfun
        'token' => env('NETFUN_TOKEN'),  // Token di autenticazione Netfun
        'api_url' => env('NETFUN_API_URL', 'https://v2.smsviainternet.it/api/rest/v1/sms-batch.json'),
        'circuit_breaker' => [
            'threshold' => env('NETFUN_CIRCUIT_BREAKER_THRESHOLD', 5),
            'timeout' => env('NETFUN_CIRCUIT_BREAKER_TIMEOUT', 60),
        ],
    ],
],
```

## Variabili d'Ambiente Richieste

Le seguenti variabili d'ambiente devono essere configurate nel file `.env` dell'applicazione:

```

# Parametri globali
SMS_FROM=YourSender
SMS_DEBUG=false

# Parametri specifici per Netfun
NETFUN_TOKEN=your_token
NETFUN_API_URL=https://v2.smsviainternet.it/api/rest/v1/sms-batch.json
```

## Note Importanti

1. **Autenticazione**: Netfun richiede un token di autenticazione per accedere alle sue API.
2. **Mittente (from)**: Il mittente è un parametro globale definito come `SMS_FROM` e non deve essere duplicato nella configurazione specifica di Netfun.
3. **Debug**: Il parametro debug è globale e non deve essere duplicato nella configurazione specifica di Netfun.
4. **Nomenclatura**: Utilizzare `token` (non `api_key`) per l'autenticazione Netfun, seguendo la nomenclatura standardizzata.

## Errori Comuni da Evitare

1. **Duplicazione di parametri globali**: Non duplicare parametri come `from`, `debug`, `retry` o `rate_limit` nella configurazione specifica di Netfun.
2. **Nomenclatura inconsistente**: Non utilizzare nomi alternativi come `api_key` invece di `token` o `sender` invece di `from`.
3. **Valori predefiniti hardcoded**: Non includere valori predefiniti hardcoded per parametri che dovrebbero essere configurati nell'ambiente.

## Documentazione Correlata

- [Struttura Standardizzata della Configurazione SMS](./standardized_sms_config_structure.md)
- [Canale SMS Netfun](./sms_netfun_channel.md)
- [Struttura Standardizzata della Configurazione SMS](../../standardized_sms_config_structure.md)
- [Canale SMS Netfun](../../sms_netfun_channel.md)

## Supporto

Per problemi di configurazione o domande sull'integrazione con Netfun, consultare la documentazione ufficiale di Netfun o contattare il team di supporto.

---

*Ultimo aggiornamento: [DATE]*

## 2. Esempio di .env

```
NETFUN_TOKEN=la_tua_api_key
NETFUN_SENDER=MittenteSMS
NETFUN_ENDPOINT=https://v2.smsviainternet.it/api/rest/v1/sms-batch.json

# NETFUN_CALLBACK_URL=https://tuodominio.it/sms/callback
```

## 3. Descrizione Parametri
- **token**: Token di autenticazione Netfun, obbligatoria per autenticazione.
- **sender**: Nome mittente (max 11 caratteri alfanumerici o 15 numerici, secondo policy Netfun).
- **endpoint**: URL endpoint batch Netfun (default consigliato).
- **callback_url**: (Opzionale) URL per ricevere report di consegna (delivery report).
- **options**: (Opzionale) Array per parametri avanzati (es. priorità, report, ecc).

## 4. Note Importanti
- Verifica che la chiave API sia attiva e abbia i permessi per l'invio.
- Il mittente deve essere registrato e approvato da Netfun.
- L'endpoint batch supporta invio multiplo e singolo.
- Per ricevere i report di consegna, configura il callback e assicurati che sia raggiungibile da Netfun.
- Tutti i parametri sensibili devono essere gestiti tramite variabili d'ambiente.

## 5. Riferimenti
- [Documentazione Netfun](https://www.netfunitalia.it/)
- [API Reference Netfun](https://v2.smsviainternet.it/api/rest/v1/sms-batch.json)

## Errori Comuni

1. **Mancata inclusione nel file di configurazione**: Se il provider Netfun non è incluso nella sezione 'drivers' del file `config/sms.php`, si verificheranno errori quando si tenta di utilizzare questo provider.

2. **API Key non valida**: Verificare sempre che l'API Key sia corretta e attiva.

3. **Endpoint errato**: L'endpoint corretto per l'invio di SMS batch è `https://v2.smsviainternet.it/api/rest/v1/sms-batch.json`.

## Checklist di Verifica

- [ ] Configurazione 'netfun' presente nel file `config/sms.php`
- [ ] Variabili d'ambiente configurate nel file `.env`
- [ ] Netfun incluso nei driver supportati nel commento del file di configurazione
- [ ] Endpoint corretto specificato nella configurazione

## Collegamenti

- [Documentazione Completa Netfun Channel](./sms_netfun_channel.md)
- [Esempi di Utilizzo Netfun](./netfun_examples.md)
- [Documentazione Completa Netfun Channel](../../sms_netfun_channel.md)
- [Esempi di Utilizzo Netfun](../../netfun_examples.md)
- [Risoluzione Conflitti Netfun](./netfunchannel_conflict_resolution.md)

---

*Ultimo aggiornamento: [DATE]*

---

## netfun-examples-1

*Consolidated from: `netfun-examples.md`*


## 1. Invio SMS OTP

### 1.1 Notification Class
```php
<?php

namespace Modules\Notify\Notifications;

use Illuminate\Support\Carbon;
use Modules\Notify\App\Data\NetfunSmsRequestData;

class OtpSmsNotification extends NetfunSmsNotification
{
    /**
     * @var string
     */
    protected string $otp;

    /**
     * @var Carbon
     */
    protected Carbon $expiresAt;

    /**
     * @param string $otp
     * @param int $minutes
     */
    public function __construct(string $otp, int $minutes = 5)
    {
        $this->otp = $otp;
        $this->expiresAt = now()->addMinutes($minutes);

        parent::__construct(
            message: "Il tuo codice OTP è: {$otp}. Valido fino alle {$this->expiresAt->format('H:i')}.",
            sender: '<nome progetto>'
        );
    }

    /**
     * Get the OTP
     *
     * @return string
     */
    public function getOtp(): string
    {
        return $this->otp;
    }

    /**
     * Get the expiration time
     *
     * @return Carbon
     */
    public function getExpiresAt(): Carbon
    {
        return $this->expiresAt;
    }

    /**
     * Get the Netfun representation of the notification.
     *
     * @param mixed $notifiable
     * @return NetfunSmsRequestData
     */
    public function toNetfun($notifiable): NetfunSmsRequestData
    {
        return new NetfunSmsRequestData(
            to: $notifiable->phone_number,
            text: $this->message,
            from: $this->sender
        );
    }
}
```

### 1.2 Utilizzo
```php
// Nel controller
public function sendOtp(User $user)
{
    try {
        // Genera OTP
        $otp = str_pad(random_int(0, 999999), 6, '0', STR_PAD_LEFT);

        // Salva OTP nel database con scadenza
        $user->update([
            'otp' => $otp,
            'otp_expires_at' => now()->addMinutes(5)
        ]);

        // Invia SMS
        $user->notify(new OtpSmsNotification($otp));

        return response()->json([
            'message' => 'OTP inviato con successo',
            'expires_at' => now()->addMinutes(5)
        ]);

    } catch (\Exception $e) {
        Log::error('Errore invio OTP', [
            'user_id' => $user->id,
            'error' => $e->getMessage()
        ]);

        return response()->json([
            'message' => 'Errore nell\'invio dell\'OTP'
        ], 500);
    }
}

// Verifica OTP
public function verifyOtp(Request $request, User $user)
{
    $request->validate([
        'otp' => 'required|string|size:6'
    ]);

    if ($user->otp !== $request->otp) {
        return response()->json([
            'message' => 'OTP non valido'
        ], 400);
    }

    if ($user->otp_expires_at->isPast()) {
        return response()->json([
            'message' => 'OTP scaduto'
        ], 400);
    }

    // OTP valido, resetta i campi
    $user->update([
        'otp' => null,
        'otp_expires_at' => null
    ]);

    return response()->json([
        'message' => 'OTP verificato con successo'
    ]);
}
```

## 2. Invio SMS Promemoria

### 2.1 Notification Class
```php
<?php

namespace Modules\Notify\Notifications;

use Illuminate\Support\Carbon;
use Modules\Notify\App\Data\NetfunSmsRequestData;

class AppointmentReminderNotification extends NetfunSmsNotification
{
    /**
     * @var Carbon
     */
    protected Carbon $appointmentDate;

    /**
     * @var string
     */
    protected string $doctorName;

    /**
     * @var string
     */
    protected string $location;

    /**
     * @var string|null
     */
    protected ?string $notes;

    /**
     * @param Carbon $appointmentDate
     * @param string $doctorName
     * @param string $location
     * @param string|null $notes
     */
    public function __construct(
        Carbon $appointmentDate,
        string $doctorName,
        string $location,
        ?string $notes = null
    ) {
        $this->appointmentDate = $appointmentDate;
        $this->doctorName = $doctorName;
        $this->location = $location;
        $this->notes = $notes;

        $message = "Promemoria: Hai un appuntamento con {$doctorName} il {$appointmentDate->format('d/m/Y H:i')}";
        $message .= " presso {$location}.";

        if ($notes) {
            $message .= " Note: {$notes}";
        }

        parent::__construct(
            message: $message,
            sender: '<nome progetto>'
        );
    }

    /**
     * Get the Netfun representation of the notification.
     *
     * @param mixed $notifiable
     * @return NetfunSmsRequestData
     */
    public function toNetfun($notifiable): NetfunSmsRequestData
    {
        return new NetfunSmsRequestData(
            to: $notifiable->phone_number,
            text: $this->message,
            from: $this->sender
        );
    }
}
```

### 2.2 Utilizzo
```php
// Nel controller
public function sendReminder(Appointment $appointment)
{
    try {
        // Verifica se l'appuntamento è nel futuro
        if ($appointment->date->isPast()) {
            throw new \Exception('Impossibile inviare promemoria per un appuntamento passato');
        }

        // Verifica se il promemoria è già stato inviato
        if ($appointment->reminder_sent_at) {
            throw new \Exception('Promemoria già inviato');
        }

        // Invia il promemoria
        $appointment->patient->notify(
            new AppointmentReminderNotification(
                appointmentDate: $appointment->date,
                doctorName: $appointment->doctor->name,
                location: $appointment->location,
                notes: $appointment->notes
            )
        );

        // Aggiorna lo stato del promemoria
        $appointment->update([
            'reminder_sent_at' => now()
        ]);

        return response()->json([
            'message' => 'Promemoria inviato con successo'
        ]);

    } catch (\Exception $e) {
        Log::error('Errore invio promemoria', [
            'appointment_id' => $appointment->id,
            'error' => $e->getMessage()
        ]);

        return response()->json([
            'message' => 'Errore nell\'invio del promemoria'
        ], 500);
    }
}
```

## 3. Invio SMS Massivo

### 3.1 Action
```php
<?php

namespace Modules\Notify\Actions;

use Spatie\QueueableAction\QueueableAction;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Cache;
use Modules\Notify\App\Data\NetfunSmsRequestData;
use Modules\Notify\App\Data\NetfunSmsResponseData;

class SendBulkSmsAction
{
    use QueueableAction;

    /**
     * @var Collection
     */
    protected Collection $users;

    /**
     * @var string
     */
    protected string $message;

    /**
     * @var string
     */
    protected string $sender;

    /**
     * @var int
     */
    protected int $batchSize;

    /**
     * @var int
     */
    protected int $delayBetweenBatches;

    /**
     * @param Collection $users
     * @param string $message
     * @param string $sender
     * @param int $batchSize
     * @param int $delayBetweenBatches
     */
    public function __construct(
        Collection $users,
        string $message,
        string $sender,
        int $batchSize = 100,
        int $delayBetweenBatches = 1
    ) {
        $this->users = $users;
        $this->message = $message;
        $this->sender = $sender;
        $this->batchSize = $batchSize;
        $this->delayBetweenBatches = $delayBetweenBatches;
    }

    /**
     * Esegue l'azione di invio SMS massivo
     *
     * @return array
     * @throws \Exception
     */
    public function execute(): array
    {
        $results = [
            'total' => $this->users->count(),
            'success' => 0,
            'failed' => 0,
            'errors' => []
        ];

        try {
            // Prepara il batch di messaggi
            $messages = $this->users->map(function ($user) {
                return new NetfunSmsRequestData(
                    to: $user->phone_number,
                    text: $this->message,
                    from: $this->sender
                );
            })->chunk($this->batchSize);

            // Invia ogni batch
            foreach ($messages as $batch) {
                try {
                    $response = Http::withHeaders([
                        'Authorization' => 'Bearer ' . config('notify.netfun.api_key'),
                        'Content-Type' => 'application/json',
                        'Accept' => 'application/json'
                    ])->timeout(30)->post(config('notify.netfun.endpoint'), [
                        'messages' => $batch->map(fn($message) => $message->toArray())->values()->all()
                    ]);

                    if (!$response->successful()) {
                        throw new \Exception('Errore HTTP: ' . $response->status());
                    }

                    $result = NetfunSmsResponseData::fromArray($response->json());

                    if ($result->status !== 'success') {
                        throw new \Exception($result->error ?? 'Errore sconosciuto');
                    }

                    $results['success'] += $batch->count();

                } catch (\Exception $e) {
                    $results['failed'] += $batch->count();
                    $results['errors'][] = [
                        'batch_size' => $batch->count(),
                        'error' => $e->getMessage()
                    ];

                    Log::error('Errore invio batch SMS', [
                        'error' => $e->getMessage(),
                        'batch_size' => $batch->count()
                    ]);
                }

                // Attendi tra i batch
                if ($this->delayBetweenBatches > 0) {
                    sleep($this->delayBetweenBatches);
                }
            }

            return $results;

        } catch (\Exception $e) {
            Log::error('Eccezione invio SMS massivo', [
                'error' => $e->getMessage(),
                'total_users' => $this->users->count()
            ]);

            throw $e;
        }
    }
}
```

### 3.2 Utilizzo
```php
// Nel controller
public function sendBulkSms(Request $request)
{
    $request->validate([
        'message' => 'required|string|max:160',
        'user_ids' => 'required|array',
        'user_ids.*' => 'exists:users,id'
    ]);

    try {
        $users = User::whereIn('id', $request->user_ids)
            ->where('consent_sms', true)
            ->get();

        if ($users->isEmpty()) {
            return response()->json([
                'message' => 'Nessun utente valido trovato'
            ], 400);
        }

        $results = SendBulkSmsAction::make(
            users: $users,
            message: $request->message,
            sender: '<nome progetto>',
            batchSize: 100,
            delayBetweenBatches: 1
        )->onQueue('bulk-sms')->execute();

        return response()->json([
            'message' => 'Invio SMS massivo completato',
            'results' => $results
        ]);

    } catch (\Exception $e) {
        Log::error('Errore invio SMS massivo', [
            'error' => $e->getMessage(),
            'user_ids' => $request->user_ids
        ]);

        return response()->json([
            'message' => 'Errore nell\'invio degli SMS'
        ], 500);
    }
}
```

## 4. Gestione Errori Avanzata

### 4.1 Action con Retry e Circuit Breaker
```php
<?php

namespace Modules\Notify\Actions;

use Illuminate\Support\Facades\Cache;
use Modules\Notify\App\Data\NetfunSmsResponseData;

class SendNetfunSmsWithRetryAction extends SendNetfunSmsAction
{
    /**
     * @var int
     */
    protected int $maxRetries;

    /**
     * @var int
     */
    protected int $retryDelay;

    /**
     * @var int
     */
    protected int $circuitBreakerThreshold;

    /**
     * @var int
     */
    protected int $circuitBreakerTimeout;

    public function __construct(
        string $to,
        string $message,
        string $sender
    ) {
        parent::__construct($to, $message, $sender);

        $this->maxRetries = config('notify.netfun.max_retries', 3);
        $this->retryDelay = config('notify.netfun.retry_delay', 1);
        $this->circuitBreakerThreshold = config('notify.netfun.circuit_breaker.threshold', 5);
        $this->circuitBreakerTimeout = config('notify.netfun.circuit_breaker.timeout', 60);
    }

    /**
     * Esegue l'azione con retry e circuit breaker
     *
     * @return NetfunSmsResponseData
     * @throws \Exception
     */
    public function execute(): NetfunSmsResponseData
    {
        // Verifica circuit breaker
        if ($this->isCircuitBreakerOpen()) {
            throw new \Exception('Circuit breaker is open');
        }

        $attempts = 0;
        $lastException = null;

        while ($attempts < $this->maxRetries) {
            try {
                $result = parent::execute();

                // Reset circuit breaker on success
                $this->resetCircuitBreaker();

                return $result;

            } catch (\Exception $e) {
                $lastException = $e;
                $attempts++;

                if ($attempts === $this->maxRetries) {
                    // Increment circuit breaker counter
                    $this->incrementCircuitBreaker();

                    Log::error('Tentativi esauriti per invio SMS', [
                        'to' => $this->to,
                        'error' => $e->getMessage(),
                        'attempts' => $attempts
                    ]);

                    throw $e;
                }

                Log::warning('Tentativo fallito, riprovo...', [
                    'attempt' => $attempts,
                    'error' => $e->getMessage()
                ]);

                sleep($this->retryDelay);
            }
        }

        throw $lastException;
    }

    /**
     * Verifica se il circuit breaker è aperto
     *
     * @return bool
     */
    protected function isCircuitBreakerOpen(): bool
    {
        return Cache::get('netfun_circuit_breaker', false);
    }

    /**
     * Incrementa il contatore del circuit breaker
     */
    protected function incrementCircuitBreaker(): void
    {
        $key = 'netfun_circuit_breaker_failures';
        $failures = Cache::get($key, 0) + 1;

        Cache::put($key, $failures, $this->circuitBreakerTimeout);

        if ($failures >= $this->circuitBreakerThreshold) {
            Cache::put('netfun_circuit_breaker', true, $this->circuitBreakerTimeout);
        }
    }

    /**
     * Resetta il circuit breaker
     */
    protected function resetCircuitBreaker(): void
    {
        Cache::forget('netfun_circuit_breaker');
        Cache::forget('netfun_circuit_breaker_failures');
    }
}
```

## 5. Monitoraggio Avanzato

### 5.1 Action con Metriche e Prometheus
```php
<?php

namespace Modules\Notify\Actions;

use Prometheus\CollectorRegistry;
use Modules\Notify\App\Data\NetfunSmsResponseData;

class SendNetfunSmsWithMetricsAction extends SendNetfunSmsAction
{
    /**
     * @var CollectorRegistry
     */
    protected CollectorRegistry $prometheus;

    public function __construct(
        string $to,
        string $message,
        string $sender
    ) {
        parent::__construct($to, $message, $sender);
        $this->prometheus = app(CollectorRegistry::class);
    }

    /**
     * Esegue l'azione con metriche
     *
     * @return NetfunSmsResponseData
     * @throws \Exception
     */
    public function execute(): NetfunSmsResponseData
    {
        $startTime = microtime(true);

        try {
            $result = parent::execute();

            // Registra metriche di successo
            $this->recordMetrics(true, microtime(true) - $startTime, [
                'message_id' => $result->message_id,
                'status' => $result->status
            ]);

            return $result;

        } catch (\Exception $e) {
            // Registra metriche di errore
            $this->recordMetrics(false, microtime(true) - $startTime, [
                'error' => $e->getMessage()
            ]);

            throw $e;
        }
    }

    /**
     * Registra le metriche
     *
     * @param bool $success
     * @param float $duration
     * @param array $context
     */
    protected function recordMetrics(bool $success, float $duration, array $context = []): void
    {
        // Incrementa il contatore totale
        $this->prometheus->getOrRegisterCounter(
            'netfun',
            'sms_total',
            'Total number of SMS sent'
        )->inc();

        // Incrementa il contatore di successo/errore
        $this->prometheus->getOrRegisterCounter(
            'netfun',
            'sms_' . ($success ? 'success' : 'error'),
            'Number of successful/failed SMS'
        )->inc();

        // Registra la durata
        $this->prometheus->getOrRegisterHistogram(
            'netfun',
            'sms_duration_seconds',
            'SMS sending duration in seconds'
        )->observe($duration);

        // Log dettagliato
        Log::info('Metriche SMS', array_merge([
            'success' => $success,
            'duration' => $duration,
            'to' => $this->to,
            'sender' => $this->sender
        ], $context));
    }
}
```

## 6. Esempi di Test

### 6.1 Test Unitario
```php
<?php

namespace Modules\Notify\Tests\Unit;

use Tests\TestCase;
use Modules\Notify\Actions\SendNetfunSmsAction;
use Modules\Notify\App\Data\NetfunSmsResponseData;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;

class NetfunSmsActionTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        Cache::flush();
    }

    public function test_sms_sent_with_valid_data()
    {
        Http::fake([
            config('notify.netfun.endpoint') => Http::response([
                'status' => 'success',
                'message_id' => '123456'
            ], 200)
        ]);

        $action = SendNetfunSmsAction::make(
            to: '+393331234567',
            message: 'Test message',
            sender: 'TEST'
        );

        $result = $action->execute();

        $this->assertInstanceOf(NetfunSmsResponseData::class, $result);
        $this->assertEquals('success', $result->status);
        $this->assertEquals('123456', $result->message_id);

        Http::assertSent(function ($request) {
            return $request->url() == config('notify.netfun.endpoint') &&
                   $request['messages'][0]['to'] == '+393331234567' &&
                   $request['messages'][0]['text'] == 'Test message' &&
                   $request['messages'][0]['from'] == 'TEST';
        });
    }

    public function test_sms_fails_with_invalid_number()
    {
        Http::fake([
            config('notify.netfun.endpoint') => Http::response([
                'status' => 'error',
                'error' => 'Invalid phone number'
            ], 400)
        ]);

        $this->expectException(\Exception::class);

        $action = SendNetfunSmsAction::make(
            to: 'invalid',
            message: 'Test message',
            sender: 'TEST'
        );

        $action->execute();
    }

    public function test_rate_limiting()
    {
        $action = SendNetfunSmsAction::make(
            to: '+393331234567',
            message: 'Test message',
            sender: 'TEST'
        );

        // Simula il raggiungimento del rate limit
        Cache::put('netfun_rate_limit_' . date('YmdHis'), 100, 60);

        $this->expectException(\Exception::class);
        $this->expectExceptionMessage('Rate limit exceeded');

        $action->execute();
    }

    public function test_circuit_breaker()
    {
        $action = new SendNetfunSmsWithRetryAction(
            to: '+393331234567',
            message: 'Test message',
            sender: 'TEST'
        );

        // Simula il circuit breaker aperto
        Cache::put('netfun_circuit_breaker', true, 60);

        $this->expectException(\Exception::class);
        $this->expectExceptionMessage('Circuit breaker is open');

        $action->execute();
    }
}
```

### 6.2 Test di Integrazione
```php
<?php

namespace Modules\Notify\Tests\Feature;

use Tests\TestCase;
use Modules\Patient\Models\User;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Queue;
use Illuminate\Support\Facades\Cache;

class NetfunNotificationIntegrationTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        Queue::fake();
        Cache::flush();
    }

    public function test_otp_notification_sent()
    {
        Http::fake([
            config('notify.netfun.endpoint') => Http::response([
                'status' => 'success',
                'message_id' => '123456'
            ], 200)
        ]);

        $user = User::factory()->create([
            'phone_number' => '+393331234567',
            'consent_sms' => true
        ]);

        $otp = '123456';

        $user->notify(new OtpSmsNotification($otp));

        Http::assertSent(function ($request) use ($otp) {
            return $request->url() == config('notify.netfun.endpoint') &&
                   $request['messages'][0]['to'] == '+393331234567' &&
                   str_contains($request['messages'][0]['text'], $otp);
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

    public function test_bulk_sms_sent()
    {
        Http::fake([
            config('notify.netfun.endpoint') => Http::response([
                'status' => 'success',
                'message_id' => '123456'
            ], 200)
        ]);

        $users = User::factory()->count(3)->create([
            'consent_sms' => true
        ]);

        $results = SendBulkSmsAction::make(
            users: $users,
            message: 'Test message',
            sender: 'TEST'
        )->execute();

        $this->assertEquals(3, $results['total']);
        $this->assertEquals(3, $results['success']);
        $this->assertEquals(0, $results['failed']);

        Http::assertSentCount(1);
    }

    public function test_metrics_recorded()
    {
        $action = new SendNetfunSmsWithMetricsAction(
            to: '+393331234567',
            message: 'Test message',
            sender: 'TEST'
        );

        $metrics = $action->recordMetrics(true, 0.5, [
            'message_id' => '123456'
        ]);

        $this->assertTrue($metrics['success']);
        $this->assertEquals(0.5, $metrics['duration']);
        $this->assertEquals('123456', $metrics['message_id']);
    }
}
```

## 7. Collegamenti Utili

- [Documentazione Netfun](https://www.netfunitalia.it/)
- [API Netfun](https://v2.smsviainternet.it/api/rest/v1/)
- [Spatie Queueable Action](https://github.com/spatie/laravel-queueable-action)
- [Spatie Laravel Data](https://github.com/spatie/laravel-data)
- [Laravel Notifications](https://laravel.com/docs/notifications)
- [Laravel Queues](https://laravel.com/docs/queues)
- [Laravel Testing](https://laravel.com/docs/testing)
- [Laravel Logging](https://laravel.com/docs/logging)
- [Laravel Cache](https://laravel.com/docs/cache)
- [Prometheus PHP Client](https://github.com/promphp/prometheus_client_php)

---

## netfun-examples-2

*Consolidated from: `netfun-examples.md`*

title: "Netfun Examples"
type: concept
tags: [netfun, examples]
created: 2026-07-14
updated: 2026-07-14
qmd: "netfun-examples-2 netfun examples"
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

                appointmentDate: $appointment->date,
                doctorName: $appointment->doctor->name,
                location: $appointment->location,
                notes: $appointment->notes
            )
        );

        // Aggiorna lo stato del promemoria
        $appointment->update([
            'reminder_sent_at' => now()
        ]);

        return response()->json([
            'message' => 'Promemoria inviato con successo'
        ]);

    } catch (\Exception $e) {
        Log::error('Errore invio promemoria', [
            'appointment_id' => $appointment->id,
            'error' => $e->getMessage()
        ]);

        return response()->json([
            'message' => 'Errore nell\'invio del promemoria'
        ], 500);
    }
}
```

## 3. Invio SMS Massivo

### 3.1 Action
```php
<?php

namespace Modules\Notify\Actions;

use Spatie\QueueableAction\QueueableAction;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Cache;
use Modules\Notify\App\Data\NetfunSmsRequestData;
use Modules\Notify\App\Data\NetfunSmsResponseData;

class SendBulkSmsAction
{
    use QueueableAction;

    /**
     * @var Collection
     */
    protected Collection $users;

    /**
     * @var string
     */
    protected string $message;

    /**
     * @var string
     */
    protected string $sender;

    /**
     * @var int
     */
    protected int $batchSize;

    /**
     * @var int
     */
    protected int $delayBetweenBatches;

    /**
     * @param Collection $users
     * @param string $message
     * @param string $sender
     * @param int $batchSize
     * @param int $delayBetweenBatches
     */
    public function __construct(
        Collection $users,
        string $message,
        string $sender,
        int $batchSize = 100,
        int $delayBetweenBatches = 1
    ) {
        $this->users = $users;
        $this->message = $message;
        $this->sender = $sender;
        $this->batchSize = $batchSize;
        $this->delayBetweenBatches = $delayBetweenBatches;
    }

    /**
     * Esegue l'azione di invio SMS massivo
     *
     * @return array
     * @throws \Exception
     */
    public function execute(): array
    {
        $results = [
            'total' => $this->users->count(),
            'success' => 0,
            'failed' => 0,
            'errors' => []
        ];

        try {
            // Prepara il batch di messaggi
            $messages = $this->users->map(function ($user) {
                return new NetfunSmsRequestData(
                    to: $user->phone_number,
                    text: $this->message,
                    from: $this->sender
                );
            })->chunk($this->batchSize);

            // Invia ogni batch
            foreach ($messages as $batch) {
                try {
                    $response = Http::withHeaders([
                        'Authorization' => 'Bearer ' . config('notify.netfun.api_key'),
                        'Content-Type' => 'application/json',
                        'Accept' => 'application/json'
                    ])->timeout(30)->post(config('notify.netfun.endpoint'), [
                        'messages' => $batch->map(fn($message) => $message->toArray())->values()->all()
                    ]);

                    if (!$response->successful()) {
                        throw new \Exception('Errore HTTP: ' . $response->status());
                    }

                    $result = NetfunSmsResponseData::fromArray($response->json());

                    if ($result->status !== 'success') {
                        throw new \Exception($result->error ?? 'Errore sconosciuto');
                    }

                    $results['success'] += $batch->count();

                } catch (\Exception $e) {
                    $results['failed'] += $batch->count();
                    $results['errors'][] = [
                        'batch_size' => $batch->count(),
                        'error' => $e->getMessage()
                    ];

                    Log::error('Errore invio batch SMS', [
                        'error' => $e->getMessage(),
                        'batch_size' => $batch->count()
                    ]);
                }

                // Attendi tra i batch
                if ($this->delayBetweenBatches > 0) {
                    sleep($this->delayBetweenBatches);
                }
            }

            return $results;

        } catch (\Exception $e) {
            Log::error('Eccezione invio SMS massivo', [
                'error' => $e->getMessage(),
                'total_users' => $this->users->count()
            ]);

            throw $e;
        }
    }
}
```

### 3.2 Utilizzo
```php
// Nel controller
public function sendBulkSms(Request $request)
{
    $request->validate([
        'message' => 'required|string|max:160',
        'user_ids' => 'required|array',
        'user_ids.*' => 'exists:users,id'
    ]);

    try {
        $users = User::whereIn('id', $request->user_ids)
            ->where('consent_sms', true)
            ->get();

        if ($users->isEmpty()) {
            return response()->json([
                'message' => 'Nessun utente valido trovato'
            ], 400);
        }

        $results = SendBulkSmsAction::make(
            users: $users,
            message: $request->message,
            sender: '<nome progetto>',
            batchSize: 100,
            delayBetweenBatches: 1
        )->onQueue('bulk-sms')->execute();

        return response()->json([
            'message' => 'Invio SMS massivo completato',
            'results' => $results
        ]);

    } catch (\Exception $e) {
        Log::error('Errore invio SMS massivo', [
            'error' => $e->getMessage(),
            'user_ids' => $request->user_ids
        ]);

        return response()->json([
            'message' => 'Errore nell\'invio degli SMS'
        ], 500);
    }
}
```

## 4. Gestione Errori Avanzata

### 4.1 Action con Retry e Circuit Breaker
```php
<?php

namespace Modules\Notify\Actions;

use Illuminate\Support\Facades\Cache;
use Modules\Notify\App\Data\NetfunSmsResponseData;

class SendNetfunSmsWithRetryAction extends SendNetfunSmsAction
{
    /**
     * @var int
     */
    protected int $maxRetries;

    /**
     * @var int
     */
    protected int $retryDelay;

    /**
     * @var int
     */
    protected int $circuitBreakerThreshold;

    /**
     * @var int
     */
    protected int $circuitBreakerTimeout;

    public function __construct(
        string $to,
        string $message,
        string $sender
    ) {
        parent::__construct($to, $message, $sender);

        $this->maxRetries = config('notify.netfun.max_retries', 3);
        $this->retryDelay = config('notify.netfun.retry_delay', 1);
        $this->circuitBreakerThreshold = config('notify.netfun.circuit_breaker.threshold', 5);
        $this->circuitBreakerTimeout = config('notify.netfun.circuit_breaker.timeout', 60);
    }

    /**
     * Esegue l'azione con retry e circuit breaker
     *
     * @return NetfunSmsResponseData
     * @throws \Exception
     */
    public function execute(): NetfunSmsResponseData
    {
        // Verifica circuit breaker
        if ($this->isCircuitBreakerOpen()) {
            throw new \Exception('Circuit breaker is open');
        }

        $attempts = 0;
        $lastException = null;

        while ($attempts < $this->maxRetries) {
            try {
                $result = parent::execute();

                // Reset circuit breaker on success
                $this->resetCircuitBreaker();

                return $result;

            } catch (\Exception $e) {
                $lastException = $e;
                $attempts++;

                if ($attempts === $this->maxRetries) {
                    // Increment circuit breaker counter
                    $this->incrementCircuitBreaker();

                    Log::error('Tentativi esauriti per invio SMS', [
                        'to' => $this->to,
                        'error' => $e->getMessage(),
                        'attempts' => $attempts
                    ]);

                    throw $e;
                }

                Log::warning('Tentativo fallito, riprovo...', [
                    'attempt' => $attempts,
                    'error' => $e->getMessage()
                ]);

                sleep($this->retryDelay);
            }
        }

        throw $lastException;
    }

    /**
     * Verifica se il circuit breaker è aperto
     *
     * @return bool
     */
    protected function isCircuitBreakerOpen(): bool
    {
        return Cache::get('netfun_circuit_breaker', false);
    }

    /**
     * Incrementa il contatore del circuit breaker
     */
    protected function incrementCircuitBreaker(): void
    {
        $key = 'netfun_circuit_breaker_failures';
        $failures = Cache::get($key, 0) + 1;

        Cache::put($key, $failures, $this->circuitBreakerTimeout);

        if ($failures >= $this->circuitBreakerThreshold) {
            Cache::put('netfun_circuit_breaker', true, $this->circuitBreakerTimeout);
        }
    }

    /**
     * Resetta il circuit breaker
     */
    protected function resetCircuitBreaker(): void
    {
        Cache::forget('netfun_circuit_breaker');
        Cache::forget('netfun_circuit_breaker_failures');
    }
}
```

## 5. Monitoraggio Avanzato

### 5.1 Action con Metriche e Prometheus
```php
<?php

namespace Modules\Notify\Actions;

use Prometheus\CollectorRegistry;
use Modules\Notify\App\Data\NetfunSmsResponseData;

class SendNetfunSmsWithMetricsAction extends SendNetfunSmsAction
{
    /**
     * @var CollectorRegistry
     */
    protected CollectorRegistry $prometheus;

    public function __construct(
        string $to,
        string $message,
        string $sender
    ) {
        parent::__construct($to, $message, $sender);
        $this->prometheus = app(CollectorRegistry::class);
    }

    /**
     * Esegue l'azione con metriche
     *
     * @return NetfunSmsResponseData
     * @throws \Exception
     */
    public function execute(): NetfunSmsResponseData
    {
        $startTime = microtime(true);

        try {
            $result = parent::execute();

            // Registra metriche di successo
            $this->recordMetrics(true, microtime(true) - $startTime, [
                'message_id' => $result->message_id,
                'status' => $result->status
            ]);

            return $result;

        } catch (\Exception $e) {
            // Registra metriche di errore
            $this->recordMetrics(false, microtime(true) - $startTime, [
                'error' => $e->getMessage()
            ]);

            throw $e;
        }
    }

    /**
     * Registra le metriche
     *
     * @param bool $success
     * @param float $duration
     * @param array $context
     */
    protected function recordMetrics(bool $success, float $duration, array $context = []): void
    {
        // Incrementa il contatore totale
        $this->prometheus->getOrRegisterCounter(
            'netfun',
            'sms_total',
            'Total number of SMS sent'
        )->inc();

        // Incrementa il contatore di successo/errore
        $this->prometheus->getOrRegisterCounter(
            'netfun',
            'sms_' . ($success ? 'success' : 'error'),
            'Number of successful/failed SMS'
        )->inc();

        // Registra la durata
        $this->prometheus->getOrRegisterHistogram(
            'netfun',
            'sms_duration_seconds',
            'SMS sending duration in seconds'
        )->observe($duration);

        // Log dettagliato
        Log::info('Metriche SMS', array_merge([
            'success' => $success,
            'duration' => $duration,
            'to' => $this->to,
            'sender' => $this->sender
        ], $context));
    }
}
```

## 6. Esempi di Test

### 6.1 Test Unitario
```php
<?php

namespace Modules\Notify\Tests\Unit;

use Tests\TestCase;
use Modules\Notify\Actions\SendNetfunSmsAction;
use Modules\Notify\App\Data\NetfunSmsResponseData;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;

class NetfunSmsActionTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        Cache::flush();
    }

    public function test_sms_sent_with_valid_data()
    {
        Http::fake([
            config('notify.netfun.endpoint') => Http::response([
                'status' => 'success',
                'message_id' => '123456'
            ], 200)
        ]);

        $action = SendNetfunSmsAction::make(
            to: '+393331234567',
            message: 'Test message',
            sender: 'TEST'
        );

        $result = $action->execute();

        $this->assertInstanceOf(NetfunSmsResponseData::class, $result);
        $this->assertEquals('success', $result->status);
        $this->assertEquals('123456', $result->message_id);

        Http::assertSent(function ($request) {
            return $request->url() == config('notify.netfun.endpoint') &&
                   $request['messages'][0]['to'] == '+393331234567' &&
                   $request['messages'][0]['text'] == 'Test message' &&
                   $request['messages'][0]['from'] == 'TEST';
        });
    }

    public function test_sms_fails_with_invalid_number()
    {
        Http::fake([
            config('notify.netfun.endpoint') => Http::response([
                'status' => 'error',
                'error' => 'Invalid phone number'
            ], 400)
        ]);

        $this->expectException(\Exception::class);

        $action = SendNetfunSmsAction::make(
            to: 'invalid',
            message: 'Test message',
            sender: 'TEST'
        );

        $action->execute();
    }

    public function test_rate_limiting()
    {
        $action = SendNetfunSmsAction::make(
            to: '+393331234567',
            message: 'Test message',
            sender: 'TEST'
        );

        // Simula il raggiungimento del rate limit
        Cache::put('netfun_rate_limit_' . date('YmdHis'), 100, 60);

        $this->expectException(\Exception::class);
        $this->expectExceptionMessage('Rate limit exceeded');

        $action->execute();
    }

    public function test_circuit_breaker()
    {
        $action = new SendNetfunSmsWithRetryAction(
            to: '+393331234567',
            message: 'Test message',
            sender: 'TEST'
        );

        // Simula il circuit breaker aperto
        Cache::put('netfun_circuit_breaker', true, 60);

        $this->expectException(\Exception::class);
        $this->expectExceptionMessage('Circuit breaker is open');

        $action->execute();
    }
}
```

### 6.2 Test di Integrazione
```php
<?php

namespace Modules\Notify\Tests\Feature;

use Tests\TestCase;
use Modules\Patient\Models\User;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Queue;
use Illuminate\Support\Facades\Cache;

class NetfunNotificationIntegrationTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        Queue::fake();
        Cache::flush();
    }

    public function test_otp_notification_sent()
    {
        Http::fake([
            config('notify.netfun.endpoint') => Http::response([
                'status' => 'success',
                'message_id' => '123456'
            ], 200)
        ]);

        $user = User::factory()->create([
            'phone_number' => '+393331234567',
            'consent_sms' => true
        ]);

        $otp = '123456';

        $user->notify(new OtpSmsNotification($otp));

        Http::assertSent(function ($request) use ($otp) {
            return $request->url() == config('notify.netfun.endpoint') &&
                   $request['messages'][0]['to'] == '+393331234567' &&
                   str_contains($request['messages'][0]['text'], $otp);
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

    public function test_bulk_sms_sent()
    {
        Http::fake([
            config('notify.netfun.endpoint') => Http::response([
                'status' => 'success',
                'message_id' => '123456'
            ], 200)
        ]);

        $users = User::factory()->count(3)->create([
            'consent_sms' => true
        ]);

        $results = SendBulkSmsAction::make(
            users: $users,
            message: 'Test message',
            sender: 'TEST'
        )->execute();

        $this->assertEquals(3, $results['total']);
        $this->assertEquals(3, $results['success']);
        $this->assertEquals(0, $results['failed']);

        Http::assertSentCount(1);
    }

    public function test_metrics_recorded()
    {
        $action = new SendNetfunSmsWithMetricsAction(
            to: '+393331234567',
            message: 'Test message',
            sender: 'TEST'
        );

        $metrics = $action->recordMetrics(true, 0.5, [
            'message_id' => '123456'
        ]);

        $this->assertTrue($metrics['success']);
        $this->assertEquals(0.5, $metrics['duration']);
        $this->assertEquals('123456', $metrics['message_id']);
    }
}
```

## 7. Collegamenti Utili

- [Documentazione Netfun](https://www.netfunitalia.it/)
- [API Netfun](https://v2.smsviainternet.it/api/rest/v1/)
- [Spatie Queueable Action](https://github.com/spatie/laravel-queueable-action)
- [Spatie Laravel Data](https://github.com/spatie/laravel-data)
- [Laravel Notifications](https://laravel.com/docs/notifications)
- [Laravel Queues](https://laravel.com/docs/queues)
- [Laravel Testing](https://laravel.com/docs/testing)
- [Laravel Logging](https://laravel.com/docs/logging)
- [Laravel Cache](https://laravel.com/docs/cache)
- [Prometheus PHP Client](https://github.com/promphp/prometheus_client_php)
# Netfun Examples

This document provides examples for Netfun integration.

---

## netfun-examples

*Consolidated from: `netfun-examples.md`*


## 1. Invio SMS OTP

### 1.1 Notification Class
```php
<?php

namespace Modules\Notify\Notifications;

use Illuminate\Support\Carbon;
use Modules\Notify\App\Data\NetfunSmsRequestData;

class OtpSmsNotification extends NetfunSmsNotification
{
    /**
     * @var string
     */
    protected string $otp;

    /**
     * @var Carbon
     */
    protected Carbon $expiresAt;

    /**
     * @param string $otp
     * @param int $minutes
     */
    public function __construct(string $otp, int $minutes = 5)
    {
        $this->otp = $otp;
        $this->expiresAt = now()->addMinutes($minutes);

        parent::__construct(
            message: "Il tuo codice OTP è: {$otp}. Valido fino alle {$this->expiresAt->format('H:i')}.",
            sender: '<nome progetto>'
        );
    }

    /**
     * Get the OTP
     *
     * @return string
     */
    public function getOtp(): string
    {
        return $this->otp;
    }

    /**
     * Get the expiration time
     *
     * @return Carbon
     */
    public function getExpiresAt(): Carbon
    {
        return $this->expiresAt;
    }

    /**
     * Get the Netfun representation of the notification.
     *
     * @param mixed $notifiable
     * @return NetfunSmsRequestData
     */
    public function toNetfun($notifiable): NetfunSmsRequestData
    {
        return new NetfunSmsRequestData(
            to: $notifiable->phone_number,
            text: $this->message,
            from: $this->sender
        );
    }
}
```

### 1.2 Utilizzo
```php
// Nel controller
public function sendOtp(User $user)
{
    try {
        // Genera OTP
        $otp = str_pad(random_int(0, 999999), 6, '0', STR_PAD_LEFT);
        
        // Salva OTP nel database con scadenza
        $user->update([
            'otp' => $otp,
            'otp_expires_at' => now()->addMinutes(5)
        ]);
        
        // Invia SMS
        $user->notify(new OtpSmsNotification($otp));

        return response()->json([
            'message' => 'OTP inviato con successo',
            'expires_at' => now()->addMinutes(5)
        ]);

    } catch (\Exception $e) {
        Log::error('Errore invio OTP', [
            'user_id' => $user->id,
            'error' => $e->getMessage()
        ]);

        return response()->json([
            'message' => 'Errore nell\'invio dell\'OTP'
        ], 500);
    }
}

// Verifica OTP
public function verifyOtp(Request $request, User $user)
{
    $request->validate([
        'otp' => 'required|string|size:6'
    ]);

    if ($user->otp !== $request->otp) {
        return response()->json([
            'message' => 'OTP non valido'
        ], 400);
    }

    if ($user->otp_expires_at->isPast()) {
        return response()->json([
            'message' => 'OTP scaduto'
        ], 400);
    }

    // OTP valido, resetta i campi
    $user->update([
        'otp' => null,
        'otp_expires_at' => null
    ]);

    return response()->json([
        'message' => 'OTP verificato con successo'
    ]);
}
```

## 2. Invio SMS Promemoria

### 2.1 Notification Class
```php
<?php

namespace Modules\Notify\Notifications;

use Illuminate\Support\Carbon;
use Modules\Notify\App\Data\NetfunSmsRequestData;

class AppointmentReminderNotification extends NetfunSmsNotification
{
    /**
     * @var Carbon
     */
    protected Carbon $appointmentDate;

    /**
     * @var string
     */
    protected string $doctorName;

    /**
     * @var string
     */
    protected string $location;

    /**
     * @var string|null
     */
    protected ?string $notes;

    /**
     * @param Carbon $appointmentDate
     * @param string $doctorName
     * @param string $location
     * @param string|null $notes
     */
    public function __construct(
        Carbon $appointmentDate,
        string $doctorName,
        string $location,
        ?string $notes = null
    ) {
        $this->appointmentDate = $appointmentDate;
        $this->doctorName = $doctorName;
        $this->location = $location;
        $this->notes = $notes;

        $message = "Promemoria: Hai un appuntamento con {$doctorName} il {$appointmentDate->format('d/m/Y H:i')}";
        $message .= " presso {$location}.";
        
        if ($notes) {
            $message .= " Note: {$notes}";
        }

        parent::__construct(
            message: $message,
            sender: '<nome progetto>'
        );
    }

    /**
     * Get the Netfun representation of the notification.
     *
     * @param mixed $notifiable
     * @return NetfunSmsRequestData
     */
    public function toNetfun($notifiable): NetfunSmsRequestData
    {
        return new NetfunSmsRequestData(
            to: $notifiable->phone_number,
            text: $this->message,
            from: $this->sender
        );
    }
}
```

### 2.2 Utilizzo
```php
// Nel controller
public function sendReminder(Appointment $appointment)
{
    try {
        // Verifica se l'appuntamento è nel futuro
        if ($appointment->date->isPast()) {
            throw new \Exception('Impossibile inviare promemoria per un appuntamento passato');
        }

        // Verifica se il promemoria è già stato inviato
        if ($appointment->reminder_sent_at) {
            throw new \Exception('Promemoria già inviato');
        }

        // Invia il promemoria
        $appointment->patient->notify(
            new AppointmentReminderNotification(
                appointmentDate: $appointment->date,
                doctorName: $appointment->doctor->name,
                location: $appointment->location,
                notes: $appointment->notes
            )
        );

        // Aggiorna lo stato del promemoria
        $appointment->update([
            'reminder_sent_at' => now()
        ]);

        return response()->json([
            'message' => 'Promemoria inviato con successo'
        ]);

    } catch (\Exception $e) {
        Log::error('Errore invio promemoria', [
            'appointment_id' => $appointment->id,
            'error' => $e->getMessage()
        ]);

        return response()->json([
            'message' => 'Errore nell\'invio del promemoria'
        ], 500);
    }
}
```

## 3. Invio SMS Massivo

### 3.1 Action
```php
<?php

namespace Modules\Notify\Actions;

use Spatie\QueueableAction\QueueableAction;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Cache;
use Modules\Notify\App\Data\NetfunSmsRequestData;
use Modules\Notify\App\Data\NetfunSmsResponseData;

class SendBulkSmsAction
{
    use QueueableAction;

    /**
     * @var Collection
     */
    protected Collection $users;

    /**
     * @var string
     */
    protected string $message;

    /**
     * @var string
     */
    protected string $sender;

    /**
     * @var int
     */
    protected int $batchSize;

    /**
     * @var int
     */
    protected int $delayBetweenBatches;

    /**
     * @param Collection $users
     * @param string $message
     * @param string $sender
     * @param int $batchSize
     * @param int $delayBetweenBatches
     */
    public function __construct(
        Collection $users,
        string $message,
        string $sender,
        int $batchSize = 100,
        int $delayBetweenBatches = 1
    ) {
        $this->users = $users;
        $this->message = $message;
        $this->sender = $sender;
        $this->batchSize = $batchSize;
        $this->delayBetweenBatches = $delayBetweenBatches;
    }

    /**
     * Esegue l'azione di invio SMS massivo
     *
     * @return array
     * @throws \Exception
     */
    public function execute(): array
    {
        $results = [
            'total' => $this->users->count(),
            'success' => 0,
            'failed' => 0,
            'errors' => []
        ];

        try {
            // Prepara il batch di messaggi
            $messages = $this->users->map(function ($user) {
                return new NetfunSmsRequestData(
                    to: $user->phone_number,
                    text: $this->message,
                    from: $this->sender
                );
            })->chunk($this->batchSize);

            // Invia ogni batch
            foreach ($messages as $batch) {
                try {
                    $response = Http::withHeaders([
                        'Authorization' => 'Bearer ' . config('notify.netfun.api_key'),
                        'Content-Type' => 'application/json',
                        'Accept' => 'application/json'
                    ])->timeout(30)->post(config('notify.netfun.endpoint'), [
                        'messages' => $batch->map(fn($message) => $message->toArray())->values()->all()
                    ]);

                    if (!$response->successful()) {
                        throw new \Exception('Errore HTTP: ' . $response->status());
                    }

                    $result = NetfunSmsResponseData::fromArray($response->json());
                    
                    if ($result->status !== 'success') {
                        throw new \Exception($result->error ?? 'Errore sconosciuto');
                    }

                    $results['success'] += $batch->count();

                } catch (\Exception $e) {
                    $results['failed'] += $batch->count();
                    $results['errors'][] = [
                        'batch_size' => $batch->count(),
                        'error' => $e->getMessage()
                    ];

                    Log::error('Errore invio batch SMS', [
                        'error' => $e->getMessage(),
                        'batch_size' => $batch->count()
                    ]);
                }

                // Attendi tra i batch
                if ($this->delayBetweenBatches > 0) {
                    sleep($this->delayBetweenBatches);
                }
            }

            return $results;

        } catch (\Exception $e) {
            Log::error('Eccezione invio SMS massivo', [
                'error' => $e->getMessage(),
                'total_users' => $this->users->count()
            ]);

            throw $e;
        }
    }
}
```

### 3.2 Utilizzo
```php
// Nel controller
public function sendBulkSms(Request $request)
{
    $request->validate([
        'message' => 'required|string|max:160',
        'user_ids' => 'required|array',
        'user_ids.*' => 'exists:users,id'
    ]);

    try {
        $users = User::whereIn('id', $request->user_ids)
            ->where('consent_sms', true)
            ->get();

        if ($users->isEmpty()) {
            return response()->json([
                'message' => 'Nessun utente valido trovato'
            ], 400);
        }

        $results = SendBulkSmsAction::make(
            users: $users,
            message: $request->message,
            sender: '<nome progetto>',
            batchSize: 100,
            delayBetweenBatches: 1
        )->onQueue('bulk-sms')->execute();

        return response()->json([
            'message' => 'Invio SMS massivo completato',
            'results' => $results
        ]);

    } catch (\Exception $e) {
        Log::error('Errore invio SMS massivo', [
            'error' => $e->getMessage(),
            'user_ids' => $request->user_ids
        ]);

        return response()->json([
            'message' => 'Errore nell\'invio degli SMS'
        ], 500);
    }
}
```

## 4. Gestione Errori Avanzata

### 4.1 Action con Retry e Circuit Breaker
```php
<?php

namespace Modules\Notify\Actions;

use Illuminate\Support\Facades\Cache;
use Modules\Notify\App\Data\NetfunSmsResponseData;

class SendNetfunSmsWithRetryAction extends SendNetfunSmsAction
{
    /**
     * @var int
     */
    protected int $maxRetries;

    /**
     * @var int
     */
    protected int $retryDelay;

    /**
     * @var int
     */
    protected int $circuitBreakerThreshold;

    /**
     * @var int
     */
    protected int $circuitBreakerTimeout;

    public function __construct(
        string $to,
        string $message,
        string $sender
    ) {
        parent::__construct($to, $message, $sender);
        
        $this->maxRetries = config('notify.netfun.max_retries', 3);
        $this->retryDelay = config('notify.netfun.retry_delay', 1);
        $this->circuitBreakerThreshold = config('notify.netfun.circuit_breaker.threshold', 5);
        $this->circuitBreakerTimeout = config('notify.netfun.circuit_breaker.timeout', 60);
    }

    /**
     * Esegue l'azione con retry e circuit breaker
     *
     * @return NetfunSmsResponseData
     * @throws \Exception
     */
    public function execute(): NetfunSmsResponseData
    {
        // Verifica circuit breaker
        if ($this->isCircuitBreakerOpen()) {
            throw new \Exception('Circuit breaker is open');
        }

        $attempts = 0;
        $lastException = null;

        while ($attempts < $this->maxRetries) {
            try {
                $result = parent::execute();
                
                // Reset circuit breaker on success
                $this->resetCircuitBreaker();
                
                return $result;

            } catch (\Exception $e) {
                $lastException = $e;
                $attempts++;

                if ($attempts === $this->maxRetries) {
                    // Increment circuit breaker counter
                    $this->incrementCircuitBreaker();
                    
                    Log::error('Tentativi esauriti per invio SMS', [
                        'to' => $this->to,
                        'error' => $e->getMessage(),
                        'attempts' => $attempts
                    ]);
                    
                    throw $e;
                }

                Log::warning('Tentativo fallito, riprovo...', [
                    'attempt' => $attempts,
                    'error' => $e->getMessage()
                ]);

                sleep($this->retryDelay);
            }
        }

        throw $lastException;
    }

    /**
     * Verifica se il circuit breaker è aperto
     *
     * @return bool
     */
    protected function isCircuitBreakerOpen(): bool
    {
        return Cache::get('netfun_circuit_breaker', false);
    }

    /**
     * Incrementa il contatore del circuit breaker
     */
    protected function incrementCircuitBreaker(): void
    {
        $key = 'netfun_circuit_breaker_failures';
        $failures = Cache::get($key, 0) + 1;
        
        Cache::put($key, $failures, $this->circuitBreakerTimeout);

        if ($failures >= $this->circuitBreakerThreshold) {
            Cache::put('netfun_circuit_breaker', true, $this->circuitBreakerTimeout);
        }
    }

    /**
     * Resetta il circuit breaker
     */
    protected function resetCircuitBreaker(): void
    {
        Cache::forget('netfun_circuit_breaker');
        Cache::forget('netfun_circuit_breaker_failures');
    }
}
```

## 5. Monitoraggio Avanzato

### 5.1 Action con Metriche e Prometheus
```php
<?php

namespace Modules\Notify\Actions;

use Prometheus\CollectorRegistry;
use Modules\Notify\App\Data\NetfunSmsResponseData;

class SendNetfunSmsWithMetricsAction extends SendNetfunSmsAction
{
    /**
     * @var CollectorRegistry
     */
    protected CollectorRegistry $prometheus;

    public function __construct(
        string $to,
        string $message,
        string $sender
    ) {
        parent::__construct($to, $message, $sender);
        $this->prometheus = app(CollectorRegistry::class);
    }

    /**
     * Esegue l'azione con metriche
     *
     * @return NetfunSmsResponseData
     * @throws \Exception
     */
    public function execute(): NetfunSmsResponseData
    {
        $startTime = microtime(true);
        
        try {
            $result = parent::execute();
            
            // Registra metriche di successo
            $this->recordMetrics(true, microtime(true) - $startTime, [
                'message_id' => $result->message_id,
                'status' => $result->status
            ]);
            
            return $result;

        } catch (\Exception $e) {
            // Registra metriche di errore
            $this->recordMetrics(false, microtime(true) - $startTime, [
                'error' => $e->getMessage()
            ]);
            
            throw $e;
        }
    }
    
    /**
     * Registra le metriche
     *
     * @param bool $success
     * @param float $duration
     * @param array $context
     */
    protected function recordMetrics(bool $success, float $duration, array $context = []): void
    {
        // Incrementa il contatore totale
        $this->prometheus->getOrRegisterCounter(
            'netfun',
            'sms_total',
            'Total number of SMS sent'
        )->inc();

        // Incrementa il contatore di successo/errore
        $this->prometheus->getOrRegisterCounter(
            'netfun',
            'sms_' . ($success ? 'success' : 'error'),
            'Number of successful/failed SMS'
        )->inc();

        // Registra la durata
        $this->prometheus->getOrRegisterHistogram(
            'netfun',
            'sms_duration_seconds',
            'SMS sending duration in seconds'
        )->observe($duration);

        // Log dettagliato
        Log::info('Metriche SMS', array_merge([
            'success' => $success,
            'duration' => $duration,
            'to' => $this->to,
            'sender' => $this->sender
        ], $context));
    }
}
```

## 6. Esempi di Test

### 6.1 Test Unitario
```php
<?php

namespace Modules\Notify\Tests\Unit;

use Tests\TestCase;
use Modules\Notify\Actions\SendNetfunSmsAction;
use Modules\Notify\App\Data\NetfunSmsResponseData;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;

class NetfunSmsActionTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        Cache::flush();
    }

    public function test_sms_sent_with_valid_data()
    {
        Http::fake([
            config('notify.netfun.endpoint') => Http::response([
                'status' => 'success',
                'message_id' => '123456'
            ], 200)
        ]);

        $action = SendNetfunSmsAction::make(
            to: '+393331234567',
            message: 'Test message',
            sender: 'TEST'
        );

        $result = $action->execute();

        $this->assertInstanceOf(NetfunSmsResponseData::class, $result);
        $this->assertEquals('success', $result->status);
        $this->assertEquals('123456', $result->message_id);
        
        Http::assertSent(function ($request) {
            return $request->url() == config('notify.netfun.endpoint') &&
                   $request['messages'][0]['to'] == '+393331234567' &&
                   $request['messages'][0]['text'] == 'Test message' &&
                   $request['messages'][0]['from'] == 'TEST';
        });
    }

    public function test_sms_fails_with_invalid_number()
    {
        Http::fake([
            config('notify.netfun.endpoint') => Http::response([
                'status' => 'error',
                'error' => 'Invalid phone number'
            ], 400)
        ]);

        $this->expectException(\Exception::class);

        $action = SendNetfunSmsAction::make(
            to: 'invalid',
            message: 'Test message',
            sender: 'TEST'
        );

        $action->execute();
    }

    public function test_rate_limiting()
    {
        $action = SendNetfunSmsAction::make(
            to: '+393331234567',
            message: 'Test message',
            sender: 'TEST'
        );

        // Simula il raggiungimento del rate limit
        Cache::put('netfun_rate_limit_' . date('YmdHis'), 100, 60);

        $this->expectException(\Exception::class);
        $this->expectExceptionMessage('Rate limit exceeded');

        $action->execute();
    }

    public function test_circuit_breaker()
    {
        $action = new SendNetfunSmsWithRetryAction(
            to: '+393331234567',
            message: 'Test message',
            sender: 'TEST'
        );

        // Simula il circuit breaker aperto
        Cache::put('netfun_circuit_breaker', true, 60);

        $this->expectException(\Exception::class);
        $this->expectExceptionMessage('Circuit breaker is open');

        $action->execute();
    }
}
```

### 6.2 Test di Integrazione
```php
<?php

namespace Modules\Notify\Tests\Feature;

use Tests\TestCase;
use Modules\Patient\Models\User;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Queue;
use Illuminate\Support\Facades\Cache;

class NetfunNotificationIntegrationTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        Queue::fake();
        Cache::flush();
    }

    public function test_otp_notification_sent()
    {
        Http::fake([
            config('notify.netfun.endpoint') => Http::response([
                'status' => 'success',
                'message_id' => '123456'
            ], 200)
        ]);

        $user = User::factory()->create([
            'phone_number' => '+393331234567',
            'consent_sms' => true
        ]);

        $otp = '123456';
        
        $user->notify(new OtpSmsNotification($otp));

        Http::assertSent(function ($request) use ($otp) {
            return $request->url() == config('notify.netfun.endpoint') &&
                   $request['messages'][0]['to'] == '+393331234567' &&
                   str_contains($request['messages'][0]['text'], $otp);
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

    public function test_bulk_sms_sent()
    {
        Http::fake([
            config('notify.netfun.endpoint') => Http::response([
                'status' => 'success',
                'message_id' => '123456'
            ], 200)
        ]);

        $users = User::factory()->count(3)->create([
            'consent_sms' => true
        ]);

        $results = SendBulkSmsAction::make(
            users: $users,
            message: 'Test message',
            sender: 'TEST'
        )->execute();

        $this->assertEquals(3, $results['total']);
        $this->assertEquals(3, $results['success']);
        $this->assertEquals(0, $results['failed']);

        Http::assertSentCount(1);
    }

    public function test_metrics_recorded()
    {
        $action = new SendNetfunSmsWithMetricsAction(
            to: '+393331234567',
            message: 'Test message',
            sender: 'TEST'
        );

        $metrics = $action->recordMetrics(true, 0.5, [
            'message_id' => '123456'
        ]);

        $this->assertTrue($metrics['success']);
        $this->assertEquals(0.5, $metrics['duration']);
        $this->assertEquals('123456', $metrics['message_id']);
    }
}
```

## 7. Collegamenti Utili

- [Documentazione Netfun](https://www.netfunitalia.it/)
- [API Netfun](https://v2.smsviainternet.it/api/rest/v1/)
- [Spatie Queueable Action](https://github.com/spatie/laravel-queueable-action)
- [Spatie Laravel Data](https://github.com/spatie/laravel-data)
- [Laravel Notifications](https://laravel.com/docs/notifications)
- [Laravel Queues](https://laravel.com/docs/queues)
- [Laravel Testing](https://laravel.com/docs/testing)
- [Laravel Logging](https://laravel.com/docs/logging)
- [Laravel Cache](https://laravel.com/docs/cache)
- [Prometheus PHP Client](https://github.com/promphp/prometheus_client_php) 

---

## netfun_action_errors

*Consolidated from: `netfun_action_errors.md`*


## Errori Identificati

Nella classe `SendNetfunSMSAction` sono stati identificati diversi errori che non rispettano le best practice e la configurazione standardizzata SMS. Questo documento elenca gli errori e le correzioni apportate.

## 1. Errori di Configurazione

### 1.1. Accesso Diretto alla Configurazione Specifica

**Errore**:
```php
$this->username = config('sms.netfun.username');
$this->password = config('sms.netfun.password');
$this->sender = config('sms.netfun.sender');
$this->apiUrl = config('sms.netfun.api_url');
```

**Problemi**:
- Accesso diretto a `sms.netfun.*` invece di `sms.drivers.netfun.*`
- Non rispetta la struttura standardizzata della configurazione
- Non implementa la logica di precedenza tra parametri a livello di root e specifici per provider

**Correzione**:
```php
$config = config('sms');
$driver = 'netfun';

// Parametri specifici per provider
$this->token = $config['drivers'][$driver]['token'] ?? null;
$this->apiUrl = $config['drivers'][$driver]['api_url'] ?? null;

// Parametri a livello di root con logica di precedenza
$this->from = $config['drivers'][$driver]['from'] ?? $config['from'] ?? null;
$this->debug = $config['drivers'][$driver]['debug'] ?? $config['debug'] ?? false;
```

## 2. Errori di Autenticazione

### 2.1. Uso di Username/Password invece di Token

**Errore**:
```php
protected string $username;
protected string $password;
// ...
$response = Http::post($this->apiUrl, [
    'username' => $this->username,
    'password' => $this->password,
    // ...
]);
```

**Problemi**:
- Utilizza `username` e `password` per l'autenticazione
- Netfun utilizza esclusivamente token (API key) per l'autenticazione

**Correzione**:
```php
protected ?string $token;
// ...
$response = Http::post($this->apiUrl, [
    'token' => $this->token,
    // ...
]);
```

## 3. Errori di Nomenclatura

### 3.1. Uso di 'sender' invece di 'from'

**Errore**:
```php
protected string $sender;
// ...
'sender' => $options['sender'] ?? $this->sender,
```

**Problemi**:
- Utilizza `sender` invece del nome standardizzato `from`
- Non rispetta la nomenclatura coerente tra i provider

**Correzione**:
```php
protected ?string $from;
// ...
'from' => $from,
```

## 4. Errori di Tipizzazione

### 4.1. Mancato Utilizzo di Tipi Nullable

**Errore**:
```php
protected string $username;
protected string $password;
protected string $sender;
protected string $apiUrl;
```

**Problemi**:
- Le proprietà sono dichiarate come `string` non nullable
- I valori potrebbero essere null se la configurazione non è presente

**Correzione**:
```php
protected ?string $token;
protected ?string $from;
protected ?string $apiUrl;
protected bool $debug;
```

## 5. Errori di Design

### 5.1. Mancato Utilizzo di DTO

**Errore**:
```php
public function execute(string $to, string $message, array $options = [])
```

**Problemi**:
- Accetta parametri primitivi invece di un DTO strutturato
- Rende difficile l'evoluzione dell'API senza breaking changes

**Correzione**:
```php
/**
 * @param SmsMessageData|string $to Destinatario o oggetto SmsMessageData
 * @param string|null $message Testo del messaggio (opzionale se si usa SmsMessageData)
 */
public function execute($to, ?string $message = null, array $options = [])
{
    // Gestione di SmsMessageData o parametri separati
    if ($to instanceof SmsMessageData) {
        $smsData = $to;
        $recipient = $this->normalizePhoneNumber($smsData->recipient);
        $messageText = $smsData->message;
        $from = $smsData->from ?? $this->from;
        // ...
    } else {
        // Retrocompatibilità
        // ...
    }
}
```

### 5.2. Mancata Validazione dei Parametri di Configurazione

**Errore**: Nessuna validazione dei parametri di configurazione obbligatori.

**Correzione**:
```php
// Verifica se i parametri di configurazione sono presenti
if (!$this->token || !$this->apiUrl) {
    throw new \RuntimeException('Configurazione Netfun incompleta: token o api_url mancanti');
}
```

### 5.3. Mancato Utilizzo del Debug Flag

**Errore**: Nessun utilizzo del flag di debug per il logging dettagliato.

**Correzione**:
```php
// Log di debug se abilitato
if ($this->debug) {
    Log::debug('Invio SMS Netfun', [
        'to' => $recipient,
        'from' => $from,
        'message_length' => strlen($messageText),
        'reference' => $reference,
    ]);
}
```

## 6. Conclusioni

Le correzioni apportate allineano la classe `SendNetfunSMSAction` con:

1. La struttura standardizzata della configurazione SMS
2. Le best practice di Laravel e PHP 8.2+
3. L'uso corretto dell'autenticazione Netfun con token
4. La nomenclatura standardizzata tra i provider
5. L'utilizzo di DTO per i dati in ingresso
6. La validazione appropriata dei parametri di configurazione
7. L'implementazione della logica di precedenza tra parametri a livello di root e specifici per provider

Queste correzioni garantiscono che l'azione funzioni correttamente con la configurazione standardizzata e sia più robusta, manutenibile ed estensibile.

---

*Ultimo aggiornamento: 2025-05-12*

---

## netfun_action_updates

*Consolidated from: `netfun_action_updates.md`*


## Panoramica delle Modifiche

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
 * * @param string $phoneNumber Numero di telefono da normalizzare
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
        }        // Se il numero inizia con '3' (cellulare italiano), aggiungi prefisso italiano
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

Le modifiche apportate a `SendNetfunSMSAction` e l'aggiunta del nuovo DTO `SmsMessageData` hanno migliorato significativamente la qualità e la robustezza del codice, allineandolo con le best practice del progetto <nome progetto> e con i pattern di configurazione standardizzati.

Questi miglioramenti garantiscono:
1. Maggiore manutenibilità del codice
2. Migliore gestione degli errori e logging
3. Supporto per diversi tipi di DTO
4. Normalizzazione corretta dei numeri di telefono
5. Configurazione standardizzata e coerente

---

*Ultimo aggiornamento: 2023-05-12*

---

## netfun_channel

*Consolidated from: `netfun_channel.md`*


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
SMS_FROM_NAME=<nome progetto>
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
- [Laravel Notifications](https://laravel.com/project_docs/notifications)
- [Laravel Queues](https://laravel.com/project_docs/queues)
- [Laravel Testing](https://laravel.com/project_docs/testing)
- [Laravel Logging](https://laravel.com/project_docs/logging)
- [Laravel Cache](https://laravel.com/project_docs/cache)- [Laravel Notifications](https://laravel.com/docs/notifications)
- [Laravel Queues](https://laravel.com/docs/queues)
- [Laravel Testing](https://laravel.com/docs/testing)
- [Laravel Logging](https://laravel.com/docs/logging)
- [Laravel Cache](https://laravel.com/docs/cache)
---

## netfun_config_requirements

*Consolidated from: `netfun_config_requirements.md`*


Questa guida descrive la configurazione necessaria per utilizzare il provider Netfun come driver SMS nel modulo Notify.

## 1. Parametri Obbligatori

Aggiungi la seguente sezione nel file `config/sms.php`:

```php
'netfun' => [
    //# Requisiti di Configurazione Netfun SMS

## Introduzione

Questo documento descrive i requisiti di configurazione per l'integrazione con il provider SMS Netfun nel modulo Notify, seguendo la [struttura standardizzata della configurazione SMS](./STANDARDIZED_SMS_CONFIG_STRUCTURE.md).
Questo documento descrive i requisiti di configurazione per l'integrazione con il provider SMS Netfun nel modulo Notify, seguendo la [struttura standardizzata della configurazione SMS](../../standardized_sms_config_structure.md).

## Struttura di Configurazione

La configurazione di Netfun segue la struttura standardizzata con parametri globali e specifici:

### Parametri Globali (a livello di root)

```php
// Configurazioni globali applicabili a tutti i provider
'from' => env('SMS_FROM'),
'debug' => env('SMS_DEBUG', false),
'retry' => [
    'attempts' => env('SMS_RETRY_ATTEMPTS', 3),
    'delay' => env('SMS_RETRY_DELAY', 60),
],
'rate_limit' => [
    'enabled' => env('SMS_RATE_LIMIT_ENABLED', true),
    'max_attempts' => env('SMS_RATE_LIMIT_MAX_ATTEMPTS', 60),
    'decay_minutes' => env('SMS_RATE_LIMIT_DECAY_MINUTES', 1),
],
```

### Parametri Specifici per Netfun (nella sezione drivers)

```php
'drivers' => [
    'netfun' => [
        // SOLO parametri specifici per Netfun
        'token' => env('NETFUN_TOKEN'),  // Token di autenticazione Netfun
        'api_url' => env('NETFUN_API_URL', 'https://v2.smsviainternet.it/api/rest/v1/sms-batch.json'),
        'circuit_breaker' => [
            'threshold' => env('NETFUN_CIRCUIT_BREAKER_THRESHOLD', 5),
            'timeout' => env('NETFUN_CIRCUIT_BREAKER_TIMEOUT', 60),
        ],
    ],
],
```

## Variabili d'Ambiente Richieste

Le seguenti variabili d'ambiente devono essere configurate nel file `.env` dell'applicazione:

```

# Parametri globali
SMS_FROM=YourSender
SMS_DEBUG=false

# Parametri specifici per Netfun
NETFUN_TOKEN=your_token
NETFUN_API_URL=https://v2.smsviainternet.it/api/rest/v1/sms-batch.json
```

## Note Importanti

1. **Autenticazione**: Netfun richiede un token di autenticazione per accedere alle sue API.
2. **Mittente (from)**: Il mittente è un parametro globale definito come `SMS_FROM` e non deve essere duplicato nella configurazione specifica di Netfun.
3. **Debug**: Il parametro debug è globale e non deve essere duplicato nella configurazione specifica di Netfun.
4. **Nomenclatura**: Utilizzare `token` (non `api_key`) per l'autenticazione Netfun, seguendo la nomenclatura standardizzata.

## Errori Comuni da Evitare

1. **Duplicazione di parametri globali**: Non duplicare parametri come `from`, `debug`, `retry` o `rate_limit` nella configurazione specifica di Netfun.
2. **Nomenclatura inconsistente**: Non utilizzare nomi alternativi come `api_key` invece di `token` o `sender` invece di `from`.
3. **Valori predefiniti hardcoded**: Non includere valori predefiniti hardcoded per parametri che dovrebbero essere configurati nell'ambiente.

## Documentazione Correlata

- [Struttura Standardizzata della Configurazione SMS](./STANDARDIZED_SMS_CONFIG_STRUCTURE.md)
- [Canale SMS Netfun](./SMS_NETFUN_CHANNEL.md)
- [Struttura Standardizzata della Configurazione SMS](../../standardized_sms_config_structure.md)
- [Canale SMS Netfun](../../sms_netfun_channel.md)

## Supporto

Per problemi di configurazione o domande sull'integrazione con Netfun, consultare la documentazione ufficiale di Netfun o contattare il team di supporto.

---

*Ultimo aggiornamento: 2025-05-12*

## 2. Esempio di .env

```
NETFUN_TOKEN=la_tua_api_key
NETFUN_SENDER=MittenteSMS
NETFUN_ENDPOINT=https://v2.smsviainternet.it/api/rest/v1/sms-batch.json

# NETFUN_CALLBACK_URL=https://tuodominio.it/sms/callback
```

## 3. Descrizione Parametri
- **token**: Token di autenticazione Netfun, obbligatoria per autenticazione.
- **sender**: Nome mittente (max 11 caratteri alfanumerici o 15 numerici, secondo policy Netfun).
- **endpoint**: URL endpoint batch Netfun (default consigliato).
- **callback_url**: (Opzionale) URL per ricevere report di consegna (delivery report).
- **options**: (Opzionale) Array per parametri avanzati (es. priorità, report, ecc).

## 4. Note Importanti
- Verifica che la chiave API sia attiva e abbia i permessi per l'invio.
- Il mittente deve essere registrato e approvato da Netfun.
- L'endpoint batch supporta invio multiplo e singolo.
- Per ricevere i report di consegna, configura il callback e assicurati che sia raggiungibile da Netfun.
- Tutti i parametri sensibili devono essere gestiti tramite variabili d'ambiente.

## 5. Riferimenti
- [Documentazione Netfun](https://www.netfunitalia.it/)
- [API Reference Netfun](https://v2.smsviainternet.it/api/rest/v1/sms-batch.json)

## Errori Comuni

1. **Mancata inclusione nel file di configurazione**: Se il provider Netfun non è incluso nella sezione 'drivers' del file `config/sms.php`, si verificheranno errori quando si tenta di utilizzare questo provider.

2. **API Key non valida**: Verificare sempre che l'API Key sia corretta e attiva.

3. **Endpoint errato**: L'endpoint corretto per l'invio di SMS batch è `https://v2.smsviainternet.it/api/rest/v1/sms-batch.json`.

## Checklist di Verifica

- [ ] Configurazione 'netfun' presente nel file `config/sms.php`
- [ ] Variabili d'ambiente configurate nel file `.env`
- [ ] Netfun incluso nei driver supportati nel commento del file di configurazione
- [ ] Endpoint corretto specificato nella configurazione

## Collegamenti

- [Documentazione Completa Netfun Channel](./SMS_NETFUN_CHANNEL.md)
- [Esempi di Utilizzo Netfun](./NETFUN_EXAMPLES.md)
- [Documentazione Completa Netfun Channel](../../sms_netfun_channel.md)
- [Esempi di Utilizzo Netfun](../../netfun_examples.md)
- [Risoluzione Conflitti Netfun](./netfunchannel_conflict_resolution.md)

---

*Ultimo aggiornamento: 2025-05-12*

---

## netfun_examples

*Consolidated from: `netfun_examples.md`*


## 1. Invio SMS OTP

### 1.1 Notification Class
```php
<?php

namespace Modules\Notify\Notifications;

use Illuminate\Support\Carbon;
use Modules\Notify\App\Data\NetfunSmsRequestData;

class OtpSmsNotification extends NetfunSmsNotification
{
    /**
     * @var string
     */
    protected string $otp;

    /**
     * @var Carbon
     */
    protected Carbon $expiresAt;

    /**
     * @param string $otp
     * @param int $minutes
     */
    public function __construct(string $otp, int $minutes = 5)
    {
        $this->otp = $otp;
        $this->expiresAt = now()->addMinutes($minutes);

        parent::__construct(
            message: "Il tuo codice OTP è: {$otp}. Valido fino alle {$this->expiresAt->format('H:i')}.",
            sender: '<nome progetto>'
            sender: 'SALUTEORA'
        );
    }

    /**
     * Get the OTP
     *
     * @return string
     */
    public function getOtp(): string
    {
        return $this->otp;
    }

    /**
     * Get the expiration time
     *
     * @return Carbon
     */
    public function getExpiresAt(): Carbon
    {
        return $this->expiresAt;
    }

    /**
     * Get the Netfun representation of the notification.
     *
     * @param mixed $notifiable
     * @return NetfunSmsRequestData
     */
    public function toNetfun($notifiable): NetfunSmsRequestData
    {
        return new NetfunSmsRequestData(
            to: $notifiable->phone_number,
            text: $this->message,
            from: $this->sender
        );
    }
}
```

### 1.2 Utilizzo
```php
// Nel controller
public function sendOtp(User $user)
{
    try {
        // Genera OTP
        $otp = str_pad(random_int(0, 999999), 6, '0', STR_PAD_LEFT);

        
        // Salva OTP nel database con scadenza
        $user->update([
            'otp' => $otp,
            'otp_expires_at' => now()->addMinutes(5)
        ]);

        
        // Invia SMS
        $user->notify(new OtpSmsNotification($otp));

        return response()->json([
            'message' => 'OTP inviato con successo',
            'expires_at' => now()->addMinutes(5)
        ]);

    } catch (\Exception $e) {
        Log::error('Errore invio OTP', [
            'user_id' => $user->id,
            'error' => $e->getMessage()
        ]);

        return response()->json([
            'message' => 'Errore nell\'invio dell\'OTP'
        ], 500);
    }
}

// Verifica OTP
public function verifyOtp(Request $request, User $user)
{
    $request->validate([
        'otp' => 'required|string|size:6'
    ]);

    if ($user->otp !== $request->otp) {
        return response()->json([
            'message' => 'OTP non valido'
        ], 400);
    }

    if ($user->otp_expires_at->isPast()) {
        return response()->json([
            'message' => 'OTP scaduto'
        ], 400);
    }

    // OTP valido, resetta i campi
    $user->update([
        'otp' => null,
        'otp_expires_at' => null
    ]);

    return response()->json([
        'message' => 'OTP verificato con successo'
    ]);
}
```

## 2. Invio SMS Promemoria

### 2.1 Notification Class
```php
<?php

namespace Modules\Notify\Notifications;

use Illuminate\Support\Carbon;
use Modules\Notify\App\Data\NetfunSmsRequestData;

class AppointmentReminderNotification extends NetfunSmsNotification
{
    /**
     * @var Carbon
     */
    protected Carbon $appointmentDate;

    /**
     * @var string
     */
    protected string $doctorName;

    /**
     * @var string
     */
    protected string $location;

    /**
     * @var string|null
     */
    protected ?string $notes;

    /**
     * @param Carbon $appointmentDate
     * @param string $doctorName
     * @param string $location
     * @param string|null $notes
     */
    public function __construct(
        Carbon $appointmentDate,
        string $doctorName,
        string $location,
        ?string $notes = null
    ) {
        $this->appointmentDate = $appointmentDate;
        $this->doctorName = $doctorName;
        $this->location = $location;
        $this->notes = $notes;

        $message = "Promemoria: Hai un appuntamento con {$doctorName} il {$appointmentDate->format('d/m/Y H:i')}";
        $message .= " presso {$location}.";

        
        if ($notes) {
            $message .= " Note: {$notes}";
        }

        parent::__construct(
            message: $message,
            sender: '<nome progetto>'
            sender: 'SALUTEORA'
        );
    }

    /**
     * Get the Netfun representation of the notification.
     *
     * @param mixed $notifiable
     * @return NetfunSmsRequestData
     */
    public function toNetfun($notifiable): NetfunSmsRequestData
    {
        return new NetfunSmsRequestData(
            to: $notifiable->phone_number,
            text: $this->message,
            from: $this->sender
        );
    }
}
```

### 2.2 Utilizzo
```php
// Nel controller
public function sendReminder(Appointment $appointment)
{
    try {
        // Verifica se l'appuntamento è nel futuro
        if ($appointment->date->isPast()) {
            throw new \Exception('Impossibile inviare promemoria per un appuntamento passato');
        }

        // Verifica se il promemoria è già stato inviato
        if ($appointment->reminder_sent_at) {
            throw new \Exception('Promemoria già inviato');
        }

        // Invia il promemoria
        $appointment->patient->notify(
            new AppointmentReminderNotification(
                appointmentDate: $appointment->date,
                doctorName: $appointment->doctor->name,
                location: $appointment->location,
                notes: $appointment->notes
            )
        );

        // Aggiorna lo stato del promemoria
        $appointment->update([
            'reminder_sent_at' => now()
        ]);

        return response()->json([
            'message' => 'Promemoria inviato con successo'
        ]);

    } catch (\Exception $e) {
        Log::error('Errore invio promemoria', [
            'appointment_id' => $appointment->id,
            'error' => $e->getMessage()
        ]);

        return response()->json([
            'message' => 'Errore nell\'invio del promemoria'
        ], 500);
    }
}
```

## 3. Invio SMS Massivo

### 3.1 Action
```php
<?php

namespace Modules\Notify\Actions;

use Spatie\QueueableAction\QueueableAction;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Cache;
use Modules\Notify\App\Data\NetfunSmsRequestData;
use Modules\Notify\App\Data\NetfunSmsResponseData;

class SendBulkSmsAction
{
    use QueueableAction;

    /**
     * @var Collection
     */
    protected Collection $users;

    /**
     * @var string
     */
    protected string $message;

    /**
     * @var string
     */
    protected string $sender;

    /**
     * @var int
     */
    protected int $batchSize;

    /**
     * @var int
     */
    protected int $delayBetweenBatches;

    /**
     * @param Collection $users
     * @param string $message
     * @param string $sender
     * @param int $batchSize
     * @param int $delayBetweenBatches
     */
    public function __construct(
        Collection $users,
        string $message,
        string $sender,
        int $batchSize = 100,
        int $delayBetweenBatches = 1
    ) {
        $this->users = $users;
        $this->message = $message;
        $this->sender = $sender;
        $this->batchSize = $batchSize;
        $this->delayBetweenBatches = $delayBetweenBatches;
    }

    /**
     * Esegue l'azione di invio SMS massivo
     *
     * @return array
     * @throws \Exception
     */
    public function execute(): array
    {
        $results = [
            'total' => $this->users->count(),
            'success' => 0,
            'failed' => 0,
            'errors' => []
        ];

        try {
            // Prepara il batch di messaggi
            $messages = $this->users->map(function ($user) {
                return new NetfunSmsRequestData(
                    to: $user->phone_number,
                    text: $this->message,
                    from: $this->sender
                );
            })->chunk($this->batchSize);

            // Invia ogni batch
            foreach ($messages as $batch) {
                try {
                    $response = Http::withHeaders([
                        'Authorization' => 'Bearer ' . config('notify.netfun.api_key'),
                        'Content-Type' => 'application/json',
                        'Accept' => 'application/json'
                    ])->timeout(30)->post(config('notify.netfun.endpoint'), [
                        'messages' => $batch->map(fn($message) => $message->toArray())->values()->all()
                    ]);

                    if (!$response->successful()) {
                        throw new \Exception('Errore HTTP: ' . $response->status());
                    }

                    $result = NetfunSmsResponseData::fromArray($response->json());

                    
                    if ($result->status !== 'success') {
                        throw new \Exception($result->error ?? 'Errore sconosciuto');
                    }

                    $results['success'] += $batch->count();

                } catch (\Exception $e) {
                    $results['failed'] += $batch->count();
                    $results['errors'][] = [
                        'batch_size' => $batch->count(),
                        'error' => $e->getMessage()
                    ];

                    Log::error('Errore invio batch SMS', [
                        'error' => $e->getMessage(),
                        'batch_size' => $batch->count()
                    ]);
                }

                // Attendi tra i batch
                if ($this->delayBetweenBatches > 0) {
                    sleep($this->delayBetweenBatches);
                }
            }

            return $results;

        } catch (\Exception $e) {
            Log::error('Eccezione invio SMS massivo', [
                'error' => $e->getMessage(),
                'total_users' => $this->users->count()
            ]);

            throw $e;
        }
    }
}
```

### 3.2 Utilizzo
```php
// Nel controller
public function sendBulkSms(Request $request)
{
    $request->validate([
        'message' => 'required|string|max:160',
        'user_ids' => 'required|array',
        'user_ids.*' => 'exists:users,id'
    ]);

    try {
        $users = User::whereIn('id', $request->user_ids)
            ->where('consent_sms', true)
            ->get();

        if ($users->isEmpty()) {
            return response()->json([
                'message' => 'Nessun utente valido trovato'
            ], 400);
        }

        $results = SendBulkSmsAction::make(
            users: $users,
            message: $request->message,
            sender: '<nome progetto>',
            sender: 'SALUTEORA',
            batchSize: 100,
            delayBetweenBatches: 1
        )->onQueue('bulk-sms')->execute();

        return response()->json([
            'message' => 'Invio SMS massivo completato',
            'results' => $results
        ]);

    } catch (\Exception $e) {
        Log::error('Errore invio SMS massivo', [
            'error' => $e->getMessage(),
            'user_ids' => $request->user_ids
        ]);

        return response()->json([
            'message' => 'Errore nell\'invio degli SMS'
        ], 500);
    }
}
```

## 4. Gestione Errori Avanzata

### 4.1 Action con Retry e Circuit Breaker
```php
<?php

namespace Modules\Notify\Actions;

use Illuminate\Support\Facades\Cache;
use Modules\Notify\App\Data\NetfunSmsResponseData;

class SendNetfunSmsWithRetryAction extends SendNetfunSmsAction
{
    /**
     * @var int
     */
    protected int $maxRetries;

    /**
     * @var int
     */
    protected int $retryDelay;

    /**
     * @var int
     */
    protected int $circuitBreakerThreshold;

    /**
     * @var int
     */
    protected int $circuitBreakerTimeout;

    public function __construct(
        string $to,
        string $message,
        string $sender
    ) {
        parent::__construct($to, $message, $sender);

        
        $this->maxRetries = config('notify.netfun.max_retries', 3);
        $this->retryDelay = config('notify.netfun.retry_delay', 1);
        $this->circuitBreakerThreshold = config('notify.netfun.circuit_breaker.threshold', 5);
        $this->circuitBreakerTimeout = config('notify.netfun.circuit_breaker.timeout', 60);
    }

    /**
     * Esegue l'azione con retry e circuit breaker
     *
     * @return NetfunSmsResponseData
     * @throws \Exception
     */
    public function execute(): NetfunSmsResponseData
    {
        // Verifica circuit breaker
        if ($this->isCircuitBreakerOpen()) {
            throw new \Exception('Circuit breaker is open');
        }

        $attempts = 0;
        $lastException = null;

        while ($attempts < $this->maxRetries) {
            try {
                $result = parent::execute();

                // Reset circuit breaker on success
                $this->resetCircuitBreaker();

                
                // Reset circuit breaker on success
                $this->resetCircuitBreaker();
                
                return $result;

            } catch (\Exception $e) {
                $lastException = $e;
                $attempts++;

                if ($attempts === $this->maxRetries) {
                    // Increment circuit breaker counter
                    $this->incrementCircuitBreaker();

                    
                    Log::error('Tentativi esauriti per invio SMS', [
                        'to' => $this->to,
                        'error' => $e->getMessage(),
                        'attempts' => $attempts
                    ]);

                    
                    throw $e;
                }

                Log::warning('Tentativo fallito, riprovo...', [
                    'attempt' => $attempts,
                    'error' => $e->getMessage()
                ]);

                sleep($this->retryDelay);
            }
        }

        throw $lastException;
    }

    /**
     * Verifica se il circuit breaker è aperto
     *
     * @return bool
     */
    protected function isCircuitBreakerOpen(): bool
    {
        return Cache::get('netfun_circuit_breaker', false);
    }

    /**
     * Incrementa il contatore del circuit breaker
     */
    protected function incrementCircuitBreaker(): void
    {
        $key = 'netfun_circuit_breaker_failures';
        $failures = Cache::get($key, 0) + 1;

        
        Cache::put($key, $failures, $this->circuitBreakerTimeout);

        if ($failures >= $this->circuitBreakerThreshold) {
            Cache::put('netfun_circuit_breaker', true, $this->circuitBreakerTimeout);
        }
    }

    /**
     * Resetta il circuit breaker
     */
    protected function resetCircuitBreaker(): void
    {
        Cache::forget('netfun_circuit_breaker');
        Cache::forget('netfun_circuit_breaker_failures');
    }
}
```

## 5. Monitoraggio Avanzato

### 5.1 Action con Metriche e Prometheus
```php
<?php

namespace Modules\Notify\Actions;

use Prometheus\CollectorRegistry;
use Modules\Notify\App\Data\NetfunSmsResponseData;

class SendNetfunSmsWithMetricsAction extends SendNetfunSmsAction
{
    /**
     * @var CollectorRegistry
     */
    protected CollectorRegistry $prometheus;

    public function __construct(
        string $to,
        string $message,
        string $sender
    ) {
        parent::__construct($to, $message, $sender);
        $this->prometheus = app(CollectorRegistry::class);
    }

    /**
     * Esegue l'azione con metriche
     *
     * @return NetfunSmsResponseData
     * @throws \Exception
     */
    public function execute(): NetfunSmsResponseData
    {
        $startTime = microtime(true);

        try {
            $result = parent::execute();

        
        try {
            $result = parent::execute();
            
            // Registra metriche di successo
            $this->recordMetrics(true, microtime(true) - $startTime, [
                'message_id' => $result->message_id,
                'status' => $result->status
            ]);

            
            return $result;

        } catch (\Exception $e) {
            // Registra metriche di errore
            $this->recordMetrics(false, microtime(true) - $startTime, [
                'error' => $e->getMessage()
            ]);

            throw $e;
        }
    }

            
            throw $e;
        }
    }
    
    /**
     * Registra le metriche
     *
     * @param bool $success
     * @param float $duration
     * @param array $context
     */
    protected function recordMetrics(bool $success, float $duration, array $context = []): void
    {
        // Incrementa il contatore totale
        $this->prometheus->getOrRegisterCounter(
            'netfun',
            'sms_total',
            'Total number of SMS sent'
        )->inc();

        // Incrementa il contatore di successo/errore
        $this->prometheus->getOrRegisterCounter(
            'netfun',
            'sms_' . ($success ? 'success' : 'error'),
            'Number of successful/failed SMS'
        )->inc();

        // Registra la durata
        $this->prometheus->getOrRegisterHistogram(
            'netfun',
            'sms_duration_seconds',
            'SMS sending duration in seconds'
        )->observe($duration);

        // Log dettagliato
        Log::info('Metriche SMS', array_merge([
            'success' => $success,
            'duration' => $duration,
            'to' => $this->to,
            'sender' => $this->sender
        ], $context));
    }
}
```

## 6. Esempi di Test

### 6.1 Test Unitario
```php
<?php

namespace Modules\Notify\Tests\Unit;

use Tests\TestCase;
use Modules\Notify\Actions\SendNetfunSmsAction;
use Modules\Notify\App\Data\NetfunSmsResponseData;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;

class NetfunSmsActionTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        Cache::flush();
    }

    public function test_sms_sent_with_valid_data()
    {
        Http::fake([
            config('notify.netfun.endpoint') => Http::response([
                'status' => 'success',
                'message_id' => '123456'
            ], 200)
        ]);

        $action = SendNetfunSmsAction::make(
            to: '+393331234567',
            message: 'Test message',
            sender: 'TEST'
        );

        $result = $action->execute();

        $this->assertInstanceOf(NetfunSmsResponseData::class, $result);
        $this->assertEquals('success', $result->status);
        $this->assertEquals('123456', $result->message_id);

        
        Http::assertSent(function ($request) {
            return $request->url() == config('notify.netfun.endpoint') &&
                   $request['messages'][0]['to'] == '+393331234567' &&
                   $request['messages'][0]['text'] == 'Test message' &&
                   $request['messages'][0]['from'] == 'TEST';
        });
    }

    public function test_sms_fails_with_invalid_number()
    {
        Http::fake([
            config('notify.netfun.endpoint') => Http::response([
                'status' => 'error',
                'error' => 'Invalid phone number'
            ], 400)
        ]);

        $this->expectException(\Exception::class);

        $action = SendNetfunSmsAction::make(
            to: 'invalid',
            message: 'Test message',
            sender: 'TEST'
        );

        $action->execute();
    }

    public function test_rate_limiting()
    {
        $action = SendNetfunSmsAction::make(
            to: '+393331234567',
            message: 'Test message',
            sender: 'TEST'
        );

        // Simula il raggiungimento del rate limit
        Cache::put('netfun_rate_limit_' . date('YmdHis'), 100, 60);

        $this->expectException(\Exception::class);
        $this->expectExceptionMessage('Rate limit exceeded');

        $action->execute();
    }

    public function test_circuit_breaker()
    {
        $action = new SendNetfunSmsWithRetryAction(
            to: '+393331234567',
            message: 'Test message',
            sender: 'TEST'
        );

        // Simula il circuit breaker aperto
        Cache::put('netfun_circuit_breaker', true, 60);

        $this->expectException(\Exception::class);
        $this->expectExceptionMessage('Circuit breaker is open');

        $action->execute();
    }
}
```

### 6.2 Test di Integrazione
```php
<?php

namespace Modules\Notify\Tests\Feature;

use Tests\TestCase;
use Modules\Patient\Models\User;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Queue;
use Illuminate\Support\Facades\Cache;

class NetfunNotificationIntegrationTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        Queue::fake();
        Cache::flush();
    }

    public function test_otp_notification_sent()
    {
        Http::fake([
            config('notify.netfun.endpoint') => Http::response([
                'status' => 'success',
                'message_id' => '123456'
            ], 200)
        ]);

        $user = User::factory()->create([
            'phone_number' => '+393331234567',
            'consent_sms' => true
        ]);

        $otp = '123456';

        
        $user->notify(new OtpSmsNotification($otp));

        Http::assertSent(function ($request) use ($otp) {
            return $request->url() == config('notify.netfun.endpoint') &&
                   $request['messages'][0]['to'] == '+393331234567' &&
                   str_contains($request['messages'][0]['text'], $otp);
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

    public function test_bulk_sms_sent()
    {
        Http::fake([
            config('notify.netfun.endpoint') => Http::response([
                'status' => 'success',
                'message_id' => '123456'
            ], 200)
        ]);

        $users = User::factory()->count(3)->create([
            'consent_sms' => true
        ]);

        $results = SendBulkSmsAction::make(
            users: $users,
            message: 'Test message',
            sender: 'TEST'
        )->execute();

        $this->assertEquals(3, $results['total']);
        $this->assertEquals(3, $results['success']);
        $this->assertEquals(0, $results['failed']);

        Http::assertSentCount(1);
    }

    public function test_metrics_recorded()
    {
        $action = new SendNetfunSmsWithMetricsAction(
            to: '+393331234567',
            message: 'Test message',
            sender: 'TEST'
        );

        $metrics = $action->recordMetrics(true, 0.5, [
            'message_id' => '123456'
        ]);

        $this->assertTrue($metrics['success']);
        $this->assertEquals(0.5, $metrics['duration']);
        $this->assertEquals('123456', $metrics['message_id']);
    }
}
```

## 7. Collegamenti Utili

- [Documentazione Netfun](https://www.netfunitalia.it/)
- [API Netfun](https://v2.smsviainternet.it/api/rest/v1/)
- [Spatie Queueable Action](https://github.com/spatie/laravel-queueable-action)
- [Spatie Laravel Data](https://github.com/spatie/laravel-data)
- [Laravel Notifications](https://laravel.com/docs/notifications)
- [Laravel Queues](https://laravel.com/docs/queues)
- [Laravel Testing](https://laravel.com/docs/testing)
- [Laravel Logging](https://laravel.com/docs/logging)
- [Laravel Cache](https://laravel.com/docs/cache)
- [Prometheus PHP Client](https://github.com/promphp/prometheus_client_php)
- [Prometheus PHP Client](https://github.com/promphp/prometheus_client_php) 

---

## netfunchannel-conflict-resolution

*Consolidated from: `netfunchannel-conflict-resolution.md`*


## Motivazione
Il conflitto era dovuto a merge multipli che hanno duplicato blocchi identici nel metodo send().

- È stata mantenuta una sola versione del blocco, con commenti in italiano e stile PSR-12.
- Nessuna logica è stata alterata rispetto alle versioni in conflitto.

## Collegamento alla doc root
Vedi `/docs/notify_conflict_links.md` per la mappatura dei file documentati localmente e i riferimenti incrociati.

---

**Consolidated by:** Phase 2f intelligent merging
**Date:** 2026-08-04
