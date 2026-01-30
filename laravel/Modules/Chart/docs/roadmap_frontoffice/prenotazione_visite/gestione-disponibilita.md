# Gestione Disponibilità Dentisti - <nome progetto>

> **🎯 OBIETTIVO**: Sistema avanzato per la gestione automatica e manuale delle disponibilità degli studi odontoiatrici

## 📋 Overview

La gestione delle disponibilità permette agli studi odontoiatrici di configurare orari, creare slot personalizzati, gestire eccezioni e automatizzare la generazione di slot disponibili per le prenotazioni.

## 🔧 Componenti in Sviluppo

### 1. Resource Gestione Disponibilità

```php
// Resource: AvailabilityManagementResource
class AvailabilityManagementResource extends XotBaseResource
{
    protected static ?string $model = Availability::class;
    
    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Informazioni Base')
                    ->schema([
                        Select::make('dentista_id')
                            ->relationship('dentista', 'nome_completo')
                            ->required()
                            ->searchable()
                            ->preload(),
                            
                        Select::make('tipo_visita')
                            ->options([
                                'prima_visita' => 'Prima Visita (60 min)',
                                'controllo' => 'Controllo (30 min)',
                                'pulizia' => 'Igiene Orale (45 min)',
                                'urgenza' => 'Urgenza (30 min)',
                                'specialistica' => 'Visita Specialistica (90 min)',
                            ])
                            ->required()
                            ->live()
                            ->afterStateUpdated(fn ($state, callable $set) => 
                                $set('durata_minuti', self::getDurataByTipo($state))),
                                
                        TextInput::make('durata_minuti')
                            ->numeric()
                            ->required()
                            ->minValue(15)
                            ->maxValue(180)
                            ->step(15)
                            ->suffix('minuti'),
                    ])->columns(3),
                    
                Section::make('Programmazione')
                    ->schema([
                        DateTimePicker::make('data_ora')
                            ->required()
                            ->native(false)
                            ->displayFormat('d/m/Y H:i')
                            ->minDate(now())
                            ->maxDate(now()->addMonths(6))
                            ->minuteStep(15),
                            
                        Toggle::make('ricorrente')
                            ->live()
                            ->helperText('Crea slot ricorrenti con le stesse impostazioni'),
                            
                        Grid::make(2)
                            ->schema([
                                Select::make('ricorrenza_tipo')
                                    ->options([
                                        'giornaliera' => 'Giornaliera',
                                        'settimanale' => 'Settimanale',
                                        'mensile' => 'Mensile',
                                    ])
                                    ->visible(fn (Get $get) => $get('ricorrente')),
                                    
                                TextInput::make('ricorrenza_fino_a')
                                    ->type('date')
                                    ->visible(fn (Get $get) => $get('ricorrente')),
                            ])
                            ->visible(fn (Get $get) => $get('ricorrente')),
                    ])->columns(2),
                    
                Section::make('Configurazioni Avanzate')
                    ->schema([
                        TextInput::make('posti_disponibili')
                            ->numeric()
                            ->default(1)
                            ->minValue(1)
                            ->maxValue(10)
                            ->helperText('Numero di pazienti che possono prenotare questo slot'),
                            
                        Select::make('priorita')
                            ->options([
                                'bassa' => 'Bassa',
                                'normale' => 'Normale',
                                'alta' => 'Alta',
                                'urgente' => 'Urgente',
                            ])
                            ->default('normale'),
                            
                        Textarea::make('note')
                            ->rows(3)
                            ->maxLength(500)
                            ->helperText('Note per il paziente (visibili durante la prenotazione)'),
                            
                        Toggle::make('solo_nuovi_pazienti')
                            ->helperText('Slot riservato solo a pazienti al primo accesso'),
                            
                        Toggle::make('conferma_automatica')
                            ->default(true)
                            ->helperText('Conferma automaticamente le prenotazioni'),
                    ])->columns(2),
                    
                Section::make('Requisiti Paziente')
                    ->schema([
                        CheckboxList::make('documenti_richiesti')
                            ->options([
                                'tessera_sanitaria' => 'Tessera Sanitaria',
                                'certificato_isee' => 'Certificato ISEE',
                                'attestazione_gravidanza' => 'Attestazione Gravidanza',
                                'prescrizione_medica' => 'Prescrizione Medica',
                            ])
                            ->helperText('Documenti che il paziente deve aver caricato'),
                            
                        TextInput::make('settimane_gestazione_min')
                            ->numeric()
                            ->minValue(1)
                            ->maxValue(42)
                            ->suffix('settimane')
                            ->helperText('Settimane minime di gestazione richieste'),
                            
                        TextInput::make('settimane_gestazione_max')
                            ->numeric()
                            ->minValue(1)
                            ->maxValue(42)
                            ->suffix('settimane')
                            ->helperText('Settimane massime di gestazione accettate'),
                    ])->columns(3),
            ]);
    }
    
    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('data_ora')
                    ->dateTime('d/m/Y H:i')
                    ->sortable(),
                    
                TextColumn::make('dentista.nome_completo')
                    ->searchable(),
                    
                TextColumn::make('tipo_visita')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'prima_visita' => 'success',
                        'controllo' => 'info',
                        'urgenza' => 'danger',
                        'pulizia' => 'warning',
                        default => 'gray',
                    }),
                    
                TextColumn::make('durata_minuti')
                    ->suffix(' min'),
                    
                IconColumn::make('prenotato')
                    ->boolean()
                    ->trueIcon('heroicon-o-user')
                    ->falseIcon('heroicon-o-calendar')
                    ->trueColor('success')
                    ->falseColor('warning'),
                    
                TextColumn::make('posti_disponibili')
                    ->alignCenter(),
                    
                TextColumn::make('priorita')
                    ->badge(),
            ])
            ->filters([
                SelectFilter::make('dentista_id')
                    ->relationship('dentista', 'nome_completo'),
                    
                SelectFilter::make('tipo_visita'),
                
                Filter::make('data_range')
                    ->form([
                        DatePicker::make('data_da'),
                        DatePicker::make('data_a'),
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query
                            ->when($data['data_da'], fn ($query, $date) => $query->whereDate('data_ora', '>=', $date))
                            ->when($data['data_a'], fn ($query, $date) => $query->whereDate('data_ora', '<=', $date));
                    }),
                    
                TernaryFilter::make('prenotato'),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
                
                Action::make('duplica')
                    ->icon('heroicon-o-document-duplicate')
                    ->action(function (Availability $record): void {
                        $record->replicate()->save();
                    }),
                    
                Action::make('genera_ricorrenza')
                    ->icon('heroicon-o-arrow-path')
                    ->visible(fn (Availability $record): bool => !$record->prenotato)
                    ->form([
                        Select::make('tipo_ricorrenza')
                            ->options([
                                'settimanale' => 'Settimanale',
                                'bi_settimanale' => 'Bi-settimanale',
                                'mensile' => 'Mensile',
                            ])
                            ->required(),
                        DatePicker::make('fino_a')
                            ->required()
                            ->minDate(now()->addWeek()),
                    ])
                    ->action(function (Availability $record, array $data): void {
                        app(GenerateRecurringAvailabilitiesAction::class)
                            ->execute($record, $data);
                    }),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                    
                    BulkAction::make('aggiorna_durata')
                        ->icon('heroicon-o-clock')
                        ->form([
                            TextInput::make('nuova_durata')
                                ->numeric()
                                ->required()
                                ->minValue(15)
                                ->maxValue(180)
                                ->step(15)
                                ->suffix('minuti'),
                        ])
                        ->action(function (Collection $records, array $data): void {
                            $records->each(function ($record) use ($data) {
                                if (!$record->prenotato) {
                                    $record->update(['durata_minuti' => $data['nuova_durata']]);
                                }
                            });
                        }),
                ]),
            ]);
    }
}
```

### 2. Widget Generazione Automatica Slot

```php
// Widget: AutoSlotGeneratorWidget
class AutoSlotGeneratorWidget extends Widget
{
    protected static string $view = 'widgets.auto-slot-generator';
    
    public Studio $studio;
    public array $configurazione = [
        'giorni_settimana' => [],
        'orario_inizio' => '09:00',
        'orario_fine' => '18:00',
        'pausa_pranzo_inizio' => '13:00',
        'pausa_pranzo_fine' => '14:00',
        'durata_slot_default' => 30,
        'genera_fino_a' => null,
    ];
    
    public function generaSlotAutomatici()
    {
        $this->validate([
            'configurazione.giorni_settimana' => 'required|array|min:1',
            'configurazione.orario_inizio' => 'required',
            'configurazione.orario_fine' => 'required',
            'configurazione.genera_fino_a' => 'required|date|after:today',
        ]);
        
        try {
            $slotsGenerati = app(AutoSlotGeneratorAction::class)
                ->execute($this->studio, $this->configurazione);
                
            Notification::make()
                ->title("Generati {$slotsGenerati} slot automaticamente")
                ->success()
                ->send();
                
        } catch (Exception $e) {
            Notification::make()
                ->title('Errore nella generazione automatica')
                ->body($e->getMessage())
                ->danger()
                ->send();
        }
    }
    
    public function resetConfigurazione()
    {
        $this->configurazione = [
            'giorni_settimana' => [],
            'orario_inizio' => '09:00',
            'orario_fine' => '18:00',
            'pausa_pranzo_inizio' => '13:00',
            'pausa_pranzo_fine' => '14:00',
            'durata_slot_default' => 30,
            'genera_fino_a' => null,
        ];
    }
}
```

### 3. Action Generazione Ricorrenze

```php
// Action: GenerateRecurringAvailabilitiesAction
class GenerateRecurringAvailabilitiesAction
{
    public function execute(Availability $baseSlot, array $config): int
    {
        $slotsCreated = 0;
        $currentDate = $baseSlot->data_ora;
        $endDate = Carbon::parse($config['fino_a']);
        
        while ($currentDate->lessThanOrEqualTo($endDate)) {
            $currentDate = $this->getNextOccurrence($currentDate, $config['tipo_ricorrenza']);
            
            if ($currentDate->lessThanOrEqualTo($endDate)) {
                // Verifica se esiste già uno slot in questo orario
                $existingSlot = Availability::where('dentista_id', $baseSlot->dentista_id)
                    ->where('data_ora', $currentDate)
                    ->first();
                    
                if (!$existingSlot) {
                    Availability::create([
                        'dentista_id' => $baseSlot->dentista_id,
                        'studio_id' => $baseSlot->studio_id,
                        'data_ora' => $currentDate,
                        'durata_minuti' => $baseSlot->durata_minuti,
                        'tipo_visita' => $baseSlot->tipo_visita,
                        'posti_disponibili' => $baseSlot->posti_disponibili,
                        'priorita' => $baseSlot->priorita,
                        'note' => $baseSlot->note,
                        'solo_nuovi_pazienti' => $baseSlot->solo_nuovi_pazienti,
                        'conferma_automatica' => $baseSlot->conferma_automatica,
                        'documenti_richiesti' => $baseSlot->documenti_richiesti,
                        'settimane_gestazione_min' => $baseSlot->settimane_gestazione_min,
                        'settimane_gestazione_max' => $baseSlot->settimane_gestazione_max,
                    ]);
                    
                    $slotsCreated++;
                }
            }
        }
        
        return $slotsCreated;
    }
    
    private function getNextOccurrence(Carbon $date, string $tipo): Carbon
    {
        return match($tipo) {
            'settimanale' => $date->addWeek(),
            'bi_settimanale' => $date->addWeeks(2),
            'mensile' => $date->addMonth(),
            default => $date->addWeek()
        };
    }
}
```

## 📱 Interfaccia di Configurazione

### Widget Generazione Automatica

```blade
<div class="auto-slot-generator">
    <div class="generator-header">
        <h3>Generazione Automatica Slot</h3>
        <p>Configura la generazione automatica degli slot di disponibilità</p>
    </div>
    
    <form wire:submit="generaSlotAutomatici">
        <div class="config-section">
            <h4>Giorni della Settimana</h4>
            <div class="days-grid">
                @foreach(['lunedi', 'martedi', 'mercoledi', 'giovedi', 'venerdi', 'sabato', 'domenica'] as $giorno)
                    <label class="day-checkbox">
                        <input type="checkbox" 
                               wire:model="configurazione.giorni_settimana" 
                               value="{{ $giorno }}">
                        <span>{{ ucfirst($giorno) }}</span>
                    </label>
                @endforeach
            </div>
        </div>
        
        <div class="config-section">
            <h4>Orari di Lavoro</h4>
            <div class="time-config">
                <div class="time-input">
                    <label>Inizio</label>
                    <input type="time" wire:model="configurazione.orario_inizio" step="900">
                </div>
                <div class="time-input">
                    <label>Fine</label>
                    <input type="time" wire:model="configurazione.orario_fine" step="900">
                </div>
            </div>
        </div>
        
        <div class="config-section">
            <h4>Pausa Pranzo</h4>
            <div class="time-config">
                <div class="time-input">
                    <label>Inizio Pausa</label>
                    <input type="time" wire:model="configurazione.pausa_pranzo_inizio" step="900">
                </div>
                <div class="time-input">
                    <label>Fine Pausa</label>
                    <input type="time" wire:model="configurazione.pausa_pranzo_fine" step="900">
                </div>
            </div>
        </div>
        
        <div class="config-section">
            <h4>Configurazione Slot</h4>
            <div class="slot-config">
                <div class="duration-input">
                    <label>Durata Slot Default</label>
                    <select wire:model="configurazione.durata_slot_default">
                        <option value="15">15 minuti</option>
                        <option value="30">30 minuti</option>
                        <option value="45">45 minuti</option>
                        <option value="60">60 minuti</option>
                        <option value="90">90 minuti</option>
                    </select>
                </div>
                
                <div class="date-input">
                    <label>Genera Fino Al</label>
                    <input type="date" 
                           wire:model="configurazione.genera_fino_a"
                           min="{{ now()->addDay()->format('Y-m-d') }}"
                           max="{{ now()->addMonths(6)->format('Y-m-d') }}">
                </div>
            </div>
        </div>
        
        <div class="generator-actions">
            <button type="submit" class="btn btn-primary">
                <i class="icon-magic-wand"></i>
                Genera Slot Automatici
            </button>
            
            <button type="button" wire:click="resetConfigurazione" class="btn btn-secondary">
                <i class="icon-refresh"></i>
                Reset Configurazione
            </button>
        </div>
    </form>
</div>
```

### Dashboard Riepilogo Disponibilità

```blade
<div class="availability-dashboard">
    <div class="dashboard-stats">
        <div class="stat-card">
            <div class="stat-icon">📅</div>
            <div class="stat-info">
                <span class="stat-value">{{ $totaleSlot }}</span>
                <span class="stat-label">Slot Totali</span>
            </div>
        </div>
        
        <div class="stat-card">
            <div class="stat-icon">✅</div>
            <div class="stat-info">
                <span class="stat-value">{{ $slotPrenotati }}</span>
                <span class="stat-label">Prenotati</span>
            </div>
        </div>
        
        <div class="stat-card">
            <div class="stat-icon">🟡</div>
            <div class="stat-info">
                <span class="stat-value">{{ $slotDisponibili }}</span>
                <span class="stat-label">Disponibili</span>
            </div>
        </div>
        
        <div class="stat-card">
            <div class="stat-icon">📈</div>
            <div class="stat-info">
                <span class="stat-value">{{ $tassoOccupazione }}%</span>
                <span class="stat-label">Tasso Occupazione</span>
            </div>
        </div>
    </div>
    
    <div class="availability-calendar-mini">
        <h4>Panoramica Settimanale</h4>
        <div class="mini-calendar">
            @foreach($prossimaSettimana as $giorno)
                <div class="day-column">
                    <div class="day-header">{{ $giorno['nome'] }}</div>
                    <div class="day-slots">
                        @foreach($giorno['slot'] as $slot)
                            <div class="mini-slot {{ $slot['stato'] }}">
                                {{ $slot['ora'] }}
                            </div>
                        @endforeach
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>
```

## 🔄 Logica di Business Avanzata

### Algoritmo Smart Scheduling

```php
// Service: SmartSchedulingService
class SmartSchedulingService
{
    public function suggerisciFasceOrarie(Studio $studio, array $parametri): array
    {
        $analisiStorico = $this->analizzaStoricoPrenotazioni($studio);
        $disponibilitaAttuali = $this->getDisponibilitaAttuali($studio);
        
        return [
            'fasce_popolari' => $this->getFasceOrariePopolari($analisiStorico),
            'gap_da_riempire' => $this->identificaGapDisponibilita($disponibilitaAttuali),
            'suggerimenti_ottimizzazione' => $this->getSuggerimentiOttimizzazione($studio),
        ];
    }
    
    public function calcolaCapacitaOttimale(Studio $studio): array
    {
        $dentistaCount = $studio->dentisti()->count();
        $oreLavorativeGiorno = 8; // Assumendo 8 ore al giorno
        $slotMediDurata = 45; // 45 minuti di media
        
        $capacitaTeoricoGiorno = ($oreLavorativeGiorno * 60 / $slotMediDurata) * $dentistaCount;
        $fattoreEfficienza = 0.8; // 80% di efficienza
        
        return [
            'capacita_teorica_giorno' => $capacitaTeoricoGiorno,
            'capacita_pratica_giorno' => $capacitaTeoricoGiorno * $fattoreEfficienza,
            'suggerimento_slot_settimanali' => $capacitaTeoricoGiorno * $fattoreEfficienza * 6, // 6 giorni lavorativi
        ];
    }
}
```

### Gestione Conflitti e Sovrapposizioni

```php
// Service: ConflictResolutionService
class ConflictResolutionService
{
    public function verificaConflitti(array $nuovoSlot): array
    {
        $conflitti = [];
        
        // Verifica sovrapposizioni con slot esistenti
        $sovrapposizioni = $this->checkOverlappingSlots($nuovoSlot);
        if ($sovrapposizioni->isNotEmpty()) {
            $conflitti[] = [
                'tipo' => 'sovrapposizione',
                'slot_conflittuali' => $sovrapposizioni,
                'gravita' => 'alta'
            ];
        }
        
        // Verifica disponibilità dentista
        $disponibilitaDentista = $this->checkDentistaAvailability($nuovoSlot);
        if (!$disponibilitaDentista) {
            $conflitti[] = [
                'tipo' => 'dentista_non_disponibile',
                'motivo' => 'Il dentista ha altri impegni in questo orario',
                'gravita' => 'critica'
            ];
        }
        
        // Verifica orari di apertura studio
        $orariStudio = $this->checkStudioHours($nuovoSlot);
        if (!$orariStudio) {
            $conflitti[] = [
                'tipo' => 'fuori_orario',
                'motivo' => 'Orario al di fuori degli orari di apertura',
                'gravita' => 'media'
            ];
        }
        
        return $conflitti;
    }
    
    public function risolviConflitti(array $conflitti, array $preferenze = []): array
    {
        $soluzioni = [];
        
        foreach ($conflitti as $conflitto) {
            switch ($conflitto['tipo']) {
                case 'sovrapposizione':
                    $soluzioni[] = $this->proponiAlternativi($conflitto);
                    break;
                    
                case 'dentista_non_disponibile':
                    $soluzioni[] = $this->proponiAltriDentisti($conflitto);
                    break;
                    
                case 'fuori_orario':
                    $soluzioni[] = $this->proponiOrariAlternativi($conflitto);
                    break;
            }
        }
        
        return $soluzioni;
    }
}
```

## 📊 Analytics e Reporting

### Dashboard Performance Disponibilità

```php
// Widget: AvailabilityPerformanceWidget
class AvailabilityPerformanceWidget extends Widget
{
    public function getPerformanceData(): array
    {
        $studio = Filament::getTenant();
        
        return [
            'utilizzo_settimana_corrente' => $this->getWeeklyUtilization($studio),
            'trend_prenotazioni' => $this->getBookingTrend($studio),
            'slot_piu_richiesti' => $this->getMostRequestedSlots($studio),
            'tempi_medi_prenotazione' => $this->getAverageBookingTimes($studio),
            'tasso_no_show' => $this->getNoShowRate($studio),
        ];
    }
    
    private function getWeeklyUtilization(Studio $studio): array
    {
        $startWeek = now()->startOfWeek();
        $endWeek = now()->endOfWeek();
        
        $totalSlots = Availability::where('studio_id', $studio->id)
            ->whereBetween('data_ora', [$startWeek, $endWeek])
            ->count();
            
        $bookedSlots = Availability::where('studio_id', $studio->id)
            ->whereBetween('data_ora', [$startWeek, $endWeek])
            ->where('prenotato', true)
            ->count();
            
        return [
            'totale' => $totalSlots,
            'prenotati' => $bookedSlots,
            'percentuale' => $totalSlots > 0 ? round(($bookedSlots / $totalSlots) * 100, 1) : 0,
        ];
    }
}
```

### Report Ottimizzazione

```php
// Report: AvailabilityOptimizationReport
class AvailabilityOptimizationReport
{
    public function generate(Studio $studio): array
    {
        return [
            'summary' => $this->generateSummary($studio),
            'recommendations' => $this->generateRecommendations($studio),
            'predictions' => $this->generatePredictions($studio),
            'actionable_insights' => $this->generateActionableInsights($studio),
        ];
    }
    
    private function generateRecommendations(Studio $studio): array
    {
        $recommendations = [];
        
        // Analizza pattern di prenotazione
        $hourlyBookings = $this->getHourlyBookingPattern($studio);
        
        // Identifica ore sottoutilizzate
        $underutilizedHours = array_filter($hourlyBookings, fn($booking) => $booking['rate'] < 0.3);
        
        if (!empty($underutilizedHours)) {
            $recommendations[] = [
                'tipo' => 'riduzione_slot',
                'priorita' => 'media',
                'descrizione' => 'Considera di ridurre gli slot in orari poco richiesti',
                'orari_interessati' => array_keys($underutilizedHours),
                'impatto_stimato' => 'Aumento efficienza del 15%',
            ];
        }
        
        // Identifica ore sovraccariche
        $overutilizedHours = array_filter($hourlyBookings, fn($booking) => $booking['rate'] > 0.9);
        
        if (!empty($overutilizedHours)) {
            $recommendations[] = [
                'tipo' => 'aumento_slot',
                'priorita' => 'alta',
                'descrizione' => 'Aggiungi più slot negli orari di maggiore richiesta',
                'orari_interessati' => array_keys($overutilizedHours),
                'impatto_stimato' => 'Aumento fatturato del 20%',
            ];
        }
        
        return $recommendations;
    }
}
```

## 🔧 Automazioni e AI

### Sistema Predittivo

```php
// Service: PredictiveSchedulingService
class PredictiveSchedulingService
{
    public function prediciDomanda(Studio $studio, Carbon $data): array
    {
        // Analizza dati storici per predire la domanda
        $storicoStessoGiorno = $this->getHistoricalDataForDay($studio, $data->dayOfWeek);
        $tendenzaRecente = $this->getRecentTrend($studio);
        $fattoriStagionali = $this->getSeasonalFactors($data);
        
        $predizione = [
            'probabilita_alta_domanda' => $this->calculateHighDemandProbability($storicoStessoGiorno, $tendenzaRecente),
            'slot_consigliati' => $this->suggestOptimalSlots($studio, $data),
            'fascia_oraria_ottimale' => $this->getOptimalTimeRange($storicoStessoGiorno),
        ];
        
        return $predizione;
    }
    
    public function suggerisciSlotDinamici(Studio $studio): array
    {
        $prossimi7Giorni = collect(range(0, 6))->map(fn($i) => now()->addDays($i));
        
        return $prossimi7Giorni->map(function ($data) use ($studio) {
            $predizione = $this->prediciDomanda($studio, $data);
            
            return [
                'data' => $data,
                'slot_suggeriti' => $predizione['slot_consigliati'],
                'confidenza' => $predizione['probabilita_alta_domanda'],
            ];
        })->toArray();
    }
}
```

## 🔗 Collegamenti

### Documenti Correlati
- [Calendario Disponibilità](./calendario_disponibilita.md)
- [Lista Studi](./lista_studi.md)
- [Area Odontoiatra](../area_odontoiatra/dashboard_studio.md)
- [Sistema Prenotazione](../03_prenotazione_visite.md)

### File Tecnici
- `Modules/<nome progetto>/Filament/Resources/AvailabilityManagementResource.php`
- `Modules/<nome progetto>/Actions/GenerateRecurringAvailabilitiesAction.php`
- `Modules/<nome progetto>/Services/SmartSchedulingService.php`

---

**📅 Ultimo aggiornamento**: 5 Giugno 2025  
**👥 Stato sviluppo**: 🔄 **In Corso** (60%)  
**🔄 Prossimi passi**: Completamento sistema predittivo e automazioni AI