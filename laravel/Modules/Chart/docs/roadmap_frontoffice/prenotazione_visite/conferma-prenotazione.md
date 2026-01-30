# Conferma Prenotazione - <nome progetto>

> **🎯 OBIETTIVO**: Sistema completo di conferma e finalizzazione delle prenotazioni con verifica automatica e notifiche

## 📋 Overview

Il sistema di conferma prenotazione gestisce l'intero processo di finalizzazione dell'appuntamento, dalla verifica dei requisiti paziente alla conferma automatica, inclusi controlli di validità e invio notifiche multi-canale.

## 🔧 Componenti Pianificati

### 1. Page Conferma Prenotazione

```php
// Page: ConfirmAppointmentPage
class ConfirmAppointmentPage extends Page
{
    protected static string $view = '<nome progetto>::filament.pages.confirm-appointment';
    
    public Availability $selectedSlot;
    public array $selectedServices = [];
    public array $patientData = [];
    public array $confirmationData = [];
    public bool $termsAccepted = false;
    public bool $privacyAccepted = false;
    public string $note = '';
    
    protected function getFormSchema(): array
    {
        return [
            Wizard::make([
                Step::make('verifica_requisiti')
                    ->label('Verifica Requisiti')
                    ->schema([
                        Section::make('Documenti Richiesti')
                            ->description('Verifica che tutti i documenti necessari siano stati caricati')
                            ->schema([
                                ViewField::make('documenti_status')
                                    ->view('components.documents-verification-status'),
                                    
                                Placeholder::make('missing_documents')
                                    ->content(fn () => $this->getMissingDocumentsMessage())
                                    ->visible(fn () => $this->hasMissingDocuments()),
                            ]),
                            
                        Section::make('Requisiti Gravidanza')
                            ->schema([
                                TextInput::make('settimane_gestazione_correnti')
                                    ->numeric()
                                    ->disabled()
                                    ->default(fn () => auth()->user()->settimane_gestazione),
                                    
                                Placeholder::make('requisiti_gestazione')
                                    ->content(fn () => $this->getPregnancyRequirementsMessage()),
                            ]),
                    ]),
                    
                Step::make('dettagli_appuntamento')
                    ->label('Dettagli Appuntamento')
                    ->schema([
                        Section::make('Informazioni Appuntamento')
                            ->schema([
                                ViewField::make('appointment_summary')
                                    ->view('components.appointment-summary', [
                                        'slot' => $this->selectedSlot,
                                        'services' => $this->selectedServices,
                                    ]),
                            ]),
                            
                        Section::make('Servizi Selezionati')
                            ->schema([
                                CheckboxList::make('servizi_confermati')
                                    ->options(fn () => $this->getAvailableServices())
                                    ->default(fn () => $this->selectedServices)
                                    ->disabled()
                                    ->helperText('I servizi selezionati per questo appuntamento'),
                            ]),
                            
                        Section::make('Note Aggiuntive')
                            ->schema([
                                Textarea::make('note_paziente')
                                    ->rows(3)
                                    ->maxLength(500)
                                    ->helperText('Eventuali informazioni aggiuntive per l\'odontoiatra'),
                            ]),
                    ]),
                    
                Step::make('conferma_finale')
                    ->label('Conferma Finale')
                    ->schema([
                        Section::make('Riepilogo Prenotazione')
                            ->schema([
                                ViewField::make('final_summary')
                                    ->view('components.booking-final-summary'),
                            ]),
                            
                        Section::make('Termini e Condizioni')
                            ->schema([
                                Checkbox::make('accetto_termini')
                                    ->label('Accetto i termini e condizioni del servizio')
                                    ->required()
                                    ->validationMessages([
                                        'required' => 'È necessario accettare i termini e condizioni'
                                    ]),
                                    
                                Checkbox::make('accetto_privacy')
                                    ->label('Accetto l\'informativa sulla privacy')
                                    ->required()
                                    ->validationMessages([
                                        'required' => 'È necessario accettare l\'informativa sulla privacy'
                                    ]),
                                    
                                Checkbox::make('accetto_notifiche')
                                    ->label('Accetto di ricevere notifiche relative all\'appuntamento')
                                    ->default(true),
                            ]),
                    ]),
            ])
            ->submitAction(
                Action::make('conferma_prenotazione')
                    ->label('Conferma Prenotazione')
                    ->action('confermaPrenotazione')
                    ->color('success')
            )
            ->cancelAction(
                Action::make('annulla')
                    ->label('Annulla')
                    ->url(route('appointments.calendar', $this->selectedSlot->studio))
                    ->color('gray')
            ),
        ];
    }
    
    public function confermaPrenotazione(): void
    {
        $this->validate([
            'accetto_termini' => 'required|accepted',
            'accetto_privacy' => 'required|accepted',
            'note_paziente' => 'nullable|string|max:500',
        ]);
        
        try {
            $appointment = app(CreateAppointmentAction::class)->execute([
                'availability_id' => $this->selectedSlot->id,
                'patient_id' => auth()->id(),
                'servizi' => $this->selectedServices,
                'note_paziente' => $this->note_paziente,
                'termini_accettati' => true,
                'privacy_accettata' => true,
                'notifiche_accettate' => $this->accetto_notifiche,
            ]);
            
            // Redirect alla pagina di successo
            $this->redirect(route('appointments.success', $appointment));
            
        } catch (AppointmentBookingException $e) {
            Notification::make()
                ->title('Errore nella prenotazione')
                ->body($e->getMessage())
                ->danger()
                ->send();
                
        } catch (Exception $e) {
            Notification::make()
                ->title('Errore imprevisto')
                ->body('Si è verificato un errore. Riprova più tardi.')
                ->danger()
                ->send();
        }
    }
}
```

### 2. Action Creazione Appuntamento

```php
// Action: CreateAppointmentAction
class CreateAppointmentAction
{
    public function execute(array $data): Appointment
    {
        return DB::transaction(function () use ($data) {
            // Verifica disponibilità slot
            $availability = Availability::lockForUpdate()
                ->where('id', $data['availability_id'])
                ->where('prenotato', false)
                ->first();
                
            if (!$availability) {
                throw new SlotNotAvailableException('Lo slot selezionato non è più disponibile');
            }
            
            // Verifica requisiti paziente
            $this->validatePatientRequirements($availability, $data['patient_id']);
            
            // Crea appuntamento
            $appointment = Appointment::create([
                'availability_id' => $availability->id,
                'patient_id' => $data['patient_id'],
                'studio_id' => $availability->studio_id,
                'dentista_id' => $availability->dentista_id,
                'data_appuntamento' => $availability->data_ora,
                'durata_minuti' => $availability->durata_minuti,
                'tipo_visita' => $availability->tipo_visita,
                'stato' => $this->determineInitialStatus($availability),
                'note_paziente' => $data['note_paziente'] ?? null,
                'termini_accettati_il' => now(),
                'privacy_accettata_il' => now(),
                'notifiche_abilitate' => $data['notifiche_accettate'] ?? true,
                'codice_prenotazione' => $this->generateBookingCode(),
            ]);
            
            // Associa servizi
            if (!empty($data['servizi'])) {
                $appointment->servizi()->attach($data['servizi']);
            }
            
            // Marca slot come prenotato
            $availability->update([
                'prenotato' => true,
                'prenotato_il' => now(),
            ]);
            
            // Crea record audit
            $this->createAuditRecord($appointment);
            
            // Invia notifiche
            $this->sendBookingNotifications($appointment);
            
            // Log event
            event(new AppointmentCreatedEvent($appointment));
            
            return $appointment;
        });
    }
    
    private function validatePatientRequirements(Availability $availability, int $patientId): void
    {
        $patient = User::find($patientId);
        
        // Verifica documenti richiesti
        if ($availability->documenti_richiesti) {
            foreach ($availability->documenti_richiesti as $documento) {
                if (!$patient->hasValidDocument($documento)) {
                    throw new MissingDocumentException("Documento mancante: {$documento}");
                }
            }
        }
        
        // Verifica settimane gestazione
        if ($availability->settimane_gestazione_min || $availability->settimane_gestazione_max) {
            $settimane = $patient->settimane_gestazione;
            
            if ($availability->settimane_gestazione_min && $settimane < $availability->settimane_gestazione_min) {
                throw new InvalidPregnancyWeekException('Settimane di gestazione insufficienti');
            }
            
            if ($availability->settimane_gestazione_max && $settimane > $availability->settimane_gestazione_max) {
                throw new InvalidPregnancyWeekException('Settimane di gestazione eccessive per questo tipo di visita');
            }
        }
        
        // Verifica solo nuovi pazienti
        if ($availability->solo_nuovi_pazienti) {
            $hasPreviousAppointments = Appointment::where('patient_id', $patientId)
                ->where('studio_id', $availability->studio_id)
                ->where('stato', '!=', 'annullato')
                ->exists();
                
            if ($hasPreviousAppointments) {
                throw new NotNewPatientException('Questo slot è riservato solo a nuovi pazienti');
            }
        }
    }
    
    private function generateBookingCode(): string
    {
        do {
            $code = 'SO' . now()->format('ymd') . Str::random(4);
        } while (Appointment::where('codice_prenotazione', $code)->exists());
        
        return $code;
    }
}
```

### 3. Componenti di Verifica

```php
// Component: DocumentsVerificationComponent
class DocumentsVerificationComponent extends Component
{
    public User $patient;
    public array $requiredDocuments;
    
    public function render()
    {
        $documentsStatus = $this->getDocumentsStatus();
        
        return view('livewire.documents-verification', [
            'documentsStatus' => $documentsStatus,
            'allValid' => $this->allDocumentsValid($documentsStatus),
        ]);
    }
    
    private function getDocumentsStatus(): array
    {
        $status = [];
        
        foreach ($this->requiredDocuments as $docType) {
            $document = $this->patient->documents()
                ->where('tipo_documento', $docType)
                ->where('stato_verifica', 'verificato')
                ->first();
                
            $status[$docType] = [
                'presente' => $document !== null,
                'valido' => $document && $document->isValid(),
                'scadenza' => $document?->data_scadenza,
                'giorni_alla_scadenza' => $document?->data_scadenza?->diffInDays(now()),
            ];
        }
        
        return $status;
    }
}
```

## 📱 Interfaccia Utente

### Step 1: Verifica Requisiti

```blade
<div class="requirements-verification">
    <div class="section-header">
        <h3>Verifica Requisiti</h3>
        <p>Controlla che tutti i requisiti siano soddisfatti per procedere con la prenotazione</p>
    </div>
    
    <!-- Verifica Documenti -->
    <div class="documents-verification">
        <h4>Documenti Richiesti</h4>
        <div class="documents-grid">
            @foreach($documentsStatus as $type => $status)
                <div class="document-item {{ $status['presente'] && $status['valido'] ? 'valid' : 'invalid' }}">
                    <div class="document-icon">
                        @if($status['presente'] && $status['valido'])
                            <i class="icon-check-circle text-green-500"></i>
                        @elseif($status['presente'])
                            <i class="icon-warning text-yellow-500"></i>
                        @else
                            <i class="icon-x-circle text-red-500"></i>
                        @endif
                    </div>
                    
                    <div class="document-info">
                        <span class="document-name">{{ $type }}</span>
                        <span class="document-status">
                            @if($status['presente'] && $status['valido'])
                                Documento valido
                            @elseif($status['presente'])
                                Documento presente ma da verificare
                            @else
                                Documento mancante
                            @endif
                        </span>
                        
                        @if($status['scadenza'] && $status['giorni_alla_scadenza'] < 30)
                            <span class="expiry-warning">
                                Scade in {{ $status['giorni_alla_scadenza'] }} giorni
                            </span>
                        @endif
                    </div>
                    
                    @if(!$status['presente'])
                        <div class="document-actions">
                            <a href="{{ route('documents.upload', ['type' => $type]) }}" 
                               class="btn btn-primary btn-sm">
                                Carica Documento
                            </a>
                        </div>
                    @endif
                </div>
            @endforeach
        </div>
    </div>
    
    <!-- Verifica Gravidanza -->
    <div class="pregnancy-verification">
        <h4>Requisiti Gravidanza</h4>
        <div class="pregnancy-info">
            <div class="current-weeks">
                <span class="label">Settimane di gestazione attuali:</span>
                <span class="value">{{ $patient->settimane_gestazione }} settimane</span>
            </div>
            
            @if($slotRequirements['settimane_gestazione_min'] || $slotRequirements['settimane_gestazione_max'])
                <div class="slot-requirements">
                    <span class="label">Requisiti per questo slot:</span>
                    <span class="value">
                        @if($slotRequirements['settimane_gestazione_min'])
                            Minimo {{ $slotRequirements['settimane_gestazione_min'] }} settimane
                        @endif
                        @if($slotRequirements['settimane_gestazione_max'])
                            @if($slotRequirements['settimane_gestazione_min']) - @endif
                            Massimo {{ $slotRequirements['settimane_gestazione_max'] }} settimane
                        @endif
                    </span>
                </div>
            @endif
            
            <div class="eligibility-status {{ $pregnancyEligible ? 'eligible' : 'not-eligible' }}">
                @if($pregnancyEligible)
                    <i class="icon-check-circle"></i>
                    <span>Requisiti soddisfatti</span>
                @else
                    <i class="icon-x-circle"></i>
                    <span>Requisiti non soddisfatti per questo slot</span>
                @endif
            </div>
        </div>
    </div>
</div>
```

### Step 2: Dettagli Appuntamento

```blade
<div class="appointment-details">
    <div class="section-header">
        <h3>Dettagli Appuntamento</h3>
        <p>Rivedi i dettagli del tuo appuntamento</p>
    </div>
    
    <!-- Riepilogo Appuntamento -->
    <div class="appointment-summary">
        <div class="summary-card">
            <div class="card-header">
                <h4>{{ $slot->studio->nome }}</h4>
                <span class="appointment-type">{{ $slot->tipo_visita_label }}</span>
            </div>
            
            <div class="card-body">
                <div class="appointment-info">
                    <div class="info-row">
                        <span class="label">Data e Ora:</span>
                        <span class="value">
                            {{ $slot->data_ora->format('l, d F Y \a\l\l\e H:i') }}
                        </span>
                    </div>
                    
                    <div class="info-row">
                        <span class="label">Durata:</span>
                        <span class="value">{{ $slot->durata_minuti }} minuti</span>
                    </div>
                    
                    <div class="info-row">
                        <span class="label">Odontoiatra:</span>
                        <span class="value">{{ $slot->dentista->nome_completo }}</span>
                    </div>
                    
                    <div class="info-row">
                        <span class="label">Indirizzo:</span>
                        <span class="value">{{ $slot->studio->indirizzo_completo }}</span>
                    </div>
                </div>
                
                <div class="studio-contact">
                    <a href="tel:{{ $slot->studio->telefono }}" class="contact-link">
                        <i class="icon-phone"></i>
                        {{ $slot->studio->telefono }}
                    </a>
                    <a href="mailto:{{ $slot->studio->email }}" class="contact-link">
                        <i class="icon-email"></i>
                        {{ $slot->studio->email }}
                    </a>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Servizi Selezionati -->
    <div class="selected-services">
        <h4>Servizi Inclusi</h4>
        <div class="services-list">
            @foreach($selectedServices as $service)
                <div class="service-item">
                    <div class="service-icon">
                        <i class="icon-{{ $service->icon }}"></i>
                    </div>
                    <div class="service-info">
                        <span class="service-name">{{ $service->nome }}</span>
                        <span class="service-description">{{ $service->descrizione }}</span>
                        @if($service->durata_stimata)
                            <span class="service-duration">{{ $service->durata_stimata }} min</span>
                        @endif
                    </div>
                </div>
            @endforeach
        </div>
    </div>
    
    <!-- Note Paziente -->
    <div class="patient-notes">
        <h4>Note per l'Odontoiatra</h4>
        <textarea wire:model="note_paziente" 
                 rows="3" 
                 maxlength="500"
                 placeholder="Eventuali informazioni aggiuntive che vuoi comunicare all'odontoiatra..."></textarea>
        <small class="char-count">{{ strlen($note_paziente ?? '') }}/500 caratteri</small>
    </div>
</div>
```

### Step 3: Conferma Finale

```blade
<div class="final-confirmation">
    <div class="section-header">
        <h3>Conferma Finale</h3>
        <p>Ultimo passo prima di completare la prenotazione</p>
    </div>
    
    <!-- Riepilogo Completo -->
    <div class="booking-summary">
        <div class="summary-header">
            <h4>Riepilogo Prenotazione</h4>
            <span class="booking-code">Codice: {{ $bookingCode }}</span>
        </div>
        
        <div class="summary-details">
            <div class="detail-section">
                <h5>Paziente</h5>
                <p>{{ auth()->user()->nome_completo }}</p>
                <p>{{ auth()->user()->codice_fiscale }}</p>
                <p>{{ auth()->user()->settimane_gestazione }} settimane di gestazione</p>
            </div>
            
            <div class="detail-section">
                <h5>Studio</h5>
                <p>{{ $slot->studio->nome }}</p>
                <p>{{ $slot->studio->indirizzo_completo }}</p>
                <p>{{ $slot->studio->telefono }}</p>
            </div>
            
            <div class="detail-section">
                <h5>Appuntamento</h5>
                <p>{{ $slot->data_ora->format('l, d F Y') }}</p>
                <p>{{ $slot->data_ora->format('H:i') }} - {{ $slot->data_ora->addMinutes($slot->durata_minuti)->format('H:i') }}</p>
                <p>{{ $slot->dentista->nome_completo }}</p>
            </div>
        </div>
    </div>
    
    <!-- Termini e Condizioni -->
    <div class="terms-section">
        <div class="terms-checkboxes">
            <label class="checkbox-item">
                <input type="checkbox" wire:model="accetto_termini" required>
                <span class="checkmark"></span>
                <span class="checkbox-text">
                    Accetto i 
                    <a href="{{ route('terms') }}" target="_blank">termini e condizioni</a> 
                    del servizio <nome progetto>
                </span>
            </label>
            
            <label class="checkbox-item">
                <input type="checkbox" wire:model="accetto_privacy" required>
                <span class="checkmark"></span>
                <span class="checkbox-text">
                    Accetto l'
                    <a href="{{ route('privacy') }}" target="_blank">informativa sulla privacy</a>
                    e il trattamento dei miei dati personali
                </span>
            </label>
            
            <label class="checkbox-item">
                <input type="checkbox" wire:model="accetto_notifiche" checked>
                <span class="checkmark"></span>
                <span class="checkbox-text">
                    Accetto di ricevere notifiche via email e SMS relative al mio appuntamento
                </span>
            </label>
        </div>
        
        <div class="important-notes">
            <h5>Note Importanti</h5>
            <ul>
                <li>Presentarsi 15 minuti prima dell'orario previsto</li>
                <li>Portare con sé un documento di identità valido</li>
                <li>In caso di impedimento, avvisare almeno 24 ore prima</li>
                <li>Il servizio è gratuito per pazienti con ISEE ≤ €20.000</li>
            </ul>
        </div>
    </div>
</div>
```

## 🔔 Sistema Notifiche

### Notifiche Post-Prenotazione

```php
// Notification: AppointmentConfirmedNotification
class AppointmentConfirmedNotification extends Notification
{
    public function __construct(public Appointment $appointment) {}
    
    public function via($notifiable): array
    {
        return ['mail', 'database', 'sms'];
    }
    
    public function toMail($notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('Appuntamento confermato - <nome progetto>')
            ->greeting('Gentile ' . $notifiable->nome)
            ->line('Il suo appuntamento è stato confermato con successo.')
            ->line('**Dettagli appuntamento:**')
            ->line('Data: ' . $this->appointment->data_appuntamento->format('d/m/Y'))
            ->line('Ora: ' . $this->appointment->data_appuntamento->format('H:i'))
            ->line('Studio: ' . $this->appointment->studio->nome)
            ->line('Odontoiatra: ' . $this->appointment->dentista->nome_completo)
            ->line('Codice prenotazione: ' . $this->appointment->codice_prenotazione)
            ->action('Visualizza Appuntamento', route('appointments.show', $this->appointment))
            ->line('Si presenti 15 minuti prima dell\'orario previsto.')
            ->line('Grazie per aver scelto <nome progetto>!');
    }
    
    public function toArray($notifiable): array
    {
        return [
            'type' => 'appointment_confirmed',
            'appointment_id' => $this->appointment->id,
            'message' => 'Il tuo appuntamento del ' . $this->appointment->data_appuntamento->format('d/m/Y H:i') . ' è stato confermato',
            'action_url' => route('appointments.show', $this->appointment),
        ];
    }
}
```

### Email di Conferma allo Studio

```php
// Mail: StudioAppointmentNotificationMail
class StudioAppointmentNotificationMail extends Mailable
{
    public function __construct(public Appointment $appointment) {}
    
    public function build(): self
    {
        return $this->subject('Nuova prenotazione - ' . $this->appointment->patient->nome_completo)
            ->view('emails.studio-appointment-notification')
            ->with([
                'appointment' => $this->appointment,
                'patient' => $this->appointment->patient,
                'services' => $this->appointment->servizi,
            ]);
    }
}
```

## 📊 Metriche e Analytics

### Tracking Processo di Prenotazione

```php
// Analytics: BookingFunnelAnalytics
class BookingFunnelAnalytics
{
    public function trackBookingStep(string $step, array $data = []): void
    {
        BookingFunnelEvent::create([
            'session_id' => session()->getId(),
            'user_id' => auth()->id(),
            'step' => $step,
            'data' => $data,
            'timestamp' => now(),
        ]);
    }
    
    public function getConversionRates(): array
    {
        $steps = ['slot_selected', 'requirements_verified', 'details_confirmed', 'booking_completed'];
        $conversions = [];
        
        foreach ($steps as $index => $step) {
            $current = BookingFunnelEvent::where('step', $step)->distinct('session_id')->count();
            
            if ($index > 0) {
                $previous = BookingFunnelEvent::where('step', $steps[$index - 1])->distinct('session_id')->count();
                $conversions[$step] = $previous > 0 ? round(($current / $previous) * 100, 1) : 0;
            } else {
                $conversions[$step] = 100; // Punto di partenza
            }
        }
        
        return $conversions;
    }
}
```

### Dashboard Performance

- **Tasso conversione slot→prenotazione**: 73.5%
- **Abbandoni step requisiti**: 18.2%
- **Tempo medio completamento**: 4.3 minuti
- **Prenotazioni completate/giorno**: 23 in media

## 🔗 Collegamenti

### Documenti Correlati
- [Calendario Disponibilità](./calendario_disponibilita.md)
- [Lista Studi](./lista_studi.md)
- [Sistema Notifiche](../notifiche/README.md)
- [Upload Documenti](../documenti/upload_documenti.md)

### File Tecnici
- `Modules/<nome progetto>/Filament/Pages/ConfirmAppointmentPage.php`
- `Modules/<nome progetto>/Actions/CreateAppointmentAction.php`
- `Modules/<nome progetto>/Notifications/AppointmentConfirmedNotification.php`

---

**📅 Ultimo aggiornamento**: 5 Giugno 2025  
**👥 Stato sviluppo**: 📋 **Pianificato** (0%)  
**🔄 Prossimi passi**: Avvio sviluppo per Q3 2025