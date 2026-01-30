# Gestione Appuntamenti - Area Odontoiatra <nome progetto>

> **🎯 OBIETTIVO**: Sistema completo per la gestione operativa degli appuntamenti da parte degli studi odontoiatrici

## 📋 Overview

La gestione appuntamenti per gli studi fornisce strumenti avanzati per visualizzare, modificare, confermare e gestire tutti gli aspetti degli appuntamenti programmati, con workflow ottimizzati per l'operatività quotidiana degli studi dentistici.

## 🔧 Componenti Implementati

### 1. Resource Gestione Appuntamenti Studio

```php
// Resource: StudioAppointmentResource
class StudioAppointmentResource extends XotBaseResource
{
    protected static ?string $model = Appointment::class;
    
    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->where('studio_id', Filament::getTenant()->id)
            ->with(['patient', 'dentista', 'servizi', 'availability']);
    }
    
    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Informazioni Appuntamento')
                    ->schema([
                        Select::make('patient_id')
                            ->relationship('patient', 'nome_completo')
                            ->searchable()
                            ->preload()
                            ->required()
                            ->live()
                            ->afterStateUpdated(fn ($state, callable $set) => 
                                $this->loadPatientData($state, $set)),
                                
                        Select::make('dentista_id')
                            ->relationship('dentista', 'nome_completo', fn (Builder $query) => 
                                $query->where('studio_id', Filament::getTenant()->id))
                            ->required()
                            ->live(),
                            
                        DateTimePicker::make('data_appuntamento')
                            ->required()
                            ->native(false)
                            ->displayFormat('d/m/Y H:i')
                            ->minDate(now())
                            ->live()
                            ->afterStateUpdated(fn ($state, callable $set) => 
                                $this->checkAvailability($state, $set)),
                                
                        TextInput::make('durata_minuti')
                            ->numeric()
                            ->required()
                            ->minValue(15)
                            ->maxValue(180)
                            ->step(15)
                            ->suffix('minuti'),
                    ])->columns(2),
                    
                Section::make('Dettagli Visita')
                    ->schema([
                        Select::make('tipo_visita')
                            ->options([
                                'prima_visita' => 'Prima Visita',
                                'controllo' => 'Controllo',
                                'igiene_orale' => 'Igiene Orale',
                                'urgenza' => 'Urgenza',
                                'specialistica' => 'Visita Specialistica',
                            ])
                            ->required()
                            ->live()
                            ->afterStateUpdated(fn ($state, callable $set) => 
                                $this->updateDefaultDuration($state, $set)),
                                
                        Select::make('stato')
                            ->options([
                                'confermato' => 'Confermato',
                                'in_attesa_conferma' => 'In Attesa Conferma',
                                'in_corso' => 'In Corso',
                                'completato' => 'Completato',
                                'annullato' => 'Annullato',
                                'no_show' => 'No Show',
                                'rinviato' => 'Rinviato',
                            ])
                            ->required()
                            ->default('confermato'),
                            
                        Select::make('priorita')
                            ->options([
                                'bassa' => 'Bassa',
                                'normale' => 'Normale',
                                'alta' => 'Alta',
                                'urgente' => 'Urgente',
                            ])
                            ->default('normale'),
                            
                        CheckboxList::make('servizi')
                            ->relationship('servizi', 'nome')
                            ->searchable()
                            ->columns(2),
                    ])->columns(2),
                    
                Section::make('Note e Comunicazioni')
                    ->schema([
                        Textarea::make('note_paziente')
                            ->rows(2)
                            ->disabled()
                            ->helperText('Note inserite dal paziente durante la prenotazione'),
                            
                        Textarea::make('note_studio')
                            ->rows(3)
                            ->maxLength(1000)
                            ->helperText('Note interne dello studio'),
                            
                        Textarea::make('note_post_visita')
                            ->rows(3)
                            ->maxLength(1000)
                            ->helperText('Note compilate dopo la visita')
                            ->visible(fn (Get $get) => in_array($get('stato'), ['completato', 'in_corso'])),
                    ]),
                    
                Section::make('Informazioni Paziente')
                    ->visible(fn (Get $get) => $get('patient_id'))
                    ->schema([
                        ViewField::make('patient_info')
                            ->view('components.patient-info-card'),
                    ]),
            ]);
    }
    
    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('data_appuntamento')
                    ->label('Data e Ora')
                    ->dateTime('d/m/Y H:i')
                    ->sortable()
                    ->searchable(),
                    
                TextColumn::make('patient.nome_completo')
                    ->label('Paziente')
                    ->searchable()
                    ->sortable(),
                    
                TextColumn::make('patient.settimane_gestazione')
                    ->label('Settimane')
                    ->suffix('°')
                    ->alignCenter(),
                    
                TextColumn::make('dentista.nome_completo')
                    ->label('Odontoiatra')
                    ->searchable(),
                    
                TextColumn::make('tipo_visita')
                    ->label('Tipo')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'prima_visita' => 'success',
                        'controllo' => 'info',
                        'urgenza' => 'danger',
                        'igiene_orale' => 'warning',
                        default => 'gray',
                    }),
                    
                TextColumn::make('durata_minuti')
                    ->label('Durata')
                    ->suffix(' min')
                    ->alignCenter(),
                    
                TextColumn::make('stato')
                    ->label('Stato')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'confermato' => 'success',
                        'in_attesa_conferma' => 'warning',
                        'in_corso' => 'info',
                        'completato' => 'success',
                        'annullato' => 'danger',
                        'no_show' => 'gray',
                        'rinviato' => 'warning',
                        default => 'gray',
                    }),
                    
                IconColumn::make('priorita')
                    ->label('Priorità')
                    ->icon(fn (string $state): string => match ($state) {
                        'urgente' => 'heroicon-s-exclamation-triangle',
                        'alta' => 'heroicon-s-arrow-up',
                        'normale' => 'heroicon-s-minus',
                        'bassa' => 'heroicon-s-arrow-down',
                        default => 'heroicon-s-minus',
                    })
                    ->color(fn (string $state): string => match ($state) {
                        'urgente' => 'danger',
                        'alta' => 'warning',
                        'normale' => 'gray',
                        'bassa' => 'success',
                        default => 'gray',
                    }),
            ])
            ->filters([
                SelectFilter::make('stato')
                    ->options([
                        'confermato' => 'Confermato',
                        'in_attesa_conferma' => 'In Attesa Conferma',
                        'in_corso' => 'In Corso',
                        'completato' => 'Completato',
                        'annullato' => 'Annullato',
                        'no_show' => 'No Show',
                        'rinviato' => 'Rinviato',
                    ])
                    ->multiple(),
                    
                SelectFilter::make('dentista_id')
                    ->relationship('dentista', 'nome_completo')
                    ->multiple(),
                    
                SelectFilter::make('tipo_visita')
                    ->multiple(),
                    
                Filter::make('data_range')
                    ->form([
                        DatePicker::make('data_da'),
                        DatePicker::make('data_a'),
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query
                            ->when($data['data_da'], fn ($q, $date) => $q->whereDate('data_appuntamento', '>=', $date))
                            ->when($data['data_a'], fn ($q, $date) => $q->whereDate('data_appuntamento', '<=', $date));
                    }),
                    
                TernaryFilter::make('urgenti')
                    ->label('Solo Urgenti')
                    ->queries(
                        true: fn (Builder $query) => $query->where('priorita', 'urgente'),
                        false: fn (Builder $query) => $query->where('priorita', '!=', 'urgente'),
                    ),
            ])
            ->actions([
                ActionGroup::make([
                    // Azioni Rapide
                    Action::make('conferma')
                        ->icon('heroicon-o-check-circle')
                        ->color('success')
                        ->visible(fn (Appointment $record) => $record->stato === 'in_attesa_conferma')
                        ->action(function (Appointment $record) {
                            $record->update(['stato' => 'confermato']);
                            Notification::make()->title('Appuntamento confermato')->success()->send();
                        }),
                        
                    Action::make('inizia')
                        ->icon('heroicon-o-play')
                        ->color('info')
                        ->visible(fn (Appointment $record) => $record->stato === 'confermato')
                        ->action(function (Appointment $record) {
                            $record->update(['stato' => 'in_corso', 'ora_inizio_effettiva' => now()]);
                            Notification::make()->title('Appuntamento iniziato')->success()->send();
                        }),
                        
                    Action::make('completa')
                        ->icon('heroicon-o-check')
                        ->color('success')
                        ->visible(fn (Appointment $record) => $record->stato === 'in_corso')
                        ->form([
                            Textarea::make('note_post_visita')
                                ->required()
                                ->rows(3)
                                ->helperText('Riassunto della visita effettuata'),
                            Rating::make('valutazione_studio')
                                ->min(1)
                                ->max(5),
                        ])
                        ->action(function (Appointment $record, array $data) {
                            $record->update([
                                'stato' => 'completato',
                                'ora_fine_effettiva' => now(),
                                'note_post_visita' => $data['note_post_visita'],
                                'valutazione_studio' => $data['valutazione_studio'] ?? null,
                            ]);
                            
                            // Invia notifica di completamento
                            $record->patient->notify(new AppointmentCompletedNotification($record));
                            
                            Notification::make()->title('Appuntamento completato')->success()->send();
                        }),
                        
                    Action::make('marca_no_show')
                        ->icon('heroicon-o-user-minus')
                        ->color('gray')
                        ->visible(fn (Appointment $record) => in_array($record->stato, ['confermato', 'in_attesa_conferma']))
                        ->requiresConfirmation()
                        ->modalHeading('Conferma No-Show')
                        ->modalDescription('Sei sicuro che il paziente non si è presentato?')
                        ->action(function (Appointment $record) {
                            $record->update(['stato' => 'no_show']);
                            
                            // Libera lo slot per nuove prenotazioni
                            $record->availability?->update(['prenotato' => false]);
                            
                            Notification::make()->title('Appuntamento marcato come No-Show')->success()->send();
                        }),
                ]),
                
                // Azioni Secondarie
                ActionGroup::make([
                    Action::make('rinvia')
                        ->icon('heroicon-o-calendar-days')
                        ->color('warning')
                        ->form([
                            DateTimePicker::make('nuova_data')
                                ->required()
                                ->minDate(now()),
                            Textarea::make('motivo_rinvio')
                                ->required()
                                ->maxLength(500),
                        ])
                        ->action(function (Appointment $record, array $data) {
                            app(RescheduleAppointmentAction::class)->execute($record, $data);
                        }),
                        
                    Action::make('invia_promemoria')
                        ->icon('heroicon-o-bell')
                        ->color('info')
                        ->action(function (Appointment $record) {
                            $record->patient->notify(new AppointmentReminderNotification($record));
                            Notification::make()->title('Promemoria inviato')->success()->send();
                        }),
                        
                    Action::make('chiama_paziente')
                        ->icon('heroicon-o-phone')
                        ->color('success')
                        ->url(fn (Appointment $record) => 'tel:' . $record->patient->telefono),
                        
                    Action::make('invia_email')
                        ->icon('heroicon-o-envelope')
                        ->color('info')
                        ->url(fn (Appointment $record) => 'mailto:' . $record->patient->email),
                ]),
                
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make()
                    ->visible(fn (Appointment $record) => $record->stato === 'annullato'),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    BulkAction::make('conferma_multipli')
                        ->label('Conferma Selezionati')
                        ->icon('heroicon-o-check-circle')
                        ->color('success')
                        ->action(function (Collection $records) {
                            $records->each(function ($record) {
                                if ($record->stato === 'in_attesa_conferma') {
                                    $record->update(['stato' => 'confermato']);
                                }
                            });
                            
                            Notification::make()
                                ->title('Appuntamenti confermati')
                                ->success()
                                ->send();
                        }),
                        
                    BulkAction::make('invia_promemoria_multipli')
                        ->label('Invia Promemoria')
                        ->icon('heroicon-o-bell')
                        ->color('info')
                        ->action(function (Collection $records) {
                            $records->each(function ($record) {
                                if (in_array($record->stato, ['confermato', 'in_attesa_conferma'])) {
                                    $record->patient->notify(new AppointmentReminderNotification($record));
                                }
                            });
                            
                            Notification::make()
                                ->title('Promemoria inviati')
                                ->success()
                                ->send();
                        }),
                        
                    Tables\Actions\DeleteBulkAction::make()
                        ->visible(fn (Collection $records) => 
                            $records->every(fn ($record) => $record->stato === 'annullato')),
                ]),
            ])
            ->defaultSort('data_appuntamento', 'asc');
    }
}
```

### 2. Widget Calendario Appuntamenti

```php
// Widget: StudioCalendarWidget
class StudioCalendarWidget extends FullCalendarWidget
{
    public function config(): array
    {
        return [
            'initialView' => 'timeGridWeek',
            'headerToolbar' => [
                'left' => 'prev,next today',
                'center' => 'title',
                'right' => 'dayGridMonth,timeGridWeek,timeGridDay,listWeek'
            ],
            'slotMinTime' => '08:00:00',
            'slotMaxTime' => '20:00:00',
            'slotDuration' => '00:15:00',
            'businessHours' => $this->getBusinessHours(),
            'locale' => 'it',
            'firstDay' => 1,
            'height' => 'auto',
            'eventDisplay' => 'block',
            'eventClick' => 'function(info) { 
                window.showAppointmentDetails(info.event); 
            }',
            'dateClick' => 'function(info) { 
                window.createQuickAppointment(info.dateStr); 
            }',
            'eventDrop' => 'function(info) { 
                window.updateAppointmentTime(info.event.id, info.event.start); 
            }',
            'eventResize' => 'function(info) { 
                window.updateAppointmentDuration(info.event.id, info.event.start, info.event.end); 
            }',
        ];
    }
    
    public function fetchEvents(array $fetchInfo): array
    {
        $studio = Filament::getTenant();
        
        $appointments = Appointment::where('studio_id', $studio->id)
            ->whereBetween('data_appuntamento', [$fetchInfo['start'], $fetchInfo['end']])
            ->with(['patient', 'dentista', 'servizi'])
            ->get();
            
        return $appointments->map(function ($appointment) {
            return [
                'id' => $appointment->id,
                'title' => $this->formatEventTitle($appointment),
                'start' => $appointment->data_appuntamento,
                'end' => $appointment->data_appuntamento->addMinutes($appointment->durata_minuti),
                'backgroundColor' => $this->getEventColor($appointment),
                'borderColor' => $this->getEventBorderColor($appointment),
                'textColor' => $this->getEventTextColor($appointment),
                'extendedProps' => [
                    'patient_id' => $appointment->patient_id,
                    'patient_name' => $appointment->patient->nome_completo,
                    'patient_weeks' => $appointment->patient->settimane_gestazione,
                    'dentist_name' => $appointment->dentista->nome_completo,
                    'tipo_visita' => $appointment->tipo_visita,
                    'stato' => $appointment->stato,
                    'priorita' => $appointment->priorita,
                    'note' => $appointment->note_paziente,
                    'servizi' => $appointment->servizi->pluck('nome')->join(', '),
                    'telefono' => $appointment->patient->telefono,
                    'email' => $appointment->patient->email,
                ],
                'classNames' => [
                    'appointment-' . $appointment->stato,
                    'priority-' . $appointment->priorita,
                    'type-' . $appointment->tipo_visita,
                ]
            ];
        })->toArray();
    }
    
    private function formatEventTitle(Appointment $appointment): string
    {
        $paziente = $appointment->patient->nome . ' ' . substr($appointment->patient->cognome, 0, 1) . '.';
        $settimane = $appointment->patient->settimane_gestazione . '°';
        
        return "{$paziente} ({$settimane}) - {$appointment->tipo_visita_label}";
    }
    
    private function getEventColor(Appointment $appointment): string
    {
        return match($appointment->stato) {
            'confermato' => '#10b981', // Verde
            'in_attesa_conferma' => '#f59e0b', // Giallo
            'in_corso' => '#3b82f6', // Blu
            'completato' => '#059669', // Verde scuro
            'annullato' => '#ef4444', // Rosso
            'no_show' => '#6b7280', // Grigio
            'rinviato' => '#f97316', // Arancione
            default => '#6b7280'
        };
    }
}
```

### 3. Action Rinvio Appuntamento

```php
// Action: RescheduleAppointmentAction
class RescheduleAppointmentAction
{
    public function execute(Appointment $appointment, array $data): Appointment
    {
        return DB::transaction(function () use ($appointment, $data) {
            // Salva data originale
            $originalDate = $appointment->data_appuntamento;
            
            // Libera lo slot originale
            if ($appointment->availability) {
                $appointment->availability->update(['prenotato' => false]);
            }
            
            // Trova o crea nuovo slot
            $newAvailability = $this->findOrCreateAvailability($appointment, $data['nuova_data']);
            
            // Aggiorna appuntamento
            $appointment->update([
                'data_appuntamento' => $data['nuova_data'],
                'availability_id' => $newAvailability->id,
                'stato' => 'confermato',
                'note_studio' => ($appointment->note_studio ?? '') . "\n\nRinviato da {$originalDate->format('d/m/Y H:i')} - Motivo: {$data['motivo_rinvio']}",
            ]);
            
            // Marca nuovo slot come prenotato
            $newAvailability->update(['prenotato' => true]);
            
            // Crea record storico
            AppointmentReschedule::create([
                'appointment_id' => $appointment->id,
                'data_originale' => $originalDate,
                'data_nuova' => $data['nuova_data'],
                'motivo' => $data['motivo_rinvio'],
                'rinviato_da' => auth()->id(),
                'rinviato_il' => now(),
            ]);
            
            // Invia notifiche
            $appointment->patient->notify(new AppointmentRescheduledNotification($appointment, $originalDate));
            
            return $appointment;
        });
    }
}
```

## 📱 Interfaccia di Gestione

### Lista Appuntamenti con Filtri

```blade
<div class="appointments-management">
    <div class="management-header">
        <div class="header-info">
            <h2>Gestione Appuntamenti</h2>
            <p>{{ $totalAppointments }} appuntamenti totali</p>
        </div>
        
        <div class="header-actions">
            <div class="view-toggles">
                <button class="view-toggle {{ $currentView === 'list' ? 'active' : '' }}" 
                        wire:click="setView('list')">
                    <i class="icon-list"></i>
                    Lista
                </button>
                <button class="view-toggle {{ $currentView === 'calendar' ? 'active' : '' }}" 
                        wire:click="setView('calendar')">
                    <i class="icon-calendar"></i>
                    Calendario
                </button>
                <button class="view-toggle {{ $currentView === 'timeline' ? 'active' : '' }}" 
                        wire:click="setView('timeline')">
                    <i class="icon-timeline"></i>
                    Timeline
                </button>
            </div>
            
            <button class="btn btn-primary" wire:click="createNewAppointment">
                <i class="icon-plus"></i>
                Nuovo Appuntamento
            </button>
        </div>
    </div>
    
    <!-- Filtri Rapidi -->
    <div class="quick-filters">
        <div class="filter-tabs">
            <button class="filter-tab {{ $activeFilter === 'today' ? 'active' : '' }}" 
                    wire:click="setFilter('today')">
                Oggi ({{ $todayCount }})
            </button>
            <button class="filter-tab {{ $activeFilter === 'tomorrow' ? 'active' : '' }}" 
                    wire:click="setFilter('tomorrow')">
                Domani ({{ $tomorrowCount }})
            </button>
            <button class="filter-tab {{ $activeFilter === 'week' ? 'active' : '' }}" 
                    wire:click="setFilter('week')">
                Questa Settimana ({{ $weekCount }})
            </button>
            <button class="filter-tab {{ $activeFilter === 'pending' ? 'active' : '' }}" 
                    wire:click="setFilter('pending')">
                Da Confermare ({{ $pendingCount }})
            </button>
            <button class="filter-tab {{ $activeFilter === 'urgent' ? 'active' : '' }}" 
                    wire:click="setFilter('urgent')">
                Urgenti ({{ $urgentCount }})
            </button>
        </div>
        
        <div class="filter-controls">
            <select wire:model.live="selectedDentist" class="filter-select">
                <option value="">Tutti gli Odontoiatri</option>
                @foreach($dentists as $dentist)
                    <option value="{{ $dentist->id }}">{{ $dentist->nome_completo }}</option>
                @endforeach
            </select>
            
            <input type="search" wire:model.live.debounce.300ms="search" 
                   placeholder="Cerca paziente..." class="search-input">
                   
            <button class="btn btn-outline" wire:click="toggleAdvancedFilters">
                <i class="icon-filter"></i>
                Filtri Avanzati
            </button>
        </div>
    </div>
    
    <!-- Filtri Avanzati -->
    @if($showAdvancedFilters)
        <div class="advanced-filters">
            <div class="filters-grid">
                <div class="filter-group">
                    <label>Periodo</label>
                    <div class="date-range">
                        <input type="date" wire:model.live="dateFrom">
                        <span>-</span>
                        <input type="date" wire:model.live="dateTo">
                    </div>
                </div>
                
                <div class="filter-group">
                    <label>Stato</label>
                    <select wire:model.live="statusFilter" multiple class="multi-select">
                        <option value="confermato">Confermato</option>
                        <option value="in_attesa_conferma">In Attesa Conferma</option>
                        <option value="in_corso">In Corso</option>
                        <option value="completato">Completato</option>
                        <option value="annullato">Annullato</option>
                        <option value="no_show">No Show</option>
                    </select>
                </div>
                
                <div class="filter-group">
                    <label>Tipo Visita</label>
                    <select wire:model.live="typeFilter" multiple class="multi-select">
                        <option value="prima_visita">Prima Visita</option>
                        <option value="controllo">Controllo</option>
                        <option value="igiene_orale">Igiene Orale</option>
                        <option value="urgenza">Urgenza</option>
                    </select>
                </div>
                
                <div class="filter-group">
                    <label>Priorità</label>
                    <select wire:model.live="priorityFilter">
                        <option value="">Tutte</option>
                        <option value="urgente">Urgente</option>
                        <option value="alta">Alta</option>
                        <option value="normale">Normale</option>
                        <option value="bassa">Bassa</option>
                    </select>
                </div>
            </div>
            
            <div class="filters-actions">
                <button class="btn btn-primary" wire:click="applyFilters">
                    Applica Filtri
                </button>
                <button class="btn btn-outline" wire:click="resetFilters">
                    Reset
                </button>
            </div>
        </div>
    @endif
    
    <!-- Contenuto Principale -->
    <div class="appointments-content">
        @if($currentView === 'list')
            {{ $this->table }}
        @elseif($currentView === 'calendar')
            @livewire('studio-calendar-widget')
        @elseif($currentView === 'timeline')
            @livewire('appointments-timeline-widget')
        @endif
    </div>
</div>
```

### Card Dettaglio Appuntamento

```blade
<div class="appointment-detail-card">
    <div class="card-header">
        <div class="appointment-time">
            <h3>{{ $appointment->data_appuntamento->format('d/m/Y') }}</h3>
            <p>{{ $appointment->data_appuntamento->format('H:i') }} - 
               {{ $appointment->data_appuntamento->addMinutes($appointment->durata_minuti)->format('H:i') }}</p>
        </div>
        
        <div class="appointment-status">
            <span class="status-badge {{ $appointment->stato }}">
                {{ $appointment->stato_label }}
            </span>
            @if($appointment->priorita === 'urgente')
                <span class="priority-badge urgent">
                    <i class="icon-alert"></i>
                    Urgente
                </span>
            @endif
        </div>
    </div>
    
    <div class="card-body">
        <!-- Info Paziente -->
        <div class="patient-section">
            <div class="patient-header">
                <div class="patient-avatar">
                    {{ substr($appointment->patient->nome, 0, 1) }}{{ substr($appointment->patient->cognome, 0, 1) }}
                </div>
                <div class="patient-info">
                    <h4>{{ $appointment->patient->nome_completo }}</h4>
                    <p>{{ $appointment->patient->settimane_gestazione }}° settimana di gestazione</p>
                    <p>{{ $appointment->patient->eta }} anni</p>
                </div>
            </div>
            
            <div class="patient-contacts">
                <a href="tel:{{ $appointment->patient->telefono }}" class="contact-link">
                    <i class="icon-phone"></i>
                    {{ $appointment->patient->telefono }}
                </a>
                <a href="mailto:{{ $appointment->patient->email }}" class="contact-link">
                    <i class="icon-email"></i>
                    {{ $appointment->patient->email }}
                </a>
            </div>
        </div>
        
        <!-- Info Visita -->
        <div class="visit-section">
            <div class="visit-details">
                <div class="detail-item">
                    <span class="label">Tipo Visita:</span>
                    <span class="value">{{ $appointment->tipo_visita_label }}</span>
                </div>
                
                <div class="detail-item">
                    <span class="label">Odontoiatra:</span>
                    <span class="value">{{ $appointment->dentista->nome_completo }}</span>
                </div>
                
                <div class="detail-item">
                    <span class="label">Durata:</span>
                    <span class="value">{{ $appointment->durata_minuti }} minuti</span>
                </div>
            </div>
            
            @if($appointment->servizi->isNotEmpty())
                <div class="services-list">
                    <span class="label">Servizi:</span>
                    <div class="services-tags">
                        @foreach($appointment->servizi as $servizio)
                            <span class="service-tag">{{ $servizio->nome }}</span>
                        @endforeach
                    </div>
                </div>
            @endif
        </div>
        
        <!-- Note -->
        @if($appointment->note_paziente || $appointment->note_studio)
            <div class="notes-section">
                @if($appointment->note_paziente)
                    <div class="note-item">
                        <strong>Note Paziente:</strong>
                        <p>{{ $appointment->note_paziente }}</p>
                    </div>
                @endif
                
                @if($appointment->note_studio)
                    <div class="note-item">
                        <strong>Note Studio:</strong>
                        <p>{{ $appointment->note_studio }}</p>
                    </div>
                @endif
            </div>
        @endif
    </div>
    
    <div class="card-actions">
        @if($appointment->stato === 'in_attesa_conferma')
            <button class="btn btn-success" wire:click="confirmAppointment({{ $appointment->id }})">
                <i class="icon-check"></i>
                Conferma
            </button>
        @endif
        
        @if($appointment->stato === 'confermato')
            <button class="btn btn-info" wire:click="startAppointment({{ $appointment->id }})">
                <i class="icon-play"></i>
                Inizia
            </button>
        @endif
        
        @if($appointment->stato === 'in_corso')
            <button class="btn btn-success" wire:click="completeAppointment({{ $appointment->id }})">
                <i class="icon-check-circle"></i>
                Completa
            </button>
        @endif
        
        <button class="btn btn-outline" wire:click="rescheduleAppointment({{ $appointment->id }})">
            <i class="icon-calendar"></i>
            Rinvia
        </button>
        
        <button class="btn btn-outline" wire:click="editAppointment({{ $appointment->id }})">
            <i class="icon-edit"></i>
            Modifica
        </button>
        
        <div class="dropdown">
            <button class="btn btn-outline dropdown-toggle">
                <i class="icon-more"></i>
            </button>
            <div class="dropdown-menu">
                <button wire:click="sendReminder({{ $appointment->id }})">
                    <i class="icon-bell"></i>
                    Invia Promemoria
                </button>
                <button wire:click="markNoShow({{ $appointment->id }})">
                    <i class="icon-user-x"></i>
                    Marca No-Show
                </button>
                <button wire:click="cancelAppointment({{ $appointment->id }})" class="text-danger">
                    <i class="icon-x"></i>
                    Annulla
                </button>
            </div>
        </div>
    </div>
</div>
```

## 📊 Analytics Appuntamenti

### Widget Statistiche Rapide

```php
// Widget: AppointmentStatsWidget
class AppointmentStatsWidget extends Widget
{
    protected static string $view = 'widgets.appointment-stats';
    
    public function getAppointmentStats(): array
    {
        $studio = Filament::getTenant();
        
        return [
            'oggi' => [
                'totali' => $this->getTodayAppointments($studio),
                'completati' => $this->getTodayCompletedAppointments($studio),
                'in_corso' => $this->getInProgressAppointments($studio),
                'cancellati' => $this->getTodayCancelledAppointments($studio),
            ],
            'settimana' => [
                'totali' => $this->getWeekAppointments($studio),
                'media_giornaliera' => $this->getDailyAverage($studio),
                'tasso_completamento' => $this->getCompletionRate($studio),
                'no_show_rate' => $this->getNoShowRate($studio),
            ],
            'mese' => [
                'totali' => $this->getMonthAppointments($studio),
                'crescita' => $this->getMonthlyGrowth($studio),
                'nuovi_pazienti' => $this->getNewPatients($studio),
                'pazienti_ricorrenti' => $this->getRecurringPatients($studio),
            ],
        ];
    }
}
```

### Report Esportazione

```php
// Export: AppointmentsExport
class AppointmentsExport implements FromCollection, WithHeadings, WithMapping
{
    public function __construct(public Collection $appointments) {}
    
    public function collection()
    {
        return $this->appointments;
    }
    
    public function headings(): array
    {
        return [
            'Data',
            'Ora',
            'Paziente',
            'Telefono',
            'Email',
            'Settimane Gestazione',
            'Odontoiatra',
            'Tipo Visita',
            'Durata (min)',
            'Stato',
            'Priorità',
            'Servizi',
            'Note Paziente',
            'Note Studio',
        ];
    }
    
    public function map($appointment): array
    {
        return [
            $appointment->data_appuntamento->format('d/m/Y'),
            $appointment->data_appuntamento->format('H:i'),
            $appointment->patient->nome_completo,
            $appointment->patient->telefono,
            $appointment->patient->email,
            $appointment->patient->settimane_gestazione,
            $appointment->dentista->nome_completo,
            $appointment->tipo_visita_label,
            $appointment->durata_minuti,
            $appointment->stato_label,
            $appointment->priorita,
            $appointment->servizi->pluck('nome')->join(', '),
            $appointment->note_paziente,
            $appointment->note_studio,
        ];
    }
}
```

## 🔗 Collegamenti

### Documenti Correlati
- [Dashboard Studio](./dashboard_studio.md)
- [Registrazione Studi](./registrazione_studi.md)
- [Calendario Disponibilità](../prenotazione_visite/calendario_disponibilita.md)
- [Sistema Notifiche](../notifiche/README.md)

### File Tecnici
- `Modules/<nome progetto>/Filament/Resources/StudioAppointmentResource.php`
- `Modules/<nome progetto>/Widgets/StudioCalendarWidget.php`
- `Modules/<nome progetto>/Actions/RescheduleAppointmentAction.php`
- `Modules/<nome progetto>/Exports/AppointmentsExport.php`

---

**📅 Ultimo aggiornamento**: 5 Giugno 2025  
**👥 Stato sviluppo**: ✅ **Completato** (100%)  
**🔄 Prossimi passi**: Integrazione AI per ottimizzazione schedule e prediction no-show