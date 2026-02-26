# Errori Comuni nelle Notifiche

## 1. Errore Destinatario Mancante

### Errore
```
Symfony\Component\Mime\Exception\LogicException
An email must have a "To", "Cc", or "Bcc" header.
```

### Causa
- Destinatario non specificato o null
- Dati non validati prima dell'invio
- Problemi con il routing delle notifiche

### Soluzione
1. **Validazione Dati**:
   ```php
   if (empty($data['to']) || !filter_var($data['to'], FILTER_VALIDATE_EMAIL)) {
       throw new \InvalidArgumentException('Indirizzo email non valido');
   }
   ```

2. **Routing Corretto con Queueable Action**:
   ```php
   // Definizione dell'Action
   class SendNotificationAction
   {
       use QueueableAction;

       public function __construct(
           protected string $to,
           protected array $data
       ) {}

       public function execute()
       {
           Notification::route('mail', $this->to)
               ->notify(new YourNotification($this->data));
       }
   }

   // Utilizzo dell'Action
   SendNotificationAction::make($data['to'], $data)
       ->onQueue('notifications')
       ->execute();
   ```

3. **Gestione Errori**:
   ```php
   try {
       SendNotificationAction::make($data['to'], $data)
           ->onQueue('notifications')
           ->execute();
   } catch (\Exception $e) {
       Log::error('Errore invio notifica: ' . $e->getMessage());
       throw $e;
   }
   ```

## 2. Best Practices

### Validazione
- Validare sempre i dati in ingresso
- Usare le regole di validazione Laravel
- Verificare i tipi di dati

### Queueable Actions
- Usare Actions per la logica di business
- Separare la logica in Actions riutilizzabili
- Utilizzare le code per operazioni pesanti

### Gestione Errori
- Usare try/catch
- Loggare gli errori
- Fornire feedback appropriato

## 3. Struttura Corretta

### Action
```php
class SendNotificationAction
{
    use QueueableAction;

    public function __construct(
        protected string $to,
        protected array $data
    ) {}

    public function execute()
    {
        $this->validate();
        
        Notification::route('mail', $this->to)
            ->notify(new YourNotification($this->data));
    }

    protected function validate()
    {
        if (empty($this->to) || !filter_var($this->to, FILTER_VALIDATE_EMAIL)) {
            throw new \InvalidArgumentException('Indirizzo email non valido');
        }
    }
}
```

### Controller
```php
public function sendNotification(Request $request)
{
    $validated = $request->validate([
        'to' => 'required|email',
        'subject' => 'required|string',
        'body' => 'required|string'
    ]);

    try {
        SendNotificationAction::make($validated['to'], $validated)
            ->onQueue('notifications')
            ->execute();
    } catch (\Exception $e) {
        Log::error('Errore invio notifica: ' . $e->getMessage());
        return back()->with('error', 'Errore nell\'invio della notifica');
    }
}
```

### Notification Class
```php
class YourNotification extends Notification
{
    public function via($notifiable)
    {
        return ['mail'];
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject($this->data['subject'])
            ->line($this->data['body']);
    }
}
```

## 4. Debugging

### Log
- Abilitare il logging delle notifiche
- Controllare i log per errori
- Verificare le configurazioni

### Test
- Testare con dati validi
- Verificare su vari canali
- Controllare i limiti

## 5. Collegamenti Utili

- [Documentazione Laravel Notifications](https://laravel.com/docs/notifications)
- [Documentazione Laravel Mail](https://laravel.com/docs/mail)
- [Documentazione Spatie Queueable Action](https://github.com/spatie/laravel-queueable-action)
- [Best Practices Email](https://www.campaignmonitor.com/dev-resources/guides/coding-html-emails/) 