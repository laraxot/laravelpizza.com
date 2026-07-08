# Invio Email per la Continuazione della Registrazione del Dottore

## Panoramica del Processo

Nel sistema <nome progetto>, l'invio dell'email al dottore con il link per continuare la registrazione è un passaggio cruciale che avviene dopo la moderazione della richiesta iniziale. Questo documento descrive in dettaglio dove e come avviene questo processo utilizzando `SpatieEmail` e `spatie/laravel-model-states`.

## Architettura del Sistema

### 1. Gestione degli Stati con Spatie Model States

Il sistema utilizza `spatie/laravel-model-states` per gestire gli stati del processo di registrazione del dottore in modo type-safe e orientato agli oggetti:

```php
// Definizione degli stati base
abstract class DoctorRegistrationState extends State
{
    public static function config(): StateConfig
    {
        return parent::config()
            ->default(Draft::class)
            ->allowTransition(Draft::class, PendingModeration::class)
            ->allowTransition(PendingModeration::class, [Approved::class, Rejected::class])
            ->allowTransition(Approved::class, Completed::class);
    }
}

// Stati concreti
class Draft extends DoctorRegistrationState {}
class PendingModeration extends DoctorRegistrationState {}
class Approved extends DoctorRegistrationState {}
class Rejected extends DoctorRegistrationState {}
class Completed extends DoctorRegistrationState {}
```

Il modello `Doctor` utilizza questi stati attraverso il trait `HasStates`:

```php
use Spatie\ModelStates\HasStates;

class Doctor extends User implements HasStatesContract
{
    use HasStates;
    
    protected function casts(): array
    {
        return [
            'registration_status' => DoctorRegistrationState::class,
            // altri cast...
        ];
    }
}
```

### 2. Transizioni di Stato e Invio Email

Le transizioni di stato sono gestite attraverso classi dedicate che incapsulano la logica di business:

```php
class ApproveDoctorRegistration extends Transition
{
    private string $moderatorId;
    
    public function __construct(string $moderatorId)
    {
        $this->moderatorId = $moderatorId;
    }
    
    public function handle(Doctor $doctor): DoctorRegistrationState
    {
        // Logica di approvazione
        $doctor->moderated_by = $this->moderatorId;
        $doctor->moderated_at = now();
        $doctor->generateModerationToken();
        $doctor->save();
        
        // Invio email
        $email = new SpatieEmail($doctor, 'registration_moderated');
        
        Mail::to($doctor->email)
            ->locale('it')
            ->send($email);
        
        return new Approved($doctor);
    }
}
```

## Template Email con Spatie

### 1. Configurazione dei Template

I template delle email sono gestiti attraverso `spatie/laravel-database-mail-templates` e memorizzati nel database:

```php
use Modules\Notify\Models\MailTemplate;

// Creazione o aggiornamento del template
MailTemplate::firstOrCreate(
    // Condizioni di ricerca - cerca un template con questo mailable e slug
    [
        'mailable' => \Modules\Notify\Emails\SpatieEmail::class,
        'slug' => 'registration_moderated'
    ],
    // Valori da inserire se non viene trovato un record corrispondente
    [
        'subject' => [
            'it' => 'Registrazione {{ status }} - <nome progetto>',
            'en' => 'Registration {{ status }} - <nome progetto>'
        ],
        'html_template' => [
            'it' => '<p>Gentile {{ full_name }},</p>
<p>La tua richiesta di registrazione è stata {{ status_text }}.</p>
{% if is_approved %}
<p>Per continuare la registrazione, <a href="{{ continue_url }}">clicca qui</a>.</p>
{% else %}
<p>{{ rejection_reason }}</p>
{% endif %}
<p>Cordiali saluti,<br>Il team di <nome progetto></p>',
            'en' => '<p>Dear {{ full_name }},</p>
<p>Your registration request has been {{ status_text_en }}.</p>
{% if is_approved %}
<p>To continue with your registration, <a href="{{ continue_url }}">click here</a>.</p>
{% else %}
<p>{{ rejection_reason_en }}</p>
{% endif %}
<p>Best regards,<br>The <nome progetto> Team</p>'
        ],
        'text_template' => [
            'it' => 'Gentile {{ full_name }},

La tua richiesta di registrazione è stata {{ status_text }}.

{% if is_approved %}
Per continuare la registrazione, visita il seguente link: {{ continue_url }}
{% else %}
{{ rejection_reason }}
{% endif %}

Cordiali saluti,
Il team di <nome progetto>',
            'en' => 'Dear {{ full_name }},

Your registration request has been {{ status_text_en }}.

{% if is_approved %}
To continue with your registration, visit the following link: {{ continue_url }}
{% else %}
{{ rejection_reason_en }}
{% endif %}

Best regards,
The <nome progetto> Team'
        ]
    ]
);
```

### 2. Classe SpatieEmail

La classe `SpatieEmail` gestisce l'invio delle email utilizzando i template dal database:

```php
namespace Modules\Notify\Emails;

use Illuminate\Database\Eloquent\Model;
use Modules\Notify\Models\MailTemplate;
use Spatie\MailTemplates\TemplateMailable;

class SpatieEmail extends TemplateMailable
{
    protected static $templateModelClass = MailTemplate::class;
    public string $slug;
    
    public function __construct(Model $record, string $slug)
    {
        $data = $record->toArray();
        
        // Aggiungiamo dati specifici per la registrazione del dottore
        if ($slug === 'registration_moderated') {
            $data['is_approved'] = $record->registration_status instanceof Approved;
            
            // Valori in italiano
            $data['status'] = $data['is_approved'] ? 'approvata' : 'in revisione';
            $data['status_text'] = $data['is_approved'] ? 'approvata' : 'messa in revisione';
            $data['rejection_reason'] = $record->moderation_notes ?? 'La tua richiesta richiede ulteriori verifiche.';
            
            // Valori in inglese
            $data['status_en'] = $data['is_approved'] ? 'approved' : 'under review';
            $data['status_text_en'] = $data['is_approved'] ? 'approved' : 'placed under review';
            $data['rejection_reason_en'] = $record->moderation_notes ?? 'Your request requires further verification.';
            
            if ($data['is_approved']) {
                $data['continue_url'] = route('doctor.registration.continue', [
                    'token' => $record->moderation_token
                ]);
            }
        }
        
        $this->setAdditionalData($data);
        $this->slug = $slug;
    }
    
    public function getSlug(): string
    {
        return $this->slug;
    }
    
    /**
     * Add attachments to the email
     *
     * @param array<int, array<string, string>> $attachments Array of attachment data
     * @return self
     */
    public function addAttachments(array $attachments): self
    {
        $attachmentObjects = [];
        
        foreach ($attachments as $item) {
            if (!isset($item['path']) || !file_exists($item['path'])) {
                continue;
            }
            
            $attachment = Attachment::fromPath($item['path']);
            
            if (isset($item['as'])) {
                $attachment = $attachment->as($item['as']);
            }
            
            if (isset($item['mime'])) {
                $attachment = $attachment->withMime($item['mime']);
            }
            
            $attachmentObjects[] = $attachment;
        }
        
        $this->customAttachments = $attachmentObjects;
        
        return $this;
    }
    
    /**
     * Get the HTML layout for the email
     *
     * @return string
     */
    public function getHtmlLayout(): string
    {
        $pathToLayout = module_path('Notify', 'resources/mail-layouts/base.html');
        return file_get_contents($pathToLayout);
    }
}
```

## Seeder per i Template Email

Per garantire che i template email siano disponibili nel sistema, è stato creato un seeder dedicato:

```php
namespace Modules\Notify\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\Notify\Models\MailTemplate;
use Modules\Notify\Emails\SpatieEmail;

class MailTemplatesTableSeeder extends Seeder
{
    public function run(): void
    {
        // Template per la registrazione del dottore
        MailTemplate::firstOrCreate(
            // Condizioni di ricerca
            [
                'mailable' => \Modules\Notify\Emails\SpatieEmail::class,
                'slug' => 'registration_moderated'
            ],
            // Valori da inserire se non trovato
            [
                'subject' => [
                    'it' => 'Registrazione {{ status }} - <nome progetto>',
                    'en' => 'Registration {{ status }} - <nome progetto>'
                ],
                'html_template' => [
                    'it' => '<p>Gentile {{ full_name }},</p>\n<p>La tua richiesta di registrazione è stata {{ status_text }}.</p>\n{% if is_approved %}\n<p>Per continuare la registrazione, <a href="{{ continue_url }}">clicca qui</a>.</p>\n{% else %}\n<p>{{ rejection_reason }}</p>\n{% endif %}\n<p>Cordiali saluti,<br>Il team di <nome progetto></p>',
                    'en' => '<p>Dear {{ full_name }},</p>\n<p>Your registration request has been {{ status_text_en }}.</p>\n{% if is_approved %}\n<p>To continue with your registration, <a href="{{ continue_url }}">click here</a>.</p>\n{% else %}\n<p>{{ rejection_reason_en }}</p>\n{% endif %}\n<p>Best regards,<br>The <nome progetto> Team</p>'
                ],
                'text_template' => [
                    'it' => 'Gentile {{ full_name }},\n\nLa tua richiesta di registrazione è stata {{ status_text }}.\n\n{% if is_approved %}\nPer continuare la registrazione, visita il seguente link: {{ continue_url }}\n{% else %}\n{{ rejection_reason }}\n{% endif %}\n\nCordiali saluti,\nIl team di <nome progetto>',
                    'en' => 'Dear {{ full_name }},\n\nYour registration request has been {{ status_text_en }}.\n\n{% if is_approved %}\nTo continue with your registration, visit the following link: {{ continue_url }}\n{% else %}\n{{ rejection_reason_en }}\n{% endif %}\n\nBest regards,\nThe <nome progetto> Team'
                ]
            ]
        );
        
        // Altri template...
    }
}
```

## Vantaggi dell'Approccio

1. **Separazione delle Responsabilità**: La logica di transizione di stato è separata dalla logica di invio email
2. **Template Centralizzati**: I template email sono gestiti nel database e possono essere modificati senza toccare il codice
3. **Type Safety**: Gli stati sono classi PHP con type hinting, riducendo errori di runtime
4. **Manutenibilità**: Facile aggiungere nuovi stati e template email senza modificare il codice esistente
5. **Localizzazione**: Supporto nativo per la localizzazione delle email
6. **Testabilità**: Facile testare le transizioni di stato e l'invio email separatamente

### 4. Generazione del Token

Prima dell'invio dell'email, se la moderazione è stata approvata, viene generato un token univoco che sarà incluso nell'URL per continuare la registrazione:

```php
// Se approvato, genera token per proseguire e aggiorna lo step
if ($approved) {
    $workflow->generateModerationToken();
    $workflow->current_step = 'contacts_step';
}
```

Il token viene generato dal metodo `generateModerationToken()` nella classe `DoctorRegistrationWorkflow`:

```php
public function generateModerationToken(): string
{
    $this->moderation_token = Str::random(64);
    $this->save();
    return $this->moderation_token;
}
```

### 5. URL di Continuazione

L'URL per continuare la registrazione viene generato utilizzando la route `doctor.registration.continue` e includendo il token di moderazione:

```php
route('doctor.registration.continue', [
    'token' => $this->workflow->moderation_token
])
```

Questo URL viene incluso nell'email solo se la moderazione è stata approvata.

## Template dell'Email

Il template dell'email si trova in:
```
Modules/Patient/resources/views/emails/doctor-registration-moderated.blade.php
```

Il template visualizza:
- Un messaggio di congratulazioni o di informazione sullo stato della moderazione
- Il link per continuare la registrazione (solo se approvata)
- Eventuali note di moderazione

## Sicurezza e Validazione

1. **Token Univoco**: Il token di 64 caratteri generato con `Str::random(64)` garantisce un'alta entropia e sicurezza
2. **Validazione del Token**: Quando il dottore clicca sul link, il token viene validato in `DoctorResource::handleModerationToken()`
3. **Scadenza del Token**: Il token ha una validità di 48 ore dalla data di moderazione
4. **Logging**: Tentativi di accesso con token non validi o scaduti vengono registrati

## Diagramma di Sequenza

```
┌─────────┐          ┌────────────────────┐          ┌─────────────────┐          ┌────────┐
│ Admin   │          │ ProcessDoctorMod.. │          │ DoctorRegistr.. │          │ Doctor │
└────┬────┘          └──────────┬─────────┘          └────────┬────────┘          └───┬────┘
     │                          │                              │                      │
     │ Approva registrazione    │                              │                      │
     │ ─────────────────────────>                              │                      │
     │                          │                              │                      │
     │                          │ Aggiorna stato a APPROVED    │                      │
     │                          │ ────────────────────────────>│                      │
     │                          │                              │                      │
     │                          │ Genera token                 │                      │
     │                          │ ────────────────────────────>│                      │
     │                          │                              │                      │
     │                          │ Invia email con token        │                      │
     │                          │ ─────────────────────────────────────────────────────>
     │                          │                              │                      │
     │                          │                              │  Clicca sul link     │
     │                          │                              │ <─────────────────────
     │                          │                              │                      │
     │                          │                              │ Valida token         │
     │                          │                              │ ──────────────┐      │
     │                          │                              │               │      │
     │                          │                              │ <─────────────┘      │
     │                          │                              │                      │
     │                          │                              │ Mostra form          │
     │                          │                              │ ─────────────────────>
     │                          │                              │                      │
┌─────────┐          ┌────────────────────┐          ┌─────────────────┐          ┌────────┐
│ Admin   │          │ ProcessDoctorMod.. │          │ DoctorRegistr.. │          │ Doctor │
└─────────┘          └────────────────────┘          └─────────────────┘          └────────┘
```

## Widget di Registrazione

Il processo di registrazione iniziale del dottore utilizza il widget di registrazione generico che si trova in:

```
Modules/User/app/Filament/Widgets/RegistrationWidget.php
```

Questo widget è progettato per gestire la registrazione di diversi tipi di utenti, non solo i dottori. Per maggiori dettagli sul funzionamento del widget e su come completarlo correttamente, consultare la [documentazione del widget di registrazione](./registration-widget.md).

## Processo di Invio Email

Il processo di invio email per la registrazione dei dottori è gestito tramite il sistema SpatieEmail, che utilizza template email personalizzabili.

### Campi Necessari per l'Invio Email

Per inviare correttamente le email di registrazione, è fondamentale raccogliere i seguenti campi durante il processo di registrazione:

```php
// Campi minimi necessari per l'invio email
'first_name' => Forms\Components\TextInput::make('first_name')->required(),
'last_name' => Forms\Components\TextInput::make('last_name')->required(),
'email' => Forms\Components\TextInput::make('email')->required()->email(),
```

**IMPORTANTE**: L'indirizzo email è essenziale per inviare notifiche all'utente. Senza questo campo, non sarà possibile comunicare con il dottore durante il processo di moderazione.

## Conclusione

Il processo di invio dell'email al dottore con il link per continuare la registrazione è un componente ben progettato del sistema <nome progetto>, che garantisce:

1. **Sicurezza**: Utilizzo di token univoci e validazione
2. **Flessibilità**: Contenuto dell'email adattato in base all'esito della moderazione
3. **Integrazione**: Utilizzo del widget di registrazione generico per la fase iniziale
4. **Tracciabilità**: Logging delle azioni e degli accessi
5. **Usabilità**: URL chiaro e diretto per continuare la registrazione
