# Notifiche

## Panoramica
Questo documento descrive il sistema di notifiche utilizzato nel modulo Notify.

## Struttura delle Notifiche

### Notifica Base
```php
// app/Notifications/BaseNotification.php
namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class BaseNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public function via($notifiable)
    {
        return ['mail', 'database'];
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject($this->getSubject())
            ->greeting($this->getGreeting())
            ->line($this->getContent())
            ->action($this->getActionText(), $this->getActionUrl());
    }

    public function toArray($notifiable)
    {
        return [
            'type' => $this->getType(),
            'data' => $this->getData(),
        ];
    }
}
```

### Notifica Personalizzata
```php
// app/Notifications/AppointmentNotification.php
namespace App\Notifications;

class AppointmentNotification extends BaseNotification
{
    protected $appointment;

    public function __construct($appointment)
    {
        $this->appointment = $appointment;
    }

    public function getSubject()
    {
        return "Appuntamento {$this->appointment->date}";
    }

    public function getContent()
    {
        return "Hai un appuntamento il {$this->appointment->date} alle {$this->appointment->time}";
    }

    public function getActionText()
    {
        return 'Vedi Dettagli';
    }

    public function getActionUrl()
    {
        return route('appointments.show', $this->appointment);
    }
}
```

## Canali di Notifica

### Email
```php
// config/notifications.php
return [
    'channels' => [
        'mail' => [
            'driver' => 'smtp',
            'host' => env('MAIL_HOST'),
            'port' => env('MAIL_PORT'),
            'username' => env('MAIL_USERNAME'),
            'password' => env('MAIL_PASSWORD'),
            'encryption' => env('MAIL_ENCRYPTION'),
            'from' => [
                'address' => env('MAIL_FROM_ADDRESS'),
                'name' => env('MAIL_FROM_NAME'),
            ],
        ],
    ],
];
```

### Database
```php
// database/migrations/create_notifications_table.php
Schema::create('notifications', function (Blueprint $table) {
    $table->uuid('id')->primary();
    $table->string('type');
    $table->morphs('notifiable');
    $table->text('data');
    $table->timestamp('read_at')->nullable();
    $table->timestamps();
});
```

### SMS
```php
// app/Notifications/Channels/SmsChannel.php
namespace App\Notifications\Channels;

use Illuminate\Notifications\Notification;

class SmsChannel
{
    public function send($notifiable, Notification $notification)
    {
        $message = $notification->toSms($notifiable);
        
        // Implementazione invio SMS
    }
}
```

## Best Practices

### 1. Gestione Code
- Utilizzare code separate per tipo
- Implementare retry policy
- Monitorare fallimenti
- Logging dettagliato

### 2. Performance
- Batch processing
- Rate limiting
- Caching
- Ottimizzazione query

### 3. Sicurezza
- Validazione input
- Sanitizzazione output
- Rate limiting
- Logging accessi

## Note
- Tutti i collegamenti sono relativi
- La documentazione è mantenuta in italiano
- I collegamenti sono bidirezionali quando appropriato
- Ogni sezione ha il suo README.md specifico

## Contribuire
Per contribuire alla documentazione, seguire le [Linee Guida](../../../../docs/linee-guida-documentazione.md) e le [Regole dei Collegamenti](../../../../docs/regole_collegamenti_documentazione.md).

## Collegamenti Completi
Per una lista completa di tutti i collegamenti tra i README.md, consultare il file [README_links.md](../../../../docs/README_links.md). 
