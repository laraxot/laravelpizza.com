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
