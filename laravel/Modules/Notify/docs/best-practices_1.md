# Best Practices Implementazione

## Template Email

### 1. Struttura Template
```php
// resources/views/vendor/notifications/email/base.blade.php
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ config('app.name') }}</title>
    <style>
        /* Stili inline per compatibilità */
        .container { max-width: 600px; margin: 0 auto; }
        .header { text-align: center; padding: 20px; }
        .content { padding: 20px; }
        .footer { text-align: center; padding: 20px; font-size: 12px; }
    </style>
</head>
<body>
    <div class="container">
        @yield('content')
    </div>
</body>
</html>
```

### 2. Gestione Variabili
```php
// app/Services/TemplateVariableService.php
class TemplateVariableService
{
    public function validate($template, $variables)
    {
        // 1. Verifica variabili richieste
        // 2. Validazione tipi
        // 3. Sanitizzazione
        // 4. Logging errori
    }

    public function replace($template, $variables)
    {
        // 1. Sostituzione sicura
        // 2. Escape HTML
        // 3. Gestione fallback
        // 4. Cache risultato
    }
}
```

## Sistema Notifiche

### 1. Gestione Code
```php
// app/Notifications/QueuedNotification.php
class QueuedNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public function retryUntil()
    {
        return now()->addHours(24);
    }

    public function backoff()
    {
        return [60, 180, 360];
    }
}
```

### 2. Rate Limiting
```php
// app/Providers/NotificationServiceProvider.php
class NotificationServiceProvider extends ServiceProvider
{
    public function boot()
    {
        RateLimiter::for('notifications', function ($job) {
            return Limit::perMinute(60)->by($job->user->id);
        });
    }
}
```

## Editor Visuale

### 1. Validazione Input
```php
// app/Filament/Resources/EmailTemplateResource.php
class EmailTemplateResource extends Resource
{
    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Builder::make('content')
                ->blocks([
                    Builder\Block::make('text')
                        ->schema([
                            Forms\Components\RichEditor::make('content')
                                ->required()
                                ->rules([
                                    'required',
                                    'string',
                                    'max:10000',
                                    function ($attribute, $value, $fail) {
                                        // Validazione personalizzata
                                    },
                                ]),
                        ]),
                ]),
        ]);
    }
}
```

### 2. Preview Template
```php
// app/Filament/Resources/EmailTemplateResource/Actions/PreviewAction.php
class PreviewAction extends Action
{
    public function handle()
    {
        // 1. Genera preview
        // 2. Valida template
        // 3. Test rendering
        // 4. Log errori
    }
}
```

## Integrazioni

### 1. Mailgun
```php
// app/Services/MailgunService.php
class MailgunService
{
    public function send($template, $data)
    {
        try {
            // 1. Validazione input
            // 2. Preparazione payload
            // 3. Invio email
            // 4. Logging risultato
        } catch (Exception $e) {
            // 1. Log errore
            // 2. Notifica admin
            // 3. Retry policy
            // 4. Fallback
        }
    }
}
```

### 2. Mailtrap
```php
// app/Services/MailtrapService.php
class MailtrapService
{
    public function test($template, $data)
    {
        // 1. Validazione ambiente
        // 2. Preparazione test
        // 3. Invio test
        // 4. Verifica risultato
    }
}
```

## Best Practices Generali

### 1. Performance
- Utilizzare cache template
- Implementare lazy loading
- Ottimizzare query database
- Minimizzare dipendenze

### 2. Sicurezza
- Validare input
- Sanitizzare output
- Implementare rate limiting
- Logging accessi

### 3. Manutenibilità
- Documentazione completa
- Test unitari
- Test integrazione
- Code review

### 4. Monitoraggio
- Logging dettagliato
- Metriche performance
- Alert errori
- Report utilizzo

## Note
- Tutti i collegamenti sono relativi
- La documentazione è mantenuta in italiano
- I collegamenti sono bidirezionali quando appropriato
- Ogni sezione ha il suo README.md specifico

## Contribuire
Per contribuire alla documentazione, seguire le [Linee Guida](../../../docs/linee-guida-documentazione.md) e le [Regole dei Collegamenti](../../../docs/regole_collegamenti_documentazione.md).

## Collegamenti Completi
Per una lista completa di tutti i collegamenti tra i README.md, consultare il file [README_links.md](../../../docs/README_links.md). 
