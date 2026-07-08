# Sistema di Notifiche con Filament Components

## Introduzione

Il sistema di notifiche del modulo Notify è stato reimplementato utilizzando i componenti Filament per garantire:

- Consistenza visiva con il resto dell'applicazione
- Gestione efficiente delle notifiche
- Supporto per diversi tipi di notifiche
- Integrazione con il sistema di code Laravel

## Componenti di Base

### Notifica Base
```blade
<x-filament::notification
    :title="$notification->title"
    :description="$notification->message"
    :type="$notification->type"
    :datetime="$notification->created_at"
/>
```

### Lista Notifiche
```blade
<x-filament::notifications.list>
    @foreach($notifications as $notification)
        <x-filament::notifications.notification
            :notification="$notification"
            :wire:key="$notification->id"
        />
    @endforeach
</x-filament::notifications.list>
```

### Indicatore Notifiche
```blade
<x-filament::notifications.indicator
    :count="$unreadCount"
    :href="route('notifications.index')"
/>
```

## Tipi di Notifica

### Notifica Informativa
```blade
<x-filament::notification
    title="Informazione"
    description="Il processo è stato completato con successo"
    type="info"
    :actions="[
        Action::make('view')
            ->label('Visualizza')
            ->url(route('process.show', $process))
    ]"
/>
```

### Notifica di Successo
```blade
<x-filament::notification
    title="Successo"
    description="L'operazione è stata completata"
    type="success"
    :actions="[
        Action::make('undo')
            ->label('Annulla')
            ->action(fn () => $this->undoAction())
    ]"
/>
```

### Notifica di Errore
```blade
<x-filament::notification
    title="Errore"
    description="Si è verificato un errore durante l'operazione"
    type="danger"
    :actions="[
        Action::make('retry')
            ->label('Riprova')
            ->action(fn () => $this->retryAction())
    ]"
/>
```

## Integrazione con Actions

### Invio Notifica
```php
class SendNotificationAction implements QueueableAction
{
    public function execute(NotificationData $data): void
    {
        Notification::make()
            ->title($data->title)
            ->body($data->message)
            ->type($data->type)
            ->actions([
                Action::make('view')
                    ->button()
                    ->url($data->action_url),
            ])
            ->send();
    }
}
```

### Gestione Code
```php
class ProcessQueueAction implements QueueableAction
{
    public function execute(string $queue = 'notifications'): void
    {
        Queue::connection('database')
            ->pushOn($queue, new ProcessNotificationsJob());
    }
}
```

## Livewire Components

### Notification List
```php
class NotificationList extends Component implements HasForms
{
    use InteractsWithForms;

    public function render()
    {
        return view('notify::notifications.list', [
            'notifications' => auth()->user()
                ->notifications()
                ->latest()
                ->paginate(10)
        ]);
    }

    public function markAsRead($id)
    {
        auth()->user()
            ->notifications()
            ->findOrFail($id)
            ->markAsRead();

        $this->dispatch('notification-read');
    }

    public function markAllAsRead()
    {
        auth()->user()
            ->unreadNotifications
            ->markAsRead();

        $this->dispatch('all-notifications-read');
    }
}
```

### Notification Counter
```php
class NotificationCounter extends Component
{
    public $count = 0;

    protected $listeners = [
        'notification-received' => 'updateCount',
        'notification-read' => 'updateCount',
        'all-notifications-read' => 'updateCount'
    ];

    public function mount()
    {
        $this->updateCount();
    }

    public function updateCount()
    {
        $this->count = auth()->user()
            ->unreadNotifications()
            ->count();
    }

    public function render()
    {
        return view('notify::notifications.counter');
    }
}
```

## Testing

### Action Tests
```php
class SendNotificationActionTest extends TestCase
{
    public function test_it_sends_notification()
    {
        Notification::fake();

        $action = app(SendNotificationAction::class);
        
        $action->execute(NotificationData::from([
            'title' => 'Test',
            'message' => 'Test message',
            'type' => 'info'
        ]));

        Notification::assertSentTo(
            auth()->user(),
            DatabaseNotification::class
        );
    }
}
```

### Component Tests
```php
class NotificationListTest extends TestCase
{
    public function test_it_displays_notifications()
    {
        $user = User::factory()->create();
        $notification = Notification::factory()
            ->for($user)
            ->create();

        Livewire::actingAs($user)
            ->test(NotificationList::class)
            ->assertSee($notification->title)
            ->assertSee($notification->message);
    }

    public function test_it_marks_notification_as_read()
    {
        $user = User::factory()->create();
        $notification = Notification::factory()
            ->unread()
            ->for($user)
            ->create();

        Livewire::actingAs($user)
            ->test(NotificationList::class)
            ->call('markAsRead', $notification->id)
            ->assertEmitted('notification-read');

        $this->assertTrue($notification->fresh()->read());
    }
}
```

## Best Practices

1. **Organizzazione**
   - Separare logica di business nelle Actions
   - Utilizzare componenti Livewire per interattività
   - Mantenere i template puliti e riutilizzabili

2. **Performance**
   - Utilizzare code per notifiche asincrone
   - Implementare caching dove appropriato
   - Paginare le liste di notifiche

3. **UX**
   - Fornire feedback immediato
   - Permettere azioni rapide sulle notifiche
   - Mantenere l'interfaccia responsive

4. **Manutenibilità**
   - Documentare i componenti
   - Scrivere test completi
   - Seguire le convenzioni di naming

## Collegamenti

- [Documentazione Form](tailwind_forms.md)
- [Documentazione Layout](tailwind_layouts.md)
- [Documentazione Componenti](tailwind_components.md)
- [Architettura](architecture.md)
