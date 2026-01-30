# Registrazione Studi Odontoiatrici - <nome progetto>

> **🎯 OBIETTIVO**: Sistema completo per la registrazione e verifica degli studi odontoiatrici al programma <nome progetto>

## 📋 Overview

Il sistema di registrazione studi gestisce l'intero processo di adesione al programma, dalla compilazione del modulo iniziale alla verifica documentale, con workflow di approvazione multi-step e integrazione automatica nel sistema di prenotazioni.

## 🔧 Componenti Implementati

### 1. Resource Registrazione Studio

```php
// Resource: StudioRegistrationResource
class StudioRegistrationResource extends XotBaseResource
{
    protected static ?string $model = StudioRegistration::class;
    
    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Wizard::make([
                    Step::make('informazioni_studio')
                        ->label('Informazioni Studio')
                        ->schema([
                            Section::make('Dati Studio')
                                ->schema([
                                    TextInput::make('nome_studio')
                                        ->required()
                                        ->maxLength(255)
                                        ->live(onBlur: true)
                                        ->afterStateUpdated(fn ($state, callable $set) => 
                                            $set('slug', Str::slug($state))),
                                            
                                    TextInput::make('partita_iva')
                                        ->required()
                                        ->length(11)
                                        ->numeric()
                                        ->unique(StudioRegistration::class, 'partita_iva')
                                        ->live(onBlur: true)
                                        ->afterStateUpdated(fn ($state, callable $set) => 
                                            $this->verificaPartitaIva($state, $set)),
                                            
                                    TextInput::make('codice_fiscale')
                                        ->required()
                                        ->length(16)
                                        ->unique(StudioRegistration::class, 'codice_fiscale'),
                                        
                                    TextInput::make('telefono')
                                        ->tel()
                                        ->required()
                                        ->rules(['regex:/^[0-9+\-\s()]+$/']),
                                        
                                    TextInput::make('email')
                                        ->email()
                                        ->required()
                                        ->unique(StudioRegistration::class, 'email'),
                                        
                                    TextInput::make('pec')
                                        ->email()
                                        ->helperText('Indirizzo PEC ufficiale dello studio'),
                                        
                                    TextInput::make('sito_web')
                                        ->url()
                                        ->helperText('Sito web ufficiale (opzionale)'),
                                ])->columns(2),
                                
                            Section::make('Indirizzo Studio')
                                ->schema([
                                    TextInput::make('indirizzo')
                                        ->required()
                                        ->maxLength(255),
                                        
                                    Grid::make(3)
                                        ->schema([
                                            TextInput::make('citta')
                                                ->required()
                                                ->maxLength(100),
                                                
                                            TextInput::make('cap')
                                                ->required()
                                                ->length(5)
                                                ->numeric()
                                                ->live(onBlur: true)
                                                ->afterStateUpdated(fn ($state, callable $set) => 
                                                    $this->updateProvinciaFromCAP($state, $set)),
                                                    
                                            TextInput::make('provincia')
                                                ->required()
                                                ->length(2)
                                                ->disabled(),
                                        ]),
                                        
                                    Toggle::make('sede_legale_diversa')
                                        ->live()
                                        ->helperText('Seleziona se la sede legale è diversa da quella operativa'),
                                        
                                    Group::make([
                                        TextInput::make('sede_legale_indirizzo')
                                            ->required(fn (Get $get) => $get('sede_legale_diversa')),
                                            
                                        Grid::make(3)
                                            ->schema([
                                                TextInput::make('sede_legale_citta')
                                                    ->required(fn (Get $get) => $get('sede_legale_diversa')),
                                                    
                                                TextInput::make('sede_legale_cap')
                                                    ->required(fn (Get $get) => $get('sede_legale_diversa'))
                                                    ->length(5)
                                                    ->numeric(),
                                                    
                                                TextInput::make('sede_legale_provincia')
                                                    ->required(fn (Get $get) => $get('sede_legale_diversa'))
                                                    ->length(2),
                                            ]),
                                    ])
                                    ->visible(fn (Get $get) => $get('sede_legale_diversa')),
                                ]),
                        ]),
                        
                    Step::make('responsabile_legale')
                        ->label('Responsabile Legale')
                        ->schema([
                            Section::make('Dati Responsabile')
                                ->schema([
                                    TextInput::make('responsabile_nome')
                                        ->required()
                                        ->maxLength(100),
                                        
                                    TextInput::make('responsabile_cognome')
                                        ->required()
                                        ->maxLength(100),
                                        
                                    TextInput::make('responsabile_codice_fiscale')
                                        ->required()
                                        ->length(16)
                                        ->unique(StudioRegistration::class, 'responsabile_codice_fiscale'),
                                        
                                    DatePicker::make('responsabile_data_nascita')
                                        ->required()
                                        ->before('18 years ago'),
                                        
                                    TextInput::make('responsabile_luogo_nascita')
                                        ->required()
                                        ->maxLength(100),
                                        
                                    Select::make('responsabile_qualifica')
                                        ->options([
                                            'titolare' => 'Titolare',
                                            'amministratore' => 'Amministratore',
                                            'legale_rappresentante' => 'Legale Rappresentante',
                                            'direttore_sanitario' => 'Direttore Sanitario',
                                        ])
                                        ->required(),
                                        
                                    TextInput::make('responsabile_telefono')
                                        ->tel()
                                        ->required(),
                                        
                                    TextInput::make('responsabile_email')
                                        ->email()
                                        ->required(),
                                ])->columns(2),
                        ]),
                        
                    Step::make('odontoiatri')
                        ->label('Odontoiatri')
                        ->schema([
                            Section::make('Odontoiatri dello Studio')
                                ->schema([
                                    Repeater::make('odontoiatri')
                                        ->schema([
                                            TextInput::make('nome')
                                                ->required()
                                                ->maxLength(100),
                                                
                                            TextInput::make('cognome')
                                                ->required()
                                                ->maxLength(100),
                                                
                                            TextInput::make('codice_fiscale')
                                                ->required()
                                                ->length(16),
                                                
                                            TextInput::make('numero_iscrizione_ordine')
                                                ->required()
                                                ->helperText('Numero iscrizione Ordine Medici'),
                                                
                                            Select::make('ordine_provinciale')
                                                ->options($this->getOrdiniProvinciali())
                                                ->required()
                                                ->searchable(),
                                                
                                            DatePicker::make('data_abilitazione')
                                                ->required()
                                                ->before('today'),
                                                
                                            CheckboxList::make('specializzazioni')
                                                ->options([
                                                    'odontoiatria_generale' => 'Odontoiatria Generale',
                                                    'ortodonzia' => 'Ortodonzia',
                                                    'endodonzia' => 'Endodonzia',
                                                    'parodontologia' => 'Parodontologia',
                                                    'chirurgia_orale' => 'Chirurgia Orale',
                                                    'odontoiatria_pediatrica' => 'Odontoiatria Pediatrica',
                                                    'protesi' => 'Protesi',
                                                ])
                                                ->columns(2),
                                                
                                            Toggle::make('direttore_sanitario')
                                                ->helperText('Questo odontoiatra è il direttore sanitario'),
                                                
                                            FileUpload::make('cv_documento')
                                                ->acceptedFileTypes(['application/pdf'])
                                                ->maxSize(5120)
                                                ->helperText('CV in formato PDF (max 5MB)'),
                                        ])
                                        ->columns(2)
                                        ->defaultItems(1)
                                        ->addActionLabel('Aggiungi Odontoiatra')
                                        ->minItems(1),
                                ]),
                        ]),
                        
                    Step::make('servizi_offerti')
                        ->label('Servizi Offerti')
                        ->schema([
                            Section::make('Tipologie di Servizi')
                                ->schema([
                                    CheckboxList::make('servizi_base')
                                        ->options([
                                            'prima_visita' => 'Prima Visita',
                                            'visite_controllo' => 'Visite di Controllo',
                                            'igiene_orale' => 'Igiene Orale',
                                            'detartrasi' => 'Detartrasi',
                                            'fluoroprofilassi' => 'Fluoroprofilassi',
                                        ])
                                        ->required()
                                        ->minItems(1)
                                        ->columns(2),
                                        
                                    CheckboxList::make('servizi_specialistici')
                                        ->options([
                                            'odontoiatria_conservativa' => 'Odontoiatria Conservativa',
                                            'endodonzia' => 'Endodonzia',
                                            'parodontologia' => 'Parodontologia',
                                            'chirurgia_orale' => 'Chirurgia Orale',
                                            'ortodonzia' => 'Ortodonzia',
                                            'protesi' => 'Protesi',
                                        ])
                                        ->columns(2),
                                        
                                    Textarea::make('note_servizi')
                                        ->rows(3)
                                        ->maxLength(500)
                                        ->helperText('Eventuali specifiche sui servizi offerti'),
                                ]),
                                
                            Section::make('Orari e Disponibilità')
                                ->schema([
                                    Repeater::make('orari_apertura')
                                        ->schema([
                                            Select::make('giorno')
                                                ->options([
                                                    'lunedi' => 'Lunedì',
                                                    'martedi' => 'Martedì',
                                                    'mercoledi' => 'Mercoledì',
                                                    'giovedi' => 'Giovedì',
                                                    'venerdi' => 'Venerdì',
                                                    'sabato' => 'Sabato',
                                                    'domenica' => 'Domenica',
                                                ])
                                                ->required(),
                                                
                                            TimePicker::make('apertura_mattina')
                                                ->seconds(false),
                                                
                                            TimePicker::make('chiusura_mattina')
                                                ->seconds(false),
                                                
                                            TimePicker::make('apertura_pomeriggio')
                                                ->seconds(false),
                                                
                                            TimePicker::make('chiusura_pomeriggio')
                                                ->seconds(false),
                                                
                                            Toggle::make('chiuso')
                                                ->helperText('Studio chiuso in questo giorno'),
                                        ])
                                        ->columns(3)
                                        ->defaultItems(7)
                                        ->addable(false)
                                        ->deletable(false),
                                ]),
                        ]),
                        
                    Step::make('documenti')
                        ->label('Documenti')
                        ->schema([
                            Section::make('Documenti Obbligatori')
                                ->description('Carica tutti i documenti richiesti per la verifica')
                                ->schema([
                                    FileUpload::make('visura_camerale')
                                        ->required()
                                        ->acceptedFileTypes(['application/pdf'])
                                        ->maxSize(10240)
                                        ->helperText('Visura camerale aggiornata (max 10MB)'),
                                        
                                    FileUpload::make('certificato_iscrizione_ordine')
                                        ->required()
                                        ->acceptedFileTypes(['application/pdf'])
                                        ->maxSize(5120)
                                        ->helperText('Certificato iscrizione Ordine Medici (max 5MB)'),
                                        
                                    FileUpload::make('polizza_assicurativa')
                                        ->required()
                                        ->acceptedFileTypes(['application/pdf'])
                                        ->maxSize(5120)
                                        ->helperText('Polizza assicurativa RC professionale (max 5MB)'),
                                        
                                    FileUpload::make('autorizzazione_sanitaria')
                                        ->required()
                                        ->acceptedFileTypes(['application/pdf'])
                                        ->maxSize(5120)
                                        ->helperText('Autorizzazione sanitaria ASL (max 5MB)'),
                                        
                                    FileUpload::make('documento_identita_responsabile')
                                        ->required()
                                        ->acceptedFileTypes(['application/pdf', 'image/jpeg', 'image/png'])
                                        ->maxSize(5120)
                                        ->helperText('Documento identità responsabile legale (max 5MB)'),
                                ])
                                ->columns(1),
                                
                            Section::make('Documenti Opzionali')
                                ->schema([
                                    FileUpload::make('certificazioni_qualita')
                                        ->multiple()
                                        ->acceptedFileTypes(['application/pdf'])
                                        ->maxSize(5120)
                                        ->helperText('Certificazioni di qualità (ISO, ecc.)'),
                                        
                                    FileUpload::make('foto_studio')
                                        ->multiple()
                                        ->acceptedFileTypes(['image/jpeg', 'image/png'])
                                        ->maxSize(2048)
                                        ->helperText('Foto dello studio (max 2MB ciascuna)'),
                                ])
                                ->columns(1),
                        ]),
                        
                    Step::make('accettazione')
                        ->label('Accettazione Termini')
                        ->schema([
                            Section::make('Termini e Condizioni')
                                ->schema([
                                    ViewField::make('termini_preview')
                                        ->view('components.terms-preview'),
                                        
                                    Checkbox::make('accetto_termini_programma')
                                        ->label('Accetto i termini e condizioni del programma <nome progetto>')
                                        ->required(),
                                        
                                    Checkbox::make('accetto_privacy')
                                        ->label('Accetto l\'informativa sulla privacy')
                                        ->required(),
                                        
                                    Checkbox::make('accetto_tariffario')
                                        ->label('Accetto il tariffario e le modalità di rimborso')
                                        ->required(),
                                        
                                    Checkbox::make('confermo_veridicita')
                                        ->label('Confermo la veridicità di tutte le informazioni fornite')
                                        ->required(),
                                        
                                    Checkbox::make('accetto_comunicazioni')
                                        ->label('Accetto di ricevere comunicazioni relative al programma')
                                        ->default(true),
                                ]),
                        ]),
                ])
                ->submitAction(
                    Action::make('invia_registrazione')
                        ->label('Invia Richiesta di Registrazione')
                        ->action('inviaRegistrazione')
                        ->color('success')
                )
            ]);
    }
}
```

### 2. Model StudioRegistration

```php
// Model: StudioRegistration
class StudioRegistration extends BaseModel
{
    protected $fillable = [
        'nome_studio',
        'partita_iva',
        'codice_fiscale',
        'telefono',
        'email',
        'pec',
        'sito_web',
        'indirizzo',
        'citta',
        'cap',
        'provincia',
        'sede_legale_diversa',
        'sede_legale_indirizzo',
        'sede_legale_citta',
        'sede_legale_cap',
        'sede_legale_provincia',
        'responsabile_nome',
        'responsabile_cognome',
        'responsabile_codice_fiscale',
        'responsabile_data_nascita',
        'responsabile_luogo_nascita',
        'responsabile_qualifica',
        'responsabile_telefono',
        'responsabile_email',
        'odontoiatri',
        'servizi_base',
        'servizi_specialistici',
        'note_servizi',
        'orari_apertura',
        'documenti_caricati',
        'stato',
        'note_verifica',
        'verificato_da',
        'verificato_il',
        'codice_registrazione',
    ];
    
    protected function casts(): array
    {
        return [
            'responsabile_data_nascita' => 'date',
            'odontoiatri' => 'array',
            'servizi_base' => 'array',
            'servizi_specialistici' => 'array',
            'orari_apertura' => 'array',
            'documenti_caricati' => 'array',
            'verificato_il' => 'datetime',
            'created_at' => 'datetime',
            'updated_at' => 'datetime',
        ];
    }
    
    public function verifier(): BelongsTo
    {
        return $this->belongsTo(User::class, 'verificato_da');
    }
    
    public function getStatoLabelAttribute(): string
    {
        return match($this->stato) {
            'in_attesa' => 'In Attesa di Verifica',
            'in_verifica' => 'In Verifica',
            'approvato' => 'Approvato',
            'rifiutato' => 'Rifiutato',
            'sospeso' => 'Sospeso',
            default => 'Sconosciuto'
        };
    }
    
    public function getTotalDocumentsCount(): int
    {
        return count($this->documenti_caricati ?? []);
    }
    
    public function getCompletionPercentage(): float
    {
        $requiredFields = [
            'nome_studio', 'partita_iva', 'email', 'telefono',
            'responsabile_nome', 'responsabile_cognome',
            'odontoiatri', 'servizi_base', 'orari_apertura'
        ];
        
        $filledFields = 0;
        foreach ($requiredFields as $field) {
            if (!empty($this->{$field})) {
                $filledFields++;
            }
        }
        
        return round(($filledFields / count($requiredFields)) * 100, 1);
    }
}
```

### 3. Action Verifica Registrazione

```php
// Action: ProcessStudioRegistrationAction
class ProcessStudioRegistrationAction
{
    public function execute(StudioRegistration $registration): void
    {
        DB::transaction(function () use ($registration) {
            // Genera codice registrazione unico
            $registration->update([
                'codice_registrazione' => $this->generateRegistrationCode(),
                'stato' => 'in_attesa',
            ]);
            
            // Crea notificazioni per amministratori
            $this->notifyAdministrators($registration);
            
            // Invia email di conferma ricezione
            Mail::to($registration->email)->send(
                new RegistrationReceivedMail($registration)
            );
            
            // Log evento
            activity()
                ->performedOn($registration)
                ->log('Nuova registrazione studio ricevuta');
        });
    }
    
    public function approve(StudioRegistration $registration, User $verifier, string $note = null): Studio
    {
        return DB::transaction(function () use ($registration, $verifier, $note) {
            // Crea studio attivo
            $studio = Studio::create([
                'nome' => $registration->nome_studio,
                'partita_iva' => $registration->partita_iva,
                'codice_fiscale' => $registration->codice_fiscale,
                'telefono' => $registration->telefono,
                'email' => $registration->email,
                'pec' => $registration->pec,
                'sito_web' => $registration->sito_web,
                'indirizzo_completo' => $this->formatAddress($registration),
                'citta' => $registration->citta,
                'cap' => $registration->cap,
                'provincia' => $registration->provincia,
                'servizi_offerti' => array_merge(
                    $registration->servizi_base ?? [],
                    $registration->servizi_specialistici ?? []
                ),
                'orari_apertura' => $registration->orari_apertura,
                'stato' => 'attivo',
                'data_attivazione' => now(),
            ]);
            
            // Crea odontoiatri associati
            foreach ($registration->odontoiatri ?? [] as $odontoiatraData) {
                $studio->dentisti()->create([
                    'nome' => $odontoiatraData['nome'],
                    'cognome' => $odontoiatraData['cognome'],
                    'codice_fiscale' => $odontoiatraData['codice_fiscale'],
                    'numero_iscrizione_ordine' => $odontoiatraData['numero_iscrizione_ordine'],
                    'ordine_provinciale' => $odontoiatraData['ordine_provinciale'],
                    'data_abilitazione' => $odontoiatraData['data_abilitazione'],
                    'specializzazioni' => $odontoiatraData['specializzazioni'] ?? [],
                    'is_direttore_sanitario' => $odontoiatraData['direttore_sanitario'] ?? false,
                    'stato' => 'attivo',
                ]);
            }
            
            // Aggiorna registrazione
            $registration->update([
                'stato' => 'approvato',
                'note_verifica' => $note,
                'verificato_da' => $verifier->id,
                'verificato_il' => now(),
            ]);
            
            // Notifica approvazione
            Mail::to($registration->email)->send(
                new RegistrationApprovedMail($registration, $studio)
            );
            
            return $studio;
        });
    }
}
```

## 📱 Interfaccia Frontend

### Landing Page Registrazione

```blade
<div class="registration-landing">
    <div class="hero-section">
        <div class="hero-content">
            <h1>Unisciti al Programma <nome progetto></h1>
            <p>Offri servizi odontoiatrici gratuiti a donne in gravidanza e contribuisci alla salute materno-infantile</p>
            
            <div class="benefits-grid">
                <div class="benefit-item">
                    <div class="benefit-icon">🏥</div>
                    <h3>Visibilità</h3>
                    <p>Aumenta la visibilità del tuo studio nella rete sanitaria territoriale</p>
                </div>
                
                <div class="benefit-item">
                    <div class="benefit-icon">💝</div>
                    <h3>Solidarietà</h3>
                    <p>Contribuisci a un importante progetto di solidarietà sociale</p>
                </div>
                
                <div class="benefit-item">
                    <div class="benefit-icon">📋</div>
                    <h3>Gestione Semplificata</h3>
                    <p>Piattaforma digitale per gestire facilmente le prenotazioni</p>
                </div>
                
                <div class="benefit-item">
                    <div class="benefit-icon">🔒</div>
                    <h3>Sicurezza</h3>
                    <p>Sistema sicuro e conforme alle normative sulla privacy</p>
                </div>
            </div>
            
            <div class="cta-section">
                <a href="{{ route('studios.registration.form') }}" class="btn btn-primary btn-large">
                    Inizia la Registrazione
                </a>
                <a href="{{ route('studios.registration.info') }}" class="btn btn-outline">
                    Maggiori Informazioni
                </a>
            </div>
        </div>
        
        <div class="hero-image">
            <img src="/images/dental-team.jpg" alt="Team odontoiatrico">
        </div>
    </div>
    
    <div class="process-section">
        <h2>Come Funziona la Registrazione</h2>
        <div class="process-steps">
            <div class="step">
                <div class="step-number">1</div>
                <h3>Compila il Modulo</h3>
                <p>Inserisci i dati del tuo studio e del team medico</p>
            </div>
            
            <div class="step">
                <div class="step-number">2</div>
                <h3>Carica i Documenti</h3>
                <p>Allega tutti i documenti richiesti per la verifica</p>
            </div>
            
            <div class="step">
                <div class="step-number">3</div>
                <h3>Verifica</h3>
                <p>Il nostro team verifica la documentazione (2-5 giorni lavorativi)</p>
            </div>
            
            <div class="step">
                <div class="step-number">4</div>
                <h3>Attivazione</h3>
                <p>Studio attivato e pronto a ricevere prenotazioni</p>
            </div>
        </div>
    </div>
</div>
```

### Form di Registrazione Progressivo

```blade
<div class="registration-form-container">
    <div class="form-header">
        <h2>Registrazione Studio Odontoiatrico</h2>
        <div class="progress-indicator">
            <div class="progress-bar">
                <div class="progress-fill" style="width: {{ $completionPercentage }}%"></div>
            </div>
            <span class="progress-text">{{ $completionPercentage }}% completato</span>
        </div>
    </div>
    
    <!-- Form Wizard -->
    <div class="wizard-container">
        {{ $this->form }}
    </div>
    
    <!-- Sidebar Info -->
    <div class="registration-sidebar">
        <div class="help-section">
            <h4>Hai bisogno di aiuto?</h4>
            <p>Il nostro team è disponibile per supportarti durante la registrazione.</p>
            <div class="contact-info">
                <p><strong>Email:</strong> supporto@<nome progetto>.it</p>
                <p><strong>Telefono:</strong> 800-123-456</p>
                <p><strong>Orari:</strong> Lun-Ven 9:00-18:00</p>
            </div>
        </div>
        
        <div class="requirements-section">
            <h4>Documenti Necessari</h4>
            <ul class="requirements-list">
                <li>Visura camerale aggiornata</li>
                <li>Certificato iscrizione Ordine Medici</li>
                <li>Polizza assicurativa RC professionale</li>
                <li>Autorizzazione sanitaria ASL</li>
                <li>Documento identità responsabile legale</li>
            </ul>
        </div>
        
        <div class="security-note">
            <h4>🔒 Sicurezza Garantita</h4>
            <p>Tutti i dati sono protetti con crittografia SSL e trattati secondo le normative GDPR.</p>
        </div>
    </div>
</div>
```

## 🔔 Sistema Notifiche

### Email Conferma Ricezione

```php
// Mail: RegistrationReceivedMail
class RegistrationReceivedMail extends Mailable
{
    public function __construct(public StudioRegistration $registration) {}
    
    public function build(): self
    {
        return $this->subject('Registrazione ricevuta - <nome progetto>')
            ->view('emails.registration-received')
            ->with([
                'studio' => $this->registration->nome_studio,
                'codice' => $this->registration->codice_registrazione,
                'completezza' => $this->registration->getCompletionPercentage(),
            ]);
    }
}
```

### Notifica Amministratori

```php
// Notification: NewStudioRegistrationNotification
class NewStudioRegistrationNotification extends Notification
{
    public function __construct(public StudioRegistration $registration) {}
    
    public function via($notifiable): array
    {
        return ['mail', 'database'];
    }
    
    public function toMail($notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('Nuova registrazione studio - ' . $this->registration->nome_studio)
            ->line('È stata ricevuta una nuova richiesta di registrazione.')
            ->line('Studio: ' . $this->registration->nome_studio)
            ->line('Codice: ' . $this->registration->codice_registrazione)
            ->line('Completezza: ' . $this->registration->getCompletionPercentage() . '%')
            ->action('Verifica Registrazione', route('admin.registrations.show', $this->registration))
            ->line('Richiede verifica e approvazione.');
    }
}
```

## 📊 Dashboard Amministrativa

### Widget Registrazioni Pending

```php
// Widget: PendingRegistrationsWidget
class PendingRegistrationsWidget extends Widget
{
    protected static string $view = 'widgets.pending-registrations';
    
    public function getPendingRegistrations(): Collection
    {
        return StudioRegistration::where('stato', 'in_attesa')
            ->orWhere('stato', 'in_verifica')
            ->orderBy('created_at', 'desc')
            ->limit(10)
            ->get();
    }
    
    public function getRegistrationStats(): array
    {
        return [
            'totali' => StudioRegistration::count(),
            'in_attesa' => StudioRegistration::where('stato', 'in_attesa')->count(),
            'approvate' => StudioRegistration::where('stato', 'approvato')->count(),
            'rifiutate' => StudioRegistration::where('stato', 'rifiutato')->count(),
        ];
    }
}
```

### Analytics Registrazioni

```php
// Analytics: RegistrationAnalytics
class RegistrationAnalytics
{
    public function getMonthlyRegistrations(): array
    {
        return StudioRegistration::selectRaw('
            DATE_FORMAT(created_at, "%Y-%m") as mese,
            COUNT(*) as registrazioni
        ')
        ->where('created_at', '>=', now()->subYear())
        ->groupBy('mese')
        ->orderBy('mese')
        ->get()
        ->toArray();
    }
    
    public function getAverageApprovalTime(): float
    {
        return StudioRegistration::where('stato', 'approvato')
            ->whereNotNull('verificato_il')
            ->selectRaw('AVG(DATEDIFF(verificato_il, created_at)) as media_giorni')
            ->value('media_giorni') ?? 0;
    }
    
    public function getCompletionRate(): float
    {
        $total = StudioRegistration::count();
        $completed = StudioRegistration::whereIn('stato', ['approvato', 'rifiutato'])->count();
        
        return $total > 0 ? round(($completed / $total) * 100, 1) : 0;
    }
}
```

## 🔗 Collegamenti

### Documenti Correlati
- [Dashboard Studio](./dashboard_studio.md)
- [Gestione Appuntamenti](./gestione_appuntamenti.md)
- [Area Odontoiatra](../04_area_odontoiatra.md)
- [Sistema Notifiche](../notifiche/README.md)

### File Tecnici
- `Modules/<nome progetto>/Filament/Resources/StudioRegistrationResource.php`
- `Modules/<nome progetto>/Models/StudioRegistration.php`
- `Modules/<nome progetto>/Actions/ProcessStudioRegistrationAction.php`

---

**📅 Ultimo aggiornamento**: 5 Giugno 2025  
**👥 Stato sviluppo**: ✅ **Completato** (100%)  
**🔄 Prossimi passi**: Ottimizzazioni workflow approvazione e automazione verifica documenti