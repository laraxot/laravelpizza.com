# Guida all'Implementazione delle Notifiche 

Questa documentazione descrive come implementare correttamente le notifiche utilizzando Laravel Notifications nel modulo Notify.

## Struttura Base di una Notifica

Per implementare correttamente una notifica, è necessario seguire questa struttura:

```php
namespace Modules\Notify\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Database\Eloquent\Model;

class RecordNotification extends Notification implements ShouldQueue
{
    use Queueable;
    
    protected Model $record;
    protected string $templateSlug;
    
    /**
     * Create a new notification instance.
     */
    public function __construct(Model $record, string $templateSlug)
    {
        $this->record = $record;
        $this->templateSlug = $templateSlug;
    }
    
    /**
     * Get the notification's delivery channels.
     */
    public function via(object $notifiable): array
    {
        return ['mail'];
    }
    
    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('Notifica da SaluteOra')
            ->greeting('Ciao ' . $this->record->name)
            ->line('Contenuto della notifica...')
            ->action('Visualizza', url('/'))
            ->line('Grazie per utilizzare la nostra applicazione!');
    }
}
```

## Utilizzo di SpatieEmail con Notifiche

Per utilizzare la classe SpatieEmail all'interno di una notifica, implementa il metodo `toMail()` come segue:

```php
/**
 * Get the mail representation of the notification.
 */
public function toMail(object $notifiable): \Illuminate\Mail\Mailable
{
    $email = new SpatieEmail($this->record, $this->templateSlug);
    
    // Aggiungi eventuali allegati
    if ($this->attachments) {
        $email->addAttachments($this->attachments);
    }
    
    return $email;
}
```

## Invio Corretto delle Notifiche

### 1. Invio di una Notifica a un Modello

```php
// Invio a un utente (che implementa Notifiable)
$user->notify(new RecordNotification($record, 'template-slug'));
```

### 2. Invio di una Notifica ad un Indirizzo Email (On-Demand)

```php
// Invio on-demand a un indirizzo email
Notification::route('mail', 'destinatario@example.com')
    ->notify(new RecordNotification($record, 'template-slug'));
```

### 3. Invio con Allegati

```php
$attachments = [
    [
        'path' => '/path/to/file.pdf',
        'as' => 'documento.pdf',
        'mime' => 'application/pdf',
    ],
];

// Crea la notifica con allegati
$notification = new RecordNotification($record, 'template-slug');
$notification->withAttachments($attachments);

// Invia la notifica
$user->notify($notification);
```

## Errori Comuni e Soluzioni

### Errore: "An email must have a 'To', 'Cc', or 'Bcc' header"

**Causa**: La notifica non ha specificato correttamente il destinatario dell'email.

**Soluzioni**:

1. Assicurarsi che il metodo `toMail()` restituisca un'istanza di `MailMessage` o una mailabile correttamente configurata.

2. Verificare che l'oggetto `$notifiable` contenga un indirizzo email valido o che sia stato specificato tramite `Notification::route('mail', 'email@example.com')`.

3. Se si restituisce una mailabile personalizzata (come `SpatieEmail`), assicurarsi che questa accetti l'oggetto `$notifiable` come destinatario o che il destinatario sia specificato in altro modo.

```php
// Esempio di correzione in toMail()
public function toMail(object $notifiable): \Illuminate\Mail\Mailable
{
    $email = new SpatieEmail($this->record, $this->templateSlug);
    
    // Imposta esplicitamente il destinatario
    // Questo non è necessario se si usa $notifiable->routeNotificationFor('mail')
    // ma è una buona pratica per la chiarezza
    $email->to($notifiable->email);
    
    return $email;
}
```

### Errore: "Notification must implement interface X"

**Causa**: La classe di notifica non implementa tutte le interfacce richieste.

**Soluzione**: Assicurarsi che la classe estenda `Illuminate\Notifications\Notification` e implementi eventuali altre interfacce richieste come `ShouldQueue` se si desidera accodare le notifiche.

## Best Practices

1. **Utilizzare le Code**: Implementare `ShouldQueue` per evitare di bloccare l'applicazione durante l'invio di email.

2. **Testare con Notifiable Mock**: Creare mock di test che implementano l'interfaccia `Notifiable` per testare facilmente le notifiche.

3. **Utilizzare il Locale**: Impostare il locale per la notifica utilizzando `->locale('it')` prima di `->notify()`.

4. **Gestire gli Errori**: Implementare una gestione degli errori per catturare eventuali problemi durante l'invio delle notifiche.

## Collegamenti alla Documentazione Correlata

- [ATTACHMENTS_USAGE.md](../email-sending/ATTACHMENTS_USAGE.md)
- [EMAIL_LAYOUTS_BEST_PRACTICES.md](../mail-templates/EMAIL_LAYOUTS_BEST_PRACTICES.md)
- [EMAIL_TROUBLESHOOTING.md](../email-sending/EMAIL_TROUBLESHOOTING.md)
