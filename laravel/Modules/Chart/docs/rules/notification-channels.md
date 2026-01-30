# Regole per l'Implementazione di Canali di Notifica in <nome progetto>

Questa documentazione fornisce linee guida standardizzate per l'implementazione di canali di notifica (email, SMS, Telegram) nel sistema <nome progetto>.

## Regole Generali

1. **Separazione delle Responsabilità**:
   - Ogni canale di notifica deve essere implementato in una classe separata
   - Riutilizzare logica comune attraverso traits o classi base

2. **Configurazione**:
   - Tutte le credenziali devono essere in `.env`
   - Tutti i valori di configurazione devono essere referenziati in `config/services.php`
   - Mai hardcodare token o chiavi API nel codice

3. **Type Hinting**:
   - Utilizzare sempre type hints nei parametri e nei valori di ritorno
   - Documentare adeguatamente i metodi con PHPDoc

4. **Logging**:
   - Registrare tentativo, successo e fallimento di ogni notifica
   - Utilizzare livelli di log appropriati (info, warning, error)

5. **Queueing**:
   - Le notifiche che utilizzano API esterne devono implementare `ShouldQueue`
   - Configurare tentativi e backoff in base alla criticità

## Email Notifications

### Utilizzo di Spatie Mail Templates

Quando si utilizza `SpatieEmail` in una notifica, seguire questo pattern:

```php
public function toMail($notifiable): SpatieEmail
{
    $email = new SpatieEmail($this->record, $this->slug);
    
    // FONDAMENTALE: impostare esplicitamente il destinatario
    if (method_exists($notifiable, 'routeNotificationFor')) {
        $email->to($notifiable->routeNotificationFor('mail'));
    }
    
    return $email;
}
```

### Errori Comuni

1. ❌ **Errore**: Ritornare SpatieEmail senza impostare il destinatario
   ```php
   // ERRATO
   return new SpatieEmail($this->record, $this->slug);
   ```

2. ✅ **Corretto**: Impostare esplicitamente il destinatario
   ```php
   $email = new SpatieEmail($this->record, $this->slug);
   $email->to($notifiable->routeNotificationFor('mail'));
   return $email;
   ```

## SMS Notifications

### Formattazione Numeri

1. I numeri di telefono devono essere sempre in formato E.164:
   - Formato: `+[codice paese][numero senza zero iniziale]`
   - Esempio per Italia: `+393331234567`

2. Implementare sempre validazione e formattazione:
   ```php
   public function routeNotificationForTwilio()
   {
       // Formatta il numero in E.164
       $phone = $this->phone_number;
       if (!str_starts_with($phone, '+')) {
           $phone = '+39' . ltrim($phone, '0');
       }
       return $phone;
   }
   ```

### Provider Supportati

I seguenti provider sono supportati e configurati in <nome progetto>:

1. **Internazionali**:
   - Twilio (preferito per affidabilità)
   - Vonage (ex Nexmo)
   - Plivo

2. **Italiani**:
   - Telcob (preferito per strutture sanitarie)
   - SMSHosting
   - NetFun Italia

## Telegram Notifications

### Configurazione Bot

1. Ogni ambiente deve avere un bot dedicato
2. I bot devono avere privacy mode disattivato
3. Configurare comandi personalizzati per migliorare l'UX

### Sicurezza

1. Verificare l'identità degli utenti prima di collegare un chat_id
2. Usare token temporanei per il collegamento account
3. Limitare l'accesso ai comandi sensibili

## Test dei Canali di Notifica

### Mock Channels

Creare classi mock per testare le notifiche senza accedere a servizi esterni:

```php
namespace Modules\Notify\Testing;

class MockSMSChannel extends SMSChannel
{
    public $messages = [];
    
    public function send($notifiable, Notification $notification)
    {
        $this->messages[] = [
            'to' => $notifiable->routeNotificationForSMS(),
            'content' => $notification->toSMS($notifiable)->content,
        ];
    }
}
```

### Test di Integrazione

Verificare sempre:
1. Corretta selezione dei canali
2. Formattazione corretta del messaggio
3. Gestione errori e fallback

## Conformità GDPR

1. Ottenere e registrare consenso esplicito per ogni canale
2. Fornire opzioni di opt-out in ogni comunicazione
3. Minimizzare i dati personali nei messaggi
4. Implementare politiche di conservazione per log e tracce

## Collegamenti alla Documentazione Dettagliata

- [MULTI_CHANNEL_NOTIFICATIONS.md](/laravel/Modules/Notify/docs/notifications/MULTI_CHANNEL_NOTIFICATIONS.md)
- [NOTIFICATIONS_IMPLEMENTATION_GUIDE.md](/laravel/Modules/Notify/docs/notifications/NOTIFICATIONS_IMPLEMENTATION_GUIDE.md)
- [SMS_PROVIDER_CONFIGURATION.md](/laravel/Modules/Notify/docs/notifications/SMS_PROVIDER_CONFIGURATION.md)
- [SMS_IMPLEMENTATION_DETAILS.md](/laravel/Modules/Notify/docs/notifications/SMS_IMPLEMENTATION_DETAILS.md)
- [TELEGRAM_NOTIFICATIONS_GUIDE.md](/laravel/Modules/Notify/docs/notifications/TELEGRAM_NOTIFICATIONS_GUIDE.md)
