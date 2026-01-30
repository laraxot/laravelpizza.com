# Implementazione Registrazione Odontoiatra

## Stato: In Corso (40%)

## Architettura del Sistema

### 1. Pattern Parental e Gerarchia delle Classi
Il sistema utilizza il pattern "parental" tramite il pacchetto [`tighten/parental`](https://github.com/tighten/parental) per gestire i diversi tipi di utenti. La gerarchia delle classi è fondamentale per il funzionamento del sistema multi-tenant:

```php
// /laravel/Modules/User/app/Models/BaseUser.php
namespace Modules\User\Models;

class BaseUser extends Model
{
    // Logica comune a tutti gli utenti
    // Gestione autenticazione
    // Gestione ruoli base
    // Gestione tenant
}

// /laravel/Modules/Patient/app/Models/User.php
namespace Modules\Patient\Models;

class User extends BaseUser
{
    // Logica specifica per i pazienti
    // Gestione profilo paziente
    // Gestione appuntamenti
    // Gestione documenti paziente
}

// /laravel/Modules/Patient/app/Models/Doctor.php
namespace Modules\Patient\Models;

class Doctor extends User
{
    // Logica specifica per i dottori
    // Gestione profilo professionale
    // Gestione disponibilità
    // Gestione tariffe
    // Gestione documenti professionali
}
```

> **Nota:** La gerarchia delle classi è fondamentale per il funzionamento del sistema multi-tenant. Doctor estende `Modules\Patient\Models\User`, che a sua volta estende `Modules\User\Models\BaseUser`. Questo garantisce:
> - Ereditarietà corretta delle funzionalità
> - Polimorfismo per la gestione dei diversi tipi di utenti
> - Coerenza con la struttura multi-tenant
> - Riutilizzo del codice comune
> - Gestione unificata delle relazioni

### 2. Pacchetti e Componenti Coinvolti
- **Single Table Inheritance**: [`tighten/parental`](https://github.com/tighten/parental)
- **Gestione Stato**: [`spatie/laravel-model-states`](../laravel-model-states.md)
- **Azioni in coda**: [`spatie/laravel-queueable-action`](https://github.com/spatie/laravel-queueable-action)
- **Widget Filament**: [`RegistrationWidget.php`](../../laravel/Modules/User/app/Filament/Widgets/RegistrationWidget.php)
- **Resource**: [`DoctorResource.php`](../../laravel/Modules/Patient/app/Filament/Resources/DoctorResource.php)
- **Action**: [`ProcessDoctorModerationAction.php`](../../laravel/Modules/Patient/app/Actions/ProcessDoctorModerationAction.php)
- **Enum Stato**: [`RegistrationStatus.php`](../../laravel/Modules/Patient/app/Enums/RegistrationStatus.php)
- **Notifiche**: `RecordNotification` (azione custom)
- **Traduzioni**: [`LangServiceProvider.php`](../../laravel/Modules/Dentist/app/Providers/LangServiceProvider.php)

### 3. Stato vs Workflow: Scelta Architetturale

Per la registrazione e moderazione del Doctor viene usato **spatie/laravel-model-states** per la gestione dello stato della registrazione.

#### Implementazione Corretta dei Casts
```php
// /laravel/Modules/Patient/app/Models/DoctorRegistration.php
use Spatie\ModelStates\HasStates;

class DoctorRegistration extends BaseModel
{
    use HasStates;

    protected function casts(): array
    {
        return [
            'status' => DoctorRegistrationStatus::class,
            'approved_at' => 'datetime',
            'completed_at' => 'datetime',
            'terms_accepted' => 'boolean',
            'privacy_accepted' => 'boolean',
        ];
    }
}
```

#### Processo di Registrazione a Step

1. **Step 1: Registrazione Iniziale**
   ```php
   // /laravel/Modules/Patient/app/Filament/Resources/DoctorResource.php
   class DoctorResource extends XotBaseResource
   {
       public static function getFormSchema(): array
       {
           return [
               Forms\Components\Wizard::make([
                   Forms\Components\Wizard\Step::make('personal')
                       ->schema([
                           // Dati personali base
                           Forms\Components\TextInput::make('first_name'),
                           Forms\Components\TextInput::make('last_name'),
                           Forms\Components\TextInput::make('email'),
                           Forms\Components\TextInput::make('phone'),
                       ])
                       ->afterStateUpdated(function ($state, $set) {
                           // Genera token di completamento
                           $token = Str::random(64);
                           $set('completion_token', $token);
                       }),
               ])
               ->submitAction(view('filament.resources.doctor-resource.complete-registration'))
               ->onSubmit(function ($data) {
                   // Salva solo i dati del primo step
                   $registration = DoctorRegistration::create([
                       'first_name' => $data['first_name'],
                       'last_name' => $data['last_name'],
                       'email' => $data['email'],
                       'phone' => $data['phone'],
                       'completion_token' => $data['completion_token'],
                       'status' => RegistrationStatus::PENDING,
                   ]);

                   // Invia email di conferma
                   $registration->notify(new RegistrationPendingNotification());
               });
           ];
       }
   }
   ```

2. **Moderazione e Approvazione**
   ```php
   // /laravel/Modules/Patient/app/Actions/ApproveDoctorRegistration.php
   class ApproveDoctorRegistration
   {
       public function handle(DoctorRegistration $registration)
       {
           $registration->status->transitionTo(RegistrationStatus::APPROVED);
           
           // Genera nuovo token per il completamento
           $token = Str::random(64);
           $registration->update(['completion_token' => $token]);
           
           // Invia email con link per completare la registrazione
           $registration->notify(new RegistrationApprovedNotification($token));
       }
   }
   ```

3. **Completamento Registrazione**
   ```php
   // /laravel/Modules/Patient/app/Filament/Pages/CompleteDoctorRegistration.php
   class CompleteDoctorRegistration extends Page
   {
       public function mount($token)
       {
           $registration = DoctorRegistration::where('completion_token', $token)
               ->where('status', RegistrationStatus::APPROVED)
               ->firstOrFail();

           $this->form->fill($registration->toArray());
       }

       protected function getFormSchema(): array
       {
           return [
               // Step successivi del wizard
               Forms\Components\Wizard\Step::make('professional')
                   ->schema([
                       // Dati professionali
                   ]),
               Forms\Components\Wizard\Step::make('documents')
                   ->schema([
                       // Upload documenti
                   ]),
               Forms\Components\Wizard\Step::make('availability')
                   ->schema([
                       // Gestione disponibilità
                   ]),
           ];
       }
   }
   ```

#### Notifiche
```php
// /laravel/Modules/Patient/app/Notifications/RegistrationPendingNotification.php
class RegistrationPendingNotification extends Notification
{
    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject('Registrazione in Attesa di Moderazione')
            ->line('La tua registrazione è stata ricevuta e sarà esaminata al più presto.')
            ->line('Riceverai un\'email quando la registrazione sarà approvata.');
    }
}

// /laravel/Modules/Patient/app/Notifications/RegistrationApprovedNotification.php
class RegistrationApprovedNotification extends Notification
{
    public function __construct(private string $token)
    {}

    public function toMail($notifiable)
    {
        $url = route('filament.pages.complete-doctor-registration', ['token' => $this->token]);

        return (new MailMessage)
            ->subject('Registrazione Approvata')
            ->line('La tua registrazione è stata approvata.')
            ->action('Completa la Registrazione', $url)
            ->line('Il link scadrà tra 7 giorni.');
    }
}
```

#### Motivazione della scelta
- Il processo di registrazione, pur articolato, può essere modellato come una sequenza di stati (Pending, Approved, Rejected, Completed) con transizioni chiare e logica associata a ciascuno stato.
- spatie/laravel-model-states permette di:
  - Definire classi di stato con metodi e logica specifica
  - Gestire le transizioni in modo sicuro e dichiarativo
  - Integrare facilmente notifiche, validazioni e policy per ogni stato
  - Mantenere il codice semplice, leggibile e facilmente estendibile
- Se in futuro il processo dovesse diventare un workflow più complesso (multi-step, dati intermedi, storicizzazione avanzata, ruoli multipli), si potrà valutare l'introduzione di un modello workflow dedicato.

#### Esempio di implementazione
```php
// /laravel/Modules/Patient/app/Models/DoctorRegistration.php
use Spatie\ModelStates\HasStates;

class DoctorRegistration extends BaseModel
{
    use HasStates;

    protected $casts = [
        'status' => DoctorRegistrationStatus::class,
    ];
}

// /laravel/Modules/Patient/app/Enums/DoctorRegistrationStatus.php
abstract class DoctorRegistrationStatus extends State
{
    public static function config(): StateConfig
    {
        return parent::config()
            ->default(Pending::class)
            ->allowTransition(Pending::class, Approved::class)
            ->allowTransition(Pending::class, Rejected::class)
            ->allowTransition(Approved::class, Completed::class);
    }
}

class Pending extends DoctorRegistrationStatus {}
class Approved extends DoctorRegistrationStatus {}
class Rejected extends DoctorRegistrationStatus {}
class Completed extends DoctorRegistrationStatus {}
```

#### Best practice
- Usa spatie/laravel-model-states per la gestione dello stato della registrazione.
- Documenta sempre la logica delle transizioni e le policy di accesso/modifica per ogni stato.
- Se il processo dovesse evolvere in un workflow articolato, valuta l'introduzione di un modello workflow custom.

Per approfondimenti vedi anche:
- [docs/laravel-model-states.md](../laravel-model-states.md)
- [docs/rules.md](../rules.md)
- [docs/memories.md](../memories.md)

---

## Possibile evoluzione futura: Workflow dedicato

Se la registrazione dovesse richiedere storicizzazione avanzata, dati intermedi tra step, ruoli multipli e logica di processo articolata, si potrà introdurre un modello workflow dedicato (es. `DoctorRegistrationWorkflow`).

Mantenere questa possibilità documentata permette di scalare la soluzione senza stravolgere l'architettura.

## Descrizione
Implementazione del sistema di registrazione degli odontoiatri con processo di verifica e approvazione in due fasi. Il sistema garantisce la qualità e l'affidabilità dei professionisti attraverso un processo di moderazione e verifica documenti.

## Filosofia e Principi
Il sistema di registrazione è basato su tre principi fondamentali:

1. **Verifica e Fiducia**
   - Ogni odontoiatra deve essere verificato prima di poter operare
   - La verifica avviene attraverso documenti ufficiali
   - Il processo è trasparente e tracciabile

2. **Esperienza Utente**
   - Processo di registrazione semplice e intuitivo
   - Feedback chiaro in ogni fase
   - Comunicazione trasparente sullo stato della richiesta

3. **Sicurezza e Privacy**
   - Protezione dei dati sensibili
   - Conformità GDPR
   - Archiviazione sicura dei documenti

## Componenti Implementati

### 1. Form di Registrazione Iniziale
- Funzionalità:
  - Inserimento dati base
  - Upload documento identità
  - Upload titolo di studio
  - Verifica email
  - Termini e condizioni
  - Privacy policy

### 2. Sistema di Moderazione
- Caratteristiche:
  - Dashboard moderatori
  - Verifica documenti
  - Approvazione/rifiuto
  - Note moderazione
  - Storico decisioni
  - Report moderazione

### 3. Wizard Completamento Registrazione
- Funzionalità:
  - Dati professionali
  - Specializzazioni
  - Orari disponibilità
  - Tariffe servizi
  - Foto profilo
  - Biografia

### 4. Sistema Notifiche
- Processo:
  - Email verifica
  - Notifiche moderazione
  - Inviti completamento
  - Promemoria scadenza
  - Conferme completamento
  - Welcome kit

### 4. Gestione Disponibilità

#### Implementazione Giorni della Settimana
```php
// /laravel/Modules/Patient/app/Enums/DayOfWeek.php
enum DayOfWeek: int
{
    case MONDAY = 1;
    case TUESDAY = 2;
    case WEDNESDAY = 3;
    case THURSDAY = 4;
    case FRIDAY = 5;
    case SATURDAY = 6;
    case SUNDAY = 7;

    public function label(): string
    {
        return Carbon::create()->startOfWeek()->addDays($this->value - 1)->locale('it')->isoFormat('dddd');
    }

    public function shortLabel(): string
    {
        return Carbon::create()->startOfWeek()->addDays($this->value - 1)->locale('it')->isoFormat('ddd');
    }

    public static function toArray(): array
    {
        return collect(self::cases())->mapWithKeys(fn ($day) => [
            $day->value => $day->label()
        ])->toArray();
    }
}

// /laravel/Modules/Patient/app/Models/DoctorAvailability.php
class DoctorAvailability extends Model
{
    protected function casts(): array
    {
        return [
            'day' => DayOfWeek::class,
            'start_time' => 'datetime',
            'end_time' => 'datetime',
        ];
    }

    public function getDayLabelAttribute(): string
    {
        return $this->day->label();
    }

    public function getDayShortLabelAttribute(): string
    {
        return $this->day->shortLabel();
    }
}

// /laravel/Modules/Patient/app/Filament/Resources/DoctorAvailabilityResource.php
class DoctorAvailabilityResource extends XotBaseResource
{
    public static function getFormSchema(): array
    {
        return [
            Forms\Components\Select::make('day')
                ->options(DayOfWeek::toArray())
                ->required()
                ->label('Giorno'),
            Forms\Components\TimePicker::make('start_time')
                ->required()
                ->label('Orario Inizio'),
            Forms\Components\TimePicker::make('end_time')
                ->required()
                ->label('Orario Fine'),
        ];
    }
}
```

#### Vantaggi dell'Implementazione
1. **Type Safety**
   - L'Enum garantisce che solo valori validi siano accettati
   - Il type-hinting aiuta a prevenire errori
   - L'IDE fornisce autocompletamento

2. **Centralizzazione**
   - La logica dei giorni è in un unico punto
   - Le traduzioni sono gestite automaticamente da Carbon
   - Facile aggiungere nuove funzionalità

3. **Manutenibilità**
   - Codice più pulito e leggibile
   - Facile da testare
   - Facile da estendere

4. **Performance**
   - Carbon è ottimizzato per le operazioni sui giorni
   - Le traduzioni sono cached
   - Meno codice da mantenere

## Dettagli Implementazione

### Frontend
```php
// app/Enums/RegistrationStatus.php
enum RegistrationStatus: string
{
    case PENDING = 'pending';
    case APPROVED = 'approved';
    case REJECTED = 'rejected';
    case COMPLETED = 'completed';

    public function label(): string
    {
        return match($this) {
            self::PENDING => __('registration.status.pending'),
            self::APPROVED => __('registration.status.approved'),
            self::REJECTED => __('registration.status.rejected'),
            self::COMPLETED => __('registration.status.completed'),
        };
    }

    public function color(): string
    {
        return match($this) {
            self::PENDING => 'warning',
            self::APPROVED => 'success',
            self::REJECTED => 'danger',
            self::COMPLETED => 'info',
        };
    }

    public function icon(): string
    {
        return match($this) {
            self::PENDING => 'heroicon-o-clock',
            self::APPROVED => 'heroicon-o-check-circle',
            self::REJECTED => 'heroicon-o-x-circle',
            self::COMPLETED => 'heroicon-o-check-badge',
        };
    }
}

// app/Filament/Resources/DoctorRegistrationResource.php
class DoctorRegistrationResource extends XotBaseResource
{
    protected static ?string $model = DoctorRegistration::class;

    public static function getFormSchema(): array
    {
        return [
            'first_name' => TextInput::make('first_name')
                ->required()
                ->maxLength(255),
            'last_name' => TextInput::make('last_name')
                ->required()
                ->maxLength(255),
            'email' => TextInput::make('email')
                ->email()
                ->required()
                ->maxLength(255),
            'phone' => TextInput::make('phone')
                ->tel()
                ->required()
                ->maxLength(255),
            'identity_document' => FileUpload::make('identity_document')
                ->required()
                ->acceptedFileTypes(['application/pdf'])
                ->maxSize(5120),
            'degree_document' => FileUpload::make('degree_document')
                ->required()
                ->acceptedFileTypes(['application/pdf'])
                ->maxSize(5120),
            'status' => Select::make('status')
                ->options(RegistrationStatus::class)
                ->required(),
            'terms_accepted' => Toggle::make('terms_accepted')
                ->required(),
            'privacy_accepted' => Toggle::make('privacy_accepted')
                ->required(),
        ];
    }

    public static function getTableColumns(): array
    {
        return [
            'id' => TextColumn::make('id')
                ->sortable(),
            'full_name' => TextColumn::make('full_name')
                ->searchable(['first_name', 'last_name'])
                ->sortable(),
            'email' => TextColumn::make('email')
                ->searchable()
                ->sortable(),
            'status' => TextColumn::make('status')
                ->badge()
                ->color(fn (RegistrationStatus $state): string => $state->color())
                ->icon(fn (RegistrationStatus $state): string => $state->icon()),
            'created_at' => TextColumn::make('created_at')
                ->dateTime()
                ->sortable(),
        ];
    }

    public static function getRelations(): array
    {
        return [
            'moderator' => BelongsTo::make('moderator', User::class),
        ];
    }
}
```

### Backend
```php
// app/Actions/ProcessDoctorRegistration.php
class ProcessDoctorRegistration
{
    use QueueableAction;

    public function __construct(
        public array $data
    ) {}

    public function handle()
    {
        // Validazione dati
        $this->validateData();

        // Creazione registrazione
        $registration = DoctorRegistration::create([
            'first_name' => $this->data['first_name'],
            'last_name' => $this->data['last_name'],
            'email' => $this->data['email'],
            'phone' => $this->data['phone'],
            'identity_document_path' => $this->data['identity_document'],
            'degree_document_path' => $this->data['degree_document'],
            'status' => RegistrationStatus::PENDING,
            'terms_accepted' => true,
            'privacy_accepted' => true,
        ]);

        // Notifica moderatori
        $this->recordNotification($registration);

        // Email conferma
        $this->sendConfirmationEmail($registration);

        return $registration;
    }

    private function recordNotification($registration)
    {
        Notification::create([
            'type' => 'registration',
            'notifiable_type' => DoctorRegistration::class,
            'notifiable_id' => $registration->id,
            'data' => [
                'message' => __('notifications.registration.submitted', [
                    'type' => __('doctor.registration.type'),
                    'name' => $registration->full_name,
                ]),
                'action_url' => route('admin.doctor-registrations.show', $registration),
                'status' => $registration->status->value,
                'color' => $registration->status->color(),
                'icon' => $registration->status->icon(),
            ],
        ]);
    }
}
```

### Modelli
```php
// app/Models/DoctorRegistration.php
class DoctorRegistration extends Model
{
    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'phone',
        'identity_document_path',
        'degree_document_path',
        'status',
        'terms_accepted',
        'privacy_accepted',
        'approved_by',
        'approved_at',
        'completion_token',
        'completed_at',
    ];

    protected $casts = [
        'terms_accepted' => 'boolean',
        'privacy_accepted' => 'boolean',
        'approved_at' => 'datetime',
        'completed_at' => 'datetime',
        'status' => RegistrationStatus::class,
    ];

    public function moderator()
    {
        return $this->belongsTo(User::class, 'approved_by');
    }

    public function getFullNameAttribute(): string
    {
        return "{$this->first_name} {$this->last_name}";
    }

    public function getStatusLabel(): string
    {
        return $this->status->label();
    }

    public function getStatusColor(): string
    {
        return $this->status->color();
    }

    public function getStatusIcon(): string
    {
        return $this->status->icon();
    }
}
```

### Traduzioni
```php
// resources/lang/it/registration.php
return [
    'status' => [
        'pending' => 'In attesa',
        'approved' => 'Approvato',
        'rejected' => 'Rifiutato',
        'completed' => 'Completato',
    ],
];

// resources/lang/it/notifications.php
return [
    'registration' => [
        'submitted' => 'Nuova registrazione :type per :name',
        'approved' => 'Registrazione :type approvata per :name',
        'rejected' => 'Registrazione :type rifiutata per :name',
        'completed' => 'Registrazione :type completata per :name',
    ],
];

// resources/lang/it/doctor.php
return [
    'registration' => [
        'type' => 'Odontoiatra',
        'steps' => [
            'personal' => 'Dati Personali',
            'documents' => 'Documenti',
            'confirm' => 'Conferma',
        ],
    ],
];
```

## Test Implementati
- ✅ Test registrazione iniziale
- ✅ Test upload documenti
- ✅ Test moderazione
- ✅ Test wizard completamento
- ✅ Test notifiche
- ✅ Test integrazione

## Metriche
- Tempo registrazione: < 5 min
- Tasso completamento: 85%
- Tasso approvazione: 90%
- Tempo moderazione: < 24h

## Documenti Correlati
- [Gestione Medici](./15-gestione-medici.md)
- [Sistema Notifiche](./28-sistema-notifiche.md)
- [Gestione Documenti](./20-gestione-documenti.md)

## Note
- Conformità normativa
- Verifica documenti
- Audit trail
- Log completo
- Backup dati
- Performance monitoring
- Analytics registrazioni
- Report periodici

## Link al Codice
- [DoctorRegistrationResource](app/Filament/Resources/DoctorRegistrationResource.php)
- [DoctorRegistrationWizard](app/Filament/Pages/DoctorRegistrationWizard.php)
- [ProcessDoctorRegistration](app/Actions/ProcessDoctorRegistration.php)
- [ApproveDoctorRegistration](app/Actions/ApproveDoctorRegistration.php)
- [DoctorRegistration Model](app/Models/DoctorRegistration.php)

## Politica di Moderazione
1. **Criteri di Approvazione**
   - Documenti validi e leggibili
   - Titolo di studio riconosciuto
   - Nessuna segnalazione precedente
   - Conformità normativa

2. **Processo di Verifica**
   - Controllo documenti identità
   - Verifica titolo di studio
   - Ricerca in database ordini
   - Controllo eventuali segnalazioni

3. **Tempi di Risposta**
   - Prima verifica: 24h
   - Approvazione: 48h
   - Completamento: 7 giorni

4. **Gestione Rifiuti**
   - Comunicazione motivata
   - Possibilità di ricorso
   - Archiviazione documentazione
   - Tracciamento decisioni

## Relazioni e Dipendenze
1. **Sistema Utenti**
   - Integrazione con autenticazione
   - Gestione ruoli e permessi
   - Profili utente

2. **Gestione Documenti**
   - Upload e verifica
   - Archiviazione sicura
   - Conformità GDPR

3. **Sistema Notifiche**
   - Email di conferma
   - Notifiche moderazione
   - Promemoria completamento

4. **Gestione Medici**
   - Profilo professionale
   - Disponibilità
   - Tariffe

## Zen e Best Practices
1. **Semplicità**
   - Processo chiaro e lineare
   - Interfaccia intuitiva
   - Feedback immediato

2. **Sicurezza**
   - Validazione robusta
   - Protezione dati
   - Audit completo

3. **Manutenibilità**
   - Codice modulare
   - Test automatizzati
   - Documentazione completa

4. **Scalabilità**
   - Architettura flessibile
   - Performance ottimizzata
   - Monitoraggio continuo

### 5. Flusso Email e Completamento Registrazione

#### 5.1 Notifiche Implementate
```php
// /laravel/Modules/Patient/app/Notifications/DoctorRegistrationPendingNotification.php
class DoctorRegistrationPendingNotification extends Notification
{
    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject('Registrazione in Attesa di Moderazione')
            ->greeting('Gentile ' . $notifiable->first_name)
            ->line('La tua registrazione è stata ricevuta e sarà esaminata al più presto.')
            ->line('Riceverai un\'email quando la registrazione sarà approvata.')
            ->line('Grazie per la pazienza.');
    }
}

// /laravel/Modules/Patient/app/Notifications/DoctorRegistrationApprovedNotification.php
class DoctorRegistrationApprovedNotification extends Notification
{
    public function __construct(private string $token)
    {}

    public function toMail($notifiable)
    {
        $url = route('filament.pages.complete-doctor-registration', [
            'token' => $this->token,
            'email' => $notifiable->email
        ]);

        return (new MailMessage)
            ->subject('Registrazione Approvata')
            ->greeting('Gentile ' . $notifiable->first_name)
            ->line('La tua registrazione è stata approvata.')
            ->line('Per completare la registrazione, clicca sul pulsante qui sotto.')
            ->action('Completa la Registrazione', $url)
            ->line('Il link scadrà tra 7 giorni.')
            ->line('Se non hai richiesto tu questa registrazione, ignora questa email.');
    }
}
```

#### 5.2 Punti di Invio Email

1. **Dopo la Registrazione Iniziale**
   ```php
   // /laravel/Modules/Patient/app/Actions/ProcessDoctorRegistration.php
   class ProcessDoctorRegistration
   {
       public function handle(array $data)
       {
           $registration = DoctorRegistration::create([
               'first_name' => $data['first_name'],
               'last_name' => $data['last_name'],
               'email' => $data['email'],
               'phone' => $data['phone'],
               'status' => RegistrationStatus::PENDING,
           ]);

           // Invio email di attesa moderazione
           $registration->notify(new DoctorRegistrationPendingNotification());

           return $registration;
       }
   }
   ```

2. **Dopo l'Approvazione da parte del Moderatore**
   ```php
   // /laravel/Modules/Patient/app/Actions/ApproveDoctorRegistration.php
   class ApproveDoctorRegistration
   {
       public function handle(DoctorRegistration $registration)
       {
           // Transizione dello stato
           $registration->status->transitionTo(RegistrationStatus::APPROVED);
           
           // Generazione token di completamento
           $token = Str::random(64);
           $registration->update([
               'completion_token' => $token,
               'approved_at' => now(),
           ]);
           
           // Invio email con link per completamento
           $registration->notify(new DoctorRegistrationApprovedNotification($token));
       }
   }
   ```

#### 5.3 Gestione Token e Sicurezza

1. **Generazione Token**
   - Token generato con `Str::random(64)`
   - Memorizzato nel campo `completion_token`
   - Associato all'email del dottore

2. **Validazione Token**
   ```php
   // /laravel/Modules/Patient/app/Filament/Pages/CompleteDoctorRegistration.php
   class CompleteDoctorRegistration extends Page
   {
       public function mount($token, $email)
       {
           $registration = DoctorRegistration::where('completion_token', $token)
               ->where('email', $email)
               ->where('status', RegistrationStatus::APPROVED)
               ->where('approved_at', '>=', now()->subDays(7))
               ->firstOrFail();

           $this->form->fill($registration->toArray());
       }
   }
   ```

3. **Sicurezza**
   - Token valido solo per 7 giorni
   - Token associato all'email specifica
   - Token valido solo per registrazioni approvate
   - Token monouso (invalidato dopo il completamento)

#### 5.4 Template Email
```php
// /laravel/Modules/Patient/resources/views/emails/doctor-registration-approved.blade.php
@component('mail::message')

# Registrazione Approvata

Gentile {{ $notifiable->first_name }},

La tua registrazione è stata approvata. Per completare la registrazione, clicca sul pulsante qui sotto.

@component('mail::button', ['url' => $url])
Completa la Registrazione
@endcomponent

Il link scadrà tra 7 giorni.

Se non hai richiesto tu questa registrazione, ignora questa email.

Grazie,<br>
{{ config('app.name') }}
@endcomponent
```
