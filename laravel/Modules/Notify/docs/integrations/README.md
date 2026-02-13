# Integrazioni

## Panoramica
Questo documento descrive le integrazioni con servizi esterni utilizzate nel modulo Notify.

## Mailgun

### Configurazione
```php
// config/services.php
return [
    'mailgun' => [
        'domain' => env('MAILGUN_DOMAIN'),
        'secret' => env('MAILGUN_SECRET'),
        'endpoint' => env('MAILGUN_ENDPOINT', 'api.mailgun.net'),
    ],
];
```

### Utilizzo
```php
// app/Services/MailgunService.php
namespace App\Services;

use Mailgun\Mailgun;

class MailgunService
{
    protected $mailgun;

    public function __construct()
    {
        $this->mailgun = Mailgun::create(
            config('services.mailgun.secret'),
            config('services.mailgun.endpoint')
        );
    }

    public function send($to, $subject, $html)
    {
        return $this->mailgun->messages()->send(
            config('services.mailgun.domain'),
            [
                'from' => config('mail.from.address'),
                'to' => $to,
                'subject' => $subject,
                'html' => $html,
            ]
        );
    }
}
```

## Mailtrap

### Configurazione
```php
// config/mail.php
return [
    'default' => env('MAIL_MAILER', 'smtp'),
    'mailers' => [
        'smtp' => [
            'transport' => 'smtp',
            'host' => env('MAILTRAP_HOST'),
            'port' => env('MAILTRAP_PORT'),
            'username' => env('MAILTRAP_USERNAME'),
            'password' => env('MAILTRAP_PASSWORD'),
            'encryption' => env('MAILTRAP_ENCRYPTION', 'tls'),
        ],
    ],
];
```

### Utilizzo
```php
// app/Services/MailtrapService.php
namespace App\Services;

use Illuminate\Support\Facades\Mail;

class MailtrapService
{
    public function send($to, $subject, $view, $data = [])
    {
        return Mail::send($view, $data, function ($message) use ($to, $subject) {
            $message->to($to)
                   ->subject($subject);
        });
    }
}
```

## Best Practices

### 1. Gestione Errori
- Implementare retry policy
- Logging dettagliato
- Monitoraggio errori
- Notifiche fallimenti

### 2. Performance
- Caching configurazioni
- Connection pooling
- Rate limiting
- Batch processing

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
