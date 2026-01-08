# Colli di Bottiglia e Soluzioni - Modulo Activity

## Panoramica
Questo documento identifica i principali colli di bottiglia nel modulo Activity e fornisce soluzioni dettagliate passo per passo per risolverli.

## 1. Logging Eccessivo delle Attività

### Problema
Il logging indiscriminato di tutte le attività utente può portare a una crescita rapida della tabella `activity_log`, causando degradazione delle performance del database.

### Impatto
- Aumento delle dimensioni del database
- Rallentamento delle query che coinvolgono la tabella `activity_log`
- Maggiore utilizzo di spazio su disco

### Soluzione Passo-Passo

1. **Implementare Politiche di Logging Selettivo**

```php
// In Modules\Activity\app\Providers\ActivityServiceProvider.php
use Spatie\Activitylog\ActivitylogServiceProvider as SpatieActivitylogServiceProvider;

class ActivityServiceProvider extends SpatieActivitylogServiceProvider
{
    public function boot()
    {
        parent::boot();
        
        // Configura il logging solo per eventi significativi
        \Spatie\Activitylog\Models\Activity::saving(function ($activity) {
            // Ignora attività di basso valore come visualizzazioni semplici
            if ($activity->description === 'viewed' && !in_array($activity->subject_type, [
                'Modules\\User\\Models\\User',
                'Modules\\SaluteOra\\Models\\Patient',
                // Altri modelli critici...
            ])) {
                return false;
            }
            
            return true;
        });
    }
}
```

2. **Ottimizzare la Tabella `activity_log`**

```php
// Crea una migrazione per ottimizzare la tabella activity_log
php artisan make:migration optimize_activity_log_table

// Implementazione
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class OptimizeActivityLogTable extends Migration
{
    public function up()
    {
        Schema::table('activity_log', function (Blueprint $table) {
            // Aggiungi indici per migliorare le performance
            $table->index(['log_name', 'subject_type', 'subject_id']);
            $table->index(['causer_type', 'causer_id', 'created_at']);
        });
    }
    
    public function down()
    {
        Schema::table('activity_log', function (Blueprint $table) {
            $table->dropIndex(['log_name', 'subject_type', 'subject_id']);
            $table->dropIndex(['causer_type', 'causer_id', 'created_at']);
        });
    }
}
```

3. **Implementare Pulizia Automatica dei Log**

```php
// In Modules\Activity\app\Console\Commands\CleanActivityLogs.php
namespace Modules\Activity\app\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class CleanActivityLogs extends Command
{
    protected $signature = 'activity:clean-logs {--days=90}';
    
    protected $description = 'Clean old activity logs from the database';
    
    public function handle()
    {
        $days = $this->option('days');
        $date = now()->subDays($days);
        
        $count = DB::table('activity_log')
            ->where('created_at', '<', $date)
            ->delete();
        
        $this->info("Deleted {$count} old activity logs.");
        
        return Command::SUCCESS;
    }
}

// Registra il comando nel service provider
// In Modules\Activity\app\Providers\ActivityServiceProvider.php
protected $commands = [
    \Modules\Activity\app\Console\Commands\CleanActivityLogs::class,
];

// Aggiungi al task scheduler
// In app/Console/Kernel.php
protected function schedule(Schedule $schedule)
{
    $schedule->command('activity:clean-logs')->monthly();
}
```

## 2. Caricamento Inefficiente dei Dati di Attività

### Problema
Il caricamento di attività con relazioni complesse può causare il problema N+1 query, degradando le performance.

### Impatto
- Rallentamento delle pagine che mostrano attività
- Aumento del carico sul database
- Maggiore utilizzo di memoria

### Soluzione Passo-Passo

1. **Implementare Eager Loading Ottimizzato**

```php
// In Modules\Activity\app\Repositories\ActivityRepository.php
namespace Modules\Activity\app\Repositories;

use Spatie\Activitylog\Models\Activity;

class ActivityRepository
{
    public function getLatestActivities($limit = 10)
    {
        return Activity::with([
            'causer', 
            'subject',
            // Carica solo le relazioni necessarie
        ])
        ->latest()
        ->take($limit)
        ->get();
    }
    
    public function getActivitiesByUser($userId, $limit = 50)
    {
        return Activity::with([
            'subject',
            // Carica solo le relazioni necessarie
        ])
        ->where('causer_type', 'Modules\\User\\Models\\User')
        ->where('causer_id', $userId)
        ->latest()
        ->paginate($limit);
    }
}
```

2. **Ottimizzare le Query con Indici**

```php
// Aggiungere indici appropriati
Schema::table('activity_log', function (Blueprint $table) {
    $table->index(['created_at']);
});
```

3. **Implementare Caching per Attività Frequentemente Accedute**

```php
// In Modules\Activity\app\Services\ActivityService.php
namespace Modules\Activity\app\Services;

use Illuminate\Support\Facades\Cache;
use Modules\Activity\app\Repositories\ActivityRepository;

class ActivityService
{
    protected $activityRepository;
    
    public function __construct(ActivityRepository $activityRepository)
    {
        $this->activityRepository = $activityRepository;
    }
    
    public function getDashboardActivities()
    {
        return Cache::remember('dashboard_activities', 300, function () {
            return $this->activityRepository->getLatestActivities(5);
        });
    }
    
    public function getUserActivities($userId)
    {
        return Cache::remember("user_activities_{$userId}", 300, function () use ($userId) {
            return $this->activityRepository->getActivitiesByUser($userId);
        });
    }
}
```

## 3. Event Sourcing: Colli di Bottiglia e Soluzioni

### Problema
- Performance del replay eventi su grandi volumi
- Proiezioni lente o non idempotenti
- Gestione versioni eventi e compatibilità
- Sincronizzazione tra event store e activity_log legacy

### Soluzioni
1. **Snapshot periodici** per evitare replay completo
2. **Proiettori idempotenti** e test di consistenza
3. **Versionamento eventi** e fallback su activitylog in caso di errore
4. **Monitoraggio e alert su proiezioni lente**
5. **Script di migrazione e rollback**

### Collegamenti
- [Best Practice Event Sourcing .mdc](../../.cursor/rules/ACTIVITY_EVENT_SOURCING_BEST_PRACTICES.mdc)

## 3. Problemi di Performance nei Widget di Attività

### Problema
I widget Filament che mostrano dati di attività possono causare rallentamenti nell'interfaccia di amministrazione.

### Impatto
- Caricamento lento del pannello di amministrazione
- Esperienza utente degradata
- Timeout potenziali su richieste complesse

### Soluzione Passo-Passo

1. **Ottimizzare i Widget Filament**

```php
// In Modules\Activity\app\Filament\Widgets\ActivityLogWidget.php
namespace Modules\Activity\app\Filament\Widgets;

use Modules\Xot\Filament\Widgets\XotBaseWidget;
use Modules\Activity\app\Services\ActivityService;

class ActivityLogWidget extends XotBaseWidget
{
    protected static string $view = 'activity::filament.widgets.activity-log';
    
    // Limita il numero di aggiornamenti
    protected static ?string $pollingInterval = '60s';
    
    // Usa il service ottimizzato
    protected $activityService;
    
    public function __construct($id = null)
    {
        parent::__construct($id);
        $this->activityService = app(ActivityService::class);
    }
    
    public function getActivities()
    {
        return $this->activityService->getDashboardActivities();
    }
}
```

2. **Implementare Lazy Loading nei Template**

```blade
{{-- In resources/views/filament/widgets/activity-log.blade.php --}}
<x-filament-widgets::widget>
    <div>
        @if($this->getActivities()->isEmpty())
            <p>Nessuna attività recente.</p>
        @else
            <ul>
                @foreach($this->getActivities() as $activity)
                    <li class="py-2">
                        {{-- Carica i dettagli solo quando necessario --}}
                        <span>{{ $activity->description }}</span>
                        <small>{{ $activity->created_at->diffForHumans() }}</small>
                    </li>
                @endforeach
            </ul>
        @endif
    </div>
</x-filament-widgets::widget>
```

3. **Implementare Paginazione Efficiente**

```php
// In Modules\Activity\app\Filament\Resources\ActivityResource\Pages\ListActivities.php
namespace Modules\Activity\app\Filament\Resources\ActivityResource\Pages;

use Modules\Xot\Filament\Pages\XotBasePage;
use Modules\Activity\app\Filament\Resources\ActivityResource;

class ListActivities extends XotBasePage
{
    protected static string $resource = ActivityResource::class;
    
    protected function getTableRecordsPerPageSelectOptions(): array
    {
        return [10, 25, 50];
    }
}
```

## Collegamenti Bidirezionali

- [README Activity](./README.md)
- [Roadmap](./roadmap.md)
- [Struttura del Modulo](./structure.md)
## Collegamenti

- [Torna a README](./README.md)
- [Vai a Roadmap](./roadmap.md)
- [Vai a Struttura](./structure.md)

## Collegamenti tra versioni di bottlenecks.md
* [bottlenecks.md](../../../../bashscripts/docs/bottlenecks.md)
* [bottlenecks.md](../../Chart/docs/bottlenecks.md)
* [bottlenecks.md](../../Chart/docs/performance/bottlenecks.md)
* [bottlenecks.md](../../Gdpr/docs/bottlenecks.md)
* [bottlenecks.md](../../Gdpr/docs/performance/bottlenecks.md)
* [bottlenecks.md](../../Xot/docs/bottlenecks.md)
* [bottlenecks.md](../../Xot/docs/performance/bottlenecks.md)
* [bottlenecks.md](../../Xot/docs/roadmap/bottlenecks.md)
* [bottlenecks.md](../../Dental/docs/bottlenecks.md)
* [bottlenecks.md](../../User/docs/bottlenecks.md)
* [bottlenecks.md](../../User/docs/roadmap/bottlenecks.md)
* [bottlenecks.md](../../UI/docs/bottlenecks.md)
* [bottlenecks.md](../../UI/docs/roadmap/bottlenecks.md)
* [bottlenecks.md](../../Lang/docs/bottlenecks.md)
* [bottlenecks.md](../../Lang/docs/performance/bottlenecks.md)
* [bottlenecks.md](../../Job/docs/performance/bottlenecks.md)
* [bottlenecks.md](../../Media/docs/bottlenecks.md)
* [bottlenecks.md](../../Media/docs/performance/bottlenecks.md)
* [bottlenecks.md](../../Patient/docs/roadmap/bottlenecks.md)
* [bottlenecks.md](../../Cms/docs/bottlenecks.md)

