# Integrazione di JpGraph nel Modulo User

## Installazione Composer e namespace

L’installazione di JpGraph e l’uso dei namespace sono documentati nel **modulo Chart**. Nel progetto si usa il pacchetto **amenadiel/jpgraph** con namespace **Amenadiel\JpGraph\*** (non `JpGraph\*`).

- [Chart: JpGraph Composer e namespace](../../Chart/docs/jpgraph-composer-and-namespaces.md)
- [Chart: JpGraph Installation](../../Chart/docs/jpgraph-installation.md)

In sintesi: dalla root Laravel `cd laravel && composer require amenadiel/jpgraph` (o `composer update`); nelle classi usare `Amenadiel\JpGraph\Graph\Graph`, `Amenadiel\JpGraph\Plot\BarPlot`, ecc. Il modulo User non dichiara JpGraph in `composer.json`; usa le Actions del modulo Chart per la generazione grafici.

## Indice

1. [Panoramica](#panoramica)
2. [Struttura dei Modelli](#struttura-dei-modelli)
3. [Servizi per Grafici Utente](#servizi-per-grafici-utente)
4. [Widget Grafici per Utenti](#widget-grafici-per-utenti)
5. [Integrazione con le Statistiche](#integrazione-con-le-statistiche)
6. [Esempi di Implementazione](#esempi-di-implementazione)
7. [Considerazioni di Sicurezza](#considerazioni-di-sicurezza)

---

## Panoramica

Il modulo User integra JpGraph per la generazione di grafici e visualizzazioni relative agli utenti, come statistiche di registrazione, attività degli utenti, e performance del sistema. Questa guida illustra come implementare e utilizzare JpGraph nel contesto del modulo User.

## Struttura dei Modelli

I modelli del modulo User che possono essere utilizzati per la generazione di grafici includono:

- `Modules\User\Models\User` - Modello utente principale
- `Modules\User\Models\Profile` - Modello profilo utente
- `Modules\User\Models\Activity` - Modello attività utente
- `Modules\User\Models\Team` - Modello team utente

## Servizi per Grafici Utente

### UserChartService

Il servizio `UserChartService` fornisce metodi per la generazione di grafici specifici per gli utenti:

```php
<?php

namespace Modules\User\Services;

use Modules\User\Models\User;
use Modules\User\Models\Activity;
use Modules\User\Models\Team;
use Amenadiel\JpGraph\Graph\Graph;
use Amenadiel\JpGraph\Plot\LinePlot;
use Amenadiel\JpGraph\Plot\BarPlot;
use Amenadiel\JpGraph\Plot\PiePlotC;

class UserChartService
{
    /**
     * Crea un grafico delle registrazioni utente per periodo
     */
    public function createUserRegistrationChart($startDate, $endDate)
    {
        $registrations = User::whereBetween('created_at', [$startDate, $endDate])
            ->selectRaw('COUNT(*) as count, DATE(created_at) as date')
            ->groupBy('date')
            ->orderBy('date')
            ->get();
            
        $data = $registrations->pluck('count')->toArray();
        $labels = $registrations->pluck('date')->toArray();
        
        $graph = new Graph\Graph(800, 600);
        $graph->title->Set('Registrazioni Utente');
        $graph->xaxis->SetTickLabels($labels);
        
        $lineplot = new LinePlot($data);
        $lineplot->SetColor('blue');
        $graph->Add($lineplot);
        
        return $graph;
    }
    
    /**
     * Crea un grafico delle attività per utente
     */
    public function createUserActivityChart($userId)
    {
        $activities = Activity::where('user_id', $userId)
            ->selectRaw('COUNT(*) as count, DATE(created_at) as date')
            ->groupBy('date')
            ->orderBy('date')
            ->limit(30) // Limita a 30 giorni
            ->get();
            
        $data = $activities->pluck('count')->toArray();
        $labels = $activities->pluck('date')->toArray();
        
        $graph = new Graph\Graph(800, 600);
        $graph->title->Set('Attività Utente');
        $graph->xaxis->SetTickLabels($labels);
        
        $barplot = new BarPlot($data);
        $barplot->SetFillColor('green');
        $graph->Add($barplot);
        
        return $graph;
    }
    
    /**
     * Crea un grafico della distribuzione degli utenti per team
     */
    public function createTeamDistributionChart()
    {
        $teamCounts = Team::withCount('users')
            ->selectRaw('teams.name, COUNT(users.id) as count')
            ->leftJoin('users', 'teams.id', '=', 'users.team_id')
            ->groupBy('teams.id')
            ->get();
            
        $data = $teamCounts->pluck('count')->toArray();
        $labels = $teamCounts->pluck('name')->toArray();
        
        $graph = new Graph\Graph(800, 600);
        $graph->title->Set('Distribuzione Utenti per Team');
        
        $pieplot = new PiePlot($data);
        $pieplot->SetLegends($labels);
        $graph->Add($pieplot);
        
        return $graph;
    }
    
    /**
     * Crea un grafico delle performance degli utenti attivi
     */
    public function createUserPerformanceChart($days = 30)
    {
        $startDate = now()->subDays($days);
        
        $activeUsers = User::where('last_activity_at', '>=', $startDate)
            ->selectRaw('DATE(last_activity_at) as date, COUNT(*) as count')
            ->groupBy('date')
            ->orderBy('date')
            ->get();
            
        $data = $activeUsers->pluck('count')->toArray();
        $labels = $activeUsers->pluck('date')->toArray();
        
        $graph = new Graph\Graph(800, 600);
        $graph->title->Set('Utenti Attivi');
        $graph->xaxis->SetTickLabels($labels);
        
        $lineplot = new LinePlot($data);
        $lineplot->SetColor('red');
        $lineplot->SetWeight(2);
        $graph->Add($lineplot);
        
        return $graph;
    }
}
```

## Widget Grafici per Utenti

### UserRegistrationChartWidget

Widget per visualizzare le registrazioni utente:

```php
<?php

namespace Modules\User\Filament\Widgets;

use Filament\Widgets\ChartWidget;
use Modules\User\Services\UserChartService;
use Carbon\Carbon;

class UserRegistrationChartWidget extends ChartWidget
{
    protected ?string $heading = 'Registrazioni Utente';
    
    protected function getData(): array
    {
        $chartService = new UserChartService();
        $startDate = Carbon::now()->subDays(30);
        $endDate = Carbon::now();
        
        $registrations = \Modules\User\Models\User::whereBetween('created_at', [$startDate, $endDate])
            ->selectRaw('COUNT(*) as count, DATE(created_at) as date')
            ->groupBy('date')
            ->orderBy('date')
            ->get();
            
        return [
            'datasets' => [
                [
                    'label' => 'Registrazioni',
                    'data' => $registrations->pluck('count')->toArray(),
                ],
            ],
            'labels' => $registrations->pluck('date')->toArray(),
        ];
    }
    
    protected function getType(): string
    {
        return 'line';
    }
}
```

### UserActivityChartWidget

Widget per visualizzare l'attività degli utenti:

```php
<?php

namespace Modules\User\Filament\Widgets;

use Filament\Widgets\ChartWidget;
use Modules\User\Services\UserChartService;

class UserActivityChartWidget extends ChartWidget
{
    protected ?string $heading = 'Attività Utenti';
    
    protected function getData(): array
    {
        $chartService = new UserChartService();
        $startDate = now()->subDays(7);
        
        $activities = \Modules\User\Models\Activity::whereBetween('created_at', [$startDate, now()])
            ->selectRaw('COUNT(*) as count, DATE(created_at) as date')
            ->groupBy('date')
            ->orderBy('date')
            ->get();
            
        return [
            'datasets' => [
                [
                    'label' => 'Attività',
                    'data' => $activities->pluck('count')->toArray(),
                ],
            ],
            'labels' => $activities->pluck('date')->toArray(),
        ];
    }
    
    protected function getType(): string
    {
        return 'bar';
    }
}
```

## Integrazione con le Statistiche

### Statistiche Utente nel Dashboard

Per integrare i grafici nel dashboard utente:

```php
<?php

namespace Modules\User\Http\Controllers;

use Modules\User\Services\UserChartService;
use Illuminate\Http\Request;

class DashboardController
{
    public function index()
    {
        $chartService = new UserChartService();
        
        // Crea i grafici per il dashboard
        $registrationChart = $chartService->createUserRegistrationChart(
            now()->subDays(30),
            now()
        );
        
        $activityChart = $chartService->createUserActivityChart(
            auth()->id()
        );
        
        $teamChart = $chartService->createTeamDistributionChart();
        
        return view('user::dashboard', [
            'registrationChart' => $registrationChart,
            'activityChart' => $activityChart,
            'teamChart' => $teamChart,
        ]);
    }
}
```

### API per Grafici Utente

Per fornire accesso agli utenti attraverso API:

```php
<?php

namespace Modules\User\Http\Controllers\Api;

use Modules\User\Services\UserChartService;
use Illuminate\Http\Request;

class UserChartController
{
    public function getRegistrationChart(Request $request)
    {
        $chartService = new UserChartService();
        $startDate = $request->get('start_date', now()->subDays(30));
        $endDate = $request->get('end_date', now());
        
        $graph = $chartService->createUserRegistrationChart($startDate, $endDate);
        
        return response($graph->Stroke(), 200, [
            'Content-Type' => 'image/png'
        ]);
    }
    
    public function getTeamDistributionChart()
    {
        $chartService = new UserChartService();
        $graph = $chartService->createTeamDistributionChart();
        
        return response($graph->Stroke(), 200, [
            'Content-Type' => 'image/png'
        ]);
    }
}
```

## Esempi di Implementazione

### Esempio 1: Dashboard Amministrativa

```php
<?php

namespace Modules\User\Filament\Pages;

use Filament\Pages\Page;
use Modules\User\Services\UserChartService;
use Amenadiel\JpGraph\Graph\Graph;

class AdminDashboard extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-chart-bar';
    
    public function render()
    {
        $chartService = new UserChartService();
        
        // Grafico delle registrazioni giornaliere
        $dailyRegistrations = $chartService->createUserRegistrationChart(
            now()->subDays(7),
            now()
        );
        
        // Grafico delle attività settimanali
        $weeklyActivity = $chartService->createUserActivityChart(
            auth()->id()
        );
        
        return view('user::admin-dashboard', [
            'dailyRegistrations' => $dailyRegistrations,
            'weeklyActivity' => $weeklyActivity,
        ]);
    }
}
```

### Esempio 2: Report Mensile Utente

```php
<?php

namespace Modules\User\Exports;

use Modules\User\Services\UserChartService;
use Maatwebsite\Excel\Concerns\FromView;
use Illuminate\Contracts\View\View;

class MonthlyUserReport implements FromView
{
    public function view(): View
    {
        $chartService = new UserChartService();
        $startDate = now()->startOfMonth();
        $endDate = now()->endOfMonth();
        
        $chart = $chartService->createUserRegistrationChart($startDate, $endDate);
        
        return view('exports.monthly-user-report', [
            'chart' => $chart,
            'startDate' => $startDate,
            'endDate' => $endDate,
        ]);
    }
}
```

## Considerazioni di Sicurezza

1. **Access Control**: Assicurati che solo gli utenti autorizzati possano accedere ai grafici sensibili
2. **Data Validation**: Convalida sempre i dati di input per prevenire attacchi
3. **Rate Limiting**: Implementa limitazione delle richieste per evitare DoS
4. **Output Sanitization**: Sanifica sempre l'output per prevenire XSS
5. **Audit Logging**: Logga le richieste di grafici per scopi di audit

### Middleware di Sicurezza per Grafici

```php
<?php

namespace Modules\User\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class SecureChartAccess
{
    public function handle(Request $request, Closure $next)
    {
        // Verifica autorizzazione
        if (!auth()->check() || !auth()->user()->can('view-user-charts')) {
            abort(403);
        }
        
        // Limita il numero di richieste
        $this->checkRateLimit();
        
        return $next($request);
    }
    
    private function checkRateLimit()
    {
        $key = 'chart_access_' . auth()->id();
        $attempts = cache()->increment($key);
        
        if ($attempts > 100) { // Limite di 100 richieste per ora
            cache()->put($key, 100, now()->addHour());
            abort(429);
        }
    }
}
```

## Best Practices

1. **Caching**: Implementa caching per migliorare le performance
2. **Error Handling**: Gestisci sempre gli errori di generazione dei grafici
3. **Testing**: Crea test per verificare la generazione dei grafici
4. **Documentation**: Documenta le funzioni e i metodi utilizzati
5. **Performance Monitoring**: Monitora le performance dei grafici generati

## Risorse Aggiuntive

- [Documentazione JpGraph](https://jpgraph.net/)
- [Guida all'uso di JpGraph](https://jpgraph.net/doc/)
- [Esempi di codice JpGraph](https://jpgraph.net/demo/)