# Notifiche Telegram 

Questa documentazione descrive come implementare notifiche Telegram nel modulo Notify di SaluteOra.

## Indice

- [Introduzione](#introduzione)
- [Setup del Bot Telegram](#setup-del-bot-telegram)
- [Configurazione Laravel](#configurazione-laravel)
- [Implementazione delle Notifiche](#implementazione-delle-notifiche)
- [Funzionalità Avanzate](#funzionalità-avanzate)
- [Gestione Utenti](#gestione-utenti)
- [Testing](#testing)
- [Best Practices](#best-practices)

## Introduzione

Telegram offre un'ottima piattaforma per notifiche istantanee grazie alla sua API per bot. SaluteOra integra Telegram per inviare notifiche relative ad appuntamenti, promemoria e altre comunicazioni importanti.

## Setup del Bot Telegram

### Creazione del Bot

1. Avvia una chat con [@BotFather](https://t.me/botfather) su Telegram
2. Invia il comando `/newbot`
3. Segui le istruzioni per dare un nome e username al bot
4. Ricevi e salva il token API del bot

### Funzionalità del Bot

Il bot di SaluteOra deve avere:
- Privacy Mode disattivata (per leggere messaggi nei gruppi)
- Comandi personalizzati configurati
- Immagine del profilo con logo SaluteOra

### Comandi Consigliati

Configura i seguenti comandi per il tuo bot:
```
start - Inizia l'interazione con il bot
register - Collega il tuo account Telegram a SaluteOra
unregister - Scollega il tuo account Telegram
settings - Gestisci le tue preferenze di notifica
help - Ottieni assistenza
```

## Configurazione Laravel

### Installazione del Pacchetto

```bash
composer require laravel-notification-channels/telegram
```

### Configurazione

Aggiungi queste impostazioni al file `config/services.php`:

```php
'telegram-bot-api' => [
    'token' => env('TELEGRAM_BOT_TOKEN'),
],
```

Aggiungi al file `.env`:

```dotenv
TELEGRAM_BOT_TOKEN=123456789:ABCDefGhIJKlmnOPQRsTUVwxyZ
```

## Implementazione delle Notifiche

### Struttura Base della Notifica

```php
namespace Modules\Notify\Notifications;

use Illuminate\Notifications\Notification;
use NotificationChannels\Telegram\TelegramChannel;
use NotificationChannels\Telegram\TelegramMessage;

class AppointmentNotification extends Notification
{
    protected $appointment;
    
    public function __construct($appointment)
    {
        $this->appointment = $appointment;
    }
    
    public function via($notifiable)
    {
        return [TelegramChannel::class];
    }
    
    public function toTelegram($notifiable)
    {
        $url = url("/appointments/{$this->appointment->id}");
        
        return TelegramMessage::create()
            ->content("**Promemoria Appuntamento**\n\nHai un appuntamento il {$this->appointment->formatted_date} alle {$this->appointment->formatted_time} con il Dr. {$this->appointment->doctor->name}.")
            ->button('Visualizza Dettagli', $url)
            ->button('Riprogramma', url("/appointments/{$this->appointment->id}/reschedule"));
    }
}
```

### Configurazione Notifiable

Nel modello User:

```php
public function routeNotificationForTelegram()
{
    return $this->telegram_chat_id;
}
```

## Funzionalità Avanzate

### Invio di File e Media

```php
public function toTelegram($notifiable)
{
    return TelegramFile::create()
        ->content('Ecco il tuo referto medico')
        ->document('/path/to/report.pdf', 'Referto.pdf');
}
```

### Notifiche con Pulsanti Inline

```php
public function toTelegram($notifiable)
{
    $appointmentId = $this->appointment->id;
    
    return TelegramMessage::create()
        ->content("Confermi l'appuntamento del {$this->appointment->formatted_date}?")
        ->buttonWithCallback('Conferma', "confirm_appointment_{$appointmentId}")
        ->buttonWithCallback('Annulla', "cancel_appointment_{$appointmentId}");
}
```

### Invio di Posizione

```php
public function toTelegram($notifiable)
{
    return TelegramLocation::create()
        ->latitude($this->clinic->latitude)
        ->longitude($this->clinic->longitude)
        ->content("La clinica si trova qui");
}
```

## Gestione Utenti

### Collegamento Account Telegram

Per collegare un account Telegram a un utente SaluteOra:

1. Implementa un comando `/register` nel bot che generi un token univoco.
2. L'utente inserisce questo token nel proprio profilo nell'app SaluteOra.
3. Salva il `chat_id` Telegram dell'utente nel database.

```php
namespace Modules\Notify\Commands;

use Telegram\Bot\Commands\Command;
use Illuminate\Support\Str;
use Modules\Notify\Models\TelegramToken;

class RegisterCommand extends Command
{
    protected $name = 'register';
    protected $description = 'Collega il tuo account Telegram a SaluteOra';
    
    public function handle()
    {
        $chatId = $this->update->getMessage()->getChat()->getId();
        $token = Str::random(8);
        
        // Salva il token temporaneo
        TelegramToken::create([
            'token' => $token,
            'chat_id' => $chatId,
            'expires_at' => now()->addHours(1),
        ]);
        
        $this->replyWithMessage([
            'text' => "Il tuo codice di collegamento è: {$token}\n\nInseriscilo nel tuo profilo SaluteOra per completare il collegamento."
        ]);
    }
}
```

### Middleware per Verifica Token

```php
namespace Modules\Notify\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Modules\Notify\Models\TelegramToken;

class VerifyTelegramToken
{
    public function handle(Request $request, Closure $next)
    {
        $token = $request->input('token');
        
        $telegramToken = TelegramToken::where('token', $token)
            ->where('expires_at', '>', now())
            ->whereNull('user_id')
            ->first();
        
        if (!$telegramToken) {
            return response()->json(['error' => 'Token non valido o scaduto'], 400);
        }
        
        $request->merge(['telegram_token' => $telegramToken]);
        
        return $next($request);
    }
}
```

## Testing

### Simulazione Notifiche Telegram

Per testare le notifiche senza inviarle realmente:

```php
namespace Tests\Unit\Notifications;

use Tests\TestCase;
use NotificationChannels\Telegram\TelegramChannel;
use Modules\Notify\Notifications\AppointmentNotification;
use Modules\Patient\Models\User;
use Modules\Appointment\Models\Appointment;

class TelegramNotificationTest extends TestCase
{
    public function testAppointmentNotification()
    {
        $user = User::factory()->create(['telegram_chat_id' => '123456789']);
        $appointment = Appointment::factory()->create();
        
        $notification = new AppointmentNotification($appointment);
        
        $telegramMessage = $notification->toTelegram($user);
        
        $this->assertStringContainsString(
            $appointment->formatted_date,
            $telegramMessage->content
        );
        
        $this->assertCount(2, $telegramMessage->buttons);
    }
}
```

## Best Practices

1. **Sicurezza**:
   - Non esporre il token del bot nel codice
   - Verifica sempre l'identità dell'utente prima di collegare un chat_id
   - Monitora l'utilizzo dell'API Telegram per rilevare abusi

2. **Usabilità**:
   - Mantieni i messaggi concisi e formatati correttamente
   - Includi sempre call-to-action chiare
   - Utilizza pulsanti per azioni comuni anziché richiedere input testuale
   - Supporta sia utenti italiani che internazionali con messaggi multilingua

3. **Robustezza**:
   - Gestisci sempre gli errori di invio
   - Implementa un sistema di retry per messaggi falliti
   - Logga tutte le interazioni per il debug

4. **Rispetto della Privacy**:
   - Ottieni sempre il consenso esplicito prima di inviare notifiche
   - Fornisci un modo semplice per disattivare le notifiche
   - Non inviare dati sensibili non criptati
   - Rispetta i limiti di rate dell'API Telegram

5. **Gestione dello Stato**:
   - Memorizza lo stato delle conversazioni per supportare interazioni complesse
   - Implementa timeout per conversazioni incomplete
   - Fornisci comandi per annullare o ripristinare operazioni

6. **Accodamento**:
   - Utilizza le code Laravel per l'invio di notifiche di massa
   - Implementa priorità per messaggi urgenti

## Collegamenti alla Documentazione Correlata

- [MULTI_CHANNEL_NOTIFICATIONS.md](./MULTI_CHANNEL_NOTIFICATIONS.md)
- [NOTIFICATIONS_IMPLEMENTATION_GUIDE.md](./NOTIFICATIONS_IMPLEMENTATION_GUIDE.md)
- [SMS_PROVIDER_CONFIGURATION.md](./SMS_PROVIDER_CONFIGURATION.md)
