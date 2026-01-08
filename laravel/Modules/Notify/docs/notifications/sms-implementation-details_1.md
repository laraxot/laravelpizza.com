# Implementazione SMS : Guida Dettagliata

Questa documentazione fornisce una guida dettagliata all'implementazione delle notifiche SMS , con confronto tra diversi provider e best practices specifiche per il contesto italiano.

## Indice

- [Confronto Provider SMS](#confronto-provider-sms)
- [Provider Consigliati per l'Italia](#provider-consigliati-per-litalia)
- [Implementazione con Twilio](#implementazione-con-twilio)
- [Implementazione con Provider Italiani](#implementazione-con-provider-italiani)
- [Gestione dei Numeri di Telefono](#gestione-dei-numeri-di-telefono)
- [Testing delle Notifiche SMS](#testing-delle-notifiche-sms)
- [Pattern Avanzati](#pattern-avanzati)
- [Conformità Normativa](#conformità-normativa)

## Confronto Provider SMS

| Provider | Copertura Italia | Costi | Affidabilità | Velocità | Supporto Unicode/Emoji | API | Documentazione |
|----------|------------------|-------|--------------|----------|------------------------|-----|---------------|
| Twilio | Eccellente | Medio-Alto | Alta | Alta | Sì | Eccellente | Ottima |
| Vonage (Nexmo) | Buona | Medio | Alta | Buona | Sì | Buona | Buona |
| Plivo | Buona | Medio | Buona | Buona | Sì | Buona | Buona |
| Telcob | Ottima | Basso | Alta | Alta | Parziale | Base | Base (IT) |
| SMSHosting | Ottima | Basso | Alta | Alta | Sì | Buona | Buona (IT) |
| NetFun Italia | Ottima | Basso | Buona | Buona | Parziale | Base | Base (IT) |
| Spring Edge | Limitata | Basso | Media | Media | No | Base | Limitata |

## Provider Consigliati per l'Italia

### Telcob

Telcob è un provider italiano specializzato nel settore sanitario, con tariffe competitive e ottima copertura nazionale.

**Vantaggi**:
- Contratti specifici per studi medici e cliniche
- Supporto in italiano
- Conformità GDPR garantita
- Ottima consegna su rete italiana

**Svantaggi**:
- API meno robusta rispetto a provider internazionali
- Limitata copertura internazionale

### SMSHosting

SMSHosting offre un buon compromesso tra qualità e prezzo, con un'API ben documentata.

**Vantaggi**:
- Prezzi competitivi
- Buona documentazione in italiano
- Supporta notifiche di consegna
- Integrazione facile con Laravel

**Svantaggi**:
- Supporto clienti non sempre tempestivo

### NetFun Italia

Provider italiano con tariffe molto competitive per volumi elevati.

**Vantaggi**:
- Prezzi molto competitivi per grandi volumi
- Ottimizzato per rete italiana
- Supporto telefonico

**Svantaggi**:
- API meno moderna
- Documentazione limitata

## Implementazione con Twilio

Sebbene più costoso, Twilio offre l'API più robusta e la migliore documentazione.

### Installazione

```bash
composer require laravel-notification-channels/twilio
```

### Configurazione

```php
// config/services.php
'twilio' => [
    'account_sid' => env('TWILIO_ACCOUNT_SID'),
    'auth_token' => env('TWILIO_AUTH_TOKEN'),
    'from' => env('TWILIO_FROM_NUMBER'),
],
```

```dotenv

# .env
TWILIO_ACCOUNT_SID=AC123...
TWILIO_AUTH_TOKEN=abc123...
TWILIO_FROM_NUMBER=+39XXXXXXXXXX
```

### Creazione Notification Class

```php
namespace Modules\Notify\Notifications;

use Illuminate\Notifications\Notification;
use NotificationChannels\Twilio\TwilioChannel;
use NotificationChannels\Twilio\TwilioSmsMessage;

class AppointmentReminder extends Notification
{
    protected $appointment;
    
    public function __construct($appointment)
    {
        $this->appointment = $appointment;
    }
    
    public function via($notifiable)
    {
        return [TwilioChannel::class];
    }
    
    public function toTwilio($notifiable)
    {
        $formattedDate = $this->appointment->formatted_date;
        $formattedTime = $this->appointment->formatted_time;
        $doctor = $this->appointment->doctor->name;
        
        return (new TwilioSmsMessage())
            ->content("Promemoria: hai un appuntamento il {$formattedDate} alle {$formattedTime} con il Dr. {$doctor}. Conferma rispondendo SI o annulla con NO.");
    }
}
```

### Aggiunta del metodo `routeNotificationForTwilio` al Model

```php
namespace Modules\Patient\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;
    
    // ...
    
    public function routeNotificationForTwilio()
    {
        // Garantisci che il numero sia in formato E.164 (es. +393331234567)
        $phoneNumber = $this->phone_number;
        
        // Rimuovi eventuali spazi o caratteri non numerici
        $phoneNumber = preg_replace('/[^0-9]/', '', $phoneNumber);
        
        // Se inizia con 0, sostituisci con +39
        if (strpos($phoneNumber, '0') === 0) {
            $phoneNumber = '+39' . substr($phoneNumber, 1);
        }
        
        // Se non ha prefisso, aggiungi +39
        if (strpos($phoneNumber, '+') !== 0) {
            $phoneNumber = '+39' . $phoneNumber;
        }
        
        return $phoneNumber;
    }
}
```

### Invio della notifica

```php
$user->notify(new AppointmentReminder($appointment));
```

## Implementazione con Provider Italiani

### SMSHosting

#### Installazione

SMSHosting non ha un canale di notifica Laravel ufficiale, quindi creiamo un canale personalizzato con Queueable Actions.

```bash
composer require smshosting/smshosting-api-php-client
composer require spatie/laravel-queueable-action
```

#### Creazione Queueable Action

```php
namespace Modules\Notify\Actions\SMS;

use Spatie\QueueableAction\QueueableAction;
use SMSHosting\Rest\Client;
use Illuminate\Support\Facades\Log;

class SendSMSHostingAction
{
    use QueueableAction;
    
    protected $client;
    
    public function __construct()
    {
        $this->client = new Client(
            config('sms.smshosting.username'),
            config('sms.smshosting.password')
        );
    }
    
    public function execute(string $to, string $content, array $options = [])
    {
        try {
            $response = $this->client->messages->send([
                'to' => $to,
                'text' => $content,
                'from' => config('sms.smshosting.sender'),
                'options' => $options,
            ]);
            
            Log::info('SMS inviato con successo', [
                'to' => $to,
                'provider' => 'SMSHosting',
                'message_id' => $response->getId() ?? null,
            ]);
            
            return $response;
        } catch (\Exception $e) {
            Log::error('Errore invio SMS', [
                'to' => $to,
                'provider' => 'SMSHosting',
                'error' => $e->getMessage(),
            ]);
            
            throw $e;
        }
    }
}
```

#### Creazione Channel usando Queueable Action

```php
namespace Modules\Notify\Channels;

use Illuminate\Notifications\Notification;
use Modules\Notify\Actions\SMS\SendSMSHostingAction;

class SMSHostingChannel
{
    protected $sendSMSAction;
    
    public function __construct(SendSMSHostingAction $sendSMSAction)
    {
        $this->sendSMSAction = $sendSMSAction;
    }
    
    public function send($notifiable, Notification $notification)
    {
        if (! $to = $notifiable->routeNotificationForSMSHosting()) {
            return;
        }
        
        $message = $notification->toSMSHosting($notifiable);
        
        // Esecuzione asincrona dell'azione
        return $this->sendSMSAction->onQueue('sms')
            ->execute($to, $message->content, $message->options);
    }
}
```

#### Configurazione

```php
// config/sms.php
return [
    'smshosting' => [
        'username' => env('SMSHOSTING_USERNAME'),
        'password' => env('SMSHOSTING_PASSWORD'),
        'sender' => env('SMSHOSTING_SENDER', '<nome progetto>'),
        'sender' => env('SMSHOSTING_SENDER', '<nome progetto>'),
    ],
];
```

#### Creazione Message Class

```php
namespace Modules\Notify\Messages;

class SMSHostingMessage
{
    public $content;
    public $options = [];
    
    public function __construct($content = '')
    {
        $this->content = $content;
    }
    
    public function content($content)
    {
        $this->content = $content;
        
        return $this;
    }
    
    public function unicode()
    {
        $this->options['unicode'] = true;
        
        return $this;
    }
    
    public function flash()
    {
        $this->options['flash'] = true;
        
        return $this;
    }
}
```

### Telcob

Telcob offre un servizio SMS con API REST. Implementiamo l'invio usando le Queueable Actions di Spatie.

#### Creazione Queueable Action

```php
namespace Modules\Notify\Actions\SMS;

use Spatie\QueueableAction\QueueableAction;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class SendTelcobSMSAction
{
    use QueueableAction;
    
    protected $apiKey;
    protected $sender;
    protected $baseUrl = 'https://api.telcob.com/sms/v1';
    
    public function __construct()
    {
        $this->apiKey = config('sms.telcob.api_key');
        $this->sender = config('sms.telcob.sender');
    }
    
    public function execute(string $to, string $message, array $options = [])
    {
        try {
            $response = Http::withHeaders([
                'Authorization' => "Bearer {$this->apiKey}",
                'Content-Type' => 'application/json',
            ])->post("{$this->baseUrl}/send", [
                'to' => $to,
                'text' => $message,
                'from' => $this->sender,
                'options' => $options,
            ]);
            
            if ($response->successful()) {
                Log::info('SMS Telcob inviato con successo', [
                    'to' => $to,
                    'message_id' => $response->json('id') ?? null,
                ]);
            } else {
                Log::warning('Risposta negativa da Telcob', [
                    'to' => $to,
                    'status' => $response->status(),
                    'body' => $response->json(),
                ]);
            }
            
            return $response;
        } catch (\Exception $e) {
            Log::error('Errore invio SMS Telcob', [
                'to' => $to,
                'error' => $e->getMessage(),
            ]);
            
            throw $e;
        }
    }
}
```

#### Creazione Channel per Telcob

```php
namespace Modules\Notify\Channels;

use Illuminate\Notifications\Notification;
use Modules\Notify\Actions\SMS\SendTelcobSMSAction;

class TelcobChannel
{
    protected $sendSMSAction;
    
    public function __construct(SendTelcobSMSAction $sendSMSAction)
    {
        $this->sendSMSAction = $sendSMSAction;
    }
    
    public function send($notifiable, Notification $notification)
    {
        if (! $to = $notifiable->routeNotificationForTelcob()) {
            return;
        }
        
        $message = $notification->toTelcob($notifiable);
        
        // Esecuzione asincrona dell'azione
        return $this->sendSMSAction->onQueue('sms')
            ->execute($to, $message->content, $message->options ?? []);
    }
}
```

## Gestione dei Numeri di Telefono

La gestione corretta dei numeri di telefono è cruciale per l'invio di SMS.

### Formato E.164

Il formato E.164 è lo standard internazionale per i numeri di telefono:
- Inizia con il simbolo `+`
- Seguito dal prefisso internazionale (39 per l'Italia)
- Seguito dal numero senza lo zero iniziale
- Senza spazi o simboli

**Esempi**:
- `+393331234567` (corretto)
- `00393331234567` (non standard)
- `3331234567` (incompleto)
- `0331234567` (formato italiano locale)

### Classe Helper per Formattazione

```php
namespace Modules\Notify\Helpers;

class PhoneNumberFormatter
{
    public static function formatToE164($phoneNumber, $defaultCountryCode = '39')
    {
        // Rimuovi tutti i caratteri non numerici
        $phoneNumber = preg_replace('/[^0-9+]/', '', $phoneNumber);
        
        // Se il numero inizia con + è già in formato internazionale
        if (strpos($phoneNumber, '+') === 0) {
            return $phoneNumber;
        }
        
        // Se inizia con 00, sostituisci con +
        if (strpos($phoneNumber, '00') === 0) {
            return '+' . substr($phoneNumber, 2);
        }
        
        // Se inizia con 0, assumi che sia un numero italiano e rimuovi lo 0
        if (strpos($phoneNumber, '0') === 0) {
            return '+' . $defaultCountryCode . substr($phoneNumber, 1);
        }
        
        // Altrimenti aggiungi solo il prefisso
        return '+' . $defaultCountryCode . $phoneNumber;
    }
    
    public static function isValidItalianMobile($phoneNumber)
    {
        $e164 = self::formatToE164($phoneNumber);
        
        // I numeri di cellulare italiani iniziano con +393
        return preg_match('/^\+393\d{8,9}$/', $e164) === 1;
    }
}
```

## Testing delle Notifiche SMS

### Mock Channel per Testing

```php
namespace Modules\Notify\Testing;

use Illuminate\Notifications\Notification;
use Modules\Notify\Channels\SMSHostingChannel;

class MockSMSChannel extends SMSHostingChannel
{
    public $messages = [];
    
    public function send($notifiable, Notification $notification)
    {
        $to = $notifiable->routeNotificationForSMSHosting();
        $message = $notification->toSMSHosting($notifiable);
        
        $this->messages[] = [
            'to' => $to,
            'content' => $message->content,
        ];
        
        return true;
    }
}
```

### Feature Test

```php
namespace Modules\Notify\Tests\Feature;

use Tests\TestCase;
use Modules\Patient\Models\User;
use Modules\Appointment\Models\Appointment;
use Modules\Notify\Notifications\AppointmentReminder;
use Modules\Notify\Testing\MockSMSChannel;
use Illuminate\Support\Facades\Notification;

class SMSNotificationTest extends TestCase
{
    public function testAppointmentReminderSMS()
    {
        // Arrange
        $user = User::factory()->create(['phone_number' => '+393331234567']);
        $appointment = Appointment::factory()->create(['user_id' => $user->id]);
        
        $mockChannel = new MockSMSChannel();
        $this->app->instance(SMSHostingChannel::class, $mockChannel);
        
        // Act
        $user->notify(new AppointmentReminder($appointment));
        
        // Assert
        $this->assertCount(1, $mockChannel->messages);
        $this->assertEquals('+393331234567', $mockChannel->messages[0]['to']);
        $this->assertStringContainsString($appointment->formatted_date, $mockChannel->messages[0]['content']);
    }
    
    public function testSMSNotSentWhenPhoneInvalid()
    {
        // Arrange
        Notification::fake();
        $user = User::factory()->create(['phone_number' => 'invalid-number']);
        $appointment = Appointment::factory()->create(['user_id' => $user->id]);
        
        // Act
        $user->notify(new AppointmentReminder($appointment));
        
        // Assert
        Notification::assertNothingSent();
    }
}
```

## Pattern Avanzati

### Notifiche Multi-canale con Fallback

```php
namespace Modules\Notify\Notifications;

use Illuminate\Notifications\Notification;
use NotificationChannels\Twilio\TwilioChannel;
use NotificationChannels\Twilio\TwilioSmsMessage;
use Modules\Notify\Emails\SpatieEmail;

class ImportantNotification extends Notification
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
        $channels = ['mail'];
        
        // Aggiungi SMS solo se l'utente ha un numero di telefono valido
        if ($notifiable->phone_number && $notifiable->sms_notifications_enabled) {
            $channels[] = TwilioChannel::class;
        }
        
        return $channels;
    }
    
    public function toMail($notifiable)
    {
        $email = new SpatieEmail($this->record, $this->slug);
        
        // IMPORTANTE: garantisci che ci sia sempre un destinatario
        if (method_exists($notifiable, 'routeNotificationFor')) {
            $email->to($notifiable->routeNotificationFor('mail'));
        }
        
        return $email;
    }
    
    public function toTwilio($notifiable)
    {
        return (new TwilioSmsMessage())
            ->content("Notifica importante: {$this->record->title}");
    }
}
```

### Gestione Tentativi Falliti con Queueable Actions

Utilizzando le Queueable Actions di Spatie, è possibile gestire i tentativi falliti in modo elegante:

```php
namespace Modules\Notify\Actions\SMS;

use Spatie\QueueableAction\QueueableAction;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Notification;
use Modules\Notify\Notifications\SMSFailureNotification;

class SendNotificationWithRetryAction
{
    use QueueableAction;
    
    // Configurazione della coda
    public $tries = 3;
    public $backoff = 60; // 1 minuto tra i tentativi
    public $queue = 'notifications';
    
    public function execute($notifiable, $notification, array $options = [])
    {
        try {
            // Invio della notifica
            $notifiable->notify($notification);
            
            // Registrazione del successo
            Log::info('Notifica inviata con successo', [
                'notifiable_type' => get_class($notifiable),
                'notifiable_id' => $notifiable->id,
                'notification_class' => get_class($notification),
            ]);
            
            return true;
        } catch (\Exception $e) {
            // Registrazione dell'errore
            Log::error('Errore invio notifica', [
                'error' => $e->getMessage(),
                'notifiable_id' => $notifiable->id,
                'notification_class' => get_class($notification),
                'attempt' => $options['attempt'] ?? 1,
            ]);
            
            // Incrementa il contatore di tentativi
            $attempt = ($options['attempt'] ?? 1) + 1;
            
            // Se non abbiamo superato il numero massimo di tentativi, ritenta
            if ($attempt <= $this->tries) {
                // Pianifica un nuovo tentativo dopo il backoff
                $this->onQueue($this->queue)
                     ->execute($notifiable, $notification, ['attempt' => $attempt]);
            } else {
                // Invia notifica di fallimento via email se abbiamo esaurito i tentativi
                $this->sendFailureNotification($notifiable, $notification);
            }
            
            // Propaga l'eccezione per gestione esterna
            throw $e;
        }
    }
    
    protected function sendFailureNotification($notifiable, $notification)
    {
        // Controlla se il notifiable ha un indirizzo email
        if (method_exists($notifiable, 'routeNotificationFor') && $notifiable->routeNotificationFor('mail')) {
            // Invia email di notifica del fallimento
            Notification::send(
                $notifiable,
                new SMSFailureNotification($notification)
            );
        }
    }
}
```

### Utilizzo dell'Action

```php
namespace Modules\Notify\Services;

use Modules\Notify\Actions\SMS\SendNotificationWithRetryAction;
use Modules\Notify\Notifications\AppointmentReminder;

class AppointmentService
{
    public function sendReminders($appointments)
    {   
        $sendNotificationAction = app(SendNotificationWithRetryAction::class);
        
        foreach ($appointments as $appointment) {
            // Crea la notifica
            $notification = new AppointmentReminder($appointment);
            
            // Invia la notifica con gestione tentativi via Queueable Action
            // L'esecuzione sarà asincrona sulla coda 'notifications'
            $sendNotificationAction->onQueue('notifications')
                                   ->execute($appointment->patient, $notification);
        }
    }
}
```
```

## Conformità Normativa

### GDPR e Privacy

Quando si inviano SMS, è necessario rispettare le normative GDPR:

1. **Consenso Esplicito**: Ottenere e documentare il consenso dell'utente
2. **Opt-Out**: Fornire istruzioni per disiscriversi dalle comunicazioni
3. **Minimizzazione Dati**: Inviare solo le informazioni necessarie
4. **Conservazione**: Definire politiche di conservazione dei log SMS
5. **Sicurezza**: Utilizzare canali sicuri per l'invio

### Template SMS GDPR-Compliant

```php
public function toTwilio($notifiable)
{
    return (new TwilioSmsMessage())
        ->content("<nome progetto>: Promemoria appuntamento {$this->appointment->formatted_date}. 
        Per annullare rispondere NO. Per info: <nome progetto>.it/privacy");
        ->content("<nome progetto>: Promemoria appuntamento {$this->appointment->formatted_date}. 
        Per annullare rispondere NO. Per info: <nome progetto>.it/privacy");
}
```

### Registro dei Consensi

Implementare un sistema di registro dei consensi:

```php
namespace Modules\Notify\Models;

use Illuminate\Database\Eloquent\Model;

class ConsentLog extends Model
{
    protected $fillable = [
        'user_id',
        'channel',
        'consented_at',
        'ip_address',
        'user_agent',
        'consent_text',
        'revoked_at',
    ];
    
    protected $casts = [
        'consented_at' => 'datetime',
        'revoked_at' => 'datetime',
    ];
    
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    
    public function scopeActive($query)
    {
        return $query->whereNotNull('consented_at')
            ->whereNull('revoked_at');
    }
    
    public function scopeForChannel($query, $channel)
    {
        return $query->where('channel', $channel);
    }
}
```

## Collegamenti alla Documentazione Correlata

- [MULTI_CHANNEL_NOTIFICATIONS.md](./MULTI_CHANNEL_NOTIFICATIONS.md)
- [SMS_PROVIDER_CONFIGURATION.md](./SMS_PROVIDER_CONFIGURATION.md)
- [NOTIFICATIONS_IMPLEMENTATION_GUIDE.md](./NOTIFICATIONS_IMPLEMENTATION_GUIDE.md)
- [TELEGRAM_NOTIFICATIONS_GUIDE.md](./TELEGRAM_NOTIFICATIONS_GUIDE.md)
