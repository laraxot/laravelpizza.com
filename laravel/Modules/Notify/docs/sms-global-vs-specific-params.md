# Parametri a Livello di Root vs Specifici per Provider nella Configurazione SMS

## Introduzione

Questo documento chiarisce la distinzione fondamentale tra parametri a livello di root e specifici per provider nella configurazione SMS del modulo Notify. Una corretta comprensione di questa distinzione è essenziale per evitare duplicazioni e inconsistenze nella configurazione.

## Struttura della Configurazione

La configurazione SMS segue una struttura gerarchica con due livelli principali:

1. **Livello Root**: Parametri comuni che si applicano a tutti i provider SMS
2. **Livello Provider**: Parametri che sono specifici per un determinato provider

```php
return [
    // Parametri a livello di root
    'default' => env('SMS_DRIVER', 'default_provider'),
    'from' => env('SMS_FROM'),
    'debug' => env('SMS_DEBUG', false),
    'queue' => env('SMS_QUEUE', 'default'),
    'retry' => [...],
    'rate_limit' => [...],
    'circuit_breaker' => [...],
    
    // Parametri specifici per provider (nella sezione 'drivers')
    'drivers' => [
        'provider1' => [
            // Solo parametri specifici per questo provider
        ],
        'provider2' => [
            // Solo parametri specifici per questo provider
        ],
    ],
];
```

## Parametri a Livello di Root

I parametri a livello di root sono definiti direttamente nel file di configurazione e si applicano a tutti i provider SMS. Questi parametri **NON devono essere duplicati** nella configurazione specifica di ciascun provider.

### Esempi di Parametri a Livello di Root

| Parametro | Descrizione | Variabile d'Ambiente |
|-----------|-------------|----------------------|
| `from` | Mittente predefinito per tutti i messaggi | `SMS_FROM` |
| `debug` | Modalità debug per tutti i provider | `SMS_DEBUG` |
| `queue` | Coda per l'invio asincrono | `SMS_QUEUE` |
| `retry.attempts` | Numero di tentativi di invio | `SMS_RETRY_ATTEMPTS` |
| `retry.delay` | Ritardo tra i tentativi (secondi) | `SMS_RETRY_DELAY` |
| `rate_limit.enabled` | Abilitazione del rate limiting | `SMS_RATE_LIMIT_ENABLED` |
| `rate_limit.max_attempts` | Numero massimo di tentativi | `SMS_RATE_LIMIT_MAX_ATTEMPTS` |
| `rate_limit.decay_minutes` | Finestra temporale per il rate limiting | `SMS_RATE_LIMIT_DECAY_MINUTES` |
| `circuit_breaker.enabled` | Abilitazione del circuit breaker | `SMS_CIRCUIT_BREAKER_ENABLED` |
| `circuit_breaker.threshold` | Soglia di errori per il circuit breaker | `SMS_CIRCUIT_BREAKER_THRESHOLD` |
| `circuit_breaker.timeout` | Timeout del circuit breaker (secondi) | `SMS_CIRCUIT_BREAKER_TIMEOUT` |

## Parametri Specifici per Provider

I parametri specifici per provider sono definiti all'interno della sezione `drivers` e si applicano solo al provider specifico. Questi parametri **NON devono duplicare** i parametri globali.

### Esempi di Parametri Specifici per Provider

#### Twilio

```php
'twilio' => [
    'account_sid' => env('TWILIO_ACCOUNT_SID'),
    'auth_token' => env('TWILIO_AUTH_TOKEN'),
],
```

#### Netfun

```php
'netfun' => [
    'token' => env('NETFUN_TOKEN'),
    'api_url' => env('NETFUN_API_URL', 'https://v2.smsviainternet.it/api/rest/v1/sms-batch.json'),
    'callback_url' => env('NETFUN_CALLBACK_URL'),
    'circuit_breaker' => [  // Solo se necessario sovrascrivere il comportamento globale
        'threshold' => env('NETFUN_CIRCUIT_BREAKER_THRESHOLD', 5),
        'timeout' => env('NETFUN_CIRCUIT_BREAKER_TIMEOUT', 60),
    ],
],
```

## Errori Comuni da Evitare

### 1. Duplicazione di Parametri a Livello di Root

❌ **Errato**:
```php
'netfun' => [
    'token' => env('NETFUN_TOKEN'),
    'from' => env('NETFUN_FROM'),  // ERRORE: duplica il parametro 'from' a livello di root
    'debug' => env('NETFUN_DEBUG', false),  // ERRORE: duplica il parametro 'debug' a livello di root
],
```

✅ **Corretto**:
```php
// A livello di root
'from' => env('SMS_FROM'),
'debug' => env('SMS_DEBUG', false),

// Nella sezione 'drivers'
'netfun' => [
    'token' => env('NETFUN_TOKEN'),
    // Nessuna duplicazione di parametri a livello di root
],
```

### 2. Nomenclatura Inconsistente

❌ **Errato**:
```php
// Nomi diversi per lo stesso concetto
'twilio' => [
    'from' => env('TWILIO_FROM'),
],
'netfun' => [
    'sender' => env('NETFUN_SENDER'),  // ERRORE: usa 'sender' invece di 'from'
],
```

✅ **Corretto**:
```php
// A livello globale
'from' => env('SMS_FROM'),

// Nessuna duplicazione nella sezione 'drivers'
```

### 3. Parametri Specifici a Livello Globale

❌ **Errato**:
```php
// A livello globale
'netfun_token' => env('NETFUN_TOKEN'),  // ERRORE: parametro specifico a livello globale
```

✅ **Corretto**:
```php
// Nella sezione 'drivers'
'netfun' => [
    'token' => env('NETFUN_TOKEN'),
],
```

## Implementazione della Precedenza

Quando sia i parametri a livello di root che quelli specifici per provider sono presenti, i parametri specifici hanno precedenza. Questo comportamento deve essere implementato nel codice che utilizza queste configurazioni:

```php
// In una classe che gestisce l'invio SMS
$config = config('sms');
$driver = $config['default'];

// Implementazione della precedenza
$debug = $config['drivers'][$driver]['debug'] ?? $config['debug'];
```

## Checklist di Verifica

Prima di modificare la configurazione SMS, verificare che:

- [ ] I parametri comuni siano definiti a livello di root
- [ ] I parametri specifici per provider siano definiti solo nella sezione `drivers`
- [ ] Non ci siano duplicazioni tra parametri a livello di root e parametri specifici per provider
- [ ] La nomenclatura sia coerente tra i diversi provider
- [ ] I nomi dei parametri seguano le convenzioni standard

## Riferimenti

- [Struttura Standardizzata della Configurazione SMS](./STANDARDIZED_SMS_CONFIG_STRUCTURE.md)
- [Configurazione Netfun](./NETFUN_CONFIG_REQUIREMENTS.md)
- [Laravel Configuration Best Practices](https://laravel.com/docs/configuration)

---

*Ultimo aggiornamento: 2025-05-12*
