# Best Practices per la Configurazione dei Provider SMS

## Struttura Corretta della Configurazione

, il file di configurazione SMS (`config/sms.php`) deve seguire una struttura precisa che separa chiaramente le configurazioni generiche dalle configurazioni specifiche dei provider.

### Configurazione Corretta

```php
<?php

return [
    // Driver predefinito
    'default' => env('SMS_DRIVER', 'netfun'),

    // Configurazioni generiche applicabili a tutti i driver
    'from' => env('SMS_FROM'),
    'timeout' => (int) env('SMS_TIMEOUT', 30),
    'debug' => (bool) env('SMS_DEBUG', false),

    // Configurazione per retry e circuit breaker
    'retry' => [
        'attempts' => (int) env('SMS_RETRY_ATTEMPTS', 3),
        'delay' => (int) env('SMS_RETRY_DELAY', 60),
    ],

    // Configurazione per rate limiting
    'rate_limit' => [
        'enabled' => (bool) env('SMS_RATE_LIMIT_ENABLED', true),
        'max_attempts' => (int) env('SMS_RATE_LIMIT_MAX_ATTEMPTS', 60),
        'decay_minutes' => (int) env('SMS_RATE_LIMIT_DECAY_MINUTES', 1),
    ],

    // Configurazioni specifiche per driver
    'drivers' => [
        'netfun' => [
            // Solo parametri specifici per Netfun
            'username' => env('NETFUN_USERNAME'),
            'password' => env('NETFUN_PASSWORD'),
            'sender' => env('NETFUN_SENDER'),
            'api_url' => env('NETFUN_API_URL', 'https://v2.smsviainternet.it/api/rest/v1/sms-batch.json'),
        ],

        'twilio' => [
            // Solo parametri specifici per Twilio
            'account_sid' => env('TWILIO_ACCOUNT_SID'),
            'auth_token' => env('TWILIO_AUTH_TOKEN'),
            'from' => env('TWILIO_FROM'),
        ],

        // Altri provider...
    ],
];
```

## Principi Fondamentali

### 1. Separazione delle Responsabilità

- **Configurazione Provider-Specifica** (sezione `drivers`):
  - SOLO credenziali e parametri di connessione essenziali (username, password, api_key, token, endpoint)
  - MAI includere retry, rate limiting, circuit breaker, timeout, debug flags

- **Configurazione Generica** (sezioni separate):
  - Sezione `retry` per tentativi di ripetizione
  - Sezione `rate_limit` per limitazione delle richieste
  - Sezione `timeout` per timeout globale
  - Sezione `debug` per flag di debug

### 2. Nessun Valore Predefinito per Parametri Critici

Per parametri critici come `sender`, non utilizzare valori predefiniti:

```php
// ❌ ERRATO
'sender' => env('NETFUN_SENDER', '<nome progetto>'),

// ✅ CORRETTO
'sender' => env('NETFUN_SENDER'),
```

### 3. Accesso alla Configurazione

Nel codice, recuperare sempre le configurazioni dal file `config/sms.php` e MAI da `config('services')`:

```php
// ✅ CORRETTO
$token = config('sms.drivers.netfun.username');
$endpoint = config('sms.drivers.netfun.api_url', 'https://v2.smsviainternet.it/api/rest/v1/sms-batch.json');

// ❌ ERRATO
$token = config('services.netfun.token');
```

## Errori Comuni da Evitare

1. **Duplicazione della Configurazione**: Non duplicare configurazioni generiche nelle sezioni dei provider
2. **Valori Predefiniti Inappropriati**: Non utilizzare valori predefiniti per parametri critici come `sender`
3. **Configurazione in File Errati**: Non inserire configurazioni SMS in `config/services.php`
4. **Endpoint Errati**: Utilizzare sempre gli endpoint corretti e verificati per ogni provider

## Provider SMS Supportati

| Provider | Endpoint Verificato | Metodo Autenticazione |
|----------|---------------------|------------------------|
| Netfun | `https://v2.smsviainternet.it/api/rest/v1/sms-batch.json` | username/password |
| Twilio | `https://api.twilio.com/2010-04-01/Accounts/{account_sid}/Messages.json` | account_sid/auth_token |
| Vonage | `https://rest.nexmo.com/sms/json` | api_key/api_secret |
| SMSHosting | `https://api.smshosting.it/rest/api/sms/send` | token |
| Telcob | `https://api.telcob.com/sms/v1/send` | api_key |

## Documentazione Correlata

- [SMS Provider Architecture](./SMS_PROVIDER_ARCHITECTURE.md)
- [SMS Implementation](./SMS_IMPLEMENTATION.md)
- [SMS Best Practices](./SMS_BEST_PRACTICES.md)
- [Netfun Authentication Methods](./NETFUN_AUTHENTICATION_METHODS.md)
