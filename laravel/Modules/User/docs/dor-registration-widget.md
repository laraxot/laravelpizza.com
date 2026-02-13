# Widget di Registrazione del Dottore

## Panoramica

Il widget di registrazione del dottore (`RegistrationWidget.php`) è un componente fondamentale nel processo di registrazione degli odontoiatri in <nome progetto>. Questo documento descrive la sua implementazione corretta e come deve essere integrato con il sistema di gestione degli stati tramite `spatie/laravel-model-states`.

## Posizione del File

```
Modules/User/app/Filament/Widgets/RegistrationWidget.php
```

## Architettura

Il widget estende `XotBaseWidget` e implementa l'interfaccia `HasForms` per gestire i form di registrazione. È progettato per funzionare in modo modulare, adattandosi al tipo di utente che si sta registrando (in questo caso, un dottore).

## Implementazione Corretta

L'implementazione attuale del widget è incompleta. Ecco come dovrebbe essere completata per gestire correttamente il salvataggio e l'impostazione dello stato:

```php
<?php

declare(strict_types=1);

namespace Modules\User\Filament\Widgets;

use Filament\Forms\Form;
use Filament\Widgets\Widget;
use Modules\Xot\Datas\XotData;
use Livewire\Attributes\Validate;
use Illuminate\Support\HtmlString;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Filament\Forms\Contracts\HasForms;
use Illuminate\Auth\Events\Registered;
use Filament\Forms\Components\Checkbox;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Wizard\Step;
use Filament\Forms\Concerns\InteractsWithForms;
use Modules\Xot\Filament\Widgets\XotBaseWidget;
use Modules\Patient\Models\Doctor;
use Modules\Patient\Models\DoctorRegistrationWorkflow;
use Illuminate\Support\Str;
use Modules\Notify\Emails\SpatieEmail;
use Illuminate\Support\Facades\Mail;

class RegistrationWidget extends XotBaseWidget
{
    public ?array $data = [];
    protected int | string | array $columnSpan = 'full';
    public string $type;
    public string $resource;
    protected static string $view = 'pub_theme::filament.widgets.registration';

    public function mount(string $type): void
    {
        $this->type = $type;
        $this->resource = XotData::make()->getUserResourceClassByType($type);
        $this->form->fill();
    }

    public function getFormSchema(): array
    {
        return $this->resource::getFormSchemaWidget();
    }

    /**
     * Gestisce la registrazione dell'utente.
     */
    public function register()
    {
        $data = $this->form->getState();
        
        // Validazione dei dati
        $this->validate();
        
        // Creazione del dottore
        $doctor = Doctor::create([
            'full_name' => $data['full_name'] ?? ($data['first_name'] . ' ' . $data['last_name']),
            'email' => $data['email'] ?? '',
            'phone' => $data['phone'] ?? '',
            'certification' => $data['certification'] ?? null,
            'state' => \Modules\Patient\States\Pending::class, // Imposta lo stato iniziale
        ]);
        
        // Creazione del workflow di registrazione
        $workflow = DoctorRegistrationWorkflow::create([
            'doctor_id' => $doctor->id,
            'current_step' => 'personal_info_step',
            'status' => DoctorRegistrationWorkflow::STATUS_PENDING_MODERATION,
            'started_at' => now(),
            'last_interaction_at' => now(),
            'session_id' => session()->getId(),
        ]);
        
        // Invio email di conferma
        $this->sendConfirmationEmail($doctor);
        
        // Reindirizzamento alla pagina di conferma
        return redirect()->route('doctor.registration.confirmation');
    }
    
    /**
     * Invia l'email di conferma della registrazione.
     */
    protected function sendConfirmationEmail(Doctor $doctor): void
    {
        $email = new SpatieEmail($doctor, 'registration_pending');
        
        Mail::to($doctor->email)
            ->locale(app()->getLocale())
            ->send($email);
    }
}
```

## Integrazione con il Sistema di Stati

Il widget deve integrarsi con il sistema di stati del dottore, che utilizza `spatie/laravel-model-states`. Quando un dottore si registra, il suo stato iniziale dovrebbe essere impostato su `Pending`.

### Classi di Stato

Le classi di stato dovrebbero essere definite in `Modules\Patient\States\`:

```php
namespace Modules\Patient\States;

use Spatie\ModelStates\State;
use Spatie\ModelStates\StateConfig;

abstract class DoctorState extends State
{
    public static function config(): StateConfig
    {
        return parent::config()
            ->default(Pending::class)
            ->allowTransition(Pending::class, Approved::class)
            ->allowTransition(Pending::class, Rejected::class)
            ->allowTransition(Approved::class, Active::class);
    }
}

class Pending extends DoctorState
{
}

class Approved extends DoctorState
{
}

class Rejected extends DoctorState
{
}

class Active extends DoctorState
{
}
```

## Workflow di Registrazione

Il workflow di registrazione del dottore segue questi passaggi:

1. **Registrazione Iniziale**: Il dottore compila il form iniziale con i dati personali e carica la certificazione
2. **Moderazione**: Un amministratore esamina la richiesta e la approva o rifiuta
3. **Completamento**: Se approvato, il dottore riceve un'email con un link per completare la registrazione
4. **Dati Professionali**: Il dottore compila i dati professionali
5. **Disponibilità**: Il dottore imposta la sua disponibilità
6. **Attivazione**: Il dottore viene attivato nel sistema

## Seeder per Template Email

Per garantire che i template email siano disponibili nel sistema, è necessario creare un seeder:

```php
namespace Modules\Notify\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\Notify\Models\MailTemplate;

class MailTemplatesTableSeeder extends Seeder
{
    public function run(): void
    {
        // Template per la registrazione iniziale del dottore
        MailTemplate::firstOrCreate(
            [
                'mailable' => \Modules\Notify\Emails\SpatieEmail::class,
                'slug' => 'registration_pending'
            ],
            [
                'subject' => [
                    'it' => 'Registrazione in attesa di moderazione - <nome progetto>',
                    'en' => 'Registration pending moderation - <nome progetto>'
                ],
                'html_template' => [
                    'it' => '<p>Gentile {{ full_name }},</p>
<p>La tua richiesta di registrazione è stata ricevuta e sarà esaminata dal nostro team.</p>
<p>Riceverai un\'email quando la tua registrazione sarà stata moderata.</p>
<p>Cordiali saluti,<br>Il team di <nome progetto></p>',
                    'en' => '<p>Dear {{ full_name }},</p>
<p>Your registration request has been received and will be reviewed by our team.</p>
<p>You will receive an email when your registration has been moderated.</p>
<p>Best regards,<br>The <nome progetto> Team</p>'
                ],
                'text_template' => [
                    'it' => 'Gentile {{ full_name }},

La tua richiesta di registrazione è stata ricevuta e sarà esaminata dal nostro team.

Riceverai un\'email quando la tua registrazione sarà stata moderata.

Cordiali saluti,
Il team di <nome progetto>',
                    'en' => 'Dear {{ full_name }},

Your registration request has been received and will be reviewed by our team.

You will receive an email when your registration has been moderated.

Best regards,
The <nome progetto> Team'
                ]
            ]
        );
        
        // Altri template...
    }
}
```

## Vantaggi dell'Approccio

1. **Separazione delle Responsabilità**: Il widget gestisce solo la parte di UI e interazione con l'utente
2. **Integrazione con Stati**: Utilizzo di `spatie/laravel-model-states` per una gestione type-safe degli stati
3. **Flessibilità**: Possibilità di estendere facilmente il processo con nuovi stati o passaggi
4. **Manutenibilità**: Codice ben organizzato e facile da mantenere
5. **Sicurezza**: Validazione dei dati e gestione sicura del processo di registrazione

## Collegamenti Bidirezionali

- [Email Doctor Registration](docs/email-doctor-registration.md)
- [Registrazione Odontoiatra](docs/roadmap_frontoffice/13-registrazione-odontoiatra.md)
- [DoctorResource](Modules/Patient/app/Filament/Resources/DoctorResource.php)
- [RegistrationWidget](Modules/User/app/Filament/Widgets/RegistrationWidget.php)
