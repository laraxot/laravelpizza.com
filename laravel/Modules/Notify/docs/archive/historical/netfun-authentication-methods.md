# Autenticazione Netfun SMS

## Introduzione

Netfun SMS utilizza esclusivamente l'autenticazione tramite token/API key. Questa documentazione chiarisce il metodo di autenticazione corretto da utilizzare nel file `config/sms.php` del modulo Notify.

## Autenticazione con Token/API Key

Netfun richiede l'utilizzo di un token di autenticazione (API key) per accedere alle sue API:

```php
'netfun' => [
    'api_key' => env('NETFUN_API_KEY'),  // Token di autenticazione Netfun
    'sender' => env('NETFUN_SENDER'),     // Mittente SMS senza valore predefinito
    'api_url' => env('NETFUN_API_URL', 'https://v2.smsviainternet.it/api/rest/v1/sms-batch.json'),
    // Parametri avanzati...
],
```

### Variabili d'ambiente richieste:
```
NETFUN_API_KEY=your_api_key
NETFUN_SENDER=YourSender
```

## Informazione Importante

**NOTA**: Alcune documentazioni precedenti potrebbero fare riferimento a un metodo di autenticazione con username/password, ma questo è errato. Netfun utilizza esclusivamente l'autenticazione tramite token/API key per le sue API REST moderne.

## Quale metodo utilizzare?

1. **Rispettare l'implementazione esistente**: Quando si utilizza il modulo Notify in un progetto esistente, utilizzare il metodo di autenticazione configurato nel file `config/sms.php` (attualmente username/password).

2. **Per nuove implementazioni**: Consultare la documentazione ufficiale Netfun per determinare il metodo di autenticazione più recente e sicuro.

## Adattamento del codice

Se il canale Netfun è implementato per utilizzare `api_key` ma la configurazione utilizza `username`/`password`, sarà necessario adattare il codice del canale o la configurazione per garantire la compatibilità.

### Esempio di adattamento nel canale:

```php
public function send($notifiable, Notification $notification)
{
    // Ottieni la configurazione
    $config = config('sms.drivers.netfun');
    
    // Determina il metodo di autenticazione
    $authParams = [];
    if (isset($config['api_key'])) {
        $authParams['apiKey'] = $config['api_key'];
    } else if (isset($config['username']) && isset($config['password'])) {
        $authParams['username'] = $config['username'];
        $authParams['password'] = $config['password'];
    } else {
        throw new \Exception('Configurazione Netfun incompleta: mancano credenziali di autenticazione');
    }
    
    // Determina l'endpoint
    $endpoint = $config['endpoint'] ?? $config['api_url'] ?? 'https://v2.smsviainternet.it/api/rest/v1/sms-batch.json';
    
    // Resto del codice...
}
```

## Collegamenti

- [Documentazione Netfun SMS Channel](./SMS_NETFUN_CHANNEL.md)
- [Requisiti di Configurazione Netfun](./NETFUN_CONFIG_REQUIREMENTS.md)

---

*Ultimo aggiornamento: 2025-05-12*
