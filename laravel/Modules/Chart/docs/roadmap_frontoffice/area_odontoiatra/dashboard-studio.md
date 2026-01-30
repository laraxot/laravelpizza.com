# Dashboard Studio - <nome progetto>

> **🎯 OBIETTIVO**: Dashboard completa per la gestione operativa degli studi odontoiatrici con analytics avanzate e controllo attività

## 📋 Overview

La Dashboard Studio fornisce una vista unificata di tutte le attività dello studio, dalle prenotazioni giornaliere alle statistiche mensili, con strumenti di gestione rapida e monitoraggio performance in tempo reale.

## 🔧 Componenti Implementati

### 1. Page Dashboard Principale

```php
// Page: StudioDashboardPage
class StudioDashboardPage extends Page
{
    protected static string $view = '<nome progetto>::filament.pages.studio-dashboard';
    
    public Studio $studio;
    public array $dateRange = [];
    public string $selectedPeriod = 'today';
    
    protected function getHeaderWidgets(): array
    {
        return [
            StudioStatsOverviewWidget::class,
            AppointmentsTodayWidget::class,
            RevenueChartWidget::class,
            UpcomingAppointmentsWidget::class,
        ];
    }
    
    protected function getFooterWidgets(): array
    {
        return [
            MonthlyPerformanceWidget::class,
            PatientSatisfactionWidget::class,
            QuickActionsWidget::class,
        ];
    }
    
    public function mount(): void
    {
        $this->studio = Filament::getTenant();
        $this->dateRange = [now()->startOfMonth(), now()];
    }
    
    public function updatePeriod(string $period): void
    {
        $this->selectedPeriod = $period;
        
        $this->dateRange = match($period) {
            'today' => [now()->startOfDay(), now()],
            'week' => [now()->startOfWeek(), now()],
            'month' => [now()->startOfMonth(), now()],
            'quarter' => [now()->startOfQuarter(), now()],
            'year' => [now()->startOfYear(), now()],
            default => $this->dateRange
        };
        
        $this->dispatch('period-updated', $this->dateRange);
    }
}
```

### 2. Widget Statistiche Overview

```php
// Widget: StudioStatsOverviewWidget
class StudioStatsOverviewWidget extends StatsOverviewWidget
{
    protected function getStats(): array
    {
        $studio = Filament::getTenant();
        $today = now();
        
        return [
            Stat::make('Appuntamenti Oggi', $this->getTodayAppointments($studio))
                ->description('Appuntamenti programmati per oggi')
                ->descriptionIcon('heroicon-m-calendar-days')
                ->chart($this->getWeeklyAppointmentsChart($studio))
                ->color('success'),
                
            Stat::make('Pazienti Totali', $this->getTotalPatients($studio))
                ->description($this->getNewPatientsThisMonth($studio) . ' nuovi questo mese')
                ->descriptionIcon('heroicon-m-user-group')
                ->color('info'),
                
            Stat::make('Tasso Occupazione', $this->getOccupancyRate($studio) . '%')
                ->description('Negli ultimi 7 giorni')
                ->descriptionIcon('heroicon-m-chart-bar')
                ->chart($this->getOccupancyChart($studio))
                ->color($this->getOccupancyColor($this->getOccupancyRate($studio))),
                
            Stat::make('Valutazione Media', $this->getAverageRating($studio))
                ->description('Basata su ' . $this->getTotalReviews($studio) . ' recensioni')
                ->descriptionIcon('heroicon-m-star')
                ->color('warning'),
                
            Stat::make('No-Show Rate', $this->getNoShowRate($studio) . '%')
                ->description('Ultimo mese')
                ->descriptionIcon('heroicon-m-exclamation-triangle')
                ->color($this->getNoShowColor($this->getNoShowRate($studio))),
        ];
    }
    
    private function getTodayAppointments(Studio $studio): int
    {
        return Appointment::where('studio_id', $studio->id)
            ->whereDate('data_appuntamento', now())
            ->where('stato', '!=', 'annullato')
            ->count();
    }
    
    private function getOccupancyRate(Studio $studio): float
    {
        $totalSlots = Availability::where('studio_id', $studio->id)
            ->whereBetween('data_ora', [now()->subDays(7), now()])
            ->count();
            
        $bookedSlots = Availability::where('studio_id', $studio->id)
            ->whereBetween('data_ora', [now()->subDays(7), now()])
            ->where('prenotato', true)
            ->count();
            
        return $totalSlots > 0 ? round(($bookedSlots / $totalSlots) * 100, 1) : 0;
    }
}
```

### 3. Widget Appuntamenti di Oggi

```php
// Widget: AppointmentsTodayWidget
class AppointmentsTodayWidget extends Widget
{
    protected static string $view = 'widgets.appointments-today';
    protected int | string | array $columnSpan = 'full';
    
    public function getAppointmentsToday(): Collection
    {
        $studio = Filament::getTenant();
        
        return Appointment::where('studio_id', $studio->id)
            ->whereDate('data_appuntamento', now())
            ->with(['patient', 'dentista', 'servizi'])
            ->orderBy('data_appuntamento')
            ->get();
    }
    
    public function updateAppointmentStatus(int $appointmentId, string $newStatus): void
    {
        $appointment = Appointment::find($appointmentId);
        
        if ($appointment && $appointment->studio_id === Filament::getTenant()->id) {
            $appointment->update(['stato' => $newStatus]);
            
            // Invia notifiche se necessario
            if ($newStatus === 'completato') {
                $this->sendCompletionNotifications($appointment);
            }
            
            $this->dispatch('appointment-updated');
        }
    }
    
    public function markAsNoShow(int $appointmentId): void
    {
        $this->updateAppointmentStatus($appointmentId, 'no_show');
        
        Notification::make()
            ->title('Appuntamento marcato come No-Show')
            ->success()
            ->send();
    }
}
```

### 4. Widget Azioni Rapide

```php
// Widget: QuickActionsWidget
class QuickActionsWidget extends Widget
{
    protected static string $view = 'widgets.quick-actions';
    
    public function createNewSlot(): void
    {
        $this->redirect(route('filament.admin.resources.availabilities.create'));
    }
    
    public function viewTodaySchedule(): void
    {
        $this->dispatch('open-modal', id: 'today-schedule-modal');
    }
    
    public function generateReport(): void
    {
        $studio = Filament::getTenant();
        
        try {
            $report = app(GenerateStudioReportAction::class)->execute([
                'studio_id' => $studio->id,
                'period' => 'month',
                'format' => 'pdf'
            ]);
            
            $this->dispatch('download-file', url: $report['download_url']);
            
            Notification::make()
                ->title('Report generato con successo')
                ->success()
                ->send();
                
        } catch (Exception $e) {
            Notification::make()
                ->title('Errore nella generazione del report')
                ->body($e->getMessage())
                ->danger()
                ->send();
        }
    }
    
    public function exportAppointments(): void
    {
        $studio = Filament::getTenant();
        
        $appointments = Appointment::where('studio_id', $studio->id)
            ->whereBetween('data_appuntamento', [now()->startOfMonth(), now()])
            ->with(['patient', 'dentista'])
            ->get();
            
        return Excel::download(
            new AppointmentsExport($appointments), 
            'appuntamenti_' . now()->format('Y_m') . '.xlsx'
        );
    }
}
```

## 📱 Interfaccia Dashboard

### Layout Principale

```blade
<div class="studio-dashboard">
    <!-- Header con Info Studio -->
    <div class="dashboard-header">
        <div class="studio-info">
            <div class="studio-avatar">
                @if($studio->logo)
                    <img src="{{ $studio->logo_url }}" alt="{{ $studio->nome }}">
                @else
                    <div class="avatar-placeholder">{{ substr($studio->nome, 0, 2) }}</div>
                @endif
            </div>
            
            <div class="studio-details">
                <h1>{{ $studio->nome }}</h1>
                <p class="studio-address">{{ $studio->indirizzo_completo }}</p>
                <div class="studio-status">
                    <span class="status-badge {{ $studio->stato }}">{{ $studio->stato_label }}</span>
                    <span class="last-activity">Ultimo accesso: {{ $studio->last_activity_at?->diffForHumans() }}</span>
                </div>
            </div>
        </div>
        
        <div class="dashboard-controls">
            <div class="period-selector">
                <select wire:model.live="selectedPeriod" class="period-select">
                    <option value="today">Oggi</option>
                    <option value="week">Questa Settimana</option>
                    <option value="month">Questo Mese</option>
                    <option value="quarter">Questo Trimestre</option>
                    <option value="year">Quest'Anno</option>
                </select>
            </div>
            
            <div class="quick-actions">
                <button class="btn btn-primary" wire:click="createNewSlot">
                    <i class="icon-plus"></i>
                    Nuovo Slot
                </button>
                
                <button class="btn btn-outline" wire:click="generateReport">
                    <i class="icon-download"></i>
                    Report
                </button>
                
                <div class="dropdown">
                    <button class="btn btn-outline dropdown-toggle">
                        <i class="icon-more"></i>
                    </button>
                    <div class="dropdown-menu">
                        <a href="{{ route('filament.admin.resources.appointments.index') }}">Gestione Appuntamenti</a>
                        <a href="{{ route('filament.admin.resources.availabilities.index') }}">Gestione Disponibilità</a>
                        <a href="{{ route('filament.admin.resources.patients.index') }}">Lista Pazienti</a>
                        <div class="dropdown-divider"></div>
                        <a href="{{ route('studio.settings') }}">Impostazioni Studio</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Statistiche Principali -->
    <div class="stats-grid">
        {{ $this->renderHeaderWidgets() }}
    </div>
    
    <!-- Contenuto Principale -->
    <div class="dashboard-content">
        <div class="main-content">
            <!-- Appuntamenti di Oggi -->
            <div class="today-appointments">
                <div class="section-header">
                    <h2>Appuntamenti di Oggi</h2>
                    <div class="section-actions">
                        <button class="btn btn-sm btn-outline" wire:click="refreshAppointments">
                            <i class="icon-refresh"></i>
                            Aggiorna
                        </button>
                        <button class="btn btn-sm btn-primary" wire:click="viewTodaySchedule">
                            <i class="icon-calendar"></i>
                            Vista Calendario
                        </button>
                    </div>
                </div>
                
                @livewire('appointments-today-widget')
            </div>
            
            <!-- Grafici Performance -->
            <div class="performance-charts">
                <div class="chart-container">
                    <h3>Andamento Appuntamenti</h3>
                    @livewire('revenue-chart-widget')
                </div>
                
                <div class="chart-container">
                    <h3>Distribuzione Servizi</h3>
                    @livewire('services-distribution-widget')
                </div>
            </div>
        </div>
        
        <div class="sidebar-content">
            <!-- Prossimi Appuntamenti -->
            <div class="upcoming-appointments">
                <h3>Prossimi Appuntamenti</h3>
                @livewire('upcoming-appointments-widget')
            </div>
            
            <!-- Notifiche Recent -->
            <div class="recent-notifications">
                <h3>Notifiche Recenti</h3>
                @livewire('recent-notifications-widget')
            </div>
            
            <!-- Azioni Rapide -->
            <div class="quick-actions-panel">
                <h3>Azioni Rapide</h3>
                @livewire('quick-actions-widget')
            </div>
        </div>
    </div>
    
    <!-- Footer Widgets -->
    <div class="footer-widgets">
        {{ $this->renderFooterWidgets() }}
    </div>
</div>
```

### Componente Appuntamenti Oggi

```blade
<div class="appointments-today-list">
    @if($appointmentsToday->isEmpty())
        <div class="empty-state">
            <div class="empty-icon">📅</div>
            <h4>Nessun appuntamento oggi</h4>
            <p>Perfetto! Oggi non hai appuntamenti programmati.</p>
            <button class="btn btn-primary" wire:click="createNewSlot">
                Crea Nuovo Slot
            </button>
        </div>
    @else
        <div class="appointments-list">
            @foreach($appointmentsToday as $appointment)
                <div class="appointment-card {{ $appointment->stato }}" 
                     wire:key="appointment-{{ $appointment->id }}">
                    <div class="appointment-time">
                        <div class="time">{{ $appointment->data_appuntamento->format('H:i') }}</div>
                        <div class="duration">{{ $appointment->durata_minuti }}min</div>
                    </div>
                    
                    <div class="appointment-details">
                        <div class="patient-info">
                            <h4>{{ $appointment->patient->nome_completo }}</h4>
                            <p class="patient-details">
                                {{ $appointment->patient->settimane_gestazione }}° settimana di gestazione
                            </p>
                        </div>
                        
                        <div class="appointment-info">
                            <span class="appointment-type">{{ $appointment->tipo_visita_label }}</span>
                            <span class="dentist">{{ $appointment->dentista->nome_completo }}</span>
                        </div>
                        
                        @if($appointment->servizi->isNotEmpty())
                            <div class="services-list">
                                @foreach($appointment->servizi as $servizio)
                                    <span class="service-tag">{{ $servizio->nome }}</span>
                                @endforeach
                            </div>
                        @endif
                        
                        @if($appointment->note_paziente)
                            <div class="patient-notes">
                                <strong>Note:</strong> {{ $appointment->note_paziente }}
                            </div>
                        @endif
                    </div>
                    
                    <div class="appointment-status">
                        <span class="status-badge {{ $appointment->stato }}">
                            {{ $appointment->stato_label }}
                        </span>
                    </div>
                    
                    <div class="appointment-actions">
                        @if($appointment->stato === 'confermato')
                            <button class="btn btn-sm btn-success" 
                                    wire:click="updateAppointmentStatus({{ $appointment->id }}, 'in_corso')">
                                <i class="icon-play"></i>
                                Inizia
                            </button>
                        @endif
                        
                        @if($appointment->stato === 'in_corso')
                            <button class="btn btn-sm btn-primary" 
                                    wire:click="updateAppointmentStatus({{ $appointment->id }}, 'completato')">
                                <i class="icon-check"></i>
                                Completa
                            </button>
                        @endif
                        
                        @if(in_array($appointment->stato, ['confermato', 'in_corso']))
                            <button class="btn btn-sm btn-warning" 
                                    wire:click="markAsNoShow({{ $appointment->id }})">
                                <i class="icon-user-x"></i>
                                No-Show
                            </button>
                        @endif
                        
                        <div class="dropdown">
                            <button class="btn btn-sm btn-outline dropdown-toggle">
                                <i class="icon-more"></i>
                            </button>
                            <div class="dropdown-menu">
                                <a href="{{ route('filament.admin.resources.appointments.edit', $appointment) }}">
                                    Modifica
                                </a>
                                <a href="tel:{{ $appointment->patient->telefono }}">
                                    Chiama Paziente
                                </a>
                                <a href="mailto:{{ $appointment->patient->email }}">
                                    Invia Email
                                </a>
                                <div class="dropdown-divider"></div>
                                <button wire:click="cancelAppointment({{ $appointment->id }})" 
                                        class="text-danger">
                                    Annulla Appuntamento
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</div>
```

### Pannello Azioni Rapide

```blade
<div class="quick-actions-panel">
    <div class="actions-grid">
        <button class="action-item" wire:click="createNewSlot">
            <div class="action-icon">🕒</div>
            <span>Nuovo Slot</span>
        </button>
        
        <button class="action-item" wire:click="viewTodaySchedule">
            <div class="action-icon">📋</div>
            <span>Agenda Oggi</span>
        </button>
        
        <button class="action-item" wire:click="generateReport">
            <div class="action-icon">📊</div>
            <span>Report</span>
        </button>
        
        <button class="action-item" wire:click="exportAppointments">
            <div class="action-icon">📥</div>
            <span>Esporta</span>
        </button>
        
        <a href="{{ route('filament.admin.resources.patients.index') }}" class="action-item">
            <div class="action-icon">👥</div>
            <span>Pazienti</span>
        </a>
        
        <a href="{{ route('studio.settings') }}" class="action-item">
            <div class="action-icon">⚙️</div>
            <span>Impostazioni</span>
        </a>
    </div>
    
    <div class="quick-stats">
        <div class="stat-item">
            <span class="stat-value">{{ $todayRevenue }}</span>
            <span class="stat-label">Fatturato Oggi</span>
        </div>
        
        <div class="stat-item">
            <span class="stat-value">{{ $weeklyAppointments }}</span>
            <span class="stat-label">Settimana</span>
        </div>
        
        <div class="stat-item">
            <span class="stat-value">{{ $monthlyGoalProgress }}%</span>
            <span class="stat-label">Obiettivo Mese</span>
        </div>
    </div>
</div>
```

## 📊 Analytics e Reporting

### Service Analytics Studio

```php
// Service: StudioAnalyticsService
class StudioAnalyticsService
{
    public function getDashboardMetrics(Studio $studio, array $period): array
    {
        [$startDate, $endDate] = $period;
        
        return [
            'appointments' => $this->getAppointmentMetrics($studio, $startDate, $endDate),
            'revenue' => $this->getRevenueMetrics($studio, $startDate, $endDate),
            'patients' => $this->getPatientMetrics($studio, $startDate, $endDate),
            'performance' => $this->getPerformanceMetrics($studio, $startDate, $endDate),
            'satisfaction' => $this->getSatisfactionMetrics($studio, $startDate, $endDate),
        ];
    }
    
    private function getAppointmentMetrics(Studio $studio, Carbon $start, Carbon $end): array
    {
        $appointments = Appointment::where('studio_id', $studio->id)
            ->whereBetween('data_appuntamento', [$start, $end]);
            
        return [
            'total' => $appointments->count(),
            'completed' => $appointments->clone()->where('stato', 'completato')->count(),
            'cancelled' => $appointments->clone()->where('stato', 'annullato')->count(),
            'no_show' => $appointments->clone()->where('stato', 'no_show')->count(),
            'completion_rate' => $this->calculateCompletionRate($appointments),
            'by_type' => $this->getAppointmentsByType($appointments),
            'by_hour' => $this->getAppointmentsByHour($appointments),
        ];
    }
    
    private function getRevenueMetrics(Studio $studio, Carbon $start, Carbon $end): array
    {
        // Per <nome progetto> il fatturato è calcolato sui rimborsi dal servizio sanitario
        $appointments = Appointment::where('studio_id', $studio->id)
            ->whereBetween('data_appuntamento', [$start, $end])
            ->where('stato', 'completato');
            
        return [
            'total_appointments' => $appointments->count(),
            'estimated_reimbursement' => $this->calculateEstimatedReimbursement($appointments),
            'services_breakdown' => $this->getServicesBreakdown($appointments),
            'monthly_trend' => $this->getMonthlyTrend($studio, $start, $end),
        ];
    }
    
    public function generatePerformanceReport(Studio $studio, string $period = 'month'): array
    {
        $dateRange = $this->getDateRangeFromPeriod($period);
        
        return [
            'studio_info' => [
                'nome' => $studio->nome,
                'indirizzo' => $studio->indirizzo_completo,
                'period' => $period,
                'generated_at' => now(),
            ],
            'summary' => $this->getDashboardMetrics($studio, $dateRange),
            'detailed_analytics' => $this->getDetailedAnalytics($studio, $dateRange),
            'recommendations' => $this->generateRecommendations($studio, $dateRange),
        ];
    }
}
```

### Widget Grafico Performance

```php
// Widget: RevenueChartWidget
class RevenueChartWidget extends ChartWidget
{
    protected static ?string $heading = 'Andamento Appuntamenti';
    protected static string $color = 'info';
    
    protected function getData(): array
    {
        $studio = Filament::getTenant();
        
        $data = Appointment::where('studio_id', $studio->id)
            ->whereBetween('data_appuntamento', [now()->subDays(30), now()])
            ->selectRaw('DATE(data_appuntamento) as date, COUNT(*) as count')
            ->groupBy('date')
            ->orderBy('date')
            ->get();
            
        return [
            'datasets' => [
                [
                    'label' => 'Appuntamenti',
                    'data' => $data->pluck('count')->toArray(),
                    'backgroundColor' => 'rgba(59, 130, 246, 0.1)',
                    'borderColor' => 'rgb(59, 130, 246)',
                    'pointBackgroundColor' => 'rgb(59, 130, 246)',
                    'fill' => true,
                ],
            ],
            'labels' => $data->pluck('date')->map(fn($date) => 
                Carbon::parse($date)->format('d/m')
            )->toArray(),
        ];
    }
    
    protected function getType(): string
    {
        return 'line';
    }
    
    protected function getOptions(): array
    {
        return [
            'responsive' => true,
            'maintainAspectRatio' => false,
            'scales' => [
                'y' => [
                    'beginAtZero' => true,
                    'ticks' => [
                        'stepSize' => 1,
                    ],
                ],
            ],
        ];
    }
}
```

## 🔔 Notifiche e Alerts

### Sistema Alert Dashboard

```php
// Service: DashboardAlertService
class DashboardAlertService
{
    public function getActiveAlerts(Studio $studio): Collection
    {
        $alerts = collect();
        
        // Alert slot disponibilità bassa
        $lowAvailability = $this->checkLowAvailability($studio);
        if ($lowAvailability) {
            $alerts->push([
                'type' => 'warning',
                'title' => 'Disponibilità Limitata',
                'message' => $lowAvailability['message'],
                'action' => 'create_slots',
                'priority' => 'medium',
            ]);
        }
        
        // Alert documenti in scadenza
        $expiringDocuments = $this->checkExpiringDocuments($studio);
        if ($expiringDocuments->isNotEmpty()) {
            $alerts->push([
                'type' => 'danger',
                'title' => 'Documenti in Scadenza',
                'message' => "Hai {$expiringDocuments->count()} documenti che scadono entro 30 giorni",
                'action' => 'update_documents',
                'priority' => 'high',
            ]);
        }
        
        // Alert alto tasso no-show
        $noShowRate = $this->calculateNoShowRate($studio);
        if ($noShowRate > 15) {
            $alerts->push([
                'type' => 'warning',
                'title' => 'Alto Tasso No-Show',
                'message' => "Il tasso di no-show è del {$noShowRate}% (superiore al 15%)",
                'action' => 'review_policies',
                'priority' => 'medium',
            ]);
        }
        
        return $alerts->sortByDesc('priority');
    }
}
```

### Widget Alerts Dashboard

```blade
<div class="dashboard-alerts">
    @if($alerts->isNotEmpty())
        <div class="alerts-container">
            <div class="alerts-header">
                <h4>⚠️ Richiede Attenzione</h4>
                <button class="btn btn-sm btn-outline" wire:click="dismissAllAlerts">
                    Ignora Tutti
                </button>
            </div>
            
            <div class="alerts-list">
                @foreach($alerts as $alert)
                    <div class="alert alert-{{ $alert['type'] }}" wire:key="alert-{{ $loop->index }}">
                        <div class="alert-content">
                            <strong>{{ $alert['title'] }}</strong>
                            <p>{{ $alert['message'] }}</p>
                        </div>
                        
                        <div class="alert-actions">
                            @if($alert['action'] === 'create_slots')
                                <button class="btn btn-sm btn-primary" wire:click="createSlots">
                                    Crea Slot
                                </button>
                            @elseif($alert['action'] === 'update_documents')
                                <a href="{{ route('studio.documents') }}" class="btn btn-sm btn-primary">
                                    Aggiorna Documenti
                                </a>
                            @endif
                            
                            <button class="btn btn-sm btn-outline" wire:click="dismissAlert({{ $loop->index }})">
                                Ignora
                            </button>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    @endif
</div>
```

## 🔗 Collegamenti

### Documenti Correlati
- [Registrazione Studi](./registrazione_studi.md)
- [Gestione Appuntamenti](./gestione_appuntamenti.md)
- [Area Odontoiatra](../04_area_odontoiatra.md)
- [Calendario Disponibilità](../prenotazione_visite/calendario_disponibilita.md)

### File Tecnici
- `Modules/<nome progetto>/Filament/Pages/StudioDashboardPage.php`
- `Modules/<nome progetto>/Widgets/StudioStatsOverviewWidget.php`
- `Modules/<nome progetto>/Services/StudioAnalyticsService.php`

---

**📅 Ultimo aggiornamento**: 5 Giugno 2025  
**👥 Stato sviluppo**: ✅ **Completato** (100%)  
**🔄 Prossimi passi**: Implementazione machine learning per analytics predittive