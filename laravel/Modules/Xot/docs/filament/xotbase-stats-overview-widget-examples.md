# XotBaseStatsOverviewWidget - Esempi Pratici

## Panoramica

Questo documento fornisce esempi pratici e completi di utilizzo della classe `XotBaseStatsOverviewWidget` migliorata, mostrando tutte le nuove funzionalità implementate.

## Esempio 1: Dashboard E-commerce

```php
<?php

declare(strict_types=1);

namespace Modules\Ecommerce\Filament\Widgets;

use Modules\Xot\Filament\Widgets\XotBaseStatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Filament\Actions\Action;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class EcommerceStatsOverviewWidget extends XotBaseStatsOverviewWidget
{
    protected static ?int $sort = 1;
    protected static ?string $pollingInterval = '3m';

    protected function getStats(): array
    {
        $cacheKey = 'ecommerce:dashboard:stats_overview';
        
        return $this->getCachedDataWithDefaultTtl($cacheKey, function () {
            $currentMonth = Carbon::now()->startOfMonth();
            $previousMonth = Carbon::now()->subMonth()->startOfMonth();
            $currentWeek = Carbon::now()->startOfWeek();
            $previousWeek = Carbon::now()->subWeek()->startOfWeek();
            
            return [
                // Statistica base con formattazione
                $this->createStat(
                    'Fatturato Totale',
                    $this->formatCurrency(DB::table('orders')->where('status', 'completed')->sum('total_amount')),
                    'Fatturato totale degli ordini completati',
                    'heroicon-m-currency-euro',
                    'success'
                ),
                
                // Statistica con trend calcolato automaticamente
                $this->createStatWithCalculatedTrend(
                    'Fatturato Mensile',
                    DB::table('orders')->where('status', 'completed')->where('created_at', '>=', $currentMonth)->sum('total_amount'),
                    DB::table('orders')->where('status', 'completed')->where('created_at', '>=', $previousMonth)->sum('total_amount'),
                    'heroicon-m-chart-bar',
                    'primary',
                    2
                ),
                
                // Statistica da query con condizioni
                $this->createStatFromQuery(
                    'Ordini Completati',
                    'orders',
                    '*',
                    ['status' => 'completed'],
                    'Numero di ordini completati',
                    'heroicon-m-check-circle',
                    'success'
                ),
                
                // Statistica con aggregazione
                $this->createStatFromAggregateQuery(
                    'Valore Medio Ordine',
                    'orders',
                    'avg',
                    'total_amount',
                    ['status' => 'completed'],
                    'Valore medio degli ordini completati',
                    'heroicon-m-calculator',
                    'warning',
                    2
                ),
                
                // Statistica con URL di navigazione
                $this->createStatWithUrl(
                    'Vedi Tutti gli Ordini',
                    $this->formatNumber(DB::table('orders')->count()),
                    '/admin/orders',
                    'Clicca per visualizzare tutti gli ordini',
                    'heroicon-m-arrow-right',
                    'primary'
                ),
                
                // Statistica con badge per ordini in attesa
                $this->createStatWithBadge(
                    'Ordini in Attesa',
                    $this->formatNumber(DB::table('orders')->where('status', 'pending')->count()),
                    'Attenzione',
                    'warning',
                    'Ordini che richiedono attenzione',
                    'heroicon-m-clock',
                    'warning'
                ),
                
                // Statistica con trend da query per settimana
                $this->createStatWithTrendFromQuery(
                    'Nuovi Clienti',
                    'users',
                    'created_at',
                    $currentWeek,
                    $previousWeek,
                    ['type' => 'customer'],
                    'Nuovi clienti questa settimana vs precedente',
                    'heroicon-m-user-plus',
                    'info'
                ),
                
                // Statistica con azione personalizzata
                $this->createStatWithAction(
                    'Esporta Report',
                    'Disponibile',
                    Action::make('export_report')
                        ->label('Esporta CSV')
                        ->icon('heroicon-m-arrow-down-tray')
                        ->color('secondary')
                        ->action(function () {
                            // Logica di esportazione
                            return redirect()->route('admin.export.orders');
                        }),
                    'Clicca per esportare il report ordini',
                    'heroicon-m-document-arrow-down',
                    'secondary'
                ),
            ];
        });
    }

    public function getHeading(): ?string
    {
        return __('ecommerce::widgets.stats_overview.title');
    }

    public static function canView(): bool
    {
        return auth()->user()->can('view_ecommerce_stats');
    }
}
```

## Esempio 2: Dashboard Healthcare

```php
<?php

declare(strict_types=1);

namespace Modules\Healthcare\Filament\Widgets;

use Modules\Xot\Filament\Widgets\XotBaseStatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class HealthcareStatsOverviewWidget extends XotBaseStatsOverviewWidget
{
    protected static ?int $sort = 2;
    protected static ?string $pollingInterval = '5m';

    protected function getStats(): array
    {
        $cacheKey = 'healthcare:dashboard:stats_overview';
        
        return $this->getCachedDataWithDefaultTtl($cacheKey, function () {
            $today = Carbon::today();
            $yesterday = Carbon::yesterday();
            $currentMonth = Carbon::now()->startOfMonth();
            $previousMonth = Carbon::now()->subMonth()->startOfMonth();
            
            return [
                // Statistica base
                $this->createStat(
                    'Pazienti Totali',
                    $this->formatNumber(DB::table('patients')->count()),
                    'Numero totale di pazienti registrati',
                    'heroicon-m-users',
                    'success'
                ),
                
                // Statistica con trend calcolato
                $this->createStatWithCalculatedTrend(
                    'Nuovi Pazienti',
                    DB::table('patients')->where('created_at', '>=', $currentMonth)->count(),
                    DB::table('patients')->where('created_at', '>=', $previousMonth)->count(),
                    'heroicon-m-user-plus',
                    'info'
                ),
                
                // Statistica da query con condizioni
                $this->createStatFromQuery(
                    'Appuntamenti Oggi',
                    'appointments',
                    '*',
                    [
                        'date' => $today->format('Y-m-d'),
                        'status' => 'confirmed'
                    ],
                    'Appuntamenti confermati per oggi',
                    'heroicon-m-calendar',
                    'primary'
                ),
                
                // Statistica con aggregazione
                $this->createStatFromAggregateQuery(
                    'Durata Media Visita',
                    'appointments',
                    'avg',
                    'duration_minutes',
                    ['status' => 'completed'],
                    'Durata media delle visite completate',
                    'heroicon-m-clock',
                    'warning',
                    0
                ),
                
                // Statistica comparativa
                $this->createComparativeStat(
                    'Appuntamenti Mensili',
                    DB::table('appointments')->where('created_at', '>=', $currentMonth)->count(),
                    DB::table('appointments')->where('created_at', '>=', $previousMonth)->count(),
                    'Questo mese',
                    'Mese scorso',
                    'heroicon-m-chart-bar',
                    'primary'
                ),
                
                // Statistica con URL
                $this->createStatWithUrl(
                    'Gestisci Appuntamenti',
                    $this->formatNumber(DB::table('appointments')->where('status', 'pending')->count()),
                    '/admin/appointments',
                    'Appuntamenti in attesa di conferma',
                    'heroicon-m-calendar-days',
                    'warning'
                ),
                
                // Statistica con badge per emergenze
                $this->createStatWithBadge(
                    'Visite Urgenti',
                    $this->formatNumber(DB::table('appointments')->where('priority', 'urgent')->where('date', '>=', $today)->count()),
                    'URGENTE',
                    'danger',
                    'Visite urgenti programmate',
                    'heroicon-m-exclamation-triangle',
                    'danger'
                ),
                
                // Statistica con gestione errori
                $this->createStatWithErrorHandling(
                    'Fatturato Mensile',
                    function () use ($currentMonth) {
                        return DB::table('appointments')
                            ->join('payments', 'appointments.id', '=', 'payments.appointment_id')
                            ->where('appointments.created_at', '>=', $currentMonth)
                            ->where('payments.status', 'completed')
                            ->sum('payments.amount');
                    },
                    '0',
                    'Fatturato del mese corrente',
                    'heroicon-m-currency-euro',
                    'success'
                ),
            ];
        });
    }

    public function getHeading(): ?string
    {
        return __('healthcare::widgets.stats_overview.title');
    }

    public static function canView(): bool
    {
        return auth()->user()->can('view_healthcare_stats');
    }
}
```

## Esempio 3: Dashboard Analytics

```php
<?php

declare(strict_types=1);

namespace Modules\Analytics\Filament\Widgets;

use Modules\Xot\Filament\Widgets\XotBaseStatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Filament\Actions\Action;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class AnalyticsStatsOverviewWidget extends XotBaseStatsOverviewWidget
{
    protected static ?int $sort = 3;
    protected static ?string $pollingInterval = '2m';

    protected function getStats(): array
    {
        $cacheKey = 'analytics:dashboard:stats_overview';
        
        return $this->getCachedDataWithDefaultTtl($cacheKey, function () {
            $today = Carbon::today();
            $yesterday = Carbon::yesterday();
            $currentWeek = Carbon::now()->startOfWeek();
            $previousWeek = Carbon::now()->subWeek()->startOfWeek();
            
            return [
                // Statistica base
                $this->createStat(
                    'Visite Oggi',
                    $this->formatNumber(DB::table('page_views')->where('created_at', '>=', $today)->count()),
                    'Numero di visite alla pagina oggi',
                    'heroicon-m-eye',
                    'info'
                ),
                
                // Statistica con trend calcolato
                $this->createStatWithCalculatedTrend(
                    'Visite Settimanali',
                    DB::table('page_views')->where('created_at', '>=', $currentWeek)->count(),
                    DB::table('page_views')->where('created_at', '>=', $previousWeek)->count(),
                    'heroicon-m-chart-bar',
                    'primary'
                ),
                
                // Statistica da query con condizioni
                $this->createStatFromQuery(
                    'Utenti Unici',
                    'page_views',
                    'user_id',
                    ['created_at' => $today->format('Y-m-d')],
                    'Utenti unici che hanno visitato oggi',
                    'heroicon-m-users',
                    'success'
                ),
                
                // Statistica con aggregazione
                $this->createStatFromAggregateQuery(
                    'Tempo Medio Sessione',
                    'sessions',
                    'avg',
                    'duration_seconds',
                    ['ended_at' => '>=', $today],
                    'Tempo medio di sessione in secondi',
                    'heroicon-m-clock',
                    'warning',
                    0
                ),
                
                // Statistica con trend da query
                $this->createStatWithTrendFromQuery(
                    'Conversioni',
                    'conversions',
                    'created_at',
                    $currentWeek,
                    $previousWeek,
                    ['status' => 'completed'],
                    'Conversioni questa settimana vs precedente',
                    'heroicon-m-arrow-trending-up',
                    'success'
                ),
                
                // Statistica con URL
                $this->createStatWithUrl(
                    'Report Dettagliato',
                    'Disponibile',
                    '/admin/analytics/reports',
                    'Clicca per visualizzare il report dettagliato',
                    'heroicon-m-document-chart-bar',
                    'primary'
                ),
                
                // Statistica con badge per performance
                $this->createStatWithBadge(
                    'Performance Sito',
                    $this->formatPercentage(DB::table('performance_metrics')->where('date', $today->format('Y-m-d'))->avg('score') / 100),
                    'Buona',
                    'success',
                    'Punteggio performance del sito',
                    'heroicon-m-speedometer',
                    'success'
                ),
                
                // Statistica con azione per esportazione
                $this->createStatWithAction(
                    'Esporta Dati',
                    'Disponibile',
                    Action::make('export_analytics')
                        ->label('Esporta Excel')
                        ->icon('heroicon-m-arrow-down-tray')
                        ->color('secondary')
                        ->requiresConfirmation()
                        ->action(function () {
                            // Logica di esportazione
                            return redirect()->route('admin.analytics.export');
                        }),
                    'Esporta i dati analytics in formato Excel',
                    'heroicon-m-document-arrow-down',
                    'secondary'
                ),
                
                // Statistica con gestione errori per dati complessi
                $this->createStatWithErrorHandling(
                    'ROI Marketing',
                    function () {
                        $revenue = DB::table('orders')->where('status', 'completed')->sum('total_amount');
                        $cost = DB::table('marketing_campaigns')->sum('budget');
                        
                        if ($cost == 0) return 0;
                        
                        return (($revenue - $cost) / $cost) * 100;
                    },
                    '0',
                    'Return on Investment delle campagne marketing',
                    'heroicon-m-currency-dollar',
                    'success'
                ),
            ];
        });
    }

    public function getHeading(): ?string
    {
        return __('analytics::widgets.stats_overview.title');
    }

    public static function canView(): bool
    {
        return auth()->user()->can('view_analytics_stats');
    }
}
```

## Esempio 4: Dashboard Sistema

```php
<?php

declare(strict_types=1);

namespace Modules\System\Filament\Widgets;

use Modules\Xot\Filament\Widgets\XotBaseStatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class SystemStatsOverviewWidget extends XotBaseStatsOverviewWidget
{
    protected static ?int $sort = 4;
    protected static ?string $pollingInterval = '1m';

    protected function getStats(): array
    {
        $cacheKey = 'system:dashboard:stats_overview';
        
        return $this->getCachedDataWithDefaultTtl($cacheKey, function () {
            $today = Carbon::today();
            $yesterday = Carbon::yesterday();
            
            return [
                // Statistica base
                $this->createStat(
                    'Utenti Online',
                    $this->formatNumber(DB::table('sessions')->where('last_activity', '>=', now()->subMinutes(5))->count()),
                    'Utenti attivi negli ultimi 5 minuti',
                    'heroicon-m-signal',
                    'success'
                ),
                
                // Statistica con trend calcolato
                $this->createStatWithCalculatedTrend(
                    'Nuovi Utenti',
                    DB::table('users')->where('created_at', '>=', $today)->count(),
                    DB::table('users')->where('created_at', '>=', $yesterday)->count(),
                    'heroicon-m-user-plus',
                    'info'
                ),
                
                // Statistica da query con condizioni
                $this->createStatFromQuery(
                    'Errori Sistema',
                    'error_logs',
                    '*',
                    ['created_at' => $today->format('Y-m-d')],
                    'Errori registrati oggi',
                    'heroicon-m-exclamation-triangle',
                    'danger'
                ),
                
                // Statistica con aggregazione
                $this->createStatFromAggregateQuery(
                    'Tempo Medio Risposta',
                    'performance_logs',
                    'avg',
                    'response_time_ms',
                    ['created_at' => $today->format('Y-m-d')],
                    'Tempo medio di risposta in millisecondi',
                    'heroicon-m-clock',
                    'warning',
                    0
                ),
                
                // Statistica con URL
                $this->createStatWithUrl(
                    'Log Sistema',
                    $this->formatNumber(DB::table('system_logs')->where('created_at', '>=', $today)->count()),
                    '/admin/system/logs',
                    'Log di sistema generati oggi',
                    'heroicon-m-document-text',
                    'info'
                ),
                
                // Statistica con badge per allarmi
                $this->createStatWithBadge(
                    'Allarmi Attivi',
                    $this->formatNumber(DB::table('alarms')->where('status', 'active')->count()),
                    'ATTIVO',
                    'danger',
                    'Allarmi di sistema attivi',
                    'heroicon-m-bell-alert',
                    'danger'
                ),
                
                // Statistica con gestione errori
                $this->createStatWithErrorHandling(
                    'Utilizzo CPU',
                    function () {
                        // Simulazione lettura CPU
                        $cpuUsage = sys_getloadavg()[0] * 100;
                        return min($cpuUsage, 100);
                    },
                    '0',
                    'Utilizzo CPU del server',
                    'heroicon-m-cpu-chip',
                    'info'
                ),
                
                // Statistica con trend da query
                $this->createStatWithTrendFromQuery(
                    'Richieste API',
                    'api_requests',
                    'created_at',
                    $today,
                    $yesterday,
                    ['status' => 'success'],
                    'Richieste API di successo oggi vs ieri',
                    'heroicon-m-server',
                    'primary'
                ),
            ];
        });
    }

    public function getHeading(): ?string
    {
        return __('system::widgets.stats_overview.title');
    }

    public static function canView(): bool
    {
        return auth()->user()->can('view_system_stats');
    }
}
```

## Best Practices Implementate

### 1. **Caching Intelligente**
- Utilizzo di `getCachedDataWithDefaultTtl()` per TTL predefinito
- Gestione errori cache con fallback automatico
- Chiavi cache descrittive e modulari

### 2. **Formattazione Consistente**
- `formatNumber()` per numeri grandi
- `formatPercentage()` per percentuali
- `formatCurrency()` per valori monetari

### 3. **Gestione Errori Robusta**
- `createStatWithErrorHandling()` per query complesse
- Fallback appropriati in caso di errore
- Logging automatico degli errori

### 4. **Trend Automatici**
- `createStatWithCalculatedTrend()` per confronti automatici
- `calculateTrend()` per calcoli percentuali
- Icone e colori automatici basati sul trend

### 5. **Query Ottimizzate**
- `createStatFromQuery()` per conteggi semplici
- `createStatFromAggregateQuery()` per aggregazioni
- `createStatWithTrendFromQuery()` per trend da database

### 6. **Interattività**
- `createStatWithUrl()` per navigazione
- `createStatWithAction()` per azioni personalizzate
- `createStatWithBadge()` per evidenziare stati

### 7. **Performance**
- Polling appropriato per tipo di dati
- Cache con TTL ottimizzato
- Query efficienti con indici appropriati

## Conclusione

La classe `XotBaseStatsOverviewWidget` migliorata fornisce un set completo di strumenti per creare dashboard statistiche avanzate, interattive e performanti. Gli esempi mostrano come utilizzare tutte le nuove funzionalità per creare widget professionali e user-friendly.

---

**Ultimo aggiornamento**: Dicembre 2024
**Versione**: 2.0
**Stato**: ✅ Completato e Documentato 