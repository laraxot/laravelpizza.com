# Guida all'utilizzo di SpatieEmail

## Introduzione

Questa guida illustra come utilizzare la classe `SpatieEmail` per inviare email personalizzate nel sistema, basandosi sul pacchetto `spatie/laravel-database-mail-templates`.

## Collegamenti correlati

- [README del modulo Notify](./README.md)
- [Documentazione Email Templates](./EMAIL_TEMPLATES.md)
- [Email Specifiche per Dottori](./DOCTOR_EMAILS.md)
- [Implementazione Database Mail](./database-mail.md)
- [Documentazione Centrale](../../../../docs/collegamenti-documentazione.md)
- [Modulo Xot](../../../Xot/docs/README.md)

## Implementazione attuale

il sistema utilizza il pacchetto `spatie/laravel-database-mail-templates` per gestire i template delle email nel database. L'implementazione attuale include:

1. **MailTemplate Model**: Estende `SpatieMailTemplate` e implementa `HasTranslations` per supportare traduzioni multilingua
2. **Migration**: Tabella `mail_templates` con colonne JSON per contenuti traducibili
3. **MailTemplateResource**: Resource Filament per gestire i template nel pannello amministrativo
4. **SpatieEmail**: Classe base che utilizza `TemplateMailable` per inviare email basate su template

## Come funziona SpatieEmail

La classe `SpatieEmail` è progettata come un componente riutilizzabile per inviare diversi tipi di email utilizzando template memorizzati nel database. La classe:

```php
<?php
namespace Modules\Notify\Emails;

use Illuminate\Database\Eloquent\Model;
use Modules\Notify\Models\MailTemplate;
use Spatie\MailTemplates\TemplateMailable;

class SpatieEmail extends TemplateMailable
{
    protected static $templateModelClass = MailTemplate::class;

    public function __construct(Model $record)
    {
        $data = $record->toArray();
        $this->setAdditionalData($data);
    }
    
    public function getHtmlLayout(): string
    {
        return '<header>Site name!</header>{{{ body }}}<footer>Copyright 2018</footer>';
    }
}
```

## Come utilizzare SpatieEmail per diversi tipi di email

### 1. Creare il template nel database

Prima di tutto, è necessario creare un template per ogni tipo di email nel database:

```php
use Modules\Notify\Models\MailTemplate;

// Email di benvenuto
MailTemplate::create([
    'mailable' => \Modules\Notify\Emails\SpatieEmail::class,
    'subject' => [
        'it' => 'Benvenuto nella piattaforma, {{ first_name }}',
        'en' => 'Welcome to the application, {{ first_name }}'
    ],
    'html_template' => [
        'it' => '<p>Ciao {{ first_name }},</p><p>Grazie per esserti registrato nella piattaforma!</p>',
        'en' => '<p>Hello {{ first_name }},</p><p>Thank you for registering with the application!</p>'
    ],
    'text_template' => [
        'it' => 'Ciao {{ first_name }}, Grazie per esserti registrato nella piattaforma!',
        'en' => 'Hello {{ first_name }}, Thank you for registering with the application!'
    ]
]);

// Email per dottori (ripresa registrazione)
MailTemplate::create([
    'mailable' => \Modules\Notify\Emails\SpatieEmail::class,
    'subject' => [
        'it' => 'Completa la tua registrazione, Dottor {{ last_name }}',
        'en' => 'Complete your registration, Dr. {{ last_name }}'
    ],
    'html_template' => [
        'it' => '<p>Gentile Dottor {{ last_name }},</p><p>La invitiamo a completare la sua registrazione sulla piattaforma cliccando sul seguente link: <a href="{{ registration_url }}">Completa Registrazione</a></p>',
        'en' => '<p>Dear Dr. {{ last_name }},</p><p>We invite you to complete your registration on the application by clicking the following link: <a href="{{ registration_url }}">Complete Registration</a></p>'
    ],
    'text_template' => [
        'it' => 'Gentile Dottor {{ last_name }}, La invitiamo a completare la sua registrazione sulla piattaforma: {{ registration_url }}',
        'en' => 'Dear Dr. {{ last_name }}, We invite you to complete your registration on the application: {{ registration_url }}'
    ]
]);
```

### 2. Inviare email specifiche

#### Email di benvenuto per nuovi utenti

```php
use Illuminate\Support\Facades\Mail;
use Modules\Notify\Emails\SpatieEmail;

// In un controller o action
public function sendWelcomeEmail(User $user): void
{
    // Il sistema selezionerà automaticamente il template corretto basato sulla classe mailable
    Mail::to($user->email)
        ->locale(app()->getLocale()) // Importante: usa sempre LaravelLocalization::getCurrentLocale() in produzione
        ->send(new SpatieEmail($user));
}
```

#### Email di promemoria per i dottori

```php
use Illuminate\Support\Facades\Mail;
use Modules\Notify\Emails\SpatieEmail;
use Modules\Doctor\Models\Doctor;

// In una Queueable Action (approccio raccomandato)
public function handle(Doctor $doctor, string $registrationUrl): void
{
    // Arricchiamo il model con dati aggiuntivi per il template
    $doctor->setAttribute('registration_url', $registrationUrl);
    
    Mail::to($doctor->email)
        ->locale(LaravelLocalization::getCurrentLocale())
        ->send(new SpatieEmail($doctor));
}
```

## Best practices

1. **Utilizzo di Queueable Actions**: Seguendo le linee guida del progetto, implementare le logiche di invio email come azioni queueable:

```php
namespace Modules\Notify\Actions;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Mail;
use Modules\Notify\Emails\SpatieEmail;
use Spatie\QueueableAction\QueueableAction;

class SendTemplatedEmailAction
{
    use QueueableAction;

    public function execute(Model $record, string $email, string $locale = null): void
    {
        Mail::to($email)
            ->locale($locale ?? LaravelLocalization::getCurrentLocale())
            ->send(new SpatieEmail($record));
    }
}
```

2. **Layout HTML personalizzato**: Sovrascrivere il metodo `getHtmlLayout()` per utilizzare un layout HTML più sofisticato:

```php
public function getHtmlLayout(): string
{
    return view('notify::emails.layouts.main')->render();
}
```

3. **Differenziazione dei template**: Creare template specifici per ogni tipo di email, utilizzando il campo `mailable` per distinguerli.

## Esempi pratici di utilizzo

### Email di benvenuto post-registrazione

```php
namespace Modules\User\Actions;

use Modules\User\Models\User;
use Modules\Notify\Actions\SendTemplatedEmailAction;
use Spatie\QueueableAction\QueueableAction;

class SendWelcomeEmailAction
{
    use QueueableAction;

    public function __construct(
        protected SendTemplatedEmailAction $sendTemplatedEmailAction
    ) {}

    public function execute(User $user): void
    {
        $this->sendTemplatedEmailAction->execute($user, $user->email);
    }
}
```

### Email di promemoria per completamento registrazione dottore

```php
namespace Modules\Doctor\Actions;

use Modules\Doctor\Models\Doctor;
use Modules\Notify\Actions\SendTemplatedEmailAction;
use Spatie\QueueableAction\QueueableAction;

class SendRegistrationReminderAction
{
    use QueueableAction;

    public function __construct(
        protected SendTemplatedEmailAction $sendTemplatedEmailAction
    ) {}

    public function execute(Doctor $doctor): void
    {
        // Generare URL sicuro per completamento registrazione
        $registrationUrl = route(
            'doctor.registration.continue', 
            ['token' => $doctor->registration_token]
        );
        
        // Aggiungi dati temporanei al modello
        $doctor->setAttribute('registration_url', $registrationUrl);
        
        $this->sendTemplatedEmailAction->execute($doctor, $doctor->email);
    }
}
```

## Personalizzazione avanzata della classe SpatieEmail

Per necessità più complesse, è possibile estendere `SpatieEmail` per specifici casi d'uso:

```php
namespace Modules\Doctor\Emails;

use Modules\Doctor\Models\Doctor;
use Modules\Notify\Emails\SpatieEmail;

class DoctorRegistrationEmail extends SpatieEmail
{
    protected static string $templateName = 'doctor-registration';
    
    public function __construct(Doctor $doctor, string $registrationUrl)
    {
        $doctor->setAttribute('registration_url', $registrationUrl);
        parent::__construct($doctor);
    }
    
    // Override del layout per questo tipo specifico di email
    public function getHtmlLayout(): string
    {
        return view('doctor::emails.layouts.medical')->render();
    }
}
```

## Risoluzione problemi comuni

1. **Template non trovato**: Verificare che il template sia stato correttamente registrato nel database con il nome della classe mailable corretto.

2. **Variabili non disponibili nel template**: Assicurarsi che tutti i dati necessari siano presenti nel modello passato al costruttore o aggiunti tramite `setAdditionalData()`.

3. **Layout HTML non corretto**: Controllare che `{{{ body }}}` sia presente nel layout, altrimenti il contenuto dell'email non verrà inserito.

## Conclusione

L'utilizzo di `SpatieEmail` nel sistema permette di gestire in modo flessibile e centralizzato i template delle email, con supporto multilingua e personalizzazione avanzata. Seguendo le best practices e utilizzando le Queueable Actions, è possibile implementare un sistema di notifiche email robusto e manutenibile.
