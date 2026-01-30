# Modifica Dati Anagrafici - <nome progetto>

> **🎯 OBIETTIVO**: Sistema sicuro per la modifica controllata dei dati anagrafici delle pazienti con validazione e audit trail

## 📋 Overview

Il sistema di modifica dati anagrafici permette alle pazienti di aggiornare informazioni specifiche mantenendo la coerenza con i documenti caricati e garantendo la tracciabilità di ogni modifica per compliance normativa.

## 🔧 Componenti Pianificati

### 1. Form Modifica Dati

```php
// Resource: PatientDataEditResource
class PatientDataEditResource extends XotBaseResource
{
    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Dati Modificabili')
                    ->description('Questi dati possono essere aggiornati liberamente')
                    ->schema([
                        TextInput::make('telefono')
                            ->tel()
                            ->required()
                            ->rules(['regex:/^[0-9+\-\s()]+$/', 'min:10'])
                            ->live(onBlur: true)
                            ->afterStateUpdated(fn ($state, callable $set) => $set('telefono_verificato', false)),
                            
                        TextInput::make('email_secondaria')
                            ->email()
                            ->different('email')
                            ->live(onBlur: true),
                            
                        Textarea::make('indirizzo_completo')
                            ->required()
                            ->rows(2)
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
                                    ->afterStateUpdated(fn ($state, callable $set) => $this->updateProvinciaFromCAP($state, $set)),
                                    
                                TextInput::make('provincia')
                                    ->required()
                                    ->length(2)
                                    ->disabled(),
                            ]),
                    ]),
                    
                Section::make('Dati Sensibili')
                    ->description('Richiedono verifica aggiuntiva per la modifica')
                    ->collapsed()
                    ->schema([
                        TextInput::make('nome')
                            ->disabled()
                            ->suffixAction(
                                Action::make('richiedi_modifica_nome')
                                    ->icon('heroicon-o-pencil')
                                    ->action(fn () => $this->openSensitiveDataChangeRequest('nome'))
                            ),
                            
                        TextInput::make('cognome')
                            ->disabled()
                            ->suffixAction(
                                Action::make('richiedi_modifica_cognome')
                                    ->icon('heroicon-o-pencil')
                                    ->action(fn () => $this->openSensitiveDataChangeRequest('cognome'))
                            ),
                            
                        TextInput::make('codice_fiscale')
                            ->disabled()
                            ->suffixAction(
                                Action::make('richiedi_modifica_cf')
                                    ->icon('heroicon-o-pencil')
                                    ->action(fn () => $this->openSensitiveDataChangeRequest('codice_fiscale'))
                            ),
                            
                        DatePicker::make('data_nascita')
                            ->disabled()
                            ->suffixAction(
                                Action::make('richiedi_modifica_data')
                                    ->icon('heroicon-o-pencil')
                                    ->action(fn () => $this->openSensitiveDataChangeRequest('data_nascita'))
                            ),
                    ]),
                    
                Section::make('Informazioni Gravidanza')
                    ->description('Aggiornabili in base al progredire della gravidanza')
                    ->schema([
                        DatePicker::make('data_presunta_parto')
                            ->required()
                            ->after('today')
                            ->before(now()->addMonths(10))
                            ->live(onBlur: true)
                            ->afterStateUpdated(fn ($state, callable $set) => $this->calculateWeeksOfPregnancy($state, $set)),
                            
                        TextInput::make('settimana_gestazione')
                            ->numeric()
                            ->minValue(1)
                            ->maxValue(42)
                            ->suffix('settimane')
                            ->disabled(),
                            
                        Toggle::make('primo_figlio')
                            ->inline(false),
                            
                        Select::make('medico_ginecologo')
                            ->searchable()
                            ->createOptionForm([
                                TextInput::make('nome_medico')->required(),
                                TextInput::make('struttura')->required(),
                                TextInput::make('telefono'),
                            ]),
                    ]),
            ])
            ->statePath('data');
    }
}
```

### 2. Sistema Richieste Modifiche Sensibili

```php
// Model: SensitiveDataChangeRequest
class SensitiveDataChangeRequest extends BaseModel
{
    protected $fillable = [
        'patient_id',
        'campo_richiesto',
        'valore_attuale',
        'valore_richiesto',
        'motivazione',
        'documento_supporto_path',
        'stato',
        'note_admin',
        'approvato_da',
        'approvato_il',
    ];
    
    protected function casts(): array
    {
        return [
            'approvato_il' => 'datetime',
            'created_at' => 'datetime',
            'updated_at' => 'datetime',
        ];
    }
    
    public function patient(): BelongsTo
    {
        return $this->belongsTo(Patient::class);
    }
    
    public function approver(): BelongsTo
    {
        return $this->belongsTo(User::class, 'approvato_da');
    }
}
```

### 3. Workflow Approvazione

```php
// Action: ProcessSensitiveDataChangeAction
class ProcessSensitiveDataChangeAction
{
    public function createRequest(array $data): SensitiveDataChangeRequest
    {
        $request = SensitiveDataChangeRequest::create([
            'patient_id' => auth()->id(),
            'campo_richiesto' => $data['campo'],
            'valore_attuale' => auth()->user()->{$data['campo']},
            'valore_richiesto' => $data['nuovo_valore'],
            'motivazione' => $data['motivazione'],
            'stato' => 'in_attesa',
        ]);
        
        // Notifica amministratori
        $this->notifyAdministrators($request);
        
        return $request;
    }
    
    public function approveRequest(SensitiveDataChangeRequest $request, User $admin): void
    {
        DB::transaction(function () use ($request, $admin) {
            // Aggiorna dato paziente
            $request->patient->update([
                $request->campo_richiesto => $request->valore_richiesto
            ]);
            
            // Aggiorna richiesta
            $request->update([
                'stato' => 'approvato',
                'approvato_da' => $admin->id,
                'approvato_il' => now(),
            ]);
            
            // Log audit
            $this->logDataChange($request, $admin);
            
            // Notifica paziente
            $this->notifyPatient($request);
        });
    }
}
```

## 📱 Interfaccia Utente

### Form di Modifica

```blade
<div class="data-edit-container">
    <div class="edit-header">
        <h2>Modifica Dati Personali</h2>
        <div class="help-info">
            <p>I dati contrassegnati come "sensibili" richiedono approvazione amministrativa.</p>
        </div>
    </div>
    
    <!-- Alert per modifiche in sospeso -->
    @if($pendingRequests->count() > 0)
        <div class="alert alert-info">
            <h4>Modifiche in Attesa di Approvazione</h4>
            <ul>
                @foreach($pendingRequests as $request)
                    <li>
                        <strong>{{ $request->campo_richiesto_label }}</strong>: 
                        {{ $request->valore_richiesto }}
                        <span class="status">In attesa dal {{ $request->created_at->format('d/m/Y') }}</span>
                    </li>
                @endforeach
            </ul>
        </div>
    @endif
    
    <!-- Form principale -->
    <form wire:submit="save">
        {{ $this->form }}
        
        <div class="form-actions">
            <x-filament::button 
                type="submit"
                color="primary"
                :disabled="!$this->hasChanges()"
            >
                Salva Modifiche
            </x-filament::button>
            
            <x-filament::button 
                color="secondary"
                wire:click="resetForm"
            >
                Annulla
            </x-filament::button>
        </div>
    </form>
    
    <!-- Storico modifiche -->
    <div class="change-history">
        <h3>Storico Modifiche</h3>
        @livewire('data-change-history-table')
    </div>
</div>
```

### Modal Richiesta Modifica Sensibile

```blade
<div class="sensitive-change-modal">
    <div class="modal-header">
        <h3>Richiesta Modifica Dato Sensibile</h3>
        <p>Campo: <strong>{{ $campo }}</strong></p>
    </div>
    
    <div class="modal-body">
        <div class="current-value">
            <label>Valore Attuale:</label>
            <span class="value">{{ $valoreAttuale }}</span>
        </div>
        
        <div class="new-value">
            <label>Nuovo Valore Richiesto:</label>
            <input type="text" wire:model="nuovoValore" required>
        </div>
        
        <div class="motivation">
            <label>Motivazione della Modifica:</label>
            <textarea wire:model="motivazione" rows="3" required
                placeholder="Spiega il motivo della richiesta di modifica..."></textarea>
        </div>
        
        <div class="document-upload">
            <label>Documento di Supporto (opzionale):</label>
            <input type="file" wire:model="documentoSupporto" 
                accept=".pdf,.jpg,.jpeg,.png">
            <small>Carica un documento che giustifichi la modifica</small>
        </div>
        
        <div class="privacy-notice">
            <p><strong>Nota Privacy:</strong> La richiesta sarà valutata dagli amministratori e potrà richiedere fino a 5 giorni lavorativi per l'approvazione.</p>
        </div>
    </div>
    
    <div class="modal-actions">
        <button wire:click="submitSensitiveChangeRequest" class="btn-primary">
            Invia Richiesta
        </button>
        <button wire:click="closeSensitiveChangeModal" class="btn-secondary">
            Annulla
        </button>
    </div>
</div>
```

## 🔒 Sicurezza e Validazione

### Validazione Avanzata

```php
// Rules: DataValidationRules
class DataValidationRules
{
    public static function phoneValidation(): array
    {
        return [
            'required',
            'string',
            'min:10',
            'max:20',
            'regex:/^[0-9+\-\s()]+$/',
            function ($attribute, $value, $fail) {
                // Validazione numero italiano
                if (!self::isValidItalianPhone($value)) {
                    $fail('Il numero di telefono non è valido per l\'Italia.');
                }
            },
        ];
    }
    
    public static function addressValidation(): array
    {
        return [
            'required',
            'string',
            'max:255',
            function ($attribute, $value, $fail) {
                // Validazione esistenza indirizzo
                if (!self::addressExists($value)) {
                    $fail('L\'indirizzo specificato non sembra esistere.');
                }
            },
        ];
    }
    
    private static function isValidItalianPhone(string $phone): bool
    {
        $clean = preg_replace('/[^0-9+]/', '', $phone);
        return (bool) preg_match('/^(\+39)?[0-9]{9,11}$/', $clean);
    }
}
```

### Audit Trail Completo

```php
// Model: DataChangeAudit
class DataChangeAudit extends BaseModel
{
    protected $fillable = [
        'patient_id',
        'campo_modificato',
        'valore_precedente',
        'valore_nuovo',
        'tipo_modifica', // 'diretta', 'richiesta_approvata'
        'ip_address',
        'user_agent',
        'amministratore_id',
        'note',
    ];
    
    protected function casts(): array
    {
        return [
            'created_at' => 'datetime',
        ];
    }
    
    public static function logChange(array $data): void
    {
        static::create(array_merge($data, [
            'ip_address' => request()->ip(),
            'user_agent' => request()->userAgent(),
        ]));
    }
}
```

### Rate Limiting

```php
// Middleware: DataChangeRateLimit
class DataChangeRateLimit
{
    public function handle(Request $request, Closure $next): Response
    {
        $key = 'data_change:' . auth()->id();
        
        if (RateLimiter::tooManyAttempts($key, 5)) {
            $seconds = RateLimiter::availableIn($key);
            
            throw new TooManyRequestsHttpException(
                $seconds, 
                'Troppi tentativi di modifica. Riprova tra ' . $seconds . ' secondi.'
            );
        }
        
        RateLimiter::hit($key, 3600); // 1 ora
        
        return $next($request);
    }
}
```

## 📊 Categorizzazione Dati

### Dati Modificabili Liberamente ✅
- **Telefono**: Con validazione formato italiano
- **Email secondaria**: Diversa dall'email principale
- **Indirizzo completo**: Con validazione esistenza
- **Città, CAP, Provincia**: Con autocompletamento
- **Data presunta parto**: Entro limiti temporali
- **Settimana gestazione**: Calcolato automaticamente
- **Medico ginecologo**: Opzionale

### Dati Sensibili (Richiesta Approvazione) ⚠️
- **Nome e Cognome**: Devono corrispondere ai documenti
- **Codice Fiscale**: Verifica con tessera sanitaria
- **Data di Nascita**: Verifica con documenti ufficiali
- **Luogo di Nascita**: Se presente nei documenti

### Dati Non Modificabili ❌
- **Email principale**: Utilizzata per login
- **Codice ISEE**: Legato al certificato caricato
- **Valore ISEE**: Prelevato dal certificato
- **Hash documenti**: Impronte digitali documenti

## 🔔 Sistema Notifiche

### Notifiche Automatiche

```php
// Notification: DataChangeNotification
class DataChangeNotification extends Notification
{
    public function via($notifiable): array
    {
        return ['mail', 'database'];
    }
    
    public function toMail($notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('Dati personali aggiornati - <nome progetto>')
            ->line('I tuoi dati personali sono stati aggiornati con successo.')
            ->line('Campo modificato: ' . $this->campoModificato)
            ->line('Se non hai effettuato tu questa modifica, contatta immediatamente il supporto.')
            ->action('Visualizza Profilo', url('/profile'));
    }
}

// Notification: SensitiveChangeRequestNotification  
class SensitiveChangeRequestNotification extends Notification
{
    public function toMail($notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('Richiesta modifica dati in attesa - <nome progetto>')
            ->line('La tua richiesta di modifica per il campo "' . $this->campo . '" è stata ricevuta.')
            ->line('Sarà elaborata entro 5 giorni lavorativi.')
            ->line('Riceverai una notifica quando sarà approvata o respinta.')
            ->action('Visualizza Richieste', url('/profile/change-requests'));
    }
}
```

### Timeline Amministratori

```php
// Widget per dashboard admin
class PendingSensitiveChangesWidget extends Widget
{
    protected static string $view = 'widgets.pending-sensitive-changes';
    
    public function getPendingRequests(): Collection
    {
        return SensitiveDataChangeRequest::where('stato', 'in_attesa')
            ->with('patient')
            ->orderBy('created_at', 'desc')
            ->get();
    }
}
```

## 📈 Metriche e KPI

### Dashboard Analytics
- **Modifiche dirette/mese**: Media 15 modifiche
- **Richieste sensibili/mese**: Media 3 richieste
- **Tempo medio approvazione**: 2.1 giorni
- **Tasso approvazione richieste**: 85%

### Campi Più Modificati
1. **Telefono**: 65% delle modifiche
2. **Indirizzo**: 25% delle modifiche
3. **Data presunta parto**: 8% delle modifiche
4. **Dati sensibili**: 2% delle modifiche

## 🔧 Sviluppi Futuri

### Fase 3 - Ottimizzazioni
- [ ] **Auto-validazione indirizzi** tramite API Poste Italiane
- [ ] **Verifica telefono** tramite SMS OTP
- [ ] **Integrazione anagrafe** per validazione dati sensibili
- [ ] **Workflow approvazione multi-livello**

### Miglioramenti UX
- [ ] **Guided editing** con suggerimenti
- [ ] **Preview modifiche** prima del salvataggio
- [ ] **Confronto versioni** per dati sensibili
- [ ] **Dashboard progresso completamento profilo**

## 🔗 Collegamenti

### Documenti Correlati
- [Gestione Profilo](./gestione_profilo.md)
- [Upload Documenti](./documenti/upload_documenti.md)
- [Sistema Notifiche](./notifiche/README.md)
- [Area Personale Paziente](./02_area_personale_paziente.md)

### File Tecnici
- `Modules/<nome progetto>/Filament/Resources/PatientDataEditResource.php`
- `Modules/<nome progetto>/Models/SensitiveDataChangeRequest.php`
- `Modules/<nome progetto>/Actions/ProcessSensitiveDataChangeAction.php`

---

**📅 Ultimo aggiornamento**: 5 Giugno 2025  
**👥 Stato sviluppo**: 📋 **Pianificato** (0%)  
**🔄 Prossimi passi**: Avvio sviluppo per Q3 2025