# Queueable Actions del Modulo Notify

## SendNotificationAction

### Responsabilità
- Invio notifiche
- Gestione code
- Tracking eventi

### Implementazione
```php
use Spatie\QueueableAction\QueueableAction;
use Illuminate\Database\Eloquent\Model;
use Modules\Notify\Models\NotificationLog;

final class SendNotificationAction extends QueueableAction
{
    public function execute(
        Model $recipient,
        string $templateCode,
        array $data = [],
        array $channels = [],
        array $options = []
    ): NotificationLog {
        $template = Template::where('code', $templateCode)->firstOrFail();
        $content = $this->compileTemplate($template, $data);

        $notification = new NotificationLog([
            'template_id' => $template->id,
            'recipient_id' => $recipient->id,
            'recipient_type' => get_class($recipient),
            'content' => $content,
            'data' => $data,
            'channels' => $channels,
            'status' => 'pending'
        ]);

        $notification->save();

        foreach ($channels as $channel) {
            $this->dispatchToChannel($channel, $notification);
        }

        return $notification;
    }

    private function compileTemplate(Template $template, array $data): string
    {
        $version = $template->latestVersion();
        if (!$version) {
            throw new RuntimeException('Template non ha versioni');
        }

        return $this->replaceVariables($version->content, $data);
    }

    private function replaceVariables(string $content, array $data): string
    {
        return preg_replace_callback(
            '/\{\{\s*([^}]+)\s*\}\}/',
            fn($matches) => $data[$matches[1]] ?? '',
            $content
        );
    }

    private function dispatchToChannel(string $channel, NotificationLog $notification): void
    {
        match($channel) {
            'mail' => $this->dispatchToMail($notification),
            'sms' => $this->dispatchToSms($notification),
            'database' => $this->dispatchToDatabase($notification),
            default => throw new InvalidArgumentException("Canale non supportato: {$channel}")
        };
    }
}
```

## TrackNotificationEventAction

### Responsabilità
- Tracking eventi notifica
- Aggiornamento analytics
- Logging attività

### Implementazione
```php
use Spatie\QueueableAction\QueueableAction;
use Modules\Notify\Models\NotificationLog;
use Modules\Notify\Models\TemplateAnalytics;

final class TrackNotificationEventAction extends QueueableAction
{
    public function execute(
        NotificationLog $notification,
        string $eventType,
        array $eventData = []
    ): void {
        $analytics = new TemplateAnalytics([
            'template_id' => $notification->template_id,
            'notification_id' => $notification->id,
            'event_type' => $eventType,
            'event_data' => $eventData,
            'occurred_at' => now()
        ]);

        $analytics->save();

        event(new AnalyticsEventRecorded($analytics));
    }
}
```

## CompileTemplateAction

### Responsabilità
- Compilazione template
- Validazione contenuti
- Gestione versioni

### Implementazione
```php
use Spatie\QueueableAction\QueueableAction;
use Modules\Notify\Models\Template;

final class CompileTemplateAction extends QueueableAction
{
    public function execute(
        Template $template,
        array $data = []
    ): string {
        $version = $template->latestVersion();
        if (!$version) {
            throw new RuntimeException('Template non ha versioni');
        }

        $content = $this->replaceVariables($version->content, $data);

        if ($template->type === 'email') {
            $content = $this->compileMjml($content);
        }

        return $content;
    }

    private function replaceVariables(string $content, array $data): string
    {
        return preg_replace_callback(
            '/\{\{\s*([^}]+)\s*\}\}/',
            fn($matches) => $data[$matches[1]] ?? '',
            $content
        );
    }

    private function compileMjml(string $mjml): string
    {
        // Implementazione compilazione MJML
        return $mjml;
    }
}
```

## Configurazione Actions

### Service Provider
```php
final class NotifyServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->bind(SendNotificationAction::class);
        $this->app->bind(TrackNotificationEventAction::class);
        $this->app->bind(CompileTemplateAction::class);
    }

    public function boot(): void
    {
        $this->loadMigrationsFrom(__DIR__ . '/../Database/Migrations');
        $this->loadRoutesFrom(__DIR__ . '/../Routes/api.php');
        $this->loadViewsFrom(__DIR__ . '/../Resources/views', 'notify');
    }
}
```

## Gestione Eventi

### Event Listeners
```php
final class NotificationEventSubscriber implements EventSubscriber
{
    public function handleNotificationSent(NotificationSent $event): void
    {
        app(TrackNotificationEventAction::class)->execute(
            $event->notification,
            'sent',
            ['recipient' => $event->recipient]
        );
    }

    public function handleNotificationDelivered(NotificationDelivered $event): void
    {
        app(TrackNotificationEventAction::class)->execute(
            $event->notification,
            'delivered',
            ['recipient' => $event->recipient]
        );
    }

    public function subscribe(Dispatcher $events): array
    {
        return [
            NotificationSent::class => 'handleNotificationSent',
            NotificationDelivered::class => 'handleNotificationDelivered',
        ];
    }
}
``` 
