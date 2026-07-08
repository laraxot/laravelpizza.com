# Configurazione Corretta dei Provider SMS 

## Regola Fondamentale

, tutte le configurazioni relative ai provider SMS **DEVONO** essere gestite esclusivamente attraverso il file `config/sms.php` e non tramite il file `config/services.php`.

## Struttura Corretta

```php
// Struttura CORRETTA in config/sms.php
return [
    // Configurazioni di base (applicate a tutti i provider)
    'from' => env('SMS_FROM', '<nome progetto>'),
    'from' => env('SMS_FROM', 'SaluteOra'),
    'retry' => [
        'attempts' => env('SMS_RETRY_ATTEMPTS', 3),
        'delay' => env('SMS_RETRY_DELAY', 60),
    ],
    'rate_limit' => [
        'enabled' => env('SMS_RATE_LIMIT_ENABLED', true),
        'max_attempts' => env('SMS_RATE_LIMIT_MAX_ATTEMPTS', 60),
        'decay_minutes' => env('SMS_RATE_LIMIT_DECAY_MINUTES', 1),
    ],
    
    // Configurazione specifiche dei provider
    'drivers' => [
        'netfun' => [
            'api_key' => env('NETFUN_API_KEY'),
            'sender' => env('NETFUN_SENDER', '<nome progetto>'),
            'sender' => env('NETFUN_SENDER', 'SaluteOra'),
            'api_url' => env('NETFUN_API_URL', 'https://v2.smsviainternet.it/api/rest/v1/sms-batch.json'),
        ],
        'twilio' => [
            'account_sid' => env('TWILIO_ACCOUNT_SID'),
            'auth_token' => env('TWILIO_AUTH_TOKEN'),
        ],
        // Altri provider...
    ],
];
```

## Implementazione Corretta nelle Action

Ecco come recuperare correttamente le configurazioni nelle classi Action:

```php
// ✅ CORRETTO
public function __construct()
{
    // Recupera configurazione specifica per il provider
    $config = config('sms.drivers.netfun');
    if (!is_array($config)) {
        throw new Exception('Configurazione Netfun non trovata in sms.php');
    }

    $this->token = $config['api_key'] ?? null;
    if (!is_string($this->token)) {
        throw new Exception('API Key Netfun non configurata in sms.php');
    }
    
    // Parametri generici a livello di root
    $this->defaultSender = config('sms.from');
    $this->timeout = config('sms.timeout', 30);
}
```

## Errori Comuni da Evitare

1. **MAI utilizzare `config('services.{provider}')` per accedere alle configurazioni SMS**:
   - ❌ ERRATO: `$token = config('services.netfun.token');`
   - ✅ CORRETTO: `$token = config('sms.drivers.netfun.api_key');`

2. **MAI duplicare configurazioni generiche nei singoli provider**:
   - ❌ ERRATO: Impostare timeout/retry in ogni provider
   - ✅ CORRETTO: Definire timeout/retry a livello di root in config/sms.php

3. **MAI assumere valori predefiniti hardcoded** che non siano documentati:
   - ❌ ERRATO: Usare URL o valori senza documentarli
   - ✅ CORRETTO: Utilizzare sempre env() con valori predefiniti documentati

## Motivazione

1. **Separazione delle Responsabilità**:
   - `services.php` è riservato ai servizi di terze parti generali
   - `sms.php` è dedicato specificatamente alle configurazioni SMS

2. **Manutenibilità**:
   - Centralizzare le configurazioni in un unico file facilita la manutenzione
   - Evita confusione su dove cercare le configurazioni

3. **Coerenza e Standardizzazione**:
   - Tutti i provider SMS seguono lo stesso pattern di configurazione
   - Facilita l'aggiunta di nuovi provider mantenendo lo stesso standard

## Riferimenti nei File di Ambiente

Quando configuri il file `.env`, utilizza questi nomi di variabili:

```

# Configurazione generale SMS
SMS_FROM=<nome progetto>
SMS_FROM=SaluteOra
SMS_RETRY_ATTEMPTS=3
SMS_RETRY_DELAY=60

# Netfun
NETFUN_API_KEY=your_api_key_here
NETFUN_SENDER=<nome progetto>
NETFUN_SENDER=SaluteOra
NETFUN_API_URL=https://v2.smsviainternet.it/api/rest/v1/sms-batch.json

# Twilio
TWILIO_ACCOUNT_SID=your_account_sid_here
TWILIO_AUTH_TOKEN=your_auth_token_here
```
