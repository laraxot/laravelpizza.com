# Backoffice: Sistema di Avvisi

## Panoramica
Il sistema di avvisi del backoffice fornisce notifiche in tempo reale agli amministratori riguardo eventi importanti che richiedono attenzione, come nuove richieste di iscrizione, documenti da verificare, o problematiche di sistema. Questo componente è fondamentale per garantire tempi di risposta rapidi e una gestione efficiente del portale.

**Percentuale di completamento: 70%**

## Componenti Principali

### 1. Centro Notifiche
- **Implementazione**: 75% completata
- **Descrizione**: Widget centralizzato che mostra tutte le notifiche in attesa, con indicatori di priorità.
- **File di Implementazione**:
  ```php
  // /var/www/html/<nome progetto>/laravel/Modules/Admin/app/Filament/Widgets/NotificationsWidget.php
  namespace Modules\Admin\Filament\Widgets;
  
  use Modules\Xot\Filament\Widgets\XotBaseWidget;
  
  class NotificationsWidget extends XotBaseWidget
  {
      // Implementazione del widget notifiche
      protected int $sort = 1;
      
      protected function getNotifications(): Collection
      {
          // Recupero notifiche da diverse fonti
      }
  }
  ```

### 2. Tipi di Avvisi
- **Implementazione**: 65% completata
- **Descrizione**: Sistema configurabile di tipi di avvisi con priorità e regole di visualizzazione.
- **Categorie Implementate**:
  - **Critici**: Richiedono attenzione immediata (sicurezza, errori sistema)
  - **Richieste**: Nuove iscrizioni o modifiche da approvare
  - **Informativi**: Aggiornamenti di stato o azioni completate
  - **Promemoria**: Scadenze o azioni in attesa
- **File di Implementazione**:
  ```php
  // /var/www/html/<nome progetto>/laravel/Modules/Admin/app/Enums/AlertType.php
  namespace Modules\Admin\Enums;
  
  enum AlertType: string
  {
      case CRITICAL = 'critical';
      case REQUEST = 'request';
      case INFORMATIONAL = 'informational';
      case REMINDER = 'reminder';
      
      public function getColor(): string
      {
          return match($this) {
              self::CRITICAL => 'danger',
              self::REQUEST => 'warning',
              self::INFORMATIONAL => 'info',
              self::REMINDER => 'secondary',
          };
      }
      
      public function getIcon(): string
      {
          return match($this) {
              self::CRITICAL => 'heroicon-o-exclamation-triangle',
              self::REQUEST => 'heroicon-o-document-text',
              self::INFORMATIONAL => 'heroicon-o-information-circle',
              self::REMINDER => 'heroicon-o-clock',
          };
      }
  }
  ```

### 3. Notifiche Tempo Reale
- **Implementazione**: 70% completata
- **Descrizione**: Sistema per notifiche push in tempo reale utilizzando WebSockets.
- **Tecnologie**:
  - Laravel Echo
  - Pusher (o alternativa self-hosted)
  - Service Worker per notifiche browser
- **File di Implementazione**:
  ```php
  // /var/www/html/<nome progetto>/laravel/Modules/Admin/app/Events/NewAlertEvent.php
  namespace Modules\Admin\Events;
  
  use Illuminate\Broadcasting\Channel;
  use Illuminate\Broadcasting\InteractsWithSockets;
  use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
  use Illuminate\Foundation\Events\Dispatchable;
  use Illuminate\Queue\SerializesModels;
  
  class NewAlertEvent implements ShouldBroadcast
  {
      use Dispatchable, InteractsWithSockets, SerializesModels;
      
      public function __construct(
          public readonly Alert $alert
      ) {}
      
      public function broadcastOn(): Channel
      {
          return new PrivateChannel('admin.alerts');
      }
  }
  ```

### 4. Gestore Regole di Notifica
- **Implementazione**: 65% completata
- **Descrizione**: Sistema configurabile per definire quali eventi generano notifiche e con quale priorità.
- **Funzionalità**:
  - Regole basate su condizioni
  - Filtri per tipo di evento
  - Assegnazione automatica agli amministratori
- **File di Implementazione**:
  ```php
  // /var/www/html/<nome progetto>/laravel/Modules/Admin/app/Services/AlertRulesService.php
  namespace Modules\Admin\Services;
  
  class AlertRulesService
  {
      public function processEvent(string $eventType, array $data): ?Alert
      {
          // Elabora evento in base alle regole configurate
          $rules = $this->getMatchingRules($eventType);
          
          if (empty($rules)) {
              return null;
          }
          
          return $this->createAlert($rules[0], $data);
      }
      
      protected function getMatchingRules(string $eventType): array
      {
          // Recupera regole applicabili
      }
      
      protected function createAlert(AlertRule $rule, array $data): Alert
      {
          // Crea notifica in base alla regola
      }
  }
  ```

### 5. Dashboard Avvisi
- **Implementazione**: 75% completata
- **Descrizione**: Pagina dedicata alla gestione centralizzata di tutti gli avvisi, con filtri e azioni batch.
- **Funzionalità**:
  - Filtri avanzati (tipo, data, stato)
  - Azioni batch (segna come letti, assegna, archivia)
  - Timeline eventi correlati
- **File di Implementazione**:
  ```php
  // /var/www/html/<nome progetto>/laravel/Modules/Admin/app/Filament/Resources/AlertResource.php
  namespace Modules\Admin\Filament\Resources;
  
  use Modules\Xot\Filament\Resources\XotBaseResource;
  use Filament\Tables\Columns\BadgeColumn;
  use Filament\Tables\Filters\SelectFilter;
  
  class AlertResource extends XotBaseResource
  {
      protected static ?string $model = Alert::class;
      
      public static function getFormSchema(): array
      {
          return [
              // Definizione form
          ];
      }
      
      public static function getTableColumns(): array
      {
          return [
              'type' => BadgeColumn::make('type')
                  ->label(__('admin.alerts.fields.type.label'))
                  ->enum(AlertType::class)
                  ->colors([
                      'danger' => AlertType::CRITICAL->value,
                      'warning' => AlertType::REQUEST->value,
                      'info' => AlertType::INFORMATIONAL->value,
                      'secondary' => AlertType::REMINDER->value,
                  ]),
                  
              'title' => TextColumn::make('title')
                  ->label(__('admin.alerts.fields.title.label'))
                  ->searchable()
                  ->sortable(),
                  
              'created_at' => DateTimeColumn::make('created_at')
                  ->label(__('admin.alerts.fields.created_at.label'))
                  ->sortable(),
                  
              // Altri campi...
          ];
      }
      
      public static function getTableFilters(): array
      {
          return [
              SelectFilter::make('type')
                  ->label(__('admin.alerts.filters.type.label'))
                  ->options(AlertType::class),
                  
              SelectFilter::make('is_read')
                  ->label(__('admin.alerts.filters.is_read.label'))
                  ->options([
                      '0' => __('admin.alerts.filters.is_read.options.unread'),
                      '1' => __('admin.alerts.filters.is_read.options.read'),
                  ]),
                  
              // Altri filtri...
          ];
      }
  }
  ```

## Integrazione con Altri Moduli

### Generazione Automatica Avvisi

Il sistema di avvisi è integrato con diversi moduli per generare notifiche automatiche:

```php
// /var/www/html/<nome progetto>/laravel/Modules/Dental/app/Providers/EventServiceProvider.php
namespace Modules\Dental\Providers;

use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Modules\Dental\Events\DentistRegistered;
use Modules\Dental\Listeners\NotifyAdminAboutNewDentist;

class EventServiceProvider extends ServiceProvider
{
    protected $listen = [
        DentistRegistered::class => [
            NotifyAdminAboutNewDentist::class,
        ],
        // Altri eventi...
    ];
}
```

Implementazione del listener:

```php
// /var/www/html/<nome progetto>/laravel/Modules/Dental/app/Listeners/NotifyAdminAboutNewDentist.php
namespace Modules\Dental\Listeners;

use Modules\Admin\Services\AlertService;
use Modules\Admin\Enums\AlertType;
use Modules\Dental\Events\DentistRegistered;

class NotifyAdminAboutNewDentist
{
    public function __construct(
        protected AlertService $alertService
    ) {}
    
    public function handle(DentistRegistered $event): void
    {
        $this->alertService->create(
            type: AlertType::REQUEST,
            title: 'Nuova iscrizione odontoiatra',
            description: "L'odontoiatra {$event->dentist->name} ha richiesto l'iscrizione",
            link: route('filament.resources.dentists.view', ['record' => $event->dentist->id]),
            data: [
                'dentist_id' => $event->dentist->id,
                'timestamp' => now()->timestamp,
            ]
        );
    }
}
```

## Interfaccia Utente

![Mockup Centro Notifiche](/var/www/html/<nome progetto>/docs/immagini/mockup-backoffice-avvisi.png)

### Componente Dropdown Notifiche

```blade
{{-- /var/www/html/<nome progetto>/laravel/Modules/Admin/resources/views/components/notification-dropdown.blade.php --}}
<x-filament::dropdown placement="bottom-end" width="md">
    <x-slot name="trigger">
        <button type="button" class="relative">
            <x-filament::icon name="heroicon-o-bell" class="h-5 w-5" />
            
            @if ($unreadCount > 0)
                <span class="absolute top-0 right-0 -mt-1 -mr-1 flex h-4 w-4 items-center justify-center rounded-full bg-danger-500 text-xs font-bold text-white">
                    {{ $unreadCount > 99 ? '99+' : $unreadCount }}
                </span>
            @endif
        </button>
    </x-slot>
    
    <x-filament::dropdown.list class="max-h-80 overflow-y-auto">
        <div class="p-2 flex justify-between items-center border-b border-gray-200 dark:border-gray-700">
            <h3 class="text-sm font-medium">{{ __('admin.alerts.dropdown.title') }}</h3>
            
            @if ($unreadCount > 0)
                <button type="button" wire:click="markAllAsRead" class="text-xs text-primary-600 hover:text-primary-500">
                    {{ __('admin.alerts.dropdown.mark_all_read') }}
                </button>
            @endif
        </div>
        
        @if ($alerts->isEmpty())
            <div class="py-4 px-2 text-center text-sm text-gray-500 dark:text-gray-400">
                {{ __('admin.alerts.dropdown.no_alerts') }}
            </div>
        @else
            @foreach ($alerts as $alert)
                <x-filament::dropdown.list.item 
                    :color="$alert->type->getColor()"
                    :icon="$alert->type->getIcon()"
                    :href="$alert->link"
                    :class="$alert->is_read ? 'opacity-70' : ''"
                >
                    <div>
                        <div class="font-medium">{{ $alert->title }}</div>
                        <div class="text-xs text-gray-500 dark:text-gray-400">
                            {{ $alert->created_at->diffForHumans() }}
                        </div>
                    </div>
                </x-filament::dropdown.list.item>
            @endforeach
            
            <div class="p-2 border-t border-gray-200 dark:border-gray-700">
                <x-filament::button 
                    size="xs" 
                    color="gray" 
                    href="{{ route('filament.resources.alerts.index') }}"
                    class="w-full justify-center"
                >
                    {{ __('admin.alerts.dropdown.view_all') }}
                </x-filament::button>
            </div>
        @endif
    </x-filament::dropdown.list>
</x-filament::dropdown>
```

## Test e Validazione

### Test Unitari
```php
// /var/www/html/<nome progetto>/laravel/Modules/Admin/Tests/Unit/AlertServiceTest.php
namespace Modules\Admin\Tests\Unit;

use Tests\TestCase;
use Modules\Admin\Services\AlertService;
use Modules\Admin\Enums\AlertType;

class AlertServiceTest extends TestCase
{
    /** @test */
    public function it_creates_an_alert()
    {
        // Implementazione test
    }
    
    /** @test */
    public function it_broadcasts_a_new_alert_event()
    {
        // Implementazione test
    }
}
```

### Test di Integrazione
```php
// /var/www/html/<nome progetto>/laravel/Modules/Admin/Tests/Feature/AlertNotificationTest.php
namespace Modules\Admin\Tests\Feature;

use Tests\TestCase;
use Illuminate\Support\Facades\Event;
use Modules\Dental\Events\DentistRegistered;
use Modules\Admin\Models\Alert;

class AlertNotificationTest extends TestCase
{
    /** @test */
    public function dentist_registration_creates_admin_alert()
    {
        // Implementazione test
    }
}
```

## Prossimi Sviluppi
1. Implementare notifiche push per browser *(Priorità: Alta)*
2. Aggiungere opzioni di personalizzazione per amministratori *(Priorità: Media)*
3. Introdurre metriche e analytics sulle notifiche *(Priorità: Bassa)*
4. Integrare sistema di escalation per avvisi critici *(Priorità: Media)*
5. Implementare supporto per notifiche via SMS per avvisi critici *(Priorità: Alta)*

## Collegamenti Correlati
- [Backoffice Verifica](./backoffice-verifica.md)
- [Backoffice Gestione](./backoffice-gestione.md)
- [Backoffice Rifiuti](./backoffice-rifiuti.md)
- [Sistema Notifiche](./28-sistema-notifiche.md)
