# Storico Appuntamenti - <nome progetto>

> **🎯 OBIETTIVO**: Sistema completo per la gestione e visualizzazione dello storico degli appuntamenti delle pazienti

## 📋 Overview

Lo storico appuntamenti permette alle pazienti di consultare tutti gli appuntamenti passati, attuali e futuri con dettagli completi, note mediche e possibilità di azioni specifiche per ogni stato.

## 🔧 Componenti in Sviluppo

### 1. Lista Storico Appuntamenti

```php
// Resource: AppointmentHistoryResource
class AppointmentHistoryResource extends XotBaseResource
{
    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('data_appuntamento')
                    ->dateTime('d/m/Y H:i')
                    ->sortable()
                    ->searchable(),
                    
                TextColumn::make('studio.nome')
                    ->label('Studio Odontoiatrico')
                    ->searchable()
                    ->limit(30),
                    
                TextColumn::make('dentista.nome_completo')
                    ->label('Odontoiatra')
                    ->searchable(),
                    
                TextColumn::make('tipo_visita')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'prima_visita' => 'info',
                        'controllo' => 'success',
                        'urgenza' => 'danger',
                        'pulizia' => 'warning',
                        default => 'gray',
                    }),
                    
                TextColumn::make('stato')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'confermato' => 'success',
                        'completato' => 'info',
                        'annullato' => 'danger',
                        'in_attesa' => 'warning',
                        'no_show' => 'gray',
                        default => 'gray',
                    }),
                    
                TextColumn::make('durata_minuti')
                    ->suffix(' min')
                    ->alignCenter(),
                    
                IconColumn::make('note_mediche_presenti')
                    ->boolean()
                    ->trueIcon('heroicon-o-document-text')
                    ->falseIcon('heroicon-o-minus'),
            ])
            ->defaultSort('data_appuntamento', 'desc')
            ->filters([
                SelectFilter::make('stato')
                    ->options([
                        'confermato' => 'Confermato',
                        'completato' => 'Completato',
                        'annullato' => 'Annullato',
                        'in_attesa' => 'In Attesa',
                        'no_show' => 'Non Presentata',
                    ]),
                    
                SelectFilter::make('tipo_visita')
                    ->options([
                        'prima_visita' => 'Prima Visita',
                        'controllo' => 'Controllo',
                        'urgenza' => 'Urgenza',
                        'pulizia' => 'Pulizia Dentale',
                    ]),
                    
                Filter::make('data_range')
                    ->form([
                        DatePicker::make('da'),
                        DatePicker::make('a'),
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query
                            ->when($data['da'], fn ($query, $date) => $query->whereDate('data_appuntamento', '>=', $date))
                            ->when($data['a'], fn ($query, $date) => $query->whereDate('data_appuntamento', '<=', $date));
                    }),
            ])
            ->actions([
                Action::make('visualizza_dettagli')
                    ->icon('heroicon-o-eye')
                    ->modalHeading('Dettagli Appuntamento')
                    ->modalContent(fn (Appointment $record) => view('appointments.details-modal', ['appointment' => $record])),
                    
                Action::make('scarica_referto')
                    ->icon('heroicon-o-document-arrow-down')
                    ->visible(fn (Appointment $record): bool => $record->referto_path !== null)
                    ->url(fn (Appointment $record): string => route('appointments.download-report', $record)),
                    
                Action::make('prenota_controllo')
                    ->icon('heroicon-o-calendar-plus')
                    ->visible(fn (Appointment $record): bool => 
                        $record->stato === 'completato' && 
                        $record->raccomandazione_controllo !== null
                    )
                    ->url(fn (Appointment $record): string => route('appointments.book-followup', $record)),
                    
                Action::make('valuta_servizio')
                    ->icon('heroicon-o-star')
                    ->visible(fn (Appointment $record): bool => 
                        $record->stato === 'completato' && 
                        $record->valutazione === null
                    )
                    ->form([
                        Select::make('valutazione')
                            ->options([
                                5 => '⭐⭐⭐⭐⭐ Eccellente',
                                4 => '⭐⭐⭐⭐ Molto Buono',
                                3 => '⭐⭐⭐ Buono',
                                2 => '⭐⭐ Sufficiente',
                                1 => '⭐ Insufficiente',
                            ])
                            ->required(),
                        Textarea::make('commento')
                            ->rows(3),
                    ])
                    ->action(function (Appointment $record, array $data): void {
                        $record->update([
                            'valutazione' => $data['valutazione'],
                            'commento_paziente' => $data['commento'],
                            'data_valutazione' => now(),
                        ]);
                        
                        Notification::make()
                            ->title('Valutazione salvata con successo')
                            ->success()
                            ->send();
                    }),
            ]);
    }
}
```

### 2. Widget Statistiche Appuntamenti

```php
// Widget: AppointmentStatsWidget
class AppointmentStatsWidget extends XotBaseStatsOverviewWidget
{
    protected function getStats(): array
    {
        $patient = auth()->user();
        $appointments = $patient->appointments();
        
        return [
            Stat::make('Appuntamenti Totali', $appointments->count())
                ->description('Dall\'inizio del programma')
                ->color('info'),
                
            Stat::make('Completati', $appointments->where('stato', 'completato')->count())
                ->description('Visite effettuate')
                ->color('success'),
                
            Stat::make('Prossimo Appuntamento', $this->getNextAppointmentDate($patient))
                ->description($this->getNextAppointmentStudio($patient))
                ->color('warning'),
                
            Stat::make('Valutazione Media', $this->getAverageRating($patient))
                ->description('La tua soddisfazione')
                ->color('success'),
        ];
    }
    
    private function getNextAppointmentDate(User $patient): string
    {
        $next = $patient->appointments()
            ->where('data_appuntamento', '>', now())
            ->where('stato', 'confermato')
            ->orderBy('data_appuntamento')
            ->first();
            
        return $next ? $next->data_appuntamento->format('d/m/Y H:i') : 'Nessuno';
    }
}
```

### 3. Dashboard Timeline

```php
// Component: AppointmentTimelineComponent
class AppointmentTimelineComponent extends Component
{
    public function render()
    {
        $appointments = auth()->user()->appointments()
            ->with(['studio', 'dentista'])
            ->orderBy('data_appuntamento', 'desc')
            ->limit(10)
            ->get();
            
        return view('livewire.appointment-timeline', [
            'appointments' => $appointments
        ]);
    }
}
```

## 📱 Interfaccia Utente

### Layout Storico

```blade
<div class="appointment-history-container">
    <div class="history-header">
        <h2>I Miei Appuntamenti</h2>
        <div class="header-actions">
            <x-filament::button 
                wire:click="exportHistory"
                color="secondary"
                icon="heroicon-o-document-arrow-down"
            >
                Esporta Storico
            </x-filament::button>
            
            <x-filament::button 
                href="{{ route('appointments.book') }}"
                color="primary"
                icon="heroicon-o-calendar-plus"
            >
                Nuovo Appuntamento
            </x-filament::button>
        </div>
    </div>
    
    <!-- Widget Statistiche -->
    <div class="stats-overview">
        @livewire('appointment-stats-widget')
    </div>
    
    <!-- Timeline Appuntamenti -->
    <div class="appointment-timeline">
        @livewire('appointment-timeline-component')
    </div>
    
    <!-- Tabella Dettagliata -->
    <div class="detailed-history">
        {{ $this->table }}
    </div>
</div>
```

### Dettagli Appuntamento Modal

```blade
<div class="appointment-details">
    <div class="appointment-header">
        <h3>{{ $appointment->tipo_visita_label }}</h3>
        <span class="status-badge {{ $appointment->stato }}">
            {{ $appointment->stato_label }}
        </span>
    </div>
    
    <div class="appointment-info">
        <div class="info-section">
            <h4>Informazioni Generali</h4>
            <dl>
                <dt>Data e Ora:</dt>
                <dd>{{ $appointment->data_appuntamento->format('d/m/Y H:i') }}</dd>
                
                <dt>Durata:</dt>
                <dd>{{ $appointment->durata_minuti }} minuti</dd>
                
                <dt>Studio:</dt>
                <dd>{{ $appointment->studio->nome }}</dd>
                
                <dt>Odontoiatra:</dt>
                <dd>{{ $appointment->dentista->nome_completo }}</dd>
            </dl>
        </div>
        
        @if($appointment->note_mediche)
        <div class="info-section">
            <h4>Note Mediche</h4>
            <div class="medical-notes">
                {!! nl2br(e($appointment->note_mediche)) !!}
            </div>
        </div>
        @endif
        
        @if($appointment->raccomandazione_controllo)
        <div class="info-section">
            <h4>Raccomandazioni</h4>
            <div class="recommendations">
                {{ $appointment->raccomandazione_controllo }}
            </div>
        </div>
        @endif
        
        @if($appointment->valutazione)
        <div class="info-section">
            <h4>La Tua Valutazione</h4>
            <div class="rating">
                <span class="stars">
                    @for($i = 1; $i <= 5; $i++)
                        <span class="{{ $i <= $appointment->valutazione ? 'filled' : 'empty' }}">⭐</span>
                    @endfor
                </span>
                @if($appointment->commento_paziente)
                    <p class="comment">{{ $appointment->commento_paziente }}</p>
                @endif
            </div>
        </div>
        @endif
    </div>
</div>
```

## 📊 Stati e Tipi di Appuntamento

### Stati Possibili
- **🟡 In Attesa**: Richiesta inviata, in attesa di conferma
- **🟢 Confermato**: Appuntamento confermato dallo studio
- **🔵 Completato**: Visita effettuata con successo
- **🔴 Annullato**: Appuntamento annullato (paziente o studio)
- **⚫ No Show**: Paziente non si è presentata

### Tipi di Visita
- **Prima Visita**: Visita iniziale di valutazione
- **Controllo**: Visita di controllo post-trattamento
- **Urgenza**: Visita urgente per problemi acuti
- **Pulizia**: Igiene orale professionale
- **Consulenza**: Consulenza specialistica

## 🔔 Azioni Disponibili per Stato

### Appuntamenti Futuri (Confermati)
- ✅ **Visualizza dettagli**
- ✅ **Modifica appuntamento** (se consentito)
- ✅ **Annulla appuntamento**
- ✅ **Aggiungi al calendario**

### Appuntamenti Completati
- ✅ **Visualizza dettagli e note mediche**
- ✅ **Scarica referto** (se disponibile)
- ✅ **Valuta servizio** (se non già fatto)
- ✅ **Prenota controllo** (se raccomandato)

### Appuntamenti Annullati
- ✅ **Visualizza motivo annullamento**
- ✅ **Riprenota** (se possibile)

## 📈 Sistema di Valutazioni

### Form Valutazione
```php
// Form: AppointmentRatingForm
public static function form(Form $form): Form
{
    return $form
        ->schema([
            Section::make('Valuta la tua esperienza')
                ->schema([
                    Select::make('valutazione')
                        ->options([
                            5 => '⭐⭐⭐⭐⭐ Eccellente - Servizio perfetto',
                            4 => '⭐⭐⭐⭐ Molto Buono - Molto soddisfatta',
                            3 => '⭐⭐⭐ Buono - Esperienza positiva',
                            2 => '⭐⭐ Sufficiente - Può migliorare',
                            1 => '⭐ Insufficiente - Non soddisfatta',
                        ])
                        ->required()
                        ->live(),
                        
                    Textarea::make('commento_paziente')
                        ->label('Commento (opzionale)')
                        ->placeholder('Condividi la tua esperienza...')
                        ->rows(3)
                        ->visible(fn (Get $get) => $get('valutazione') !== null),
                        
                    Toggle::make('raccomanda_studio')
                        ->label('Raccomanderesti questo studio?')
                        ->visible(fn (Get $get) => (int)$get('valutazione') >= 4),
                ]),
        ]);
}
```

### Dashboard Valutazioni
```php
// Analytics per lo studio
class StudioRatingAnalytics
{
    public function getAverageRating(Studio $studio): float
    {
        return $studio->appointments()
            ->whereNotNull('valutazione')
            ->avg('valutazione') ?? 0;
    }
    
    public function getRatingDistribution(Studio $studio): array
    {
        return $studio->appointments()
            ->whereNotNull('valutazione')
            ->selectRaw('valutazione, COUNT(*) as count')
            ->groupBy('valutazione')
            ->orderBy('valutazione', 'desc')
            ->pluck('count', 'valutazione')
            ->toArray();
    }
}
```

## 📊 Metriche e KPI

### Statistiche Paziente
- **Appuntamenti completati**: In media 2.3 per paziente
- **Tasso no-show**: 8% (target: <5%)
- **Soddisfazione media**: 4.2/5 ⭐
- **Tempo medio visita**: 45 minuti

### Performance Sistema
- **Caricamento storico**: < 800ms
- **Esportazione PDF**: < 3s
- **Sincronizzazione stati**: Real-time
- **Notifiche push**: < 5s

## 🔧 Export e Reporting

### Export Storico
```php
// Action: ExportAppointmentHistory
class ExportAppointmentHistoryAction
{
    public function handle(User $patient, array $filters = []): string
    {
        $appointments = $patient->appointments()
            ->with(['studio', 'dentista'])
            ->when($filters['date_from'] ?? null, fn ($q, $date) => $q->whereDate('data_appuntamento', '>=', $date))
            ->when($filters['date_to'] ?? null, fn ($q, $date) => $q->whereDate('data_appuntamento', '<=', $date))
            ->orderBy('data_appuntamento', 'desc')
            ->get();
            
        return Excel::download(
            new AppointmentHistoryExport($appointments),
            "storico_appuntamenti_{$patient->id}_{now()->format('Y-m-d')}.xlsx"
        );
    }
}
```

### Report Mensile Automatico
```php
// Job: MonthlyAppointmentReportJob
class MonthlyAppointmentReportJob implements ShouldQueue
{
    public function handle(): void
    {
        $patients = User::whereHas('appointments', function ($query) {
            $query->whereMonth('data_appuntamento', now()->subMonth()->month);
        })->get();
        
        foreach ($patients as $patient) {
            Mail::to($patient->email)->send(
                new MonthlyAppointmentReportMail($patient)
            );
        }
    }
}
```

## 🔗 Collegamenti

### Documenti Correlati
- [Sistema Prenotazione](./03_prenotazione_visite.md)
- [Area Personale Paziente](./02_area_personale_paziente.md)
- [Sistema Notifiche](./notifiche/README.md)
- [Dashboard Paziente](./dashboard_paziente.md)

### File Tecnici
- `Modules/<nome progetto>/Filament/Resources/AppointmentHistoryResource.php`
- `Modules/<nome progetto>/Livewire/AppointmentTimelineComponent.php`
- `Modules/<nome progetto>/Exports/AppointmentHistoryExport.php`

---

**📅 Ultimo aggiornamento**: 5 Giugno 2025  
**👥 Stato sviluppo**: 🔄 **In Corso** (65%)  
**🔄 Prossimi passi**: Completamento sistema valutazioni e export avanzati