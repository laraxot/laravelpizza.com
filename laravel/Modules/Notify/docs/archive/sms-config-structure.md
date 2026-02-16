# Struttura della Configurazione SMS 

## Introduzione

Questo documento definisce la struttura corretta del file di configurazione SMS (`config/sms.php`) nel modulo Notify, con particolare attenzione alla gestione delle configurazioni generiche vs specifiche per provider.

## Struttura Generale

Il file `config/sms.php` è organizzato in sezioni distinte:

```php
return [
    // Driver predefinito
    'default' => env('SMS_DRIVER', 'default_provider'),
    
    // Configurazione dei driver/provider
    'drivers' => [
        // Configurazioni specifiche per provider...
    ],
    
    // Configurazioni generiche per tutti i provider
    'queue' => env('SMS_QUEUE', 'default'),
    'retry' => [...],
    'rate_limit' => [...],
    'logging' => [...],
    'validation' => [...],
];
```

## Configurazioni Generiche vs Specifiche

### 1. Configurazioni Generiche

Le configurazioni generiche si applicano a **tutti** i provider SMS e sono definite a livello di root nel file di configurazione:

```php
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

### 2. Configurazioni Specifiche per Provider

Le configurazioni specifiche per provider sono definite all'interno della sezione `drivers` e contengono **solo** i parametri specifici per quel provider:

```php
'drivers' => [
    'netfun' => [
        // Credenziali e parametri di connessione
        'username' => env('NETFUN_USERNAME'),
        'password' => env('NETFUN_PASSWORD'),
        'sender' => env('NETFUN_SENDER', 'SaluteOra'),
        'api_url' => env('NETFUN_API_URL', 'https://v2.smsviainternet.it/api/rest/v1/sms-batch.json'),
        
        // Configurazioni avanzate specifiche per Netfun
        'circuit_breaker' => [
            'threshold' => env('NETFUN_CIRCUIT_BREAKER_THRESHOLD', 5),
            'timeout' => env('NETFUN_CIRCUIT_BREAKER_TIMEOUT', 60),
        ],
    ],
    
    'twilio' => [
        'account_sid' => env('TWILIO_ACCOUNT_SID'),
        'auth_token' => env('TWILIO_AUTH_TOKEN'),
        'from' => env('TWILIO_FROM'),
    ],
    
    // Altri provider...
],
```

## Regola Fondamentale: Evitare Duplicazioni

**IMPORTANTE**: Evitare di duplicare le configurazioni generiche all'interno delle configurazioni specifiche per provider. Ad esempio:

❌ **ERRATO**:
```php
'drivers' => [
    'netfun' => [
        // ...
        'max_retries' => env('NETFUN_MAX_RETRIES', 3),      // Duplica 'retry.attempts'
        'retry_delay' => env('NETFUN_RETRY_DELAY', 1),      // Duplica 'retry.delay'
        'rate_limit' => env('NETFUN_RATE_LIMIT', 100),      // Duplica 'rate_limit.max_attempts'
        'rate_limit_window' => env('NETFUN_RATE_LIMIT_WINDOW', 60), // Duplica 'rate_limit.decay_minutes'
        // ...
    ],
],
```

✅ **CORRETTO**:
```php
// Configurazioni generiche a livello di root
'retry' => [
    'attempts' => env('SMS_RETRY_ATTEMPTS', 3),
    'delay' => env('SMS_RETRY_DELAY', 60),
],

'rate_limit' => [
    'enabled' => env('SMS_RATE_LIMIT_ENABLED', true),
    'max_attempts' => env('SMS_RATE_LIMIT_MAX_ATTEMPTS', 60),
    'decay_minutes' => env('SMS_RATE_LIMIT_DECAY_MINUTES', 1),
],

// Solo configurazioni specifiche per provider nella sezione 'drivers'
'drivers' => [
    'netfun' => [
        'username' => env('NETFUN_USERNAME'),
        'password' => env('NETFUN_PASSWORD'),
        'sender' => env('NETFUN_SENDER', 'SaluteOra'),
        'api_url' => env('NETFUN_API_URL', 'https://v2.smsviainternet.it/api/rest/v1/sms-batch.json'),
        
        // Solo configurazioni veramente specifiche per Netfun
        'circuit_breaker' => [
            'threshold' => env('NETFUN_CIRCUIT_BREAKER_THRESHOLD', 5),
            'timeout' => env('NETFUN_CIRCUIT_BREAKER_TIMEOUT', 60),
        ],
    ],
],
```

## Gestione Precedenze

Quando sia le configurazioni generiche che quelle specifiche per provider sono presenti:

1. Le configurazioni specifiche per provider hanno **precedenza** sulle configurazioni generiche
2. Il codice che utilizza queste configurazioni deve implementare questa logica di precedenza

Esempio di implementazione della logica di precedenza:

```php
// In una classe che gestisce l'invio SMS
$retryAttempts = $config['drivers'][$driver]['max_retries'] ?? $config['retry']['attempts'];
$retryDelay = $config['drivers'][$driver]['retry_delay'] ?? $config['retry']['delay'];
```

## Checklist di Verifica

- [ ] Configurazioni generiche (retry, rate_limit, ecc.) definite a livello di root
- [ ] Configurazioni specifiche per provider definite solo nella sezione `drivers`
- [ ] Nessuna duplicazione tra configurazioni generiche e specifiche
- [ ] Logica di precedenza implementata nel codice che utilizza queste configurazioni

## Collegamenti

- [Configurazione Netfun](./NETFUN_CONFIG_REQUIREMENTS.md)
- [Provider SMS Supportati](./notifications/SMS_PROVIDER_CONFIGURATION.md)

---

*Ultimo aggiornamento: 2025-05-12*
