# Implementazione di Notifiche Multi-Canale 

Questa documentazione descrive come implementare correttamente notifiche multi-canale (email, SMS, Telegram) nel modulo Notify di <nome progetto>.
Questa documentazione descrive come implementare correttamente notifiche multi-canale (email, SMS, Telegram) nel modulo Notify di <nome progetto>.

## Indice

- [Introduzione](#introduzione)
- [Architettura delle Notifiche](#architettura-delle-notifiche)
- [Implementazione Email](#implementazione-email)
- [Implementazione SMS](#implementazione-sms)
- [Implementazione Telegram](#implementazione-telegram)
- [Notifiche Multi-Canale](#notifiche-multi-canale)
- [Errori Comuni e Soluzioni](#errori-comuni-e-soluzioni)
- [Best Practices](#best-practices)

## Introduzione

<nome progetto> utilizza il sistema di notifiche di Laravel per inviare comunicazioni attraverso diversi canali. Ogni canale richiede un'implementazione specifica per garantire la corretta consegna dei messaggi.
<nome progetto> utilizza il sistema di notifiche di Laravel per inviare comunicazioni attraverso diversi canali. Ogni canale richiede un'implementazione specifica per garantire la corretta consegna dei messaggi.

## Architettura delle Notifiche

### Struttura Base

Tutte le classi di notifica devono:

1. Estendere `Illuminate\Notifications\Notification`
2. Implementare almeno un metodo `toXXX()` per ogni canale
3. Definire correttamente il metodo `via()`

```php
namespace Modules\Notify\Notifications;

use Illuminate\Notifications\Notification;

class RecordNotification extends Notification
{
    // Proprietà e costruttore

    public function via(object $notifiable): array
    {
        // Ritorna i canali di notifica
        return ['mail', 'sms', 'telegram'];
    }

    // Metodi per i vari canali
    public function toMail(object $notifiable) { /* ... */ }
    public function toSms(object $notifiable) { /* ... */ }
    public function toTelegram(object $notifiable) { /* ... */ }
}
```

## Implementazione Email

### Utilizzo di Spatie TemplateMailable

Quando si utilizza `SpatieEmail` con le notifiche, è **fondamentale** impostare esplicitamente il destinatario:

```php
public function toMail($notifiable): SpatieEmail
{
    $email = new SpatieEmail($this->record, $this->slug);
    
    // IMPORTANTE: garantisci che ci sia sempre un destinatario
    if (method_exists($notifiable, 'routeNotificationFor')) {
        $email->to($notifiable->routeNotificationFor('mail'));
    }
    
    return $email;
}
```

### Differenza tra MailMessage e TemplateMailable

**Laravel MailMessage**:
- Imposta automaticamente i destinatari basandosi sul `$notifiable`
- Utilizza una fluent API per costruire l'email

**Spatie TemplateMailable**:
- **Non imposta automaticamente i destinatari** dal `$notifiable`
- Utilizza template dal database per il contenuto
- Richiede impostazione esplicita del destinatario

## Implementazione SMS

### Configurazione Provider SMS

<nome progetto> supporta diversi provider SMS. La configurazione di base prevede:
<nome progetto> supporta diversi provider SMS. La configurazione di base prevede:

1. Installazione del provider scelto:
   ```bash
   composer require laravel-notification-channels/twilio
   ```

2. Configurazione in `config/services.php`:
   ```php
   'twilio' => [
       'account_sid' => env('TWILIO_ACCOUNT_SID'),
       'auth_token' => env('TWILIO_AUTH_TOKEN'),
       'from' => env('TWILIO_FROM_NUMBER'),
   ],
   ```

### Implementazione Notifica SMS

```php
use NotificationChannels\Twilio\TwilioChannel;
use NotificationChannels\Twilio\TwilioSmsMessage;

// Nel metodo via()
public function via($notifiable)
{
    return ['mail', TwilioChannel::class];
}

// Metodo per SMS
public function toTwilio($notifiable)
{
    return (new TwilioSmsMessage())
        ->content("Il tuo appuntamento è confermato per il {$this->appointment->date}");
}
```

### Configurazione Notifiable

Nelle classi Notifiable (es. User):

```php
public function routeNotificationForTwilio()
{
    return $this->phone_number; // Deve essere in formato E.164 (+39XXXXXXXXXX)
}
```

## Implementazione Telegram

### Configurazione

1. Installazione:
   ```bash
   composer require laravel-notification-channels/telegram
   ```

2. Configurazione:
   ```php
   // config/services.php
   'telegram-bot-api' => [
       'token' => env('TELEGRAM_BOT_TOKEN'),
   ],
   ```

### Implementazione

```php
use NotificationChannels\Telegram\TelegramChannel;
use NotificationChannels\Telegram\TelegramMessage;

// Nel metodo via()
public function via($notifiable)
{
    return ['mail', TelegramChannel::class];
}

// Metodo per Telegram
public function toTelegram($notifiable)
{
    return TelegramMessage::create()
        ->content("**Notifica Importante**\nIl tuo appuntamento è confermato.")
        ->button('Visualizza Dettagli', url('/appointments'));
}
```

## Notifiche Multi-Canale

### Implementazione Completa

Una notifica multi-canale completa include:

```php
namespace Modules\Notify\Notifications;

use Illuminate\Notifications\Notification;
use NotificationChannels\Twilio\TwilioChannel;
use NotificationChannels\Twilio\TwilioSmsMessage;
use NotificationChannels\Telegram\TelegramChannel;
use NotificationChannels\Telegram\TelegramMessage;
use Modules\Notify\Emails\SpatieEmail;

class AppointmentNotification extends Notification
{
    protected $record;
    protected $slug;
    
    public function __construct($record, $slug)
    {
        $this->record = $record;
        $this->slug = $slug;
    }
    
    public function via($notifiable)
    {
        // Determina dinamicamente i canali basandosi sulle preferenze dell'utente
        $channels = ['mail'];
        
        if ($notifiable->sms_notifications_enabled) {
            $channels[] = TwilioChannel::class;
        }
        
        if ($notifiable->telegram_notifications_enabled) {
            $channels[] = TelegramChannel::class;
        }
        
        return $channels;
    }
    
    public function toMail($notifiable)
    {
        $email = new SpatieEmail($this->record, $this->slug);
        
        // IMPORTANTE: imposta esplicitamente il destinatario
        if (method_exists($notifiable, 'routeNotificationFor')) {
            $email->to($notifiable->routeNotificationFor('mail'));
        }
        
        return $email;
    }
    
    public function toTwilio($notifiable)
    {
        return (new TwilioSmsMessage())
            ->content("Notifica: {$this->record->title}");
    }
    
    public function toTelegram($notifiable)
    {
        return TelegramMessage::create()
            ->content("Il tuo appuntamento è confermato per il {$this->appointment->date}");
    }
}
```

## Implementazione Netfun SMS

Netfun è un provider di SMS italiano che offre API per l'invio di messaggi SMS. Seguendo l'architettura di <nome progetto>, implementeremo l'integrazione con Netfun utilizzando Spatie Queueable Actions.
Netfun è un provider di SMS italiano che offre API per l'invio di messaggi SMS. Seguendo l'architettura di <nome progetto>, implementeremo l'integrazione con Netfun utilizzando Spatie Queueable Actions.

### 1. Configurazione

Per prima cosa, aggiungiamo la configurazione nel file `config/sms.php`:

```php
// config/sms.php
return [
    // Altre configurazioni...
    
    'netfun' => [
        'username' => env('NETFUN_USERNAME'),
        'password' => env('NETFUN_PASSWORD'),
        'sender' => env('NETFUN_SENDER', '<nome progetto>'),
        'sender' => env('NETFUN_SENDER', '<nome progetto>'),
        'api_url' => env('NETFUN_API_URL', 'https://api.netfun.it/sms/v1/'),
    ],
];
```

Assicurati di aggiungere le corrispondenti variabili al tuo file `.env`:

```
NETFUN_USERNAME=your_username
NETFUN_PASSWORD=your_password
NETFUN_SENDER=<nome progetto>
NETFUN_SENDER=<nome progetto>
```

### 2. Creazione della Queueable Action

Implementiamo una Queueable Action per l'invio SMS tramite Netfun:

```php
<?php

namespace Modules\Notify\Actions\SMS;

use Spatie\QueueableAction\QueueableAction;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class SendNetfunSMSAction
{
    use QueueableAction;
    
    protected string $username;
    protected string $password;
    protected string $sender;
    protected string $apiUrl;
    
    public function __construct()
    {
        $this->username = config('sms.netfun.username');
        $this->password = config('sms.netfun.password');
        $this->sender = config('sms.netfun.sender');
        $this->apiUrl = config('sms.netfun.api_url');
    }
    
    public function execute(string $to, string $message, array $options = [])
    {
        // Normalizza il numero di telefono (formato E.164)
        $to = $this->normalizePhoneNumber($to);
        
        // Genera un ID di riferimento univoco per il messaggio
        $reference = $options['reference'] ?? (string) Str::uuid();
        
        try {
            $response = Http::post($this->apiUrl, [
                'username' => $this->username,
                'password' => $this->password,
                'sender' => $options['sender'] ?? $this->sender,
                'recipient' => $to,
                'message' => $message,
                'reference' => $reference,
                // Altri parametri opzionali
                'date' => $options['scheduled_date'] ?? null, // Data pianificata di invio
            ]);
            
            if ($response->successful()) {
                $responseData = $response->json();
                
                Log::info('SMS Netfun inviato con successo', [
                    'to' => $to,
                    'reference' => $reference,
                    'message_id' => $responseData['message_id'] ?? null,
                ]);
                
                return [
                    'success' => true,
                    'message_id' => $responseData['message_id'] ?? null,
                    'reference' => $reference,
                ];
            } else {
                Log::warning('Errore invio SMS Netfun', [
                    'to' => $to,
                    'reference' => $reference,
                    'status' => $response->status(),
                    'response' => $response->json(),
                ]);
                
                return [
                    'success' => false,
                    'error' => $response->json()['message'] ?? 'Errore sconosciuto',
                    'reference' => $reference,
                ];
            }
        } catch (\Exception $e) {
            Log::error('Eccezione durante invio SMS Netfun', [
                'to' => $to,
                'reference' => $reference,
                'error' => $e->getMessage(),
            ]);
            
            throw $e;
        }
    }
    
    /**
     * Normalizza il numero di telefono nel formato E.164
     * 
     * @param string $phoneNumber
     * @return string
     */
    protected function normalizePhoneNumber(string $phoneNumber): string
    {
        // Rimuovi tutti i caratteri non numerici
        $digits = preg_replace('/[^0-9]/', '', $phoneNumber);
        
        // Se il numero non inizia con '+' e non ha un prefisso internazionale,
        // aggiungi il prefisso italiano per default
        if (!Str::startsWith($phoneNumber, '+')) {
            // Se il numero inizia con '00', sostituisci con '+'
            if (Str::startsWith($digits, '00')) {
                $digits = '+' . substr($digits, 2);
            } 
            // Se il numero inizia con '3' (cellulare italiano), aggiungi prefisso italiano
            elseif (Str::startsWith($digits, '3')) {
                $digits = '+39' . $digits;
            }
        }
        
        return $digits;
    }
}
```

### 3. Creazione di un Message DTO

Creiamo un Data Transfer Object (DTO) per rappresentare un messaggio SMS Netfun:

```php
<?php

namespace Modules\Notify\Datas;

class NetfunSMSMessage
{
    public string $content;
    public ?string $sender = null;
    public ?string $reference = null;
    public ?string $scheduledDate = null;
    
    /**
     * Imposta il contenuto del messaggio
     * 
     * @param string $content
     * @return $this
     */
    public function content(string $content): self
    {
        $this->content = $content;
        return $this;
    }
    
    /**
     * Imposta il mittente del messaggio
     * 
     * @param string $sender
     * @return $this
     */
    public function from(string $sender): self
    {
        $this->sender = $sender;
        return $this;
    }
    
    /**
     * Imposta un riferimento personalizzato
     * 
     * @param string $reference
     * @return $this
     */
    public function reference(string $reference): self
    {
        $this->reference = $reference;
        return $this;
    }
    
    /**
     * Pianifica l'invio del messaggio
     * 
     * @param string $date Formato: 'Y-m-d H:i:s'
     * @return $this
     */
    public function scheduleFor(string $date): self
    {
        $this->scheduledDate = $date;
        return $this;
    }
    
    /**
     * Converte l'oggetto in array di opzioni
     * 
     * @return array
     */
    public function toArray(): array
    {
        return [
            'sender' => $this->sender,
            'reference' => $this->reference,
            'scheduled_date' => $this->scheduledDate,
        ];
    }
}
```

### 4. Creazione del Channel Netfun

Implementiamo un Channel personalizzato per Netfun che utilizza la nostra Queueable Action:

```php
<?php

namespace Modules\Notify\Channels;

use Illuminate\Notifications\Notification;
use Modules\Notify\Actions\SMS\SendNetfunSMSAction;
use Modules\Notify\Datas\NetfunSMSMessage;

class NetfunChannel
{
    protected SendNetfunSMSAction $sendSMSAction;
    
    public function __construct(SendNetfunSMSAction $sendSMSAction)
    {
        $this->sendSMSAction = $sendSMSAction;
    }
    
    /**
     * Invia la notifica tramite Netfun SMS
     * 
     * @param mixed $notifiable
     * @param \Illuminate\Notifications\Notification $notification
     * @return array|null
     */
    public function send($notifiable, Notification $notification)
    {
        // Ottieni il numero di telefono dal Notifiable
        if (!$to = $notifiable->routeNotificationForNetfun($notification)) {
            return null;
        }
        
        // Ottieni il messaggio dalla notifica
        $message = $notification->toNetfun($notifiable);
        
        if (!$message instanceof NetfunSMSMessage) {
            throw new \Exception('Il metodo toNetfun() deve restituire un\'istanza di NetfunSMSMessage');
        }
        
        // Esegui l'invio tramite la Queueable Action
        // L'esecuzione avverrà in modo asincrono (in background)
        return $this->sendSMSAction
            ->onQueue('sms') // Esegui sulla coda 'sms'
            ->execute(
                $to,
                $message->content,
                $message->toArray()
            );
    }
}
```

### 5. Metodo Necessario nel Notifiable (es. User Model)

```php
<?php

namespace Modules\User\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;
    
    // ... altri metodi e proprietà
    
    /**
     * Restituisce il numero di telefono per invio notifiche Netfun
     * 
     * @param \Illuminate\Notifications\Notification $notification
     * @return string|null
     */
    public function routeNotificationForNetfun($notification)
    {
        return $this->phone_number; // Dovrebbe essere in formato E.164
    }
}
```

### 6. Utilizzo nella Notification

Ora possiamo utilizzare il canale Netfun nelle nostre notifiche:

```php
<?php

namespace Modules\Notify\Notifications;

use Illuminate\Notifications\Notification;
use Modules\Notify\Channels\NetfunChannel;
use Modules\Notify\Datas\NetfunSMSMessage;

class AppointmentReminder extends Notification
{
    protected $appointment;
    
    public function __construct($appointment)
    {
        $this->appointment = $appointment;
    }
    
    /**
     * Definisci i canali su cui inviare la notifica
     * 
     * @param mixed $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail', NetfunChannel::class];
    }
    
    /**
     * Formatta il messaggio per il canale Netfun
     * 
     * @param mixed $notifiable
     * @return \Modules\Notify\Datas\NetfunSMSMessage
     */
    public function toNetfun($notifiable)
    {
        $date = $this->appointment->date->format('d/m/Y H:i');
        
        return (new NetfunSMSMessage())
            ->content("Gentile {$notifiable->first_name}, le ricordiamo il suo appuntamento del {$date}. <nome progetto>.")
            ->content("Gentile {$notifiable->first_name}, le ricordiamo il suo appuntamento del {$date}. <nome progetto>.")
            ->reference('app_' . $this->appointment->id);
    }
    
    // Altri metodi per altri canali (mail, ecc.)
}
```

### 7. Test dell'Implementazione

Per testare l'invio di un SMS tramite Netfun con la nostra implementazione:

```php
<?php

namespace Modules\Notify\Tests\Feature;

use Tests\TestCase;
use Modules\User\Models\User;
use Modules\Notify\Datas\NetfunSMSMessage;
use Modules\Notify\Actions\SMS\SendNetfunSMSAction;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\Http;

class NetfunSMSTest extends TestCase
{
    use DatabaseTransactions;
    
    public function testSendSMS()
    {
        // Mock della risposta HTTP
        Http::fake([
            'api.netfun.it/*' => Http::response([
                'success' => true,
                'message_id' => '123456789',
            ], 200),
        ]);
        
        $user = User::factory()->create([
            'phone_number' => '+393401234567',
        ]);
        
        $action = app(SendNetfunSMSAction::class);
        
        $message = (new NetfunSMSMessage())
            ->content('Test SMS da <nome progetto>')
            ->content('Test SMS da <nome progetto>')
            ->reference('test_123');
        
        $result = $action->execute(
            $user->phone_number,
            $message->content,
            $message->toArray()
        );
        
        $this->assertTrue($result['success']);
        $this->assertEquals('123456789', $result['message_id']);
    }
}
```

### 8. Invio Personalizzato con Queue

Puoi anche utilizzare la Queueable Action direttamente nei tuoi controller o service:

```php
<?php

namespace Modules\Appointment\Controllers;

use Illuminate\Http\Request;
use Modules\Notify\Datas\NetfunSMSMessage;
use Modules\Notify\Actions\SMS\SendNetfunSMSAction;
use Modules\Appointment\Models\Appointment;

class AppointmentReminderController extends Controller
{
    public function sendReminder(Request $request, Appointment $appointment)
    {
        $sendSMSAction = app(SendNetfunSMSAction::class);
        
        $message = (new NetfunSMSMessage())
            ->content("Gentile {$appointment->patient->first_name}, le ricordiamo il suo appuntamento del {$appointment->date->format('d/m/Y H:i')}. <nome progetto>.")
            ->content("Gentile {$appointment->patient->first_name}, le ricordiamo il suo appuntamento del {$appointment->date->format('d/m/Y H:i')}. <nome progetto>.")
            ->reference('app_' . $appointment->id);
        
        // Esecuzione asincrona
        $sendSMSAction->onQueue('sms')
            ->execute(
                $appointment->patient->phone_number,
                $message->content,
                $message->toArray()
            );
        
        return response()->json([
            'message' => 'Promemoria inviato con successo',
        ]);
    }
}
```

Utilizzando questa architettura basata su Queueable Actions, otteniamo diversi vantaggi:

1. **Esecuzione asincrona** semplicemente chiamando `->onQueue('sms')`
2. **Migliore testabilità** delle singole componenti
3. **Riutilizzo** del codice in diversi contesti (notifiche, controller, command, ecc.)
4. **Chiarezza architetturale** con componenti a singola responsabilità
            ->content("**{$this->record->title}**\n{$this->record->description}");
    }
}
```

### Invio di Notifiche On-Demand

Per inviare notifiche a destinatari che non sono models Notifiable:

```php
Notification::route('mail', 'esempio@example.com')
    ->route('twilio', '+39XXXXXXXXXX')  // Numero in formato E.164
    ->route('telegram', '123456789')    // Chat ID Telegram
    ->notify(new AppointmentNotification($record, 'appointment-confirm'));
```

## Errori Comuni e Soluzioni

### 1. "An email must have a To, Cc, or Bcc header"

**Causa**: Quando si usa `SpatieEmail` nelle notifiche, non viene impostato automaticamente il destinatario.

**Soluzione**: Impostare esplicitamente il destinatario:
```php
$email = new SpatieEmail($this->record, $this->slug);
$email->to($notifiable->routeNotificationFor('mail'));
return $email;
```

### 2. Errori di formattazione numeri telefonici

**Causa**: I provider SMS richiedono numeri in formato E.164 (+39XXXXXXXXXX).

**Soluzione**: Formattare correttamente i numeri:
```php
public function routeNotificationForTwilio()
{
    // Aggiungi il prefisso +39 se mancante
    $phone = $this->phone;
    if (!str_starts_with($phone, '+')) {
        $phone = '+39' . ltrim($phone, '0');
    }
    return $phone;
}
```

### 3. Errori di autenticazione API

**Causa**: Credenziali mancanti o errate per i servizi esterni.

**Soluzione**: Verificare la presenza di tutte le variabili d'ambiente:
```bash

# .env
TWILIO_ACCOUNT_SID=AC123...
TWILIO_AUTH_TOKEN=abc123...
TWILIO_FROM_NUMBER=+39XXXXXXXXXX
TELEGRAM_BOT_TOKEN=12345:ABC...
```

## Best Practices

1. **Utilizza le Code**: Implementa `ShouldQueue` per non bloccare l'applicazione.

2. **Gestisci Preferenze Utente**: Permetti agli utenti di scegliere quali canali utilizzare.

3. **Fallback Automatico**: Implementa logica di fallback (se l'email fallisce, prova SMS).

4. **Logging**: Registra sempre successi e fallimenti delle notifiche.

5. **Test di Integrazione**: Crea test dedicati per ogni canale di notifica.

6. **Validazione Input**: Valida sempre email e numeri di telefono prima dell'invio.

7. **GDPR Compliance**: Includi link per disattivare le notifiche.

8. **Rate Limiting**: Implementa limiti per evitare spam accidentali.

## Collegamenti alla Documentazione Correlata

- [NOTIFICATIONS_IMPLEMENTATION_GUIDE.md](./NOTIFICATIONS_IMPLEMENTATION_GUIDE.md)
- [SMS_PROVIDER_CONFIGURATION.md](./SMS_PROVIDER_CONFIGURATION.md)
- [TELEGRAM_NOTIFICATIONS_GUIDE.md](./TELEGRAM_NOTIFICATIONS_GUIDE.md)
