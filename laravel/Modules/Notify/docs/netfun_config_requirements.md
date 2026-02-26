# Requisiti di Configurazione per Netfun SMS

Questa guida descrive la configurazione necessaria per utilizzare il provider Netfun come driver SMS nel modulo Notify.

## 1. Parametri Obbligatori

Aggiungi la seguente sezione nel file `config/sms.php`:

```php
'netfun' => [
    //# Requisiti di Configurazione Netfun SMS

## Introduzione

Questo documento descrive i requisiti di configurazione per l'integrazione con il provider SMS Netfun nel modulo Notify, seguendo la [struttura standardizzata della configurazione SMS](./STANDARDIZED_SMS_CONFIG_STRUCTURE.md).

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
- [Risoluzione Conflitti Netfun](./netfunchannel_conflict_resolution.md)

---

*Ultimo aggiornamento: 2025-05-12*
