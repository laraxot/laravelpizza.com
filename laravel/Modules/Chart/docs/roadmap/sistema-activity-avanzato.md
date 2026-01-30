# Sistema Activity Avanzato con Audit Trail Completo

> [Torna alla Roadmap Principale](../roadmap.md#q3-2024-luglio-settembre)

## Stato Attuale

Il sistema Activity avanzato con audit trail completo è attualmente completato al 20%. Questo componente è fondamentale per garantire la tracciabilità di tutte le operazioni effettuate sulla piattaforma il progetto, con particolare attenzione ai dati sensibili e ai processi clinici.

## Obiettivi dell'Implementazione

L'implementazione del sistema Activity avanzato mira a:

1. Fornire un audit trail completo di tutte le operazioni sulla piattaforma
2. Garantire la conformità normativa nel tracciamento delle attività
3. Supportare l'analisi forense in caso di necessità di indagini
4. Migliorare la sicurezza attraverso il monitoraggio delle attività anomale
5. Implementare dashboard di analisi per l'utilizzo del sistema

## Componenti Implementati (20%)

- ✅ Sistema base di logging attività utente
- ✅ Registrazione operazioni CRUD principali
- ✅ Interfaccia Filament per visualizzazione attività
- ✅ Filtri base per tipo di attività e utente

## Componenti da Implementare (80%)

- 🚧 Audit trail avanzato (25%)
  - 🚧 Registrazione dettagliata modifiche dati (diff)
  - 🚧 Tracciamento navigazione e accessi a dati sensibili
  - 🚧 Log contestualizzati per operazioni cliniche
  - 📅 Firma digitale degli audit log per non ripudio
- 🚧 Analisi e reporting (15%)
  - 🚧 Dashboard per amministratori con metriche chiave
  - 🚧 Report periodici automatizzati
  - 📅 Sistema di allerta per attività sospette
  - 📅 Analisi tendenze e pattern di utilizzo
- 🚧 Integrazione workflow clinici (10%)
  - 🚧 Tracciamento completo flussi pazienti
  - 📅 Registrazione automatica eventi clinici significativi
  - 📅 Log approfonditi per modifiche trattamenti
- 📅 Funzionalità avanzate
  - 📅 Esportazione audit trail per requisiti legali
  - 📅 Conservazione a norma dei log
  - 📅 Integrazione con sistemi di monitoraggio esterni

## Architettura del Sistema

Il sistema Activity avanzato è progettato secondo un'architettura a eventi che consente massima flessibilità e completezza nel tracciamento:

```
┌───────────────────┐       ┌───────────────────┐       ┌───────────────────┐
│                   │       │                   │       │                   │
│  Eventi Sistema   │       │  Processore       │       │  Storage Log      │
│  e Utente         │─────►│  Activity          │─────►│  e Ricerca        │
│                   │       │                   │       │                   │
└───────────────────┘       └───────────────────┘       └───────────────────┘
                                      │
                                      │
                                      ▼
          ┌───────────────────┐       ┌───────────────────┐       
          │                   │       │                   │       
          │  Analisi e        │◄─────►│  Interfaccia      │       
          │  Reporting        │       │  Utente           │       
          │                   │       │                   │       
          └───────────────────┘       └───────────────────┘       
```

## Modello dei Dati

```php
// Modules/Activity/Models/Activity.php
namespace Modules\Activity\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Activity extends Model
{
    /**
     * Attributi assegnabili.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'log_name',
        'description',
        'subject_type',
        'subject_id',
        'causer_type',
        'causer_id',
        'properties',
        'event',
        'batch_uuid',
        'ip_address',
        'user_agent',
        'severity',
        'module',
        'context',
        'old_values',
        'new_values',
    ];
    
    /**
     * Gli attributi da castare.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'properties' => 'collection',
        'old_values' => 'collection',
        'new_values' => 'collection',
    ];
    
    /**
     * Livelli di severità
     */
    public const SEVERITY_INFO = 'info';
    public const SEVERITY_WARNING = 'warning';
    public const SEVERITY_ERROR = 'error';
    public const SEVERITY_CRITICAL = 'critical';
    
    /**
     * Relazione con l'oggetto soggetto dell'attività.
     */
    public function subject(): MorphTo
    {
        return $this->morphTo();
    }
    
    /**
     * Relazione con l'utente che ha causato l'attività.
     */
    public function causer(): MorphTo
    {
        return $this->morphTo();
    }
    
    /**
     * Scope per filtrare per severità.
     */
    public function scopeWithSeverity($query, string $severity)
    {
        return $query->where('severity', $severity);
    }
    
    /**
     * Scope per filtrare per modulo.
     */
    public function scopeInModule($query, string $module)
    {
        return $query->where('module', $module);
    }
    
    /**
     * Scope per filtrare per tipo di evento.
     */
    public function scopeOfEvent($query, string $event)
    {
        return $query->where('event', $event);
    }
    
    /**
     * Determina se l'attività mostra modifiche ai dati.
     */
    public function hasChanges(): bool
    {
        return $this->old_values->isNotEmpty() || $this->new_values->isNotEmpty();
    }
}
```

## Implementazione con Action Pattern

Seguendo la regola di utilizzo di Spatie Laravel-Queueable-Action invece di Service Classes, implementiamo le funzionalità principali tramite Action Pattern:

```php
// Modules/Activity/Actions/LogActivityAction.php
namespace Modules\Activity\Actions;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Modules\Activity\Models\Activity;
use Spatie\QueueableAction\QueueableAction;

class LogActivityAction
{
    use QueueableAction;
    
    /**
     * Registra un'attività nel sistema.
     *
     * @param string $description Descrizione dell'attività
     * @param \Illuminate\Database\Eloquent\Model|null $subject Oggetto dell'attività
     * @param string $event Tipo di evento
     * @param array $properties Proprietà aggiuntive
     * @param string $severity Livello di severità
     * @param array $oldValues Vecchi valori (per diff)
     * @param array $newValues Nuovi valori (per diff)
     * 
     * @return \Modules\Activity\Models\Activity
     */
    public function execute(
        string $description,
        ?Model $subject = null,
        string $event = 'generic',
        array $properties = [],
        string $severity = Activity::SEVERITY_INFO,
        array $oldValues = [],
        array $newValues = []
    ): Activity {
        $request = request();
        
        return Activity::create([
            'log_name' => 'default',
            'description' => $description,
            'subject_type' => $subject ? get_class($subject) : null,
            'subject_id' => $subject?->getKey(),
            'causer_type' => Auth::user() ? get_class(Auth::user()) : null,
            'causer_id' => Auth::id(),
            'properties' => collect($properties),
            'event' => $event,
            'ip_address' => $request?->ip(),
            'user_agent' => $request?->userAgent(),
            'severity' => $severity,
            'module' => $this->determineModule($subject),
            'context' => $this->captureContext(),
            'old_values' => collect($oldValues),
            'new_values' => collect($newValues),
        ]);
    }
    
    /**
     * Determina il modulo dal soggetto dell'attività.
     */
    protected function determineModule(?Model $subject): ?string
    {
        if (!$subject) {
            return null;
        }
        
        $class = get_class($subject);
        $parts = explode('\\', $class);
        
        return $parts[1] ?? null; // Assumendo struttura Modules\NomeModulo\...
    }
    
    /**
     * Cattura il contesto dell'operazione.
     */
    protected function captureContext(): array
    {
        return [
            'url' => request()?->fullUrl(),
            'method' => request()?->method(),
            'route' => request()?->route()?->getName(),
            'user_id' => Auth::id(),
            'timestamp' => now()->toIso8601String(),
        ];
    }
}
```

## Tracciamento Modifiche Modelli

Per il tracciamento dettagliato delle modifiche ai modelli, implementiamo un trait che può essere utilizzato nei modelli che richiedono audit trail:

```php
// Modules/Activity/Traits/LogsActivity.php
namespace Modules\Activity\Traits;

use Modules\Activity\Actions\LogActivityAction;
use Illuminate\Database\Eloquent\Model;

trait LogsActivity
{
    /**
     * Boot del trait.
     */
    public static function bootLogsActivity()
    {
        static::created(function(Model $model) {
            app(LogActivityAction::class)->execute(
                "Creato {$model->getTable()}",
                $model,
                'created',
                [],
                'info',
                [],
                $model->getAttributes()
            );
        });
        
        static::updated(function(Model $model) {
            if (count($model->getDirty()) > 0) {
                app(LogActivityAction::class)->execute(
                    "Aggiornato {$model->getTable()}",
                    $model,
                    'updated',
                    [],
                    'info',
                    $model->getOriginal(),
                    $model->getAttributes()
                );
            }
        });
        
        static::deleted(function(Model $model) {
            app(LogActivityAction::class)->execute(
                "Eliminato {$model->getTable()}",
                $model,
                'deleted',
                [],
                'warning',
                $model->getOriginal(),
                []
            );
        });
    }
    
    /**
     * Definisce gli attributi da escludere dal log.
     */
    public function getActivityLogExcludedAttributes(): array
    {
        return property_exists($this, 'activityLogExcludedAttributes')
            ? $this->activityLogExcludedAttributes
            : ['password', 'remember_token', 'updated_at'];
    }
}
```

## Implementazione in Filament

L'interfaccia di gestione audit trail utilizza esclusivamente Filament, seguendo la regola fondamentale del progetto:

```php
// Modules/Activity/Filament/Resources/ActivityResource.php
namespace Modules\Activity\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use Filament\Tables\Filters;
use Modules\Activity\Models\Activity;
use Modules\Xot\Filament\Resources\XotBaseResource;

class ActivityResource extends XotBaseResource
{
    protected static ?string $model = Activity::class;
    
    public static function table(Tables\Table $table): Tables\Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Data e Ora')
                    ->dateTime()
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('description')
                    ->label('Descrizione')
                    ->searchable(),
                Tables\Columns\TextColumn::make('causer.name')
                    ->label('Utente')
                    ->searchable(),
                Tables\Columns\TextColumn::make('subject_type')
                    ->label('Tipo Oggetto')
                    ->formatStateUsing(fn (string $state): string => class_basename($state))
                    ->searchable(),
                Tables\Columns\TextColumn::make('event')
                    ->label('Evento')
                    ->badge()
                    ->color(fn (string $state): string => match($state) {
                        'created' => 'success',
                        'updated' => 'warning',
                        'deleted' => 'danger',
                        default => 'primary',
                    })
                    ->searchable(),
                Tables\Columns\TextColumn::make('module')
                    ->label('Modulo')
                    ->searchable(),
                Tables\Columns\TextColumn::make('severity')
                    ->label('Severità')
                    ->badge()
                    ->color(fn (string $state): string => match($state) {
                        'info' => 'info',
                        'warning' => 'warning',
                        'error' => 'danger',
                        'critical' => 'danger',
                        default => 'primary',
                    })
                    ->searchable(),
            ])
            ->filters([
                Filters\SelectFilter::make('event')
                    ->options([
                        'created' => 'Creazione',
                        'updated' => 'Aggiornamento',
                        'deleted' => 'Eliminazione',
                        'viewed' => 'Visualizzazione',
                        'login' => 'Login',
                        'logout' => 'Logout',
                        'failed_login' => 'Login Fallito',
                    ]),
                Filters\SelectFilter::make('severity')
                    ->options([
                        'info' => 'Informazione',
                        'warning' => 'Avviso',
                        'error' => 'Errore',
                        'critical' => 'Critico',
                    ]),
                Filters\SelectFilter::make('module')
                    ->options([
                        'Patient' => 'Pazienti',
                        'Dental' => 'Dentale',
                        'User' => 'Utenti',
                        'Media' => 'Documenti',
                        'Auth' => 'Autenticazione',
                    ]),
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
            ])
            ->bulkActions([])
            ->defaultSort('created_at', 'desc');
    }
    
    public static function getPages(): array
    {
        return [
            'index' => Pages\ListActivities::route('/'),
            'view' => Pages\ViewActivity::route('/{record}'),
        ];
    }
}
```

## Interfaccia di Visualizzazione Dettagli

```php
// Modules/Activity/Filament/Resources/ActivityResource/Pages/ViewActivity.php
namespace Modules\Activity\Filament\Resources\ActivityResource\Pages;

use Filament\Resources\Pages\ViewRecord;
use Modules\Activity\Filament\Resources\ActivityResource;
use Illuminate\Contracts\Support\Htmlable;

class ViewActivity extends ViewRecord
{
    protected static string $resource = ActivityResource::class;
    
    public function getTitle(): string|Htmlable
    {
        return "Dettaglio Attività #{$this->record->id}";
    }
    
    protected function getHeaderActions(): array
    {
        return [];
    }
    
    protected function mutateFormData(array $data): array
    {
        // Formatta i dati per la visualizzazione
        if (isset($data['old_values']) && isset($data['new_values'])) {
            $data['changes'] = $this->formatChanges($data['old_values'], $data['new_values']);
        }
        
        return $data;
    }
    
    protected function formatChanges(array $oldValues, array $newValues): array
    {
        $changes = [];
        
        // Combina tutte le chiavi da entrambi gli array
        $allKeys = array_unique([...array_keys($oldValues), ...array_keys($newValues)]);
        
        foreach ($allKeys as $key) {
            $oldValue = $oldValues[$key] ?? null;
            $newValue = $newValues[$key] ?? null;
            
            if ($oldValue !== $newValue) {
                $changes[$key] = [
                    'old' => $oldValue,
                    'new' => $newValue,
                ];
            }
        }
        
        return $changes;
    }
}
```

## Implementazione Dashboard di Analisi

La dashboard di analisi offrirà una visione aggregata delle attività del sistema:

```php
// Modules/Activity/Filament/Widgets/ActivityOverviewWidget.php
namespace Modules\Activity\Filament\Widgets;

use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Modules\Activity\Models\Activity;
use Carbon\Carbon;

class ActivityOverviewWidget extends BaseWidget
{
    protected function getStats(): array
    {
        $todayCount = Activity::whereDate('created_at', Carbon::today())->count();
        $yesterdayCount = Activity::whereDate('created_at', Carbon::yesterday())->count();
        $percentChange = $yesterdayCount ? (($todayCount - $yesterdayCount) / $yesterdayCount) * 100 : 0;
        
        return [
            Stat::make('Attività Oggi', $todayCount)
                ->description($percentChange >= 0 ? "Aumento del " . number_format(abs($percentChange), 1) . "%" : "Diminuzione del " . number_format(abs($percentChange), 1) . "%")
                ->descriptionIcon($percentChange >= 0 ? 'heroicon-m-arrow-trending-up' : 'heroicon-m-arrow-trending-down')
                ->color($percentChange >= 0 ? 'success' : 'danger'),
                
            Stat::make('Login Falliti (24h)', Activity::where('event', 'failed_login')
                ->where('created_at', '>=', now()->subDay())
                ->count())
                ->color('danger'),
                
            Stat::make('Modifiche Dati Sensibili (24h)', Activity::where('event', 'updated')
                ->whereIn('module', ['Patient', 'Dental'])
                ->where('created_at', '>=', now()->subDay())
                ->count())
                ->color('warning'),
        ];
    }
}
```

## Integrazione con Altri Moduli

### 1. Integrazione con Autenticazione

```php
// Modules/User/Listeners/LogSuccessfulLogin.php
namespace Modules\User\Listeners;

use Illuminate\Auth\Events\Login;
use Modules\Activity\Actions\LogActivityAction;

class LogSuccessfulLogin
{
    public function handle(Login $event): void
    {
        app(LogActivityAction::class)->execute(
            "Login effettuato",
            $event->user,
            'login',
            [
                'guard' => $event->guard,
            ],
            'info'
        );
    }
}

// Registrazione in AuthServiceProvider
```

### 2. Integrazione con Modulo Patient

```php
// Modules/Patient/Models/Patient.php
use Modules\Activity\Traits\LogsActivity;

class Patient extends Model
{
    use LogsActivity;
    
    /**
     * Attributi da escludere dal log di attività.
     */
    protected $activityLogExcludedAttributes = [
        'updated_at',
        'created_at',
        'remember_token',
    ];
}
```

## Audit Trail per Accessi ai Dati Sensibili

Per implementare il tracciamento degli accessi ai dati sensibili:

```php
// Modules/Activity/Actions/LogDataAccessAction.php
namespace Modules\Activity\Actions;

use Illuminate\Database\Eloquent\Model;
use Spatie\QueueableAction\QueueableAction;

class LogDataAccessAction
{
    use QueueableAction;
    
    /**
     * Registra l'accesso a dati sensibili.
     */
    public function execute(
        Model $subject,
        string $action = 'viewed',
        array $context = []
    ): void {
        app(LogActivityAction::class)->execute(
            "Accesso a {$subject->getTable()} #{$subject->getKey()}",
            $subject,
            $action,
            $context,
            'info'
        );
    }
}

// Esempio di middleware o trait per implementare il tracciamento automatico
```

## Calendario di Completamento

| Funzionalità | Completamento Previsto | Priorità |
|--------------|------------------------|----------|
| Audit trail modifiche dati | Luglio 2024 | Alta |
| Tracciamento accessi | Luglio 2024 | Alta |
| Dashboard admin | Luglio 2024 | Media |
| Log workflow clinici | Agosto 2024 | Alta |
| Report automatici | Agosto 2024 | Media |
| Sistema di allerta | Settembre 2024 | Media |
| Esportazione audit | Settembre 2024 | Bassa |

## Metriche di Successo

- Copertura audit trail 100% per dati sensibili
- Tempo di risposta per ricerche audit trail < 3 secondi
- Latenza aggiunta dal sistema di logging < 50ms
- Efficacia rilevamento accessi non autorizzati > 95%
- Conformità requisiti GDPR e normative sanitarie 100%
