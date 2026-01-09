# Implementazione Canale WhatsApp

## 1. Struttura Base

Il canale WhatsApp implementa le funzionalità per l'invio di messaggi tramite l'API di WhatsApp. La struttura include:

- Provider specifici (Twilio, Vonage, Meta)
- Azioni per l'invio dei messaggi
- Configurazione del canale
- Gestione della logica di invio

## 2. Provider WhatsApp Supportati

### 2.1 Twilio WhatsApp
- Provider: `twilio`
- Configurazione richiesta: `TWILIO_ACCOUNT_SID`, `TWILIO_AUTH_TOKEN`, `TWILIO_WHATSAPP_NUMBER`
- API: Twilio WhatsApp API

### 2.2 Vonage WhatsApp
- Provider: `vonage`
- Configurazione richiesta: `VONAGE_API_KEY`, `VONAGE_API_SECRET`, `VONAGE_WHATSAPP_NUMBER`
- API: Vonage WhatsApp API

### 2.3 Meta WhatsApp Cloud API
- Provider: `meta`
- Configurazione richiesta: `META_ACCESS_TOKEN`, `META_PHONE_NUMBER_ID`
- API: Meta WhatsApp Cloud API

## 3. Azioni di Invio

### 3.1 SendTwilioWhatsAppAction
Azione per inviare messaggi tramite Twilio WhatsApp.

### 3.2 SendVonageWhatsAppAction
Azione per inviare messaggi tramite Vonage WhatsApp.

### 3.3 SendMetaWhatsAppAction
Azione per inviare messaggi tramite Meta WhatsApp Cloud API.

## 4. Configurazione

### 4.1 File di Configurazione
- `config/whatsapp.php`: Configurazione generale del canale WhatsApp
- `.env`: Variabili d'ambiente per i provider WhatsApp

### 4.2 Provider Supportati
La configurazione permette di specificare quale provider utilizzare e le relative credenziali.

## 5. Modalità di Utilizzo

### 5.1 Facade Notify
```php
Notify::via('whatsapp')
    ->to($phone)
    ->message($message)
    ->send();
```

### 5.2 Azione Specifica
```php
app(SendTwilioWhatsAppAction::class)->execute([
    'to' => $phone,
    'message' => $message,
]);
```

## 6. Logica di Selezione Provider

La logica di selezione del provider WhatsApp è implementata in `WhatsAppProviderSelectionLogicAction` che permette di:

- Determinare quale provider utilizzare in base alla configurazione
- Gestire fallback tra diversi provider
- Applicare logiche specifiche per la selezione del provider

## 7. Collegamenti Utili

- [Twilio WhatsApp API](https://www.twilio.com/whatsapp)
- [Vonage WhatsApp API](https://developer.vonage.com/messaging/whatsapp/overview)
- [Meta WhatsApp Business API](https://developers.facebook.com/docs/whatsapp/cloud-api)
- [Laravel Notifications](https://laravel.com/docs/notifications)
- [Laravel Queues](https://laravel.com/docs/queues)
- [Laravel Testing](https://laravel.com/docs/testing)
- [Laravel Logging](https://laravel.com/docs/logging)
- [Laravel Cache](https://laravel.com/docs/cache)
