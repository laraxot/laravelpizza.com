# Registrazione Dentista: Flusso Completo (Parte 1)

## Panoramica del Processo

Il processo di registrazione dei dentisti nel portale <nome progetto> segue un flusso specifico progettato per garantire sicurezza, verificabilità e facilità d'uso. Questo documento descrive in dettaglio l'implementazione tecnica, seguendo le best practices e l'architettura del progetto.

![Diagramma Flusso Registrazione](/var/www/html/<nome progetto>/docs/images/flusso-registrazione-dentista.png)

## Filosofia e Principi Guida

### Principi Fondamentali

1. **Verifica progressiva dell'identità**: Prima i dati basilari, poi la verifica dell'identità e solo dopo richiediamo informazioni complete
2. **Minimizzazione della frizione**: Le barriere all'ingresso sono ridotte al minimo iniziale necessario
3. **Processo guidato**: Il dentista viene accompagnato passo dopo passo
4. **Fiducia bidirezionale**: Il sistema verifica l'identità del dentista, il dentista riceve conferma dell'affidabilità del sistema

### Zen della Registrazione

La filosofia sottostante è quella del "momento giusto": ogni informazione viene richiesta solo quando è effettivamente necessaria, evitando sovraccarichi cognitivi e migliorando l'esperienza utente. Il processo è scandito da momenti di attesa consapevole, che permettono sia al sistema che al dentista di prepararsi per i passi successivi.

## Architettura Tecnica

L'implementazione segue rigorosamente l'architettura di <nome progetto>:

1. **Widget Filament** per tutti i form e le interfacce utente
2. **QueueableAction** per tutte le operazioni di business logic
3. **Enum** per tutte le opzioni fisse e stati
4. **Records** per la struttura dati
5. **Traduzioni** gestite tramite LangServiceProvider
6. **RecordNotification** per le notifiche multi-canale

### 1. Enums per Stati Verifica

```php
<?php

declare(strict_types=1);

namespace Modules\Dental\Enums;

enum VerificationStatus: string
{
    case PENDING = 'pending';
    case APPROVED = 'approved';
    case REJECTED = 'rejected';
    case REQUIRES_ADDITIONAL_INFO = 'requires_additional_info';
}
```

### 2. Models per la Gestione Dati

```php
<?php

declare(strict_types=1);

namespace Modules\Dental\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Modules\Dental\Enums\VerificationStatus;
use Modules\Tenant\Traits\BelongsToTenant;
use Modules\Xot\Models\BaseModel;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class DentistVerification extends BaseModel implements HasMedia
{
    use BelongsToTenant;
    use InteractsWithMedia;

    protected $fillable = [
        'dentist_id',
        'status',
        'submitted_at',
        'approved_at',
        'approved_by',
        'rejected_at',
        'rejected_by',
        'rejection_reason',
        'note',
    ];

    protected $casts = [
        'status' => VerificationStatus::class,
        'submitted_at' => 'datetime',
        'approved_at' => 'datetime',
        'rejected_at' => 'datetime',
    ];

    public function dentist(): BelongsTo
    {
        return $this->belongsTo(Dentist::class);
    }

    public function approver(): BelongsTo
    {
        return $this->belongsTo(User::class, 'approved_by');
    }

    public function rejector(): BelongsTo
    {
        return $this->belongsTo(User::class, 'rejected_by');
    }

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('identity_documents')
            ->singleFile()
            ->acceptsMimeTypes(['application/pdf', 'image/jpeg', 'image/png']);

        $this->addMediaCollection('license_documents')
            ->singleFile()
            ->acceptsMimeTypes(['application/pdf', 'image/jpeg', 'image/png']);

        $this->addMediaCollection('declarations')
            ->singleFile()
            ->acceptsMimeTypes(['application/pdf']);
    }

    public function isPending(): bool
    {
        return $this->status === VerificationStatus::PENDING;
    }

    public function isApproved(): bool
    {
        return $this->status === VerificationStatus::APPROVED;
    }

    public function isRejected(): bool
    {
        return $this->status === VerificationStatus::REJECTED;
    }

    public function requiresAdditionalInfo(): bool
    {
        return $this->status === VerificationStatus::REQUIRES_ADDITIONAL_INFO;
    }
}
```

## Fase 1: Registrazione Iniziale

### 1.1 Widget di Registrazione Iniziale

```php
<?php

declare(strict_types=1);

namespace Modules\Dental\Filament\Widgets;

use Filament\Forms;
use Modules\Dental\Actions\Dentist\RegisterDentistAction;
use Modules\Dental\Datas\DentistRegistrationData;
use Modules\Xot\Filament\Widgets\XotBaseWidget;

class DentistRegistrationWidget extends XotBaseWidget
{
    protected static string $view = 'dental::widgets.dentist-registration';

    public function getFormSchema(): array
    {
        return [
            'personal_info' => Forms\Components\Section::make()
                ->schema([
                    'first_name' => Forms\Components\TextInput::make('first_name')
                        ->required()
                        ->maxLength(255),
                        
                    'last_name' => Forms\Components\TextInput::make('last_name')
                        ->required()
                        ->maxLength(255),
                        
                    'fiscal_code' => Forms\Components\TextInput::make('fiscal_code')
                        ->required()
                        ->unique('dentists', 'fiscal_code')
                        ->maxLength(16),
                        
                    'email' => Forms\Components\TextInput::make('email')
                        ->email()
                        ->required()
                        ->unique('dentists', 'email')
                        ->maxLength(255),
                        
                    'phone' => Forms\Components\TextInput::make('phone')
                        ->tel()
                        ->maxLength(20),
                ]),
                
            'professional_info' => Forms\Components\Section::make()
                ->schema([
                    'license_number' => Forms\Components\TextInput::make('license_number')
                        ->required()
                        ->maxLength(50),
                        
                    'license_issue_date' => Forms\Components\DatePicker::make('license_issue_date')
                        ->required(),
                        
                    'license_authority' => Forms\Components\TextInput::make('license_authority')
                        ->required()
                        ->maxLength(255),
                ]),
                
            'documents' => Forms\Components\Section::make()
                ->schema([
                    'identity_document' => Forms\Components\FileUpload::make('identity_document')
                        ->required()
                        ->acceptedFileTypes(['application/pdf', 'image/jpeg', 'image/png'])
                        ->maxSize(5120) // 5MB max
                        ->disk('dentist_documents'),
                        
                    'license_document' => Forms\Components\FileUpload::make('license_document')
                        ->required()
                        ->acceptedFileTypes(['application/pdf', 'image/jpeg', 'image/png'])
                        ->maxSize(5120)
                        ->disk('dentist_documents'),
                        
                    'self_declaration' => Forms\Components\FileUpload::make('self_declaration')
                        ->required()
                        ->acceptedFileTypes(['application/pdf'])
                        ->maxSize(5120)
                        ->disk('dentist_documents'),
                        
                    'privacy_consent' => Forms\Components\Checkbox::make('privacy_consent')
                        ->required()
                        ->accepted(),
                ]),
        ];
    }
    
    public function register(): void
    {
        $data = $this->form->getState();
        $data = DentistRegistrationData::from($data);
        
        // Utilizzo dell'action queueable per la registrazione
        app(RegisterDentistAction::class)->handle($data);
        
        // Reindirizzamento alla pagina di conferma
        redirect()->route('dentist.registration.confirmation');
    }
}
```

### 1.2 Data Transfer Object per la Registrazione

```php
<?php

declare(strict_types=1);

namespace Modules\Dental\Datas;

use Illuminate\Http\UploadedFile;
use Spatie\LaravelData\Data;

class DentistRegistrationData extends Data
{
    public function __construct(
        public readonly string $first_name,
        public readonly string $last_name,
        public readonly string $fiscal_code,
        public readonly string $email,
        public readonly ?string $phone,
        public readonly string $license_number,
        public readonly string $license_issue_date,
        public readonly string $license_authority,
        public readonly UploadedFile $identity_document,
        public readonly UploadedFile $license_document,
        public readonly UploadedFile $self_declaration,
        public readonly bool $privacy_consent,
    ) {}
}
```

### 1.3 Action di Registrazione

```php
<?php

declare(strict_types=1);

namespace Modules\Dental\Actions\Dentist;

use Illuminate\Support\Facades\Hash;
use Modules\Dental\Datas\DentistRegistrationData;
use Modules\Dental\Enums\VerificationStatus;
use Modules\Dental\Models\Dentist;
use Modules\Dental\Models\DentistVerification;
use Spatie\QueueableAction\QueueableAction;

class RegisterDentistAction
{
    use QueueableAction;

    public function __construct(
        protected readonly CreateUserForDentistAction $createUserAction,
        protected readonly SendRegistrationNotificationAction $sendNotificationAction
    ) {}
    
    public function handle(DentistRegistrationData $data): Dentist
    {
        // Creare un utente (senza inviargli credenziali di accesso)
        $user = $this->createUserAction->handle(
            $data->first_name,
            $data->last_name,
            $data->email,
            Hash::make(str_random(16)), // Password temporanea
            false // Non attivo fino alla verifica
        );
        
        // Creare il profilo dentista
        $dentist = Dentist::create([
            'user_id' => $user->id,
            'first_name' => $data->first_name,
            'last_name' => $data->last_name,
            'fiscal_code' => $data->fiscal_code,
            'email' => $data->email,
            'phone' => $data->phone,
            'license_number' => $data->license_number,
            'license_issue_date' => $data->license_issue_date,
            'license_authority' => $data->license_authority,
            'is_active' => false,
        ]);
        
        // Creare una richiesta di verifica
        $verification = DentistVerification::create([
            'dentist_id' => $dentist->id,
            'status' => VerificationStatus::PENDING,
            'submitted_at' => now(),
        ]);
        
        // Gestire i documenti caricati
        $this->handleDocumentUploads($verification, $data);
        
        // Notificare il dentista della ricezione
        $this->sendNotificationAction->handle($dentist, 'dentist_registration_received');
        
        // Notificare gli amministratori della nuova richiesta
        $this->notifyAdmins($dentist);
        
        return $dentist;
    }
    
    protected function handleDocumentUploads(DentistVerification $verification, DentistRegistrationData $data): void
    {
        // Gestione upload documenti con Spatie MediaLibrary
        $verification->addMedia($data->identity_document)
            ->usingName('Documento di identità')
            ->toMediaCollection('identity_documents');
        
        $verification->addMedia($data->license_document)
            ->usingName('Documento di iscrizione Albo')
            ->toMediaCollection('license_documents');
        
        $verification->addMedia($data->self_declaration)
            ->usingName('Autocertificazione')
            ->toMediaCollection('declarations');
    }
    
    protected function notifyAdmins(Dentist $dentist): void
    {
        // Notifica agli amministratori della nuova richiesta
        // Implementazione tramite canale appropriato
    }
}
```

### 1.4 File di Traduzione per la Fase di Registrazione

```php
// Modules/Dental/lang/it/dentist.php
return [
    'fields' => [
        'first_name' => [
            'label' => 'Nome',
            'placeholder' => 'Inserisci il tuo nome',
            'help' => 'Il tuo nome anagrafico',
        ],
        'last_name' => [
            'label' => 'Cognome',
            'placeholder' => 'Inserisci il tuo cognome',
            'help' => 'Il tuo cognome anagrafico',
        ],
        'fiscal_code' => [
            'label' => 'Codice Fiscale',
            'placeholder' => 'Inserisci il tuo codice fiscale',
            'help' => 'Il tuo codice fiscale italiano',
        ],
        'email' => [
            'label' => 'Email',
            'placeholder' => 'Inserisci la tua email',
            'help' => 'La tua email professionale',
        ],
        'phone' => [
            'label' => 'Telefono',
            'placeholder' => 'Inserisci il tuo numero di telefono',
            'help' => 'Il tuo numero di telefono professionale',
        ],
        'license_number' => [
            'label' => 'Numero Iscrizione Albo',
            'placeholder' => 'Inserisci il numero di iscrizione',
            'help' => 'Il tuo numero di iscrizione all\'Albo degli Odontoiatri',
        ],
        'license_issue_date' => [
            'label' => 'Data Iscrizione',
            'placeholder' => 'Seleziona la data di iscrizione',
            'help' => 'La data di prima iscrizione all\'Albo',
        ],
        'license_authority' => [
            'label' => 'Ordine di Iscrizione',
            'placeholder' => 'Es. Ordine dei Medici di Roma',
            'help' => 'L\'Ordine presso cui sei iscritto',
        ],
        'identity_document' => [
            'label' => 'Documento d\'Identità',
            'placeholder' => 'Carica documento',
            'help' => 'Carta d\'identità, patente o passaporto in corso di validità',
        ],
        'license_document' => [
            'label' => 'Certificato Iscrizione Albo',
            'placeholder' => 'Carica certificato',
            'help' => 'Certificato di iscrizione all\'Albo degli Odontoiatri',
        ],
        'self_declaration' => [
            'label' => 'Autocertificazione',
            'placeholder' => 'Carica autocertificazione',
            'help' => 'Autocertificazione di adesione al progetto <nome progetto>',
        ],
        'privacy_consent' => [
            'label' => 'Consenso Privacy',
            'help' => 'Accetto i termini e le condizioni e l\'informativa sulla privacy',
        ],
    ],
    'sections' => [
        'personal_info' => [
            'label' => 'Informazioni Personali',
            'description' => 'Inserisci i tuoi dati anagrafici',
        ],
        'professional_info' => [
            'label' => 'Informazioni Professionali',
            'description' => 'Inserisci i tuoi dati professionali',
        ],
        'documents' => [
            'label' => 'Documentazione',
            'description' => 'Carica i documenti richiesti',
        ],
    ],
    'buttons' => [
        'register' => [
            'label' => 'Registrati',
        ],
        'next' => [
            'label' => 'Avanti',
        ],
        'back' => [
            'label' => 'Indietro',
        ],
    ],
];
```

## Sistema di Verifica e Validazione

La verifica dell'identità e dei documenti caricati si basa su:

1. **Verifica documento identità**: Il documento caricato viene verificato per leggibilità e validità
2. **Verifica iscrizione Albo**: Il numero di iscrizione all'Albo viene verificato contro i database ufficiali
3. **Verifica autocertificazione**: Il documento di autocertificazione viene controllato per completezza
4. **Controllo incrociato**: I dati forniti vengono confrontati per coerenza

Ogni fase genera una reportistica completa disponibile agli amministratori nel backoffice.

### Interfaccia di Conferma di Ricezione Documenti

![Interfaccia Conferma](/var/www/html/<nome progetto>/docs/images/conferma-ricezione-dentista.png)

Dopo l'invio della documentazione, il dentista riceve una conferma visuale e via email che include:

1. Un riepilogo dei documenti inviati
2. Una stima dei tempi di verifica
3. Istruzioni su cosa aspettarsi nei passaggi successivi
4. Contatti per eventuale assistenza
