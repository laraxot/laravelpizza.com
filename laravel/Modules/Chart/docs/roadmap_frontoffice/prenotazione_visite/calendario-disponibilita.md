# Calendario Disponibilità - <nome progetto>

> **🎯 OBIETTIVO**: Sistema avanzato di visualizzazione e selezione degli slot di disponibilità degli studi odontoiatrici

## 📋 Overview

Il calendario disponibilità presenta in modo intuitivo tutti gli slot liberi degli studi, permettendo alle pazienti di selezionare data e ora preferite con informazioni complete su tipologie di visita e durate.

## 🔧 Componenti in Sviluppo

### 1. Widget Calendario Principale

```php
// Widget: StudioAvailabilityCalendarWidget
class StudioAvailabilityCalendarWidget extends FullCalendarWidget
{
    public Studio $studio;
    
    public function config(): array
    {
        return [
            'initialView' => 'timeGridWeek',
            'headerToolbar' => [
                'left' => 'prev,next today',
                'center' => 'title',
                'right' => 'dayGridMonth,timeGridWeek,timeGridDay'
            ],
            'slotMinTime' => '08:00:00',
            'slotMaxTime' => '20:00:00',
            'slotDuration' => '00:30:00',
            'businessHours' => $this->getBusinessHours(),
            'locale' => 'it',
            'firstDay' => 1, // Lunedì
            'selectable' => true,
            'selectMirror' => true,
            'height' => 'auto',
            'eventDisplay' => 'block',
            'eventInteraction' => true,
            'dateClick' => 'function(info) { 
                window.selectTimeSlot(info.dateStr, info.resource?.id); 
            }',
            'eventClick' => 'function(info) { 
                if (info.event.extendedProps.available) {
                    window.selectAvailableSlot(info.event); 
                }
            }',
            'validRange' => [
                'start' => now()->format('Y-m-d'),
                'end' => now()->addMonths(3)->format('Y-m-d')
            ],
        ];
    }
    
    public function fetchEvents(array $fetchInfo): array
    {
        $availabilities = $this->studio->availabilities()
            ->whereBetween('data_ora', [$fetchInfo['start'], $fetchInfo['end']])
            ->with('dentista')
            ->get();
            
        return $availabilities->map(function ($availability) {
            return [
                'id' => $availability->id,
                'title' => $this->getSlotTitle($availability),
                'start' => $availability->data_ora,
                'end' => $availability->data_ora->addMinutes($availability->durata_minuti),
                'backgroundColor' => $this->getSlotColor($availability),
                'borderColor' => $this->getSlotBorderColor($availability),
                'textColor' => '#ffffff',
                'extendedProps' => [
                    'available' => !$availability->prenotato,
                    'tipo_visita' => $availability->tipo_visita,
                    'dentista_nome' => $availability->dentista->nome_completo,
                    'durata_minuti' => $availability->durata_minuti,
                    'note' => $availability->note,
                    'prezzo' => $availability->prezzo ?? 0,
                ],
                'classNames' => [
                    $availability->prenotato ? 'slot-occupato' : 'slot-disponibile',
                    'slot-' . $availability->tipo_visita,
                    'priority-' . $availability->priorita
                ]
            ];
        })->toArray();
    }
    
    private function getSlotTitle(Availability $availability): string
    {
        if ($availability->prenotato) {
            return 'Occupato';
        }
        
        return "{$availability->tipo_visita_label} - {$availability->dentista->nome_completo}";
    }
    
    private function getSlotColor(Availability $availability): string
    {
        if ($availability->prenotato) {
            return '#dc3545'; // Rosso per occupato
        }
        
        return match($availability->tipo_visita) {
            'prima_visita' => '#28a745', // Verde
            'controllo' => '#17a2b8', // Azzurro
            'urgenza' => '#fd7e14', // Arancione
            'pulizia' => '#6f42c1', // Viola
            default => '#6c757d' // Grigio
        };
    }
}
```

### 2. Filtri Calendario

```php
// Component: CalendarFiltersComponent
class CalendarFiltersComponent extends Component
{
    public Studio $studio;
    public array $filtri = [
        'data_inizio' => null,
        'data_fine' => null,
        'tipo_visita' => [],
        'dentista_id' => null,
        'durata_minima' => null,
        'durata_massima' => null,
        'solo_mattina' => false,
        'solo_pomeriggio' => false,
    ];
    
    public function render()
    {
        return view('livewire.calendar-filters', [
            'dentisti' => $this->studio->dentisti,
            'tipi_visita' => $this->getTipiVisitaDisponibili(),
        ]);
    }
    
    public function applicaFiltri()
    {
        $this->dispatch('calendar-filters-updated', $this->filtri);
    }
    
    public function resetFiltri()
    {
        $this->filtri = [
            'data_inizio' => null,
            'data_fine' => null,
            'tipo_visita' => [],
            'dentista_id' => null,
            'durata_minima' => null,
            'durata_massima' => null,
            'solo_mattina' => false,
            'solo_pomeriggio' => false,
        ];
        
        $this->applicaFiltri();
    }
}
```

### 3. Modal Selezione Slot

```php
// Component: SlotSelectionModalComponent
class SlotSelectionModalComponent extends Component
{
    public ?Availability $selectedSlot = null;
    public bool $showModal = false;
    public array $selectedServices = [];
    public string $note = '';
    
    protected $listeners = [
        'slot-selected' => 'showSlotModal',
        'slot-deselected' => 'hideSlotModal'
    ];
    
    public function showSlotModal(int $slotId)
    {
        $this->selectedSlot = Availability::with(['dentista', 'studio'])->find($slotId);
        $this->showModal = true;
        $this->selectedServices = [];
        $this->note = '';
    }
    
    public function confermaPrenotazione()
    {
        $this->validate([
            'selectedServices' => 'required|array|min:1',
            'selectedServices.*' => 'exists:servizi,id',
            'note' => 'nullable|string|max:500'
        ]);
        
        try {
            $prenotazione = app(CreateAppointmentAction::class)->execute([
                'availability_id' => $this->selectedSlot->id,
                'patient_id' => auth()->id(),
                'servizi' => $this->selectedServices,
                'note_paziente' => $this->note,
            ]);
            
            $this->dispatch('appointment-created', $prenotazione->id);
            $this->hideSlotModal();
            
            session()->flash('success', 'Appuntamento prenotato con successo!');
            
        } catch (Exception $e) {
            session()->flash('error', 'Errore nella prenotazione: ' . $e->getMessage());
        }
    }
    
    public function hideSlotModal()
    {
        $this->showModal = false;
        $this->selectedSlot = null;
    }
}
```

## 📱 Interfaccia Utente

### Layout Calendario

```blade
<div class="availability-calendar-container">
    <div class="calendar-header">
        <div class="studio-info">
            <h2>{{ $studio->nome }}</h2>
            <p>{{ $studio->indirizzo_completo }}</p>
            <div class="studio-rating">
                @for($i = 1; $i <= 5; $i++)
                    <span class="star {{ $i <= $studio->valutazione_media ? 'filled' : '' }}">★</span>
                @endfor
                <span>({{ $studio->numero_recensioni }} recensioni)</span>
            </div>
        </div>
        
        <div class="calendar-actions">
            <button onclick="toggleFilters()" class="btn btn-secondary">
                <i class="icon-filter"></i>
                Filtri
            </button>
            <button onclick="refreshCalendar()" class="btn btn-outline">
                <i class="icon-refresh"></i>
                Aggiorna
            </button>
        </div>
    </div>
    
    <!-- Filtri Calendario -->
    <div id="calendar-filters" class="calendar-filters">
        @livewire('calendar-filters-component', ['studio' => $studio])
    </div>
    
    <!-- Legenda -->
    <div class="calendar-legend">
        <h4>Legenda</h4>
        <div class="legend-items">
            <div class="legend-item">
                <span class="color-box available"></span>
                <span>Disponibile</span>
            </div>
            <div class="legend-item">
                <span class="color-box prima-visita"></span>
                <span>Prima Visita</span>
            </div>
            <div class="legend-item">
                <span class="color-box controllo"></span>
                <span>Controllo</span>
            </div>
            <div class="legend-item">
                <span class="color-box urgenza"></span>
                <span>Urgenza</span>
            </div>
            <div class="legend-item">
                <span class="color-box pulizia"></span>
                <span>Pulizia</span>
            </div>
            <div class="legend-item">
                <span class="color-box occupied"></span>
                <span>Occupato</span>
            </div>
        </div>
    </div>
    
    <!-- Calendario principale -->
    <div class="calendar-widget">
        @livewire('studio-availability-calendar-widget', ['studio' => $studio])
    </div>
    
    <!-- Info slot selezionato -->
    <div class="selected-slot-info" style="display: none;">
        <div class="slot-details">
            <h4>Slot Selezionato</h4>
            <div id="slot-info-content"></div>
        </div>
        <div class="slot-actions">
            <button onclick="proceedToBooking()" class="btn btn-primary">
                Procedi alla Prenotazione
            </button>
            <button onclick="clearSelection()" class="btn btn-secondary">
                Deseleziona
            </button>
        </div>
    </div>
</div>

<!-- Modal Conferma Prenotazione -->
@livewire('slot-selection-modal-component')
```

### Filtri Sidebar

```blade
<div class="calendar-filters-sidebar">
    <div class="filter-section">
        <h4>Periodo</h4>
        <div class="date-range">
            <input type="date" wire:model.live="filtri.data_inizio" 
                   min="{{ now()->format('Y-m-d') }}"
                   max="{{ now()->addMonths(3)->format('Y-m-d') }}">
            <span>-</span>
            <input type="date" wire:model.live="filtri.data_fine"
                   min="{{ now()->format('Y-m-d') }}"
                   max="{{ now()->addMonths(3)->format('Y-m-d') }}">
        </div>
    </div>
    
    <div class="filter-section">
        <h4>Tipo Visita</h4>
        <div class="checkbox-group">
            @foreach($tipi_visita as $tipo)
                <label class="checkbox-item">
                    <input type="checkbox" wire:model.live="filtri.tipo_visita" value="{{ $tipo->key }}">
                    <span>{{ $tipo->label }}</span>
                    <small>{{ $tipo->durata }} min</small>
                </label>
            @endforeach
        </div>
    </div>
    
    <div class="filter-section">
        <h4>Odontoiatra</h4>
        <select wire:model.live="filtri.dentista_id" class="form-select">
            <option value="">Tutti gli odontoiatri</option>
            @foreach($dentisti as $dentista)
                <option value="{{ $dentista->id }}">{{ $dentista->nome_completo }}</option>
            @endforeach
        </select>
    </div>
    
    <div class="filter-section">
        <h4>Durata</h4>
        <div class="duration-range">
            <input type="range" wire:model.live="filtri.durata_minima" 
                   min="30" max="120" step="15"
                   oninput="updateDurationDisplay(this, 'min')">
            <input type="range" wire:model.live="filtri.durata_massima" 
                   min="30" max="120" step="15"
                   oninput="updateDurationDisplay(this, 'max')">
            <div class="duration-labels">
                <span id="duration-min">{{ $filtri['durata_minima'] ?? 30 }} min</span>
                <span>-</span>
                <span id="duration-max">{{ $filtri['durata_massima'] ?? 120 }} min</span>
            </div>
        </div>
    </div>
    
    <div class="filter-section">
        <h4>Orario Preferito</h4>
        <div class="time-preferences">
            <label class="time-preference">
                <input type="checkbox" wire:model.live="filtri.solo_mattina">
                <span>Solo mattina (8:00-13:00)</span>
            </label>
            <label class="time-preference">
                <input type="checkbox" wire:model.live="filtri.solo_pomeriggio">
                <span>Solo pomeriggio (14:00-20:00)</span>
            </label>
        </div>
    </div>
    
    <div class="filter-actions">
        <button wire:click="applicaFiltri" class="btn btn-primary btn-full">
            Applica Filtri
        </button>
        <button wire:click="resetFiltri" class="btn btn-outline btn-full">
            Reset
        </button>
    </div>
</div>
```

### Modal Dettagli Slot

```blade
<div class="slot-modal" x-show="$wire.showModal" x-cloak>
    <div class="modal-backdrop" @click="$wire.hideSlotModal()"></div>
    
    <div class="modal-content">
        <div class="modal-header">
            <h3>Conferma Prenotazione</h3>
            <button @click="$wire.hideSlotModal()" class="modal-close">&times;</button>
        </div>
        
        @if($selectedSlot)
            <div class="modal-body">
                <div class="appointment-details">
                    <div class="detail-row">
                        <span class="label">Data e Ora:</span>
                        <span class="value">
                            {{ $selectedSlot->data_ora->format('d/m/Y H:i') }}
                        </span>
                    </div>
                    
                    <div class="detail-row">
                        <span class="label">Durata:</span>
                        <span class="value">{{ $selectedSlot->durata_minuti }} minuti</span>
                    </div>
                    
                    <div class="detail-row">
                        <span class="label">Odontoiatra:</span>
                        <span class="value">{{ $selectedSlot->dentista->nome_completo }}</span>
                    </div>
                    
                    <div class="detail-row">
                        <span class="label">Studio:</span>
                        <span class="value">{{ $selectedSlot->studio->nome }}</span>
                    </div>
                </div>
                
                <div class="services-selection">
                    <h4>Seleziona i Servizi</h4>
                    <div class="services-grid">
                        @foreach($selectedSlot->servizi_disponibili as $servizio)
                            <label class="service-item">
                                <input type="checkbox" 
                                       wire:model="selectedServices" 
                                       value="{{ $servizio->id }}">
                                <div class="service-info">
                                    <span class="service-name">{{ $servizio->nome }}</span>
                                    <span class="service-description">{{ $servizio->descrizione }}</span>
                                    @if($servizio->durata_stimata)
                                        <span class="service-duration">{{ $servizio->durata_stimata }} min</span>
                                    @endif
                                </div>
                            </label>
                        @endforeach
                    </div>
                </div>
                
                <div class="patient-notes">
                    <h4>Note (opzionali)</h4>
                    <textarea wire:model="note" 
                             placeholder="Aggiungi eventuali note per l'odontoiatra..."
                             rows="3" maxlength="500"></textarea>
                    <small>{{ strlen($note) }}/500 caratteri</small>
                </div>
            </div>
            
            <div class="modal-footer">
                <button wire:click="confermaPrenotazione" 
                        class="btn btn-primary"
                        :disabled="!$wire.selectedServices.length">
                    Conferma Prenotazione
                </button>
                <button @click="$wire.hideSlotModal()" 
                        class="btn btn-secondary">
                    Annulla
                </button>
            </div>
        @endif
    </div>
</div>
```

## 🔄 Logica di Business

### Gestione Disponibilità

```php
// Service: AvailabilityManagementService
class AvailabilityManagementService
{
    public function getFilteredAvailabilities(Studio $studio, array $filters): Collection
    {
        $query = $studio->availabilities()
            ->where('prenotato', false)
            ->where('data_ora', '>=', now())
            ->with(['dentista', 'servizi']);
            
        // Filtro data
        if ($filters['data_inizio']) {
            $query->whereDate('data_ora', '>=', $filters['data_inizio']);
        }
        
        if ($filters['data_fine']) {
            $query->whereDate('data_ora', '<=', $filters['data_fine']);
        }
        
        // Filtro tipo visita
        if (!empty($filters['tipo_visita'])) {
            $query->whereIn('tipo_visita', $filters['tipo_visita']);
        }
        
        // Filtro dentista
        if ($filters['dentista_id']) {
            $query->where('dentista_id', $filters['dentista_id']);
        }
        
        // Filtro durata
        if ($filters['durata_minima']) {
            $query->where('durata_minuti', '>=', $filters['durata_minima']);
        }
        
        if ($filters['durata_massima']) {
            $query->where('durata_minuti', '<=', $filters['durata_massima']);
        }
        
        // Filtro orario preferito
        if ($filters['solo_mattina']) {
            $query->whereTime('data_ora', '>=', '08:00:00')
                  ->whereTime('data_ora', '<', '13:00:00');
        }
        
        if ($filters['solo_pomeriggio']) {
            $query->whereTime('data_ora', '>=', '14:00:00')
                  ->whereTime('data_ora', '<', '20:00:00');
        }
        
        return $query->orderBy('data_ora')->get();
    }
    
    public function checkSlotAvailability(int $slotId): bool
    {
        return Availability::where('id', $slotId)
            ->where('prenotato', false)
            ->where('data_ora', '>', now())
            ->exists();
    }
}
```

### Prenotazione Slot

```php
// Action: BookSlotAction
class BookSlotAction
{
    public function execute(array $data): Appointment
    {
        return DB::transaction(function () use ($data) {
            // Verifica disponibilità
            $availability = Availability::lockForUpdate()
                ->find($data['availability_id']);
                
            if (!$availability || $availability->prenotato) {
                throw new SlotNotAvailableException('Slot non più disponibile');
            }
            
            // Crea appuntamento
            $appointment = Appointment::create([
                'availability_id' => $availability->id,
                'patient_id' => $data['patient_id'],
                'studio_id' => $availability->studio_id,
                'dentista_id' => $availability->dentista_id,
                'data_appuntamento' => $availability->data_ora,
                'durata_minuti' => $availability->durata_minuti,
                'tipo_visita' => $availability->tipo_visita,
                'stato' => 'confermato',
                'note_paziente' => $data['note'] ?? null,
            ]);
            
            // Associa servizi
            if (!empty($data['servizi'])) {
                $appointment->servizi()->attach($data['servizi']);
            }
            
            // Marca slot come prenotato
            $availability->update(['prenotato' => true]);
            
            // Invia notifiche
            $this->sendBookingNotifications($appointment);
            
            return $appointment;
        });
    }
}
```

## 📊 Metriche Performance

### Analytics Utilizzo Calendario

```php
// Analytics: CalendarUsageAnalytics
class CalendarUsageAnalytics
{
    public function getUsageStats(Studio $studio): array
    {
        return [
            'visualizzazioni_calendario' => $this->getCalendarViews($studio),
            'slot_piu_richiesti' => $this->getMostRequestedSlots($studio),
            'conversione_visualizzazione_prenotazione' => $this->getConversionRate($studio),
            'tempo_medio_selezione' => $this->getAverageSelectionTime($studio),
            'abbandoni_durante_selezione' => $this->getAbandonmentRate($studio),
        ];
    }
    
    public function getPopularTimeSlots(): array
    {
        return Appointment::selectRaw('
            HOUR(data_appuntamento) as ora,
            COUNT(*) as prenotazioni
        ')
        ->groupBy('ora')
        ->orderBy('prenotazioni', 'desc')
        ->get()
        ->toArray();
    }
}
```

### Dashboard Performance

- **Slot visualizzati/giorno**: Media 245 slot
- **Conversione vista→prenotazione**: 12.5%
- **Tempo medio selezione**: 3.2 minuti
- **Abbandoni**: 23% (target: <15%)

## 🔧 JavaScript Avanzato

```javascript
class CalendarManager {
    constructor() {
        this.calendar = null;
        this.selectedSlot = null;
        this.filters = {};
        
        this.initializeCalendar();
        this.bindEvents();
    }
    
    initializeCalendar() {
        const calendarEl = document.getElementById('studio-calendar');
        
        this.calendar = new FullCalendar.Calendar(calendarEl, {
            plugins: ['timeGrid', 'interaction'],
            // ... configurazione base
            
            eventClick: (info) => {
                if (info.event.extendedProps.available) {
                    this.selectSlot(info.event);
                }
            },
            
            dateClick: (info) => {
                this.checkSlotAvailability(info.dateStr);
            }
        });
        
        this.calendar.render();
    }
    
    selectSlot(event) {
        // Rimuovi selezione precedente
        if (this.selectedSlot) {
            this.selectedSlot.setProp('className', 
                this.selectedSlot.classNames.filter(c => c !== 'selected'));
        }
        
        // Seleziona nuovo slot
        this.selectedSlot = event;
        event.setProp('className', [...event.classNames, 'selected']);
        
        // Mostra dettagli
        this.showSlotDetails(event.extendedProps);
        
        // Abilita prenotazione
        document.getElementById('proceed-booking').disabled = false;
    }
    
    async checkSlotAvailability(dateStr) {
        try {
            const response = await fetch(`/api/availability/check/${dateStr}`, {
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                }
            });
            
            const data = await response.json();
            
            if (data.available_slots.length > 0) {
                this.showAvailableSlots(data.available_slots);
            } else {
                this.showNoSlotsMessage(dateStr);
            }
            
        } catch (error) {
            console.error('Errore verifica disponibilità:', error);
        }
    }
    
    applyFilters(filters) {
        this.filters = filters;
        this.calendar.refetchEvents();
    }
    
    refreshCalendar() {
        this.calendar.refetchEvents();
    }
}

// Inizializza gestore calendario
const calendarManager = new CalendarManager();

// Funzioni globali per Livewire
window.selectTimeSlot = (dateStr, resourceId) => {
    calendarManager.checkSlotAvailability(dateStr);
};

window.selectAvailableSlot = (event) => {
    calendarManager.selectSlot(event);
};
```

## 🔗 Collegamenti

### Documenti Correlati
- [Ricerca Studi](./ricerca_studi.md)
- [Lista Studi](./lista_studi.md)
- [Gestione Disponibilità](./gestione_disponibilita.md)
- [Conferma Prenotazione](./conferma_prenotazione.md)

### File Tecnici
- `Modules/<nome progetto>/Widgets/StudioAvailabilityCalendarWidget.php`
- `Modules/<nome progetto>/Services/AvailabilityManagementService.php`
- `Modules/<nome progetto>/Actions/BookSlotAction.php`

---

**📅 Ultimo aggiornamento**: 5 Giugno 2025  
**👥 Stato sviluppo**: 🔄 **In Corso** (70%)  
**🔄 Prossimi passi**: Completamento integrazione filtri avanzati e ottimizzazioni performance