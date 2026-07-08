# Architettura delle Configurazioni nei Moduli Laravel

## Struttura Base di Configurazione

La struttura di configurazione in Laravel segue un pattern consistente, visibile chiaramente nel file `config/mail.php`:

```php
return [
    // 1. Driver predefinito
    'default' => env('MAIL_MAILER', 'smtp'),
    
    // 2. Configurazioni specifiche dei driver
    'mailers' => [
        'smtp' => [
            'transport' => 'smtp',
            'host' => env('MAIL_HOST'),
            'port' => env('MAIL_PORT'),
            // Altri parametri specifici di SMTP
        ],
        'ses' => [
            'transport' => 'ses',
            // Parametri specifici di SES
        ],
    ],
    
    // 3. Configurazioni globali applicabili a tutti i driver
    'from' => [
        'address' => env('MAIL_FROM_ADDRESS'),
        'name' => env('MAIL_FROM_NAME'),
    ],
    
    // Altre configurazioni globali...
];
```

## Pattern di Configurazione per SMS

Lo stesso pattern deve essere applicato nei moduli SMS:

```php
return [
    // 1. Driver predefinito
    'default' => env('SMS_DRIVER', 'default_driver'),
    
    // 2. Configurazioni specifiche dei driver (SOLO parametri di connessione e credenziali)
    'drivers' => [
        'netfun' => [
            'api_key' => env('NETFUN_API_KEY'),      // Specifico di Netfun
            'token' => env('NETFUN_TOKEN'),         // Specifico di Netfun (alternativo a api_key)
            'endpoint' => env('NETFUN_ENDPOINT', 'https://...'),  // Specifico di Netfun
        ],
        'twilio' => [
            'account_sid' => env('TWILIO_ACCOUNT_SID'), // Specifico di Twilio
            'auth_token' => env('TWILIO_AUTH_TOKEN'),  // Specifico di Twilio
        ],
    ],
    
    // 3. Configurazioni globali applicabili a tutti i driver
    'sender' => env('SMS_SENDER'),  // Globale per tutti i driver
    
    // Altre configurazioni globali
    'debug' => env('SMS_DEBUG', false),
    'retry' => [
        'attempts' => env('SMS_RETRY_ATTEMPTS', 3),
        'delay' => env('SMS_RETRY_DELAY', 60),
    ],
];
```

## Distinzione Chiave: Specifico vs Globale

### Configurazioni Specifiche del Driver
Sono parametri necessari per stabilire la connessione e autenticazione con un provider specifico:

- **Credenziali**: token, api_key, account_sid, auth_token, username, password
- **Connessione**: endpoint, host, port
- **Identificazione**: client_id, app_id

### Configurazioni Globali
Sono comportamenti o impostazioni che si applicano indipendentemente dal driver utilizzato:

- **Mittente**: sender, from, from_name
- **Comportamento**: debug, retry, rate_limit, timeout
- **Logging**: logging, log_channel, log_level

## Token vs API Key: Differenze Importanti

I termini non sono intercambiabili:

- **Token**: Generalmente un valore unico che identifica completamente un'autorizzazione (es. JWT, OAuth token)
- **API Key**: Chiave specifica per API, spesso usata in combinazione con altri parametri di autenticazione
- **Auth Token**: Valore di autorizzazione temporaneo o permanente

## Implementazione Corretta 

Per moduli riutilizzabili come Notify:

1. **Non modificare mai** configurazioni esistenti nei moduli di libreria
2. **Estendere** configurazioni in file separati quando necessario
3. **Utilizzare** i parametri global/common quando applicabili a tutti i driver
4. **Aderire** ai pattern di configurazione esistenti nel progetto
