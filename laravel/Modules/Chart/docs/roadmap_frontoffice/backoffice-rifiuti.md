# Backoffice: Gestione Richieste Rifiutate

## Panoramica
Questo modulo del backoffice è dedicato alla gestione delle richieste di iscrizione che sono state rifiutate, sia per pazienti che per odontoiatri. Il sistema fornisce una visione completa delle richieste rifiutate, le motivazioni del rifiuto, e gli strumenti per gestire eventuali ricorsi o nuove sottomissioni. Questo processo è essenziale per mantenere la trasparenza e garantire che tutte le richieste siano valutate correttamente.

**Percentuale di completamento: 80%**

## Componenti Principali

### 1. Dashboard Richieste Rifiutate
- **Implementazione**: 85% completata
- **Descrizione**: Vista centralizzata di tutte le richieste rifiutate con filtri avanzati e dettagli.
- **Funzionalità**:
  - Filtri per tipo utente (paziente/odontoiatra)
  - Filtri per data rifiuto
  - Filtri per motivo rifiuto
  - Ricerca per nome/email
- **File di Implementazione**:
  ```php
  // /var/www/html/<nome progetto>/laravel/Modules/Admin/app/Filament/Resources/RejectedRequestResource.php
  namespace Modules\Admin\Filament\Resources;
  
  use Filament\Tables\Columns\TextColumn;
  use Filament\Tables\Filters\SelectFilter;
  use Modules\Xot\Filament\Resources\XotBaseResource;
  
  class RejectedRequestResource extends XotBaseResource
  {
      protected static ?string $model = Request::class;
      
      public static function getEloquentQuery()
      {
          return parent::getEloquentQuery()->rejected();
      }
      
      public static function getFormSchema(): array
      {
          return [
              // Schema form con tutti i campi necessari
          ];
      }
      
      public static function getTableColumns(): array
      {
          return [
              'id' => TextColumn::make('id')
                  ->label(__('admin.rejected_requests.fields.id.label'))
                  ->sortable(),
                  
              'user_type' => TextColumn::make('user_type')
                  ->label(__('admin.rejected_requests.fields.user_type.label'))
                  ->formatStateUsing(fn (string $state): string => match($state) {
                      'patient' => __('admin.rejected_requests.user_types.patient'),
                      'dentist' => __('admin.rejected_requests.user_types.dentist'),
                      default => $state,
                  }),
                  
              'name' => TextColumn::make('user.name')
                  ->label(__('admin.rejected_requests.fields.name.label'))
                  ->searchable()
                  ->sortable(),
                  
              'email' => TextColumn::make('user.email')
                  ->label(__('admin.rejected_requests.fields.email.label'))
                  ->searchable(),
                  
              'rejected_at' => DateTimeColumn::make('rejected_at')
                  ->label(__('admin.rejected_requests.fields.rejected_at.label'))
                  ->sortable(),
                  
              'rejected_by' => TextColumn::make('rejector.name')
                  ->label(__('admin.rejected_requests.fields.rejected_by.label')),
                  
              'reason' => TextColumn::make('rejection_reason')
                  ->label(__('admin.rejected_requests.fields.reason.label'))
                  ->limit(50)
                  ->tooltip(function (TextColumn $column): ?string {
                      $state = $column->getState();
                      return strlen($state) > 50 ? $state : null;
                  }),
          ];
      }
      
      public static function getTableFilters(): array
      {
          return [
              SelectFilter::make('user_type')
                  ->label(__('admin.rejected_requests.filters.user_type.label'))
                  ->options([
                      'patient' => __('admin.rejected_requests.user_types.patient'),
                      'dentist' => __('admin.rejected_requests.user_types.dentist'),
                  ]),
                  
              DateRangeFilter::make('rejected_at')
                  ->label(__('admin.rejected_requests.filters.rejected_at.label')),
                  
              // Altri filtri...
          ];
      }
  }
  ```

### 2. Dettaglio Richiesta Rifiutata
- **Implementazione**: 80% completata
- **Descrizione**: Vista dettagliata di una singola richiesta rifiutata con tutti i dati e documenti.
- **Funzionalità**:
  - Visualizzazione completa dati utente
  - Motivo dettagliato del rifiuto
  - Storico interazioni
  - Documenti allegati
  - Note dell'amministratore
- **File di Implementazione**:
  ```php
  // /var/www/html/<nome progetto>/laravel/Modules/Admin/app/Filament/Resources/RejectedRequestResource/Pages/ViewRejectedRequest.php
  namespace Modules\Admin\Filament\Resources\RejectedRequestResource\Pages;
  
  use Modules\Admin\Filament\Resources\RejectedRequestResource;
  use Modules\Xot\Filament\Resources\Pages\XotBaseViewRecord;
  
  class ViewRejectedRequest extends XotBaseViewRecord
  {
      protected static string $resource = RejectedRequestResource::class;
      
      public function mount($record): void
      {
          parent::mount($record);
          
          // Carica le relazioni necessarie
          $this->record->load(['user', 'documents', 'rejector', 'notes']);
      }
      
      protected function getHeaderActions(): array
      {
          return [
              Actions\Action::make('reconsider')
                  ->label(__('admin.rejected_requests.actions.reconsider.label'))
                  ->icon('heroicon-o-arrow-path')
                  ->color('secondary')
                  ->action(fn () => $this->reconsider())
                  ->requiresConfirmation(),
          ];
      }
      
      protected function reconsider(): void
      {
          // Logica per riconsiderare la richiesta
          app(ReconsiderRejectedRequestAction::class)->handle($this->record);
          
          Notification::make()
              ->title(__('admin.rejected_requests.notifications.reconsidered.title'))
              ->success()
              ->send();
              
          $this->redirect(RejectedRequestResource::getUrl());
      }
  }
  ```

### 3. Gestione Ricorsi
- **Implementazione**: 75% completata
- **Descrizione**: Sistema per gestire i ricorsi presentati dagli utenti dopo un rifiuto.
- **Funzionalità**:
  - Registrazione ricorsi
  - Upload documentazione aggiuntiva
  - Assegnazione ad amministratore specifico
  - Notifiche automatiche
  - Tracking stato ricorso
- **File di Implementazione**:
  ```php
  // /var/www/html/<nome progetto>/laravel/Modules/Admin/app/Models/Appeal.php
  namespace Modules\Admin\Models;
  
  use Modules\Xot\Models\BaseModel;
  
  class Appeal extends BaseModel
  {
      protected $fillable = [
          'request_id',
          'user_id',
          'status',
          'appeal_reason',
          'admin_notes',
          'assigned_to',
          'decided_at',
          'decided_by',
          'decision',
          'decision_reason',
      ];
      
      protected $casts = [
          'status' => AppealStatus::class,
          'decided_at' => 'datetime',
      ];
      
      public function request()
      {
          return $this->belongsTo(Request::class);
      }
      
      public function user()
      {
          return $this->belongsTo(User::class);
      }
      
      public function assignee()
      {
          return $this->belongsTo(User::class, 'assigned_to');
      }
      
      public function decider()
      {
          return $this->belongsTo(User::class, 'decided_by');
      }
      
      public function documents()
      {
          return $this->morphMany(Document::class, 'documentable');
      }
      
      public function isPending(): bool
      {
          return $this->status === AppealStatus::PENDING;
      }
      
      public function isApproved(): bool
      {
          return $this->status === AppealStatus::APPROVED;
      }
      
      public function isRejected(): bool
      {
          return $this->status === AppealStatus::REJECTED;
      }
  }
  ```

### 4. Form di Riconsiderazione
- **Implementazione**: 70% completata
- **Descrizione**: Interfaccia per riconsiderare una richiesta precedentemente rifiutata.
- **Flusso di Lavoro**:
  1. Amministratore seleziona "Riconsiderare"
  2. Viene mostrato un form per inserire note e motivazione
  3. La richiesta torna nello stato "In Revisione"
  4. Notifica all'utente che la sua richiesta è stata riconsiderata
- **File di Implementazione**:
  ```php
  // /var/www/html/<nome progetto>/laravel/Modules/Admin/app/Actions/ReconsiderRejectedRequestAction.php
  namespace Modules\Admin\Actions;
  
  use Modules\Admin\Enums\RequestStatus;
  use Modules\Admin\Models\Request;
  use Modules\Admin\Notifications\RequestReconsideredNotification;
  
  class ReconsiderRejectedRequestAction
  {
      public function handle(Request $request, ?string $note = null): bool
      {
          // Aggiorna lo stato della richiesta
          $request->update([
              'status' => RequestStatus::UNDER_REVIEW,
              'rejected_at' => null,
              'rejected_by' => null,
              'rejection_reason' => null,
              'reconsidered_at' => now(),
              'reconsidered_by' => auth()->id(),
              'reconsideration_note' => $note,
          ]);
          
          // Crea un record nel log delle attività
          activity()
              ->performedOn($request)
              ->causedBy(auth()->user())
              ->withProperties([
                  'action' => 'reconsider',
                  'note' => $note,
              ])
              ->log('request_reconsidered');
          
          // Notifica l'utente
          $request->user->notify(new RequestReconsideredNotification($request));
          
          return true;
      }
  }
  ```

### 5. Statistiche e Reporting
- **Implementazione**: 85% completata
- **Descrizione**: Dashboard con statistiche e report sui rifiuti per analisi e miglioramento del processo.
- **Metriche**:
  - Tasso di rifiuto per tipo utente
  - Motivi più comuni di rifiuto
  - Tempi medi di risposta
  - Tasso di ricorsi
  - Tasso di approvazione dopo ricorso
- **File di Implementazione**:
  ```php
  // /var/www/html/<nome progetto>/laravel/Modules/Admin/app/Filament/Widgets/RejectionStatisticsWidget.php
  namespace Modules\Admin\Filament\Widgets;
  
  use Modules\Xot\Filament\Widgets\XotBaseWidget;
  
  class RejectionStatisticsWidget extends XotBaseWidget
  {
      protected static string $view = 'admin::widgets.rejection-statistics';
      
      protected function getViewData(): array
      {
          return [
              'rejectionRate' => $this->calculateRejectionRate(),
              'topRejectionReasons' => $this->getTopRejectionReasons(),
              'averageResponseTime' => $this->calculateAverageResponseTime(),
              'appealRate' => $this->calculateAppealRate(),
              'appealSuccessRate' => $this->calculateAppealSuccessRate(),
          ];
      }
      
      protected function calculateRejectionRate(): array
      {
          // Calcola il tasso di rifiuto per tipo di utente
          $total = Request::count();
          $rejected = Request::rejected()->count();
          
          $patientTotal = Request::where('user_type', 'patient')->count();
          $patientRejected = Request::rejected()->where('user_type', 'patient')->count();
          
          $dentistTotal = Request::where('user_type', 'dentist')->count();
          $dentistRejected = Request::rejected()->where('user_type', 'dentist')->count();
          
          return [
              'overall' => $total > 0 ? round(($rejected / $total) * 100, 2) : 0,
              'patient' => $patientTotal > 0 ? round(($patientRejected / $patientTotal) * 100, 2) : 0,
              'dentist' => $dentistTotal > 0 ? round(($dentistRejected / $dentistTotal) * 100, 2) : 0,
          ];
      }
      
      protected function getTopRejectionReasons(): array
      {
          // Recupera i motivi più comuni di rifiuto
          return Request::rejected()
              ->select('rejection_reason')
              ->selectRaw('COUNT(*) as count')
              ->groupBy('rejection_reason')
              ->orderByDesc('count')
              ->limit(5)
              ->get()
              ->map(function ($item) {
                  return [
                      'reason' => Str::limit($item->rejection_reason, 50),
                      'count' => $item->count,
                  ];
              })
              ->toArray();
      }
      
      // Altri metodi di calcolo...
  }
  ```

## Implementazione della Notifica di Riconsiderazione

```php
// /var/www/html/<nome progetto>/laravel/Modules/Admin/app/Notifications/RequestReconsideredNotification.php
namespace Modules\Admin\Notifications;

use Illuminate\Notifications\Notification;
use Modules\Admin\Models\Request;
use Modules\Notify\Actions\Email\SendSpatieEmailAction;

class RequestReconsideredNotification extends Notification
{
    public function __construct(
        public readonly Request $request
    ) {}
    
    public function via($notifiable): array
    {
        return ['mail', 'database'];
    }
    
    public function toMail($notifiable): SpatieEmail
    {
        $email = new SpatieEmail('request_reconsidered', [
            'name' => $notifiable->name,
            'user_type' => $this->request->user_type,
            'login_url' => route('login'),
        ]);
        
        // Impostazione esplicita del destinatario (regola obbligatoria)
        if (method_exists($notifiable, 'routeNotificationFor')) {
            $email->to($notifiable->routeNotificationFor('mail'));
        }
        
        return $email;
    }
    
    public function toDatabase($notifiable): array
    {
        return [
            'request_id' => $this->request->id,
            'message' => 'La tua richiesta è stata riconsiderata',
            'user_type' => $this->request->user_type,
        ];
    }
}
```

## Enum per lo Stato del Ricorso

```php
// /var/www/html/<nome progetto>/laravel/Modules/Admin/app/Enums/AppealStatus.php
namespace Modules\Admin\Enums;

enum AppealStatus: string
{
    case PENDING = 'pending';
    case APPROVED = 'approved';
    case REJECTED = 'rejected';
    
    public function getLabel(): string
    {
        return match($this) {
            self::PENDING => __('admin.appeals.status.pending'),
            self::APPROVED => __('admin.appeals.status.approved'),
            self::REJECTED => __('admin.appeals.status.rejected'),
        };
    }
    
    public function getColor(): string
    {
        return match($this) {
            self::PENDING => 'warning',
            self::APPROVED => 'success',
            self::REJECTED => 'danger',
        };
    }
}
```

## Interfaccia Utente

### Componente Statistiche Rifiuti

```blade
{{-- /var/www/html/<nome progetto>/laravel/Modules/Admin/resources/views/widgets/rejection-statistics.blade.php --}}
<x-filament::card>
    <div class="space-y-4">
        <div class="flex items-center justify-between">
            <h2 class="text-lg font-bold tracking-tight">
                {{ __('admin.rejected_requests.statistics.title') }}
            </h2>
            
            <x-filament::icon-button
                icon="heroicon-o-arrow-path"
                wire:click="$refresh"
                :label="__('admin.rejected_requests.statistics.refresh')"
            />
        </div>
        
        <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-3">
            <div class="rounded-lg border border-gray-200 bg-white p-4 shadow-sm dark:border-gray-700 dark:bg-gray-800">
                <h3 class="text-sm font-medium text-gray-500 dark:text-gray-400">
                    {{ __('admin.rejected_requests.statistics.rejection_rate') }}
                </h3>
                
                <div class="mt-2 flex items-baseline justify-between">
                    <div class="text-2xl font-semibold text-gray-900 dark:text-white">
                        {{ $rejectionRate['overall'] }}%
                    </div>
                    
                    <div class="text-sm">
                        <span class="text-gray-500 dark:text-gray-400">
                            {{ __('admin.rejected_requests.statistics.patient') }}:
                        </span>
                        <span class="font-medium text-gray-900 dark:text-white">
                            {{ $rejectionRate['patient'] }}%
                        </span>
                    </div>
                    
                    <div class="text-sm">
                        <span class="text-gray-500 dark:text-gray-400">
                            {{ __('admin.rejected_requests.statistics.dentist') }}:
                        </span>
                        <span class="font-medium text-gray-900 dark:text-white">
                            {{ $rejectionRate['dentist'] }}%
                        </span>
                    </div>
                </div>
            </div>
            
            <div class="rounded-lg border border-gray-200 bg-white p-4 shadow-sm dark:border-gray-700 dark:bg-gray-800">
                <h3 class="text-sm font-medium text-gray-500 dark:text-gray-400">
                    {{ __('admin.rejected_requests.statistics.appeal_rate') }}
                </h3>
                
                <div class="mt-2 flex items-baseline justify-between">
                    <div class="text-2xl font-semibold text-gray-900 dark:text-white">
                        {{ $appealRate }}%
                    </div>
                    
                    <div class="text-sm">
                        <span class="text-gray-500 dark:text-gray-400">
                            {{ __('admin.rejected_requests.statistics.success_rate') }}:
                        </span>
                        <span class="font-medium text-gray-900 dark:text-white">
                            {{ $appealSuccessRate }}%
                        </span>
                    </div>
                </div>
            </div>
            
            <div class="rounded-lg border border-gray-200 bg-white p-4 shadow-sm dark:border-gray-700 dark:bg-gray-800">
                <h3 class="text-sm font-medium text-gray-500 dark:text-gray-400">
                    {{ __('admin.rejected_requests.statistics.average_response_time') }}
                </h3>
                
                <div class="mt-2 text-2xl font-semibold text-gray-900 dark:text-white">
                    {{ $averageResponseTime }} {{ __('admin.rejected_requests.statistics.hours') }}
                </div>
            </div>
        </div>
        
        <div>
            <h3 class="mb-2 text-sm font-medium text-gray-500 dark:text-gray-400">
                {{ __('admin.rejected_requests.statistics.top_reasons') }}
            </h3>
            
            <ul class="divide-y divide-gray-200 rounded-lg border border-gray-200 bg-white dark:divide-gray-700 dark:border-gray-700 dark:bg-gray-800">
                @forelse ($topRejectionReasons as $reason)
                    <li class="flex items-center justify-between py-3 px-4">
                        <span class="text-sm text-gray-900 dark:text-white">
                            {{ $reason['reason'] }}
                        </span>
                        
                        <span class="inline-flex items-center rounded-full bg-gray-100 px-2.5 py-0.5 text-xs font-medium text-gray-800 dark:bg-gray-700 dark:text-gray-300">
                            {{ $reason['count'] }}
                        </span>
                    </li>
                @empty
                    <li class="py-3 px-4 text-center text-sm text-gray-500 dark:text-gray-400">
                        {{ __('admin.rejected_requests.statistics.no_data') }}
                    </li>
                @endforelse
            </ul>
        </div>
    </div>
</x-filament::card>
```

## Test e Validazione

### Test Unitari
```php
// /var/www/html/<nome progetto>/laravel/Modules/Admin/Tests/Unit/ReconsiderRejectedRequestActionTest.php
namespace Modules\Admin\Tests\Unit;

use Tests\TestCase;
use Modules\Admin\Actions\ReconsiderRejectedRequestAction;
use Modules\Admin\Enums\RequestStatus;
use Modules\Admin\Models\Request;
use Modules\Admin\Notifications\RequestReconsideredNotification;
use Illuminate\Support\Facades\Notification;

class ReconsiderRejectedRequestActionTest extends TestCase
{
    /** @test */
    public function it_reconsiders_a_rejected_request()
    {
        // Implementazione test
        Notification::fake();
        
        $request = Request::factory()->rejected()->create();
        $user = $request->user;
        
        $action = new ReconsiderRejectedRequestAction();
        $result = $action->handle($request, 'Documentation was incomplete');
        
        $this->assertTrue($result);
        $this->assertEquals(RequestStatus::UNDER_REVIEW, $request->fresh()->status);
        $this->assertNull($request->fresh()->rejected_at);
        $this->assertNull($request->fresh()->rejected_by);
        $this->assertNull($request->fresh()->rejection_reason);
        $this->assertNotNull($request->fresh()->reconsidered_at);
        $this->assertNotNull($request->fresh()->reconsidered_by);
        $this->assertEquals('Documentation was incomplete', $request->fresh()->reconsideration_note);
        
        Notification::assertSentTo($user, RequestReconsideredNotification::class);
    }
}
```

### Test di Integrazione
```php
// /var/www/html/<nome progetto>/laravel/Modules/Admin/Tests/Feature/RejectedRequestManagementTest.php
namespace Modules\Admin\Tests\Feature;

use Tests\TestCase;
use Modules\Admin\Models\Request;
use Modules\Admin\Enums\RequestStatus;

class RejectedRequestManagementTest extends TestCase
{
    /** @test */
    public function admin_can_view_rejected_requests()
    {
        // Implementazione test
    }
    
    /** @test */
    public function admin_can_reconsider_a_rejected_request()
    {
        // Implementazione test
    }
}
```

## Prossimi Sviluppi
1. Implementare sistema di escalation per ricorsi *(Priorità: Media)*
2. Creare sistema di feedback strutturato per migliorare il processo *(Priorità: Alta)*
3. Sviluppare analisi predittiva per identificare potenziali rifiuti *(Priorità: Bassa)*
4. Migliorare il sistema di notifiche automatiche *(Priorità: Media)*
5. Implementare dashboard di tendenze per monitorare l'evoluzione dei rifiuti nel tempo *(Priorità: Bassa)*

## Collegamenti Correlati
- [Backoffice Verifica](./backoffice-verifica.md)
- [Backoffice Gestione](./backoffice-gestione.md)
- [Backoffice Avvisi](./backoffice-avvisi.md)
- [Iscrizione Odontoiatra](./09-iscrizione-odontoiatra.md)
- [Iscrizione Paziente](./06-iscrizione-paziente.md)
