# Notifiche

## Configurazione Base

### Mail
```php
// config/mail.php
return [
    'default' => env('MAIL_MAILER', 'smtp'),
    'mailers' => [
        'smtp' => [
            'transport' => 'smtp',
            'host' => env('MAIL_HOST', 'smtp.mailgun.org'),
            'port' => env('MAIL_PORT', 587),
            'encryption' => env('MAIL_ENCRYPTION', 'tls'),
            'username' => env('MAIL_USERNAME'),
            'password' => env('MAIL_PASSWORD'),
            'timeout' => null,
            'local_domain' => env('MAIL_EHLO_DOMAIN'),
        ],
    ],
    'from' => [
        'address' => env('MAIL_FROM_ADDRESS', 'hello@example.com'),
        'name' => env('MAIL_FROM_NAME', 'Example'),
    ],
];
```

### Notifiche
```php
// config/notifications.php
return [
    'channels' => [
        'mail' => [
            'driver' => 'smtp',
            'queue' => 'notifications',
        ],
        'database' => [
            'driver' => 'database',
            'table' => 'notifications',
        ],
        'broadcast' => [
            'driver' => 'pusher',
            'key' => env('PUSHER_APP_KEY'),
            'secret' => env('PUSHER_APP_SECRET'),
            'app_id' => env('PUSHER_APP_ID'),
            'options' => [
                'cluster' => env('PUSHER_APP_CLUSTER'),
                'encrypted' => true,
            ],
        ],
    ],
];
```

## Notifiche Base

### Notifica Mail
```php
namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;

class InvoicePaid extends Notification
{
    use Queueable;

    protected $invoice;

    public function __construct($invoice)
    {
        $this->invoice = $invoice;
    }

    public function via($notifiable)
    {
        return ['mail', 'database'];
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject('Fattura Pagata')
            ->greeting('Ciao!')
            ->line('La tua fattura è stata pagata.')
            ->line('Importo: ' . $this->invoice->amount)
            ->action('Vedi Fattura', url('/invoices/' . $this->invoice->id))
            ->line('Grazie per il tuo business!');
    }

    public function toArray($notifiable)
    {
        return [
            'invoice_id' => $this->invoice->id,
            'amount' => $this->invoice->amount,
        ];
    }
}
```

### Notifica Database
```php
namespace App\Notifications;

use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\DatabaseMessage;

class NewMessage extends Notification
{
    public function via($notifiable)
    {
        return ['database'];
    }

    public function toDatabase($notifiable)
    {
        return [
            'message' => 'Hai ricevuto un nuovo messaggio',
            'sender' => 'John Doe',
            'timestamp' => now(),
        ];
    }
}
```

## Best Practices

### 1. Struttura
- Separare le notifiche per tipo
- Utilizzare nomi descrittivi
- Implementare template riutilizzabili
- Gestire le traduzioni

### 2. Performance
- Utilizzare le code
- Implementare il rate limiting
- Ottimizzare i template
- Monitorare le notifiche

### 3. Sicurezza
- Validare i dati
- Sanitizzare l'output
- Proteggere i dati sensibili
- Implementare il logging

### 4. Manutenzione
- Monitorare le notifiche
- Gestire i fallimenti
- Implementare alerting
- Documentare le notifiche

## Esempi di Utilizzo

### Notifiche Multiple
```php
// Inviare a più canali
$user->notify(new InvoicePaid($invoice));

// Inviare a più utenti
Notification::send($users, new NewMessage($message));

// Inviare immediatamente
$user->notifyNow(new UrgentNotification($data));
```

### Notifiche Personalizzate
```php
namespace App\Notifications;

class CustomNotification extends Notification
{
    public function via($notifiable)
    {
        return $notifiable->preferredChannels();
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->view('emails.custom', ['data' => $this->data])
            ->subject('Notifica Personalizzata');
    }
}
```

## Strumenti Utili

### Comandi Artisan
```bash
# Creare una nuova notifica
php artisan make:notification InvoicePaid

# Pubblicare le migrazioni
php artisan vendor:publish --tag=laravel-notifications

# Pulire le notifiche
php artisan notifications:table
```

### Monitoraggio
```php
use Illuminate\Support\Facades\Notification;

Notification::beforeSending(function ($notifiable, $notification, $channel) {
    // Prima dell'invio
});

Notification::afterSending(function ($notifiable, $notification, $channel) {
    // Dopo l'invio
});
```

## Gestione degli Errori

### Notifiche Fallite
```php
namespace App\Notifications;

use Illuminate\Support\Facades\Log;

class InvoicePaid extends Notification
{
    public function failed($notifiable, $exception)
    {
        Log::error('Notifica fallita', [
            'notification' => get_class($this),
            'notifiable' => get_class($notifiable),
            'exception' => $exception->getMessage(),
        ]);
    }
}
```

### Retry Logic
```php
namespace App\Notifications;

class InvoicePaid extends Notification
{
    public $tries = 3;
    public $timeout = 30;
    public $backoff = [60, 180, 360];

    public function via($notifiable)
    {
        return ['mail'];
    }
}
``` 