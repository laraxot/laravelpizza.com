# Struttura Standardizzata della Configurazione SMS

## Introduzione

Questo documento definisce la struttura standardizzata del file di configurazione SMS (`config/sms.php`) nel modulo Notify, basata sul modello di configurazione `mail.php` di Laravel. Questa struttura garantisce coerenza, manutenibilità e chiarezza nella configurazione dei provider SMS.

## Struttura Generale

```php
return [
    // Driver predefinito
    'default' => env('SMS_DRIVER', 'default_provider'),
    
    // Parametri a livello di root
    'from' => env('SMS_FROM'),
    'debug' => env('SMS_DEBUG', false),
    'queue' => env('SMS_QUEUE', 'default'),
    'retry' => [
        'attempts' => env('SMS_RETRY_ATTEMPTS', 3),
        'delay' => env('SMS_RETRY_DELAY', 60),
    ],
    'rate_limit' => [
        'enabled' => env('SMS_RATE_LIMIT_ENABLED', true),
        'max_attempts' => env('SMS_RATE_LIMIT_MAX_ATTEMPTS', 60),
        'decay_minutes' => env('SMS_RATE_LIMIT_DECAY_MINUTES', 1),
    ],
    'logging' => [
        'enabled' => env('SMS_LOGGING_ENABLED', true),
        'channel' => env('SMS_LOGGING_CHANNEL', 'stack'),
    ],
    'validation' => [
        'enabled' => env('SMS_VALIDATION_ENABLED', true),
        'pattern' => env('SMS_VALIDATION_PATTERN', '/^\+[1-9]\d{1,14}$/'),
    ],
    
    // Configurazione dei driver/provider
    'drivers' => [
        'provider1' => [
            // Parametri specifici per questo provider
        ],
        'provider2' => [
            // Parametri specifici per questo provider
        ],
    ],
];
```

## Parametri a Livello di Root vs Specifici per Provider

### 1. Parametri a Livello di Root

I parametri a livello di root si applicano a tutti i provider SMS e sono definiti direttamente nel file di configurazione:

| Parametro | Descrizione | Esempio |
|-----------|-------------|--------|
| `from` | Mittente predefinito per tutti i provider | `env('SMS_FROM')` |
| `debug` | Modalità debug per tutti i provider | `env('SMS_DEBUG', false)` |
| `queue` | Coda predefinita per l'invio asincrono | `env('SMS_QUEUE', 'default')` |
| `retry` | Configurazione tentativi di invio | `['attempts' => env('SMS_RETRY_ATTEMPTS', 3)]` |
| `rate_limit` | Limiti di invio per tutti i provider | `['enabled' => env('SMS_RATE_LIMIT_ENABLED', true)]` |
| `logging` | Configurazione logging | `['enabled' => env('SMS_LOGGING_ENABLED', true)]` |
| `validation` | Validazione numeri di telefono | `['enabled' => env('SMS_VALIDATION_ENABLED', true)]` |

### 2. Parametri Specifici per Provider

Ogni provider ha parametri specifici che devono essere definiti nella sezione `drivers`:

#### Twilio

```php
'twilio' => [
    'account_sid' => env('TWILIO_ACCOUNT_SID'),
    'auth_token' => env('TWILIO_AUTH_TOKEN'),
],
```

#### Vonage (ex Nexmo)

```php
'nexmo' => [
    'key' => env('NEXMO_KEY'),
    'secret' => env('NEXMO_SECRET'),
],
```

#### Netfun

```php
'netfun' => [
    'token' => env('NETFUN_TOKEN'),
    'api_url' => env('NETFUN_API_URL', 'https://v2.smsviainternet.it/api/rest/v1/sms-batch.json'),
    'circuit_breaker' => [
        'threshold' => env('NETFUN_CIRCUIT_BREAKER_THRESHOLD', 5),
        'timeout' => env('NETFUN_CIRCUIT_BREAKER_TIMEOUT', 60),
    ],
],
```

## Nomenclatura Standardizzata

Per garantire coerenza tra i provider, utilizzare la seguente nomenclatura standardizzata:

| Concetto | Nome Standardizzato | Nomi da Evitare |
|----------|---------------------|-----------------|
| Mittente | `from` | `sender`, `from_number` |
| Credenziali | `key`/`secret`, `account_sid`/`auth_token`, `token` | `api_key`, `username`/`password` |
| Debug | `debug` (globale) | `debug_mode`, `is_debug` |
| Endpoint API | `api_url` | `endpoint`, `url`, `base_url` |

## Implementazione della Precedenza

Quando sia i parametri a livello di root che quelli specifici per provider sono presenti, i parametri specifici hanno precedenza:

```php
// In una classe che gestisce l'invio SMS
$from = $config['drivers'][$driver]['from'] ?? $config['from'];
$debug = $config['drivers'][$driver]['debug'] ?? $config['debug'];
```

## Esempi di Configurazione Corretta

### Configurazione Globale

```php
// Configurazioni globali a livello di root
'from' => env('SMS_FROM'),
'debug' => env('SMS_DEBUG', false),
'retry' => [
    'attempts' => env('SMS_RETRY_ATTEMPTS', 3),
    'delay' => env('SMS_RETRY_DELAY', 60),
],
```

### Configurazione Specifica per Netfun

```php
'drivers' => [
    'netfun' => [
        'token' => env('NETFUN_TOKEN'),
        'api_url' => env('NETFUN_API_URL', 'https://v2.smsviainternet.it/api/rest/v1/sms-batch.json'),
        'circuit_breaker' => [
            'threshold' => env('NETFUN_CIRCUIT_BREAKER_THRESHOLD', 5),
            'timeout' => env('NETFUN_CIRCUIT_BREAKER_TIMEOUT', 60),
        ],
    ],
],
```

## Checklist di Verifica

- [ ] Parametri comuni definiti a livello di root
- [ ] Parametri specifici per provider definiti solo nella sezione `drivers`
- [ ] Nomenclatura standardizzata utilizzata in modo coerente
- [ ] Nessuna duplicazione tra parametri a livello di root e parametri specifici per provider
- [ ] Logica di precedenza implementata nel codice che utilizza queste configurazioni

## Collegamenti

- [Configurazione Netfun](./NETFUN_CONFIG_REQUIREMENTS.md)
- [Provider SMS Supportati](./notifications/SMS_PROVIDER_CONFIGURATION.md)

---

*Ultimo aggiornamento: 2025-05-12*
